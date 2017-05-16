<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Packages extends CI_Controller {

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
    	$this->load->model('packages_model');
        $this->load->model('package_services_model');

    	$data = array();

    	if(!empty($id))
    	{
    		$existing_data = $this->packages_model->getDataById($id);

    		if($existing_data->num_rows() > 0)
    		{
    			$existing_row = $existing_data->row();
    			$data['package_id'] = $existing_row->id;
    			$data['package_name'] = $existing_row->name;
    			$data['amount_1_3'] = $existing_row->amount_1_3;
                $data['amount_4_6'] = $existing_row->amount_4_6;
                $data['amount_6_above'] = $existing_row->amount_6_above;
    		}

            $row_sevices = $this->package_services_model->getDataByPackageId($id);

            $existing_service = array();

            if($row_sevices->num_rows() > 0)
            {
                foreach ($row_sevices->result() as $row_service) {
                    $existing_service[] = $row_service->service_id;
                }
            }

            $data['service'] =  $existing_service;
    		

    	}

        //get the services
        $services_data = $this->services_model->getData();

        if($services_data->num_rows() > 0)
        {
            $service_array = array();

            foreach($services_data->result() as $row){

                
                $service_array[]  = array ('service_id'=> $row->service_id ,
                                             'service' => $row->service) ;
            }

            $data['services'] = $service_array;
            
        }



    	if (isset($_POST['submit']))
		{
			$this->form_validation->set_rules("package_name", 'package_name','trim|required');
			$this->form_validation->set_rules("amount_1_3", 'amount_1_3','trim|required|numeric');
            $this->form_validation->set_rules("amount_4_6", 'amount_4_6','trim|required|numeric');
            $this->form_validation->set_rules("service[]", 'service[]','trim|required');

            $service = $this->input->post('service[]');


        	$data['errors']['package_name']  = "Please enter the package name";
        	$data['errors']['amount']  = "Please enter the amount of package";

            if( empty($service) )
            {
                
                $data['errors']['option_error']= 'Please select at least one service...';

                $data['error_display'] =1;
            }


        	$package_id = $this->input->post('package_id');


        	if ($this->form_validation->run() == TRUE){


        		$data_client = array(

						    			'name' => $this->input->post('package_name') ,
						    			'amount_1_3' => $this->input->post('amount_1_3'),
                                        'amount_4_6' => $this->input->post('amount_4_6'), 
                                        'amount_6_above' => $this->input->post('amount_6_above')
	    							);

        		if(!empty($package_id))
        		{        			
        			$this->packages_model->updateData($data_client, $package_id);

                    $this->package_services_model->process_services( $package_id, $service);
        		}
        		else
        		{
        			$package_id = $this->packages_model->insertData($data_client);
                    $data['package_id']  = $package_id;

                    if(!empty($package_id))
                    {
                       
                        $data_services = array();

                        $N = count($service);
                                        
                        for($i=0; $i < $N; $i++)
                        {
                            $ss_data = array(
                                'package_id' =>$package_id ,
                                'service_id' => $service[$i]
                                );

                            $data_services[]  = $ss_data;

                        }

                        $this->package_services_model->insertBulk($data_services);

                    }
        		}
	    		

	    		$data['error_display'] =2;

        	}
        	else{

	    		$data['error_display'] =1;
	    	}

		}



        //notifications
        $data =  array_merge($data , $this->notification->__getNotifications($this->user_id) );

    	$this->load->view('add_packages', $data);

    }


    function view(){

    	$this->load->model('packages_model');
        $data["results"] = $this->packages_model->getDataAdminView();

        //notifications
        $data =  array_merge($data , $this->notification->__getNotifications($this->user_id) );
        
        $this->load->view('list_packages', $data);
    }


    function delete(){

    		$this->load->model('packages_model');

			$this->form_validation->set_rules("package_id", 'package_id','trim|required');

			if ($this->form_validation->run() == TRUE){

        	 	$package_id = $this->input->post('package_id');

				$data_client = array(
						    			'status' => 2
	    							);
        		
        		$this->packages_model->updateData($data_client, $package_id);

			}

		redirect('admin/packages/view');

    }


}