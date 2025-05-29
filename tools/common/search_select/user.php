<?php
if($word==''){
	$_G['main_list']=$this->CM->db->where('acctstatus','Y')->where('isactive','Y')->order_by('name','ASC CONVERT( name using big5 )')->get('jec_user')->result_array();
}else{
	$_G['main_list']=$this->CM->db->like('name',$word)->where('acctstatus','Y')->where('isactive','Y')->order_by('name','ASC CONVERT( name using big5 )')->get('jec_user')->result_array();//
}
?>
