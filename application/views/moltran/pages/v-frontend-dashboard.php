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
                                <h4 class="pull-left page-title">Selamat Datang, <strong><?php echo ucwords(strtolower($this->session->tempdata('full_name'))); ?></strong></h4>
                                <ol class="breadcrumb pull-right">
                                    <li><a href="<?php echo @ site_url('frontend/dashboard'); ?>">Simple Dashboard</a></li>
                                    <li class="active">Beranda</li>
                                </ol>
                            </div>
                        </div>

                        <!-- Start Widget -->
                        <div class="row">
                            <div class="col-md-6 col-sm-6 col-lg-3">
                                <div class="mini-stat clearfix bg-purple bx-shadow">
                                    <span class="mini-stat-icon"><i class="ion-person"></i></span>
                                    <div class="mini-stat-info text-right">
                                        <span class="counter"><?php echo number_format(floatval($summary_dashboard['visitor']['all']), 0, ',', '.'); ?></span>
                                        Pengunjung
                                    </div>
                                    <div class="tiles-progress">
                                        <div class="m-t-20">
                                            <h5 class="text-uppercase text-white m-0">Bulan Ini <span class="pull-right"><?php echo number_format(floatval($summary_dashboard['visitor']['monthly']), 0, ',', '.'); ?></span></h5>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- End row-->

                        <div style="clear: both;">&nbsp;</div>

                        <div class="row">
                            <div class="col-md-6 col-sm-6 col-lg-3">
                            	&nbsp;
                            </div>
                            <div class="col-md-6 col-sm-6 col-lg-6">
                            	<table width="100%" cellpadding="5">
                            		<tr>
                            			<td style="padding-bottom: 10px;" width="40%">User ID anda :</td><td style="padding-bottom: 10px;" width="60%"><strong><?php echo $this->session->tempdata('user_id'); ?></strong></td>
                            		</tr>
                            		<tr>
                            			<td style="padding-bottom: 10px;">Nama Lengkap :</td><td style="padding-bottom: 10px;"><?php echo strtoupper($this->session->tempdata('full_name')); ?></td>
                            		</tr>
                            		<tr>
                            			<td style="padding-bottom: 10px;">Alamat Email :</td><td style="padding-bottom: 10px;"><?php echo strtolower($this->session->tempdata('email')); ?></td>
                            		</tr>
                            	</table>
                            </div>
                            <div class="col-md-6 col-sm-6 col-lg-3">
                            	&nbsp;
                            </div>
                       	</div>

                    </div> <!-- container -->

                </div> <!-- content -->

                <?php $this->load->view($params['base_comp'] . 'v-frontend-footer'); ?>

            </div>
            <!-- ============================================================== -->
            <!-- End Right content here -->
            <!-- ============================================================== -->