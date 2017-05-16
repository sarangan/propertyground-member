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

		if ($this->ion_auth->get_users_groups($this->user_id )->row()->id != 1) 
		{
			 redirect('welcome/index/');
		}

    }


    public function send()
    {
    	$this->load->model('message_model');
    	$this->load->model('project_model');
    	$this->load->model('client_user_link_model');
    	$this->load->model('user_model');

    	$data = array();


			$this->form_validation->set_rules("message", 'message','trim|required');
			$this->form_validation->set_rules("project_id", 'project_id','trim|required');
			


			if ($this->form_validation->run() == TRUE){

				$sender_id = $this->input->post('sender_id');

				if(!empty($sender_id))
				{
					$data_project = array(

						    			'message' => $this->input->post('message') ,
						    			'project_id' => $this->input->post('project_id') ,
						    			'sender_id' => $sender_id,
						    			'receiver_id' => $this->user_id,
						    			'message' => $this->input->post('message') ,
						    			'status' => 1
	    							);
				}
	    		else
	    		{
	    			//admin sending
	    			$data_project = array(

						    			'message' => $this->input->post('message') ,
						    			'project_id' => $this->input->post('project_id') ,
						    			'sender_id' => $this->user_id,
						    			'receiver_id' => $this->project_model->getProjectUser($this->input->post('project_id')),//$this->client_user_link_model->getFirstUser($this->input->post('client_id')) ,
						    			'message' => $this->input->post('message') ,
						    			'status' => 1
	    							);
	    		}
	    		

	    		$msg_id = $this->message_model->insertData($data_project);

	    		if(isset($msg_id))
	    		{

	    			$data = array( 'status' => 1 );

	    			if(empty($sender_id))
					{
						$data_project['client_id'] = $this->input->post('client_id');

						$user_details =  $this->user_model->getDataByUserId($data_project['receiver_id']);
						if($user_details->num_rows() > 0)
						{
							$user_detail = $user_details->row();

							$data_project['receiver_email'] = $user_detail->email; //$default_user->email;
							$data_project['job_user_name'] =  $user_detail->first_name . ' ' . $user_detail->last_name;
						}

						$this->__sendEmail($data_project);
					}

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
        $this->load->model('client_user_link_model');
		$this->load->model('client_model');
		$this->load->model('project_model');


        $email_vars = array();

        $email_vars['user_full_name'] =  $this->config->item('admin_name');
        $email_vars['company_name'] = $this->client_model->getCompanyName($data_mail['client_id'] );
        $email_vars['job_user_name'] =   $data_mail['job_user_name'];

        $email_vars['message'] = $data_mail['message'];

        $row_project_set = $this->project_model->getDataById($data_mail['project_id']);

		if($row_project_set->num_rows() > 0)
		{
			$row_project = 	$row_project_set->row();
        	$email_vars['address'] =  $row_project->address;

        }

        // this is admin view so updates will be send to clients
		// $default_user = $this->client_user_link_model->getDefaultUser($data_mail['client_id'] );
		// if(isset($default_user) )
		// {
		// 	$receiver_email = $default_user->email;
		// }
         $receiver_email = $data_mail['receiver_email'];

        $this->email_processor->process_email('NEWMSG', $email_vars, $receiver_email);

    }


}