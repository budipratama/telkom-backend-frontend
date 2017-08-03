<link href="<?php echo $css_admin?>plugins/datatables/dataTables.bootstrap.css" rel="stylesheet" type="text/css" />

    <section class="content-header">
      <h1>
        List
        <small>Customer</small>
      </h1>
    </section>

    <section class="content">
      <div class="row">
        <div class="col-xs-12">
          <!-- Search box -->
          <div class="box box-info">
            <div class="box-header with-border">
              <h3 class="box-title">Search Customer</h3>
            </div>
                <form id="search" class="form-horizontal">
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
                          <select class="form-control" name="search_based">
                            <option value="nama">Name</option>
                            <option value="email">Email</option>
                          </select>
                      </div>
                    </div>
                      <div class="form-group">
                      <label for="inputEmail3" class="col-sm-2 control-label">Search Term</label>
                      <div class="col-sm-8">
                          <input type="text" class="form-control pull-right" name="masukan_pencarian" />
                      </div>
                    </div>
                    </div>
                    <div class="box-footer">
                      <button id="btn-search" type="button" class="btn btn-info pull-right" onclick="searchCustomer()"><b class="glyphicon glyphicon-search"></b> Search</button>
                    </div>
                </form>
          </div>
          <!-- Customer data -->
          <div class="box">
            <div class="box-header">
              <h3 class="box-title">Customer</h3>
            </div>
            <div class="box-body table-responsive" style="overflow-x: unset">
              <table id="customerTable" class="table table-bordered table-striped">
                <thead>
                  <tr>
                    <th>Code</th>
                    <th>Email</th>
                    <th>Cust Code</th>
                    <th>Cust Type</th>
                    <th>Registered</th>
                    <th>Pass Fail Count</th>
                    <th>Unblock Cust</th>
                    <th>Status</th>
                  </tr>
                </thead>
                <tbody id="customerTableBody">
                  <tr>
                    <td colspan="7" class="text-center">Search Customer</td>
                  </tr>
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

  $('#search').on('submit', function(e){
    e.preventDefault();

    $('#btn-search').trigger('click');
  });

  function prosesFormMerchant(custId){
      $('#'+custId).submit();
  }

  // unblock
  function unblock(custId){
        $.ajax({
            type: "POST",
            url: baseurl+"customer_info/ajax_set_block",
            data: {'custId': custId, blockStatus: 0},
            cache: false,
            dataType: "json",
            success: function (result) {
              if(result.status){
                alert("Unblock success");
                // refresh
                searchCustomer();
              }
              else{
                alert("Unblock failed"); return;
              }
            }
        });
  }

  // block
  function block(custId){
        $.ajax({
            type: "POST",
            url: baseurl+"customer_info/ajax_set_block",
            data: {'custId': custId, blockStatus: 1},
            cache: false,
            dataType: "json",
            success: function (result) {
              if(result.status){
                alert("Block success");
                // refresh
                searchCustomer();
              }
              else{
                alert("Block failed"); return;
              }
            }
        });
  }

  // search customer
  function searchCustomer(){
    // set value
    var search_based = $('select[name="search_based"]').val();
    var masukan_pencarian = $('input[name="masukan_pencarian"]').val();

    // validation
    if(search_based == ''){
      alert('Pilih field masukan berdasarkan');
    }
    else if(masukan_pencarian == ''){
      alert('Isi field masukan pencarian');
    }

    // get data
    else{
        $.ajax({
            type: "POST",
            url: baseurl+"customer_info/ajax_search_customer",
            data: {'search_based': search_based, 'masukan_pencarian' : masukan_pencarian},
            cache: false,
            dataType: "json",
            success: function (result) {
              // set not found
              if(result.length <= 0){
                alert("Data Not Found. Try another value."); return;
              }

              // set table
              var val = '';
              $.each(result, function (keyRep, valRep) {
                // set block button
                if (valRep['login_failed'] >= 3) {
                  var blockButton = '<a onclick="unblock('+valRep['cust_id']+')" style="cursor: pointer;">Unblock</a>';
                }
                else{
                  var blockButton = '<a onclick="block('+valRep['cust_id']+')" style="cursor: pointer;">Block</a>';
                }

                var cust_status = (valRep['cust_status'] == 1) ? 'Active' : 'Inactive';

                val += '<tr>'+
                      '<td>'+
                        '<form id="'+valRep['cust_id']+'" method="POST" action="'+baseurl+'customer_info/customer_detail">'+
                          '<input type="hidden" name="custId" value="'+valRep['cust_id']+'">'+
                          '<a onclick="prosesFormMerchant('+valRep['cust_id']+')" style="cursor: pointer;">'+valRep['cust_code']+'</a>'+
                        '</form>'+
                      '</td>'+
                      '<td>'+valRep['cust_email']+'</td>'+
                      '<td>'+valRep['cust_code']+'</td>'+
                      '<td>'+valRep['cust_type']+'</td>'+
                      '<td>'+valRep['registered_date']+'</td>'+
                      '<td class="text-center">'+valRep['login_failed']+'</td>'+
                      '<td class="text-center">'+
                          blockButton+
                      '</td>'+
                      '<td class="text-center">'+cust_status+'</td>'+
                 '</tr>';
              });
              val += '<link href="'+css_admin+'"plugins/datatables/dataTables.bootstrap.css" rel="stylesheet" type="text/css" />';

              // destroy
              if ($.fn.dataTable.isDataTable('#customerTable')) {
                $("#customerTable").DataTable().destroy();
              }

              // create table
              $('#customerTableBody').html(val);
              $("#customerTable").DataTable({
                pageLength: 10,
              });
            }
        });
    }
  }
</script>
