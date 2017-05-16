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
            <i class="fa fa-user"></i> Add New Company
          </h1>
          <ol class="breadcrumb">
            <li><a href="<?php echo base_url(); ?>">Home</a></li>
            <li><a href="<?php echo base_url() . 'index.php/admin/clients/view'; ?>">Companies</a></li>
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
                <form role="form" accept-charset="utf-8" method="POST" action="<?php echo base_url() . 'index.php/admin/clients/add'; ?>" enctype="multipart/form-data" >
                  <div class="box-body">
                    
                    <div class="form-group">
                      <label for="exampleInputEmail1">Company Name :</label>
                      <input type="text" name="company_name"  class="form-control" id="company_name" placeholder="Enter company name" value="<?php echo set_value('company_name',  (isset($company_name) ? $company_name : '') ); ?>">

                      <?php if( form_error('company_name') )
                           {
                      ?>
                              <div class="col-lg-12 form-group has-error">
                                  <p class="help-block">

                               <?php echo isset($errors['company_name'])?$errors['company_name']:'';?>
                                  </p>
                              </div>

                      <?php
                        }
                      ?>

                    </div>

                    <div class="form-group">
                      <label for="exampleInputEmail1">Address :</label>
                      <input type="text" name="company_address"  class="form-control" id="company_address" placeholder="Enter company address" value="<?php echo set_value('company_address',  (isset($company_address) ? $company_address : '') ); ?>">

                      <?php if( form_error('company_address') )
                           {
                      ?>
                              <div class="col-lg-12 form-group has-error">
                                  <p class="help-block">

                               <?php echo isset($errors['company_address'])?$errors['company_address']:'';?>
                                  </p>
                              </div>

                      <?php
                        }
                      ?>

                    </div>

                    <div class="form-group">
                      <label for="exampleInputEmail1">Website :</label>
                      <input type="text" name="company_website"  class="form-control" id="company_website" placeholder="Enter company website" value="<?php echo set_value('company_website',  (isset($company_website) ? $company_website : '') ); ?>">

                      <?php if( form_error('company_website') )
                           {
                      ?>
                              <div class="col-lg-12 form-group has-error">
                                  <p class="help-block">

                               <?php echo isset($errors['company_website'])?$errors['company_website']:'';?>
                                  </p>
                              </div>

                      <?php
                        }
                      ?>

                    </div>


                    <div class="form-group">
                      <label for="exampleInputEmail1">Contact :</label>
                      <input type="text" name="company_contact"  class="form-control" id="company_contact" placeholder="Enter company telephone number" value="<?php echo set_value('company_contact',  (isset($company_contact) ? $company_contact : '') ); ?>">

                      <?php if( form_error('company_contact') )
                           {
                      ?>
                              <div class="col-lg-12 form-group has-error">
                                  <p class="help-block">

                               <?php echo isset($errors['company_contact'])?$errors['company_contact']:'';?>
                                  </p>
                              </div>

                      <?php
                        }
                      ?>

                    </div>


                    <div class="form-group">
                      <label for="exampleInputEmail1">Email :</label>
                      <input type="text" name="company_email"  class="form-control" id="company_email" placeholder="Enter company email address" value="<?php echo set_value('company_email',  (isset($company_email) ? $company_email : '') ); ?>">

                      <?php if( form_error('company_email') )
                           {
                      ?>
                              <div class="col-lg-12 form-group has-error">
                                  <p class="help-block">

                               <?php echo isset($errors['company_email'])?$errors['company_email']:'';?>
                                  </p>
                              </div>

                      <?php
                        }
                      ?>

                    </div>


                    <div class="form-group">
                      <label for="exampleInputEmail1">Exceed amount :</label>
                      <input type="text" name="exceed_amount"  class="form-control" id="exceed_amount" placeholder="Enter exceed amount" value="<?php echo set_value('exceed_amount',  (isset($exceed_amount) ? $exceed_amount : '') ); ?>">

                      <?php if( form_error('exceed_amount') )
                           {
                      ?>
                              <div class="col-lg-12 form-group has-error">
                                  <p class="help-block">

                               <?php echo isset($errors['exceed_amount'])?$errors['exceed_amount']:'';?>
                                  </p>
                              </div>

                      <?php
                        }
                      ?>

                    </div>

                     <div class="form-group">
                      <label for="exampleInputEmail1">Logo position :</label>
                        <select class="my_select" id="photo_position" name="photo_position" >
                           <option value="">-- Please select --</option>
                           <option  value="Left Top" <?php echo set_select('photo_position', 'Left Top', isset($photo_position)? $photo_position == 'Left Top' : ''); ?> >Left Top</option>
                           <option  value="Left Center" <?php echo set_select('photo_position', 'Left Center', isset($photo_position)? $photo_position == 'Left Center' : ''); ?> >Left Center</option>
                           <option  value="Left Bottom" <?php echo set_select('photo_position', 'Left Bottom', isset($photo_position)? $photo_position == 'Left Bottom' : ''); ?> >Left Bottom</option>
                           <option  value="Right Top" <?php echo set_select('photo_position', 'Right Top', isset($photo_position)? $photo_position == 'Right Top' : ''); ?> >Right Top</option>
                           <option  value="Right Center" <?php echo set_select('photo_position', 'Right Center', isset($photo_position)? $photo_position == 'Right Center' : ''); ?> >Right Center</option>
                           <option  value="Right Bottom" <?php echo set_select('photo_position', 'Right Bottom', isset($photo_position)? $photo_position == 'Right Bottom' : ''); ?> >Right Bottom</option>
                           <option  value="Center Top" <?php echo set_select('photo_position', 'Center Top', isset($photo_position)? $photo_position == 'Center Top' : ''); ?> >Center Top</option>
                           <option  value="Center Center" <?php echo set_select('photo_position', 'Center Center', isset($photo_position)? $photo_position == 'Center Center' : ''); ?> >Center Center</option>
                           <option  value="Center Bottom" <?php echo set_select('photo_position', 'Center Bottom', isset($photo_position)? $photo_position == 'Center Bottom' : ''); ?> >Center Bottom</option>
                           <option  value="None" <?php echo set_select('photo_position', 'None', isset($photo_position)? $photo_position == 'None' : ''); ?> >None</option>
                       </select>

                      <?php if( form_error('photo_position') )
                           {
                      ?>
                              <div class="col-lg-12 form-group has-error">
                                  <p class="help-block">

                               <?php echo isset($errors['photo_position'])?$errors['photo_position']:'';?>
                                  </p>
                              </div>

                      <?php
                        }
                      ?>

                    </div>


                    <div class="row fontawesome-icon-list">
                      <label class="control-label col-md-2">Upload Logo</label>
                      <div class="col-md-4">
                          <div class="fileupload fileupload-new" data-provides="fileupload">
                              <div class="fileupload-new thumbnail" style="width: 200px; height: 150px;">
                                  <img id="image_preview" src="<?php echo isset($logo)?$logo:'res/images/noimage.gif'; ?>" alt="" />
                                  <input type="hidden" name="image_preview" value="<?php echo isset($logo)?$logo:'res/images/noimage.gif'; ?>" />
                              </div>
                              <div class="fileupload-preview fileupload-exists thumbnail" style="max-width: 200px; max-height: 150px; line-height: 20px;"></div>
                              <div>
                             <span class="btn btn-white btn-file">
                             <span class="fileupload-new"><i class="fa fa-paperclip"></i> Select image</span>
                             <span class="fileupload-exists"><i class="fa fa-undo"></i> Change</span>
                             <input type="file" name="logoimg" class="default" />
                             </span>
                                  <a href="#" class="btn btn-danger fileupload-exists" data-dismiss="fileupload"><i class="fa fa-trash"></i> Remove</a>
                              </div>
                          </div>
                          <span class="label label-danger">NOTE!</span>
                         <span>
                           Attached image thumbnail is
                           supported in Latest Firefox, Chrome, Opera,
                           Safari and Internet Explorer 10 only
                         </span>
                      </div>

                  </div>



                 </div><!-- /.box-body -->

                  <div class="box-footer">
                    <input type="hidden" name="company_id" id="company_id" value="<?php echo set_value('company_id',  (isset($company_id) ? $company_id : '') ); ?>">
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
$(function ()
{
    'use strict';

    // Initialize the jQuery File Upload widget:
    $('#fileupload').fileupload();

    // Enable iframe cross-domain access via redirect option:
    $('#fileupload').fileupload(
        'option',
        'redirect',
        window.location.href.replace(
            /\/[^\/]*$/,
            './cors/result.html?%s'
            )
        );

//Set your url localhost or your ndd (perrot-julien.fr)
    if (window.location.hostname === 'localhost') {
        //Load files
        // Upload server status check for browsers with CORS support:
        if ($.ajaxSettings.xhr().withCredentials !== undefined)
        {
            $.ajax({
                url: 'upload/get_files',
                dataType: 'json', 

                success : function(data) {  

                    var fu = $('#fileupload').data('fileupload'), 
                    template;
                    fu._adjustMaxNumberOfFiles(-data.length);
                    template = fu._renderDownload(data)
                    .appendTo($('#fileupload .files'));

                    // Force reflow:
                    fu._reflow = fu._transition && template.length &&
                    template[0].offsetWidth;
                    template.addClass('in');
                    $('#loading').remove();
                }

            }).fail(function () {
                $('<span class="alert alert-error"/>')
                .text('Upload server currently unavailable - ' +
                    new Date())
                .appendTo('#fileupload');
            });
        }
    } else {
        // Load existing files:
        $('#fileupload').each(function () {
            var that = this;
            $.getJSON(this.action, function (result) {
                if (result && result.length) {
                    $(that).fileupload('option', 'done')
                    .call(that, null, {
                        result: result
                    });
                }
            });
        });
    }


    // Open download dialogs via iframes,
    // to prevent aborting current uploads:
    $('#fileupload .files a:not([target^=_blank])').on('click', function (e) {
        e.preventDefault();
        $('<iframe style="display:none;"></iframe>')
        .prop('src', this.href)
        .appendTo('body');
    });
});

        
</script>