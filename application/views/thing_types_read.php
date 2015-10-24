
<table class="table">
    <tr><td>tty_title</td><td><?php echo $tty_title; ?></td></tr>
    <tr><td>tty_icon</td><td>
        
        <?php if($tty_icon) :?>
        <img src="<?php echo base_url('uploads/'.$tty_icon) ?>" width="32" />
        <?php endif;?>
        
        
        </td></tr>
    <tr><td></td><td><a href="<?php echo site_url('thing_types') ?>" class="btn btn-default">Cancel</button></td></tr>
</table>
