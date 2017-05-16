<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Clients extends CI_Controller {

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

    	$this->load->model('client_model');

    	$data = array();

    	if(!empty($id))
    	{
    		$existing_data = $this->client_model->getDataById($id);

    		if($existing_data->num_rows() > 0)
    		{
    			$existing_row = $existing_data->row();
    			$data['company_id'] = $existing_row->id;
    			$data['company_name'] = $existing_row->name;
    			$data['company_address'] = $existing_row->address;
    			$data['company_website'] = $existing_row->website;
    			$data['company_contact'] = $existing_row->contact;
    			$data['company_email'] = $existing_row->email;
    			$data['exceed_amount'] = $existing_row->exceed_amount;
    			$data['photo_position'] = $existing_row->photo_position;

                $logo = $existing_row->logo;
                if( strlen( trim($logo) ) > 0 )
                {
                    $logo = $this->config->item('logos') .  $logo ;
                }
                else
                {
                    $logo = 'res/images/noimage.gif';
                }
                $data['logo'] = $logo;

            }
    		

    	}


    	if (isset($_POST['submit']))
		{
			$this->form_validation->set_rules("company_name", 'company_name','trim|required');
			$this->form_validation->set_rules("company_address", 'company_address','trim|required');
			$this->form_validation->set_rules("company_email", 'company_email','trim|required');
			$this->form_validation->set_rules("exceed_amount", 'exceed_amount','trim|required'); 


        	$data['errors']['company_name']  = "Please enter the company name";
        	$data['errors']['company_address']  = "Please enter the company address";
        	$data['errors']['company_email']  = "Please enter the company email address";
        	$data['errors']['exceed_amount']  = "Please enter exceed amount";

        	 $company_id = $this->input->post('company_id');

            $data['logo'] = $this->input->post('image_preview');

        	if ($this->form_validation->run() == TRUE){


        		$data_client = array(

						    			'name' => $this->input->post('company_name') ,
						    			'address' => $this->input->post('company_address') ,
						    			'website' => $this->input->post('company_website') ,
						    			'contact' => $this->input->post('company_contact') ,
						    			'email' => $this->input->post('company_email') ,
						    			'exceed_amount' => $this->input->post('exceed_amount'),
						    			'photo_position' => $this->input->post('photo_position')
	    							);

                // logo setting
                $logo_name ='';
                $file_url = $this->config->item('logos') ;

                //Your upload directory, see CI user guide
                $config['upload_path'] = $file_url;
                $config['allowed_types'] = 'gif|jpg|png|JPG|GIF|PNG';
                $config['max_size'] = '10000';
                $config['remove_spaces'] = true;
                $config['overwrite'] = false;
                $config['encrypt_name'] = true;
                $config['remove_spaces'] = true;
                $config['max_filename'] = 0;

                //Load the upload library
                $this->load->library('upload', $config);
                $this->upload->initialize($config);

                if (! $this->upload->do_upload('logoimg')) {

                    error_log($this->upload->display_errors());
                }
                else
                {

                    $data = $this->upload->data();
                    $logo_name = $data['file_name'];

                    $this->load->library('process_image');

                    $source_image =   $file_url .  $logo_name;
                    $new_image =   $file_url .  $data['raw_name'] . '_' . 'thumb.'. PHOTOEXT ;
                    $this->process_image->createImage($data['image_width'] ,  $data['image_height'], $source_image,  $new_image );

                    //$logo_name = $new_image;

                    $data_client['logo'] =  $logo_name;
                }



        		if(!empty($company_id))
        		{        			
        			$this->client_model->updateData($data_client, $company_id);
        		}
        		else
        		{
        			$data['company_id']  = $this->client_model->insertData($data_client);

                    $this->__sendEmail('NEWCOM', array('company_name' => $data_client['name'] , 'company_email' => $data_client['email'] ) );
        		}
	    		

	    		$data['error_display'] =2;

        	}
        	else{

	    		$data['error_display'] =1;
	    	}

		}

        //notifications
        $data =  array_merge($data , $this->notification->__getNotifications($this->user_id) );

    	$this->load->view('add_clients' , $data);

    }


    function view(){

    	$this->load->model('client_model');

		$data["results"] = $this->client_model->getData();

        //notifications
        $data =  array_merge($data , $this->notification->__getNotifications($this->user_id) );

		$this->load->view('list_clients', $data);
    }


    function delete(){

    		$this->load->model('client_model');

			$this->form_validation->set_rules("client_id", 'client_id','trim|required');

			if ($this->form_validation->run() == TRUE){

        	 	$company_id = $this->input->post('client_id');

				$data_client = array(
						    			'status' => 2
	    							);
        		
        		$this->client_model->updateData($data_client, $company_id);

			}

		redirect('admin/clients/view');

    }

    function summary($client_id){

        $this->load->model('project_model');

        if(!empty($client_id))
        {
            $data["results"] = $this->project_model->getDataByClient($client_id);

            $status_sum = $this->project_model->getStatusSummary($client_id);
            if($status_sum->num_rows() > 0)
            {
                foreach ($status_sum->result() as $row) {
                                    
                  switch ($row->status){
                    
                    case 1:
                          $data['processing'] = $row->total;
                          break;
                    case 2:
                        $data['finished'] = $row->total;                
                        break;
                    case 3:
                       $data['canceled'] = $row->total;
                      break;
                    case 4:
                       $data['completed'] = $row->total;
                      break;
                    
                    default:
                      # code...
                      break;
                  }

                }

                
            }
        }

        //notifications
        $data =  array_merge($data , $this->notification->__getNotifications($this->user_id) );

        $this->load->view('summary_clients', $data);

    }

    function __sendEmail($type, $data_mail)
    {
        $this->load->library('email_processor');

        $email_vars = array();

        $email_vars['company_name'] =  $data_mail['company_name'];
               
        $receiver_email = $data_mail['company_email'];
        $sender_email = $this->config->item('admin_email');
        $from =  $this->config->item('website_name');

        $this->email_processor->process_email($type, $email_vars, $receiver_email, $sender_email, $from);

    }

}