<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Test extends CI_Controller {

	private $user_id;

	public function __construct()
    {
        parent::__construct();
        // Your own constructor code

        $this->load->helper(array('form', 'url'));
        $this->load->library('form_validation');
        $this->load->library("pagination");
        $this->load->library('notification');
        $this->load->library('email_processor');
    }

    function index(){

    	$this->load->view('test');
    }

    function send(){

    	$receiver = $this->input->post('rev') ;


    	error_log($receiver);

    	//sending mail
                    $type = 'NEWJOB' ;
                     
                    $email_vars['company_name'] = 'testing company';
                    
                    $email_vars['services'] = 'Photos';
                    
                    
                    $email_vars['job_start_datetime'] = '12/12/11222 : 12:33SM';
                    $email_vars['key_collection_info'] =  "Appointment with vendor - Kevin O'Sullivan - 07831 500300";
                    $email_vars['address'] =  'Mellow Purgess Farm, Chivers Road, Stondon Massey, Brentwood, Essex CM15 OLL';

                    $receiver_email = $receiver;//'sarangan12@gmail.com';
                    $sender_email = 'info@propertyground.com';
                    $from = 'propertyground';
 
                    $this->email_processor->process_email($type, $email_vars, $receiver_email, $sender_email, $from);

                    $data['texts'] = 'sent';
                    $this->load->view('test', $data);

    }
}
