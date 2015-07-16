$(function(){
    $('#groups_datatable').dataTable({
        "sDom": '<"toolbar col-md-3"><"col-md-3"l><"col-md-3"f><"col-md-3 text-right"T>rtip',
        //            "bSort": false,
        "aoColumnDefs": [
        {
            "aTargets": [2],
            "bSearchable":false,
            "mRender": function (data, type, full) {
                switch(data){
                    case '-1':
                        return '<span class="label label-danger">Suspended</span>';
                        break;
                    case '0':
                        return '<span class="label label-info">New</span>';
                        break;
                    case '1':
                        return '<span class="label label-success">Active</span>';
                        break;
                    default:
                        return 'New';
                        break;
                }
            }
        },
        {
            "aTargets": [3],
            "sType":"date",
            "bSearchable":false,
            "mRender": function (data, type, full) {
                var datex = data.split(" ");
                var datey = datex[0].split("-");
                return datey[2]+'-'+datey[1]+'-'+datey[0];
            }
        },
//        {
//            "aTargets": [4],
//            "bSortable":false,
//            "bSearchable":false,
//            "mData": null,
//            "mRender": function (data, type, full) {
//                return '<a class="" onclick="alert(\''+ full[0] +'\');"><i class="fa fa-eye"></i></a>';
//            }
//        },
        {
            "aTargets": [5],
            "bSortable":false,
            "bSearchable":false,
            "mData": null,
            "mRender": function (data, type, full) {
                return '<a class="" href="'+base_url+'acl/group/'+full[0]+'"><i class="fa fa-unlock-alt"></i></a>';
            }
        }
        ],
        "fnRowCallback": function( nRow, aData, iDisplayIndex, iDisplayIndexFull ) {
            $('td:eq(4),td:eq(5)', nRow).addClass('text-center');
        },
        "oTableTools": {
            "sSwfPath": base_url+"assets/js/plugins/datatables-1.9.4/tabletools-2.2.0/swf/copy_csv_xls_pdf.swf",
            "aButtons": [
            {
                "sExtends": "xls",
                "sButtonText": "<i class='fa fa-save'></i> EXCEL",
                "mColumns": [0,1,2,3]
            },
            {
                "sExtends": "pdf",
                "sButtonText": "<i class='fa fa-save'></i> PDF",
                "sPdfOrientation": "landscape",
                "sPdfSize": "tabloid",
                //                            "sPdfMessage": "Groups Listing [test message]",
                "mColumns": [0,1,2,3]
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
        "sAjaxSource": base_url+"groups/datatable",
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
            $("div.toolbar").html('<a class="btn btn-primary" href=""><i class="fa fa-plus"></i> Add New Group</a>');
            $(".dataTables_filter label input").addClass('form-control input-sm');
            $(".dataTables_length label select").css({
                'width':'100px'
            }).select2();
        }
    }).fnSetFilteringDelay(700);
});