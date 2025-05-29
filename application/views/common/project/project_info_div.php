<?php
$projtype_ld=$this->mm_common_set->common_use_ld('projtype');
$projtype_pdb=$this->CM->FormatData(array('db'=>$projtype_ld,'key'=>'id','vf'=>'name'),'page_db',1);
?>
        	<table class="info-div" cellspacing="1" cellpadding="3">
            	<tr>
            		<td colspan="2"  class="info-title">專案資訊</td>
            	</tr>
                <tr>
                	<td width="50">公司別</td>
                    <td><?=$proj_data['company_name']?></td>
                </tr>
                <tr>
                	<td>專案年度</td>
                    <td><?=$proj_data['projyear']?></td>
                </tr>
                <tr>
                	<td>客戶名稱</td>
                    <td><?=$proj_data['jec_customer_id']==0?$proj_data['customername']:$proj_data['customer_name']?></td>
                </tr>
                <tr>
                	<td>客戶案號</td>
                    <td><?=$proj_data['customerdoc']?></td>
                </tr>
                <tr>
                	<td>工程編號</td>
                    <td><?=$proj_data['value2']?></td>
                </tr>
                <tr>
                	<td>工程名稱</td>
                    <td><?=$proj_data['name2']?></td>
                </tr> 
                <tr>
                	<td>專案名稱</td>
                    <td style="word-break: break-all;"><?=$proj_data['name']?></td>
                </tr>
                <tr>
                	<td>專案性質</td>
                    <td><?=$projtype_pdb[$proj_data['projtype']]?></td>
                </tr>
                <tr>
                	<td>履約地點</td>
                    <td><?=$proj_data['address']?></td>
                </tr>
                <tr>
                	<td>備註說明<br /></td>
                    <td><?=$proj_data['description']?></td>
                </tr>
                <tr>
                	<td>備註2<br /></td>
                    <td><?=$proj_data['description2']?></td>
                </tr>
                <tr>
                	<td>備註3<br /></td>
                    <td><?=$proj_data['description3']?></td>
                </tr>
            </table>
