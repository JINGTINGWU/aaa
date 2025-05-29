        	<table  class="info-div" cellspacing="1" cellpadding="3">
            	<tr>
            		<td colspan="2"   class="info-title">專案管理</td>
            	</tr>
                <tr>
                	<td width="50">起始日期</td>
                    <td><?=substr($proj_data['startdate'],0,10)?></td>
                </tr>
                <tr>
                	<td>結束日期</td>
                    <td><?=substr($proj_data['enddate'],0,10)?></td>
                </tr>
                <tr>
                	<td>部門</td>
                    <td><?=$proj_data['jec_dept_id']>0?$this->GM->GetSpecData('jec_dept','name','jec_dept_id',$proj_data['jec_dept_id']):'-'?></td>
                </tr>
                <tr>
                	<td>業務</td>
                    <td><?=$proj_data['sales_name']?></td>
                </tr>
                <tr>
                	<td>專案負責</td>
                    <td><?=$this->GM->GetSpecData('jec_user','name','jec_user_id',$proj_data['jec_user_id'])?></td>
                </tr>   
                <tr>
                	<td>發票合計</td>
                    <td><?=$this->mm_project_search_set->get_project_invoice($proj_data['jec_project_id'])?></td>
                </tr>        
            </table>