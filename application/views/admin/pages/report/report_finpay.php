<link href="<?php echo $css_admin?>plugins/datatables/dataTables.bootstrap.css" rel="stylesheet" type="text/css" />

    <section class="content-header">
      <h1>
        Report Finpay
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
                <div class="col-md-3">
                  <div class="input-group">
                    <input type="text" class="form-control" placeholder="Filter by User Email, Payment code" name="s" value="<?php echo $this->input->get('s') ?>">
                        <span class="input-group-btn">
                          <button type="submit" class="btn btn-danger btn-flat"><i class="fa fa-search"></i></button>
                        </span>
                  </div>
                </div>
                 <div class="col-md-3" style="padding-left: 0px;">
                  <input id="filterbydate" type="text" name="range" class="form-control viewdaterangepicker active" placeholder="Tanggal" value="<?php echo $this->input->get('range')?>">
                </div>
                <div class="col-md-2"  style="padding: 0px;">
                  <button type="submit" class="btn btn-danger">Filter</button>
                  <a href="<?php echo current_url() ?>" class="btn btn-default" data-toggle="tooltip" title="Clear Filter"><i class="fa fa-times"></i></a>
                </div>
                </form>
                <div class="col-md-3 pull-right">
                   <?php if (!empty($finpay)): ?>
                  <div id="export" class="btn-group pull-right">
                    <a id="export-to-excel" href="<?php echo base_url('report/finpay/export?' . http_build_query($_GET)) ?>" class="btn btn-success"><i class="fa fa-download"></i>  Export To Excel</a>
                  </div>
                    <?php endif; ?>
                </div>
              </div>
            </div>
            
            <div class="box-body table-responsive" style="overflow-x: unset">
              <table id="datatable" class="table table-bordered table-striped">
                     <?php if (!empty($finpay)): ?>
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
                        <th>FINRESULTDESC</th>
                        <th>FINPAYMENTSOURCE</th>
                        <th>DATE</th>
                      </tr>
                    </thead>
                  <?php endif; ?>
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
                           <td><?php echo $data['FINRESULTDESC'] ?></td>
                           <td><?php echo $data['FINPAYMENTSOURCE'] ?></td>
                           <td><?php echo $data['TIMESTAMP'] ?></td>
                         </tr>
                       <?php endforeach ?>
                    </tbody>
                </table>
                <div class="pull-right"><?php echo $pagination ?></div>
            </div>
          </div>
          <?php if (empty($finpay)): ?>
              <div class="alert alert-info">
                Tidak ada hasil
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