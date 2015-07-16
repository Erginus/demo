$.blockUI.defaults.message = '<img alt="Processing..." src="'+base_url+'assets/images/ajax-loading.gif" />';
$.blockUI.defaults.css.border = 'none';
$.blockUI.defaults.css.backgroundColor = 'none';
$.blockUI.defaults.overlayCSS.opacity = 0.1;
$.blockUI.defaults.fadeOut = 100;
$(function(){
    $('.sortable-list').sortable({
        connectWith: '.sortable-list',
        containment: '#drag_container',
        placeholder: 'placeholder',
        receive: function(e,ui){
            msnry.layout();
            $("#drag_container").block();
            $.post(base_url+'acl/update-url-set',{
                'url_id':ui.item.attr('id'),
                'url_set_id':ui.item.closest('ul').attr('id')
            },function(data){                    
                if(data === '1'){
                    $("#drag_container").unblock();
                } else {
                    document.location.href='';
                }
            });
        }
    });
    var msnry = new Masonry( "#masonry", {
        itemSelector: '.masonry'
    });
    msnry.layout();
});
$("#add_url_set").click(function(){
    bootbox.dialog({
        message: "<form id='new_url_set_form'><div class='form-group'><input class='form-control input-lg' type='text' id='url_set_name' name='url_set_name' placeholder='New URL Set' value='' /></div></form>",
        title: "Add New URL Set",
        buttons: {
            cancel:{
                label: "Cancel",
                className: "btn-default",
                callback: function(){
                    document.location.href = '';
                }
            },
            main: {
                label: "Add URL Set",
                className: "btn-primary",
                callback: function() {
                    $(".modal-content").block();
                    $.post(base_url+'acl/add-url-set',{
                        url_set_name:$("#url_set_name").val()
                    },function(data){
                        if(data ==='0'){
                            $("#new_url_set_form").before('<div class="alert alert-danger alert-dismissable"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>Error Creating New URL Set !!!</div>');
                        } else if (data ==='1'){
                            $("#new_url_set_form").before('<div class="alert alert-success alert-dismissable"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>New URL Set Created Successfully !!!</div>');
                            setTimeout(function(){
                                bootbox.hideAll();
                                document.location.href = '';
                            },3500);
                        } else {
                            $("#new_url_set_form").before('<div class="alert alert-danger alert-dismissable"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>'+data+'</div>');
                        }
                        $(".modal-content").unblock();
                        if($(".alert-danger").is(':visible')){
                            setTimeout(function(){
                                $('.alert-danger').fadeOut();
                            },2000);
                        }
                    });
                    return false;
                }
            }
        }
    });
});

function delete_url_set(t,id){
    bootbox.dialog({
        message: '<div id="delete_url_set_confirm" class="alert alert-info"><i class="fa fa-info-circle"></i> URL Sets having absolutely NO URLs can only be deleted.</div>Do You want to delete URL Set : '+$(t).parent('h3').text(),
        title: "Delete URL Set Confirmation",
        buttons: {
            cancel:{
                label: "Cancel",
                className: "btn-default",
                callback: function(){
                    document.location.href = '';
                }
            },
            main: {
                label: "Delete URL Set",
                className: "btn-primary",
                callback: function() {
                    $(".modal-content").block();
                    $.post(base_url+'acl/delete-url-set',{
                        url_set_id:id
                    },function(data){
                        if(data ==='0'){
                            $("#delete_url_set_confirm").before('<div class="alert alert-danger alert-dismissable"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>Error Deleting URL Set !!!</div>');
                        } else if (data ==='1'){
                            $("#delete_url_set_confirm").before('<div class="alert alert-success alert-dismissable"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>URL Set Deleted Successfully !!!</div>');
                            setTimeout(function(){
                                bootbox.hideAll();
                                document.location.href = '';
                            },3500);
                        } else {
                            $("#delete_url_set_confirm").before('<div class="alert alert-danger alert-dismissable"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>'+data+'</div>');
                        }
                        $(".modal-content").unblock();
                        if($(".alert-danger").is(':visible')){
                            setTimeout(function(){
                                $('.alert-danger').fadeOut();
                            },2000);
                        }
                    });
                    return false;
                }
            }
        }
    });
}