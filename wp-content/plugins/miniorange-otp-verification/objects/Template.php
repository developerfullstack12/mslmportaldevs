<?php


namespace OTP\Objects;

use OTP\Helper\MoConstants;
use OTP\Helper\MoMessages;
use OTP\Helper\MoUtility;
if (defined("\x41\x42\123\120\x41\124\x48")) {
    goto QK;
}
die;
QK:
abstract class Template extends BaseActionHandler implements MoITemplate
{
    protected $key;
    protected $templateEditorID;
    protected $nonce;
    protected $preview = FALSE;
    protected $jqueryUrl;
    protected $img;
    public $paneContent;
    public $messageDiv;
    protected $successMessageDiv;
    public static $templateEditor = array("\167\x70\x61\165\164\157\x70" => false, "\x6d\x65\x64\x69\141\137\142\x75\x74\164\157\x6e\x73" => false, "\x74\145\x78\x74\141\162\145\141\x5f\162\x6f\167\x73" => 20, "\164\x61\x62\151\x6e\144\145\x78" => '', "\164\x61\x62\x66\x6f\x63\165\x73\x5f\x65\154\145\155\x65\x6e\164\163" => "\x3a\x70\x72\x65\x76\x2c\72\x6e\145\170\x74", "\x65\x64\151\x74\157\x72\x5f\x63\163\163" => '', "\145\x64\x69\x74\x6f\162\137\143\154\x61\x73\163" => '', "\x74\145\x65\x6e\x79" => false, "\x64\x66\167" => false, "\x74\151\x6e\x79\x6d\x63\145" => false, "\x71\165\151\143\x6b\164\141\x67\163" => true);
    protected $requiredTags = array("\173\x7b\x4a\121\x55\105\122\131\x7d\175", "\173\173\x47\x4f\x5f\x42\x41\103\x4b\137\101\x43\x54\x49\x4f\x4e\137\103\x41\x4c\114\x7d\175", "\173\173\106\117\x52\115\137\x49\x44\175\175", "\x7b\173\122\x45\x51\x55\x49\x52\105\x44\137\x46\111\105\114\104\123\x7d\175", "\x7b\173\x52\x45\121\x55\x49\x52\x45\x44\x5f\x46\x4f\122\115\123\x5f\123\x43\122\111\x50\124\123\175\175");
    protected function __construct()
    {
        parent::__construct();
        $this->jqueryUrl = "\74\x73\143\x72\x69\160\164\40\163\x72\143\x3d\42\x68\164\x74\x70\x73\x3a\57\57\141\152\x61\x78\56\147\x6f\157\147\x6c\145\x61\x70\151\x73\56\143\x6f\155\57\141\152\141\x78\57\x6c\x69\x62\163\x2f\152\161\x75\145\x72\x79\x2f\61\x2e\x31\x32\x2e\x34\57\x6a\161\165\145\162\171\x2e\x6d\x69\x6e\x2e\152\163\42\x3e\74\57\x73\143\162\x69\160\x74\76";
        $this->img = "\x3c\144\151\x76\x20\163\x74\171\x6c\145\x3d\x27\144\x69\163\x70\x6c\141\x79\72\164\x61\x62\154\145\73\164\x65\x78\x74\55\141\154\x69\147\x6e\x3a\x63\145\156\164\145\x72\x3b\47\76" . "\74\x69\x6d\x67\x20\163\x72\143\x3d\47\x7b\173\x4c\x4f\101\x44\105\x52\x5f\103\123\126\175\x7d\x27\76" . "\x3c\x2f\x64\151\x76\76";
        $this->paneContent = "\74\144\151\x76\40\x73\164\x79\154\145\75\47\164\145\170\164\x2d\x61\154\151\x67\x6e\x3a\143\x65\x6e\x74\x65\162\73\x77\x69\x64\164\x68\72\40\61\60\60\45\x3b\150\x65\151\147\x68\x74\x3a\x20\64\x35\60\x70\x78\73\x64\x69\x73\x70\154\x61\171\72\40\x62\154\157\143\153\x3b" . "\155\x61\162\147\x69\156\x2d\x74\x6f\x70\72\x20\x34\x30\x25\73\x76\145\162\164\x69\x63\141\154\55\141\154\151\147\156\x3a\x20\155\x69\x64\x64\154\x65\x3b\47\x3e" . "\173\173\103\x4f\x4e\124\105\116\x54\x7d\x7d" . "\x3c\x2f\144\x69\166\76";
        $this->messageDiv = "\74\x64\x69\166\x20\163\x74\x79\154\x65\x3d\x27\x66\x6f\x6e\x74\55\x73\164\171\154\x65\x3a\x20\151\164\x61\154\x69\x63\x3b\x66\x6f\x6e\164\x2d\x77\145\x69\x67\x68\x74\72\40\66\60\60\73\143\x6f\154\157\x72\72\40\x23\62\x33\62\x38\x32\x64\x3b" . "\146\157\x6e\x74\x2d\146\141\x6d\151\x6c\171\72\123\x65\x67\157\x65\x20\x55\x49\x2c\110\x65\154\166\145\x74\151\143\141\40\116\145\x75\x65\54\x73\x61\156\163\x2d\x73\145\162\151\146\73" . "\x63\x6f\154\157\162\x3a\43\x39\x34\x32\70\x32\x38\x3b\x27\x3e" . "\x7b\x7b\x4d\x45\123\123\x41\107\105\x7d\175" . "\x3c\x2f\144\151\x76\76";
        $this->successMessageDiv = "\74\144\151\166\40\x73\164\x79\x6c\145\75\47\146\x6f\x6e\164\x2d\163\164\x79\x6c\145\72\40\151\164\141\154\151\x63\73\146\157\x6e\164\x2d\x77\145\151\147\x68\164\x3a\40\66\60\x30\73\x63\157\x6c\157\162\x3a\x20\43\x32\x33\x32\70\62\144\x3b" . "\146\x6f\x6e\x74\55\146\141\155\151\x6c\171\72\x53\145\x67\157\x65\x20\x55\x49\x2c\x48\x65\154\166\145\x74\x69\143\141\x20\x4e\145\165\x65\54\x73\x61\156\163\55\163\x65\x72\x69\x66\x3b\143\x6f\x6c\x6f\x72\x3a\43\x31\63\x38\x61\x33\x64\x3b\47\76" . "\x7b\173\115\x45\123\123\101\107\x45\175\x7d" . "\74\57\x64\x69\x76\x3e";
        $this->img = str_replace("\173\x7b\x4c\117\x41\x44\105\122\x5f\103\123\x56\175\175", MOV_LOADER_URL, $this->img);
        $this->_nonce = "\155\x6f\x5f\x70\x6f\x70\165\x70\x5f\157\x70\164\151\157\156\x73";
        add_filter("\155\157\137\164\145\155\160\x6c\x61\164\145\137\x64\x65\146\141\165\154\164\163", array($this, "\147\145\x74\104\145\146\x61\165\x6c\164\x73"), 1, 1);
        add_filter("\x6d\x6f\137\x74\145\155\x70\x6c\141\164\x65\137\142\165\x69\154\144", array($this, "\142\x75\x69\x6c\x64"), 1, 5);
        add_action("\141\x64\x6d\x69\x6e\x5f\x70\157\163\x74\137\x6d\157\137\160\x72\145\x76\151\x65\x77\x5f\x70\x6f\x70\165\160", array($this, "\163\x68\x6f\167\120\x72\x65\166\151\145\x77"));
        add_action("\x61\144\155\151\x6e\x5f\160\x6f\163\x74\x5f\x6d\x6f\137\160\157\160\165\x70\x5f\163\141\166\145", array($this, "\163\141\166\x65\120\x6f\x70\165\x70"));
    }
    public function showPreview()
    {
        if (!(array_key_exists("\160\157\x70\165\160\164\x79\160\145", $_POST) && $_POST["\160\x6f\x70\x75\x70\x74\171\x70\x65"] != $this->getTemplateKey())) {
            goto ss;
        }
        return;
        ss:
        if ($this->isValidRequest()) {
            goto dX;
        }
        return;
        dX:
        $SF = "\x3c\x69\76" . mo_("\120\157\x70\125\x70\x20\115\145\x73\x73\x61\147\145\x20\163\150\x6f\x77\x73\x20\x75\x70\40\x68\145\162\x65\56") . "\x3c\57\x69\76";
        $rI = VerificationType::TEST;
        $X6 = stripslashes($_POST[$this->getTemplateEditorId()]);
        $Wj = false;
        $this->preview = TRUE;
        wp_send_json(MoUtility::createJson($this->parse($X6, $SF, $rI, $Wj), MoConstants::SUCCESS_JSON_TYPE));
    }
    public function savePopup()
    {
        if (!(!$this->isTemplateType() || !$this->isValidRequest())) {
            goto Sj;
        }
        return;
        Sj:
        $X6 = stripslashes($_POST[$this->getTemplateEditorId()]);
        $this->validateRequiredFields($X6);
        $nY = maybe_unserialize(get_mo_option("\143\165\163\x74\x6f\155\x5f\x70\x6f\x70\x75\x70\163"));
        $nY[$this->getTemplateKey()] = $X6;
        update_mo_option("\143\x75\x73\164\x6f\x6d\x5f\x70\x6f\160\x75\x70\x73", $nY);
        wp_send_json(MoUtility::createJson($this->showSuccessMessage(MoMessages::showMessage(MoMessages::TEMPLATE_SAVED)), MoConstants::SUCCESS_JSON_TYPE));
    }
    public function build($X6, $f6, $SF, $rI, $Wj)
    {
        if (!(strcasecmp($f6, $this->getTemplateKey()) != 0)) {
            goto Vd;
        }
        return $X6;
        Vd:
        $nY = maybe_unserialize(get_mo_option("\143\x75\x73\164\x6f\x6d\x5f\160\x6f\x70\165\x70\163"));
        $X6 = $nY[$this->getTemplateKey()];
        return $this->parse($X6, $SF, $rI, $Wj);
    }
    protected function validateRequiredFields($X6)
    {
        foreach ($this->requiredTags as $dy) {
            if (!(strpos($X6, $dy) === FALSE)) {
                goto iA;
            }
            $SF = str_replace("\173\173\x4d\105\123\x53\x41\107\x45\x7d\175", MoMessages::showMessage(MoMessages::REQUIRED_TAGS, array("\x54\101\x47" => $dy)), $this->messageDiv);
            wp_send_json(MoUtility::createJson(str_replace("\173\173\103\117\116\124\105\116\124\175\x7d", $SF, $this->paneContent), MoConstants::ERROR_JSON_TYPE));
            iA:
            L8:
        }
        ov:
    }
    protected function showSuccessMessage($SF)
    {
        $SF = str_replace("\x7b\173\115\x45\x53\x53\101\x47\x45\x7d\175", $SF, $this->successMessageDiv);
        return str_replace("\x7b\173\103\117\x4e\x54\105\116\124\x7d\x7d", $SF, $this->paneContent);
    }
    protected function showMessage($SF)
    {
        $SF = str_replace("\x7b\x7b\115\x45\123\x53\x41\x47\x45\175\x7d", $SF, $this->messageDiv);
        return str_replace("\173\173\103\x4f\x4e\x54\x45\116\124\x7d\175", $SF, $this->paneContent);
    }
    protected function isTemplateType()
    {
        return array_key_exists("\x70\157\160\x75\160\164\171\160\x65", $_POST) && strcasecmp($_POST["\160\157\160\165\160\164\x79\160\x65"], $this->getTemplateKey()) == 0;
    }
    public function getTemplateKey()
    {
        return $this->key;
    }
    public function getTemplateEditorId()
    {
        return $this->templateEditorID;
    }
}
