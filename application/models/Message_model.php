<?php
if (! defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class Message_Model extends CI_Model {

	function __construct(){

		parent::__construct();
		$this->load->database();
	}


	function getData(){
		$query = $this->db->get('message');

		return $query;
	}

	function getDataByUserProject($project_id , $user_id){

		$query = $this->db->query("select message.*, UNIX_TIMESTAMP(message.updated_date) as mytime , (select CONCAT_WS(' ', users.first_name, users.last_name) as sender_name from users where users.id=message.sender_id) as sender_name, 
			(select CONCAT_WS(' ', users.first_name, users.last_name) as reseiver_name from users where users.id=message.receiver_id) as receiver_name  
		  from message where (message.sender_id= " . $user_id . " or message.receiver_id = " .  $user_id . ") and message.project_id=" .  $project_id  ." ORDER BY message.updated_date ASC " );

		return $query;
	}

	function getDataByProjectAdmin($project_id ){

		$query = $this->db->query("select message.*, UNIX_TIMESTAMP(message.updated_date) as mytime , (select CONCAT_WS(' ', users.first_name, users.last_name) as sender_name from users where users.id=message.sender_id) as sender_name, 
			(select CONCAT_WS(' ', users.first_name, users.last_name) as reseiver_name from users where users.id=message.receiver_id) as receiver_name  
		  from message where message.project_id=" .  $project_id  ." ORDER BY message.updated_date ASC " );

		return $query;
	}


	function insertData($data){

		$this->db->insert('message', $data);
		$id = $this->db->insert_id();
        return $id;
	}


	function fetch_notificationsClient($user_id) {
      
        $query = $this->db->query("SELECT message.*, users.first_name as sender_firstname , users.last_name as sender_lastname 
        	 FROM message 
        	INNER JOIN users ON 
        	message.sender_id = users.id
        	WHERE message.status <= 2 and message.receiver_id =" . $user_id . 
        	" ORDER BY message.updated_date DESC" );

		if ($query->num_rows() > 0) {
		    // foreach ($query->result() as $row) { (select 1) as sender_profile_image
		    	
		    // 	if($row->company != 'ADMIN')
		    // 	{
		    // 		$row->sender_profile_image = '';
		    // 	}
		    // 	else
		    // 	{
		    // 		$row->sender_profile_image = 'res/images/admin.png';
		    // 	}

		    //     $data[] = $row;
		    // }
	    	return $query;
		}
		return null;
   	}

   	function fetch_notificationsAdmin($user_id) {
      
        $query = $this->db->query("SELECT message.*, clients.name as sender_firstname , '' as sender_lastname 
        	 FROM message 
        	INNER JOIN clients ON 
        	message.sender_id = clients.id
        	WHERE message.status <= 2 and message.receiver_id =" . $user_id . 
        	" ORDER BY message.updated_date DESC" );

		if ($query->num_rows() > 0) {
		    // foreach ($query->result() as $row) {
		    	
		    // 	if($row->company != 'ADMIN')
		    // 	{
		    // 		$row->sender_profile_image = '';
		    // 	}
		    // 	else
		    // 	{
		    // 		$row->sender_profile_image = 'res/images/admin.png';
		    // 	}

		    //     $data[] = $row;
		    // }
	    	return $query;
		}
		return null;
   	}


   	 function record_receive_count($user_id) {
		$this->db->where('status <=', 1);
		$this->db->where('receiver_id', $user_id);
		$this->db->from('message');
        return $this->db->count_all_results();
    }

    function updateRead($project_id, $user_id){

    	$data = array('status' => 2);

		$this->db->where('project_id', $project_id);
		$this->db->where('receiver_id', $user_id);
        $this->db->update('message', $data);
	}


}