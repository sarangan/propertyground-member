<?php
ini_set('memory_limit', '128M');
defined('BASEPATH') OR exit('No direct script access allowed');

class Files extends CI_Controller {

	private $user_id;

	public function __construct()
    {
        parent::__construct();
        // Your own constructor code

        $this->load->helper(array('form', 'url'));
        $this->load->library('form_validation');
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


    function upload($job_id=0)
    {
        $this->load->model('project_model');

    	$data= array();

    	if(!empty($job_id)){

    		$data['project_id'] = $job_id;
            $data['client_id'] = $this->project_model->getProjectClient($job_id);
    	}
    	else{

    		redirect('admin/jobs/view');
    	}	

        //notifications
        $data =  array_merge($data , $this->notification->__getNotifications($this->user_id) );

        $this->load->view('file_upload', $data);

    }

    function fileUpload()
    {	
		$this->load->model('files_model');
        $this->load->model('project_model');
		$this->load->library('process_image');

		$files = null;

    	if ($this->ion_auth->logged_in())
    	{

    		$project_id = trim($this->input->post('project_id'));
    		
            $file_url = $this->config->item('files') . $project_id .  '/' ;     
                    
            //Your upload directory, see CI user guide
            $config['upload_path'] = $file_url;
            //$config['allowed_types'] = 'gif|jpg|png|JPG|GIF|PNG';
            $config['allowed_types'] = '*';
            $config['max_size'] = '20500';
            $config['remove_spaces'] = true;
            $config['overwrite'] = false;
            $config['encrypt_name'] = true;
            $config['remove_spaces'] = true;
            $config['max_filename'] = 0;
            
            //Load the upload library
            $this->load->library('upload', $config);
            $this->upload->initialize($config);
                
            if (! $this->upload->do_upload('files')) {

                error_log($this->upload->display_errors());

                $files = array(
                            'error' => str_ireplace('</p>','', str_ireplace('<p>','', $this->upload->display_errors() ) )           
                        );                

            } 
            else 
            {
            	                                
                $data = $this->upload->data();
                $name = $data['file_name'];                

                $data_insert = array(
                                'project_id' => $project_id,
                                'file_url' => $data['file_name'],
                                'file_type' => strtoupper( str_replace('.', '', $data['file_ext']) ),
                                'size' => $data['file_size'] ,
                                'is_image' => $data['is_image'],
                                'image_url' =>  $data['raw_name'] . '_thumb'  .'.'. PHOTOEXT
                                //'caption' => $this->input->post('caption')                                    
                            );

                $id = $this->files_model->insertData($data_insert);

                $files = array(
                               'error' => '',
                               'file_id' => $id     
                        );

                if($data['is_image'])
                {
                	$source_image =   $file_url .  $name;
                	$new_image =   $file_url .  $data['raw_name'] . '_thumb'  .'.'. PHOTOEXT ;
                
                	$this->process_image->createImage($data['image_width'] ,  $data['image_height'], $source_image,  $new_image );
                }
                
                    
                //send notifications 
                $project_details = $this->project_model->getDataById($project_id);
                
                if($project_details->num_rows() > 0)
                {
                    $project_details_row  = $project_details->row();
                    
                    $this->notification->__sendNotification($project_id, 'UPLOAD_FILES',  $this->config->item('admin_id'),  $project_details_row->link_user_id , 1);
                }
               

            }

       	}
        else{

            $files = array(
                        'error' => lang('login_error')           
                        );
        }


        
        echo json_encode($files);
    }


    /*
    * this to get photo title 
    *
    */
    function updateTitle()
    {
        $this->load->model('files_model');

        $arr = null;
         
        if(empty($_POST))
        {    
           error_log( 'Empty post update title!');
        }
        else
        {
        	
            $this->form_validation->set_rules("file_id", "file_id","trim|required");

            if ($this->form_validation->run() == false){
                 error_log( 'Required parameter empty');
            }
            else
            {
                $caption = $this->input->post('caption');
                $file_id = $this->input->post('file_id');

                $data = array("description"=> $caption);
                $this->files_model->updateData(  $data , $file_id);
            }
        }

        redirect('/admin/jobs/view/');

    }


    function desEdit($file_id = 0)
    {
    	$this->load->model('files_model');
        $this->load->model('project_model');

    	$data= array();

		if(!empty($_POST))
        {
                	
            $this->form_validation->set_rules("file_id", "file_id","trim|required");
            $this->form_validation->set_rules("description", "description","trim|required");

            $data['errors']['description']  = "Please enter description";

            if ($this->form_validation->run() == false){
               $data['error_display'] =1;
            }
            else
            {
                $description = $this->input->post('description');
                $file_id = $this->input->post('file_id');

                $data = array("description"=> $description);
                $this->files_model->updateData(  $data , $file_id);


                $data['error_display'] =2;
            }
        }

        if(!empty($file_id)   || ( strlen(trim($this->input->post('file_id')) ) > 0  ) ) {

    		$file_id =  empty($file_id)?$this->input->post('file_id'):$file_id;
    		$data['file_id'] = $file_id;
    		//error_log($file_id);
    	
       		$result = $this->files_model->getDataById($file_id);

	    	if($result->num_rows() > 0)
	    	{
	    		$file_row = $result->row();
	    		$data['file_url'] = $file_row->file_url;
	    		$data['description'] = $file_row->description;
	    		$data['file_type'] = $file_row->file_type;
	    		$data['size'] = $file_row->size;
	    		$data['is_image'] = $file_row->is_image;
	    		$data['image_url'] = $file_row->image_url;
                $data['project_id'] = $file_row->project_id;

                $data['client_id'] = $this->project_model->getProjectClient($file_row->project_id);

	    		$data['file_path'] = $this->config->item('files') . $file_row->project_id . '/';
	    	}
	    }


        //notifications
        $data =  array_merge($data , $this->notification->__getNotifications($this->user_id) );
        
        $this->load->view('file_edit', $data);

    }


    function delete(){

    	$this->load->model('files_model');

		$this->form_validation->set_rules("file_id", 'file_id','trim|required');

		if ($this->form_validation->run() == TRUE){

        	 	$project_id = $this->input->post('project_id');
        	 	$file_id = $this->input->post('file_id');

        		$result = $this->files_model->getDataById($file_id);

		    	if($result->num_rows() > 0)
		    	{
		    		$file_row = $result->row();
		    		$file_url = $file_row->file_url;
		    		$is_image = $file_row->is_image;
	    			$image_url = $file_row->image_url;

	    			$file_path = $this->config->item('files') . $file_row->project_id . '/';

	    			unlink($file_path . $file_url );

	    			if($is_image)
	    			{
	    				unlink($file_path . $image_url );
	    			}

		    	}

		    	$this->files_model->deleteData($file_id);


		}
		else
		{
			redirect('admin/jobs/view');
		}

		redirect('admin/jobs/singleView/'. $project_id);

    }


}