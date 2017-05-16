<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<?php $this->load->view('./include/head.php');?>
<?php $this->load->view('./include/sidebar_admin.php');?>

      <!-- Content Wrapper. Contains page content -->
      <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">

        
          <h1>
            <i class="fa fa-user"></i> Login details
          </h1>
          <ol class="breadcrumb">
            <li><a onclick="return false;" href="#">Home</a></li>
            <li class="active"><a onclick="return false;" href="#">Login details</a></li>
          </ol>


        </section>

        <!-- Main content -->
        <section class="content">
          
          <!-- Your Page Content Here -->
          <div class="row">
            <div class="col-lg-12">

				<h1><?php echo lang('reset_password_heading');?></h1>

				<div id="infoMessage"><?php echo $message;?></div>

				<?php echo form_open('auth/reset_password/' . $code);?>

					<p>
						<label for="new_password"><?php echo sprintf(lang('reset_password_new_password_label'), $min_password_length);?></label> <br />
						<?php echo form_input($new_password);?>
					</p>

					<p>
						<?php echo lang('reset_password_new_password_confirm_label', 'new_password_confirm');?> <br />
						<?php echo form_input($new_password_confirm);?>
					</p>

					<?php echo form_input($user_id);?>
					<?php echo form_hidden($csrf); ?>

					<p><?php echo form_submit('submit', lang('reset_password_submit_btn'));?></p>

				<?php echo form_close();?>

            </div>
          </div>

        </section><!-- /.content -->
      </div><!-- /.content-wrapper -->


<?php $this->load->view('./include/footer.php');?>

<script type="text/javascript">
  $(function () {


  });
</script>