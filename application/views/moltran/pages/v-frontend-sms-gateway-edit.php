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
                                        			<a href="<?php echo site_url('frontend/setting/sms-gateway'); ?>">
                                        				<button class="btn btn-danger waves-effect waves-light"><i class="md md-list"></i> <span>Lihat SMS Gateway</span></button>
                                        			</a>
												</div>
                                        	</div>
                                        	<div class="clearfix">&nbsp;</div>

											<?php $this->load->view($params['base_widget'] . 'v-widget-alert'); ?>

                                        	<div class="clearfix">&nbsp;</div>

                                            <form class="cmxform form-horizontal tasi-form" id="dataSMSGateway" method="post" action="<?php echo @ site_url('frontend/setting/sms-gateway/edit-hp'); ?>">
                                                <div class="form-group">
                                                    <label for="user_id" class="control-label col-lg-2">Nomor HP *</label>
                                                    <div class="col-lg-10">
                                                    	<input required="required" autocomplete="off" readonly="readonly" onfocus="this.removeAttribute('readonly');" placeholder="Masukkan Nomor HP Testing SMS Gateway" maxlength="15" class="form-control" id="old_phone_number" name="old_phone_number" type="hidden" value="<?php echo $phone_number; ?>" />
                                                        <input required="required" autocomplete="off" readonly="readonly" onfocus="this.removeAttribute('readonly');" placeholder="Masukkan Nomor HP Testing SMS Gateway" maxlength="15" class="form-control" id="new_phone_number" name="new_phone_number" type="text" value="<?php echo $phone_number; ?>" />
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <div class="col-lg-offset-2 col-lg-10">
                                                        <button class="btn btn-danger waves-effect waves-light" type="submit">Edit</button>
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