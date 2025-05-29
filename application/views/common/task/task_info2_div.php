        	<table class="info-div" cellspacing="1" cellpadding="3">
            	<tr>
            		<td colspan="2" class="mm_table3_title2">工作項目</td>
            	</tr>
                <tr>
                  <td>任務名稱</td>
                  <td><?=$projt_data['job_name']?></td>
                </tr>
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
                	<td>負責人</td>
                    <td><?=substr($projt_data['sales_name'],0,10)?></td>
                </tr>
            </table>
