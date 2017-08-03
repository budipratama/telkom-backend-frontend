
<section class="content-header">
    <h1>
      Platinum
      <small>Detail</small>
    </h1>
</section>
<section class="content">
    <div class="row">
        <div class="col-md-12">
          <div class="box box-info">
            <div class="box-header with-border">
              <h3 class="box-title">Data Platinum</h3>
            </div>
            <form class="form-horizontal">
              <div class="box-body">
                <div class="form-group">
                  <label for="inputEmail3" class="col-sm-2 control-label">Customer Code</label>
                  <div class="col-sm-8">
                    <input type="text" disabled class="form-control" value="<?php echo $customerData[0]['CUSTCODE']?>">
                    <input type="hidden" disabled class="form-control" id="custId" value="<?php echo $customerData[0]['ID']?>">
                    <input type="hidden" disabled class="form-control" id="upgradeCode" value="<?php echo $customerData[0]['CUSTCODE']?>">
                  </div>
                </div>
                <div class="form-group">
                  <label for="inputEmail3" class="col-sm-2 control-label">Customer Name</label>
                  <div class="col-sm-8">
                    <input type="text" disabled class="form-control" value="<?php echo $customerData[0]['CUSTNAME']?>">
                  </div>
                </div>
                <div class="form-group">
                  <label for="inputEmail3" class="col-sm-2 control-label">Email</label>
                  <div class="col-sm-8">
                    <input type="text" disabled class="form-control" value="<?php echo $customerData[0]['EMAIL']?>">
                  </div>
                </div>
                <div class="form-group">
                  <label for="inputEmail3" class="col-sm-2 control-label">Customer Type</label>
                  <div class="col-sm-8">
                    <input type="text" disabled class="form-control" value="<?php echo $customerData[0]['LEVEL_NAME']?>">
                  </div>
                </div>
                <div class="form-group">
                  <label for="inputEmail3" class="col-sm-2 control-label">Province</label>
                  <div class="col-sm-8">
                    <input type="text" disabled class="form-control" value="<?php echo $customerData[0]['NAMA_PROVINSI']?>">
                  </div>
                </div>
                <div class="form-group">
                  <label for="inputEmail3" class="col-sm-2 control-label">City</label>
                  <div class="col-sm-8">
                    <input type="text" disabled class="form-control" value="<?php echo $customerData[0]['NAMA_KABUPATEN']?>">
                  </div>
                </div>
                <div class="form-group">
                  <label for="inputEmail3" class="col-sm-2 control-label">ID Card File</label>
                  <div class="col-sm-4">
                    <input type="text" disabled class="form-control" value="Type: <?php echo $customerData[0]['CU_IDENTITYTYPE']?>">
                  </div>
                  <div class="col-sm-4">
                    <input type="text" disabled class="form-control" value="No : <?php echo $customerData[0]['CU_IDENTITYCODE']?>">
                  </div>
                </div>
                <div class="form-group">
                  <label for="inputEmail3" class="col-sm-2 control-label">Approval Reason</label>
                  <div class="col-sm-8">
                    <textarea class="form-control" rows="5" placeholder="Enter reason..." name="remarks" id="remarks"><?php echo $customerData[0]['REMARKS']?></textarea>
                  </div>
                </div>
                <div class="form-group">
                  <label for="inputEmail3" class="col-sm-2 control-label">Type Customer</label>
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
                      <select class="form-control" name="custType" id="custType">
                        <?php
                            foreach ($custLevel as $key => $value) {
                                echo '<option value="'.$value['ID'].'">'.$value['LEVEL_NAME'].'</option>';
                            }
                        ?>
                      </select>
                  </div>
                </div>
              </div>
              <div class="box-footer">
                <a href="<?php echo base_url()?>authorize/platinum" class="btn btn-default">Cancel</a>
                <button type="button" class="btn btn-info pull-right" onclick="submitFormPlatinum()">Proses</button>
              </div>
            </form>
          </div>
        </div>
    </div>
</section>
<script type="text/javascript">
    var baseurl = "<?php echo base_url()?>";
    function submitFormPlatinum(){
        var custId = $('#custId').val();
        var remarks = $('#remarks').val();
        var custType = $('#custType').val();
        var upgradeCode = $('#upgradeCode').val();
        if(remarks == ''){
            alert('Please input Approval Reason.');
            return false;
        }else{
            $.ajax({
                type: "POST",
                url: baseurl+"authorize/updatePlatinum",
                data: {'custId': custId, 'remarks' : remarks, 'custType' : custType, 'upgradeCode':upgradeCode},
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
