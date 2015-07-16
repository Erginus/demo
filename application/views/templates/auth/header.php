<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1" />
        <meta name="description" content="<?php echo isset($description) ? $description : ''; ?>" />
        <meta name="author" content="<?php echo defined('AUTHOR') ? AUTHOR : ''; ?>" />
        <title><?php echo isset($title) ? $title : ucwords(str_replace('_', ' ', $this->router->method)) . ' ' . ucwords(str_replace('_', ' ', $this->router->class)); ?></title>
        <?php if (ENVIRONMENT === 'development') { ?>
            <link href="<?php echo base_url('assets/css/bootstrap.min.css'); ?>" rel="stylesheet" />
            <link href="<?php echo base_url('assets/css/plugins/font-awesome-4.1.0/css/font-awesome.min.css'); ?>" rel="stylesheet" />
            <link href="<?php echo base_url('assets/js/plugins/uniformjs-2.1.2/themes/default/css/uniform.default.min.css'); ?>" rel="stylesheet" />
            <link href="<?php echo base_url('assets/css/plugins/bootstrap-social-4.2.1/bootstrap-social.min.css'); ?>" rel="stylesheet" />
            <!--[if lt IE 9]>
            <script src="<?php echo base_url('assets/js/html5shiv.js'); ?>"></script>
            <script src="<?php echo base_url('assets/js/respond.min.js'); ?>"></script>
            <![endif]-->
            <script type="text/javascript" src="<?php echo base_url('assets/js/jquery-1.11.1.min.js'); ?>"></script>
            <script type="text/javascript" src="<?php echo base_url('assets/js/jquery-migrate-1.2.1.min.js'); ?>"></script>
            <script type="text/javascript" src="<?php echo base_url('assets/js/bootstrap.min.js'); ?>"></script>
            <script type="text/javascript" src="<?php echo base_url('assets/js/plugins/bootstrap-hover-dropdown-2.0.2/bootstrap-hover-dropdown.min.js'); ?>"></script>
            <script type="text/javascript" src="<?php echo base_url('assets/js/plugins/jquery-placeholder-2.0.7/jquery.placeholder.min.js'); ?>"></script>
            <script type="text/javascript" src="<?php echo base_url('assets/js/plugins/uniformjs-2.1.2/jquery.uniform.min.js'); ?>"></script>
        <?php } else { ?>
            <link href="http://netdna.bootstrapcdn.com/bootswatch/3.2.0/lumen/bootstrap.min.css" rel="stylesheet" />
            <link href="http://netdna.bootstrapcdn.com/font-awesome/4.1.0/css/font-awesome.min.css" rel="stylesheet" />
            <link href="http://cdnjs.cloudflare.com/ajax/libs/Uniform.js/2.1.2/themes/default/css/uniform.default.min.css" rel="stylesheet" />
            <link href="http://cdnjs.cloudflare.com/ajax/libs/bootstrap-social/4.2.1/bootstrap-social.min.css" rel="stylesheet" />
            <!--[if lt IE 9]>
            <script type="text/javascript" src="http://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
            <script type="text/javascript" src="http://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
            <![endif]-->
            <script type="text/javascript" src="http://code.jquery.com/jquery-1.11.1.min.js"></script>
            <script type="text/javascript" src="http://code.jquery.com/jquery-migrate-1.2.1.min.js"></script>
            <script type="text/javascript" src="http://netdna.bootstrapcdn.com/bootstrap/3.2.0/js/bootstrap.min.js"></script>
            <script type="text/javascript" src="http://cdnjs.cloudflare.com/ajax/libs/bootstrap-hover-dropdown/2.0.2/bootstrap-hover-dropdown.min.js"></script>
            <script type="text/javascript" src="http://cdnjs.cloudflare.com/ajax/libs/jquery-placeholder/2.0.7/jquery.placeholder.min.js"></script>
            <script type="text/javascript" src="http://cdnjs.cloudflare.com/ajax/libs/Uniform.js/2.1.2/jquery.uniform.min.js"></script>
            <?php
        }
        if (($this->router->directory === '') && (is_file(FCPATH . 'assets/css/application/' . $this->router->class . '/' . $this->router->method . '.min.css'))) {
            ?>
            <link href="<?php echo base_url('assets/css/application/' . $this->router->class . '/' . $this->router->method . '.min.css'); ?>" rel="stylesheet" />
            <?php
        } else if (is_file(FCPATH . 'assets/css/application/' . $this->router->directory . '/' . $this->router->class . '/' . $this->router->method . '.min.css')) {
            ?>
            <link href="<?php echo base_url('assets/css/application/' . $this->router->directory . '/' . $this->router->class . '/' . $this->router->method . '.min.css'); ?>" rel="stylesheet" />
        <?php } ?>
        <script type="text/javascript">var base_url = '<?php echo base_url(); ?>';<?php if ($this->config->item('csrf_protection') === TRUE) { ?>$.ajaxSetup({data:{'<?php echo $this->security->get_csrf_token_name(); ?>':'<?php echo $this->security->get_csrf_hash(); ?>'}});<?php } ?>
        </script>
    </head>
    <body>
        <div class="navbar navbar-default navbar-fixed-top" role="navigation">
            <div class="container">
                <div class="navbar-header">
                    <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                        <span class="sr-only">Toggle navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
                    <a class="navbar-brand" href="<?php echo base_url(); ?>">Demo Application</a>
                </div>
                <div class="collapse navbar-collapse">
                    <ul class="nav navbar-nav">
                        <li class="active"><a href="<?php echo base_url(); ?>">Home</a></li>
                    </ul>
                    <ul class="nav navbar-nav navbar-right">
                        <li><a href="<?php echo base_url('auth/login'); ?>">Login</a></li>
                    </ul>
                </div>
            </div>
        </div>