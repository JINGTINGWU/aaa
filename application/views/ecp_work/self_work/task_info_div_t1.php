        	<table class="info-div" cellspacing="1" cellpadding="3" style="height:35px;">
            	<tr>
            		<td class="info-title"  width="130">工作項目</td><td><?=$projt_data['taskname']?>，<?=substr($projt_data['startdate'],0,10)?>~<?=substr($projt_data['enddate'],0,10)?>，<?=$projt_data['sales_name']?></td></tr>
                    <!--
            	<tr>
            		<td rowspan="2" class="info-title">工作項目</td>
                    <td align="right" width="60">工作名稱：</td>
                    <td align="left"><?=$projt_data['taskname']?></td>
                	<td align="right" width="60">工作日期：</td>
                    <td align="left"><?=substr($projt_data['startdate'],0,10)?>~<?=substr($projt_data['enddate'],0,10)?></td>
                    <td rowspan="2"><input type="button" value="查看工作紀錄"  onclick="JS_Link('<?=site_url($var_purl.'work_record_index/list/'.$projt_data['jec_projtask_id'].'/')?>');"  class="mm_submit_button" ></td>
            	</tr>
                <tr>
                    <td align="right">負責人員：</td>
                    <td align="left"><?=(int)$projt_data['jec_user_id']>0?$this->GM->GetSpecData('jec_user','name','jec_user_id',$projt_data['jec_user_id']):$this->GM->GetSpecData('jec_group','name','jec_group_id',$projt_data['jec_group_id'])?></td>
                	<td align="right">督導人員：</td>
                    <td align="left"><?=$this->GM->GetSpecData('jec_user','name','jec_user_id',$projt_data['jec_usersuper_id'])?></td>	
                </tr>-->
                <!--
                <tr>
                	<td width="50">工作名稱</td>
                    <td><?=$projt_data['name']?></td>
                </tr>
                <tr>
                	<td>起始日期</td>
                    <td><?=substr($projt_data['startdate'],0,10)?></td>
                </tr>
                <tr>
                	<td>結束日期</td>
                    <td><?=substr($projt_data['enddate'],0,10)?></td>
                </tr>
                <tr>
                	<td colspan="2"><input type="button" value="查看工作紀錄"  onclick="JS_Link('<?=site_url($var_purl.'work_record_index/list/'.$projt_data['jec_projtask_id'].'/')?>');"  class="mm_submit_button" ></td>
                </tr>-->
            </table>
