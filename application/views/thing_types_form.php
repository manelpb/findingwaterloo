<h2 style="margin-top:0px">Thing_types <?php echo $button ?></h2>

<?php echo form_open_multipart($action);?>

    <div class="form-group">
        <label for="varchar">title <?php echo form_error('tty_title') ?></label>
        <input type="text" class="form-control" name="tty_title" id="tty_title" placeholder="title" value="<?php echo $tty_title; ?>" />
    </div>
    <div class="form-group">
        <label for="varchar">icon <?php echo form_error('tty_icon') ?></label>
        
        <?php echo form_upload("tty_icon", null, "class='form-control'") ?>

        <?php if ($tty_icon): ?>
            <img src="<?php echo base_url('uploads/'.$tty_icon) ?>" width="32" />
        <?php endif; ?>
    </div>
    <input type="hidden" name="tty_id" value="<?php echo $tty_id; ?>" /> 
    <button type="submit" class="btn btn-primary"><?php echo $button ?></button> 
    <a href="<?php echo site_url('thing_types') ?>" class="btn btn-default">Cancel</a>
</form>