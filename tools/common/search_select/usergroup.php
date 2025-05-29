<?php
$projt_v_set=$this->CM->Init_TB_Set('mm_projtask_search_set');
$_G['main_list']=$this->$projt_v_set['mm_set']->get_jec_user_ld(0,$word);
/*
if($word==''){
	$_G['main_list']=$this->CM->db->where('acctstatus','Y')->where('isactive','Y')->order_by('name','ASC CONVERT( name using big5 )')->get('jec_user')->result_array();
}else{
	$_G['main_list']=$this->CM->db->like('name',$word)->where('acctstatus','Y')->where('isactive','Y')->order_by('name','ASC CONVERT( name using big5 )')->get('jec_user')->result_array();//
}*/
?>
