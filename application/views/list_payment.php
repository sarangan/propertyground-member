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
            <i class="fa fa-rss"></i> Payment History
          </h1>
          <ol class="breadcrumb">
            <li><a href="<?php echo base_url(); ?>">Home</a></li>
            <li><a href="<?php echo base_url() . 'index.php/admin/jobs/pendingPayments'; ?>">Pending</a></li>
            <li><a href="<?php echo base_url() . 'index.php/admin/payment/view'; ?>">Recent</a></li>
            <li class="active"><a onclick="return false;" href="#">History</a></li>
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
                                                <th>Address</th>
                                                <th>Invoice ID</th>
                                                <th>Services</th>
                                                <th>Company</th>
                                                <th>Amount</th>
                                            </tr>
                                        </thead>
                                        <tbody>

                                            <?php 

                                                if( ( isset($results) ) && ($results->num_rows() > 0 ) )
                                                {
                                                    //$i = 1;
                                                    foreach ($results->result() as $war) {

                                                        $myclass = '';
                                                        
                                                        # code...
                                                        echo '
                                                                    <td><a class="table-link" href="'. base_url() . 'index.php/admin/jobs/singleView/'.  $war->project_id .'">'. $war->address .'</a></td>
                                                                    <td>'. $war->invoice_id .'</td>
                                                                    <td>'. $war->my_service .'</td>
                                                                    <td>'. $war->company .'</td>
                                                                    <td>'. $war->amount .'</td>
                                                                    
                                                                </tr>';

                                                       // $i +=1;
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


    $('#dataTables-example').dataTable({
            "bProcessing": true,
                
                "bFilter": true,
                "bLengthChange": true,
                "bInfo": true,
                
    });

  });
</script>