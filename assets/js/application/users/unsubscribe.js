$(function(){
    $('input[type=text],input[type=password],textarea').placeholder();
    if($(".alert-danger").is(':visible')){
        setTimeout(function(){
            $('.alert-danger').fadeOut();
        },2000);
    }
    $("#unsubscribe_form").validate({
        errorElement: 'span',
        errorClass: 'help-block',
        rules: {
            user_email: {
                required: true,
                email: true
            },
            captcha_image: {
                required: true
            }
        },
        messages: {
            user_email: {
                required: "The Email field is required.",
                email: "The Email field must contain a valid email address."
            },
            captcha_image: {
                required: "The Image Text field is required."
            }
        },
        invalidHandler: function (event, validator) {
            $("hr.colorgraph:first").after('<div class="alert alert-danger alert-dismissable"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>Unsubscribing Incomplete !!!</div>');
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