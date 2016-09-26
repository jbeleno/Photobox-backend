<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Image extends CI_Controller {

	/**
	 * This method takes a picture file as POST parameter and upload it into 
	 * a temporal folder called '/img' and after that it's uploaded in AWS S3
	 * saving a log in the database.
	 */
	public function upload()
	{
		// Load the upload helper
		$this->load->library('upload', $config);

		// Getting the file metadata
		$metadata = $this->upload->data();

		// Setting up the image file to upload it correctly
		$config['upload_path']          = './img/';
        $config['allowed_types']        = 'gif|jpg|png';
        $config['max_size']             = 10240;
        $config['file_name']			= uniqid('img_');

        if ( ! $this->upload->do_upload('image'))
        {
        	$response = array(
        		'status'	=> 'BAD',
        		'msg' 		=> 'Damn bro, this shit does not work!'
        	);

        	$this->output
	         ->set_content_type('application/json')
	         ->set_output(json_encode($response));
        }
        else
        {
        	
        }
	}
}
