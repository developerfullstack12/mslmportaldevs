<?php


namespace OTP\Helper;

if (defined("\101\102\123\120\x41\x54\110")) {
    goto gM;
}
die;
gM:
use OTP\Handler\MoOTPActionHandlerHandler;
use OTP\Objects\NotificationSettings;
use OTP\Helper\GatewayType;
use OTP\SplClassLoader;
use OTP\Helper\MoSMSBackupGateway;
use OTP\Objects\Tabs;
class CustomGateway
{
    public function __construct()
    {
        $this->_loadHooks();
    }
    protected $applicationName;
    public function _loadHooks()
    {
        add_action("\x77\160\x5f\x61\152\141\x78\137\x6d\x69\156\x69\157\x72\x61\156\x67\145\x5f\147\145\x74\x5f\x74\145\x73\164\x5f\162\x65\x73\x70\157\156\x73\145", array($this, "\x67\x65\x74\137\147\141\164\145\x77\141\171\137\x72\x65\x73\160\x6f\x6e\163\x65"));
    }
    public function hourlySync()
    {
        if ($this->ch_xdigit()) {
            goto Ht;
        }
        $this->daoptions();
        Ht:
    }
    public function flush_cache()
    {
        if (MO_TEST_MODE) {
            goto G0;
        }
        if (!$this->mclv()) {
            goto gN;
        }
        $this->mius();
        gN:
        goto kB;
        G0:
        delete_mo_option("\163\151\x74\x65\137\x65\x6d\x61\151\x6c\x5f\143\x6b\x6c");
        delete_mo_option("\145\x6d\141\x69\154\x5f\166\x65\162\151\146\x69\143\141\164\151\x6f\x6e\137\154\x6b");
        kB:
    }
    public function _vlk($post)
    {
        if (!MoUtility::isBlank($post["\145\x6d\x61\151\x6c\x5f\154\x6b"])) {
            goto JB;
        }
        do_action("\x6d\x6f\137\x72\145\x67\x69\x73\x74\162\141\x74\151\x6f\x6e\x5f\163\x68\x6f\167\137\155\x65\x73\x73\x61\147\x65", MoMessages::showMessage(MoMessages::REQUIRED_FIELDS), MoConstants::ERROR);
        return;
        JB:
        $fS = trim($_POST["\145\155\x61\x69\x6c\137\154\x6b"]);
        $fM = json_decode($this->ccl(), true);
        switch ($fM["\163\x74\141\164\165\x73"]) {
            case "\x53\125\103\x43\x45\x53\123":
                $this->_vlk_success($fS);
                goto Vw;
            default:
                $this->_vlk_fail();
                goto Vw;
        }
        yx:
        Vw:
    }
    public function mclv()
    {
        $Zm = get_mo_option("\143\165\x73\x74\157\x6d\145\x72\137\164\157\153\145\156");
        $Sz = isset($Zm) && !empty($Zm) ? AEncryption::decrypt_data(get_mo_option("\x73\x69\x74\x65\x5f\x65\x6d\x61\151\154\x5f\143\x6b\x6c"), $Zm) : "\x66\x61\154\163\x65";
        $aN = get_mo_option("\x65\155\141\151\154\x5f\x76\x65\162\x69\146\151\x63\x61\x74\x69\x6f\156\x5f\154\153");
        $h4 = get_mo_option("\141\x64\x6d\x69\x6e\x5f\145\155\x61\151\154");
        $dT = get_mo_option("\141\144\x6d\151\156\137\143\x75\163\x74\157\x6d\x65\162\137\x6b\x65\x79");
        return $Sz == "\164\162\165\145" && $aN && $h4 && $dT && is_numeric(trim($dT));
    }
    public function isGatewayConfig()
    {
        if (!get_mo_option("\143\165\x73\164\157\155\x65\137\x67\141\164\x65\167\141\x79\137\x74\x79\160\145")) {
            goto UL;
        }
        return TRUE;
        UL:
        return FALSE;
    }
    public function isMG()
    {
        return FALSE;
    }
    public function getApplicationName()
    {
        return $this->applicationName;
    }
    private function ch_xdigit()
    {
        if (get_mo_option("\163\x69\x74\x65\x5f\145\155\x61\x69\154\137\143\x6b\x6c")) {
            goto RH;
        }
        return FALSE;
        RH:
        $Zm = get_mo_option("\143\x75\x73\x74\x6f\155\145\162\x5f\164\x6f\x6b\x65\x6e");
        return AEncryption::decrypt_data(get_mo_option("\x73\151\164\145\137\145\155\x61\151\154\137\x63\153\154"), $Zm) == "\164\162\x75\145";
    }
    private function daoptions()
    {
        delete_mo_option("\x77\x70\137\144\145\146\x61\165\x6c\x74\x5f\145\156\x61\142\x6c\145");
        delete_mo_option("\167\143\137\x64\x65\146\141\x75\154\x74\x5f\x65\x6e\141\x62\154\x65");
        delete_mo_option("\x70\142\137\x64\x65\x66\141\x75\154\164\x5f\x65\x6e\x61\x62\154\x65");
        delete_mo_option("\x75\x6d\x5f\x64\145\146\141\165\154\x74\x5f\x65\x6e\141\x62\154\145");
        delete_mo_option("\x73\x69\155\x70\x6c\162\137\144\x65\146\x61\165\154\x74\x5f\x65\156\x61\142\154\x65");
        delete_mo_option("\x65\166\x65\156\x74\x5f\x64\x65\x66\x61\165\154\x74\137\145\156\x61\x62\154\x65");
        delete_mo_option("\x62\x62\160\137\x64\x65\x66\141\165\154\x74\137\x65\156\x61\142\154\145");
        delete_mo_option("\x63\x72\x66\137\x64\x65\146\x61\165\154\164\x5f\x65\156\x61\x62\154\145");
        delete_mo_option("\165\x75\154\164\x72\x61\x5f\144\x65\146\141\x75\x6c\164\137\145\156\x61\x62\x6c\x65");
        delete_mo_option("\167\x63\137\x63\x68\x65\143\153\x6f\165\164\137\145\x6e\x61\142\154\145");
        delete_mo_option("\165\160\155\x65\x5f\144\145\x66\x61\165\x6c\x74\137\145\156\141\142\x6c\145");
        delete_mo_option("\x70\x69\145\137\144\145\146\141\x75\154\164\x5f\145\x6e\x61\142\x6c\x65");
        delete_mo_option("\143\x66\67\x5f\x63\157\x6e\164\141\x63\x74\x5f\x65\x6e\141\142\x6c\145");
        delete_mo_option("\143\x6c\x61\x73\163\x69\146\171\137\145\156\141\x62\x6c\145");
        delete_mo_option("\x67\x66\x5f\x63\x6f\156\164\141\143\164\137\145\x6e\141\142\154\x65");
        delete_mo_option("\x6e\152\141\137\x65\x6e\141\142\x6c\x65");
        delete_mo_option("\x6e\151\156\x6a\141\137\x66\x6f\x72\x6d\137\145\156\141\x62\x6c\145");
        delete_mo_option("\164\x6d\154\137\145\156\x61\x62\x6c\145");
        delete_mo_option("\165\x6c\x74\x69\160\x72\157\x5f\145\156\x61\x62\154\145");
        delete_mo_option("\165\163\x65\x72\160\x72\x6f\137\x64\145\146\141\165\x6c\x74\x5f\x65\156\x61\x62\154\x65");
        delete_mo_option("\x77\x70\137\x6c\157\x67\x69\156\137\145\x6e\141\x62\x6c\145");
        delete_mo_option("\146\x6f\x72\x6d\x63\162\x61\146\164\137\160\162\145\155\151\165\155\x5f\x65\156\x61\142\154\x65");
        delete_mo_option("\167\x70\x5f\155\145\155\x62\x65\162\137\x72\145\147\x5f\145\156\x61\x62\x6c\x65");
        delete_mo_option("\147\146\x5f\x6f\x74\x70\x5f\145\x6e\x61\x62\x6c\145\x64");
        delete_mo_option("\167\x63\137\163\x6f\x63\151\141\154\x5f\154\x6f\x67\x69\x6e\137\x65\156\x61\x62\x6c\x65");
        delete_mo_option("\x66\x6f\x72\x6d\x63\x72\141\x66\164\x5f\145\156\141\142\x6c\x65");
        delete_mo_option("\x6d\x6f\137\143\x75\x73\164\x6f\155\145\x72\x5f\x76\x61\154\151\144\x61\164\151\157\156\x5f\141\144\155\151\156\137\x65\155\141\151\154");
        delete_mo_option("\x77\160\143\x6f\155\x6d\145\x6e\x74\x5f\145\156\x61\x62\x6c\x65");
        delete_mo_option("\144\x6f\x63\144\151\x72\x65\x63\164\137\x65\156\141\x62\x6c\145");
        delete_mo_option("\167\160\146\x6f\x72\x6d\x5f\x65\156\x61\142\x6c\x65");
        delete_mo_option("\143\x72\146\x5f\x6f\x74\160\x5f\x65\156\x61\x62\154\x65\x64");
        delete_mo_option("\143\x61\x6c\144\145\162\x61\x5f\145\156\x61\x62\x6c\145");
        delete_mo_option("\146\x6f\x72\x6d\x6d\141\x6b\x65\162\137\145\x6e\x61\142\154\x65");
        delete_mo_option("\x75\155\x5f\x70\162\x6f\146\x69\x6c\145\137\145\x6e\x61\142\154\145");
        delete_mo_option("\x76\x69\x73\165\141\154\137\146\157\x72\155\137\x65\156\141\142\154\x65");
        delete_mo_option("\146\162\x6d\x5f\146\x6f\162\x6d\137\145\x6e\x61\142\154\x65");
        delete_mo_option("\167\x63\x5f\142\x69\154\x6c\151\x6e\x67\x5f\145\156\141\142\154\145");
    }
    private function _vlk_success($fS)
    {
        $SC = json_decode($this->vml($fS), true);
        if (strcasecmp($SC["\x73\x74\x61\164\x75\163"], "\123\125\x43\x43\105\x53\x53") == 0) {
            goto Tc;
        }
        if (strcasecmp($SC["\x73\x74\141\x74\x75\x73"], "\106\x41\111\114\x45\104") == 0) {
            goto Rt;
        }
        do_action("\x6d\157\x5f\x72\145\147\151\163\164\162\x61\x74\x69\157\x6e\x5f\163\150\x6f\x77\137\x6d\x65\x73\163\x61\x67\145", MoMessages::showMessage(MoMessages::UNKNOWN_ERROR), "\105\x52\x52\117\x52");
        goto Hz;
        Rt:
        if (strcasecmp($SC["\155\x65\x73\x73\x61\147\145"], "\103\x6f\144\145\x20\x68\141\x73\x20\x45\x78\x70\x69\x72\145\144") == 0) {
            goto Ug;
        }
        do_action("\155\157\137\x72\145\147\151\163\x74\x72\x61\164\151\x6f\x6e\x5f\163\150\x6f\x77\x5f\155\145\163\163\x61\x67\x65", MoMessages::showMessage(MoMessages::INVALID_LK), "\105\x52\x52\117\122");
        goto Pn;
        Ug:
        do_action("\155\157\x5f\x72\x65\147\x69\163\x74\x72\x61\x74\151\157\156\x5f\x73\150\x6f\x77\137\155\x65\x73\x73\x61\x67\x65", MoMessages::showMessage(MoMessages::LK_IN_USE), "\x45\x52\122\117\122");
        Pn:
        Hz:
        goto vq;
        Tc:
        $Zm = get_mo_option("\x63\165\x73\164\157\x6d\x65\162\x5f\x74\x6f\x6b\x65\x6e");
        update_mo_option("\145\155\x61\151\154\x5f\x76\145\x72\151\146\x69\x63\141\164\151\x6f\156\137\154\153", AEncryption::encrypt_data($fS, $Zm));
        update_mo_option("\163\x69\x74\x65\137\x65\x6d\x61\151\x6c\x5f\x63\153\154", AEncryption::encrypt_data("\x74\x72\165\145", $Zm));
        do_action("\x6d\x6f\x5f\x72\x65\x67\151\x73\x74\162\x61\164\x69\x6f\x6e\x5f\163\150\x6f\x77\x5f\155\145\x73\x73\141\147\145", MoMessages::showMessage(MoMessages::VERIFIED_LK), "\123\x55\103\x43\x45\x53\123");
        vq:
    }
    private function _vlk_fail()
    {
        $Zm = get_mo_option("\x63\165\x73\164\157\155\145\x72\x5f\x74\x6f\x6b\145\x6e");
        update_mo_option("\x73\151\x74\x65\x5f\145\155\141\151\x6c\137\143\153\x6c", AEncryption::encrypt_data("\146\x61\x6c\163\x65", $Zm));
        do_action("\155\x6f\137\x72\x65\147\x69\163\164\x72\x61\x74\x69\157\156\x5f\163\x68\x6f\x77\137\x6d\x65\163\x73\x61\x67\x65", MoMessages::showMessage(MoMessages::NEED_UPGRADE_MSG), "\105\122\122\117\122");
    }
    private function vml($fS)
    {
        $JX = MoConstants::HOSTNAME . "\x2f\x6d\x6f\141\163\57\x61\160\x69\57\142\141\x63\x6b\165\160\143\x6f\x64\x65\x2f\166\x65\x72\151\146\171";
        $dT = get_mo_option("\x61\x64\155\x69\156\x5f\143\x75\163\164\157\x6d\145\x72\137\x6b\145\171");
        $Ca = get_mo_option("\x61\144\x6d\x69\156\x5f\x61\160\x69\x5f\x6b\145\171");
        $KB = array("\x63\157\144\145" => $fS, "\x63\x75\x73\x74\x6f\x6d\145\162\113\145\x79" => $dT, "\x61\144\144\151\164\x69\x6f\156\141\x6c\x46\x69\145\x6c\x64\x73" => array("\x66\x69\145\x6c\x64\x31" => site_url()));
        $Rn = json_encode($KB);
        $KI = MocURLOTP::createAuthHeader($dT, $Ca);
        $Re = MocURLOTP::callAPI($JX, $Rn, $KI);
        return $Re;
    }
    private function ccl()
    {
        $JX = MoConstants::HOSTNAME . "\x2f\x6d\x6f\x61\163\x2f\162\145\x73\x74\x2f\143\x75\x73\164\x6f\155\x65\162\x2f\x6c\x69\x63\x65\x6e\x73\x65";
        $dT = get_mo_option("\x61\144\x6d\x69\156\x5f\143\x75\163\164\x6f\x6d\x65\x72\x5f\153\x65\x79");
        $Ca = get_mo_option("\x61\144\x6d\x69\156\x5f\141\x70\x69\137\x6b\x65\x79");
        $KB = array("\143\165\x73\164\x6f\155\x65\162\x49\144" => $dT, "\x61\160\160\154\x69\143\141\164\151\157\156\x4e\x61\x6d\x65" => $this->applicationName);
        $Rn = json_encode($KB);
        $KI = MocURLOTP::createAuthHeader($dT, $Ca);
        $Re = MocURLOTP::callAPI($JX, $Rn, $KI);
        return $Re;
    }
    private function mius()
    {
        $JX = MoConstants::HOSTNAME . "\57\x6d\157\141\x73\x2f\141\160\x69\x2f\x62\141\143\153\165\x70\143\x6f\x64\x65\x2f\165\160\144\x61\x74\x65\x73\164\x61\164\165\163";
        $dT = get_mo_option("\141\x64\x6d\x69\x6e\137\x63\x75\x73\x74\157\155\x65\162\137\x6b\x65\171");
        $Ca = get_mo_option("\x61\x64\x6d\151\x6e\137\x61\160\151\x5f\153\145\x79");
        $Zm = get_mo_option("\x63\x75\163\164\x6f\155\145\x72\137\x74\157\153\x65\156");
        $fS = AEncryption::decrypt_data(get_mo_option("\x65\155\141\151\x6c\137\166\x65\x72\x69\x66\151\x63\x61\164\x69\x6f\x6e\x5f\154\x6b"), $Zm);
        $KB = array("\x63\x6f\x64\x65" => $fS, "\x63\x75\x73\164\x6f\x6d\145\162\x4b\x65\171" => $dT);
        $Rn = json_encode($KB);
        $KI = MocURLOTP::createAuthHeader($dT, $Ca);
        $Re = MocURLOTP::callAPI($JX, $Rn, $KI);
        return $Re;
    }
    public function custom_wp_mail_from_name($Wk)
    {
        return get_mo_option("\143\165\163\x74\157\x6d\x5f\145\155\x61\151\x6c\x5f\x66\162\157\x6d\x5f\x6e\x61\x6d\145") ? get_mo_option("\x63\165\x73\x74\157\x6d\137\x65\155\141\151\x6c\137\146\x72\x6f\155\137\x6e\141\155\x65") : $Wk;
    }
    function _mo_configure_sms_template($zy)
    {
        if (!isset($zy["\155\157\x5f\x63\165\x73\164\157\x6d\145\x72\x5f\x76\x61\x6c\x69\x64\x61\164\x69\x6f\156\137\x63\x75\163\164\x6f\x6d\x5f\x73\x6d\x73\x5f\x6d\x73\x67"])) {
            goto VC;
        }
        $ii = trim($zy["\x6d\x6f\137\143\x75\x73\164\157\x6d\x65\x72\x5f\x76\x61\x6c\x69\x64\141\x74\151\x6f\x6e\137\143\x75\x73\x74\x6f\155\137\x73\x6d\x73\137\x6d\x73\147"]);
        $ii = str_replace(PHP_EOL, "\x25\x30\141", $ii);
        update_mo_option("\x63\x75\x73\x74\x6f\155\137\x73\x6d\x73\137\155\x73\147", $ii);
        VC:
        if (!isset($zy["\x6d\157\x5f\x63\x75\163\164\x6f\x6d\145\x72\x5f\x76\141\x6c\151\x64\x61\x74\151\x6f\x6e\x5f\x63\x75\x73\x74\x6f\x6d\x5f\147\x61\164\145\x77\x61\171\x5f\x74\x79\160\x65"])) {
            goto kg;
        }
        update_mo_option("\143\x75\163\x74\x6f\x6d\x65\x5f\147\x61\164\x65\x77\x61\x79\137\164\x79\x70\145", $zy["\155\157\137\143\165\163\164\x6f\155\x65\162\x5f\x76\x61\154\x69\144\141\x74\x69\x6f\x6e\137\x63\165\163\x74\x6f\155\137\x67\x61\x74\145\x77\x61\171\137\164\x79\x70\145"]);
        $wQ = GatewayType::instance();
        $wQ->saveGatewayDetails($zy);
        kg:
    }
    function _mo_configure_email_template($zy)
    {
        update_mo_option("\x63\x75\x73\x74\157\x6d\x5f\145\155\x61\151\154\137\155\163\x67", wpautop($zy["\155\157\x5f\x63\x75\x73\x74\x6f\155\x65\x72\x5f\166\141\x6c\x69\x64\x61\x74\151\x6f\156\x5f\143\x75\x73\164\157\155\137\x65\x6d\x61\x69\x6c\x5f\x6d\163\x67"]));
        update_mo_option("\x63\x75\x73\x74\x6f\x6d\x5f\145\155\x61\x69\x6c\x5f\163\x75\142\152\145\x63\164", sanitize_text_field($zy["\155\157\137\143\165\x73\164\157\155\145\x72\x5f\166\141\154\x69\144\x61\164\151\x6f\156\x5f\143\165\163\164\x6f\x6d\x5f\x65\x6d\x61\x69\154\x5f\x73\165\x62\x6a\x65\143\164"]));
        update_mo_option("\x63\x75\x73\164\157\155\x5f\x65\155\141\x69\154\x5f\146\x72\157\x6d\x5f\x69\144", sanitize_text_field($zy["\x6d\x6f\x5f\x63\165\x73\164\157\155\145\162\x5f\166\141\x6c\x69\x64\x61\x74\151\157\156\137\143\165\x73\164\157\155\x5f\x65\x6d\141\151\154\137\146\x72\x6f\x6d\x5f\x69\x64"]));
        update_mo_option("\143\165\163\164\x6f\x6d\x5f\145\x6d\x61\x69\154\137\x66\x72\x6f\x6d\137\x6e\141\155\x65", sanitize_text_field($zy["\155\x6f\137\x63\165\163\164\x6f\155\x65\x72\x5f\166\x61\x6c\x69\x64\x61\164\151\x6f\156\x5f\143\x75\163\164\157\x6d\x5f\145\x6d\x61\151\154\137\146\x72\x6f\x6d\137\156\x61\155\145"]));
    }
    public function showConfigurationPage($GZ)
    {
        $Tj = get_mo_option("\x63\165\163\164\157\x6d\x5f\163\155\x73\137\155\163\147") ? get_mo_option("\143\x75\163\x74\157\155\137\163\x6d\x73\137\x6d\x73\147") : MoMessages::showMessage(MoMessages::DEFAULT_SMS_TEMPLATE);
        $Tj = mo_($Tj);
        $Pa = get_mo_option("\143\x75\163\x74\x6f\155\137\145\155\141\151\x6c\137\163\x75\x62\x6a\x65\143\164") ? get_mo_option("\x63\x75\163\164\x6f\x6d\x5f\145\x6d\141\x69\x6c\x5f\163\x75\x62\x6a\145\x63\x74") : MoMessages::showMessage(MoMessages::EMAIL_SUBJECT);
        $yD = get_mo_option("\143\x75\x73\x74\157\x6d\x5f\145\x6d\141\151\154\137\146\x72\157\155\x5f\x69\144") ? get_mo_option("\x63\165\163\x74\157\155\x5f\145\x6d\141\x69\154\137\146\x72\x6f\155\x5f\151\x64") : get_mo_option("\141\144\155\x69\156\137\145\155\x61\x69\154");
        $P7 = get_mo_option("\143\x75\163\164\x6f\155\x5f\x65\155\x61\151\x6c\x5f\x66\x72\x6f\155\x5f\x6e\x61\x6d\x65") ? get_mo_option("\143\165\x73\x74\157\x6d\x5f\x65\155\141\151\154\x5f\146\162\157\x6d\x5f\156\x61\155\145") : get_bloginfo("\156\x61\x6d\x65");
        $SC = get_mo_option("\x63\x75\163\x74\x6f\x6d\x5f\145\155\141\151\x6c\x5f\155\163\x67") ? stripslashes(get_mo_option("\143\x75\x73\164\157\x6d\137\x65\155\x61\151\154\x5f\x6d\x73\x67")) : MoMessages::showMessage(MoMessages::DEFAULT_EMAIL_TEMPLATE);
        $yK = "\143\x75\163\164\x6f\155\145\155\141\x69\154\x65\x64\x69\164\157\162";
        $a6 = array("\x6d\145\144\151\x61\137\x62\x75\164\x74\x6f\156\x73" => false, "\x74\x65\x78\164\x61\162\x65\x61\137\156\x61\155\x65" => "\155\x6f\137\x63\165\x73\164\x6f\x6d\145\162\x5f\x76\141\x6c\x69\144\x61\x74\151\x6f\x6e\x5f\143\165\163\x74\157\x6d\x5f\x65\x6d\141\151\154\137\155\x73\x67", "\145\144\x69\164\x6f\x72\x5f\x68\x65\151\147\150\164" => "\x31\x37\x30\x70\170", "\167\160\x61\165\x74\157\x70" => false);
        $Uh = MoOTPActionHandlerHandler::instance();
        $fD = $Uh->getNonceValue();
        $t0 = wp_nonce_field($fD);
        $tO = mo_("\x53\115\123\x20\124\x45\115\120\114\101\x54\105\x20\x43\x4f\x4e\x46\x49\x47\125\x52\101\x54\x49\x4f\x4e");
        $Lp = mo_("\x53\115\x53\40\107\x41\124\105\x57\101\x59\x20\103\117\x4e\106\x49\x47\125\x52\x41\124\x49\x4f\x4e");
        $KR = mo_("\123\x4d\x53\x20\124\x65\155\160\x6c\x61\164\145");
        $Ss = mo_("\105\156\164\145\x72\x20\117\124\120\x20\x53\115\123\x20\115\145\x73\163\141\x67\145");
        $pV = mo_("\131\x6f\x75\x20\156\145\x65\144\x20\164\157\x20\x77\x72\x69\x74\145\x20\43\x23\157\164\x70\x23\43\x20\167\x68\145\x72\145\x20\x79\157\165\x20\x77\151\163\150\40\x74\157\x20\x70\x6c\141\143\x65\40\x67\145\156\145\162\x61\x74\x65\144\40\157\x74\160\40\x69\x6e\x20\164\x68\x69\163\x20\x74\145\155\x70\154\141\164\145\x2e");
        $K0 = mo_("\131\x6f\x75\40\167\151\154\x6c\40\x6e\145\145\144\x20\x74\157\40\x70\x6c\141\x63\x65\x20\171\157\165\162\40\123\x4d\123\40\147\141\x74\145\167\x61\x79\x20\125\122\x4c\40\x69\x6e\40\x74\150\145\x20\x66\x69\145\154\144\x20\x61\142\157\166\x65\x20\151\x6e\40\157\x72\144\145\162\40\x74\157\40\142\x65\15\12\x20\x20\40\40\x20\40\x20\x20\x20\40\x20\x20\40\x20\40\40\40\x20\40\x20\40\40\40\x20\40\x20\40\40\x20\40\x20\x20\x20\x20\40\x20\40\x20\40\x20\40\x20\40\x20\x61\x62\154\145\40\x74\x6f\40\163\145\156\144\40\117\124\120\163\40\x74\157\x20\x74\150\145\x20\x75\163\x65\162\x27\163\x20\160\150\x6f\x6e\x65\x2e") . "\x3c\142\x72\57\76" . mo_("\131\x6f\165\40\167\151\x6c\x6c\x20\142\145\x20\x61\x62\154\x65\x20\x74\x6f\x20\x67\x65\x74\40\164\x68\151\163\x20\x55\x52\114\x20\146\162\157\x6d\x20\171\x6f\165\x72\x20\123\x4d\x53\x20\x67\141\x74\145\167\141\x79\x20\160\162\x6f\166\x69\x64\145\162\x2e");
        $wW = mo_("\x49\x66\x20\171\x6f\x75\40\141\162\145\x20\x68\x61\x76\x69\x6e\147\x20\164\162\157\165\142\154\145\x20\151\156\40\146\x69\x6e\144\x69\x6e\x67\x20\x79\157\165\x72\x20\x67\x61\164\x65\167\141\x79\x20\125\x52\114\x20\x74\x68\145\156\x20\171\x6f\x75\40\144\x72\x6f\160\x20\165\163\x20\x61\156\xd\12\40\x20\40\40\x20\x20\x20\40\40\x20\40\x20\x20\x20\x20\x20\x20\x20\40\x20\x20\40\40\x20\40\x20\40\x20\40\x20\x20\x20\x20\40\40\40\x20\x20\40\x20\x20\40\40\x20\145\x6d\x61\x69\154\x20\141\164\40\74\x61\x20\157\x6e\x43\x6c\x69\143\153\x3d\x27\157\x74\160\123\x75\x70\x70\157\162\x74\117\156\x43\154\x69\143\153\x28\x29\73\47\76\157\164\x70\163\x75\160\160\x6f\x72\x74\100\155\151\156\x69\x6f\162\x61\156\147\145\56\143\x6f\155\74\57\x61\x3e\56\x20\x57\x65\40\x77\151\154\154\40\x68\x65\x6c\x70\40\171\157\x75\40\x77\x69\x74\x68\x20\x74\x68\145\40\163\x65\x74\x75\x70\56");
        $iL = mo_("\124\x65\163\164\x20\x53\115\123\x20\x47\x61\x74\x65\x77\141\171\40\103\157\156\146\151\147\x75\162\141\x74\x69\157\x6e\163");
        $nA = mo_("\124\145\x73\164\40\x43\157\156\146\x69\147\165\x72\141\x74\151\x6f\156");
        $ng = mo_("\107\x61\x74\x65\x77\141\x79\40\122\x65\163\x70\157\156\x73\x65");
        $ZP = "\105\x78\x61\155\160\x6c\x65\72\55\x20\150\x74\x74\160\72\x2f\x2f\141\x6c\145\x72\164\x73\56\163\151\156\x66\151\x6e\x69\x2e\x63\157\x6d\x2f\141\x70\x69\x2f\167\x65\142\x32\163\x6d\x73\x2e\x70\x68\x70\x75\x73\x65\x72\x6e\x61\x6d\145\75\x58\131\132\x26\160\141\x73\x73\x77\157\162\144\75\160\141\x73\163\167\157\x72\144\46\164\x6f\x3d\43\43\x70\150\x6f\156\x65\43\43\x26\x73\x65\x6e\x64\x65\x72\x3d\163\145\x6e\144\145\x72\x69\x64\46\155\x65\163\x73\141\147\x65\75\43\x23\155\x65\163\163\141\x67\145\43\43";
        $Y9 = mo_("\103\101\116\x4e\x4f\124\x20\x46\111\116\104\x20\124\110\x45\40\107\101\x54\x45\x57\101\131\x20\125\x52\x4c\x3f");
        $ZV = mo_("\123\141\x76\x65\40\123\115\x53\x20\x43\x6f\x6e\x66\151\147\x75\x72\x61\164\151\x6f\156\x73");
        $m3 = mo_("\123\141\x76\x65\40\x47\141\164\x65\x77\x61\x79\40\103\157\156\146\x69\x67\x75\162\141\164\151\x6f\156\x73");
        $L0 = mo_("\105\x4d\x41\x49\114\x20\103\117\116\106\111\107\x55\x52\101\x54\x49\117\x4e");
        $tS = mo_("\x59\157\x75\x20\156\x65\x65\144\x20\x74\157\x20\x63\157\156\146\x69\147\165\162\x65\x20\x79\x6f\x75\162\40\x70\x68\x70\56\151\156\151\40\x66\151\154\145\40\x77\151\x74\x68\40\x53\115\124\120\x20\163\x65\164\x74\x69\156\x67\163\x20\x74\x6f\40\x62\145\40\x61\142\154\145\x20\x74\157\40\x73\145\156\144\40\145\x6d\141\x69\154\x73\x2e");
        $XP = mo_("\123\x61\x76\145\40\x45\155\141\151\154\40\x43\157\156\x66\151\147\x75\x72\141\x74\x69\157\156\163");
        $ia = mo_("\x45\156\x74\x65\x72\x20\x79\x6f\165\162\x20\117\x54\x50\40\105\x6d\x61\151\154\x20\x53\165\x62\x6a\x65\143\x74");
        $td = mo_("\x45\156\x74\145\x72\x20\x4e\x61\x6d\145");
        $jL = mo_("\105\156\x74\x65\162\x20\145\x6d\141\151\154\x20\141\x64\x64\x72\145\x73\163");
        $xq = mo_("\106\162\157\155\40\x49\x44");
        $Wu = mo_("\x46\162\x6f\155\x20\116\x61\x6d\145");
        $Rk = mo_("\x53\x75\142\152\145\x63\x74");
        $sY = mo_("\x42\157\x64\x79");
        $wQ = GatewayType::instance();
        $RR = get_mo_option("\143\x75\163\164\x6f\x6d\137\x73\x6d\x73\x5f\x67\x61\x74\x65\x77\141\x79") ? get_mo_option("\143\165\163\164\157\x6d\137\x73\x6d\x73\x5f\x67\141\x74\x65\167\141\171") : '';
        $X8 = $wQ->getGatewayConfigView($GZ, $RR);
        $Qv = $this->get_gateway_list();
        $S_ = get_mo_option("\143\165\163\x74\x6f\155\x65\137\x67\x61\x74\x65\x77\x61\x79\137\164\171\160\145") ? get_mo_option("\x63\x75\163\164\x6f\155\145\x5f\x67\x61\164\145\x77\141\x79\x5f\164\x79\160\x65") : "\x4d\157\x47\x61\x74\x65\x77\x61\x79\x55\122\114";
        include MOV_DIR . "\166\x69\145\167\x73\57\x63\x63\157\156\146\151\x67\x75\162\141\x74\x69\157\156\56\160\150\x70";
    }
    public function get_gateway_list()
    {
        $D6 = '';
        $Mv = new \RecursiveIteratorIterator(new \RecursiveDirectoryIterator(MOV_DIR . "\x68\x65\x6c\160\x65\162\x2f\147\141\164\145\167\141\171", \RecursiveDirectoryIterator::SKIP_DOTS), \RecursiveIteratorIterator::LEAVES_ONLY);
        foreach ($Mv as $D2) {
            $QN = $D2->getFilename();
            $S0 = "\x4f\x54\x50\x5c\x48\x65\x6c\160\145\162\134\107\141\x74\145\x77\x61\x79\x5c" . str_replace("\56\160\150\x70", '', $QN);
            $tu = $S0::instance();
            $D6 .= $this->addOption($tu->_gatewayName, str_replace("\56\160\x68\160", '', $QN));
            zP:
        }
        A5:
        return $D6;
    }
    public function get_gateway_response()
    {
        $qG = isset($_POST["\164\x65\x73\x74\x5f\143\157\x6e\x66\151\147\137\x6e\x75\155\142\x65\x72"]) ? $_POST["\164\145\x73\x74\137\143\157\156\146\x69\147\137\x6e\x75\155\x62\145\162"] : '';
        $NA = $this->mo_send_otp_token("\x53\x4d\123", '', $qG);
        print_r($NA);
        die;
    }
    private function addOption($P6, $VT)
    {
        return "\74\x6f\x70\x74\151\157\156\x20\x76\141\x6c\165\x65\x3d\42" . $VT . "\42\76" . $P6 . "\74\57\157\160\164\151\x6f\x6e\x3e";
    }
    public function mo_send_otp_token($Vi, $h4, $fk)
    {
        if (MO_TEST_MODE) {
            goto AZ;
        }
        $SC = $this->send_otp_token($Vi, $h4, $fk);
        return json_decode($SC, TRUE);
        goto K7;
        AZ:
        return array("\x73\164\x61\x74\x75\163" => "\123\125\x43\x43\x45\x53\x53", "\164\170\111\144" => MoUtility::rand());
        K7:
    }
    public function mo_send_notif(NotificationSettings $nZ)
    {
        $Re = $nZ->sendSMS ? self::send_sms_token($nZ->message, $nZ->phoneNumber) : self::send_email_token($nZ->message, $nZ->toEmail, $nZ->fromEmail, $nZ->subject);
        return !is_null($Re) ? json_encode(array("\163\x74\141\164\165\163" => "\x53\125\x43\x43\x45\123\x53")) : json_encode(array("\x73\164\141\164\165\163" => "\105\122\x52\117\122"));
    }
    private function send_otp_token($Vi, $h4 = null, $fk = null)
    {
        $ip = get_mo_option("\157\164\x70\137\x6c\145\156\x67\x74\150") ? get_mo_option("\x6f\x74\160\x5f\154\x65\x6e\147\164\x68") : 5;
        $lo = wp_rand(pow(10, $ip - 1), pow(10, $ip) - 1);
        $lo = apply_filters("\155\157\x5f\141\154\x70\150\141\156\x75\x6d\145\162\x69\x63\x5f\157\x74\160\x5f\x66\x69\x6c\x74\x65\x72", $lo);
        $dT = get_mo_option("\x61\x64\155\x69\x6e\137\x63\165\x73\x74\x6f\x6d\x65\162\137\x6b\145\x79");
        $g6 = $dT . $lo;
        $Ew = hash("\163\150\141\65\x31\x32", $g6);
        $Re = self::httpRequest($Vi, $lo, $h4, $fk);
        if ($Re) {
            goto BW;
        }
        $SC = array("\x73\164\141\x74\165\163" => "\x46\x41\111\x4c\x55\122\105");
        goto ZP;
        BW:
        MoPHPSessions::addSessionVar("\155\x6f\137\x6f\164\160\164\x6f\x6b\x65\156", true);
        MoPHPSessions::addSessionVar("\x73\145\x6e\164\137\157\x6e", time());
        $SC = array("\x73\164\x61\x74\x75\x73" => "\x53\x55\103\103\105\x53\x53", "\164\170\x49\144" => $Ew);
        ZP:
        if (!(isset($_POST["\x61\143\x74\151\x6f\156"]) && $_POST["\x61\x63\164\x69\157\x6e"] == "\x6d\x69\x6e\x69\157\x72\141\156\147\x65\137\147\x65\164\137\164\x65\x73\164\137\162\145\163\160\157\156\x73\x65")) {
            goto ev;
        }
        return json_encode($Re);
        ev:
        return json_encode($SC);
    }
    private function httpRequest($Vi, $lo, $h4 = null, $fk = null)
    {
        $Re = null;
        switch ($Vi) {
            case "\123\115\123":
                $SF = get_mo_option("\143\x75\x73\164\x6f\155\x5f\163\x6d\x73\x5f\155\163\x67") ? mo_(get_mo_option("\x63\x75\x73\x74\x6f\155\x5f\163\155\x73\x5f\x6d\x73\x67")) : mo_(MoMessages::showMessage(MoMessages::DEFAULT_SMS_TEMPLATE));
                $SF = mo_($SF);
                $SF = str_replace("\43\43\x6f\164\x70\43\43", $lo, $SF);
                $Re = $this->send_sms_token($SF, $fk);
                goto SP;
            case "\105\x4d\x41\111\114":
                $SF = get_mo_option("\143\x75\163\164\x6f\155\x5f\145\x6d\141\x69\154\x5f\x6d\163\147") ? mo_(get_mo_option("\x63\x75\x73\x74\157\x6d\137\x65\155\x61\151\154\x5f\155\x73\x67")) : mo_(MoMessages::showMessage(MoMessages::DEFAULT_EMAIL_TEMPLATE));
                $SF = mo_($SF);
                $SF = stripslashes($SF);
                $SF = str_replace("\x23\x23\x6f\x74\160\x23\x23", $lo, $SF);
                $s0 = get_mo_option("\143\x75\163\164\157\155\137\145\155\x61\151\x6c\137\146\x72\x6f\155\x5f\x69\x64");
                $Rk = get_mo_option("\143\165\x73\x74\157\155\x5f\145\x6d\x61\151\154\x5f\163\x75\x62\x6a\145\143\x74");
                $dB = get_mo_option("\143\x75\163\164\157\155\x5f\145\155\x61\x69\154\137\x66\x72\157\x6d\x5f\156\141\155\145");
                $Re = $this->send_email_token($SF, $h4, $s0, $Rk, $dB);
                goto SP;
        }
        ZB:
        SP:
        return $Re;
    }
    private function send_sms_token($SF, $fk)
    {
        $tu = GatewayType::instance();
        $Re = $tu->sendOTPRequest($SF, $fk);
        return $tu->handleGatewayResponse($Re, $SF, $fk);
    }
    private function send_email_token($SF, $h4, $s0 = null, $Rk = null, $dB = null)
    {
        $s0 = !MoUtility::isBlank($s0) ? $s0 : MoConstants::FROM_EMAIL;
        $Rk = !MoUtility::isBlank($Rk) ? $Rk : MoMessages::showMessage(MoMessages::EMAIL_SUBJECT);
        $dB = !MoUtility::isBlank($dB) ? $dB : $s0;
        $i7 = "\106\162\x6f\x6d\x3a" . $dB . "\40\x3c" . $s0 . "\x3e\40\12";
        $i7 .= MoConstants::HEADER_CONTENT_TYPE;
        $SC = $SF;
        return ini_get("\x53\x4d\124\120") != FALSE || ini_get("\163\155\164\x70\137\x70\157\162\164") != FALSE ? wp_mail($h4, $Rk, $SC, $i7) : false;
    }
    public function mo_validate_otp_token($Mc, $Fz)
    {
        return MO_TEST_MODE ? MO_FAIL_MODE ? array("\x73\x74\141\164\x75\x73" => '') : array("\163\x74\x61\x74\165\163" => "\x53\125\x43\103\105\123\123") : $this->validate_otp_token($Mc, $Fz);
    }
    private function validate_otp_token($Ew, $V7)
    {
        $dT = get_mo_option("\141\144\x6d\151\156\137\143\x75\163\164\157\155\x65\x72\x5f\x6b\x65\171");
        if (MoPHPSessions::getSessionVar("\x6d\x6f\137\157\x74\x70\x74\157\153\x65\156")) {
            goto JY;
        }
        $SC = array("\163\x74\141\x74\165\x73" => MoConstants::FAILURE);
        goto z9;
        JY:
        $wY = $this->checkTimeStamp(MoPHPSessions::getSessionVar("\163\x65\x6e\x74\x5f\x6f\156"), time());
        $wY = $this->checkTransactionId($dT, $V7, $Ew, $wY);
        if ($wY) {
            goto kW;
        }
        $SC = array("\x73\164\x61\x74\165\x73" => MoConstants::FAILURE);
        goto QL;
        kW:
        $SC = array("\163\164\141\164\165\x73" => MoConstants::SUCCESS);
        QL:
        MoPHPSessions::unsetSession("\44\155\x6f\137\157\x74\x70\164\x6f\153\x65\156");
        z9:
        return $SC;
    }
    private function checkTimeStamp($oG, $tr)
    {
        $lu = get_mo_option("\x6f\164\x70\x5f\x76\141\154\x69\144\151\164\x79") ? get_mo_option("\x6f\x74\x70\x5f\166\141\154\151\144\151\164\x79") : 5;
        $tN = round(abs($tr - $oG) / 60, 2);
        return $tN > $lu ? false : true;
    }
    private function checkTransactionId($dT, $V7, $Ew, $wY)
    {
        if ($wY) {
            goto g6;
        }
        return false;
        g6:
        $g6 = $dT . $V7;
        $fX = hash("\x73\x68\141\x35\61\x32", $g6);
        return $fX === $Ew;
    }
}
