<?php
if (! defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class Services_Model extends CI_Model {

	function __construct(){

		parent::__construct();
		$this->load->database();
	}

	function getData(){
		$query = $this->db->get_where('services', array('status' =>  1) );

		return $query;
	}

	function getDataForJob(){
		$query = $this->db->get_where('services', array('status <=' =>  1) );

		return $query;
	}

	function getDataById($id){
		$query = $this->db->get_where('services', array('service_id' =>  $id, 'status' =>  1 ));

		return $query;
	}

	function getServiceById($id){
		$service = '';
		$query = $this->db->get_where('services', array('service_id' =>  $id, 'status' =>  1 ));

		if($query->num_rows()> 0){
			$row = $query->row();
			$service = $row->service;
		}
		
		return $service;
	}

	function insertData($data){

		$this->db->insert('services', $data);
		$id = $this->db->insert_id();
        return $id;
	}


	function insertBulk($data){

		$this->db->insert_batch('services', $data);
	}


	function updateData($data, $id){

		$this->db->where('service_id', $id);
        $this->db->update('services', $data);
	}


}