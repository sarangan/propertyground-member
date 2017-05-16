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
            <i class="fa fa-file-image-o"></i> Invoice
          </h1>
          <ol class="breadcrumb">
            <li><a href="<?php echo base_url(); ?>">Home</a></li>
            <li><a href="<?php echo base_url() . 'index.php/admin/jobs/view'; ?>">All Jobs</a></li>
             <li><a href="<?php echo base_url() . 'index.php/admin/clients/view'; ?>">Companies</a></li>
            <li><a href="<?php echo base_url() . 'index.php/admin/clients/summary/'. (isset($client_id)?$client_id:''); ?>">Jobs</a></li>
            <li><a href="<?php echo base_url() . 'index.php/admin/jobs/singleView/' . (isset($project_id)?$project_id:''); ?>">View</a></li>
            <li class="active"><a onclick="return false;" href="#">Invoice</a></li>
          </ol>


        </section>

        <!-- Main content -->
        <section class="content">
          
          <!-- Your Page Content Here -->
           <div class="row">

 
            <!-- left column -->
            <div class="col-md-11">

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

                        <div class="invoice-block">

                        <form accept-charset="utf-8" method="POST" action="<?php echo base_url() . 'index.php/admin/invoice/save'; ?>">

                        <div class="row">

                          <table class="table">
                            <thead>
                              <tr>
                                <th colspan="6">

                                  <span class="pull-left titletxt">
                                    Client : <?php echo isset($client_name)?$client_name:'' ?>
                                  </span> 

                                  <span class="pull-right">
                                            <a href="#" class="fileDownloadPromise" href="#" data-fileid="<?php echo (isset($project_id) ? $project_id : ''); ?>"><button class="btn blue"><i class="fa fa-print"></i></button></a>
                                            <a href="#" href="#" data-toggle="modal" data-target="#send_email"><button class="btn blue"><i class="fa fa-envelope-o"></i></button></a>                                  
                                  </span> 
                              <span class="clearfix"></span>

                                  </th>
                              </tr>

                              <tr>
                                <th colspan="4">

                                  <span class="pull-left greentxt">
                                    Job Details : <?php echo isset($address)?$address:'' ?>
                                  </span><br/>
                                   <span class="pull-left greentxt">
                                    Starting Date : <?php echo isset($job_start_on)?$job_start_on:'' ?>
                                  </span> <br/>
                                  
                                  <?php 
                                      if(isset($property_type)  && !empty($property_type)){
                                   ?>
                                      <span class="pull-left greentxt">
                                        Property type : <?php echo isset($property_type)?$property_type:'' ?>
                                      </span> <br/>
                                      
                                  <?php 
                                      }
                                  ?>

                                  <?php 
                                      if(isset($furnishing)  && !empty($furnishing)){
                                   ?>
                                      <span class="pull-left greentxt">
                                        Furnishing : <?php echo isset($furnishing)?$furnishing:'' ?>
                                      </span>

                                  <?php 
                                      }
                                  ?>
                                  </th>
                              </tr>

                            </thead>
                            <tbody>
                              <tr>
                                <td style="width:100px;"><strong>Date Billed:</strong> </td>
                                <td>
                                  <div class="input-group my-colorpicker2">
                                    <input type="text" class="form-control" name="date_billed" id="date_billed" value="<?php echo set_value('date_billed',  (isset($date_billed) ? $date_billed : date('y-m-d') ) ); ?>">
                                     <div class="input-group-addon">
                                      <i class="fa fa-calendar"></i>
                                    </div>
                                  </div>
                                </td>
                                <td><strong>Paid:</strong></td>
                                <td style="width:10%;">
                                  <input type="radio" name="paid" id="paid" value="1"  <?php echo set_radio('paid', '1', isset($paid)? $paid == '1' : ''); ?> > YES
                                  <input type="radio" name="paid" id="paid" value="0"  <?php echo set_radio('paid', '0', isset($paid)? $paid == '0' : ''); ?> > NO
                                </td>
                                  <td></td>
                                  <td></td>
                              </tr>
                              <tr>
                                <td><strong>Date Due:</strong></td>
                                <td>
                                  <div class="input-group my-colorpicker2">
                                    <input type="text" class="form-control" name="date_due" id="date_due" value="<?php echo set_value('date_due',  (isset($date_due) ? $date_due : date('y-m-d')) ); ?>">
                                  <div class="input-group-addon">
                                      <i class="fa fa-calendar"></i>
                                    </div>
                                  </div>
                                </td>
                                <td>                                    
                                    <strong>Publish:</strong>                        
                                </td>
                                  <td style="width:10%;">
                                  <input type="radio" name="publish" id="publish" value="1"   <?php echo set_radio('publish', '1', isset($publish)? $publish == '1' : ''); ?> > YES
                                  <input type="radio" name="publish" id="publish" value="0"   <?php echo set_radio('publish', '0', isset($publish)? $publish == '0' : ''); ?> > NO
                                </td>
                                  
                                  <td><strong>Status:</strong></td>
                                <td><span id="bns-status-badge" class="label label-success"><?php echo (isset($status) && ($status == 1) )? 'NEW' : 'OLD' ; ?></span>
                                </td>
                                  
                                
                              </tr>
                            </tbody>
                          </table>

                        </div>


                        <div class="row" style="margin-bottom: 10px;">
                          <div class="col-lg-12">

                          <div class="widget-box">
                            <!--WI_INVOICE_TABLE-->
                            <table width="100%" class="table table-bordered">
                              <thead>
                                <tr>
                                  <th style="width:30px;"><i class="fa fa-bars"></i></th>
                                  <th>Services</th>
                                  <th>Rate</th>
                                </tr>
                              </thead>
                              <tbody>
                                <!--wi_no_invoice_items_found-->
                                
                                <!--wi_no_invoice_items_found-->
                                <tr>
                                  
                                  <td><!--control buttons delete-->
                                    <span>
                                    </span>
                                    <!--control buttons delete - end -->
                                  </td>

                                  <td><?php echo isset($services_str)?$services_str:'no items' ?></td>
                                  <td class="ser-amt-cls"><?php echo isset($total_amount_services)?$total_amount_services:'0.00' ?></td>
                                </tr>
                                <!--wi_invocie_tax-->

                                <?php

                                    if(isset($additional_amt_result))
                                    {
                                      if($additional_amt_result->num_rows() > 0)
                                      {
                                        foreach ($additional_amt_result->result() as $add_amt_row) {
                                          
                                          echo"<tr>
                                                  <td>
                                                      <span>
                                                        <a href='". base_url(). 'index.php/admin/invoice/deleteItem/'.  $add_amt_row->id . "/" .  (isset($project_id) ? $project_id : 0) ."'> <i class='fa fa-trash'></i> </a>
                                                      </span>
                                                  </td>
                                                  <td>". $add_amt_row->name .  "</td>
                                                  <td class='add_amt_cls'>". $add_amt_row->amount . "</td>
                                                </tr>
                                              ";

                                        }
                                      }
                                    }

                                ?>
                                
                                <!--wi_invocie_tax_end-->
                              </tbody>
                            </table>
                            <div class="form-group">
                              <span class="pull-right">
                                  <a href="#" data-toggle="modal" data-target="#add_invoice_items"><button class="btn blue">Add Items</button></a>                                  
                              </span> <span class="clearfix"></span>
                            </div>
                            <!--WI_INVOICE_TABLE-->
                            <!--WI_INVOICE_TABLE_TOTAL-->
                            <div class="widget-box-footer">
                              <div class="invoice-footer-total pull-left"> Actual Amount</div>
                              <div class="invoice-footer-amount pull-right">
                               <input type="text" class="form-input txt-algn-right" name="actual_amount" readonly id="actual_amount" value="<?php echo set_value('actual_amount',  (isset($actual_amount) ? $actual_amount : '') ); ?>">
                              </div>
                            </div>
                            <div class="clearfix"></div>
                            <div class="widget-box-footer">
                              <div class="invoice-footer-total pull-left"> Discount</div>
                              <div class="invoice-footer-amount pull-right">
                                 <input type="text" class="form-input  txt-algn-right" name="discount" id="discount" value="<?php echo set_value('discount',  (isset($discount) ? $discount : '') ); ?>">
                              </div>
                            </div>
                            <div class="clearfix"></div>
                            <div class="widget-box-footer">
                              <div class="invoice-footer-total pull-left"> Advance Payment</div>
                              <div class="invoice-footer-amount pull-right">
                                 <input type="text" class="form-input  txt-algn-right" name="advance_payment" id="advance_payment" value="<?php echo set_value('advance_payment',  (isset($advance_payment) ? $advance_payment : '') ); ?>">
                              </div>
                            </div>
                            <div class="clearfix"></div>
                            <div class="widget-box-footer">
                              <div class="invoice-footer-total pull-left"> Balance Amount</div>
                              <div class="invoice-footer-amount pull-right">
                                 <input type="text" class="form-input  txt-algn-right" readonly name="total_amount" id="total_amount" value="<?php echo set_value('total_amount',  (isset($total_amount) ? $total_amount : '') ); ?>">
                              </div>
                            </div>
                            <div class="clearfix"></div>
                           
                            <!--WI_INVOICE_TABLE_TOTAL-->
                          </div>

                          </div>
                        </div>                           
                            
                            

                        <div class="row" style="margin-bottom : 10px;">
                          <textarea class="form-control" name="notes" rows="3" placeholder="Notes..."><?php echo  set_value('notes',  (isset($notes) ? $notes : '') ); ?></textarea>
                        </div>
                        
                        
                            

                         <div class="box-footer">
                             <span class="pull-right">
                                  <button  type="submit" name="submit" class="btn blue">Save</button>
                                    
                            </span> <span class="clearfix"></span>
                          </div>

                            <input type="hidden" name="invoice_id" id="invoice_id" value="<?php echo set_value('invoice_id',  (isset($invoice_id) ? $invoice_id : '') ); ?>">
                            <input type="hidden" name="project_id" id="project_id" value="<?php echo set_value('project_id',  (isset($project_id) ? $project_id : '') ); ?>">
                        </form>
              </div><!-- /.box -->

              </div>



           </div>

        </section><!-- /.content -->
      </div><!-- /.content-wrapper -->



<div class="modal fade" id="add_invoice_items" tabindex="-1" role="dialog" aria-labelledby="basicModal" aria-hidden="true">
      <form name="add_invoice_items" id="add_invoice_items"  accept-charset="utf-8" method="POST" action="<?php echo base_url() . 'index.php/admin/invoice/addItems'; ?>">
      <div class="modal-dialog model-sm">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            <h4 class="modal-title" id="myModalLabel">Add Items</h4>
          </div>
          <div class="modal-body">
            <div class="form-group">
              <label for="item_name" class="control-label" style="color: #333;">Item Name:</label>
              <input type="text" class="form-control" required style="color:#333; background-color: rgb(234, 234, 234);" id="item_name" name="item_name">
            </div>
            <div class="form-group">
              <label for="item_name" class="control-label" style="color: #333;">Amount:</label>
              <input type="text" class="form-control" required style="color:#333; background-color: rgb(234, 234, 234);" id="item_amount" name="item_amount">
            </div>
          <input type="hidden" name="invoice_id" id="invoice_id" value="<?php echo set_value('invoice_id',  (isset($invoice_id) ? $invoice_id : '') ); ?>">
          <input type="hidden" name="project_id" id="project_id" value="<?php echo set_value('project_id',  (isset($project_id) ? $project_id : '') ); ?>">
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            <button type="submit" class="btn btn-primary">Save</button>
          </div>
        </div>
      </div>
      </form>
</div>


<div class="modal fade" id="send_email" tabindex="-1" role="dialog" aria-labelledby="basicModal" aria-hidden="true">
      <form name="send_email" id="send_email" accept-charset="utf-8" method="POST" action="<?php echo base_url() . 'index.php/admin/invoice/sendMail'; ?>">
      <div class="modal-dialog model-sm">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            <h4 class="modal-title" id="myModalLabel">Send Email</h4>
          </div>
          <div class="modal-body">

            <div class="row">
             <?php
                $i = 1;

                if( isset($client_email) ){
                 
                  echo'
                    <div class="col-sm-12">
                      <input value="'. $client_email .'"  id="cc_'. $i .'" type="checkbox" class="custom-checkbox" name="useremails[]" /> 
                      <label for="cc_'. $i .'"> '. $client_email .' </label>
                    </div>';
                     $i += 1;
                } 
              ?>

            <?php
              if( isset($users_emails) )
            
                foreach ($users_emails->result() as $user_email) {
                
                  echo'
                        <div class="col-sm-12">
                          <input value="'. $user_email->email .'"  id="cc_'. $i .'" type="checkbox" class="custom-checkbox" name="useremails[]" /> 
                          <label for="cc_'. $i .'"> '. $user_email->email .' </label>
                        </div>
                      ';
                  $i += 1;
                }             

            ?>
            </div>
            <div class="form-group">
              <label for="add_emails" class="control-label" style="color: #333;">Enter emails</label>
              <input type="text" class="form-control" style="color:#333; background-color: rgb(234, 234, 234);" id="add_emails" name="add_emails" placeholder="Enter emails seprated by coma">
            </div>
          <input type="hidden" name="invoice_id" id="invoice_id" value="<?php echo set_value('invoice_id',  (isset($invoice_id) ? $invoice_id : '') ); ?>">
          <input type="hidden" name="project_id" id="project_id" value="<?php echo set_value('project_id',  (isset($project_id) ? $project_id : '') ); ?>">
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            <input type="submit" name="send" class="btn btn-primary" value="Send">
          </div>
        </div>
      </div>
      </form>
</div>



<?php $this->load->view('include/footer.php');?>

<script type="text/javascript">
$(function () {

    $('#date_billed').datepicker({
           format: 'yyyy-mm-dd'
    });

    $('#date_billed').on('change',function(e){

         var new_date = moment($('#date_billed').val(), "YYYY-MM-DD").add('days', 14);

        // console.log(new_date);
        var day = new_date.format('DD');
        var month = new_date.format('MM');
        var year = new_date.format('YYYY');

        $('#date_due').val(year + '-' + month + '-' + day);

    });


    $('#date_due').datepicker({
           format: 'yyyy-mm-dd'
    });
   
    var additional_amt = 0.0;
    $('.add_amt_cls').each( function()
    { 
        additional_amt += parseFloat($(this).html());
    });

     $('#actual_amount').val(parseFloat($('.ser-amt-cls').html()) + additional_amt );

     updateAmount();

     $('#discount').keyup(function () {
          updateAmount();
     });

      $('#advance_payment').keyup(function () {
          updateAmount();
     });



      $(document).on("click", "a.fileDownloadPromise", function () {
                       
         var url = '<?php echo base_url()."index.php/admin/invoice/pdfDownload"; ?>';

         console.log($(this).data('fileid') );

         var params = {
              fileid :  $(this).data('fileid')
          };

         $.fileDownload(url, {

              successCallback: function () {
                //console.log('ok');
                 //showballoon('glyphicon glyphicon-ok-circle', '', " File is ready to download!.." , 'success');
              },
              failCallback: function (responseHtml, url) {
                  // console.log('not ok');
                  //showballoon('glyphicon glyphicon-exclamation-sign', '', " File not found!..", 'warning' ); 
              },
              httpMethod: "POST",
              data: params
          });
       
          return false; //this is critical to stop the click event which will trigger a normal file download
      });


    
});


function updateAmount()
{

  var actual_amt = parseFloat($('#actual_amount').val());
  var dis_amt = parseFloat($('#discount').val());
  var adv_amt = parseFloat($('#advance_payment').val());

  $('#total_amount').val( actual_amt - (dis_amt + adv_amt) );
}

        
</script>