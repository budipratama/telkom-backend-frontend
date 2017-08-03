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
                                        <h3 class="panel-title">IP Geo Location</h3>
                                    </div>
                                    <div class="panel-body">
                                        <div class="form">
                                        	<div class="wizard">
                                        		<div class="steps clearfix">
                                        			<ul role="tablist">
                                        				<li class="first disabled" role="tab">
                                        					<a>
	                                        					<span class="number">1.</span> Tahap Pencarian
	                                        				</a>
                                        				</li>
                                        				<li class="current" role="tab">
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

                                        	<?php
                                        		if ($query->num_rows() > 0) :
                                        	?>
	                                            <div class="row">
		                                            <div class="col-md-12 col-sm-12 col-xs-12">
		                                                <table id="datatable" class="table table-striped table-bordered">
		                                                    <thead>
		                                                        <tr>
		                                                            <th><small>No</small></th>
		                                                            <th><small>Alamat IP</small></th>
		                                                            <!-- <th><small>Grup</small></th> -->
		                                                            <th><small>Kota</small></th>
		                                                            <th><small>Region</small></th>
		                                                            <th><small>Negara</small></th>
		                                                            <th><small>Latitude</small></th>
		                                                            <th><small>Longitude</small></th>
		                                                            <th><small>Zona Waktu</small></th>
		                                                            <th><small>Pertama Diakses</small></th>
		                                                            <th><small>Aksi</small></th>
		                                                        </tr>
		                                                    </thead>
		                                                    <tbody>
		                                                    <?php
		                                                    	$no 		= 1;

		                                                    	foreach($query->result() as $data)
		                                                    	{
		                                                    ?>
		                                                        <tr>
		                                                            <td><small><?php echo $no; ?></small></td>
		                                                            <td><small><strong><?php echo $data->GIP_IP_ADDRESS; ?></strong></small></td>
																	<!-- <td><small><?php echo $data->GIP_GROUP; ?></small></td> -->
																	<td><small><?php echo $data->GIP_CITY; ?></small></td>
																	<td><small><?php echo $data->GIP_REGION; ?></small></td>
																	<td><small><?php echo $data->GIP_COUNTRY_NAME . ' (' . $data->GIP_COUNTRY . ')'; ?></small></td>
																	<td><small><?php echo $data->GIP_LATITUDE; ?></small></td>
																	<td><small><?php echo $data->GIP_LONGITUDE; ?></small></td>
																	<td><small><?php echo $data->GIP_TIMEZONE; ?></small></td>
																	<td><small><?php echo @ formatter_date($data->FIRST_ACCESS_TIMESTAMP); ?></small></td>
																	<td>
																		<a href="https://maps.google.co.id/?q=<?php echo $data->GIP_LATITUDE . ',' . $data->GIP_LONGITUDE; ?>" target="_blank">
																			<i class="md-view-list"></i> <small>Buka Maps</small>
																		</a>
																	</td>
		                                                        </tr>
		                                                   	<?php
		                                                   			$no++;
		                                                    	}
		                                                   	?>

		                                                    </tbody>
		                                              	</table>
		                                          	</div>
		                                       	</div>
		                                   	<?php
		                                   		else :
		                                   	?>
												<div class="row">
		                                            <div class="col-md-12 col-sm-12 col-xs-12">
		                                                Tidak ada data dengan kata kunci tersebut. Silakan coba dengan kata kunci yang lain.<br />
		                                                <div style="clear: both;">&nbsp;</div>
		                                          	</div>
		                                       	</div>
		                                   	<?php
		                                   		endif;
		                                   	?>
                                        </div> <!-- .form -->
                                    </div> <!-- panel-body -->
                                </div> <!-- End panel -->

                            </div> <!-- end col -->

                        </div> <!-- End row -->

                    </div> <!-- container -->

                </div> <!-- content -->

                <?php
                	$query->free_result();
                	$this->load->view($params['base_comp'] . 'v-frontend-footer');
                ?>

            </div>
            <!-- ============================================================== -->
            <!-- End Right content here -->
            <!-- ============================================================== -->