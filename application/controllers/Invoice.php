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

        $this->load->library("invoice_lib");

        $this->load->library('ion_auth');

		if (!$this->ion_auth->logged_in())
		{
			redirect('auth/login');
		}

		$user = $this->ion_auth->user()->row();
		$this->user_id  =  $user->id;

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
               // error_log('empts');
            }
            else {
                //error_log('fine');
                
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

        $data = $this->invoice_lib->generatePdfData($project_id);

        $this->load->view('invoice_pdf', $data);

        $html = ob_get_contents();

        ob_end_clean();

        return $html;
    }

    

    //payment through paypal
    function payment($project_id= 0)
    {
        $data = array();

        $data = $this->invoice_lib->generatePdfData($project_id);

        $data['project_id'] = $project_id;

        //notifications
        $data =  array_merge($data , $this->notification->__getNotifications($this->user_id) );
        $this->load->view('pay_invoice', $data);
    }

    function thankyou()
    {   
        
        $this->load->view('thankyou');
    }
}