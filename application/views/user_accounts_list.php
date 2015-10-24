
        <div class="row" style="margin-bottom: 10px">
            <div class="col-md-4">
                <h2 style="margin-top:0px">User_accounts List</h2>
            </div>
            <div class="col-md-4 text-center">
                <div style="margin-top: 4px"  id="message">
                    <?php echo $this->session->userdata('message') <> '' ? $this->session->userdata('message') : ''; ?>
                </div>
            </div>
            <div class="col-md-4 text-right">
                <?php echo anchor(site_url('user_accounts/create'), 'Create', 'class="btn btn-primary"'); ?>
	    </div>
        </div>
        <table class="table table-bordered table-striped" id="mytable">
            <thead>
                <tr>
                    <th>No</th>
		    <th>email</th>
		    <th>username</th>
		    <th>created_date</th>
		    <th>Action</th>
                </tr>
            </thead>
	    <tbody>
            <?php
            $start = 0;
            foreach ($user_accounts_data as $user_accounts)
            {
                ?>
                <tr>
		    <td><?php echo ++$start ?></td>
		    <td><?php echo $user_accounts->uacc_email ?></td>
		    <td><?php echo $user_accounts->uacc_username ?></td>
		    <td><?php echo $user_accounts->uacc_date_added ?></td>
		    <td style="text-align:center">
			<?php 
			echo anchor(site_url('user_accounts/read/'.$user_accounts->uacc_id),'Read'); 
			echo ' | '; 
			echo anchor(site_url('user_accounts/update/'.$user_accounts->uacc_id),'Update'); 
			echo ' | '; 
			echo anchor(site_url('user_accounts/delete/'.$user_accounts->uacc_id),'Delete','onclick="javasciprt: return confirm(\'Are You Sure ?\')"'); 
			?>
		    </td>
	        </tr>
                <?php
            }
            ?>
            </tbody>
        </table>
        <script src="<?php echo base_url('assets/js/jquery-1.11.2.min.js') ?>"></script>
        <script src="<?php echo base_url('assets/datatables/jquery.dataTables.js') ?>"></script>
        <script src="<?php echo base_url('assets/datatables/dataTables.bootstrap.js') ?>"></script>
        <script type="text/javascript">
            $(document).ready(function () {
                $("#mytable").dataTable();
            });
        </script>