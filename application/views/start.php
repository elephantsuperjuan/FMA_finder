<!DOCTYPE html>
<html lang="en">
	<head>
	   <title>FMA-finder:Online visualization tool for network alignment analysis</title>
	   <meta http-equiv="content-type" content="text/html; charset=utf-8" >
	   <meta name="description" content="The FMA-finder tool provides both analysis and visualization of functional module alignments (FMAs)."> 
	   <meta name="keyword" content="functional module alignment,visualization,network alignment" > 
	   <meta name"author" content="Chaojuan Xiang(cjxiang@shu.edu.cn), Jiang Xie(jiangx@shu.edu.cn) from Shanghai University" >
	   <meta name="revised" content="Chaojuan Xiang, 10/9/2015" >
	   <meta name="generator" content="php codeigniter" >
	   <meta name="robots" contect= "all"> 

       <link type="text/css" rel="stylesheet" href="<?php echo base_url('assets/css/bootstrap.min.css') ?>" />
   	   <link type="text/css" rel="stylesheet" href="<?php echo base_url('assets/css/welcome.css')?>"/>
   	   <link type="text/css" rel="stylesheet" href="<?php echo base_url('assets/css/start.css')?>"/>

	</head>

	<body>
	  <header><a href="<?php echo site_url('')?>" data-toggle="tooltip" data-placement="bottom" title="Back to Home" id="home">FMA-finder</a></header>
	  <div class="content">
	  	<div class="txt-title">Discovery of <em>functional module alignment (FMA)</em></div>
	 	<div class="txt">
        We present a tool, namely FMA-finder, which can visualize large-scale network alignments between different species. 
        Moreover, instead of focusing only on the protein pairs to detect functional homologies, functional module alignment (FMA) is proposed in this study. 
        FMAs are pairs of subnetworks that share similar functions, which are more biologically meaningful. 
        The FMA-finder tool provides both analysis and visualization of FMAs.
    	</div>
	 	<div class="main">
	 		<div id="step" class="step-item">
	 			<div class="btn-div checkbox">
				    <label>
				      <input type="checkbox" id="examplebox1"> Use example 1 (Yeast and Human)
				    </label>
				    &nbsp;&nbsp;
				    <label>
				      <input type="checkbox" id="examplebox2"> Use example 2 (C.E. and D.M.)
				    </label>
				 </div>
	 		</div>
	 		<?php echo form_open(site_url('visual/visualize'));?>
			<div id="step1" class="step-item">
				<div class="step-title">
					<img src="<?php echo base_url('assets/img/1.jpg')?>" />
					Step 1: Upload files of two networks and their alignment mapping.</div>
				<div class="step-content">
					<table class="table table-striped">
						<tr><td class="name">Network A: </td>
							<td><input type="file" name="net1_file" id="net1_file" class="file" /></td>
							<td><button type="button" class="upload" id="net1_btn">upload</button></td>
							<td><a href="" id="net1_upload" name="net1_upload" class="file-ok"></a></td>
						</tr>
						<tr><td class="name">Network B: </td>
							<td><input  type="file" id="net2_file" name="net2_file" class="file"/></td>
							<td><button type="button" class="upload" id="net2_btn">upload</button></td>
							<td><a href="" id="net2_upload" class="file-ok"></a></td>
						</tr>
						<tr><td class="name">Mapping of Network A and B: </td>
							<td><input  type="file" id="mapping_file" name="mapping_file" class="file" /></td>
							<td><button type="button" class="upload" id="mapping_btn">upload</button></td>
							<td><a href="" id="mapping_upload" class="file-ok"></a></td>
						</tr>
					</table>
					<input id="net1_gofile" name="net1_gofile" type="hidden"/>
					<input id="net2_gofile" name="net2_gofile" type="hidden"/>

					<div class="step-des">
						<pre>
Example
NetworkA:		NetworkB:		MappingA-B:	
Node1	Node2		Node1	Node2		CE10013 DM6830	
CE16467	CE16239		DM8252	DM14097		CE10014 DM8455	
CE16467	CE16005		DM8252	DM7955		CE10015 DM1021	
CE16467	CE8786		DM8252	DM6912		CE10017 DM7603</pre>
					</div>
				</div>
			</div>
			<div id="step2" class="step-item">
				<div class="step-title">
					<img src="<?php echo base_url('assets/img/2.jpg')?>" />
					Step 2: Generate prepared file.</div>
				<div class="step-content">
					<div class="btn-div">
						<button type="button" class="btn btn-primary" id="generate_btn">Generate</button><em>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;(Instead of example files, generate new files below.)</em>
						<div class="progress">
						  <div id="generate-progress" class="progress-bar" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" style="width:0%;">
						    0
						  </div>
						</div>
					</div>
					<table class="table table-striped">
						<thead>
							<tr><th class="name">Network</th><th>name file</th><th>cluster file</th><th>source file for visualization</th></tr>
						</thead>
						<tbody>
							<tr><td class="name">Network A: </td><td class="file-ok"><a href="" id="net1_namefile" target="_blank">nameA.txt</a></td><td class="file-ok"><a href="" id="net1_treefile" target="_blank">clusteredA.txt</a></td><td class="file-ok"><a href="" id="net1_jsonfile" target="_blank">A.json</a></td></tr>
							<tr><td class="name">Network B: </td><td class="file-ok"><a href="" id="net2_namefile" target="_blank">nameB.txt</a></td><td class="file-ok"><a href="" id="net2_treefile" target="_blank">clusteredB.txt</a></td><td class="file-ok"><a href="" id="net2_jsonfile" target="_blank">B.json</a></td></tr>
						</tbody>
					</table>
					<input id="net1_json" name="net1_json" type="hidden"/>
					<input id="net2_json" name="net2_json" type="hidden"/>

					<div class="step-des">
						<pre>
nameA.txt: node list of Network A
clusterA.txt: clustering result of network A; 
A.json: json file for visualization.</pre>
					</div>
				</div>
			</div>
			<div id="step3" class="step-item">
				<div class="step-title">
					<img src="<?php echo base_url('assets/img/3.jpg')?>" />
					Step 3: Start visualization.</div>
				<div class="step-content">
					<div class="btn-div">
						<button type="submit" class="btn btn-primary" id="visualBtn">Go to Visualization</button>
					</div>
				</div>
			</div>
			</form>
	 	</div>
	  </div>
	  <footer><footer>
	</body>


	<script type="text/javascript" src="<?php echo base_url('assets/js/jquery-2.1.3.min.js') ?>"></script> 
	<script type="text/javascript" src = "<?php echo base_url('assets/js/ajaxfileupload.js');?>"></script> 
	<script type="text/javascript" src="<?php echo base_url('assets/js/bootstrap.min.js') ?>"></script>
	<script type="text/javascript" >

	function setSampleFile($obj,name,href){
		$obj.html(name);
		$obj.attr("href",href);
	}

	function setPostFile($obj,name){
		$obj.val(name);
	}

	//设置文件函数
	function setFile(){
		var box1_flag = $('#examplebox1').attr("checked");
		var box2_flag = $('#examplebox2').attr("checked");
		if(box2_flag){
			// setSampleFile($('#net1_upload'),'JejuniNet.txt',"<?php echo base_url('assets/download/src/JejuniNet.txt')?>");
			// setSampleFile($('#net2_upload'),'EcoliNet.txt',"<?php echo base_url('assets/download/src/EcoliNet.txt')?>");
			// setSampleFile($('#mapping_upload'),'cj-ec.txt',"<?php echo base_url('assets/download/src/cj-ec.txt')?>");

			// setSampleFile($('#net1_upload'),'cj2.txt',"<?php echo base_url('assets/download/src/cj2.txt')?>");
			// setSampleFile($('#net2_upload'),'ec2.txt',"<?php echo base_url('assets/download/src/ec2.txt')?>");
			// setSampleFile($('#mapping_upload'),'cj-ec.txt',"<?php echo base_url('assets/download/src/cj-ec.txt')?>");

			setSampleFile($('#net1_upload'),'ce.txt',"<?php echo base_url('assets/download/src/ce.txt')?>");
			setSampleFile($('#net2_upload'),'dm.txt',"<?php echo base_url('assets/download/src/dm.txt')?>");
			setSampleFile($('#mapping_upload'),'ce-dm.txt',"<?php echo base_url('assets/download/src/ce-dm.txt')?>");

			setPostFile($('#net1_gofile'),"<?php echo base_url('assets/data/ceGOlist.json') ?>");
			setPostFile($('#net2_gofile'),"<?php echo base_url('assets/data/dmGOlist.json') ?>");

			setPostFile($('#net1_json'),"<?php echo base_url('assets/download/num/hga_ce.json')?>");
			setPostFile($('#net2_json'),"<?php echo base_url('assets/download/num/hga_dm.json')?>");

			setSampleFile($('#net1_namefile'),'hga_namelist_ce.txt',"<?php echo base_url('assets/download/num/hga_namelist_ce.txt')?>");
			setSampleFile($('#net2_namefile'),'hga_namelist_dm.txt',"<?php echo base_url('assets/download/num/hga_namelist_dm.txt')?>");

			setSampleFile($('#net1_treefile'),'hga_ce.tree',"<?php echo base_url('assets/download/num/hga_ce.tree')?>");
			setSampleFile($('#net2_treefile'),'hga_dm.tree',"<?php echo base_url('assets/download/num/hga_dm.tree')?>");

			setSampleFile($('#net1_jsonfile'),'hga_ce.json',"<?php echo base_url('assets/download/num/hga_ce.json')?>");
			setSampleFile($('#net2_jsonfile'),'hga_dm.json',"<?php echo base_url('assets/download/num/hga_dm.json')?>");

		}else if(box1_flag){
			setSampleFile($('#net1_upload'),'YeastNet.txt',"<?php echo base_url('assets/download/src/YeastNet.txt')?>");
			setSampleFile($('#net2_upload'),'HumanNet.txt',"<?php echo base_url('assets/download/src/HumanNet.txt')?>");
			setSampleFile($('#mapping_upload'),'yeast-human.txt',"<?php echo base_url('assets/download/src/yeast-human.txt')?>");
			
			setPostFile($('#net1_gofile'),"<?php echo base_url('assets/data/yeastGOlist.json') ?>");
			setPostFile($('#net2_gofile'),"<?php echo base_url('assets/data/humanGOlist.json') ?>");

			setPostFile($('#net1_json'),"<?php echo base_url('assets/download/num/hga_yeastnet.json')?>");
			setPostFile($('#net2_json'),"<?php echo base_url('assets/download/num/hga_humannet.json')?>");

			setSampleFile($('#net1_namefile'),'hga_namelist_YeastNet.txt',"<?php echo base_url('assets/download/num/hga_namelist_YeastNet.txt')?>");
			setSampleFile($('#net2_namefile'),'hga_namelist_HumanNet.txt',"<?php echo base_url('assets/download/num/hga_namelist_HumanNet.txt')?>");
			
			setSampleFile($('#net1_treefile'),'hga_YeastNet.tree',"<?php echo base_url('assets/download/num/hga_YeastNet.tree')?>");
			setSampleFile($('#net2_treefile'),'hga_HumanNet.tree',"<?php echo base_url('assets/download/num/hga_HumanNet.tree')?>");
			
			setSampleFile($('#net1_jsonfile'),'hga_yeastnet.json',"<?php echo base_url('assets/download/num/hga_yeastnet.json')?>");
			setSampleFile($('#net2_jsonfile'),'hga_humannet.json',"<?php echo base_url('assets/download/num/hga_humannet.json')?>");

		}else{
			setSampleFile($('#net1_upload'),'',"");
			setSampleFile($('#net2_upload'),'',"");
			setSampleFile($('#mapping_upload'),'',"");
		}
	}
	//上传文件功能函数
	function postFile(ID,uploadID) 
	{
		$.ajaxFileUpload({
			fileElementId: ID,
			url: "<?php echo site_url('uploadfile/fileUpload');?>",
			dataType: 'jsonp',
			data: {'piType':ID},
			success: function (data) {
				var d = JSON.parse(data);
				if (d.flag = true)
				{
					$("#"+uploadID).attr("href","<?php echo base_url()?>" + d.path);
					$("#"+uploadID).html(d.name);
					alert("upload success");
				}
			},
			error: function (XMLHttpRequest, textStatus, errorThrown) {
				console.log(errorThrown);
			},
			complete: function (XMLHttpRequest, textStatus) {
			}
		});
	}

	$(document).ready(function(){
		$('[data-toggle="tooltip"]').tooltip();
	  	$('#home').tooltip('show');
	  	
		$('#generate-progress').parent().hide();
		//使用例子文件
		var $examplebox1 = $('#examplebox1');
		var $examplebox2 = $('#examplebox2');
		$examplebox1.click(function(){
			if(!$examplebox1.attr("checked")){
				$examplebox1.attr("checked","checked");
				if($examplebox2.attr("checked")=="checked"){
					$('#examplebox2').trigger("click");
				}
			}else{
				$examplebox1.attr("checked",false);
			}
			setFile();
		});
		$examplebox2.click(function(){
			if(!$examplebox2.attr("checked")){
				$examplebox2.attr("checked","checked");
				if($examplebox1.attr("checked")=="checked"){
					$('#examplebox1').trigger("click");
				}
			}else{
				$examplebox2.attr("checked",false);
			}
			setFile();
		});

	  	//上传文件功能
	  	var $upload_btn = $('.upload');
	  	$upload_btn.each(function(i){
	  		var $tr_parent = $upload_btn.eq(i).parent().parent();
	  		var file_origin = $tr_parent.find('.file:first').attr("id");
	  		var file_upload = $tr_parent.find('.file-ok:first').attr("id");

	  		$upload_btn.eq(i).click(function(){
	  			postFile(file_origin,file_upload);
	  		});
	  	});

	  	//分析－页面跳转,改用表单提交
	  	// $('#visualBtn').click(function(){
	  	// 	var net1_json = $('#net1_jsonfile').html();
	  	// 	var net2_json = $('#net2_jsonfile').html();
	  	// 	var visual_url = '/visual/visualize?net1='+net1_json+'&net2='+net2_json;
	  	// 	window.location.href="<?php echo site_url()?>"+visual_url;
	  	// });

	  	var net1, net2, mapping;
	  	$('#generate_btn').click(function(){
	  		net1 = $('#net1_upload').attr("href");
	  		net2 = $('#net2_upload').attr("href");
	  		mapping = $('#mapping_upload').attr("href");
	  		$('#generate-progress').parent().show();

			$.ajax({ 
				type: "POST", 
				url: "<?php echo site_url('visual/generate')?>", 
				data: {net1_file:net1,
					   net2_file:net2,
					   mapping_file:mapping}, 
				dataType:"json",
				success: function(data){ 
					console.log(data);
					$('#generate-progress').attr("aria-valuenow",30);
					$('#generate-progress').html('30%');
					$('#generate-progress').width('30%');

					$('#net1_namefile').attr("href",data.net1_href);
					$('#net1_namefile').html(data.net1_namefile);
					$('#net2_namefile').attr("href",data.net2_href);
					$('#net2_namefile').html(data.net2_namefile);

					generate_cluster();
				} 
			}); 
	  	});

	  	generate_cluster = function(){
	  		net1 = $('#net1_upload').attr("href");
	  		net2 = $('#net2_upload').attr("href");
	  		$.ajax({ 
				type: "POST", 
				url: "<?php echo site_url('visual/generate_cluster')?>", 
				data: {net1_file:net1,
					   net2_file:net2}, 
				dataType:"json",
				success: function(data){ 
					console.log(data);
					$('#generate-progress').attr("aria-valuenow",60);
					$('#generate-progress').html('60%');
					$('#generate-progress').width('60%');

					$('#net1_treefile').attr("href",data.net1_href);
					$('#net1_treefile').html(data.net1_treefile);
					$('#net2_treefile').attr("href",data.net2_href);
					$('#net2_treefile').html(data.net2_treefile);

					generate_json();
				} 
			}); 
	  	}

	  	generate_json = function(){
	  		net1 = $('#net1_upload').attr("href");
	  		net2 = $('#net2_upload').attr("href");
	  		mapping = $('#mapping_upload').attr("href");
	  		$('#generate-progress').parent().show();

			$.ajax({ 
				type: "POST", 
				url: "<?php echo site_url('visual/generate_json')?>", 
				data: {net1_file:net1,
					   net2_file:net2,
					   mapping_file:mapping}, 
				dataType:"json",
				success: function(data){ 
					console.log(data);
					$('#generate-progress').attr("aria-valuenow",100);
					$('#generate-progress').html('100%');
					$('#generate-progress').width('100%');

					$('#net1_jsonfile').attr("href",data.net1_href);
					$('#net1_jsonfile').html(data.net1_jsonfile);
					$('#net2_jsonfile').attr("href",data.net2_href);
					$('#net2_jsonfile').html(data.net2_jsonfile);

					setPostFile($('#net1_json'),data.net1_href);
					setPostFile($('#net2_json'),data.net2_href);

					alert("All files are ok. Now please go to visualize!");
				} 
			}); 
	  	}


	  });
	</script>
</html>