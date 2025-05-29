<table>
	<tr>
    	<td>
        <div id="project_info_div">
        	<table>
            	<tr>
            		<td colspan="2">專案資訊</td>
            	</tr>
                <tr>
                	<td>專案編號</td>
                    <td><select></select></td>
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
                    <td><select></select></td>
                </tr>
            </table>
        </div>
        <div id="mission_info_div">
        	<table>
            	<tr>
            		<td colspan="2">專案管理</td>
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
                	<td>業務</td>
                    <td></td>
                </tr>
                <tr>
                	<td>專案負責</td>
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
        	<th>選擇任務：</th><td><select></select></td>
            <th>備註說明：</th><td><input type="text"></td>
            <td><input type="button" value="片語輸入 "><input type="button" value="新增任務"></td>
        </tr>
	</table>
</div>
<div id="result_area_div">
	<table>
    	<tr>
    		<td colspan="12">任務列表</td>
    	</tr>
        <tr>
        	<td>排序</td>
            <td>任務名稱</td>
            <td>任務特性</td>
            <td>備註說明</td>  
            <td>編輯工作</td>   
            <td>上傳附件</td> 
            <td>刪除</td>            
        </tr>
        <?php foreach($file_list as $value):?>
        <tr>
        	<td>排序</td>
            <td>任務名稱</td>
            <td>任務特性</td>
            <td>備註說明</td>  
            <td><input type="button" value="工作項目"></td>   
            <td><input type="button" value="上傳附件"></td> 
            <td><input type="button" value="刪除任務"></td>  
        </tr>        
        <?php endforeach;?>
    </table>

</div>
        </td>
    </tr>
</table>