<section class="sidebar">
  <ul class="sidebar-menu">
    <li class="header">MAIN NAVIGATION</li>
    <li class="treeview <?php if(isset($parent_menu_active) && $parent_menu_active == 'authorize') echo 'active'; ?>">
      <a href="#">
        <i class="fa fa-users"></i>
        <span>Authorize</span>
        <i class="fa fa-angle-left pull-right"></i>
      </a>
      <ul class="treeview-menu">
        <li class="<?php if(isset($child_menu_active) && $child_menu_active == 'merchant') echo 'active'; ?>">
            <a href="<?=base_url()?>authorize/merchant"><i class="fa fa-circle-o"></i> Authorize merchant</a>
        </li>
        <li class="<?php if(isset($child_menu_active) && $child_menu_active == 'platinum') echo 'active'; ?>">
            <a href="<?=base_url()?>authorize/platinum"><i class="fa fa-circle-o"></i> Authorize Full Service</a>
        </li>
        <li class="<?php if(isset($child_menu_active) && $child_menu_active == 'registration') echo 'active'; ?>">
            <a href="<?=base_url()?>authorize/registration"><i class="fa fa-circle-o"></i> Registration</a>
        </li>
      </ul>
    </li>
    <li class="treeview <?php if(isset($parent_menu_active) && $parent_menu_active == 'management') echo 'active'; ?>">
      <a href="#">
        <i class="fa fa-cubes"></i>
        <span>Management</span>
        <i class="fa fa-angle-left pull-right"></i>
      </a>
      <ul class="treeview-menu">
        <li class="<?php if(isset($child_menu_active) && $child_menu_active == 'customer_level') echo 'active'; ?>">
            <a href="<?=base_url()?>management/customer_level"><i class="fa fa-circle-o"></i> Customer Level</a>
        </li>
        <li class="<?php if(isset($child_menu_active) && $child_menu_active == 'merchant_registration') echo 'active'; ?>">
            <a href="<?=base_url()?>management/merchant_registration"><i class="fa fa-circle-o"></i> Merchant registrations</a>
        </li>
        <li class="<?php if(isset($child_menu_active) && $child_menu_active == 'ppob_registration') echo 'active'; ?>">
            <a href="<?=base_url()?>management/ppob_registration"><i class="fa fa-circle-o"></i> PPOB registration</a>
        </li>
        <!-- DISABLED <li class="<?php if(isset($child_menu_active) && $child_menu_active == 'plasa_telkom') echo 'active'; ?>">
            <a href="<?=base_url()?>management/plasa_telkom"><i class="fa fa-circle-o"></i> Plasa Telkom</a>
        </li> -->
        <li class="<?php if(isset($child_menu_active) && $child_menu_active == 'province') echo 'active'; ?>">
            <a href="<?=base_url()?>management/province"><i class="fa fa-circle-o"></i> Province</a>
        </li>
        <li class="<?php if(isset($child_menu_active) && $child_menu_active == 'city') echo 'active'; ?>">
            <a href="<?=base_url()?>management/city"><i class="fa fa-circle-o"></i> City</a>
        </li>
      </ul>
    </li>
    <li class="treeview <?php if(isset($parent_menu_active) && $parent_menu_active == 'security') echo 'active'; ?>">
      <a href="#">
        <i class="fa fa-key"></i>
        <span>Security</span>
        <i class="fa fa-angle-left pull-right"></i>
      </a>
      <ul class="treeview-menu">
        <li class="<?php if(isset($child_menu_active) && $child_menu_active == 'change_password') echo 'active'; ?>">
            <a href="<?=base_url()?>security/change_password"><i class="fa fa-circle-o"></i> Change Password</a>
        </li>
        <li class="<?php if(isset($child_menu_active) && $child_menu_active == 'user_level') echo 'active'; ?>">
            <a href="<?=base_url()?>security/user_level"><i class="fa fa-circle-o"></i> User Level</a>
        </li>
        <li class="<?php if(isset($child_menu_active) && $child_menu_active == 'reset_password') echo 'active'; ?>">
            <a href="<?=base_url()?>security/reset_password"><i class="fa fa-circle-o"></i> Reset Password</a>
        </li>
        <li class="<?php if(isset($child_menu_active) && $child_menu_active == 'user_info') echo 'active'; ?>">
            <a href="<?=base_url()?>security/user_info"><i class="fa fa-circle-o"></i> User Info</a>
        </li>
      </ul>
    </li>
    <li class="treeview <?php if(isset($parent_menu_active) && $parent_menu_active == 'customer_info') echo 'active'; ?>">
      <a href="#">
        <i class="fa fa-info"></i>
        <span>Customer Info</span>
        <i class="fa fa-angle-left pull-right"></i>
      </a>
      <ul class="treeview-menu">
        <li class="<?php if(isset($child_menu_active) && $child_menu_active == 'customer') echo 'active'; ?>">
            <a href="<?=base_url()?>customer_info/customer"><i class="fa fa-circle-o"></i> Customer</a>
        </li>
        <li class="<?php if(isset($child_menu_active) && $child_menu_active == 'merchant_setting') echo 'active'; ?>">
            <a href="<?=base_url()?>customer_info/merchant_setting"><i class="fa fa-circle-o"></i> Merchant Setting</a>
        </li>
      </ul>
    </li>
    <li class="treeview <?php if(isset($parent_menu_active) && $parent_menu_active == 'setting') echo 'active'; ?>">
      <a href="#">
        <i class="fa fa-gears"></i>
        <span>Setting</span>
        <i class="fa fa-angle-left pull-right"></i>
      </a>
      <ul class="treeview-menu">
        <li class="<?php if(isset($child_menu_active) && $child_menu_active == 'tarif_template') echo 'active'; ?>">
            <a href="<?=base_url()?>setting/tarif_template"><i class="fa fa-circle-o"></i> Tarif Template</a>
        </li>
      </ul>
    </li>
    <li class="treeview <?php if(isset($parent_menu_active) && $parent_menu_active == 'customer_support') echo 'active'; ?>">
      <a href="#">
        <i class="fa fa-user-plus"></i>
        <span>Customer Support</span>
        <i class="fa fa-angle-left pull-right"></i>
      </a>
      <ul class="treeview-menu">
        <li class="<?php if(isset($child_menu_active) && $child_menu_active == 'product') echo 'active'; ?>">
            <a href="<?=base_url()?>customer_support/product"><i class="fa fa-circle-o"></i> Product</a>
        </li>
        <li class="<?php if(isset($child_menu_active) && $child_menu_active == 'vendor_profile') echo 'active'; ?>">
            <a href="<?=base_url()?>customer_support/vendor_profile"><i class="fa fa-circle-o"></i> Vendor Profile</a>
        </li>
        <li class="<?php if(isset($child_menu_active) && $child_menu_active == 'product_value') echo 'active'; ?>">
            <a href="<?=base_url()?>customer_support/product_value"><i class="fa fa-circle-o"></i> Product Value</a>
        </li>
      </ul>
    </li>
    <li class="treeview">
      <a href="#">
        <i class="fa fa-file-text-o"></i>
        <span>Report</span>
        <!-- <i class="fa fa-angle-left pull-right"></i> -->
      </a>
      <!-- <ul class="treeview-menu">
        <li><a href="#"><i class="fa fa-circle-o"></i> Bill payment report</a></li>
        <li><a href="#"><i class="fa fa-circle-o"></i> Cash in cash out</a></li>
        <li><a href="#"><i class="fa fa-circle-o"></i> Payment purchase Transfer</a></li>
        <li><a href="#"><i class="fa fa-circle-o"></i> Payment Merchant</a></li>
        <li><a href="#"><i class="fa fa-circle-o"></i> Report BI</a></li>
        <li><a href="#"><i class="fa fa-circle-o"></i> Report Cash In</a></li>
        <li><a href="#"><i class="fa fa-circle-o"></i> Topup report</a></li>
        <li><a href="#"><i class="fa fa-circle-o"></i> Transaction account history</a></li>
        <li><a href="#"><i class="fa fa-circle-o"></i> Transaction log browser</a></li>
        <li><a href="#"><i class="fa fa-circle-o"></i> Transaction summary report</a></li>
        <li><a href="#"><i class="fa fa-circle-o"></i> Wallet report</a></li>
        <li><a href="#"><i class="fa fa-circle-o"></i> Statement of earning</a></li>
      </ul> -->
    </li>
  </ul>
</section>
