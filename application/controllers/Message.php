<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Message extends CI_Controller {

	private $user_id;

	public function __construct()
    {
        parent::__construct();
        // Your own constructor code

        $this->load->helper(array('form', 'url'));
        $this->load->library('form_validation');
        $this->load->library("pagination");

        $this->load->library('ion_auth');

		if (!$this->ion_auth->logged_in())
		{
			redirect('auth/login');
		}

		$user = $this->ion_auth->user()->row();
		$this->user_id  =  $user->id;

    }


    public function send()
    {
    	$this->load->model('message_model');

    	$data = array();


			$this->form_validation->set_rules("message", 'message','trim|required');
			$this->form_validation->set_rules("project_id", 'project_id','trim|required');
			


			if ($this->form_validation->run() == TRUE){

	    		
	    		$data_project = array(

						    			'message' => $this->input->post('message') ,
						    			'project_id' => $this->input->post('project_id') ,
						    			'sender_id' => $this->user_id,
						    			'receiver_id' => $this->config->item('admin_id'),
						    			'message' => $this->input->post('message') ,
						    			'status' => 1
	    							);

	    		$msg_id = $this->message_model->insertData($data_project);

	    		if(isset($msg_id))
	    		{

	    			$data = array( 'status' => 1 );
					$this->__sendEmail($data_project);
	    		}
	    		else
	    		{

	    			$data = array( 'status' => 2 );
	    		}


	    	}
	    	else
	    	{
	    		$data = array( 'status' => 2 );
	    	}

		echo json_encode($data);

    }

    function __sendEmail($data_mail)
    {
        $this->load->library('email_processor');
		$this->load->model('project_model');

        $email_vars = array();
               
        $email_vars['message'] = $data_mail['message'];
        $email_vars['company_name'] = $this->config->item('admin_name');

        $user = $this->ion_auth->user()->row();
       	$email_vars['user_full_name'] = $user->first_name . ' ' .  $user->last_name;

        $row_project_set = $this->project_model->getDataById($data_mail['project_id']);

		if($row_project_set->num_rows() > 0)
		{
			$row_project = 	$row_project_set->row();
        	$email_vars['address'] =  $row_project->address;       	

        }

		$receiver_email = $this->config->item('admin_email');


        $this->email_processor->process_email('NEWMSG', $email_vars, $receiver_email);

    }


}