<section class="content-header">
    <h1>
      Province
      <small>Detail</small>
    </h1>
</section>
<section class="content">
    <div class="row">
    <?php //print_r($customerData);?>
        <div class="col-md-12">  
          <div class="box box-info">
            <div class="box-header with-border">
              <h3 class="box-title">Province</h3>
            </div>
            <?php if(isset($provinsiData)){ ?>
                <form class="form-horizontal">
                  <div class="box-body">
                    <div class="errorMessage hide alert alert-danger alert-dismissable">
                        <span class="messageText"></span>
                    </div>
                    <div class="successMessage hide alert alert-success alert-dismissable">
                        <span class="messageText"></span>
                    </div>
                    <div class="form-group">
                      <label for="inputEmail3" class="col-sm-2 control-label">Province Name</label>
                      <div class="col-sm-8">
                        <input type="text" id="provName" class="form-control" value="<?=$provinsiData[0]['NAMA_PROVINSI']?>">
                        <input type="hidden" id="provId" class="form-control" value="<?=$provinsiData[0]['ID_PROVINSI']?>">
                      </div>
                    </div>                                  
                    <div class="form-group">
                      <div class="col-sm-offset-2 col-sm-10">
                        <div class="checkbox">
                          <?php 
                                $checked = '';
                                if($provinsiData[0]['STATUS'] == 1){
                                    $checked = "checked=''";
                                }
                          ?>
                          <label>
                              <input type="checkbox" <?=$checked?> value="1" name="active" id="active"> Active
                          </label>
                        </div>
                      </div>
                    </div>
                    <div>
                    <div class="box-footer">
                      <a href="<?=base_url()?>management/province" class="btn btn-default">Cancel</a>
                      <button type="button" class="btn btn-info pull-right" onclick="submitFormEdit()">Proses</button>
                    </div>
                </form>
            <?php }else{ ?>
                <form class="form-horizontal" id="formAddprov" method="post" action="<?=base_url()?>management/province_save">
                    <div class="box-body">
                      <div class="errorMessage hide alert alert-danger alert-dismissable">
                          <span class="messageText"></span>
                      </div>
                      <div class="successMessage hide alert alert-success alert-dismissable">
                          <span class="messageText"></span>
                      </div>
                      <div class="form-group">
                        <label for="inputEmail3" class="col-sm-2 control-label">Province Name</label>
                        <div class="col-sm-8">
                          <input type="text" id="provName" name="provName" class="form-control" value="">
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
                      <div>
                      <div class="box-footer">
                        <a href="<?=base_url()?>management/province" class="btn btn-default">Cancel</a>
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
        var provName = $('#provName').val();
        var provId = $('#provId').val();
        var provId = $('#provId').val();
        var active = 0;
        if ($('#active').prop('checked')) {
            active = 1;
        }
        if(provName != ''){    
            $.ajax({
                type: "POST",
                url: baseurl+"management/province_save",
                data: {'provId': provId, 'provName' : provName, 'active' : active},
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
        var provName = $('#provName').val();
        var active = 0;
        if ($('#active').prop('checked')) {
            active = 1;
        }
        if(provName != ''){
            $('#formAddprov').submit();
        }else{
            $('.errorMessage').removeClass('hide');
            $('.messageText').text("Error. Please fill all field");
        }
    }
</script>