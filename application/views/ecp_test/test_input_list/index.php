<script>
function handleKeyPress(evt)
{
	var on_no=parseInt(document.getElementById('on_select').value);
	if($('#search_list').contents().find('#search_value_'+on_no).length>0){
		$('#search_list').contents().find('#search_value_'+on_no).attr('className','off_select');
	}
	var nbr = (window.event)?event.keyCode:evt.which;
	switch(nbr){
		case 40://下
			document.getElementById('search_here').blur();
			if(on_no==-1){
				on_no=0;
			}else{
				on_no++;
			}
			
			if($('#search_list').contents().find('#search_value_'+on_no).length>0){
				//alert(on_no);

				window.search_list.PG_JumpFocus(on_no);
				//$('#search_list').contents().find('#search_tag_'+on_no).focus();
				
			}else{
				on_no=0;
				window.search_list.PG_JumpFocus(on_no);
				//$('#search_list').contents().find('#search_tag_'+on_no).focus();
			}

			//$('#search_list').contents().find('#search_value_'+on_no).focus();
			//$('#search_list').contents().find('#search_tag_'+on_no).blur();
			$('#search_list').contents().find('#search_value_'+on_no).attr('className','on_select');
			document.getElementById('on_select').value=on_no;
			
			break;
		case 38://上
			document.getElementById('search_here').blur();
			if(on_no==-1){
				on_no=-1;
			}else{
				on_no--;
			}
			if($('#search_list').contents().find('#search_value_'+on_no).length>0){
				//alert(on_no);
				//$('#search_list').contents().find('#search_tag_'+on_no).focus();
				window.search_list.PG_JumpFocus(on_no);
			}else{
				on_no=0;
				window.search_list.PG_JumpFocus(on_no);
				//$('#search_list').contents().find('#search_tag_'+on_no).focus();	
			}
			//$('#search_list').contents().find('#search_tag_'+on_no).blur();
			//$('#search_list').contents().find('#search_tag_'+on_no).mouseout();
			$('#search_list').contents().find('#search_value_'+on_no).attr('className','on_select');
			document.getElementById('on_select').value=on_no;
			break;
			
		case 13://查or儲
			if($('#search_list').contents().find('#search_value_'+on_no).length>0){
				document.getElementById('search_here').value=$('#search_list').contents().find('#search_value_'+on_no).html();
				document.getElementById('search_div').style.display='none';
				document.getElementById('search_list').src='<?=base_url($this->m_controller.'/blank')?>';
				document.getElementById('on_select').value=-1;		
				document.getElementById('select_status').value='Y';	
				document.getElementById('search_here').focus();	
			}
			break;
	}
	//40 f下 38上 13->enter
	return true;
}
document.onkeydown= handleKeyPress
</script>
<!--
<script language="javascript">
//偵測瀏覽器版本

var browser=navigator.appName;
if(browser=="Netscape"){    //如果瀏覽器為Netscape或者Firefox
    //開始監聽鍵盤事件
    document.captureEvents(Event.KEYDOWN)
    document.onkeydown=function(event){
        if(event.which==37){
            //key code 37為→
            alert("你按下了下一頁");
        }
        else if(event.which==39){
            //key code 39為←
            alert("你按下了上一頁");
        }
    }
}
else{    //假設瀏覽器不為Nescape則猜測為ie
    //開始監聽鍵盤事件
    document.onkeydown = function(){
        if(event.whitch==37){
            //key code 37為→
            alert("你按下了下一頁");
        }
        else if(event.whitch==39){
            //key code 39為←
            alert("你按下了上一頁");
        }
    }
}
</script>-->
<style>
.mm_cal{
	width:90%;
	border:#CCCCCC 2px solid;
}
.mm_cal th{
	height:30px;
	font-weight:bolder;
	padding-left:5px;
	text-align:left;
}
.mm_cal td{
	height:80px;
	padding-left:5px;
	padding-top:5px;
	border:#CCCCCC 1px solid;
	vertical-align:top;
}
.s-date2{
	color:#FF0000;
}
.cal_today{
	background:#CCCCCC;
}
.nodate{
	color:#CCCCCC;
}
</style>
<!--
<div>
	<table width="90%">
    	<tr><th>公告日期</th><th>公告內容</th><th>發表人</th></tr>
        <tr><td>2012-05-18</td><td>testtest</td><td>Admin</td></tr>
    </table>
</div>
<div>
	<table width="90%">
    	<tr><th>通知日期</th><th>通知內容</th><th>通知類型</th></tr>
        <tr><td>2012-05-18</td><td>testtest</td><td>Admin</td></tr>
    </table>
</div>alert("<?=base_url($this->m_controller.'/blank')?>");document.getElementById('search_list').src='<?=base_url($this->m_controller.'/blank')?>';
-->
<div align="center" onclick="document.getElementById('select_status').value='N';	document.getElementById('on_select').value=-1;document.getElementById('search_div').style.display='none';document.getElementById('search_list').src='<?=base_url($this->m_controller.'/blank')?>';">
<div>

<div style="padding-2px;">
<div style="position:absolute;left:25%;background:#FFFFFF;">
<table>
<tr><td>
<input type="text" id="search_here" style="width:600px;" onkeypress="PG_GetList(this.value);" onblur="PG_CloseList();" />
<div id="search_div" style="position:relative;top:-5px;left:0px;display:none;">
<iframe id="search_list" name="search_list" frameborder="0" style="border:1px solid #CCCCCC;width:600px;height:300px;" ></iframe>
</div>
</td></tr>
</table>
</div>
</div>

<div>here
文字文字文字???<br /><br />
文字文字文字???<br />文字文字文字?<br />內容內容內容內容內容br />內容內容內容內容內
內容內容內容內<br />
內容內容內容內
內容內容內容內<br />
內容內容內容內<br />
內容內容內容內<br />
內容內容內容<br />
內容內容內容<br />內
內容內容內容內<br />內容內容內容內<br />
內容內容內容內<br />
內容內容內容<br />
內容內容內容<br />內
內容內容內容內<br />內容內容內容內<br />
內容內容內容內<br />
內容內容內容<br />
內容內容內容<br />內
內容內容內容內<br />內容內容內容內<br />
內容內容內容<br />內
內容內容內容內<br />內容內容內容內<br />
內容內容內容內<br />

內容內容內容<br />
內容內容內容<br />內

內容內容內容內<br />內容內容內容內<br />
內容內容內容內<br />
內容內容內容<br />內容內容內容內<br />內
</div>
<input type="hidden" id="on_select" value="-1" />
<input type="hidden" id="select_status" value="N" />
<script>
/*
function PG_GetList(search_here){
	if(search_here!=''){ document.getElementById('search_div').style.display='block';	}
	document.getElementById('search_list').src="<?=base_url($this->m_controller.'/search_list')?>/"+encodeURI(search_here);
}*/
function PG_GetList(search_here,e)
{
var keycode;
if (window.event) keycode = window.event.keyCode;
else if (e) keycode = e.which;
else return true;
if (keycode == 13)
   {
   		if(document.getElementById('select_status').value=='N'){
			document.getElementById('search_div').style.display='block';
			document.getElementById('search_list').src="<?=base_url($this->m_controller.'/search_list')?>/"+encodeURI(search_here);		
		}
		document.getElementById('select_status').value='N';
   return false;
   }
else
   return true;
}
function PG_CloseList(){
	if(document.getElementById('search_div').mouseout==true){
		alert('yes');
	}
}
</script>
</div>  
      