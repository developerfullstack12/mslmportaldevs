<?php


namespace OTP\Helper;

if (defined("\x41\102\123\120\101\124\110")) {
    goto ya;
}
die;
ya:
class MoDisplayMessages
{
    private $_message;
    private $_type;
    function __construct($SF, $QH)
    {
        $this->_message = $SF;
        $this->_type = $QH;
        add_action("\141\x64\155\151\156\x5f\x6e\x6f\164\151\143\x65\x73", array($this, "\x72\x65\156\144\145\162"));
    }
    function render()
    {
        switch ($this->_type) {
            case "\103\x55\x53\124\x4f\115\x5f\x4d\105\x53\123\101\x47\105":
                echo mo_($this->_message);
                goto c0;
            case "\x4e\117\x54\111\x43\x45":
                echo "\74\x64\151\x76\40\163\164\171\154\145\75\42\x6d\141\162\x67\x69\x6e\55\164\157\x70\x3a\61\x25\x3b\x22" . "\143\154\141\x73\163\x3d\x22\x69\x73\55\x64\151\x73\x6d\x69\163\163\151\x62\x6c\x65\x20\x6e\x6f\164\151\x63\x65\40\x6e\x6f\x74\151\x63\145\x2d\x77\141\162\156\x69\x6e\x67\40\x6d\x6f\x2d\x61\144\155\151\156\55\156\x6f\x74\151\146\x22\x3e" . "\x3c\x70\x3e" . mo_($this->_message) . "\x3c\57\160\76" . "\74\57\144\x69\166\x3e";
                goto c0;
            case "\105\x52\122\x4f\x52":
                echo "\x3c\144\x69\166\x20\x73\x74\171\x6c\x65\75\42\155\141\x72\x67\151\156\55\164\157\160\x3a\x31\45\73\x22" . "\143\154\141\x73\163\75\42\156\x6f\164\x69\143\145\x20\156\x6f\x74\x69\x63\145\x2d\145\x72\162\157\162\x20\x69\x73\x2d\144\x69\x73\x6d\151\163\163\x69\142\154\145\x20\x6d\x6f\x2d\x61\144\x6d\151\x6e\x2d\x6e\157\164\x69\146\42\76" . "\x3c\160\x3e" . mo_($this->_message) . "\74\57\x70\x3e" . "\74\57\144\151\x76\76";
                goto c0;
            case "\x53\x55\x43\103\x45\x53\x53":
                echo "\74\144\151\x76\40\x20\x73\164\x79\154\x65\75\42\x6d\x61\x72\147\x69\x6e\x2d\x74\157\x70\x3a\x31\x25\73\x22" . "\x63\154\x61\x73\x73\x3d\x22\x6e\x6f\x74\151\x63\x65\40\x6e\x6f\164\x69\143\x65\x2d\163\165\x63\143\x65\163\x73\x20\x69\x73\x2d\144\x69\x73\x6d\151\163\x73\x69\142\154\145\x20\155\157\55\x61\144\x6d\x69\156\55\156\x6f\164\x69\146\42\x3e" . "\x3c\x70\x3e" . mo_($this->_message) . "\74\57\160\x3e" . "\74\57\x64\x69\166\x3e";
                goto c0;
        }
        tA:
        c0:
    }
    function showMessageDivAddons()
    {
        switch ($this->_type) {
            case "\x4d\117\x5f\x41\x44\104\117\116\137\115\105\x53\123\x41\x47\105\x5f\x43\125\123\x54\x4f\115\137\115\105\x53\123\101\x47\105\137\123\125\x43\x43\x45\x53\123":
                echo "\74\x64\x69\166\x20\40\163\x74\x79\x6c\145\75\x22\x6d\x61\162\147\x69\156\x2d\164\x6f\160\x3a\61\x25\x3b\x22" . "\x63\x6c\x61\x73\163\75\x22\156\x6f\164\x69\143\x65\x20\156\x6f\x74\151\143\145\x2d\x73\x75\143\143\x65\163\x73\x20\151\x73\x2d\144\x69\163\155\151\163\x73\151\x62\x6c\x65\40\x6d\x6f\55\141\144\155\151\156\x2d\156\157\x74\x69\146\x22\x3e" . "\x3c\160\x3e" . mo_($this->_message) . "\x3c\57\160\76" . "\74\x2f\x64\151\x76\76";
                goto jb;
            case "\x4d\x4f\137\101\104\x44\x4f\x4e\x5f\x4d\x45\x53\123\x41\107\x45\x5f\x43\x55\x53\x54\x4f\x4d\137\115\105\123\x53\x41\107\105\x5f\x45\x52\x52\x4f\122":
                echo "\74\144\x69\x76\40\x73\164\171\x6c\145\75\42\155\141\x72\x67\x69\156\x2d\164\157\x70\x3a\61\45\x3b\42" . "\143\154\x61\x73\163\x3d\42\156\x6f\164\151\143\145\40\x6e\x6f\x74\151\143\x65\x2d\145\x72\162\157\162\x20\151\x73\55\144\151\x73\x6d\x69\163\x73\x69\x62\x6c\145\40\x6d\x6f\55\141\x64\x6d\151\156\55\x6e\157\x74\151\146\42\76" . "\x3c\x70\76" . mo_($this->_message) . "\74\x2f\160\x3e" . "\74\57\144\x69\166\76";
                goto jb;
        }
        a_:
        jb:
    }
}
