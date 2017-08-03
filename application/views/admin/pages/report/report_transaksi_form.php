<link href="<?php echo $css_admin?>plugins/daterangepicker/daterangepicker-bs3.css" rel="stylesheet" type="text/css" />
<link href="<?php echo $css_admin?>plugins/datatables/dataTables.bootstrap.css" rel="stylesheet" type="text/css" />

<section class="content-header">
    <h1>
      <?php echo $title_page?>
      <small></small>
    </h1>
</section>
<section class="content">
    <div class="row">
    <?php //print_r($customerData);?>
        <div class="col-md-12">
          <div class="box box-info">
            <div class="box-header with-border">
              <h3 class="box-title">Select Report</h3>
            </div>
                <form class="form-horizontal">
                  <div class="box-body">
                    <div class="errorMessage hide alert alert-danger alert-dismissable">
                        <span class="messageText"></span>
                    </div>
                    <div class="successMessage hide alert alert-success alert-dismissable">
                        <span class="messageText"></span>
                    </div>
                    <div class="form-group">
                      <label for="inputEmail3" class="col-sm-2 control-label">Report</label>
                      <div class="col-sm-8">
                          <select class="form-control" id="trxCode" name="trxCode" >
                              <?php foreach ($trxRefCodeData as $key => $value) {
                                  $selected = '';
                                  if($refCodeActive == $value['REF_ID']){
                                      $selected = 'selected';
                                  }
                                  echo "<option value='".$value['REF_CODE']."' ".$selected.">".$value['REF_CODE']."</option>";
                              }
                              ?>
                          </select>
                      </div>
                    </div>
                      <div class="form-group">
                      <label for="inputEmail3" class="col-sm-2 control-label">Report Date Range</label>
                      <div class="col-sm-8">
                        <div class="input-group">
                          <div class="input-group-addon">
                            <i class="fa fa-calendar"></i>
                          </div>
                            <input type="text" class="form-control pull-right" id="reservation" name="reservation" />
                        </div>
                      </div>
                    </div>
                    </div>
                    <div class="box-footer">
                      <!--<a href="<?php echo base_url()?>setting/tarif_template_body" class="btn btn-default">Cancel</a>-->
                      <button type="button" class="btn btn-info pull-right" onclick="viewReport()">View</button>
                    </div>
                </form>
          </div>
          <div class="row">
            <div class="col-xs-12">
              <div class="box">
                <div class="box-header">
                  <h3 class="box-title">Report</h3>
                </div>
                  <div class="col-xs-12">
                    <div id="export" class="btn-group pull-right" style="margin-bottom:25px">
                      <a id="export-to-pdf" href="#" class="btn btn-danger">Export To PDF</a>
                      <a id="export-to-excel" href="#" class="btn btn-success">Export To Excel</a>
                    </div>
                  </div>
                  <div class="clearfix"></div>
                  <div class="box-body table-responsive" style="overflow-x: unset">
                  <!--<a href="#" class="btn btn-block btn-success" style="width: 150px; margin-bottom: 25px;">XLS</a>-->
                  <table id="example1" class="table table-bordered table-striped">
                    <thead>
                      <tr>
                        <th>Receive Time</th>
                        <th>Invoice Number</th>
                        <th>TRX ID</th>
                        <th>Trx Value</th>
                        <th>Tahapan</th>
                        <th>Status</th>

                      </tr>
                    </thead>
                    <tbody class="reportView">

                    </tbody>
                  </table>
                </div>
              </div>
          </div>
      </div>
        </div>
    </div>
</section>
<script src="<?php echo $css_admin?>plugins/input-mask/jquery.inputmask.js" type="text/javascript"></script>
<script src="<?php echo $css_admin?>plugins/input-mask/jquery.inputmask.date.extensions.js" type="text/javascript"></script>
<script src="<?php echo $css_admin?>plugins/input-mask/jquery.inputmask.extensions.js" type="text/javascript"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.10.2/moment.min.js" type="text/javascript"></script>
<script src="<?php echo $css_admin?>plugins/daterangepicker/daterangepicker.js" type="text/javascript"></script>
    <script src="<?php echo $css_admin?>plugins/datatables/jquery.dataTables.min.js" type="text/javascript"></script>
    <script src="<?php echo $css_admin?>plugins/datatables/dataTables.bootstrap.min.js" type="text/javascript"></script>
<script type="text/javascript">
    var baseurl = "<?php echo base_url()?>";
    var css_admin = "<?php echo $css_admin?>";
    function viewReport(){
        var trxCode = $('#trxCode').val();
        var reservation = $('#reservation').val();
        if(reservation != ''){
            $.ajax({
                type: "POST",
                url: baseurl+"report/transaksi/get_report",
                data: {'trxCode': trxCode, 'reservation' : reservation},
                cache: false,
                dataType: "json",
                success: function (res) {
                    var val = '';
                    $.each(res.data, function (keyRep, valRep) {
                      var tahapan = '';
                      var stat = '';

                      if(valRep['LASTSTATE'] == 1){
                          tahapan = "Incomplete";
                      }else{
                          tahapan = "Complete";
                      }

                      if(valRep['LASTRC'] == 0){
                          stat = "Success";
                      }else{
                          stat = "Failed";
                      }


                            val += '<tr>'+
                                        '<td>'+valRep['RCVTIME']+'</td>'+
                                        '<td>'+valRep['INVOICENO']+'</td>'+
                                        '<td>'+valRep['SYSLOGNO']+'</td>'+
                                        '<td>'+valRep['TRXVALUE']+'</td>'+
                                        '<td>'+tahapan+'</td>'+
                                        '<td>'+stat+'</td>'+
                                   '</tr>';
                    });
                    val += '<link href="'+css_admin+'"plugins/datatables/dataTables.bootstrap.css" rel="stylesheet" type="text/css" />';

                    // destroy
                    if ($.fn.dataTable.isDataTable('#example1')) {
                      $("#example1").DataTable().destroy();
                    }

                    $('.reportView').html(val);
                    $("#example1").DataTable();

                    // embed report query
                    $('#export-to-pdf').attr('href',baseurl+'report/export_to_pdf?data='+res.export_query);
                    $('#export-to-excel').attr('href',baseurl+'report/export_to_excel?data='+res.export_query);
                }
            });
        }else{
            alert("Select Report date range");
        }
    }

    $('#reservation').daterangepicker();
        //Date range picker with time picker
        $('#reservationtime').daterangepicker({timePicker: true, timePickerIncrement: 30, format: 'MM/DD/YYYY h:mm A'});
        //Date range as a button
        $('#daterange-btn').daterangepicker(
                {
                  ranges: {
                    'Today': [moment(), moment()],
                    'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
                    'Last 7 Days': [moment().subtract(6, 'days'), moment()],
                    'Last 30 Days': [moment().subtract(29, 'days'), moment()],
                    'This Month': [moment().startOf('month'), moment().endOf('month')],
                    'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
                  },
                  startDate: moment().subtract(29, 'days'),
                  endDate: moment()
                },
        function (start, end) {
          $('#reportrange span').html(start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'));
        }
        );

</script>
