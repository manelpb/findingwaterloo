<h2 style="margin-top:0px">Things <?php echo $button ?></h2>
<?php echo form_open_multipart($action);?>
    <div class="form-group">
        <label for="varchar">title <?php echo form_error('thg_title') ?></label>
        <input type="text" class="form-control" name="thg_title" id="thg_title" placeholder="title" value="<?php echo $thg_title; ?>" />
    </div>
    <div class="form-group">
        <label for="tgh_description">description <?php echo form_error('tgh_description') ?></label>
        <textarea class="form-control" rows="3" name="tgh_description" id="tgh_description" placeholder="description"><?php echo $tgh_description; ?></textarea>
    </div>
    <div class="form-group">
        <label for="varchar">image <?php echo form_error('tgh_image') ?></label>

        <?php echo form_upload("tgh_image", null, "class='form-control'") ?>

        <?php if ($tgh_image): ?>
            <?php echo $tgh_image; ?>
        <?php endif; ?>
    </div>
    <div class="form-group">
        <label for="varchar">address <?php echo form_error('tgh_address') ?></label>
        <input type="text" class="form-control" name="tgh_address" id="tgh_address" placeholder="address" value="<?php echo $tgh_address; ?>" />
    </div>
    <div class="form-group">
        <label for="int">popularity <?php echo form_error('tgh_popularity') ?></label>
        <input type="text" class="form-control" name="tgh_popularity" id="tgh_popularity" placeholder="popularity" value="<?php echo $tgh_popularity; ?>" />
    </div>
    <div class="form-group">
        <label for="int">tty <?php echo form_error('tgh_tty_id') ?></label>
        <?php echo form_dropdown("tgh_tty_id", $thingsTypesOptions, $tgh_tty_id, "class='form-control'") ?>
    </div>
    <input type="hidden" name="thg_id" value="<?php echo $thg_id; ?>" /> 
    <button type="submit" class="btn btn-primary"><?php echo $button ?></button> 
    <a href="<?php echo site_url('things') ?>" class="btn btn-default">Cancel</a>
</form>