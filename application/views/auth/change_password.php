<div class="container">
    <div class="row">
        <div class="col-xs-12 col-sm-8 col-md-6 col-sm-offset-2 col-md-offset-3">
            <h1>Change Password</h1>
            <hr class="colorgraph"/>
            <?php if (isset($error)) { ?>
                <div class="alert alert-danger alert-dismissable"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button><?php echo $error; ?></div>
            <?php } if (isset($success)) {
                ?>
                <div class="alert alert-success alert-dismissable"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button><?php echo $success; ?></div>
                <script type="text/javascript">
                    setTimeout(function(){
                        document.location.href = base_url + 'auth/dashboard';
                    },3000);
                </script>
                Redirecting to Dashboard...<br/>    
                <a href="<?php echo base_url(); ?>auth/dashboard">Click Here</a> if browser do not redirect you to dashboard.
                <?php
            } else {
                echo form_open('', array('id' => 'change_password_form'));
                ?>
                <div class="form-group<?php
            if (form_error('user_old_password')) {
                echo ' has-error';
            }
                ?>">
                    <input type="password" name="user_old_password" id="user_old_password" class="form-control input-lg" placeholder="Old Password" maxlength="20" value="<?php echo set_value('user_old_password'); ?>" />
                    <?php echo form_error('user_old_password'); ?>
                </div>
                <div class="form-group<?php
                if (form_error('user_login_password')) {
                    echo ' has-error';
                }
                    ?>">
                    <input type="password" name="user_login_password" id="user_login_password" class="form-control input-lg" placeholder="New Password" maxlength="20" value="<?php echo set_value('user_login_password'); ?>" />
                    <?php echo form_error('user_login_password'); ?>
                </div>
                <div class="form-group<?php
                if (form_error('user_confirm_password')) {
                    echo ' has-error';
                }
                    ?>">
                    <input type="password" name="user_confirm_password" id="user_confirm_password" class="form-control input-lg" placeholder="Confirm Password" maxlength="20" value="<?php echo set_value('user_confirm_password'); ?>" />
                    <?php echo form_error('user_confirm_password'); ?>
                </div>
                <hr class="colorgraph" />
                <div class="row">
                    <div class="col-xs-6 col-sm-6 col-md-6">
                        <input type="submit" class="btn btn-lg btn-success btn-block" value="Submit Request">
                    </div>
                    <div class="col-xs-6 col-sm-6 col-md-6">
                        <a href="<?php echo base_url(); ?>auth/dashboard" class="btn btn-lg btn-primary btn-block">Back to Dashboard</a>
                    </div>
                </div>
                <?php
                echo form_close();
            }
            ?>
        </div>
    </div>
</div>
<?php if (ENVIRONMENT === 'development') { ?>
    <script type="text/javascript" src="<?php echo base_url('assets/js/plugins/jquery-validate-1.12.0/jquery.validate.min.js'); ?>"></script>
    <script type="text/javascript" src="<?php echo base_url('assets/js/plugins/jquery-validate-1.12.0/additional-methods.min.js'); ?>"></script>
<?php } else { ?>
    <script type="text/javascript" src="http://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.12.0/jquery.validate.min.js"></script>
    <script type="text/javascript" src="http://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.12.0/additional-methods.min.js"></script>
<?php } ?>