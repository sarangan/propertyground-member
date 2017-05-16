      <!-- Main Footer -->
      <footer class="main-footer">
        <!-- To the right -->
        <div class="pull-right hidden-xs">
          Property marketing made Simple by Property Ground
        </div>
        <!-- Default to the left --> 
        <strong>Copyright &copy; 2015 PropertyGround.</strong> All rights reserved.
      </footer>

    </div><!-- ./wrapper -->

    <!-- REQUIRED JS SCRIPTS -->
    
    <!-- jQuery 2.1.3 -->
    <script src="res/plugins/jQuery/jQuery-2.1.3.min.js"></script>
    <!-- Bootstrap 3.3.2 JS -->
    <script src="res/bootstrap/js/bootstrap.min.js" type="text/javascript"></script>
    <!-- AdminLTE App -->
    <script src="res/dist/js/app.min.js" type="text/javascript"></script>


     <!-- bootstrap time picker -->
    <script src="res/plugins/timepicker/bootstrap-timepicker.min.js" type="text/javascript"></script>
    <!-- SlimScroll 1.3.0 -->
    <script src="res/plugins/slimScroll/jquery.slimscroll.min.js" type="text/javascript"></script>

     <!-- bootstrap time picker -->
    <script src="res/plugins/datepicker/bootstrap-datepicker.js" type="text/javascript"></script>


    <script src="res/plugins/calendar/moment-2.2.1.js"></script>

    <script src="res/plugins/jquery.scrollTo/jquery.scrollTo.js"></script>


    <script type="text/javascript" src="res/plugins/timeagojs/moment.min.js"></script>
    <script type="text/javascript" src="res/plugins/timeagojs/livestamp.min.js"></script>


    <script type="text/javascript" src="res/plugins/filedownload/jquery.fileDownload.js"></script>

   

     
      <script src="res/plugins/datatables/jquery.dataTables.js" type="text/javascript"></script>

      <!--script src="res/plugins/datatables/dataTables.bootstrap.js" type="text/javascript"></script-->
    <!-- Optionally, you can add Slimscroll and FastClick plugins. 
          Both of these plugins are recommended to enhance the 
          user experience -->

      <script type="text/javascript" src="res/plugins/bootstrap-fileupload/bootstrap-fileupload.js"></script>

      <script type="text/javascript" src="res/plugins/timeagojs/moment.min.js"></script>
      <script type="text/javascript" src="res/plugins/timeagojs/livestamp.min.js"></script>


<script>
    $(function ()
    {
        $('.notifications-menu').on('click', function(event){
            //event.preventDefault();

               var _self = $(this);
              console.log('ssds');
              var url = "<?php echo base_url().  'index.php/notification/updateAlerts'; ?>";
              // var data = {
              //     'userkey' : ''
              // };

              $.ajax({
                  url: url,
                  type: 'POST',
                  dataType: 'json',
                  //data:  data,
                  success: function(output_string){ 
                      objStatus = output_string.status;
                      if(objStatus == 1)
                      {
                         _self.find('.label').removeClass('label-danger');
                         _self.find('.label').html('');
                      }
                  },
                  error: function(output_string){ 
                      objStatus = output_string.status;
                  }
              });
        });
       

    });
</script>

<script src="//pmetrics.performancing.com/js" type="text/javascript"></script>
<script type="text/javascript">try{ clicky.init(22731); }catch(e){}</script>
<noscript><p><img alt="Performancing Metrics" width="1" height="1" src="//pmetrics.performancing.com/22731ns.gif" /></p></noscript>

  </body>
</html>