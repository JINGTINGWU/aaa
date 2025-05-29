        	<table class="info-div" cellspacing="1" cellpadding="3">
            	<tr>
            		<td colspan="2" class="info-title">專案資訊</td>
            	</tr>
                <tr>
                	<td width="75">公司別</td>
                    <td><?=$proj_op['jec_company_id']['op']?></td>
                </tr>
                <tr>
                	<td>專案年度</td>
                    <td><?=$proj_op['projyear']['op']?></td>
                </tr>
                <tr>
                	<td>客戶名稱</td>
                    <td><!--<?=$proj_op['cus_select_type']['op']?><br />--><?=$proj_op['jec_customer_id']['op']?><?=$proj_op['jec_customer_id_title']['op']?></td>
                </tr>
                <tr>
                	<td>客戶案號</td>
                    <td><?=$proj_op['customerdoc']['op']?></td>
                </tr>
              
                <tr>
                	<td>工程編號</td>
                    <td><?=$proj_op['value2']['op']?></td>
                </tr>
                <tr>
                	<td>工程名稱</td>
                    <td><?=$proj_op['name2']['op']?></td>
                </tr>                
                <tr>
                	<td>專案名稱</td>
                    <td><?=$proj_op['name']['op']?></td>
                </tr>
                <tr>
                	<td>專案性質</td>
                    <td><?=$proj_op['projtype']['op']?></td>
                </tr>
                <tr>
                	<td>採購部門</td>
                    <td><?=$proj_op['efprojdept']['op']?></td>
                </tr>                
                 <tr>
                	<td>採購編號<input type="button" value="..." onclick="PG_BK_Action('search_ef_proj',{})" /></td>
                    <td><?=$proj_op['efprojno']['op']?></td>
                </tr>               
                <tr>
                	<td>採購名稱</td>
                    <td id="purchase_name_tag"><?=$proj_op['efprojname']['op']?></td>
                </tr>                 
                
                <tr>
                	<td>履約地點</td>
                    <td><?=$proj_op['address']['op']?></td>
                </tr>
                <tr>
                	<td>備註說明<br /><input type="button" value="片語輸入" onclick="thick_box('open','片語輸入','<?=site_url('ecp_common/phrase_search_div/description/')?>')"  class="mm_submit_button" <?=$up_btn?> /></td>
                    <td><?=$proj_op['description']['op']?></td>
                </tr>
                
                <tr>
                	<td>備註說明2<br /><input type="button" value="片語輸入" onclick="thick_box('open','片語輸入','<?=site_url('ecp_common/phrase_search_div/description2/')?>')"  class="mm_submit_button" /></td>
                    <td><?=$proj_op['description2']['op']?></td>
                </tr>
                <tr>
                	<td>備註說明3<br /><input type="button" value="片語輸入" onclick="thick_box('open','片語輸入','<?=site_url('ecp_common/phrase_search_div/description3/')?>')"  class="mm_submit_button" /></td>
                    <td><?=$proj_op['description3']['op']?></td>
                </tr>
                 <tr>
                	<td>合約總價</td>
                    <td><?=$proj_op['total']['op']?></td>
                </tr>               
                <tr>
                	<td>成本係數</td>
                    <td><?=$proj_op['costrate']['op']?></td>
                </tr>  
            </table>