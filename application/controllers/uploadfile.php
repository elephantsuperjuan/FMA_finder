<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

use Everyman\Neo4j\Client,
	Everyman\Neo4j\Index\NodeIndex,
	Everyman\Neo4j\Relationship,
	Everyman\Neo4j\Node;

require_once 'example_bootstrap.php';

class uploadfile extends CI_Controller {

	function __construct()
	{
		parent::__construct();
		$this->load->helper('url');
	}
	function index(){
		echo site_url();
	}
	function getUploadFolder()
	{
		$max_file_num=500;
		$this->load->helper('file');
		$this->load->helper('directory');
		$parentFolder='./assets/upload';
		$startfolder=0;
		$targetFolder="";
		while (True) { 
			# code...
			$targetFolder=$parentFolder.'/'.$startfolder;
			$files=get_filenames($targetFolder);
			if(is_array($files))
			{
				if(count($files)<$max_file_num)
				{
					break;
				}
			}else
			{
				mkdir($targetFolder);
				//chmod($targetFolder, 777); 
				break;
			}
			$startfolder+=1;
		}
		return $targetFolder;
	}
	function uploadFile($input)
	{
		
		$targetFolder=$this->getUploadFolder();
		$config['upload_path'] = $targetFolder;
		// $config['allowed_types'] = 'gif|jpg|png|jpeg';
		$config['max_size'] = '10000';
		$config['max_width']  = '10240';
		$config['max_height']  = '7680';
		$config['file_name'] = time();
		$this->load->library('upload', $config);


		if(null==$input)
		{
			die("must have Upload ui name ");
		}
		if(!is_array($input))
		{
			if($this->upload->do_upload($input))
			{
				$uploadresult=$this->upload->data();
				
				return $targetFolder.'/'.$uploadresult['file_name'];
			}else{
				//$error = array('error' => $this->upload->display_errors());
				return null;
			}
		}else{
			$data=array();
			foreach ($input as $key => $value) {
				if ($this->upload->do_upload($value))
				{
					$uploadresult=$this->upload->data();
					$data[$value]=$uploadresult['file_name'];
				} 
			}
			return $data;
		}
	}

	private function set_upload_options()
	{   
	//  upload an image options
	    $config = array();
		$config['upload_path'] = './assets/upload/'; 
		// $config['allowed_types'] = 'gif|jpg|png|jpeg|bmp|json|txt';
		$config['allowed_types'] = '*';
		$config['max_size'] = '10000000000';
		$config['file_name']  = time(); 
        $this->newfile_name = $config['file_name'];
	    return $config;
	}
	function fileUpload()
	{
	    $this->load->library('upload', $this->set_upload_options());
		if (!$this->upload->do_upload($_POST['piType']))
		{
			$returnInfo['flag'] = false;	
			$error = array('error' => $this->upload->display_errors());	
			//$data = array('upload_data' => $this->upload->data());
			echo json_encode($error); 
		} 
		else
		{
			$data = array('upload_data' => $this->upload->data());
			//$returnInfo['data'] =$data;

            $returnInfo['name'] = $data['upload_data']['file_name'];
            $returnInfo['path'] = './assets/upload/'.$data['upload_data']['file_name'];
			$returnInfo['flag'] = true;	
			echo json_encode($returnInfo);
		}
	}
}