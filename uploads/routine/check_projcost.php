<?php

//計算專案實際花費是否高於預估成本
$fp = fopen('uploads/routine/projcost_' . date('Y-m-d-H-i-s') . '.txt', 'a+');  // Debug
$mssqlef = $this->load->database('mssqlefnet', true);
$pms = $this->load->database('default', true);
$where = "efprojno is not null and efprojno !='' AND isactive='Y' and projtype=1";
$project_list = $pms->where($where)->get('jec_project')->result_array();
foreach ($project_list as $value):
    $projcost = $mssqlef->where('odmems003005', $value['efprojno'])->select('odmems003004C')->select('odmems003006')->select('odmems003016')->get('odmems003')->result_array();
    $projcost_value = '';
    foreach ($projcost as $row) {
        $projcost_value = $row['odmems003016'];
    }
    $projcost_value = str_replace(',', '', $projcost_value);
    //$projtaskcost=$pms->where('jec_project_id',$value['jec_project_id'])->where('isactive','Y')->select_sum('price',sumprice)->get('jec_projtask')->result_array();//加總工作的實際成本
    $projtaskcost = $pms->where('jec_project_id', $value['jec_project_id'])->where('isactive', 'Y')->where('isexport', 'Y')->select_sum('total', sumprice)->get('jec_projprod')->result_array(); //加總工作明細已送出報支單的費用
    $projtaskcost_value = '';
    foreach ($projtaskcost as $row) {
        $projtaskcost_value = $row['sumprice'];
    }
    fwrite($fp, 'pms專案名：' . $value['name'] . '，ef專案資訊：' . $value['efprojdept'] . $value['efprojno'] . $value['efprojname'] . '，預估成本：' . (int) $projcost_value . '，實際花費：' . (int) $projtaskcost_value . "\r\n");  // Debug
    if ((int) $projcost_value>0 && (int) $projtaskcost_value > (int) $projcost_value) {
        $this->CM->JS_TMsg($value['jec_project_id'] . '-' . (int) $projcost_value . '-' . (int) $projtaskcost_value);
        fwrite($fp, 'pms專案名：' . $value['name'] . '，ef專案資訊：' . $value['efprojdept'] . $value['efprojno'] . $value['efprojname'] . '，預估成本：' . (int) $projcost_value . '，實際花費：' . (int) $projtaskcost_value . "\r\n");  // Debug

        $email = array(
            'name' => '履約管制系統',
            'to' => 'a' . $this->GM->GetSpecData('jec_setup', 'value', 'noticetype', 'EW') . '@ems.com.tw',
            'time' => date('Y-m-d H:i:s'),
            'subject' => '[警示] 專案實際花費高於預估成本',
            'content' => 'pms專案名：' . $value['name'] . '，ef專案資訊：' . $value['efprojdept'] .'-'. $value['efprojno'] .'-'.$value['efprojname'] . '，預估成本：' . (int) $projcost_value . '，實際花費：' . (int) $projtaskcost_value,
            'emailsend' => 'N'
        );
        //$this->CM->JS_TMsg('Begin send email');
        if ($this->CM->SendMailGo($email['to'], $email['name'], $email['subject'], $email['content'], '', 'From-System')):
            $email['emailsend'] = 'Y';
        endif;
        //送籢呈....... 
        $target_db = $this->GM->GetSpecData('jec_company', 'dbsetup', 'jec_company_id', '1');
        $p_user_id = $this->GM->GetSpecData('jec_user', 'jec_user_id', 'value', $this->GM->GetSpecData('jec_setup', 'value', 'noticetype', 'EW'));
        $p_user = $this->QIM->get_user_row($p_user_id);
        $target_db = 'mssqlefnet';
        $prodprep_v_set=$this->CM->Init_TB_Set('mm_productprep_search_set');
        $mssqlef = $this->load->database($target_db, TRUE); //mssqlef


        $ms_p_user = $mssqlef->query("SELECT a.resan001 AS deptno, b.resal003 AS deptname FROM resan a LEFT JOIN resal b ON a.resan001=b.resal001 WHERE a.resan003='" . $this->CM->db_trans($p_user['value'], 'input') . "'")->result_array();
        if (count($ms_p_user) > 0):
            $ms_p_user = $ms_p_user[0];
        else:
            $ms_p_user = array('deptno' => '', 'deptname' => '');
        endif;
        $serial = date('Y-m-d-H-i-s-') . rand(100, 999);
        $time = date('Y/m/d H:i:s');
        $ODMEMS001_upd = array(
            'odmems001001' => '',
            'odmems001002' => '',
            'odmems001003' => $this->CM->pdb_trans('履約管制系統'),
            'odmems001004' => $this->CM->pdb_trans($p_user['value']), //p_acc 承辦人->登入者,//...
            'odmems001004c' => $this->CM->pdb_trans($p_user['name']), //p_name
            'odmems001005' => $ms_p_user['deptname'], //p_dept 
            'odmems001006' => date("Ymd"), //申請日期
            'odmems001007' => 'PMS系統自動警示-標案實際花費高於預估支出金額', //主旨	
            'odmems001008' => 'PMS專案名：' . $value['name'] . '，EF.net專案資訊：' . $value['efprojdept'] .'-'.$value['efprojno'] .'-'. $value['efprojname'] . '，預估成本：' . (int) $projcost_value . '，實際花費：' . (int) $projtaskcost_value, //擬辦
            'odmems001009' => '略',
            'odmems001024' => $target_db,
            'odmems001025' => $this->CM->pdb_trans('無'),
            'odmems001026'=>$this->$prodprep_v_set['mm_set']->get_projfile_string($value)//附件字串,
        );
        $proj_company = $this->GM->GetSpecData('jec_company', 'name', 'jec_company_id', $data['proj_data']['jec_company_id']);
        $e_upd = array(
            'strFormID' => $this->CM->pdb_trans('ODMEMS001'),
            'ScriptSheetNo' => $this->CM->pdb_trans($time),
            'Owner' => $this->CM->pdb_trans($p_user['value']), //acc
            'RecordsetName' => $this->CM->pdb_trans('resda'),
            'FieldName' => $this->CM->pdb_trans('ScriptSubj'),
            'RecordIndex' => $this->CM->pdb_trans(1),
            'FieldValue' => $this->CM->pdb_trans('1§[PMS警示] 標案實際花費高於預估支出金額') //$現在日期$-$專案名稱$-$任務名稱$-$工作明稱$//主旨
        );

        $mssqlef->insert('ressa', $e_upd); //

        $xmlstr = "<diffgr:diffgram xmlns:msdata=\"urn:schemas-microsoft-com:xml-msdata\" xmlns:diffgr=\"urn:schemas-microsoft-com:xml-diffgram-v1\">
  <NewDataSet>
    <RESULT diffgr:id=\"RESULT2\" msdata:rowOrder=\"0\" diffgr:hasChanges=\"inserted\">
      <COMPANY>EFNETDB</COMPANY>
      <CREATE_DATE>" . date("Ymd") . "</CREATE_DATE>
      <CREATOR>" . $this->CM->pdb_trans($p_user['value']) . "</CREATOR>
      <FLAG>1</FLAG>
      <USR_GROUP>0000</USR_GROUP>
      <odmems001001>ODMEMS001</odmems001001>
      <odmems001002>AutoNumber</odmems001002>
      <odmems001003>" . $ODMEMS001_upd['odmems001003'] . "</odmems001003>
      <odmems001004>" . $ODMEMS001_upd['odmems001004'] . "</odmems001004>
      <odmems001004C>" . $ODMEMS001_upd['odmems001004c'] . "</odmems001004C>
      <odmems001005>" . $ODMEMS001_upd['odmems001005'] . "</odmems001005>
      <odmems001006>" . $ODMEMS001_upd['odmems001006'] . "</odmems001006>
	  <odmems001007>" . $ODMEMS001_upd['odmems001007'] . "</odmems001007>
	  <odmems001008>" . $ODMEMS001_upd['odmems001008'] . "</odmems001008>
	  <odmems001009>" . $ODMEMS001_upd['odmems001009'] . "</odmems001009>
      <odmems001024>" . $ODMEMS001_upd['odmems001024'] . "</odmems001024>
      <odmems001025>無</odmems001025>
      <odmems001026>".$ODMEMS001_upd['odmems001026']."</odmems001026>
    </RESULT>
  </NewDataSet>
</diffgr:diffgram>
				";
        //log_message('info','xml:'.$xmlstr);				
        $e_upd = array(
            'strFormID' => $this->CM->pdb_trans('ODMEMS001'),
            'ScriptSheetNo' => $this->CM->pdb_trans($time),
            'Owner' => $this->CM->pdb_trans($p_user['value']), //acc
            'RecordsetName' => $this->CM->pdb_trans('rstODMEMS001'),
            'FieldName' => '',
            'RecordIndex' => $this->CM->pdb_trans(0),
            'FieldValue' => $xmlstr,
        );
        //insert 

        $mssqlef->insert('ressa', $e_upd);
    }
endforeach;
fclose($fp); // Debug
?>