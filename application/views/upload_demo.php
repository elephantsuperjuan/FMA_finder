<!DOCTYPE html>
<html>
<body>

	<label for="file">Filename:</label>
	<input type="file" name="file" id="file" onchange="postImg()"/> 
	<img id="original-photo" src="" style="width:100%;margin:0; padding:0; position:relative;"/>

</body>
</html>

<script type="text/javascript" src="<?php echo base_url('assets/js/jquery.min.js')?>"></script>
<script type="text/javascript" src = "<?php echo base_url('assets/js/ajaxfileupload.js');?>"></script>

<script type="text/javascript">
    function postImg() 
	{
		$.ajaxFileUpload({
			fileElementId: 'file',
			url: "<?php echo site_url('uploadfile/fileUpload');?>",
			dataType: 'jsonp',
			data: {'piType':'file'},
			success: function (data) {
				var d = JSON.parse(data);
				if (d.flag = true)
				{
					$("#original-photo").attr("src", "<?php echo base_url()?>" + d.path);
				}
			},
			error: function (XMLHttpRequest, textStatus, errorThrown) {
				console.log(errorThrown);
			},
			complete: function (XMLHttpRequest, textStatus) {
			}
		});
	}

</script>