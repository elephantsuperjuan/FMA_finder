<!DOCTYPE html>
<html lang="en">
	<head>
	   <title>FMA-finder:Online visualization tool for network alignment analysis</title>
	   <meta http-equiv="content-type" content="text/html; charset=utf-8" >
	   <meta name="description" content="The FMA-finder tool provides both analysis and visualization of functional module alignments (FMAs)."> 
	   <meta name="keyword" content="functional module alignment,visualization,network alignment" > 
	   <meta name="author" content="Chaojuan Xiang(cjxiang@shu.edu.cn), Jiang Xie(jiangx@shu.edu.cn) from Shanghai University" >
	   <meta name="revised" content="Chaojuan Xiang, 10/9/2015" >
	   <meta name="generator" content="php codeigniter" >
	   <meta name="robots" contect= "all"> 


       <link type="text/css" rel="stylesheet" href="<?php echo base_url('assets/css/bootstrap.min.css') ?>" />
   	   <link href="<?php echo base_url('assets/css/welcome.css')?>" rel="stylesheet" type="text/css" />

	</head>

	<body>
	  <header>
	  	<a href="<?php echo site_url('')?>" data-toggle="tooltip" data-placement="bottom" title="Back to Home" id="home">FMA-finder</a>
	  </header>
	  <div class="content">
	  	<div class="txt-title">Online visualization tool for <br/> <em>network alignment analysis</em></div>
	 	<div class="txt">
        Functional module alignments (FMAs) are pairs of subnetworks that share similar functions, which are biologically meaningful. 
        The FMA-finder tool visualizes large-scale network alignments between different species and provides both analysis and visualization of FMAs.
    	</div>
	 	<div class="main">
	 		<div class="nav-item" for="dataset">
	 			<div class="item-title">
	 				Dataset
	 			</div>
	 			<a href="<?php echo site_url('visual/dataset')?>"><img class="item-img" src="<?php echo base_url('assets/img/dataset.png')?>"></img></a>
	 			<div class="item-des">dataset, result</div>
	 		</div>
	 		<div class="nav-item" for="vedio">
	 			<div class="item-title">
	 				Vedio Demo
	 			</div>
	 			<img class="item-img" src="<?php echo base_url('assets/img/vedio.png')?>" id="vedioSample"></img>
	 			<div class="item-des">Screencasts, to be continued</div>
	 		</div>
	 		<div class="nav-item" for="start">
	 			<div class="item-title">
	 				Get started
	 			</div>
	 			<a href="<?php echo site_url('visual/start')?>"><img class="item-img" src="<?php echo base_url('assets/img/demo.png')?>"></img></a>
	 			<div class="item-des">visualization</div>
	 		</div>
	 	</div>
	  </div>
	  <footer>
	  	This work was partially supported by 
	  	<a href="http://biocenter.shu.edu.cn/biocenter/">Center for Bioinformatics</a> at
	  	<a href="http://en.shu.edu.cn/Default.aspx">Shanghai University</a>. 
	  	For more information, please contact <a href="mailto:jiangx@shu.edu.cn">jiangx@shu.edu.cn</a> (Jiang Xie) and <a href="mailto:cjxiang@shu.edu.cn">cjxiang@shu.edu.cn</a> (Chaojuan Xiang)
	  </footer>
	</body>

	<div class="modal" id="vedioModal" tabindex="-1" role="dialog" aria-labelledby="vedioModalLabel" aria-hidden="true">
	  <div class="modal-dialog large-dialog">
	    <div class="modal-content">
	      	<div class="modal-header">
	        	<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
	        	<h4 class="modal-title" id="searchNodeModalLabel">Demo screencasts</h4>
	      	</div>
	        <div class="modal-body">
	        	<video id="videosample" controls="" class="vedio_fixedpx"><source src="<?php echo base_url('assets/download/fma-finder.mp4') ?>" type="video/mp4"></video>
	        	 </div>
	        <div class="modal-footer">
	            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
	        </div>
	    </div>
	  </div>
	</div>

	<script type="text/javascript" src="<?php echo base_url('assets/js/jquery-2.1.3.min.js') ?>"></script> 
<script type="text/javascript" src="<?php echo base_url('assets/js/bootstrap.min.js') ?>"></script>
	<script type="text/javascript" >
	  $(document).ready(function(){
	  	 $('#vedioSample').click(function(){
	        $('#vedioModal').modal('show');
	    });
	  	$('[data-toggle="tooltip"]').tooltip();
	  	$('#home').tooltip('show');
	  });
	</script>
</html>