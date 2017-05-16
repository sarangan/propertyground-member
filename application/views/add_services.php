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
            <i class="fa fa-cube"></i> Add New Service
          </h1>
          <ul class="breadcrumb">
            <li><a href="<?php echo base_url() ; ?>">Home</a></li>
            <li><a href="<?php echo base_url() . 'index.php/admin/services/view'; ?>">Services</a></li>
            <li class="active"><a onclick="return false;" href="#">Add New</a></li>
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
                <form role="form" accept-charset="utf-8" method="POST" action="<?php echo base_url() . 'index.php/admin/services/add'; ?>" >
                  <div class="box-body">
                    
                    <div class="form-group">
                      <label for="exampleInputEmail1">Service Name :</label>
                      <input type="text" name="service_name"  class="form-control" id="service_name" placeholder="Enter service name" value="<?php echo set_value('service_name',  (isset($service_name) ? $service_name : '') ); ?>">

                      <?php if( form_error('service_name') )
                           {
                      ?>
                              <div class="col-lg-12 form-group has-error">
                                  <p class="help-block">

                               <?php echo isset($errors['service_name'])?$errors['service_name']:'';?>
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






                 </div><!-- /.box-body -->

                  <div class="box-footer">
                    <input type="hidden" name="service_id" id="service_id" value="<?php echo set_value('service_id',  (isset($service_id) ? $service_id : '') ); ?>">
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