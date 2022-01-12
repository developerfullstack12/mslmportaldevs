<?php

use OTP\Addons\PasswordResetWp\Helper\WpPasswordResetMessages;
use OTP\Addons\PasswordResetWp\Helper\WpPasswordResetUtility;

echo'	<div class="mo_registration_divided_layout mo-otp-full">
            <div class="mo_registration_table_layout mo-otp-center">';

            WpPasswordResetUtility::is_addon_activated();

echo'		    <table style="width:100%">
                    <form name="f" method="post" action="" id="mo_wp_pr_notif_settings">
                        <input type="hidden" id="error_message" name="error_message" value="">
                        <input type="hidden" name="option" value="'.$formOption.'" />';

                        wp_nonce_field($nonce);

echo'			            <tr>
                                <td>
                                    <h2>'.mo_("WORDPRESS PASSWORD RESET SETTINGS").'
                                        <span style="float:right;margin-top:-10px;">
                                            <a  href="'.$addon.'" 
                                                id="goBack" 
                                                class="button button-primary button-large">
                                                '.mo_("Go Back").'
                                            </a>
                                            <input  type="submit" 
                                                    name="save" 
                                                    id="save" '.$disabled.' 
                                                    class="button button-primary button-large" 
                                                    value="'.mo_('Save Settings').'">
                                        </span>
                                    </h2>
                                    <hr>
                                </td>
                            </tr>
                            <tr>
                                <td>'.mo_("Enable or Disable Options for the Password Reset Form.").'</td>
                            </tr>
                            <tr>
                                <table class="wppr-table-list" cellspacing="0" style="width:100%">
                                    <tr>
                                        <td>
                                            <div class="mo_otp_form" style="text-align: left;">
                                                <input  type="checkbox" '.$disabled.' 
                                                        id="wp_pr" 
                                                        value="1"
                                                        data-toggle="wp_pr_options" 
                                                        class="app_enable" '.$wppr_enabled.' 
                                                        name="mo_customer_validation_wp_pr_enable" />
                                                <strong>'. $form_name . '</strong>
                                                <div    class="mo_registration_help_desc"  '.$wppr_hidden.' 
                                                        id="wp_pr_options">                                              
                                                    <p>
                                                        <input  type="radio" '.$disabled.' 
                                                                id="wp_phone" 
                                                                name="mo_customer_validation_wp_pr_enable_type" 
                                                                data-toggle="wp_pr_phone_option" 
                                                                class="app_enable"
                                                                value="'.$wppr_type_phone.'" 
                                                                '.( $wppr_enabled_type == $wppr_type_phone ? "checked" : "").' />
                                                        <strong>'. mo_( "Enable Phone Verification" ).'</strong>
                                                    </p>
                                                    <div    '.($wppr_enabled_type != $wppr_type_phone ? "hidden" :"").'
                                                            class="mo_registration_help_desc" 
                                                            id="wp_pr_phone_option" 
                                                            '.$disabled.'">
                                                        <p>'. mo_( "Enter the Name of the Phone field on your Registration Form." );
                                                            // mo_draw_tooltip(
                                                            //     WpPasswordResetMessages::showMessage(WpPasswordResetMessages::META_KEY_HEADER),
                                                            //     WpPasswordResetMessages::showMessage(WpPasswordResetMessages::META_KEY_BODY)
                                                            // );

echo'							                            : <input    class="mo_registration_table_textbox"
                                                                        id="mo_customer_validation_wp_pr_phone_field_key"
                                                                        name="mo_customer_validation_wp_pr_phone_field_key"
                                                                        type="text" 
                                                                        style="width: 48%;"
                                                                        value="'.$wppr_field_key.'">
                                                        </p>
                                                    </div>
                                                    <p>
                                                        <input  type="radio" '.$disabled.' 
                                                                id="wp_email" 
                                                                class="app_enable" 
                                                                name="mo_customer_validation_wp_pr_enable_type" 
                                                                value="'.$wppr_type_email.'"
                                                                '.( $wppr_enabled_type == $wppr_type_email ? "checked" : "").' />
                                                        <strong>'. mo_( "Enable Email Verification" ).'</strong>
                                                    </p>
                                                    <p>
                                                        <p>
                                                            <i><b>'.mo_("Verification Button text").':</b></i>
                                                            <input style="width: 59%;margin-left: 2%;"
                                                                   class="mo_registration_table_textbox" 
                                                                   name="mo_customer_validation_wp_pr_button_text" 
                                                                   type="text" 
                                                                   value="'.$wppr_button_text.'">
                                                        </p>
                                                    </p>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                </table>
                            </tr>
                        </form>	
                    </table>
                </div>
            </div>';