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
                                        <h3 class="panel-title">Reset PIN Akun T-MONEY</h3>
                                    </div>

                                    <?php $transaction 	= $this->session->tempdata('transaction'); ?>

                                    <div class="panel-body">
                                        <div class="form">
                                        	<div class="wizard">
                                        		<div class="steps clearfix">
                                        			<ul role="tablist">
                                        				<li class="first disabled" role="tab">
                                        					<a>
	                                        					<span class="number">1.</span> Tahap Pengecekan
	                                        				</a>
                                        				</li>
                                        				<li class="current" role="tab">
                                        					<a>
                                        						<span class="number">2.</span> Tahap Konfirmasi
                                        					</a>
                                        				</li>
                                        				<li class="disabled" role="tab">
                                        					<a>
                                        						<span class="number">3.</span> Tahap Print-out
                                        					</a>
                                        				</li>
													</ul>
												</div>
                                        	</div>
                                        	<div class="clearfix">&nbsp;</div>

											<?php $this->load->view($params['base_widget'] . 'v-widget-alert'); ?>

                                        	<div class="clearfix">&nbsp;</div>

                                            <form enctype="multipart/form-data" class="cmxform form-horizontal tasi-form" id="commentForm" method="post" action="<?php echo @ site_url('frontend/authorize/reset-pin-confirmation'); ?>">
                                            	<div class="form-group">
                                                    <label for="cname" class="control-label col-lg-2">ID / Email *</label>
                                                    <div class="col-lg-10">
                                                        <input required="required" autocomplete="off" placeholder="" readonly="readonly" class="form-control" id="id_tmoney" name="id_tmoney" type="text" value="<?php echo (isset($transaction['idTmoney'])) ? trim($transaction['idTmoney']) : ''; ?>" />
                                                    </div>
                                                </div>
                                            	<div class="form-group">
                                                    <label for="cname" class="control-label col-lg-2">Nama Lengkap *</label>
                                                    <div class="col-lg-10">
                                                        <input required="required" autocomplete="off" placeholder="" readonly="readonly" class="form-control" id="full_name" name="full_name" type="text" value="<?php echo (isset($transaction['customerName'])) ? trim(strtoupper($transaction['customerName'])) : ''; ?>" />
                                                    </div>
                                                </div>
                                            	<div class="form-group">
                                                    <label for="cname" class="control-label col-lg-2">Alamat Email *</label>
                                                    <div class="col-lg-10">
                                                        <input required="required" autocomplete="off" placeholder="" readonly="readonly" class="form-control" id="email_address" name="email_address" type="email" value="<?php echo (isset($transaction['email'])) ? trim(strtolower($transaction['email'])) : ''; ?>" />
                                                    </div>
                                                </div>
												<hr />
                                            	<div class="form-group">
                                                    <label for="cname" class="control-label col-lg-2">Dokumen Karpeg *</label>
                                                    <div class="col-lg-10">
                                                        <input required="required" autocomplete="off" placeholder="" type="file" id="docKarpeg" name="docKarpeg" size="20" />
                                                    </div>
                                                </div>
                                            	<div class="form-group">
                                                    <label for="cname" class="control-label col-lg-2">Dokumen KTP *</label>
                                                    <div class="col-lg-10">
                                                        <input required="required" autocomplete="off" placeholder="" type="file" id="docKTP" name="docKTP" size="20" />
                                                    </div>
                                                </div>
												<hr />
                                                <div class="form-group">
                                                    <div class="col-lg-offset-2 col-lg-10">
                                                    	<!-- <a href="javascript:;" class="md-trigger btn btn-primary waves-effect waves-light" data-modal="modal-12">
                                                    		Peringatan
                                                    	</a> -->
                                                        <button class="btn btn-danger waves-effect waves-light" type="submit">Reset PIN</button>
                                                        <a href="<?php echo @ site_url('frontend/authorize/reset-pin-inquiry'); ?>">
                                                        	<button class="btn btn-default waves-effect" type="button">Kembali</button>
                                                        </a>
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
            <div class="md-modal md-effect-12" id="modal-12">
            	<div class="md-content">
                	<h3>Notifikasi</h3>
                    <div>
                    	<p>Demi keamanan dan validitas data customer, pastikan :</p>
                        <ul>
                            <li><strong>Klarifikasi :</strong> Setiap request yang tidak jelas, <strong>JANGAN</strong> di-approve sebelum diklarifikasi kepada pemilik yang bersangkutan</li>
                        	<li><strong>Validasi :</strong> Cek dan pastikan bahwa data <span class="label label-danger">Kartu Pegawai</span> dan <span class="label label-danger">KTP</span> adalah asli dan bukan hasil editing</li>
                            <li><strong>Konfirmasi :</strong> Cek dan pastikan bahwa customer benar-benar dan jelas merupakan pemilik akun</li>
                        </ul>
						<button class="md-close btn-sm btn-danger waves-effect waves-light">Tutup Dialog</button>
                   	</div>
              	</div>
           	</div>
            <!-- ============================================================== -->
            <!-- End Right content here -->
            <!-- ============================================================== -->