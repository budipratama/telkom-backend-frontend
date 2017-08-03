
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
            <form class="form-horizontal" id="saveMerchant" method="post" action="<?=base_url()?>customer_info/merchant_setting_save">

              <div class="box-body">
                <div class="form-group">
                  <label for="inputEmail3" class="col-sm-2 control-label">Merchant Type</label>
                  <div class="col-sm-8">
                    <?php
                      switch ($customerData[0]['CUSTTYPEID']) {
                        case '1':
                          $cus_type = 'GOLD';
                          break;
                        case '2':
                          $cus_type = 'PLATINUM';
                          break;
                        case '3':
                          $cus_type = 'MERCHANT';
                          break;
                      }
                    ?>
                    <input type="text" disabled class="form-control" value="<?= $cus_type; ?>">
                  </div>
                </div>
                <div class="form-group">
                  <label for="inputEmail3" class="col-sm-2 control-label">Merchant Code</label>
                  <div class="col-sm-8">
                    <input type="text" disabled class="form-control"  name=""  value="<?=$customerData[0]['CUSTCODE']?>">
                    <input type="hidden"  class="form-control" name="custId" id="custId" value="<?=$customerData[0]['ID']?>">
                    <input type="hidden"  class="form-control" name="custCode" id="custCode" value="<?=$customerData[0]['CUSTCODE']?>">
                  </div>
                </div>
                <div class="form-group">
                  <label for="inputEmail3" class="col-sm-2 control-label">Merchant Name</label>
                  <div class="col-sm-8">
                    <input type="text" disabled id="custName" class="form-control" value="<?=$customerData[0]['CUSTNAME']?>" required>
                  </div>
                </div>
                <div class="form-group">
                  <label for="inputEmail3" class="col-sm-2 control-label">ID Fusion</label>
                  <div class="col-sm-8">
                    <input type="text" readonly id="idFusion" class="form-control" value="<?=$customerData[0]['CONTACTPHONE']?>" required>
                  </div>
                </div>
                <div class="form-group">
                  <label for="inputEmail3" class="col-sm-2 control-label">Registered Date</label>
                  <div class="col-sm-8">
                    <input type="text" disabled id="registeredDate" class="form-control" value="<?=$customerData[0]['CREATEDON']?>" required>
                  </div>
                </div>
                <div class="form-group">
                  <label class="col-sm-2 control-label">Tarif Merchant</label>
                  <div class="col-sm-5 optionCity">
                      <select class="form-control" name="mercTarif" id="mercTarif" required disabled>
                        <?php
                            foreach ($tarifData as $key => $value) {
                                $tarifSelect = '';
                                if($tarifSelected[0]['FH_ID'] == $value['FH_ID']){
                                    $tarifSelect = 'selected';
                                }
                                echo "<option ".$tarifSelect." value='".$value['FH_ID']."'>".$value['FH_NAME']."</option>";

                            }
                        ?>
                      </select>
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
                    <label for="inputEmail3" class="col-sm-2 control-label">Status</label>
                    <div class="col-sm-8">
                      <input type="text" disabled class="form-control" value="<?php echo ($customerData[0]['STATUS'] == 1) ? 'Active' : 'Inactive'; ?>">
                    </div>
                  </div>
                </div>
              </div>
              <div class="box-footer">
                <a href="<?=base_url()?>customer_info/merchant_setting" class="btn btn-default">Back</a>
              </div>
            </form>
          </div>
        </div>
    </div>
</section>
<script type="text/javascript">
    var baseurl = "<?=base_url()?>";

    $(document).ready(function(){
      // fill prov
      var province_id = "<?=$customerData[0]['PROVINCEID']?>";
      // fil identity type
      $('input[name="identityType"][value="'+"<?=$customerData[0]['IDENTITYTYPE']?>"+'"]').prop('checked',true);
    });
</script>
