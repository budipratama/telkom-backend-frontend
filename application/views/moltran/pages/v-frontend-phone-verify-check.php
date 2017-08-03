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
                                        <h3 class="panel-title">Data Verifikasi Nomor HP</h3>
                                    </div>
                                    <div class="panel-body">
                                        <div class="form">
                                        	<div class="clearfix">&nbsp;</div>

											<?php $this->load->view($params['base_widget'] . 'v-widget-alert'); ?>

                                        	<div class="clearfix">&nbsp;</div>

                                        	<?php
                                        		if ($phone_verify->num_rows() > 0) :
                                        	?>
	                                            <div class="row">
		                                            <div class="col-md-12 col-sm-12 col-xs-12">
		                                                <table id="datatable" class="table table-striped table-bordered">
		                                                    <thead>
		                                                        <tr>
		                                                            <th><small>No</small></th>
		                                                            <th><small>ID Akun</small></th>
		                                                            <th><small>Nomor HP</small></th>
		                                                            <th><small>Approval</small></th>
		                                                            <th><small>Aktivasi</small></th>
		                                                            <th><small>OTP</small></th>
		                                                            <th><small>Retry</small></th>
		                                                            <th><small>Waktu Request</small></th>
		                                                            <th><small>Aksi</small></th>
		                                                        </tr>
		                                                    </thead>
		                                                    <tbody>
		                                                    <?php
		                                                    	$no 					= 1;

		                                                    	foreach($phone_verify->result() as $data)
		                                                    	{
		                                                    		$phone 				= substr($data->PHONE_NUMBER, 0, 3) . ' ' . substr($data->PHONE_NUMBER, 3, 3) . ' ' .
						                                                    	substr($data->PHONE_NUMBER, 6, 4) . ' ' . substr($data->PHONE_NUMBER, 10, 4) . ' ' .
						                                                    	substr($data->PHONE_NUMBER, 14);
		                                                    ?>
		                                                        <tr>
		                                                            <td><small><?php echo $no; ?></small></td>
																	<td><small style="font-weight: bold;"><?php echo @ splitter_vars($data->CUSTOMER_CODE); ?></small></td>
																	<td><small><?php echo trim($phone); ?></small></td>
																	<td><small><?php echo ($data->APPROVED == 1) ? '<span class="label label-success">Sudah di-approve</span>' : '<span class="label label-danger">Belum di-approve</span>'; ?></small></td>
																	<td><small><?php echo ($data->USED == 1) ? '<span class="label label-success">Aktif</span>' : '<span class="label label-danger">Tidak Aktif</span>'; ?></small></td>
																	<td><small><?php echo ($data->DELIVERED == 1) ? '<span class="label label-success">Terkirim</span>' : '<span class="label label-danger">Belum Terkirim</span>'; ?></small></td>
																	<td style="text-align: center;"><small><?php echo ($data->TOTAL_RETRY == 0) ? '-' : $data->TOTAL_RETRY; ?></small></td>
																	<td><small><?php echo @ formatter_date($data->REQUEST_TIMESTAMP); ?></small></td>
																	<td>
																		<a data-toggle="modal" data-target="#detail-<?php echo $data->ID; ?>" style="cursor: pointer;">
																			<i class="md-view-list"></i> <small>Detail</small>
																		</a>
																		&nbsp;&nbsp;
																		<?php
																			if($data->TOTAL_RETRY < 3 && $data->APPROVED == 1) :
																		?>
																			<a href="<?php echo site_url('frontend/authorize/phone-send-otp/' . $data->ID); ?>">
																				<i class="md md-send"></i> <small>Kirim OTP</small>
																			</a>
																		<?php
																			elseif($data->APPROVED == 0) :
																		?>
																			<a class="autoclose-forbidden" style="cursor: pointer;">
																				<i class="md md-send"></i> <small>Kirim OTP</small>
																			</a>
																		<?php
																			else :
																		?>
																			<a class="autoclose-limit" style="cursor: pointer;">
																				<i class="md md-send"></i> <small>Kirim OTP</small>
																			</a>
																		<?php
																			endif;
																		?>
																		<form enctype="multipart/form-data" name="frmApprovePhone" action="<?php echo site_url('frontend/authorize/phone-verify-otp'); ?>" method="post">
																			<div id="detail-<?php echo $data->ID; ?>" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
									                                            <div class="modal-dialog" style="width: 55%;">
									                                                <div class="modal-content">
									                                                    <div class="modal-header">
									                                                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">x</button>
									                                                        <h4 class="modal-title" id="myModalLabel"><small><strong>Detail Data Verifikasi Nomor HP</strong></small></h4>
									                                                    </div>
									                                                    <div class="modal-body">
									                                                        <table width="100%" border="0" cellpadding="5" cellspacing="0">
											                                                    <tr>
										                                                            <td width="25%" style="padding-bottom: 10px;"><small>ID Akun</small></td>
										                                                            <td width="75%" style="padding-bottom: 10px;"><small><strong><?php echo @ splitter_vars($data->CUSTOMER_CODE); ?></strong></small></td>
										                                                        </tr>
											                                                    <tr>
										                                                            <td style="padding-bottom: 10px;"><small>Nama Lengkap</small></td>
										                                                            <td style="padding-bottom: 10px;"><small><?php echo $data->CUSTOMER_NAME; ?></small></td>
										                                                        </tr>
											                                                    <tr>
										                                                            <td style="padding-bottom: 10px;"><small>Nomor HP</small></td>
										                                                            <td style="padding-bottom: 10px;"><small><?php echo trim($phone); ?></small></td>
										                                                        </tr>
											                                                    <tr>
										                                                            <td style="padding-bottom: 10px;"><small>Status Approval</small></td>
										                                                            <td style="padding-bottom: 10px;"><small><?php echo ($data->APPROVED == 1) ? '<span class="label label-success">Sudah di-approve</span>' : '<span class="label label-danger">Belum di-approve</span>'; ?></small></td>
										                                                        </tr>
										                                                        <?php
										                                                        	if($data->APPROVED == 1) :
										                                                        ?>
											                                                    <tr>
										                                                            <td style="padding-bottom: 10px;"><small>Di-approve oleh</small></td>
										                                                            <td style="padding-bottom: 10px;"><small><?php echo ($data->APPROVED == 1) ? $data->APPROVED_BY : '-'; ?></small></td>
										                                                        </tr>
										                                                        <?php
										                                                        	endif;
										                                                        ?>
											                                                    <tr>
										                                                            <td style="padding-bottom: 10px;"><small>Status Aktivasi</small></td>
										                                                            <td style="padding-bottom: 10px;"><small><?php echo ($data->USED == 1) ? '<span class="label label-success">Aktif</span>' : '<span class="label label-danger">Tidak Aktif</span>'; ?></small></td>
										                                                        </tr>
										                                                        <?php
										                                                        	if($data->APPROVED == 1) :
										                                                        ?>
											                                                    <tr>
										                                                            <td style="padding-bottom: 10px;"><small>Status OTP</small></td>
										                                                            <td style="padding-bottom: 10px;"><small><?php echo ($data->DELIVERED == 1) ? '<span class="label label-success">Terkirim</span>' : '<span class="label label-danger">Belum Terkirim</span>'; ?></small></td>
										                                                        </tr>
											                                                    <tr>
										                                                            <td style="padding-bottom: 10px;"><small>Kode OTP</small></td>
										                                                            <td style="padding-bottom: 10px;"><small><strong><?php echo ($data->OTP_CODE == '') ? '-' : 'xxx-x' . substr($data->OTP_CODE, 4, 2); ?></strong></small></td>
										                                                        </tr>
											                                                    <tr>
										                                                            <td style="padding-bottom: 10px;"><small>Retry</small></td>
										                                                            <td style="padding-bottom: 10px;"><small><?php echo ($data->TOTAL_RETRY == 0) ? '-' : $data->TOTAL_RETRY . ' kali'; ?></small></td>
										                                                        </tr>
										                                                        <?php
										                                                        	endif;
										                                                        ?>
											                                                    <tr>
										                                                            <td style="padding-bottom: 10px;"><small>Waktu Request</small></td>
										                                                            <td style="padding-bottom: 10px;"><small><?php echo @ formatter_date($data->REQUEST_TIMESTAMP); ?></small></td>
										                                                        </tr>
										                                                        <?php
										                                                        	if($data->APPROVED == 1) :
										                                                        ?>
											                                                    <tr>
										                                                            <td style="padding-bottom: 10px;"><small>Waktu Approval</small></td>
										                                                            <td style="padding-bottom: 10px;"><small><?php echo @ formatter_date($data->APPROVED_TIMESTAMP); ?></small></td>
										                                                        </tr>
										                                                        <?php
										                                                        	endif;
										                                                        ?>
											                                              	</table>
											                                              	<?php
											                                              		if($data->APPROVED == '0') :
											                                              	?>
																							<hr />
																							<table width="100%" border="0" cellpadding="5" cellspacing="0">
											                                                    <tr>
										                                                            <td width="25%" style="padding-bottom: 10px;"><small>Dokumen Karpeg <span style="color: red;">*</span></small></td>
										                                                            <td width="75%" style="padding-bottom: 10px;"><small><input required="required" autocomplete="off" placeholder="" type="file" id="docKarpeg" name="docKarpeg" size="20" /></small></td>
										                                                        </tr>
											                                                    <tr>
										                                                            <td style="padding-bottom: 10px;"><small>Dokumen KTP <span style="color: red;">*</span></small></td>
										                                                            <td style="padding-bottom: 10px;"><small><input required="required" autocomplete="off" placeholder="" type="file" id="docKTP" name="docKTP" size="20" /></small></td>
										                                                        </tr>
										                                                   	</table>
											                                              	<div style="clear: both;">&nbsp;</div>
										                                                   	<small><span style="color: red;">*</span> <em>Harus dilengkapi</em></small>
											                                              	<?php
											                                              		endif;
											                                              	?>
											                                              	<?php
												                                              	$retry_no 			= 1;
												                                              	$ivana 				= $this->load->database('ivana', TRUE);

												                                              	$retry_exec 		= $ivana->select('SMS_GATEWAY, SMS_ID, RESULT_CODE, RETRY_BY, RETRY_TIMESTAMP')
												                                              					->from(TBL_IV_PHONE_VERIFY_RETRY)
												                                              					->where('VPN_ID', $data->ID)
												                                              					->order_by('ID', 'ASC')
												                                              				->get();

												                                              	if($retry_exec->num_rows() > 0) :
											                                              	?>
											                                              	<div style="clear: both;">&nbsp;</div>
											                                              	<h4 style="text-align: center;"><small><strong>Pengulangan Kirim Kode OTP</strong></small></h4>
											                                              	<div style="clear: both;">&nbsp;</div>
											                                              	<table class="table table-bordered">
											                                                    <thead>
											                                                        <tr>
											                                                            <th width="5%"><small>No</small></th>
											                                                            <th width="15%"><small>Gateway</small></th>
											                                                            <th width="20%"><small>ID SMS</small></th>
											                                                            <th width="15%"><small>Status</small></th>
											                                                            <th width="20%"><small>Diulang oleh</small></th>
											                                                            <th width="25%"><small>Waktu</small></th>
											                                                        </tr>
											                                                    </thead>
											                                                    <tbody>
											                                                    	<?php
											                                                    		foreach ($retry_exec->result() as $retry_data) :
											                                                    			$result_code 		= '';
											                                                    			$sms_gateway		= '';

											                                                    			if($retry_data->SMS_GATEWAY == 1) :
											                                                    				$result_code 	= ($retry_data->RESULT_CODE == 1) ? 'Terkirim' : '-';
											                                                    				$sms_gateway 	= '<span class="label label-purple">mainapi</span>';
											                                                    			elseif($retry_data->SMS_GATEWAY == 2) :
											                                                    				$result_code 	= ($retry_data->RESULT_CODE == 10) ? 'Terkirim' : '-';
											                                                    				$sms_gateway 	= '<span class="label label-pink">raja-sms</span>';
											                                                    			elseif($retry_data->SMS_GATEWAY == 3) :
											                                                    				$result_code 	= ($retry_data->RESULT_CODE == 0) ? 'Terkirim' : '-';
											                                                    				$sms_gateway 	= '<span class="label label-danger">zenziva</span>';
											                                                    			endif;
											                                                    	?>
											                                                        <tr>
											                                                            <td><small><?php echo $retry_no; ?></small></td>
											                                                            <td><small><?php echo $sms_gateway; ?></small></td>
											                                                            <td><small><?php echo ($retry_data->SMS_ID != '') ? @ splitter_vars($retry_data->SMS_ID) : '-'; ?></small></td>
											                                                            <td><small><span class="label label-info"><?php echo $result_code; ?></span></small></td>
											                                                            <td><small><?php echo $retry_data->RETRY_BY; ?></small></td>
											                                                            <td><small><?php echo @ formatter_date($retry_data->RETRY_TIMESTAMP); ?></small></td>
											                                                        </tr>
											                                                        <?php
											                                                        		$retry_no++;
											                                                        	endforeach;
											                                                        ?>
											                                                    </tbody>
											                                                </table>
											                                                <?php
											                                                	endif;
											                                                ?>
									                                                        <?php
									                                                        	if(($data->DOC_KARPEG != '' && $data->DOC_KTP != '') && $data->APPROVED == 1) :
									                                                        ?>
											                                              	<div style="clear: both;">&nbsp;</div>
											                                              	<h4 style="text-align: center;"><small><strong>Kelengkapan Dokumen Approval</strong></small></h4>
											                                              	<div style="clear: both;">&nbsp;</div>
											                                              	<table class="table table-bordered">
											                                                    <thead>
											                                                        <tr>
											                                                            <th width="5%"><small>No</small></th>
											                                                            <th width="25%"><small>Tipe Dokumen</small></th>
											                                                            <!-- <th width="40%"><small>Nama Dokumen</small></th> -->
											                                                            <th width="40%"><small>Screenshot</small></th>
											                                                            <th width="30%"><small>Waktu</small></th>
											                                                        </tr>
											                                                    </thead>
											                                                    <tbody>
											                                                        <tr>
											                                                            <td><small>1</small></td>
											                                                            <td><small><span class="label label-pink">Kartu Pegawai</span></small></td>
											                                                            <!-- <td><small><?php echo $data->DOC_KARPEG; ?></small></td> -->
											                                                            <td>
											                                                            	<div class="col-sm-12 graphicdesign photography">
																			                                    <div class="gal-detail">
																			                                        <a href="<?php echo base_url(); ?>uploads/<?php echo $data->DOC_KARPEG; ?>" class="image-popup" title="<?php echo $data->DOC_KARPEG; ?>">
											                                                            				<img style="border: dashed 1px #CDCDCD;" src="<?php echo base_url(); ?>uploads/<?php echo $data->DOC_KARPEG; ?>" width="100%" />
											                                                            			</a>
											                                                            		</div>
											                                                            	</div>
																										</td>
											                                                            <td><small><?php echo @ formatter_date($data->APPROVED_TIMESTAMP); ?></small></td>
											                                                        </tr>
											                                                        <tr>
											                                                            <td><small>2</small></td>
											                                                            <td><small><span class="label label-purple">KTP</span></small></td>
											                                                            <!-- <td><small><?php echo $data->DOC_KTP; ?></small></td> -->
											                                                            <td>
																											<div class="col-sm-12 graphicdesign photography">
																			                                    <div class="gal-detail">
																			                                        <a href="<?php echo base_url(); ?>uploads/<?php echo $data->DOC_KTP; ?>" class="image-popup" title="<?php echo $data->DOC_KTP; ?>">
											                                                            				<img style="border: dashed 1px #CDCDCD;" src="<?php echo base_url(); ?>uploads/<?php echo $data->DOC_KTP; ?>" width="100%" />
											                                                            			</a>
											                                                            		</div>
											                                                            	</div>
																										</td>
											                                                            <td><small><?php echo @ formatter_date($data->APPROVED_TIMESTAMP); ?></small></td>
											                                                        </tr>
											                                                    </tbody>
											                                                </table>
											                                              	<?php
																								endif;
											                                              	?>
									                                                    </div>
									                                                    <div class="modal-footer">
									                                                    	<br />
								                                                    		<input type="hidden" name="customerCode" value="<?php echo $data->CUSTOMER_CODE; ?>" />
								                                                    		<input type="hidden" name="phoneNumber" value="<?php echo $data->PHONE_NUMBER; ?>" />
								                                                    		<?php
								                                                    			if($data->APPROVED == '0') :
								                                                    		?>
								                                                        		<button type="submit" class="btn btn-danger waves-effect waves-light">Approve</button>
								                                                        	<?php
								                                                        		endif;
								                                                        	?>
								                                                        	<button type="button" class="btn btn-inverse waves-effect waves-light" data-dismiss="modal">Tutup Dialog</button>
									                                                    </div>
									                                                </div><!-- /.modal-content -->
									                                            </div><!-- /.modal-dialog -->
									                                        </div>
			                                                  			</form>
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
					$retry_exec->free_result();
                	$phone_verify->free_result();
                	$this->load->view($params['base_comp'] . 'v-frontend-footer');
                ?>

            </div>
            <!-- ============================================================== -->
            <!-- End Right content here -->
            <!-- ============================================================== -->