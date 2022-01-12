<?php


namespace OTP\Addons\PasswordReset\Helper;

use OTP\Helper\MoUtility;
use OTP\Objects\BaseMessages;
use OTP\Traits\Instance;
final class UMPasswordResetMessages extends BaseMessages
{
    use Instance;
    private function __construct()
    {
        define("\x4d\x4f\x5f\x55\115\x50\122\x5f\101\x44\104\117\x4e\137\115\105\123\x53\101\x47\x45\123", serialize(array(self::USERNAME_MISMATCH => mo_("\125\163\145\162\x6e\141\x6d\145\40\164\x68\x61\x74\x20\x74\150\145\40\x4f\124\120\x20\167\x61\163\x20\163\x65\x6e\164\40\x74\x6f\40\141\156\144\x20\x74\x68\145\40\x75\x73\x65\x72\156\x61\155\145\x20\163\165\142\x6d\x69\164\164\145\x64\40\144\157\x20\x6e\157\x74\40\155\141\164\x63\x68"), self::USERNAME_NOT_EXIST => mo_("\127\x65\40\143\141\156\x27\164\x20\146\151\x6e\x64\40\141\x6e\x20\x61\143\143\157\165\x6e\164\x20\x72\145\147\x69\x73\164\145\x72\x65\144\40\x77\151\x74\x68\40\164\x68\x61\164\x20\141\144\144\162\145\163\x73\x20\157\162\x20" . "\165\x73\x65\162\x6e\x61\155\x65\x20\157\x72\x20\160\x68\x6f\156\145\40\156\x75\x6d\x62\145\x72"), self::RESET_LABEL => mo_("\124\157\x20\x72\x65\163\x65\164\40\x79\157\165\x72\x20\160\x61\163\x73\167\x6f\162\144\x2c\40\160\x6c\x65\x61\x73\145\40\145\156\x74\145\x72\40\x79\x6f\x75\x72\x20\145\x6d\141\151\154\40\141\144\x64\x72\145\x73\163\54\x20\x75\163\145\162\x6e\141\155\145\x20\x6f\162\40\x70\x68\x6f\x6e\145\x20\156\165\155\x62\x65\x72\x20\142\x65\x6c\x6f\167"), self::RESET_LABEL_OP => mo_("\124\x6f\40\162\x65\163\145\164\x20\171\x6f\165\162\x20\160\141\x73\163\167\157\162\x64\x2c\40\160\154\145\141\163\145\x20\x65\x6e\x74\145\x72\40\171\157\165\x72\x20\162\145\147\151\163\164\x65\162\145\x64\40\160\x68\157\156\x65\40\156\x75\x6d\142\145\x72\40\x62\x65\x6c\x6f\x77"))));
    }
    public static function showMessage($ur, $pO = array())
    {
        $MA = '';
        $ur = explode("\40", $ur);
        $Ze = unserialize(MO_UMPR_ADDON_MESSAGES);
        $Xo = unserialize(MO_MESSAGES);
        $Ze = array_merge($Ze, $Xo);
        foreach ($ur as $KJ) {
            if (!MoUtility::isBlank($KJ)) {
                goto PJ;
            }
            return $MA;
            PJ:
            $iD = $Ze[$KJ];
            foreach ($pO as $Zm => $zs) {
                $iD = str_replace("\173\x7b" . $Zm . "\x7d\x7d", $zs, $iD);
                tS:
            }
            lt:
            $MA .= $iD;
            v3:
        }
        QU:
        return $MA;
    }
}
