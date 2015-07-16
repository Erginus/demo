Dear <?php echo $user_first_name . ' ' . $user_last_name; ?>,<br/><br/>
Congratulations !!!<br/>
Your account is successfully created.
<br/><br/>
Please Click on the Verify Email address button to verify your email address in order to activate your account.
<div style="text-align: center">
    <a href="<?php echo $verify_account_link; ?>" style="text-decoration: none;display: inline-block;background-color: rgb(52,142,218);margin: 5px;font-weight: bold;font-size: 16px;padding: 7px;color: rgb(255,255,255)" title="Verify Email address">Verify Email address</a>
</div>
<br/>
If clicking this link does not work then please paste the below URL in address bar of your browser and press enter.<br/>
<div style="padding: 12px;background-color: rgb(217,237,247); border-color: rgb(188,232,241);color: rgb(49,112,143);word-wrap:break-word;"><?php echo $verify_account_link; ?></div>