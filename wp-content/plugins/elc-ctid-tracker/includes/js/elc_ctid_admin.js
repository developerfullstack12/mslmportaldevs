/**
 * Created by michaeldajewski on 10/27/20.
 */

window.addEventListener("load", function () {

    var elc_ctid_qrcode = document.querySelector('#elc-ctid-qrcode');//document.getElementById('elc-ctid-qrcode');
    var elc_qrcode_options_enable = document.querySelector('#elc_qrcode_options_enable');
    elc_qrcode_options_enable.addEventListener('change', (event) => {
        if (event.target.checked) {
            elc_ctid_qrcode.removeAttribute('style');
        } else {
            elc_ctid_qrcode.style.position = 'absolute';
            elc_ctid_qrcode.style.left = '-100%';
        }
    });

    var svgObject = document.getElementById('svg-object').contentDocument;
    // page width:  279.4mm   792pt
    // page height: 215.9mm   612pt

    // Initial aligment for LTR and Top.
    var px_1 = 108;
    var py_1 = 108;

    var translate_string_1 = '';
    var translate_string_2 = '';
    var translate_string_3 = '';

    var elem_y = svgObject.getElementById('Dim_Y');
    var elem_x = svgObject.getElementById('Dim_X');
    var elem_size = svgObject.getElementById('Size');
    var elem_qrcode = svgObject.getElementById('QRCode');

    function elc_update_svg() {

        var px_tx1 = 108;
        var px_tx2 = 108;
        var px_tx3 = 108;

        switch (h_align) {
            case 'right':
                px_tx1 = 2 * px_1 + 72; //translate_string_1
                px_tx2 = 4 * px_1;      //translate_string_2
                px_tx3 = 2 * px_1 + 72; //translate_string_3
                break;
            case 'left':
            default:
                px_tx1 = 1 * px_1;      //translate_string_1
                px_tx2 = 1 * px_1;      //translate_string_2
                px_tx3 = 1 * px_1;      //translate_string_3
                break;
        }

        var py_tx1 = 108;
        var py_tx2 = 108;
        var py_tx3 = 108;

        switch (v_align) {
            case 'bottom':
                py_tx1 = 2 * px_1 - 18; //translate_string_1
                py_tx2 = 2 * px_1 - 18; //translate_string_2
                py_tx3 = 3 * px_1 + 18; //translate_string_3
                break;
            case 'top':
            default:
                py_tx1 = 1 * px_1;      //translate_string_1
                py_tx2 = 1 * px_1;      //translate_string_2
                py_tx3 = 1 * px_1;      //translate_string_3
                break;
        }

        translate_string_1 = sprintf('translate(%s,%s)', px_tx1, py_tx1);
        translate_string_2 = sprintf('translate(%s,%s)', px_tx2, py_tx2);
        translate_string_3 = sprintf('translate(%s,%s)', px_tx3, py_tx3);

        elem_y.setAttributeNS(null, 'transform', translate_string_3);
        elem_x.setAttributeNS(null, 'transform', translate_string_2);
        elem_size.setAttributeNS(null, 'transform', translate_string_1);
        elem_qrcode.setAttributeNS(null, 'transform', translate_string_1);
    }

    //elc_qrcode_options_align
    const elc_select_align_element = document.querySelector('#elc_qrcode_options_align');

    elc_select_align_element.addEventListener('change', (event) => {
        const result = document.querySelector('.result');
        h_align = event.target.value;
        elc_update_svg();
    });

    // fields
    var h_align = elc_select_align_element.value;

    //elc_qrcode_options_position
    const elc_qrcode_position_element = document.querySelector('#elc_qrcode_options_position');

    var v_align = elc_qrcode_position_element.value;

    elc_qrcode_position_element.addEventListener('change', (event) => {
        const result = document.querySelector('.result');
        v_align = event.target.value;
        elc_update_svg();
    });

    elc_update_svg();

});
