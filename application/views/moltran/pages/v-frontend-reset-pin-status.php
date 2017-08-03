			<!-- ============================================================== -->
            <!-- Start right Content here -->
            <!-- ============================================================== -->
            <div class="content-page">
                <!-- Start content -->
                <div class="content">
                    <div class="container">

                        <!-- Page-Title -->
                        <div class="row">
                            <div class="col-sm-12">
                                <h4 class="pull-left page-title">INVOICE RESET PIN T-MONEY</h4>
                                <ol class="breadcrumb pull-right">
                                    <li><a href="<?php echo @ site_url('frontend/dashboard'); ?>">Simple Dashboard</a></li>
                                    <li><a href="<?php echo @ site_url('frontend/authorize/reset-pin-inquiry'); ?>">Reset PIN</a></li>
                                    <li class="active">Invoice</li>
                                </ol>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-12">
                                <div class="panel panel-default">
                                    <!-- <div class="panel-heading">
                                        <h4>Invoice</h4>
                                    </div> -->
                                    <div class="panel-body">
                                        <div class="clearfix">
                                            <div class="pull-left">
                                                <h4 class="text-right"><img src="<?php echo $params['base_image'] . 't-money.png'; ?>" alt="velonic"></h4>

                                            </div>
                                            <div class="pull-right">
                                                <h4>Invoice # <br>
                                                    <strong><?php echo (isset($transaction['transactionID'])) ? trim(splitter_vars($transaction['transactionID'])) : splitter_vars(date('YmdHis') . mt_rand(100000, 999999), 6, '-'); ?></strong>
                                                </h4>
                                            </div>
                                        </div>
                                        <hr>
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="pull-left m-t-30">
                                                    <address>
                                                      <strong>T-MONEY by PT Telkom Indonesia</strong><br>
                                                      Gd. Menara Multimedia Lt. 15<br>
                                                      Jakarta Pusat<br>
                                                      </address>
                                                </div>
                                                <?php
                                                	if(isset($transaction['resultCode']) && $transaction['resultCode'] == '0')
                                                	{
                                                		$label 			= 'label-success';
                                                		$info 			= 'Sukses';
                                                	}
                                                	else
                                                	{
                                                		$label 			= 'label-danger';
                                                		$info 			= 'Gagal';
                                                	}
                                                ?>
                                                <div class="pull-right m-t-30">
                                                    <p><strong>Tanggal Reset : </strong> <?php echo @ formatter_date(date($this->config->item('log_date_format'))); ?></p>
                                                    <p class="m-t-10"><strong>Status Reset : </strong> <span class="label <?php echo $label; ?>"><?php echo $info; ?></span></p>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="m-h-50"></div>
                                        <div class="row">
                                            <div class="col-md-12">
                                            	<table width="100%" border="0">
                                            		<!-- <tr style="color: #333333;">
                                            			<td width="35%" style="padding-bottom: 10px;">ID Transaksi</td>
                                            			<td width="65%" style="padding-bottom: 10px;"><?php echo (isset($transaction['transactionID'])) ? trim(splitter_vars($transaction['transactionID'])) : '-'; ?></td>
                                            		</tr>
                                            		<tr style="color: #333333;">
                                            			<td style="padding-bottom: 10px;">Nomor Referensi</td>
                                            			<td style="padding-bottom: 10px;"><?php echo (isset($transaction['refNo'])) ? trim(splitter_vars($transaction['refNo'])) : '-'; ?></td>
                                            		</tr> -->
                                            		<tr style="color: #333333;">
                                            			<td width="35%" style="padding-bottom: 10px;">ID Akun</td>
                                            			<td width="65%" style="padding-bottom: 10px;"><?php echo (isset($transaction['idTmoney'])) ? trim($transaction['idTmoney']) : '-'; ?></td>
                                            		</tr>
                                            		<tr style="color: #333333;">
                                            			<td style="padding-bottom: 10px;">Nama Lengkap</td>
                                            			<td style="padding-bottom: 10px;"><strong><?php echo (isset($transaction['customerName'])) ? trim(strtoupper($transaction['customerName'])) : '-'; ?></strong></td>
                                            		</tr>
													<tr style="color: #333333;">
                                            			<td style="padding-bottom: 10px;">Alamat Email</td>
                                            			<td style="padding-bottom: 10px;"><strong><?php echo (isset($transaction['email'])) ? trim(strtolower($transaction['email'])) : '-'; ?></strong></td>
                                            		</tr>
                                            	</table>
                                            </div>
                                        </div>
                                        <div class="m-h-50"></div>
                                        <?php
                                        	$page_title 		= date('Ymd') . '_' . date('Hi') . '_' . 'Reset PIN' . '_' . ((isset($transaction['idTmoney'])) ? trim(ucwords($transaction['idTmoney'])) : '-');
                                        ?>
                                        <script language="javascript" type="text/javascript">
											function print_page()
											{
												document.title = '<?php echo $page_title; ?>';
												window.print();
												return false;
											}
                                        </script>
                                        <div class="hidden-print">
                                            <div class="pull-right">
                                                <a href="" onclick="javascript: print_page();" class="btn btn-inverse waves-effect waves-light"><i class="fa fa-print"></i></a>
                                                <a href="<?php echo @site_url('frontend/authorize/reset-pin-inquiry'); ?>" class="btn btn-danger waves-effect waves-light">Kembali</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            </div>

                        </div>

                    </div> <!-- container -->

                </div> <!-- content -->

                <?php $this->load->view($params['base_comp'] . 'v-frontend-footer'); ?>

            </div>
            <!-- ============================================================== -->
            <!-- End Right content here -->
            <!-- ============================================================== -->