<?php


namespace OTP\Helper;

use OTP\Objects\IMoSessions;
if (defined("\x41\x42\x53\x50\101\124\x48")) {
    goto ZD;
}
die;
ZD:
class MoPHPSessions implements IMoSessions
{
    static function addSessionVar($Zm, $vv)
    {
        switch (MOV_SESSION_TYPE) {
            case "\103\117\117\113\x49\105":
                setcookie($Zm, maybe_serialize($vv));
                goto kG;
            case "\123\x45\x53\123\111\117\x4e":
                self::checkSession();
                $_SESSION[$Zm] = maybe_serialize($vv);
                goto kG;
            case "\x43\x41\x43\x48\x45":
                if (wp_cache_add($Zm, maybe_serialize($vv))) {
                    goto WA;
                }
                wp_cache_replace($Zm, maybe_serialize($vv));
                WA:
                goto kG;
            case "\124\122\x41\x4e\x53\111\x45\x4e\124":
                if (!isset($_COOKIE["\164\x72\141\x6e\163\151\145\x6e\164\x5f\x6b\145\x79"])) {
                    goto it;
                }
                $nG = $_COOKIE["\x74\x72\x61\x6e\163\151\145\156\164\137\x6b\145\171"];
                goto PK;
                it:
                if (!wp_cache_get("\164\162\x61\156\163\x69\x65\x6e\x74\137\153\x65\171")) {
                    goto qk;
                }
                $nG = wp_cache_get("\164\x72\141\x6e\163\x69\x65\x6e\164\137\153\x65\171");
                goto F5;
                qk:
                $nG = MoUtility::rand();
                if (!ob_get_contents()) {
                    goto u8;
                }
                ob_clean();
                u8:
                setcookie("\164\x72\x61\156\163\151\x65\156\164\x5f\x6b\x65\x79", $nG, time() + 12 * HOUR_IN_SECONDS, COOKIEPATH, COOKIE_DOMAIN);
                wp_cache_add("\x74\x72\x61\156\x73\x69\x65\156\x74\x5f\153\x65\x79", $nG);
                F5:
                PK:
                set_site_transient($nG . $Zm, $vv, 12 * HOUR_IN_SECONDS);
                goto kG;
        }
        y2:
        kG:
    }
    static function getSessionVar($Zm)
    {
        switch (MOV_SESSION_TYPE) {
            case "\103\117\117\113\x49\x45":
                return maybe_unserialize($_COOKIE[$Zm]);
            case "\123\x45\123\x53\111\117\116":
                self::checkSession();
                return maybe_unserialize(MoUtility::sanitizeCheck($Zm, $_SESSION));
            case "\103\x41\x43\110\105":
                return maybe_unserialize(wp_cache_get($Zm));
            case "\124\122\101\116\x53\111\105\116\124":
                $nG = isset($_COOKIE["\x74\x72\141\x6e\163\151\x65\156\164\x5f\x6b\145\171"]) ? $_COOKIE["\x74\x72\141\x6e\163\x69\145\156\164\x5f\153\145\x79"] : wp_cache_get("\164\162\x61\x6e\x73\x69\145\156\x74\137\153\145\x79");
                return get_site_transient($nG . $Zm);
        }
        LL:
        Xk:
    }
    static function unsetSession($Zm)
    {
        switch (MOV_SESSION_TYPE) {
            case "\103\x4f\117\113\x49\x45":
                unset($_COOKIE[$Zm]);
                setcookie($Zm, '', time() - 15 * 60);
                goto xG;
            case "\123\105\123\x53\111\117\116":
                self::checkSession();
                unset($_SESSION[$Zm]);
                goto xG;
            case "\103\x41\x43\110\x45":
                wp_cache_delete($Zm);
                goto xG;
            case "\124\x52\101\x4e\123\x49\105\x4e\124":
                $nG = isset($_COOKIE["\x74\162\141\156\163\151\x65\x6e\164\137\x6b\145\x79"]) ? $_COOKIE["\x74\162\141\x6e\163\x69\145\x6e\164\137\153\145\171"] : wp_cache_get("\x74\162\x61\156\x73\x69\145\x6e\x74\137\153\145\171");
                if (MoUtility::isBlank($nG)) {
                    goto tW;
                }
                delete_site_transient($nG . $Zm);
                tW:
                goto xG;
        }
        WK:
        xG:
    }
    static function checkSession()
    {
        if (!(MOV_SESSION_TYPE == "\x53\x45\x53\123\111\x4f\116")) {
            goto sY;
        }
        if (!(session_id() == '' || !isset($_SESSION))) {
            goto aJ;
        }
        session_start();
        aJ:
        sY:
    }
}
