<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends CI_Controller {

	private $user_id;

	public function __construct()
    {
        parent::__construct();
        // Your own constructor code

        $this->load->helper(array('form', 'url'));
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

		$data = array();

		if (!$this->ion_auth->logged_in())
		{
			redirect('auth/login');
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

		$data['results'] =  $this->project_model->getDataAdminSummaryView();

		$data['results_noinvoice'] =  $this->project_model->getDataAdminNoInvoice();

		$status_sum = $this->project_model->getStatusAdminSummary();
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
                case 5:
                   $data['accepted'] = $row->total;
                  break;
                
                default:
                  # code...
                  break;
              }

            }

            
        }

		
		//notifications
		$data =  array_merge($data , $this->notification->__getNotifications($this->user_id) );

		$this->load->view('dashboard'  , $data);
	}


	function summaryProjects()
	{
		$this->load->model('project_model');

		$result = $this->project_model->admin_summary_projects();

		$summary = array();

		if($result->num_rows() > 0 )
		{
			
			foreach ($result->result() as $row) {
					
				$temp_row = array('y' => $row->monthly , 'item1' => $row->num_of_projects);
				$summary[] = $temp_row;
			}

		}

		$data = array('result' => $summary);
		echo json_encode($data);	
	}

}
