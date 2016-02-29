<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

use Everyman\Neo4j\Client,
	Everyman\Neo4j\Index\NodeIndex,
	Everyman\Neo4j\Relationship,
	Everyman\Neo4j\Node,
	Everyman\Neo4j\Cypher\Query;

require_once 'example_bootstrap.php';

class query4j extends CI_Controller {

	function __construct()
	{
		parent::__construct();
		$this->load->helper('url');
	}
	public function index()
	{
		$from = 'RPL28';
		$to = 'RPL14B';

		$client = new Client();
		$actors = new NodeIndex($client, 'actors');
		


		$fromNode = $actors->findOne('NAME', $from);
		if (!$fromNode) {
			echo "$from not found\n";
			exit(1);
		}

		$toNode = $actors->findOne('NAME', $to);
		if (!$toNode) {
			echo "$to not found\n";
			exit(1);
		}

		// Each degree is an actor and movie node
		$maxDegrees = 6;
		$depth = $maxDegrees * 2;

		$path = $fromNode->findPathsTo($toNode)
			->setmaxDepth($depth)
			->getSinglePath();

		if ($path) {
			// foreach ($path as $i => $node) {
			// 	if ($i % 2 == 0) {
			// 		$degree = $i/2;
			// 		echo str_repeat("\t", $degree);
			// 		echo $degree . ': ' .$node->getProperty('NAME');
			// 		if ($i+1 != count($path)) {
			// 			echo " was in ";
			// 		}
			// 	} else {
			// 		echo $node->getProperty('NAME') . " with\n";
			// 	}
			// }
			echo "YES\n";
		}
	}
	public function getRelationship()
	{
		$client = new Client();
		// $transaction = $client->beginTransaction();
		// $query = new Query($client, "MATCH n WHERE n.SPECIES = {species} and n.NAME = {name} RETURN n", array('species' => 'YEAST','name' => 'RPL28'));
		// $result = $transaction->addStatements($query);
		// $transaction->commit();

		$queryString = "MATCH n WHERE n.SPECIES = {species} and n.NAME = {name} RETURN n";
		$query = new Query($client, $queryString, array('species' => 'YEAST','name' => 'RPL28'));
		$result = $query->getResultSet();

		foreach ($result as $row) {
		    echo $row['x']->getProperty('NAME') . "\n";
		    echo $row['x']->getProperty('SPECIES') . "\n";
		    echo $row['x']->getProperty('ID') . "\n";
		}
		
	}
	public function getNode()
	{
		$upload_path = './assets/download/'; 
		$fileName = $upload_path.time().'.txt'; // 获取需要创建的文件名称

		if (!is_dir($upload_path)) mkdir(site_url($upload_path), 0777); // 使用最大权限0777创建文件
		if (!file_exists($fileName)) { // 如果不存在则创建
			$client = new Client();

			$queryString = "MATCH n WHERE n.SPECIES = {species} RETURN n LIMIT 10";
			$query = new Query($client, $queryString, array('species' => 'HUMAN'));
			$result = $query->getResultSet();

			$myfile = fopen($fileName, "w") or die("Unable to open file!");
			foreach ($result as $row) {
			    fwrite($myfile, $row['x']->getProperty('NAME')."\r\n");
			}
			fclose($myfile);
			$returnInfo['filename'] = $fileName;
		}
		$returnInfo['msg'] = "true";
		echo json_encode($returnInfo);
	}
	public function getNetwork()
	{
		$upload_path = './assets/download/'; 
		$fileName = $upload_path.time().'.txt'; // 获取需要创建的文件名称
		
		set_time_limit(0);//设置脚本执行时间无限长

		if (!is_dir($upload_path)) mkdir(site_url($upload_path), 0777); // 使用最大权限0777创建文件
		if (!file_exists($fileName)) { // 如果不存在则创建
			$client = new Client();

			$number = (int)$_POST['number'];
			$limit_str = '';
			if($number){
				$limit_str = " LIMIT {number}";
			}

			$queryString = "MATCH (m)-[:connected]->(n) WHERE m.SPECIES = {species} RETURN m.".$_POST['type'].", n.".$_POST['type'].$limit_str;
			// var_dump($queryString);
			$query = new Query($client, $queryString, array('species' => $_POST['species'],'number' => (int)$_POST['number']));
			$result = $query->getResultSet();

			$myfile = fopen($fileName, "w") or die("Unable to open file!");
			foreach ($result as $row) {
			    fwrite($myfile, $row[0].' '.$row[1]."\r\n");
			}
			fclose($myfile);
			$returnInfo['filename'] = $fileName;
		}
		$returnInfo['msg'] = "true";
		echo json_encode($returnInfo);
	}
}
