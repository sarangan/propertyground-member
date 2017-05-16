<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <base href="<?php echo base_url(); ?>" />
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>PropertyGround :: Sign in</title>

   <!-- Bootstrap 3.3.2 -->
    <link href="res/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
    <!-- Font Awesome Icons -->
    <!-- <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css" rel="stylesheet" type="text/css" /> -->
    <link rel="stylesheet" href="res/font-awesome/css/font-awesome.min.css">

        <!-- Theme style -->
    <link href="res/dist/css/AdminLTE.css" rel="stylesheet" type="text/css" />
  
</head>
<body>
  <div id="loading">
    <div class="loader loader-light loader-large"></div>
  </div>

  
        
        
          <div>
          
          <div class="col-md-4  col-md-offset-4">
            <article class="widget widget__login">
              <header class="widget__header_login one-btn">
                <div class="widget__title_login login_title">
                  <div class="main-logo"><img src="res/images/logo.png"></div> <?php echo lang('login_heading');?>
                </div>
                <div class="widget__config_login">
                 <a href="<?php echo base_url() . 'index.php/auth/forgot_password'; ?>"><i class="fa fa-question-circle"></i></a>
                </div>
              </header>

               <?php echo form_open("auth/login");?>

              <div class="widget__content_login">
                <input type="text" placeholder="Username" id="identity" value="" name="identity">
              
                <input type="password" placeholder="Password" id="password" value="" name="password">

                <button type="submit">Sign in</button>
               

              </div>
              <div class="login__remember text-center">

              <?php 
                    $data = array(
                                'name'        => 'remember',
                                'id'          => 'cc1',
                                'value'       => '1',
                                'checked'     => TRUE,
                                'class'       => 'custom-checkbox',
                                );

              echo form_checkbox($data);?>
                <label for="cc1"></label>
                 <?php echo lang('login_remember_label', 'remember');?>
              </div>

              <?php echo form_close();?>

              <p><a href="<?php echo base_url() . 'index.php/auth/forgot_password'; ?>"><?php echo lang('login_forgot_password');?></a></p>

              <div id="infoMessage"><?php echo $message;?></div>

               
            </article><!-- /widget -->
          </div>

        </div>



   
    <!-- jQuery 2.1.3 -->
    <script src="res/plugins/jQuery/jQuery-2.1.3.min.js"></script>
    <!-- Bootstrap 3.3.2 JS -->
    <script src="res/bootstrap/js/bootstrap.min.js" type="text/javascript"></script>
    <!-- AdminLTE App -->
    <script src="res/dist/js/app.min.js" type="text/javascript"></script>
</body>
</html>