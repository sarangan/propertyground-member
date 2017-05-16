<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<?php $this->load->view('./include/head.php');?>
<?php $this->load->view('./include/sidebar.php');?>

<style type="text/css">
  input[type="password"] {
  width: 100%;
  color: black;
}
input[type="text"] {
  width: 100%;
  color: black;
}
input[type="submit"] {
  color: black;
}
</style>

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
            
				<h1><?php echo lang('forgot_password_heading');?></h1>
				<p><?php echo sprintf(lang('forgot_password_subheading'), $identity_label);?></p>

				<div id="infoMessage"><?php echo $message;?></div>

				<?php echo form_open("auth/forgot_password");?>

				      <p>
				      	<label for="email"><?php echo sprintf(lang('forgot_password_email_label'), $identity_label);?></label> <br />
				      	<?php echo form_input($email);?>
				      </p>

				      <p><?php echo form_submit('submit', lang('forgot_password_submit_btn'));?></p>

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