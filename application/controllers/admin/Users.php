<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Users extends CI_Controller {

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


    function add($id = 0){

    	$this->load->model('client_model');
    	$this->load->model('client_user_link_model');

    	$data = array();


    	if(!empty($id))
    	{
    		$row_user = $this->ion_auth->user($id)->row();

			$data['user_id'] =  $row_user->id;
			$data['user_email'] = $row_user->email;
			$data['username'] = $row_user->username;
			$data['first_name'] = $row_user->first_name;
			$data['last_name'] = $row_user->last_name;
			$data['company'] = $row_user->company;
			$data['phone'] = $row_user->phone;


			$user_link_details = $this->client_user_link_model->getDataByUserId($id);
			if($user_link_details->num_rows() > 0 )
			{
				$user_link_detail = $user_link_details->row();
				$data['default_user'] = $user_link_detail->default_user;
				$data['company'] = $user_link_detail->client_id;
			}
			

    	}



    	//get the services
		$clients_data = $this->client_model->getData();
        $data['clients_data'] = $clients_data;


    	if (isset($_POST['submit']))
		{
						
			if(empty($id))
    		{
				$this->form_validation->set_rules("username", "username", 'trim|required');
				$this->form_validation->set_rules("user_email", 'user_email','trim|required');				

			}
			else
			{
				$this->form_validation->set_rules("username", "username", 'trim|required|callback_validate_username');
				$this->form_validation->set_rules("user_email", 'user_email','trim|required|callback_validate_email');		
			}

			$this->form_validation->set_rules("first_name", 'first_name','trim|required');
			$this->form_validation->set_rules("last_name", 'last_name','trim|required');
			$this->form_validation->set_rules("company", 'company','trim|required');
			$this->form_validation->set_rules("user_password", 'user_password','trim|required');
			$this->form_validation->set_rules("user_confirm_password", 'user_confirm_password','trim|required|matches[user_password]');

        	$data['errors']['user_email']  = "Please enter user email address";
        	$data['errors']['username']  = "Please enter username";
        	$data['errors']['first_name']  = "Please enter first name";
        	$data['errors']['last_name']  = "Please enter last name";
        	$data['errors']['company']  = "Please select company";
        	$data['errors']['user_password']  = "Please provide password";
        	$data['errors']['user_confirm_password']  = "Please re-enter confirm password, Passwords don\'t match";

        	//$this->validation->set_message('matches', 'Passwords don\'t match');

        	//$this->form_validation->set_message('validate_username','username is not available!');


        	$user_id = $this->input->post('user_id');

        	if ($this->form_validation->run() == TRUE){

        		if(!empty($user_id))
        		{
        			$data_update = array(
						'first_name' => $this->input->post('first_name'),
						'last_name' =>  $this->input->post('last_name'),
						'company' => $this->input->post('company'),
						'password' => $this->input->post('user_password'),
						'username' => $this->input->post('username'),
						'email' => $this->input->post('user_email'),
						'phone' => $this->input->post('phone'),
					 );

					$this->ion_auth->update($user_id, $data_update);

					

					//update default user
					$data_link = array(
							'default_user' =>  $this->input->post('default_user')
							);
						$this->client_user_link_model->updateDataByUserID($data_link, $user_id);

        		}
        		else
        		{
        			$username = $this->input->post('username');
					$password = $this->input->post('user_password');
					$email = $this->input->post('user_email');
					$additional_data = array(
											'first_name' => $this->input->post('first_name'),
											'last_name' =>  $this->input->post('last_name'),
											'company' => $this->input->post('company'),
											'phone' => $this->input->post('phone')
											);
					$group = array('2'); // Sets user to admin. No need for array('1', '2') as user is always set to member by default

					$created_user_id = $this->ion_auth->register($username, $password, $email, $additional_data);//, $group);

					if(!empty($created_user_id)){
						
						$data_link = array(
							'client_id' => $this->input->post('company'),
							'user_id' => $created_user_id,
							'default_user' =>  $this->input->post('default_user')
							);
						$this->client_user_link_model->insertData($data_link);
					}

					//send email
					 $this->__sendEmail('NEWUSR', array('user_full_name' => $additional_data['first_name'] . ' ' . $additional_data['last_name']  , 'user_email' => $email, 'username'=> $username, 'user_password' => $password)  );
					
        		}




	    		$data['error_display'] =2;

        	}
        	else{

	    		$data['error_display'] =1;
	    	}

		}

		//notifications
        $data =  array_merge($data , $this->notification->__getNotifications($this->user_id) );

    	$this->load->view('add_users' , $data);

    }

    function validate_username($str)
	{
	   $username = $str; //this is redundant, but it's to show you how
	   //the content of the fields gets automatically passed to the method

	   if($this->ion_auth->username_check($username))
	   {
	     return FALSE;
	   }
	   else
	   {
	     return TRUE;
	   }
	}

	function validate_email($str)
	{
	   $email = $str; //this is redundant, but it's to show you how
	   //the content of the fields gets automatically passed to the method

	   if($this->ion_auth->email_check($email))
	   {
	     return FALSE;
	   }
	   else
	   {
	     return TRUE;
	   }
	}



    function view(){

    	$this->load->model('user_model');

		$data["results"] = $this->user_model->getData();

		//notifications
        $data =  array_merge($data , $this->notification->__getNotifications($this->user_id) );
        
		$this->load->view('list_users', $data);
    }


    function delete(){

    		$this->load->model('client_model');

			$this->form_validation->set_rules("user_id", 'user_id','trim|required');

			if ($this->form_validation->run() == TRUE){

        	 	$user_id = $this->input->post('user_id');

        	 //	$this->ion_auth->delete_user($user_id)

				$data_user = array(
						    			'active' => 0
	    							);
        		
        		
				$this->ion_auth->update($user_id, $data_user);

			}

		redirect('admin/users/view');

    }

    function __sendEmail($type, $data_mail)
    {
        $this->load->library('email_processor');

        $email_vars = array();

        $email_vars['user_full_name'] =  $data_mail['user_full_name'];
        $email_vars['user_email'] =  $data_mail['user_email'];
        $email_vars['username'] =  $data_mail['username'];
        $email_vars['user_password'] =  $data_mail['user_password'];
               
        $receiver_email = $data_mail['user_email'];
        $sender_email = $this->config->item('admin_email');
        $from =  $this->config->item('website_name');

        $this->email_processor->process_email($type, $email_vars, $receiver_email, $sender_email, $from);

    }

    function getUsersByClient()
    {

    	$this->load->model('user_model');

    	$user_array = array();

    	$client_id = $this->input->get('client_id');

    	if(!empty($client_id))
    	{
    		$data_users = $this->user_model->getDataByClient($client_id);          

	       if($data_users->num_rows() > 0)
	       {
	            foreach ( $data_users->result()  as $user) {
	                 $user_array[]  = array(
	                                    'id' => $user->id,
	                                    'user_name' => $user->first_name . ' ' .  $user->last_name
	                                );
	            }

	       }
	       
    	}
       
       

    	$data = array('users' => $user_array );
          
        echo json_encode($data);
    
    }

}