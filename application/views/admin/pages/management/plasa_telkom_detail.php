
<section class="content-header">
    <h1>
      Registration
      <small>Plasa Telkom</small>
    </h1>
</section>
<section class="content">
    <div class="row">
    <?php // print_r($plasaData);?>
        <div class="col-md-12">  
          <div class="box box-info">
            <div class="box-header with-border">
              <h3 class="box-title">Data Plasa Telkom</h3>
            </div>
            <?php if(isset($plasaData)){ ?>
                <form class="form-horizontal">
                <div class="box-body">
                    <div class="errorMessage hide alert alert-danger alert-dismissable">
                        <span class="messageText"></span>
                    </div>
                    <div class="successMessage hide alert alert-success alert-dismissable">
                        <span class="messageText"></span>
                    </div>
                    <div class="form-group">
                      <label class="col-sm-2 control-label">Plasa Telkom Name</label>
                      <div class="col-sm-8">
                        <input type="text" class="form-control" name="custName"  placeholder="" id="custName"  value="<?=$plasaData[0]['PLASANAME']?>">  
                        <input type="hidden" id="plasaId" class="form-control" value="<?=$plasaData[0]['ID']?>">

                      </div>
                    </div>                
                    <div class="form-group">
                      <label class="col-sm-2 control-label">Provinsi</label>                  
                      <div class="col-sm-5">                    
                          <select class="form-control" name="custProv" id="custProv" onchange="getCity()">
                            <option value="0">- Pilih Provinsi -</option>
                              <?php foreach ($provinsiData as $key => $value) {
                                    $selected = '';
                                    if($plasaData[0]['PROVINCEID'] == $value['ID_PROVINSI']){
                                        $selected = 'selected';
                                    }
                                    echo "<option value='".$value['ID_PROVINSI']."' ".$selected.">".$value['NAMA_PROVINSI']."</option>";
                                }
                              ?>
                          </select>
                      </div>
                    </div>        
                    <div class="form-group">
                      <label class="col-sm-2 control-label">Kota</label>
                      <div class="col-sm-5 optionCity">                    
                          <select class="form-control" name="custCity" id="custCity">
                              <?php foreach ($cityData as $key => $value) {
                                    $selected = '';
                                    if($plasaData[0]['CITYID'] == $value['ID_KABUPATEN']){
                                        $selected = 'selected';
                                    }
                                    echo "<option value='".$value['ID_KABUPATEN']."' ".$selected.">".$value['NAMA_KABUPATEN']."</option>";
                                }
                              ?>
                          </select>
                      </div>
                    </div>        
                    <div class="form-group">
                      <label class="col-sm-2 control-label">Alamat</label>
                      <div class="col-sm-8">
                        <textarea class="form-control" rows="5" placeholder="Enter Address..." id="custAddress"><?=$plasaData[0]['PLASAADDRESS']?></textarea>
                      </div>
                    </div>        
                    <div class="form-group">
                      <label class="col-sm-2 control-label">No Telpon / HP</label>
                      <div class="col-sm-8">
                          <input type="text" class="form-control" placeholder="" id="custPhone" value="<?=$plasaData[0]['PHONE']?>">
                      </div>
                    </div> 
                </div>
                <div class="box-footer">
                    <a href="<?=base_url()?>management/plasa_telkom" class="btn btn-default">Cancel</a> 
                    <button type="button" class="btn btn-info pull-right" onclick="submitFormEdit()">Edit</button>
                </div>
              </form>
            <?php }else{ ?>
            <form class="form-horizontal">
              <div class="box-body">
                <div class="form-group">
                  <label class="col-sm-2 control-label">Plasa Telkom Name</label>
                  <div class="col-sm-8">
                    <input type="text" class="form-control" name="custName"  placeholder="" id="custName">
                  </div>
                </div>                
                <div class="form-group">
                  <label class="col-sm-2 control-label">Provinsi</label>                  
                  <div class="col-sm-5">                    
                      <select class="form-control" name="custProv" id="custProv" onchange="getCity()">
                        <option value="0">- Pilih Provinsi -</option>
                        <?php
                        	foreach ($provinsiData as $keyP => $valueP) {
                        		echo "<option value='".$valueP['ID_PROVINSI']."'>".$valueP['NAMA_PROVINSI']."</option>";
                        	}
                    	?>
                      </select>
                  </div>
                </div>        
                <div class="form-group">
                  <label class="col-sm-2 control-label">Kota</label>
                  <div class="col-sm-5 optionCity">                    
                      <select class="form-control" name="custCity" id="custCity">
                        <option value="0">- Pilih Kota -</option>
                      </select>
                  </div>
                </div>        
                <div class="form-group">
                  <label class="col-sm-2 control-label">Alamat</label>
                  <div class="col-sm-8">
                    <textarea class="form-control" rows="5" placeholder="Enter Address..." id="custAddress"></textarea>
                  </div>
                </div>        
                <div class="form-group">
                  <label class="col-sm-2 control-label">No Telpon / HP</label>
                  <div class="col-sm-8">
                    <input type="text" class="form-control" placeholder="" id="custPhone">
                  </div>
                </div> 
        	  </div>
              <div class="box-footer">
                 <a href="<?=base_url()?>management/plasa_telkom" class="btn btn-default">Cancel</a> 
                <button type="button" class="btn btn-info pull-right" onclick="submitFormRegistrasi()">Setuju dan Daftarkan</button>
              </div>
            </form>
              
            <?php } ?>
          </div>
        </div>
    </div>
</section>
<form id="regNewDetail" method="post" action="<?=base_url()?>authorize/registration_detail">
    <input type="hidden" id="custIdRegNew" name="custIdRegNew"></input>
</form>
<script type="text/javascript">
	var baseurl = "<?=base_url()?>";
	function submitFormRegistrasiAlert(){
		alert("Peringatan. Belum ada tables database untuk Plasa Telkom");
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
    function submitFormEdit(){
        $('.errorMessage').addClass('hide');
        $('.successMessage').addClass('hide');
        var plasaId = $('#plasaId').val();
        var custName = $('#custName').val();
        var custProv = $('#custProv').val();
        var custCity = $('#custCity').val();
        var custAddress = $('#custAddress').val();
        var custPhone = $('#custPhone').val();
        if(custName != '' && custProv !=0 && custCity != 0 && custAddress != '' && custPhone != ''){
            $.ajax({
                type: "POST",
                url: baseurl+"management/plasa_telkom_save",
                data: {'plasaId':plasaId, 'custName': custName, 'custProv':custProv, 'custCity':custCity, 'custAddress':custAddress, 'custPhone':custPhone},
                cache: false,
                dataType: "json",
                success: function (res) {
                    if(res.result){     
                        $('.successMessage').removeClass('hide');
                        $('.messageText').text(res.message);
                    }else{           
                        $('.errorMessage').removeClass('hide');
                        $('.messageText').text(res.message);
                    }
                }
            });
        }else{
            alert('Please Fill all field.');
        }
  }
  function submitFormRegistrasi(){
        $('.errorMessage').addClass('hide');
        $('.successMessage').addClass('hide');
        var custName = $('#custName').val();
        var custProv = $('#custProv').val();
        var custCity = $('#custCity').val();
        var custAddress = $('#custAddress').val();
        var custPhone = $('#custPhone').val();
        if(custName != '' && custProv !=0 && custCity != 0 && custAddress != '' && custPhone != ''){
            $.ajax({
                type: "POST",
                url: baseurl+"management/plasa_telkom_save",
                data: {'custName': custName, 'custProv':custProv, 'custCity':custCity, 'custAddress':custAddress, 'custPhone':custPhone},
                cache: false,
                dataType: "json",
                success: function (res) {
                    if(res.result){
  //                      $('#custIdRegNew').val(res.custId);
  //                      $('#regNewDetail').submit();
                    }else{
                        alert('Registration Failed. '+res.message);
                    }
                }
            });
        }else{
            alert('Please Fill all field.');
        }
  }
</script>