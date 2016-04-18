<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');


class visual extends CI_Controller {

	function __construct()
	{
		parent::__construct();
		$this->load->helper('url');
		$this->load->helper('form');
        $this->load->helper('language');
	}
	public function index()
	{
		$this->load->view('main');
	}
	public function dataset()
	{
		$this->load->view('dataset');
	}
	public function start()
	{
		$this->load->view('start');
	}
	public function generate(){
		require_once 'ppython/php_python.php';

		// $net1 = 'http://localhost/netCompare/assets/download/src/ce.txt';
		// $net2 = 'http://localhost/netCompare/assets/download/src/dm.txt';
		// $_mapping = 'http://localhost/netCompare/assets/download/src/ce-dm.txt';
		$net1 = $_POST["net1_file"];
		$net2 = $_POST["net2_file"];
		$_mapping = $_POST["mapping_file"];

		// $my_base_url = base_url();
		// $net1_relative_path = substr($net1, strlen($my_base_url));
		// $net1 = '.'.$net1_relative_path;
		// $net2_relative_path = substr($net2, strlen($my_base_url));
		// $net2 = '.'.$net2_relative_path;
		//echo $net1;
		//echo $net2;

		$net1_arr = preg_split("/[\/]+/", $net1);
		$net1_file = $net1_arr[count($net1_arr)-1];
		$net1_namefile = ppython('node_count::network_num',$net1_file);
		
		$net2_arr = preg_split("/[\/]+/", $net2);
		$net2_file = $net2_arr[count($net2_arr)-1];
		$net2_namefile = ppython('node_count::network_num',$net2_file);

		$_mapping_arr = preg_split("/[\/]+/", $_mapping);
		$_mapping_file = $_mapping_arr[count($_mapping_arr)-1];
		$_mapping_namefile = ppython('node_count::sif_num',$net1_file,$net2_file,$_mapping_file);

		$retPackage = array('net1_namefile'=>$net1_namefile,'net1_href'=>base_url('assets/download/num').'/'.$net1_namefile,
							'net2_namefile'=>$net2_namefile,'net2_href'=>base_url('assets/download/num').'/'.$net1_namefile,
							'mapping_namefile'=>$_mapping_namefile,'mapping_href'=>base_url('assets/download/num').'/'.$_mapping_namefile,);

		echo json_encode($retPackage);
	}

	public function generate_cluster(){

		// $net1 = 'http://localhost/netCompare/assets/download/src/ce.txt';
		// $net2 = 'http://localhost/netCompare/assets/download/src/dm.txt';
		$net1 = $_POST["net1_file"];
		$net2 = $_POST["net2_file"];
		// echo $net1;
		// echo $net2;

		//system("pwd",$result);  
		//print($result);

		$net1_arr = preg_split("/[\/]+/", $net1);
		$net1_file = $net1_arr[count($net1_arr)-1];
		$net1_file_arr = explode('.',$net1_file); 
		$net1_filename = $net1_file_arr[0];

		$net2_arr = preg_split("/[\/]+/", $net2);
		$net2_file = $net2_arr[count($net2_arr)-1];
		$net2_file_arr = explode('.',$net2_file); 
		$net2_filename = $net2_file_arr[0];

		if(PATH_SEPARATOR==':'){//'Linux系统';
			$net1_cmd = "./application/controllers/ppython/community/convert -i ./assets/download/num/num_".$net1_file." -o ./assets/download/num/".$net1_filename.".bin";
			system($net1_cmd);
			$net1_cmd = "./application/controllers/ppython/community/community ./assets/download/num/".$net1_filename.".bin -l -1 -v > ./assets/download/num/".$net1_filename.".tree";
			system($net1_cmd);

			$net2_cmd = "./application/controllers/ppython/community/convert -i ./assets/download/num/num_".$net2_file." -o ./assets/download/num/".$net2_filename.".bin";
			system($net2_cmd);
			$net2_cmd = "./application/controllers/ppython/community/community ./assets/download/num/".$net2_filename.".bin -l -1 -v > ./assets/download/num/".$net2_filename.".tree";
			system($net2_cmd);

		}else{//windows 是';' 'Windows系统';
			$net1_cmd = "application\\controllers\\ppython\\community\\convert.exe -i assets\\download\\num\\num_".$net1_file." -o assets\\download\\num\\".$net1_filename.".bin";
			system($net1_cmd);
			$net1_cmd = "application\\controllers\\ppython\\community\\community.exe assets\\download\\num\\".$net1_filename.".bin -l -1 -v > assets\\download\\num\\".$net1_filename.".tree";
			system($net1_cmd);

			$net2_cmd = "application\\controllers\\ppython\\community\\convert -i assets\\download\\num\\num_".$net2_file." -o assets\\download\\num\\".$net2_filename.".bin";
			system($net2_cmd);
			$net2_cmd = "application\\controllers\\ppython\\community\\community assets\\download\\num\\".$net2_filename.".bin -l -1 -v > assets\\download\\num\\".$net2_filename.".tree";
			system($net2_cmd);

		}

		$retPackage = array('net1_treefile'=>$net1_filename.".tree",'net1_href'=>base_url('assets/download/num').'/'.$net1_filename.".tree",
		'net2_treefile'=>$net2_filename.".tree",'net2_href'=>base_url('assets/download/num').'/'.$net2_filename.".tree");

		echo json_encode($retPackage);
	}

	public function generate_json(){
		require_once 'ppython/php_python.php';

		// $net1 = 'http://localhost/netCompare/assets/download/src/ce.txt';
		// $net2 = 'http://localhost/netCompare/assets/download/src/dm.txt';
		// $_mapping = 'http://localhost/netCompare/assets/download/src/ce-dm.txt';

		$net1 = $_POST["net1_file"];
		$net2 = $_POST["net2_file"];
		$_mapping = $_POST["mapping_file"];

		$net1_arr = preg_split("/[\/]+/", $net1);
		$net1_file = $net1_arr[count($net1_arr)-1];
		$net1_file_arr = explode('.',$net1_file); 
		$net1_filename = $net1_file_arr[0];

		$net2_arr = preg_split("/[\/]+/", $net2);
		$net2_file = $net2_arr[count($net2_arr)-1];
		$net2_file_arr = explode('.',$net2_file); 
		$net2_filename = $net2_file_arr[0];

		$_mapping_arr = preg_split("/[\/]+/", $_mapping);
		$_mapping_file = $_mapping_arr[count($_mapping_arr)-1];

		// echo $net1_file;
		// echo $net2_file;
		// echo $_mapping_file;
		ppython('tree2D3network::network_json',$net1_file,$net2_file,$_mapping_file);

		$retPackage = array('net1_jsonfile'=>$net1_filename.".json",'net1_href'=>base_url('assets/download/num').'/'.$net1_filename.".json",
		'net2_jsonfile'=>$net2_filename.".json",'net2_href'=>base_url('assets/download/num').'/'.$net2_filename.".json");

		echo json_encode($retPackage);
		
	}

	public function visualization()
	{
		$get_str = $_GET["str"];
		$get_json = json_decode(urldecode($get_str));
		
		$this->data["net1_json"] = $get_json->net1_json;
		$this->data["net2_json"] = $get_json->net2_json;
		$this->data["net1_gofile"] = $get_json->net1_gofile;
		$this->data["net2_gofile"] = $get_json->net2_gofile;

		$this->load->view('visualization',$this->data);
	}
	public function visualize()
	{
		$get_arr = array(
				'net1_json'=>$_POST["net1_json"],
				'net2_json'=>$_POST["net2_json"],
				'net1_gofile'=>$_POST["net1_gofile"],
				'net2_gofile'=>$_POST["net2_gofile"]);
		$get_str = urlencode(json_encode($get_arr));

		redirect('visual/visualization/?str='.$get_str, "refresh");

	}
	
	public function uploadfile()
	{
		$this->load->view('upload_demo');
	}
	public function download()
	{
		$this->load->view('download',$data);
	}

}