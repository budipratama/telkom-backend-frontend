			<!-- Top Bar Start -->
			<div class="topbar">
                <!-- LOGO -->
                <div class="topbar-left">
                    <div class="text-center">
                        <a href="<?php echo @ site_url('frontend/dashboard'); ?>" class="logo"><img height="50" src="<?php echo $params['base_image'] . 'favicon.png'; ?>" />&nbsp;<span><?php echo strtoupper(FUSION_PLATFORM_NAME); ?></span></a>
                    </div>
                </div>
                <!-- Button mobile view to collapse sidebar menu -->
                <div class="navbar navbar-default" role="navigation">
                    <div class="container">
                        <div class="">
                            <div class="pull-left">
                                <button class="button-menu-mobile open-left">
                                    <i class="fa fa-bars"></i>
                                </button>
                                <span class="clearfix"></span>
                            </div>

                            <ul class="nav navbar-nav navbar-right pull-right">
                                <li class="dropdown">
                                    <a href="" class="dropdown-toggle profile" data-toggle="dropdown" aria-expanded="true"><img src="<?php echo $params['base_image']; ?>profile.png" alt="user-img" class="img-circle"> </a>
                                    <ul class="dropdown-menu">
                                        <li><a href="<?php echo @ site_url('frontend/user/my-profile'); ?>"><i class="md md-face-unlock"></i> Profil Saya</a></li>
                                        <!-- <li><a href="<?php echo @ site_url('frontend/user/my-profile') . '#profile-setting'; ?>"><i class="md md-settings"></i> Pengaturan</a></li> -->
                                        <li><a href="<?php echo @ site_url('frontend/lock-screen'); ?>"><i class="md md-lock"></i> Kunci Layar</a></li>
                                        <li><a href="<?php echo @ site_url('authentication/user/sign-out'); ?>"><i class="md md-settings-power"></i> Keluar (Logout)</a></li>
                                    </ul>
                                </li>
                            </ul>
                        </div>
                        <!--/.nav-collapse -->
                    </div>
                </div>
            </div>
            <!-- Top Bar End -->


            <!-- ========== Left Sidebar Start ========== -->

            <div class="left side-menu">
                <div class="sidebar-inner slimscrollleft">
                    <div class="user-details">
                        <div class="pull-left">
                            <img src="<?php echo $params['base_image']; ?>profile.png" alt="" class="thumb-md img-circle">
                        </div>
                        <div class="user-info">
                            <div class="dropdown">
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-expanded="false"><?php echo ucwords(strtolower($this->session->tempdata('full_name'))); ?> <span class="caret"></span></a>
                                <ul class="dropdown-menu">
                                    <li><a href="<?php echo @ site_url('frontend/user/my-profile'); ?>"><i class="md md-face-unlock"></i> Profil Saya<div class="ripple-wrapper"></div></a></li>
                                    <!-- <li><a href="<?php echo @ site_url('frontend/user/my-profile') . '#profile-setting'; ?>"><i class="md md-settings"></i> Pengaturan</a></li> -->
                                    <li><a href="<?php echo @ site_url('frontend/lock-screen'); ?>"><i class="md md-lock"></i> Kunci Layar</a></li>
                                    <li><a href="<?php echo @ site_url('authentication/user/sign-out'); ?>"><i class="md md-settings-power"></i> Keluar (Logout)</a></li>
                                </ul>
                            </div>

                            <p class="text-muted m-0">
                            	<?php
                            		echo $this->session->tempdata('levelName');
                            	?>
                            </p>
                        </div>
                    </div>
                    <!--- Divider -->
                    <div id="sidebar-menu">
                        <ul>
                            <li>
                                <a href="<?php echo @ site_url('frontend/dashboard'); ?>" class="waves-effect waves-light active"><i class="md md-home"></i><span> Dashboard </span></a>
                            </li>
                            <?php if($this->session->tempdata('accessResetPin') == 1 OR $this->session->tempdata('accessPhoneVerify') == 1) : ?>
	                            <li class="has_sub">
	                                <a href="#" class="waves-effect waves-light"><i class="md md-vpn-key"></i><span> Autorisasi </span><span class="pull-right"><i class="md md-add"></i></span></a>
	                                <ul class="list-unstyled">
	                                	<?php if($this->session->tempdata('accessResetPin') == 1) : ?><li><a href="<?php echo @ site_url('frontend/authorize/reset-pin-inquiry'); ?>">Reset PIN</a></li><?php endif; ?>
	                                    <?php if($this->session->tempdata('accessPhoneVerify') == 1) : ?><li><a href="<?php echo @ site_url('frontend/authorize/phone-verify-check'); ?>">Verifikasi Nomor HP</a></li><?php endif; ?>
	                                </ul>
	                            </li>
                            <?php endif; ?>
                            <?php if($this->session->tempdata('accessGetCustomer') == 1 OR $this->session->tempdata('accessGetFinpay') == 1 OR $this->session->tempdata('accessGetResetPin') == 1 OR $this->session->tempdata('accessGetTransaction') == 1) : ?>
	                            <li class="has_sub">
	                                <a href="#" class="waves-effect waves-light"><i class="md md-view-list"></i><span> Laporan </span><span class="pull-right"><i class="md md-add"></i></span></a>
	                                <ul class="list-unstyled">
	                                    <?php if($this->session->tempdata('accessGetCustomer') == 1) : ?><li><a href="<?php echo @ site_url('frontend/reporting/customer'); ?>">Customer</a></li><?php endif; ?>
	                                    <?php if($this->session->tempdata('accessGetFinpay') == 1) : ?><li><a href="<?php echo @ site_url('frontend/reporting/finpay'); ?>">Finpay 0211</a></li><?php endif; ?>
	                                    <?php if($this->session->tempdata('accessGetResetPin') == 1) : ?><li><a href="<?php echo @ site_url('frontend/reporting/reset-pin'); ?>">Reset PIN</a></li><?php endif; ?>
	                                    <?php if($this->session->tempdata('accessGetTransaction') == 1) : ?><li><a href="<?php echo @ site_url('frontend/reporting/transaction'); ?>">Transaksi</a></li><?php endif; ?>
	                                </ul>
	                            </li>
                            <?php endif; ?>
                            <?php if($this->session->tempdata('accessUserActivity') == 1 OR $this->session->tempdata('accessGeoIp') == 1 OR $this->session->tempdata('accessGetTransaction') == 1) : ?>
	                            <li class="has_sub">
	                                <a href="#" class="waves-effect waves-light"><i class="ion-monitor"></i><span> Cek & Monitor </span><span class="pull-right"><i class="md md-add"></i></span></a>
	                                <ul class="list-unstyled">
	                                	<?php if($this->session->tempdata('accessUserActivity') == 1) : ?><li><a href="<?php echo @ site_url('frontend/monitoring/user-account-activity'); ?>">Aktivitas Akun</a></li><?php endif; ?>
	                                	<?php if($this->session->tempdata('accessGeoIp') == 1) : ?><li><a href="<?php echo @ site_url('frontend/checking/geo-ip-address'); ?>">IP Geo Location</a></li><?php endif; ?>
	                                    <?php if($this->session->tempdata('accessSMSGateway') == 1) : ?><li><a href="<?php echo @ site_url('frontend/monitoring/sms-gateway-send-test'); ?>">Tes SMS Gateway</a></li><?php endif; ?>
	                                    <?php if($this->session->tempdata('accessGetTransaction') == 1) : ?><li><a href="<?php echo @ site_url('frontend/monitoring/last-day-transaction'); ?>">Transaksi Hari Ini</a></li><?php endif; ?>
	                                </ul>
	                            </li>
                            <?php endif; ?>
                            <?php if($this->session->tempdata('accessGetUser') == 1) : ?>
	                            <li class="has_sub">
	                                <a href="#" class="waves-effect waves-light"><i class="ion-android-contact"></i><span> Hak Akses </span><span class="pull-right"><i class="md md-add"></i></span></a>
	                                <ul class="list-unstyled">
	                                    <?php if($this->session->tempdata('accessGetUser') == 1) : ?><li><a href="<?php echo @ site_url('frontend/reporting/user'); ?>">Daftar User</a></li><?php endif; ?>
	                                </ul>
	                            </li>
                            <?php endif; ?>
                            <?php if($this->session->tempdata('accessSMSGateway') == 1) : ?>
	                            <li class="has_sub">
	                                <a href="#" class="waves-effect waves-light"><i class="md md-settings"></i><span> Pengaturan </span><span class="pull-right"><i class="md md-add"></i></span></a>
	                                <ul class="list-unstyled">
	                                    <?php if($this->session->tempdata('accessSMSGateway') == 1) : ?><li><a href="<?php echo @ site_url('frontend/setting/sms-gateway'); ?>">SMS Gateway</a></li><?php endif; ?>
	                                </ul>
	                            </li>
                            <?php endif; ?>
                            <li>
                                <a href="<?php echo @ site_url('authentication/user/sign-out'); ?>" class="waves-effect"><i class="fa fa-sign-out"></i><span> Logout </span></a>
                            </li>
                        </ul>
                        <div class="clearfix"></div>
                    </div>
                    <div class="clearfix"></div>
                </div>
            </div>
            <!-- Left Sidebar End -->
