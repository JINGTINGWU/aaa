<?php
$projtype_ld=$this->mm_common_set->common_use_ld('projtype');
$projtype_pdb=$this->CM->FormatData(array('db'=>$projtype_ld,'key'=>'id','vf'=>'name'),'page_db',1);
?>
<style>
.mm_table_th{
	background:#CFDAD2;
}
</style>
        	<table class="info-div" cellspacing="1" cellpadding="3" style="height:60px;">
            	<tr>
            		<td class="info-title" width="50">專案資訊</td><td>專案名稱：<?=$proj_data['name']?></td><td>客戶名稱：<?=$proj_data['customername']?></td><td>專案日期：<?=$proj_data['startdate']?>~<?=$proj_data['enddate']?></td>
            	</tr>
            	<tr>
            		<td class="info-title" width="50">上傳附件</td><td colspan="6"><input type="button" value="上傳其他附件"  onclick="thick_box('open','檔案上傳','<?=site_url('ecp_common/file_upload_div/prepare_item/'.$proj_data['jec_project_id'].'/')?>')"  class="mm_submit_button" <?=$proj_data['exportcode']==''?'':'disabled="disabled"'?> /> 「履約備品清單」不需重覆上傳，送出電子表單時，將由「備品清單明細」中自動產生此附件。</td>
            	</tr>
                <!--
                <tr>
                	<td class="mm_table_th" width="50">公司別</td>
                    <td><?=$proj_data['company_name']?></td>
                	<td class="mm_table_th">專案年度</td>
                    <td><?=$proj_data['projyear']?></td>
                	<td class="mm_table_th">專案名稱</td>
                    <td><?=$proj_data['name']?></td>
                	<td class="mm_table_th">專案性質</td>
                    <td><?=$projtype_pdb[$proj_data['projtype']]?></td>
                	<td class="mm_table_th">客戶名稱</td>
                    <td><?=$proj_data['customer_name']?></td>
                	<td class="mm_table_th">客戶案號</td>
                    <td><?=$proj_data['customerdoc']?></td>
                </tr>
                <tr>
                	<td class="mm_table_th">工程編號</td>
                    <td><?=$proj_data['value2']?></td>
                	<td class="mm_table_th">備註說明<br /></td>
                    <td colspan="9" ><?=$proj_data['description']?></td>

                </tr>
                <tr>
                	<td class="mm_table_th">工程名稱</td>
                    <td><?=$proj_data['name2']?></td>
                	<td class="mm_table_th">備註2<br /></td>
                    <td colspan="9" ><?=$proj_data['description2']?></td>
                </tr> 
                <tr>
                	<td class="mm_table_th">履約地點</td>
                    <td><?=$proj_data['address']?></td>
                	<td class="mm_table_th">備註3<br /></td>
                    <td colspan="9"><?=$proj_data['description3']?></td>
                </tr>-->
            </table>
