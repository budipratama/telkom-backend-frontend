
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
                  <label for="inputEmail3" class="col-sm-2 control-label">Customer Code</label>
                  <div class="col-sm-8">
                    <input type="text" disabled class="form-control" value="<?php echo $customerData[0]['CUSTCODE']?>">
                    <input type="hidden" disabled class="form-control" id="custId" value="<?php echo $customerData[0]['ID']?>">
                  </div>
                </div>
                <div class="form-group">
                  <label for="inputEmail3" class="col-sm-2 control-label">Customer Type</label>
                  <div class="col-sm-8">
                    <input type="text" disabled class="form-control" value="MERCHANT">
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
                    <input type="text" disabled class="form-control" value="<?php echo $customerData[0]['CUSTNAME']?>">
                  </div>
                </div>
                <div class="form-group">
                  <label for="inputEmail3" class="col-sm-2 control-label">Phone Number</label>
                  <div class="col-sm-8">
                    <input type="text" disabled class="form-control" value="<?php echo $customerData[0]['CUSTPHONE']?>">
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
                  <label for="inputEmail3" class="col-sm-2 control-label">Address</label>
                  <div class="col-sm-8">
                    <input type="text" disabled class="form-control" value="<?php echo $customerData[0]['CUSTADDRESS']?>">
                  </div>
                </div>
                <div class="form-group">
                  <label for="inputEmail3" class="col-sm-2 control-label">ID Card File</label>
                  <div class="col-sm-8">
                    <input type="text" disabled class="form-control" value="<?php echo $customerData[0]['IDENTITYTYPE']?> / No : <?php echo $customerData[0]['IDENTITYCODE']?>">
                  </div>
                </div>
                <div class="form-group">
                  <label for="inputEmail3" class="col-sm-2 control-label">SIUP/NPWP Number</label>
                  <div class="col-sm-8">
                    <input type="text" disabled class="form-control" value="<?php echo $customerData[0]['NPWPNUMBER']?>">
                  </div>
                </div>
                <div class="form-group">
                  <label for="inputEmail3" class="col-sm-2 control-label">Business Type</label>
                  <div class="col-sm-8">
                    <input type="text" disabled class="form-control" value="<?php echo $customerData[0]['COMPANYTYPE']?>">
                  </div>
                </div>
                <div class="form-group">
                  <label for="inputEmail3" class="col-sm-2 control-label">Business Province</label>
                  <div class="col-sm-8">
                    <input type="text" disabled class="form-control" value="<?php echo $customerData[0]['NAMA_PROVINSI_COMPANY']?>">
                  </div>
                </div>
                <div class="form-group">
                  <label for="inputEmail3" class="col-sm-2 control-label">Business City</label>
                  <div class="col-sm-8">
                    <input type="text" disabled class="form-control" value="<?php echo $customerData[0]['NAMA_KABUPATEN_COMPANY']?>">
                  </div>
                </div>
                <div class="form-group">
                  <label for="inputEmail3" class="col-sm-2 control-label">Business Address</label>
                  <div class="col-sm-8">
                    <input type="text" disabled class="form-control" value="<?php echo $customerData[0]['COMPANYADDRESS']?>">
                  </div>
                </div>
                <div class="form-group">
                  <label for="inputEmail3" class="col-sm-2 control-label">Bank Name</label>
                  <div class="col-sm-8">
                    <input type="text" disabled class="form-control" value="<?php echo $customerData[0]['BANKNAME']?>">
                  </div>
                </div>
                <div class="form-group">
                  <label for="inputEmail3" class="col-sm-2 control-label">Bank Account</label>
                  <div class="col-sm-8">
                    <input type="text" disabled class="form-control" value="<?php echo $customerData[0]['BANKACCOUNT']?>">
                  </div>
                </div>
                <div class="form-group">
                  <label for="inputEmail3" class="col-sm-2 control-label">Merchant URL</label>
                  <div class="col-sm-8">
                    <input type="text" disabled class="form-control" value="<?php echo $customerData[0]['MERCHANTURL']?>">
                  </div>
                </div>
                <div class="form-group">
                  <label for="inputEmail3" class="col-sm-2 control-label">Merchant File</label>
                  <div class="col-sm-8">
                    <input type="text" disabled class="form-control" value="-">
                  </div>
                </div>
                <div class="form-group">
                  <label for="inputEmail3" class="col-sm-2 control-label">Approval Reason</label>
                  <div class="col-sm-8">
                    <textarea class="form-control" rows="5" placeholder="Enter reason..." name="remarks" id="remarks"><?php echo $customerData[0]['REMARKS']?></textarea>
                  </div>
                </div>
                <div class="form-group">
                  <label for="inputEmail3" class="col-sm-2 control-label">Approval Status</label>
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
                      <select class="form-control" name="approval" id="approval">
                        <option value="-" <?php echo $selectDefault?> >- Pilih status -</option>
                        <option value="1" <?php echo $selectApprove?> >Diterima</option>
                        <option value="0" <?php echo $selectUnApprove?> >Ditolak</option>
                      </select>
                  </div>
                </div>
              </div>
              <div class="box-footer">
                <a href="<?php echo base_url()?>authorize/merchant" class="btn btn-default">Cancel</a>
                <button type="button" class="btn btn-info pull-right" onclick="submitFormMerchant()">Proses</button>
              </div>
            </form>
          </div>
        </div>
    </div>
</section>
<script type="text/javascript">
    var baseurl = "<?php echo base_url()?>";
    function submitFormMerchant(){
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
                url: baseurl+"authorize/merchantApproval",
                data: {'custId': custId, 'remarks' : remarks, 'approval' : approval},
                cache: false,
                dataType: "json",
                success: function (res) {
                    if(res.result){
                        alert(res.message);
                        window.location.href = baseurl+"authorize/merchant";
                    }else{
                        alert(res.message);

                    }
                }
            });
        }
    }
</script>
