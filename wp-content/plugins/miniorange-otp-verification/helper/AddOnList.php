<?php


namespace OTP\Helper;

if (defined("\x41\102\x53\x50\x41\124\x48")) {
    goto mg;
}
die;
mg:
use OTP\Objects\BaseAddOnHandler;
use OTP\Traits\Instance;
final class AddOnList
{
    use Instance;
    private $_addOns;
    private function __construct()
    {
        $this->_addOns = array();
    }
    public function add($Zm, $form)
    {
        $this->_addOns[$Zm] = $form;
    }
    public function getList()
    {
        return $this->_addOns;
    }
}
