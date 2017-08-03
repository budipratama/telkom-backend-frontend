<!-- ============================================================== -->
            <!-- Start right Content here -->
            <!-- ============================================================== -->
            <div class="content-page">
                <!-- Start content -->
                <div class="content">



                <div class="wraper container-fluid">
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="bg-picture text-center" style="background-image:url('<?php echo $params['base_theme']; ?>dark/assets/images/big/bg.jpg')">
                                <div class="bg-picture-overlay"></div>
                                <div class="profile-info-name">
                                    <img src="<?php echo $params['base_image']; ?>profile.png" class="thumb-lg img-circle img-thumbnail" alt="profile-image">
                                    <h3 class="text-white"><?php echo ucwords(strtolower($this->session->tempdata('full_name'))); ?></h3>
                                </div>
                            </div>
                            <!--/ meta -->
                        </div>
                    </div>
                    <div class="row user-tabs">
                        <div class="col-lg-6 col-md-9 col-sm-9">
                            <ul class="nav nav-tabs tabs">
                            <li class="active tab">
                                <a href="#about-me" data-toggle="tab" aria-expanded="false" class="active">
                                    <span class="visible-xs"><i class="fa fa-home"></i></span>
                                    <span class="hidden-xs">Tentang Saya</span>
                                </a>
                            </li>
                           	<li class="tab">
                                <a href="#profile-setting" data-toggle="tab" aria-expanded="false">
                                    <span class="visible-xs"><i class="fa fa-cog"></i></span>
                                    <span class="hidden-xs">Pengaturan</span>
                                </a>
                            </li>
                        <div class="indicator"></div></ul>
                    </div>
                    <div class="row">
                        <div class="col-lg-11">

                        <div class="tab-content profile-tab-content">
                            <div class="tab-pane active" id="about-me">
                                <div class="row">
                                	<?php
                                		if(isset($_SESSION['profile_update'])) :
                                	?>
                                	<div class="col-md-12">
                                		<div class="alert alert-success alert-dismissable">
                                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true"><small>x</small></button>
                                            <?php echo $_SESSION['profile_update']; ?>
                                        </div>
                                	</div>
                                	<?php
                                		endif;
                                	?>
                                    <div class="col-md-4">
                                        <!-- Personal-Information -->
                                        <div class="panel panel-default panel-fill">
                                            <div class="panel-heading">
                                                <h3 class="panel-title">Informasi Personal</h3>
                                            </div>
                                            <div class="panel-body">
                                                <div class="about-info-p">
                                                    <strong>Nama Lengkap</strong>
                                                    <br>
                                                    <p class="text-muted"><?php echo trim(ucwords(strtolower($this->session->tempdata('full_name')))); ?></p>
                                                </div>
                                                <div class="about-info-p">
                                                    <strong>Nomor Telepon</strong>
                                                    <br>
                                                    <p class="text-muted"><?php echo trim($this->session->tempdata('phone_number')); ?></p>
                                                </div>
                                                <div class="about-info-p">
                                                    <strong>Alamat Email</strong>
                                                    <br>
                                                    <p class="text-muted"><?php echo trim($this->session->tempdata('email')); ?></p>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- Personal-Information -->
                                    </div>
                                    <div class="col-md-8">
                                        <!-- Personal-Information -->
                                        <div class="panel panel-default panel-fill">
                                            <div class="panel-heading">
                                                <h3 class="panel-title">Deskripsi Singkat</h3>
                                            </div>
                                            <div class="panel-body">
                                            	<p style="text-align: justify;">
                                                	&nbsp;
                                                </p>
                                            </div>
                                        </div>
                                        <!-- Personal-Information -->
                                        </div>

                                    </div>

                                </div>
                            </div>

                            <div class="tab-pane" id="profile-setting">
                                <div class="row">
                                	<?php
                                		if(isset($_SESSION['profile_update'])) :
                                	?>
                                	<div class="col-md-12">
                                		<div class="alert alert-success alert-dismissable">
                                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true"><small>x</small></button>
                                            <?php echo $_SESSION['profile_update']; ?>
                                        </div>
                                	</div>
                                	<?php
                                		endif;
                                	?>
                                </div>
                                <div class="row">
	                                <div class="panel panel-default panel-fill">
	                                    <div class="panel-heading">
	                                        <h3 class="panel-title">Ubah Profil</h3>
	                                    </div>
	                                    <div class="panel-body">
	                                        <form method="post" name="formProfile" id="formProfile" action="<?php echo site_url('frontend/user/my-profile'); ?>">
	                                            <div class="form-group">
	                                                <label for="Username">User ID</label>
	                                                <input readonly="readonly" onfocus="this.removeAttribute('readonly');" autocomplete="off" placeholder="Masukkan user ID anda" readonly="readonly" type="text" value="<?php echo trim($this->session->tempdata('user_id')); ?>" name="UserID" id="UserID" class="form-control" />
	                                            </div>
	                                            <div class="form-group">
	                                                <label for="FullName">Nama Lengkap</label>
	                                                <input readonly="readonly" onfocus="this.removeAttribute('readonly');" autocomplete="off" placeholder="Masukkan nama lengkap anda" type="text" value="<?php echo trim(strtoupper($this->session->tempdata('full_name'))); ?>" maxlength="100" name="FullName" id="FullName" class="form-control" />
	                                            </div>
	                                            <div class="form-group">
	                                                <label for="Email">Nomor Telepon</label>
	                                                <input readonly="readonly" onfocus="this.removeAttribute('readonly');" autocomplete="off" placeholder="Masukkan nomor telepon anda" type="text" value="<?php echo trim($this->session->tempdata('phone_number')); ?>" maxlength="100" name="Phone" id="Phone" class="form-control" />
	                                            </div>
	                                            <div class="form-group">
	                                                <label for="Email">Alamat Email</label>
	                                                <input readonly="readonly" onfocus="this.removeAttribute('readonly');" autocomplete="off" placeholder="Masukkan alamat email anda" type="email" value="<?php echo trim($this->session->tempdata('email')); ?>" maxlength="100" name="Email" id="Email" class="form-control" />
	                                            </div>
	                                            <div class="form-group">
	                                                <label for="Password">Password</label>
	                                                <input readonly="readonly" onfocus="this.removeAttribute('readonly');" type="password" placeholder="Masukkan password anda (8 - 50 karakter)" name="Password" id="Password" maxlength="50" class="form-control" />
	                                            </div>
	                                            <div class="form-group">
	                                                <label for="RePassword">Ulangi Password</label>
	                                                <input readonly="readonly" onfocus="this.removeAttribute('readonly');" type="password" placeholder="Masukkan password anda (8 - 50 karakter)" name="RePassword" id="RePassword" maxlength="50" class="form-control" />
	                                            </div>
	                                            <input type="submit" class="btn btn-danger" name="profileSubmit" id="profileSubmit" value="Simpan" />
	                                            <input type="reset" class="btn btn-default" name="profileReset" id="profileReset" value="Reset" />
	                                        </form>

	                                    </div>
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
