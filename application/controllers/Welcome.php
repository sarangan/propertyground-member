<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Welcome extends CI_Controller {

	private $user_id;

	public function __construct()
    {
        parent::__construct();
        // Your own constructor code
		$this->load->library('notification');
        $this->load->library('ion_auth');

		if (!$this->ion_auth->logged_in())
		{
			redirect('auth/login');
		}

		$user = $this->ion_auth->user()->row();
		$this->user_id  =  $user->id;

		if ($this->ion_auth->get_users_groups($this->user_id )->row()->id == 1) 
		{
			redirect('admin/dashboard/index');
		}


    }


	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see http://codeigniter.com/user_guide/general/urls.html
	 */
	public function index()
	{

		$this->load->library('ion_auth');
		$this->load->library('notification');
		 $this->load->model('project_model');

		 $data  = array();
		
		if (!$this->ion_auth->logged_in())
		{
			redirect('auth/login');
		}

		if ($this->ion_auth->get_users_groups($this->user_id )->row()->id == 1) 
		{
			redirect('admin/dashboard/index');
		}

		// $username = 'client1';
		// $password = 'client1';
		// $email = 'client1@gmail.com';
		// $additional_data = array(
		// 						'first_name' => 'Ben',
		// 						'last_name' => 'Edmunds',
		// 						);
		// $group = array('2'); // Sets user to admin. No need for array('1', '2') as user is always set to member by default

		// $this->ion_auth->register($username, $password, $email, $additional_data, $group);

		//notifications
		$data =  array_merge($data , $this->notification->__getNotifications($this->user_id) );

		$status_sum = $this->project_model->getStatusSummary( $this->client_user_link_model->getClientIdByUserid($this->user_id) );
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


		$this->load->view('welcome_message', $data);
	}

	function getPackages(){

       $this->load->model('packages_model');
       $this->load->model('services_model');


       $pack_array = array();
       
       $data_pack = $this->packages_model->getDataPackageView();          

       if($data_pack->num_rows() > 0)
       {
            foreach ( $data_pack->result()  as $pack) {
                 $pack_array[]  = array(
                                    'my_service' => $pack->my_service,
                                    'amount_1_3' => $pack->amount_1_3,
                                    'amount_4_6' => $pack->amount_4_6
                                );
            }

       }


       $data_services = $this->services_model->getDataForJob();

       if($data_services->num_rows() > 0)
       {

            foreach ($data_services->result()  as $service) {
            	
            	if($service->service_id != INVID ){

            		$pack_array[] = array(
                                    'my_service' => $service->service,
                                    'amount_1_3' => $service->amount_1_3,
                                    'amount_4_6' => $service->amount_4_6
                                );
            	}
               
            }
       }

       $data = array('records' => $pack_array );
      
      echo json_encode($data);

    }


    function getProjectsSummary(){

    	$this->load->model('project_model');
    	$this->load->model('client_user_link_model');

    	//error_log( $this->client_user_link_model->getClientIdByUserid($this->user_id) );
    	$total_projects = $this->project_model->myJobsTotalCount( $this->client_user_link_model->getClientIdByUserid($this->user_id) );

    	$processing_projects = $this->project_model->myJobsCount( $this->client_user_link_model->getClientIdByUserid($this->user_id) );
    	$carried_projects = 0;//$this->project_model->myJobsCarriedCount( $this->client_user_link_model->getClientIdByUserid($this->user_id) );

    	$data_summary = array('total' => $total_projects, 'processing' => $processing_projects, 'carriedout' => $carried_projects);

    	$data = array('summary' => $data_summary );
          
        echo json_encode($data);
    }


}
