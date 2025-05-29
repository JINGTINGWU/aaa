<?php
$projf_set=$this->CM->Init_TB_Set('mm_projfile_set');
//$save_folder='uploads/project_file/';
$save_folder='';
		foreach($saved_info as $value):
			if(!in_array($value,$keep_info)):
				$this->CM->db->where('jec_projfile_id',$saved_key[$value])->update('jec_projfile',array('isactive'=>'N'));
				
			else:
				//copy
				//get_file_name
				/*
				$efile_data=$this->CM->db->where('jec_projfile_id',$saved_key[$value])->get('jec_projfile')->result_array();
				if(count($efile_data)>0):
					@copy($target_folder.$value,$save_folder.iconv('utf-8','big5',$efile_data[0]['filename']));
				endif;		*/
				
				$efile_data=$this->CM->db->where('jec_projfile_id',$saved_key[$value])->get('jec_projfile')->result_array();
				if(count($efile_data)>0):
				
					if($save_folder==''):
						$save_folder='uploads/project_file/'.$this->GM->GetSpecData('jec_project','value','jec_project_id',$efile_data[0]['jec_project_id']).'/';
					endif;
				
					//check_name_duplicate
					//Pig.Group Don't bother me.-  
					$save_name=$this->CM->ReadFileName('save',$efile_data[0]['filename']);
					//check_dup
					//$this->CM->JS_TMsg($save_name);
					$read_name=$this->CM->ReadFileName('read',$save_name);
					if(file_exists($save_folder.$read_name))://
						//$only_name=$this->CM->FormatData($save_name,'file',1);
						$sub_name='.'.$this->CM->FormatData($save_name,'file',2);
						$only_name=str_replace($sub_name,'',$save_name);
						for($i=1;$i<=999;$i++):
							$eno=$this->CM->FormatData(array('len'=>3,'value'=>$i),'number','fill_num');
							$test_name=$only_name.'-'.$eno.$sub_name;
							
							if(!file_exists($save_folder.$this->CM->ReadFileName('read',$test_name))):
								//update
								$this->CM->db->where($projf_set['mm_kid'],$saved_key[$value])->update($projf_set['mm_tb'],array('filename'=>$test_name));
								@copy($target_folder.$value,$save_folder.$this->CM->ReadFileName('read',$test_name));
								break;
							endif;
						endfor;
					else:
						@copy($target_folder.$value,$save_folder.$read_name);
					endif;
					//@copy($target_folder.$value,$save_folder.iconv('utf-8','big5',$efile_data[0]['filename']));
				 endif;							
			endif;
		endforeach;
//reload_ac
$bk_action="reload_file_list";
//delete
?>
