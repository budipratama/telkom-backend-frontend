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

                                            <form class="cmxform form-horizontal tasi-form" name="accountActivityForm" id="accountActivityForm" method="post" action="<?php echo @ site_url('frontend/monitoring/user-account-activity'); ?>">
                                            	<div class="form-group">
                                                    <label for="id_tmoney" class="control-label col-lg-2">ID Akun *</label>
                                                    <div class="col-lg-10">
                                                        <input readonly="readonly" onfocus="this.removeAttribute('readonly');" required="required" autocomplete="off" placeholder="Masukkan ID Akun T-MONEY" maxlength="100" class="form-control" id="id_tmoney" name="id_tmoney" type="text" />
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label for="datepicker-start" class="control-label col-lg-2">Rentang Waktu *</label>
                                                    <div class="col-lg-10" style="text-align: left;">
	                                                    <div class="col-lg-5">
	                                                        <div class="input-group">
							                                    <input readonly="readonly" onfocus="this.removeAttribute('readonly');" type="text" class="form-control" placeholder="Masukkan tanggal awal : yyyy-mm-dd" name="start_date" id="datepicker-start" />
							                                    <span class="input-group-addon"><i class="glyphicon glyphicon-calendar"></i></span>
							                                </div>
							                           	</div>
	                                                    <div class="col-lg-5">
	                                                        <div class="input-group">
							                                    <input readonly="readonly" onfocus="this.removeAttribute('readonly');" type="text" class="form-control" placeholder="Masukkan tanggal akhir : yyyy-mm-dd" name="stop_date" id="datepicker-stop" />
							                                    <span class="input-group-addon"><i class="glyphicon glyphicon-calendar"></i></span>
							                                </div>
	                                                    </div>
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