$.blockUI.defaults.message = '<img alt="Processing..." src="'+base_url+'assets/images/ajax-loading.gif" />';
$.blockUI.defaults.css.border = 'none';
$.blockUI.defaults.css.backgroundColor = 'none';
$.blockUI.defaults.overlayCSS.opacity = 0.1;
$.blockUI.defaults.fadeOut = 100;
$(function(){
    $('input[type=radio],input[type=checkbox]').uniform();
    var msnry = new Masonry( "#masonry", {
        itemSelector: '.masonry'
    });
    msnry.layout();
    $("input.url_permission").click(function(){
        $("#urls_container").block();
        var urls_id = $(this).attr('id').replace('user_url_permission_','');
        var user_url_permission = '0';
        if($(this).is(":checked")){
            user_url_permission = '1';
        }
        $.post(base_url+'acl/update-user-url-premission',{
            urls_id:urls_id,
            user_url_permission:user_url_permission
        },function(data){
            $("#urls_container").unblock();
            if(data === '1'){
                
            } else {
                
            }
        });
    });
});