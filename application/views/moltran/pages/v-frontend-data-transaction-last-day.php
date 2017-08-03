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
                                        <h3 class="panel-title">Data Transaksi T-MONEY Hari Ini</h3>
                                    </div>
                                    <div class="panel-body">
                                        <div class="form">
                                        	<div class="clearfix">&nbsp;</div>

											<?php $this->load->view($params['base_widget'] . 'v-widget-alert'); ?>

                                        	<div class="clearfix">&nbsp;</div>

                                        	<?php
                                        		if ($last_day->num_rows() > 0) :
                                        	?>
	                                            <div class="row">
		                                            <div class="col-md-12 col-sm-12 col-xs-12">
		                                                <table id="datatable" class="table table-striped table-bordered">
		                                                    <thead>
		                                                        <tr>
		                                                            <th><small>No</small></th>
		                                                            <th><small>ID Akun</small></th>
		                                                            <th><small>ID Transaksi</small></th>
		                                                            <th><small>Tipe Transaksi</small></th>
		                                                            <th><small>Nominal</small></th>
																	<th><small>Tahapan</small></th>
		                                                            <th><small>RC Fusion</small></th>
		                                                            <th><small>RC Finnet</small></th>
		                                                            <th><small>Kode Produk</small></th>
		                                                            <th><small>No Invoice</small></th>
		                                                            <th><small>Nama Invoice</small></th>
		                                                            <th><small>Akun Sumber</small></th>
		                                                            <th><small>Akun Tujuan</small></th>
		                                                            <th><small>Waktu</small></th>
		                                                        </tr>
		                                                    </thead>
		                                                    <tbody>
		                                                    <?php
		                                                    	$no 		= 1;

		                                                    	foreach($last_day->result() as $data)
		                                                    	{
		                                                    ?>
		                                                        <tr>
		                                                            <td><small><?php echo $no; ?></small></td>
		                                                            <td><small><?php echo @ splitter_vars($data->CUSTCODE); ?></small></td>
		                                                            <td><small><?php echo @ splitter_vars($data->SYSLOGNO); ?></small></td>
		                                                            <td><small><?php echo $data->TRXCODE; ?></small></td>
		                                                            <td><small><?php echo 'IDR ' . number_format($data->TRXVALUE, 0, ',', '.'); ?></small></td>
		                                                            <td><small><?php echo $data->LASTSTATE; ?></small></td>
																	<td><small><?php echo $data->LASTRC; ?></small></td>
																	<td><small><?php echo $data->LASTRCFIN; ?></small></td>
																	<td><small><?php echo $data->PRODCODE; ?></small></td>
																	<td><small><?php echo $data->INVOICENO; ?></small></td>
																	<td><small><?php echo $data->INVOICENAME; ?></small></td>
																	<td><small><?php echo $data->SRAC; ?></small></td>
																	<td><small><?php echo $data->DSAC; ?></small></td>
																	<td><small><?php echo $data->RCVTIME; ?></small></td>
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
                	$last_day->free_result();
                	$this->load->view($params['base_comp'] . 'v-frontend-footer');
                ?>

            </div>
            <!-- ============================================================== -->
            <!-- End Right content here -->
            <!-- ============================================================== -->