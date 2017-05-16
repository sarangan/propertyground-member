<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<?php $this->load->view('include/head.php');?>
<?php $this->load->view('include/sidebar_admin.php');?>

  <script type="text/javascript" src="res/plugins/angularjs/angular.min.js"></script>
  <script type="text/javascript" src="res/plugins/angular-chart/Chart.min.js"></script>
  <!-- <script type="text/javascript" src="res/plugins/angularjs/Chart.Core.js"></script>
  <script type="text/javascript" src="res/plugins/angularjs/Chart.Line.js"></script> -->
  <script type="text/javascript" src="res/plugins/angular-chart/angular-chart.min.js"></script>

  <script type="text/javascript" src="res/plugins/angularjs/admin-dashboard.js"></script>

  
      <!-- Content Wrapper. Contains page content -->
      <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">

          <h1>
            <i class="fa fa-money"></i> Pending payments
          </h1>
          <ol class="breadcrumb">
            <li><a href="<?php echo base_url(); ?>">Home</a></li>
            <li class="active"><a onclick="return false;" href="#">Pending</a></li>
            <li><a href="<?php echo base_url() . 'index.php/admin/payment/history'; ?>">History</a></li>
          </ol>

        </section>

        <!-- Main content -->
        <section class="content"  data-ng-app="admindashboard">
          
          <!-- Your Page Content Here -->
          <div class="row">
            <div class="col-lg-12">
                                  <div class="table-responsive" ng-controller ="sendRem as sendCrtl">
                
                                      <span>{{sendCrtl.statustxt}}</span>
                                      <table class="table table-bordered" id="dataTables-example_2">
                                        <thead>
                                          <tr>
                                            <th>Address</th>
                                            <th>Invoice publish</th>
                                            <th>Amount</th>
                                            <th><i class="fa fa-bars"></i></th>
                                          </tr>
                                        </thead>
                                        <tbody>

                                      <?php 

                                          if( ( isset($results_unpaid) ) && ($results_unpaid->num_rows() > 0 ) )
                                          {
                                            foreach ($results_unpaid->result() as $war) {
                                              echo '
                                              <tr>
                                              <td><a class="table-link" href="'. base_url() . 'index.php/admin/jobs/singleView/'.  $war->id .'">'. $war->address .'</a></td>
                                              <td>'. $war->date_billed .'</td>
                                              <td>'. $war->balance_amount .'</td>                                                                 
                                              <td>
                                                <span class="tools-icons edit-ico">                       
                                                  <a  data-toggle="tooltip" data-original-title="View" href="'. base_url() . 'index.php/admin/jobs/singleView/'.  $war->id .'"><i class="fa fa-folder-open"></i></a>
                                                </span>

                                                 <span class="tools-icons edit-ico">                       
                                                  <span  data-toggle="tooltip" data-original-title="Re-send invoice" ng-click="sendCrtl.send('.$war->id .')" style="cursor:pointer;"><i class="fa fa-envelope"></i></span>
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

        </section><!-- /.content -->
      </div><!-- /.content-wrapper -->

<?php $this->load->view('include/footer.php');?>

<script type="text/javascript">
  $(function () {

       $('#dataTables-example_2').dataTable({
                "bProcessing": true,
                "bFilter": true,
                "bLengthChange": true,
                "bInfo": true                  
        });   

  });
</script>