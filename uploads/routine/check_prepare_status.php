<?php	//@@
				$proj_set=$this->CM->Init_TB_Set('mm_project_set');
				
				$final['main_list']=$this->GM->common_ac('list',array('info'=>$proj_set['mm_set'],'type'=>'def','data'=>array('con_isworkflow'=>'N','con_exportcode <>'=>'','con_isactive'=>'Y')));
				//db分頁…超煩的= =
				
				$main_list=$this->$proj_set['mm_set']->classify_prepare_check_item_by_db($final['main_list']);
				
				foreach($main_list as $db_id=>$e_list):				
					//check_each_value-
					if((int)$db_id>0):
						$e_db=$this->load->database('mssqlefnet',TRUE);	
						//$e_db=$this->load->database($this->GM->GetSpecData('jec_company','dbsetup','jec_company_id',$db_id),TRUE);						
						//$e_db='mssqlefnet';
						foreach($e_list as $e_value):
						//check-check-e_value.e_db
							include('tools/common/prepare_item_check.php');
						endforeach;
					endif;
				endforeach;
				//OK--
				//$this->CM->JS_TMsg('test');//
?>