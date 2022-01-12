<?php


namespace OTP\Helper;

if (defined("\101\x42\123\x50\101\x54\x48")) {
    goto pK;
}
die;
pK:
use OTP\MoOTP;
use OTP\Objects\PluginPageDetails;
use OTP\Objects\TabDetails;
use OTP\Traits\Instance;
final class MenuItems
{
    use Instance;
    private $_callback;
    private $_menuSlug;
    private $_menuLogo;
    private $_tabDetails;
    private function __construct()
    {
        $this->_callback = array(MoOTP::instance(), "\x6d\x6f\x5f\143\165\163\164\x6f\x6d\x65\x72\x5f\166\x61\x6c\x69\x64\x61\x74\151\157\x6e\137\157\160\164\x69\x6f\156\x73");
        $this->_menuLogo = MOV_ICON;
        $qZ = TabDetails::instance();
        $this->_tabDetails = $qZ->_tabDetails;
        $this->_menuSlug = $qZ->_parentSlug;
        $this->addMainMenu();
        $this->addSubMenus();
    }
    private function addMainMenu()
    {
        add_menu_page("\117\x54\x50\40\x56\145\162\x69\146\151\143\x61\x74\x69\157\x6e", "\117\124\120\x20\126\x65\x72\151\146\151\x63\x61\164\x69\157\x6e", "\155\141\x6e\141\x67\145\x5f\157\x70\164\151\157\156\163", $this->_menuSlug, $this->_callback, $this->_menuLogo);
    }
    private function addSubMenus()
    {
        foreach ($this->_tabDetails as $NM) {
            add_submenu_page($this->_menuSlug, $NM->_pageTitle, $NM->_menuTitle, "\x6d\x61\156\x61\x67\145\x5f\x6f\x70\x74\151\x6f\x6e\163", $NM->_menuSlug, $this->_callback);
            In:
        }
        Sk:
    }
}
