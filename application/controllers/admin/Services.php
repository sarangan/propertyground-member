<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Services extends CI_Controller {

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

    	$this->load->model('services_model');

    	$data = array();

    	if(!empty($id))
    	{
    		$existing_data = $this->services_model->getDataById($id);

    		if($existing_data->num_rows() > 0)
    		{
    			$existing_row = $existing_data->row();
    			$data['service_id'] = $existing_row->service_id;
    			$data['service_name'] = $existing_row->service;
    			$data['amount_1_3'] = $existing_row->amount_1_3;
                $data['amount_4_6'] = $existing_row->amount_4_6;
                $data['amount_6_above'] = $existing_row->amount_6_above;
    		}
    		

    	}

    	if (isset($_POST['submit']))
		{
			$this->form_validation->set_rules("service_name", 'service_name','trim|required');
			$this->form_validation->set_rules("amount_1_3", 'amount_1_3','trim|required|numeric');
            $this->form_validation->set_rules("amount_4_6", 'amount_4_6','trim|required|numeric');


        	$data['errors']['service_name']  = "Please enter the service name";
        	$data['errors']['amount']  = "Please enter the amount of service";

        	$service_id = $this->input->post('service_id');


        	if ($this->form_validation->run() == TRUE){


        		$data_client = array(

						    			'service' => $this->input->post('service_name') ,
						    			'amount_1_3' => $this->input->post('amount_1_3'),
                                        'amount_4_6' => $this->input->post('amount_4_6'),
                                        'amount_6_above' => $this->input->post('amount_6_above')
	    							);

        		if(!empty($service_id))
        		{        			
        			$this->services_model->updateData($data_client, $service_id);
        		}
        		else
        		{
        			$data['service_id']  = $this->services_model->insertData($data_client);
        		}
	    		

	    		$data['error_display'] =2;

        	}
        	else{

	    		$data['error_display'] =1;
	    	}

		}


        //notifications
        $data =  array_merge($data , $this->notification->__getNotifications($this->user_id) );

    	$this->load->view('add_services', $data);

    }


    function view(){
    	$this->load->model('services_model');

		$data["results"] = $this->services_model->getData();

        //notifications
        $data =  array_merge($data , $this->notification->__getNotifications($this->user_id) );
        
		$this->load->view('list_services', $data);
    }


    function delete(){

    		$this->load->model('services_model');

			$this->form_validation->set_rules("service_id", 'service_id','trim|required');

			if ($this->form_validation->run() == TRUE){

        	 	$service_id = $this->input->post('service_id');

				$data_client = array(
						    			'status' => 2
	    							);
        		
        		$this->services_model->updateData($data_client, $service_id);

			}

		redirect('admin/services/view');

    }

}