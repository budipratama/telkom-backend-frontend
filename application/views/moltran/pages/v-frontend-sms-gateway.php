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
                                        <h3 class="panel-title">Data SMS Gateway</h3>
                                    </div>
                                    <div class="panel-body">
                                        <div class="form">
                                        	<div class="wizard">
                                        		<div class="clearfix">
                                        			<a href="<?php echo site_url('frontend/setting/sms-gateway/edit-hp'); ?>">
                                        				<button class="btn btn-danger waves-effect waves-light"><i class="md md-mode-edit"></i> <span>Edit Nomor HP Testing</span></button>
                                        			</a>
												</div>
                                        	</div>
                                        	<div class="clearfix">&nbsp;</div>

											<?php $this->load->view($params['base_widget'] . 'v-widget-alert'); ?>

                                        	<div class="clearfix">&nbsp;</div>

                                        	<?php
                                        		if ($sms_gateway->num_rows() > 0) :
                                        	?>
	                                            <div class="row">
		                                            <div class="col-md-12 col-sm-12 col-xs-12">
		                                                <table id="datatable" class="table table-striped table-bordered">
		                                                    <thead>
		                                                        <tr>
		                                                            <th><small>No</small></th>
		                                                            <th><small>Nama Gateway</small></th>
		                                                            <th><small>Kode Gateway</small></th>
		                                                            <th><small>Sisa Deposit</small></th>
		                                                            <th><small>Status</small></th>
		                                                            <th><small>Waktu Create</small></th>
		                                                            <th><small>Aksi</small></th>
		                                                        </tr>
		                                                    </thead>
		                                                    <tbody>
		                                                    <?php
		                                                    	$no 					= 1;

		                                                    	foreach($sms_gateway->result() as $data)
		                                                    	{
		                                                    		$label				= '';
		                                                    		$deposit 			= 0;
		                                                    		$divide 			= 0;
		                                                    		$unit 				= '';

		                                                    		if($data->GATEWAY_CODE == 'mainapi') :
		                                                    			$label 			= 'label-purple';
		                                                    			$deposit 		= formatter_currency($data->DEPOSIT_BALANCE);
		                                                    			$divide 		= floor($data->DEPOSIT_BALANCE / 295);
		                                                    			$unit 			= 'IDR (Rupiah)';
		                                                    		elseif($data->GATEWAY_CODE == 'raja-sms') :
		                                                    			$label 			= 'label-pink';
		                                                    			$deposit 		= formatter_currency($data->DEPOSIT_BALANCE);
		                                                    			$divide 		= floor($data->DEPOSIT_BALANCE / 120);
		                                                    			# $divide 		= $data->DEPOSIT_BALANCE / 1;
		                                                    			$unit 			= 'IDR (Rupiah)';
		                                                    		elseif($data->GATEWAY_CODE == 'zenziva') :
		                                                    			$label 			= 'label-danger';
		                                                    			$deposit 		= number_format($data->DEPOSIT_BALANCE, 0, ',', '.');
		                                                    			$divide 		= $data->DEPOSIT_BALANCE / 1;
		                                                    			$unit 			= 'SMS';
		                                                    		endif;
		                                                    ?>
		                                                        <tr>
		                                                            <td><small><?php echo $no; ?></small></td>
																	<td><small style="font-weight: bold;"><?php echo $data->GATEWAY_NAME; ?></small></td>
																	<td><small><span class="label <?php echo $label; ?>"><?php echo $data->GATEWAY_CODE; ?></span></small></td>
																	<td><small><?php echo '<strong>' . $deposit . '</strong> <em>(' . $divide . ' SMS)</em>'; ?></small></td>
																	<td><small><?php echo ($data->SET_AS_MAIN == 1) ? '<span class="label label-success">Aktif</span>' : '<span class="label label-inverse">Tidak Aktif</span>'; ?></small></td>
																	<td><small><?php echo @ formatter_date($data->CREATED_ON); ?></small></td>
																	<td>
																		<?php
																			if($data->SET_AS_MAIN == 0 && $divide > 50) :
																		?>
																		<!-- <small><span class="label label-info">SMS Gateway Aktif</span></small> -->
																		<?php
																			# else :
																		?>
																		<a href="<?php echo site_url('frontend/setting/sms-gateway/activate/' . $data->GATEWAY_CODE)?>">
																			<i class="ion-arrow-up-a"></i> <small>Aktifkan</small>
																		</a>
																		&nbsp;
																		<?php
																			elseif($data->SET_AS_MAIN == 0 && $divide <= 50) :
																		?>
																		<a class="autoclose-sms-deposit" style="cursor: pointer;">
																			<i class="ion-arrow-up-a"></i> <small>Aktifkan</small>
																		</a>
																		&nbsp;
																		<?php
																			endif;
																		?>
																		<?php
																			if($divide > 0) :
																		?>
																		<a href="<?php echo site_url('frontend/setting/sms-gateway/send-test/' . $data->GATEWAY_CODE)?>">
																			<i class="md md-message"></i> <small>Tes SMS</small>
																		</a>
																		&nbsp;
																		<?php
																			else :
																		?>
																		<a class="autoclose-sms-test" style="cursor: pointer;">
																			<i class="md md-message"></i> <small>Tes SMS</small>
																		</a>
																		&nbsp;
																		<?php
																			endif;
																		?>
																		<a data-toggle="modal" data-target="#detail-<?php echo $data->GATEWAY_CODE; ?>" style="cursor: pointer;">
																			<i class="md md-account-balance-wallet"></i> <small>Topup Deposit</small>
																		</a>
																		<div id="detail-<?php echo $data->GATEWAY_CODE; ?>" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
								                                            <div class="modal-dialog">
								                                                <div class="modal-content">
								                                                    <div class="modal-header">
								                                                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">x</button>
								                                                        <h4 class="modal-title" id="myModalLabel"><small><strong>Topup Deposit SMS Gateway</strong></small></h4>
								                                                    </div>
								                                                    <div class="modal-body">
								                                                        <table width="100%" border="0" cellpadding="5" cellspacing="0">
										                                                    <tr>
									                                                            <td width="25%" style="padding-bottom: 10px;"><small>Nama Gateway</small></td>
									                                                            <td width="75%" style="padding-bottom: 10px;"><small><strong><?php echo $data->GATEWAY_NAME; ?></strong></small></td>
									                                                        </tr>
										                                                    <tr>
									                                                            <td style="padding-bottom: 10px;"><small>Kode Gateway</small></td>
									                                                            <td style="padding-bottom: 10px;"><small><?php echo $data->GATEWAY_CODE; ?></small></td>
									                                                        </tr>
										                                                    <tr>
									                                                            <td style="padding-bottom: 10px;"><small>Sisa Deposit</small></td>
									                                                            <td style="padding-bottom: 10px;"><small><?php echo '<strong>' . $deposit . '</strong> <em>(' . $divide . ' SMS)</em>'; ?></small></td>
									                                                        </tr>
									                                                        <tr>
									                                                        	<td colspan="2">&nbsp;</td>
									                                                        </tr>
										                                                    <tr>
									                                                            <td style="padding-bottom: 10px;"><small>Satuan</small></td>
									                                                            <td style="padding-bottom: 10px;"><small><?php echo $unit; ?></small></td>
									                                                        </tr>
										                                                    <tr>
									                                                            <td style="padding-bottom: 10px;"><small>Tambah Deposit</small></td>
									                                                            <td style="padding-bottom: 10px;">
                                                    												<div class="row">
											                                                            <div class="col-md-12">
											                                                                <div class="form-group">
											                                                                    <input type="text" class="form-control" style="width: 190%;" id="newDeposit" name="newDeposit" placeholder="Masukkan deposit dalam <?php echo $unit; ?>" />
											                                                                </div>
											                                                            </div>
											                                                        </div>
																								</td>
									                                                        </tr>
										                                              	</table>
								                                                    </div>
								                                                    <div class="modal-footer">
								                                                    	<br />
								                                                    	<form name="frmApprovePhone" action="<?php echo site_url('frontend/authorize/phone-verify-otp'); ?>" method="post">
								                                                        		<button type="submit" class="btn btn-danger waves-effect waves-light">Approve</button>
								                                                        	<button type="button" class="btn btn-inverse waves-effect waves-light" data-dismiss="modal">Tutup Dialog</button>
								                                                        </form>
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
                	$sms_gateway->free_result();
                	$this->load->view($params['base_comp'] . 'v-frontend-footer');
                ?>

            </div>
            <!-- ============================================================== -->
            <!-- End Right content here -->
            <!-- ============================================================== -->