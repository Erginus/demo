<div class="container">
    <div class="row">
        <div class="col-md-12">
            <h1>URL Sets</h1>
            <hr class="colorgraph" />
        </div>        
        <div class="col-md-12 text-right">
            <a href="javascript:;" id="add_url_set" class="btn btn-primary btn-lg"><i class="fa fa-plus"></i> Add URL Set</a> &nbsp; <a href="<?php echo base_url(); ?>acl/refresh" class="btn btn-success btn-lg"><i class="fa fa-refresh"></i> Refresh URL Sets and Permissions</a>
            <br/>
            <br/>
        </div>
        <div id="drag_container" class="col-md-12">
            <div class="row">
                <div class="col-md-12">
                    <div class="panel panel-info">
                        <div class="panel-heading">
                            <h3 class="panel-title">Orphan URLs</h3>
                        </div>
                        <div class="panel-body">
                            <ul class="nav nav-pills sortable-list" id="url_set_0">
                                <?php
                                foreach ($urls as $url) {
                                    if ($url['url_sets_id'] === '0') {
                                        ?>
                                        <li class="sortable-item" id="url_<?php echo $url['url_id']; ?>"><a href="javascript:;">
                                                <?php
                                                if ($url['url_directory'] !== '') {
                                                    echo base_url() . $url['url_directory'] . '/' . $url['url_class'] . '/' . str_replace('_', '-', $url['url_method']);
                                                } else {
                                                    echo base_url() . $url['url_class'] . '/' . str_replace('_', '-', $url['url_method']);
                                                }
                                                ?>
                                            </a>
                                        </li>
                                        <?php
                                    }
                                }
                                ?>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row" id="masonry">
                <?php foreach ($url_sets as $url_set) { ?>
                    <div class="col-md-4 masonry">
                        <div class="panel panel-success">
                            <div class="panel-heading">
                                <h3 class="panel-title"><?php echo $url_set['url_set_name']; ?><a onclick="delete_url_set(this,<?php echo $url_set['url_set_id']; ?>);" class="pull-right" href="javascript:;"><i class="fa fa-times"></i></a></h3>
                            </div>
                            <div class="panel-body">
                                <ul class="nav nav-pills nav-stacked sortable-list" id="url_set_<?php echo $url_set['url_set_id']; ?>">
                                    <?php
                                    foreach ($urls as $url) {
                                        if ($url['url_sets_id'] === $url_set['url_set_id']) {
                                            ?>
                                            <li class="sortable-item" id="url_<?php echo $url['url_id']; ?>"><a href="javascript:;">
                                                    <?php
                                                    if ($url['url_directory'] !== '') {
                                                        echo base_url() . $url['url_directory'] . '/' . $url['url_class'] . '/' . str_replace('_', '-', $url['url_method']);
                                                    } else {
                                                        echo base_url() . $url['url_class'] . '/' . str_replace('_', '-', $url['url_method']);
                                                    }
                                                    ?>
                                                </a>
                                            </li>
                                            <?php
                                        }
                                    }
                                    ?>
                                </ul>
                            </div>
                        </div>
                    </div>
                <?php }
                ?>                
            </div>
        </div>
    </div>
</div>
<?php if (ENVIRONMENT === 'development') { ?>
    <script type="text/javascript" src="<?php echo base_url(); ?>assets/js/plugins/jquery-ui-1.10.4/js/jquery-ui-1.10.4.custom.js"></script>
    <script type="text/javascript" src="<?php echo base_url(); ?>assets/js/plugins/masonry-3.1.5/masonry.pkgd.min.js"></script>
    <script type="text/javascript" src="<?php echo base_url(); ?>assets/js/plugins/jquery-blockUI-2.66.0/jquery.blockUI.min.js"></script>
<?php } else { ?>
    <script type="text/javascript" src="http://code.jquery.com/ui/1.10.4/jquery-ui.min.js"></script>
    <script type="text/javascript" src="http://cdnjs.cloudflare.com/ajax/libs/masonry/3.1.2/masonry.pkgd.js"></script>
    <script type="text/javascript" src="http://cdnjs.cloudflare.com/ajax/libs/jquery.blockUI/2.66.0-2013.10.09/jquery.blockUI.min.js"></script>
<?php } ?>