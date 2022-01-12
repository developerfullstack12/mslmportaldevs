<?php


namespace OTP\Helper;

use OTP\Objects\FormHandler;
use OTP\Traits\Instance;
if (defined("\x41\102\x53\x50\101\x54\x48")) {
    goto hp;
}
die;
hp:
final class FormList
{
    use Instance;
    private $_forms;
    private $enabled_forms;
    private function __construct()
    {
        $this->_forms = array();
    }
    public function add($Zm, $form)
    {
        $this->_forms[$Zm] = $form;
        if (!$form->isFormEnabled()) {
            goto mv;
        }
        $this->enabled_forms[$Zm] = $form;
        mv:
    }
    public function getList()
    {
        return $this->_forms;
    }
    public function getEnabledForms()
    {
        return $this->enabled_forms;
    }
}
