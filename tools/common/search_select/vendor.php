<?php
if($word==''){
	$_G['main_list']=$this->CM->db->where('isactive','Y')->order_by('name','ASC')->get('jec_vendor')->result_array();
}else{
	$_G['main_list']=$this->CM->db->like('name',$word)->where('isactive','Y')->order_by('name','ASC')->get('jec_vendor')->result_array();//
}
?>
