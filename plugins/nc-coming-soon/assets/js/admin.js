$(document).ready(function(){

    $(".cj-tabs-menu li a").click(function(){
        var tab = $(this).attr('id');
        $("#selected-tab").val(tab);
        $(".tabs").hide(0);
        $("."+tab).fadeIn(300);
        $(".cj-tabs-menu li a").removeClass('current');
        $(this).addClass('current');
        return false;
    })


    $(".form-field input, .form-field select").focus(function(){
        $('.form-field').removeClass('form-field-focus');
        $(this).parent().addClass('form-field-focus');
    })

    $("#cj-form-ac").submit(function(){
        var username = $("#ac_username").val();
        var password = $("#ac_password").val();
        if(username == '' || password == ''){
            alert("Missing required fields");
            return false;
        }else{
            return true;
        }
    })


    $(".theme-sc").click(function(){
        $('.theme').removeClass('current-theme');
        $(this).parent().parent().addClass('current-theme');
    })


//    $(".updated").animate({
//        "": ""
//    }, {
//        duration: 4000
//    }).slideToggle(100);


})