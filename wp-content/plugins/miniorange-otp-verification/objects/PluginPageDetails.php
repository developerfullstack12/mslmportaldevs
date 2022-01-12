<?php


namespace OTP\Objects;

class PluginPageDetails
{
    function __construct($Uj, $kj, $ct, $T8, $QL, $od, $ro, $uD = '', $zW = true)
    {
        $this->_pageTitle = $Uj;
        $this->_menuSlug = $kj;
        $this->_menuTitle = $ct;
        $this->_tabName = $T8;
        $this->_url = add_query_arg(array("\160\141\x67\x65" => $this->_menuSlug), $QL);
        $this->_url = remove_query_arg(array("\x61\144\144\x6f\x6e", "\146\157\x72\x6d", "\x73\x6d\163", "\163\x75\142\160\x61\147\145"), $this->_url);
        $this->_view = $od;
        $this->_id = $ro;
        $this->_showInNav = $zW;
        $this->_css = $uD;
    }
    public $_pageTitle;
    public $_menuSlug;
    public $_menuTitle;
    public $_tabName;
    public $_url;
    public $_view;
    public $_id;
    public $_showInNav;
    public $_css;
}
