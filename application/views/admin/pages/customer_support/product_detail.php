<section class="content-header">
    <h1>
      Product
      <small>Detail</small>
    </h1>
</section>
<section class="content">
    <div class="row">
    <?php //print_r($customerData);?>
        <div class="col-md-12">
          <div class="box box-info">
            <div class="box-header with-border">
              <h3 class="box-title">Product</h3>
            </div>
            <?php if(isset($productData)){ ?>
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
                        <input type="text" id="prdName" name='prdName' class="form-control" value="<?=$productData[0]['PRD_NAME']?>">
                        <input type="hidden" id="prdId" name="prdId" class="form-control" value="<?=$productData[0]['PRD_ID']?>">
                      </div>
                    </div>
                    <div class="form-group">
                      <label for="inputEmail3" class="col-sm-2 control-label">Product Code</label>
                      <div class="col-sm-8">
                          <input type="text" id="prdCode" name="prdCode" class="form-control" value="<?=$productData[0]['PRD_CODE']?>">
                      </div>
                    </div>
                    <div class="form-group">
                      <label for="inputEmail3" class="col-sm-2 control-label">Product Order</label>
                      <div class="col-sm-8">
                          <input type="text" id="prdOrder" name="prdOrder" class="form-control" value="<?=$productData[0]['PRD_ORDER']?>">
                      </div>
                    </div>
                    <div class="form-group">
                      <label for="inputEmail3" class="col-sm-2 control-label">Product Group</label>
                      <div class="col-sm-8">
                            <select class="form-control" id="prdGroup" name="prdGroup">
                                <?php foreach ($productGroupData as $key => $value) {
                                    $selected = '';
                                    if($productData[0]['PRD_GROUP'] == $value['GROUP_ID']){
                                        $selected = 'selected';
                                    }
                                    echo "<option value='".$value['GROUP_ID']."' ".$selected.">".$value['GROUP_NAME']."</option>";
                                }
                                ?>
                            </select>
                      </div>
                    </div>
                    <div class="form-group">
                      <label for="inputEmail3" class="col-sm-2 control-label">Operator</label>
                      <div class="col-sm-8">
                            <select class="form-control" id="operatorCode" name="operatorCode">
                                <?php foreach ($operatorData as $key => $value) {
                                    $selected = '';
                                    if($productData[0]['OP_CODE'] == $value['OP_ID']){
                                        $selected = 'selected';
                                    }
                                    echo "<option value='".$value['OP_ID']."' ".$selected.">".$value['OP_NAME']."</option>";
                                }
                                ?>
                            </select>
                      </div>
                    </div>
                    <div class="form-group">
                      <label for="inputEmail3" class="col-sm-2 control-label">Vendor</label>
                      <div class="col-sm-8">
                            <select class="form-control" id="vendorId" name="vendorId">
                                <?php foreach ($vendorData as $key => $value) {
                                    $selected = '';
                                    if($vendorSelected[0]['VENDOR_ID'] == $value['ID']){
                                        $selected = 'selected';
                                    }
                                    echo "<option value='".$value['ID']."' ".$selected.">".$value['VENDOR_NAME']."</option>";
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
                                if($productData[0]['PRD_ACTIVE'] == 1){
                                    $checked = "checked=''";
                                }
                            ?>
                            <label>
                                <input type="checkbox"  <?=$checked?> value="1" name="active" id="active"> Active
                            </label>
                        </div>
                      </div>
                    </div>
                    </div>
                    <div class="box-footer">
                      <a href="<?=base_url()?>customer_support/product" class="btn btn-default">Cancel</a>
                      <button type="button" class="btn btn-info pull-right" onclick="submitFormEdit()">Proses</button>
                    </div>
                </form>
            <?php }else{ ?>
                <form class="form-horizontal" id="formAdd" method="post" action="<?=base_url()?>customer_support/product_save">
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
                            <input type="text" id="prdName" name='prdName' class="form-control">
                          </div>
                        </div>
                        <div class="form-group">
                          <label for="inputEmail3" class="col-sm-2 control-label">Product Code</label>
                          <div class="col-sm-8">
                              <input type="text" id="prdCode" name="prdCode" class="form-control">
                          </div>
                        </div>
                        <div class="form-group">
                          <label for="inputEmail3" class="col-sm-2 control-label">Product Group</label>
                          <div class="col-sm-8">
                                <select class="form-control" id="prdGroup" name="prdGroup">
                                    <?php foreach ($productGroupData as $key => $value) {
                                        $selected = '';
                                        echo "<option value='".$value['GROUP_ID']."' ".$selected.">".$value['GROUP_NAME']."</option>";
                                    }
                                    ?>
                                </select>
                          </div>
                        </div>
                        <div class="form-group">
                          <label for="inputEmail3" class="col-sm-2 control-label">Operator</label>
                          <div class="col-sm-8">
                                <select class="form-control" id="operatorCode" name="operatorCode">
                                    <?php foreach ($operatorData as $key => $value) {
                                        $selected = '';
                                        echo "<option value='".$value['OP_ID']."' ".$selected.">".$value['OP_NAME']."</option>";
                                    }
                                    ?>
                                </select>
                          </div>
                        </div>
                        <div class="form-group">
                          <label for="inputEmail3" class="col-sm-2 control-label">Vendor</label>
                          <div class="col-sm-8">
                                <select class="form-control" id="vendorId" name="vendorId">
                                    <?php foreach ($vendorData as $key => $value) {
                                        echo "<option value='".$value['ID']."'>".$value['VENDOR_NAME']."</option>";
                                    }
                                    ?>
                                </select>
                          </div>
                        </div>
                        <div class="form-group">
                          <div class="col-sm-offset-2 col-sm-10">
                            <div class="checkbox">
                                <label>
                                    <input type="checkbox"checked="" value="1" name="active" id="active"> Active
                                </label>
                            </div>
                          </div>
                        </div>
                        </div>
                        <div class="box-footer">
                          <a href="<?=base_url()?>customer_support/product" class="btn btn-default">Cancel</a>
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
        var prdId = $('#prdId').val();
        var prdCode = $('#prdCode').val();
        var prdType = $('#prdType').val();
        var prdGroup = $('#prdGroup').val();
        var operatorCode = $('#operatorCode').val();
        var vendorId = $('#vendorId').val();
        var prdOrder = $('#prdOrder').val();
        var active = 0;
        if ($('#active').prop('checked')) {
            active = 1;
        }
        if(prdName != '' && prdCode != ''){
            $.ajax({
                type: "POST",
                url: baseurl+"customer_support/product_save",
                data: {'prdName': prdName, 'prdId' : prdId, 'prdCode' : prdCode, 'prdType' : prdType,
                       'prdGroup' : prdGroup, 'operatorCode' : operatorCode, 'vendorId':vendorId, 'prdOrder':prdOrder, 'active' : active},
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
        var prdCode = $('#prdCode').val();
        var active = 0;
        if ($('#active').prop('checked')) {
            active = 1;
        }
        if(prdName != '' && prdCode != ''){
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
