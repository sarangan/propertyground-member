<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Templates extends CI_Controller {

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


    function add($id =0){

    	$this->load->model('template_model');

    	$data = array();

    	if(!empty($id))
    	{
    		$existing_data = $this->template_model->getDataById($id);

    		if($existing_data->num_rows() > 0)
    		{
    			$existing_row = $existing_data->row();
    			$data['id'] = $existing_row->id;
    			$data['subject'] = $existing_row->subject;
    			$data['body'] = $existing_row->body;
    			$data['type'] = $existing_row->type;
    		}
    		
    	}

    	if (isset($_POST['submit']))
		{
			$this->form_validation->set_rules("subject", 'subject','trim|required');
			$this->form_validation->set_rules("body", 'body','trim|required');
			$this->form_validation->set_rules("type", 'type','trim|required');
            
        	$data['errors']['subject']  = "Please enter the subject";
            $data['errors']['body']  = "Please enter the email body";
            $data['errors']['type']  = "Please select the type";

        	$id = $this->input->post('id');

        	if($this->form_validation->run() == TRUE){

        		$data_template = array(

						    			'subject' => $this->input->post('subject'),
                                        'body' => $this->input->post('body'),
                                        'default_body' => $this->input->post('body'),
                                        'type' => $this->input->post('type')
	    							);

        		if(!empty($id))
        		{        			
        			$this->template_model->updateData($data_template, $id);
        		}
        		else
        		{
        			$data['id']  = $this->template_model->insertData($data_template);
        		}
	    		

	    		$data['error_display'] =2;

        	}
        	else{

	    		$data['error_display'] =1;
	    	}

		}

        //notifications
        $data =  array_merge($data , $this->notification->__getNotifications($this->user_id) );

    	$this->load->view('add_template', $data);

    }

     function view(){

    	$this->load->model('template_model');

		$data["results"] = $this->template_model->getData();

        //notifications
        $data =  array_merge($data , $this->notification->__getNotifications($this->user_id) );
        
		$this->load->view('list_templates', $data);
    }


    function delete(){

		$this->load->model('template_model');

		$this->form_validation->set_rules("id", 'id','trim|required');

		if ($this->form_validation->run() == TRUE){

    	 	$inventory_id = $this->input->post('id');

			$data_inventory = array(
					    			'status' => 2
    							);
    		
    		$this->template_model->updateData($data_inventory, $inventory_id);

		}

		redirect('admin/templates/view');

    }



}