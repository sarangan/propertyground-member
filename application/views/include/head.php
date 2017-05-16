<!DOCTYPE html>
<html>
  <head>
    <base href="<?php echo base_url(); ?>" />
    <meta charset="UTF-8">

    <title>Property Ground | Dashboard</title>
    <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>
    <link rel="shortcut icon" href="res/images/favicion.png" type="image/x-icon" />
    <!-- Bootstrap 3.3.2 -->
    <link href="res/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
    <!-- Font Awesome Icons -->
    <!-- <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css" rel="stylesheet" type="text/css" /> -->
    <link rel="stylesheet" href="res/font-awesome/css/font-awesome.min.css">

    <!-- Ionicons -->
    <!-- <link href="http://code.ionicframework.com/ionicons/2.0.0/css/ionicons.min.css" rel="stylesheet" type="text/css" /> -->

        <!-- Bootstrap time Picker -->
    <link href="res/plugins/timepicker/bootstrap-timepicker.min.css" rel="stylesheet"/>

    <!-- Bootstrap Color Picker -->
    <link href="res/plugins/datepicker/datepicker3.css" rel="stylesheet"/>


    <!-- Theme style -->
    <link href="res/dist/css/AdminLTE.css" rel="stylesheet" type="text/css" />
    <!-- AdminLTE Skins. We have chosen the skin-blue for this starter
          page. However, you can choose any other skin. Make sure you
          apply the skin class to the body tag so the changes take effect.
    -->
    <link href="res/dist/css/skins/skin-blue.min.css" rel="stylesheet" type="text/css" />

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script>
    <![endif]-->


<!-- <link href="res/dist/css/main.min.css" rel="stylesheet" type="text/css" /> -->
      
      <link href="res/plugins/datatables/dataTables.bootstrap.css" rel="stylesheet"/>

      <link rel="stylesheet" type="text/css" href="res/plugins/bootstrap-fileupload/bootstrap-fileupload.css" />

  </head>
  <!--
  BODY TAG OPTIONS:
  =================
  Apply one or more of the following classes to get the 
  desired effect
  |---------------------------------------------------------|
  | SKINS         | skin-blue                               |
  |               | skin-black                              |
  |               | skin-purple                             |
  |               | skin-yellow                             |
  |               | skin-red                                |
  |               | skin-green                              |
  |---------------------------------------------------------|
  |LAYOUT OPTIONS | fixed                                   |
  |               | layout-boxed                            |
  |               | layout-top-nav                          |
  |               | sidebar-collapse                        |  
  |---------------------------------------------------------|
  class="skin-blue"
  -->
  <body >
    <div class="wrapper">

      <!-- Main Header -->
      <header class="main-header">

        <!-- Logo -->
        <a href="<?php echo base_url(); ?>" class="logo">
          <img src="res/images/logo.png" class="my_logo">
        </a>

        <!-- Header Navbar -->
        <nav class="navbar navbar-static-top" role="navigation">
          <!-- Sidebar toggle button-->
          <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
            <span class="sr-only">Toggle navigation</span>
          </a>
          <!-- Navbar Right Menu -->
          <div class="navbar-custom-menu">
            <ul class="nav navbar-nav">
              <!-- Messages: style can be found in dropdown.less-->
              <li class="dropdown messages-menu">
                <!-- Menu toggle button -->
                <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                  <i class="fa fa-envelope-o"></i>
                  <span class="label label-danger"><?php 
                    if(isset($my_mails_count))
                        {
                          if($my_mails_count > 0 )
                          {
                            echo $my_mails_count;
                          }
                        }
                    ?></span>
                  </a>
                <ul class="dropdown-menu">
                  
                  <li class="header">
                    <?php
                        if(isset($my_mails_count))
                        {
                          if($my_mails_count > 0 )
                          {
                            echo 'You have '. $my_mails_count .' messages';
                          }
                        }
                    ?>
                  </li>
                  
                  <li>
                    <!-- inner menu: contains the messages -->
                    <ul class="menu">

                      <?php                      

                           if(isset($my_mails)){
                              foreach ($my_mails->result() as $mail) {

                                  $link_url = '#';
                                  $user_img = '';
                                  if(isset($current_usr_is_admin))
                                  {
                                    if($current_usr_is_admin == 1)
                                    {
                                        $link_url = 'index.php/admin/jobs/singleView/' .  $mail->project_id;
                                        $user_img = 'res/images/client.png';
                                    }
                                    else
                                    {
                                       $link_url =  'index.php/jobs/view/' . $mail->project_id ;
                                       $user_img = 'res/images/admin.png';
                                    }
                                  }

                                  $read_color = "";
                                  if($mail->status == 1)
                                  {
                                    $read_color = "style='background-color : #ffffff;' ";
                                  }


                                echo '<li '.$read_color. '><!-- start notification -->

                                          <a href="'. base_url() . $link_url  .'">
                                            <div class="pull-left">
                                              <!-- User Image -->
                                              <img src="'. $user_img .'" class="img-circle" alt="User Image"/>
                                            </div>
                                            <!-- Message title and timestamp -->
                                            <h4>'.                            
                                              $mail->sender_firstname .' ' . $mail->sender_lastname .'
                                              <small><i class="fa fa-clock-o"></i> <span data-livestamp="'. $mail->updated_date .'"</span></small>
                                            </h4>
                                            <!-- The message -->
                                            <p>'.                            
                                                substr($mail->message, 0, 20) .
                                            '</p>
                                          </a>
                                      </li><!-- end notification -->
                                ';
                              }
                           }

                      ?>

                    </ul><!-- /.menu -->
                  </li>
                  <li class="footer"></li>
                </ul>
              </li><!-- /.messages-menu -->

              <!-- Notifications Menu -->
              <li class="dropdown notifications-menu">
                <!-- Menu toggle button -->
                <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                  <i class="fa fa-bell-o"></i>
                  <?php
                    if(isset($my_notifications_count))
                    {
                      if($my_notifications_count > 0 )
                      {
                        echo '<span class="label label-danger">'.  $my_notifications_count . '</span>';
                      }
                    }
                  ?>
                </a>
                <ul class="dropdown-menu">
                  <li class="header">
                    <?php
                        if(isset($my_notifications_count))
                        {
                          if($my_notifications_count > 0 )
                          {
                            echo 'You have '. $my_notifications_count .' notifications';
                          }
                        }
                    ?>
                  </li>
                  <li>
                    <!-- Inner Menu: contains the notifications -->
                    <ul class="menu">
                      <?php                      

                           if(isset($my_notifications)){
                              foreach ($my_notifications as $notification) {

                                  $link_url = '#';
                                  if(isset($current_usr_is_admin))
                                  {
                                    if($current_usr_is_admin == 1)
                                    {
                                        $link_url = 'index.php/admin/jobs/singleView/' .  $notification->event_id;

                                        if( 'PAYMENT_RECEIVED' ==  $notification->type )
                                        {
                                           $link_url = 'index.php/admin/payment/view';
                                        }
                                    }
                                    else
                                    {
                                       $link_url =  'index.php/jobs/view/' . $notification->event_id ;
                                    }
                                  }

                                  $read_color = "";
                                  if($notification->status == 1)
                                  {
                                    $read_color = "style='background-color : #ffffff;' ";
                                  }


                                echo '<li '.  $read_color . ' ><!-- start notification -->

                                          <a href="'. base_url() . $link_url  .'">
                                            <div class="pull-left">
                                              <!-- User Image -->
                                              <img src="'. $notification->sender_profile_image .'" class="img-circle" alt="User Image"/>
                                            </div>
                                            <!-- Message title and timestamp -->
                                            <h4>'.                            
                                              substr($notification->sender_name, 0, 12) .'... 
                                              <small><i class="fa fa-clock-o"></i> <span data-livestamp="'. $notification->updated_date .'"</span></small>
                                            </h4>
                                            <!-- The message -->
                                            <p>'.                            
                                                $notification->notification_text .
                                            '</p>
                                          </a>
                                      </li><!-- end notification -->
                                ';
                              }
                           }

                      ?>

                    </ul>
                  </li>
                  <li class="footer"></li>
                </ul>
              </li>


              <!-- User Account Menu -->
              <li class="dropdown user user-menu">
                <!-- Menu Toggle Button -->
                <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                  <!-- The user image in the navbar-->
                  <img src="<?php echo (isset($current_usr_image)?$current_usr_image:'res/images/client.png'); ?>" class="user-image" alt="User Image"/>
                  <!-- hidden-xs hides the username on small devices so only the image appears. -->
                  <span class="hidden-xs"><?php echo (isset($current_usr_first_name)?$current_usr_first_name:'') . ' '  . (isset($current_usr_last_name)?$current_usr_last_name:'') ; ?></span>
                </a>
                <ul class="dropdown-menu">
                  <!-- The user image in the menu -->
                  <li class="user-header">
                    <img src="<?php echo (isset($current_user_full_image)?$current_user_full_image:'res/images/client.png'); ?>" class="img-circle" alt="User Image" />
                    <p style="color:black;">
                      <?php echo (isset($current_usr_first_name)?$current_usr_first_name:'') . ' '  . (isset($current_usr_last_name)?$current_usr_last_name:'') ; ?>
                      <small style="color:black;" ><?php echo (isset($current_usr_company)?$current_usr_company:''); ?></small>
                    </p>
                  </li>                  
                  <!-- Menu Footer-->
                  <li class="user-footer">

                    <div class="pull-left">
                      <a href="<?php echo base_url() . 'index.php/auth/change_password'; ?>" class="btn btn-default btn-flat" style="padding:8px;">Reset Password</a>
                    </div>
                    
                    <div class="pull-right">
                      <a href="<?php echo base_url().  'index.php/auth/logout/' ; ?>" class="btn btn-default btn-flat" style="padding:8px;">Sign out</a>
                    </div>

                  </li>
                </ul>
              </li>
            </ul>
          </div>
        </nav>
      </header>