<?php //print_r($cityDataList); ?>
    <link href="<?=$css_admin?>plugins/datatables/dataTables.bootstrap.css" rel="stylesheet" type="text/css" />

        <section class="content-header">
          <h1>
            Data Tables
            <small>Partner</small>
          </h1>
        </section>

        <section class="content">
          <div class="row">
            <div class="col-xs-12">
              <div class="box">
                <div class="box-header">
                  <h3 class="box-title">Data Tables List Partner</h3>
                </div>
                <div class="box-body table-responsive" style="overflow-x: unset">
                  <a href="<?=base_url()?>management/partner_add" class="btn btn-block btn-success" style="width: 150px; margin-bottom: 25px;">Add Partner</a>
                  <table id="example1" class="table table-bordered table-striped">
                    <thead>
                      <tr>
                        <th>Partner Name</th>
                        <th>Code</th>
                        <th>Public Key</th>
						<th>Private Key</th>
                        <th>Description</th>
                        <th>Active</th>
                        <th>Action</th>
                      </tr>
                    </thead>
                    <tbody>
                      <?php
                      foreach ($partnerData as $keyProvince => $value) {
                          echo "<tr>";
                          echo "<td>".$value['CP_NAME']."</td>";
						  echo "<td>".$value['CP_CODE']."</td>";
						  echo "<td>".$value['CP_PUBLIC_KEY']."</td>";
						  echo "<td>".$value['CP_PRIVATE_KEY']."</td>";
						  echo "<td>".$value['CP_DESCRIPTION']."</td>";
                          if($value['STATUS'] == 1){
                              $status = 'fa-check text-green';
                          }else{
                              $status = 'fa-remove text-red';
                          }
                          echo "<td class='text-center'><i class='fa fa-fw ".$status."'></i></td>"; 
                          echo "<td class='text-center'>
                                  <form id='prov".$value['CP_ID']."' method='POST' action=".base_url()."management/partner_detail>
                                  <input type='hidden' name='id' value='".$value['CP_ID']."'>
                                  <a onclick='prosesForm(".$value['CP_ID'].")' style='cursor: pointer;'><i class='fa fa-edit' title='edit'></i></a>
                                  &nbsp; &nbsp; &nbsp;
                                  <a onclick='prosesDelete(".$value['CP_ID'].")' style='cursor: pointer;'><i class='fa fa-trash' title='delete'></i></a>
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
        var conf = confirm('Delete Partner ?');
        if(conf){
            var conf2 = confirm('Are you sure !');
            if(conf2){
                $.ajax({
                    type: "POST",
                    url: baseurl+"management/partner_delete",
                    data: {'id': id},
                    cache: false,
                    dataType: "json",
                    success: function (res) {
                        if(res.result){
                            alert(res.message);                            
                            window.location.href = baseurl+"management/partner";
                        }else{
                            alert(res.message);
                        }
                    }
                });
            }
        }
      }
    </script>