      <!-- Left side column. contains the logo and sidebar -->
      <aside class="main-sidebar">

        <!-- sidebar: style can be found in sidebar.less -->
        <section class="sidebar">

          <!-- Sidebar user panel (optional) -->
          <!-- <div class="user-panel">
            <div class="pull-left image">
              <img src="res/dist/img/user2-160x160.jpg" class="img-circle" alt="User Image" />
            </div>
            <div class="pull-left info">
              <p>Alexander Pierce</p>
              <!-- Status
              <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
            </div>
          </div> -->

          <!-- search form (Optional) -->
          <!-- <form action="#" method="get" class="sidebar-form">
            <div class="input-group">
              <input type="text" name="q" class="form-control" placeholder="Search..."/>
              <span class="input-group-btn">
                <button type='submit' name='search' id='search-btn' class="btn btn-flat"><i class="fa fa-search"></i></button>
              </span>
            </div>
          </form> -->
          <!-- /.search form -->

          <!-- Sidebar Menu -->
          <ul class="sidebar-menu main-nav">
            
            <li class="treeview">
              <a href="#"><span>Companies</span> <i class="fa fa-user pull-right"></i></a>
              <ul class="treeview-menu">                
                  <li><a href="<?php echo base_url() . 'index.php/admin/clients/add'; ?>" class="main-nav__link"><span class="main-nav__icon"><i class="fa fa-user"></i></span>Add Company</a></li>
                  <li><a href="<?php echo base_url() . 'index.php/admin/clients/view'; ?>" class="main-nav__link"><span class="main-nav__icon"><i class="fa fa-users"></i></span>View Companies</a></li>
              </ul>
            </li>

            <li class="treeview">
              <a href="#"><span>Users</span> <i class="fa fa-male pull-right"></i></a>
              <ul class="treeview-menu">
                  <li><a href="<?php echo base_url() . 'index.php/admin/users/add'; ?>" class="main-nav__link"><span class="main-nav__icon"><i class="fa fa-user-plus"></i></span>Add User</a></li>
                  <li><a href="<?php echo base_url() . 'index.php/admin/users/view'; ?>" class="main-nav__link"><span class="main-nav__icon"><i class="fa fa-male"></i></span>View Users</a></li>
              </ul>
            </li>


            <li class="treeview">
              <a href="#"><span>Jobs</span> <i class="fa fa-university pull-right"></i></a>
              <ul class="treeview-menu">
                  <li><a href="<?php echo base_url() . 'index.php/admin/jobs/add'; ?>" class="main-nav__link"><span class="main-nav__icon"><i class="fa fa-university"></i></span>Add New Job</a></li>
                  <li><a href="<?php echo base_url() . 'index.php/admin/jobs/view'; ?>" class="main-nav__link"><span class="main-nav__icon"><i class="fa fa-home"></i></span>View Jobs</a></li>                  
              </ul>
            </li>

             <li class="treeview">
              <a href="#"><span>Payments</span> <i class="fa fa-suitcase pull-right"></i></a>
              <ul class="treeview-menu">
                 <li><a href="<?php echo base_url() . 'index.php/admin/jobs/pendingPayments'; ?>" class="main-nav__link"><span class="main-nav__icon"><i class="fa fa-money"></i></span>Pending Payments</a></li>
                  <li><a href="<?php echo base_url() . 'index.php/admin/payment/view'; ?>" class="main-nav__link"><span class="main-nav__icon"><i class="fa fa-suitcase"></i></span>Recent Payment</a></li>
                  <li><a href="<?php echo base_url() . 'index.php/admin/payment/history'; ?>" class="main-nav__link"><span class="main-nav__icon"><i class="fa fa-recycle"></i></span>Payment History</a></li>
              </ul>
            </li>

             <li class="treeview">
              <a href="#"><span>Services</span> <i class="fa fa-crosshairs pull-right"></i></a>
              <ul class="treeview-menu">
                  <li><a href="<?php echo base_url() . 'index.php/admin/services/add'; ?>" class="main-nav__link"><span class="main-nav__icon"><i class="fa fa-cube"></i></span>Add New Service</a></li>
                  <li><a href="<?php echo base_url() . 'index.php/admin/services/view'; ?>" class="main-nav__link"><span class="main-nav__icon"><i class="fa fa-cubes"></i></span>View Services</a></li>

                  <li><a href="<?php echo base_url() . 'index.php/admin/inventory/add'; ?>" class="main-nav__link"><span class="main-nav__icon"><i class="fa fa-leaf"></i></span>Add New Inventory</a></li>
                  <li><a href="<?php echo base_url() . 'index.php/admin/inventory/view'; ?>" class="main-nav__link"><span class="main-nav__icon"><i class="fa fa-fire"></i></span>View Inventory</a></li>

                  <li><a href="<?php echo base_url() . 'index.php/admin/virtualTours/add'; ?>" class="main-nav__link"><span class="main-nav__icon"><i class="fa fa-street-view"></i></span>Add New Viturl Tours</a></li>
                  <li><a href="<?php echo base_url() . 'index.php/admin/virtualTours/view'; ?>" class="main-nav__link"><span class="main-nav__icon"><i class="fa fa-circle-o-notch"></i></span>View Viturl Tours</a></li>

              </ul>
            </li>

            <li class="treeview">
              <a href="#"><span>Packages</span> <i class="fa fa-gift pull-right"></i></a>
              <ul class="treeview-menu">
                  <li><a href="<?php echo base_url() . 'index.php/admin/packages/add'; ?>" class="main-nav__link"><span class="main-nav__icon"><i class="fa fa-gift"></i></span>Add New Package</a></li>
                  <li><a href="<?php echo base_url() . 'index.php/admin/packages/view'; ?>" class="main-nav__link"><span class="main-nav__icon"><i class="fa fa-glass"></i></span>View Packages</a></li>
              </ul>
            </li>

            <li class="treeview">
              <a href="#"><span>Templates</span> <i class="fa fa-envelope-o pull-right"></i></a>
              <ul class="treeview-menu">
                  <li><a href="<?php echo base_url() . 'index.php/admin/templates/add'; ?>" class="main-nav__link"><span class="main-nav__icon"><i class="fa fa-file-text-o"></i></span>Add New Template</a></li>
                  <li><a href="<?php echo base_url() . 'index.php/admin/templates/view'; ?>" class="main-nav__link"><span class="main-nav__icon"><i class="fa fa-envelope"></i></span>View templates</a></li>
              </ul>
            </li>

            
            <!-- <li><a href="<?php echo base_url() . 'index.php/jobs/add'; ?>"  class="main-nav__link"><span class="main-nav__icon"><i class="fa fa-university"></i></span>Add New Job</a></li>
            <li><a href="<?php echo base_url() . 'index.php/jobs/add'; ?>"  class="main-nav__link"><span class="main-nav__icon"><i class="fa fa-key"></i></span>Finished Jobs</a></li> -->
          
          </ul><!-- /.sidebar-menu -->
        </section>
        <!-- /.sidebar -->
      </aside>