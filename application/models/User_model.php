<?php
if (! defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class User_Model extends CI_Model {

	function __construct(){

		parent::__construct();
		$this->load->database();
	}

	function getData()
	{
		$result = $this->db->query('Select users.id, users.first_name, users.last_name, users.email, users.username, users.company, users.phone, clients.name as company_name from users 
			 inner join clients on clients.id = users.company where users.active = 1');
		return $result;
	}


	function getDataByClient($company)
	{
		$result = $this->db->get_where('users' , array('company' => $company, 'active' => 1 ));
		return $result;
	}


	function getDataByUserId($id)
	{
		$result = $this->db->get_where('users' , array('id' => $id));
		return $result;
	}


	function geUserFullNameById($id)
	{
		$full_name = '';
		$result = $this->db->get_where('users' , array('id' => $id ));
		if($result->num_rows() > 0)
		{
			$row = $result->row();

			$full_name = $row->first_name . ' ' .  $row->last_name;
		}
		return $full_name;
	}


}