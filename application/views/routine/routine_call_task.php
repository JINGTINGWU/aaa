<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>無標題文件</title>
<script type="text/javascript" src="<?=base_url()?>js/jquery.js"></script>
<script type="text/javascript" src="<?=base_url()?>js/url.min.js"></script>
<script>
$(document).ready(function () {
//alert(url('?key_id'));
PG_EXE_ACTION('exe_once',url('?key_id'));
});

function PG_EXE_ACTION(status,key_id){
	 document.getElementById('action_type').value=status;
	 document.getElementById('key_id').value=key_id;
	 //document.getElementById('edit_form').target='phf';
	 //document.getElementById('edit_form').submit();
	 //document.getElementById('action_type').value='new_routine';
         $.post("<?=site_url('ecp_routine/routine_bk/')?>", {action_type: status,key_id:key_id}, function(result){
             //alert(result.replace(/\r\n|\n/g,""));
             //result=result.replace(/\r\n|\n/g,"");
             result=result.slice(-1);
             //alert(result);
         if(result==true)
         {              
            window.opener=null;
            window.open("","_self");
            window.close();
         }
    });	 
}
</script>
</head>
<body>
<div>
<div>New</div>
<form method="post" name="edit_form" id="edit_form" action="<?=site_url('ecp_routine/routine_bk/')?>" target="phf" >
<input type="hidden" name="key_id" id="key_id" value="0" />
<input type="hidden" name="action_type" id="action_type" value="new_routine" />
<input type="text" name="zrs_title" />
<input type="button" onclick="document.getElementById('edit_form').submit();" value="Send" />
</form>

<iframe name="phf" id="phf" style="display:none;"></iframe>
</body>
</html>
