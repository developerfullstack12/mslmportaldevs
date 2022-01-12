/**
 * Created by michaeldajewski on 12/13/20.
 */

// Fix for LD ver.: 3.2.3.6
// LD keypress event listener if the number field min is other than 0 or 1 will not let user to enter e.g. 10.
// Disable LD on keypress event listener for some the number fields.
//
jQuery(window).on("load", function() {
    jQuery('.sfwd_options input[id="elc_qrcode_options_size"][type="number"]').off('keypress');
});
