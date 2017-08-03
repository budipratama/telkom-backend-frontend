<?php //print_r($cityDataList); ?>
<link href="<?=$css_admin?>plugins/datatables/dataTables.bootstrap.css" rel="stylesheet" type="text/css" />

    <section class="content-header">
      <h1>
        Data Vendor
        <small>Customer</small>
      </h1>
    </section>

    <section class="content">
      <div class="row">
        <div class="col-xs-12">
          <div class="box">
            <div class="box-header">
              <h3 class="box-title">Data Vendor</h3>
            </div>
              <div class="box-body table-responsive" style="overflow-x: unset">
              <a href="<?=base_url()?>customer_support/vendor_profile_add" class="btn btn-block btn-success" style="width: 150px; margin-bottom: 25px;">Add Vendor</a>
              <table id="example1" class="table table-bordered table-striped">
                <thead>
                  <tr>
                    <th>Vendor Code</th>
                    <th>Vendor Name</th>
                    <th>Telco Code</th>
                    <th>Vendor Account</th>
                    <th>Bank Account</th>
                    <th>Status</th>
                     <th>Action</th>
                  </tr>
                </thead>
                <tbody>
                    <?php
                    foreach ($vendorData as $keyProvince => $value) {
                          echo "<tr>";
                          echo "<td>".$value['VENDOR_CODE']."</td>";
                          echo "<td>".$value['VENDOR_NAME']."</td>";
                          echo "<td>".$value['TELCO_CODE']."</td>";
                          echo "<td>".$value['VENDOR_ACCOUNT']."</td>";
                          echo "<td>".$value['BANK_ACCOUNT']."</td>";
                          if($value['STATUS'] == 1){
                              $status = 'fa-check text-green';
                          }else{
                              $status = 'fa-remove text-red';
                          }
                          echo "<td class='text-center'><i class='fa fa-fw ".$status."'></i></td>";
                          echo "<td class='text-center'>
                                  <form id='vendor".$value['ID']."' method='POST' action=".base_url()."customer_support/vendor_profile_detail>
                                  <input type='hidden' name='id' value='".$value['ID']."'>
                                  <a onclick='prosesForm(".$value['ID'].")' style='cursor: pointer;'><i class='fa fa-edit' title='edit'></i></a>
                                  </form>
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
<script src="<?=$css_admin?>plugins/datatables/jquery.dataTables.min.js" type="text/javascript"></script>
<script src="<?=$css_admin?>plugins/datatables/dataTables.bootstrap.min.js" type="text/javascript"></script>
<!-- AdminLTE App -->
<!-- page script -->
<script type="text/javascript">
    var baseurl = "<?=base_url()?>";
    $(function () {
      $("#example1").DataTable();
    });
    function prosesForm(id){
        $('#vendor'+id).submit();
    }
    function prosesDelete(id){
        var conf = confirm('Delete Vendor ?');
        if(conf){
            var conf2 = confirm('Are you sure !');
            if(conf2){
                $.ajax({
                    type: "POST",
                    url: baseurl+"customer_support/vendor_profile_delete",
                    data: {'id': id},
                    cache: false,
                    dataType: "json",
                    success: function (res) {
                        if(res.result){
                            alert(res.message);
                            window.location.href = baseurl+"customer_support/vendor_profile";
                        }else{
                            alert(res.message);
                        }
                    }
                });
            }
        }
    }
</script>
