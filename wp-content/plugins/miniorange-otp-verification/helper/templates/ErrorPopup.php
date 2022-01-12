<?php


namespace OTP\Helper\Templates;

if (defined("\101\102\x53\120\101\x54\110")) {
    goto nX;
}
die;
nX:
use OTP\Objects\MoITemplate;
use OTP\Objects\Template;
use OTP\Traits\Instance;
class ErrorPopup extends Template implements MoITemplate
{
    use Instance;
    protected function __construct()
    {
        $this->key = "\x45\122\x52\x4f\122";
        $this->templateEditorID = "\143\x75\163\164\157\155\x45\x6d\x61\151\x6c\115\x73\x67\x45\144\x69\164\x6f\162\x34";
        $this->requiredTags = array_diff($this->requiredTags, array("\x7b\173\106\x4f\x52\x4d\137\111\104\x7d\175", "\173\173\122\105\121\x55\x49\x52\105\104\137\x46\111\x45\114\x44\123\175\x7d"));
        parent::__construct();
    }
    public function getDefaults($xC)
    {
        if (is_array($xC)) {
            goto Hj;
        }
        $xC = array();
        Hj:
        $xC[$this->getTemplateKey()] = file_get_contents(MOV_DIR . "\151\156\x63\154\x75\144\145\x73\57\150\x74\x6d\x6c\57\x65\x72\x72\x6f\162\56\x6d\x69\x6e\x2e\150\x74\x6d\154");
        return $xC;
    }
    public function parse($X6, $SF, $rI, $Wj)
    {
        $Wj = $Wj ? "\164\x72\x75\145" : "\x66\x61\154\x73\145";
        $OH = $this->getRequiredFormsSkeleton($rI, $Wj);
        $X6 = str_replace("\x7b\x7b\x4a\x51\125\105\122\x59\x7d\x7d", $this->jqueryUrl, $X6);
        $X6 = str_replace("\173\x7b\107\x4f\x5f\x42\x41\103\x4b\137\101\103\124\x49\117\x4e\137\x43\101\114\x4c\175\x7d", "\x6d\157\x5f\x76\x61\154\x69\144\141\x74\151\x6f\x6e\137\147\157\142\x61\x63\x6b\50\51\73", $X6);
        $X6 = str_replace("\173\x7b\115\117\x5f\x43\123\123\137\125\x52\114\175\175", MOV_CSS_URL, $X6);
        $X6 = str_replace("\x7b\x7b\122\105\121\125\x49\122\105\104\x5f\x46\117\122\x4d\x53\x5f\123\x43\122\x49\x50\124\123\x7d\x7d", $OH, $X6);
        $X6 = str_replace("\173\173\110\105\x41\104\x45\x52\x7d\175", mo_("\126\x61\154\151\x64\141\164\x65\40\x4f\124\x50\x20\x28\117\x6e\145\x20\x54\151\x6d\x65\40\120\141\x73\x73\x63\157\x64\x65\x29"), $X6);
        $X6 = str_replace("\173\173\107\117\x5f\102\101\x43\113\175\x7d", mo_("\x26\x6c\141\162\162\73\x20\x47\x6f\40\102\x61\143\x6b"), $X6);
        $X6 = str_replace("\173\x7b\x4d\105\x53\x53\101\107\x45\175\175", mo_($SF), $X6);
        return $X6;
    }
    private function getRequiredFormsSkeleton($rI, $Wj)
    {
        $Sb = "\x3c\146\x6f\162\155\40\156\141\155\145\x3d\42\146\x22\x20\155\x65\x74\x68\157\144\75\x22\160\157\x73\164\x22\x20\x61\x63\164\151\x6f\156\75\x22\42\x20\x69\x64\75\x22\166\141\154\151\144\x61\x74\x69\157\x6e\x5f\147\x6f\102\x61\143\x6b\137\146\x6f\162\x6d\42\x3e\15\12\11\11\x9\74\151\x6e\x70\165\x74\x20\151\144\x3d\42\166\x61\x6c\x69\144\x61\x74\x69\x6f\x6e\137\x67\x6f\102\141\x63\x6b\42\x20\x6e\x61\x6d\x65\x3d\42\157\160\164\x69\157\x6e\x22\40\166\x61\x6c\x75\145\x3d\42\x76\x61\154\x69\x64\141\164\151\157\156\137\147\x6f\102\141\x63\x6b\42\x20\164\171\x70\145\75\x22\x68\151\144\x64\145\156\x22\57\x3e\xd\12\x9\x9\74\57\146\157\162\x6d\76\x7b\x7b\x53\x43\x52\x49\120\124\123\x7d\x7d";
        $Sb = str_replace("\x7b\173\x53\x43\122\x49\x50\124\x53\175\x7d", $this->getRequiredScripts(), $Sb);
        return $Sb;
    }
    private function getRequiredScripts()
    {
        $F5 = "\x3c\x73\164\x79\154\x65\76\x2e\x6d\x6f\137\143\x75\x73\x74\x6f\x6d\x65\162\x5f\166\141\154\151\x64\141\x74\x69\157\156\55\x6d\x6f\x64\141\154\x7b\x64\151\163\x70\154\141\171\72\x62\x6c\x6f\x63\153\41\151\155\160\157\162\x74\141\156\x74\175\x3c\57\x73\164\x79\154\x65\76";
        $F5 .= "\x3c\x73\x63\x72\x69\x70\164\x3e\146\x75\156\143\164\x69\157\x6e\40\x6d\157\137\x76\x61\x6c\151\144\x61\164\x69\157\x6e\x5f\147\x6f\142\141\x63\153\x28\51\173\144\157\143\x75\x6d\x65\x6e\x74\56\147\x65\164\105\154\145\155\145\156\164\102\x79\x49\x64\x28\42\166\x61\154\x69\x64\x61\164\151\157\156\137\x67\x6f\x42\141\x63\x6b\137\146\x6f\162\155\42\51\x2e\x73\x75\142\x6d\x69\x74\x28\51\x7d\x3c\x2f\163\x63\162\x69\160\x74\76";
        return $F5;
    }
}
