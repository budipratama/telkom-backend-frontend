
<section class="content-header">
    <h1>
      Customer
      <small>Detail</small>
    </h1>
</section>
<section class="content">
    <div class="row">
    <?php //print_r($customerData);?>
        <div class="col-md-12">
          <div class="box box-info">
            <div class="box-header with-border">
              <h3 class="box-title">Data Customer</h3>
            </div>
            <form class="form-horizontal">
              <div class="box-body">
                <div class="form-group">
                  <label for="inputEmail3" class="col-sm-2 control-label">Customer Type</label>
                  <div class="col-sm-8">
                    <?php

                        foreach ($customerLevel as $keyL => $valueL) {
                            $levelName = '';
                            if($customerData[0]['CUSTTYPEID'] == $valueL['ID']){
                                $levelName = $valueL['LEVEL_NAME'];
                                break;
                            }
                        }
                    ?>
                    <input type="text" disabled class="form-control" value="<?php echo  $levelName; ?>">
                  </div>
                </div>
                <div class="form-group">
                  <label for="inputEmail3" class="col-sm-2 control-label">Customer Code</label>
                  <div class="col-sm-8">
                    <input type="text" disabled class="form-control" value="<?php echo $customerData[0]['CUSTCODE']?>">
                    <input type="hidden" disabled class="form-control" id="custId" value="<?php echo $customerData[0]['ID']?>">
                  </div>
                </div>
                <div class="form-group">
                  <label for="inputEmail3" class="col-sm-2 control-label">Approval Status</label>
                  <div class="col-sm-5">
                      <select class="form-control" id="approval" disabled>
                        <option value="-">- No Status -</option>
                        <option value="1">Diterima</option>
                        <option value="0">Ditolak</option>
                      </select>
                      <script>
                        $('#approval').val("<?php echo ( in_array($customerData[0]['STATUS'],array(0,1)) ) ? $customerData[0]['STATUS'] : '-' ?>");
                      </script>
                  </div>
                </div>
                <div class="form-group">
                  <label for="inputEmail3" class="col-sm-2 control-label">Registration Date</label>
                  <div class="col-sm-8">
                    <input type="text" disabled class="form-control" value="<?php echo $customerData[0]['CREATEDON']?>">
                  </div>
                </div>
                <div class="form-group">
                  <label for="inputEmail3" class="col-sm-2 control-label">Activation Date</label>
                  <div class="col-sm-8">
                    <input type="text" disabled class="form-control" value="<?php echo $customerData[0]['ACTIVATEDON']?>">
                  </div>
                </div>
                <div class="form-group">
                  <label for="inputEmail3" class="col-sm-2 control-label">Last Login Date</label>
                  <div class="col-sm-8">
                    <input type="text" disabled class="form-control" value="<?php echo $customerData[0]['LASTLOGINDATE']?>">
                  </div>
                </div>
                <div class="form-group">
                  <label for="inputEmail3" class="col-sm-2 control-label">Pass Changed Date</label>
                  <div class="col-sm-8">
                    <input type="text" disabled class="form-control" value="<?php echo $customerData[0]['PASSCHANGEDDATE']?>">
                  </div>
                </div>
                <div class="form-group">
                  <label for="inputEmail3" class="col-sm-2 control-label">Pass Failed Count</label>
                  <div class="col-sm-8">
                    <input type="text" disabled class="form-control" value="<?php echo $customerData[0]['PASSFAILEDCOUNT']?>">
                  </div>
                </div>
                <div class="form-group">
                  <label for="inputEmail3" class="col-sm-2 control-label">Email</label>
                  <div class="col-sm-8">
                    <input type="text" disabled class="form-control" value="<?php echo $customerData[0]['EMAIL']?>">
                  </div>
                </div>
                <div class="form-group">
                  <label for="inputEmail3" class="col-sm-2 control-label">Customer Name</label>
                  <div class="col-sm-8">
                    <input type="text" id="custName" class="form-control" value="<?php echo $customerData[0]['CUSTNAME']?>" required>
                  </div>
                </div>
                <div class="form-group">
                  <label for="inputEmail3" class="col-sm-2 control-label">Customer Phone</label>
                  <div class="col-sm-8">
                    <input type="text" id="custPhone" class="form-control" value="<?php echo $customerData[0]['CUSTPHONE']?>" required>
                  </div>
                </div>
                <div class="form-group">
                  <label class="col-sm-2 control-label">Province Name</label>
                  <div class="col-sm-5">
                      <select class="form-control" id="custProv" onchange="getCity()" required>
                        <option value="0">- Pilih Provinsi -</option>
                        <?php
                          foreach ($provinsiDataList as $keyP => $valueP) {
                            echo "<option value='".$valueP['ID_PROVINSI']."'>".$valueP['NAMA_PROVINSI']."</option>";
                          }
                      ?>
                      </select>
                  </div>
                </div>
                <div class="form-group">
                  <label class="col-sm-2 control-label">City Name</label>
                  <div class="col-sm-5 optionCity">
                      <select class="form-control" id="custCity" required>
                        <option value="0">- Pilih Kota -</option>
                      </select>
                  </div>
                </div>
                <div class="form-group">
                  <label class="col-sm-2 control-label">Customer Address</label>
                  <div class="col-sm-8">
                    <textarea id="custAddress" class="form-control" rows="5" placeholder="Enter Address..." id="custAddress"><?php echo  $customerData[0]['CUSTADDRESS'] ?></textarea>
                  </div>
                </div>
                <div class="form-group">
                  <label for="inputEmail3" class="col-sm-2 control-label">Identity Type</label>
                  <div class="col-sm-5">
                      <div class="radio">
                        <label>
                          <input type="radio" name="identityType" id="optionsJI1" value="Passport" required/>
                          Passport
                        </label>
                      </div>
                      <div class="radio">
                        <label>
                          <input type="radio" name="identityType" id="optionsJI2" value="SIM"  required/>
                          SIM
                        </label>
                      </div>
                      <div class="radio">
                        <label>
                          <input type="radio" name="identityType" id="optionsJI3" value="KTP"  required/>
                          KTP
                        </label>
                      </div>
                      <div class="radio">
                        <label>
                          <input type="radio" name="identityType" id="optionsJI4" value="NPWP"  required/>
                          NPWP
                        </label>
                      </div>
                      <div class="radio">
                        <label>
                          <input type="radio" name="identityType" id="optionsJI5" value="Kartu Pelajar"  required/>
                          Kartu Pelajar
                        </label>
                      </div>
                  </div>
                </div>
                <div class="form-group">
                  <label for="inputEmail3" class="col-sm-2 control-label">Identity Code</label>
                  <div class="col-sm-8">
                    <input id="identityCode" type="text" class="form-control numeric" value="<?php echo $customerData[0]['IDENTITYCODE']?>" required>
                  </div>
                </div>
              <div class="box-footer">
                <a href="<?php echo base_url()?>customer_info/customer" class="btn btn-default">Cancel</a>
                <button type="button" class="btn btn-info pull-right" onclick="submitFormCust()">Save</button>
              </div>
            </form>
          </div>
        </div>
    </div>
</section>
<script type="text/javascript">
    var baseurl = "<?php echo base_url()?>";

    function getCity(){
      var provId = $('#custProv').val();
      if(provId != 0){
        $.ajax({
              type: "POST",
              url: baseurl+"authorize/getCityByProv",
              data: {'provId': provId},
              cache: false,
              dataType: "json",
              success: function (res) {
                var val = '';
                val += '<select class="form-control" name="custCity" id="custCity">';
                $.each(res, function (keyCity, valCity) {
                  val += '<option value="'+valCity['ID_KABUPATEN']+'">'+valCity['NAMA_KABUPATEN']+'</option>';
                });
                val += '</select>';
                $('.optionCity').html(val);

                // auto fill city
                var city_id = "<?php echo $customerData[0]['CITYID']?>";
                if (city_id != 0 && city_id != null) {
                  if ($("#custCity option[value='"+city_id+"']").length > 0) {
                    $("#custCity").val(city_id);
                  };
                };
              }
          });
      }else{
            var val = '';
            val += '<select class="form-control" name="custCity">';
            val += '<option value="0">- Pilih Kota -</option>';
            val += '</select>';
        $('.optionCity').html(val);
      }
    }

    function submitFormCust(){
        $.ajax({
            type: "POST",
            url: baseurl+"customer_info/customer_update",
            data: {
              'custId': $('#custId').val(),
              'custName': $('#custName').val(),
              'custProv': $('#custProv').val(),
              'custCity': $('#custCity').val(),
              'custAddress': $('#custAddress').val(),
              'identityType': $('input[name="identityType"]:checked').val(),
              'identityCode': $('#identityCode').val(),
              'custPhone': $('#custPhone').val(),
            },
            cache: false,
            dataType: "json",
            success: function (res) {
                if(res.result){
                    alert(res.message);
                    window.location.href = baseurl+"customer_info/customer";
                }else{
                    alert(res.message);

                }
            }
        });
    }

    $(document).ready(function(){
      // fill prov
      var province_id = "<?php echo $customerData[0]['PROVINCEID']?>";
      $("#custProv").val(province_id); getCity();

      // fil identity type
      $('input[name="identityType"][value="'+"<?php echo $customerData[0]['IDENTITYTYPE']?>"+'"]').prop('checked',true);
    });
</script>
