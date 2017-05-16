<?php
if (! defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class Files_Model extends CI_Model {

	function __construct(){

		parent::__construct();
		$this->load->database();
	}


	function getData(){
		$query = $this->db->get('files');

		return $query;
	}

	function getDataById($id){

		$query = $this->db->get_where('files', array('id' => $id ));

		return $query;
	}

	function getDataByProject($project_id){

		$query = $this->db->get_where('files', array('project_id' => $project_id ));

		return $query;
	}


	function insertData($data){

		$this->db->insert('files', $data);
		$id = $this->db->insert_id();
        return $id;
	}


	function insertBulk($data){

		$this->db->insert_batch('files', $data);
	}


	function updateData($data, $id){

		$this->db->where('id', $id);
        $this->db->update('files', $data);
	}


	function deleteData($id){
		$this->db->delete('files', array('id' => $id));
	}

}