<section class="content-header">
    <h1>
      Product Value
      <small>Detail</small>
    </h1>
</section>
<section class="content">
    <div class="row">
    <?php //print_r($customerData);?>
        <div class="col-md-12">  
          <div class="box box-info">
            <div class="box-header with-border">
              <h3 class="box-title">Product Value</h3>
            </div>
            <?php if(isset($productValueData)){ ?>
                <form class="form-horizontal">
                  <div class="box-body">
                    <div class="errorMessage hide alert alert-danger alert-dismissable">
                        <span class="messageText"></span>
                    </div>
                    <div class="successMessage hide alert alert-success alert-dismissable">
                        <span class="messageText"></span>
                    </div>
                    <div class="form-group">
                      <label for="inputEmail3" class="col-sm-2 control-label">Product Name</label>
                      <div class="col-sm-8">                        
                                <select class="form-control" id="prdName" name="prdName">
                                    <?php foreach ($productData as $key => $value) {
                                        $selected = '';
                                        if($productValueData[0]['PRD_ID'] == $value['PRD_ID']){
                                            $selected = 'selected';
                                        }
                                        echo "<option value='".$value['PRD_ID']."' ".$selected.">".$value['PRD_NAME']."</option>";
                                    }
                                    ?>
                                </select>
                            <input type="hidden" id="prdValueId" name="prdValueId" class="form-control" value="<?=$productValueData[0]['ID']?>">
                      </div>
                    </div>
                    <div class="form-group">
                      <label for="inputEmail3" class="col-sm-2 control-label">Product Value</label>
                      <div class="col-sm-8">
                          <input type="text" id="prdValue" name="prdValue" class="form-control" value="<?=$productValueData[0]['PRD_VALUE']?>">
                      </div>
                    </div>
                    </div>
                    <div class="box-footer">
                      <a href="<?=base_url()?>customer_support/product_value" class="btn btn-default">Cancel</a>
                      <button type="button" class="btn btn-info pull-right" onclick="submitFormEdit()">Proses</button>
                    </div>
                </form>
            <?php }else{ ?>
                <form class="form-horizontal" id="formAdd" method="post" action="<?=base_url()?>customer_support/product_value_save">
                        <div class="box-body">
                            <div class="errorMessage hide alert alert-danger alert-dismissable">
                                <span class="messageText"></span>
                            </div>
                            <div class="successMessage hide alert alert-success alert-dismissable">
                                <span class="messageText"></span>
                            </div>
                            <div class="form-group">
                                <label for="inputEmail3" class="col-sm-2 control-label">Product Name</label>
                                <div class="col-sm-8">                        
                                          <select class="form-control" id="prdName" name="prdName">
                                              <?php foreach ($productData as $key => $value) {
                                                  $selected = '';
                                                  
                                                  echo "<option value='".$value['PRD_ID']."' ".$selected.">".$value['PRD_NAME']."</option>";
                                              }
                                              ?>
                                          </select>
                                </div>
                            </div>
                            <div class="form-group">
                              <label for="inputEmail3" class="col-sm-2 control-label">Product Value</label>
                              <div class="col-sm-8">
                                  <input type="text" id="prdValue" name="prdValue" class="form-control">
                              </div>
                            </div>
                        </div>
                        <div class="box-footer">
                          <a href="<?=base_url()?>customer_support/product_value" class="btn btn-default">Cancel</a>
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
        var prdName = $('#prdName').val();
        var prdValueId = $('#prdValueId').val();
        var prdValue = $('#prdValue').val();
        if(prdName != '' && prdValue != ''){    
            $.ajax({
                type: "POST",
                url: baseurl+"customer_support/product_value_save",
                data: {'prdName': prdName, 'prdValueId' : prdValueId, 'prdValue' : prdValue},
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
        var prdName = $('#prdName').val();
        var prdValue = $('#prdValue').val();
        if(prdName != '' && prdValue != ''){    
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