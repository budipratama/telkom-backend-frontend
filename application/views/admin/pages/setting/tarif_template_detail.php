
<link href="<?php echo $css_admin?>plugins/datepicker/datepicker3.css" rel="stylesheet" type="text/css" />
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
              <h3 class="box-title">Tarif Template</h3>
            </div>
            <?php if(isset($tarifData)){ ?>
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
                        <input type="text" id="trfName" class="form-control" value="<?php echo $tarifData[0]['FH_NAME']?>">
                        <input type="hidden" id="trfId" class="form-control" value="<?php echo $tarifData[0]['FH_ID']?>">
                      </div>
                    </div>
                    <div class="form-group">
                      <label for="inputEmail3" class="col-sm-2 control-label">Description</label>
                      <div class="col-sm-8">
                          <textarea id="trfDesc" class="form-control"><?php echo $tarifData[0]['DESCRIPTION']?></textarea>
                      </div>
                    </div>
                    <div class="form-group">
                      <label for="inputEmail3" class="col-sm-2 control-label">Active From</label>
                      <div class="col-sm-8">
                            <div class="input-group date" data-provide="datepicker" data-date-format="yyyy-mm-dd">
                                <?php $dateFrom = explode(' ', $tarifData[0]['FH_ACTIVE_FROM']);?>
                                <input type="text"  id="dateFrom" class="form-control" value="<?php echo $dateFrom[0]?>">
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
                                <?php $dateTo = explode(' ', $tarifData[0]['FH_ACTIVE_TO']);?>
                                <input type="text"  id="dateTo" class="form-control" value="<?php echo $dateTo[0]?>">
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
                                if($tarifData[0]['FH_STATUS'] == 1){
                                    $checked = "checked=''";
                                }
                          ?>
                          <label>
                              <input type="checkbox" <?php echo $checked?> value="1" name="active" id="active"> Active
                          </label>
                        </div>
                      </div>
                    </div>
                    </div>
                    <div class="box-footer">
                      <a href="<?php echo base_url()?>setting/tarif_template" class="btn btn-default">Cancel</a>
                      <button type="button" class="btn btn-info pull-right" onclick="submitFormEdit()">Edit</button>
                    </div>
                </form>
            <?php }else{ ?>
                <form class="form-horizontal" id="formAdd" method="post" action="<?php echo base_url()?>setting/tarif_template_save">
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
                        <input type="text" id="trfName" name="trfName" class="form-control" value="">
                      </div>
                    </div>
                    <div class="form-group">
                      <label for="inputEmail3" class="col-sm-2 control-label">Description</label>
                      <div class="col-sm-8">
                          <textarea id="trfDesc" name="trfDesc" class="form-control"></textarea>
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
<!--                            <div class="input-group">
                                <div class="input-group-addon">
                                <i class="fa fa-calendar"></i>
                                </div>
                                <input id="dateFrom" name="dateFrom" class="form-control" type="text" data-mask="" data-inputmask="'alias': 'yyyy-mm-dd'">
                            </div>-->
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
<!--                            <div class="input-group">
                                <div class="input-group-addon">
                                <i class="fa fa-calendar"></i>
                                </div>
                                <input id="dateTo" name="dateTo" class="form-control" type="text" data-mask="" data-inputmask="'alias': 'yyyy-mm-dd'">
                            </div>-->
                        </div>
                    </div>
                    <div class="form-group">
                      <div class="col-sm-offset-2 col-sm-10">
                        <div class="checkbox">
                          <label>
                              <input type="checkbox"  value="1" name="active" id="active"> Active
                          </label>
                        </div>
                      </div>
                    </div>
                    </div>
                    <div class="box-footer">
                      <a href="<?php echo base_url()?>setting/tarif_template" class="btn btn-default">Cancel</a>
                      <button type="button" class="btn btn-info pull-right" onclick="submitFormAdd()">Proses</button>
                    </div>
                  </form>
              <?php } ?>
          </div>
        </div>
    </div>
</section>
<script src="<?php echo $css_admin?>plugins/input-mask/jquery.inputmask.js" type="text/javascript"></script>
<script src="<?php echo $css_admin?>plugins/datepicker/bootstrap-datepicker.js" type="text/javascript"></script>
<script src="<?php echo $css_admin?>plugins/input-mask/jquery.inputmask.date.extensions.js" type="text/javascript"></script>
<script src="<?php echo $css_admin?>plugins/input-mask/jquery.inputmask.extensions.js" type="text/javascript"></script>
<script type="text/javascript">

    $('.datepicker').datepicker();
    var baseurl = "<?php echo base_url()?>";
    function submitFormEdit(){
        $('.errorMessage').addClass('hide');
        $('.successMessage').addClass('hide');
        var trfName = $('#trfName').val();
        var trfId = $('#trfId').val();
        var trfDesc = $('#trfDesc').val();
        var dateFrom = $('#dateFrom').val();
        var dateTo = $('#dateTo').val();
        var active = 0;
        if ($('#active').prop('checked')) {
            active = 1;
        }
        if(trfName != '' && trfDesc != '' && trfDesc!='' && dateFrom != '' && dateTo!= ''){
            $.ajax({
                type: "POST",
                url: baseurl+"setting/tarif_template_save",
                data: {'trfId': trfId, 'trfName' : trfName, 'trfDesc':trfDesc, 'dateFrom': dateFrom, 'dateTo':dateTo, 'active' : active},
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
        var trfName = $('#trfName').val();
        var trfId = $('#trfId').val();
        var trfDesc = $('#trfDesc').val();
        var dateFrom = $('#dateFrom').val();
        var dateTo = $('#dateTo').val();
        var active = 0;
        if ($('#active').prop('checked')) {
            active = 1;
        }
        if(trfName != '' && trfDesc != '' && trfDesc!='' && dateFrom != '' && dateTo!= ''){
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
