<section class="content-header">
  <section class="content">
    <div class="row" style="padding-top:125px">
        <div class="col-lg-12">
          <div class="box">
            <div class="box-body">
              <p class="text-center text-uppercase" style="font-size:25px;">
                Selamat datang <b><?php echo $this->session->userdata('userRealName')?></b>
              </p>
              <p class="text-center text-uppercase" style="font-size:25px;">
                Anda login sebagai <b><?php echo $user_level ?></b>
              </p>
            </div>
          </div>
        </div>
    </div>
    <div class="row" style="display:none">
      <div class="col-lg-12" style="min-height: 50vh; position: relative; overflow: hidden;">
        <div class="box" style="position: absolute; bottom: 0; width: 100%;">
            <div class="box-header">
              <b><center>SHORTCUT</center></b>
            </div>
            <div class="box-body">
              <p class="text-center text-uppercase">
                  <a href="<?php echo site_url('authorize/registration') ?>" class="btn btn-lg btn-primary" style="margin:0 10px;width:20%">REGISTRATION</a>
                  <a href="<?php echo site_url('management/merchant_registration') ?>" class="btn btn-lg btn-success" style="margin:0 10px;">MERCHANT REGISTRATION</a>
                  <a href="<?php echo site_url('security/user_info') ?>" class="btn btn-lg btn-warning" style="margin:0 10px;width:20%">USER INFO</a>
                  <a href="<?php echo site_url('report/view_report') ?>" class="btn btn-lg btn-danger" style="margin:0 10px;width:20%">REPORT</a>
              </p>
          </div>
        </div>
      </div>
    </div>
    <!-- /.row -->
</section>
