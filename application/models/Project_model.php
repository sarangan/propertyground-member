<?php
if (! defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class Project_Model extends CI_Model {

	function __construct(){

		parent::__construct();
		$this->load->database();
	}


	function getData(){
		$query = $this->db->get('projects');

		return $query;
	}

    function getDataById($id){
        $query = $this->db->get_where('projects', array('id' =>  $id ));

        return $query;
    }


	function getDataByClient($client_id){
		$this->load->model('invoice_model');

		$query = $this->db->query("SELECT projects.*,  GROUP_CONCAT(services.service) as my_service, invoice.publish, (select count(files.id) as total_files from files where files.project_id = projects.id ) as total_files, 
            invoice.paid , DATEDIFF(CURDATE() , invoice.date_due ) as days_frm_billed
          FROM projects 
        	LEFT JOIN project_services ON 
        	project_services.project_id = projects.id 
        	left join services on 
        	services.service_id = project_services.service_id 
            LEFT join invoice on 
            projects.id = invoice.project_id 
        	WHERE projects.client_id =" . $client_id . 
        	" GROUP BY projects.id Order by projects.job_start_date DESC , projects.status ASC" );

        // if ($query->num_rows() > 0) {

        //     foreach ($query->result() as $row) {

        //          $invoice_details = $this->invoice_model->getDataByProjectId( $row->client_id ); // TODO invoice

        //          if($invoice_details->num_rows() >0)
        //          {
        //             $invoice_detail =  $invoice_details->row();
        //              $row->invoice_download = $invoice_detail->publish;

        //          }

        //         // if($net_amount > $exceed_amount ){
        //         //     $row->can_download = 2;
        //         // }
        //         // else
        //         // {
        //         //     $row->can_download = 1;
        //         // }

        //         //     $data[] = $row;
        //     }
        //    // return $query;
        // }

		return $query;
	}

    function getDataByUser($user_id){
        $this->load->model('invoice_model');

        $query = $this->db->query("SELECT projects.*,  GROUP_CONCAT(services.service) as my_service, invoice.publish, (select count(files.id) as total_files from files where files.project_id = projects.id ) as total_files, 
            invoice.paid , DATEDIFF(CURDATE() , invoice.date_due ) as days_frm_billed
          FROM projects 
            LEFT JOIN project_services ON 
            project_services.project_id = projects.id 
            left join services on 
            services.service_id = project_services.service_id 
            LEFT join invoice on 
            projects.id = invoice.project_id 
            WHERE projects.link_user_id =" . $user_id . 
            " GROUP BY projects.id Order by projects.job_start_date DESC , projects.status ASC" );

        return $query;
    }

    function getDataAdminView(){
        
        $query = $this->db->query("SELECT projects.*,  GROUP_CONCAT(services.service) as my_service, invoice.publish,  invoice.paid , DATEDIFF(CURDATE() , invoice.date_due ) as days_frm_billed   FROM projects 
            LEFT JOIN project_services ON 
            project_services.project_id = projects.id 
            left join services on 
            services.service_id = project_services.service_id 
            LEFT join invoice on 
            projects.id = invoice.project_id 
             GROUP BY projects.id Order by projects.job_start_date DESC , projects.status ASC" );

        return $query;
    }

	function insertData($data){

		$this->db->insert('projects', $data);
		$id = $this->db->insert_id();
        return $id;
	}

	function myJobsCount($client_id) {
        $this->db->select('id');
        $this->db->where('client_id', $client_id);
        $this->db->where('status', 1);
        $this->db->or_where('status', 4);		
		$this->db->from('projects');
        return $this->db->count_all_results();
    }

    function myJobsCarriedCount($client_id) {
        $this->db->where('status', 4);
        $this->db->where('client_id', $client_id);
        $this->db->from('projects');
        return $this->db->count_all_results();
    }


    function myJobsTotalCount($client_id) {
        $this->db->select('id');        
        $this->db->from('projects');
        $this->db->where('client_id', $client_id);
        return $this->db->count_all_results();

    }


	function fetch_myjobs($limit, $start, $user_id) {
      
        $query = $this->db->query("SELECT projects.*,  GROUP_CONCAT(services.service) as my_service FROM projects 
        	LEFT JOIN project_services ON 
        	project_services.project_id = projects.id 
        	inner join services on 
        	services.service_id = project_services.service_id 
        	WHERE projects.status= 1 and projects.client_id =" . $user_id . 
        	" GROUP BY projects.id LIMIT ". $start .",". $limit );

         return $query;
   }

   function getView($user_id, $project_id){
		
		$query = $this->db->query("SELECT projects.*,  GROUP_CONCAT(services.service) as my_service FROM projects 
        	LEFT JOIN project_services ON 
        	project_services.project_id = projects.id 
        	left join services on 
        	services.service_id = project_services.service_id 
        	WHERE projects.client_id =" . $user_id . 
        	" AND projects.id =" . $project_id .
        	" GROUP BY projects.id Order by projects.job_start_date DESC , projects.status ASC" );

		return $query;
	}

    function getViewAdmin($project_id){
        
        $query = $this->db->query("SELECT projects.*,  GROUP_CONCAT(services.service) as my_service, clients.name as company_name, clients.exceed_amount FROM projects 
            LEFT JOIN project_services ON 
            project_services.project_id = projects.id 
            left join services on 
            services.service_id = project_services.service_id 
            inner join clients on 
            clients.id = projects.client_id  
            WHERE projects.id =" . $project_id .
            " GROUP BY projects.id Order by projects.job_start_date DESC , projects.status ASC" );

        return $query;
    }

    function updateData($data, $id){

        $this->db->where('id', $id);
        $this->db->update('projects', $data);
    }


    function admin_summary_projects()
    {
        $query = $this->db->query("select COALESCE(count(projects.id),0) as num_of_projects, CONCAT ( YEAR(projects.job_start_date),' Q', QUARTER( projects.job_start_date ) ) as monthly  from projects 
group by  monthly order by YEAR(projects.job_start_date) asc , monthly");

        return $query;
    }


    function getDataAdminSummaryView(){
        
         $query = $this->db->query("SELECT projects.*,  GROUP_CONCAT(services.service) as my_service FROM projects 
            LEFT JOIN project_services ON 
            project_services.project_id = projects.id 
            left join services on 
            services.service_id = project_services.service_id 
            where projects.status = 1 or projects.status = 4 or projects.status = 5  
             GROUP BY projects.id Order by projects.job_start_date DESC" );

        return $query;
    }

    function getDataAdminPendingPayment(){
        
         $query = $this->db->query("SELECT projects.*,  GROUP_CONCAT(services.service) as my_service, invoice.date_billed , invoice.balance_amount FROM projects 
            LEFT JOIN project_services ON 
            project_services.project_id = projects.id 
            left join services on 
            services.service_id = project_services.service_id 
            left join invoice on 
            invoice.project_id = projects.id  
            where projects.status = 2 and invoice.publish = 1 and invoice.paid = 0 
             GROUP BY projects.id Order by projects.job_start_date DESC" );

        return $query;
    }

    function getStatusSummary($client_id){

        $query = $this->db->query("SELECT count(projects.id) as total, projects.status from projects WHERE projects.client_id =" . $client_id ." group by projects.status");
        return $query;
    }

    function getStatusAdminSummary(){

        $query = $this->db->query("SELECT count(projects.id) as total, projects.status from projects group by projects.status");
        return $query;
    }

    function getDataAdminNoInvoice(){
        
         $query = $this->db->query("SELECT projects.*,  GROUP_CONCAT(services.service) as my_service, clients.name as company_name FROM projects 
            LEFT JOIN project_services ON 
            project_services.project_id = projects.id 
            left join services on 
            services.service_id = project_services.service_id 
            left join invoice on 
            invoice.project_id = projects.id  
            left join clients on 
            clients.id = projects.client_id  
            where projects.status = 2 and (invoice.publish = 0 or invoice.publish IS NULL)
             GROUP BY projects.id Order by projects.job_start_date DESC" );

        return $query;
    }

    function getProjectUser($project_id)
    {
        $user_id =0;

        $query = $this->db->get_where('projects', array('id' =>  $project_id ));

        if( $query->num_rows() > 0  )
        {
            $row = $query->row();

            $user_id = $row->link_user_id;
        }

        return $user_id;
    }

    function getProjectClient($project_id)
    {
        $client_id =0;

        $query = $this->db->get_where('projects', array('id' =>  $project_id ));

        if( $query->num_rows() > 0  )
        {
            $row = $query->row();

            $client_id = $row->client_id;
        }

        return $client_id;
    }

}

