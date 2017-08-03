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
                                        <h3 class="panel-title">Tambah User Aplikasi Simple Dashboard T-MONEY</h3>
                                    </div>
                                    <div class="panel-body">
                                        <div class="form">
                                        	<div class="wizard">
                                        		<div class="clearfix">
                                        			<a href="<?php echo site_url('frontend/reporting/user'); ?>">
                                        				<button class="btn btn-danger waves-effect waves-light"><i class="fa fa-list"></i> <span>Lihat User</span></button>
                                        			</a>
												</div>
                                        	</div>
                                        	<div class="clearfix">&nbsp;</div>

											<?php $this->load->view($params['base_widget'] . 'v-widget-alert'); ?>

                                        	<div class="clearfix">&nbsp;</div>

                                            <form class="cmxform form-horizontal tasi-form" id="dataUser" method="post" action="<?php echo @ site_url('frontend/reporting/user/add'); ?>">
                                                <div class="form-group">
                                                    <label for="user_id" class="control-label col-lg-2">User ID *</label>
                                                    <div class="col-lg-10">
                                                        <input required="required" autocomplete="off" readonly="readonly" onfocus="this.removeAttribute('readonly');" placeholder="Masukkan User ID" maxlength="100" class="form-control" id="user_id" name="user_id" type="text" />
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label for="full_name" class="control-label col-lg-2">Nama Lengkap *</label>
                                                    <div class="col-lg-10">
                                                        <input required="required" autocomplete="off" readonly="readonly" onfocus="this.removeAttribute('readonly');" placeholder="Masukkan Nama Lengkap" maxlength="100" class="form-control" id="full_name" name="full_name" type="text" />
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label for="password" class="control-label col-lg-2">Password *</label>
                                                    <div class="col-lg-10">
                                                        <input required="required" autocomplete="off" readonly="readonly" onfocus="this.removeAttribute('readonly');" placeholder="Masukkan Password" maxlength="100" class="form-control" id="password" name="password" type="password" />
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label for="email_address" class="control-label col-lg-2">Alamat Email *</label>
                                                    <div class="col-lg-10">
                                                        <input required="required" autocomplete="off" readonly="readonly" onfocus="this.removeAttribute('readonly');" placeholder="Masukkan Alamat Email" maxlength="100" class="form-control" id="email_address" name="email_address" type="email" />
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label for="phone_number" class="control-label col-lg-2">Nomor HP *</label>
                                                    <div class="col-lg-10">
                                                        <input required="required" autocomplete="off" readonly="readonly" onfocus="this.removeAttribute('readonly');" placeholder="Masukkan Nomor HP" maxlength="100" class="form-control" id="phone_number" name="phone_number" type="text" />
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label for="status" class="control-label col-lg-2">Status *</label>
                                                    <div class="col-lg-10">
			                                            <select required="required" name="status" class="select2 form-control" data-placeholder="-- Pilih Status --">
			                                              	<option value="">&nbsp;</option>
			                                              	<option value="1">Aktif</option>
			                                              	<option value="0">Tidak Aktif</option>
			                                            </select>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label for="level_id" class="control-label col-lg-2">Level User *</label>
                                                    <div class="col-lg-10">
			                                            <select required="required" name="level_id" class="select2 form-control" data-placeholder="-- Pilih Level User --">
			                                              	<option value="">&nbsp;</option>
			                                              	<?php
			                                              		foreach($query->result() as $data)
			                                              		{
			                                              	?>
			                                              	<option value="<?php echo $data->LEVEL_ID; ?>"><?php echo $data->LEVEL_NAME; ?></option>
															<?php
			                                              		}
															?>
			                                            </select>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label for="address" class="control-label col-lg-2">Alamat Lengkap</label>
                                                    <div class="col-lg-10">
                                                        <textarea autocomplete="off" readonly="readonly" onfocus="this.removeAttribute('readonly');" placeholder="Masukkan Alamat Lengkap" class="form-control" id="address" name="address"></textarea>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <div class="col-lg-offset-2 col-lg-10">
                                                        <button class="btn btn-danger waves-effect waves-light" type="submit">Tambah</button>
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