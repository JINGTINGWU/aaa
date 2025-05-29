<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Mm_project_set
{
    var $mm_tb='jec_project';
	var $mm_tablename='JEC_Project';
	var $mm_glt='2';
    var $mm_td=array();
    var $mm_kid='jec_project_id';
    var $mm_deltype='isactive';
    var $mm_actb='jec_project';
			
	public function __construct()
	{   global $_G;
		$this->ci =& get_instance();
		$this->load_mm_td();
	}
	
	function load_mm_td()
	{   global $_G;
	    $this->mm_td=array(
		        'nav'=>array(   //noticetype
						'con'=>array('datatype'=>3)				
				    ),																	
				'def'=>array()
		    );
		
	}
    function load_mm_field_check()
    {	global $_G;

        $final=array(
                'value'=>array(
                        'call_name'=>'專案編號',
                        'type'=>'text',
                        'readonly'=>'Y'//系統給定 
                    ),
                'jec_company_id'=>array(
                        'call_name'=>'公司別',
                        'type'=>'select',
                        'ld'=>'mm_company_set@def',
                        'ld_value'=>'name',
                        'ld_key'=>'jec_company_id',
                        'full_selected'=>'N'
                    ),
                'projyear'=>array(
                        'call_name'=>'專案年度',
                        'type'=>'select',
						'ld'=>$this->ci->CM->FormatData(array('key'=>'id','value'=>'name','sn'=>(date('Y')-1),'en'=>(date('Y')+4)),"page_db","num"),
						'ld_key'=>'id',
						'ld_value'=>'name',
						'full_selected'=>'N'
                    ),
                'jec_dept_id'=>array(
                        'call_name'=>'部門',
                        'type'=>'select',
						'ld'=>'mm_dept_set@def',
						'ld_key'=>'jec_dept_id',
						'ld_value'=>'name',
						'ld_choose_msg'=>'-部門-',
						'disabled'=>'Y'
                    ),
                'name'=>array(
                        'call_name'=>'專案名稱',
                        'type'=>'text',
						'style'=>'width:260px;'
                    ),
                'description'=>array(
                        'call_name'=>'備註說明',
                        'type'=>'text',
						'style'=>'width:680px;'
                    ),/*
                'jec_customer_id'=>array(
                        'call_name'=>'客戶',
                        'type'=>'select',
                        'ld'=>'mm_customer_set@def',
                        'ld_key'=>'jec_customer_id',
                        'ld_value'=>'name'
                    ),*/
                'jec_project_id_title'=>array(
                        'call_name'=>'專案-顯示',
                        'type'=>'text',
						'onblur'=>'PL_CloseList();',
						'onclick'=>"PL_ChangePL('project');",
						'onfocus'=>"PL_ChangePL('project');",
						'style'=>"width:260px;"
                    ),
                'jec_project_id'=>array(
                        'call_name'=>'專案',
                        'type'=>'hidden'
                    ),					
                'jec_customer_id_title'=>array(
                        'call_name'=>'客戶-顯示',
                        'type'=>'text',
						'onblur'=>'PL_CloseList();',
						'onclick'=>"PL_ChangePL('cus');",
						'onfocus'=>"PL_ChangePL('cus');",
						'style'=>"width:260px;"
                    ),
                'jec_customer_id'=>array(
                        'call_name'=>'客戶',
                        'type'=>'hidden'
                    ),/*
                'jec_user_id'=>array(
                        'call_name'=>'專案負責人',
                        'type'=>'select',
                        'ld'=>'mm_user_set@def',
                        'ld_key'=>'jec_user_id',
                        'ld_value'=>'name'
                    ),
                'jec_usersales_id'=>array(
                        'call_name'=>'專案業務',
                        'type'=>'select',
                        'ld'=>'mm_user_set@def',
                        'ld_key'=>'jec_user_id',
                        'ld_value'=>'name'
                    ),*/
                'jec_user_id'=>array(
                        'call_name'=>'專案負責人',
                        'type'=>'hidden'
                    ),
                'jec_user_id_title'=>array(
                        'call_name'=>'專案負責人=input',
                        'type'=>'text',
						'onblur'=>'PL_CloseList();',
						'onclick'=>"PL_ChangePL('user');",
						'onfocus'=>"PL_ChangePL('user');"/*,
						'style'=>"width:120px;"*/
                    ),
					'createdby'=>array(
                        'call_name'=>'建檔人員',
                        'type'=>'hidden'
                    ),
                'createdby_title'=>array(
                        'call_name'=>'建檔人員',
                        'type'=>'text',
						'value'=>'test',
						'onblur'=>'PL_CloseList();',
						'onclick'=>"PL_ChangePL('createdby');",
						'onfocus'=>"PL_ChangePL('createdby');"/*,
						'style'=>"width:120px;"*/
                    ),
                'jec_usersales_id'=>array(
                        'call_name'=>'專案業務',
                        'type'=>'hidden'
                    ),
                'jec_usersales_id_title'=>array(
                        'call_name'=>'專案業務',
                        'type'=>'text',
						'onblur'=>'PL_CloseList();',
						'onclick'=>"PL_ChangePL('usersales');",
						'onfocus'=>"PL_ChangePL('usersales');"/*,
						'style'=>"width:120px;"*/
                    ),
                'startdate'=>array(
                        'call_name'=>'起始日期',
                        'type'=>'text',
                        'readonly'=>'Y'//cal
                    ),
                'enddate'=>array(
                        'call_name'=>'結束日期',
                        'type'=>'text',
                        'readonly'=>'Y'//cal
                    ),
				'showdate'=>array(
                        'call_name'=>'範本日期',
                        'type'=>'text',
						'style'=>"width:100px;",
                        'readonly'=>'Y'//cal
                    ),
				'getdate'=>array(
                        'call_name'=>'得標日期',
                        'type'=>'text',
						'style'=>"width:100px;",
                        'readonly'=>'Y'//cal
                    ),
				'limitdate'=>array(
                        'call_name'=>'合約期限',
                        'type'=>'text',
						'style'=>"width:100px;",
                        'readonly'=>'Y'//cal
                    ),
                'projtype'=>array(
                        'call_name'=>'專案性質',
                        'type'=>'select',
                        'ld'=>$this->ci->$_G['L_CS']->common_use_ld('projtype'),
                        'ld_key'=>'id',
                        'ld_value'=>'name',
						'full_selected'=>'N',
						'onchange'=>"projtype_onchange();"
                    ),
				'tendertype'=>array(
                        'call_name'=>'標案類型',
                        'type'=>'select',
                        'ld'=>$this->ci->$_G['L_CS']->common_use_ld('tendertype'),
                        'ld_key'=>'id',
                        'ld_value'=>'name',
						'full_selected'=>'N'
                    ),
                'projstatus'=>array(
                        'call_name'=>'專案狀態',
                        'type'=>'select',
                        'ld'=>$this->ci->$_G['L_CS']->common_use_ld('projstatus'),
                        'ld_key'=>'id',
                        'ld_value'=>'name'              
                    ),
                'customerdoc'=>array(
                        'call_name'=>'客戶案號',
                        'type'=>'text',
						'maxlength'=>50            
                    ),
                'value2'=>array(
                        'call_name'=>'工程(採購)編號',
                        'type'=>'text',
						'maxlength'=>50,
						'style'=>'width:260px;'            
                    ),
                'name2'=>array(
                        'call_name'=>'工程(標的)名稱',
                        'type'=>'text',
						'maxlength'=>50,
						'style'=>'width:260px;'            
                    ),
                'address'=>array(
                        'call_name'=>'履約地點',
                        'type'=>'text',
						'maxlength'=>100 ,
						'style'=>'width:400px;'           
                    ),
                'description2'=>array(
                        'call_name'=>'備註說明2',
                        'type'=>'text',
						'maxlength'=>100,
						'style'=>'width:300px;'            
                    ),
                'description3'=>array(
                        'call_name'=>'預算金額',
                        'type'=>'text',
						'pii'=>array('nod')              
                    ),
                'efprojdept'=>array(
                        'call_name'=>'部門',
                        'type'=>'select',
						'disabled'=>'Y',
						'ld'=>array(),
						'ld_key'=>'odmems003004C',
						'ld_value'=>'odmems003004C'           
                    ),/*
                'efprojno'=>array(
                        'call_name'=>'採購編號',
                        'type'=>'select',
						'ld'=>array(),
						'ld_key'=>array('ad019004','ad019006'),
						'ld_key_span'=>'>>',
						'ld_value'=>array('ad019004','ad019006'),
						'style'=>'width:160px;'        
                    ),*/
                'efprojno'=>array(
                        'call_name'=>'採購編號',
                        'type'=>'text',
						'disabled'=>'Y',
						'style'=>'width:120px;'        
                    ),//
                'efprojname'=>array(
                        'call_name'=>'採購名稱',
                        'type'=>'text',
						'maxlength'=>100,
						'disabled'=>'Y',
						'style'=>'width:400px;',
						'readonly'=>'Y'           
                    ),
                'total'=>array(
                        'call_name'=>'合約總價',
                        'type'=>'text',
						'pii'=>array('nod')          
                    ),
                'costrate'=>array(
                        'call_name'=>'成本係數',
                        'type'=>'text',
						'pii'=>array('nod')          
                    ),
                'totalvoucher'=>array(
                        'call_name'=>'發票金額',
                        'type'=>'text',
						'pii'=>array('nod')  
                    ),
                'totalaccept'=>array(
                        'call_name'=>'驗收金額',
                        'type'=>'text',
						'pii'=>array('nod')          
                    )
            );
        return $final;
    }    
	
	function classify_prepare_check_item_by_db($list=array())
	{	$final=array();
		foreach($list as $value):
			if(isset($final[$value['ef_company_id']])):
				array_push($final[$value['ef_company_id']],$value);
			else:
				
				$final[$value['ef_company_id']]=array($value);
			endif;
		endforeach;
		return $final;
	}
	
	function get_project_cost($project_id=0)
	{
		//Don't bother me.
		$sql="SELECT SUM(price) AS cost FROM jec_projtask WHERE jec_project_id='".$project_id."' AND isactive='Y'";
		$result=$this->ci->db->query($sql)->result_array();
		return (float)$result[0]['cost'];
	}
	function get_jtp_num($project_id=0,$type=0)
	{	//Don't dream.
		$final='';
		if($type===0):
			$j_data=$this->ci->db->query("SELECT COUNT(jec_projjob_id) AS num FROM jec_projjob WHERE jec_project_id='".$project_id."' AND isactive='Y'")->result_array();
			$t_data=$this->ci->db->query("SELECT COUNT(jec_projtask_id) AS num FROM jec_projtask WHERE jec_project_id='".$project_id."' AND isactive='Y'")->result_array();
			$p_data=$this->ci->db->query("SELECT COUNT(jec_projprod_id)  AS num FROM jec_projprod WHERE jec_project_id='".$project_id."' AND isactive='Y'")->result_array();
			$final=array(
					'j'=>$j_data[0]['num'],
					't'=>$t_data[0]['num'],
					'p'=>$p_data[0]['num']
				);//
		else:
			switch($type):
				case 'j':
					$j_data=$this->ci->db->query("SELECT COUNT(jec_projjob_id) AS num FROM jec_projjob WHERE jec_project_id='".$project_id."' AND isactive='Y'")->result_array();
					$final=$j_data[0]['num'];
					break;
				case 't':
					$t_data=$this->ci->db->query("SELECT COUNT(jec_projtask_id) AS num FROM jec_projtask WHERE jec_project_id='".$project_id."' AND isactive='Y'")->result_array();
					$final=$t_data[0]['num'];
					break;
				case 'p':
					$p_data=$this->ci->db->query("SELECT COUNT(jec_projprod_id)  AS num FROM jec_projprod WHERE jec_project_id='".$project_id."' AND isactive='Y'")->result_array();
					$final=$p_data[0]['num'];
					break;
			endswitch;
		endif;
		
		
		return $final;
	}
	function get_project_series()
	{
		$def_num=(date('Y')-1911).date('md');
		$min=(int)$def_num.'000';
		$max=(int)$def_num.'999';
		$sql="SELECT MAX(value)+1 AS max_value FROM ".$this->mm_tb." WHERE value>'".$min."' AND value<'".$max."' AND isactive='Y'";
		
		$result=$this->ci->db->query($sql)->result_array();
		
		return (int)$result[0]['max_value']>0?$result[0]['max_value']:$def_num.'001';
	}
	
	function delete_project($project_id=0)
	{	global $_G;
		$_G['err_msg']='';
		if((int)$project_id>0):
			//check
			$projt_set=$this->ci->CM->Init_TB_Set('mm_projtask_set');//刪工作
			$check=$this->ci->db->query("SELECT jec_projtask_id FROM ".$projt_set['mm_tb']." WHERE jec_project_id='".$project_id."' AND (jec_user_id>'0' OR jec_group_id>'0') AND isactive='Y' limit 0,1")->num_rows();
			//$this->ci->CM->JS_TMsg($check);
			//$_G['err_msg']=$check;
			if($check==0):
				$projf_set=$this->ci->CM->Init_TB_Set('mm_projfile_set');//刪檔
				$file_list=$this->ci->db->where('jec_project_id',$project_id)->where('isactive','Y')->get($projf_set['mm_tb'])->result_array();
				$save_folder='uploads/project_file/';
				foreach($file_list as $value):
					@unlink($save_folder.$this->ci->CM->ReadFileName('read',$value['filename']));
				endforeach;
				$this->ci->db->where('jec_project_id',$project_id)->where('isactive','Y')->update($projf_set['mm_tb'],array('isactive'=>'N','updated'=>date('Y-m-d H:i:s'),'updatedby'=>$this->ci->ad_id));
			//明細需一支一支刪…
			
				$projp_set=$this->ci->CM->Init_TB_Set('mm_projprod_set');//刪工作明細
				$this->ci->db->where('jec_project_id',$project_id)->update($projp_set['mm_tb'],array('isactive'=>'N','updated'=>date('Y-m-d H:i:s'),'updatedby'=>$this->ci->ad_id));	
			/*
			$prod_list=$this->ci->where('jec_project_id',$project_id)->where('isactive','Y')->get($projp_set['mm_tb'])->result_array();
			foreach($prod_list as $value):
				$this->ci->$projp_set['mm_set']->delete_projprod($value);
			endforeach;
			*/
			//$this->ci->db->where('jec_project_id',$project_id)->update($projp_set['mm_tb'],array('isactive'=>'N'));
			
			
				$this->ci->db->where('jec_project_id',$project_id)->update($projt_set['mm_tb'],array('isactive'=>'N','updated'=>date('Y-m-d H:i:s'),'updatedby'=>$this->ci->ad_id));	
				$projj_set=$this->ci->CM->Init_TB_Set('mm_projjob_set');//刪任務
				$this->ci->db->where('jec_project_id',$project_id)->update($projj_set['mm_tb'],array('isactive'=>'N','updated'=>date('Y-m-d H:i:s'),'updatedby'=>$this->ci->ad_id));	
			
			//刪專案
				$this->ci->db->where('jec_project_id',$project_id)->update($this->mm_tb,array('isactive'=>'N','updated'=>date('Y-m-d H:i:s'),'updatedby'=>$this->ci->ad_id));
			else:	
				$_G['err_msg']='此專案已有工作分派出去，無法刪除。';		
			endif;
			
		
		endif;	//
	}
	
	function get_project_row($project_id=0)
	{
		$result=$this->ci->db->where($this->mm_kid,$project_id)->get($this->mm_tb)->result_array();
		return count($result)>0?$result[0]:0;
	}
	
	function projstatus_ld_adjust($now_status=0,$ld=array())
	{	$final=array();
		$allow_info=array(
				2=>array(2,4,5,6),
				4=>array(2,4),
				5=>array(2,5)
			);
		if(isset($allow_info[$now_status])):
			foreach($ld as $value):
				if(in_array($value['id'],$allow_info[$now_status])) array_push($final,$value);
			endforeach;
		else:
			$final=$ld;
		endif;
		return $final;
	}
	
	function exe_right_check($type='',$data=array())
	{	//執行的權限設定--不過方向大致已定就是了。= =!ok
		 global $_G;
		 $final=array();
		 switch($type){
		 	case 'change_projstatus':
				$_G['err_msg']='';
				$final='Y';
				switch($data['projstatus']):
					case 6:
						$test=$this->ci->db->query("SELECT jec_projtask_id FROM jec_projtask WHERE jec_project_id='".$data['jec_project_id']."' AND projtasktype IN(1,2,3,5) AND isactive='Y' limit 0,1")->num_rows();
						if($test>0):
							$final='N';
							$_G['err_msg']='尚有工作未完成，無法結案。';
						endif; 
					break;
				endswitch;
				//
				break;
			case 'check_adjust_right':
				$asi_list=$this->ci->db->where('jec_dept_id',$data['jec_dept_id'])->where('isactive','Y')->where('jec_title_id',14)->where('jec_user_id',$this->ci->ad_id)->get('jec_user')->result_array();
				if($data['createdby']==$this->ci->ad_id||$data['jec_user_id']==$this->ci->ad_id||$data['jec_usersales_id']==$this->ci->ad_id||$this->ci->isadmin=='Y'||count($asi_list)>0):
					$final=true;
				else:
					$final=false;
				endif;
				break;
			case 'test_work':
				//
				break;
		 }
		 return $final;
	}
	
    function after_exe_ac($ac='',$data=array())
    {   //
 		//
    }         
}