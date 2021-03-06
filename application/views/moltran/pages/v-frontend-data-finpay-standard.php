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
                                        <h3 class="panel-title">Data Finpay 0211 T-MONEY</h3>
                                    </div>
                                    <div class="panel-body">
                                        <div class="form">
                                        	<div class="wizard">
                                        		<div class="steps clearfix">
                                        			<ul role="tablist">
                                        				<li class="first current" role="tab">
                                        					<a>
	                                        					<span class="number">1.</span> Tahap Pencarian
	                                        				</a>
                                        				</li>
                                        				<li class="disabled" role="tab">
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

                                            <form class="cmxform form-horizontal tasi-form" id="dataFinpay" method="post" action="<?php echo @ site_url('frontend/reporting/finpay-record'); ?>">
                                                <div class="form-group">
                                                    <label for="keytype" class="control-label col-lg-2">Tipe Pencarian *</label>
                                                    <div class="col-lg-10">
			                                            <select required="required" name="keytype" class="select2 form-control" data-placeholder="-- Pilih Field Pencarian --">
			                                              	<option value="">&nbsp;</option>
			                                              	<option value="INVOICE">Nomor Invoice</option>
			                                              	<!-- <option value="AMOUNT">Nominal</option> -->
			                                              	<option value="PAYMENTCODE">Kode Pembayaran</option>
			                                              	<option value="IDTMONEY">ID T-MONEY</option>
			                                              	<!-- <option value="IDFUSION">ID FUSION</option> -->
			                                              	<option value="PAID">Status Bayar</option>
			                                              	<option value="TERMINAL">Terminal</option>
			                                              	<option value="TOPUPRESPONSECODE">RC Fusion</option>
			                                              	<option value="FINRESULTCODE">RC Finnet</option>
			                                              	<!-- <option value="FINRESULTDESC">Deskripsi</option> -->
			                                              	<option value="FINPAYMENTSOURCE">Asal Dana</option>
			                                            </select>
                                                    </div>
                                                </div>
                                            	<div class="form-group">
                                                    <label for="keyword" class="control-label col-lg-2">Keyword *</label>
                                                    <div class="col-lg-10">
                                                        <input readonly="readonly" onfocus="this.removeAttribute('readonly');" required="required" autocomplete="off" placeholder="Masukkan Keyword" maxlength="100" class="form-control" id="keyword" name="keyword" type="text" />
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <div class="col-lg-offset-2 col-lg-10">
                                                        <button class="btn btn-danger waves-effect waves-light" type="submit">Cari</button>
                                                        <button class="btn btn-default waves-effect" type="reset">Reset</button>
                                                    </div>
                                                </div>
                                            </form>
                                        </div> <!-- .form -->
                                    </div> <!-- panel-body -->
                                </div> <!-- End panel -->

                            </div> <!-- end col -->

                        </div> <!-- End row -->

                    </div> <!-- container -->

                </div> <!-- content -->

                <?php $this->load->view($params['base_comp'] . 'v-frontend-footer'); ?>

            </div>
            <!-- ============================================================== -->
            <!-- End Right content here -->
            <!-- ============================================================== -->