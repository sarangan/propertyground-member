<?php
if (! defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class Template_Model extends CI_Model {

	function __construct(){

		parent::__construct();
		$this->load->database();
	}


	function getData(){
		$this->db->select('id, subject, body, type, status');
		$query = $this->db->get_where('email_templates', array('status' =>  1) );

		return $query;
	}

	function getDataById($id){
		$this->db->select('id, subject, body, type, status');
		$query = $this->db->get_where('email_templates', array('id' =>  $id, 'status' =>  1 ));

		return $query;
	}

	function getVirtualToursById($id){
		$inventory_name = '';
		$query = $this->db->get_where('email_templates', array('id' =>  $id, 'status' =>  1 ));

		if($query->num_rows()> 0){
			$row = $query->row();
			$inventory_name = $row->inventory_name;
		}
		
		return $inventory_name;
	}

	function insertData($data){

		$this->db->insert('email_templates', $data);
		$id = $this->db->insert_id();
        return $id;
	}


	function insertBulk($data){

		$this->db->insert_batch('email_templates', $data);
	}


	function updateData($data, $id){

		$this->db->where('id', $id);
        $this->db->update('email_templates', $data);
	}

	function getTemplate($type){
		$this->db->select('id, subject, body, type, status');
		$query = $this->db->get_where('email_templates', array('type' =>  $type, 'status' =>  1 ));

		return $query;
	}

}