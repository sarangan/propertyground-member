<?php

if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

/**
 * class for perfoming all Paypal ipn related functions
 *
 */
class Paypalipn extends CI_Controller
{

    /**
     * constructor method
     */
    public function __construct()
    {
        error_log('callimg');

        parent::__construct();

        $this->load->helper('toolbox');
        $this->load->model('payment_model');
        $this->load->library("notification");
        $this->load->library('email_processor');
    }

    /**
     * process paypal IPN calls
     *
     */
    function index()
    {
        error_log('Paymet staring' . date('Y-m-d H:i:s') );

        //flow control
        $next = true;

        //Set to false when live & true when testing
        define("USE_SANDBOX", false);

        /** ---------------------------------------------------------------------------
         *  STEP 1
         *  Read initial Paypal post data. This is initiation call made by Paypal
         * ----------------------------------------------------------------------------*/
        if ($next) {
            $raw_post_data = file_get_contents('php://input');
            $raw_post_array = explode('&', $raw_post_data);

            //save each post item to an array
            $paypal = array();
            foreach ($raw_post_array as $keyval) {
                error_log($keyval);
                $keyval = explode('=', $keyval);
                if (count($keyval) == 2) $paypal[$keyval[0]] = urldecode($keyval[1]);
            }

            //log that ipn has been initiated
           // error_log(string_print_r($paypal) );
            error_log('post received' . date('Y-m-d H:i:s') );
        }

        /** ---------------------------------------------------------------------------
         *  STEP 2
         *  Read the post from PayPal system and add 'cmd=_notify-validate'
         * ----------------------------------------------------------------------------*/
        if ($next) {
            $our_reponse = 'cmd=_notify-validate';
            if (function_exists('get_magic_quotes_gpc')) {
                $get_magic_quotes_exists = true;
            }
            foreach ($paypal as $key => $value) {
                if ($get_magic_quotes_exists == true && get_magic_quotes_gpc() == 1) {
                    $value = urlencode(stripslashes($value));
                } else {
                    $value = urlencode($value);
                }
                $our_reponse .= "&$key=$value";
            }
        }

        /** ------------------------------------------------------------------------------
         *  STEP 3
         *  Post Paypals origianl data (received in step 1: $our_response) back to Paypal
         * -------------------------------------------------------------------------------*/
        if ($next) {

            //live or sandbox
            if (USE_SANDBOX == true) {
                $paypal_url = "https://www.sandbox.paypal.com/cgi-bin/webscr";
            } else {
                $paypal_url = "https://www.paypal.com/cgi-bin/webscr";
            }

            $ch = curl_init($paypal_url);
            curl_setopt($ch, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_1);
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $our_reponse);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 1);
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 2);
            curl_setopt($ch, CURLOPT_FORBID_REUSE, 1);
            curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 60);
            curl_setopt($ch, CURLOPT_HTTPHEADER, array('Connection: Close'));
            $paypal_response = curl_exec($ch);

            //check if ok
            if (curl_errno($ch) != 0) {

                //full header response
                $header_response = curl_getinfo($ch, CURLINFO_HEADER_OUT);

                //log this error & header repsonse
               // error_log( $header_response);
                error_log('error header response' . date('Y-m-d H:i:s') );
                //halt
                $next = false;

            }

            //close curl
            curl_close($ch);
        }

        /** ---------------------------------------------------------------------------
         *  STEP 4
         *  Inspect Paypals reponse to our post back. Response is alway one word
         *  VERIFIED or INVALID
         * ----------------------------------------------------------------------------*/
        // Split response headers and payload, a better way for strcmp
        if ($next) {
            $tokens = explode("\r\n\r\n", trim($paypal_response));
            $paypal_response = trim(end($tokens));

            //transaction verified OK
            if (strcmp($paypal_response, "VERIFIED") == 0) {

                //get the payments details we need and save to array
                $payment['payments_transaction_id'] = $_POST['txn_id'];
                $payment['payments_invoice_id'] = $_POST['item_number'];
                $payment['payments_invoice_unique_id'] = $_POST['item_name'];
                $payment['payments_amount'] = $_POST['payment_gross'];
                $payment['payments_currency_code'] = $_POST['mc_currency'];
                $payment['payments_transaction_status'] = strtolower($_POST['payment_status']);
                $payment['payments_notes'] = '';
                $payment['payments_by_user_id'] = $_POST['custom'];

                //log this for debugging
               //error_log(string_print_r($_POST) );
                error_log('posting again' . date('Y-m-d H:i:s') );

                //now check what paypal had to say about the transaction itself
                if (in_array($payment['payments_transaction_status'], array(
                    'completed',
                    'in-progress',
                    'pending'))) {
                    //flow control for (step 5)
                    $update_database = true;
                }
            }

            //actaul IPN failed. NB 'failed transactions' should be checked above, not here
            if (strcmp($paypal_response, "INVALID") == 0) {
                //log this for debugging
                    
               // error_log(string_print_r($_POST) );

                error_log('Paypal invalid' . date('Y-m-d H:i:s') );

                //halt
                $next = false;
            }
        }

        /** ---------------------------------------------------------------------------
         *  STEP 5
         *  Update our database
         * ----------------------------------------------------------------------------*/
        if ($next && $update_database) {

            //get invoice id
            error_log('paypal database entry success ' . date('Y-m-d H:i:s') );

            $data_payment_history = array(
                'invoice_id' => $_POST['item_number'],
                'amount' =>  $_POST['mc_gross'],
                'payer_email' =>  $_POST['payer_email'],
                'first_name' =>  $_POST['first_name'],
                'payer_id' =>  $_POST['payer_id'],
                'txn_id' =>  $_POST['txn_id'],
                'payment_date' =>  $_POST['payment_date'],
                'notes' =>  $_POST['custom'],
                'ipn_track_id' =>  $_POST['ipn_track_id'],
                'payment_status' =>  $_POST['payment_status'],
                'mc_currency' =>  $_POST['mc_currency']
            );

            $payment_id = $this->payment_model->insertData($data_payment_history);

            $this->load->model('invoice_model');
            $client_id = $this->invoice_model->getClientIdByInvID( $_POST['item_number'] );

            $this->notification->__sendNotification($payment_id, 'PAYMENT_RECEIVED',  $client_id , $this->config->item('admin_id') );
            $email_vars = array();

            $this->load->model('client_model');

            $email_vars['company_name'] = $this->client_model->getCompanyName($client_id);


            $invoice_details = $this->invoice_model->getDataById($_POST['item_number']);
            if($invoice_details->num_rows() > 0)
            {
                $invoice_data = $invoice_details->row();

                $project_id =  $invoice_data->project_id; 
                $this->load->model('project_model');

                $row_project_set = $this->project_model->getDataById($project_id);
                if($row_project_set->num_rows() > 0)
                {
                    $row_project =  $row_project_set->row();
                    $email_vars['address'] =  $row_project->address;

                   

                }

            }


          
            
            $email_vars['user_full_name'] =  $this->config->item('admin_name');
            $email_vars['invoice_id'] =  $invoice_id;


            $this->email_processor->process_email('PAYREC', $email_vars, $this->config->item('admin_email') );
        }

        /** ---------------------------------------------------------------------------
         *  STEP 6
         *  Send out emails & track event & update invoice with new payment (refresh)
         * ----------------------------------------------------------------------------*/
        if ($next && $next_email) {

            //---email admins--------------------------
            error_log('sending mail' . date('Y-m-d H:i:s') );
        }

        //debugging
        
    }

}

/* End of file paypalipn.php */
/* Location: ./application/controllers/api/paypalipn.php */
