<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<?php $this->load->view('include/head.php');?>
<?php $this->load->view('include/sidebar.php');?>


      <!-- Content Wrapper. Contains page content -->
      <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
          
          <h1>
            <i class="fa fa-cc-paypal"></i> Make Payment
          </h1>
          <ul class="breadcrumb">
            <li><a href="<?php echo base_url(); ?>">Home</a></li>
            <li><a href="<?php echo base_url() . 'index.php/jobs/index'; ?>">Jobs</a></li>
            <li><a href="<?php echo base_url() . 'index.php/jobs/view/' . (isset($project_id)?$project_id:''); ?>">View</a></li>
            <li class="active"><a onclick="return false;" href="#">Pay</a></li>
          </ul>
       
        </section>

        <!-- Main content -->
        <section class="content">
          
          <!-- Your Page Content Here -->
           <div class="row">
            <!-- left column -->
            <div class="col-md-8">

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

                <!-- form start https://www.sandbox.paypal.com/cgi-bin/webscr-->
                <form role="form" accept-charset="utf-8" method="POST" action="https://www.paypal.com/cgi-bin/webscr">
                  <div class="box-body">

                    <div class="form-group">
                      <label for="exampleInputEmail1">Amount :</label>
                      <span  class="form-control" id="amount" > <?php echo  isset($balance_amount) ? ( number_format((float)$balance_amount, 2, '.', '') ) :''; ?></span>
                      
                    </div>                    
        

                    <div class="form-group">
                      <label for="exampleInputPassword1">Notes :</label>
                      <textarea class="form-control" id ="notes" name="notes" rows="3" placeholder="Notes..."></textarea>
                    </div>


                  </div><!-- /.box-body -->

                  <div class="box-footer">
                     <input type="hidden" name="project_id" id="project_id" value="<?php echo set_value('project_id',  (isset($project_id) ? $project_id : '') ); ?>">

                    <input type="hidden" value="_xclick" name="cmd">
                    <input type="hidden" value="<?php echo get_instance()->config->item('paypal_email'); ?>" name="business">
                    <input type="hidden" value="<?php echo isset($services_str)?$services_str :''; ?>" name="item_name">
                    <input type="hidden" value="<?php echo isset($invoice_id)?$invoice_id :''; ?>" name="item_number">
                    <input type="hidden" value="<?php echo base_url() . 'images/logo.png'; ?>" name="image_url">
                    <input type="hidden" value="<?php echo  isset($balance_amount) ? ( number_format((float)$balance_amount, 2, '.', '') ) :''; ?>" name="amount">
                    <input type="hidden" value="1" name="no_shipping">
                    <input type="hidden" value="1" name="no_note">
                    <input type="hidden" value="GBP" name="currency_code">
                    <input type="hidden" value="FC-BuyNow" name="bn">
                    <input type="hidden" value="<?php echo base_url() .'index.php/invoice/thankyou'; ?>" name="return">
                    <input type="hidden" value="<?php echo base_url() .'index.php/invoice/payment/'. (isset($project_id) ? $project_id : ''); ?>" name="cancel_return">
                    <input type="hidden" value="2" name="rm">
                    <input type="hidden" value="<?php echo base_url() .'index.php/paypalipn/'; ?>" name="notify_url">
                    <input type="hidden" value="1" name="custom">

                    <button type="submit" name="submit" class="btn blue"><i class="fa fa-paypal pull-left"></i> Make payment</button>
                  </div>
                </form>
              </div><!-- /.box -->

              </div>

              <div class="col-md-4">

                    <article class="widget">

                      <header class="widget__header">
                        <div class="widget__title">
                          <i class="fa fa-credit-card"></i><h3>Invoice Details</h3>
                        </div>
                      </header>

                      <div class="widget__content filled pad20">
                        
                          <div class="row">

                            <div class="col-md-12 text-center btn__showcase2">
                              
                              
                                <div class="widget__content filled">

                                    <table>
                                        <tbody>

                                          <tr>
                                            <td>Invoice Number</td>
                                            <td><?php echo isset($invoice_id)?$invoice_id :''; ?> </td>
                                          </tr>

                                           <tr>
                                            <td>Invoice Date</td>
                                            <td><?php echo isset($date_billed)?$date_billed :''; ?> </td>
                                          </tr>

                                           <tr>
                                            <td>Invoice Amount</td>
                                            <td><?php echo isset($actual_amount)?( number_format((float)$actual_amount, 2, '.', '') ) :''; ?> </td>
                                          </tr>

                                           <tr>
                                            <td>Discount</td>
                                            <td><?php echo isset($discount)?( number_format((float)$discount, 2, '.', '') ) :''; ?> </td>
                                          </tr>

                                           <tr>
                                            <td>Advance Payment</td>
                                            <td><?php echo isset($advance_payment)?( number_format((float)$advance_payment, 2, '.', '') ) :''; ?> </td>
                                          </tr>

                                           <tr>
                                            <td>Balance Due</td>
                                            <td><?php echo isset($balance_amount)?( number_format((float)$balance_amount, 2, '.', '') ) :''; ?> </td>
                                          </tr>
                                        
                                      </tbody>
                                    </table>                                  
                                    

                                </div>

                                


                            </div>

                          </div>

                      </div>

                  </article>

              </div>


              </div>

        </section><!-- /.content -->
      </div><!-- /.content-wrapper -->


<?php $this->load->view('include/footer.php');?>

<script type="text/javascript">
$(function () {


   function myFunc(){
        var input = $("#notes").val();

        $( "input[name='custom']" ).val(input);
    }
      
    myFunc();

    //either this
    $('#notes').keyup(function(){
         $( "input[name='custom']" ).val($(this).val());
    });

    //or this
    $('#notes').keyup(function(){
        myFunc();
    });

    //and this for good measure
    $('#notes').change(function(){
        myFunc(); //or direct assignment $('#txtHere').html($(this).val());
    });


});
        
</script>