<?php
//kid->條件作用
if($word==''){
	$_G['main_list']=$this->CM->db->where('isactive','Y')->order_by('name','ASC')->get('jec_product')->result_array();
}else{
	$_G['main_list']=$this->CM->db->like('name',$word)->or_like('value',$word)->or_like('specification',$word)->where('isactive','Y')->order_by('name','ASC')->get('jec_product')->result_array();//
}
?>
