<div id="footer">
    <div class="container">
        <div class="row">
            <div class="col-md-12 text-center">Copyright &copy; <?php echo date('Y'); ?></div>
        </div>
    </div>
</div>
<link href="<?php echo base_url('assets/css/common.min.css'); ?>" rel="stylesheet" />
<script type="text/javascript" src="<?php echo base_url('assets/js/common.js'); ?>"></script>
<?php if (($this->router->directory === '') && (is_file(FCPATH . 'assets/js/application/' . $this->router->class . '/' . $this->router->method . '.min.js'))) { ?>
    <script type="text/javascript" src="<?php echo base_url('assets/js/application/' . $this->router->class . '/' . $this->router->method . '.min.js'); ?>"></script>
    <?php
}
else if (is_file(FCPATH . 'assets/js/application/' . $this->router->directory . '/' . $this->router->class . '/' . $this->router->method . '.min.js')) {
    ?>
<script type="text/javascript" src="<?php echo base_url('assets/js/application/' . $this->router->directory . '/' . $this->router->class . '/' . $this->router->method . '.min.js'); ?>"></script>
<?php } ?>
<!--{elapsed_time}|{memory_usage}-->
</body>
</html>