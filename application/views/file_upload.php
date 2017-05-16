<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<link href="res/plugins/fileupload/bucketmin.css" rel="stylesheet" />
<?php $this->load->view('include/head.php');?>
<?php $this->load->view('include/sidebar_admin.php');?>


      <!-- Content Wrapper. Contains page content -->
      <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">        
          <h1>
            <i class="fa fa-file-image-o"></i> Upload Files
          </h1>
          <ol class="breadcrumb">
            <li><a href="<?php echo base_url(); ?>">Home</a></li>
              <li><a href="<?php echo base_url() . 'index.php/admin/jobs/view'; ?>">All Jobs</a></li>
             <li><a href="<?php echo base_url() . 'index.php/admin/clients/view'; ?>">Companies</a></li>
            <li><a href="<?php echo base_url() . 'index.php/admin/clients/summary/'. (isset($client_id)?$client_id:''); ?>">Jobs</a></li>
            <li><a href="<?php echo base_url() . 'index.php/admin/jobs/singleView/' . (isset($project_id)?$project_id:''); ?>">View</a></li>
            <li class="active"><a onclick="return false;" href="#">Upload Files</a></li>
          </ol>


        </section>

        <!-- Main content -->
        <section class="content">
          
          <!-- Your Page Content Here -->
           <div class="row">
            <!-- left column -->
            
              <div class="col-md-12">

                  <article class="widget">

                      <header class="widget__header">
                        <div class="widget__title">
                          <i class="fa fa-cloud-upload"></i><h3>Upload Files</h3>
                        </div>
                      </header>

                      <div class="widget__content filled pad20">
                        
                          
                            <form class="form-horizontal" accept-charset="utf-8" method="post" action="<?php echo base_url().  'index.php/admin/files/fileUpload'; ?>" id="upload" >
                              <div id="drop">
                                  Drop here

                                  <a>Browse</a>
                                  <input type="hidden" name="project_id" value="<?php echo isset($project_id)?$project_id:'';?>">
                                  <input type="file" name="files" multiple />
                              </div>

                              <ul>
                                  <!-- The file uploads will be shown here -->
                              </ul>

                              <br><br>
                              <p style="font-size:20px; font-weight:600; border-top: 1px solid #CCC; margin-top:10px; margin-bottom:15px;" ></p>
                              <div class="form-group">

                                  <div class="col-lg-12">
                                      <div class="pull-right">
                                          <a href="<?php echo base_url().  'index.php/admin/jobs/singleView/'. (isset($project_id)?$project_id:''); ?>"><button type="button" class="btn green"><i class="fa fa-check"></i> Done</button></a>

                                      </div>

                                  </div>
                              </div>

                          </form>
                          

                      </div>

                  </article>


              </div>



          </div>

        </section><!-- /.content -->
      </div><!-- /.content-wrapper -->


<?php $this->load->view('include/footer.php');?>

<script src="res/plugins/knob/jquery.knob.js"></script>

<!-- jQuery File Upload Dependencies -->
<script src="res/plugins/jQueryUI/jquery.ui.widget.js"></script>


<!-- The Iframe Transport is required for browsers without support for XHR file uploads -->
<script src="res/plugins/fileupload/jquery.iframe-transport.js"></script>
<!-- The basic File Upload plugin -->
<script src="res/plugins/fileupload/jquery.fileupload.js"></script>

<!-- <script src="res/plugins/fileupload/script.js"></script> -->

<script type="text/javascript">
  

$(function(){

    var ul = $('#upload ul');

    $('#drop a').click(function(){
        // Simulate a click on the file input button
        // to show the file browser dialog
        $(this).parent().find('input').click();
    });

    // Initialize the jQuery File Upload plugin
    $('#upload').fileupload({

        // This element will accept file drag/drop uploading
        dropZone: $('#drop'),

        // This function is called when a file is added to the queue;
        // either via the browse button, or via drag/drop:
        add: function (e, data) {

            var tpl = $('<li class="working"><input type="text" class="dial" value="0"  data-skin="tron" data-width="48" data-height="48"'+
                ' data-fgColor="#1CA59E" data-readOnly="1" data-displayprevious="true" data-thickness=".2" /><p></p><span></span></li>');

            // Append the file name and file size
            tpl.find('p').text(data.files[0].name)
                         .append('<i>' + formatFileSize(data.files[0].size) + '</i>');

            // Add the HTML to the UL element
            data.context = tpl.appendTo(ul);

            // Initialize the knob plugin
            tpl.find('input.dial').knob();

            // Listen for clicks on the cancel icon
            tpl.find('span').click(function(){

                if(tpl.hasClass('working')){
                    jqXHR.abort();
                }

                tpl.fadeOut(function(){
                    tpl.remove();
                });

            });

            // Automatically upload the file once it is added to the queue
            var jqXHR = data.submit();
        },

        progress: function(e, data){

            // Calculate the completion percentage of the upload
            var progress = parseInt(data.loaded / data.total * 100, 10);

            // Update the hidden input field and trigger a change
            // so that the jQuery knob plugin knows to update the dial
            data.context.find('input.dial').val(progress).change();

            if(progress == 100){
                data.context.removeClass('working');
            }
        },
        done: function(e, data){
            var result =  $.parseJSON( data.result);
                        
            if(result.error.trim().length > 0 )
            {
                
                // there is an error
                data.context.find('input.dial').parent().parent().append('<p style="color:#FF0000; left:250px;overflow:visible;font-weight:normal;font-size:11px;width:auto;">' + result.error  +  '</p>' );

            }
            else
            {
                
                data.context.find('input.dial').parent().parent().append('<input type="text" onblur="updateDescription(this)" style="margin-left:250px;overflow:visible;font-weight:normal;width:auto;display:inline;" class="form-control" id="phototitle" class="photo_title" placeholder="file description" data-fileid="' + result.file_id + '"/>' );
            }


        },
        fail:function(e, data){
            // Something has gone wrong!
            data.context.addClass('error');
        }

    });


    // Prevent the default action when a file is dropped on the window
    $(document).on('drop dragover', function (e) {
        e.preventDefault();
    });

    // Helper function that formats the file sizes
    function formatFileSize(bytes) {
        if (typeof bytes !== 'number') {
            return '';
        }

        if (bytes >= 1000000000) {
            return (bytes / 1000000000).toFixed(2) + ' GB';
        }

        if (bytes >= 1000000) {
            return (bytes / 1000000).toFixed(2) + ' MB';
        }

        return (bytes / 1000).toFixed(2) + ' KB';
    }

});



function updateDescription(myCaption)
{
    if($(myCaption).val().length > 0){
       
       var upCap = new updateCaption();
       upCap.file_id = $(myCaption).data('fileid');
       upCap.caption =  $(myCaption).val() ;
       upCap.update();
    }
        
}


function updateCaption()
{
    var _url = "<?php echo base_url() . 'index.php/admin/files/updateTitle'  ; ?>";
    this.file_id;
    this.caption;

    this.update = function()
    {
        var _data = {
            'caption' : this.caption,
            'file_id': this.file_id
        };

        $.ajax({            
            url : _url,
            type: 'POST',
            dataType: 'json',
            data : _data,
            sucess: function(response){               
                // console.log(response);                 
            },
            error:function(response){                
               // console.log(response);
            }
            
        });
    }

}

</script>