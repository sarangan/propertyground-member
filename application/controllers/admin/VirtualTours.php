<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class VirtualTours extends CI_Controller {

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

    	$this->load->model('virtualtours_model');

    	$data = array();

    	if(!empty($id))
    	{
    		$existing_data = $this->virtualtours_model->getDataById($id);

    		if($existing_data->num_rows() > 0)
    		{
    			$existing_row = $existing_data->row();
    			$data['id'] = $existing_row->id;
    			$data['name'] = $existing_row->name;
    			$data['No_of_Bedrooms'] = $existing_row->No_of_Bedrooms;
                $data['amount'] = $existing_row->amount;
    		}
    		

    	}

    	if (isset($_POST['submit']))
		{
			// $this->form_validation->set_rules("name", 'name','trim|required');
			$this->form_validation->set_rules("No_of_Bedrooms", 'No_of_Bedrooms','trim|required|numeric');
            $this->form_validation->set_rules("amount", 'amount','trim|required|numeric');
            
        	//$data['errors']['name']  = "Please enter the name of virtual tour Example:- Bed 1";
            $data['errors']['No_of_Bedrooms']  = "Please enter the number of bedrooms";
        	$data['errors']['amount']  = "Please enter the amount";

        	$id = $this->input->post('id');


        	if ($this->form_validation->run() == TRUE){


        		$data_inventory = array(

						    			'name' => $this->input->post('name') ,
                                        'No_of_Bedrooms' => $this->input->post('No_of_Bedrooms'),
                                        'amount' => $this->input->post('amount')
	    							);

        		if(!empty($id))
        		{        			
        			$this->virtualtours_model->updateData($data_inventory, $id);
        		}
        		else
        		{
        			$data['id']  = $this->virtualtours_model->insertData($data_inventory);
        		}
	    		

	    		$data['error_display'] =2;

        	}
        	else{

	    		$data['error_display'] =1;
	    	}

		}


        //notifications
        $data =  array_merge($data , $this->notification->__getNotifications($this->user_id) );

    	$this->load->view('add_virtual_tour', $data);

    }


    function view(){
    	$this->load->model('virtualtours_model');

		$data["results"] = $this->virtualtours_model->getData();

        //notifications
        $data =  array_merge($data , $this->notification->__getNotifications($this->user_id) );
        
		$this->load->view('list_virtualtours', $data);
    }


    function delete(){

    		$this->load->model('virtualtours_model');

			$this->form_validation->set_rules("id", 'id','trim|required');

			if ($this->form_validation->run() == TRUE){

        	 	$inventory_id = $this->input->post('id');

				$data_inventory = array(
						    			'status' => 2
	    							);
        		
        		$this->virtualtours_model->updateData($data_inventory, $inventory_id);

			}

		redirect('admin/virtualtours/view');

    }

}