			<!-- ============================================================== -->
            <!-- Start right Content here -->
            <!-- ============================================================== -->
            <div class="content-page">
                <!-- Start content -->
                <div class="content">
                    <div class="container">

                        <!-- Wizard with Validation -->
                        <div class="row">
                            <div class="col-md-12">
                                <div class="panel panel-default">
                                    <div class="panel-heading">
                                        <h3 class="panel-title">Data User Aplikasi Simple Dashboard T-MONEY</h3>
                                    </div>
                                    <div class="panel-body">
                                        <div class="form">
                                        	<div class="wizard">
                                        		<div class="clearfix">
                                        			<a href="<?php echo site_url('frontend/reporting/user/add'); ?>">
                                        				<button class="btn btn-danger waves-effect waves-light"><i class="md md-add"></i> <span>Tambah User</span></button>
                                        			</a>
												</div>
                                        	</div>
                                        	<div class="clearfix">&nbsp;</div>

											<?php $this->load->view($params['base_widget'] . 'v-widget-alert'); ?>

                                        	<div class="clearfix">&nbsp;</div>

                                        	<?php
                                        		if ($query->num_rows() > 0) :
                                        	?>
	                                            <div class="row">
		                                            <div class="col-md-12 col-sm-12 col-xs-12">
		                                                <table id="datatable" class="table table-striped table-bordered">
		                                                    <thead>
		                                                        <tr>
		                                                            <th><small>No</small></th>
		                                                            <th><small>Nama Lengkap</small></th>
		                                                            <th><small>User ID</small></th>
		                                                            <th><small>Alamat Email</small></th>
		                                                            <!-- <th><small>Nomor HP</small></th> -->
		                                                            <th><small>Status</small></th>
		                                                            <th><small>Level</small></th>
		                                                            <th><small>Waktu Create</small></th>
		                                                            <th><small>Aksi</small></th>
		                                                        </tr>
		                                                    </thead>
		                                                    <tbody>
		                                                    <?php
		                                                    	$no 		= 1;

		                                                    	foreach($query->result() as $data)
		                                                    	{
		                                                    ?>
		                                                        <tr>
		                                                            <td><small><?php echo $no; ?></small></td>
		                                                            <td><small><strong><?php echo $data->AUTH_FULL_NAME; ?></strong></small></td>
		                                                            <td><small><span class="label label-purple"><?php echo $data->AUTH_USER_ID; ?></span></small></td>
																	<td><small><?php echo $data->EMAIL_ADDRESS; ?></small></td>
																	<!-- <td><small><?php echo @ splitter_vars($data->PHONE_NUMBER); ?></small></td> -->
																	<td><small><?php echo ($data->STATUS == 1) ? '<span class="label label-success">Aktif</span>' : '<span class="label label-danger">Tidak Aktif</span>'; ?></small></td>
																	<td><small><?php echo $data->LEVEL_NAME; ?></small></td>
																	<td><small><?php echo @ formatter_date($data->CREATED_ON); ?></small></td>
																	<td>
																		<?php
																			if($data->STATUS == 1) :
																		?>
																		<a href="<?php echo site_url('frontend/reporting/user/deactivate/' . $data->AUTH_USER_ID)?>">
																			<i class="ion-arrow-down-a"></i> <small>Non Aktifkan</small>
																		</a>
																		<?php
																			else :
																		?>
																		<a href="<?php echo site_url('frontend/reporting/user/activate/' . $data->AUTH_USER_ID)?>">
																			<i class="ion-arrow-up-a"></i> <small>Aktifkan</small>
																		</a>
																		<?php
																			endif;
																		?>
																	</td>
		                                                        </tr>
		                                                   	<?php
		                                                   			$no++;
		                                                    	}
		                                                   	?>

		                                                    </tbody>
		                                              	</table>
		                                          	</div>
		                                       	</div>
		                                   	<?php
		                                   		else :
		                                   	?>
												<div class="row">
		                                            <div class="col-md-12 col-sm-12 col-xs-12">
		                                                Tidak ada data dengan kata kunci tersebut. Silakan coba dengan kata kunci yang lain.<br />
		                                                <div style="clear: both;">&nbsp;</div>
		                                          	</div>
		                                       	</div>
		                                   	<?php
		                                   		endif;
		                                   	?>
                                        </div> <!-- .form -->
                                    </div> <!-- panel-body -->
                                </div> <!-- End panel -->

                            </div> <!-- end col -->

                        </div> <!-- End row -->

                    </div> <!-- container -->

                </div> <!-- content -->

                <?php
                	$query->free_result();
                	$this->load->view($params['base_comp'] . 'v-frontend-footer');
                ?>

            </div>
            <!-- ============================================================== -->
            <!-- End Right content here -->
            <!-- ============================================================== -->