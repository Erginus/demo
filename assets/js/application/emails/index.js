$.blockUI.defaults.message = '<img alt="Processing..." src="'+base_url+'assets/images/ajax-loading.gif" />';
$.blockUI.defaults.css.border = 'none';
$.blockUI.defaults.css.backgroundColor = 'none';
$.blockUI.defaults.overlayCSS.opacity = 0.1;
$.blockUI.defaults.fadeOut = 100;
$(function(){
    $('#emails_datatable').dataTable({
        "sDom": '<"toolbar col-md-3"><"col-md-3"l><"col-md-3"f><"col-md-3 text-right"T>rtip',
        "bSort": false,
        "aoColumnDefs": [
        {
            "aTargets": [0],
            "bSearchable":false
        },
        {
            "aTargets": [1],
            "bSearchable":true
        },
        {
            "aTargets": [2],
            "bSearchable":false
        },
        {
            "aTargets": [3],
            "bSearchable":false,
            "mRender": function (data, type, full) {
                switch(data){
                    case '0':
                        return '<span class="label label-default">Queued</span>';
                        break;
                    case '1':
                        return '<span class="label label-info">Delivered</span>';
                        break;
                    case '2':
                        return '<span class="label label-primary">Opened</span>';
                        break;
                    case '3':
                        return '<span class="label label-success">Clicked</span>';
                        break;
                    case '4':
                        return '<span class="label label-danger">Failed</span>';
                        break;
                    default:
                        return '<span class="label label-default">Queued</span>';
                        break;
                }
            }
        },
        {
            "aTargets": [4],
            "bSearchable":false
        },
        {
            "aTargets": [5],
            "bSearchable":false
        },
        {
            "aTargets": [6],
            "bSearchable":false
        },
        {
            "aTargets": [7],
            "bSearchable":false
        }
        ],
        "fnRowCallback": function( nRow, aData, iDisplayIndex, iDisplayIndexFull ) {
        //            $('td', nRow).addClass('text-center');
        },
        "oTableTools": {
            "sSwfPath": base_url+"assets/js/plugins/datatables-1.9.4/tabletools-2.2.0/swf/copy_csv_xls_pdf.swf",
            "aButtons": [
            {
                "sExtends": "xls",
                "sButtonText": "<i class='fa fa-save'></i> EXCEL",
                "mColumns": [0,1,2,3,4,5,6,7,8,9,10,11,12]
            },
            {
                "sExtends": "pdf",
                "sButtonText": "<i class='fa fa-save'></i> PDF",
                "sPdfOrientation": "landscape",
                "sPdfSize": "tabloid",
                //                            "sPdfMessage": "User Listing [test message]",
                "mColumns": [0,1,2,3,4,5,6,7,8,9,10,11,12]
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
        "sAjaxSource": base_url+"emails/datatable",
        "iDisplayLength": 10,
        "aLengthMenu": [[20,50,100,200,500,1000],[20,50,100,200,500,1000]],
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
            $("div.toolbar").html('<a class="btn btn-primary" target="_blank" href="'+base_url+'emails/download"><i class="fa fa-download"></i> Download Full Report</a>');
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