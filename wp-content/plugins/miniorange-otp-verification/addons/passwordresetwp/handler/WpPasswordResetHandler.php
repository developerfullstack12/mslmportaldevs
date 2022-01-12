<?php

namespace OTP\Addons\PasswordResetWp\Handler;

use OTP\Addons\PasswordResetWp\Helper\WpPasswordResetMessages;
use OTP\Helper\FormSessionVars;
use OTP\Helper\MoUtility;
use OTP\Helper\SessionUtils;
use OTP\Objects\FormHandler;
use OTP\Objects\IFormHandler;
use OTP\Objects\VerificationType;
use OTP\Traits\Instance;
use OTP\Helper\MoConstants;
use Wp;
use wp\core\Form;
use wp\core\Options;
use wp\core\Password;
use wp\core\User;
use WP_User;
use \WP_Error;
use \BP_Signup;

/**
 * Password Reset Handler handles sending an OTP to the user instead of
 * the link that usually gets sent out to the user's email address.
 */
class WpPasswordResetHandler extends FormHandler implements IFormHandler
{
    use Instance;

    /** @var string $_fieldKey username field key */
    private $_fieldKey;

    /** @var boolean $_isOnlyPhoneReset if only phone allowed */
    private $_isOnlyPhoneReset;

    protected function __construct()
    {
        $this->_isAjaxForm = TRUE;
        $this->_isAddOnForm = TRUE;
        $this->_formOption = "wp_password_reset_handler";
        $this->_formSessionVar = FormSessionVars::WP_DEFAULT_PASS;
        $this->_typePhoneTag = 'mo_wp_phone_enable';
        $this->_typeEmailTag = 'mo_wp_email_enable';
        $this->_phoneFormId = "user_login";
        $this->_fieldKey = "user_login";
        $this->_formKey = 'WORDPRESS_PASS_RESET';
        $this->_formName = mo_("WordPress Password Reset using OTP");
        $this->_isFormEnabled = get_wppr_option('pass_enable') ? TRUE : FALSE ;
        $this->_generateOTPAction = 'mo_wppr_send_otp';
        $this->_buttonText = get_wppr_option("pass_button_text");
        $this->_buttonText = !MoUtility::isBlank($this->_buttonText) ? $this->_buttonText : mo_("Reset Password");
        $this->_phoneKey =  get_wppr_option('pass_phoneKey');
        // $this->_phoneKey = $this->_phoneKey ? $this->_phoneKey : "phone_number_mo";
        $this->_isOnlyPhoneReset = get_wppr_option('only_phone_reset');

        parent::__construct();
    }

    /**
     * Function checks if form has been enabled by the admin and initializes
     * all the class variables. This function also defines all the hooks to
     * hook into to make OTP Verification possible.
     */
    public function handleForm()
    {
        $this->isErrorExists=false;
        $this->_otpType = get_wppr_option('enabled_type');
        if($this->_isOnlyPhoneReset) $this->_phoneFormId = 'input#user_login';
        add_action("wp_ajax_nopriv_".$this->_generateOTPAction,array($this,'sendAjaxOTPRequest'));
        add_action("wp_ajax_".$this->_generateOTPAction,array($this,'sendAjaxOTPRequest'));

        add_action('login_enqueue_scripts',array($this, 'miniorange_register_wp_script'));
        add_action('wp_enqueue_scripts',array($this, 'miniorange_register_wp_script'));

        add_action('lostpassword_post', array($this,'checkUser'),1,1);
        add_filter( 'allow_password_reset',[$this,'checkiferrors'],1,2 );
    }   



    public function checkiferrors($var,$vare){

        if($this->isErrorExists){
            return new WP_Error();
        }
        return $var;


    }
    public function checkUser($errors){
       $user = MoUtility::sanitizeCheck($this->_fieldKey,$_POST);
       if(is_email($user)){
            $user = $this->getUser($user);
            $userId=$user->ID;
            $user = $this->getUserPhoneNumberById($userId);
       }
       if(isset($errors->errors))
       {
           var_dump(MoUtility::validatePhoneNumber($user));
           if( strcasecmp($this->_otpType,$this->_typePhoneTag)==0 && MoUtility::validatePhoneNumber($user))
           {
               $user_id = $this->getUser($user);
               var_dump(!$user_id);
               if(!$user_id)
               {
                $errors->add(
                    $this->_fieldKey, WpPasswordResetMessages::showMessage(WpPasswordResetMessages::WPUSERNAME_NOT_EXIST));  
                return false;
               } 
               else 
               {
                   unset($errors->errors);
                   // Reset attempt code goes here
               }
           }
       }

       if(empty($errors->errors)) {
           $this->checkIntegrityAndValidateOTP($errors,MoUtility::sanitizeCheck('verify_field',$_POST),$_POST);
       }
    }
     


    /**
     * Send an OTP to the user's phone or email.
     * @throws \ReflectionException
     */
    public function sendAjaxOTPRequest()
    {
        $username = MoUtility::sanitizeCheck('username',$_POST);
        if($this->_isOnlyPhoneReset)
        {
            if(!MoUtility::validatePhoneNumber($username))
            {
             wp_send_json(MoUtility::createJson(
                        WpPasswordResetMessages::showMessage(WpPasswordResetMessages::WP_RESET_ERROR_OTP), MoConstants::ERROR_JSON_TYPE
                    ));
            }
        }
        MoUtility::initialize_transaction($this->_formSessionVar);
        $this->validateAjaxRequest();
        SessionUtils::addUserInSession($this->_formSessionVar,$username);
        $user = $this->getUser($username);
        if(is_email($username)){
            $userId=$user->ID;
            $username = $this->getUserPhoneNumberById($userId);
        }
        // $phone =$this->getPhoneNumberfromUser($username);
        // $phone = get_user_meta($user->ID,$this->_phoneKey,true);
        $this->startOtpTransaction($username,$user->user_email,null,$username,null,null);
         
    }
    /**
     * Check Integrity of the email or phone number. i.e. Ensure that the Email or
     * Phone that the OTP was sent to is the same Email or Phone that is being submitted
     * with the form.
     * <br/<br/>
     * Once integrity check passes validate the OTP to ensure that the user has entered
     * the correct OTP.
     *
     * @param Form $form
     * @param $value
     * @param array $args
     * 
     * 
     * 
     * add the error message in this function..!
     */
    private function checkIntegrityAndValidateOTP(&$errors,$value,array $args)
    {
        $user_login = $args['user_login'];
        /**if(is_email($user_login))
        {
            $otpVerType = 'email';
        }
        else**/
        $otpVerType = 'phone';
        if(!SessionUtils::isOTPInitialized($this->_formSessionVar)) {
            
                $errors->add($this->_fieldKey,WpPasswordResetMessages::showMessage(WpPasswordResetMessages::ENTER_VERIFY_CODE), MoConstants::ERROR_JSON_TYPE);
                return $errors;
        
        }
        $this->checkIntegrity($errors,$args);
        $this->validateChallenge($otpVerType,NULL,$value);
        if(!SessionUtils::isStatusMatch($this->_formSessionVar,self::VALIDATED,$otpVerType)) 
        {   
            $errors->add($this->_fieldKey,WpPasswordResetMessages::showMessage(WpPasswordResetMessages::INVALID_OTP));
             $this->isErrorExists = true;
             return $errors;
        }
             $username = $args['user_login']; 
             $user = $this->getUser($username);
             if($user===false){
                return $errors;
               }
             $userId = $user->ID;
             $userName = $user->user_login;
             $key = get_password_reset_key($user);
             if(!empty($key->errors))
            {
               return $errors;
            }
            $exclude_url=str_replace("action=lostpassword","",$_SERVER['REQUEST_URI']);
            $current_url=$_SERVER['HTTP_ORIGIN'].$exclude_url."action=rp&key=".$key."&login=".$userName;
            wp_redirect($current_url);
            $this->unsetOTPSessionVariables();
            exit();
    }


    /**
     * This function checks the integrity of the phone or email value that was submitted
     * with the form. It needs to match with the email or value that the OTP was
     * initially sent to.
     *
     * @param Form $umForm
     * @param array $args
     */
    private function checkIntegrity($errors,array $args)
    {
        $sessionVar = SessionUtils::getUserSubmitted($this->_formSessionVar);
        if($sessionVar!==$args[$this->_fieldKey]) {
            $errors->add($this->_fieldKey, WpPasswordResetMessages::showMessage(WpPasswordResetMessages::WPUSERNAME_MISMATCH));
        }
        return;
    }


    /**
     * Get UserId based on the username passed
     *
     * @param $user
     * @return bool|int
     */
    public function getUserId($user)
    {
        $user = $this->getUser($user);
        return $user ? $user->ID : false;
    }


    /**
     * Get User based on the username passed
     * @param $username
     * @return bool|WP_User
     */
    public function getUser($username)
    {
        if( strcasecmp($this->_otpType,$this->_typePhoneTag)==0
            && MoUtility::validatePhoneNumber($username)) {
            // $username = MoUtility::processPhoneNumber($username);
            $user = $this->getUserFromPhoneNumber($username);
        } else if(is_email($username)) {
            $user = get_user_by("email",$username);
        }
        return $user;
        
    }

    function getUserPhoneNumberById($userId)
    {
        global $wpdb;
        $field_key = $this->moBBPgetphoneFieldId();
        $results = $wpdb->get_row("SELECT `value` FROM `{$wpdb->prefix}bp_xprofile_data` WHERE `field_id` = '$field_key' AND `user_id` =  '$userId'");
		//var_dump($wpdb->prefix);

        return MoUtility::isBlank($results) ? false : $results->value;
    }

    /**
     * This functions fetches the user associated with a phone number
     *
     * @param $username - the user's username
     * @return bool|WP_User
     */
    function getUserFromPhoneNumber($phone)
    {   
            global $wpdb;
            // $phone = MoUtility::processPhoneNumber($phone);
            $field_key = $this->moBBPgetphoneFieldId();
			//var_dump($wpdb->prefix);
			//var_dump($phone);

            $results = $wpdb->get_row("SELECT `user_id` FROM `{$wpdb->prefix}bp_xprofile_data` WHERE `field_id` = '$field_key' AND `value` =  '$phone'");
           return MoUtility::isBlank($results) ? false : get_userdata($results->user_id);
    }

     function moBBPgetphoneFieldId()
    {
        global $wpdb;
        return $wpdb->get_var("SELECT `id` FROM `{$wpdb->prefix}bp_xprofile_fields` where `name` ='".$this->_phoneKey."'");
    }


    

    /**
     * The function is called to start the OTP Transaction based on the OTP Type
     * set by the admin in the settings.
     *
     * @param $username  	- the username passed by the registration_errors hook
     * @param $email 		- the email passed by the registration_errors hook
     * @param $errors 		- the errors variable passed by the registration_errors hook
     * @param $phone_number - the phone number posted by the user during registration
     * @param $password 	- the password submitted by the user during registration
     * @param $extra_data 	- the extra data submitted by the user during registration
     */
    private function startOtpTransaction($username,$email,$errors,$phone_number,$password,$extra_data)
    {
        if(is_email($username)){

                $this->sendChallenge($username,$email,$errors,$phone_number,VerificationType::EMAIL,$password,$extra_data);

        }
        else if(strcasecmp($this->_otpType,$this->_typePhoneTag)==0)
            $this->sendChallenge($username,$email,$errors,$phone_number,VerificationType::PHONE,$password,$extra_data);
    }


    /**
     * This function registers the js file for enabling OTP Verification
     * for Ultimate Member using AJAX calls.
     */
    public function miniorange_register_wp_script()
    {
        wp_register_script( 'mowppr', WPPR_URL . 'includes/js/mowppr.js',array('jquery') );
        wp_localize_script( 'mowppr', 'mowpprvar', array(
            'siteURL' 		=> wp_ajax_url(),
            'nonce'         => wp_create_nonce($this->_nonce),
            'buttontext'    => mo_($this->_buttonText),
            'imgURL'        => MOV_LOADER_URL,
            'action'        => [ 'send' => $this->_generateOTPAction ],
            'fieldKey'      => $this->_fieldKey,
            'resetLabelText'    => $this->_otpType==$this->_typePhoneTag? $this->_isOnlyPhoneReset ? 
                                    WpPasswordResetMessages::showMessage(WpPasswordResetMessages::WPRESET_LABEL_OP)
                                    :WpPasswordResetMessages::showMessage(WpPasswordResetMessages::WPRESET_LABEL) :WpPasswordResetMessages::showMessage(WpPasswordResetMessages::WPRESET_LABEL_EMAIL_ONLY) ,
            'phText'            => $this->_isOnlyPhoneReset ? mo_('Enter Your Phone Number') : mo_('Enter Your Email or Phone Number'),
        ));
        wp_enqueue_script( 'mowppr' );
    }


    /**
     * Unset all the session variables so that a new form submission starts
     * a fresh process of OTP verification.
     */
    public function unsetOTPSessionVariables()
    {
        SessionUtils::unsetSession([$this->_txSessionId, $this->_formSessionVar]);
    }


    /**
     * This function hooks into the otp_verification_successful hook. This function is
     * details what needs to be done if OTP Verification is successful.
     *
     * @param string $redirect_to the redirect to URL after new user registration
     * @param string $user_login the username posted by the user
     * @param string $user_email the email posted by the user
     * @param string $password the password posted by the user
     * @param string $phone_number the phone number posted by the user
     * @param string $extra_data any extra data posted by the user
     * @param string $otpType the verification type
     */
    public function handle_post_verification($redirect_to, $user_login, $user_email, $password, $phone_number, $extra_data, $otpType)
    {
        SessionUtils::addStatus($this->_formSessionVar,self::VALIDATED,$otpType);
    }


    /**
     * This function hooks into the otp_verification_failed hook. This function
     * details what is done if the OTP verification fails.
     *
     * @param string $user_login the username posted by the user
     * @param string $user_email the email posted by the user
     * @param string $phone_number the phone number posted by the user
     * @param string $otpType the verification type
     */
    public function handle_failed_verification($user_login, $user_email, $phone_number, $otpType)
    {
        SessionUtils::addStatus($this->_formSessionVar,self::VERIFICATION_FAILED,$otpType);
    }



    public function handleFormOptions()
    {
        if(!MoUtility::areFormOptionsBeingSaved($this->getFormOption())) return;

        $this->_isFormEnabled = $this->sanitizeFormPOST("wp_pr_enable");
        $this->_buttonText = $this->sanitizeFormPOST("wp_pr_button_text");
        $this->_buttonText = $this->_buttonText ? $this->_buttonText : "Reset Password";
        $this->_otpType = $this->sanitizeFormPOST("wp_pr_enable_type");
        $this->_phoneKey = $this->sanitizeFormPOST("wp_pr_phone_field_key");
        $this->_isOnlyPhoneReset = $this->sanitizeFormPOST("wp_pr_only_phone");

        update_wppr_option('only_phone_reset',$this->_isOnlyPhoneReset);
        update_wppr_option('pass_enable',$this->_isFormEnabled);
        update_wppr_option("pass_button_text",$this->_buttonText);
        update_wppr_option('enabled_type',$this->_otpType);
        update_wppr_option('pass_phoneKey',$this->_phoneKey);
    }


    /**
     * This function is called by the filter mo_phone_dropdown_selector
     * to return the Jquery selector of the phone field. The function will
     * push the formID to the selector array if OTP Verification for the
     * form has been enabled.
     *
     * @param  array $selector - the Jquery selector to be modified
     * @return array
     */
    public function getPhoneNumberSelector($selector)
    {
        if($this->isFormEnabled() && strcasecmp($this->_otpType,$this->_typePhoneTag)==0) {
            array_push($selector, $this->_phoneFormId);
        }
        return $selector;
    }

    /** getter for $_isOnlyPhoneReset */
    public function getIsOnlyPhoneReset(){ return $this->_isOnlyPhoneReset; }

}