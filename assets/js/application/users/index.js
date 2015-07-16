$.blockUI.defaults.message = '<img alt="Processing..." src="'+base_url+'assets/images/ajax-loading.gif" />';
$.blockUI.defaults.css.border = 'none';
$.blockUI.defaults.css.backgroundColor = 'none';
$.blockUI.defaults.overlayCSS.opacity = 0.1;
$.blockUI.defaults.fadeOut = 100;
$(function(){
    $('#users_datatable').dataTable({
        "sDom": '<"toolbar col-md-3"><"col-md-3"l><"col-md-3"f><"col-md-3 text-right"T>rtip',
        "bSort": false,
        "aoColumnDefs": [
        {
            "aTargets": [6],
            "bSearchable":false,
            "mRender": function (data, type, full) {
                switch(data){
                    case '-1':
                        return '<span id="user_status_'+full[0]+'" class="label label-danger">Suspended</span>';
                        break;
                    case '0':
                        return '<span id="user_status_'+full[0]+'" class="label label-info">New</span>';
                        break;
                    case '1':
                        return '<span id="user_status_'+full[0]+'" class="label label-success">Active</span>';
                        break;
                    default:
                        return '<span id="user_status_'+full[0]+'" class="label label-info">New</span>';
                        break;
                }
            }
        },
        {
            "aTargets": [7],
            "sType":"date",
            "bSearchable":false,
            "mRender": function (data, type, full) {
                var datex = data.split(" ");
                var datey = datex[0].split("-");
                return datey[2]+'-'+datey[1]+'-'+datey[0];
            }
        },
        {
            "aTargets": [8],
            //            "bSortable":false,
            "bSearchable":false,
            "mData": null,
            "mRender": function (data, type, full) {
                return '<a class="" href="'+base_url+'acl/user/'+full[0]+'"><i class="fa fa-unlock-alt"></i></a>';
            }
        },
        {
            "aTargets": [9],
            //            "bSortable":false,
            "bSearchable":false,
            "mData": null,
            "mRender": function (data, type, full) {
                return '<a class="" href="javascript:;" onclick="change_password(\''+ full[0] +'\',\''+ full[2] +' '+full[3]+'\');"><i class="fa fa-key"></i></a>';
            }
        },
        {
            "aTargets": [10],
            //            "bSortable":false,
            "bSearchable":false,
            "mData": null,
            "mRender": function (data, type, full) {
                return '<a class="" href="'+base_url+'users/edit/'+full[0]+'"><i class="fa fa-pencil"></i></a>';
            }
        },
        {
            "aTargets": [11],
            //            "bSortable":false,
            "bSearchable":false,
            "mData": null,
            "mRender": function (data, type, full) {
                return '<a class="" href="javascript:;" onclick="delete_user(\''+ full[0] +'\',\''+ full[2] +' '+full[3]+'\');"><i class="fa fa-times"></i></a>';
            }
        }
        ],
        "fnRowCallback": function( nRow, aData, iDisplayIndex, iDisplayIndexFull ) {
            $('td:eq(8),td:eq(9),td:eq(10),td:eq(11)', nRow).addClass('text-center');
        },
        "oTableTools": {
            "sSwfPath": base_url+"assets/js/plugins/datatables-1.9.4/tabletools-2.2.0/swf/copy_csv_xls_pdf.swf",
            "aButtons": [
            {
                "sExtends": "xls",
                "sButtonText": "<i class='fa fa-save'></i> EXCEL",
                "mColumns": [0,1,2,3,4,5,6,7,8]
            },
            {
                "sExtends": "pdf",
                "sButtonText": "<i class='fa fa-save'></i> PDF",
                "sPdfOrientation": "landscape",
                "sPdfSize": "tabloid",
                //                            "sPdfMessage": "User Listing [test message]",
                "mColumns": [0,1,2,3,4,5,6,7,8]
            }
            ]
        },
        "oLanguage": {
            "sProcessing": '<img alt="Processing..." src="'+base_url+'assets/images/ajax-loading.gif" />',
            "sInfoFiltered":""
        },
        "bProcessing": true,
        "bServerSide": true,
        "bDeferRender": true,
        "sPaginationType": "bootstrap",
        "sServerMethod": "POST",
        "sAjaxSource": base_url+"users/datatable",
        "iDisplayLength": 10,
        "aLengthMenu": [[20,50,100,200,500,1000,-1],[20,50,100,200,500,1000,"All"]],
        "aaSorting": [[0, 'asc']],
        "fnServerParams": function (aoData) {
            $.each($.ajaxSetup()['data'], function(key, element) {
                aoData.push({
                    name:key,
                    value:element
                });
            });                                
        },
        "fnPreDrawCallback": function(oSettings) {
            $("div.toolbar").html('<a class="btn btn-primary" href="'+base_url+'users/add"><i class="fa fa-plus"></i> Add New User</a>');
            $(".dataTables_filter label input").addClass('form-control input-sm');
            $(".dataTables_length label select").css({
                'width':'100px'
            }).select2();
        }
    }).fnSetFilteringDelay(700);
    $(document).on("show.bs.modal", function (event){
        setTimeout(function(){
            $('input[type=text],input[type=password],textarea').placeholder();
            $('input[type=radio],input[type=checkbox]').uniform();
        },0);
    });
});
function delete_user(user_id,full_name){
    bootbox.confirm('Do you want to delete : '+full_name+' ?', function(result){
        if(result === true){
            $.post(base_url+'users/delete',{
                user_id:user_id
            },function(data){
                if(data === '1'){
                    $("#user_status_"+user_id).removeAttr('class').addClass('label label-danger').html('Suspended');
                } else {
                    bootbox.alert('Error Deleting User : '+full_name+' !!!'); 
                }
            });
        }
    });
}
function change_password(user_id,full_name){
    bootbox.dialog({
        message: "<form id='new_password_form'><input type='hidden' id='user_id' name='user_id' value='"+user_id+"' /><div class='form-group'><input class='form-control input-lg' type='password' id='user_login_password' name='user_login_password' placeholder='New Password' value='' /></div><div class='form-group'><input class='form-control input-lg' type='password' id='user_confirm_password' name='user_confirm_password' placeholder='Confirm Password' value='' /></div><div class='form-group'><label class='checkbox-inline'><input type='checkbox' id='notify_user' value='1' name='notify_user'>Send Email to <b>"+full_name+"</b> about Account Modifications</label></div></form>",
        title: "Change Password : "+ full_name,
        buttons: {
            cancel:{
                label: "Cancel",
                className: "btn-default"
            },
            main: {
                label: "Change Password",
                className: "btn-primary",
                callback: function() {
                    $(".modal-content").block();
                    $.post(base_url+'users/change-password',{
                        user_id:$("#user_id").val(),
                        user_login_password:$("#user_login_password").val(),
                        user_confirm_password:$("#user_confirm_password").val(),
                        notify_user:$("#notify_user:checked").val()
                    },function(data){
                        if(data ==='0'){
                            $("#new_password_form").before('<div class="alert alert-danger alert-dismissable"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>Error Changing Password !!!</div>');
                        } else if (data ==='1'){
                            $("#new_password_form").before('<div class="alert alert-success alert-dismissable"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>Password Changed Successfully !!!</div>');
                            setTimeout(function(){
                                bootbox.hideAll();
                            },3500);
                        } else {
                            $("#new_password_form").before('<div class="alert alert-danger alert-dismissable"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>'+data+'</div>');
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