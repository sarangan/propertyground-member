<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Inventory extends CI_Controller {

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

    	$this->load->model('inventory_model');

    	$data = array();

    	if(!empty($id))
    	{
    		$existing_data = $this->inventory_model->getDataById($id);

    		if($existing_data->num_rows() > 0)
    		{
    			$existing_row = $existing_data->row();
    			$data['id'] = $existing_row->id;
    			$data['property_type'] = $existing_row->property_type;
    			$data['inventory_name'] = $existing_row->inventory_name;
                $data['No_of_Bedrooms'] = $existing_row->No_of_Bedrooms;
                $data['unfurnished_amount'] = $existing_row->unfurnished_amount;
                $data['furnished_amount'] = $existing_row->furnished_amount;
    		}
    		

    	}

    	if (isset($_POST['submit']))
		{
			$this->form_validation->set_rules("inventory_name", 'inventory_name','trim|required');
            $this->form_validation->set_rules("property_type", 'property_type','trim|required');
			$this->form_validation->set_rules("No_of_Bedrooms", 'No_of_Bedrooms','trim|required|numeric');
            $this->form_validation->set_rules("unfurnished_amount", 'unfurnished_amount','trim|required|numeric');
            $this->form_validation->set_rules("furnished_amount", 'furnished_amount','trim|required|numeric');
            
        	$data['errors']['inventory_name']  = "Please enter the name of inventory Example:- Bed 1";
            $data['errors']['property_type']  = "Please enter the property type";
            $data['errors']['No_of_Bedrooms']  = "Please enter the number of bedrooms";
        	$data['errors']['unfurnished_amount']  = "Please enter the unfurnished amount";
            $data['errors']['furnished_amount']  = "Please enter the furnished amount";

        	$id = $this->input->post('id');


        	if ($this->form_validation->run() == TRUE){


        		$data_inventory = array(

						    			'inventory_name' => $this->input->post('inventory_name') ,
						    			'property_type' => $this->input->post('property_type'),
                                        'No_of_Bedrooms' => $this->input->post('No_of_Bedrooms'),
                                        'unfurnished_amount' => $this->input->post('unfurnished_amount'),
                                        'furnished_amount' => $this->input->post('furnished_amount')
	    							);

        		if(!empty($id))
        		{        			
        			$this->inventory_model->updateData($data_inventory, $id);
        		}
        		else
        		{
        			$data['id']  = $this->inventory_model->insertData($data_inventory);
        		}
	    		

	    		$data['error_display'] =2;

        	}
        	else{

	    		$data['error_display'] =1;
	    	}

		}


        //notifications
        $data =  array_merge($data , $this->notification->__getNotifications($this->user_id) );

    	$this->load->view('add_inventory', $data);

    }


    function view(){
    	$this->load->model('inventory_model');

		$data["results"] = $this->inventory_model->getData();

        //notifications
        $data =  array_merge($data , $this->notification->__getNotifications($this->user_id) );
        
		$this->load->view('list_inventory', $data);
    }


    function delete(){

    		$this->load->model('inventory_model');

			$this->form_validation->set_rules("id", 'id','trim|required');

			if ($this->form_validation->run() == TRUE){

        	 	$inventory_id = $this->input->post('id');

				$data_inventory = array(
						    			'status' => 2
	    							);
        		
        		$this->inventory_model->updateData($data_inventory, $inventory_id);

			}

		redirect('admin/inventory/view');

    }

}