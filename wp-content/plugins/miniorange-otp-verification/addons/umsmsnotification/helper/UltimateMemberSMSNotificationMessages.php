<?php


namespace OTP\Addons\UmSMSNotification\Helper;

use OTP\Helper\MoUtility;
use OTP\Objects\BaseMessages;
use OTP\Traits\Instance;
final class UltimateMemberSMSNotificationMessages extends BaseMessages
{
    use Instance;
    private function __construct()
    {
        define("\115\117\137\x55\x4d\137\x41\104\x44\117\116\137\x4d\105\x53\123\x41\x47\105\123", serialize(array(self::NEW_UM_CUSTOMER_NOTIF_HEADER => mo_("\x4e\x45\127\40\101\x43\103\117\125\116\x54\x20\x4e\117\124\111\106\111\x43\101\x54\111\x4f\x4e"), self::NEW_UM_CUSTOMER_NOTIF_BODY => mo_("\x43\x75\x73\x74\157\x6d\145\x72\163\40\x61\162\145\x20\163\x65\x6e\x74\x20\141\x20\x6e\x65\167\x20\x61\x63\143\157\x75\156\x74\40\x53\x4d\x53\40\156\157\x74\x69\146\x69\143\141\x74\151\x6f\x6e" . "\x20\x77\150\x65\156\x20\x74\150\x65\171\40\x73\x69\x67\x6e\40\165\160\40\157\156\40\164\150\x65\x20\x73\151\x74\145\x2e"), self::NEW_UM_CUSTOMER_SMS => mo_("\124\x68\x61\x6e\x6b\x73\40\x66\157\162\x20\x63\162\145\141\x74\x69\x6e\147\x20\141\x6e\x20\x61\143\x63\x6f\x75\156\x74\40\157\x6e\40\x7b\x73\151\164\x65\55\156\x61\x6d\145\x7d\56" . "\x25\x30\x61\x59\157\165\162\40\x75\x73\145\162\x6e\x61\x6d\145\40\151\x73\40\173\x75\163\x65\x72\x6e\141\155\145\x7d\x2e\x25\x30\141\114\157\147\151\x6e\40\110\x65\x72\x65\72\x20" . "\x7b\141\143\143\x6f\165\x6e\x74\x70\x61\x67\x65\55\165\x72\x6c\175"), self::NEW_UM_CUSTOMER_ADMIN_NOTIF_BODY => mo_("\x41\x64\155\151\x6e\x73\x20\x61\162\x65\40\x73\145\156\164\x20\141\x20\156\x65\167\x20\141\143\x63\157\165\x6e\x74\40\123\x4d\x53\x20\x6e\x6f\164\151\146\x69\x63\141\164\x69\x6f\156\x20\x77\150\x65\x6e" . "\x20\141\40\165\x73\145\162\40\163\151\147\x6e\163\40\165\160\x20\x6f\156\x20\x74\150\145\x20\x73\x69\x74\x65\56"), self::NEW_UM_CUSTOMER_ADMIN_SMS => mo_("\116\x65\x77\40\x55\163\x65\162\x20\103\x72\145\x61\164\145\x64\40\157\156\40\173\163\151\164\x65\55\x6e\x61\x6d\145\x7d\56\x25\60\141\125\x73\x65\162\x6e\x61\x6d\x65\72\40" . "\173\165\x73\145\162\x6e\x61\155\145\175\x2e\x25\x30\141\x50\x72\x6f\146\151\x6c\x65\40\x50\141\x67\x65\72\x20\173\x61\143\143\157\x75\156\164\x70\x61\147\x65\x2d\x75\x72\154\175"))));
    }
    public static function showMessage($ur, $pO = array())
    {
        $MA = '';
        $ur = explode("\40", $ur);
        $Ze = unserialize(MO_UM_ADDON_MESSAGES);
        $Xo = unserialize(MO_MESSAGES);
        $Ze = array_merge($Ze, $Xo);
        foreach ($ur as $KJ) {
            if (!MoUtility::isBlank($KJ)) {
                goto mo;
            }
            return $MA;
            mo:
            $iD = $Ze[$KJ];
            foreach ($pO as $Zm => $zs) {
                $iD = str_replace("\x7b\173" . $Zm . "\x7d\175", $zs, $iD);
                oI:
            }
            oR1:
            $MA .= $iD;
            WS:
        }
        r_:
        return $MA;
    }
}
