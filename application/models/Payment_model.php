<?php
if (! defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class Payment_Model extends CI_Model {

	function __construct(){

		parent::__construct();
		$this->load->database();
	}


	function getData(){
		$query = $this->db->get('payments');

		return $query;
	}

	function getNewData(){
		$query = $this->db->query("select payments.*, projects.id as project_id , projects.address, GROUP_CONCAT(services.service) as my_service, clients.name as company 
			FROM payments 
			inner join invoice on
			payments.invoice_id = invoice.id 
			inner join projects on 
            invoice.project_id = projects.id  
			LEFT JOIN project_services ON 
            project_services.project_id = projects.id 
            left join services on 
            services.service_id = project_services.service_id  
            left join clients on 
            clients.id = projects.client_id             
            where payments.status = 1  
            GROUP BY projects.id Order by payments.updated_date DESC 
             ");

		return $query;
	}

	function getOldData(){
		$query = $this->db->query("select payments.*, projects.id as project_id , projects.address, GROUP_CONCAT(services.service) as my_service, clients.name as company 
			FROM payments 
			inner join invoice on
			payments.invoice_id = invoice.id 
			inner join projects on 
            invoice.project_id = projects.id  
			LEFT JOIN project_services ON 
            project_services.project_id = projects.id 
            left join services on 
            services.service_id = project_services.service_id  
            left join clients on 
            clients.id = projects.client_id    
            GROUP BY projects.id Order by payments.updated_date DESC 
             ");

		return $query;
	}

	function getDataById($id){
		$query = $this->db->get_where('payments', array('id' =>  $id ));

		return $query;
	}

	
	function insertData($data){

		$this->db->insert('payments', $data);
		$id = $this->db->insert_id();
        return $id;
	}


	function insertBulk($data){

		$this->db->insert_batch('payments', $data);
	}


	function updateData($data, $id){

		$this->db->where('id', $id);
        $this->db->update('payments', $data);
	}

}