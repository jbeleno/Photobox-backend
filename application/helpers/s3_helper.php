<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * This helper handle with functions in the API AWS S3, mainly upload,
 * list and delete images.
 *
 * @author Juan Sebastián Beleño Díaz <jsbeleno@gmail.com>
 */

require APPPATH.'/third_party/aws/aws-autoloader.php';
use Aws\S3\S3Client;


if ( ! function_exists('s3_upload')){
   function s3_upload($fileName, $filePath){

   		$bucket = 's3photobox';

   		$client = S3Client::factory(array(
		    'region'  => 'us-west-2',
		    'version' => '2006-03-01',
		    'credentials' => [
		        'key' => AWS_ACCESS_KEY_ID,
		        'secret' => AWS_SECRET_ACCESS_KEY
		    ]
		));

		$result = $client->putObject(array(
		    'Bucket'     	=> $bucket,
		    'Key'        	=> $fileName,
		    'SourceFile' 	=> $filePath,
			'StorageClass' 	=> 'REDUCED_REDUNDANCY',
			'ACL'          	=> 'public-read'
		));

   }
}