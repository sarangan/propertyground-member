<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<?php $this->load->view('include/head.php');?>
<script type="text/javascript" src="res/plugins/angularjs/angular.min.js"></script>
<script type="text/javascript" src="res/plugins/angularjs/dashboard.js"></script>
<?php $this->load->view('include/sidebar.php');?>


      <!-- Content Wrapper. Contains page content -->
      <div class="content-wrapper" data-ng-app="dashboard">
        <!-- Content Header (Page header) -->
        <section class="content-header">
          <h1>
            Dashboard
            <small>Welcome to Propertyground</small>
          </h1>
          <ol class="breadcrumb">
            <li class="active"><a onclick="return false;" href="#"><i class="fa fa-dashboard"></i> Home</a></li>
          </ol>
        </section>

        <!-- Main content -->
        <section class="content">
          
          <!-- Your Page Content Here -->

          <div class="row" data-ng-controller="projectSummaryCtrl as psCtrl">
            
            <div class="col-md-4 col-sm-6 col-xs-12">
              <div class="info-box">
                <span class="info-box-icon bg-aqua"><i class="fa fa-gears"></i></span>
                <div class="info-box-content">
                  <span class="info-box-text">Total Jobs</span>
                  <span class="info-box-number">{{psCtrl.projectsummary.total}}<small> jobs</small></span>
                </div><!-- /.info-box-content -->
              </div><!-- /.info-box -->
            </div><!-- /.col -->


            <div class="col-md-4 col-sm-6 col-xs-12">
              <div class="info-box">
                <span class="info-box-icon bg-aqua"><i class="fa fa-gears"></i></span>
                <div class="info-box-content">
                  <span class="info-box-text">Currently Processing</span>
                  <span class="info-box-number">{{psCtrl.projectsummary.processing}}<small> jobs</small></span>
                </div><!-- /.info-box-content -->
              </div><!-- /.info-box -->
            </div><!-- /.col -->


             <div class="col-md-4 col-sm-6 col-xs-12">
              <div class="info-box">
                <span class="info-box-icon bg-aqua"><i class="fa fa-file-pdf-o"></i></span>
                <div class="info-box-content">
                  <span class="info-box-text">Services Price List</span>
                  <span class="info-box-number"><a href="res/pdf/services_price_list.pdf" target="_blank">Download</a></span>
                </div><!-- /.info-box-content -->
              </div><!-- /.info-box -->
            </div><!-- /.col -->
            


          </div>
          
          <div class="row">
            
            <div class="col-md-7">

                <article class="widget widget__form" data-ng-controller="newJobCtrl as newJob">
                    <header class="widget__header">
                      <div class="widget__title">
                        <i class="fa fa-cube"></i><h3>Add new job {{newJob.job.statustxt}}</h3>
                      </div>
                    </header>

                    <div class="widget__content" style="padding-top: 0px;">
                    <form name="frmNewJob" novalidate ng-submit="frmNewJob.$valid && newJob.save(newJob.job)">
                      <input type="text" name="address" id="address" placeholder="Address" data-ng-model="newJob.job.address" required>
                       <textarea name="description" id="description" rows="9" placeholder="Description" data-ng-model="newJob.job.description"></textarea>
                      <button type="submit">Submit</button>
                    </form>
                  </div>
                </article>


            </div>

            <div class="col-md-5">


                  <article class="widget" style="margin-right: 0px;">

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