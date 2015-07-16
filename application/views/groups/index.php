<div class="container">
    <div class="row">
        <div class="col-md-12">
        <h1>Manage Groups</h1>
        <hr class="colorgraph" />
        <div class="col-md-offset-1 col-md-10">
            <table id="groups_datatable" class="table table-striped table-bordered table-hover">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Group Name</th>
                        <th>Status</th>
                        <th>Created</th>
                        <th class="text-center">Users Count</th>
                        <th class="text-center">Permissions</th>
                    </tr>
                </thead>
                <tbody></tbody>
                <tfoot></tfoot>
            </table>
        </div>
        </div>
    </div>
</div>
<?php if (ENVIRONMENT === 'development') { ?>
    <link type="text/css" rel="stylesheet" href="<?php echo base_url(); ?>assets/js/plugins/datatables-1.9.4/css/jquery.dataTables.css" />
    <link type="text/css" rel="stylesheet" href="<?php echo base_url(); ?>assets/js/plugins/datatables-1.9.4/tabletools-2.2.0/css/dataTables.tableTools.min.css" />
    <link type="text/css" rel="stylesheet" href="<?php echo base_url(); ?>assets/js/plugins/select2-3.4.6/select2.min.css" />
    <link type="text/css" rel="stylesheet" href="<?php echo base_url(); ?>assets/js/plugins/select2-3.4.6/select2-bootstrap.css" />
    <script type="text/javascript" src="<?php echo base_url(); ?>assets/js/plugins/datatables-1.9.4/js/jquery.dataTables.min.js"></script>
    <script type="text/javascript" src="<?php echo base_url(); ?>assets/js/plugins/datatables-1.9.4/tabletools-2.2.0/js/dataTables.tableTools.min.js"></script>
    <script type="text/javascript" src="<?php echo base_url(); ?>assets/js/plugins/datatables-1.9.4/js/jquery.dataTables.delay.min.js"></script>
    <script type="text/javascript" src="<?php echo base_url(); ?>assets/js/plugins/datatables-1.9.4/js/dataTables.bootstrap.custom.js"></script>
    <script type="text/javascript" src="<?php echo base_url(); ?>assets/js/plugins/select2-3.4.6/select2.min.js"></script>
    <script type="text/javascript" src="<?php echo base_url(); ?>assets/js/plugins/jquery-blockUI-2.66.0/jquery.blockUI.min.js"></script>
<?php } else { ?>
    <link type="text/css" rel="stylesheet" href="http://cdn.datatables.net/1.9.4/css/jquery.dataTables.min.css" />
    <link type="text/css" rel="stylesheet" href="http://cdn.datatables.net/tabletools/2.2.0/css/dataTables.tableTools.min.css" />
    <link type="text/css" rel="stylesheet" href="http://cdnjs.cloudflare.com/ajax/libs/select2/3.4.6/select2.min.css" />
    <link type="text/css" rel="stylesheet" href="http://cdnjs.cloudflare.com/ajax/libs/select2/3.4.6/select2-bootstrap.css" />
    <script type="text/javascript" src="http://cdn.datatables.net/1.9.4/js/jquery.dataTables.min.js"></script>
    <script type="text/javascript" src="http://cdn.datatables.net/tabletools/2.2.0/js/dataTables.tableTools.min.js"></script>
    <script type="text/javascript" src="<?php echo base_url(); ?>assets/js/plugins/datatables-1.9.4/js/jquery.dataTables.delay.min.js"></script>
    <script type="text/javascript" src="<?php echo base_url(); ?>assets/js/plugins/datatables-1.9.4/js/dataTables.bootstrap.custom.js"></script>
    <script type="text/javascript" src="http://cdnjs.cloudflare.com/ajax/libs/select2/3.4.6/select2.min.js"></script>
    <script type="text/javascript" src="http://cdnjs.cloudflare.com/ajax/libs/jquery.blockUI/2.66.0-2013.10.09/jquery.blockUI.min.js"></script>
<?php } ?>