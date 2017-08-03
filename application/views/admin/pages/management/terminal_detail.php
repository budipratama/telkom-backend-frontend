<section class="content-header">
    <?php if(isset($terminalData)){ ?>
	<h1>
	Edit
      <small>Terminal</small>
    </h1>
	<?php } else { ?>
	<h1>
	Registrasi
      <small>Terminal</small>
    </h1>
	<?php } ?>
</section>
<section class="content">
    <div class="row">
    <?php // print_r($terminalData);?>
        <div class="col-md-12">  
          <div class="box box-info">
            <div class="box-header with-border">
              <h3 class="box-title">Data Terminal</h3>
            </div>
            <?php if(isset($terminalData)){ ?>
                <form class="form-horizontal">
                <div class="box-body">
                    <div class="errorMessage hide alert alert-danger alert-dismissable">
                        <span class="messageText"></span>
                    </div>
                    <div class="successMessage hide alert alert-success alert-dismissable">
                        <span class="messageText"></span>
                    </div>
                    <div class="form-group">
                      <label class="col-sm-2 control-label">Terminal Name</label>
                      <div class="col-sm-8">
                        <input type="text" class="form-control" name="terminalName"  placeholder="" id="terminalName"  value="<?=$terminalData[0]['TERMINAL_NAME']?>">  
                        <input type="hidden" id="terminalId" class="form-control" value="<?=$terminalData[0]['ID']?>">

                      </div>
                    </div>                               
                    <div class="form-group">
                      <label class="col-sm-2 control-label">Client Partner</label>                  
                      <div class="col-sm-5">                    
                          <select class="form-control" name="clientPartner" id="clientPartner">
                            <option value="0">- Pilih Client Partner -</option>
                              <?php foreach ($partnerData as $key => $value) {
                                    $selected = '';
                                    if($terminalData[0]['CP_ID'] == $value['CP_ID']){
                                        $selected = 'selected';
                                    }
                                    echo "<option value='".$value['CP_ID']."' ".$selected.">".$value['CP_NAME']."</option>";
                                }
                              ?>
                          </select>
                      </div>
                    </div>        
                    <div class="form-group">
                      <label class="col-sm-2 control-label">Description</label>
                      <div class="col-sm-8">
                        <textarea class="form-control" rows="5" placeholder="Enter Description..." id="description"><?=$terminalData[0]['DESCRIPTION']?></textarea>
                      </div>
                    </div>        
					<div class="form-group">
					  <label class="col-sm-2 control-label">Created By</label>
					  <div class="col-sm-8">
						<input type="text" class="form-control" name="createdBy"  placeholder="" id="createdBy"  value="<?=$terminalData[0]['CREATED_BY']?>" readonly="true">
					  </div>
					</div> 
					<div class="form-group">
                        <div class="col-sm-offset-2 col-sm-10">
                          <div class="checkbox">
                            <label>
								<?php
									$status = '';
									if ($terminalData[0]['ACTIVE'] == 1) $status='checked';
								?>
                                <input type="checkbox" value="<?=$terminalData[0]['ACTIVE']?>" name="active" id="active" <?php echo $status ?> > Active
                            </label>
                          </div>
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
                      <label class="col-sm-2 control-label">Terminal Name</label>
                      <div class="col-sm-8">
                        <input type="text" class="form-control" name="terminalName"  placeholder="" id="terminalName">  
                      </div>
                    </div>                               
                    <div class="form-group">
                      <label class="col-sm-2 control-label">Client Partner</label>                  
                      <div class="col-sm-5">                    
                          <select class="form-control" name="clientPartner" id="clientPartner">
                            <option value="0">- Pilih Client Partner -</option>
                              <?php foreach ($partnerData as $key => $value) {
									$selected = '';
                                    echo "<option value='".$value['CP_ID']."' ".$selected.">".$value['CP_NAME']."</option>";
                                }
                              ?>
                          </select>
                      </div>
                    </div>        
                    <div class="form-group">
                      <label class="col-sm-2 control-label">Description</label>
                      <div class="col-sm-8">
                        <textarea class="form-control" rows="5" name="description" placeholder="Enter Description..." id="description"></textarea>
                      </div>
                    </div>        
					<div class="form-group">
					  <label class="col-sm-2 control-label">Created By</label>
					  <div class="col-sm-8">
						<input type="text" class="form-control" name="createdBy"  placeholder="" id="createdBy" value="<?php echo $this->session->userdata('userRealName')?>" readonly="true">
					  </div>
					</div> 
					<div class="form-group">
                        <div class="col-sm-offset-2 col-sm-10">
                          <div class="checkbox">
                            <label>
                                <input type="checkbox" name="active" id="active"> Active
                            </label>
                          </div>
                        </div>
                      </div>
                </div>
              <div class="box-footer">
                 <a href="<?=base_url()?>management/terminal" class="btn btn-default">Cancel</a> 
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
		alert("Peringatan. Belum ada tables database untuk terminal");
	}
	
    function submitFormEdit(){
        $('.errorMessage').addClass('hide');
        $('.successMessage').addClass('hide');
        var terminalId = $('#terminalId').val();
        var terminalName = $('#terminalName').val();
        var clientPartner = $('#clientPartner').val();
        var description = $('#description').val();
        var createdBy = $('#createdBy').val();
        var active = 0;
        if ($('#active').prop('checked')) {
            active = 1;
        }
        if(terminalName != '' && clientPartner !=0 && description != 0 && createdBy != ''){
            $.ajax({
                type: "POST",
                url: baseurl+"management/terminal_save",
                data: {'terminalId': terminalId, 'terminalName': terminalName, 'clientPartner':clientPartner, 'description':description, 'createdBy':createdBy, 'active':active},
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
        var terminalName = $('#terminalName').val();
        var clientPartner = $('#clientPartner').val();
        var description = $('#description').val();
        var createdBy = $('#createdBy').val();
        var active = 0;
        if ($('#active').prop('checked')) {
            active = 1;
        }
        if(terminalName != '' && clientPartner !=0 && description != 0 && createdBy != '' && active != ''){
            $.ajax({
                type: "POST",
                url: baseurl+"management/terminal_save",
                data: {'terminalName': terminalName, 'clientPartner':clientPartner, 'description':description, 'createdBy':createdBy, 'active':active},
                cache: false,
                success: function (res) {
                    alert('Add Terminal Success');
					window.location.href = baseurl+"management/terminal`";
                },
				error: function(request,error) { 
					alert(request.responseText);
					alert("Add Terminal Failed :"+error);
				}
            });
        }else{
            alert('Please Fill all field.');
        }
  }
</script>