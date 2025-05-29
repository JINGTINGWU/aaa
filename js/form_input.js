// JavaScript Document
function fi_isEmail(email){
    if (email=="") return true;
    reEmail=/^\w+((-\w+)|(\.\w+))*\@[A-Za-z0-9]+((\.|-)[A-Za-z0-9]+)*\.[A-Za-z0-9]+$/
	return reEmail.test(email);
}
function fi_ne(fi_id,msg)
{
	if(document.getElementById(fi_id).value==''){
		//document.getElementById(fi_id).focus();		
		if(typeof(msg) != undefined){
			//choose show way
			//alert(msg);
			//humane.info(msg);
			ECP_Msg(msg,-1,'error');
		}	
		return false;
	}else{
		return true;
	}
}

function fi_no(fi_id)
{
	//document.getElementById(fi_id).value=document.getElementById(fi_id).value.replace(/[^0-9]/g,"");
	fi_id.value=fi_id.value.replace(/[^0-9.]/g,"");
}

function fi_nod(fi_id)
{   //可小數點
	//alert(fi_id);
	
	fi_id.value=fi_id.value.replace(/[^0-9.]/g,"");
	//document.getElementById(fi_id).value=document.getElementById(fi_id).value.replace(/[^0-9.]/g,"");
}
function fi_noam(fi_id)
{   //可小數點
	//alert('noam');
	//re = /0-9./-/+/;
	fi_id.value=fi_id.value.replace(/[^\+\-0-9.0-9]/g,"");
	
	//document.getElementById(fi_id).value=document.getElementById(fi_id).value.replace(/[^0-9.]/g,"");
}
function CleanFile(name,frame_name){
	if(frame_name!=""){
		$('#'+frame_name).contents().find('#'+name).replaceWith($('#'+frame_name).contents().find('#'+name).clone(true));
	}else{
		$("#"+name).replaceWith($("#"+name).clone(true));
	}
}

function  CheckFileType(value_1,default_type,frame_name,up_type){				    
    //up_type=m->check->add NEW
	mm_split_tag='ZZZ';
	if(frame_name==""){
		x=document.getElementById(value_1).value;
	}else{
		x=$('#'+frame_name).contents().find('#'+value_1).val();
	}
	
	x=x.toLowerCase();
	default_type=default_type.toLowerCase();
	x=x.substr(x.lastIndexOf(".")+1,4);
	
	//處理default_type
	dt=default_type.split("@");
	dts=dt[0];
	for(i=1;i<dt.length;i++){
		dts+=","+dt[i];
	}
	
	if(default_type.search(x)==-1){
		//alert("請上傳 "+dts+" 檔案。");
		
		ECP_Msg("請上傳 "+dts+" 檔案。",-1,'error');
		CleanFile(value_1,frame_name);
		return false;
	}else{
	    if(frame_name==""){
		    x=document.getElementById(value_1).value;
	    }else{
		    x=$('#'+frame_name).contents().find('#'+value_1).val();
	    }
	    if(x!=x.replace(";","")){
	        //alert("待上傳的檔案名稱包含分號，請更改檔名。");
			ECP_Msg("待上傳的檔案名稱包含分號，請更改檔名。",-1,'error');
			//ECP_Msg(msg);
			CleanFile(value_1,frame_name);
		    return false;
	    }else{
			//_ti
			if(InStr(value_1,mm_split_tag)){
				mm_ori_id=GetString(value_1,"",mm_split_tag);
				mm_on_num=GetString(value_1,mm_split_tag,"");
			}else{
				mm_ori_id=value_1;
				mm_on_num=1;
			}
			if($("#"+mm_ori_id+"_ti").length>0){
				if($("#"+mm_ori_id+"_ti").val()==mm_on_num){			
					new_num=parseInt(mm_on_num)+1;
					$("#"+mm_ori_id+"_ti").val(new_num);
					new_id=mm_ori_id+mm_split_tag+new_num;
					$("<div id=\"filediv_"+new_id+"\"><input type=\"file\" id=\""+new_id+"\" name=\""+new_id+"\" onchange=\"CheckFileType('"+new_id+"','"+default_type+"','','"+up_type+"')\"><a onclick=\"CleanFile('"+new_id+"','');\" title=\"清除\" class=\"mm_clean_file\">x</a></div>").insertAfter($("#filediv_"+value_1));
				}
			}
		    return true;
	    }
	}
}

function fi_submit_check(info,isMsg)
{	
	var fi_msg='';	
	for(mi=0;mi<info.length;mi++){
		var fi_e=info[mi];
		//id/msg/type
		switch(fi_e.type){
			/**/
			case 'ne':
				//ECP_Msg(fi_e.id);
				if(document.getElementById(fi_e.id).value==''){
					fi_msg=fi_e.msg;
					//document.getElementById(fi_e.id).focus();
				}
			break;
			case 'nz':
				if(document.getElementById(fi_e.id).value==''||parseInt(document.getElementById(fi_e.id).value)==0){
					fi_msg=fi_e.msg;
					//document.getElementById(fi_e.id).focus();
				}
			break;
			case 'ndz'://日期不為0000-00-00
				//ECP_Msg(fi_e.id);
				if(document.getElementById(fi_e.id).value=='0000-00-00' || document.getElementById(fi_e.id).value==''){
					fi_msg=fi_e.msg;
					//document.getElementById(fi_e.id).focus();
				}
			break;
			case 'sed':
				//sd_id.ed_id.
				var sd_value=document.getElementById(fi_e.sd_id).value; var ed_value=document.getElementById(fi_e.ed_id).value;
				if(sd_value!=''&&ed_value!=''){
					var sd_num=sd_value.substr(0,4)+sd_value.substr(5,2)+sd_value.substr(8,2);
					var ed_num=ed_value.substr(0,4)+ed_value.substr(5,2)+ed_value.substr(8,2);
					//alert(sd_num+'-'+ed_num);
					if(parseInt(sd_num)>parseInt(ed_num)){
						fi_msg=fi_e.msg;
						//document.getElementById(fi_e.ed_id).focus();
					}
				}
			break;
			case 'email':
				if(fi_isEmail(document.getElementById(fi_e.id).value)){
				}else{
					fi_msg=fi_e.msg;
					//document.getElementById(fi_e.id).focus();					
				}
			break;
			case 'quote':
				var sd_value=document.getElementById(fi_e.sd_id).value; var ed_value=document.getElementById(fi_e.ed_id).value;
				if(sd_value==ed_value)
				{
					fi_msg=fi_e.msg;
				}
			break;
		}
		if(fi_msg!=''&&typeof(isMsg)=='undefined'){
			//alert(fi_msg);
			ECP_Msg(fi_msg,-1,'error');
			break;
		}
	}
	
	return fi_msg;
}

function fi_min_len(fi_obj,msg)
{
	var def_len=4;
	var len=fi_obj.value.length;
	if(fi_obj.value!=''&&len<def_len){
		//fi_obj.focus();
		//document.getElementById(fi_id).focus();		
		if(typeof(msg) != undefined){
			//choose show way
			//alert(msg);
			ECP_Msg(msg);
		}	
		return false;		
	}else{
		return true;
	}	
}


