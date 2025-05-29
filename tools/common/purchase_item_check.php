<?php
//e_db/e_value
	//$check_1=$e_db->query("SELECT top 1 * FROM ressa WHERE FieldValue LIKE '%".$e_value['exportcode']."%' AND  strFormID='ODMEMS005' AND FieldName='odmems005904' ")->result_array();
$query = $e_db->query("SELECT top 1 * FROM ressa WHERE FieldValue LIKE '%".$e_value['exportcode']."%' AND  strFormID='ODMEMS005' AND RecordsetName='rstODMEMS005'");

$check_1 = array();
if($query !== FALSE && $query->num_rows() > 0){
    $check_1 = $query->result_array();
	
//$check_1=$e_db->query("SELECT top 1 * FROM ressa WHERE FieldValue LIKE '%".$e_value['exportcode']."%' AND  strFormID='ODMEMS005' AND RecordsetName='rstODMEMS005' ")->result_array();
	$e_upd=array( //clean
				'isexport'=>'N',
				'exporttime'=>'0000-00-00 00:00:00',
				'exportcode'=>'',
				'isworkflow'=>'N',
				'workflowtime'=>'0000-00-00 00:00:00',
				'ad005002'=>'',
				'ad005003'=>'',
				'resda020'=>0,
				'resda021'=>0,
				'jec_company_id'=>NULL
		);	
	if(count($check_1)>0):
		//$msg.='Y';
		//check resda-不動-還在草稿
		//echo '<msg>here</msg>';
		//$this->CM->JS_TMsg('here');
	else:
		//$this->db->where('jec_prodprod_id',$e_value['jec_projprod_id'])->update('jec_projprod',$e_upd);
		
		$check_2=$e_db->query("SELECT * FROM odmems005 WHERE odmems005904='".$e_value['exportcode']."'")->result_array();
		//$check_2=array(1);
		if(count($check_2)>0):
			//check簽核
		log_message('info','in odmems005 exportcode:'.$e_value['exportcode']);
			$check_3=$e_db->query("SELECT * FROM resda WHERE resda001='ODMEMS005' AND resda002='".$check_2[0]['odmems005002']."'")->result_array();
			if(count($check_3)>0):
					log_message('info','in odmems005002:'.$check_2[0]['odmems005002']);

				$i_upd=array(
						'ad005002'=>$check_2[0]['odmems005002'],
						'ad005003'=>$check_2[0]['odmems005002'],
						'resda020'=>$check_3[0]['resda020'],
						'resda021'=>$check_3[0]['resda021']
					);
				if($i_upd['resda020']==3&&$i_upd['resda021']==2):
				   $i_upd['isworkflow']='Y';
				   $i_upd['workflowtime']=date('Y-m-d H:i:s');
				endif;
				if($i_upd['resda020']==4||($i_upd['resda021']==4||$i_upd['resda021']==3)):
					$i_upd=array_merge($e_upd,$i_upd);
					unset($e_upd['exportcode']);
				endif;
				$this->db->where('jec_projprod_id',$e_value['jec_projprod_id'])->update('jec_projprod',$i_upd);
				
			else:
				//default. Not My Business. 固定尺寸
			endif;
		else:
			//被刪掉了
			//$msg.='>'.$e_value['jec_projprod_id'].'<';
			$this->db->where('jec_projprod_id',$e_value['jec_projprod_id'])->update('jec_projprod',$e_upd);
		endif;
	endif;
}
?>