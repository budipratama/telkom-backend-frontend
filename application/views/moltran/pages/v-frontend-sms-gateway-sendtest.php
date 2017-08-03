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
                                        <h3 class="panel-title">Data Tes Kirim SMS Gateway</h3>
                                    </div>
                                    <div class="panel-body">
                                        <div class="form">
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
		                                                            <th><small>Kode Gateway</small></th>
		                                                            <th><small>Jenis SMS</small></th>
		                                                            <th><small>Nomor HP</small></th>
		                                                            <th><small>Status</small></th>
		                                                            <th><small>Dikirim oleh</small></th>
		                                                            <th><small>Waktu</small></th>
		                                                        </tr>
		                                                    </thead>
		                                                    <tbody>
		                                                    <?php
		                                                    	$no 					= 1;

		                                                    	foreach($sms_gateway->result() as $data)
		                                                    	{
		                                                    		$label				= '';
											                        $result_code 		= '';

		                                                    		if($data->GATEWAY_CODE == 'mainapi') :
		                                                    			$label 			= 'label-purple';
											                            $result_code 	= ($data->RESULT_CODE == 1) ? '<span class="label label-success">Sukses</span>' : '<span class="label label-danger">Gagal</span>';
		                                                    		elseif($data->GATEWAY_CODE == 'raja-sms') :
		                                                    			$label 			= 'label-pink';
											                            $result_code 	= ($data->RESULT_CODE == 10) ? '<span class="label label-success">Sukses</span>' : '<span class="label label-danger">Gagal</span>';
		                                                    		elseif($data->GATEWAY_CODE == 'zenziva') :
		                                                    			$label 			= 'label-danger';
											                            $result_code 	= ($data->RESULT_CODE == 0) ? '<span class="label label-success">Sukses</span>' : '<span class="label label-danger">Gagal</span>';
		                                                    		endif;
		                                                    ?>
		                                                        <tr>
		                                                            <td><small><?php echo $no; ?></small></td>
																	<td><small><span class="label <?php echo $label; ?>"><?php echo $data->GATEWAY_CODE; ?></span></small></td>
																	<td><small><em>Testing SMS Gateway</em></small></td>
																	<td><small><?php echo @ splitter_vars($data->PHONE_NUMBER); ?></small></td>
																	<td><small><?php echo $result_code; ?></small></td>
																	<td><small><span class="label label-inverse"><?php echo $data->DELIVERED_BY; ?></span></small></td>
																	<td><small><?php echo @ formatter_date($data->DELIVERED_TIMESTAMP); ?></small></td>
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