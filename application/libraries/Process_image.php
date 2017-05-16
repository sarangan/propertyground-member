<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 
/**
 * this is to process company details when creating a new company
 */
class Process_image {

	function __construct()
	{
		$this->ci =& get_instance();
		$this->ci->load->database();

		$this->ci->load->library('image_lib');
	}
        
    /*
    *this is the function to resize the image into 30% 50% and 80%
    */
    function resizeImage($source_image, $new_image, $width, $height)
    {
        
        $config['image_library'] = 'gd2';
        //$config['image_library'] = 'imagemagick';
       // $config['library_path']='/usr/bin';//'/opt/local/bin/';//'/usr/bin/convert'; 
        $config['source_image'] = $source_image;
        $config['new_image'] = $new_image;
        $config['create_thumb'] = FALSE;
        $config['maintain_ratio'] = TRUE;
        $config['width']     = $width;
        $config['height']   = $height;
        $config['quality'] =  '90%';        

        $this->ci->image_lib->clear();
        $this->ci->image_lib->initialize($config);
        if ( ! $this->ci->image_lib->resize())
        {
            error_log( $this->ci->image_lib->display_errors() );
        }
        
    } 

    /*
    * this function is to create medium images 
    *
    */
    function createImage($image_width, $image_height , $source_image, $new_image)
    {
        
        $width = $this->ci->config->item('img_width');
        $height = ($this->ci->config->item('img_width') /  $image_width ) * $image_height ;
        $this->resizeImage($source_image, $new_image, $width , $height );

    }


    /*
    * this function to rotate image
    */ 
    function rotate($image , $rotate)
    {
        //$this->load->library('image_lib');

       // $config['image_library'] = 'netpbm';
        $config['image_library']   = 'gd2';
       // $config['library_path'] = '/usr/bin/';
        $config['source_image'] = $image;
        $config['rotation_angle'] = $rotate;
        $config['create_thumb'] = FALSE; //No thumbnail

        $this->ci->image_lib->clear();

        $this->ci->image_lib->initialize($config);

        if ( ! $this->ci->image_lib->rotate())
        {
            error_log( $this->ci->image_lib->display_errors() );
        }
        
    }

    function crop($file_name, $thumbnail, $user_id, $w, $h, $x1,$y1,$x2,$y2, $target_width, $target_height  )
    {
        
    	/*$this->ci->image_moo
                    ->load($file_name)
                   // ->resize_crop($w ,$h)
                    ->crop($x1,$y1,$x2,$y2)
                    //->resize_crop($this->ci->config->item('profile_img_width') ,$this->ci->config->item('profile_img_height') )
                    ->save( $this->ci->config->item('photos') . $user_id .  '/' . $thumbnail) ;
        error_log('cropping end ');

        if ($this->ci->image_moo->errors) {
            error_log($this->ci->image_moo->display_errors() ) ;
            return FALSE;
        }
        else 
        {
        	return TRUE;
        }
        */

        $targ_w = $target_width; //$this->ci->config->item('profile_img_width');
        $targ_h = $target_height ;// $this->ci->config->item('profile_img_height') ;
        $jpeg_quality = 90;

        $src = $file_name;
        $img_r = imagecreatefromjpeg($src);
        $dst_r = ImageCreateTrueColor( $targ_w, $targ_h );

        imagecopyresampled($dst_r,$img_r,0,0,$x1,$y1, $targ_w,$targ_h,$w,$h);
        imagejpeg($dst_r,  $this->ci->config->item('photos') . $user_id .  '/' . $thumbnail);

        return TRUE;

    }     
        
}