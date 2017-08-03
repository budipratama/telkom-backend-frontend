<!-- Logo -->
<a href="<?php echo base_url()?>" class="logo">
  <!-- mini logo for sidebar mini 50x50 pixels -->
  <span class="logo-mini"><b>C</b>MS</span>
  <!-- logo for regular state and mobile devices -->
  <span class="logo-lg"><b>tMoney</b>CMS</span>
</a>

<!-- Header Navbar: style can be found in header.less -->
<nav class="navbar navbar-static-top" role="navigation">
  <!-- Sidebar toggle button-->
  <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
    <span class="sr-only">Toggle navigation</span>
  </a>
  <!-- Navbar Right Menu -->
  <div class="navbar-custom-menu">
    <ul class="nav navbar-nav">
      <li class="dropdown user user-menu">
        <a href="#" class="dropdown-toggle" data-toggle="dropdown">
          <img style="display: none" src="<?php echo $css_admin?>dist/img/avatar5.png" class="user-image" alt="User Image" />
          <span class="hidden-xs"><?php echo $this->session->userdata('userRealName')?> </span>
        </a>
        <ul class="dropdown-menu">
          <!-- User image -->
          <li class="user-header" style="height: 75px;">
            <img style="display: none" src="<?php echo $css_admin?>dist/img/avatar5.png" class="img-circle" alt="User Image" />
            <b style="color: white">Selamat Datang </b>
            <p>
              <?php echo $this->session->userdata('userRealName')?>
              <!-- <small>Member since Jun. 2016</small> -->
            </p>
          </li>
          <!-- Menu Body -->
          <!-- <li class="user-body">
            <div class="col-xs-4 text-center">
              <a href="#">Followers</a>
            </div>
            <div class="col-xs-4 text-center">
              <a href="#">Sales</a>
            </div>
            <div class="col-xs-4 text-center">
              <a href="#">Friends</a>
            </div>
          </li> -->
          <!-- Menu Footer-->
          <li class="user-footer">
            <div class="pull-left">
              <!-- <a href="#" class="btn btn-default btn-flat">Profile</a> -->
            </div>
            <div class="pull-right">
              <a href="<?php echo base_url()?>auth/logout" class="btn btn-default btn-flat">Sign out</a>
            </div>
          </li>
        </ul>
      </li>
    </ul>
  </div>

</nav>
