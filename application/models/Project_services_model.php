<?php
if (! defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class Project_services_Model extends CI_Model {

	function __construct(){

		parent::__construct();
		$this->load->database();
	}

	function getData(){
		$query = $this->db->get('project_services');
		return $query;
	}

	function getDataByProjectId($project_id){
		$query = $this->db->get_where('project_services', array('project_id' => $project_id));
		return $query;
	}

	function getDataServicesProjectId( $project_id)
	{        
        $query = $this->db->query("SELECT project_services.*,  GROUP_CONCAT(services.service) as my_service FROM project_services 
            inner join services on 
            services.service_id = project_services.service_id 
            where project_services.status = 1 
            and project_services.project_id=" .  $project_id );

        return $query;
	}

	function insertData($data){

		$this->db->insert('project_services', $data);
		$id = $this->db->insert_id();
        return $id;
	}

	function insertBulk($data){

		$this->db->insert_batch('project_services', $data);
	}

	function checkDataExistsData($project_id, $service_id)
    {
        $query = $this->db->get_where('project_services', array('project_id' => $project_id, 'service_id' => $service_id  ));

        if($query->num_rows() > 0)
        {
            // exists
            $row = $query->row();
            return $row->id;
        }
        return FALSE;
    }

    function process_services($project_id, $services){
		
		$current_data_rows = $this->getDataByProjectId($project_id );

		$existing_data = array();

		if($current_data_rows->num_rows() > 0 )
		{
			// we have some previous rows 
			
			foreach ($current_data_rows->result() as $current_data_row) {
					
				if( ! in_array ( $current_data_row->service_id , $services ) )
				{
					//data not found in the post array
					$this->db->where('project_id', $project_id);
					$this->db->where('service_id',  $current_data_row->service_id);
					$this->db->delete('project_services');
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
	    						'project_id' =>$project_id ,
	    						'service_id' => $value
	    						);

	    	$data_services[]  = $ss_data;
		}
		if(count($data_services) > 0)
			$this->insertBulk($data_services);

	}

}