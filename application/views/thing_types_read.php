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
        <h2 style="margin-top:0px">Thing_types Read</h2>
        <table class="table">
	    <tr><td>tty_title</td><td><?php echo $tty_title; ?></td></tr>
	    <tr><td>tty_icon</td><td><?php echo $tty_icon; ?></td></tr>
	    <tr><td></td><td><a href="<?php echo site_url('thing_types') ?>" class="btn btn-default">Cancel</button></td></tr>
	</table>
    </body>
</html>