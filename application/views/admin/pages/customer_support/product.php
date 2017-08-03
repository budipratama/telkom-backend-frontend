<?php //print_r($cityDataList); ?>
    <link href="<?=$css_admin?>plugins/datatables/dataTables.bootstrap.css" rel="stylesheet" type="text/css" />

        <section class="content-header">
          <h1>
            Data Product
            <small>Customer</small>
          </h1>
        </section>

        <section class="content">
          <div class="row">
            <div class="col-xs-12">
              <div class="box">
                <div class="box-header">
                  <h3 class="box-title">Data Product</h3>
                </div>
                <div class="box-body table-responsive" style="overflow-x: unset">
                  <a href="<?=base_url()?>customer_support/product_add" class="btn btn-block btn-success" style="width: 150px; margin-bottom: 25px;">Add Product</a>
                  <table id="example1" class="table table-bordered table-striped">
                    <thead>
                      <tr>
                        <th class='text-center'>Product Code</th>
                        <th class='text-center'>Product Name</th>
                        <th class='text-center'>Product Type</th>
                        <th class='text-center'>Product Order</th>
                         <th class='text-center'>Status</th>
                        <th class='text-center'>Action</th>
                      </tr>
                    </thead>
                    <tbody>
                      <?php
                      $statusVal = 1;
                      foreach ($productData as $key => $value) {
                          echo "<tr>";
                          echo "<td>".$value['PRD_CODE']."</td>";
                          echo "<td>".$value['PRD_NAME']."</td>";
                          echo "<td>".$value['TYPE_NAME']."</td>";
                          echo "<td class='text-center'>".$value['PRD_ORDER']."</td>";
                           if($value['PRD_ACTIVE'] == 1){
                               $status = 'fa-check text-green';
                           }else{
                               $status = 'fa-remove text-red';
                           }
                           echo "<td class='text-center'><i class='fa fa-fw ".$status."'></i></td>";
                          echo "<td class='text-center'>
                                  <form id='cust".$value['PRD_ID']."' method='POST' action=".base_url()."customer_support/product_detail>
                                  <input type='hidden' name='id' value='".$value['PRD_ID']."'>
                                  <a onclick='prosesForm(".$value['PRD_ID'].")' style='cursor: pointer;'><i class='fa fa-edit' title='open'></i></a>

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
        $("#example1").DataTable({
          "sorting": [],
        });
      });
      var baseurl = "<?=base_url()?>";
      function prosesForm(custId){
          $('#cust'+custId).submit();
      }
      function prosesDelete(id){
        var conf = confirm('Delete Product ?');
        if(conf){
            var conf2 = confirm('Are you sure !');
            if(conf2){
                $.ajax({
                    type: "POST",
                    url: baseurl+"customer_support/product_delete",
                    data: {'id': id},
                    cache: false,
                    dataType: "json",
                    success: function (res) {
                        if(res.result){
                            alert(res.message);
                            window.location.href = baseurl+"customer_support/product";
                        }else{
                            alert(res.message);
                        }
                    }
                });
            }
        }
      }
    </script>
