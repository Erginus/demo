$(function(){
    $('input[type=text],input[type=password],textarea').placeholder();
    if($(".alert-danger").is(':visible')){
        setTimeout(function(){
            $('.alert-danger').fadeOut();
        },2000);
    }
    $("#create_account_form").validate({
        errorElement: 'span',
        errorClass: 'help-block',
        rules: {
            groups_id: {
                required: true
            },
            user_login: {
                required: true,
                minlength:5
            },
            user_login_password: {
                required: true,
                minlength:5
            },
            user_confirm_password: {
                required: true,
                equalTo:'#user_login_password'
            },
            user_email: {
                required: true,
                email: true
            },
            user_first_name: {
                required: true
            },
            user_last_name: {
                required: true
            },
            captcha_image: {
                required: true
            }
        },
        messages: {
            groups_id: {
                required: "The User Group field is required."
            },
            user_login: {
                required: "The Username field is required.",
                minlength: "The Username field must be at least {0} characters in length."
            },
            user_login_password: {
                required: "The Password field is required.",
                minlength: "The Password field must be at least {0} characters in length."
            },
            user_confirm_password: {
                required: "The Confirm Password field is required.",
                equalTo: "The Confirm Password field does not match the Password field."
            },
            user_email: {
                required: "The Email field is required.",
                email: "The Email field must contain a valid email address."
            },
            user_first_name: {
                required: "The First Name field is required."
            },
            user_last_name: {
                required: "The Last Name field is required."
            },
            captcha_image: {
                required: "The Image Text field is required."
            }
        },
        invalidHandler: function (event, validator) {
            $("hr.colorgraph:first").after('<div class="alert alert-danger alert-dismissable"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>Error Adding User Account !!!</div>');
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