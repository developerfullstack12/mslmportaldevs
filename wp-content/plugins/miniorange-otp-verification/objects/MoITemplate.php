<?php


namespace OTP\Objects;

interface MoITemplate
{
    public function build($X6, $f6, $SF, $rI, $Wj);
    public function parse($X6, $SF, $rI, $Wj);
    public function getDefaults($xC);
    public function showPreview();
    public function savePopup();
    public static function instance();
    public function getTemplateKey();
    public function getTemplateEditorId();
}
