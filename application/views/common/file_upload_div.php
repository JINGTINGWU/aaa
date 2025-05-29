<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>無標題文件</title>
</head>
<link rel="stylesheet" href="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8.9/themes/base/jquery-ui.css" type="text/css" />
<link rel="stylesheet" href="<?=base_url()?>js/plupload/jquery.ui.plupload/css/jquery.ui.plupload.css" type="text/css" />
<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.5.1/jquery.min.js"></script>
<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.8.9/jquery-ui.min.js"></script>
<script type="text/javascript" src="http://bp.yahooapis.com/2.4.21/browserplus-min.js"></script>
<script type="text/javascript" src="<?=base_url()?>js/plupload//plupload.js"></script>

<script type="text/javascript" src="<?=base_url()?>js/plupload/plupload.flash.js"></script>
<!--
<script type="text/javascript" src="../../js/plupload.gears.js"></script>
<script type="text/javascript" src="../../js/plupload.silverlight.js"></script>
<script type="text/javascript" src="../../js/plupload.browserplus.js"></script>-->
<script type="text/javascript" src="<?=base_url()?>js/plupload/plupload.html4.js"></script>
<script type="text/javascript" src="<?=base_url()?>js/plupload/plupload.html5.js"></script>
<script type="text/javascript" src="<?=base_url()?>js/plupload/jquery.ui.plupload/jquery.ui.plupload.js"></script>
<body>
<form  method="post" action="dump.php">
	<!-- 上傳時給一個代號，存檔用的。存檔時送出該代號吧!來寫每日跑的單獨一支吧- -->
	<div id="uploader">
		<p>You browser doesn't have Flash, Silverlight, Gears, BrowserPlus or HTML5 support.</p>
	</div>
</form>
<div id="up_msg"></div>
<!--<input type="button" value="-" onclick="alert(document.getElementById('uploader').innerHTML);" />-->


<script type="text/javascript">
function PG_Upload_Save(){
	var content=document.getElementById('uploader').innerHTML;
	var url="<?=$save_url?>";
	mvalue={
			content:content
		};
	parent.AWEA_Ajax(url,mvalue,'');//
}
// Convert divs to queue widgets when the DOM is ready。
$(function() {
	$("#uploader").plupload({
		// General settings
		runtimes : 'html4,flash',//,html5,browserplus,silverlight,gears,html4
		url : '<?=$upload_url?>',
		max_file_size : '10mb',
		max_file_count: 20, // user can add no more then 20 files at a time
		chunk_size : '1mb',
		unique_names : true,
		multiple_queues : true,

		// Resize images on clientside if we can
		//resize : {width : 320, height : 240, quality : 90}, //可設定壓縮檔
		
		// Rename files by clicking on their titles
		rename: true,
		
		// Sort files
		sortable: true,

		// Specify what files to browse for
		filters : [
			{title : "Doc files", extensions : "docx,doc,xls,txt,pdf,xlsx,ppt,pptx"},
			{title : "Zip files", extensions : "zip,rar,7z"},
			{title : "Image files", extensions : "jpg,gif,png"},
			{title : "Any files", extensions : "*"}								
		],

		// Flash settings - 
		flash_swf_url : '<?=base_url()?>js/plupload/plupload.flash.swf',

		// Silverlight settings
		silverlight_xap_url : '<?=base_url()?>js/plupload/plupload.silverlight.xap'
	});

	// Client side form validation
	$('form').submit(function(e) {
        var uploader = $('#uploader').plupload('getUploader');

        // Files in queue upload them first
        if (uploader.files.length > 0) {
            // When all files are uploaded submit form
            uploader.bind('StateChanged', function() {
                if (uploader.files.length === (uploader.total.uploaded + uploader.total.failed)) {
                    $('form')[0].submit();
                }
            });
               
            uploader.start();
        } else
            alert('You must at least upload one file.');

        return false;
    });
	 

});
</script>
</body>
</html>
