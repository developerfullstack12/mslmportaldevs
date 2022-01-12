<?php


namespace OTP\Addons\CustomMessage\Handler;

use OTP\Traits\Instance;
class CustomMessagesShortcode
{
    use Instance;
    private $_adminActions;
    private $_nonce;
    public function __construct()
    {
        $MK = CustomMessages::instance();
        $this->_nonce = $MK->getNonceValue();
        $this->_adminActions = $MK->_adminActions;
        add_shortcode("\155\157\x5f\143\x75\x73\x74\157\155\137\x73\155\163", array($this, "\x5f\x63\x75\x73\164\x6f\x6d\x5f\163\x6d\x73\137\163\x68\157\x72\x74\143\157\x64\x65"));
        add_shortcode("\155\157\137\143\165\x73\164\x6f\x6d\137\145\x6d\x61\151\154", array($this, "\137\x63\165\x73\164\157\155\x5f\145\x6d\x61\x69\x6c\137\x73\x68\x6f\x72\x74\x63\157\x64\x65"));
    }
    function _custom_sms_shortcode()
    {
        if (is_user_logged_in()) {
            goto QN;
        }
        return;
        QN:
        $u6 = array_keys($this->_adminActions);
        include MCM_DIR . "\x76\x69\145\167\163\x2f\143\165\x73\x74\x6f\x6d\123\x4d\123\102\x6f\x78\56\x70\150\160";
        wp_register_script("\x63\165\x73\164\x6f\155\x5f\x73\155\163\x5f\x6d\163\147\137\x73\143\x72\151\160\164", MCM_SHORTCODE_SMS_JS, array("\x6a\x71\165\x65\x72\171"), MOV_VERSION);
        wp_localize_script("\x63\x75\163\x74\157\155\137\x73\155\163\x5f\155\x73\147\137\x73\143\x72\151\160\164", "\155\157\x76\143\x75\163\x74\x6f\155\163\155\163", array("\141\154\x74" => mo_("\x53\x65\x6e\144\151\x6e\147\x2e\56\x2e"), "\151\155\x67" => MOV_LOADER_URL, "\x6e\x6f\156\x63\x65" => wp_create_nonce($this->_nonce), "\x75\x72\x6c" => wp_ajax_url(), "\x61\143\x74\x69\157\156" => $u6[0], "\x62\165\x74\164\x6f\156\x54\x65\170\x74" => mo_("\123\145\x6e\144\x20\123\x4d\123")));
        wp_enqueue_script("\x63\x75\x73\x74\157\x6d\137\x73\155\x73\x5f\155\163\147\x5f\x73\143\162\x69\160\x74");
    }
    function _custom_email_shortcode()
    {
        if (is_user_logged_in()) {
            goto b9;
        }
        return;
        b9:
        $u6 = array_keys($this->_adminActions);
        include MCM_DIR . "\166\151\x65\x77\x73\57\143\165\x73\164\x6f\x6d\105\x6d\141\151\154\x42\x6f\170\56\160\150\160";
        wp_register_script("\x63\165\x73\x74\157\x6d\137\x65\155\x61\x69\x6c\137\x6d\x73\x67\137\163\143\162\151\160\x74", MCM_SHORTCODE_EMAIL_JS, array("\x6a\161\x75\x65\162\171"), MOV_VERSION);
        wp_localize_script("\x63\x75\x73\164\157\155\x5f\145\155\141\151\154\137\155\163\x67\137\x73\143\162\x69\x70\164", "\x6d\157\x76\143\165\x73\x74\157\x6d\145\155\141\x69\154", array("\141\154\164" => mo_("\123\145\x6e\x64\x69\x6e\x67\56\56\56"), "\151\x6d\x67" => MOV_LOADER_URL, "\156\157\156\x63\x65" => wp_create_nonce($this->_nonce), "\x75\162\x6c" => wp_ajax_url(), "\x61\143\x74\151\157\x6e" => $u6[1], "\x62\x75\x74\x74\157\x6e\124\x65\x78\164" => mo_("\123\145\156\x64\40\x45\x6d\x61\151\x6c")));
        wp_enqueue_script("\143\x75\163\164\157\x6d\137\x65\155\x61\x69\x6c\137\155\163\147\137\x73\143\162\151\160\164");
    }
}
