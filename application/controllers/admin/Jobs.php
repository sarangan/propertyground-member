<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Jobs extends CI_Controller {

	private $user_id;

	/*
	* 1 = processing
	* 2 = finished
	* 3 = cancel
	*
	*/

	public function __construct()
    {
        parent::__construct();
        // Your own constructor code

        $this->load->helper(array('form', 'url'));
        $this->load->helper('common');
        $this->load->library('form_validation');
        $this->load->library("pagination");
        $this->load->library("notification");


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


    /*
	* Add new job
	*
	*/
	public function add($id = 0){

		//load model
		$this->load->model('services_model');
		$this->load->model('project_model');
		$this->load->model('project_services_model');
		$this->load->model('packages_model');
		$this->load->model('client_model');
		$this->load->model('user_model');
		// $this->load->model('inventory_model');
		

		$data= array();

		if(!empty($id))
    	{
    		$row_project_set = $this->project_model->getDataById($id);

    		if($row_project_set->num_rows() > 0)
    		{
    			$row_project = 	$row_project_set->row();    			

				$data['project_id'] =  $row_project->id;
				$data['address'] = $row_project->address;
				$data['request_date'] = $row_project->job_start_date;
				$data['request_time'] = $row_project->job_start_time;
				$data['key_collection'] = $row_project->key_collection_info;				
				$data['no_of_rooms'] = $row_project->no_of_rooms;
				$data['property_type'] = $row_project->property_type;
				$data['furnishing'] = $row_project->furnishing;
				$data['company'] = $row_project->client_id;
				$data['link_user_id'] = $row_project->link_user_id;

				//load all the users
				$data_users = $this->user_model->getDataByClient($data['company']);
				$data['users_data'] = $data_users;

				
    		}
    		

			$row_sevices = $this->project_services_model->getDataByProjectId($id);

			$existing_service = array();

			if($row_sevices->num_rows() > 0)
			{
				foreach ($row_sevices->result() as $row_service) {
					$existing_service[] = $row_service->service_id;
				}
			}

			$data['service'] =  $existing_service;

    	}
    	else{

    		//prevent angular js error ng-init 

    		//load all the users
			$data_users = $this->user_model->getDataByClient($this->input->post('company'));
			$data['users_data'] = $data_users;

			$data['company'] = $this->input->post('company');

    	}



		//get the clients
		$clients_data = $this->client_model->getData();
        $data['clients_data'] = $clients_data;

      

		//get the services
		$services_data = $this->services_model->getDataForJob();

		if($services_data->num_rows() > 0)
		{
			$service_array = array();

			foreach($services_data->result() as $row){

				
                $service_array[]  = array ('service_id'=> $row->service_id ,
                							 'service' => $row->service) ;
            }

            $data['services'] = $service_array;
            
		}

		//get packages
		$data['pacakges'] = $this->packages_model->getDataPackageView();
		
		//inventory
		//$data['inventory'] = $this->inventory_model->getData();


		if (isset($_POST['submit']))
		{
			
        	$this->form_validation->set_rules("address", 'address','trim|required');
        	$this->form_validation->set_rules("company", 'company','trim|required');
        	$this->form_validation->set_rules("link_user_id", 'link_user_id','trim|required');
        	$this->form_validation->set_rules("request_date", 'request_date','trim|required');
        	$this->form_validation->set_rules("no_of_rooms", 'no_of_rooms','trim|required');
        	// $this->form_validation->set_rules("key_collection", 'key_collection','');
        	$this->form_validation->set_rules("service[]", 'service[]','trim|required');

        	$service = $this->input->post('service[]');

        	$data['errors']['address']  = "Please enter the address";
        	$data['errors']['request_date']  = "Please seelct the jost start date";
        	$data['errors']['company']  = "Please select the company";
        	$data['errors']['link_user_id']  = "Please assign the user";
        	$data['errors']['no_of_rooms']  = "Please select number of rooms";
        	

        	if( empty($service) )
	    	{
	    		
	    		$data['errors']['option_error']= 'Please select at least one service...';

        		$data['error_display'] =1;
	    	}
	    	else
	    	{
	    		$property_type_chk = in_array(INVID, $service); //default iD for inventory is 10000
		    	if($property_type_chk)
		    	{
		    		// Inventory is clicked
		    		$this->form_validation->set_rules("property_type", 'property_type','trim|required'); 
		    		$data['errors']['property_type']  = "Please select the property type";

		    		$this->form_validation->set_rules("furnishing", 'furnishing','trim|required');
		    		$data['errors']['furnishing']  = "Please select the furnishing type";
		    	}
		    	
	    	}

	    	

	    	if ($this->form_validation->run() == TRUE){

	    		$date = new DateTime($this->input->post('request_date') );

	    		$data_project = array(

						    			'address' => $this->input->post('address') ,
						    			'description' => $this->input->post('description') ,
						    			'job_start_date' => $date->format('Y-m-d'),
						    			'job_start_time' => $this->input->post('request_time') ,
						    			'key_collection_info' => $this->input->post('key_collection') ,
						    			'no_of_rooms' => $this->input->post('no_of_rooms') ,
						    			'property_type' => $this->input->post('property_type'),
						    			'furnishing' => $this->input->post('furnishing'),
						    			'client_id' =>  $this->input->post('company'),
						    			'link_user_id' =>  $this->input->post('link_user_id')
	    							);

	    		$project_id = $this->input->post('project_id');

	    		if(!empty($project_id))
	    		{
	    			
	    			$this->project_model->updateData($data_project, $project_id);
	    			$this->project_services_model->process_services( $project_id, $service);
                    
                    //send notifications                        
                    $this->notification->__sendNotification($project_id, 'UPDATED_JOB',  $this->config->item('admin_id'),  $data_project['link_user_id'] , 1 );


                    //sending mail
                    //$this->__sendEmail('EDITJOB', $project_id); // TO DO
                    


	    		}
	    		else
	    		{
	    			
	    			$project_id = $this->project_model->insertData($data_project);
	    			
		    		if(!empty($project_id))
		    		{
		    			createFolder($project_id);
		    			$data_services = array();

		    			$N = count($service);
	    				     			
	    				for($i=0; $i < $N; $i++)
	    				{
	    					$ss_data = array(
	    						'project_id' =>$project_id ,
	    						'service_id' => $service[$i]
	    						);

	    					$data_services[]  = $ss_data;

	    				}

		    			$this->project_services_model->insertBulk($data_services);
                                                
                        //send notifications                        
                        $this->notification->__sendNotification($project_id, 'ADD_NEW_JOB',  $this->config->item('admin_id'),  $data_project['link_user_id'], 1 );                        
                                                

		    			//sending mail
	                    $this->__sendEmail('NEWJOB', $project_id);

		    		}

	    		}	    		

	    		$data['error_display'] =2;
	    	}
	    	else
	    	{
	    		$data['error_display'] =1;
	    	}
   

		}

       
		//notifications
		$data =  array_merge($data , $this->notification->__getNotifications($this->user_id) );

        
		$this->load->view('new_job_admin', $data);
	}


	function view()
	{
		$this->load->model('project_model');
		$data["results"] = $this->project_model->getDataAdminView();

		//notifications
		$data =  array_merge($data , $this->notification->__getNotifications($this->user_id) );

		$this->load->view('jobs_admin', $data);
	}


	public function singleView($job_id)
	{
		$this->load->model('project_model');
		$this->load->model('message_model');
		$this->load->model('user_model');
		$this->load->model('files_model');
		$this->load->model('invoice_model');
		$this->load->model('user_model');
		$this->load->library('invoice_lib');
		
		$data = array();
		
		$result = $this->project_model->getViewAdmin($job_id);

		if($result->num_rows() > 0)
		{
			$row = $result->row();
			$data['address'] = $row->address;
			$data['start_datatime'] = $row->job_start_date . ' ' .  $row->job_start_time ;
			$data['services'] =  $row->my_service;
			$data['description'] =  $row->description;
			$data['key_collection_info'] =  $row->key_collection_info;
			$data['property_type'] =  $row->property_type;
			$data['no_of_rooms'] =  $row->no_of_rooms;
			$data['furnishing'] =  $row->furnishing;
			$data['company'] = $row->company_name;
			$data['client_id']  =  $row->client_id;
			$data['status'] = $row->status;

			$data['assign_user'] = $this->user_model->geUserFullNameById($row->link_user_id);

			$data['send_users']  = $this->user_model->getDataByClient( $row->client_id );
		}

		$data['mesages'] = $this->message_model->getDataByProjectAdmin($job_id);

		
		$data['file_url'] = $this->config->item('files') . $job_id .  '/' ; 

		$data['files'] = $this->files_model->getDataByProject($job_id);

		$data['user_id'] = $this->user_id;
		$data['project_id'] = $job_id;

		$user = $this->ion_auth->user()->row();
		$data['user_name'] =   $user->first_name . ' ' . $user->last_name ;

		//invoice link
		$data['publish'] = $this->invoice_model->published($job_id);

		$data['paid'] = $this->invoice_model->paid($job_id);

		if($data['publish'] == 1){
			$invoice_data = $this->invoice_lib->generatePdfData($job_id);

			$data['total_amount'] = $invoice_data['balance_amount'];
		}



		//notifications
		$data =  array_merge($data , $this->notification->__getNotifications($this->user_id) );
		
		$this->message_model->updateRead($job_id, $this->user_id );
		
		$this->load->view('job_view_admin', $data);
	}



    function delete(){

    		$this->load->model('project_model');

			$this->form_validation->set_rules("project_id", 'project_id','trim|required');

			if ($this->form_validation->run() == TRUE){

        	 	$project_id = $this->input->post('project_id');

				$data_project = array(
						    			'status' => 3
	    							);
        		
        		$this->project_model->updateData($data_project, $project_id);
                
                //send notifications 
                $project_details = $this->project_model->getDataById($project_id);
                
                if($project_details->num_rows() > 0)
                {
                    $project_details_row  = $project_details->row();
                    
                    $this->notification->__sendNotification($project_id, 'CANCEL_JOB',  $this->config->item('admin_id'),  $project_details_row->link_user_id , 1);

                    //sending mail
                    $this->__sendEmail('STCANC', $project_id);
                }                   
                

			}

		redirect('admin/jobs/view');

    }


    function processUpdate(){

    		$this->load->model('project_model');

			$this->form_validation->set_rules("project_id", 'project_id','trim|required');
			$this->form_validation->set_rules("change_process", 'change_process','trim|required');

			if ($this->form_validation->run() == TRUE){

        	 	$project_id = $this->input->post('project_id');
        	 	$change_process = $this->input->post('change_process');

				$data_project = array(
						    			'status' => $change_process
	    							);
        		
        		$this->project_model->updateData($data_project, $project_id);
                
                
                //send notifications 
                $project_details = $this->project_model->getDataById($project_id);
                
                if($project_details->num_rows() > 0)
                {
                    $project_details_row  = $project_details->row();
                    
                    $status_text = '';
                    switch ($change_process)
                    {
                    	 case 1 : 
                            $this->notification->__sendNotification($project_id, 'PROCSS_JOB',  $this->config->item('admin_id'),  $project_details_row->link_user_id , 1);

                            //sending mail
                    		$this->__sendEmail('STPROC', $project_id);

                            break;

                        case 2 : 
                            $this->notification->__sendNotification($project_id, 'CARRIED_OUT_JOB',  $this->config->item('admin_id'),  $project_details_row->link_user_id , 1);

                            //sending mail
                    		$this->__sendEmail('STCARRY', $project_id);

                            break;
                        case 3:
                            $this->notification->__sendNotification($project_id, 'CANCEL_JOB',  $this->config->item('admin_id'),  $project_details_row->link_user_id, 1 );

                            //sending mail
                    		$this->__sendEmail('STCANC', $project_id);

                    		break;

                    	case 4:
                            $this->notification->__sendNotification($project_id, 'FINISH_JOB',  $this->config->item('admin_id'),  $project_details_row->link_user_id, 1 );

                            //sending mail
                    		$this->__sendEmail('STCOMP', $project_id);

                            break;

                        case 5:
                        	error_log('accept job');
                            $this->notification->__sendNotification($project_id, 'ACCEPT_JOB',  $this->config->item('admin_id'),  $project_details_row->link_user_id, 1 );

                            //sending mail
                    		$this->__sendEmail('STACC', $project_id);

                            break;
                           
                    }
                    
                    
                }
                
                

        		redirect('admin/jobs/singleView/' .$project_id);
			}

			redirect('admin/jobs/view');

    }   


	function __sendEmail($type, $project_id)
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
			$row_project = 	$row_project_set->row();
			//
			$email_vars['company_name'] = $this->client_model->getCompanyName($row_project->client_id);

			
			$mail_services_record = $this->project_services_model->getDataServicesProjectId($project_id);
	        if($mail_services_record->num_rows() > 0)
	        {	
	        	$mail_services_row = $mail_services_record->row();
	        	$email_vars['services'] = $mail_services_row->my_service;
	        }


	        $email_vars['job_start_datetime'] =   $row_project->job_start_date . ' ' .  $row_project->job_start_time;
        	$email_vars['key_collection_info'] =   $row_project->key_collection_info;
        	$email_vars['address'] =  $row_project->address;
        	$email_vars['user_full_name'] =  $this->config->item('admin_name');
        	
        	// this is admin view so updates will be send to users 

        	$user_details =  $this->user_model->getDataByUserId($row_project->link_user_id);      	

			//$default_user = $this->client_user_link_model->getDefaultUser($row_project->client_id );
			//if(isset($default_user) )
			if($user_details->num_rows() > 0)
			{
				$user_detail = $user_details->row();

				$receiver_email = $user_detail->email; //$default_user->email;
				$email_vars['job_user_name'] =  $user_detail->first_name . ' ' . $user_detail->last_name;
			}
        	

		}                
               
      	$email_vars['admin_name'] = $this->config->item('admin_name');

        $sender_email = $this->config->item('admin_email');
        $from = $this->config->item('website_name');

        $this->email_processor->process_email($type, $email_vars, $receiver_email, $sender_email, $from);

	}

	//download files as zip folder
	function zipDownload()
	{

		header('Set-Cookie: fileDownload=true; path=/');
		header('Cache-Control: max-age=60, must-revalidate');
		

		$arr = null;

		if(empty($_POST)){  
			//$arr = array ('status'=> 'we need more info to process file!');
			//error_log('1');
		}
 		else
		{
			$this->form_validation->set_rules("project_id", "project_id","trim|required");
			
			if ($this->form_validation->run() == false){
				//$arr = array ('status'=> 'Required parameter empty' );
				//error_log('2');
			}
			else {
				//error_log('3');
				$this->load->model('files_model');
				$this->load->library('zip');

				$project_id = $this->input->post('project_id');

				$file_url = $this->config->item('files') . $project_id .  '/' ; 


				$files = $this->files_model->getDataByProject($project_id);

				$data_files = array();

				if($files->num_rows() > 0)
				{
					
					foreach ($files->result() as $file) {
						$this->zip->read_file(  $file_url .  $file->file_url  , FALSE); 
						
					}
				}
				
				// Download the file to your desktop. Name it "my_backup.zip"
				$this->zip->download($this->generateKey(). '.zip');
			
			}
		}


	}

	function generateKey($length=8) {
        $s = strtoupper(md5(uniqid(rand(),true))); 
        $guidText = 
        substr($s,0,$length); 
        return $guidText;
    }


    function pendingPayments(){

		$this->load->model('project_model');

		$data = array();	

    	$data['results_unpaid'] =  $this->project_model->getDataAdminPendingPayment();

    	//notifications
		$data =  array_merge($data , $this->notification->__getNotifications($this->user_id) );

		$this->load->view('pending_payments', $data);

    }
	
}