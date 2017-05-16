<?php
if (! defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class Invoice_Model extends CI_Model {

	function __construct(){

		parent::__construct();
		$this->load->database();
	}

	function getData(){
		$query = $this->db->get('invoice');

		return $query;
	}

	function getDataById($id){
		$query = $this->db->get_where('invoice', array('id' =>  $id ));

		return $query;
	}


	function getDataByProjectId($project_id){
		$query = $this->db->get_where('invoice', array('project_id' =>  $project_id ));

		return $query;
	}

	function insertData($data){

		$this->db->insert('invoice', $data);
		$id = $this->db->insert_id();
        return $id;
	}


	function insertBulk($data){

		$this->db->insert_batch('invoice', $data);
	}


	function updateData($data, $id){

		$this->db->where('id', $id);
        $this->db->update('invoice', $data);
	}

	function getUnPaid($client_id){
		
		$amount =0;

		$query = $this->db->query('select sum(invoice.balance_amount) as net_total from invoice inner join projects on invoice.project_id = projects.id where projects.client_id=' . $client_id .' and invoice.paid=0 and projects.status = 2');

		if($query->num_rows() > 0)
		{
			$row = $query->row();
			$amount = $row->net_total;
		}

		return $amount;

	}

	function published($project_id){
		
		$publish =0;

		$query = $this->db->query('select invoice.publish from invoice where invoice.project_id=' . $project_id );

		if($query->num_rows() > 0)
		{
			$row = $query->row();
			$publish = $row->publish;
		}

		return $publish;

	}


	function paid($project_id){
		
		$paid =0;

		$query = $this->db->query('select invoice.paid from invoice where invoice.project_id=' . $project_id );

		if($query->num_rows() > 0)
		{
			$row = $query->row();
			$paid = $row->paid;
		}

		return $paid;

	}


	function getClientIdByInvID($id){
		$client_id = '';
		$query = $this->db->query("select projects.client_id as client_id from invoice inner join projects on projects.id = invoice.project_id where invoice.id =" . $id);

		if($query->num_rows()> 0){
			$row = $query->row();
			$client_id = $row->client_id;
		}
		
		return $client_id;
	}



}