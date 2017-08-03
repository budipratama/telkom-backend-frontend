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
                                        <h3 class="panel-title">Aktivitas Akun T-MONEY</h3>
                                    </div>
                                    <div class="panel-body">
                                        <div class="form">
                                        	<div class="wizard">
                                        		<div class="steps clearfix">
                                        			<ul role="tablist">
                                        				<li class="first disabled" role="tab">
                                        					<a>
	                                        					<span class="number">1.</span> Tahap Pencarian
	                                        				</a>
                                        				</li>
                                        				<li class="current" role="tab">
                                        					<a>
                                        						<span class="number">2.</span> Tahap Penyajian
                                        					</a>
                                        				</li>
													</ul>
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
		                                                            <th><small>ID T-MONEY</small></th>
		                                                            <!-- <th><small>Aktivitas</small></th> -->
		                                                            <th><small>ID Session</small></th>
		                                                            <th><small>Alamat IP</small></th>
		                                                            <th><small>OS</small></th>
		                                                            <th><small>Browser</small></th>
		                                                            <th><small>Waktu</small></th>
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
		                                                            <td><small><strong><?php echo @ splitter_vars($data->CUSTOMER_CODE); ?></strong></small></td>
																	<!-- <td><small><?php echo '1 Activity Cycle'; # $data->REF_ID; ?></small></td> -->
																	<td><small><?php echo @ splitter_vars($data->SESSION_ID); ?></small></td>
																	<td><small><?php echo $data->IP_ADDRESS; ?></small></td>
																	<td><small><?php echo $data->UA_PLATFORM; ?></small></td>
																	<td><small><?php echo $data->UA_DEVICE; ?></small></td>
																	<td><small><?php echo @ formatter_date($data->TIMESTAMP); ?></small></td>
																	<td>
																		<a data-toggle="modal" data-target="#activity-<?php echo $data->SESSION_ID; ?>" style="cursor: pointer;">
																			<i class="md-view-list"></i> <small>Detail</small>
																		</a>
																		<div id="activity-<?php echo $data->SESSION_ID; ?>" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
								                                            <div class="modal-dialog modal-full">
								                                                <div class="modal-content">
								                                                    <div class="modal-header">
								                                                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">x</button>
								                                                        <h4 class="modal-title" id="myModalLabel"><small><strong>Detail Aktivitas Akun</strong></small></h4>
								                                                    </div>
								                                                    <div class="modal-body">
								                                                        <table id="datatable" class="table table-striped table-bordered">
										                                                    <thead>
										                                                        <tr>
										                                                            <th width="5%"><small>No</small></th>
										                                                            <th width="15%"><small>Grup</small></th>
										                                                            <th width="18%"><small>Aktivitas</small></th>
										                                                            <th width="9%"><small>Latitude</small></th>
										                                                            <th width="9%"><small>Longitude</small></th>
										                                                            <th width="44%"><small>Parameter</small></th>
										                                                        </tr>
										                                                    </thead>
										                                                    <tbody>
										                                                    <?php
										                                                    	$ivana 				= $this->load->database('ivana', TRUE);

										                                                    	$rec 				= 1;

										                                                    	$detail_query 		= 'SELECT * FROM `' . TBL_IV_ALL_ACTIVITY . '` WHERE `SESSION_ID` = "' . $data->SESSION_ID . '" ORDER BY `AC_ID` ASC';
										                                                    	$detail_exec 		= $ivana->query($detail_query);

										                                                    	foreach($detail_exec->result() as $detail_data)
										                                                    	{
										                                                    ?>
										                                                        <tr>
										                                                            <td><small><?php echo $rec; ?></small></td>
										                                                            <td><small><?php echo $detail_data->GROUP_ID; ?></small></td>
																									<td><small><?php echo $detail_data->REF_ID; ?></small></td>
																									<td><small><?php echo $detail_data->LATITUDE; ?></small></td>
																									<td><small><?php echo $detail_data->LONGITUDE; ?></small></td>
																									<td><small><?php echo $detail_data->PARAMETERS; ?></small></td>
										                                                        </tr>
										                                                   	<?php
										                                                   			$rec++;
										                                                    	}
										                                                   	?>

										                                                    </tbody>
										                                              	</table>
								                                                    </div>
								                                                    <div class="modal-footer">
								                                                    	<br />
								                                                        <button type="button" class="btn btn-danger waves-effect waves-light" data-dismiss="modal">Tutup Dialog</button>
								                                                    </div>
								                                                </div><!-- /.modal-content -->
								                                            </div><!-- /.modal-dialog -->
								                                        </div>
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