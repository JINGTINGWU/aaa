<?php
			$full_set=$this->ECPM->m_right_tag['up_da']==''?array():array('disabled'=>'Y');
			$up_da=$this->ECPM->m_right_tag['up_da'];
			$del_da=$this->ECPM->m_right_tag['del_da'];
			//$edit_1_info=$this->mm_projtask_search_set->edit_1_info;
			//$edit_2_info=$this->mm_projtask_search_set->edit_2_info;
			if($proj_data['projstatus']==6):
   				$up_da='disabled';
   				$del_da='disabled';
				$full_set['disabled']='Y';
			endif;
			if($proj_data['exportcode']!='') $del_da='disabled';
?>
<?php /* $this->load->view('common/page_bar_div',array('pd'=>$pd)); */ ?>
	<table class="detail-div" cellspacing="1" cellpadding="3">
    	<tr>
    		<td colspan="4" class="mm_table2_title">聯絡單與簽呈附件列表</td>
    	</tr>
        <tr>
        	<td class="mm_table2_title2" <?=$ob=='seqno'?'id="'.$pd['ob_css'].'"':'class="detail-nosort" id="detail-normal"'?>><a  onclick="ECP_Load_Div('file_area_div','<?=$pd['ob_seqno_url']?>');">附件類型</a></td>
        	<td class="mm_table2_title2" <?=$ob=='filename'?'id="'.$pd['ob_css'].'"':'class="detail-nosort" id="detail-normal"'?>><a  onclick="ECP_Load_Div('file_area_div','<?=$pd['ob_filename_url']?>');">附件名稱</a></td>
            <td class="mm_table2_title2" width="120" <?=$ob=='uploader_name'?'id="'.$pd['ob_css'].'"':'class="detail-nosort" id="detail-normal"'?>><a  onclick="ECP_Load_Div('file_area_div','<?=$pd['ob_uploader_name_url']?>');">上傳者</a></td>
            <td class="mm_table2_title2" id="detail-normal">刪除</td>         
        </tr>
        <?php
		if(file_exists('uploads/project_file/'.$this->GM->GetSpecData('jec_project','value','jec_project_id',$proj_data['jec_project_id']).'/'.$this->CM->ReadFileName('download','履約備品清單-'.$proj_data['name'].'.xls'))):
			//
			?>
        <tr>
        	<td>系統產生<br/><a href='#' onclick="PG_BK_Action('updatexls')">重新產生履約備品清單xls檔</a></td>
        	<td><a href="<?=base_url().'uploads/project_file/'.$proj_data['value'].'/履約備品清單-'.$proj_data['name'].'.xls' ?>"><?='履約備品清單-'.$proj_data['name'].'.xls'?></a><br/>(送出後此excel檔才會更新,如需預覽請至備品清單明細匯出查看)</td>
            <td ></td>
            <td ></td>
        </tr>
        <?php
		elseif(file_exists('uploads/project_file/'.$this->GM->GetSpecData('jec_project','value','jec_project_id',$proj_data['jec_project_id']).'/'.$this->CM->ReadFileName('download','履約備品清單-'.$proj_data['value'].'.xls'))):
			//
			?>
        <tr>
        	<td>系統產生<br/><a href='#' onclick="PG_BK_Action('updatexls')">重新產生履約備品清單xls檔</a></td>
        	<td><a href="<?=base_url().'uploads/project_file/'.$proj_data['value'].'/履約備品清單-'.$proj_data['value'].'.xls' ?>"><?='履約備品清單-'.$proj_data['value'].'.xls'?></a><br/>(送出後此excel檔才會更新,如需預覽請至備品清單明細匯出查看)</td>
            <td ></td>
            <td ></td>
        </tr>				
			<?php
		endif;
		?>
        <?php //
			$ip_info['jec_usersuper_id_title']['style']="width:45px;";
			$ip_info['jec_user_id_title']['style']="width:45px;";
			$ip_info['taskconfirmtype']['style']="width:50px;";
			$ip_info['taskworkweight']['style']="width:35px;";
			$ip_info['taskdaynotice']['style']="width:17px;";
			$ip_info['taskdaydelay']['style']="width:17px;";
			$ip_info['taskname']['style']="width:100px;";
			$ip_info['price']['style']="width:50px;";
			$ip_info['description']['style']="width:70px;";
			//-- 
			 foreach($main_list as $no=>$value):?>
        	<?php
			//$value['startdate']=substr($value['startdate'],0,10); - 
			//$value['enddate']=substr($value['enddate'],0,10);
			//$ip_info['jec_user_id']['ld']=$user_ld;
			/*
			if($value['jec_user_id']>0||$value['jec_group_id']>0):
				$ip_info['jec_user_id']['full_selected']='N';
			else:
				$ip_info['jec_user_id']['full_selected']='Y';
			endif;*/
			//$value['jec_user_id_title']=$value['sales_name'];
			//if($value['jec_user_id_title']==''&&(int)$value['jec_group_id']>0) $value['jec_user_id_title']=$this->GM->GetSpecData("jec_group",'name','jec_group_id',$value['jec_group_id']);
			//$ip_info['jec_usersuper_id_title']['title']=$value['jec_usersuper_id_title']=$value['super_name'];
			//$ip_info['jec_user_id_title']['onclick']=$ip_info['jec_user_id_title']['onfocus']="PL_ChangePL('user_".$no."');";
			//$ip_info['jec_usersuper_id_title']['onclick']=$ip_info['jec_usersuper_id_title']['onfocus']="PL_ChangePL('usersuper_".$no."');";
			
			//$e_jec_user_id=(int)$value['jec_user_id']==0?'G-'.$value['jec_group_id']:'U-'.$value['jec_user_id'];
			//$value['jec_user_id']=$e_jec_user_id;
			//$ip_info['price']['disabled']=$value['isprojprod'];
			//$value['price']=(float)$value['price'];
			//$e_ip_info=$ip_info;
			/*
			$e_full_set=$full_set;
			if(!isset($e_full_set['disabled']))://非disabled				
				$edit_1_right=$this->mm_projtask_search_set->exe_right_check('check_edit_1',$value);
				$edit_2_right=$this->mm_projtask_search_set->exe_right_check('check_edit_2',$value);
				if($edit_1_right==false):
					foreach($edit_1_info as $ed1v):
						$e_ip_info[$ed1v]['disabled']='Y';//Yes
					endforeach;
				endif;
				if($edit_2_right==false):
					foreach($edit_2_info as $ed1v):
						$e_ip_info[$ed1v]['disabled']='Y';//Yes
					endforeach;
				endif;
				if($edit_2_right==false):
					//$e_full_set['disabled']='Y';
				endif;
			endif;
			$e_op=$this->form_input->each_op_trans('full',$e_ip_info,$value,'_'.$no,$e_full_set);*/
			?>
        <tr id="tr_<?=$no?>">
            <td>手動上傳</td>
			<td><a href="<?=$this->CM->DL_URL($value['jec_projfile_id'])?>" ><?=$value['filename']?></a></td> 
            <td><?=$value['uploader_name']?></td> 
            <td>
            	
            <input type="button" value="刪除"  onclick="AWEA_Ajax('<?=site_url('ecp_common/delete_file/reload_file_list/'.$value['jec_projfile_id'].'/')?>','','del','tr_<?=$no?>')"  class="mm_submit_button_1"  <?=$del_da?> >
            	
            </td> 
        </tr>      
        <?php endforeach;?>
    </table>