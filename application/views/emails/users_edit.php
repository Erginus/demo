Dear <?php echo $user_first_name . ' ' . $user_last_name; ?>,<br/><br/>
Your account is edited by site administrator. Following are the details.
<div style="padding: 12px;background-color: rgb(252,248,227); border-color: rgb(250,235,204);color: rgb(138,109,59);word-wrap:break-word;">
    Username : <b><?php echo $user_login; ?></b><br/>
    First Name : <b><?php echo $user_first_name; ?></b><br/>
    Last Name : <b><?php echo $user_last_name; ?></b><br/>
    Email : <b><?php echo $user_email; ?></b>
</div>
<br/>
Please Click on the Verify Account Changes button to verify account changes.
<div style="text-align: center">
    <a href="<?php echo $login_link; ?>" style="text-decoration: none;display: inline-block;background-color: rgb(52,142,218);margin: 5px;font-weight: bold;font-size: 16px;padding: 7px;color: rgb(255,255,255)" title="Verify Account Changes">Verify Account Changes</a>
</div>
<br/>
If clicking this link does not work then please paste the below URL in address bar of your browser and press enter.<br/>
<div style="padding: 12px;background-color: rgb(217,237,247); border-color: rgb(188,232,241);color: rgb(49,112,143);word-wrap:break-word;"><?php echo $login_link; ?></div>