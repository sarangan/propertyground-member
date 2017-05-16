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
            <i class="fa fa-home"></i> Company Summary
          </h1>
          <ol class="breadcrumb">
            <li><a href="<?php echo base_url(); ?>">Home</a></li>
            <li><a href="<?php echo base_url() . 'index.php/admin/clients/view'; ?>">Companies</a></li>
            <li><a href="<?php echo base_url() . 'index.php/admin/jobs/view'; ?>">All Jobs</a></li>
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
                                                <th>Start Date & Time</th>
                                                <th>Status</th>
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
                                                          $status = 'Processing';
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
                                                          $status = 'Canceled';
                                                          $color_class ='label label-warning';
                                                          break;
                                                         case 4:
                                                          $status = 'Completed';
                                                          $color_class ='label label-warning';
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
                                                                    <td><a  class="table-link" href="'. base_url() . 'index.php/admin/jobs/singleView/'.  $war->id .'/#tab-msg">'. $war->address .'</a></td>
                                                                    <td>'. $war->job_start_date . ' ' .  $war->job_start_time .'</td>                                                                   
                                                                    <td><span class="' . $color_class. '">'. $status . '</span></td>
                                                                    <td style="width:10%;">
                                                                         <span class="tools-icons edit-ico">                       
                                                                            <a  data-toggle="tooltip" data-original-title="View" href="'. base_url() . 'index.php/admin/jobs/singleView/'.  $war->id .'"><i class="fa fa-folder-open"></i></a>
                                                                        </span>

                                                                    </td>
                                                                </tr>';

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

          <div class="row">
            
               <div class="col-md-6">


                  <article class="widget">

                    <header class="widget__header">
                      <div class="widget__title">
                        <i class="fa fa-pie-chart"></i><h3>Summary</h3>
                      </div>
                    </header>

                    <div class="widget__content filled pad20">

                      <div class="row">

                        <div class="col-md-12 text-center btn__showcase2">


                          <div class="widget__content filled">
                              <div class="box-body chart-responsive">
                                <div class="chart" id="sales-chart" style="height: 300px; position: relative;"></div>
                              </div><!-- /.box-body -->
                            

                          </div>


                      </div>

                    </div>

                  </div>

                </article>

              </div>

          </div>

        </section><!-- /.content -->
      </div><!-- /.content-wrapper -->

<?php $this->load->view('include/footer.php');?>
<!-- Morris.js charts -->
<script src="http://cdnjs.cloudflare.com/ajax/libs/raphael/2.1.0/raphael-min.js"></script>
<script src="res/plugins/morris/morris.min.js" type="text/javascript"></script>

<script type="text/javascript">
  $(function () {


    $('#dataTables-example').dataTable({
            "bProcessing": true,
                
                "bFilter": true,
                "bLengthChange": true,
                "bInfo": true,
        });



    //DONUT CHART
        var donut = new Morris.Donut({
          element: 'sales-chart',
          resize: true,
          colors: ["#00a65a", "#3c8dbc", "#f56954", "#09430d"],
          data: [
           <?php echo isset($processing)? '{label: "Processing", value:'. $processing .'},': '' ;?>
           <?php echo isset($finished)? '{label: "Ready to download", value:'. $finished .'},': '' ;?>
           <?php echo isset($canceled)? '{label: "Canceled", value:'. $canceled .'},': '' ;?>
           <?php echo isset($completed)? '{label: "Completed", value:'. $completed .'},': '' ;?>
          ],
          hideHover: 'auto'
        });

  });
</script>