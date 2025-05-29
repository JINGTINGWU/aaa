        	<table class="info-div" cellspacing="1" cellpadding="3">
            	<tr>
            		<td colspan="2" class="info-title">工作項目</td>
            	</tr>
                <tr>
                  <td>任務名稱</td>
                  <td><?=$projt_data['job_name']?></td>
                </tr>
                <tr>
                	<td width="50">工作名稱</td>
                    <td><?=$projt_data['taskname']?></td>
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
                </tr>
            </table>
