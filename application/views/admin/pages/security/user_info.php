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
                  <h3 class="box-title">Data Tables User Info CMS</h3>
                </div>
                <div class="box-body table-responsive" style="overflow-x: unset">
                  <a href="<?=base_url()?>security/user_info_add" class="btn btn-block btn-success" style="width: 150px; margin-bottom: 25px;">Add User Info</a>
                  <table id="example1" class="table table-bordered table-striped">
                    <thead>
                      <tr>
                        <th>User Name</th>
                        <th>User Real Name</th>
                        <th>User Level</th>
                        <!-- <th>Plasa Telkom Name</th> -->
                        <!-- <th>Status</th> -->
                        <th>Action</th>
                      </tr>
                    </thead>
                    <tbody>
                      <?php
                      foreach ($userCmsList as $key => $value) {
                          echo "<tr>";
                          echo "<td>".$value['USERNAME']."</td>";
                          echo "<td>".$value['REALNAME']."</td>";
                          $levelName = '';
                          foreach ($levelList as $keyLevel => $valueLevel) {
                              if($value['LEVEL'] == $valueLevel['ID']){
                                  $levelName = $valueLevel['LEVELNAME'];
                              }
                          }
                          echo "<td>".$levelName."</td>";
                          if($value['STATUS'] == 1){
                              $status = 'fa-check text-green';
                          }else{
                              $status = 'fa-remove text-red';
                          }
                          // echo "<td class='text-center'><i class='fa fa-fw ".$status."'></i></td>";
                          echo "<td class='text-center'>
                                  <form id='user".$value['ID']."' method='POST' action=".base_url()."security/user_info_detail>
                                  <input type='hidden' name='userId' value='".$value['ID']."'>
                                  <a onclick='prosesForm(".$value['ID'].")' style='cursor: pointer;'><i class='fa fa-edit' title='edit'></i></a>
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
      var baseurl = "<?=base_url()?>";
      $(function () {
        $("#example1").DataTable();
      });
      function prosesForm(custId){
          $('#user'+custId).submit();
      }
      function prosesDelete(id){
        var conf = confirm('Delete User Info ?');
        if(conf){
            var conf2 = confirm('Are you sure !');
            if(conf2){
                $.ajax({
                    type: "POST",
                    url: baseurl+"security/user_info_delete",
                    data: {'id': id},
                    cache: false,
                    dataType: "json",
                    success: function (res) {
                        if(res.result){
                            alert(res.message);
                            window.location.href = baseurl+"security/user_info";
                        }else{
                            alert(res.message);
                        }
                    }
                });
            }
        }
      }
    </script>
