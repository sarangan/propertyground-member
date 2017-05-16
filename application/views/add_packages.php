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
            <i class="fa fa-gift"></i> Add New Package
          </h1>
          <ol class="breadcrumb">
            <li><a href="<?php echo base_url(); ?>">Home</a></li>
            <li><a href="<?php echo base_url() . 'index.php/admin/packages/view'; ?>">Packages</a></li>
            <li class="active"><a onclick="return false;" href="#">Add New</a></li>
          </ol>


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
                <form role="form" accept-charset="utf-8" method="POST" action="<?php echo base_url() . 'index.php/admin/packages/add'; ?>" >
                  <div class="box-body">
                    
                    <div class="form-group">
                      <label for="exampleInputEmail1">Package Name :</label>
                      <input type="text" name="package_name"  class="form-control" id="package_name" placeholder="Enter package name" value="<?php echo set_value('package_name',  (isset($package_name) ? $package_name : '') ); ?>">

                      <?php if( form_error('package_name') )
                           {
                      ?>
                              <div class="col-lg-12 form-group has-error">
                                  <p class="help-block">

                               <?php echo isset($errors['package_name'])?$errors['package_name']:'';?>
                                  </p>
                              </div>

                      <?php
                        }
                      ?>

                    </div>

                    <div class="form-group">
                      <label for="exampleInputEmail1">Amount up to 3 bedroom:</label>
                      <input type="text" name="amount_1_3"  class="form-control" id="amount_1_3" placeholder="Enter amount" value="<?php echo set_value('amount_1_3',  (isset($amount_1_3) ? $amount_1_3 : '') ); ?>">

                      <?php if( form_error('amount_1_3') )
                           {
                      ?>
                              <div class="col-lg-12 form-group has-error">
                                  <p class="help-block">

                               <?php echo isset($errors['amount'])?$errors['amount']:'';?>
                                  </p>
                              </div>

                      <?php
                        }
                      ?>

                    </div>


                    <div class="form-group">
                      <label for="exampleInputEmail1">Amount 4 to 6 bedroom:</label>
                      <input type="text" name="amount_4_6"  class="form-control" id="amount_4_6" placeholder="Enter amount" value="<?php echo set_value('amount_4_6',  (isset($amount_4_6) ? $amount_4_6 : '') ); ?>">

                      <?php if( form_error('amount_4_6') )
                           {
                      ?>
                              <div class="col-lg-12 form-group has-error">
                                  <p class="help-block">

                               <?php echo isset($errors['amount'])?$errors['amount']:'';?>
                                  </p>
                              </div>

                      <?php
                        }
                      ?>

                    </div>


                    <div class="form-group">
                      <label for="exampleInputEmail1">Amount above 6 bedroom:</label>
                      <input type="text" name="amount_6_above"  class="form-control" id="amount_6_above" placeholder="Enter amount" value="<?php echo set_value('amount_6_above',  (isset($amount_6_above) ? $amount_6_above : '') ); ?>">

                      <?php if( form_error('amount_6_above') )
                           {
                      ?>
                              <div class="col-lg-12 form-group has-error">
                                  <p class="help-block">

                               <?php echo isset($errors['amount'])?$errors['amount']:'';?>
                                  </p>
                              </div>

                      <?php
                        }
                      ?>

                    </div>


                    <div class="form-group">

                        <label for="sdsd">Please select service :</label>

                        <?php if( form_error('service[]') )
                           {
                      ?>
                              <div class="col-lg-12 form-group has-error">
                                  <p class="help-block">

                               <?php echo isset($errors['option_error'])?$errors['option_error']:'';?>
                                  </p>
                              </div>

                      <?php
                        }
                      ?>

                        
                        <div class="row">

                        <?php 

                         

                          if( isset($services) )
                        
                            $i = 1;
                            foreach ($services as $myservice) {
                            
                              echo'
                                    <div class="col-sm-4">
                                      <input value="'. $myservice['service_id'] .'"  id="cc_'. $i .'" type="checkbox" class="custom-checkbox" name="service[]"'. set_checkbox('service[]',   $myservice['service_id'], isset($service)?  in_array(  $myservice['service_id']  , $service )  : '' ) .' /> 
                                      <label for="cc_'. $i .'"> '. $myservice['service'] .' </label>
                                    </div>
                                  ';
                              $i += 1;
                            }

                          

                        ?>
                        

                      </div>

                    </div>



                 </div><!-- /.box-body -->

                  <div class="box-footer">
                    <input type="hidden" name="package_id" id="package_id" value="<?php echo set_value('package_id',  (isset($package_id) ? $package_id : '') ); ?>">
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