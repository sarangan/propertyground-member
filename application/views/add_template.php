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
            <i class="fa fa-envelope-o"></i> Add New Template
          </h1>
          <ol class="breadcrumb">
            <li><a href="<?php echo base_url(); ?>">Home</a></li>
            <li><a href="<?php echo base_url() . 'index.php/admin/templates/view'; ?>">Templates</a></li>
            <li class="active"><a onclick="return false;" href="#">Add New</a></li>
          </ol>
        </section>

        <!-- Main content -->
        <section class="content">
          
          <!-- Your Page Content Here -->
           <div class="row">
            <!-- left column -->
            <div class="col-md-12">

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
                <form role="form" accept-charset="utf-8" method="POST" action="<?php echo base_url() . 'index.php/admin/templates/add'; ?>" >
                  <div class="box-body">


                    <div class="form-group">
                      <label for="exampleInputEmail1">Type :</label>                     
                      <select class="my_select" id="type" name="type" >
                           <option value="">-- Please select --</option>
                           <option  value="NEWCOM" <?php echo set_select('type', 'NEWCOM', isset($type)? $type == 'NEWCOM' : ''); ?> >Create a new company</option>
                           <option  value="NEWUSR" <?php echo set_select('type', 'NEWUSR', isset($type)? $type == 'NEWUSR' : ''); ?> >Create a new user</option>
                           <option  value="NEWJOB" <?php echo set_select('type', 'NEWJOB', isset($type)? $type == 'NEWJOB' : ''); ?> >Create a new job</option>
                           <option  value="EDITJOB" <?php echo set_select('type', 'EDITJOB', isset($type)? $type == 'EDITJOB' : ''); ?> >Update job</option>
                           <option  value="NEWMSG" <?php echo set_select('type', 'NEWMSG', isset($type)? $type == 'NEWMSG' : ''); ?> >Send message</option>
                           <option  value="STPROC" <?php echo set_select('type', 'STPROC', isset($type)? $type == 'STPROC' : ''); ?> >Update status processing</option>
                           <option  value="STACC" <?php echo set_select('type', 'STACC', isset($type)? $type == 'STACC' : ''); ?> >Job has been accepted</option>
                           <option  value="STCARRY" <?php echo set_select('type', 'STCARRY', isset($type)? $type == 'STCARRY' : ''); ?> >Update status ready to download</option>
                           <option  value="STCANC" <?php echo set_select('type', 'STCANC', isset($type)? $type == 'STCANC' : ''); ?> >Update status cancel</option>
                           <option  value="STCOMP" <?php echo set_select('type', 'STCOMP', isset($type)? $type == 'STCOMP' : ''); ?> >Update status completed</option>

                           <option  value="SENDINV" <?php echo set_select('type', 'SENDINV', isset($type)? $type == 'SENDINV' : ''); ?> >Send invoice</option>
                           <option  value="REMINVO" <?php echo set_select('type', 'REMINVO', isset($type)? $type == 'REMINVO' : ''); ?> >Re-send invoice</option>
                           
                           <option  value="NEWJOB_ADMIN" <?php echo set_select('type', 'NEWJOB_ADMIN', isset($type)? $type == 'NEWJOB_ADMIN' : ''); ?> >Create new job admin</option>
                           <option  value="EDITJOB_ADMIN" <?php echo set_select('type', 'EDITJOB_ADMIN', isset($type)? $type == 'EDITJOB_ADMIN' : ''); ?> >Update job admin</option>

                           <option  value="PAYACC" <?php echo set_select('type', 'PAYACC', isset($type)? $type == 'PAYACC' : ''); ?> >Payment accepted</option>
                           <option  value="PAYREJ" <?php echo set_select('type', 'PAYREJ', isset($type)? $type == 'PAYREJ' : ''); ?> >Payment rejected</option>
                           <option  value="PAYREC" <?php echo set_select('type', 'PAYREC', isset($type)? $type == 'PAYREC' : ''); ?> >Payment received</option>

                           <option  value="DEFAULT" <?php echo set_select('type', 'DEFAULT', isset($type)? $type == 'DEFAULT' : ''); ?> >Additional template</option>
                       </select>

                      <?php if( form_error('type') )
                           {
                      ?>
                              <div class="col-lg-12 form-group has-error">
                                  <p class="help-block">

                               <?php echo isset($errors['type'])?$errors['type']:'';?>
                                  </p>
                              </div>

                      <?php
                        }
                      ?>

                    </div>
                    
                    
                    <div class="form-group">
                      <label for="exampleInputEmail1">Subject:</label>
                      <input type="text" name="subject"  class="form-control" id="subject" placeholder="Email subject..." value="<?php echo set_value('subject',  (isset($subject) ? $subject : '') ); ?>">
                      <?php if( form_error('subject') )
                        {
                      ?>
                              <div class="col-lg-12 form-group has-error">
                                  <p class="help-block">
                                      <?php echo isset($errors['subject'])?$errors['subject']:'';?>
                                  </p>
                              </div>
                      <?php
                        }
                      ?>

                    </div>


                    <div class="form-group">
                      <label for="exampleInputEmail1">Body:</label>

                      <textarea class="form-control" name="body" id="body" placeholder="Enter email body..."><?php echo  set_value('body',  (isset($body) ? $body : '') ); ?></textarea>
                      <script>
                            document.addEventListener('DOMContentLoaded', function(){
                                               CKEDITOR.replace( 'body', {
                                                        toolbar: 'Advanced',
                                                        uiColor: '#ffffff',
                                                      height: '450px'});
                                            });
                      </script>

                      <?php if( form_error('body') )
                        {
                      ?>
                              <div class="col-lg-12 form-group has-error">
                                  <p class="help-block">
                                      <?php echo isset($errors['body'])?$errors['body']:'';?>
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

<!-- jQuery File Upload Dependencies -->
<script src="res/plugins/ckeditor/ckeditor.js"></script>

<script type="text/javascript">
$(function () {
  
});

        
</script>