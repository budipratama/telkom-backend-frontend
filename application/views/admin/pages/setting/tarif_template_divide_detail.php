<link href="<?=$css_admin?>plugins/datepicker/datepicker3.css" rel="stylesheet" type="text/css" />
<section class="content-header">
    <h1>
      Tarif Template
      <small>Detail</small>
    </h1>
</section>
<section class="content">
    <div class="row">
    <?php //print_r($customerData);?>
        <div class="col-md-12">  
          <div class="box box-info">
            <div class="box-header with-border">
              <h3 class="box-title">Tarif Template Divide</h3>
            </div>
            <?php if(isset($tarifDivideData)){ ?>
                <form class="form-horizontal">
                  <div class="box-body">
                    <div class="errorMessage hide alert alert-danger alert-dismissable">
                        <span class="messageText"></span>
                    </div>
                    <div class="successMessage hide alert alert-success alert-dismissable">
                        <span class="messageText"></span>
                    </div>
                    <div class="form-group">
                      <label for="inputEmail3" class="col-sm-2 control-label">Tarif Template Name</label>
                      <div class="col-sm-8">
                        <select class="form-control" id="FH_ID" name="FH_ID">
                              <?php foreach ($tarifHeaderData as $key => $value) {
                                  $selected = '';
                                  if($tarifBodyData[0]['FH_ID'] == $value['FH_ID']){
                                      $selected = 'selected';
                                  }
                                  echo "<option value='".$value['FH_ID']."' ".$selected.">".$value['FH_NAME']."</option>";
                              }
                              ?>
                          </select>
                          <input type="hidden" id="FB_ID" class="form-control" value="<?=$tarifBodyData[0]['FB_ID']?>">
                      </div>
                    </div>  
                    <div class="form-group">
                      <label for="inputEmail3" class="col-sm-2 control-label">Ref Code</label>
                      <div class="col-sm-8">
                          <select class="form-control" id="REF_ID" name="REF_ID" onchange="checkRefId()">
                              <?php foreach ($refcodeData as $key => $value) {
                                  $selected = '';
                                  if($tarifBodyData[0]['REF_ID'] == $value['REF_ID']){
                                      $selected = 'selected';
                                  }
                                  echo "<option value='".$value['REF_ID']."' ".$selected.">".$value['REF_CODE']."</option>";
                              }
                              ?>
                          </select>
                      </div>
                    </div>
                    <div class="form-group prd_name hide">
                      <label for="inputEmail3" class="col-sm-2 control-label">Product Name</label>
                      <div class="col-sm-8">
                        <select class="form-control" id="PRD_NAME" name="PRD_NAME" onchange="checkProdName()">
                              <?php foreach ($productData as $key => $value) {
                                  $selected = '';
                                  if($tarifBodyData[0]['PRD_ID'] == $value['PRD_ID']){
                                      $selected = 'selected';
                                  }
                                  echo "<option value='".$value['PRD_ID']."' ".$selected.">".$value['PRD_NAME']."</option>";
                              }
                              ?>
                          </select>
                      </div>
                    </div> 
                    <div class="form-group prd_val hide optionPrdVal">
                      <label for="inputEmail3" class="col-sm-2 control-label">Product Value</label>
                      <div class="col-sm-8">
                        <select class="form-control" id="PRD_VAL_ID" name="PRD_VAL_ID">
                              <?php 
                                foreach ($productValueData as $key => $value) {
                                  if($tarifBodyData[0]['PRD_ID'] == $value['PRD_ID']){
                                    $selected = '';
                                    if($tarifBodyData[0]['PRD_VAL_ID'] == $value['ID']){
                                        $selected = 'selected';
                                    }
                                    echo "<option value='".$value['ID']."' ".$selected.">".$value['PRD_VALUE']."</option>";
                                }
                              }
                              ?>
                          </select>
                      </div>
                    </div>      
                    <div class="form-group">
                      <label for="inputEmail3" class="col-sm-2 control-label">Fee Type</label>
                      <div class="col-sm-8">
                        <select class="form-control" id="FT_ID" name="FT_ID">
                              <?php foreach ($typeData as $key => $value) {
                                  $selected = '';
                                  if($tarifBodyData[0]['FT_ID'] == $value['FT_ID']){
                                      $selected = 'selected';
                                  }
                                  echo "<option value='".$value['FT_ID']."' ".$selected.">".$value['FT_NAME']."</option>";
                              }
                              ?>
                          </select>
                      </div>
                    </div> 
                    <div class="form-group">
                      <label for="inputEmail3" class="col-sm-2 control-label">Active From</label>
                      <div class="col-sm-8">
<!--                            <div class="input-group">
                                <div class="input-group-addon">
                                <i class="fa fa-calendar"></i>
                                </div>
                                <?php $dateFrom = explode(' ', $tarifBodyData[0]['FB_ACTIVE_FROM']);?>
                                <input id="dateFrom" class="form-control" type="text" data-mask="" value="<?=$dateFrom[0]?>" data-inputmask="'alias': 'yyyy-mm-dd'">
                            </div>-->
                            <div class="input-group date" data-provide="datepicker" data-date-format="yyyy-mm-dd">
                                <?php $dateFrom = explode(' ', $tarifBodyData[0]['FB_ACTIVE_FROM']);?>
                                <input type="text"  id="dateFrom" class="form-control" value="<?=$dateFrom[0]?>">
                                <div class="input-group-addon">
                                    <span class="fa fa-calendar"></span>
                                </div>
                            </div>
                        </div>
                    </div>     
                    <div class="form-group">
                        <label for="inputEmail3" class="col-sm-2 control-label">Active To</label>
                        <div class="col-sm-8">
<!--                            <div class="input-group">
                                <div class="input-group-addon">
                                <i class="fa fa-calendar"></i>
                                </div>
                                <?php $dateTo = explode(' ', $tarifBodyData[0]['FB_ACTIVE_TO']);?>
                                <input id="dateTo"class="form-control" type="text" data-mask="" value="<?=$dateTo[0]?>" data-inputmask="'alias': 'yyyy-mm-dd'">
                            </div>
                            -->
                            <div class="input-group date" data-provide="datepicker" data-date-format="yyyy-mm-dd">
                                <?php $dateTo = explode(' ', $tarifBodyData[0]['FB_ACTIVE_TO']);?>
                                <input type="text"  id="dateTo" class="form-control" value="<?=$dateTo[0]?>">
                                <div class="input-group-addon">
                                    <span class="fa fa-calendar"></span>
                                </div>
                            </div>
                        </div>                            
                    </div>                               
                    <div class="form-group">
                      <div class="col-sm-offset-2 col-sm-10">
                        <div class="checkbox">
                          <?php 
                                $checked = '';
                                if($tarifBodyData[0]['FB_STATUS'] == 1){ 
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
                      <a href="<?=base_url()?>setting/tarif_template_divide" class="btn btn-default">Cancel</a>
                      <button type="button" class="btn btn-info pull-right" onclick="submitFormEdit()">Proses</button>
                    </div>
                </form>
            <?php }else{ ?>
                <form class="form-horizontal" id="formAdd" method="post" action="<?=base_url()?>setting/tarif_template_body_save">
                  <div class="box-body">
                    <div class="errorMessage hide alert alert-danger alert-dismissable">
                        <span class="messageText"></span>
                    </div>
                    <div class="successMessage hide alert alert-success alert-dismissable">
                        <span class="messageText"></span>
                    </div>
                    <div class="form-group">
                      <label for="inputEmail3" class="col-sm-2 control-label">Tarif Template Name</label>
                        <div class="col-sm-8">
                            <select class="form-control" id="FH_ID" name="FH_ID">
                                  <?php foreach ($tarifHeaderData as $key => $value) {
                                      echo "<option value='".$value['FH_ID']."'>".$value['FH_NAME']."</option>";
                                  }
                                  ?>
                            </select>
                        </div>
                    </div>  
                    <div class="form-group">
                      <label for="inputEmail3" class="col-sm-2 control-label">Ref Code</label>
                      <div class="col-sm-8">
                          <select class="form-control" id="REF_ID" name="REF_ID" onchange="checkRefId()">
                              <?php foreach ($refcodeData as $key => $value) {
                                  echo "<option value='".$value['REF_ID']."'>".$value['REF_CODE']."</option>";
                              }
                              ?>
                          </select>
                      </div>
                    </div>
                    <div class="form-group prd_name">
                      <label for="inputEmail3" class="col-sm-2 control-label">Product Name</label>
                      <div class="col-sm-8">
                        <select class="form-control" id="PRD_NAME" name="PRD_NAME" onchange="checkProdName()">
                              <?php foreach ($productData as $key => $value) {
                                  echo "<option value='".$value['PRD_ID']."'>".$value['PRD_NAME']."</option>";
                              }
                              ?>
                          </select>
                      </div>
                    </div> 
                    <div class="form-group prd_val  optionPrdVal">
                      <label for="inputEmail3" class="col-sm-2 control-label">Product Value</label>
                      <div class="col-sm-8">
                        <select class="form-control" id="PRD_VAL_ID" name="PRD_VAL_ID">
                            <option value="-">- Select Product -</option>
                          </select>
                      </div>
                    </div>      
                    <div class="form-group">
                      <label for="inputEmail3" class="col-sm-2 control-label">Fee Type</label>
                      <div class="col-sm-8">
                        <select class="form-control" id="FT_ID" name="FT_ID">
                              <?php foreach ($typeData as $key => $value) {
                                  echo "<option value='".$value['FT_ID']."'>".$value['FT_NAME']."</option>";
                              }
                              ?>
                          </select>
                      </div>
                    </div> 
                    <div class="form-group">
                      <label for="inputEmail3" class="col-sm-2 control-label">Active From</label>
                        <div class="col-sm-8">
                            <div class="input-group date" data-provide="datepicker" data-date-format="yyyy-mm-dd">
                                <input type="text" name="dateFrom"   id="dateFrom" class="form-control" value="">
                                <div class="input-group-addon">
                                    <span class="fa fa-calendar"></span>
                                </div>
                            </div>
                        </div>
                    </div>     
                    <div class="form-group">
                        <label for="inputEmail3" class="col-sm-2 control-label">Active To</label>
                        <div class="col-sm-8">
                            <div class="input-group date" data-provide="datepicker" data-date-format="yyyy-mm-dd">
                                <input type="text" name="dateTo"   id="dateTo" class="form-control" value="">
                                <div class="input-group-addon">
                                    <span class="fa fa-calendar"></span>
                                </div>
                            </div>
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
                      <a href="<?=base_url()?>setting/tarif_template_divide" class="btn btn-default">Cancel</a>
                      <button type="button" class="btn btn-info pull-right" onclick="submitFormSave()">Proses</button>
                    </div>
                </form>
              <?php } ?>
          </div>
        </div>
    </div>
</section>
<script src="<?=$css_admin?>plugins/datepicker/bootstrap-datepicker.js" type="text/javascript"></script>
<script src="<?=$css_admin?>plugins/input-mask/jquery.inputmask.js" type="text/javascript"></script>
<script src="<?=$css_admin?>plugins/input-mask/jquery.inputmask.date.extensions.js" type="text/javascript"></script>
<script src="<?=$css_admin?>plugins/input-mask/jquery.inputmask.extensions.js" type="text/javascript"></script>
<script type="text/javascript">
    var baseurl = "<?=base_url()?>";
    checkRefId();
    function submitFormEdit(){
        $('.errorMessage').addClass('hide');
        $('.successMessage').addClass('hide');
        var FB_ID = $('#FB_ID').val();
        var FH_ID = $('#FH_ID').val();
        var REF_ID = $('#REF_ID').val();
        var dateFrom = $('#dateFrom').val();
        var dateTo = $('#dateTo').val();
        
        if(REF_ID == 1){
            var PRD_NAME = $('#PRD_NAME').val();
            var PRD_VAL_ID = $('#PRD_VAL_ID').val();
        }else if(refId == 2){            
            var PRD_NAME = $('#PRD_NAME').val();
        }else if(refId == 6){            
            var PRD_NAME = $('#PRD_NAME').val();
        }else{            
            var PRD_NAME = '-';
            var PRD_VAL_ID = '-';
        }
        var FT_ID = $('#FT_ID').val();
        var active = 0;
        if ($('#active').prop('checked')) {
            active = 1;
        }
//        if(provName != ''){    
            $.ajax({
                type: "POST",
                url: baseurl+"setting/tarif_template_body_save",
                data: {'FB_ID': FB_ID, 'FH_ID' : FH_ID, 'REF_ID' : REF_ID, 'PRD_NAME' : PRD_NAME, 'PRD_VAL_ID' : PRD_VAL_ID, 
                        'FT_ID' : FT_ID, 'dateFrom':dateFrom, 'dateTo':dateTo, 'active' : active},
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
//        }else{
//            $('.errorMessage').removeClass('hide');
//            $('.messageText').text('Please fill all Field');
//        }
    }
    function submitFormSave(){
        $('.errorMessage').addClass('hide');
        $('.successMessage').addClass('hide');
        var dateFrom = $('#dateFrom').val();
        var dateTo = $('#dateTo').val();
        var active = 0;
        if ($('#active').prop('checked')) {
            active = 1;
        }
        if(dateFrom != '' && dateTo != ''){
            $('#formAdd').submit();
        }else{
            $('.errorMessage').removeClass('hide');
            $('.messageText').text("Error. Please fill all field");
        }
    }
    function checkRefId(){
        var refId = $('#REF_ID').val();
        $('.prd_name').addClass('hide');
        $('.prd_val').addClass('hide');
        if(refId == 1){
            $('.prd_name').removeClass('hide');
            $('.prd_val').removeClass('hide');
        }else if(refId == 2){            
            $('.prd_name').removeClass('hide');
        }else if(refId == 6){            
            $('.prd_name').removeClass('hide');
        }
    }
    function checkProdName(){
        var prdName = $('#PRD_NAME').val();
        $.ajax({
            type: "POST",
            url: baseurl+"setting/checkPrdValByPrdName",
            data: {'prdName': prdName},
            cache: false,
            dataType: "json",
            success: function (res) {
                var val = '';
                
                val += '<label for="inputEmail3" class="col-sm-2 control-label">Product Value</label>'+
                       '<div class="col-sm-8">'+
                            '<select class="form-control" id="PRD_VAL_ID" name="PRD_VAL_ID">';
                                $.each(res, function (keyPrdVal, valPrdVal) {
                                    val += '<option value="'+valPrdVal['ID']+'">'+valPrdVal['PRD_VALUE']+'</option>';
                                });                              
                    val +=  '</select>'+
                        '</div>';
                $('.optionPrdVal').html(val);
            }
        });
    }
    //Datemask dd/mm/yyyy
    $("#datemask").inputmask("yyyy-mm-dd", {"placeholder": "yyyy-mm-dd"});
    //Datemask2 mm/dd/yyyy
    $("#datemask2").inputmask("yyyy-mm-dd", {"placeholder": "yyyy-mm-dd"});
    //Money Euro
    $("[data-mask]").inputmask();
</script>