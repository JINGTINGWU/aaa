// JavaScript Document

function PL_DivClick()
{	
	if(InputList.pg_list_on=='N'){
		document.getElementById(InputList.select_status).value='N';	
		document.getElementById(InputList.on_select).value=-1;
		document.getElementById(InputList.info[InputList.on].search_div).style.display='none';
		document.getElementById(InputList.info[InputList.on].search_list).src=InputList.blank_url;	
		
	}
	InputList.pg_list_on='N';	
	//InputList.onfocus=''; 
}
	
function handleKeyPress(evt)
{	
	var on_no=parseInt(document.getElementById(InputList.on_select).value);
	if($('#'+InputList.info[InputList.on].search_list).contents().find('#'+InputList.info[InputList.on].search_value+'_'+on_no).length>0){
		$('#'+InputList.info[InputList.on].search_list).contents().find('#'+InputList.info[InputList.on].search_value+'_'+on_no).attr('className',InputList.css_off_select);
	}
	var nbr = (window.event)?event.keyCode:evt.which;
	switch(nbr){
		case 40://下
			
			document.getElementById(InputList.info[InputList.on].search_here).blur();
			if(on_no==-1){
				on_no=0;
			}else{
				on_no++;
			}
			
			if($('#'+InputList.info[InputList.on].search_list).contents().find('#'+InputList.info[InputList.on].search_value+'_'+on_no).length>0){
				PL_InputList_Focus(on_no);		
			}else{
				on_no=0;
				PL_InputList_Focus(on_no);
			}
			$('#'+InputList.info[InputList.on].search_list).contents().find('#'+InputList.info[InputList.on].search_value+'_'+on_no).attr('className',InputList.css_on_select);
			document.getElementById(InputList.on_select).value=on_no;
			
			break;
		case 38://上
			document.getElementById(InputList.info[InputList.on].search_here).blur();
			if(on_no==-1){
				on_no=-1;
			}else{
				on_no--;
			}
			if($('#'+InputList.info[InputList.on].search_list).contents().find('#'+InputList.info[InputList.on].search_value+'_'+on_no).length>0){
				PL_InputList_Focus(on_no);
			}else{
				on_no=0;
				PL_InputList_Focus(on_no);
			}
			$('#'+InputList.info[InputList.on].search_list).contents().find('#'+InputList.info[InputList.on].search_value+'_'+on_no).attr('className',InputList.css_on_select);
			document.getElementById(InputList.on_select).value=on_no;
			break;
			
		case 13://查or儲	
			if(InputList.onfocus==InputList.info[InputList.on].search_here){
				
				search_here=document.getElementById(InputList.info[InputList.on].search_here).value;
   				//if(document.getElementById('select_status').value=='N'){
					if(typeof(InputList.info[InputList.on].width)!='undefined'){
						document.getElementById(InputList.info[InputList.on].search_div).style.width=InputList.info[InputList.on].width+'px';
						document.getElementById(InputList.info[InputList.on].search_list).style.width=InputList.info[InputList.on].width+'px';
					}
					document.getElementById(InputList.info[InputList.on].search_div).style.display='block';
					PL_AdjustListPosition();					
					document.getElementById(InputList.info[InputList.on].search_list).src=InputList.info[InputList.on].url+"/"+encodeURI(search_here);	
				//}
				
				document.getElementById('select_status').value='N';
			}else{
				
				if($('#'+InputList.info[InputList.on].search_list).contents().find('#'+InputList.info[InputList.on].search_value+'_'+on_no).length>0){
					var search_here_value=$('#'+InputList.info[InputList.on].search_list).contents().find('#'+InputList.info[InputList.on].search_value+'_'+on_no).html();
					//alert(search_here_value);
					if(InStr(search_here_value,'<label>')){
						var search_here_value=GetTagV(search_here_value,'label');
					}
					switch(InputList.info[InputList.on].input_type){
						case 'A':
							document.getElementById(InputList.info[InputList.on].search_here).value=document.getElementById(InputList.info[InputList.on].search_here).value+search_here_value;
							break;
						case 'R':
							document.getElementById(InputList.info[InputList.on].search_here).value=search_here_value;
							break;
					}
					if(typeof(InputList.info[InputList.on].label_id)!='undefined'){
						 document.getElementById(InputList.info[InputList.on].label_id).innerHTML=search_here_value;
					}
					if(typeof(InputList.info[InputList.on].title_id)!='undefined'){
						 document.getElementById(InputList.info[InputList.on].title_id).title=search_here_value;
					}
					if(typeof(InputList.info[InputList.on].input_id)!='undefined'){
						document.getElementById(InputList.info[InputList.on].input_id).value=$('#'+InputList.info[InputList.on].search_list).contents().find('#'+InputList.info[InputList.on].search_value+'_'+on_no).attr('abbr');
						if(typeof(InputList.info[InputList.on].onchange)!='undefined'){

							PG_BK_Action(InputList.info[InputList.on].onchange);
						}
					}
					
					document.getElementById(InputList.info[InputList.on].search_div).style.display='none';
					document.getElementById(InputList.info[InputList.on].search_list).src=InputList.blank_url;
					document.getElementById(InputList.on_select).value=-1;		
					document.getElementById(InputList.select_status).value='Y';//Y	
					document.getElementById(InputList.info[InputList.on].search_here).focus();	
					InputList.onfocus=InputList.info[InputList.on].search_here;
				}
			}

			break;
	}
	//40 f下 38上 13->enter
	return true;
}
document.onkeydown= handleKeyPress

function PL_CloseList(){
	InputList.onfocus='';
}
/*
function PL_GetList()
{	
	
	
	var keycode;
	if (window.event) keycode = window.event.keyCode;
	else if (e) keycode = e.which;
	else return true;
		if (keycode == 13)
   		{
			search_here=document.getElementById(InputList.info[InputList.on].search_here).value;
   			if(document.getElementById(InputList.select_status).value=='N'){
				document.getElementById(InputList.info[InputList.on].search_div).style.display='block';
				PL_AdjustListPosition();
				document.getElementById(InputList.info[InputList.on].search_list).src=InputList.info[InputList.on].url+"/"+encodeURI(search_here);	
			}
			document.getElementById(InputList.select_status).value='N';
   			return false;
   		}
	else
   	return true;
	
}*/

function PL_Full_List(on_select){ //
	PL_ChangePL(on_select);
	document.getElementById(InputList.info[InputList.on].search_here).focus();	
	document.getElementById(InputList.select_status).value='N';
	if(typeof(InputList.info[InputList.on].width)!='undefined'){
		document.getElementById(InputList.info[InputList.on].search_div).style.width=InputList.info[InputList.on].width+'px';
		document.getElementById(InputList.info[InputList.on].search_list).style.width=InputList.info[InputList.on].width+'px';
	}
	document.getElementById(InputList.info[InputList.on].search_div).style.display='block';
	PL_AdjustListPosition();
	document.getElementById(InputList.info[InputList.on].search_list).src=InputList.info[InputList.on].url+"/";	//
	InputList.pg_list_on='Y';	
}

function PL_ChangePL(on_select)
{	//
	if(on_select!=InputList.on){
		document.getElementById(InputList.info[InputList.on].search_div).style.display='none';
		document.getElementById(InputList.info[InputList.on].search_list).src=InputList.blank_url;
		document.getElementById(InputList.on_select).value=-1;	
	}
	InputList.on=on_select;
	InputList.onfocus=InputList.info[InputList.on].search_here;//
}

function PL_AdjustListPosition()
{
	var pl_top=35; var pl_left=10;
	
	if(typeof(InputList.top)!='undefined') pl_top=InputList.top;
	if(typeof(InputList.left)!='undefined') pl_left=InputList.left;
	if(typeof(InputList.info[InputList.on].top)!='undefined') pl_top=InputList.info[InputList.on].top;
	if(typeof(InputList.info[InputList.on].left)!='undefined') pl_left=InputList.info[InputList.on].left;

	var PG_top=$("#"+InputList.info[InputList.on].search_here).offset().top-pl_top;//35
	var PG_left=$("#"+InputList.info[InputList.on].search_here).offset().left-pl_left;//10
	$("#"+InputList.info[InputList.on].search_div).css('position','absolute');
	$("#"+InputList.info[InputList.on].search_div).css('z-index',9999999);
	$("#"+InputList.info[InputList.on].search_div).css('left',PG_left);
	$("#"+InputList.info[InputList.on].search_div).css('top',PG_top);
}
function getElementPos(elementId) {
 var ua = navigator.userAgent.toLowerCase();
 var isOpera = (ua.indexOf('opera') != -1);
 var isIE = (ua.indexOf('msie') != -1 && !isOpera); // not opera spoof
 var el = document.getElementById(elementId);
 if(el.parentNode === null || el.style.display == 'none') {
  return false;
 }      
 var parent = null;
 var pos = [];     
 var box;     
 if(el.getBoundingClientRect)    //IE
 {         
  box = el.getBoundingClientRect();
  var scrollTop = Math.max(document.documentElement.scrollTop, document.body.scrollTop);
  var scrollLeft = Math.max(document.documentElement.scrollLeft, document.body.scrollLeft);
  return {x:box.left + scrollLeft, y:box.top + scrollTop};
 }else if(document.getBoxObjectFor)    // gecko    
 {
  box = document.getBoxObjectFor(el); 
  var borderLeft = (el.style.borderLeftWidth)?parseInt(el.style.borderLeftWidth):0; 
  var borderTop = (el.style.borderTopWidth)?parseInt(el.style.borderTopWidth):0; 
  pos = [box.x - borderLeft, box.y - borderTop];
 } else    // safari & opera    
 {
  pos = [el.offsetLeft, el.offsetTop];  
  parent = el.offsetParent;     
  if (parent != el) { 
   while (parent) {  
    pos[0] += parent.offsetLeft; 
    pos[1] += parent.offsetTop; 
    parent = parent.offsetParent;
   }  
  }   
  if (ua.indexOf('opera') != -1 || ( ua.indexOf('safari') != -1 && el.style.position == 'absolute' )) { 
   pos[0] -= document.body.offsetLeft;
   pos[1] -= document.body.offsetTop;         
  }    
 }              
 if (el.parentNode) { 
    parent = el.parentNode;
   } else {
    parent = null;
   }
 while (parent && parent.tagName != 'BODY' && parent.tagName != 'HTML') { // account for any scrolled ancestors
  pos[0] -= parent.scrollLeft;
  pos[1] -= parent.scrollTop;
  if (parent.parentNode) {
   parent = parent.parentNode;
  } else {
   parent = null;
  }
 }
 return {x:pos[0], y:pos[1]};
}


//-------------
function PL_InputList_Focus(on_no){
	switch(InputList.on){
		default:
			window.pl_search_list.PL_JumpFocus(on_no);
			break;
	}	
}
function PL_Load_CData(){
	switch(InputList.on){
		default:
			window.pl_search_list.PL_Load_PData(InputList);
			break;
	}
}