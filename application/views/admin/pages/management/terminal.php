<?php //print_r($cityDataList); ?>
    <link href="<?=$css_admin?>plugins/datatables/dataTables.bootstrap.css" rel="stylesheet" type="text/css" />

        <section class="content-header">
          <h1>
            Data Tables
            <small>Terminal</small>
          </h1>
        </section>

        <section class="content">
          <div class="row">
            <div class="col-xs-12">
              <div class="box">
                <div class="box-header">
                  <h3 class="box-title">Data Tables List Terminal</h3>
                </div>
                <div class="box-body table-responsive" style="overflow-x: unset">
                  <a href="<?=base_url()?>management/terminal_add" class="btn btn-block btn-success" style="width: 150px; margin-bottom: 25px;">Add Terminal</a>
                  <table id="example1" class="table table-bordered table-striped">
                    <thead>
                      <tr>
                        <th>Terminal Name</th>
                        <th>Description</th>
                        <th>Created On</th>
						<th>Status</th>
                        <th>Client Partner</th>
                        <th>Action</th>
                      </tr>
                    </thead>
                    <tbody>
                      <?php
                      foreach ($terminal as $keyProvince => $value) {
						  foreach ($partnerData as $key => $partnervalue) {
                                  if($value['CP_ID'] == $partnervalue['CP_ID']){
									  $partnerName = $partnervalue['CP_NAME'];
                                  }
						  }
                          echo "<tr>";
                          echo "<td>".$value['TERMINAL_NAME']."</td>";
						  echo "<td>".$value['DESCRIPTION']."</td>";
						  echo "<td>".$value['CREATED_ON']."</td>";
                          if($value['ACTIVE'] == 1){
                              $status = 'fa-check text-green';
                          }else{
                              $status = 'fa-remove text-red';
                          }
                          echo "<td class='text-center'><i class='fa fa-fw ".$status."'></i></td>"; 
						  echo "<td>".$partnerName."</td>";
                          echo "<td class='text-center'>
                                  <form id='prov".$value['ID']."' method='POST' action=".base_url()."management/terminal_detail>
                                  <input type='hidden' name='id' value='".$value['ID']."'>
                                  <a onclick='prosesForm(".$value['ID'].")' style='cursor: pointer;'><i class='fa fa-edit' title='edit'></i></a>
                                  &nbsp; &nbsp; &nbsp;
                                  <a onclick='prosesDelete(".$value['ID'].")' style='cursor: pointer;'><i class='fa fa-trash' title='delete'></i></a>
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
          $('#prov'+id).submit();
      }
      function prosesDelete(id){
        var conf = confirm('Delete Terminal ?');
        if(conf){
            var conf2 = confirm('Are you sure !');
            if(conf2){
                $.ajax({
                    type: "POST",
                    url: baseurl+"management/terminal_delete",
                    data: {'id': id},
                    cache: false,
                    dataType: "json",
                    success: function (res) {
                        if(res.result){
                            alert(res.message);                            
                            window.location.href = baseurl+"management/terminal";
                        }else{
                            alert(res.message);
                        }
                    }
                });
            }
        }
      }
    </script>