<?php
$projtype_ld=$this->mm_common_set->common_use_ld('projtype');
$projtype_pdb=$this->CM->FormatData(array('db'=>$projtype_ld,'key'=>'id','vf'=>'name'),'page_db',1);
?>
<style>
.mm_table_th{
	background:#CFDAD2;
}
</style>
        	<table class="info-div" cellspacing="1" cellpadding="3">
            	<tr>
            		<td rowspan="2" class="info-title" align="center">專案資訊</td>
            		<td>專案編號：<?=$proj_data['value']?>-<?=$proj_data['jec_project_id']?></td>
            		<td>專案名稱：<?=$proj_data['name']?></td>
            		<td>客戶名稱：<?=$proj_data['customername']?></td>
            	</tr>
            	<tr>
            		<td>業務(專案主持人)：<?=$proj_data['sales_name']?></td>
            		<td>專案負責人：<?=$this->GM->GetSpecData('jec_user','name','jec_user_id',$proj_data['jec_user_id'])?></td>
            		<td>專案日期：<?=substr($proj_data['startdate'],0,10)?>~<?=substr($proj_data['enddate'],0,10)?></td>
             	</tr>
            </table>
