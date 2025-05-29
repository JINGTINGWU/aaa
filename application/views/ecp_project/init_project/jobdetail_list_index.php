<table>
	<tr>
    	<td>
        <div id="project_info_div">
        	<table>
            	<tr>
            		<td colspan="2">專案資訊</td>
            	</tr>
                <tr>
                	<td>公司別</td>
                    <td><select></select></td>
                </tr>
                <tr>
                	<td>專案年度</td>
                    <td><select></select></td>
                </tr>
                <tr>
                	<td>客戶名稱</td>
                    <td><select></select></td>
                </tr>
                <tr>
                	<td>專案名稱</td>
                    <td><select></select></td>
                </tr>
                <tr>
                	<td>備註說明</td>
                    <td></td>
                </tr>
            </table>
        </div>
        <div id="job_info_div">
        	<table>
            	<tr>
            		<td colspan="2">工作項目</td>
            	</tr>
                <tr>
                	<td>工作名稱</td>
                    <td></td>
                </tr>
                <tr>
                	<td>負責人員</td>
                    <td></td>
                </tr>
                <tr>
                	<td>起始日期</td>
                    <td></td>
                </tr>
                <tr>
                	<td>結束日期</td>
                    <td></td>
                </tr>
                <tr>
                	<td>允許延遲</td>
                    <td></td>
                </tr>
                <tr>
                	<td>工作權重</td>
                    <td></td>
                </tr>
                <tr>
                	<td>處理原則</td>
                    <td></td>
                </tr>
                <tr>
                	<td>確認方式</td>
                    <td></td>
                </tr>
                <tr>
                	<td>預估成本</td>
                    <td></td>
                </tr>
            </table>
        </div>
        </td>
        <td valign="top">
<div id="search_area_div">
	<table>
		<tr>
        	<th>選擇料品範本：</th><td><select></select><input type="button" value="從範本匯入料品清單" /></td>
            <th>選擇EXCEL檔案：</th><td><input type="text" /><input type="button" value="從EXCEL匯入料品清單" /></td>
        </tr>
	</table>
	<table>
		<tr>
        	<th>選擇料品：</th><td><select></select></td>
            <th>數量：</th>
            <td><input type="text" /></td>
            <th>預估單價：</th><td><input type="text" /></td>
            <th>採購廠商：</th><td><select></select>(可線上新增)</td>
        </tr>
		<tr>
        	<th>需求日期：</th><td><input type="text" /></td>
            <th>備註說明：</th><td colspan="5"><input type="text" /><input type="button" value="片語輸入" /><input type="button" value="新增料品" /></td>
        </tr>
	</table>
</div>
<div id="result_area_div">
	<table>
    	<tr>
    		<td colspan="13">料品清單與工作明細列表</td>
    	</tr>
        <tr>
        	<td>排序</td>
            <td>料號</td>
            <td>品名</td>
            <td>規格</td>  
            <td>單位</td>   
            <td>數量</td> 
            <td>單價</td> 
            <td>合計</td> 
            <td>需求日期</td>
			<td>採購廠商</td> 
            <td>備註說明</td> 
            <td>修改</td> 
            <td>刪除</td>          
        </tr>
        <?php foreach($file_list as $value):?>
        <tr>
        	<td>排序</td>
            <td>料號</td>
            <td>品名</td>
            <td>規格</td>  
            <td>單位</td>   
            <td>數量</td> 
            <td>單價</td> 
            <td>合計</td> 
            <td>需求日期</td>
			<td>採購廠商</td> 
            <td>備註說明</td> 
            <td><input type="button" value="修改"></td> 
            <td><input type="button" value="刪除"></td>  
        </tr>        
        <?php endforeach;?>
    </table>

</div>
        </td>
    </tr>
</table>
