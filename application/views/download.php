<!DOCTYPE html>
<html lang="en">
<head>
    <meta http-equiv="CONTENT-TYPE" CONTENT="text/html; charset=utf-8">
</head>
<body>

<form action="<?php echo site_url('uploadFile/uploadFile')?>" method="post"
enctype="multipart/form-data">
	<label for="species">Species</label>
	<select id="species">
	  <option value ="HUMAN">Human</option>
	  <option value ="YEAST">Yeast</option>
	  <option value="CE">C. Elegans</option>
	  <option value="DM">D. Melanogaster</option>
	</select>
	<label for="type">Type</label>
	<select id="type">
	  <option value ="ID">ID</option>
	  <option value ="NAME">Name</option>
	</select>
	<label for="number">Number</label>
	<input id="number" name="number" value="20" />(limit for relationship)
	<br />
	<input type="button" id="download" name="download" value="下载" onclick="downloadFile()" />
	<div id="file_div" style="visibility:hidden;"><a id="download_file" href="">点击下载</a></div>
</form>

</body>
</html>

<script type="text/javascript" src="<?php echo base_url('assets/js/jquery.min.js')?>"></script>
<script type="text/javascript" src = "<?php echo base_url('assets/js/ajaxfileupload.js');?>"></script>

<script type="text/javascript">
    function downloadFile() 
	{
		//1.$.ajax带json数据的异步请求  
		var species = $('#species option:selected').val();
		var type = $('#type option:selected').val();
		var number = $('#number').val();

		var aj = $.ajax( {    
		    url:'<?php echo site_url('query4j/getNetwork');?>',// 跳转到 action    
		    data:{ 
	            species : species,
	            type : type,
	            number : number
		    },    
		    type:'post',    
		    cache:false,    
		    dataType:'json',    
		    success:function(data) {    
		        if(data.msg =="true" ){     
		            alert("选取文件成功！"+data.filename);
		            $('#download_file').attr('href',"<?php echo base_url()?>"+data.filename);
		            $('#file_div').attr('style','visibility:visible');
		        }else{    
		            view(data.msg);    
		        }    
		     },    
		     error : function() {    
		          // view("异常！");    
		          alert("异常！");    
		     }    
		});  
	}

</script>