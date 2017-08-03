
<section class="content-header">
    <h1>
      Registration
      <small>PPOB</small>
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
                  <label class="col-sm-2 control-label">Account type</label>
                  <div class="col-sm-8">
                    <select class="form-control" name="accType" id="accType">
                        <?php
                            foreach ($custLevel as $key => $value) {
                                $selected = '';
                                if($value['ID'] == 4){
                                    $selected = "selected";
                                }
                                echo '<option value="'.$value['ID'].'" '.$selected.'>'.$value['LEVEL_NAME'].'</option>';
                            }                            
                        ?>
                      </select>
                  </div>
                </div>
                <div class="form-group">
                  <label class="col-sm-2 control-label">Email</label>
                  <div class="col-sm-8">
                    <input type="text" class="form-control" name="custEmail"  placeholder="" id="custEmail">
                  </div>
                </div> 
                <div class="form-group">
                  <label class="col-sm-2 control-label">Nama</label>
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
                        	foreach ($provinsiDataList as $keyP => $valueP) {
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
                <div class="form-group">
                  <label for="inputEmail3" class="col-sm-2 control-label">Jenis Identitas</label>
                  <div class="col-sm-5">                     
                      <div class="radio">
                        <label>
                          <input type="radio" name="JenisIdentitas" id="optionsJI1" value="Passport"/>
                          Passport
                        </label>
                      </div>
                      <div class="radio">
                        <label>
                          <input type="radio" name="JenisIdentitas" id="optionsJI2" value="SIM" />
                          SIM
                        </label>
                      </div>
                      <div class="radio">
                        <label>
                          <input type="radio" name="JenisIdentitas" id="optionsJI3" value="KTP" />
                          KTP
                        </label>
                      </div>
                      <div class="radio">
                        <label>
                          <input type="radio" name="JenisIdentitas" id="optionsJI4" value="NPWP" />
                          NPWP
                        </label>
                      </div>
                      <div class="radio">
                        <label>
                          <input type="radio" name="JenisIdentitas" id="optionsJI5" value="Kartu Pelajar" />
                          Kartu Pelajar
                        </label>
                      </div>
                  </div>
                </div>     
                <div class="form-group">
                  <label class="col-sm-2 control-label">No Identitas</label>
                  <div class="col-sm-8">
                    <input type="text" class="form-control" placeholder="" id="custIdenNo">
                  </div>
                </div>    
                <div class="form-group">
                  <label class="col-sm-2 control-label">No SIUP / NPWP</label>
                  <div class="col-sm-8">
                    <input type="text" class="form-control" placeholder="" id="custNoNpwp">
                  </div>
                </div>    
                <div class="form-group">
                  <label class="col-sm-2 control-label">Jenis Usaha</label>
                  <div class="col-sm-8">
                    <input type="text" class="form-control" placeholder="" id="custJenisUsaha">
                  </div>
                </div>    
                <div class="form-group">
                  <label class="col-sm-2 control-label">Nama Usaha</label>
                  <div class="col-sm-8">
                    <input type="text" class="form-control" placeholder="" id="custNamaUsaha">
                  </div>
                </div> 
                <div class="form-group">
                  <label class="col-sm-2 control-label">Provinsi Usaha</label>                  
                  <div class="col-sm-5">                    
                      <select class="form-control" name="custProv" id="custProvUsaha" onchange="getCity2()">
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
                  <label class="col-sm-2 control-label">Kota Usaha</label>
                  <div class="col-sm-5 optionCity2">                    
                      <select class="form-control" name="custCity" id="custCityUsaha">
                        <option value="0">- Pilih Kota -</option>
                      </select>
                  </div>
                </div>        
                <div class="form-group">
                  <label class="col-sm-2 control-label">Alamat Usaha</label>
                  <div class="col-sm-8">
                    <textarea class="form-control" rows="5" placeholder="Enter Address..." id="custAddressUsaha"></textarea>
                  </div>
                </div>      
                <div class="form-group">
                  <label class="col-sm-2 control-label">Nama Bank</label>
                  <div class="col-sm-8">
                    <input type="text" class="form-control" placeholder="" id="custBank">
                  </div>
                </div>    
                <div class="form-group">
                  <label class="col-sm-2 control-label">Nomor Rekening Bank</label>
                  <div class="col-sm-8">
                    <input type="text" class="form-control" placeholder="" id="custNoAccount">
                  </div>
                </div>  
                <div class="form-group">
                  <label class="col-sm-2 control-label">Min Balance</label>
                  <div class="col-sm-8">
                    <input type="text" class="form-control" placeholder="" id="custMinBal">
                  </div>
                </div>  
                <div class="form-group">
                  <label class="col-sm-2 control-label">Max Balance</label>
                  <div class="col-sm-8">
                    <input type="text" class="form-control" placeholder="" id="custMaxBal">
                  </div>
                </div> 
<!--                <div class="form-group">
                  <label class="col-sm-2 control-label">Tarif</label>
                  <div class="col-sm-8">
                    <input type="text" class="form-control" placeholder="" id="custTarif">
                  </div>
                </div>-->
        	  </div>
              <div class="box-footer">
                <!-- <a href="<?=base_url()?>authorize/Merchant" class="btn btn-default">Cancel</a> -->
                <button type="button" class="btn btn-info pull-right" onclick="submitFormRegistrasi()">Setuju dan Daftarkan</button>
              </div>
            </form>
          </div>
        </div>
    </div>
</section>
<form id="regNewDetail" method="post" action="<?=base_url()?>authorize/merchant_detail">
    <input type="hidden" id="custIdRegNew" name="custIdRegNew"></input>
</form>
<script type="text/javascript">
	var baseurl = "<?=base_url()?>";
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
	}function getCity2(){
		var provId = $('#custProvUsaha').val();
		if(provId != 0){
			$.ajax({
		        type: "POST",
		        url: baseurl+"authorize/getCityByProv",
		        data: {'provId': provId},
		        cache: false,
		        dataType: "json",
		        success: function (res) {
		        	var val = '';
		        	val += '<select class="form-control" name="custCity" id="custCityUsaha">';
		        	$.each(res, function (keyCity, valCity) {
		        		val += '<option value="'+valCity['ID_KABUPATEN']+'">'+valCity['NAMA_KABUPATEN']+'</option>';
		        	});
		        	val += '</select>';
		        	$('.optionCity2').html(val);
		        }
		    });
		}else{
        	var val = '';
        	val += '<select class="form-control" name="custCityUsaha">';
        	val += '<option value="0">- Pilih Kota -</option>';
        	val += '</select>';
			$('.optionCity2').html(val);
		}
	}
  function submitFormRegistrasi(){
    alert("Kode PPOB belum terdefinisi di dalam sistem kami (API). Silakan hubungi customer service T-MONEY untuk investigasi lebih lanjut");
    return false;
    var accType = $('#accType').val();
    var custName = $('#custName').val();
    var custEmail = $('#custEmail').val();
    var custProv = $('#custProv').val();
    var custCity = $('#custCity').val();
    var custAddress = $('#custAddress').val();
    var custPhone = $('#custPhone').val();
    var custIdenType = $("input[name='JenisIdentitas']:checked").val();
    var custIdenNo = $('#custIdenNo').val();
    var custNoNpwp = $('#custNoNpwp').val();
    var custProvUsaha = $('#custProvUsaha').val();
    var custCityUsaha = $('#custCityUsaha').val();
    var custNoAccount = $('#custNoAccount').val();
    var custBank = $('#custBank').val();
    var custAddressUsaha = $('#custAddressUsaha').val();
    var custMaxBal = $('#custMaxBal').val();
    var custMinBal = $('#custMinBal').val();
    var custJenisUsaha = $('#custJenisUsaha').val();
    var custNamaUsaha = $('#custNamaUsaha').val();
      
      
      if(custName != '' && custEmail != '' && custProv !=0 && custCity != 0 && custAddress != '' && custPhone != '' && typeof custIdenType != 'undefined' && custIdenNo != ''){
          $.ajax({
              type: "POST",
              url: baseurl+"authorize/addRegistration",
              data: {'accType':accType,'custName': custName, 'custEmail':custEmail, 'custProv':custProv, 'custCity':custCity, 'custAddress':custAddress, 
                  'custPhone':custPhone, 'custIdenType':custIdenType, 'custIdenNo':custIdenNo, 'custNoNpwp':custNoNpwp,
                  'custProvUsaha' :custProvUsaha, 'custCityUsaha':custCityUsaha, 'custNoAccount':custNoAccount, 'custBank':custBank,
                  'custAddressUsaha':custAddressUsaha, 'custMaxBal':custMaxBal, 'custMinBal':custMinBal, 
                   'custJenisUsaha':custJenisUsaha,'custNamaUsaha':custNamaUsaha},
              cache: false,
              dataType: "json",
              success: function (res) {
                  if(res.result){
                        $('#custIdRegNew').val(res.custId);                      
                        alert('Registration Success');
                        window.location.href = baseurl+"management/ppob_registration";
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