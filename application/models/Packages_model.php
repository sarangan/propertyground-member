<?php
if (! defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class Packages_Model extends CI_Model {

	function __construct(){

		parent::__construct();
		$this->load->database();
	}


	function getData(){
		$query = $this->db->get_where('packages', array('status' =>  1) );

		return $query;
	}

	function getDataById($id){
		$query = $this->db->get_where('packages', array('id' =>  $id, 'status' =>  1 ));

		return $query;
	}

	function insertData($data){

		$this->db->insert('packages', $data);
		$id = $this->db->insert_id();
        return $id;
	}

	function insertBulk($data){

		$this->db->insert_batch('packages', $data);
	}

	function updateData($data, $id){

		$this->db->where('id', $id);
        $this->db->update('packages', $data);
	}

	function getDataAdminView(){
        
        $query = $this->db->query("SELECT packages.*,  GROUP_CONCAT(services.service) as my_service FROM packages 
            LEFT JOIN package_service_link ON 
            package_service_link.package_id = packages.id 
            inner join services on 
            services.service_id = package_service_link.service_id 
            where packages.status = 1 
             GROUP BY packages.id" );

        return $query;
    }


    function getDataPackageView(){
        
        $query = $this->db->query("SELECT packages.*,  GROUP_CONCAT(services.service SEPARATOR ' + ') as my_service,  GROUP_CONCAT(services.service_id ) as my_service_ids FROM packages 
            LEFT JOIN package_service_link ON 
            package_service_link.package_id = packages.id 
            inner join services on 
            services.service_id = package_service_link.service_id 
            where packages.status = 1 
             GROUP BY packages.id" );

        return $query;
    }


}