<?php //print_r($cityDataList); ?>
    <link href="<?php echo $css_admin?>plugins/datatables/dataTables.bootstrap.css" rel="stylesheet" type="text/css" />

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
                  <h3 class="box-title">Data Tables User Level CMS</h3>
                </div>
                <div class="box-body table-responsive" style="overflow-x: unset">
                  <a href="<?php echo base_url()?>security/user_level_add" class="btn btn-block btn-success" style="width: 150px; margin-bottom: 25px;">Add User Level</a>
                  <table id="example1" class="table table-bordered table-striped">
                    <thead>
                      <tr>
                        <th>User Level Name</th>
                        <th>Description</th>
                        <!-- <th>Status</th> -->
                        <th>Action</th>
                      </tr>
                    </thead>
                    <tbody>
                      <?php
                      $statusVal = 1;
                      foreach ($levelList as $key => $value) {
                          echo "<tr>";
                          echo "<td>".$value['LEVELNAME']."</td>";
                          echo "<td>".$value['DESCRIPTION']."</td>";
                          if($statusVal == 1){
                              $status = 'fa-check text-green';
                          }else{
                              $status = 'fa-remove text-red';
                          }
                          // echo "<td class='text-center'><i class='fa fa-fw ".$status."'></i></td>";
                          echo "<td class='text-center'>
                                  <form id='id".$value['ID']."' method='POST' action=".base_url()."security/user_level_detail>
                                  <input type='hidden' name='id' value='".$value['ID']."'>
                                  <a onclick='prosesFormLevel(".$value['ID'].")' style='cursor: pointer;'><i class='fa fa-edit' title='edit'></i></a>
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
    <script src="<?php echo $css_admin?>plugins/datatables/jquery.dataTables.min.js" type="text/javascript"></script>
    <script src="<?php echo $css_admin?>plugins/datatables/dataTables.bootstrap.min.js" type="text/javascript"></script>
    <!-- AdminLTE App -->
    <!-- page script -->
    <script type="text/javascript">
    var baseurl = "<?php echo base_url()?>";
      $(function () {
        $("#example1").DataTable();
      });
      function prosesFormLevel(id){
          $('#id'+id).submit();
      }
      function prosesDelete(levelId){
        var conf = confirm('Delete User Level ?');
        if(conf){
            var conf2 = confirm('Are you sure !');
            if(conf2){
                $.ajax({
                    type: "POST",
                    url: baseurl+"security/user_level_delete",
                    data: {'levelId': levelId},
                    cache: false,
                    dataType: "json",
                    success: function (res) {
                        // console.log(res.message);
                        if(res.result){
                            alert(res.message);
                            window.location.href = baseurl+"security/user_level";
                        }else{
                            alert(res.message);
                        }
                    }
                });
            }
        }
      }
    </script>
