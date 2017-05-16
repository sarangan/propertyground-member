<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Invoice extends CI_Controller {

	private $user_id;

	/*
	* 1 = processing
	* 2 = finished
	* 3 = cancel
	*
	*/

	public function __construct()
    {
        parent::__construct();
        // Your own constructor code

        $this->load->helper(array('form', 'url'));
        $this->load->helper('common');
        $this->load->library('form_validation');
        $this->load->library("pagination");
        $this->load->library("notification");

        $this->load->library('ion_auth');

		if (!$this->ion_auth->logged_in())
		{
			redirect('auth/login');
		}

		$user = $this->ion_auth->user()->row();
		$this->user_id  =  $user->id;

		if ($this->ion_auth->get_users_groups($this->user_id )->row()->id != 1)
		{
			 redirect('welcome/index/');
		}

    }


    function generate($project_id=0, $error = 0)
    {
    	$this->load->model('project_model');
    	$this->load->model('client_model');
    	$this->load->model('project_services_model');
    	$this->load->model('packages_model');
        $this->load->model('services_model');
        $this->load->model('additional_amount_model');
        $this->load->model('client_user_link_model');

    	$data = array();


    	if( !empty($project_id) )
    	{
            $data['project_id'] = $project_id;

    		$result = $this->project_model->getDataById($project_id);
    		
    		//client details
    		if($result->num_rows() >  0){
    			
    			$row = $result->row();
    			$client_id = $row->client_id;

                $data['client_id'] = $client_id;
                
    			$client_details = $this->client_model->getDataById($client_id);
    			if($client_details->num_rows() > 0)
    			{
    				$client_row = $client_details->row();
    				$data['client_name'] =  $client_row->name;
                    $data['client_email'] =  $client_row->email;

                    //client users email  
                    $data['users_emails'] = $this->client_user_link_model->getUsersEmails($client_row->id);
    			}

                $data['address']  = $row->address;
                $data['job_start_on'] = $row->job_start_date . ' ' . $row->job_start_time;
                $data['property_type'] = $row->property_type;
                $data['no_of_rooms'] = ($row->no_of_rooms == STUDIO) ? 1 : $row->no_of_rooms;
                $data['furnishing'] = $row->furnishing;



     		}



    		//servics 
    		$servics_set = $this->project_services_model->getDataByProjectId($project_id);

    		if($servics_set->num_rows() > 0)
    		{	
    			$servics = array();

    			$services_str = ' ';

    			foreach ($servics_set->result() as $row) {
    				array_push($servics, $row->service_id);
    				$services_str .=   $this->services_model->getServiceById($row->service_id) . ', ' ;
    			}

               	$data['services_str'] = rtrim(trim($services_str) , ',');
    			//package
    			$data['total_amount_services'] = $this->getTotalAmount($servics, $data['no_of_rooms'] , $data['property_type'], $data['furnishing']);

    		}


            //invoice data
            $invoice_resultset = $this->getInvoiceData($project_id);

            if($invoice_resultset->num_rows() > 0 ){
                //invoice data
                $invoice_set = $invoice_resultset->row();
                $data['invoice_id'] = $invoice_set->id;
                $data['discount'] = $invoice_set->discount;
                $data['advance_payment'] = $invoice_set->advance_payment; 
                $data['balance_amount'] = $invoice_set->balance_amount;
                $data['publish'] =  $invoice_set->publish;
                $data['status'] = $invoice_set->status;
                $data['paid'] = $invoice_set->paid;
                $data['notes'] = $invoice_set->notes;
                $data['date_billed'] = $invoice_set->date_billed;
                $data['date_due'] = $invoice_set->date_due;


                //get additional data                
                $data['additional_amt_result'] = $this->additional_amount_model->getDataByInvoiceId($invoice_set->id);
            }
            
    	}
    	
        $data['error_display'] = $error;

        //notifications
        $data =  array_merge($data , $this->notification->__getNotifications($this->user_id) );
        
    	$this->load->view('invoice_edit', $data);
    }


    function save()
    {
        $this->load->model('invoice_model');
        $this->load->model('project_model');

        $arr = null;
        
        $error =0;

        if(empty($_POST))
        {    
            error_log( 'Empty post details!');
            $error = 1;
        }
        else
        {
            
            $this->form_validation->set_rules("invoice_id", "invoice_id","trim|required");
            $this->form_validation->set_rules("project_id", "project_id","trim|required");
            $this->form_validation->set_rules("actual_amount", "actual_amount","trim|required");
            $this->form_validation->set_rules("total_amount", "total_amount","trim|required");

            if ($this->form_validation->run() == false){
                error_log( 'Required parameter empty');
                $error = 1;
            }
            else
            {
                $invoice_id = $this->input->post('invoice_id');
                $project_id = $this->input->post('project_id');
                $actual_amount = $this->input->post('actual_amount');
                $advance_payment = $this->input->post('advance_payment');
                $discount = $this->input->post('discount');
                $total_amount = $actual_amount - $discount;
                $balance_amount = $this->input->post('total_amount');
                $date_billed = $this->input->post('date_billed');
                $date_due = $this->input->post('date_due');
                $paid = $this->input->post('paid');
                $publish = $this->input->post('publish');
                $notes = $this->input->post('notes');
                $status = 2;

                $data = array(
                    "actual_amount"=> $actual_amount, 
                    "total_amount"=>  $total_amount , 
                    "discount" => $discount, 
                    'advance_payment' => $advance_payment,
                    'balance_amount' => $balance_amount,
                    'paid' => $paid,
                    'publish' => $publish,
                    'status' =>  $status,
                    'date_billed' => $date_billed, 
                    'date_due' => $date_due,  
                    'notes' => $notes);

                $invoice_id = $this->invoice_model->updateData($data, $invoice_id);
                
                if($publish == 1)
                {                    
                    //send notifications 
                    $project_details = $this->project_model->getDataById($project_id);

                    if($project_details->num_rows() > 0)
                    {
                        $project_details_row  = $project_details->row();
                        $this->notification->__sendNotification($project_id, 'INVOICE_UPDATED',  $this->config->item('admin_id'),  $project_details_row->client_id, 1 );
                    }
                    
                }

                $error = 2;
            }
        }

        redirect('/admin/invoice/generate/' . $this->input->post('project_id') . '/'. $error );

    }



    function getInvoiceData($project_id)
    {
        $this->load->model('invoice_model');
        $resultset = null;

        if(!empty($project_id))
        {
            $invoice_set =  $this->invoice_model->getDataByProjectId($project_id);
            
            if($invoice_set->num_rows() > 0)
            {
                // found details
                $resultset = $invoice_set;
            }
            else
            {
                 $resultset = $this->insertDefaultInvoice($project_id);
            }

        }

        return $resultset;
    }


    function insertDefaultInvoice($project_id)
    {
        $this->load->model('invoice_model');


        $date = new DateTime( date('Y-m-d') );
        $date->add(new DateInterval('P14D'));

        $data_invoice = array('project_id' => $project_id, 'status' => 1 , 'date_billed' => date('Y-m-d'), 'date_due' => $date->format('Y-m-d')  );
        $invoice_id = $this->insertInvoiceData($data_invoice);
        
        $invoice_set =  $this->invoice_model->getDataByProjectId($project_id);

        return $invoice_set;
    }


    function insertInvoiceData($data)
    {
        $this->load->model('invoice_model');
         
        $id = $this->invoice_model->insertData($data);

        return $id;

    }


    function addItems()
    {
        $this->load->model('additional_amount_model');
        $arr = null;
         
        if(empty($_POST))
        {    
           error_log( 'Empty post update title!');
        }
        else
        {
            
            $this->form_validation->set_rules("item_name", "item_name","trim|required");
            $this->form_validation->set_rules("item_amount", "item_amount","trim|required");
            $this->form_validation->set_rules("invoice_id", "invoice_id","trim|required");

            if ($this->form_validation->run() == false){
                 error_log( 'Required parameter empty');
            }
            else
            {
                $item_name = $this->input->post('item_name');
                $item_amount = $this->input->post('item_amount');
                $invoice_id = $this->input->post('invoice_id');

                $data = array("name"=> $item_name, "amount"=>  $item_amount , "invoice_id" => $invoice_id );
                $this->additional_amount_model->insertData(  $data );
            }
        }

        redirect('/admin/invoice/generate/' . $this->input->post('project_id'));

    }


    function deleteItem($item_id=0, $project_id=0){

        $this->load->model('additional_amount_model');

        if (!empty($item_id)){
           
            $this->additional_amount_model->deleteData($item_id);

        }

        redirect('/admin/invoice/generate/' . $project_id );

    }
    
    function publish($invoice_id=0, $project_id=0){

        $this->load->model('invoice_model');
        $this->load->model('project_model');
        
        //error_log('publish');

        if (!empty($invoice_id)){
           
           $data = array(                    
                    'publish' => 1,
                    );

            $invoice_id = $this->invoice_model->updateData($data, $invoice_id);
            
            //send notifications 
            $project_details = $this->project_model->getDataById($project_id);

            if($project_details->num_rows() > 0)
            {
                $project_details_row  = $project_details->row();

                $this->notification->__sendNotification($project_id, 'INVOICE_CREATED',  $this->config->item('admin_id'),  $project_details_row->client_id, 1 );
            }
            

        }

        redirect('/admin/invoice/generate/' . $project_id );

    }


    //get packages
    function getTotalAmount($servics, $rooms, $property_type, $furnishing)
    {	
    	$this->load->model('packages_model');
    	$this->load->model('package_services_model');
        $this->load->model('virtualtours_model');


    	$packages = $this->packages_model->getData();

    	$diff = array();
    	$diff_array = array();

        $amount =  0;

        //inventory check
        $inventry_check = in_array(INVID, $servics);
        if($inventry_check)
        {
            /*
            * yes he found the inventory
            * ask the property type
            */
            
            //adding to main amount 
            $amount += $this->getInventoryAmount($rooms, $property_type, $furnishing);

            //remove Inventory ID
            $servics = array_diff($servics, array(INVID) );           

            
        }


        //360 virtual check
        $virtual_tours_check = in_array(VRID, $servics);
        if($virtual_tours_check)
        {
            /*
            * yes he found the virtual tours
            * ask the property type
            */
            
            //adding to main amount 
            $amount += $this->virtualtours_model->getAmountByRoom($rooms);

            //remove virtual tours ID
            $servics = array_diff($servics, array(VRID) );           

            
        }

      
    	if($packages->num_rows() > 0 ){

    		
    		foreach ($packages->result() as $pk) {
    			
    			$package_id = $pk->id;

    			$package_services =  $this->package_services_model->getDataByPackageId($package_id);

    			$temp_services = array();

    			if($package_services->num_rows() > 0)
    			{	
    				foreach ($package_services->result() as $servics_row ) {
    					
    					array_push($temp_services, $servics_row->service_id);
    				}
    			}

               
                //compare arrays

                $result_array = array();

                // search for compleate package
                if(!array_diff($servics, $temp_services) && !array_diff($temp_services, $servics)){

                    // foreach ($temp_services as $ke) {
                    //     # code...
                    //     error_log($ke);
                    // }
                    // this is the package
                   
                    return ($amount + $this->getPackageAmount($package_id, $rooms) );
                }

                //$result_array = array_diff($servics, $temp_services);
                if(array_intersect($temp_services, $servics) ===  $temp_services )
                {
                    
                    // this package is including inside the services
                    $result_array = array_diff($servics, $temp_services);
                }

    			if(count($result_array) != 0)
    			{
                    
    				$diff[$package_id] = count($result_array);
    				$diff_array[$package_id] = $result_array;
    			}


    		}

    	}
    	
    	if(count($diff) > 0 )
    	{           
    		//$extra_package_key =  key(reset(array_slice(asort($diff), -1, 1 ) ) );
            asort($diff);
            $slice = reset($diff);

    		$extra_package_key =  key( $diff ) ;

    		$extra_services = $diff_array[$extra_package_key];

    		$package_amount = $this->getPackageAmount($extra_package_key, $rooms);
            
    		foreach ($extra_services as $service) {
    			$package_amount += $this->getServiceAmount($service, $rooms);
    		}

    		return ($amount + $package_amount);
    	}

    	
    	foreach ($servics as $service) {
    		$amount += $this->getServiceAmount($service, $rooms);
    	}

    	return $amount;
    	
    }


    function getPackageAmount($package_id, $rooms)
    {
    	$this->load->model('packages_model');

    	$amount =0;
    	if(!empty($package_id))
		{
			$packages = $this->packages_model->getDataById($package_id);
			if($packages->num_rows() > 0){
				$packages_row = $packages->row();

                if($rooms <= 3)
                {
                    $amount =  $packages_row->amount_1_3;
                }
                elseif( ($rooms > 3) && ($rooms <= 6) )
                {
                    $amount =  $packages_row->amount_4_6;
                }
                elseif( ($rooms > 6 ))
                {
                    $amount =  $packages_row->amount_6_above;
                }

				
			}
		}

		return $amount;
    }


    function getServiceAmount($service_id, $rooms)
    {
    	$this->load->model('services_model');
    	
    	$amount =0;
    	if(!empty($service_id))
		{
			$services = $this->services_model->getDataById($service_id);
			if($services->num_rows() > 0){
				$services_row = $services->row();
				
                if($rooms <= 3)
                {
                    $amount =  $services_row->amount_1_3;
                }
                elseif( ($rooms > 3) && ($rooms <= 6) )
                {
                    $amount =  $services_row->amount_4_6;
                }
                elseif( ($rooms > 6 ))
                {
                    $amount =  $services_row->amount_6_above;
                }

			}
		}

		return $amount;
    }


    function getInventoryAmount($rooms, $property_type, $furnishing)
    {
        $this->load->model('inventory_model');

        $inventory_amount =0;

            switch ($rooms) {

                case STUDIO:
                    
                    if($furnishing == 'FURNISHED')
                    {
                        $inventory_amount = $this->inventory_model->getFurnishingAmount($property_type, 'STUDIO', $rooms);
                    }
                    elseif ($furnishing == 'UNFURNISHED')
                    {
                        $inventory_amount = $this->inventory_model->getUnfurnishingAmount($property_type, 'STUDIO', $rooms);
                    }

                    break;

                case ABTEN:

                    if($furnishing == 'FURNISHED')
                    {
                        $inventory_amount = $this->inventory_model->getFurnishingAmount($property_type, 'ABOVE 10 BEDROOMS', $rooms);
                    }
                    elseif ($furnishing == 'UNFURNISHED')
                    {
                        $inventory_amount = $this->inventory_model->getUnfurnishingAmount($property_type, 'ABOVE 10 BEDROOMS', $rooms);
                    }
                    
                    break;

                case 1:

                    if($furnishing == 'FURNISHED')
                    {
                        $inventory_amount = $this->inventory_model->getFurnishingAmount($property_type, '1 BEDROOM', $rooms);
                    }
                    elseif ($furnishing == 'UNFURNISHED')
                    {
                        $inventory_amount = $this->inventory_model->getUnfurnishingAmount($property_type, '1 BEDROOM', $rooms);
                    }
                    
                    break;

                default:

                    if($furnishing == 'FURNISHED')
                    {
                        $inventory_amount = $this->inventory_model->getFurnishingAmount($property_type, $rooms. ' BEDROOMS', $rooms);
                    }
                    elseif ($furnishing == 'UNFURNISHED')
                    {
                        $inventory_amount = $this->inventory_model->getUnfurnishingAmount($property_type, $rooms.' BEDROOMS', $rooms);
                    }
                    
                    break;
            }

            return $inventory_amount;
    }

    
    function generateKey($length=8) {
        $s = strtoupper(md5(uniqid(rand(),true))); 
        $guidText = 
        substr($s,0,$length); 
        return $guidText;
    }

    function pdfDownload()
    {
       

        header('Set-Cookie: fileDownload=true; path=/');
        header('Cache-Control: max-age=60, must-revalidate');
        
        $arr = null;

        if(empty($_POST)){  
            //$arr = array ('status'=> 'we need more info to process file!');
            error_log('empty pdf');
        }
        else
        {

            $this->form_validation->set_rules("fileid", "fileid","trim|required");
            
            if ($this->form_validation->run() == false){
                //$arr = array ('status'=> 'Required parameter empty' );
                error_log('empts');
                error_log('comes here fuck');
            }
            else {
                error_log('fine');
                
                $project_id = $this->input->post('fileid');

                $filename = 'invoice_' . $this->generateKey() . '.pdf';

                $download_path_url =  base_url() . $this->config->item('pdf') .  $filename;
               
                $html = $this->generateHtml($project_id);

                /*------------------------------- GENERATE PDF------- (mpdf class)------------------------/
                * Take generated html and passes it to mpdf class pdf output is saved in variable $pdf
                *
                *----------------------------------------------------------------------------------------*/
                $this->load->library('dompdf_lib');
                $dompdf = new DOMPDF();

                // Convert to PDF
                //$this->dompdf->set_paper(DEFAULT_PDF_PAPER_SIZE, 'portrait');
                $this->dompdf->set_paper("A4", "portrait");
                $this->dompdf->load_html($html);
                $this->dompdf->render();
                $pdf = $this->dompdf->output();
                /*-------------------------------------- GENERATE PDF END -------------------------------*/


                force_download($filename,$pdf);
            
            }
        }

    }

    function generateHtml($project_id)
    {
        //generate the invoice view as normal, but buffer it to variable ($html)
        ob_start();

        $data = $this->generatePdfData($project_id);

        $this->load->view('invoice_pdf', $data);

        $html = ob_get_contents();

        ob_end_clean();

        return $html;
    }

    function generatePdfData($project_id)
    {
        $this->load->model('project_model');
        $this->load->model('client_model');
        $this->load->model('additional_amount_model');
        $this->load->helper('download');
        $this->load->model('project_services_model');
        $this->load->model('packages_model');
        $this->load->model('services_model');

        // $data = file_get_contents($download_path_url);

        $data = array();

        
        $result = $this->project_model->getDataById($project_id);
    
        //client details
        if($result->num_rows() >  0){
            
            $row = $result->row();
            $client_id = $row->client_id;


            $client_details = $this->client_model->getDataById($client_id);
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
            $data['no_of_rooms'] = $row->no_of_rooms;
            $data['furnishing'] = $row->furnishing;

        }



        //servics 
        $servics_set = $this->project_services_model->getDataByProjectId($project_id);

        if($servics_set->num_rows() > 0)
        {   
            $servics = array();

            $services_str = ' ';

            foreach ($servics_set->result() as $row) {
                array_push($servics, $row->service_id);
                $services_str .=   $this->services_model->getServiceById($row->service_id) . ', ' ;
            }

            $data['services_str'] = rtrim(trim($services_str) , ',');
            
            //package
            $data['total_amount_services'] =  $this->getTotalAmount($servics, $data['no_of_rooms'] , $data['property_type'], $data['furnishing']);

        }

        //invoice data
        $invoice_resultset = $this->getInvoiceData($project_id);

        if($invoice_resultset->num_rows() > 0 ){
            //invoice data
            $invoice_set = $invoice_resultset->row();
            $data['invoice_id'] = $invoice_set->id;
            $data['discount'] = $invoice_set->discount;
            $data['advance_payment'] = $invoice_set->advance_payment; 
            $data['balance_amount'] = $invoice_set->balance_amount;
            $data['publish'] =  $invoice_set->publish;
            $data['status'] = $invoice_set->status;
            $data['paid'] = $invoice_set->paid;
            $data['notes'] = $invoice_set->notes;
            $data['date_billed'] = $invoice_set->date_billed;
            $data['date_due'] = $invoice_set->date_due;


            //get additional data                
            $data['additional_amt_result'] = $this->additional_amount_model->getDataByInvoiceId($invoice_set->id);
        }


        return $data;

    }

    function sendMail()
    {
        $this->load->model('project_model');

        if(empty($_POST['send'])){  
            //$arr = array ('status'=> 'we need more info to process file!');
           
        }
        else
        {

            $this->form_validation->set_rules("project_id", "project_id","trim|required");
            
            if ($this->form_validation->run() == false){
                //$arr = array ('status'=> 'Required parameter empty' );
                
            }
            else 
            {
                               
                $project_id = $this->input->post('project_id');

                $this->load->library('email_processor');
               // $subject = "Property Ground send you an invoice";

                $body = $this->generateHtml($project_id);
               // $body_alt ="Please login to PropertyGround portal to see your invoice...";

                $txt_emails = $this->input->post('add_emails');
                $check_emails = $this->input->post('useremails[]');

                $email_vars = array();

                $row_project_set = $this->project_model->getDataById($project_id);

                if($row_project_set->num_rows() > 0)
                {
                    $row_project =  $row_project_set->row();
                    $email_vars['address'] =  $row_project->address;
                }


                if(is_array($check_emails))
                {
                   
                    $receiver_emails = implode(',', $check_emails);
                }
                else
                {
                     $receiver_emails =$check_emails;
                }
                               

                if( strlen(trim( $txt_emails)) > 0 )
                {
                    $txt_emails = rtrim(trim($txt_emails) , ',');

                    $receiver_emails .= ',' . $txt_emails;
                }

                $filename = 'invoice_' . $this->generateKey() . '.pdf';
                $download_path_url = $this->config->item('pdf') .  $filename;

                $this->load->library('dompdf_lib');
                $dompdf = new DOMPDF();

                // Convert to PDF
                //$this->dompdf->set_paper(DEFAULT_PDF_PAPER_SIZE, 'portrait');
                $this->dompdf->set_paper("A4", "portrait");
                $this->dompdf->load_html($body);
                $this->dompdf->render();
                $pdf = $this->dompdf->output();

                file_put_contents( $download_path_url , $pdf);


                $attachment = $download_path_url;
               

                // send to mail 
                //$this->email_processor->send_email_attach($body, $body_alt,   $receiver_emails  , $subject , $attachment);

                $this->email_processor->process_email('SENDINV', $email_vars, $receiver_emails, '', '', $attachment );

            }

        }

         redirect('/admin/invoice/generate/' . $this->input->post('project_id'));
        
    }


    function sendRemMail()
    {
        $this->load->model('project_model');
        $this->load->model('user_model');
        $this->load->model('client_user_link_model');
        
        $arr = array();

        if(empty($_POST)){  
           $arr = array ('status'=> 1);
        }
        else
        {

            $this->form_validation->set_rules("project_id", "project_id","trim|required");
            
            if ($this->form_validation->run() == false){
                $arr = array ('status'=> 2 );
                               
            }
            else 
            {
                               
                $project_id = $this->input->post('project_id');

                $this->load->library('email_processor');

                $body = $this->generateHtml($project_id);
                
                $email_vars = array();
                $receiver_email = '';


                $row_project_set = $this->project_model->getDataById($project_id);

                if($row_project_set->num_rows() > 0)
                {
                    $row_project =  $row_project_set->row();
                    $email_vars['address'] =  $row_project->address;

                    // this is admin view so updates will be send to clients
                    // $default_user = $this->client_user_link_model->getDefaultUser($row_project->client_id );
                    // if(isset($default_user) )
                    // {
                    //     $receiver_email = $default_user->email;
                    // }

                    $user_details =  $this->user_model->getDataByUserId($row_project->link_user_id);           
                    if($user_details->num_rows() > 0)
                    {
                        $user_detail = $user_details->row();

                        $receiver_email = $user_detail->email; //$default_user->email;
                        $email_vars['job_user_name'] =  $user_detail->first_name . ' ' . $user_detail->last_name;
                    }

                }                


                $filename = 'invoice_' . $this->generateKey() . '.pdf';
                $download_path_url = $this->config->item('pdf') .  $filename;

                $this->load->library('dompdf_lib');
                $dompdf = new DOMPDF();

                // Convert to PDF
                //$this->dompdf->set_paper(DEFAULT_PDF_PAPER_SIZE, 'portrait');
                $this->dompdf->set_paper("A4", "portrait");
                $this->dompdf->load_html($body);
                $this->dompdf->render();
                $pdf = $this->dompdf->output();

                file_put_contents( $download_path_url , $pdf);

                $attachment = $download_path_url;

                $this->email_processor->process_email('REMINVO', $email_vars, $receiver_email, '', '', $attachment );

                $arr = array ('status'=> 3);

                
            }

        }

        echo json_encode($arr);
        
    }


}