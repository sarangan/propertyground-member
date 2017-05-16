<?php
if (! defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class Client_Model extends CI_Model {

	function __construct(){

		parent::__construct();
		$this->load->database();
	}

	function getData(){
		$query = $this->db->get_where('clients', array('status' =>  1 ));

		return $query;
	}

	function getDataById($id){
		$query = $this->db->get_where('clients', array('id' =>  $id, 'status' =>  1 ));

		return $query;
	}

	function insertData($data){

		$this->db->insert('clients', $data);
		$id = $this->db->insert_id();
        return $id;
	}


	function insertBulk($data){

		$this->db->insert_batch('clients', $data);
	}


	function updateData($data, $id){

		$this->db->where('id', $id);
        $this->db->update('clients', $data);
	}

	function getDataByUserId($user_id){
		$query = $this->db->query("select * from clients inner join client_user_link on clients.id = client_user_link.client_id where clients.status=1 and client_user_link.user_id=" . $user_id);

		return $query;
	}

	function getCompanyName($id)
	{
		$company_name =  '';
		$query = $this->db->get_where('clients', array('status' =>  1, 'id' =>  $id ));
		if($query->num_rows() > 0 )
		{
			$row = $query->row();
			$company_name = $row->name;
		}

		return $company_name;
	}

}