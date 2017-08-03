<?php //print_r($cityDataList); ?>
    <link href="<?=$css_admin?>plugins/datatables/dataTables.bootstrap.css" rel="stylesheet" type="text/css" />
        <section class="content-header">
          <h1>
            Data Tarif Template
            <small>Customer</small>
          </h1>
        </section>

        <section class="content">
          <div class="row">
            <div class="col-xs-12">
              <div class="box">
                <div class="box-header">
                  <h3 class="box-title">Data Tarif template</h3>
                </div>
                  <div class="box-body table-responsive" style="overflow-x: unset">
                  <a href="<?=base_url()?>setting/tarif_template_add" class="btn btn-block btn-success" style="width: 150px; margin-bottom: 25px;">Add Tarif Template</a>
                  <table id="example1" class="table table-bordered table-striped">
                    <thead>
                      <tr>
                        <th>Tarif tempate Name</th>
                        <!-- <th>Tarif template ID</th> -->
                        <th>Description</th>
                        <th>Status</th>
                        <th>Action</th>
                      </tr>
                    </thead>
                    <tbody>
                      <?php
                      $statusVal = 1;
                      foreach ($tarifHeaderData as $key => $value) {
                          echo "<tr>";
                          echo "<td>".$value['FH_NAME']."</td>";
                          echo "<td>".$value['DESCRIPTION']."</td>";
                          if($value['FH_STATUS'] == 1){
                              $status = 'fa-check text-green';
                          }else{
                              $status = 'fa-remove text-red';
                          }
                          echo "<td class='text-center'><i class='fa fa-fw ".$status."'></i></td>";
                          echo "<td class='text-center'>
                                  <form id='fh".$value['FH_ID']."' method='POST' action=".base_url()."setting/tarif_template_detail>
                                  <input type='hidden' name='id' value='".$value['FH_ID']."'>
                                  <a onclick='prosesForm(".$value['FH_ID'].")' style='cursor: pointer;'><i class='fa fa-edit' title='edit'></i></a>
                                  </form>
                                </td>";
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
        function prosesForm(id){
            $('#fh'+id).submit();
        }
        function prosesDelete(id){
          var conf = confirm('Delete Tarif template ?');
          if(conf){
              var conf2 = confirm('Are you sure !');
              if(conf2){
                  $.ajax({
                      type: "POST",
                      url: baseurl+"setting/tarif_template_delete",
                      data: {'id': id},
                      cache: false,
                      dataType: "json",
                      success: function (res) {
                          if(res.result){
                              alert(res.message);
                              window.location.href = baseurl+"setting/tarif_template";
                          }else{
                              alert(res.message);
                          }
                      }
                  });
              }
          }
        }
    </script>
