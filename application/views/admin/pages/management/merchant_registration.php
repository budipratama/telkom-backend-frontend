<section class="content-header">
    <h1>
      Registration
      <small>Merchant</small>
    </h1>
</section>
<section class="content">
    <div class="row">
        <div class="col-md-12">
          <div class="box box-info">
            <div class="box-header with-border">
              <h3 class="box-title">Data Merchant</h3>
            </div>
            <form id="registration-form" class="form-horizontal">
              <div class="box-body">
                <div class="form-group">
                  <label class="col-sm-2 control-label">Tipe Akun</label>
                  <div class="col-sm-8">
                    <select class="form-control" name="accType" id="accType" disabled="disabled">
                        <?php
                            foreach ($custLevel as $key => $value) {
                                $selected = ($value['ID'] == 3) ? "selected" : NULL;

                                echo '<option value="'.$value['ID'].'" '.$selected.'>'.$value['LEVEL_NAME'].'</option>';
                            }
                        ?>
                      </select>
                  </div>
                </div>

                <!-- Gold field -->
                <div id="form-section-1" class="form-section" style="display:none">
                  <div class="form-group">
                    <label class="col-sm-2 control-label">Nama</label>
                    <div class="col-sm-8">
                      <input type="text" class="form-control" name="custName"  placeholder="" id="custName">
                    </div>
                  </div>
                  <div class="form-group">
                    <label class="col-sm-2 control-label">Email</label>
                    <div class="col-sm-8">
                      <input type="text" class="form-control" name="custEmail"  placeholder="" id="custEmail">
                    </div>
                  </div>
                  <div class="form-group">
                    <label class="col-sm-2 control-label">No Telpon / HP</label>
                    <div class="col-sm-8">
                      <input type="text" class="form-control" placeholder="" id="custPhone">
                    </div>
                  </div>
                </div>

                <!-- Platinum field -->
                <div id="form-section-2" class="form-section" style="display:none">
                  <div class="form-group">
                    <label class="col-sm-2 control-label">Provinsi</label>
                    <div class="col-sm-5">
                        <select class="form-control" name="custProv" id="custProv" onchange="getCity('custCity')">
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
                    </div>
                  </div>
                  <div class="form-group">
                    <label class="col-sm-2 control-label">No Identitas</label>
                    <div class="col-sm-8">
                      <input type="text" class="form-control" placeholder="" id="custIdenNo">
                    </div>
                  </div>
                </div>

                <!-- Merchant field -->
                <div id="form-section-3" class="form-section" style="display:none">
                  <div class="form-group">
                    <label class="col-sm-2 control-label">Izin Bisnis (Nomor NPWP)</label>
                    <div class="col-sm-8">
                      <input type="text" class="form-control" name="custNoNpwp"  placeholder="" id="custNoNpwp">
                    </div>
                  </div>
                  <div class="form-group">
                    <label class="col-sm-2 control-label">Jenis Usaha</label>
                    <div class="col-sm-8">
                      <input type="text" class="form-control" name="custJenisUsaha"  placeholder="" id="custJenisUsaha">
                    </div>
                  </div>
                  <div class="form-group">
                    <label class="col-sm-2 control-label">Nama Usaha</label>
                    <div class="col-sm-8">
                      <input type="text" class="form-control" name="custNamaUsaha"  placeholder="" id="custNamaUsaha">
                    </div>
                  </div>
                  <div class="form-group">
                    <label class="col-sm-2 control-label">Provinsi Usaha</label>
                    <div class="col-sm-5">
                        <select class="form-control" name="custProvUsaha" id="custProvUsaha" onchange="getCity('custCityUsaha')">
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
                    <div class="col-sm-5 optionCity">
                        <select class="form-control" name="custCityUsaha" id="custCityUsaha">
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
                    <label class="col-sm-2 control-label">Kode Bank</label>
                    <div class="col-sm-8">
                      <input type="text" class="form-control" name="custBankCode"  placeholder="" id="custBankCode">
                    </div>
                  </div>
                  <div class="form-group">
                    <label class="col-sm-2 control-label">Nomor Rekening</label>
                    <div class="col-sm-8">
                      <input type="text" class="form-control" name="custBankAccount"  placeholder="" id="custBankAccount">
                    </div>
                  </div>
                  <div class="form-group">
                    <label class="col-sm-2 control-label">URL Website Usaha</label>
                    <div class="col-sm-8">
                      <input type="text" class="form-control" name="custUrlUsaha"  placeholder="http://www.example.com" id="custUrlUsaha">
                    </div>
                  </div>
                </div>
              </div>
              <div class="box-footer">
                <button id="btn-register" type="button" class="btn btn-info pull-right" onclick="submitFormRegistrasi()" disabled="disabled">Setuju dan Daftarkan</button>
              </div>
            </form>
          </div>
        </div>
    </div>
</section>
<form id="regNewDetail" method="post" action="<?php echo base_url()?>authorize/registration_detail">
    <input type="hidden" id="custIdRegNew" name="custIdRegNew"></input>
</form>
<script type="text/javascript">
  var baseurl = "<?php echo base_url()?>";

  // init
  $(function(){
    // view field
    setFormSection();
  });

  // view field
  $('#accType').on('change', function(){
    setFormSection();
  });

  // set form section
  function setFormSection(){
    // hide all
    $('.form-section').hide();

    // disabled button
    $('#btn-register').prop('disabled', true);

    // set rule
    var sectionViewRule = {
      2: [1], // view also section 1
      3: [1,2],
    }

    // seet acc type
    var accType = $('#accType').val();

    // set section
    var formSection = $('#form-section-' + accType);

    // check is acc type supported
    if(formSection.length < 1){
      alert("Account type not supported!");
      return false;
    }

    // set view rule
    if(typeof sectionViewRule[accType] != 'undefined'){
      sectionViewRule[accType].forEach(function(val, i){
        // show related section
        $('#form-section-' + val).show();
      });
    }

    // view section
    formSection.show();

    // enable button
    $('#btn-register').prop('disabled', false);
  }

  function getCity(cityElementID){
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
              $.each(res, function (keyCity, valCity) {
                val += '<option value="'+valCity['ID_KABUPATEN']+'">'+valCity['NAMA_KABUPATEN']+'</option>';
              });

              $('#'+cityElementID).html(val);
            }
        });
    }else{
      val = '<option value="0">- Pilih Kota -</option>';

      $('#'+cityElementID).html(val);
    }
  }

  function submitFormRegistrasi(){
    // set all input
    var allInputs = {
      accType: $('#accType').val(),
      custName: $('#custName').val(),
      custEmail: $('#custEmail').val(),
      custPhone: $('#custPhone').val(),
      custProv: $('#custProv').val(),
      custCity: $('#custCity').val(),
      custAddress: $('#custAddress').val(),
      custIdenType: $("input[name='JenisIdentitas']:checked").val(),
      custIdenNo: $('#custIdenNo').val(),
      custNoNpwp: $('#custNoNpwp').val(),
      custJenisUsaha: $('#custJenisUsaha').val(),
      custNamaUsaha: $('#custNamaUsaha').val(),
      custProvUsaha: $('#custProvUsaha').val(),
      custCityUsaha: $('#custCityUsaha').val(),
      custAddressUsaha: $('#custAddressUsaha').val(),
      custBankCode: $('#custBankCode').val(),
      custBankAccount: $('#custBankAccount').val(),
      custUrlUsaha: $('#custUrlUsaha').val(),
    };

    // validation section rule
    var validationSectionRule = {};
    validationSectionRule.section_1 = [
        'accType',
        'custName',
        'custEmail',
        'custPhone',
      ];
    validationSectionRule.section_2 = validationSectionRule.section_1.concat([
        'custProv',
        'custCity',
        'custAddress',
        'custIdenType',
        'custIdenNo',
      ]);
    validationSectionRule.section_3 = validationSectionRule.section_2.concat([
        'custNoNpwp',
        'custJenisUsaha',
        'custNamaUsaha',
        'custProvUsaha',
        'custCityUsaha',
        'custAddressUsaha',
        'custBankCode',
        'custBankAccount',
        'custUrlUsaha',
      ]);

    // set selected rule
    var selectedRules = [];
    if(validationSectionRule['section_' + allInputs.accType] != 'undefined')
      selectedRules = validationSectionRule['section_' + allInputs.accType];

    // check validation
    var validationStatus = true;
    for(var key in allInputs){
      if(selectedRules.indexOf(key) >= 0){
        // validation false
        if(allInputs[key] == '' || allInputs[key] == 0 || allInputs[key] == 'undefined'){
          validationStatus = false;
          break;
        }
      }
    }

    // show alert
    if(validationStatus == false){
      alert('Please Fill all field.');
    }
    else{
      $.ajax({
        type: "POST",
        url: baseurl+"authorize/addRegistration",
        data: allInputs,
        cache: false,
        dataType: "json",
        success: function (response) {
            if(response.result){
              $('#custIdRegNew').val(response.custId);

              alert('Registration Success');
              window.location.href = baseurl+"management/merchant_registration";
            }else{

              alert(response.message+': '+response.error);
            }
        }
      });
    }
  }
</script>
