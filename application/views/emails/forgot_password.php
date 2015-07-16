Dear <?php echo $user_first_name . ' ' . $user_last_name; ?>,<br/><br/>
We have received Forgot Password Request for your account.<br/>
Please Click on the link below to reset your password.<br/><br/>
<div style="text-align: center">
    <a href="<?php echo $password_reset_link; ?>" style="text-decoration: none;display: inline-block;background-color: rgb(52,142,218);margin: 5px;font-weight: bold;font-size: 16px;padding: 7px;color: rgb(255,255,255)" title="Reset Account Password">Reset Account Password</a>
</div>
<br/>
If clicking this link does not work then please paste the below URL in address bar of your browser and press enter.<br/>
<div style="padding: 12px;background-color: rgb(217,237,247); border-color: rgb(188,232,241);color: rgb(49,112,143);word-wrap:break-word;"><?php echo $password_reset_link; ?></div>