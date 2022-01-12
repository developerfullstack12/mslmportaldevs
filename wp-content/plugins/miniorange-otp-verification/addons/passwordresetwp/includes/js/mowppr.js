jQuery(document).ready( function() {
    $mo = jQuery;
    var html = "<div id='mo_message' hidden style='background-color: #f7f6f7;padding: 1em 2em 1em 3.5em;'>"+
                    "<img src='"+mowpprvar.imgURL+"'>"+
                "</div>";

    var button2=html+
                '<div class="input" id="verify_div" hidden>'+
                    '<div class="input">'+
                        '<input autocomplete="off"  style ="margin:10px 0 10px" class="input" type="text" name="verify_field" '+
                            'id="verify_field" value="" placeholder="Enter Verification code here">'+
                    '</div>'+
                '</div>'+
                '<div class="login js login-action-lostpassword ">'+
                    '<div class="input flex" style="align-items: center; justify-content: center;">'+
                        '<input type="button" style="width: 100%;" value="'+mowpprvar.buttontext+'" '+
                            'class="submit" id="mo_wp_send_otp_pass">'+
                        '<input type="submit" style ="margin-left:10px; width: 100%" value="Verify" class="wp-button wp-alt" id="mo_wp_verify_pass" hidden >'+
                    '</div>'+
                    // '<div class="wordpress-form-row ">'+
                    //     '<input type="submit" value="Verify" class="wp-button wp-alt" id="mo_wp_verify_pass" disabled>'+
                    // '</div>'+
             
                '</div>';

    if($mo("#lostpasswordform").length>0) {
         $mo('label[for=user_login]').remove();
         $mo("#lostpasswordform #wp-submit").hide();
         $mo(".privacy-policy-page-link").hide();
         $mo(".cab").hide();
         $mo(button2).insertAfter('input[name="wp-submit"]');
        setTimeout(function(){  $mo("#user_login").attr("placeholder",mowpprvar.phText); }, 100);
         // $mo("input#user_login").attr('placeholder',mowpprvar.phText);
         // $mo('.input p:first').text(mowpprvar.resetLabelText);
         
         //$mo('#mo_wp_verify_pass').attr('disabled','disabled');
         $mo('#mo_wp_verify_pass').addClass('hide');
    }
    $mo("#mo_wp_send_otp_pass").click(function(e){
        e.preventDefault();
        mo_wp_send_pass();
        });
    // } 
});

function mo_wp_send_pass() {
    var e = $mo('[id^='+mowpprvar.fieldKey+']').val();

    $mo("#mo_message").empty();
    $mo("#mo_message").show();
    $mo.ajax( {
        url: mowpprvar.siteURL,
        type:"POST",
        data:{username:e,security:mowpprvar.nonce,action:mowpprvar.action.send},
        crossDomain:!0,dataType:"json",
        success:function(o){
            $mo("#mo_wp_send_otp_pass").removeClass("hide");
            if(o.result=="success"){
                $mo("#verify_div").show();
                // $mo("#mo_wp_send_otp_pass").show();
                $mo("#mo_wp_verify_pass").removeClass("hide");
                $mo("#mo_wp_send_otp_pass").addClass("hide");
                $mo("#mo_message").empty(),$mo("#mo_message").append(o.message),
                $mo("#mo_message").css("border-top","3px solid green");
            }else{
                $mo("#verify_div").hide();
                $mo("#mo_message").empty(),$mo("#mo_message").append(o.message),
                $mo("#mo_message").css("border-top","3px solid red");
            }
        },
        error:function(o){
            $mo("#mo_wp_send_otp_pass").removeclass("hide");
            $mo("#mo_message").empty(),$mo("#mo_message").append(o.message),
            $mo("#mo_message").css("border-top","3px solid red");
        }
    });
}