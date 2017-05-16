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
            <i class="fa fa-file-image-o"></i> Edit File
          </h1>
          <ol class="breadcrumb">
           <li><a href="<?php echo base_url(); ?>">Home</a></li>
           <li><a href="<?php echo base_url() . 'index.php/admin/jobs/view'; ?>">All Jobs</a></li>
             <li><a href="<?php echo base_url() . 'index.php/admin/clients/view'; ?>">Companies</a></li>
            <li><a href="<?php echo base_url() . 'index.php/admin/clients/summary/'. (isset($client_id)?$client_id:''); ?>">Jobs</a></li>
            <li><a href="<?php echo base_url() . 'index.php/admin/jobs/singleView/' . (isset($project_id)?$project_id:''); ?>">View</a></li>
            <li class="active"><a onclick="return false;" href="#">Edit File</a></li>
          </ol>

        </section>

        <!-- Main content -->
        <section class="content">
          
          <!-- Your Page Content Here -->
           <div class="row">

           <div class="col-md-5">
              
              <article class="widget">

                <header class="widget__header">
                  <div class="widget__title">
                    <i class="fa fa-file-image-o"></i><h3>File...</h3>
                  </div>
                </header>

                      <div class="widget__content filled pad20">
                        
                          <div class="row">

                            <div class="col-md-12 text-center btn__showcase2">
                              
                              <div class="img-map">
                                  <?php
                                      if(isset($is_image))
                                      {

                                        if($is_image)
                                        {
                                          // this is a image
                                          echo '<img class="my_file_preview" src="'. (isset($file_path)? $file_path . (isset($image_url)? $image_url : '')  : '') .'" alt="preview" />';
                                        }
                                        else
                                        {
                                          echo '<img class="my_file_preview" src="res/images/no_preview.gif" alt="no preview" />';
                                        }

                                      }

                                  ?>
                              </div>

                              <div class="widget__content filled">

                                    <table>
                                        <tbody>
                                        <tr>
                                          <td>File Type:</td>
                                          <td><?php echo '<img src="res/filetype_icons/'.  (isset($file_type)? strtolower($file_type):'default') . '.png" /> '  . (isset($file_type)?$file_type:'') ;  ?> </td>
                                        </tr>
                                        <tr>
                                          <td>Size:</td>
                                          <td><?php echo isset($size)?$size:'';  ?> KB</td>
                                        </tr>
                                        <tr>
                                          <td>Description:</td>
                                          <td><?php echo isset($description)?$description:'';  ?></td>
                                        </tr>

                                      </tbody>
                                    </table>
                                    
                                    

                                </div>

                                
                            </div>

                          </div>

                      </div>

                  </article>


           </div>


            <!-- left column -->
            <div class="col-md-7">

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
                <form role="form" accept-charset="utf-8" method="POST" action="<?php echo base_url() . 'index.php/admin/files/desEdit'; ?>" >
                  <div class="box-body">
                    
                    <div class="form-group">
                      <label for="exampleInputEmail1">Description :</label>
                      <input type="text" name="description"  class="form-control" id="description" placeholder="Enter file description" value="<?php echo set_value('description',  (isset($description) ? $description : '') ); ?>">

                      <?php if( form_error('description') )
                           {
                      ?>
                              <div class="col-lg-12 form-group has-error">
                                  <p class="help-block">

                               <?php echo isset($errors['description'])?$errors['description']:'';?>
                                  </p>
                              </div>

                      <?php
                        }
                      ?>

                    </div>


                 </div><!-- /.box-body -->

                  <div class="box-footer">
                    <input type="hidden" name="file_id" id="file_id" value="<?php echo set_value('file_id',  (isset($file_id) ? $file_id : '') ); ?>">
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