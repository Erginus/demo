$(function(){
    $('input[type=text],input[type=password],textarea').placeholder();
    if($(".alert-danger").is(':visible')){
        setTimeout(function(){
            $('.alert-danger').fadeOut();
        },2000);
    }
    $("#change_password_form").validate({
        errorElement: 'span',
        errorClass: 'help-block',
        rules: {
            user_old_password: {
                required: true,
                minlength: 5
            },
            user_login_password: {
                required: true,
                minlength: 5
            },
            user_confirm_password: {
                required: true,
                equalTo:'#user_login_password'
            }
        },
        messages: {
            user_old_password: {
                required: "The Old Password field is required.",
                minlength: "The Old Password field must be at least {0} characters in length."
            },
            user_login_password: {
                required: "The New Password field is required.",
                minlength: "The New Password field must be at least {0} characters in length."
            },
            user_confirm_password: {
                required: "The Confirm Password field is required.",
                equalTo: "The Confirm Password field does not match the Password field."
            }
        },
        invalidHandler: function (event, validator) {
            $("hr.colorgraph:first").after('<div class="alert alert-danger alert-dismissable"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>Error in Changing Password !!!</div>');
            setTimeout(function(){
                $('.alert-danger').fadeOut();
            },2000);
        },
        highlight: function (element) {
            $(element).closest('.form-group').addClass('has-error');
        },
        success: function (element) {
            $(element).closest('.form-group').removeClass('has-error');
            $(element).closest('.form-group').children('span.help-block').remove();
        },
        errorPlacement: function (error, element) {
            error.appendTo(element.closest('.form-group'));
        },
        submitHandler: function (form) {
            form.submit();
        }
    });
});