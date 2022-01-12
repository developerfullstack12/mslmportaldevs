<?php


namespace OTP\Helper\Templates;

if (defined("\101\102\123\x50\101\124\x48")) {
    goto p8;
}
die;
p8:
use OTP\Objects\MoITemplate;
use OTP\Objects\Template;
use OTP\Traits\Instance;
class ExternalPopup extends Template implements MoITemplate
{
    use Instance;
    protected function __construct()
    {
        $this->key = "\x45\x58\124\x45\122\x4e\101\114";
        $this->templateEditorID = "\x63\x75\x73\164\x6f\155\x45\x6d\x61\x69\154\x4d\163\x67\105\x64\x69\164\157\162\x33";
        $this->requiredTags = array_merge($this->requiredTags, array("\173\x7b\x50\110\117\x4e\x45\137\106\x49\105\114\x44\137\x4e\101\115\105\175\x7d", "\173\x7b\123\105\x4e\x44\x5f\117\x54\x50\137\x42\124\116\137\x49\104\175\175", "\x7b\173\126\x45\x52\111\106\x49\x43\101\x54\x49\117\116\x5f\106\x49\105\114\104\137\116\101\x4d\x45\x7d\x7d", "\x7b\173\126\101\x4c\x49\104\x41\x54\105\137\102\x54\x4e\x5f\x49\x44\175\x7d", "\x7b\173\123\x45\116\x44\x5f\117\x54\x50\137\x42\124\x4e\137\x49\x44\175\175", "\x7b\x7b\x56\105\122\111\106\x59\137\103\117\104\x45\x5f\x42\117\x58\175\x7d"));
        parent::__construct();
    }
    public function getDefaults($xC)
    {
        if (is_array($xC)) {
            goto Fn1;
        }
        $xC = array();
        Fn1:
        $xC[$this->getTemplateKey()] = file_get_contents(MOV_DIR . "\x69\x6e\x63\154\165\144\x65\x73\57\x68\x74\x6d\x6c\57\x65\x78\x74\145\x72\x6e\141\x6c\160\150\x6f\156\x65\56\x6d\x69\x6e\56\x68\x74\155\154");
        return $xC;
    }
    public function parse($X6, $SF, $rI, $Wj)
    {
        $OH = $this->getRequiredScripts();
        $jt = $this->preview ? '' : extra_post_data();
        $ub = "\x3c\151\x6e\x70\x75\x74\x20\x74\x79\160\x65\x3d\x22\150\x69\x64\x64\145\156\42\40\156\141\155\145\x3d\x22\157\x70\x74\151\x6f\156\42\x20\166\x61\154\x75\x65\x3d\42\155\x6f\x5f\x61\x6a\141\x78\x5f\x66\157\x72\x6d\x5f\x76\x61\154\x69\x64\x61\x74\145\x22\x20\x2f\x3e";
        $X6 = str_replace("\x7b\x7b\x4a\121\x55\105\x52\x59\x7d\175", $this->jqueryUrl, $X6);
        $X6 = str_replace("\173\x7b\106\117\122\x4d\x5f\x49\x44\x7d\175", "\x6d\x6f\x5f\x76\x61\x6c\x69\144\x61\164\145\x5f\x66\x6f\162\x6d", $X6);
        $X6 = str_replace("\x7b\x7b\107\117\x5f\102\101\x43\113\137\101\103\x54\x49\x4f\x4e\x5f\x43\101\114\114\175\x7d", "\155\x6f\x5f\166\x61\x6c\x69\144\141\164\151\157\156\137\x67\x6f\142\x61\143\153\50\51\x3b", $X6);
        $X6 = str_replace("\173\173\115\x4f\137\x43\123\123\137\x55\x52\114\175\x7d", MOV_CSS_URL, $X6);
        $X6 = str_replace("\x7b\173\x4f\124\x50\x5f\115\105\x53\123\101\x47\105\x5f\102\x4f\x58\x7d\175", "\x6d\157\x5f\x6d\x65\x73\163\x61\x67\x65", $X6);
        $X6 = str_replace("\173\x7b\x52\x45\x51\x55\111\122\105\x44\137\106\x4f\x52\115\x53\x5f\123\103\x52\x49\x50\124\123\x7d\175", $OH, $X6);
        $X6 = str_replace("\x7b\173\x48\x45\x41\104\x45\122\x7d\175", mo_("\126\141\154\x69\x64\x61\x74\x65\x20\x4f\124\120\x20\x28\x4f\156\145\40\x54\151\155\x65\40\120\141\x73\x73\143\157\144\x65\51"), $X6);
        $X6 = str_replace("\x7b\x7b\x47\117\x5f\102\101\x43\113\175\x7d", mo_("\x26\x6c\141\x72\x72\73\x20\107\x6f\40\102\x61\x63\x6b"), $X6);
        $X6 = str_replace("\173\x7b\115\x45\123\x53\x41\107\x45\175\175", mo_($SF), $X6);
        $X6 = str_replace("\x7b\x7b\x52\x45\121\x55\x49\x52\105\104\137\106\x49\x45\114\104\123\175\x7d", $ub, $X6);
        $X6 = str_replace("\x7b\x7b\x50\x48\117\x4e\105\x5f\106\111\105\114\104\x5f\x4e\x41\115\105\x7d\175", "\155\x6f\x5f\x70\x68\x6f\x6e\145\x5f\x6e\165\155\x62\145\162", $X6);
        $X6 = str_replace("\x7b\x7b\x4f\124\120\137\106\111\x45\x4c\x44\x5f\124\x49\x54\114\x45\175\x7d", mo_("\x45\156\164\145\x72\x20\x43\157\144\x65\56"), $X6);
        $X6 = str_replace("\x7b\173\126\105\x52\x49\106\x59\x5f\x43\x4f\x44\105\137\102\x4f\130\175\x7d", "\x6d\157\x5f\x76\141\x6c\x69\x64\141\x74\145\137\x6f\x74\x70", $X6);
        $X6 = str_replace("\x7b\x7b\x56\105\122\x49\106\x49\x43\x41\x54\111\117\116\x5f\106\x49\x45\114\104\x5f\x4e\x41\x4d\105\x7d\x7d", "\x6d\x6f\137\x6f\x74\x70\x5f\164\157\153\145\156", $X6);
        $X6 = str_replace("\x7b\173\126\x41\x4c\x49\104\101\124\105\x5f\x42\124\x4e\137\x49\104\175\x7d", "\166\141\154\151\144\141\164\x65\x5f\157\164\x70", $X6);
        $X6 = str_replace("\x7b\x7b\x56\x41\114\x49\x44\101\x54\105\137\102\x55\124\124\x4f\116\x5f\x54\105\130\124\175\x7d", mo_("\x56\141\x6c\151\x64\x61\164\x65"), $X6);
        $X6 = str_replace("\173\x7b\x53\105\x4e\x44\137\117\124\120\x5f\x54\105\130\x54\175\x7d", mo_("\x53\x65\x6e\144\x20\117\x54\x50"), $X6);
        $X6 = str_replace("\x7b\173\x53\105\x4e\x44\137\117\124\x50\137\102\124\x4e\137\111\x44\175\x7d", "\163\x65\156\x64\137\x6f\x74\160", $X6);
        $X6 = str_replace("\x7b\x7b\105\x58\x54\x52\x41\x5f\x50\117\x53\x54\137\104\x41\124\x41\x7d\x7d", $jt, $X6);
        $X6 .= $this->getExtraFormFields();
        return $X6;
    }
    private function getExtraFormFields()
    {
        $XM = "\74\x66\x6f\162\155\x20\156\x61\155\x65\x3d\x22\146\42\40\155\x65\164\x68\157\144\x3d\x22\x70\x6f\163\x74\x22\x20\x61\x63\164\x69\157\x6e\75\42\42\40\x69\x64\x3d\42\x76\141\154\151\x64\141\x74\x69\x6f\156\137\147\x6f\x42\x61\143\x6b\x5f\146\x6f\x72\x6d\x22\76\xd\12\x20\40\x20\40\x20\x20\x20\x20\x20\40\40\x20\x20\40\x20\40\40\40\40\x20\40\40\40\40\x3c\151\x6e\160\x75\164\40\151\144\x3d\x22\x76\x61\x6c\x69\144\141\x74\151\x6f\x6e\x5f\x67\x6f\x42\141\x63\153\x22\40\156\x61\155\145\x3d\x22\x6f\160\x74\151\157\x6e\x22\x20\166\141\154\165\x65\75\42\x76\141\x6c\151\x64\x61\164\x69\157\156\x5f\x67\157\x42\x61\143\153\42\40\x74\x79\160\x65\x3d\x22\x68\x69\144\144\145\156\42\x2f\76\xd\xa\x20\40\40\x20\40\x20\40\x20\x20\x20\x20\40\40\40\40\x20\40\40\40\40\x3c\x2f\x66\x6f\162\x6d\x3e";
        return $XM;
    }
    private function getRequiredScripts()
    {
        $F5 = "\74\x73\164\171\154\145\x3e\56\155\157\137\x63\x75\x73\164\x6f\155\145\x72\x5f\166\141\x6c\151\144\x61\164\x69\x6f\156\55\155\x6f\x64\x61\x6c\x7b\x64\x69\x73\x70\x6c\141\171\72\x62\x6c\x6f\x63\x6b\x21\x69\155\x70\x6f\x72\x74\x61\x6e\x74\x7d\74\57\163\x74\x79\154\145\x3e";
        if (!$this->preview) {
            goto zb;
        }
        $F5 .= "\74\163\143\x72\151\x70\x74\x3e" . "\44\x6d\x6f\75\152\x51\165\x65\162\171\54" . "\x24\x6d\x6f\50\x22\43\155\157\137\x76\141\154\x69\x64\x61\164\145\137\x66\x6f\x72\155\x22\51\56\163\165\142\155\x69\164\x28\146\165\156\x63\164\151\157\156\50\145\x29\173" . "\x65\x2e\x70\162\x65\166\145\156\x74\x44\145\146\x61\165\154\x74\x28\x29\x3b" . "\175\51\x3b" . "\74\57\163\x63\x72\151\x70\x74\76";
        goto Fe;
        zb:
        $F5 .= "\x3c\x73\x63\162\151\160\x74\76\146\165\x6e\x63\164\151\x6f\156\40\x6d\x6f\x5f\x76\x61\154\x69\144\x61\164\151\157\x6e\137\147\157\x62\141\x63\x6b\50\x29\173\15\12\x20\40\40\x20\40\x20\40\40\40\40\x20\40\x20\x20\x20\x64\x6f\x63\165\155\145\x6e\164\x2e\x67\145\164\105\154\145\x6d\145\x6e\164\x42\x79\111\x64\50\42\166\141\x6c\151\144\141\x74\x69\x6f\156\137\147\157\x42\141\143\153\x5f\146\x6f\162\x6d\42\x29\56\x73\165\142\x6d\151\x74\50\51\175\73" . "\152\x51\x75\x65\162\171\50\x64\157\x63\165\x6d\x65\x6e\x74\x29\56\162\145\141\144\x79\x28\x66\165\156\x63\164\151\x6f\156\50\x29\173" . "\x24\x6d\x6f\75\152\x51\x75\145\x72\171\54" . "\44\x6d\x6f\x28\42\43\163\145\156\144\137\x6f\164\160\x22\51\x2e\x63\x6c\x69\143\x6b\x28\x66\165\156\x63\x74\x69\157\156\x28\157\x29\x7b" . "\166\141\162\x20\x65\75\44\x6d\x6f\x28\x22\151\156\160\x75\164\x5b\156\x61\155\145\x3d\x6d\x6f\x5f\160\x68\157\156\145\137\156\165\155\x62\x65\x72\x5d\42\51\56\x76\141\x6c\x28\x29\73" . "\x24\x6d\x6f\x28\x22\43\155\157\137\155\145\x73\x73\x61\147\x65\x22\x29\56\x65\155\x70\x74\171\x28\x29\54" . "\44\155\157\50\x22\43\x6d\157\x5f\x6d\145\163\163\x61\x67\145\x22\51\56\x61\x70\x70\x65\x6e\144\50\x22" . $this->img . "\x22\51\x2c" . "\44\155\x6f\50\x22\43\155\x6f\137\x6d\x65\x73\x73\141\147\145\42\x29\56\163\x68\x6f\x77\50\x29\x2c" . "\44\155\x6f\56\x61\x6a\141\170\x28\173" . "\165\162\x6c\72\42" . site_url() . "\x2f\x3f\157\x70\164\x69\157\156\x3d\x6d\x69\156\x69\x6f\162\x61\156\147\x65\55\x61\x6a\141\170\55\x6f\164\x70\55\x67\145\156\145\162\x61\164\145\x22\x2c" . "\x74\x79\x70\x65\72\x22\120\117\x53\x54\42\x2c" . "\x64\x61\164\x61\x3a\173\165\163\x65\x72\x5f\160\x68\157\156\x65\72\x65\175\54" . "\x63\x72\157\x73\x73\x44\x6f\155\141\151\156\72\x21\x30\x2c" . "\144\141\164\141\124\x79\160\x65\x3a\x22\x6a\x73\x6f\x6e\42\54\15\xa\x20\x20\x20\x20\x20\40\x20\40\40\x20\x20\40\40\x20\40\40\x20\x20\x20\40\40\x20\x20\40\x20\x20\40\40\x20\40\x20\40\x73\x75\143\143\145\x73\x73\72\x66\x75\x6e\143\x74\x69\x6f\156\50\157\x29\x7b" . "\x22\x73\x75\x63\x63\145\x73\x73\x22\x3d\x3d\x6f\56\162\145\x73\x75\154\164\x3f\x28" . "\x24\x6d\157\50\42\x23\x6d\157\x5f\x6d\x65\163\163\x61\x67\145\x22\x29\56\x65\x6d\x70\x74\x79\50\51\x2c" . "\x24\x6d\x6f\50\x22\x23\x6d\x6f\x5f\x6d\145\x73\163\x61\x67\145\x22\x29\56\x61\160\160\x65\156\x64\50\157\x2e\x6d\x65\163\163\x61\x67\145\x29\x2c" . "\44\x6d\x6f\50\42\x23\155\157\137\155\145\x73\x73\x61\147\145\x22\x29\56\x63\163\163\50\x22\x62\x61\x63\x6b\x67\x72\x6f\165\x6e\x64\55\143\157\154\x6f\162\x22\x2c\x22\43\x38\145\145\144\x38\x65\x22\x29\54" . "\x24\x6d\x6f\50\x22\43\166\141\154\x69\x64\x61\164\x65\137\x6f\x74\x70\x22\x29\56\163\150\157\x77\50\x29\54" . "\x24\155\157\x28\42\43\163\145\x6e\x64\x5f\x6f\x74\x70\42\x29\x2e\166\x61\154\50\x22" . mo_("\x52\145\163\x65\156\144\x20\117\124\120") . "\42\51\x2c" . "\44\155\157\50\x22\x23\155\157\x5f\166\141\154\151\x64\141\x74\145\137\x6f\164\x70\x22\51\x2e\163\x68\157\167\50\51\x2c" . "\44\155\x6f\x28\42\151\x6e\160\x75\164\x5b\156\141\x6d\145\x3d\x6d\x6f\x5f\166\x61\x6c\151\144\141\164\x65\x5f\x6f\164\x70\135\42\x29\x2e\x66\x6f\143\x75\163\50\51" . "\51\72\50" . "\x24\155\x6f\x28\x22\43\x6d\x6f\137\x6d\145\163\163\141\147\x65\x22\51\x2e\145\155\x70\x74\171\50\x29\54" . "\44\155\x6f\50\x22\x23\155\157\137\x6d\x65\x73\163\141\147\x65\42\x29\x2e\141\160\160\x65\156\x64\50\x6f\56\x6d\145\x73\x73\141\x67\x65\51\x2c" . "\x24\x6d\x6f\50\x22\x23\x6d\157\x5f\x6d\145\163\163\141\147\145\x22\51\x2e\143\163\x73\x28\42\142\141\143\x6b\147\162\x6f\165\x6e\144\55\x63\157\x6c\x6f\x72\42\54\42\43\145\144\x61\x35\x38\145\42\x29\54" . "\44\155\157\50\x22\x69\156\160\x75\164\x5b\156\x61\155\145\x3d\x6d\x6f\x5f\160\150\157\x6e\x65\x5f\x6e\x75\155\x62\145\x72\x5d\x22\x29\x2e\146\x6f\x63\165\163\x28\51" . "\51" . "\x7d\x2c" . "\145\162\x72\x6f\162\72\x66\x75\156\143\164\151\157\156\x28\157\54\x65\x2c\x6d\51\x7b\x7d" . "\175\x29" . "\175\51\54" . "\x24\x6d\x6f\x28\42\43\x76\141\x6c\151\144\141\x74\x65\x5f\x6f\164\x70\42\x29\56\x63\154\x69\x63\153\50\x66\165\x6e\143\164\151\157\x6e\50\157\51\x7b" . "\x76\x61\x72\x20\145\75\x24\155\x6f\50\x22\151\156\x70\165\164\133\x6e\141\x6d\145\75\x6d\x6f\x5f\157\x74\x70\x5f\x74\x6f\153\145\x6e\x5d\42\51\56\166\x61\x6c\50\x29\54" . "\155\75\44\155\157\x28\x22\151\156\160\x75\164\133\156\x61\x6d\x65\x3d\155\x6f\x5f\x70\x68\x6f\156\x65\x5f\x6e\x75\155\x62\145\x72\x5d\x22\x29\56\166\141\x6c\x28\x29\x3b" . "\x24\x6d\x6f\x28\42\x23\x6d\x6f\x5f\155\x65\x73\163\x61\147\145\x22\51\56\x65\x6d\160\164\171\50\x29\x2c" . "\x24\155\157\x28\42\43\155\x6f\x5f\x6d\145\x73\163\x61\147\145\42\51\x2e\141\160\x70\145\156\x64\x28\x22" . $this->img . "\x22\51\x2c" . "\x24\x6d\157\50\x22\x23\x6d\157\x5f\x6d\145\163\x73\x61\147\145\x22\x29\56\163\150\157\x77\50\51\x2c" . "\x24\x6d\157\56\141\x6a\x61\x78\x28\x7b" . "\x75\162\154\x3a\42" . site_url() . "\x2f\x3f\x6f\160\164\x69\157\156\75\x6d\x69\156\151\x6f\162\141\x6e\x67\145\55\141\x6a\x61\170\55\157\164\x70\x2d\166\x61\154\x69\x64\x61\164\145\42\54" . "\164\x79\160\x65\x3a\x22\120\117\x53\x54\42\x2c" . "\x64\x61\x74\x61\72\x7b\x6d\x6f\137\x6f\x74\160\137\x74\157\153\145\156\x3a\x65\x2c\x75\x73\x65\162\137\x70\150\x6f\156\145\x3a\155\175\54" . "\x63\162\157\163\x73\x44\x6f\155\x61\x69\156\72\41\60\54" . "\144\x61\x74\x61\x54\x79\160\x65\72\x22\152\x73\x6f\x6e\42\x2c" . "\163\165\143\x63\x65\163\163\72\x66\x75\x6e\143\164\151\157\x6e\50\157\51\x7b" . "\42\x73\165\143\143\145\163\x73\42\x3d\75\x6f\56\162\145\x73\x75\154\164\77\50" . "\x24\x6d\157\x28\x22\43\x6d\x6f\x5f\155\x65\x73\163\141\147\145\x22\x29\x2e\145\155\x70\x74\171\50\x29\x2c" . "\44\x6d\x6f\x28\x22\x23\155\x6f\137\166\x61\154\151\x64\141\164\x65\137\x66\157\x72\155\x22\x29\56\x73\165\142\x6d\x69\x74\x28\x29" . "\x29\x3a\50" . "\x24\x6d\x6f\50\x22\x23\155\x6f\137\x6d\x65\163\x73\x61\x67\145\x22\51\56\x65\x6d\x70\164\x79\x28\51\x2c" . "\44\155\157\50\42\x23\x6d\157\x5f\x6d\x65\x73\163\x61\147\x65\x22\51\56\141\x70\160\145\156\x64\50\157\56\155\145\163\x73\141\147\145\x29\x2c" . "\44\155\x6f\x28\x22\43\155\x6f\x5f\x6d\x65\x73\x73\x61\x67\x65\42\x29\x2e\143\x73\x73\50\x22\x62\141\x63\x6b\147\162\x6f\x75\x6e\144\55\143\157\154\157\x72\x22\54\x22\43\145\144\x61\x35\x38\x65\x22\51\54" . "\x24\155\157\x28\x22\151\x6e\x70\165\x74\x5b\x6e\141\x6d\x65\75\166\x61\x6c\x69\x64\x61\164\x65\x5f\157\164\x70\135\42\x29\x2e\146\157\143\x75\x73\x28\x29" . "\x29" . "\x7d\54" . "\x65\x72\162\157\162\72\146\x75\x6e\143\164\151\157\x6e\x28\x6f\54\x65\x2c\155\x29\x7b\x7d" . "\x7d\x29" . "\x7d\51" . "\175\51\x3b" . "\74\x2f\163\143\x72\x69\x70\164\x3e";
        Fe:
        return $F5;
    }
}
