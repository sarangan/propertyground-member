<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 
/**
 * this is to process company details when creating a new company
 */
class Email_processor {

	function __construct()
	{
		$this->ci =& get_instance();
		$this->ci->load->model('template_model');
		$this->ci->load->helper('url');
	}

	function process_email($type, $email_vars, $receiver_email, $sender_email='', $from='', $attachment='')
	{
		$template_record  = $this->ci->template_model->getTemplate($type);
		//error_log('test s');
		//check the template 
		if($template_record->num_rows() > 0){

			//error_log('test p');

			$template_row = $template_record->row();

			$body = $template_row->body;
			$subject = $template_row->subject;

			//replace with data varibales
			//$email_vars['company_name'] = $this->ci->config->item('website_name');
			$email_vars['dashboard_url'] = base_url();

			$email_vars['todays_date'] = date("Y-m-d");
			$email_vars['current_time'] = date('G:ia');
			$email_vars['admin_name'] = $this->ci->config->item('admin_name');
			$email_vars['account_name'] = $this->ci->config->item('account_name');
			$email_vars['website_name'] = $this->ci->config->item('website_name');

			$subject = $this->parse_email_template($subject, $email_vars);
			$body = $this->parse_email_template($body, $email_vars);

			$from = $this->ci->config->item('website_name');
   			$sender_email = $this->ci->config->item('webmaster_email');

			if( ($type == 'SENDINV') || ( $type == 'REMINVO') )
			{	
				$from = $this->ci->config->item('account_name');
   				$sender_email = $this->ci->config->item('invoice_email');

				$this->send_email_attachment($receiver_email, $sender_email, $from, $subject, $body, $attachment);
			}
			elseif( ($type == 'PAYREC') || ( $type == 'PAYACC') || ($type == 'PAYREJ') )
			{
				$from = $this->ci->config->item('account_name');
   				$sender_email = $this->ci->config->item('invoice_email');

   				$this->send_email_html($receiver_email, $sender_email, $from, $subject, $body);
			}
			else
			{
				$this->send_email_html($receiver_email, $sender_email, $from, $subject, $body);
			}
    		

		}


	}


	function parse_email_template($email_template = '', $email_vars = ''){

        if (is_array($email_vars)) {
            
            //loop through array and replace vars in email template

            foreach ($email_vars as $key => $value) {
                $replace_var = "[var.$key]";
                //error_log($replace_var);
                $email_template = str_replace($replace_var, $value, $email_template);
            }

            //remove un-identified [vars]
            return preg_replace("%\[var.[a-z_]+\]%", '', $email_template);
        }
    	else {
        	//remove un-identified [vars]
        	return preg_replace("%\[var.[a-z_]+\]%", '', $email_template);
    	}

	}

    
    function send_emailxxx($type, $email, $subject, $data_mail)
    {
    	//error_log('email start');

    	$from = $this->ci->config->item('website_name') ;
    	$from_email = $this->ci->config->item('webmaster_email') ;

    	$this->ci->load->library('email');
		$this->ci->email->from($from_email , $from );
		$this->ci->email->reply_to($from_email , $from );
		$this->ci->email->to($email);
		$this->ci->email->subject( $subject );
		$this->ci->email->message($this->ci->load->view('email/'.$type.'-html', $data_mail, TRUE));
		$this->ci->email->set_alt_message($this->ci->load->view('email/'.$type.'-txt', $data_mail, TRUE));
		$this->ci->email->send();
		//error_log('email sent');

    }

    function send_email_attachxxx($body, $alt_body, $email, $subject, $attachment)
    {

    	$from = $this->ci->config->item('website_name') ;
    	$from_email = $this->ci->config->item('invoice_email') ;

    	$this->ci->load->library('email');
		$this->ci->email->from($from_email , $from );
		$this->ci->email->reply_to($from_email , $from );
		$this->ci->email->to($email);
		$this->ci->email->subject( $subject );
		$this->ci->email->message($body);
		$this->ci->email->set_alt_message($alt_body);
		$this->ci->email->attach($attachment);
		$this->ci->email->send();
		

    }

    function send_email($receiver_email, $subject, $message)
    {
    	error_log('email start');
    	$from = $this->ci->config->item('website_name');
   		$sender_email = $this->ci->config->item('webmaster_email');

    	$this->ci->load->library('email');

    	$config['protocol'] = 'smtp';
	    $config['smtp_host'] = 'localhost'; //change this
	    $config['smtp_port'] = '25';
	    $config['smtp_user'] = 'info@propertyground.com'; //change this
	    $config['smtp_pass'] = 'shannira123'; //change this
	    $config['mailtype'] = 'html';
	    $config['charset'] = 'iso-8859-1';
	    $config['wordwrap'] = TRUE;

    	//settings
        $this->ci->email->initialize($config);

    	//$this->ci->email->set_mailtype("html");
		$this->ci->email->from($sender_email , $from );
		$this->ci->email->reply_to($sender_email , $from );
		$this->ci->email->to($receiver_email);
		$this->ci->email->subject($subject);
		$this->ci->email->message($message);
		
		error_log('email sent');

		return $this->ci->email->send();

		
    }



    function send_email_html($receiver_email, $sender_email, $from, $subject, $message)
    {
    	error_log('email start');


    	$this->ci->load->library('email');

    	// $config['protocol'] = 'sendmail';
     //    $config['charset'] = 'utf-8';
     //    $config['wordwrap'] = true;
     //    $config['mailtype'] = 'html';
     //    // if ($config['protocol'] == 'sendmail') {
     //    $config['mailpath'] = '/usr/sbin/sendmail'; //if using sendmail
     //    // }

    	$config['protocol'] = 'smtp';
	    $config['smtp_host'] = 'localhost'; //change this
	    $config['smtp_port'] = '25';
	    $config['smtp_user'] = 'info@propertyground.com'; //change this
	    $config['smtp_pass'] = 'shannira123'; //change this
	    $config['mailtype'] = 'html';
	    $config['charset'] = 'iso-8859-1';
	    $config['wordwrap'] = TRUE;


     //    $sender_email = 'info@propertyground.com';
     //    $from = 'info';
     //    $receiver_email = 'sarangan12@gmail.com';
    	// $subject = 'propertyground';
    	// $message = 'testing';

    	//settings
        $this->ci->email->initialize($config);

    	//$this->ci->email->set_mailtype("html");
		$this->ci->email->from($sender_email , $from );
		$this->ci->email->reply_to($sender_email , $from );
		$this->ci->email->to($receiver_email);
		$this->ci->email->subject($subject);
		$this->ci->email->message($message);
		$this->ci->email->send();

		error_log('email sent');
    }


    function send_email_attachment($receiver_email, $sender_email, $from, $subject, $message, $attachment )
    {
    	//error_log('email start');

    	$this->ci->load->library('email');

    	$config['protocol'] = 'smtp';
	    $config['smtp_host'] = 'localhost'; //change this
	    $config['smtp_port'] = '25';
	    $config['smtp_user'] = 'info@propertyground.com'; //change this
	    $config['smtp_pass'] = 'shannira123'; //change this
	    $config['mailtype'] = 'html';
	    $config['charset'] = 'iso-8859-1';
	    $config['wordwrap'] = TRUE;

    	//settings
        $this->ci->email->initialize($config);
		$this->ci->email->from($sender_email , $from );
		$this->ci->email->reply_to($sender_email , $from );
		$this->ci->email->to($receiver_email);
		$this->ci->email->subject($subject);
		$this->ci->email->message($message);
		$this->ci->email->attach($attachment);
		$this->ci->email->send();

		//error_log('email sent');
    }

        
}