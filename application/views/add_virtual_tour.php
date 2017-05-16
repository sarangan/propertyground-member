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
            <i class="fa fa-street-view"></i> Add New 360 Virutal Tours
          </h1>
          <ol class="breadcrumb">
            <li><a  href="<?php echo base_url(); ?>">Home</a></li>
            <li><a href="<?php echo base_url() . 'index.php/admin/virtualTours/view'; ?>">Virutal Tours</a></li>
            <li class="active"><a onclick="return false;" href="#">Add New 360 Virutal Tours</a></li>
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
                <form role="form" accept-charset="utf-8" method="POST" action="<?php echo base_url() . 'index.php/admin/virtualTours/add'; ?>" >
                  <div class="box-body">
                    
                    <div class="form-group">
                      <label for="exampleInputEmail1">Name :</label>                     
                      <select class="my_select" id="name" name="name" >
                           <option value="">-- Please select --</option>
                           <option  value="STUDIO" <?php echo set_select('name', 'STUDIO', isset($name)? $name == 'STUDIO' : ''); ?> >STUDIO</option>
                           <option  value="1 BEDROOM" <?php echo set_select('name', '1 BEDROOM', isset($name)? $name == '1 BEDROOM' : ''); ?> >1 BEDROOM</option>
                           <option  value="2 BEDROOMS" <?php echo set_select('name', '2 BEDROOMS', isset($name)? $name == '2 BEDROOMS' : ''); ?> >2 BEDROOMS</option>
                           <option  value="3 BEDROOMS" <?php echo set_select('name', '3 BEDROOMS', isset($name)? $name == '3 BEDROOMS' : ''); ?> >3 BEDROOMS</option>
                           <option  value="4 BEDROOMS" <?php echo set_select('name', '4 BEDROOMS', isset($name)? $name == '4 BEDROOMS' : ''); ?> >4 BEDROOMS</option>
                           <option  value="5 BEDROOMS" <?php echo set_select('name', '5 BEDROOMS', isset($name)? $name == '5 BEDROOMS' : ''); ?> >5 BEDROOMS</option>
                           <option  value="6 BEDROOMS" <?php echo set_select('name', '6 BEDROOMS', isset($name)? $name == '6 BEDROOMS' : ''); ?> >6 BEDROOMS</option>
                           <option  value="7 BEDROOMS" <?php echo set_select('name', '7 BEDROOMS', isset($name)? $name == '7 BEDROOMS' : ''); ?> >7 BEDROOMS</option>
                           <option  value="8 BEDROOMS" <?php echo set_select('name', '8 BEDROOMS', isset($name)? $name == '8 BEDROOMS' : ''); ?> >8 BEDROOMS</option>
                           <option  value="9 BEDROOMS" <?php echo set_select('name', '9 BEDROOMS', isset($name)? $name == '9 BEDROOMS' : ''); ?> >9 BEDROOMS</option>
                           <option  value="10 BEDROOMS" <?php echo set_select('name', '10 BEDROOMS', isset($name)? $name == '10 BEDROOMS' : ''); ?> >10 BEDROOMS</option>
                           <option  value="ABOVE 10 BEDROOMS" <?php echo set_select('name', 'ABOVE 10 BEDROOMS', isset($name)? $name == 'ABOVE 10 BEDROOMS' : ''); ?> >ABOVE 10 BEDROOMS</option>
                       </select>

                      <?php if( form_error('name') )
                           {
                      ?>
                              <div class="col-lg-12 form-group has-error">
                                  <p class="help-block">

                               <?php echo isset($errors['name'])?$errors['name']:'';?>
                                  </p>
                              </div>

                      <?php
                        }
                      ?>

                    </div>


                    <div class="form-group">
                      <label for="exampleInputEmail1">No of Bedrooms:</label>
                      <input type="text" name="No_of_Bedrooms"  class="form-control" id="No_of_Bedrooms" placeholder="Enter number of bedrooms" value="<?php echo set_value('No_of_Bedrooms',  (isset($No_of_Bedrooms) ? $No_of_Bedrooms : '') ); ?>">

                      <?php if( form_error('No_of_Bedrooms') )
                           {
                      ?>
                              <div class="col-lg-12 form-group has-error">
                                  <p class="help-block">

                               <?php echo isset($errors['No_of_Bedrooms'])?$errors['No_of_Bedrooms']:'';?>
                                  </p>
                              </div>

                      <?php
                        }
                      ?>

                    </div>


                    <div class="form-group">
                      <label for="exampleInputEmail1">Amount:</label>
                      <input type="text" name="amount"  class="form-control" id="amount" placeholder="Enter amount" value="<?php echo set_value('amount',  (isset($amount) ? $amount : '') ); ?>">

                      <?php if( form_error('amount') )
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
                    <input type="hidden" name="id" id="id" value="<?php echo set_value('id',  (isset($id) ? $id : '') ); ?>">
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