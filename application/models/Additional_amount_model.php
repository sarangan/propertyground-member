<?php
if (! defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class Additional_amount_Model extends CI_Model {

	function __construct(){

		parent::__construct();
		$this->load->database();
	}

	function getData(){
		$query = $this->db->get_where('additional_amount', array('status' =>  1 ));

		return $query;
	}

	function getDataById($id){
		$query = $this->db->get_where('additional_amount', array('id' =>  $id, 'status' =>  1 ));

		return $query;
	}


	function getDataByInvoiceId($invoice_id){
		$query = $this->db->get_where('additional_amount', array('invoice_id' =>  $invoice_id ));

		return $query;
	}

	function insertData($data){

		$this->db->insert('additional_amount', $data);
		$id = $this->db->insert_id();
        return $id;
	}


	function insertBulk($data){

		$this->db->insert_batch('additional_amount', $data);
	}


	function updateData($data, $id){

		$this->db->where('id', $id);
        $this->db->update('additional_amount', $data);
	}

	function deleteData($id){
		$this->db->delete('additional_amount', array('id' => $id));
	}


}