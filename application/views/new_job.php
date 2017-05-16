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
            <i class="fa fa-university"></i> Add New Job
          </h1>
          <ul class="breadcrumb">
            <li><a href="<?php echo base_url(); ?>">Home</a></li>
             <li><a href="<?php echo base_url() . 'index.php/jobs/index'; ?>">Jobs</a></li>
            <li class="active"><a onclick="return false;" href="#">Add New Job</a></li>
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

                <!-- form start -->
                <form role="form" accept-charset="utf-8" method="POST" action="<?php echo base_url() . 'index.php/jobs/add'; ?>" >
                  <div class="box-body">

                    <div class="form-group">
                      <label for="exampleInputEmail1">Address :</label>
                      <input type="text" name="address"  class="form-control" id="address" placeholder="Enter place address..." value="<?php echo set_value('address',  (isset($address) ? $address : '') ); ?>">

                      <?php if( form_error('address') )
                           {
                      ?>
                              <div class="col-lg-12 form-group has-error">
                                  <p class="help-block">

                               <?php echo isset($errors['address'])?$errors['address']:'';?>
                                  </p>
                              </div>

                      <?php
                        }
                      ?>

                    </div>                    

                    <div class="form-group">
                      <label for="exampleInputPassword1">Job Request Date :</label>
                      <div class="input-group my-colorpicker2 date">
                        <input type="text" class="form-control" name="request_date"  id="request_date" placeholder="Request date..." value="<?php echo set_value('request_date',  (isset($request_date) ? $request_date : '') ); ?>"/>
                        
                        <span class="input-group-addon">
                          <i class="fa fa-calendar"></i>
                        </span>                       

                    </div><!-- /.input group -->

                      <?php if( form_error('request_date') )
                           {
                      ?>
                              <div class="col-lg-12 form-group has-error">
                                  <p class="help-block">

                               <?php echo isset($errors['request_date'])?$errors['request_date']:'';?>
                                  </p>
                              </div>

                      <?php
                        }
                      ?>

                    </div>

                  <!-- time Picker -->
                  
                    <div class="form-group">
                      <label>Job Request Time :</label>
                      <div class="input-group input-append bootstrap-timepicker">
                        <input type="text" class="form-control timepicker" name="request_time" id="request_time" placeholder="Request time..." value="<?php echo set_value('request_time',  (isset($request_time) ? $request_time : '') ); ?>"/>
                       
                        <span class="input-group-addon add-on">
                          <i class="fa fa-clock-o"></i>
                        </span>
                         

                      </div><!-- /.input group -->
                    </div><!-- /.form group -->
                  


                  <div class="form-group">
                      <label for="exampleInputEmail1">Key Collection Information :</label>
                      <input type="text" class="form-control" id="key_collection" name="key_collection" placeholder="Write about key collection information..." value="<?php echo set_value('key_collection',  (isset($key_collection) ? $key_collection : '') ); ?>">
                  </div>

                 <div class="form-group">
                      <label for="exampleInputEmail1">Number of Bedrooms :</label>
                        <select class="my_select" id="no_of_rooms" name="no_of_rooms" >
                           <option value="">-- Please select --</option>
                           <option  value="<?php echo STUDIO; ?>" <?php echo set_select('no_of_rooms', STUDIO, isset($no_of_rooms)? $no_of_rooms == STUDIO : ''); ?> >STUDIO</option>
                           <option  value="1" <?php echo set_select('no_of_rooms', '1', isset($no_of_rooms)? $no_of_rooms == '1' : ''); ?> >1 BEDROOM</option>
                           <option  value="2" <?php echo set_select('no_of_rooms', '2', isset($no_of_rooms)? $no_of_rooms == '2' : ''); ?> >2 BEDROOMS</option>
                           <option  value="3" <?php echo set_select('no_of_rooms', '3', isset($no_of_rooms)? $no_of_rooms == '3' : ''); ?> >3 BEDROOMS</option>
                           <option  value="4" <?php echo set_select('no_of_rooms', '4', isset($no_of_rooms)? $no_of_rooms == '4' : ''); ?> >4 BEDROOMS</option>
                           <option  value="5" <?php echo set_select('no_of_rooms', '5', isset($no_of_rooms)? $no_of_rooms == '5' : ''); ?> >5 BEDROOMS</option>
                           <option  value="6" <?php echo set_select('no_of_rooms', '6', isset($no_of_rooms)? $no_of_rooms == '6' : ''); ?> >6 BEDROOMS</option>
                           <option  value="7" <?php echo set_select('no_of_rooms', '7', isset($no_of_rooms)? $no_of_rooms == '7' : ''); ?> >7 BEDROOMS</option>
                           <option  value="8" <?php echo set_select('no_of_rooms', '8', isset($no_of_rooms)? $no_of_rooms == '8' : ''); ?> >8 BEDROOMS</option>
                           <option  value="9" <?php echo set_select('no_of_rooms', '9', isset($no_of_rooms)? $no_of_rooms == '9' : ''); ?> >9 BEDROOMS</option>
                           <option  value="10" <?php echo set_select('no_of_rooms', '10', isset($no_of_rooms)? $no_of_rooms == '10' : ''); ?> >10 BEDROOMS</option>
                           <option  value="<?php echo ABTEN; ?>" <?php echo set_select('no_of_rooms', ABTEN, isset($no_of_rooms)? $no_of_rooms == ABTEN : ''); ?> >ABOVE 10 BEDROOMS</option>
                       </select>

                      <?php if( form_error('no_of_rooms') )
                           {
                      ?>
                              <div class="col-lg-12 form-group has-error">
                                  <p class="help-block">

                               <?php echo isset($errors['no_of_rooms'])?$errors['no_of_rooms']:'';?>
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
                        
                            //$i = 1;
                            foreach ($services as $myservice) {
                            
                              echo'
                                    <div class="col-sm-4">
                                      <input value="'. $myservice['service_id'] .'"  id="cc_'. $myservice['service_id'] .'" type="checkbox" class="custom-checkbox" name="service[]"'. set_checkbox('service[]',   $myservice['service_id'], isset($service)?  in_array(  $myservice['service_id']  , $service )  : '' ) .' /> 
                                      <label for="cc_'. $myservice['service_id'] .'"> '. $myservice['service'] .' </label>
                                    </div>
                                  ';
                             // $i += 1;
                            }                         

                        ?>
                            <!-- <div class="col-sm-4">
                              <input value="10000"  id="cc_inven" type="checkbox" class="custom-checkbox" name="service[]" <?php //set_checkbox('service[]',   $myservice['service_id'], '10000' ) ?> /> 
                              <label for="cc_inven">Inventory</label>
                            </div>  -->

                      </div>

                    </div>


                    <div class="show-hide-inventory">

                       <div class="form-group" >
                          <label for="exampleInputEmail1">Property type :</label>
                           <input type="radio" name="property_type" id="property_type_1" value="FLATS"  < <?php echo set_radio('property_type', 'FLATS', isset($property_type)? $property_type == 'FLATS' : ''); ?> > FLATS 
                           <input type="radio" name="property_type" id="property_type_2" value="HOUSES"  < <?php echo set_radio('property_type', 'HOUSES', isset($property_type)? $property_type == 'HOUSES' : ''); ?> > HOUSES 

                          <?php if( form_error('property_type') )
                               {
                          ?>
                                  <div class="col-lg-12 form-group has-error">
                                      <p class="help-block">

                                   <?php echo isset($errors['property_type'])?$errors['property_type']:'';?>
                                      </p>
                                  </div>

                          <?php
                            }
                          ?>

                        </div>

                        <div class="form-group" >
                          <label for="exampleInputEmail1">Furnishing :</label>
                           <input type="radio" name="furnishing" id="furnishing_1" value="FURNISHED"  < <?php echo set_radio('furnishing', 'FURNISHED', isset($furnishing)? $furnishing == 'FURNISHED' : ''); ?> > FURNISHED 
                           <input type="radio" name="furnishing" id="furnishing_2" value="UNFURNISHED"  < <?php echo set_radio('furnishing', 'UNFURNISHED', isset($furnishing)? $furnishing == 'UNFURNISHED' : ''); ?> > UNFURNISHED 

                          <?php if( form_error('furnishing') )
                               {
                          ?>
                                  <div class="col-lg-12 form-group has-error">
                                      <p class="help-block">

                                   <?php echo isset($errors['furnishing'])?$errors['furnishing']:'';?>
                                      </p>
                                  </div>

                          <?php
                            }
                          ?>

                        </div>

                  </div>


                    <div class="form-group">
                      <label for="exampleInputPassword1">Additional Notes :</label>
                      <textarea class="form-control" name="description" rows="3" placeholder="Notes..."><?php echo  set_value('description',  (isset($description) ? $description : '') ); ?></textarea>
                    </div>


                  </div><!-- /.box-body -->

                  <div class="box-footer">
                     <input type="hidden" name="project_id" id="project_id" value="<?php echo set_value('project_id',  (isset($project_id) ? $project_id : '') ); ?>">
                    <button type="submit" name="submit" class="btn blue">Submit</button>
                  </div>
                </form>
              </div><!-- /.box -->

              </div>

              <div class="col-md-4">

                    <article class="widget">

                      <header class="widget__header">
                        <div class="widget__title">
                          <i class="fa fa-building-o"></i><h3>Packages</h3>
                        </div>
                      </header>

                      <div class="widget__content filled pad20">
                        
                          <div class="row">

                            <div class="col-md-12 text-center btn__showcase2">
                              
                              
                                <div class="widget__content filled">

                                    <table>
                                        <tbody>

                                        <?php  

                                            if(isset($pacakges))
                                            {

                                              if($pacakges->num_rows() > 0 )
                                              {
                                                  foreach ($pacakges->result() as $package) {
                                                      
                                                      echo '<tr>
                                                              <td><span style="font-weight:bold;">'. $package->my_service .'</span></td>
                                                              <td> 

                                                                  <input id="pk_'. $package->id .'" class="custom-radio" type="radio" name="c-radio" data-serviceids="'. $package->my_service_ids .'">
                                                                  <label for="pk_'. $package->id .'"></label>
                                                              </td>
                                                            </tr>';

                                                  }                                                
                                              }
                                            }

                                        ?>

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

     //Timepicker
      $(".timepicker").timepicker({
            showInputs: false,
            defaultTime: false
      });


      $('.input-group.date').datepicker({
           format: 'yyyy/mm/dd',
           todayBtn: "linked"
      });

      if($('#cc_<?php echo INVID; ?>').is(':checked') )
     {
        $('.show-hide-inventory').css('display', 'block');

     }
     else
     {
         $('.show-hide-inventory').css('display', 'none');
         
     }


      $('.custom-radio').on('click', function(){

          var serviceids = $(this).data('serviceids');
          var ids = serviceids.split(",");

              $('.custom-checkbox').each(function()
              {
                  $(this).prop( "checked", false );
              });

              for (var i = 0; i < ids.length; i++)
              {
                 setChecked('#cc_' +  ids[i], true);
              }

        }
      );

      $('#cc_<?php echo INVID; ?>').on('click' , function() {

           if($(this).is(':checked') )
           {
              $('.show-hide-inventory').css('display', 'block');

           }
           else
           {
              $('.show-hide-inventory').css('display', 'none');

              $('#furnishing_1').prop("checked", false );
              $('#furnishing_2').prop("checked", false );

              $('#property_type_1').prop("checked", false );
              $('#property_type_2').prop("checked", false );
           }

      });


});


function setChecked(id, set)
{

    $( id ).prop( "checked", set );

}



        
</script>