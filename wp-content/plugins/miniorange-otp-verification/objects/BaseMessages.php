<?php


namespace OTP\Objects;

class BaseMessages
{
    const GLOBALLY_INVALID_PHONE_FORMAT = "\x47\114\x4f\102\x41\114\x4c\x59\137\111\116\x56\x41\x4c\111\104\x5f\120\110\x4f\x4e\x45\137\x46\x4f\122\115\x41\x54";
    const OTP_SENT_PHONE = "\x4f\124\x50\x5f\123\105\116\124\137\120\110\x4f\x4e\x45";
    const OTP_SENT_EMAIL = "\x4f\124\x50\137\x53\x45\x4e\124\x5f\x45\x4d\101\111\x4c";
    const ERROR_OTP_EMAIL = "\x45\122\122\117\122\x5f\x4f\124\120\137\x45\115\x41\111\114";
    const ERROR_OTP_PHONE = "\105\x52\x52\x4f\x52\x5f\x4f\x54\120\137\120\x48\117\x4e\105";
    const ERROR_PHONE_FORMAT = "\105\122\x52\x4f\x52\137\120\x48\117\x4e\105\x5f\x46\117\122\115\101\124";
    const ERROR_EMAIL_FORMAT = "\105\x52\x52\117\122\x5f\x45\115\101\111\x4c\x5f\106\117\x52\x4d\101\x54";
    const CHOOSE_METHOD = "\x43\x48\x4f\117\123\x45\137\115\x45\x54\110\117\104";
    const PLEASE_VALIDATE = "\120\x4c\105\x41\x53\105\x5f\x56\x41\114\x49\x44\101\124\105";
    const REGISTER_WITH_US = "\x52\x45\x47\x49\123\124\105\122\x5f\x57\111\124\110\137\125\123";
    const ACTIVATE_PLUGIN = "\x41\103\124\111\126\101\x54\105\x5f\x50\114\125\107\111\116";
    const CONFIG_GATEWAY = "\103\x4f\116\x46\111\107\137\107\x41\124\x45\127\101\x59";
    const ERROR_PHONE_BLOCKED = "\105\122\122\x4f\x52\137\120\110\x4f\x4e\105\137\102\x4c\117\103\x4b\105\104";
    const ERROR_EMAIL_BLOCKED = "\105\122\122\117\x52\x5f\x45\115\x41\x49\114\137\102\114\x4f\103\113\x45\x44";
    const FORM_NOT_AVAIL_HEAD = "\106\117\x52\115\x5f\116\117\x54\137\x41\126\101\111\x4c\137\110\105\101\104";
    const FORM_NOT_AVAIL_BODY = "\106\117\122\x4d\137\116\x4f\124\137\101\126\101\111\x4c\137\x42\117\104\x59";
    const CHANGE_SENDER_ID_BODY = "\103\x48\x41\x4e\107\105\137\123\x45\x4e\104\x45\122\x5f\x49\104\137\x42\117\104\x59";
    const CHANGE_SENDER_ID_HEAD = "\x43\x48\101\116\107\x45\137\x53\105\x4e\104\x45\122\x5f\x49\104\137\110\x45\101\x44";
    const CHANGE_EMAIL_ID_BODY = "\103\110\x41\x4e\107\x45\x5f\105\115\x41\x49\x4c\137\111\104\137\102\117\x44\x59";
    const CHANGE_EMAIL_ID_HEAD = "\103\x48\101\116\x47\x45\137\x45\x4d\x41\111\x4c\137\x49\x44\137\110\x45\x41\x44";
    const INFO_HEADER = "\x49\x4e\x46\117\x5f\x48\105\x41\x44\x45\x52";
    const META_KEY_HEADER = "\115\105\x54\x41\137\113\105\x59\x5f\x48\x45\101\x44\105\x52";
    const META_KEY_BODY = "\x4d\x45\124\x41\x5f\113\x45\x59\137\x42\x4f\x44\x59";
    const ENABLE_BOTH_BODY = "\x45\116\x41\x42\114\105\137\x42\x4f\x54\x48\x5f\102\x4f\x44\x59";
    const COUNTRY_CODE_HEAD = "\x43\x4f\x55\116\x54\x52\131\x5f\x43\117\x44\x45\x5f\110\105\x41\104";
    const COUNTRY_CODE_BODY = "\x43\117\x55\116\x54\x52\131\x5f\x43\117\104\x45\x5f\102\117\104\131";
    const WC_GUEST_CHECKOUT_HEAD = "\x57\x43\x5f\x47\x55\x45\123\124\x5f\x43\110\x45\x43\x4b\x4f\125\x54\x5f\x48\x45\101\x44";
    const WC_GUEST_CHECKOUT_BODY = "\127\103\137\x47\x55\x45\x53\124\137\x43\110\105\x43\113\117\125\124\137\102\x4f\x44\x59";
    const SUPPORT_FORM_VALUES = "\123\x55\x50\x50\117\122\124\137\x46\117\122\x4d\137\126\x41\x4c\x55\x45\123";
    const SUPPORT_FORM_SENT = "\123\125\x50\x50\x4f\x52\124\x5f\106\117\122\x4d\x5f\x53\x45\116\x54";
    const SUPPORT_FORM_ERROR = "\123\125\x50\x50\x4f\122\124\x5f\x46\117\x52\115\137\x45\122\x52\117\x52";
    const FEEDBACK_SENT = "\x46\x45\x45\104\x42\101\x43\x4b\137\123\105\x4e\x54";
    const FEEDBACK_ERROR = "\x46\105\x45\104\102\x41\103\x4b\137\105\x52\x52\117\x52";
    const SETTINGS_SAVED = "\x53\105\124\124\111\116\107\x53\x5f\x53\101\x56\105\104";
    const REG_ERROR = "\x52\x45\x47\x5f\x45\122\x52\x4f\x52";
    const MSG_TEMPLATE_SAVED = "\x4d\123\107\137\124\105\x4d\120\x4c\x41\124\x45\137\x53\101\x56\105\x44";
    const SMS_TEMPLATE_SAVED = "\x53\x4d\x53\x5f\124\105\115\120\114\x41\x54\105\x5f\x53\x41\x56\x45\104";
    const SMS_TEMPLATE_ERROR = "\123\x4d\x53\137\x54\x45\115\x50\114\101\x54\x45\x5f\105\122\122\117\x52";
    const EMAIL_TEMPLATE_SAVED = "\105\x4d\x41\111\114\137\124\105\115\x50\114\x41\124\x45\137\x53\x41\126\105\x44";
    const CUSTOM_MSG_SENT = "\x43\x55\123\124\117\115\137\x4d\x53\x47\137\123\105\x4e\x54";
    const CUSTOM_MSG_SENT_FAIL = "\x43\x55\123\x54\117\115\x5f\x4d\x53\x47\137\123\105\x4e\x54\137\106\x41\x49\x4c";
    const EXTRA_SETTINGS_SAVED = "\105\x58\x54\x52\101\x5f\x53\x45\124\124\111\116\107\123\137\123\101\126\105\x44";
    const NINJA_FORM_FIELD_ERROR = "\x4e\111\116\112\x41\137\x46\117\122\115\137\x46\x49\105\x4c\x44\137\x45\122\122\117\122";
    const NINJA_CHOOSE = "\x4e\111\116\112\101\137\x43\110\117\x4f\x53\x45";
    const EMAIL_MISMATCH = "\x45\115\101\111\114\137\x4d\111\x53\115\x41\x54\x43\110";
    const PHONE_MISMATCH = "\x50\110\x4f\x4e\x45\x5f\115\111\123\115\101\124\103\x48";
    const ENTER_PHONE = "\105\x4e\124\105\122\x5f\120\110\x4f\x4e\105";
    const ENTER_EMAIL = "\x45\x4e\124\105\x52\x5f\x45\115\101\111\x4c";
    const CF7_PROVIDE_EMAIL_KEY = "\x43\x46\x37\x5f\x50\x52\x4f\126\111\104\x45\137\x45\x4d\x41\x49\x4c\137\x4b\105\131";
    const CF7_CHOOSE = "\103\x46\x37\x5f\103\x48\117\x4f\x53\x45";
    const BP_PROVIDE_FIELD_KEY = "\102\120\x5f\120\122\117\126\111\104\105\137\106\x49\x45\114\104\x5f\x4b\105\x59";
    const BP_CHOOSE = "\x42\120\137\103\110\x4f\117\x53\105";
    const UM_CHOOSE = "\125\x4d\137\x43\x48\x4f\117\123\105";
    const UM_PROFILE_CHOOSE = "\125\x4d\137\x50\x52\117\x46\111\x4c\105\137\103\x48\117\x4f\123\105";
    const EVENT_CHOOSE = "\105\126\105\x4e\x54\x5f\103\x48\x4f\x4f\123\x45";
    const UULTRA_PROVIDE_FIELD = "\125\125\114\124\x52\x41\137\x50\x52\117\126\111\x44\x45\137\106\x49\x45\114\104";
    const UULTRA_CHOOSE = "\x55\x55\114\124\122\101\x5f\x43\110\117\117\123\x45";
    const CRF_PROVIDE_PHONE_KEY = "\x43\x52\106\x5f\120\122\x4f\x56\111\x44\105\x5f\x50\110\117\x4e\105\137\x4b\105\x59";
    const CRF_PROVIDE_EMAIL_KEY = "\103\122\x46\x5f\120\x52\117\126\111\104\105\137\105\x4d\101\111\114\137\x4b\105\x59";
    const CRF_CHOOSE = "\x43\122\106\137\x43\110\x4f\x4f\x53\x45";
    const SMPLR_PROVIDE_FIELD = "\123\115\x50\114\122\x5f\120\x52\x4f\126\111\x44\105\137\x46\x49\x45\114\104";
    const SIMPLR_CHOOSE = "\123\x49\115\x50\x4c\122\x5f\103\x48\x4f\x4f\123\x45";
    const UPME_PROVIDE_PHONE_KEY = "\x55\120\x4d\105\x5f\x50\122\117\x56\x49\x44\x45\x5f\x50\110\x4f\116\x45\137\113\105\x59";
    const UPME_CHOOSE = "\x55\120\115\105\137\103\x48\117\117\x53\105";
    const PB_PROVIDE_PHONE_KEY = "\x50\x42\137\120\122\x4f\126\x49\104\x45\x5f\x50\x48\x4f\x4e\x45\x5f\113\x45\x59";
    const PB_CHOOSE = "\x50\x42\x5f\103\x48\x4f\117\123\105";
    const PIE_PROVIDE_PHONE_KEY = "\120\111\105\x5f\x50\x52\x4f\126\x49\104\x45\x5f\120\110\x4f\x4e\105\137\x4b\x45\131";
    const PIE_CHOOSE = "\120\x49\x45\x5f\x43\110\117\117\x53\x45";
    const ENTER_PHONE_CODE = "\x45\x4e\124\105\x52\x5f\x50\110\x4f\x4e\x45\137\103\x4f\x44\x45";
    const ENTER_EMAIL_CODE = "\x45\x4e\124\x45\122\137\x45\115\x41\111\114\137\103\x4f\104\x45";
    const ENTER_VERIFY_CODE = "\x45\x4e\x54\105\122\137\x56\x45\122\111\x46\131\x5f\x43\117\x44\105";
    const PHONE_VALIDATION_MSG = "\120\110\117\x4e\x45\x5f\126\101\x4c\x49\x44\101\124\x49\117\116\x5f\115\123\107";
    const WC_CHOOSE_METHOD = "\x57\103\137\103\x48\117\x4f\x53\x45\137\115\105\x54\x48\x4f\x44";
    const WC_CHECKOUT_CHOOSE = "\x57\103\x5f\103\110\105\x43\113\x4f\x55\124\x5f\103\x48\x4f\x4f\123\105";
    const TMLM_CHOOSE = "\124\115\x4c\x4d\137\x43\x48\x4f\117\x53\x45";
    const ENTER_PHONE_DEFAULT = "\105\116\x54\105\x52\x5f\x50\x48\x4f\x4e\x45\x5f\x44\105\106\x41\x55\x4c\x54";
    const WP_CHOOSE_METHOD = "\x57\120\x5f\103\x48\x4f\x4f\x53\x45\137\x4d\x45\x54\x48\x4f\104";
    const AUTO_ACTIVATE_HEAD = "\x41\x55\124\x4f\x5f\101\x43\x54\x49\126\x41\124\x45\x5f\110\105\101\104";
    const AUTO_ACTIVATE_BODY = "\101\125\x54\117\x5f\101\x43\124\111\x56\x41\x54\x45\x5f\102\117\104\x59";
    const USERPRO_CHOOSE = "\125\123\105\122\120\122\x4f\x5f\103\110\x4f\x4f\123\105";
    const USERPRO_VERIFY = "\125\123\x45\x52\x50\122\x4f\137\x56\105\x52\111\106\x59";
    const PASS_LENGTH = "\x50\101\x53\123\x5f\114\105\x4e\x47\124\x48";
    const PASS_MISMATCH = "\x50\x41\123\123\x5f\115\x49\x53\115\101\124\x43\x48";
    const OTP_SENT = "\117\x54\x50\x5f\123\x45\x4e\x54";
    const ERR_OTP = "\105\122\x52\137\117\x54\x50";
    const REG_SUCCESS = "\122\x45\x47\137\123\x55\x43\103\x45\x53\x53";
    const ACCOUNT_EXISTS = "\101\x43\103\117\125\x4e\124\x5f\x45\x58\x49\x53\124\x53";
    const REG_COMPLETE = "\122\x45\107\x5f\103\x4f\115\x50\114\x45\x54\x45";
    const INVALID_OTP = "\111\x4e\x56\x41\x4c\111\x44\x5f\x4f\124\120";
    const RESET_PASS = "\122\105\x53\x45\124\137\x50\x41\x53\123";
    const REQUIRED_FIELDS = "\122\105\x51\x55\x49\x52\105\104\x5f\106\x49\105\114\x44\x53";
    const REQUIRED_OTP = "\122\x45\121\x55\x49\122\x45\104\137\x4f\124\120";
    const INVALID_SMS_OTP = "\111\116\126\101\114\111\104\x5f\123\115\123\x5f\117\124\120";
    const NEED_UPGRADE_MSG = "\116\105\105\x44\137\125\120\107\122\101\104\105\137\x4d\123\107";
    const VERIFIED_LK = "\x56\x45\x52\111\106\x49\x45\104\137\114\113";
    const LK_IN_USE = "\x4c\x4b\x5f\111\x4e\x5f\x55\123\x45";
    const INVALID_LK = "\x49\x4e\x56\101\114\111\x44\137\114\x4b";
    const REG_REQUIRED = "\122\x45\107\137\x52\105\x51\x55\x49\x52\x45\104";
    const UNKNOWN_ERROR = "\x55\116\x4b\116\x4f\x57\116\x5f\x45\122\x52\x4f\122";
    const MO_REG_ENTER_PHONE = "\x4d\117\137\122\x45\107\137\x45\116\x54\105\x52\x5f\120\110\117\x4e\105";
    const INVALID_OP = "\x49\x4e\126\101\114\111\x44\137\x4f\x50";
    const UPGRADE_MSG = "\125\120\x47\122\101\x44\x45\137\x4d\x53\x47";
    const FREE_PLAN_MSG = "\106\x52\x45\105\x5f\120\x4c\101\116\137\x4d\x53\x47";
    const TRANS_LEFT_MSG = "\x54\x52\101\116\123\137\x4c\105\106\x54\137\115\123\x47";
    const YOUR_GATEWAY_HEADER = "\x59\117\x55\122\x5f\x47\x41\x54\x45\x57\x41\x59\137\x48\x45\x41\x44\105\122";
    const YOUR_GATEWAY_BODY = "\131\x4f\125\x52\137\107\101\124\105\127\101\131\137\x42\x4f\x44\x59";
    const MO_GATEWAY_HEADER = "\x4d\x4f\x5f\x47\x41\124\105\x57\101\x59\137\x48\x45\x41\x44\x45\x52";
    const MO_GATEWAY_BODY = "\x4d\x4f\x5f\107\101\124\x45\x57\x41\131\137\102\x4f\x44\131";
    const MO_PAYMENT = "\115\117\x5f\x50\x41\131\115\x45\x4e\x54";
    const GRAVITY_CHOOSE = "\107\x52\101\126\111\x54\131\x5f\103\110\117\x4f\x53\105";
    const PHONE_NOT_FOUND = "\x50\110\117\x4e\105\137\116\x4f\124\x5f\106\x4f\x55\116\x44";
    const REGISTER_PHONE_LOGIN = "\x52\x45\x47\111\123\124\105\122\137\120\x48\x4f\x4e\x45\x5f\x4c\x4f\107\x49\x4e";
    const WP_MEMBER_CHOOSE = "\x57\120\137\115\x45\115\x42\105\x52\137\x43\x48\x4f\x4f\x53\x45";
    const UMPRO_VERIFY = "\x55\x4d\120\x52\x4f\137\x56\x45\x52\x49\106\131";
    const UMPRO_CHOOSE = "\125\x4d\120\122\117\x5f\103\110\x4f\117\123\105";
    const CLASSIFY_THEME = "\103\114\101\x53\123\111\x46\131\137\x54\x48\x45\115\x45";
    const REALES_THEME = "\x52\x45\x41\x4c\105\123\x5f\x54\110\105\115\105";
    const LOGIN_MISSING_KEY = "\x4c\117\107\111\x4e\x5f\x4d\111\123\123\111\x4e\107\x5f\x4b\105\x59";
    const PHONE_EXISTS = "\x50\110\x4f\x4e\105\137\x45\130\x49\x53\124\123";
    const WP_LOGIN_CHOOSE = "\127\x50\137\114\x4f\107\111\x4e\137\103\110\x4f\117\123\x45";
    const WPCOMMNENT_CHOOSE = "\x57\x50\x43\x4f\x4d\115\x4e\x45\116\124\x5f\103\110\x4f\117\x53\x45";
    const WPCOMMNENT_PHONE_ENTER = "\127\120\x43\117\115\115\116\x45\x4e\x54\137\120\110\x4f\116\x45\137\105\116\x54\105\122";
    const WPCOMMNENT_VERIFY_ENTER = "\x57\120\103\x4f\115\115\116\105\x4e\124\137\x56\105\122\111\106\x59\x5f\x45\116\124\x45\122";
    const FORMCRAFT_CHOOSE = "\106\117\122\115\x43\x52\101\106\x54\x5f\x43\x48\117\117\123\x45";
    const FORMCRAFT_FIELD_ERROR = "\106\x4f\x52\115\103\122\101\x46\x54\137\x46\111\x45\x4c\104\x5f\105\122\122\117\x52";
    const WPEMEMBER_CHOOSE = "\127\120\x45\115\x45\115\102\x45\x52\137\103\110\x4f\x4f\123\105";
    const DOC_DIRECT_VERIFY = "\104\117\103\x5f\104\x49\x52\x45\103\124\137\126\x45\122\x49\106\x59";
    const DCD_ENTER_VERIFY_CODE = "\x44\103\104\137\x45\x4e\124\x45\x52\x5f\x56\105\x52\x49\x46\131\x5f\103\117\104\105";
    const DOC_DIRECT_CHOOSE = "\x44\x4f\x43\137\104\111\x52\x45\103\x54\137\x43\110\x4f\117\123\105";
    const WPFORM_FIELD_ERROR = "\x57\120\x46\117\x52\x4d\x5f\x46\x49\105\114\104\x5f\x45\122\x52\x4f\x52";
    const CALDERA_FIELD_ERROR = "\x43\x41\x4c\x44\x45\x52\x41\x5f\106\111\105\x4c\104\137\x45\122\122\x4f\x52";
    const INVALID_USERNAME = "\x49\116\x56\x41\114\111\x44\x5f\125\123\105\122\x4e\101\x4d\105";
    const UM_LOGIN_CHOOSE = "\125\115\137\x4c\117\107\x49\x4e\137\x43\110\x4f\x4f\x53\105";
    const MEMBERPRESS_CHOOSE = "\x4d\x45\x4d\x42\105\x52\120\x52\105\x53\123\137\103\x48\117\117\x53\105";
    const REQUIRED_TAGS = "\x52\105\x51\x55\x49\122\105\x44\137\124\x41\107\123";
    const TEMPLATE_SAVED = "\124\105\x4d\x50\x4c\101\x54\105\137\x53\101\x56\105\x44";
    const DEFAULT_SMS_TEMPLATE = "\104\x45\106\101\x55\x4c\x54\137\123\115\x53\x5f\124\105\x4d\x50\114\x41\x54\105";
    const EMAIL_SUBJECT = "\105\115\101\111\x4c\137\123\125\x42\112\x45\x43\x54";
    const DEFAULT_EMAIL_TEMPLATE = "\x44\105\x46\x41\x55\114\124\137\x45\115\101\111\x4c\x5f\x54\105\115\120\x4c\101\124\105";
    const ADD_ON_VERIFIED = "\x41\104\x44\x5f\117\x4e\137\126\x45\122\x49\x46\x49\x45\104";
    const INVALID_PHONE = "\111\116\126\x41\114\111\x44\x5f\x50\110\x4f\116\x45";
    const ERROR_SENDING_SMS = "\x45\x52\122\117\x52\137\x53\x45\116\x44\x49\116\x47\137\x53\115\123";
    const SMS_SENT_SUCCESS = "\123\115\x53\137\x53\105\x4e\x54\137\x53\x55\103\103\x45\x53\x53";
    const OTP_LENGTH_HEADER = "\117\124\120\x5f\114\x45\116\107\124\x48\x5f\110\x45\101\104\105\122";
    const OTP_LENGTH_BODY = "\117\124\x50\x5f\x4c\105\116\x47\x54\110\137\x42\117\x44\131";
    const OTP_VALIDITY_HEADER = "\117\124\x50\137\126\x41\114\x49\x44\x49\x54\x59\x5f\x48\x45\x41\x44\x45\122";
    const OTP_VALIDITY_BODY = "\x4f\124\x50\x5f\126\101\x4c\111\x44\x49\x54\x59\x5f\x42\117\x44\131";
    const DEFAULT_BOX_HEADER = "\x44\x45\x46\x41\x55\x4c\x54\x5f\102\117\x58\137\x48\105\x41\104\105\x52";
    const GO_BACK = "\x47\x4f\137\x42\x41\103\x4b";
    const RESEND_OTP = "\x52\105\123\105\116\104\137\x4f\124\120";
    const VALIDATE_OTP = "\126\101\114\x49\104\x41\x54\x45\x5f\117\x54\120";
    const VERIFY_CODE = "\x56\x45\x52\x49\x46\131\x5f\x43\117\x44\x45";
    const SEND_OTP = "\123\x45\x4e\x44\x5f\117\124\x50";
    const VALIDATE_PHONE_NUMBER = "\x56\101\x4c\111\104\x41\124\x45\137\120\110\117\116\x45\x5f\x4e\x55\x4d\x42\105\x52";
    const VERIFY_CODE_DESC = "\x56\x45\x52\x49\x46\x59\x5f\x43\x4f\x44\x45\137\x44\x45\123\x43";
    const WC_BUTTON_TEXT = "\127\x43\137\x42\125\124\124\x4f\116\x5f\x54\x45\x58\124";
    const WC_POPUP_BUTTON_TEXT = "\127\103\x5f\120\117\120\125\120\137\x42\x55\124\x54\117\116\137\x54\105\130\124";
    const WC_LINK_TEXT = "\127\x43\137\114\x49\x4e\x4b\137\x54\x45\130\x54";
    const WC_EMAIL_TTLE = "\x57\103\x5f\105\115\x41\111\x4c\x5f\x54\x54\114\105";
    const WC_PHONE_TTLE = "\x57\x43\x5f\x50\x48\x4f\x4e\105\137\124\x54\x4c\x45";
    const VISUAL_FORM_CHOOSE = "\x56\111\x53\125\x41\114\137\x46\117\122\x4d\137\103\110\117\x4f\x53\x45";
    const FORMIDABLE_CHOOSE = "\106\117\x52\x4d\x49\x44\x41\x42\114\x45\x5f\x43\110\117\x4f\x53\105";
    const FORMMAKER_CHOOSE = "\106\x4f\x52\115\x4d\x41\113\x45\122\137\x43\x48\117\117\123\105";
    const WC_BILLING_CHOOSE = "\x57\x43\137\x42\x49\114\x4c\x49\116\107\x5f\x43\x48\x4f\117\x53\x45";
    const EMAIL_EXISTS = "\105\x4d\x41\x49\x4c\x5f\x45\x58\111\123\124\x53";
    const INSTALL_PREMIUM_PLUGIN = "\x49\x4e\123\x54\x41\x4c\x4c\137\120\x52\x45\x4d\111\x55\x4d\137\x50\114\x55\x47\111\116";
    const USERNAME_MISMATCH = "\125\x53\x45\x52\116\101\x4d\x45\x5f\115\x49\x53\x4d\101\124\x43\x48";
    const USERNAME_NOT_EXIST = "\125\123\105\x52\116\x41\115\105\x5f\x4e\x4f\124\137\105\130\111\123\x54";
    const RESET_LABEL = "\122\105\123\105\x54\137\114\101\x42\x45\x4c";
    const RESET_LABEL_OP = "\x52\x45\x53\105\x54\x5f\x4c\x41\102\105\114\x5f\x4f\x50";
    const WCUSERNAME_MISMATCH = "\127\103\x55\x53\105\122\116\x41\x4d\x45\137\x4d\111\123\x4d\101\x54\103\110";
    const WCUSERNAME_NOT_EXIST = "\127\x43\125\123\105\122\x4e\101\x4d\x45\137\116\x4f\x54\137\105\130\x49\x53\124";
    const WCRESET_LABEL = "\127\x43\122\x45\x53\x45\124\137\114\x41\102\105\x4c";
    const WCRESET_LABEL_OP = "\127\x43\x52\105\123\105\x54\137\x4c\x41\x42\105\114\137\117\120";
    const WOO_RESET_ERROR_OTP = "\x57\117\x4f\137\x52\105\123\x45\124\137\105\122\x52\117\x52\137\x4f\x54\x50";
    const WCRESET_LABEL_EMAIL_ONLY = "\127\x43\122\x45\123\x45\x54\x5f\x4c\x41\102\105\114\x5f\105\115\101\111\114\x5f\117\116\114\131";
    const NEW_UM_CUSTOMER_NOTIF_HEADER = "\116\x45\x57\x5f\x55\x4d\137\103\x55\x53\124\x4f\115\x45\x52\137\116\117\x54\111\x46\x5f\110\105\101\104\x45\x52";
    const NEW_UM_CUSTOMER_NOTIF_BODY = "\116\105\x57\137\125\115\137\x43\125\123\x54\x4f\115\x45\x52\137\x4e\117\124\111\x46\137\102\117\104\131";
    const NEW_UM_CUSTOMER_SMS = "\116\105\x57\137\125\115\137\103\x55\123\x54\117\115\105\122\137\x53\x4d\x53";
    const NEW_UM_CUSTOMER_ADMIN_NOTIF_BODY = "\x4e\105\x57\x5f\x55\115\x5f\103\x55\123\124\117\x4d\x45\122\137\101\104\115\111\x4e\137\116\x4f\x54\x49\x46\x5f\102\117\x44\131";
    const NEW_UM_CUSTOMER_ADMIN_SMS = "\116\x45\127\137\125\115\137\x43\x55\x53\124\x4f\x4d\105\122\137\x41\104\115\111\x4e\x5f\x53\115\x53";
    const NEW_WP_CUSTOMER_NOTIF_HEADER = "\116\x45\127\x5f\x57\120\x5f\103\125\x53\x54\117\x4d\x45\x52\137\x4e\117\124\111\106\137\110\x45\101\x44\105\x52";
    const NEW_WP_CUSTOMER_NOTIF_BODY = "\116\105\127\x5f\127\120\137\103\125\x53\124\x4f\115\105\x52\x5f\116\117\x54\x49\x46\137\x42\117\104\131";
    const NEW_WP_CUSTOMER_SMS = "\116\x45\127\137\127\120\137\103\x55\123\124\x4f\115\105\x52\137\123\x4d\x53";
    const NEW_WP_CUSTOMER_ADMIN_NOTIF_BODY = "\116\105\x57\x5f\x57\x50\x5f\103\125\x53\124\x4f\115\105\x52\137\x41\104\x4d\x49\x4e\x5f\x4e\x4f\124\111\106\x5f\x42\117\x44\x59";
    const NEW_WP_CUSTOMER_ADMIN_SMS = "\x4e\105\127\x5f\x57\120\137\103\x55\x53\x54\117\x4d\x45\x52\137\101\x44\x4d\x49\116\137\x53\x4d\x53";
    const PHONE_ID_HEADER = "\120\110\x4f\116\105\x5f\x48\x45\x41\104\105\x52";
    const PHONE_ID_BODY = "\120\x48\117\116\x45\x5f\111\x44\137\102\117\x44\131";
    const NEW_WC_CUSTOMER_ADMIN_SMS = "\x4e\105\x57\137\127\x43\x5f\103\125\123\124\117\x4d\105\122\137\x41\104\x4d\111\116\x5f\x53\x4d\123";
    const NEW_CUSTOMER_ADMIN_NOTIF_BODY = "\116\x45\127\x5f\103\125\123\124\x4f\115\x45\x52\137\101\x44\x4d\x49\x4e\137\116\x4f\x54\x49\x46\137\102\117\x44\131";
    const NEW_CUSTOMER_NOTIF_HEADER = "\116\105\x57\x5f\103\x55\123\x54\117\x4d\x45\122\x5f\116\x4f\x54\x49\x46\137\x48\105\x41\104\x45\x52";
    const NEW_CUSTOMER_NOTIF_BODY = "\116\x45\127\137\x43\125\x53\124\x4f\115\105\122\137\x4e\117\124\x49\x46\x5f\102\x4f\x44\x59";
    const NEW_CUSTOMER_SMS_WITH_PASS = "\x4e\x45\127\137\103\125\x53\x54\x4f\x4d\105\122\137\x53\x4d\x53\x5f\127\111\124\x48\137\120\101\x53\x53";
    const NEW_CUSTOMER_SMS = "\x4e\x45\x57\137\x43\x55\x53\x54\x4f\x4d\x45\122\137\x53\115\x53";
    const CUSTOMER_NOTE_NOTIF_HEADER = "\x43\x55\123\x54\x4f\115\x45\122\137\116\x4f\124\105\x5f\x4e\117\x54\x49\x46\x5f\x48\105\x41\x44\105\x52";
    const CUSTOMER_NOTE_NOTIF_BODY = "\103\x55\123\x54\117\115\x45\122\137\116\x4f\x54\x45\137\x4e\x4f\x54\x49\106\x5f\x42\x4f\x44\131";
    const CUSTOMER_NOTE_SMS = "\x43\125\123\124\x4f\x4d\105\x52\137\116\117\x54\x45\137\123\115\x53";
    const NEW_ORDER_NOTIF_HEADER = "\116\x45\x57\x5f\117\122\104\105\x52\137\x4e\117\x54\111\106\x5f\x48\x45\101\x44\105\x52";
    const NEW_ORDER_NOTIF_BODY = "\x4e\x45\x57\137\x4f\122\x44\x45\x52\137\x4e\117\x54\111\x46\137\x42\x4f\x44\x59";
    const ADMIN_STATUS_SMS = "\x41\104\115\x49\x4e\137\123\124\x41\x54\125\x53\x5f\x53\115\x53";
    const ORDER_ON_HOLD_NOTIF_HEADER = "\x4f\122\x44\x45\122\137\x4f\x4e\137\110\117\114\104\x5f\x4e\117\124\111\x46\x5f\110\105\x41\104\105\x52";
    const ORDER_ON_HOLD_NOTIF_BODY = "\117\x52\104\105\x52\x5f\x4f\x4e\137\110\117\114\104\137\x4e\x4f\x54\111\106\137\x42\x4f\x44\x59";
    const ORDER_ON_HOLD_SMS = "\x4f\x52\x44\x45\122\x5f\117\x4e\137\110\x4f\114\x44\x5f\x53\115\123";
    const ORDER_PROCESSING_NOTIF_HEADER = "\117\x52\104\x45\x52\x5f\x50\122\117\x43\105\x53\123\111\x4e\107\137\x4e\x4f\x54\111\106\x5f\110\105\x41\104\105\122";
    const ORDER_PROCESSING_NOTIF_BODY = "\117\122\x44\105\x52\x5f\120\x52\x4f\103\105\x53\x53\x49\116\107\x5f\116\x4f\124\111\x46\x5f\x42\117\104\131";
    const PROCESSING_ORDER_SMS = "\120\x52\x4f\x43\x45\123\123\x49\116\107\137\x4f\x52\104\x45\122\137\x53\115\x53";
    const ORDER_COMPLETED_NOTIF_HEADER = "\x4f\x52\104\105\x52\x5f\x43\x4f\x4d\120\x4c\x45\124\x45\x44\x5f\x4e\x4f\124\111\x46\x5f\x48\x45\x41\x44\x45\122";
    const ORDER_COMPLETED_NOTIF_BODY = "\117\x52\104\x45\x52\x5f\103\117\x4d\120\x4c\105\x54\105\x44\x5f\116\117\x54\111\106\137\102\x4f\x44\131";
    const ORDER_COMPLETED_SMS = "\x4f\122\x44\105\122\137\x43\x4f\115\x50\x4c\105\x54\x45\104\137\123\x4d\123";
    const ORDER_REFUNDED_NOTIF_HEADER = "\x4f\122\x44\105\x52\x5f\x52\105\x46\x55\116\x44\105\104\x5f\116\117\124\x49\x46\137\x48\105\101\104\105\x52";
    const ORDER_REUNDED_NOTIF_BODY = "\x4f\x52\x44\x45\122\x5f\x52\105\x55\116\x44\x45\x44\x5f\x4e\117\x54\x49\106\137\102\x4f\104\131";
    const ORDER_REFUNDED_SMS = "\x4f\122\x44\105\122\x5f\x52\105\106\125\116\x44\105\104\137\123\115\123";
    const ORDER_CANCELLED_NOTIF_HEADER = "\117\122\104\105\x52\137\x43\101\x4e\103\x45\114\114\x45\x44\x5f\x4e\x4f\x54\x49\106\x5f\110\105\101\x44\x45\x52";
    const ORDER_CANCELLED_NOTIF_BODY = "\x4f\x52\x44\105\x52\137\103\101\x4e\x43\x45\114\x4c\105\104\x5f\116\117\x54\x49\106\137\102\117\104\x59";
    const ORDER_CANCELLED_SMS = "\117\x52\x44\105\122\x5f\x43\x41\x4e\103\x45\x4c\x4c\105\x44\137\123\x4d\x53";
    const ORDER_FAILED_NOTIF_HEADER = "\x4f\122\x44\x45\122\x5f\106\101\x49\114\105\x44\137\116\117\124\x49\x46\137\110\105\x41\x44\105\122";
    const ORDER_FAILED_NOTIF_BODY = "\x4f\122\x44\x45\x52\137\106\101\x49\x4c\x45\104\x5f\116\117\124\111\106\137\x42\x4f\x44\131";
    const ORDER_FAILED_SMS = "\117\122\x44\105\x52\137\x46\x41\x49\x4c\x45\104\137\123\115\x53";
    const ORDER_PENDING_NOTIF_HEADER = "\117\x52\x44\105\x52\x5f\x50\x45\x4e\104\111\116\x47\137\116\x4f\x54\x49\106\x5f\x48\x45\x41\104\105\x52";
    const ORDER_PENDING_NOTIF_BODY = "\x4f\x52\x44\x45\x52\x5f\120\x45\x4e\104\x49\x4e\x47\137\116\117\x54\111\x46\x5f\x42\117\104\x59";
    const ORDER_PENDING_SMS = "\117\122\x44\x45\x52\x5f\x50\105\x4e\x44\x49\x4e\x47\x5f\x53\x4d\x53";
    const FORGOT_PASSWORD_MESSAGE = "\106\117\x52\x47\x4f\124\x5f\120\101\123\x53\x57\117\x52\104\x5f\115\x45\123\x53\x41\x47\x45";
    const ENTERPRIZE_EMAIL = "\105\116\124\x45\x52\120\122\111\x5a\x45\x5f\105\x4d\x41\111\x4c";
    const REGISTRATION_ERROR = "\122\x45\107\x49\123\124\x52\101\124\x49\117\x4e\x5f\x45\x52\x52\117\122";
    const CUSTOM_CHOOSE = "\103\x55\123\124\117\x4d\x5f\103\x48\x4f\117\x53\105";
    const GATEWAY_PARAM_NOTE = "\107\101\x54\105\127\101\131\137\120\101\122\101\x4d\137\x4e\117\x54\105";
    const CUSTOM_PACKS = "\x43\x55\x53\124\x4f\115\137\120\x41\x43\113\123";
    const REMAINING_TRANSACTION_MSG = "\122\105\x4d\101\x49\116\111\116\x47\137\124\122\101\116\x53\101\x43\124\x49\117\x4e\137\x4d\123\x47";
    const CUSTOM_FORM_MESSAGE = "\x43\x55\123\124\117\115\x5f\x46\117\122\x4d\137\115\x45\x53\123\x41\x47\105";
    const WPUSERNAME_MISMATCH = "WPUSERNAME_MISMATCH";
    const WPUSERNAME_NOT_EXIST = "WPUSERNAME_NOT_EXIST";
    const WPRESET_LABEL = "WPRESET_LABEL";
    const WPRESET_LABEL_OP = "WPRESET_LABEL_OP";
    const WP_RESET_ERROR_OTP= 'WP_RESET_ERROR_OTP';
    const WPRESET_LABEL_EMAIL_ONLY='WPRESET_LABEL_EMAIL_ONLY';
}