<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Notification extends CI_Controller {

	private $user_id=0;

	function __construct() {
		parent::__construct();
		$this->load->helper('url');
		$this->load->library("form_validation");
		$this->load->helper(array('form', 'url'));		

		$this->load->library('ion_auth');

		if (!$this->ion_auth->logged_in())
		{
			redirect('auth/login');
		}

		$user = $this->ion_auth->user()->row();
		$this->user_id  =  $user->id;

	}


	/*
	*	this is to update the fav via ajax
	*/
	function updateAlerts()
	{
		$this->load->model('notification_model');
		$this->load->model('client_user_link_model');

		$arr = null;
		 
		
		// insert new record
	    $data = array(
	        'status' =>  2 );

	   		
		// if ($this->ion_auth->get_users_groups($this->user_id )->row()->id != 1) 
		// {
		// 	 $this->notification_model->captureAlerts($data, $this->client_user_link_model->getClientIdByUserid($this->user_id) );
		// }
		// else
		// {
		// 	$this->notification_model->captureAlerts($data, $this->user_id );
		// }

		$this->notification_model->captureAlerts($data, $this->user_id );
	   
	    $arr = array ('status'=> 1 );
		
		
		echo json_encode($arr);
	}

	
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */