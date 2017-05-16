<?php
if (! defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class Package_services_Model extends CI_Model {

	function __construct(){

		parent::__construct();
		$this->load->database();
	}

	function getData(){
		$this->db->group_by("package_id");
		$query = $this->db->get('package_service_link');
		return $query;
	}

	function getDataByPackageId($package_id){
		$query = $this->db->get_where('package_service_link', array('package_id' => $package_id));
		return $query;
	}

	function insertData($data){

		$this->db->insert('package_service_link', $data);
		$id = $this->db->insert_id();
        return $id;
	}

	function insertBulk($data){

		$this->db->insert_batch('package_service_link', $data);
	}

	function checkDataExistsData($package_id, $service_id)
    {
        $query = $this->db->get_where('package_service_link', array('package_id' => $package_id, 'service_id' => $service_id  ));

        if($query->num_rows() > 0)
        {
            // exists
            $row = $query->row();
            return $row->id;
        }
        return FALSE;
    }

    function process_services($package_id, $services){
		
		$current_data_rows = $this->getDataByPackageId($package_id );

		$existing_data = array();

		if($current_data_rows->num_rows() > 0 )
		{
			// we have some previous rows 
			
			foreach ($current_data_rows->result() as $current_data_row) {
					
				if( ! in_array ( $current_data_row->service_id , $services ) )
				{
					//data not found in the post array
					$this->db->where('package_id', $package_id);
					$this->db->where('service_id',  $current_data_row->service_id);
					$this->db->delete('package_service_link');
				}
				else
				{
					$existing_data[] = $current_data_row->service_id;
				}
				
			}

			
		}

		$diff_services = array_diff( $services , $existing_data );

		$data_services = array();
		foreach ($diff_services as $value) {
			
			$ss_data = array(
	    						'package_id' =>$package_id ,
	    						'service_id' => $value
	    						);

	    	$data_services[]  = $ss_data;
		}
		if(count($data_services) > 0)
			$this->insertBulk($data_services);

	}

}