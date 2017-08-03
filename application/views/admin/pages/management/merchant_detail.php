
<section class="content-header">
    <h1>
      Merchant
      <small>Detail</small>
    </h1>
</section>
<section class="content">
    <div class="row">
    <?php //print_r($customerData);?>
        <div class="col-md-12">  
          <div class="box box-info">
            <div class="box-header with-border">
              <h3 class="box-title">Data Merchant</h3>
            </div>
            <form class="form-horizontal">
              <div class="box-body">
                <div class="form-group">
                  <label for="" class="col-sm-2 control-label">Customer Type</label>
                  <div class="col-sm-8">
                    <input type="text" disabled class="form-control" value="MERCHANT">
                    <input type="hidden" disabled class="form-control" id="custId" value="<?=$customerData[0]['ID']?>">
                  </div>
                </div>
                <div class="form-group">
                  <label for="" class="col-sm-2 control-label">Customer Code</label>
                  <div class="col-sm-8">
                    <input type="text" disabled class="form-control" value="<?=$customerData[0]['CUSTCODE']?>">
                  </div>
                </div>
                <div class="form-group">
                  <label for="" class="col-sm-2 control-label">Approval Status</label>
                  <div class="col-sm-5">                      
                      <?php
                        $selectApprove = '';
                        $selectUnApprove = '';
                        $selectDefault = '';
                        if($customerData[0]['STATUS'] == 1){
                            $selectApprove = 'selected';
                        }else if($customerData[0]['STATUS'] == 0){
                            $selectUnApprove = 'selected';
                        }else{
                            $selectDefault = 'selected';
                        }
                      ?>
                      <select class="form-control" name="approval" id="approval" disabled="">
                        <option value="-" <?=$selectDefault?> >- Pilih status -</option>
                        <option value="1" <?=$selectApprove?> >Diterima</option>
                        <option value="0" <?=$selectUnApprove?> >Ditolak</option>
                      </select>
                  </div>
                </div>
                <div class="form-group">
                  <label for="" class="col-sm-2 control-label">Activation Date</label>
                  <div class="col-sm-8">
                    <input type="text" disabled class="form-control" value="<?=$customerData[0]['ACTIVATEDON']?>">
                  </div>
                </div>
                <div class="form-group">
                  <label class="col-sm-2 control-label">Pass Changed Date</label>
                  <div class="col-sm-8">
                    <input type="text" disabled class="form-control" value="<?=$customerData[0]['PASSCHANGEDDATE']?>">
                  </div>
                </div>
                <div class="form-group">
                  <label class="col-sm-2 control-label">Pass Failed Count</label>
                  <div class="col-sm-8">
                    <input type="text" disabled class="form-control" value="<?=$customerData[0]['PASSFAILEDCOUNT']?>">
                  </div>
                </div>
                <div class="form-group">
                  <label class="col-sm-2 control-label">Email</label>
                  <div class="col-sm-8">
                    <input type="text" disabled class="form-control" value="<?=$customerData[0]['EMAIL']?>">
                  </div>
                </div>
                <div class="form-group">
                  <label for="" class="col-sm-2 control-label">Customer Name</label>
                  <div class="col-sm-8">
                    <input type="text" disabled class="form-control" value="<?=$customerData[0]['CUSTNAME']?>">
                  </div>
                </div>
                <div class="form-group">
                  <label for="" class="col-sm-2 control-label">Province Name</label>
                  <div class="col-sm-8">
                    <?php 
                      $provName = '';
                      foreach ($provinsiDataList as $keyP => $valueP) {
                          if($customerData[0]['PROVINCEID'] == $valueP['ID_PROVINSI']){
                              $provName = $valueP['NAMA_PROVINSI'];
                          }
                      }
                    ?>
                    <input type="text" disabled class="form-control" value="<?=$provName?>">
                  </div>
                </div>
                <div class="form-group">
                  <label for="" class="col-sm-2 control-label">City Name</label>
                  <div class="col-sm-8">
                    <?php 
                      $cityName = '';
                      foreach ($cityDataList as $keyC => $valueC) {
                          if($customerData[0]['CITYID'] == $valueC['ID_KABUPATEN']){
                              $cityName = $valueC['NAMA_KABUPATEN'];
                          }
                      }
                    ?>
                    <input type="text" disabled class="form-control"  value="<?=$cityName?>">
                  </div>
                </div>
                <div class="form-group">
                  <label for="" class="col-sm-2 control-label">Customer Address</label>
                  <div class="col-sm-8">
                    <textarea class="form-control" rows="5" placeholder="Enter address..." disabled ><?=$customerData[0]['CUSTADDRESS']?></textarea>
                  </div>
                </div>
                <div class="form-group">
                  <label for="" class="col-sm-2 control-label">Customer Phone</label>
                  <div class="col-sm-8">
                    <input type="text" disabled class="form-control" value="<?=$customerData[0]['CUSTPHONE']?>">
                  </div>
                </div>
                <div class="form-group">
                  <label for="" class="col-sm-2 control-label">ID Card File</label>
                  <div class="col-sm-8">
                    <input type="text" disabled class="form-control" value="<?=$customerData[0]['IDENTITYTYPE']?> / No : <?=$customerData[0]['IDENTITYCODE']?>">
                  </div>
                </div>
              </div>
              <div class="box-footer">
                <a href="<?=base_url()?>managent/merchant_registration" class="btn btn-info pull-right">OK</a>
                <!-- <button type="button" class="btn btn-info pull-right" onclick="submitFormPlatinum()">Proses</button> -->
              </div>
            </form>
          </div>
        </div>
    </div>
</section>
<script type="text/javascript">
    var baseurl = "<?=base_url()?>";
    function submitFormPlatinum(){
        var custId = $('#custId').val();
        var remarks = $('#remarks').val();
        var approval = $('#approval').val();
        if(remarks == ''){
            alert('Please input Approval Reason.');
            return false;
        }else if(approval == '-'){
            alert('Please select Approval Status.');
            return false;
        }else{
            $.ajax({
                type: "POST",
                url: baseurl+"authorize/updatePlatinum",
                data: {'custId': custId, 'remarks' : remarks, 'approval' : approval},
                cache: false,
                dataType: "json",
                success: function (res) {
                    if(res.result){
                        alert(res.message);
                        window.location.href = baseurl+"authorize/platinum";
                    }else{
                        alert(res.message);

                    }
                }
            });
        }
    }
</script>