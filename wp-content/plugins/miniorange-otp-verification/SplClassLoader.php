<?php


namespace OTP;

if (defined("\x41\102\123\120\101\x54\x48")) {
    goto t5;
}
die;
t5:
final class SplClassLoader
{
    private $_fileExtension = "\56\160\x68\160";
    private $_namespace;
    private $_includePath;
    private $_namespaceSeparator = "\134";
    public function __construct($Rp = null, $q9 = null)
    {
        $this->_namespace = $Rp;
        $this->_includePath = $q9;
    }
    public function register()
    {
        spl_autoload_register(array($this, "\x6c\x6f\141\x64\103\x6c\141\x73\x73"));
    }
    public function unregister()
    {
        spl_autoload_unregister(array($this, "\x6c\x6f\141\x64\103\154\x61\x73\163"));
    }
    public function loadClass($S0)
    {
        if (!(null === $this->_namespace || $this->isSameNamespace($S0))) {
            goto wV;
        }
        $cu = '';
        $hr = '';
        if (!(false !== ($qr = strripos($S0, $this->_namespaceSeparator)))) {
            goto qg;
        }
        $hr = strtolower(substr($S0, 0, $qr));
        $S0 = substr($S0, $qr + 1);
        $cu = str_replace($this->_namespaceSeparator, DIRECTORY_SEPARATOR, $hr) . DIRECTORY_SEPARATOR;
        qg:
        $cu .= str_replace("\x5f", DIRECTORY_SEPARATOR, $S0) . $this->_fileExtension;
        $cu = str_replace("\x6f\164\x70", MOV_NAME, $cu);
        require ($this->_includePath !== null ? $this->_includePath . DIRECTORY_SEPARATOR : '') . $cu;
        wV:
    }
    private function isSameNamespace($S0)
    {
        return $this->_namespace . $this->_namespaceSeparator === substr($S0, 0, strlen($this->_namespace . $this->_namespaceSeparator));
    }
}
