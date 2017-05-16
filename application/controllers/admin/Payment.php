<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Payment extends CI_Controller {

	private $user_id;

	public function __construct()
    {
        parent::__construct();
        // Your own constructor code

        $this->load->helper(array('form', 'url'));
        $this->load->library('form_validation');
        $this->load->library("pagination");
        $this->load->library('notification');

        $this->load->library('ion_auth');

		if (!$this->ion_auth->logged_in())
		{
			redirect('auth/login');
		}
		

		$user = $this->ion_auth->user()->row();
		$this->user_id  =  $user->id;

		if ($this->ion_auth->get_users_groups($this->user_id )->row()->id != 1) 
		{
			 redirect('welcome/index/');
		}

    }


    function view(){

    	$this->load->model('payment_model');

		$data["results"] = $this->payment_model->getNewData();

        //notifications
        $data =  array_merge($data , $this->notification->__getNotifications($this->user_id) );
        
		$this->load->view('list_newpayment', $data);
    }

    function history(){

        $this->load->model('payment_model');

        $data["results"] = $this->payment_model->getOldData();

        //notifications
        $data =  array_merge($data , $this->notification->__getNotifications($this->user_id) );
        
        $this->load->view('list_payment', $data);
    }


    function accept($id=0, $invoice_id=0){

        $this->load->model('payment_model');
        $this->load->model('invoice_model');
        $this->load->model('project_model');

		if(!empty($id))
        {
            $data = array('status' => 2); // 2 is accept 
            $this->payment_model->updateData($data , $id);

            if(!empty($invoice_id))
            {
                $data_invo = array('paid' => 1 );
                $this->invoice_model->updateData($data_invo, $invoice_id);

                $invoice_details = $this->invoice_model->getDataById($invoice_id);
               if($invoice_details->num_rows() > 0)
               {
                     $invoice_data = $invoice_details->row();

                    //send notifications                        
                    $this->notification->__sendNotification($invoice_data->project_id, 'PAYMENT_ACCEPT',  $this->config->item('admin_id'),  $this->project_model->getProjectUser($invoice_data->project_id) , 1 );
                    $this->__sendEmail('PAYACC', $invoice_data->project_id, $invoice_id);
               }    
                
            }
        }

		redirect('admin/payment/view');

    }

    function reject($id=0, $invoice_id=0){

        $this->load->model('payment_model');
        $this->load->model('invoice_model');
        $this->load->model('project_model');

        if(!empty($id))
        {
            $data = array('status' => 3); // 3 is reject 
            $this->payment_model->updateData($data , $id);

            if(!empty($invoice_id))
            {
               $invoice_details = $this->invoice_model->getDataById($invoice_id);
               if($invoice_details->num_rows() > 0)
               {
                     $invoice_data = $invoice_details->row();

                    //send notifications                        
                    $this->notification->__sendNotification($invoice_data->project_id, 'PAYMENT_REJECT',  $this->config->item('admin_id'),   $this->project_model->getProjectUser($invoice_data->project_id)  , 1 );
                     $this->__sendEmail('PAYREJ', $invoice_data->project_id, $invoice_id);
               }

                
            }
        }

        redirect('admin/payment/view');

    }


    function __sendEmail($type, $project_id, $invoice_id)
    {
        $this->load->library('email_processor');
        $this->load->model('project_services_model');
        $this->load->model('project_model');
        $this->load->model('client_user_link_model');
        $this->load->model('client_model');
        $this->load->model('user_model');

        $email_vars = array();
        $receiver_email = '';

        $row_project_set = $this->project_model->getDataById($project_id);

        if($row_project_set->num_rows() > 0)
        {
            $row_project =  $row_project_set->row();
            //
            $email_vars['company_name'] = $this->client_model->getCompanyName($row_project->client_id);

            //error_log($email_vars['company_name'] );
          
            $email_vars['address'] =  $row_project->address;
            $email_vars['user_full_name'] =  $this->config->item('admin_name');
            $email_vars['invoice_id'] =  $invoice_id;
            
            // this is admin view so updates will be send to clients
            // $default_user = $this->client_user_link_model->getDefaultUser($row_project->client_id );
            // if(isset($default_user) )
            // {
            //     $receiver_email = $default_user->email;
            // }

            $user_details =  $this->user_model->getDataByUserId($row_project->link_user_id);
            if($user_details->num_rows() > 0)
            {
                $user_detail = $user_details->row();

                $receiver_email = $user_detail->email; //$default_user->email;
                $email_vars['job_user_name'] =  $user_detail->first_name . ' ' . $user_detail->last_name;
            }
            

        }
               
        $email_vars['admin_name'] = $this->config->item('admin_name');

        $sender_email = $this->config->item('invoice_email');
        $from = $this->config->item('website_name');

        $this->email_processor->process_email($type, $email_vars, $receiver_email, $sender_email, $from);

    }


}