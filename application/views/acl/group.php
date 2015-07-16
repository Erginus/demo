<div class="container">
    <div class="row">
        <div class="col-md-12">
            <h1><?php echo $group['group_name']; ?> Permissions</h1>
            <hr class="colorgraph" />
        </div>        
        <div id="urls_container" class="col-md-12">
            <div class="row">
                <div class="col-md-12">
                    <div class="panel panel-info">
                        <div class="panel-heading">
                            <h3 class="panel-title">Orphan URLs</h3>
                        </div>
                        <div class="panel-body">
                            <ul class="nav nav-pills">
                                <?php
                                foreach ($urls as $url) {
                                    if ($url['url_sets_id'] === '0') {
                                        ?>
                                        <li>
                                            <label><input type="checkbox" value="1" class="url_permission" id="group_url_permission_<?php echo $url['url_id']; ?>" <?php
                                if ($url['group_url_permission'] === '1') {
                                    echo 'checked="checked"';
                                }
                                        ?> />
                                                          <?php
                                                          if ($url['url_directory'] !== '') {
                                                              echo base_url() . $url['url_directory'] . '/' . $url['url_class'] . '/' . str_replace('_', '-', $url['url_method']);
                                                          } else {
                                                              echo base_url() . $url['url_class'] . '/' . str_replace('_', '-', $url['url_method']);
                                                          }
                                                          ?>
                                            </label>
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
                                <h3 class="panel-title"><?php echo $url_set['url_set_name'] ?></h3>
                            </div>
                            <div class="panel-body">
                                <ul class="nav nav-pills nav-stacked" id="url_set_<?php echo $url_set['url_set_id']; ?>">
                                    <?php
                                    foreach ($urls as $url) {
                                        if ($url['url_sets_id'] === $url_set['url_set_id']) {
                                            ?>
                                            <li>
                                                <label>
                                                    <input type="checkbox" value="1" class="url_permission" id="group_url_permission_<?php echo $url['url_id']; ?>" <?php
                                if ($url['group_url_permission'] === '1') {
                                    echo 'checked="checked"';
                                }
                                            ?> />
                                                           <?php
                                                           if ($url['url_directory'] !== '') {
                                                               echo base_url() . $url['url_directory'] . '/' . $url['url_class'] . '/' . str_replace('_', '-', $url['url_method']);
                                                           } else {
                                                               echo base_url() . $url['url_class'] . '/' . str_replace('_', '-', $url['url_method']);
                                                           }
                                                           ?>
                                                </label>
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
    <script type="text/javascript" src="<?php echo base_url(); ?>assets/js/plugins/masonry-3.1.5/masonry.pkgd.min.js"></script>
    <script type="text/javascript" src="<?php echo base_url(); ?>assets/js/plugins/jquery-blockUI-2.66.0/jquery.blockUI.min.js"></script>
<?php } else { ?>
    <script type="text/javascript" src="http://cdnjs.cloudflare.com/ajax/libs/masonry/3.1.2/masonry.pkgd.js"></script>
    <script type="text/javascript" src="http://cdnjs.cloudflare.com/ajax/libs/jquery.blockUI/2.66.0-2013.10.09/jquery.blockUI.min.js"></script>
<?php } ?>