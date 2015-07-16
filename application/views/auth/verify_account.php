<div class="container">
    <div class="row">
        <div class="col-xs-12 col-sm-8 col-md-6 col-sm-offset-2 col-md-offset-3">
            <h1>Verify Account</h1>
            <hr class="colorgraph"/>
            <?php if (isset($error)) { ?>
                <div class="alert alert-danger alert-dismissable"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button><?php echo $error; ?></div>
            <?php } if (isset($success)) {
                ?>
                <div class="alert alert-success alert-dismissable"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button><?php echo $success; ?></div>
            <?php } ?>
            <script type="text/javascript">
                setTimeout(function(){
                    document.location.href = base_url + 'auth/login';
                },3000);
            </script>
            Redirecting to Login Page...<br/>    
            <a href="<?php echo base_url(); ?>auth/login">Click Here</a> if browser do not redirect you to login page.
        </div>
    </div>
</div>