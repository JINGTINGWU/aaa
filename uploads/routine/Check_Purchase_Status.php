<?php
				$projp_set=$this->CM->Init_TB_Set('mm_projprod_set');
				$final['main_list']=$this->GM->common_ac('list',array('info'=>$projp_set['mm_set'],'type'=>'def','data'=>array('con_isexport'=>'Y','con_isworkflow'=>'N','con_isactive'=>'Y')));
				//db分頁…超煩的= =
				$main_list=$this->$projp_set['mm_set']->classify_purchase_check_item_by_db($final['main_list']);
				foreach($main_list as $db_id=>$e_list):
					//check_each_value
					if((int)$db_id>0):
						$e_db=$this->load->database($this->GM->GetSpecData('jec_company','dbsetup','jec_company_id',$db_id),TRUE);
						foreach($e_list as $e_value):
						//check-check-e_value.e_db
							include('tools/common/purchase_item_check.php');
						endforeach;
					endif;
				endforeach;
				//OK--
				//$this->CM->JS_TMsg('test');
?>