<h2 style="margin-top:0px">Thing_types <?php echo $button ?></h2>
        <form action="<?php echo $action; ?>" method="post">
	    <div class="form-group">
                <label for="varchar">title <?php echo form_error('tty_title') ?></label>
                <input type="text" class="form-control" name="tty_title" id="tty_title" placeholder="title" value="<?php echo $tty_title; ?>" />
            </div>
	    <div class="form-group">
                <label for="varchar">icon <?php echo form_error('tty_icon') ?></label>
                <input type="text" class="form-control" name="tty_icon" id="tty_icon" placeholder="icon" value="<?php echo $tty_icon; ?>" />
            </div>
	    <input type="hidden" name="tty_id" value="<?php echo $tty_id; ?>" /> 
	    <button type="submit" class="btn btn-primary"><?php echo $button ?></button> 
	    <a href="<?php echo site_url('thing_types') ?>" class="btn btn-default">Cancel</a>
	</form>