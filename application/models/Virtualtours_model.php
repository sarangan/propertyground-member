<?php
if (! defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class Virtualtours_Model extends CI_Model {

	function __construct(){

		parent::__construct();
		$this->load->database();
	}


	function getData(){
		$query = $this->db->get_where('virtual_tours', array('status' =>  1) );

		return $query;
	}

	function getDataById($id){
		$query = $this->db->get_where('virtual_tours', array('id' =>  $id, 'status' =>  1 ));

		return $query;
	}

	function getVirtualToursById($id){
		$inventory_name = '';
		$query = $this->db->get_where('virtual_tours', array('id' =>  $id, 'status' =>  1 ));

		if($query->num_rows()> 0){
			$row = $query->row();
			$inventory_name = $row->inventory_name;
		}
		
		return $inventory_name;
	}

	function insertData($data){

		$this->db->insert('virtual_tours', $data);
		$id = $this->db->insert_id();
        return $id;
	}


	function insertBulk($data){

		$this->db->insert_batch('virtual_tours', $data);
	}


	function updateData($data, $id){

		$this->db->where('id', $id);
        $this->db->update('virtual_tours', $data);
	}

	function getAmountByRoom($room)
	{
		$amount =0;
		$query = $this->db->get_where('virtual_tours', array('No_of_Bedrooms' =>  $room, 'status' =>  1 ));

		if($query->num_rows()  > 0 )
		{
			$row = $query->row();
			$amount = $row->amount;
		}

		return $amount;

	}

}