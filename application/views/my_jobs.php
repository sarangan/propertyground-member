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
             <i class="fa fa-home"></i> View Jobs
          </h1>
          <ol class="breadcrumb">
            <li><a href="<?php echo base_url(); ?>">Home</a></li>
            <li class="active"><a onclick="return false;" href="#">Jobs</a></li>
          </ol>
        </section>


        <!-- Main content -->
        <section class="content">
          
          <!-- Your Page Content Here -->
          <div class="row">
            <div class="col-lg-12">
                                  <div class="table-responsive" >
                                    <table class="table table-bordered" id="dataTables-example">
                                        <thead>
                                            <tr>
                                                <!-- <th>#</th> -->
                                                <th>Address</th>
                                               <!--  <th>Start Date & Time</th> -->
                                                <th>Status</th>
                                                <th>Download</th>
                                                <th>Invoice</th>
                                                <th><i class="fa fa-bars"></i></th>
                                            </tr>
                                        </thead>
                                        <tbody class="client-myjobs">

                                            <?php 

                                                if( ( isset($results) ) && ($results->num_rows() > 0 ) )
                                                {
                                                    //$i = 1;
                                                    $status = '';
                                                    $color_class ='';

                                                    foreach ($results->result() as $war) {

                                                      switch ($war->status) {
                                                        case 1:
                                                          $status = 'Job Requested';
                                                          $color_class ='label label-success';
                                                          break;
                                                        case 2:
                                                          if(  ($war->paid != 1)  && ($war->publish == 1) && ( $war->days_frm_billed >= 1) ){

                                                             $status = 'Ready to download - Unpaid';
                                                             $color_class ='label label-danger';
                                                          }
                                                          elseif( ($war->paid == 1)  && ($war->publish == 1) )
                                                          {
                                                              $status = 'Ready to download - Paid';
                                                             $color_class ='label label-primary';
                                                          }
                                                          else
                                                          {
                                                             $status = 'Ready to download';
                                                              $color_class ='label label-primary';
                                                          }
                                                         
                                                         
                                                          break;
                                                        case 3:
                                                          $status = 'Job canceled';
                                                          $color_class ='label label-warning';
                                                          break;
                                                        case 4:
                                                          $status = 'Job completed';
                                                          $color_class ='label label-warning';
                                                          break;
                                                        case 5:
                                                          $status = 'Appointment Confirmed';
                                                          $color_class ='label label-primary';
                                                          break;
                                                        
                                                        default:
                                                          # code...
                                                          break;
                                                      }
                                                        
                                                        # code...  <td>'. $war->job_start_date . ' ' .  $war->job_start_time .'</td>
                                                      // <span class="tools-icons edit-ico">                       
                                                                            // <a href="'. base_url() . 'index.php/jobs/view/'.  $war->id .'"><i class="fa fa-folder-open"></i></a>
                                                                        // </span>

                                                        echo '                                                                    
                                                                    <td><a  class="table-link" href="'. base_url() . 'index.php/jobs/view/'.  $war->id .'/#tab-msg">'. $war->address .'</a></td>
                                                                   
                                                                    <td><span class="' . $color_class. '">'. $status . '</span></td>';

                                                        if($war->total_files > 0){
                                                        echo'
                                                                    <td>
                                                                        <span class="tools-icons edit-ico">                       
                                                                            <a  data-toggle="tooltip" data-original-title="Download" href="'. base_url() . 'index.php/jobs/view/'.  $war->id .'/#tab-file"><i class="fa fa-cloud-download"></i> Download files</a>
                                                                        </span>
                                                                    </td>
                                                                        ';
                                                        }
                                                        else
                                                        {
                                                          echo '<td>Pending</td>';
                                                        }

                                                        if($war->publish == 1){
  
                                                                    echo '<td><span class="tools-icons edit-ico">                       
                                                                            <a  data-toggle="tooltip" data-original-title="Download invoice" class="pdfDownloadPromise" href="#" data-fileid="'. $war->id .'"><i class="fa fa-file-text"></i> Invoice</a>
                                                                        </span></td>';
                                                        }
                                                        else{
                                                          echo '<td>Pending</td>';
                                                        }
                                                        
                                                        if($war->status <= 1){
                                                            echo'
                                                                    <td style="width:10%;">
                                                                        <span class="tools-icons edit-ico">                             
                                                                            <a  data-toggle="tooltip" data-original-title="Edit" href="'. base_url() . 'index.php/jobs/add/'.  $war->id .'"><i class="fa fa-pencil"></i></a>
                                                                        </span> 

                                                                    </td>
                                                                </tr>';
                                                        }             
                                                        else
                                                        {
                                                          echo '<td>Locked</td>
                                                          </tr>';
                                                        }

                                                        //$i +=1;
                                                    }
                                                }

                                                

                                            ?>
                                            
                                        </tbody>
                                    </table>
                                </div>
                                <!-- /.table-responsive -->
            </div>
          </div>

        </section><!-- /.content -->
      </div><!-- /.content-wrapper -->


<?php $this->load->view('include/footer.php');?>

<script type="text/javascript">
  $(function () {

    $(document).on("click", "a.pdfDownloadPromise", function () {
                       
       var url = '<?php echo base_url()."index.php/invoice/pdfDownload"; ?>';

       console.log($(this).data('fileid') );

       var params = {
            fileid :  $(this).data('fileid')
        };

       $.fileDownload(url, {

            successCallback: function () {
              //console.log('ok');
               //showballoon('glyphicon glyphicon-ok-circle', '', " File is ready to download!.." , 'success');
            },
            failCallback: function (responseHtml, url) {
                // console.log('not ok');
                //showballoon('glyphicon glyphicon-exclamation-sign', '', " File not found!..", 'warning' ); 
            },
            httpMethod: "POST",
            data: params
        });
     
        return false; //this is critical to stop the click event which will trigger a normal file download
    });

    $('#dataTables-example').dataTable({
            "bProcessing": true,
                
                "bFilter": true,
                "bLengthChange": true,
                "bInfo": true,
    });


  });
</script>