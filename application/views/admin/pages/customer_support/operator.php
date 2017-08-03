<?php //print_r($cityDataList); ?>
    <link href="<?=$css_admin?>plugins/datatables/dataTables.bootstrap.css" rel="stylesheet" type="text/css" />

        <section class="content-header">
          <h1>
            Data Operator
            <small>Customer</small>
          </h1>
        </section>
        <section class="content">
          <div class="row">
            <!-- alert -->
            <?php if($msg = $this->session->flashdata('msg-success')): ?>
              <div class="col-lg-12">
                <div class="alert alert-success">
                  <?php echo $msg; ?>
                </div>
              </div>
            <?php endif; ?>
          </div>
          <div class="row">
            <div class="col-xs-12">
              <div class="box">
                <div class="box-header">
                  <h3 class="box-title">Data Operator</h3>
                </div>
                <div class="box-body table-responsive" style="overflow-x: unset">
                  <a href="<?php echo site_url('customer_support/operator_add'); ?>" class="btn btn-block btn-success" style="width: 150px; margin-bottom: 25px;">Add Operator</a>
                  <table id="example1" class="table table-bordered table-striped">
                    <thead>
                      <tr>
                        <th class='text-center'>Operator Name</th>
                         <th class='text-center'>Status</th>
                        <th class='text-center'>Action</th>
                      </tr>
                    </thead>
                    <tbody>
                      <?php $num = 1; ?>
                      <?php foreach ($operator as $item): ?>
                        <tr>
                          <td><?php echo $item->OP_NAME; ?></td>
                          <td class="text-center"><?php echo ($item->OP_ACTIVE == 1) ? 'Active' : 'Inactive'; ?></td>
                          <td class="text-center">
                            <a href="<?php echo site_url('customer_support/operator_detail/' . $item->OP_ID) ?>" style='cursor: pointer;'><i class='fa fa-edit' title='open'></i></a>
                          </td>
                        </tr>
                        <?php $num++; ?>
                      <?php endforeach; ?>
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
