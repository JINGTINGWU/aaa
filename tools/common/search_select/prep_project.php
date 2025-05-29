<?php
if($word==''){
	$sql = "SELECT * FROM jec_project WHERE isproductprep != 'Y' AND projstatus not in ('3','4','6') AND isactive = 'Y' order by name ASC";
	//$_G['main_list']=$this->CM->db->where_not_in('isproductprep','Y')->where('isactive','Y')->order_by('name','ASC')->get('jec_project')->result_array();
	$_G['main_list'] = $this->CM->db->query($sql)->result_array();
}else{
	//$_G['main_list']=$this->CM->db->like('name',$word)->where_not_in('isproductprep','Y')->where('isactive','Y')->order_by('name','ASC')->get('jec_project')->result_array();//
	$sql = "SELECT * FROM jec_project WHERE isproductprep != 'Y' AND projstatus not in ('3','4','6') AND name LIKE '%".$word."%' AND isactive = 'Y' order by name ASC";
	$_G['main_list'] = $this->CM->db->query($sql)->result_array();
}
?>
