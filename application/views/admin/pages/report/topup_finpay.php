<link href="<?php echo $css_admin?>plugins/datatables/dataTables.bootstrap.css" rel="stylesheet" type="text/css" />

    <section class="content-header">
      <h1>
        Topup Ulang Finpay
      </h1>
    </section>

    <section class="content">
      <div class="row">
        <div class="col-xs-12">
          <!-- Customer data -->
          <div class="box">
            <div class="box-header">
              <div class="row">
                <form action="<?php echo current_url(); ?>">
                <div class="col-md-5">
                    <input type="text" class="form-control" placeholder="Search by User Email or Payment code" name="s" value="<?php echo $this->input->get('s') ?>">
                </div>
                 <div class="col-md-3" style="padding-left: 0px;">
                  <input id="filterbydate" type="text" name="range" class="form-control viewdaterangepicker active" placeholder="Search by date" value="<?php echo $this->input->get('range')?>">
                </div>
                <div class="col-md-2"  style="padding: 0px;">
                  <button type="submit" class="btn btn-danger">Search</button>
                </div>
                </form>
                <div class="col-md-3 pull-right">
                </div>
              </div>
            </div>
            <?php if ($this->session->flashdata('msg')): ?>
              <div class="alert alert-info">
                <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                <p><?php echo $this->session->flashdata('msg') ?></p>
              </div>
            <?php endif ?>
            <?php if (!empty($finpay)): ?>
            <div class="box-body table-responsive" style="overflow-x: unset">
              <table id="datatable" class="table table-bordered table-striped">
                    <thead>
                      <tr>
                        <th>Invoice</th>
                        <th>Amount</th>
                        <th>Payment Code</th>
                        <th>ID tmoney</th>
                        <th>Email</th>
                        <th>ID Fusion</th>
                        <th>PAID </th>
                        <th>TOPUP RESPONSECODE</th>
                        <th>FINRESULTCODE</th>
                        <th>DATE</th>
                      </tr>
                    </thead>
                    <tbody class="reportView">
                       <?php foreach ($finpay as $data): ?>
                         <tr>
                           <td><?php echo $data['INVOICE'] ?></td>
                           <td><?php echo 'Rp. ' . number_format( $data['AMOUNT'], 0 , '.' , '.' ) ?></td>
                           <td><?php echo $data['PAYMENTCODE'] ?></td>
                           <td><?php echo $data['IDTMONEY'] ?></td>
                           <td><?php echo $data['EMAIL'] ?></td>
                           <td><?php echo $data['IDFUSION'] ?></td>
                           <td><?php echo $data['PAID'] ?></td>
                           <td><?php echo $data['TOPUPRESPONSECODE'] ?></td>
                           <td><?php echo $data['FINRESULTCODE'] ?></td>
                           <td><?php echo $data['TIMESTAMP'] ?></td>
                           <td>
                            <form action="<?php echo base_url('report/finpay/topup_process') ?>" method="post">
                              <input type="hidden" value="<?php echo $data['PAYMENTCODE'] ?>" name="payment_code">
                              <span data-toggle="tooltip" data-title="Topup Ulang">
                                <button type="submit" data-toggle=confirmation data-title="Topup Ulang?" class="btn btn-success" title="Topup Ulang"><i class="fa fa-refresh"></i></button> 
                              </span> 
                            </form>
                            
                            </td>
                         </tr>
                       <?php endforeach ?>
                    </tbody>
                </table>
                
                <div class="pull-right"><?php echo $pagination ?></div>
            </div>
            <?php endif; ?>
          </div>
          <?php if (empty($finpay) && !empty($_GET)): ?>
              <div class="alert alert-info">
                Tidak ada hasil untuk transaksi topup yang gagal
              </div>
            <?php endif ?>
      </div>
  </div>
</section>
  <script src="<?php echo base_url('assets/js/bootstrap-confirmation/bootstrap-confirmation.min.js')?>" type="text/javascript"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/moment.js/2.11.2/moment.min.js"></script>
    <script src="<?php echo $css_admin?>plugins/daterangepicker/daterangepicker.js"></script>
    <link rel="stylesheet" href="https://webmin.cari-aja.com/assets/padi-admin/plugins/daterangepicker/daterangepicker-bs3.css">
    <!-- AdminLTE App -->
    <!-- page script -->
    <script type="text/javascript">
     $('[data-toggle=confirmation]').confirmation({singleton : true,placement : 'left',popout : true,});
      $(function () {
         $('.viewdaterangepicker').daterangepicker();
      });
      $(window).load(function(){
        $('.sidebar-toggle').trigger('click');
      })
    </script>