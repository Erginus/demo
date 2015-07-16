$(function(){
    $('input[type=text],input[type=password],textarea').placeholder();
    $('input[type=radio],input[type=checkbox]').uniform();
    if($(".alert-danger").is(':visible')){
        setTimeout(function(){
            $('.alert-danger').fadeOut();
        },2000);
    }
    $("#login_form").validate({
        errorElement: 'span',
        errorClass: 'help-block',
        rules: {
            user_login: {
                required: true,
                minlength:5
            },
            user_login_password: {
                required: true,
                minlength:5
            },
            captcha_image: {
                required: true
            }
        },
        messages: {
            user_login: {
                required: "The Username field is required.",
                minlength: "The Username field must be at least {0} characters in length."
            },
            user_login_password: {
                required: "The Password field is required.",
                minlength: "The Password field must be at least {0} characters in length."
            },
            captcha_image: {
                required: "The Image Text field is required."
            }
        },
        invalidHandler: function (event, validator) {
            $("hr.colorgraph:first").after('<div class="alert alert-danger alert-dismissable"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>Error Processing Login !!!</div>');
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