<?php //print_r($cityDataList); ?>
    <link href="<?=$css_admin?>plugins/datatables/dataTables.bootstrap.css" rel="stylesheet" type="text/css" />

        <section class="content-header">
          <h1>
            List
            <small>Merchant</small>
          </h1>
        </section>

        <section class="content">
          <div class="row">
            <div class="col-xs-12">
              <div class="box">
                <div class="box-header">
                  <h3 class="box-title">Merchant</h3>
                </div>
                <div class="box-body table-responsive" style="overflow-x: unset">
                  <table id="example1" class="table table-bordered table-striped">
                    <thead>
                      <tr>
                        <th class="text-center">Merchant Name</th>
                        <th class="text-center">Merchant Code</th>
                        <th class="text-center">Registered</th>
                        <th class="text-center">Status</th>
                      </tr>
                    </thead>
                    <tbody>
                      <?php
                      foreach ($merchantList as $keyM => $valueM) {
                          echo "<tr>";
                          echo "<td>
                                    <form id='cust".$valueM['ID']."' method='POST' action=".base_url('customer_info/merchant_detail').">
                                    <input type='hidden' name='custId' value='".$valueM['ID']."'>
                                    <a onclick='prosesFormMerchant(".$valueM['ID'].")' style='cursor: pointer;'>".$valueM['CUSTNAME']."</a>
                                    </form>
                                </td>";
                          echo "<td>".$valueM['CUSTCODE']."</td>";
                          echo "<td>".$valueM['CREATEDON']."</td>";

                          if ($valueM['STATUS'] == 1)
                            echo "<td class='text-center'>Active</td>";
                          else
                            echo "<td class='text-center'>Inactive</td>";
                          echo "</tr>";
                      }?>
                    </tbody>
                  </table>
                </div>
              </div>
          </div>
      </div>
    </section>
    <script src="<?=$css_admin?>plugins/datatables/jquery.dataTables.min.js" type="text/javascript"></script>
    <script src="<?=$css_admin?>plugins/datatables/dataTables.bootstrap.min.js" type="text/javascript"></script>
    <!-- AdminLTE App -->
    <!-- page script -->
    <script type="text/javascript">
      $(function () {
        $("#example1").DataTable();
      });
      function prosesFormMerchant(custId){
          $('#cust'+custId).submit();
      }
    </script>
