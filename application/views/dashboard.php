  <?php
  defined('BASEPATH') OR exit('No direct script access allowed');
  ?>
  <?php $this->load->view('include/head.php');?>
  <?php $this->load->view('include/sidebar_admin.php');?>
  <!-- Morris charts -->
  <link href="res/plugins/morris/morris.css" rel="stylesheet" type="text/css" />
  <link href="res/plugins/angular-chart/angular-chart.css" rel="stylesheet" type="text/css" />

  <script type="text/javascript" src="res/plugins/angularjs/angular.min.js"></script>
  <script type="text/javascript" src="res/plugins/angular-chart/Chart.min.js"></script>
  <!-- <script type="text/javascript" src="res/plugins/angularjs/Chart.Core.js"></script>
  <script type="text/javascript" src="res/plugins/angularjs/Chart.Line.js"></script> -->
  <script type="text/javascript" src="res/plugins/angular-chart/angular-chart.min.js"></script>

  <script type="text/javascript" src="res/plugins/angularjs/admin-dashboard.js"></script>



  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper" data-ng-app="admindashboard">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Dashboard
        <small>Welcome to Propertyground</small>
      </h1>
      <ol class="breadcrumb">
        <li class="active"><a href="#" onclick="return false;"><i class="fa fa-dashboard"></i>Home</a></li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">

      <!-- Your Page Content Here -->


            <div class="row">

              <div class="col-md-6">

               <article class="widget">

                <header class="widget__header">
                  <div class="widget__title">
                    <i class="fa fa-cube"></i><h3>Upcoming jobs</h3>
                  </div>
                </header>

                <div class="widget__content filled pad20">


                  <div class="table-responsive" >
                    <table class="table table-bordered" id="dataTables-example">
                      <thead>
                        <tr>
                          <th>Address</th>
                          <th>Start Date & Time</th>
                          <th>Services</th>
                          <th><i class="fa fa-bars"></i></th>
                        </tr>
                      </thead>
                      <tbody>

                        <?php 

                        if( ( isset($results) ) && ($results->num_rows() > 0 ) )
                        {

                          foreach ($results->result() as $war) {

                            echo '
                                <td><a class="table-link" href="'. base_url() . 'index.php/admin/jobs/singleView/'.  $war->id .'">'. $war->address .'</a></td>
                                <td>'. $war->job_start_date . ' ' .  $war->job_start_time .'</td>
                                <td>'. $war->my_service .'</td>                                                                 
                                <td>
                                  <span class="tools-icons edit-ico">                             
                                    <a data-toggle="tooltip" data-original-title="Edit" href="'. base_url() . 'index.php/admin/jobs/add/'.  $war->id .'"><i class="fa fa-pencil"></i></a>
                                  </span>
                                  <span class="tools-icons edit-ico">                       
                                    <a data-toggle="tooltip" data-original-title="View"  href="'. base_url() . 'index.php/admin/jobs/singleView/'.  $war->id .'"><i class="fa fa-folder-open"></i></a>
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

            </article>

          </div>


          <div class="col-md-6">

           <article class="widget">

            <header class="widget__header">
              <div class="widget__title">
              <i class="fa fa-thumb-tack"></i><h3>Invoices to be sent...</h3>
              </div>
            </header>

            <div class="widget__content filled pad20">


              <div class="table-responsive">
                
                <table class="table table-bordered" id="dataTables-example_2">
                  <thead>
                    <tr>
                      <th>Address</th>
                      <th>Services</th>
                      <th>Company</th>
                      <th><i class="fa fa-bars"></i></th>
                    </tr>
                  </thead>
                  <tbody>

                <?php 

                    if( ( isset($results_noinvoice) ) && ($results_noinvoice->num_rows() > 0 ) )
                    {
                      foreach ($results_noinvoice->result() as $war) {
                        echo '
                        <tr>
                        <td><a class="table-link" href="'. base_url() . 'index.php/admin/jobs/singleView/'.  $war->id .'">'. $war->address .'</a></td>
                        <td>'. $war->my_service .'</td>
                        <td>'. $war->company_name .'</td>                                                                 
                        <td>
                          
                           <span class="tools-icons edit-ico">                       
                             <a  data-toggle="tooltip" data-original-title="Edit" href="'. base_url() . 'index.php/admin/jobs/view/'.  $war->id .'"><i class="fa fa-pencil"></i></a>
                          </span>

                          <span class="tools-icons edit-ico">                       
                            <a  data-toggle="tooltip" data-original-title="View" href="'. base_url() . 'index.php/admin/jobs/singleView/'.  $war->id .'"><i class="fa fa-folder-open"></i></a>
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

        </article>

      </div>




    </div>



      <div class="row">

        <div class="col-md-6">

         <article class="widget">

          <header class="widget__header">
            <div class="widget__title">
              <i class="fa fa-calendar"></i><h3>Summary</h3>
            </div>
          </header>

          <div class="widget__content filled pad20">

            <!-- LINE CHART -->
            <div class="box box-info">
              <div class="box-header">
                <h3 class="box-title">Jobs</h3>
              </div>
              <div class="box-body chart-responsive">
                              <!-- <div class="chart" id="jobs-line-chart" style="height: 300px;" data-ng-controller="LineChartCtrl as line">
                                <linechart id="line-example" data-options="chart_options"></linechart>
                              </div> -->

                              <div class="charts" id="jobs-line-chart" data-ng-controller="LineCtrl" >

                                  <canvas id="line" class="chart chart-line" data="data" labels="labels" legend="true" series="series" click="onClick">
                                  </canvas> 


                              </div>

                         </div><!-- /.box-body -->
                       </div><!-- /.box -->


                     </div>

                   </article>

                 </div><!-- /.col (RIGHT) -->



                 <div class="col-md-6">


                  <article class="widget">

                    <header class="widget__header">
                      <div class="widget__title">
                        <i class="fa fa-pie-chart"></i><h3>Jobs summary</h3>
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
                "bFilter": false,
                "bLengthChange": false,
                "bInfo": false,
                 "iDisplayLength": 5,
                 "bPaginate": true,
                  
    });

    $('#dataTables-example_2').dataTable({
                "bProcessing": true,                
                "bFilter": false,
                "bLengthChange": false,
                "bInfo": false,
                  "iDisplayLength": 5,
                  "bPaginate": true,
                  
    });


    //DONUT CHART
        var donut = new Morris.Donut({
          element: 'sales-chart',
          resize: true,
          colors: ["#00a65a", "#3c8dbc", "#f56954", "#09430d", "#FF00FF"],
          data: [
           <?php echo isset($processing)? '{label: "Job requested", value:'. $processing .'},': '' ;?>
           <?php echo isset($finished)? '{label: "Ready to download", value:'. $finished .'},': '' ;?>
           <?php echo isset($canceled)? '{label: "Job canceled", value:'. $canceled .'},': '' ;?>
           <?php echo isset($completed)? '{label: "Job completed", value:'. $completed .'},': '' ;?>
           <?php echo isset($accepted)? '{label: "Appointment confirmed", value:'. $accepted .'},': '' ;?>
          ],
          hideHover: 'auto'
        });


  });
</script>