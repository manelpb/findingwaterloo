<h2 style="margin-top:0px">User_rank <?php echo $button ?></h2>
<form action="<?php echo $action; ?>" method="post">


    <div class="form-group">
        <label for="int">User</label>
        <?php echo form_dropdown("usr_uacc_id", $usersList, $usr_uacc_id, "class='form-control'") ?>
    </div>

    <div class="form-group">
        <label for="int">position <?php echo form_error('usr_position') ?></label>
        <input type="text" class="form-control" name="usr_position" id="usr_position" placeholder="position" value="<?php echo $usr_position; ?>" />
    </div>
    <div class="form-group">
        <label for="int">points <?php echo form_error('usr_points') ?></label>
        <input type="text" class="form-control" name="usr_points" id="usr_points" placeholder="points" value="<?php echo $usr_points; ?>" />
    </div>
    <input type="hidden" name="usr_id" value="<?php echo $usr_id; ?>" /> 
    <button type="submit" class="btn btn-primary"><?php echo $button ?></button> 
    <a href="<?php echo site_url('user_rank') ?>" class="btn btn-default">Cancel</a>
</form>