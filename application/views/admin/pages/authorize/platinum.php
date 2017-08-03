<?php //print_r($cityDataList); ?>
    <link href="<?php echo $css_admin?>plugins/datatables/dataTables.bootstrap.css" rel="stylesheet" type="text/css" />

        <section class="content-header">
          <h1>
            Data Tables
            <small>Platinum</small>
          </h1>
        </section>

        <section class="content">
          <div class="row">
            <div class="col-xs-12">
              <div class="box">
                <div class="box-header">
                  <h3 class="box-title">Data Tables Platinum</h3>
                </div>
                  <div class="box-body clearfix">
                      <blockquote class="pull-left">
                          <small>
                          <cite title="Source Title">
                              Modul yang berfungsi untuk Upgrade user. </cite>
                          </small>
                      </blockquote>
                  </div>
                <div class="box-body table-responsive" style="overflow-x: unset">
                  <table id="example1" class="table table-bordered table-striped">
                    <thead>
                      <tr>
                        <th>Email</th>
                        <th>Customer Name</th>
                        <th>Customer Type</th>
                        <th>tMoney Number</th>
                        <th>Status</th>
                        <th>Action</th>
                      </tr>
                    </thead>
                    <tbody>
                      <?php
                      foreach ($customerList as $key => $value) {
                          echo "<tr>";
                          echo "<td>".$value['EMAIL']."</td>";
                          echo "<td>".$value['CUSTNAME']."</td>";
                          $custtype = '';
                          if($value['CUSTTYPEID'] == 1){
                              $custtype = "Basic service";
                          }else if($value['CUSTTYPEID'] == 2){
                              $custtype = "Full service";
                          }else if($value['CUSTTYPEID'] == 3){
                              $custtype = "Merchant";
                          }
                          if($value['STATUS'] == 1){
                              $status = 'fa-check text-green';
                          }else{
                              $status = 'fa-remove text-red';
                          }
                          echo "<td>".$custtype."</td>";
                          echo "<td>".$value['CUSTCODE']."</td>";
                          echo "<td class='text-center'><i class='fa fa-fw ".$status."'></i></td>";
                          echo "<td class='text-center'>
                                  <form id='cust".$value['ID']."' method='POST' action=".base_url()."authorize/platinum_detail>
                                  <input type='hidden' name='custId' value='".$value['ID']."'>
                                  <a onclick='prosesFormPlatinum(".$value['ID'].")' style='cursor: pointer;'><i class='fa fa fa-edit' title='open'></i></a></form>
                                </td>";
                          echo "</tr>";
                      }?>
                    </tbody>
                  </table>
                </div>
              </div>
          </div>
      </div>
    </section>
    <script src="<?php echo $css_admin?>plugins/datatables/jquery.dataTables.min.js" type="text/javascript"></script>
    <script src="<?php echo $css_admin?>plugins/datatables/dataTables.bootstrap.min.js" type="text/javascript"></script>
    <!-- AdminLTE App -->
    <!-- page script -->
    <script type="text/javascript">
      $(function () {
        $("#example1").DataTable();
      });
      function prosesFormPlatinum(custId){
          $('#cust'+custId).submit();
      }
    </script>
