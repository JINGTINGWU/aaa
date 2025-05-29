<?php
//e_db/e_value->pre_pare.
	
	//$check_1=$e_db->query("SELECT * FROM ressa WHERE FieldValue LIKE '%<odmems001027>".$e_value['exportcode']."</odmems001027>%' AND strFormID='ODMEMS001'")->result_array();
$check_1=$e_db->query("SELECT * FROM ressa WHERE FieldValue LIKE '%".$e_value['value'].$e_value['name']."%' AND strFormID='ODMEMS001'")->result_array();
		
	$e_upd=array( //clean. 
				'isworkflow'=>'N',
				'exportcode'=>'',
				'ef_company_id'=>'',
				'ad004002'=>'',
				'ad004003'=>'',
				'resda020'=>0,
				'resda021'=>0
		);
	if(count($check_1)>0):
		//check resda-不動-還在草稿

	else:
		//$this->db->where('jec_prodprod_id',$e_value['jec_projprod_id'])->update('jec_projprod',$e_upd);
		
		//$check_2=$e_db->query("SELECT * FROM AD004 WHERE ad004910='".$e_value['exportcode']."'")->result_array();
		//$check_2=$e_db->query("SELECT * FROM AD004 WHERE ad004910 LIKE'".$e_value['exportcode']."'")->result_array();
		
		$check_2=$e_db->where('odmems001027',$e_value['exportcode'])->get('odmems001')->result_array();
		
		//$check_2=array(1);
		if(count($check_2)>0):
			//check簽核
			//$check_3=array();
			$check_3=$e_db->query("SELECT * FROM resda WHERE resda001='ODMEMS001' AND resda002='".$check_2[0]['odmems001002']."'")->result_array();
			if(count($check_3)>0):
				$i_upd=array(
						'ad004002'=>$check_2[0]['odmems001002'],
						'ad004003'=>$check_2[0]['odmems001002'],							
						'resda020'=>$check_3[0]['resda020'],
						'resda021'=>$check_3[0]['resda021']
					);
					
				if($i_upd['resda020']==3&&$i_upd['resda021']==2):
				   $i_upd['isworkflow']='Y';//
				   //$i_upd['workflowtime']=date('Y-m-d H:i:s');
				endif;
				if($i_upd['resda020']==4||($i_upd['resda021']==4||$i_upd['resda021']==3)):
					$i_upd=array_merge($e_upd,$i_upd);
					unset($e_upd['exportcode']);
				endif;
				$this->db->where('jec_project_id',$e_value['jec_project_id'])->update('jec_project',$i_upd);
				
			else:
				//....
			endif;
		else:
			//被刪掉了
			$this->db->where('jec_project_id',$e_value['jec_project_id'])->update('jec_project',$e_upd);
		endif;
	endif;

?>