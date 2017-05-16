<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
<!--define our base-->
<base href="<?php echo base_url(); ?>">
<!--define our base-->
<!-- #GOOGLE FONT -->
<link rel="stylesheet" href="res/dist/css/invoice.print.css">
</head>
<body class="invoice-body">
<div class="invoice-main-container">
<div>
<table cellpadding="0" cellspacing="0" class="invoice-table-grid" width="100%">
    <thead>
      <tr valign="top">
        <th width="33%"><div class="invoice-logo">
          <div align="left">
          <img src="res/images/logo.png" alt="Freelane dashboard"></div>
        </div></th>
        <th width="33%">&nbsp;</th>
        <th width="34%"></th>
        </tr>
      <tr>
        <td valign="top">&nbsp;</td>
        <td valign="top">&nbsp;</td>
        <td valign="top"><div class="invoice-title">
          <div align="right">Invoice: <?php echo isset($invoice_id)?$invoice_id:'' ?></div>
        </div></td>
      </tr>
      <tr>
        <td valign="top"><div class="invoice-date-issued">Invoice Date: <?php echo isset($date_billed)?$date_billed:'' ?></div></td>
        <td valign="top">&nbsp;</td>
        <td valign="top"><div align="right" class="invoice-date-due"></div></td>
      </tr>
    </thead>
    <tbody>
      <tr>
        <td valign="top">&nbsp;</td>
        <td valign="top">&nbsp;</td>
        <td valign="top">&nbsp;</td>
      </tr>
      <tr>
        <td valign="top" style="padding:0px;"><table cellpadding="0" cellspacing="0" class="invoice-table">
    <thead>
      <tr>
        <th valign="middle">To: <?php echo isset($client_name)?$client_name:'' ?></th>
        </tr>
    </thead>
    <tbody>
      <tr>
        <td valign="top"><div class="table-row-div"><?php echo isset($client_address)?$client_address:'' ?></div>
            <div class="table-row-div"><!--[invoice.clients_city;noerr;comm]--></div>
          <div class="table-row-div"><!--[invoice.clients_state;noerr;comm]--> <!--[invoice.clients_zipcode;noerr;comm]--></div>
          <div class="table-row-div"><!--[invoice.clients_country;noerr;comm]--></div>
                    <div class="table-row-div"><?php //echo isset($client_contact)?$client_contact:'' ?></div>          </td>
    </tbody>
  </table></td>
        <td valign="top">&nbsp;</td>
        <td valign="top"><table class="invoice-table">
    <thead>
      <tr>
        <th>Property Ground</th>
        </tr>
    </thead>
    <tbody>
      <tr>
        <td valign="top"><div class="table-row-div">Oasis Business Centre</div>
            <div class="table-row-div">468 Church Lane</div>
          <div class="table-row-div">Kingsbury, London</div>
          <div class="table-row-div">NW9 8UA</div>
          <div class="table-row-div">Phone: 020 8200 2342</div>          
        </td>
      </tr>
    </tbody>
  </table></td>
      </tr>
      <tr>
        <td valign="top" bgcolor="#FFFFFF">&nbsp;</td>
        <td valign="top" bgcolor="#FFFFFF">&nbsp;</td>
        <td valign="top" bgcolor="#FFFFFF">&nbsp;</td>
      </tr>
      <tr>
        <td valign="top" bgcolor="#FFFFFF">&nbsp;</td>
        <td valign="top" bgcolor="#FFFFFF">&nbsp;</td>
        <td valign="top" bgcolor="#FFFFFF">&nbsp;</td>
      </tr>
      <tr>
        <td colspan="3" bgcolor="#FFFFFF">
        <div class="invoice-main-section">        
  <table class="invoice-table">
    <thead>
      <tr>
        <th width="33%" valign="middle">Address</th>
        <th width="54%" valign="middle">Services</th>
        <th width="13%" valign="middle" class="invoice-amount"><div align="right">Total</div></th>
      </tr>
    </thead>
    <tbody>


      <tr>
        <td valign="middle"><div align="left">
         <?php echo isset($address)?$address:''; ?>
        </div></td>
        <td valign="middle"><div align="left">
         <?php echo isset($services_str)?$services_str:'' ?>
        </div></td>
        <td valign="middle"><div align="right"><?php echo isset($total_amount_services)?  ( number_format((float)$total_amount_services, 2, '.', '') ) :'' ?></div></td>
      </tr>


      <?php

          $actual_amount = isset($total_amount_services)?$total_amount_services:0;


      if(isset($additional_amt_result))
      {
        if($additional_amt_result->num_rows() > 0)
        {
          foreach ($additional_amt_result->result() as $add_amt_row) {

            $actual_amount += $add_amt_row->amount;
            echo"<tr>
                    <td valign='middle'><div align='left'>
                        </div>
                    </td>
                     <td valign='middle'><div align='left'>". $add_amt_row->name .  "</div></td>
                    <td valign='middle'><div align='right'>". ( number_format((float)$add_amt_row->amount, 2, '.', '') ) . "</div></td>
                  </tr>
                ";

          }
        }
      }

  ?>


    </tbody>
  </table>
 </div>        </td>
        </tr>
      <tr>
        <td bgcolor="#FFFFFF">&nbsp;</td>
        <td bgcolor="#FFFFFF">&nbsp;</td>
        <td bgcolor="#FFFFFF">&nbsp;</td>
      </tr>
      <tr>
        <td bgcolor="#FFFFFF">&nbsp;</td>
        <td bgcolor="#FFFFFF">&nbsp;</td>
        <td bgcolor="#FFFFFF">&nbsp;</td>
      </tr>
      <tr>
        <td colspan="2" valign="top" bgcolor="#FFFFFF">
        </td>
        <td valign="top" bgcolor="#FFFFFF">
    <table cellpadding="0" cellspacing="0" class="invoice-table">
    
    <tbody>

      <tr>
        <td width="46%">
          <div align="left">
            Sub Total
          </div></td>
        <td width="54%"><div align="right"> <?php echo isset($actual_amount)? ( number_format((float)$actual_amount, 2, '.', '') ) : 0 ?> </div></td>
      </tr>
      <?php
      if(isset($discount))
        if($discount > 0){
      ?>
            <tr>
              <td width="46%">
                <div align="left">
                  Discount
                </div></td>
              <td width="54%"><div align="right"> <?php echo isset($discount)?( number_format((float)$discount, 2, '.', '') ) :0 ?> </div></td>
            </tr>
      <?php } ?>

      <?php
      if(isset($advance_payment))
        if($advance_payment > 0){
      ?>
        <tr>
          <td width="46%">
            <div align="left">
              Advance Payment
            </div></td>
          <td width="54%"><div align="right"> <?php echo isset($advance_payment)?( number_format((float)$advance_payment, 2, '.', '') ) :0 ?> </div></td>
        </tr>
      <?php } ?>

      <tr>
        <td><div align="left">
          <!--tax--> </div></td>
        <td><div align="right"><!--tax--></div></td>
      </tr>

      <tr>
        <td><div align="left">
          Total </div></td>
        <td class="invoice-total">
        <div>
          <div align="right">£ <?php echo isset($balance_amount)?( number_format((float)$balance_amount, 2, '.', '') ) :'' ?></div>
        </div>
        </td>
        </tr>
    </tbody>
  </table></td>
      </tr>
      <tr>
        <td bgcolor="#FFFFFF">&nbsp;</td>
        <td bgcolor="#FFFFFF">&nbsp;</td>
        <td bgcolor="#FFFFFF">&nbsp;</td>
      </tr>
      <tr>
        <td bgcolor="#FFFFFF">&nbsp;</td>
        <td bgcolor="#FFFFFF">&nbsp;</td>
        <td bgcolor="#FFFFFF">&nbsp;</td>
        </tr>
    </tbody>
  </table>
</div>


<div>
<!-- <p>Comments or Special Instructions:</p> -->
<p>Payment Details:
            <p style="color:#ed0707;">Terms : 14 days</p>
</p>
            <p>Direct bank transfers can be made (quoting invoice number) to:<br/>
             Property Ground Limited
              <br/>
              Sort code: 20-29-41 Account No: 20717835<br/>
            </p>
            <p>
              You can pay your invoice by posting us a cheque or send it to:<br/>
              Property Ground Limited<br/>
              Oasis Business Centre<br/>
              468 Church Lane Kingsbury<br/>
              London<br/>
              NW9 8UA
            </p>
</div>

</div>

 <div id="footer">
     <p class="page"><p style="text-align:center;">TP: 020 8200 2342 Email: info@propertyground.com Web: www.propertyground.com<br/>
Property Ground Limited | Company Reg no. 9181186</p>
</p>
   </div>

</body>
</html>