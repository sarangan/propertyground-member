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
            <i class="fa fa-users"></i> Users
          </h1>
          <ol class="breadcrumb">
           <li><a href="<?php echo base_url(); ?>">Home</a></li>   
            <li class="active"><a onclick="return false;" href="#">Users</a></li>
            <li><a href="<?php echo base_url() . 'index.php/admin/users/add'; ?>">Add New</a></li>
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
                                                <th>#</th>
                                                <th>First Name</th>
                                                <th>Last Name</th>
                                                <th>Email</th>
                                                <th>Username</th>
                                                <th>Company</th>
                                                <th>Contact</th>
                                                <th><i class="fa fa-bars"></i></th>
                                            </tr>
                                        </thead>
                                        <tbody>

                                            <?php 

                                                if( ( isset($results) ) && ($results->num_rows() > 0 ) )
                                                {
                                                    $i = 1;
                                                    foreach ($results->result() as $war) {                                                       
                                                        # code...
                                                        echo '
                                                                    <td>'. $i .'</td>
                                                                    <td>'. $war->first_name .'</td>
                                                                    <td>'. $war->last_name .'</td>
                                                                    <td>'. $war->email .'</td>
                                                                    <td>'. $war->username .'</td>
                                                                    <td>'. $war->company_name .'</td>
                                                                     <td>'. $war->phone .'</td>
                                                                    <td>
                                                                       <span class="tools-icons edit-ico">                             
                                                                            <a  data-toggle="tooltip" data-original-title="Edit" href="'. base_url() . 'index.php/admin/users/add/'.  $war->id .'"><i class="fa fa-pencil"></i></a>
                                                                        </span>

                                                                        <span class="tools-icons delete-ico">                       
                                                                            <a href="#" data-toggle="modal" data-target="#confirm-submit" data-id="'. $war->id .'"><i class="fa fa-times-circle"></i></a>
                                                                        </span>
                                                                    </td>
                                                                </tr>';

                                                        $i +=1;
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

<form accept-charset="utf-8" method="POST" action="<?php echo base_url() . 'index.php/admin/users/delete'; ?>">
<div class="modal fade" id="confirm-submit" tabindex="-1" role="dialog" aria-labelledby="basicModal" aria-hidden="true">
      <div class="modal-dialog model-sm">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            <h4 class="modal-title" id="myModalLabel">Delete</h4>
          </div>
          <div class="modal-body">
          <h5 class="model-text"> Are you sure do you want to delete this record?</h5>
          <input type="hidden" name="user_id" id="user_id">
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
        modal.find('#user_id').val(recipient);
      });




  });
</script>