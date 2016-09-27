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
		// Load the s3 helper
		$this->load->helper('s3');

		// Getting the file extention
		$path = $_FILES['image']['name'];
		$ext = pathinfo($path, PATHINFO_EXTENSION);

		// Setting up the image file to upload it correctly
		$config['upload_path']          = './img/';
        $config['allowed_types']        = 'gif|jpg|png';
        $config['max_size']             = 10240;
        $config['file_name']			= uniqid('img_').'.'.$ext;

        // Load the upload class
        $this->load->library('upload', $config);

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
        	$metadata = $this->upload->data();

        	$filePath = $metadata['full_path'];
        	$fileName = $metadata['client_name'];

        	s3_upload($fileName, $filePath);
        }
	}
}
