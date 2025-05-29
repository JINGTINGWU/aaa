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
                	<td>備註說明<br /><input type="button" value="片語輸入" /></td>
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
<div id="result_area_div">
	<table>
    	<tr>
    		<td colspan="12">專案所有工作清單列表</td>
    	</tr>
        <tr>
        	<td>項次</td>
            <td>狀態/比率</td>
            <td>任務名稱</td>
            <td>工作項目</td>  
            <td>負責人員</td>   
            <td>工作日期</td> 
            <td>完成狀態</td> 
            <td>完成日期</td> 
            <td>料品與工作明細</td>
			<td>數量*單價=金額</td> 
            <td>需求日期</td> 
            <td>採購廠商</td>      
            <td>匯出表單</td>   
            <td>流程完成</td>           
        </tr>
        <?php foreach($main_list as $value):?>
        <tr>
        	<td>項次</td>
            <td>狀態/比率</td>
            <td>任務名稱</td>
            <td>工作項目</td>  
            <td>負責人員</td>   
            <td>工作日期</td> 
            <td>完成狀態</td> 
            <td>完成日期</td> 
            <td>料品與工作明細</td>
			<td>數量*單價=金額</td> 
            <td>需求日期</td> 
            <td>採購廠商</td>      
            <td>匯出表單</td>   
            <td>流程完成</td> 
        </tr>        
        <?php endforeach;?>
    </table>

</div>
        </td>
    </tr>
</table>