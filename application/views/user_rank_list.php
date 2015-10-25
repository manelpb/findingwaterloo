
        <div class="row" style="margin-bottom: 10px">
            <div class="col-md-4">
                <h2 style="margin-top:0px">User_rank List</h2>
            </div>
            <div class="col-md-4 text-center">
                <div style="margin-top: 4px"  id="message">
                    <?php echo $this->session->userdata('message') <> '' ? $this->session->userdata('message') : ''; ?>
                </div>
            </div>
            <div class="col-md-4 text-right">
                <?php echo anchor(site_url('user_rank/create'), 'Create', 'class="btn btn-primary"'); ?>
	    </div>
        </div>
        <table class="table table-bordered table-striped" id="mytable">
            <thead>
                <tr>
                    <th>No</th>
		    <th>uacc</th>
		    <th>position</th>
		    <th>points</th>
		    <th>Action</th>
                </tr>
            </thead>
	    <tbody>
            <?php
            $start = 0;
            foreach ($user_rank_data as $user_rank)
            {
                ?>
                <tr>
		    <td><?php echo ++$start ?></td>
		    <td><?php echo $user_rank->usr_uacc_id ?></td>
		    <td><?php echo $user_rank->usr_position ?></td>
		    <td><?php echo $user_rank->usr_points ?></td>
		    <td style="text-align:center">
			<?php 
			echo anchor(site_url('user_rank/read/'.$user_rank->usr_id),'Read'); 
			echo ' | '; 
			echo anchor(site_url('user_rank/update/'.$user_rank->usr_id),'Update'); 
			echo ' | '; 
			echo anchor(site_url('user_rank/delete/'.$user_rank->usr_id),'Delete','onclick="javasciprt: return confirm(\'Are You Sure ?\')"'); 
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