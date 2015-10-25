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
        <h2 style="margin-top:0px">User_rank Read</h2>
        <table class="table">
	    <tr><td>usr_uacc_id</td><td><?php echo $usr_uacc_id; ?></td></tr>
	    <tr><td>usr_position</td><td><?php echo $usr_position; ?></td></tr>
	    <tr><td>usr_points</td><td><?php echo $usr_points; ?></td></tr>
	    <tr><td></td><td><a href="<?php echo site_url('user_rank') ?>" class="btn btn-default">Cancel</button></td></tr>
	</table>
    </body>
</html>