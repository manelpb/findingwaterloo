<h2 style="margin-top:0px">Things <?php echo $button ?></h2>
<?php echo form_open_multipart($action);?>
    <div class="form-group">
        <label for="varchar">file</label>

        <?php echo form_upload("file", null, "class='form-control'") ?>
    </div>
    <div class="form-group">
        <label for="int">type <?php echo form_error('tgh_tty_id') ?></label>
        <?php echo form_dropdown("tgh_tty_id", $thingsTypesOptions, $tgh_tty_id, "class='form-control'") ?>
    </div>
    <input type="hidden" name="thg_id" value="<?php echo $thg_id; ?>" /> 
    <button type="submit" class="btn btn-primary"><?php echo $button ?></button> 
    <a href="<?php echo site_url('things') ?>" class="btn btn-default">Cancel</a>
</form>