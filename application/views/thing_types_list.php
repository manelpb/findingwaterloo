
        <div class="row" style="margin-bottom: 10px">
            <div class="col-md-4">
                <h2 style="margin-top:0px">Thing_types List</h2>
            </div>
            <div class="col-md-4 text-center">
                <div style="margin-top: 4px"  id="message">
                    <?php echo $this->session->userdata('message') <> '' ? $this->session->userdata('message') : ''; ?>
                </div>
            </div>
            <div class="col-md-4 text-right">
                <?php echo anchor(site_url('thing_types/create'), 'Create', 'class="btn btn-primary"'); ?>
	    </div>
        </div>
        <table class="table table-bordered table-striped" id="mytable">
            <thead>
                <tr>
                    <th>No</th>
		    <th>title</th>
		    <th>icon</th>
		    <th>Action</th>
                </tr>
            </thead>
	    <tbody>
            <?php
            $start = 0;
            foreach ($thing_types_data as $thing_types)
            {
                ?>
                <tr>
		    <td><?php echo ++$start ?></td>
		    <td><?php echo $thing_types->tty_title ?></td>
		    <td>
                        <?php if($thing_types->tty_icon) :?>
                        <img src="<?php echo base_url('uploads/'.$thing_types->tty_icon) ?>" width="32" />
                        <?php endif;?>
                    </td>
		    <td style="text-align:center">
			<?php 
			echo anchor(site_url('thing_types/read/'.$thing_types->tty_id),'Read'); 
			echo ' | '; 
			echo anchor(site_url('thing_types/update/'.$thing_types->tty_id),'Update'); 
			echo ' | '; 
			echo anchor(site_url('thing_types/delete/'.$thing_types->tty_id),'Delete','onclick="javasciprt: return confirm(\'Are You Sure ?\')"'); 
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