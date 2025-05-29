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
                	<td>備註說明<br /></td>
                	<td><select></select></td>
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
<div id="result_area_div">
	<table>
    	<tr>
    		<td colspan="5">工作紀錄列表</td>
    	</tr>
        <tr>
        	<td>自動</td>
            <td>處理時間</td>
            <td>工作紀錄</td>
            <td>異動人員</td>  
            <td>完成</td>         
        </tr>
        <?php foreach($file_list as $value):?>
        <tr>
        	<td>自動</td>
            <td>處理時間</td>
            <td>工作紀錄</td>
            <td>異動人員</td>  
            <td>完成</td>  
        </tr>        
        <?php endforeach;?>
    </table>

</div>
<div id="file_area_div">
	<table>
    	<tr>
    		<td colspan="12">工作項目附件列表</td>
    	</tr>
        <tr>
        	<td>附件名稱</td>
            <td>刪除</td>        
        </tr>
        <?php foreach($file_list as $value):?>
        <tr>
        	<td>附件名稱</td>
            <td><input type="button" value="刪除附件"></td> 
        </tr>        
        <?php endforeach;?>
    </table>

</div>
        </td>
    </tr>
</table>