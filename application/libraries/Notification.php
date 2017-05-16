<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 
/**
 * this is to process company details when creating a new company
 */
class Notification {

    function __construct()
    {
        $this->ci =& get_instance();
        
    }

    function __messageRead($project_id, $user_id){

        $this->ci->load->model('notification_model');
        
    }

    function __sendNotification($event_id, $type, $updated_person, $send_who, $is_admin = 0){

		$this->ci->load->model('notification_model');

		//notification
        $data_notification = array(
                                    'user_id' => $send_who,
                                    'event_id' =>  $event_id,
                                    'type' => $type,
                                    'updated_person' => $updated_person,
                                    'status' => 1,
                                    'is_admin' => $is_admin
                                    );
        $this->ci->notification_model->insertData($data_notification);
	}


    function __getNotifications($user_id)
    {
        $this->ci->load->model('notification_model');
        $this->ci->load->model('client_model');
        $this->ci->load->model('client_user_link_model');
        $this->ci->load->model('message_model');
        $this->ci->load->library('ion_auth');

        $data = array();

        $user = $this->ci->ion_auth->user()->row();
        $data['current_usr_first_name'] = $user->first_name;
        $data['current_usr_last_name'] = $user->last_name;


        //getting my mails
        $data['my_mails'] = $this->ci->message_model->fetch_notificationsClient($user_id);
        $data['my_mails_count'] = $this->ci->message_model->record_receive_count($user_id);

        if ($this->ci->ion_auth->get_users_groups($user->id )->row()->id == 1) 
        {

            //getting my notifications
            $data['my_notifications'] = $this->ci->notification_model->fetch_notifications($user_id, 0);
            $data['my_notifications_count'] = $this->ci->notification_model->record_count($user_id, 0);      

        
            
            $data['current_usr_is_admin'] = 1;
            $data['current_usr_company'] = 'Administrator';
            $data['current_usr_image'] = 'res/images/admin.png';
        }
        else
        {

             //getting my notifications
            $data['my_notifications'] = $this->ci->notification_model->fetch_notifications($user_id , 1 );
            $data['my_notifications_count'] = $this->ci->notification_model->record_count($user_id, 1);   


            $data['current_usr_is_admin'] = 0;
            $data['current_usr_image'] = 'res/images/client.png';

            $company_details = $this->ci->client_model->getDataByUserId($user->id);
            //$company_details = $this->ci->client_model->getDataByUserId( $this->ci->client_user_link_model->getClientIdByUserid($user_id) );

            if($company_details->num_rows() > 0 )
            {
                $company = $company_details->row();
                $data['current_usr_company'] = $data['current_usr_first_name'] . ' ' . $data['current_usr_last_name']; //$company->name;

                $company_image = $company->logo;
                if( strlen(trim( $company_image)) > 0 ){
                    $ext = pathinfo($company_image, PATHINFO_EXTENSION);
                    $data['current_usr_image'] = $this->ci->config->item('logos') . basename($company_image, "." . $ext) . '_thumb' . '.' . PHOTOEXT;
                    $data['current_user_full_image'] = $this->ci->config->item('logos') . $company_image;
                }
                else{
                        $data['current_usr_image'] = 'res/images/client.png';
                    }
                // //getting my mails
                // $data['my_mails'] = $this->ci->message_model->fetch_notificationsClient($user->id);
                // $data['my_mails_count'] = $this->ci->message_model->record_receive_count($user->id);

            }
           

            
        }


        return $data;
    }

}