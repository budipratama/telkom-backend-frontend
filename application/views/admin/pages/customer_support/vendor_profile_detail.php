<section class="content-header">
    <h1>
      Vendor Profile
      <small>Detail</small>
    </h1>
</section>
<section class="content">
    <div class="row">
    <?php //print_r($customerData);?>
        <div class="col-md-12">  
          <div class="box box-info">
            <div class="box-header with-border">
              <h3 class="box-title">Vendor</h3>
            </div>
            <?php if(isset($vendorData)){ ?>
                <form class="form-horizontal">
                  <div class="box-body">
                    <div class="errorMessage hide alert alert-danger alert-dismissable">
                        <span class="messageText"></span>
                    </div>
                    <div class="successMessage hide alert alert-success alert-dismissable">
                        <span class="messageText"></span>
                    </div>
                    <div class="form-group">
                      <label for="inputEmail3" class="col-sm-2 control-label">Vendor Name</label>
                      <div class="col-sm-8">
                        <input type="text" id="vendorName" name='vendorName' class="form-control" value="<?=$vendorData[0]['VENDOR_NAME']?>">
                        <input type="hidden" id="vendorId" name="vendorId" class="form-control" value="<?=$vendorData[0]['ID']?>">
                      </div>
                    </div>
                    <div class="form-group">
                      <label for="inputEmail3" class="col-sm-2 control-label">Vendor Code</label>
                      <div class="col-sm-8">
                          <input type="text" id="vendorCode" name="vendorCode" class="form-control" value="<?=$vendorData[0]['VENDOR_CODE']?>">
                      </div>
                    </div>
                    <div class="form-group">
                      <label for="inputEmail3" class="col-sm-2 control-label">Vendor Account</label>
                      <div class="col-sm-8">
                          <input type="text" id="vendorAcc" name="vendorAcc" class="form-control" value="<?=$vendorData[0]['VENDOR_ACCOUNT']?>">
                      </div>
                    </div>
                    <div class="form-group">
                      <label for="inputEmail3" class="col-sm-2 control-label">Telco Code</label>
                      <div class="col-sm-8">
                          <input type="text" id="telcoCode" name="telcoCode" class="form-control" value="<?=$vendorData[0]['TELCO_CODE']?>">
                      </div>
                    </div> 
                    <div class="form-group">
                      <label for="inputEmail3" class="col-sm-2 control-label">Bank Account</label>
                      <div class="col-sm-8">
                          <input type="text" id="bankAcc" name="bankAcc" class="form-control" value="<?=$vendorData[0]['BANK_ACCOUNT']?>">
                      </div>
                    </div>  
                    <div class="form-group">
                      <label for="inputEmail3" class="col-sm-2 control-label">Remarks</label>
                      <div class="col-sm-8">
                        <textarea class="form-control" rows="5" placeholder="Enter remarks..." name="remarks" id="remarks"><?=$vendorData[0]['REMARKS']?></textarea>
                      </div>
                    </div> 
                    <div class="form-group">
                      <label for="inputEmail3" class="col-sm-2 control-label">Active From</label>
                      <div class="col-sm-8">
                            <div class="input-group">
                                <div class="input-group-addon">
                                <i class="fa fa-calendar"></i>
                                </div>
                                <?php $dateFrom = explode(' ', $vendorData[0]['VENDOR_ACTIVE_FROM']);?>
                                <input id="dateFrom" name="dateFrom" class="form-control" type="text" data-mask="" value="<?=$dateFrom[0]?>" data-inputmask="'alias': 'yyyy-mm-dd'">
                            </div>
                        </div>
                    </div>     
                    <div class="form-group">
                        <label for="inputEmail3" class="col-sm-2 control-label">Active To</label>
                        <div class="col-sm-8">
                            <div class="input-group">
                                <div class="input-group-addon">
                                <i class="fa fa-calendar"></i>
                                </div>
                                <?php $dateTo = explode(' ', $vendorData[0]['VENDOR_ACTIVE_TO']);?>
                                <input id="dateTo" name="dateTo" class="form-control" type="text" data-mask="" value="<?=$dateTo[0]?>" data-inputmask="'alias': 'yyyy-mm-dd'">
                            </div>
                        </div>                            
                    </div>                                      
                    <div class="form-group">
                      <div class="col-sm-offset-2 col-sm-10">
                        <div class="checkbox">
                            <?php 
                                $checked = '';
                                if($vendorData[0]['STATUS'] == 1){
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
                      <a href="<?=base_url()?>customer_support/vendor_profile" class="btn btn-default">Cancel</a>
                      <button type="button" class="btn btn-info pull-right" onclick="submitFormEdit()">Proses</button>
                    </div>
                </form>
            <?php }else{ ?>
                <form class="form-horizontal" id="formAdd" method="post" action="<?=base_url()?>customer_support/vendor_profile_save">
                    <div class="box-body">
                        <div class="errorMessage hide alert alert-danger alert-dismissable">
                            <span class="messageText"></span>
                        </div>
                        <div class="successMessage hide alert alert-success alert-dismissable">
                            <span class="messageText"></span>
                        </div>
                        <div class="form-group">
                          <label for="inputEmail3" class="col-sm-2 control-label">Vendor Name</label>
                          <div class="col-sm-8">
                            <input type="text" id="vendorName" name='vendorName' class="form-control">
                          </div>
                        </div>
                        <div class="form-group">
                          <label for="inputEmail3" class="col-sm-2 control-label">Vendor Code</label>
                          <div class="col-sm-8">
                              <input type="text" id="vendorCode" name="vendorCode" class="form-control">
                          </div>
                        </div>
                        <div class="form-group">
                          <label for="inputEmail3" class="col-sm-2 control-label">Vendor Account</label>
                          <div class="col-sm-8">
                              <input type="text" id="vendorAcc" name="vendorAcc" class="form-control">
                          </div>
                        </div>
                        <div class="form-group">
                          <label for="inputEmail3" class="col-sm-2 control-label">Telco Code</label>
                          <div class="col-sm-8">
                              <input type="text" id="telcoCode" name="telcoCode" class="form-control">
                          </div>
                        </div> 
                        <div class="form-group">
                          <label for="inputEmail3" class="col-sm-2 control-label">Bank Account</label>
                          <div class="col-sm-8">
                              <input type="text" id="bankAcc" name="bankAcc" class="form-control">
                          </div>
                        </div>  
                        <div class="form-group">
                          <label for="inputEmail3" class="col-sm-2 control-label">Remarks</label>
                          <div class="col-sm-8">
                            <textarea class="form-control" rows="5" placeholder="Enter remarks..." name="remarks" id="remarks"></textarea>
                          </div>
                        </div> 
                        <div class="form-group">
                          <label for="inputEmail3" class="col-sm-2 control-label">Active From</label>
                          <div class="col-sm-8">
                                <div class="input-group">
                                    <div class="input-group-addon">
                                    <i class="fa fa-calendar"></i>
                                    </div>
                                    <input id="dateFrom" name="dateFrom" class="form-control" type="text" data-mask="" data-inputmask="'alias': 'yyyy-mm-dd'">
                                </div>
                            </div>
                        </div>     
                        <div class="form-group">
                            <label for="inputEmail3" class="col-sm-2 control-label">Active To</label>
                            <div class="col-sm-8">
                                <div class="input-group">
                                    <div class="input-group-addon">
                                    <i class="fa fa-calendar"></i>
                                    </div>
                                    <input id="dateTo" name="dateTo" class="form-control" type="text" data-mask="" data-inputmask="'alias': 'yyyy-mm-dd'">
                                </div>
                            </div>                            
                        </div>                                      
                        <div class="form-group">
                          <div class="col-sm-offset-2 col-sm-10">
                            <div class="checkbox">
                                <label>
                                    <input type="checkbox" checked="" value="1" name="active" id="active"> Active
                                </label>
                            </div>
                          </div>
                        </div>
                        </div>
                      <div class="box-footer">
                        <a href="<?=base_url()?>customer_support/vendor_profile" class="btn btn-default">Cancel</a>
                        <button type="button" class="btn btn-info pull-right" onclick="submitFormAdd()">Proses</button>
                      </div>
                  </form>
              <?php } ?>
          </div>
        </div>
    </div>
</section>
<script src="<?=$css_admin?>plugins/input-mask/jquery.inputmask.js" type="text/javascript"></script>
<script src="<?=$css_admin?>plugins/input-mask/jquery.inputmask.date.extensions.js" type="text/javascript"></script>
<script src="<?=$css_admin?>plugins/input-mask/jquery.inputmask.extensions.js" type="text/javascript"></script>
<script type="text/javascript">
    var baseurl = "<?=base_url()?>";
    function submitFormEdit(){
        $('.errorMessage').addClass('hide');
        $('.successMessage').addClass('hide');
        var vendorName = $('#vendorName').val();
        var vendorId = $('#vendorId').val();
        var vendorCode = $('#vendorCode').val();
        var vendorAcc = $('#vendorAcc').val();
        var telcoCode = $('#telcoCode').val();
        var bankAcc = $('#bankAcc').val();
        var remarks = $('#remarks').val();
        var dateFrom = $('#dateFrom').val();
        var dateTo = $('#dateTo').val();
        var active = 0;
        if ($('#active').prop('checked')) {
            active = 1;
        }
        if(vendorName != '' && vendorCode != '' && vendorAcc != '' && telcoCode != '' && bankAcc != '' && dateFrom != '' && dateTo != ''){    
            $.ajax({
                type: "POST",
                url: baseurl+"customer_support/vendor_profile_save",
                data: {'vendorName': vendorName, 'vendorId' : vendorId, 'vendorCode' : vendorCode, 'vendorAcc' : vendorAcc,
                       'telcoCode' : telcoCode, 'bankAcc' : bankAcc, 'remarks' : remarks, 'dateFrom' : dateFrom, 'dateTo' : dateTo, 'active' : active},
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
        var vendorName = $('#vendorName').val();
        var vendorCode = $('#vendorCode').val();
        var vendorAcc = $('#vendorAcc').val();
        var telcoCode = $('#telcoCode').val();
        var bankAcc = $('#bankAcc').val();
        var remarks = $('#remarks').val();
        var dateFrom = $('#dateFrom').val();
        var dateTo = $('#dateTo').val();
        var active = 0;
        if ($('#active').prop('checked')) {
            active = 1;
        }
        if(vendorName != '' && vendorCode != '' && vendorAcc != '' && telcoCode != '' && bankAcc != '' && dateFrom != '' && dateTo != ''){    
            $('#formAdd').submit();
        }else{
            $('.errorMessage').removeClass('hide');
            $('.messageText').text("Error. Please fill all field");
        }
    }
    //Datemask dd/mm/yyyy
    $("#datemask").inputmask("yyyy-mm-dd", {"placeholder": "yyyy-mm-dd"});
    //Datemask2 mm/dd/yyyy
    $("#datemask2").inputmask("yyyy-mm-dd", {"placeholder": "yyyy-mm-dd"});
    //Money Euro
    $("[data-mask]").inputmask();
</script>