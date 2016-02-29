#!/usr/bin/env php
<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

use Everyman\Neo4j\Client,
	Everyman\Neo4j\Index\NodeIndex,
	Everyman\Neo4j\Relationship,
	Everyman\Neo4j\Node;

require_once 'example_bootstrap.php';

class insert4j extends CI_Controller {

	function __construct()
	{
		parent::__construct();
		$this->load->helper('url');
	}
	public function index()
	{
		$filename = base_url('assets/upload/net-38n.txt');
		var_dump($filename);
		
		$myfile = fopen($filename, "r") or die("Unable to open file!");
		// 输出单行直到 end-of-file

		$client = new Client();
		$proteins = new NodeIndex($client, 'proteins');

		while(!feof($myfile)) {
		  $connStr = preg_split('[\s]',trim(fgets($myfile)));
		  var_dump($connStr);
  		  $node1 = $client->makeNode()->setProperty('name', $connStr[0])->save();
  		  $node2 = $client->makeNode()->setProperty('name', $connStr[1])->save();

  		  $node2->relateTo($node1, 'IN')->save();
  		  $node1->relateTo($node2, 'IN')->save();

		 //  $fromNode = $proteins->findOne('name', $connStr[0]);
			
			// if (!$fromNode) {
			// 	echo "$from not found\n";
			// }

			// $toNode = $proteins->findOne('name', $connStr[1]);
			// if (!$toNode) {
			// 	echo "$to not found\n";
			// }

		}
		fclose($myfile);

		die();

		// $keanu = $client->makeNode()->setProperty('name', 'Keanu Reeves')->save();
		// $laurence = $client->makeNode()->setProperty('name', 'Laurence Fishburne')->save();
		// $jennifer = $client->makeNode()->setProperty('name', 'Jennifer Connelly')->save();
		// $kevin = $client->makeNode()->setProperty('name', 'Kevin Bacon')->save();

		// $actors->add($keanu, 'name', $keanu->getProperty('name'));
		// $actors->add($laurence, 'name', $laurence->getProperty('name'));
		// $actors->add($jennifer, 'name', $jennifer->getProperty('name'));
		// $actors->add($kevin, 'name', $kevin->getProperty('name'));

		// $matrix = $client->makeNode()->setProperty('title', 'The Matrix')->save();
		// $higherLearning = $client->makeNode()->setProperty('title', 'Higher Learning')->save();
		// $mysticRiver = $client->makeNode()->setProperty('title', 'Mystic River')->save();

		// $keanu->relateTo($matrix, 'IN')->save();
		// $laurence->relateTo($matrix, 'IN')->save();

		// $laurence->relateTo($higherLearning, 'IN')->save();
		// $jennifer->relateTo($higherLearning, 'IN')->save();

		// $laurence->relateTo($mysticRiver, 'IN')->save();
		// $kevin->relateTo($mysticRiver, 'IN')->save();
	}

}
