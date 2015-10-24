<h2 style="margin-top:0px">User_accounts <?php echo $button ?></h2>
        <form action="<?php echo $action; ?>" method="post">
	    <div class="form-group">
                <label for="smallint">group <?php echo form_error('uacc_group_fk') ?></label>
                <input type="text" class="form-control" name="uacc_group_fk" id="uacc_group_fk" placeholder="group" value="<?php echo $uacc_group_fk; ?>" />
            </div>
	    <div class="form-group">
                <label for="varchar">email <?php echo form_error('uacc_email') ?></label>
                <input type="text" class="form-control" name="uacc_email" id="uacc_email" placeholder="email" value="<?php echo $uacc_email; ?>" />
            </div>
	    <div class="form-group">
                <label for="varchar">username <?php echo form_error('uacc_username') ?></label>
                <input type="text" class="form-control" name="uacc_username" id="uacc_username" placeholder="username" value="<?php echo $uacc_username; ?>" />
            </div>
	    <div class="form-group">
                <label for="varchar">password <?php echo form_error('uacc_password') ?></label>
                <input type="text" class="form-control" name="uacc_password" id="uacc_password" placeholder="password" value="<?php echo $uacc_password; ?>" />
            </div>
	    <div class="form-group">
                <label for="varchar">ip <?php echo form_error('uacc_ip_address') ?></label>
                <input type="text" class="form-control" name="uacc_ip_address" id="uacc_ip_address" placeholder="ip" value="<?php echo $uacc_ip_address; ?>" />
            </div>
	    <div class="form-group">
                <label for="varchar">salt <?php echo form_error('uacc_salt') ?></label>
                <input type="text" class="form-control" name="uacc_salt" id="uacc_salt" placeholder="salt" value="<?php echo $uacc_salt; ?>" />
            </div>
	    <div class="form-group">
                <label for="varchar">activation <?php echo form_error('uacc_activation_token') ?></label>
                <input type="text" class="form-control" name="uacc_activation_token" id="uacc_activation_token" placeholder="activation" value="<?php echo $uacc_activation_token; ?>" />
            </div>
	    <div class="form-group">
                <label for="varchar">forgotten <?php echo form_error('uacc_forgotten_password_token') ?></label>
                <input type="text" class="form-control" name="uacc_forgotten_password_token" id="uacc_forgotten_password_token" placeholder="forgotten" value="<?php echo $uacc_forgotten_password_token; ?>" />
            </div>
	    <div class="form-group">
                <label for="datetime">forgotten <?php echo form_error('uacc_forgotten_password_expire') ?></label>
                <input type="text" class="form-control" name="uacc_forgotten_password_expire" id="uacc_forgotten_password_expire" placeholder="forgotten" value="<?php echo $uacc_forgotten_password_expire; ?>" />
            </div>
	    <div class="form-group">
                <label for="varchar">update <?php echo form_error('uacc_update_email_token') ?></label>
                <input type="text" class="form-control" name="uacc_update_email_token" id="uacc_update_email_token" placeholder="update" value="<?php echo $uacc_update_email_token; ?>" />
            </div>
	    <div class="form-group">
                <label for="varchar">update <?php echo form_error('uacc_update_email') ?></label>
                <input type="text" class="form-control" name="uacc_update_email" id="uacc_update_email" placeholder="update" value="<?php echo $uacc_update_email; ?>" />
            </div>
	    <div class="form-group">
                <label for="tinyint">active <?php echo form_error('uacc_active') ?></label>
                <input type="text" class="form-control" name="uacc_active" id="uacc_active" placeholder="active" value="<?php echo $uacc_active; ?>" />
            </div>
	    <div class="form-group">
                <label for="tinyint">suspend <?php echo form_error('uacc_suspend') ?></label>
                <input type="text" class="form-control" name="uacc_suspend" id="uacc_suspend" placeholder="suspend" value="<?php echo $uacc_suspend; ?>" />
            </div>
	    <div class="form-group">
                <label for="smallint">fail <?php echo form_error('uacc_fail_login_attempts') ?></label>
                <input type="text" class="form-control" name="uacc_fail_login_attempts" id="uacc_fail_login_attempts" placeholder="fail" value="<?php echo $uacc_fail_login_attempts; ?>" />
            </div>
	    <div class="form-group">
                <label for="varchar">fail <?php echo form_error('uacc_fail_login_ip_address') ?></label>
                <input type="text" class="form-control" name="uacc_fail_login_ip_address" id="uacc_fail_login_ip_address" placeholder="fail" value="<?php echo $uacc_fail_login_ip_address; ?>" />
            </div>
	    <div class="form-group">
                <label for="datetime">date <?php echo form_error('uacc_date_fail_login_ban') ?></label>
                <input type="text" class="form-control" name="uacc_date_fail_login_ban" id="uacc_date_fail_login_ban" placeholder="date" value="<?php echo $uacc_date_fail_login_ban; ?>" />
            </div>
	    <div class="form-group">
                <label for="datetime">date <?php echo form_error('uacc_date_last_login') ?></label>
                <input type="text" class="form-control" name="uacc_date_last_login" id="uacc_date_last_login" placeholder="date" value="<?php echo $uacc_date_last_login; ?>" />
            </div>
	    <div class="form-group">
                <label for="datetime">date <?php echo form_error('uacc_date_added') ?></label>
                <input type="text" class="form-control" name="uacc_date_added" id="uacc_date_added" placeholder="date" value="<?php echo $uacc_date_added; ?>" />
            </div>
	    <input type="hidden" name="uacc_id" value="<?php echo $uacc_id; ?>" /> 
	    <button type="submit" class="btn btn-primary"><?php echo $button ?></button> 
	    <a href="<?php echo site_url('user_accounts') ?>" class="btn btn-default">Cancel</a>
	</form>