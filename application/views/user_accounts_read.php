<!doctype html>
<html>
    <head>
        <title>harviacode.com - codeigniter crud generator</title>
        <link rel="stylesheet" href="<?php echo base_url('assets/bootstrap/css/bootstrap.min.css') ?>"/>
        <style>
            body{
                padding: 15px;
            }
        </style>
    </head>
    <body>
        <h2 style="margin-top:0px">User_accounts Read</h2>
        <table class="table">
	    <tr><td>uacc_group_fk</td><td><?php echo $uacc_group_fk; ?></td></tr>
	    <tr><td>uacc_email</td><td><?php echo $uacc_email; ?></td></tr>
	    <tr><td>uacc_username</td><td><?php echo $uacc_username; ?></td></tr>
	    <tr><td>uacc_password</td><td><?php echo $uacc_password; ?></td></tr>
	    <tr><td>uacc_ip_address</td><td><?php echo $uacc_ip_address; ?></td></tr>
	    <tr><td>uacc_salt</td><td><?php echo $uacc_salt; ?></td></tr>
	    <tr><td>uacc_activation_token</td><td><?php echo $uacc_activation_token; ?></td></tr>
	    <tr><td>uacc_forgotten_password_token</td><td><?php echo $uacc_forgotten_password_token; ?></td></tr>
	    <tr><td>uacc_forgotten_password_expire</td><td><?php echo $uacc_forgotten_password_expire; ?></td></tr>
	    <tr><td>uacc_update_email_token</td><td><?php echo $uacc_update_email_token; ?></td></tr>
	    <tr><td>uacc_update_email</td><td><?php echo $uacc_update_email; ?></td></tr>
	    <tr><td>uacc_active</td><td><?php echo $uacc_active; ?></td></tr>
	    <tr><td>uacc_suspend</td><td><?php echo $uacc_suspend; ?></td></tr>
	    <tr><td>uacc_fail_login_attempts</td><td><?php echo $uacc_fail_login_attempts; ?></td></tr>
	    <tr><td>uacc_fail_login_ip_address</td><td><?php echo $uacc_fail_login_ip_address; ?></td></tr>
	    <tr><td>uacc_date_fail_login_ban</td><td><?php echo $uacc_date_fail_login_ban; ?></td></tr>
	    <tr><td>uacc_date_last_login</td><td><?php echo $uacc_date_last_login; ?></td></tr>
	    <tr><td>uacc_date_added</td><td><?php echo $uacc_date_added; ?></td></tr>
	    <tr><td></td><td><a href="<?php echo site_url('user_accounts') ?>" class="btn btn-default">Cancel</button></td></tr>
	</table>
    </body>
</html>