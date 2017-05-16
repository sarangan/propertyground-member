<?php 
class Notification_Model extends CI_Model {

	function __construct(){

		parent::__construct();
		$this->load->database();
	}

	function insertData($data){
		$this->db->insert('notifications', $data);
	}

	function getData($user_id){
		$query = $this->db->get_where('notifications', array('user_id' => $user_id));

		return $query;
	}

	function updateData($user_id , $data){
		$this->db->where('user_id', $user_id);
        $this->db->update('notifications', $data);
	}

	function checkDataExists($user_id )
	{
		$query = $this->db->get_where('notifications', array('user_id' => $user_id ));
	    
	    if($query->num_rows() > 0)
	    {
	    	// exists 
	    	return TRUE;
	    }
	    return FALSE;
	}

	function fetch_notifications($user_id, $is_admin) {
      
        $query = $this->db->query("SELECT DISTINCT notifications.*, (select 1) as notification_text, (select 1) as sender_profile_image, (select 1) as link_url from notifications where notifications.user_id=" . $user_id . " and notifications.is_admin=". $is_admin." ORDER BY notifications.updated_date DESC, notifications.status ASC LIMIT 5" );

		if ($query->num_rows() > 0) {

			$data = array();

		    foreach ($query->result() as $row) {

		    	$notification_text = '';

		    	$link_url = '';
		    	$image_url ='';
		    	
		    	$first_name = '';
		    	$last_name = '';

		    	if($row->is_admin == 1 )
		    	{
		    		//admin is updated 
		    		$this->load->model('user_model');
		    		$user_details = $this->user_model->getDataByUserId($row->updated_person );
		    		if($user_details->num_rows() >0 )
		    		{
		    			$user = $user_details->row();
		    			$first_name = $user->first_name;
		    			$last_name = $user->last_name;
		    		}

		    		$image_url = 'res/images/admin.png';
		    		
		    	}
		    	else
		    	{
		    		$this->load->model('client_model');
		    		$this->load->model('client_user_link_model');
		    		$client_details = $this->client_model->getDataById( $this->client_user_link_model->getClientIdByUserid( $row->updated_person ) );
		    		if($client_details->num_rows() >0 )
		    		{
		    			$client = $client_details->row();
		    			$first_name = $client->name;
		    			$last_name = '';
		    			if( strlen( trim( $client->logo )) >0 )
		    				$image_url = $this->config->item('logos') . $client->logo;
		    			else
		    				$image_url = 'res/images/client.png';
		    		}

		    	}		    	

		    	switch ($row->type) {
		    		case 'ADD_NEW_JOB':
		    			$notification_text  = ADD_NEW_JOB;		
		    			
		    			if($row->is_admin == 1 )
		    			{
		    				$link_url =  'index.php/admin/jobs/singleView/' . $row->event_id ;
		    			}
		    			else
		    			{
		    				$link_url =  'index.php/jobs/view/' . $row->event_id ;
		    			}		    			
		    			break;

		    		case 'UPDATED_JOB':
		    			$notification_text  =  UPDATED_JOB;		
		    			
		    			if($row->is_admin == 1 )
		    			{
		    				$link_url =  'index.php/admin/jobs/singleView/' . $row->event_id ;
		    			}
		    			else
		    			{
		    				$link_url =  'index.php/jobs/view/' . $row->event_id ;
		    			}
		    			break;

		    		case 'FINISH_JOB':
		    			$notification_text  = FINISH_JOB  ;		
		    			
		    			if($row->is_admin == 1 )
		    			{
		    				$link_url =  'index.php/admin/jobs/singleView/' . $row->event_id ;
		    			}
		    			else
		    			{
		    				$link_url =  'index.php/jobs/view/' . $row->event_id ;
		    			}
		    			break;

		    		case 'ACCEPT_JOB':
		    			$notification_text  = ACCEPT_JOB  ;		
		    			
		    			if($row->is_admin == 1 )
		    			{
		    				$link_url =  'index.php/admin/jobs/singleView/' . $row->event_id ;
		    			}
		    			else
		    			{
		    				$link_url =  'index.php/jobs/view/' . $row->event_id ;
		    			}
		    			break;

		    		case 'CANCEL_JOB':
		    			$notification_text  = CANCEL_JOB  ;		
		    			
		    			if($row->is_admin == 1 )
		    			{
		    				$link_url =  'index.php/admin/jobs/singleView/' . $row->event_id ;
		    			}
		    			else
		    			{
		    				$link_url =  'index.php/jobs/view/' . $row->event_id ;
		    			}
		    			break;

		    		case 'UPLOAD_FILES':
		    			$notification_text  = UPLOAD_FILES;	
		    			
		    			if($row->is_admin == 1 )
		    			{
		    				$link_url =  'index.php/admin/jobs/singleView/' . $row->event_id ;
		    			}
		    			else
		    			{
		    				$link_url =  'index.php/jobs/view/' . $row->event_id ;
		    			}
		    			break;

		    		case 'INVOICE_CREATED':
		    			$notification_text  = INVOICE_CREATED;	
		    			
		    			if($row->is_admin == 1 )
		    			{
		    				$link_url =  'index.php/admin/jobs/singleView/' . $row->event_id ;
		    			}
		    			else
		    			{
		    				$link_url =  'index.php/jobs/view/' . $row->event_id ;
		    			}
		    			break;

		    		case 'INVOICE_UPDATED':
		    			$notification_text  = INVOICE_UPDATED;	
		    			
		    			if($row->is_admin == 1 )
		    			{
		    				$link_url =  'index.php/admin/jobs/singleView/' . $row->event_id ;
		    			}
		    			else
		    			{
		    				$link_url =  'index.php/jobs/view/' . $row->event_id ;
		    			}
		    			break;

		    		case 'PROCSS_JOB':
		    			$notification_text  = PROCSS_JOB;	
		    			
		    			if($row->is_admin == 1 )
		    			{
		    				$link_url =  'index.php/admin/jobs/singleView/' . $row->event_id ;
		    			}
		    			else
		    			{
		    				$link_url =  'index.php/jobs/view/' . $row->event_id ;
		    			}
		    			break;

		    		case 'PAYMENT_RECEIVED':
		    			$notification_text  = PAYMENT_RECEIVED;	
		    			
		    			if($row->is_admin == 1 )
		    			{
		    				$link_url =  'index.php/admin/invoice/generate/' . $row->event_id ;
		    			}
		    			else
		    			{
		    				$link_url =  '#' ;
		    			}
		    			break;

		    		case 'PAYMENT_ACCEPT':
		    			$notification_text  = PAYMENT_ACCEPT;	
		    			
		    			if($row->is_admin == 1 )
		    			{
		    				$link_url =  'index.php/admin/jobs/singleView/' . $row->event_id ;
		    			}
		    			else
		    			{
		    				$link_url =  'index.php/jobs/view/' . $row->event_id ;
		    			}
		    			break;
		    			
		    		case 'PAYMENT_REJECT':
		    			$notification_text  = PAYMENT_REJECT;	
		    			
		    			if($row->is_admin == 1 )
		    			{
		    				$link_url =  'index.php/admin/jobs/singleView/' . $row->event_id ;
		    			}
		    			else
		    			{
		    				$link_url =  'index.php/jobs/view/' . $row->event_id ;
		    			}
		    			break;
		    				    		
		    		
		    		default:
		    			# code...
		    			break;
		    	}

		    	$row->notification_text = $notification_text;
		    	$row->sender_profile_image = $image_url;
		    	$row->sender_name =  $first_name . ' ' .  $last_name ; //$link_url;

		        $data[] = $row;
		    }
	    	return $data;
		}
		return null;
   	}

	 function record_count($user_id, $is_admin) {
		$this->db->where('status', 1);
		$this->db->where('is_admin', $is_admin);
		$this->db->where('user_id', $user_id);
		$this->db->from('notifications');
        return $this->db->count_all_results();
    }


    function captureAlerts($data , $user_id){
		$this->db->where('user_id', $user_id);
        $this->db->update('notifications', $data);
	}
}