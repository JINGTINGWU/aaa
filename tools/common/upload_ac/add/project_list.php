
<?php
//key_id
//$target_folder=$targetDir;
$projid=$this->GM->GetSpecData('jec_projfile','jec_project_id','jec_projfile_id',$efid);
$proj_folder=$this->GM->GetSpecData('jec_project','value','jec_project_id',$projid);
$save_folder='uploads/project_file/'.$proj_folder.'/';
if(file_exists($target_folder.'upload_list.txt')):
	$as_info=array();
	if(file_exists($target_folder.'already_saved.txt')):
		$as_data=file_get_contents($target_folder.'already_saved.txt');
		$as_list=$this->CM->GetRow($as_data,'<ef>','</ef>');
		foreach($as_data as $value):
			$eid=trim($value);
			array_push($as_info,$eid);
		endforeach;
	endif;
	
	$as_content=fopen($target_folder.'already_saved.txt','a+');

	$uploaded=file_get_contents($target_folder.'upload_list.txt');
	$uploaded_list=$this->CM->GetRow($uploaded,'<ef>','</ef>');
	$uploaded_info=array();
	$projf_set=$this->CM->Init_TB_Set('mm_projfile_set');
	foreach($uploaded_list as $value):
		$eid=trim($this->CM->GetString($value,'','@@@@@@@@@@'));
		if(!in_array($eid,$as_info)):
			
			//save-!  It's your turn.
			$save_name=trim($this->CM->GetString($value,'@@@@@@@@@@',''));
			@copy($target_folder.$eid,$save_folder.$save_name);
			$upd=array_merge(array('jec_project_id'=>$key_id,'filename'=>$save_name,'filepath'=>$save_folder),$this->CM->Base_New_UPD());
			$this->GM->common_ac('insert',array('info'=>$projf_set['mm_set'],'upt'=>'def','upd'=>$upd));
			$file_id=mysql_insert_id();
			fwrite($as_content,"<ef>".$eid."@@@@@@@@@@".$file_id."</ef>");
		endif;
		//array_push($uploaded_info,$eid);
			//fwrite($save_record,"\n\n".$eid."===".$type);
	endforeach;
	fclose($as_content);
endif;
?>

