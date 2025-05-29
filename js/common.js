// JavaScript Document

function InStr(con,tv){
	if(con.replace(tv,"")==con){
		return false;
	}else{
		return true;
	}
}
function GetString(con,pf,lf){
	//去頭
	if(pf!=""){
		tip=con.indexOf(pf);
		len=pf.length;
		tip=tip+len;
		con=con.substr(tip);
	}

	//去尾
	if(lf!=""){
	    tip=con.indexOf(lf);
		len=lf.length;
		con=con.substr(0,tip);
	}
	return con;
}
function GetTagV(con,tag){
	pf="<"+tag+">";
	lf="</"+tag+">";
	final=GetString(con,pf,lf);
	return final;
}

function AWEA_Load_Div(id,url,input_data)//json_encode input_data
{
	//alert(id+"="+url);
	if(typeof(input_data)=='undefined'){
		input_data={ d:new Date().getTime() };
	}else{
		input_data.d=new Date().getTime();
	}
	$("#"+id).load(url,input_data);
}

function AWEA_PG_AC(url,mvalue,type,on_id,obj)//json_encode input_data
{	
	mm_msg=''; mm_stop=0;
	if(typeof(on_id)!='undefined'){
		document.getElementById(on_id).className='mm_tr_on';
	}
	switch(type){
		case 'del':
			mm_msg='確定刪除?';
		break;
		case 'query':
			mm_msg=mvalue;
		break;
	}
	if(mm_msg!=''){
		if(confirm(mm_msg)){
			//
		}else{
			document.getElementById(on_id).className='mm_tr_off';			
			mm_stop=1;
		}
	}
	if(InStr(url,"&act=")==false){
		url=url+"&act="+type;	 
	}
	if(mm_stop==0){
		document.getElementById('edit_form').action=url;
		document.getElementById('edit_form').submit();
		if(typeof(obj)!='undefined'){
			obj.disabled=true;
		}		
	}
}
function AWEA_Ajax(url,mvalue,type,on_id)//json_encode input_data
{	//
	mm_msg=''; mm_stop=0;
	if($("#exe_tag").length>0){
		$("#exe_tag").val(1);
	}	
	if(typeof(on_id)!='undefined'){
		document.getElementById(on_id).className='mm_tr_on';
	}
	switch(type){
		case 'del':
			mm_msg='確定刪除?';
		break;
		case 'clean':
			mm_msg='確定清除?';
		break;
	}
	if(mm_msg!=''){
		if(confirm(mm_msg)){
			//
		}else{
			document.getElementById(on_id).className='mm_tr_off';			
			mm_stop=1;
		}
	}
	/*
	if(InStr(url,"&act=")==false){
		url=url+"&act="+type;	 
	}*/
	input_data={
			mvalue:mvalue
		};
	if($("#key_id").length>0){
		input_data['key_id']=$("#key_id").val();
	}
	if(typeof(mvalue)=='object'){
		input_data=mvalue;
	}
	if(mm_stop==0){
        $.ajax({
            url: url,
            type:"POST",
            data: (input_data), 
            success: function(dd){
			//回傳dd值，讓字項目判斷
				//alert(dd);
			    if(GetTagV(dd,'pass')=='1')
				{
					if($("#exe_tag").length>0){
						$("#exe_tag").val(0);
					}
					if(GetTagV(dd,'msg')!=''){
						//refresh
						ECP_Msg(GetTagV(dd,'msg'),999);
					    //alert(GetTagV(dd,'msg'));					
					}
					if(GetTagV(dd,'msg_num')!=''){
						//refresh
						ECP_Msg(0,GetTagV(dd,'msg_num'));
					    //alert(GetTagV(dd,'msg'));					
					}
					if(GetTagV(dd,'refresh_url')!=''){
					    location.href=GetTagV(dd,'refresh_url');					
					}
					if(GetTagV(dd,'reload')!=''){
						ECP_Load_Div(GetTagV(dd,'reload'),GetTagV(dd,'reload_url'),'',GetTagV(dd,'input_string'));
					}
					if(GetTagV(dd,'ne_ac')!=''){
						document.getElementById(GetTagV(dd,'ne_ac')).value='';				
					}
					if(GetTagV(dd,'innerId')!=''){
						
						$("#"+GetTagV(dd,'innerId')).html(GetTagV(dd,'innerHTML'));			
					}
					if(GetTagV(dd,'bk_action')!=''){
						PG_BK_Action(GetTagV(dd,'bk_action'),dd);//data back		
					}
					if(GetTagV(dd,'valueId')!=''){
						$("#"+GetTagV(dd,'valueId')).val(GetTagV(dd,'valueValue'));	
					}
					if(GetTagV(dd,'classId')!=''){
						document.getElementById(GetTagV(dd,'classId')).className=GetTagV(dd,'className');
					}
					if(GetTagV(dd,'insert_point')!=''){
						switch(GetTagV(dd,'insert_type')){
							case 'P'://pre
								$(GetTagV(dd,'insert_content')).insertBefore("#"+GetTagV(dd,'insert_point'));
								break;
							case 'A'://after
								$(GetTagV(dd,'insert_content')).insertAfter("#"+GetTagV(dd,'insert_point'));
								break;
						}
					}
				}
            }
        });
	}
}
function ECP_Load_Div(id,url,input_data,input_string)//json_encode input_data
{	
	switch(typeof(input_data)){
		case 'undefined':
			var input_data={ d:new Date().getTime() };
		break;
		case 'string':
			switch(input_data){
				case 'fs':
					var input_data=fs_fix_ip;
				break;
			}
			input_data.d=new Date().getTime();
		break;
	}
	if(typeof(input_string)!='undefined'){
		input_data.input_string=input_string;
	}	
	if($("#"+id).length>0){
		$("#"+id).load(url,input_data);
	}   //	
}
function IsChecked(id)
{
	return document.getElementById(id).checked;
}

function thick_box(type,value_1,value_2)
{   
	switch(type)
	{
		case 'close':
		    tb_remove();
		break;
		case 'open':			
            tb_show(value_1,value_2,'');
		break;
	}
}

function RefreshPG(id)
{
	location.href=document.getElementById(id).value;
}

function FillNum(len,value)
{
	var nlen=value.length;
	if(nlen<len){
		var fill_num=len-nlen;
		for(i=1;i<=fill_num;i++){
			value="0"+value;
		}	
	}
	return value;
}

function JS_Link(url,type)
{
	if(typeof(type)=='undefined'){
		location.href=url;
	}else{
		parent.location.href=url;
	}
}

function ECP_Msg(msg,type,hu_type)
{	
	if(typeof(type)=='undefined'||parseInt(type)==0){
		//alert(msg);
		if(hu_type=='error'){
			humane.error(msg);
		}else{
			humane.info(msg);
		}
		
	}else{
		switch(type){
			case '1':
				msg='已修改';
			break;
		}
		if(hu_type=='error'){
			humane.error(msg);
		}else{
			humane.info(msg);
		}
	}
	
}
function Adjust_MathVar(test,num)
{
			return parseFloat(test/num);
}

function accMul(arg1,arg2) 
{ 
	var m=0,s1=arg1.toString(),s2=arg2.toString(); 
	try{m =s1.split(".")[1].length}catch(e){} 
	try{m =s2.split(".")[1].length}catch(e){} 
	return Number(s1.replace(".",""))*Number(s2.replace(".",""))/Math.pow(10,m) 
} 

function accAdd(arg1,arg2){
    var r1,r2,m;
   try{r1=arg1.toString().split(".")[1].length}catch(e){r1=0}
   try{r2=arg2.toString().split(".")[1].length}catch(e){r2=0}
   m=Math.pow(10,Math.max(r1,r2))
    return(arg1*m+arg2*m)/m
}