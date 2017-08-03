<section class="content-header">
    <h1>
      City
      <small>Detail</small>
    </h1>
</section>
<section class="content">
    <div class="row">
    <?php //print_r($customerData);?>
        <div class="col-md-12">  
          <div class="box box-info">
            <div class="box-header with-border">
              <h3 class="box-title">City</h3>
            </div>
            <?php if(isset($cityData)){ ?>
                <form class="form-horizontal">
                  <div class="box-body">
                    <div class="errorMessage hide alert alert-danger alert-dismissable">
                        <span class="messageText"></span>
                    </div>
                    <div class="successMessage hide alert alert-success alert-dismissable">
                        <span class="messageText"></span>
                    </div>
                    <div class="form-group">
                      <label for="inputEmail3" class="col-sm-2 control-label">City Name</label>
                      <div class="col-sm-8">
                        <input type="text" id="cityName" class="form-control" value="<?=$cityData[0]['NAMA_KABUPATEN']?>">
                        <input type="hidden" id="cityId" class="form-control" value="<?=$cityData[0]['ID_KABUPATEN']?>">
                      </div>
                    </div>
                    <div class="form-group">
                      <label for="inputEmail3" class="col-sm-2 control-label">City Code</label>
                      <div class="col-sm-8">
                        <input type="text" id="cityCode" class="form-control" value="<?=$cityData[0]['KODE_KABUPATEN']?>">
                      </div>
                    </div>
                    <div class="form-group">
                      <label for="inputEmail3" class="col-sm-2 control-label">Province</label>
                      <div class="col-sm-8">
                          <select class="form-control" id="provId" name="provId">
                              <?php foreach ($provinsiData as $key => $value) {
                                  $selected = '';
                                  if($cityData[0]['ID_PROVINSI'] == $value['ID_PROVINSI']){
                                      $selected = 'selected';
                                  }
                                  echo "<option value='".$value['ID_PROVINSI']."' ".$selected.">".$value['NAMA_PROVINSI']."</option>";
                              }
                              ?>
                          </select>
                      </div>  
                    </div>                                        
                    <div class="form-group">
                      <div class="col-sm-offset-2 col-sm-10">
                        <div class="checkbox">
                          <?php 
                                $checked = '';
                                if($cityData[0]['STATUS'] == 1){
                                    $checked = "checked=''";
                                }
                          ?>
                          <label>
                              <input type="checkbox" <?=$checked?> value="1" name="active" id="active"> Active
                          </label>
                        </div>
                      </div>
                    </div>
                    </div>
                    <div class="box-footer">
                      <a href="<?=base_url()?>management/city" class="btn btn-default">Cancel</a>
                      <button type="button" class="btn btn-info pull-right" onclick="submitFormEdit()">Proses</button>
                    </div>
                        
                </form>
            <?php }else{ ?>
                <form class="form-horizontal" id="formAddCity" method="post" action="<?=base_url()?>management/city_save">
                    <div class="box-body">
                      <div class="errorMessage hide alert alert-danger alert-dismissable">
                          <span class="messageText"></span>
                      </div>
                      <div class="successMessage hide alert alert-success alert-dismissable">
                          <span class="messageText"></span>
                      </div>
                      <div class="form-group">
                        <label for="inputEmail3" class="col-sm-2 control-label">City Name</label>
                        <div class="col-sm-8">
                          <input type="text" id="cityName" name="cityName" class="form-control" value="">
                        </div>
                      </div>
                      <div class="form-group">
                        <label for="inputEmail3" class="col-sm-2 control-label">City Code</label>
                        <div class="col-sm-8">
                          <input type="text" id="cityCode" name="cityCode"class="form-control" value="">
                        </div>
                      </div>
                      <div class="form-group">
                        <label for="inputEmail3" class="col-sm-2 control-label">Province</label>
                        <div class="col-sm-8">
                            <select class="form-control" id="provId" name="provId">
                                <?php foreach ($provinsiData as $key => $value) {
                                    echo "<option value='".$value['ID_PROVINSI']."'>".$value['NAMA_PROVINSI']."</option>";
                                }
                                ?>
                            </select>
                        </div>  
                      </div>                                        
                      <div class="form-group">
                        <div class="col-sm-offset-2 col-sm-10">
                          <div class="checkbox">
                            <label>
                                <input type="checkbox" value="1" name="active" id="active"> Active
                            </label>
                          </div>
                        </div>
                      </div>
                      </div>
                      <div class="box-footer">
                        <a href="<?=base_url()?>management/city" class="btn btn-default">Cancel</a>
                        <button type="button" class="btn btn-info pull-right" onclick="submitFormAdd()">Proses</button>
                      </div>
                  </form>
              <?php } ?>
          </div>
        </div>
    </div>
</section>
<script type="text/javascript">
    var baseurl = "<?=base_url()?>";
    function submitFormEdit(){
        $('.errorMessage').addClass('hide');
        $('.successMessage').addClass('hide');
        var cityName = $('#cityName').val();
        var cityId = $('#cityId').val();
        var provId = $('#provId').val();
        var cityCode = $('#cityCode').val();
        var active = 0;
        if ($('#active').prop('checked')) {
            active = 1;
        }
        if(cityName != '' && cityCode != ''){    
            $.ajax({
                type: "POST",
                url: baseurl+"management/city_save",
                data: {'cityId': cityId, 'cityName' : cityName, 'provId' : provId, 'cityCode' : cityCode, 'active' : active},
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
            $('.errorMessage').removeClass('hide');
            $('.messageText').text('Please fill all Field');
        }
    }
    function submitFormAdd(){
        $('.errorMessage').addClass('hide');
        $('.successMessage').addClass('hide');
        var cityName = $('#cityName').val();
        var provId = $('#provId').val();
        var cityCode = $('#cityCode').val();
        var active = 0;
        if ($('#active').prop('checked')) {
            active = 1;
        }
        if(cityName != '' && cityCode != ''){
            $('#formAddCity').submit();
        }else{
            $('.errorMessage').removeClass('hide');
            $('.messageText').text("Error. Please fill all field");
        }
    }
</script>