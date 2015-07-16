<div class="container">
    <div class="row">
        <div class="col-xs-12 col-sm-8 col-md-6 col-sm-offset-2 col-md-offset-3">
            <h1>Create Account</h1>
            <hr class="colorgraph"/>
            <?php if (isset($error)) { ?>
                <div class="alert alert-danger alert-dismissable"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button><?php echo $error; ?></div>
            <?php } if (isset($success)) { ?>
                <div class="alert alert-success alert-dismissable"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button><?php echo $success; ?></div>
                <script type="text/javascript">
                    setTimeout(function(){
                        document.location.href = base_url + 'auth/login';
                    },3000);
                </script>
                Redirecting to Login Page...<br/>    
                <a href="<?php echo base_url(); ?>auth/login">Click Here</a> if browser do not redirect you to login page.
                <?php
            } else {
                echo form_open('', array('id' => 'create_account_form'));
                ?>
                <div class="form-group<?php
            if (form_error('user_login')) {
                echo ' has-error';
            }
                ?>">
                    <input type="text" autocomplete="off" name="user_login" id="user_login" class="form-control input-lg" placeholder="Username" maxlength="20" value="<?php echo set_value('user_login'); ?>" />
                    <?php echo form_error('user_login'); ?>
                </div>
                <div class="row">
                    <div class="col-xs-6 col-sm-6 col-md-6">
                        <div class="form-group<?php
                if (form_error('user_login_password')) {
                    echo ' has-error';
                }
                    ?>">
                            <input type="password" name="user_login_password" id="user_login_password" class="form-control input-lg" placeholder="Password" value="" />
                            <?php echo form_error('user_login_password'); ?>
                        </div>
                    </div>
                    <div class="col-xs-6 col-sm-6 col-md-6">
                        <div class="form-group<?php
                        if (form_error('user_confirm_password')) {
                            echo ' has-error';
                        }
                            ?>">
                            <input type="password" name="user_confirm_password" id="user_confirm_password" class="form-control input-lg" placeholder="Confirm Password" value="" />
                            <?php echo form_error('user_confirm_password'); ?>
                        </div>
                    </div>
                </div>
                <div class="form-group<?php
                        if (form_error('user_email')) {
                            echo ' has-error';
                        }
                            ?>">
                    <input type="text" autocomplete="off" name="user_email" id="user_email" class="form-control input-lg" placeholder="Email Address" value="<?php echo set_value('user_email'); ?>" data-container="body" data-toggle="popover" data-trigger="focus" data-placement="auto top" data-content="Don't Worry. We DO NOT send useless emails. We DO NOT sell email ids." />
                    <?php echo form_error('user_email'); ?>
                </div>
                <div class="row">
                    <div class="col-xs-12 col-sm-6 col-md-6">
                        <div class="form-group<?php
                if (form_error('user_first_name')) {
                    echo ' has-error';
                }
                    ?>">
                            <input type="text" autocomplete="off" name="user_first_name" id="user_first_name" class="form-control input-lg" placeholder="First Name" value="<?php echo set_value('user_first_name'); ?>" />
                            <?php echo form_error('user_first_name'); ?>
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-6 col-md-6">
                        <div class="form-group<?php
                        if (form_error('user_last_name')) {
                            echo ' has-error';
                        }
                            ?>">
                            <input type="text" autocomplete="off" name="user_last_name" id="user_last_name" class="form-control input-lg" placeholder="Last Name (Optional)" value="<?php echo set_value('user_last_name'); ?>" />
                            <?php echo form_error('user_last_name'); ?>
                        </div>
                    </div>
                </div>
                <div class="form-group<?php
                if (form_error('newsletter_status')) {
                    echo ' has-error';
                }
                    ?>">
                    <label class="checkbox-inline"><input type="checkbox" name="newsletter_status" id="newsletter_status" value="1" <?php echo set_checkbox('newsletter_status', '1'); ?> />Send me occasional newsletters and other informations via email.</label>
                </div>
                <?php
                if (isset($captcha_image)) {
                    ?>
                    <div class="form-group<?php
            if (form_error('captcha_image')) {
                echo ' has-error';
            }
                    ?>">
                        <div class="input-group">
                            <span class="input-group-addon"><?php echo $captcha_image; ?></span>
                            <input class="form-control input-lg" type="text" value="" name="captcha_image" id="captcha_image" placeholder="Image Text" maxlength="6" />        
                        </div>
                        <?php echo form_error('captcha_image'); ?>
                    </div>
                <?php } ?>
                <hr class="colorgraph" />
                <div class="row">
                    <div class="col-xs-6 col-sm-6 col-md-6">
                        <input type="submit" class="btn btn-lg btn-success btn-block" value="Create Account">
                    </div>
                    <div class="col-xs-6 col-sm-6 col-md-6">
                        <a href="<?php echo base_url(); ?>auth/login" class="btn btn-lg btn-primary btn-block">Back to Login</a>
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