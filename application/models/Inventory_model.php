<?php
if (! defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class Inventory_Model extends CI_Model {

	function __construct(){

		parent::__construct();
		$this->load->database();
	}


	function getData(){
		$query = $this->db->get_where('inventory', array('status' =>  1) );

		return $query;
	}

	function getDataById($id){
		$query = $this->db->get_where('inventory', array('id' =>  $id, 'status' =>  1 ));

		return $query;
	}

	function getInventoryById($id){
		$inventory_name = '';
		$query = $this->db->get_where('inventory', array('id' =>  $id, 'status' =>  1 ));

		if($query->num_rows()> 0){
			$row = $query->row();
			$inventory_name = $row->inventory_name;
		}
		
		return $inventory_name;
	}

	function insertData($data){

		$this->db->insert('inventory', $data);
		$id = $this->db->insert_id();
        return $id;
	}


	function insertBulk($data){

		$this->db->insert_batch('inventory', $data);
	}


	function updateData($data, $id){

		$this->db->where('id', $id);
        $this->db->update('inventory', $data);
	}

	function getFurnishingAmount($property_type, $inventory_name, $rooms)
	{
		$amount = '0';
		$query = $this->db->get_where('inventory', array('property_type' => $property_type, 'inventory_name' =>$inventory_name , 'status' =>  1 ));

		if($query->num_rows()> 0){
			$row = $query->row();
			$amount = $row->furnished_amount;
		}
		
		return $amount;
	}


	function getUnfurnishingAmount($property_type, $inventory_name, $rooms)
	{
		$amount = '0';
		$query = $this->db->get_where('inventory', array('property_type' => $property_type, 'inventory_name' =>$inventory_name , 'status' =>  1 ));

		if($query->num_rows()> 0){
			$row = $query->row();
			$amount = $row->unfurnished_amount;
		}
		
		return $amount;
	}
}