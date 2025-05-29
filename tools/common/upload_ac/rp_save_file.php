<?php
//回報存檔用的
//df_ip['key_id']=>projtask_id/df_ip['ac']
					$up_file_array=array();
					$proj_folder=$this->GM->GetSpecData('jec_project','value','jec_project_id',$projt_data['jec_project_id']);
					$save_folder='uploads/project_file/'.$proj_folder.'/';
					
					$file_ac=isset($file_ac)?$file_ac:$df_ip['ac'];
					$folder=$file_ac.$gv['time_tag'];
					$source_path='uploads/'.MM_Common_Temp.$folder.'/';
					
					if(file_exists($source_path.'upload_list.txt')):
						$saved=file_get_contents($source_path.'upload_list.txt');
					else:
						$saved='';
					endif;
					
					$saved_list=$this->CM->GetRow($saved,'<ef>','</ef>');
					$saved_info=array();
					$saved_key=array();
					foreach($saved_list as $value):
						$ef=trim($this->CM->GetString($value,'','@@@@@@@@@@'));
						$ename=trim($this->CM->GetString($value,'@@@@@@@@@@',''));
						log_message('info','save name:'.$ename.',ef:'.$ef);
						/*
						$check=$this->CM->db->where('filename',$ename)->where('isactive','Y')->get('jec_projfile')->result_array();

						if(count($check)==0&&trim($ename)!=''):
							
							$upd=array_merge(array('jec_user_id'=>$this->ad_id,'jec_project_id'=>$projt_data['jec_project_id'],'jec_projjob_id'=>$projj_data['jec_projjob_id'],'jec_projtask_id'=>$projt_data['jec_projtask_id'],'filetype'=>2,'filename'=>$ename,'filepath'=>$save_folder),$this->CM->Base_New_UPD());
							$this->CM->db->insert('jec_projfile',$upd);
							$file_id=mysql_insert_id();
							array_push($up_file_array,$file_id);
						//move
							@copy($source_path.$ef,$save_folder.iconv('utf-8','big5',$ename));
						endif;
						*/
						
						if(trim($ename)!=''):
							
							
							$save_name=$this->CM->ReadFileName('save',$ename);
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
									
										$upd=array_merge(array('jec_user_id'=>$this->ad_id,'jec_project_id'=>$projt_data['jec_project_id'],'jec_projjob_id'=>$projj_data['jec_projjob_id'],'jec_projtask_id'=>$projt_data['jec_projtask_id'],'filetype'=>2,'filename'=>$test_name,'filepath'=>$save_folder),$this->CM->Base_New_UPD());
										$this->CM->db->insert('jec_projfile',$upd);
										$file_id=mysql_insert_id();
										array_push($up_file_array,$file_id);
										@copy($source_path.$ef,$save_folder.$this->CM->ReadFileName('read',$test_name));
										break;
									endif;
								 endfor;
						 	else:
								$upd=array_merge(array('jec_user_id'=>$this->ad_id,'jec_project_id'=>$projt_data['jec_project_id'],'jec_projjob_id'=>$projj_data['jec_projjob_id'],'jec_projtask_id'=>$projt_data['jec_projtask_id'],'filetype'=>2,'filename'=>$save_name,'filepath'=>$save_folder),$this->CM->Base_New_UPD());
								$this->CM->db->insert('jec_projfile',$upd);
								$file_id=mysql_insert_id();
								array_push($up_file_array,$file_id);
								@copy($source_path.$ef,$save_folder.$read_name);
						 	endif;
						endif;	
							
						
						

					endforeach;	
					$this->load->model('File_model','FM',True);
					$this->FM->delete_temp_folder($source_path);

//delete
?>
