<link href="<?php echo $css_admin?>plugins/datatables/dataTables.bootstrap.css" rel="stylesheet" type="text/css" />

    <section class="content-header">
      <h1>
        Search
        <small>Report</small>
      </h1>
    </section>

    <section class="content">
      <div class="row">
        <div class="col-xs-12">
          <!-- Search box -->
          <div class="box box-info">
            <div class="box-header with-border">
              <h3 class="box-title">Search Report</h3>
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
                      <label for="inputEmail3" class="col-sm-2 control-label">Search Based On</label>
                      <div class="col-sm-8">
                          <select class="form-control" name="search_based" id="search_based">
                            <option value="syslog">Syslog</option>
                            <option value="email">Email</option>
                          </select>
                      </div>
                    </div>
                      <div class="form-group">
                      <label for="inputEmail3" class="col-sm-2 control-label">Search Term</label>
                      <div class="col-sm-8">
                          <input type="text" class="form-control pull-right" id="search_term" name="masukan_pencarian" />
                      </div>
                    </div>
                    </div>
                    <div class="box-footer">
                      <button type="button" class="btn btn-info pull-right" onclick="searchReport()"><b class="glyphicon glyphicon-search"></b> Search</button>
                    </div>
                </form>
          </div>
          <!-- Customer data -->
          <div class="box">
            <div class="box-header">
              <h3 class="box-title">Customer</h3>
            </div>
            <div class="col-xs-12">
              <div id="export" class="btn-group pull-right" style="margin-bottom:25px">
                <a id="export-to-pdf" href="#" class="btn btn-danger">Export To PDF</a>
                <a id="export-to-excel" href="#" class="btn btn-success">Export To Excel</a>
              </div>
            </div>
            <div class="box-body table-responsive" style="overflow-x: unset">
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
</section>
<script src="<?php echo $css_admin?>plugins/datatables/jquery.dataTables.min.js" type="text/javascript"></script>
<script src="<?php echo $css_admin?>plugins/datatables/dataTables.bootstrap.min.js" type="text/javascript"></script>
<!-- AdminLTE App -->
<!-- page script -->
<script type="text/javascript">
  // set url
  var baseurl = "<?php echo base_url()?>";
  var css_admin = "<?php echo $css_admin?>";

  $(function () {
    // $("#example1").DataTable();
  });
  function searchReport(){
      var search_based = $('#search_based').val();
      var search_term = $('#search_term').val();
      if(search_term != ''){
          $.ajax({
              type: "POST",
              url: baseurl+"report/transaksi/get_search_report",
              data: {'search_based': search_based, 'search_term' : search_term},
              cache: false,
              dataType: "json",
              success: function (res) {
                // console.log(res);
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
          alert("Please Fill Search Term");
      }
  }
  function prosesFormMerchant(custId){
      $('#'+custId).submit();
  }
</script>
