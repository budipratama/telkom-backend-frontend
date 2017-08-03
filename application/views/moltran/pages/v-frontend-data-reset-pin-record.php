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
                                        <h3 class="panel-title">Data Reset PIN akun T-MONEY</h3>
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
		                                                            <th><small>ID Akun</small></th>
		                                                            <th><small>Nama Lengkap</small></th>
		                                                            <th><small>Alamat Email</small></th>
		                                                            <th><small>Karpeg</small></th>
		                                                            <th><small>KTP</small></th>
		                                                            <th><small>RC</small></th>
		                                                            <th><small>Di-approve oleh</small></th>
		                                                            <th><small>Waktu</small></th>
		                                                        </tr>
		                                                    </thead>
		                                                    <tbody>
		                                                    <?php
		                                                    	$no 		= 1;

		                                                    	foreach($query->result() as $data)
		                                                    	{
		                                                    		$name 		= $data->CUSTOMER_NAME;
		                                                    		$exp_name	= explode(' ', $name);

		                                                    		if(count($exp_name) > 2)
		                                                    			$name 	= $exp_name[0] . ' ' . $exp_name[1] . ' ' . substr($exp_name[2], 0, 1);
		                                                    ?>
		                                                        <tr>
		                                                            <td><small><?php echo $no; ?></small></td>
		                                                            <td><small><strong><?php echo @ splitter_vars($data->CUSTOMER_CODE); ?></strong></small></td>
		                                                            <td><small style="text-transform: uppercase;"><?php echo $name; ?></small></td>
		                                                            <td><small><span class="label label-purple"><?php echo $data->CUSTOMER_EMAIL; ?></span></small></td>
																	<td>
																		<?php
																			if($data->DOC_KARPEG != '') :
																		?>
																		<div class="col-sm-12 graphicdesign photography">
										                                    <div class="gal-detail">
										                                        <a href="<?php echo base_url(); ?>uploads/<?php echo $data->DOC_KARPEG; ?>" class="image-popup" title="<?php echo $data->DOC_KARPEG; ?>">
		                                                            				<small data-toggle="tooltip" data-placement="right" title="Klik untuk melihat screenshot Karpeg" data-original-title="Klik untuk melihat screenshot Karpeg">Screenshot</small>
		                                                            			</a>
		                                                            		</div>
		                                                            	</div>
		                                                            	<?php
		                                                            		else :
		                                                            			echo '-';
		                                                            		endif;
		                                                            	?>
																	</td>
																	<td>
																		<?php
																			if($data->DOC_KTP != '') :
																		?>
																		<div class="col-sm-12 graphicdesign photography">
										                                    <div class="gal-detail">
										                                        <a href="<?php echo base_url(); ?>uploads/<?php echo $data->DOC_KTP; ?>" class="image-popup" title="<?php echo $data->DOC_KTP; ?>">
		                                                            				<small data-toggle="tooltip" data-placement="right" title="Klik untuk melihat screenshot KTP" data-original-title="Klik untuk melihat screenshot KTP">Screenshot</small>
		                                                            			</a>
		                                                            		</div>
		                                                            	</div>
		                                                            	<?php
		                                                            		else :
		                                                            			echo '-';
		                                                            		endif;
		                                                            	?>
																	</td>
																	<td><small><?php echo ($data->RESULT_CODE == 0) ? '<span class="label label-success">Sukses</span>' : '<span class="label label-danger">Gagal</span>'; ?></small></td>
																	<td><small><span class="label label-inverse"><?php echo $data->USER_ID; ?></span></small></td>
																	<td><small><?php echo @ formatter_date($data->TIMESTAMP); ?></small></td>
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