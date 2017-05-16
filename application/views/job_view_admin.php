<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<?php $this->load->view('include/head.php');?>
<link href="res/plugins/magnific/magnific-popup.css" rel="stylesheet">
<?php $this->load->view('include/sidebar_admin.php');?>


      <!-- Content Wrapper. Contains page content -->
      <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">

        
          <h1>
            <i class="fa fa-home"></i> <?php echo isset($address)? $address : '' ; ?>
          </h1>
          <ol class="breadcrumb">
            <li><a href="<?php echo base_url(); ?>">Home</a></li>
             <li><a href="<?php echo base_url() . 'index.php/admin/jobs/view'; ?>">All Jobs</a></li>
            <li><a href="<?php echo base_url() . 'index.php/admin/clients/view'; ?>">Companies</a></li>          
            <li><a href="<?php echo base_url() . 'index.php/admin/clients/summary/'. (isset($client_id)?$client_id:''); ?>">Jobs</a></li>
            <li class="active"><a onclick="return false;" href="#">View</a></li>
          </ol>


        </section>

        <!-- Main content -->
        <section class="content">
          
          <!-- Your Page Content Here -->
           <div class="row">
            <!-- left column -->


              <div class="col-md-7">

                <article class="widget">

                    <ul id="myTab" class="nav nav-pills nav-justified">
                        <li class="active"><a href="#service-one"  data-toggle="tab">Messages</a>
                        </li>
                        <li><a href="#service-two" data-toggle="tab">Files</a>
                        </li>
                        
                    </ul>

                   <div id="myTabContent" class="tab-content">
                        <div class="tab-pane fade active in" id="service-one">

                            <div class="widget__content filled">
                              

                              <div class="chat-conversation">

                                <ul class="conversation-list">

                                  <?php
                                      get_instance()->load->helper('common');
                                    

                                    if(isset($mesages))
                                    {
                                      if($mesages->num_rows() > 0 )
                                      {

                                        foreach ($mesages->result() as $msg) {
                                            
                                            $ago = time_elapsed_string($msg->mytime ); 
                                            if($msg->sender_id == $user_id)
                                            {

                                              // $time = strtotime($msg->updated_date );
                                              // $dbDate = new DateTime($time);
                                              // $currDate = new DateTime();
                                              // $interval = $currDate->diff($dbDate);
                                              //$interval->d." days ".$interval->h." hours ago";

                                              echo '<li class="clearfix odd">
                                                    <div class="chat-avatar">
                                                        <img src="res/images/admin.png" alt="male">
                                                        <i>'. $ago.'</i>
                                                    </div>
                                                    <div class="conversation-text">
                                                        <div class="ctext-wrap">
                                                            <i>'.$msg->sender_name .'</i>
                                                            <p>'.
                                                                nl2br($msg->message)
                                                            .'</p>
                                                        </div>
                                                    </div>
                                                </li>';

                                            }
                                            else{
                                              echo '<li class="clearfix ">
                                                      <div class="chat-avatar">
                                                          <img src="res/images/client.png" alt="female">
                                                          <i>'. $ago.'</i>
                                                      </div>
                                                      <div class="conversation-text">
                                                          <div class="ctext-wrap">
                                                              <i>'. $msg->sender_name .'</i>
                                                              <p>'.
                                                                nl2br($msg->message)
                                                            .'</p>
                                                          </div>
                                                      </div>
                                                  </li>';


                                            }
                                            

                                        }

                                      }
                                    }

                                  ?>
                                </ul>
                                <div class="row">                                  

                                      <div class="col-xs-9">
                                          <!-- <input type="text" class="form-control chat-input" name="message" placeholder="Enter your text"> -->
                                          <textarea class="form-control chat-input" name="message" rows="3" placeholder="Enter your text"></textarea>
                                      </div>
                                      <div class="col-xs-3 chat-send">                                         

                                          <button type="submit" class="btn blue"><i class="fa fa-comments-o pull-left"></i> Send</button>
                                      </div>                                 

                                </div>

                                <div class="row">

                                  <div class="col-md-4">
                                    <div class="box box-default collapsed-box">
                                      <div class="box-header with-border">
                                        <h3 class="box-title">Send as</h3>
                                        <div class="box-tools pull-right">
                                          <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-plus"></i></button>
                                        </div><!-- /.box-tools -->
                                      </div><!-- /.box-header -->
                                      <div class="box-body">
                                        <input type="checkbox" name="sendas" id="sendas" value="1">Send as <br/>

                                        <?php 
                                              if(isset($send_users) && ($send_users->num_rows() > 0 ))
                                              {
                                                foreach ($send_users->result() as $usr) {

                                                  echo '<input type="radio" class="user_rdb"  id="usr_'. $usr->id.'" name="usr" data-name="'. $usr->first_name . ' ' . $usr->last_name .'" value="'. $usr->id .'"><label for="usr_'. $usr->id.'">'. $usr->first_name . ' ' . $usr->last_name . '</label><br/>';

                                                }
                                              }

                                        ?>

                                        
                                      </div><!-- /.box-body -->
                                    </div><!-- /.box -->
                                  </div><!-- /.col -->

                                </div>


                              </div>


                            </div>

                        </div>

                         <div class="tab-pane fade" id="service-two">
                             
                             <div class="widget__content filled">

                                  <div class="upload-btn-div">
                                  <a data-toggle="tooltip" data-original-title="Upload files"  href="<?php echo base_url() . 'index.php/admin/files/upload/'. (isset($project_id)?$project_id:'') ; ?>"><button type="button" class="btn green"><i class="fa fa-cloud-upload"></i> Upload</button></a>
                                  <a data-toggle="tooltip" data-original-title="Download all files as zip file"  href="#" class="zipDownloadPromise" href="#" data-fileid="<?php echo (isset($project_id) ? $project_id : ''); ?>"><button type="button" class="btn green"> <i class="fa fa-cloud-download"></i> Download as zip</button></a>

                                  </div>
                                  
                                  <div class="table-responsive" >
                                    <table class="table table-bordered" id="dataTables-example">
                                        <thead>
                                            <tr>
                                                <th>File</th>
                                                <th>Description</th>
                                                <th>Size</th>
                                                <th style="width:100px;"><i class="fa fa-bars"></i></th>
                                            </tr>
                                        </thead>
                                        <tbody>

                                            <?php 

                                                if( ( isset($files) ) && ($files->num_rows() > 0 ) )
                                                {
                                                    foreach ($files->result() as $war) {

                                                      $src ="";
                                                      $style ="";
                                                      if($war->is_image)
                                                      {
                                                          if(isset($file_url) )
                                                          {
                                                             $src = $file_url .$war->image_url;
                                                              $style = "style=' width: 50px; height: auto;' ";
                                                          }
                                                          else
                                                          {
                                                            $src = 'res/filetype_icons/'.  strtolower($war->file_type) . '.png';
                                                            if(!file_exists( $src))
                                                            {
                                                               $src = 'res/filetype_icons/default.png';
                                                            }
                                                            $style ='';
                                                          }
                                                         
                                                         
                                                      }
                                                      else{

                                                          $src =  'res/filetype_icons/'.  strtolower($war->file_type) . '.png';
                                                          if(!file_exists( $src))
                                                          {
                                                             $src = 'res/filetype_icons/default.png';
                                                          }

                                                          $style ='';
                                                      }
                                                        
                                                        echo '<tr>
                                                                    <td><a class="image-link" href="'. $src .'"><img src="'. $src .'" alt="download"' . $style  . '/></a></td>
                                                                    <td>'. $war->description .'</td>
                                                                    <td>'. $war->size . ' KB</td>                                                                   
                                                                    <td>
                                                                        <span class="tools-icons edit-ico">
                                                                            <a  data-toggle="tooltip" data-original-title="Download" class="fileDownloadPromise" href="#" data-fileid="'. $war->file_url.'" href=""><i class="fa fa-cloud-download"></i></a>
                                                                        </span>
                                                                        <span class="tools-icons edit-ico">                             
                                                                            <a  data-toggle="tooltip" data-original-title="Edit" href="'. base_url() . 'index.php/admin/files/desEdit/'.  $war->id .'"><i class="fa fa-pencil"></i></a>
                                                                        </span>
                                                                        <span class="tools-icons delete-ico">                       
                                                                            <a href="#" data-toggle="modal" data-target="#confirm-submit" data-id="'. $war->id .'"><i class="fa fa-times-circle"></i></a>
                                                                        </span>
                                                                    </td>
                                                                </tr>';
                                                    }
                                                }

                                                

                                            ?>
                                            
                                        </tbody>
                                    </table>
                                </div>
                                <!-- /.table-responsive -->

                              </div>

                          </div>

                    </div>

                  </article>

              </div>


                            <div class="col-md-5">

                  <article class="widget">

                      <header class="widget__header">
                        <div class="widget__title">
                          <i class="fa fa-location-arrow"></i><h3><?php echo isset($address)? substr( $address, 0, 20 ) : '' ; ?>...</h3>
                        </div>
                       <!--  <div class="widget__config">
                        <a>
                        </a>
                        <a>
                        </a>
                        </div> -->
                      </header>

                      <div class="widget__content filled pad20">
                        
                          <div class="row">

                            <div class="col-md-12 text-center btn__showcase2">
                              
                              <div class="google-map">
                                <address><?php echo isset($address)?$address:'';  ?></address>
                              </div>

                              <div align="right" style="margin-bottom:10px;">
                                <a data-toggle="tooltip" data-original-title="Edit invoice"  href="<?php echo base_url(). 'index.php/admin/invoice/generate/' . (isset($project_id)?$project_id:'') ?>"><button type="button" class="btn blue"><i class="fa fa-print"></i>  Invoice</button></a>
                                <a data-toggle="tooltip" data-original-title="Edit job details"  href="<?php echo base_url(). 'index.php/admin/jobs/add/' . (isset($project_id)?$project_id:'') ?>"><button type="button" class="btn blue"><i class="fa fa-pencil"></i>  Edit</button></a>

                              </div>

                                <div class="widget__content filled">

                                    <table>
                                        <tbody>
                                        <tr>
                                          <td>Address:</td>
                                          <td><?php echo isset($address)?$address:'';  ?></td>
                                        </tr>
                                        <tr>
                                          <td>Services:</td>
                                          <td><?php echo isset($services)?$services:'';  ?></td>
                                        </tr>
                                         <?php
                                          if( isset($publish) && !empty($publish)){
                                         ?>
                                        <tr>
                                          <td>
                                            Total:
                                          </td>
                                          <td><?php echo isset($total_amount)?( number_format((float)$total_amount, 2, '.', '') ):'0.00';  ?></td>
                                        </tr>
                                         <?php
                                        }
                                        ?>  
                                        <tr>
                                          <td>Key Collection Info:</td>
                                          <td><?php echo isset($key_collection_info)?$key_collection_info:'';  ?></td>
                                        </tr>
                                        <tr>
                                          <td>Property Type:</td>
                                          <td><?php echo isset($property_type)?$property_type:'';  ?></td>
                                        </tr>
                                        <tr>
                                          <td>Number of Rooms:</td>
                                          <td>
                                          <?php 
                                                if(isset($no_of_rooms))
                                                {
                                                  $num_rooms = '';
                                                  switch ($no_of_rooms) {
                                                    case '10000':
                                                        $num_rooms = 'STUDIO';
                                                      break;                                                      
                                                     case '10001':
                                                        $num_rooms = 'ABOVE 10 BEDROOMS';
                                                      break;
                                                    case '1':
                                                        $num_rooms = '1 BEDROOM';
                                                      break;

                                                    default:
                                                         $num_rooms = $no_of_rooms . ' BEDROOMS';
                                                      break;
                                                  }

                                                  echo $num_rooms;
                                                }
                                                else
                                                {
                                                  echo '';
                                                }

                                            ?></td>
                                        </tr>
                                        <tr>
                                          <td>Company:</td>
                                          <td><?php echo isset($company)?$company:'';  ?></td>
                                        </tr>
                                         <tr>
                                          <td>User:</td>
                                          <td><?php echo isset($assign_user)?$assign_user:'';  ?></td>
                                        </tr>
                                        <tr>
                                          <td>Status:</td>
                                          <td><?php 

                                                  $status_txt = '';
                                                  $color ='';

                                                  if(isset($status))
                                                  {
                                                      switch ($status) {
                                                          case 1:
                                                            $status_txt = 'Job requested';
                                                            $color ='#048304';
                                                            break;
                                                          case 2:
                                                            $status_txt = 'Ready to download';
                                                            $color ='#16c2d9';
                                                            break;
                                                          case 3:
                                                            $status_txt = 'Job canceled';
                                                            $color ='#eda61f';
                                                            break;
                                                          case 4:
                                                            $status_txt = 'Job completed';
                                                            $color ='#16c2d9';
                                                            break;
                                                          case 5:
                                                            $status_txt = 'Appointment Confirmed';
                                                            $color ='#FF0099';
                                                            break;

                                                          default:
                                                            break;
                                                      }

                                                  }

                                                  echo '<span style="color:'. $color .';">'. $status_txt . '</span>';  
                                          ?></td>
                                        </tr>
                                        <tr>
                                          <td>Description:</td>
                                          <td style="text-align:justify;"><?php echo isset($description)?$description:'';  ?>
                                          </td>
                                        </tr>
                                        <tr>
                                          <td>Start Date and Time:</td>
                                          <td><?php echo isset($start_datatime)?$start_datatime:'';  ?></td>
                                        </tr>
                                        <tr>
                                          <td>Furnishing:</td>
                                          <td><?php echo isset($furnishing)? (!empty($furnishing)?$furnishing : '')  :'';  ?></td>
                                        </tr>                                         

                                      </tbody>
                                    </table>
                                    
                                    

                                </div>

                                <div class="widget__form">                             
                                  

                                  <div class="change_process_div">
                                    <form role="form" accept-charset="utf-8" method="POST" action="<?php echo base_url() . 'index.php/admin/jobs/processUpdate'; ?>" >
                                      
                                    
                                      Change Status :     
                                      <select name="change_process" id="change_process" class="change_process">
                                        <option  value="1" <?php echo set_select('change_process', '1', isset($status)? $status == '1' : ''); ?> >Job requested</option>
                                        <option  value="5" <?php echo set_select('change_process', '5', isset($status)? $status == '5' : ''); ?> >Appointment Confirmed</option>
                                        <option  value="4" <?php echo set_select('change_process', '4', isset($status)? $status == '4' : ''); ?> >Job completed</option>
                                        <option  value="2" <?php echo set_select('change_process', '2', isset($status)? $status == '2' : ''); ?> >Ready to download</option>
                                        <option  value="3" <?php echo set_select('change_process', '3', isset($status)? $status == '3' : ''); ?> >Job canceled</option>

                                      </select>

                                      <button type="submit" class="btn green">Save</button>
                                      <input type="hidden" name="project_id" id="project_id" value="<?php echo isset($project_id)?$project_id:''; ?>">
                                    
                                    </form>

                                  </div>

                                  
                                  

                                </div>


                            </div>

                          </div>

                      </div>

                  </article>


              </div>


          </div>

        </section><!-- /.content -->
      </div><!-- /.content-wrapper -->


<form accept-charset="utf-8" method="POST" action="<?php echo base_url() . 'index.php/admin/files/delete'; ?>">
<div class="modal fade" id="confirm-submit" tabindex="-1" role="dialog" aria-labelledby="basicModal" aria-hidden="true">
      <div class="modal-dialog model-sm">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            <h4 class="modal-title" id="myModalLabel">Delete</h4>
          </div>
          <div class="modal-body">
          <h5 class="model-text"> Are you sure do you want to delete this record?</h5>
          <input type="hidden" name="file_id" id="file_id">
          <input type="hidden" name="project_id" id="project_id" value="<?php echo isset($project_id)?$project_id:''; ?>">
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            <button type="submit" id="submit" class="btn btn-primary">Confirm</button>
          </div>
        </div>
      </div>
</div>
</form>


<?php $this->load->view('include/footer.php');?>
<script src="res/plugins/magnific/jquery.magnific-popup.min.js"></script>

<script type="text/javascript">
  $(function () {


           /*==Slim Scroll ==*/
        if ($.fn.slimScroll) {
            
            $('.conversation-list').slimscroll({
                height: '360px',
                wheelStep: 35,
                start: 'bottom'
            });
        }


      $("address").each(function(){
        var embed ="<iframe width='420' height='250' frameborder='0' scrolling='no' marginheight='0' marginwidth='0' src='https://maps.google.com/maps?&amp;q="+ encodeURIComponent( $(this).text() ) +"&amp;output=embed'></iframe>";
        $(this).html(embed);
        });

      });

  /*Chat*/
        $(function () {
            // $('.chat-input').keypress(function (ev) {
            //     var p = ev.which;
                
            //     var chatText = $('.chat-input').val();
            //     if (p == 13) {
            //         if (chatText == "") {
            //             alert('Empty Field');
            //         } else {


            //           sendMsg(chatText);
                        
            //         }
            //         $(this).val('');
            //         $('.conversation-list').scrollTo('100%', '100%', {
            //             easing: 'swing'
            //         });
            //         return false;
            //         ev.epreventDefault();
            //         ev.stopPropagation();
            //     }
            // });


            $('.chat-send .btn').click(function () {
                // var chatTime = moment().format("h:mm");
                var chatText = $('.chat-input').val();
                
                if (chatText == "") {
                    alert('Empty Field');
                    $(".chat-input").focus();
                } else {
                    
                     sendMsg(chatText );

                    $('.chat-input').val('');
                    $(".chat-input").focus();
                    $('.conversation-list').scrollTo('100%', '100%', {
                        easing: 'swing'
                    });
                }
            });




            $(document).on("click", "a.fileDownloadPromise", function () {
                       
                 var url = '<?php echo base_url()."index.php/jobs/fileDownload"; ?>';

                 var params = {
                      fileid :  $(this).data('fileid'),
                      project_id : <?php echo isset($project_id)?$project_id:'';  ?>,
                  };

                 $.fileDownload(url, {

                      successCallback: function () {
                          //showballoon('glyphicon glyphicon-ok-circle', '', " File is ready to download!.." , 'success');
                      },
                      failCallback: function (responseHtml, url) {
                          //showballoon('glyphicon glyphicon-exclamation-sign', '', " File not found!..", 'warning' ); 
                      },
                      httpMethod: "POST",
                      data: params
                  });
               
                  return false; //this is critical to stop the click event which will trigger a normal file download
            });

            $(document).on("click", "a.zipDownloadPromise", function () {
                       
                 var url = '<?php echo base_url()."index.php/admin/jobs/zipDownload"; ?>';

                 var params = {
                      project_id : <?php echo isset($project_id)?$project_id:'';  ?>,
                  };

                 $.fileDownload(url, {

                      successCallback: function () {
                          //showballoon('glyphicon glyphicon-ok-circle', '', " File is ready to download!.." , 'success');
                      },
                      failCallback: function (responseHtml, url) {
                          //showballoon('glyphicon glyphicon-exclamation-sign', '', " File not found!..", 'warning' ); 
                      },
                      httpMethod: "POST",
                      data: params
                  });
               
                  return false; //this is critical to stop the click event which will trigger a normal file download
            });

        
         $('#sendas').on('click', function()
         {
             

              if($(this).is(':checked'))
              {
              }
              else
              {
                $('.user_rdb').prop('checked',false);
              }

         });


         $('#confirm-submit').on('show.bs.modal', function (event) {
          
            var button = $(event.relatedTarget) // Button that triggered the modal
            var recipient = button.data('id') // Extract info from data-* attributes
            // If necessary, you could initiate an AJAX request here (and then do the updating in a callback).
            // Update the modal's content. We'll use jQuery here, but you could use a data binding library or other methods instead.
            var modal = $(this)
            modal.find('#file_id').val(recipient);
        
        });


    });



function sendMsg(chatText)
{
    var chatTime = moment().format("h:mm");

    var user_id ='';

    if($("#sendas").is(':checked'))
    {
      user_id = $("input[name=usr]:checked").val();

    }
    else
    {
      user_id ='';
     

    }

    var _data = { 
                   "project_id" : <?php echo isset($project_id)?$project_id:'';  ?>,
                   "client_id" : <?php echo isset($client_id)?$client_id:'';  ?>,
                   'message' : chatText,
                   'sender_id' : user_id
                };

    $.ajax({
              url: "<?php echo base_url() . 'index.php/admin/message/send/'; ?>",
              type: 'POST',
              dataType: 'json',
              data : _data,
              success: function(response){
                  
                  console.log(response);

                  if(response.status == 1)
                  {

                    if($("#sendas").is(':checked'))
                    {
                      var user_name = $("input[name=usr]:checked").data('name');
                      $('<li class="clearfix"><div class="chat-avatar"><img src="res/images/client.png" alt="male"><i>' + chatTime + '</i></div><div class="conversation-text"><div class="ctext-wrap"><i>' + user_name +'</i><p style="white-space: pre-wrap;">' + chatText + '</p></div></div></li>').appendTo('.conversation-list');
                    }
                    else
                    {
                      $('<li class="clearfix odd"><div class="chat-avatar"><img src="res/images/admin.png" alt="male"><i>' + chatTime + '</i></div><div class="conversation-text"><div class="ctext-wrap"><i> <?php echo isset($user_name)?$user_name:'';  ?></i><p style="white-space: pre-wrap;">' + chatText + '</p></div></div></li>').appendTo('.conversation-list');
                    }   
                     
                     
                  }
                                                                                  
              },
              error: function(response){ 
                  console.log(response);
              }
      });

}


$(document).ready(function() {
  $('.image-link').magnificPopup({type:'image'});



});

</script>