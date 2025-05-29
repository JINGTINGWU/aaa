<?php
if($word==''){
	$_G['main_list']=$this->CM->db->where('isactive','Y')->order_by('value','ASC')->get('jec_product')->result_array();
}else{
	$_G['main_list']=$this->CM->db->like('value',$word)->where('isactive','Y')->order_by('value','ASC')->get('jec_product')->result_array();//
}
?>

