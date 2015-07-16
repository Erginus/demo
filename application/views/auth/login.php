<div class="container">
    <div class="row">
        <div class="col-xs-12 col-sm-8 col-md-6 col-sm-offset-2 col-md-offset-3">
            <h1>Login</h1>
            <hr class="colorgraph"/>
            <?php if (isset($error)) { ?>
                <div class="alert alert-danger alert-dismissable"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button><?php echo $error; ?></div>
            <?php }
            ?>
            <?php echo form_open('', array('id' => 'login_form')); ?>
            <div class="form-group<?php
            if (form_error('user_login')) {
                echo ' has-error';
            }
            ?>">
                <input type="text" autocomplete="off" name="user_login" id="user_login" class="form-control input-lg" placeholder="Username OR Email Address" maxlength="50" />
                <?php echo form_error('user_login'); ?>
            </div>
            <div class="form-group<?php
                if (form_error('user_login_password')) {
                    echo ' has-error';
                }
                ?>">
                <input type="password" name="user_login_password" id="user_login_password" class="form-control input-lg" placeholder="Password" />
                <?php echo form_error('user_login_password'); ?>
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
            <div class="form-group">
                <label><input name="user_remember" type="checkbox" value="1" checked="checked" /> Remember Me</label>
                <a href="<?php echo base_url(); ?>auth/forgot-password" class="pull-right">Forgot Password</a>
            </div>
            <hr class="colorgraph" />
            <div class="row">
                <div class="col-xs-6 col-sm-6 col-md-6">
                    <input type="submit" class="btn btn-lg btn-success btn-block" value="Login">
                </div>
                <div class="col-xs-6 col-sm-6 col-md-6">
                    <a href="<?php echo base_url(); ?>auth/create-account" class="btn btn-lg btn-primary btn-block">Create Account</a>
                </div>
            </div>
            <?php echo form_close(); ?>
        </div>
    </div>
    <div class="row">
        <div class="col-xs-12 col-sm-8 col-md-6 col-sm-offset-2 col-md-offset-3 text-center">
            <hr class="colorgraph" />
            <div class="form-group">
                <h3>OR</h3>
            </div>
            <div class="text-center"></div>
            <div class="form-group">
                <div class="row">
                    <div class="col-md-6 col-sm-6 col-xs-6">
                        <a class="btn btn-lg btn-block btn-social btn-facebook" href="<?php echo base_url(); ?>auth/facebook" title="Login with Facebook">
                            <i class="fa fa-facebook"></i> Login with Facebook
                        </a>
                    </div>
                    <div class="col-md-6 col-sm-6 col-xs-6">
                        <a class="btn btn-lg btn-block btn-social btn-google-plus" href="<?php echo base_url(); ?>auth/google" title="Login with Google+">
                            <i class="fa fa-google-plus"></i> Login with Google+
                        </a>
                    </div>
                </div>
            </div>
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