// JavaScript Document
function PL_Load_PData(data){
	InputList=data;
}
function PL_SelectList(no){
	var search_here_value=document.getElementById(InputList.info[InputList.on].search_value+'_'+no).innerHTML;
	if(parent.InStr(search_here_value,'<label>')){
		var search_here_value=parent.GetTagV(search_here_value,'label');
	}
	switch(InputList.info[InputList.on].input_type){
		case 'A':
			parent.document.getElementById(InputList.info[InputList.on].search_here).value=parent.document.getElementById(InputList.info[InputList.on].search_here).value+search_here_value;
			break;
		case 'R':
			parent.document.getElementById(InputList.info[InputList.on].search_here).value=search_here_value;
			break;
	}
	if(typeof(InputList.info[InputList.on].label_id)!='undefined'){

		parent.document.getElementById(InputList.info[InputList.on].label_id).innerHTML=search_here_value;
	}
	if(typeof(InputList.info[InputList.on].title_id)!='undefined'){

		parent.document.getElementById(InputList.info[InputList.on].title_id).title=search_here_value;
	}
	if(typeof(InputList.info[InputList.on].input_id)!='undefined'){		
		parent.document.getElementById(InputList.info[InputList.on].input_id).value=document.getElementById(InputList.info[InputList.on].search_value+'_'+no).abbr;
		if(typeof(InputList.info[InputList.on].onchange)!='undefined'){
			parent.PG_BK_Action(InputList.info[InputList.on].onchange);
		}
		//
		//alert(document.getElementById(InputList.info[InputList.on].search_value+'_'+no).abbr);
	}
	//onchange
	parent.document.getElementById(InputList.info[InputList.on].search_div).style.display='none';
	//parent.document.getElementById(InputList.info[InputList.on].search_list).innerHTML='';
	parent.document.getElementById(InputList.info[InputList.on].search_list).src=InputList.blank_url;
	parent.document.getElementById(InputList.on_select).value=-1;
	parent.document.getElementById(InputList.select_status).value='N';	
}
function PL_JumpFocus(no){
	var src=document.getElementById(InputList.info[InputList.on].search_value+'_'+no);
	window.scrollTo(src.offsetLeft,src.offsetTop);
}