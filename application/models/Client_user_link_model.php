<?php
if (! defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class Client_user_link_Model extends CI_Model {

	function __construct(){

		parent::__construct();
		$this->load->database();
	}

	function getData(){
		$query = $this->db->get_where('client_user_link', array('status' =>  1 ));

		return $query;
	}

	function getDataById($id){
		$query = $this->db->get_where('client_user_link', array('id' =>  $id, 'status' =>  1 ));

		return $query;
	}

	function getDataByUserId($user_id){
		$query = $this->db->get_where('client_user_link', array('user_id' =>  $user_id, 'status' =>  1 ));

		return $query;
	}

	function insertData($data){

		$this->db->insert('client_user_link', $data);
		$id = $this->db->insert_id();
        return $id;
	}


	function insertBulk($data){

		$this->db->insert_batch('client_user_link', $data);
	}


	function updateData($data, $id){

		$this->db->where('id', $id);
        $this->db->update('client_user_link', $data);
	}

	function updateDataByUserID($data, $user_id){

		$this->db->where('user_id', $user_id);
        $this->db->update('client_user_link', $data);
	}

	function getUsersEmails($client_id){
		$query = $this->db->query("select users.email from client_user_link inner join users on client_user_link.user_id = users.id where client_user_link.client_id =" . $client_id);

		return $query;

	}

	function getClientIdByUserid($user_id){

		$client_id = 0;
		$query = $this->db->get_where('client_user_link', array('user_id' =>  $user_id, 'status' =>  1 ));

		if($query->num_rows() > 0 )
		{
			$row = $query->row();
			$client_id = $row->client_id;
		}
		return $client_id;

	}

	function getFirstUser($client_id)
	{
		$user_id = 0;
		$query = $this->db->get_where('client_user_link', array('client_id' =>  $client_id, 'status' =>  1, 'default_user' => 1 ));

		if($query->num_rows() > 0 )
		{
			$row = $query->row();
			$user_id = $row->user_id;
		}
		else
		{
			$query = $this->db->get_where('client_user_link', array('client_id' =>  $client_id, 'status' =>  1 ));
			if($query->num_rows() > 0 )
			{
				$row = $query->row();
				$user_id = $row->user_id;
			}

		}
		return $user_id;
	}


	function getDefaultUser($client_id)
	{
		$user = '';
		$query = $this->db->query("select users.* from client_user_link inner join users on client_user_link.user_id = users.id where client_user_link.client_id =".  $client_id .
			" and client_user_link.status = 1 and client_user_link.default_user = 1");

		if($query->num_rows() > 0 )
		{
			$user = $query->row();
			//$user_id = $row->user_id;
		}
		else
		{
			$query = $this->db->query("select users.* from client_user_link inner join users on client_user_link.user_id = users.id where client_user_link.client_id =".  $client_id .
			" and client_user_link.default_user = 1");
			if($query->num_rows() > 0 )
			{
				$user = $query->row();
			}

		}
		return $user;
	}


}