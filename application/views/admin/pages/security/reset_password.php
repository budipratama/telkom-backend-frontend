<?php //print_r($cityDataList); ?>
    <link href="<?=$css_admin?>plugins/datatables/dataTables.bootstrap.css" rel="stylesheet" type="text/css" />

        <section class="content-header">
          <h1>
            Data User
            <small>CMS</small>
          </h1>
        </section>

        <section class="content">
          <div class="row">
            <div class="col-xs-12">
              <div class="box">
                <div class="box-header">
                  <h3 class="box-title">Data Tables User CMS</h3>
                </div>
                <div class="box-body table-responsive" style="overflow-x: unset">
                  <table id="example1" class="table table-bordered table-striped">
                    <thead>
                      <tr>
                        <th>User Name</th>
                        <th>Status</th>
                        <th>Action</th>
                      </tr>
                    </thead>
                    <tbody>
                      <?php
                      $statusVal = 1;
                      foreach ($userCmsList as $key => $value) {
                          echo "<tr>";
                          echo "<td>".$value['USERNAME']."</td>";
                          if($value['STATUS'] == 1){
                              $status = 'fa-check text-green';
                          }else{
                              $status = 'fa-remove text-red';
                          }
                          echo "<td class='text-center'><i class='fa fa-fw ".$status."'></i></td>";                          
                          echo "<td class='text-center'>
                                  <form id='cust".$value['ID']."' method='POST' action=".base_url()."security/reset_password_detail>
                                  <input type='hidden' name='userId' value='".$value['ID']."'>
                                  <a onclick='prosesFormMerchant(".$value['ID'].")' style='cursor: pointer;'><i class='fa fa-edit' title='edit'></i></a>
                                  </form>
                                </td>";
                          echo "</tr>";
                      }
                      ?>
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