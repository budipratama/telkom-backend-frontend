<?php //print_r($cityDataList); ?>
<link href="<?=$css_admin?>plugins/datatables/dataTables.bootstrap.css" rel="stylesheet" type="text/css" />

    <section class="content-header">
      <h1>
        Customer Level
        <small>Level</small>
      </h1>
    </section>

    <section class="content">
      <div class="row">
        <div class="col-xs-12">
          <div class="box">
            <div class="box-header">
              <h3 class="box-title">Customer Level Level</h3>
            </div>
            <div class="box-body table-responsive" style="overflow-x: unset">
              <a href="<?=base_url()?>management/customer_level_add" class="btn btn-block btn-success" style="width: 150px; margin-bottom: 25px;">Add Customer Level</a>
                <table id="example1" class="table table-bordered table-striped">
                <thead>
                  <tr>
                    <th>Level Name</th>
                    <th>Level Deskripsi</th>
                    <th>Status</th>
                    <th>Action</th>
                  </tr>
                </thead>
                <tbody>
                  <?php
                  foreach ($listLevel as $key => $value) {
                      echo "<tr>";
                      echo "<td>".$value['LEVEL_NAME']."</td>";
                      echo "<td>".$value['LEVEL_DESC']."</td>";
                      if($value['LEVEL_STATUS'] == 1){
                          $status = 'fa-check text-green';
                      }else{
                          $status = 'fa-remove text-red';
                      }
                      echo "<td class='text-center'><i class='fa fa-fw ".$status."'></i></td>";
                      echo "<td class='text-center'>
                                <form id='id".$value['ID']."' method='POST' action=".base_url()."management/customer_level_detail>
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
  function prosesForm(custId){
      $('#id'+custId).submit();
  }
  function prosesFormLevelAlert(){
      alert("under development");
  }
  function prosesDelete(levelId){
        var conf = confirm('Delete Customer Level ?');
        if(conf){
            var conf2 = confirm('Are you sure !');
            if(conf2){
                $.ajax({
                    type: "POST",
                    url: baseurl+"management/customer_level_delete",
                    data: {'levelId': levelId},
                    cache: false,
                    dataType: "json",
                    success: function (res) {
                        if(res.result){
                            alert(res.message);
                            window.location.href = baseurl+"management/customer_level";
                        }else{
                            alert(res.message);
                        }
                    }
                });
            }
        }
      }
</script>
