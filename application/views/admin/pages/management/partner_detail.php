
<section class="content-header">
    <?php if(isset($partnerData)){ ?>
	<h1>
	Edit
      <small>Partner</small>
    </h1>
	<?php } else { ?>
	<h1>
	Registrasi
      <small>Partner</small>
    </h1>
	<?php } ?>
</section>
<section class="content">
    <div class="row">
    <?php // print_r($terminalData);?>
        <div class="col-md-12">  
          <div class="box box-info">
            <div class="box-header with-border">
              <h3 class="box-title">Data Partner</h3>
            </div>
            <?php if(isset($partnerData)){ ?>
            <form class="form-horizontal" id="formAddPartner" method="post" action="<?=base_url()?>management/partner_save">
              <div class="box-body">
					<div class="form-group">
                      <label class="col-sm-2 control-label">Name</label>
                      <div class="col-sm-8">
                        <input type="text" class="form-control" name="cpName"  placeholder="" id="cpName" value="<?php echo $partnerData[0]['CP_NAME']?>">  
                        <input type="hidden" class="form-control" name="partnerId"  placeholder="" id="partnerId" value="<?php echo $partnerData[0]['CP_ID']?>">  
                      </div>
                    </div>                               
                    <div class="form-group">
                      <label class="col-sm-2 control-label">Code</label>
                      <div class="col-sm-8">
                        <input type="text" class="form-control" name="cpCode"  placeholder="" id="cpCode" value="<?php echo $partnerData[0]['CP_CODE']?>">  
                      </div>
                    </div> 
					<div class="form-group">
                      <label class="col-sm-2 control-label">Public Key</label>
                      <div class="col-sm-8">
                        <input type="text" class="form-control" name="publicKey"  placeholder="" id="publicKey" value="<?php echo $partnerData[0]['CP_PUBLIC_KEY']?>">  
                      </div>
                    </div>
					<div class="form-group">
					  <label class="col-sm-2 control-label">Private Key</label>
					  <div class="col-sm-8">
						<input type="text" class="form-control" name="privateKey"  placeholder="" id="privateKey" value="<?php echo $partnerData[0]['CP_PRIVATE_KEY']?>">
					  </div>
					</div> 
					<div class="form-group">
					  <label class="col-sm-2 control-label">URL</label>
					  <div class="col-sm-8">
						<input type="text" class="form-control" name="cpUrl"  placeholder="" id="cpUrl" value="https://" value="<?php echo $partnerData[0]['CP_AUTH_URL']?>">
					  </div>
					</div> 
					<div class="form-group">
						<label class="col-sm-2 control-label">Active</label>
                        <div class="col-sm-8">
                          <div class="checkbox">
                            <label>
								<?php
									$status = '';
									if ($partnerData[0]['STATUS'] == 1) $status='checked';
								?>
                                <input type="checkbox" name="active" id="active" <?php echo $status ?>>
                            </label>
                          </div>
                        </div>
                    </div>
					<div class="form-group">
                      <label class="col-sm-2 control-label">Description</label>
                      <div class="col-sm-8">
						<input type="text" class="form-control" name="description"  placeholder="" id="description" value="<?php echo $partnerData[0]['CP_DESCRIPTION']?>">
                        
                      </div>
                    </div> 
					<div class="form-group">
					  <label class="col-sm-2 control-label">Identity Type</label>
					  <div class="col-sm-8">
						<input type="text" class="form-control" name="identityType"  placeholder="" id="identityType" value="<?php echo $partnerData[0]['CP_IDENTITYTYPE']?>">
					  </div>
					</div> 
					<div class="form-group">
					  <label class="col-sm-2 control-label">Identity Number</label>
					  <div class="col-sm-8">
						<input type="text" class="form-control" name="identityNumber"  placeholder="" id="identityNumber" value="<?php echo $partnerData[0]['CP_IDENTITYNUMBER']?>">
					  </div>
					</div> 
					<div class="form-group">
					  <label class="col-sm-2 control-label">Address</label>
					  <div class="col-sm-8">
						<input type="text" class="form-control" name="address"  placeholder="" id="address" value="<?php echo $partnerData[0]['CP_ADDRESS']?>">
					  </div>
					</div>
					<div class="form-group">
					  <label class="col-sm-2 control-label">Province</label>
					  <div class="col-sm-8">
						<select class="form-control" name="custProv" id="custProv" onchange="getCity()">
                            <option value="0">- Pilih Provinsi -</option>
                              <?php foreach ($provinsiData as $key => $value) {
                                    $selected = '';
                                    if($partnerData[0]['CP_PROVINCE_ID'] == $value['ID_PROVINSI']){
                                        $selected = 'selected';
                                    }
                                    echo "<option value='".$value['ID_PROVINSI']."' ".$selected.">".$value['NAMA_PROVINSI']."</option>";
                                }
                              ?>
                        </select>
					  </div>
					</div>
					<div class="form-group">
					  <label class="col-sm-2 control-label">City</label>
					  <div class="col-sm-5 optionCity">                    
                      <select class="form-control" name="custCity" id="custCity">
                        <option value="0">- Pilih Kota -</option>
						<?php foreach ($cityData as $key => $value) {
                                    $selected = '';
                                    if($partnerData[0]['CP_CITY_ID'] == $value['ID_KABUPATEN']){
                                        $selected = 'selected';
                                    }
                                    echo "<option value='".$value['ID_KABUPATEN']."' ".$selected.">".$value['NAMA_KABUPATEN']."</option>";
                                }
                              ?>
                      </select>
					  </div>
					</div>
					<div class="form-group">
					  <label class="col-sm-2 control-label">Password Format</label>
					  <div class="col-sm-8">
						<input type="text" class="form-control" name="passwordFormat"  placeholder="" id="passwordFormat" value="<?php echo $partnerData[0]['CP_PASSWORD_FORMAT']?>">
					  </div>
					</div>
					<div class="form-group">
						<label class="col-sm-2 control-label">Strict IP Address</label>
                        <div class="col-sm-8">
                          <div class="checkbox">
                            <label>
								<?php
									$status = '';
									if ($partnerData[0]['CP_STRICT_IP_ADDR'] == 1) $status='checked';
								?>
                                <input type="checkbox" name="strictIp" id="strictIp" <?php echo $status ?>>
                            </label>
                          </div>
                        </div>
                    </div>
					<div class="form-group">
						<label class="col-sm-2 control-label">Use Signature</label>
                        <div class="col-sm-8">
                          <div class="checkbox">
                            <label>
								<?php
									$status = '';
									if ($partnerData[0]['CP_USE_SIGNATURE'] == 1) $status='checked';
								?>
                                <input type="checkbox" name="signature" id="signature" <?php echo $status ?>>
                            </label>
                          </div>
                        </div>
                    </div>
					<div class="form-group">
						<label class="col-sm-2 control-label">Use Password</label>
                        <div class="col-sm-8">
                          <div class="checkbox">
                            <label>
								<?php
									$status = '';
									if ($partnerData[0]['CP_USE_PASSWORD'] == 1) $status='checked';
								?>
                                <input type="checkbox" name="usePassword" id="usePassword" <?php echo $status ?>>
                            </label>
                          </div>
                        </div>
                    </div>
					<div class="form-group">
						<label class="col-sm-2 control-label">Update Phone</label>
                        <div class="col-sm-8">
                          <div class="checkbox">
                            <label>
								<?php
									$status = '';
									if ($partnerData[0]['CP_UPDATE_PHONE'] == 1) $status='checked';
								?>
                                <input type="checkbox" name="updatePhone" id="updatePhone" <?php echo $status ?>>
                            </label>
                          </div>
                        </div>
                    </div>
					<div class="form-group">
						<label class="col-sm-2 control-label">Email Notification</label>
                        <div class="col-sm-8">
                          <div class="checkbox">
                            <label>
								<?php
									$status = '';
									if ($partnerData[0]['CP_EMAIL_NOTIFICATION'] == 1) $status='checked';
								?>
                                <input type="checkbox" name="emailNotification" id="emailNotification" <?php echo $status ?>>
                            </label>
                          </div>
                        </div>
                    </div>
					<div class="form-group">
						<label class="col-sm-2 control-label">SMS Notification</label>
                        <div class="col-sm-8">
                          <div class="checkbox">
                            <label>
								<?php
									$status = '';
									if ($partnerData[0]['CP_SMS_NOTIFICATION'] == 1) $status='checked';
								?>
                                <input type="checkbox" name="smsNotification" id="smsNotification" <?php echo $status ?>>
                            </label>
                          </div>
                        </div>
                    </div>
					<div class="form-group">
					  <label class="col-sm-2 control-label">Token Validity (second)</label>
					  <div class="col-sm-8">
						<input type="text" class="form-control" name="tokenValidity"  placeholder="" id="tokenValidity" value="<?php echo $partnerData[0]['CP_TOKEN_VALIDITY']?>">
					  </div>
					</div>
					<div class="form-group">
						<label class="col-sm-2 control-label">Hanshake Encryption</label>
                        <div class="col-sm-8">
                          <div class="checkbox">
                            <label>
								<?php
									$status = '';
									if ($partnerData[0]['CP_HANDSHAKE_ENCRYPTION'] == 1) $status='checked';
								?>
                                <input type="checkbox" name="handshakeEncryption" id="handshakeEncryption" <?php echo $status ?>>
                            </label>
                          </div>
                        </div>
                    </div>
					<div class="form-group">
					  <label class="col-sm-2 control-label">Hanshake Algorithm</label>
					  <div class="col-sm-8">
						<input type="text" class="form-control" name="handshakeAlgorithm"  placeholder="" id="handshakeAlgorithm" value="<?php echo $partnerData[0]['CP_HANDSHAKE_ALGORITHM']?>">
					  </div>
					</div>
					<div class="form-group">
					  <label class="col-sm-2 control-label">Hanshake Key</label>
					  <div class="col-sm-8">
						<input type="text" class="form-control" name="handshakeKey"  placeholder="" id="handshakeKey" value="<?php echo $partnerData[0]['CP_HANDSHAKE_KEY']?>">
					  </div>
					</div>
					<div class="form-group">
					  <label class="col-sm-2 control-label">Hanshake Block Size</label>
					  <div class="col-sm-8">
						<input type="text" class="form-control" name="handshakeBlockSize"  placeholder="" id="handshakeBlockSize" value="<?php echo $partnerData[0]['CP_HANDSHAKE_BLOCKSIZE']?>">
					  </div>
					</div>
					<div class="form-group">
					  <label class="col-sm-2 control-label">Created By</label>
					  <div class="col-sm-8">
						<input type="text" class="form-control" name="createdBy"  placeholder="" id="createdBy" value="<?php echo $partnerData[0]['CREATED_BY']?>" readonly="true">
					  </div>
					</div>
					<div class="form-group">
					  <label class="col-sm-2 control-label">Updated By</label>
					  <div class="col-sm-8">
						<input type="text" class="form-control" name="updatedBy"  placeholder="" id="updatedBy" value="<?php echo $this->session->userdata('userRealName')?>" readonly="true">
					  </div>
					</div>
                </div>
              <div class="box-footer">
                 <a href="<?=base_url()?>management/partner" class="btn btn-default">Cancel</a> 
                <button type="button" class="btn btn-info pull-right" onclick="submitFormEdit()">Edit</button>
              </div>
            </form>
            <?php }else{ ?>
            <form class="form-horizontal" id="formAddPartner" method="post" action="<?=base_url()?>management/partner_save">
              <div class="box-body">
					<div class="form-group">
                      <label class="col-sm-2 control-label">Name</label>
                      <div class="col-sm-8">
                        <input type="text" class="form-control" name="cpName"  placeholder="" id="cpName">  
                      </div>
                    </div>                               
                    <div class="form-group">
                      <label class="col-sm-2 control-label">Code</label>
                      <div class="col-sm-8">
                        <input type="text" class="form-control" name="cpCode"  placeholder="" id="cpCode">  
                      </div>
                    </div> 
					<div class="form-group">
                      <label class="col-sm-2 control-label">Public Key</label>
                      <div class="col-sm-8">
                        <input type="text" class="form-control" name="publicKey"  placeholder="" id="publicKey">  
                      </div>
                    </div>
					<div class="form-group">
					  <label class="col-sm-2 control-label">Private Key</label>
					  <div class="col-sm-8">
						<input type="text" class="form-control" name="privateKey"  placeholder="" id="privateKey" >
					  </div>
					</div> 
					<div class="form-group">
					  <label class="col-sm-2 control-label">URL</label>
					  <div class="col-sm-8">
						<input type="text" class="form-control" name="cpUrl"  placeholder="" id="cpUrl" value="https://">
					  </div>
					</div> 
					<div class="form-group">
						<label class="col-sm-2 control-label">Active</label>
                        <div class="col-sm-8">
                          <div class="checkbox">
                            <label>
                                <input type="checkbox" name="active" id="active">
                            </label>
                          </div>
                        </div>
                    </div>
					<div class="form-group">
                      <label class="col-sm-2 control-label">Description</label>
                      <div class="col-sm-8">
                        <input type="text" class="form-control" name="description"  placeholder="" id="description">
                      </div>
                    </div> 
					<div class="form-group">
					  <label class="col-sm-2 control-label">Identity Type</label>
					  <div class="col-sm-8">
						<input type="text" class="form-control" name="identityType"  placeholder="" id="identityType" value="SIUP">
					  </div>
					</div> 
					<div class="form-group">
					  <label class="col-sm-2 control-label">Identity Number</label>
					  <div class="col-sm-8">
						<input type="text" class="form-control" name="identityNumber"  placeholder="" id="identityNumber" >
					  </div>
					</div> 
					<div class="form-group">
					  <label class="col-sm-2 control-label">Address</label>
					  <div class="col-sm-8">
						<input type="text" class="form-control" name="address"  placeholder="" id="address" >
					  </div>
					</div>
					<div class="form-group">
					  <label class="col-sm-2 control-label">Province</label>
					  <div class="col-sm-8">
						<select class="form-control" name="custProv" id="custProv" onchange="getCity()">
                            <option value="0">- Pilih Provinsi -</option>
                              <?php foreach ($provinsiData as $key => $value) {
                                    echo "<option value='".$value['ID_PROVINSI']."'>".$value['NAMA_PROVINSI']."</option>";
                                }
                              ?>
                        </select>
					  </div>
					</div>
					<div class="form-group">
					  <label class="col-sm-2 control-label">City</label>
					  <div class="col-sm-5 optionCity">                    
                      <select class="form-control" name="custCity" id="custCity">
                        <option value="0">- Pilih Kota -</option>
                      </select>
					  </div>
					</div>
					<div class="form-group">
					  <label class="col-sm-2 control-label">Password Format</label>
					  <div class="col-sm-8">
						<input type="text" class="form-control" name="passwordFormat"  placeholder="" id="passwordFormat" value="#.*^(?=.{8,100})(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9]).*$#">
					  </div>
					</div>
					<div class="form-group">
						<label class="col-sm-2 control-label">Strict IP Address</label>
                        <div class="col-sm-8">
                          <div class="checkbox">
                            <label>
                                <input type="checkbox" name="strictIp" id="strictIp">
                            </label>
                          </div>
                        </div>
                    </div>
					<div class="form-group">
						<label class="col-sm-2 control-label">Use Signature</label>
                        <div class="col-sm-8">
                          <div class="checkbox">
                            <label>
                                <input type="checkbox" name="signature" id="signature" checked>
                            </label>
                          </div>
                        </div>
                    </div>
					<div class="form-group">
						<label class="col-sm-2 control-label">Use Password</label>
                        <div class="col-sm-8">
                          <div class="checkbox">
                            <label>
                                <input type="checkbox" name="usePassword" id="usePassword" checked>
                            </label>
                          </div>
                        </div>
                    </div>
					<div class="form-group">
						<label class="col-sm-2 control-label">Update Phone</label>
                        <div class="col-sm-8">
                          <div class="checkbox">
                            <label>
                                <input type="checkbox" name="updatePhone" id="updatePhone">
                            </label>
                          </div>
                        </div>
                    </div>
					<div class="form-group">
						<label class="col-sm-2 control-label">Email Notification</label>
                        <div class="col-sm-8">
                          <div class="checkbox">
                            <label>
                                <input type="checkbox" name="emailNotification" id="emailNotification" checked>
                            </label>
                          </div>
                        </div>
                    </div>
					<div class="form-group">
						<label class="col-sm-2 control-label">SMS Notification</label>
                        <div class="col-sm-8">
                          <div class="checkbox">
                            <label>
                                <input type="checkbox" name="smsNotification" id="smsNotification" checked>
                            </label>
                          </div>
                        </div>
                    </div>
					<div class="form-group">
					  <label class="col-sm-2 control-label">Token Validity (second)</label>
					  <div class="col-sm-8">
						<input type="text" class="form-control" name="tokenValidity"  placeholder="" id="tokenValidity" value="86400">
					  </div>
					</div>
					<div class="form-group">
						<label class="col-sm-2 control-label">Hanshake Encryption</label>
                        <div class="col-sm-8">
                          <div class="checkbox">
                            <label>
                                <input type="checkbox" name="handshakeEncryption" id="handshakeEncryption">
                            </label>
                          </div>
                        </div>
                    </div>
					<div class="form-group">
					  <label class="col-sm-2 control-label">Hanshake Algorithm</label>
					  <div class="col-sm-8">
						<input type="text" class="form-control" name="handshakeAlgorithm"  placeholder="" id="handshakeAlgorithm" value="AES-ECB">
					  </div>
					</div>
					<div class="form-group">
					  <label class="col-sm-2 control-label">Hanshake Key</label>
					  <div class="col-sm-8">
						<input type="text" class="form-control" name="handshakeKey"  placeholder="" id="handshakeKey" value="TELKOMTMONEY123">
					  </div>
					</div>
					<div class="form-group">
					  <label class="col-sm-2 control-label">Hanshake Block Size</label>
					  <div class="col-sm-8">
						<input type="text" class="form-control" name="handshakeBlockSize"  placeholder="" id="handshakeBlockSize" value="256">
					  </div>
					</div>
					<div class="form-group">
					  <label class="col-sm-2 control-label">Created By</label>
					  <div class="col-sm-8">
						<input type="text" class="form-control" name="createdBy"  placeholder="" id="createdBy" value="<?php echo $this->session->userdata('userRealName')?>" readonly="true">
					  </div>
					</div>
                </div>
              <div class="box-footer">
                 <a href="<?=base_url()?>management/partner" class="btn btn-default">Cancel</a> 
                <button type="button" class="btn btn-info pull-right" onclick="submitFormRegistrasi()">Setuju dan Daftarkan</button>
              </div>
            </form>
              
            <?php } ?>
          </div>
        </div>
    </div>
</section>
<script type="text/javascript">
	var baseurl = "<?=base_url()?>";
	function submitFormRegistrasiAlert(){
		alert("Peringatan. Belum ada tables database untuk terminal");
	}

	function submitFormEdit(){
		$('.errorMessage').addClass('hide');
        $('.successMessage').addClass('hide');
		var partnerId = $('#partnerId').val();
        var cpName = $('#cpName').val();
        var cpCode = $('#cpCode').val();
        var publicKey = $('#publicKey').val();
        var privateKey = $('#privateKey').val();
        var cpUrl = $('#cpUrl').val();
        var active = 0;
        if ($('#active').prop('checked')) {
            active = 1;
        }
		var description = $('#description').val();
		var identityType = $('#identityType').val();
		var identityNumber = $('#identityNumber').val();
		var address = $('#address').val();
		var custProv = $('#custProv').val();
		var custCity = $('#custCity').val();
		var passwordFormat = $('#passwordFormat').val();
		var strictIp = 0;
		if ($('#strictIp').prop('checked')) {
            strictIp = 1;
        }
		var signature = 0;
		if ($('#signature').prop('checked')) {
            signature = 1;
        }
		var usePassword = 0;
		if ($('#usePassword').prop('checked')) {
            usePassword = 1;
        }
		var updatePhone = 0;
		if ($('#updatePhone').prop('checked')) {
            updatePhone = 1;
        }
		var emailNotification = 0;
		if ($('#emailNotification').prop('checked')) {
            emailNotification = 1;
        }
		var smsNotification = 0;
		if ($('#smsNotification').prop('checked')) {
            smsNotification = 1;
        }
		var tokenValidity = $('#tokenValidity').val();
		var handshakeEncryption = 0;
		if ($('#handshakeEncryption').prop('checked')) {
            handshakeEncryption = 1;
        }
		var handshakeAlgorithm = $('#handshakeAlgorithm').val();
		var handshakeKey = $('#handshakeKey').val();
		var handshakeBlockSize = $('#handshakeBlockSize').val();
		
		var createdBy = $('#createdBy').val();
		var updatedBy = $('#updatedBy').val();
		
        if(cpName != '' && cpCode !='' && publicKey !='' && privateKey != '' && cpUrl!= '' && 
		identityType!= '' && identityNumber!= '' && address!= '' && custProv!= '' && passwordFormat!= '' && tokenValidity!= '' &&
		createdBy!= ''){
            //$('#formAddPartner').submit();
			$.ajax({
                type: "POST",
                url: baseurl+"management/partner_save",
                data: {
					'partnerId': partnerId,'cpName': cpName, 'cpCode':cpCode, 'publicKey':publicKey, 'privateKey':privateKey, 'cpUrl':cpUrl,
					'active': active, 'description':description, 'identityType':identityType, 'identityNumber':identityNumber, 'address':address,
					'custProv': custProv, 'custCity':custCity, 'passwordFormat':passwordFormat, 'strictIp':strictIp, 'signature':signature,
					'usePassword': usePassword, 'updatePhone':updatePhone, 'emailNotification':emailNotification, 'smsNotification':smsNotification, 'tokenValidity':tokenValidity,
					'handshakeEncryption': handshakeEncryption, 'handshakeAlgorithm':handshakeAlgorithm, 'handshakeKey':handshakeKey, 'handshakeBlockSize':handshakeBlockSize, 
					'createdBy':createdBy, 'updatedBy':updatedBy
				},
                cache: false,
                success: function (res) {
                    alert('Edit Partner Success');
					//window.location.href = baseurl+"management/partner";
                },
				error: function(request,error) { 
					alert(request.responseText);
					alert("Edit Partner Failed :"+error);
				}
            });
        }else{
            alert('Please Fill all field.');
        }
  }
  
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
					val += '<option value="0">- Pilih Kota -</option>';
		        	$.each(res, function (keyCity, valCity) {
		        		val += '<option value="'+valCity['ID_KABUPATEN']+'">'+valCity['NAMA_KABUPATEN']+'</option>';
		        	});
		        	val += '</select>';
		        	$('.optionCity').html(val);
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
	
  function submitFormRegistrasi(){
        $('.errorMessage').addClass('hide');
        $('.successMessage').addClass('hide');
        var cpName = $('#cpName').val();
        var cpCode = $('#cpCode').val();
        var publicKey = $('#publicKey').val();
        var privateKey = $('#privateKey').val();
        var cpUrl = $('#cpUrl').val();
        var active = 0;
        if ($('#active').prop('checked')) {
            active = 1;
        }
		var description = $('#description').val();
		var identityType = $('#identityType').val();
		var identityNumber = $('#identityNumber').val();
		var address = $('#address').val();
		var custProv = $('#custProv').val();
		var custCity = $('#custCity').val();
		var passwordFormat = $('#passwordFormat').val();
		var strictIp = 0;
		if ($('#strictIp').prop('checked')) {
            strictIp = 1;
        }
		var signature = 0;
		if ($('#signature').prop('checked')) {
            signature = 1;
        }
		var usePassword = 0;
		if ($('#usePassword').prop('checked')) {
            usePassword = 1;
        }
		var updatePhone = 0;
		if ($('#updatePhone').prop('checked')) {
            updatePhone = 1;
        }
		var emailNotification = 0;
		if ($('#emailNotification').prop('checked')) {
            emailNotification = 1;
        }
		var smsNotification = 0;
		if ($('#smsNotification').prop('checked')) {
            smsNotification = 1;
        }
		var tokenValidity = $('#tokenValidity').val();
		var handshakeEncryption = 0;
		if ($('#handshakeEncryption').prop('checked')) {
            handshakeEncryption = 1;
        }
		var handshakeAlgorithm = $('#handshakeAlgorithm').val();
		var handshakeKey = $('#handshakeKey').val();
		var handshakeBlockSize = $('#handshakeBlockSize').val();
		var createdBy = $('#createdBy').val();
		
        if(cpName != '' && cpCode !='' && publicKey !='' && privateKey != '' && cpUrl!= '' && description!= '' && 
		identityType!= '' && identityNumber!= '' && address!= '' && custProv!= '' && passwordFormat!= '' && tokenValidity!= '' &&
		createdBy!= ''){
            //$('#formAddPartner').submit();
			$.ajax({
                type: "POST",
                url: baseurl+"management/partner_save",
                data: {
					'cpName': cpName, 'cpCode':cpCode, 'publicKey':publicKey, 'privateKey':privateKey, 'cpUrl':cpUrl,
					'active': active, 'description':description, 'identityType':identityType, 'identityNumber':identityNumber, 'address':address,
					'custProv': custProv, 'custCity':custCity, 'passwordFormat':passwordFormat, 'strictIp':strictIp, 'signature':signature,
					'usePassword': usePassword, 'updatePhone':updatePhone, 'emailNotification':emailNotification, 'smsNotification':smsNotification, 'tokenValidity':tokenValidity,
					'handshakeEncryption': handshakeEncryption, 'handshakeAlgorithm':handshakeAlgorithm, 'handshakeKey':handshakeKey, 'handshakeBlockSize':handshakeBlockSize, 
					'createdBy':createdBy
				},
                cache: false,
                success: function (res) {
                    alert('Add Partner Success');
					window.location.href = baseurl+"management/partner";
                },
				error: function(request,error) { 
					alert(request.responseText);
					alert("Add Partner Failed :"+error);
				}
            });
        }else{
            alert('Please Fill all field.');
        }
	}
</script>