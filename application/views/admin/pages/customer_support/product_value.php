<?php //print_r($cityDataList); ?>
    <link href="<?=$css_admin?>plugins/datatables/dataTables.bootstrap.css" rel="stylesheet" type="text/css" />

        <section class="content-header">
          <h1>
            Data Product Value
            <small>Customer</small>
          </h1>
        </section>
        <section class="content">
          <div class="row">
            <div class="col-xs-12">
              <div class="box">
                <div class="box-header">
                  <h3 class="box-title">Data Product Value</h3>
                </div>
                <div class="box-body table-responsive" style="overflow-x: unset">
                  <a href="<?=base_url()?>customer_support/product_value_add" class="btn btn-block btn-success" style="width: 150px; margin-bottom: 25px;">Add Product Value</a>
                  <table id="example1" class="table table-bordered table-striped">
                    <thead>
                      <tr>
                        <th>Product Name </th>
                        <th>Product Value</th>
                        <th>Action</th>
                      </tr>
                    </thead>
                    <tbody>
                      <?php
                      $statusVal = 1;
                       foreach ($productValueData as $key => $value) {
                          echo "<tr>";
                          $prdName = '';
                          foreach ($productData as $keyPrdName => $valuePrdName) {
                              if($value['PRD_ID'] == $valuePrdName['PRD_ID']){
                                  $prdName = $valuePrdName['PRD_NAME'];
                              }
                          }
                          echo "<td>".$prdName."</td>";
                          echo "<td>".$value['PRD_VALUE']."</td>";
                          echo "<td class='text-center'>
                                  <form id='cust".$value['ID']."' method='POST' action=".base_url()."customer_support/product_value_detail>
                                  <input type='hidden' name='id' value='".$value['ID']."'>
                                  <a onclick='prosesForm(".$value['ID'].")' style='cursor: pointer;'><i class='fa fa-edit' title='open'></i></a>

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
      var baseurl = "<?=base_url()?>";
      function prosesForm(custId){
          $('#cust'+custId).submit();
      }
      function prosesDelete(id){
        var conf = confirm('Delete Product Value?');
        if(conf){
            var conf2 = confirm('Are you sure !');
            if(conf2){
                $.ajax({
                    type: "POST",
                    url: baseurl+"customer_support/product_value_delete",
                    data: {'id': id},
                    cache: false,
                    dataType: "json",
                    success: function (res) {
                        if(res.result){
                            alert(res.message);
                            window.location.href = baseurl+"customer_support/product_value";
                        }else{
                            alert(res.message);
                        }
                    }
                });
            }
        }
      }
    </script>
