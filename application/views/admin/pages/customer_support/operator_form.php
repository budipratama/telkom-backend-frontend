<section class="content-header">
    <h1>
      Operator
    </h1>
</section>
<section class="content">
    <div class="row">
        <div class="col-md-12">
          <div class="box box-info">
            <div class="box-header with-border">
              <h3 class="box-title">Add Operator</h3>
            </div>
            <form class="form-horizontal" method="post" action="<?php echo site_url(uri_string()); ?>" enctype="multipart/form-data">
                <div class="box-body">
                  <!-- alert -->
                  <?php if(validation_errors()): ?>
                    <div class="col-lg-12">
                      <div class="alert alert-danger">
                        <?php echo validation_errors(); ?>
                      </div>
                    </div>
                  <?php endif; ?>
                  <?php if($msg = $this->session->flashdata('msg-error')): ?>
                    <div class="col-lg-12">
                      <div class="alert alert-danger">
                        <?php echo $msg; ?>
                      </div>
                    </div>
                  <?php endif; ?>

                  <div class="row">
                    <div class="col-lg-8">
                      <div class="form-group">
                        <label for="inputEmail3" class="col-sm-2 control-label">Operator Name</label>
                        <div class="col-sm-8">
                          <input type="text" name='name' class="form-control" value="<?php echo @$operator->OP_NAME; ?>">
                        </div>
                      </div>
                      <div class="form-group">
                        <label for="inputEmail3" class="col-sm-2 control-label">Operator Logo</label>
                        <div class="col-sm-8">
                          <input type="file" name='logo' class="form-control">
                        </div>
                      </div>
                      <div class="form-group">
                        <div class="col-sm-offset-2 col-sm-10">
                          <div class="checkbox">
                              <label>
                                <?php if(@$operator->OP_ACTIVE === '1'): ?>
                                  <input type="checkbox" checked value="1" name="active"> Active
                                <?php else: ?>
                                  <input type="checkbox" value="1" name="active"> Active
                                <?php endif; ?>
                              </label>
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="col-lg-4">
                      <?php if(! empty($operator->OP_LOGO)): ?>
                        <div class="logo text-center" style="margin: 0 auto; width: 150px;">
                          <img src="<?php echo base_url('assets/images/operator/' . $operator->OP_LOGO) ?>" alt="Logo" style="width:100%">
                        </div>
                      <?php endif; ?>
                    </div>
                  </div>

                  <div class="box-footer">
                    <a href="<?php echo site_url('customer_support/operator'); ?>" class="btn btn-default">Cancel</a>
                    <button type="submit" class="btn btn-info pull-right">Process</button>
                  </div>
              </form>
          </div>
        </div>
    </div>
</section>
