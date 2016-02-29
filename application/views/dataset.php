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
   	   <link type="text/css" rel="stylesheet" href="<?php echo base_url('assets/css/welcome.css')?>"/>

	</head>
<style type="text/css">
table{
	font-size: 1.3em;
}
table a{
	text-decoration: underline;
}
</style>
	<body>
	  <header><a href="<?php echo site_url('')?>" data-toggle="tooltip" data-placement="bottom" title="Back to Home" id="home">FMA-finder</a></header>
	  <div class="content">
	  	<div class="txt-title">Dataset for <em>network alignment analysis</em></div>
	 	<div class="txt">
        We conduct our experiments on PIN pairs, such as Homo sapiens (Human) and Saccharomyces cerevisiae (Yeast) PINs that were used in previous researches for network alignment. The Yeast PIN (Y-PIN) contains 2390 proteins with 16,127 interactions, and Human PIN (H-PIN) contains 9141 proteins with 41,456 interactions. The GO annotations of these two species were downloaded from UniProt Database on April 6th, 2015.
    	</div>
	 	<div class="main">
			<table align="center" class="table table-condensed table-hover">
				<thead>
			        <tr>
			          <th class="title" colspan="2">Download</th>
			        </tr>
			    </thead>
			    <tbody>
			    <tr>
			      <td class="name">
			        Datasets:
			      </td>
			      <td class="data">
			        <a href="<?php echo base_url('assets/download/dataset/Yeast-Human.zip') ?>">Yeast and Human</a><br>
					<a href="<?php echo base_url('assets/download/dataset/ce-dm.zip') ?>">C. elegans and D. melanogaster</a><br>
			      </td>
			    </tr> 
			    <tr>
			      <td class="name">
			        Results:
			      </td>
			      <td class="data">
			        <a href="<?php echo base_url('assets/download/dataset/supplement.xlsx') ?>">supplement</a><br><br>
			      </td>
			    </tr> 
			</tbody>
			</table>
	 	</div>
	  </div>
	  <footer>
	  	This work was partially supported by 
	  	<a href="http://biocenter.shu.edu.cn/biocenter/">Center for Bioinformatics</a> at
	  	<a href="http://en.shu.edu.cn/Default.aspx">Shanghai University</a>. 
	  	For more information, please contact <a href="mailto:jiangx@shu.edu.cn">jiangx@shu.edu.cn</a> (Jiang Xie) and <a href="mailto:cjxiang@shu.edu.cn">cjxiang@shu.edu.cn</a> (Chaojuan Xiang)
	  </footer>
	</body>


	<script type="text/javascript" src="<?php echo base_url('assets/js/jquery-2.1.3.min.js') ?>"></script> 
	<script type="text/javascript" src="<?php echo base_url('assets/js/bootstrap.min.js') ?>"></script>
	<script type="text/javascript" >
	  $(document).ready(function(){
	  	$('[data-toggle="tooltip"]').tooltip();
	  });
	</script>
</html>