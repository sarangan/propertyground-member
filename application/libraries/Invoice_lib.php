<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 
/**
 * this is to process company details when creating a new company
 */
class Invoice_lib {

    function __construct()
    {
        $this->ci =& get_instance();
        
    }


    function generatePdfData($project_id)
    {
        $this->ci->load->model('project_model');
        $this->ci->load->model('client_model');
        $this->ci->load->model('additional_amount_model');
        $this->ci->load->helper('download');
        $this->ci->load->model('project_services_model');
        $this->ci->load->model('packages_model');
        $this->ci->load->model('services_model');
        $this->ci->load->model('invoice_model');
        // $data = file_get_contents($download_path_url);

        $data = array();

        $result = $this->ci->project_model->getDataById($project_id);
    
        //client details
        if($result->num_rows() >  0){
            
            $row = $result->row();
            $client_id = $row->client_id;


            $client_details = $this->ci->client_model->getDataById($client_id);
            if($client_details->num_rows() > 0)
            {
                $client_row = $client_details->row();
                $data['client_name'] =  $client_row->name;
                $data['client_address'] =  $client_row->address;
                $data['client_contact'] =  $client_row->contact;
            }

            $data['address']  = $row->address;
            $data['job_start_on'] = $row->job_start_date . ' ' . $row->job_start_time;
            $data['property_type'] = $row->property_type;
            $data['no_of_rooms'] = ($row->no_of_rooms == STUDIO) ? 1 : $row->no_of_rooms; //$row->no_of_rooms;
            $data['furnishing'] = $row->furnishing;

        }

        //servics 
        $servics_set = $this->ci->project_services_model->getDataByProjectId($project_id);

        if($servics_set->num_rows() > 0)
        {   
            $servics = array();

            $services_str = ' ';

            foreach ($servics_set->result() as $row) {
                array_push($servics, $row->service_id);
                $services_str .=   $this->ci->services_model->getServiceById($row->service_id) . ', ' ;
            }

            $data['services_str'] = rtrim(trim($services_str) , ',');
            //package
            //$data['total_amount_services'] = $this->getTotalAmount($servics, $data['no_of_rooms'] , $data['property_type'], $data['furnishing']);

        }

        //invoice data
        $invoice_resultset = $this->ci->invoice_model->getDataByProjectId($project_id);

        if($invoice_resultset->num_rows() > 0 ){
            //invoice data
            $invoice_set = $invoice_resultset->row();
            $data['invoice_id'] = $invoice_set->id;
            $data['discount'] = $invoice_set->discount;
            $data['advance_payment'] = $invoice_set->advance_payment; 
            $data['balance_amount'] = $invoice_set->balance_amount;
            $data['actual_amount'] = $invoice_set->actual_amount;
            $data['publish'] =  $invoice_set->publish;
            $data['status'] = $invoice_set->status;
            $data['paid'] = $invoice_set->paid;
            $data['notes'] = $invoice_set->notes;
            $data['date_billed'] = $invoice_set->date_billed;
            $data['date_due'] = $invoice_set->date_due;

            //get additional data                
            $data['additional_amt_result'] = $this->ci->additional_amount_model->getDataByInvoiceId($invoice_set->id);

            $add_amount = 0;

            if( $data['additional_amt_result']->num_rows() > 0)
            {
                foreach ($data['additional_amt_result']->result() as $add_row) {
                    
                    $add_amount += $add_row->amount;
                }
            }

           
            $data['total_amount_services'] = floatval($invoice_set->actual_amount) -  $add_amount;

            
        }




        return $data;

    }

}