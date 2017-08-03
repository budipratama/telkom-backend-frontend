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
                                    <div class="panel-body">
                                        <div class="form">
                                        	<div class="wizard">
                                        		<div class="steps clearfix">
                                        			<ul role="tablist">
                                        				<li class="first current" role="tab">
                                        					<a>
	                                        					<span class="number">1.</span> Tahap Pengecekan
	                                        				</a>
                                        				</li>
                                        				<li class="disabled" role="tab">
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

											<?php $this->load->view(FUSION_DEFAULT_THEME.$params['base_widget'] . 'v-widget-alert'); ?>

                                        	<div class="clearfix">&nbsp;</div>

                                            <form class="cmxform form-horizontal tasi-form" name="resetPinForm" id="resetPinForm" method="post" action="<?php echo @ site_url('frontend/authorize/reset-pin-inquiry'); ?>">
                                            	<div class="form-group">
                                                    <label for="cname" class="control-label col-lg-2">ID / Email *</label>
                                                    <div class="col-lg-10">
                                                        <input readonly="readonly" onfocus="this.removeAttribute('readonly');" required="required" autocomplete="off" placeholder="Masukkan ID / EMail T-MONEY" maxlength="100" class="form-control" id="id_tmoney" name="id_tmoney" type="text" />
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <div class="col-lg-offset-2 col-lg-10">
                                                        <button class="btn btn-danger waves-effect waves-light" type="submit">Konfirmasi</button>
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

                <?php $this->load->view(FUSION_DEFAULT_THEME.$params['base_comp'] . 'v-frontend-footer'); ?>

            </div>
            <!-- ============================================================== -->
            <!-- End Right content here -->
            <!-- ============================================================== -->