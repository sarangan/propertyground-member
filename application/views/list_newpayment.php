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
            <i class="fa fa-ticket"></i> Recent Payment History
          </h1>
          <ol class="breadcrumb">
            <li><a href="<?php echo base_url(); ?>">Home</a></li>
            <li class="active"><a onclick="return false;" href="#">Recent</a></li>
            <li><a href="<?php echo base_url() . 'index.php/admin/payment/history'; ?>">History</a></li>
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
                                                <th><i class="fa fa-bars"></i></th>
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
                                                                    <td>
                                                                        <span class="tools-icons edit-ico">                             
                                                                            <a data-toggle="tooltip" data-original-title="Accept the payment" href="'. base_url() . 'index.php/admin/payment/accept/'. $war->id . '/' . $war->invoice_id .'"><i class="fa fa-thumbs-o-up"></i></a>
                                                                        </span>

                                                                        <span class="tools-icons delete-ico">                       
                                                                            <a data-toggle="tooltip" data-original-title="Reject the payment" href="'. base_url() . 'index.php/admin/payment/reject/'. $war->id . '/' . $war->invoice_id .'"><i class="fa fa-thumbs-o-down"></i></a>
                                                                        </span>
                                                                    </td>
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

<form accept-charset="utf-8" method="POST" action="<?php echo base_url() . 'index.php/admin/templates/delete'; ?>">
<div class="modal fade" id="confirm-submit" tabindex="-1" role="dialog" aria-labelledby="basicModal" aria-hidden="true">
      <div class="modal-dialog model-sm">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            <h4 class="modal-title" id="myModalLabel">Delete</h4>
          </div>
          <div class="modal-body">
          <h5 class="model-text"> Are you sure do you want to delete this record?</h5>
          <input type="hidden" name="id" id="id">
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

<script type="text/javascript">
  $(function () {


    $('#dataTables-example').dataTable({
            "bProcessing": true,
                
                "bFilter": true,
                "bLengthChange": true,
                "bInfo": true,
                
    });


    $('#confirm-submit').on('show.bs.modal', function (event) {
        var button = $(event.relatedTarget) // Button that triggered the modal
        var recipient = button.data('id') // Extract info from data-* attributes
        // If necessary, you could initiate an AJAX request here (and then do the updating in a callback).
        // Update the modal's content. We'll use jQuery here, but you could use a data binding library or other methods instead.
        var modal = $(this)
        modal.find('#id').val(recipient);
      });




  });
</script>