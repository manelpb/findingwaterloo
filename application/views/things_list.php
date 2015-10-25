
        <div class="row" style="margin-bottom: 10px">
            <div class="col-md-4">
                <h2 style="margin-top:0px">Things List</h2>
            </div>
            <div class="col-md-4 text-center">
                <div style="margin-top: 4px"  id="message">
                    <?php echo $this->session->userdata('message') <> '' ? $this->session->userdata('message') : ''; ?>
                </div>
            </div>
            <div class="col-md-4 text-right">
                <?php echo anchor(site_url('things/create'), 'Create', 'class="btn btn-primary"'); ?>
                
                <?php echo anchor(site_url('things/import_opendata'), 'Import Open Data', 'class="btn btn-primary"'); ?>
	    </div>
        </div>
        <table class="table table-bordered table-striped" id="mytable">
            <thead>
                <tr>
                    <th>No</th>
		    <th>title</th>
		    <th>address</th>
		    <th>popularity</th>
		    <th>tty</th>
		    <th>created</th>
		    <th>Action</th>
                </tr>
            </thead>
	    <tbody>
            <?php
            $start = 0;
            foreach ($things_data as $things)
            {
                ?>
                <tr>
		    <td><?php echo ++$start ?></td>
		    <td><?php echo $things->thg_title ?></td>
		    <td><?php echo $things->tgh_address ?></td>
		    <td><?php echo $things->tgh_popularity ?></td>
		    <td><?php echo $things->tty_title ?></td>
		    <td><?php echo $things->tgh_created_at ?></td>
		    <td style="text-align:center">
			<?php 
			echo anchor(site_url('things/read/'.$things->thg_id),'Read'); 
			echo ' | '; 
			echo anchor(site_url('things/update/'.$things->thg_id),'Update'); 
			echo ' | '; 
			echo anchor(site_url('things/delete/'.$things->thg_id),'Delete','onclick="javasciprt: return confirm(\'Are You Sure ?\')"'); 
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