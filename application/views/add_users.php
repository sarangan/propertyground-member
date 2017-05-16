<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<?php $this->load->view('include/head.php');?>
<?php $this->load->view('include/sidebar_admin.php');?>


      <!-- Content Wrapper. Contains page content -->
      <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">

          
          <h1>
            <i class="fa fa-user-plus"></i> Add New Users
          </h1>
          <ul class="breadcrumb">
            <li><a href="<?php echo base_url(); ?>">Home</a></li>
            <li><a href="<?php echo base_url() . 'index.php/admin/users/view'; ?>">Users</a></li>
            <li class="active"><a onclick="return false;" href="#">Add New Users</a></li>
          </ul>

        </section>

        <!-- Main content -->
        <section class="content">
          
          <!-- Your Page Content Here -->
           <div class="row">
            <!-- left column -->
            <div class="col-md-10">

          <!-- general form elements -->
              <div class="box box-primary">
                <div class="box-header">
                  
                </div><!-- /.box-header -->

                <?php 

                if(isset($error_display))
                {

                  if($error_display == 2 )
                  {
                    echo '  <div role="alert" class="alert alert-fixed alert-success alert-dismissible">
                              <button data-dismiss="alert" class="close" type="button"><span aria-hidden="true"><i class="fa fa-times"></i></span><span class="sr-only">Close</span></button>
                              <div class="alert__icon pull-left">
                                <i class="fa fa-floppy-o"></i>
                              </div>
                              <p class="alert__text"> Successfully Saved!</p>
                            </div>'
                ;
                  }
                  elseif($error_display == 1 )
                  {
                    echo '  <div role="alert" class="alert alert-fixed alert-warning alert-dismissible">
                              <button data-dismiss="alert" class="close" type="button"><span aria-hidden="true"><i class="fa fa-times"></i></span><span class="sr-only">Close</span></button>
                              <div class="alert__icon pull-left">
                                <i class="fa fa-exclamation-triangle"></i>
                              </div>
                              <p class="alert__text"> Something went wrong!</p>
                            </div>'
                ;
                  }
                }

                  

                ?>

                <!-- form start -->
                <form role="form" accept-charset="utf-8" method="POST" action="<?php echo base_url() . 'index.php/admin/users/add'; ?>" >
                  <div class="box-body">


                    <div class="form-group">
                      <label for="exampleInputEmail1">Email :</label>
                      <input type="text" name="user_email"  class="form-control" id="user_email" placeholder="Enter email address" value="<?php echo set_value('user_email',  (isset($user_email) ? $user_email : '') ); ?>">

                      <?php if( form_error('user_email') )
                           {
                      ?>
                              <div class="col-lg-12 form-group has-error">
                                  <p class="help-block">

                               <?php echo isset($errors['user_email'])?$errors['user_email']:'';?>
                                  </p>
                              </div>

                      <?php
                        }
                      ?>

                    </div>


                    <div class="form-group">
                      <label for="exampleInputEmail1">Username :</label>
                      <input type="text" name="username"  class="form-control" id="username" placeholder="Enter username" value="<?php echo set_value('username',  (isset($username) ? $username : '') ); ?>">

                      <?php if( form_error('username') )
                           {
                      ?>
                              <div class="col-lg-12 form-group has-error">
                                  <p class="help-block">

                               <?php echo isset($errors['username'])?$errors['username']:'';?>
                                  </p>
                              </div>

                      <?php
                        }
                      ?>

                    </div>


                    
                    <div class="form-group">
                      <label for="exampleInputEmail1">First Name :</label>
                      <input type="text" name="first_name"  class="form-control" id="first_name" placeholder="Enter first name" value="<?php echo set_value('first_name',  (isset($first_name) ? $first_name : '') ); ?>">

                      <?php if( form_error('first_name') )
                           {
                      ?>
                              <div class="col-lg-12 form-group has-error">
                                  <p class="help-block">

                               <?php echo isset($errors['first_name'])?$errors['first_name']:'';?>
                                  </p>
                              </div>

                      <?php
                        }
                      ?>

                    </div>

                    <div class="form-group">
                      <label for="exampleInputEmail1">Last Name :</label>
                      <input type="text" name="last_name"  class="form-control" id="last_name" placeholder="Enter last name" value="<?php echo set_value('last_name',  (isset($last_name) ? $last_name : '') ); ?>">

                      <?php if( form_error('last_name') )
                           {
                      ?>
                              <div class="col-lg-12 form-group has-error">
                                  <p class="help-block">

                               <?php echo isset($errors['last_name'])?$errors['last_name']:'';?>
                                  </p>
                              </div>

                      <?php
                        }
                      ?>

                    </div>


                    <div class="form-group">
                      <label for="exampleInputEmail1">Company :</label>
                      <select name="company" id="company" class="my_select">

                            <option value="">Please select company</option>

                          <?php 

                              if(isset($clients_data) && ($clients_data->num_rows() > 0) )
                              {
                                  foreach ($clients_data->result() as  $company_row) {
                                      
                                    echo '<option  value="'. $company_row->id .'" '. set_select("company", $company_row->id, isset($company)? $company == $company_row->id : '') .'>'. $company_row->name .'</option>';

                                  }
                                  
                              }


                          ?>
                      </select>

                      <?php if( form_error('company') )
                           {
                      ?>
                              <div class="col-lg-12 form-group has-error">
                                  <p class="help-block">

                               <?php echo isset($errors['company'])?$errors['company']:'';?>
                                  </p>
                              </div>

                      <?php
                        }
                      ?>

                    </div>

                    <div class="form-group">
                      <label for="exampleInputEmail1">Contact Number :</label>
                      <input type="text" name="phone"  class="form-control" id="phone" placeholder="Enter contact number" value="<?php echo set_value('phone',  (isset($phone) ? $phone : '') ); ?>">

                      <?php if( form_error('phone') )
                           {
                      ?>
                              <div class="col-lg-12 form-group has-error">
                                  <p class="help-block">

                               <?php echo isset($errors['phone'])?$errors['phone']:'';?>
                                  </p>
                              </div>

                      <?php
                        }
                      ?>

                    </div>


                    <div class="form-group">
                      <label for="exampleInputEmail1">Password :</label>
                      <input type="password" name="user_password"  class="form-control" id="user_password" value="">

                      <?php if( form_error('user_password') )
                           {
                      ?>
                              <div class="col-lg-12 form-group has-error">
                                  <p class="help-block">

                               <?php echo isset($errors['user_password'])?$errors['user_password']:'';?>
                                  </p>
                              </div>

                      <?php
                        }
                      ?>

                    </div>

                    <div class="form-group">
                      <label for="exampleInputEmail1">Confirm password :</label>
                      <input type="password" name="user_confirm_password"  class="form-control" id="user_confirm_password" value="">

                      <?php if( form_error('user_confirm_password') )
                           {
                      ?>
                              <div class="col-lg-12 form-group has-error">
                                  <p class="help-block">

                               <?php echo isset($errors['user_confirm_password'])?$errors['user_confirm_password']:'';?>
                                  </p>
                              </div>

                      <?php
                        }
                      ?>

                    </div>


                    <div class="form-group">
                      <label for="default_user">Default User :</label>
                      <input type="checkbox" name="default_user" id="default_user" value="1" <?php echo set_checkbox('default_user', '1', isset($default_user)? $default_user == '1' : ''); ?> >
                       

                      <?php if( form_error('default_user') )
                           {
                      ?>
                              <div class="col-lg-12 form-group has-error">
                                  <p class="help-block">

                               <?php echo isset($errors['default_user'])?$errors['default_user']:'';?>
                                  </p>
                              </div>

                      <?php
                        }
                      ?>

                    </div>
 

                 </div><!-- /.box-body -->

                  <div class="box-footer">
                    <input type="hidden" name="user_id" id="user_id" value="<?php echo set_value('user_id',  (isset($user_id) ? $user_id : '') ); ?>">
                    <button type="submit" name="submit" class="btn blue">Submit</button>
                  </div>
                </form>
              </div><!-- /.box -->

              </div>

           </div>

        </section><!-- /.content -->
      </div><!-- /.content-wrapper -->


<?php $this->load->view('include/footer.php');?>

<script type="text/javascript">
$(function () {

});


        
</script>