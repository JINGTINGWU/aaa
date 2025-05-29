<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Mm_project_search_set
{
    var $mm_tb='jec_project_search_view';
	var $mm_tablename='JEC_Project';
	var $mm_glt='2';
    var $mm_td=array();
    var $mm_kid='jec_project_id';
    var $mm_deltype='isactive';
    var $mm_actb='jec_project_search_view';
			
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
				'cost'=>array(
						'join'=>array('type'=>'left','jtb'=>'jec_project_cost_charge_invoice','jkey'=>'jec_project_id','mkey'=>'jec_project_id','tb'=>$this->mm_tb),
						'con'=>array($this->mm_tb.'.isactive'=>'Y'),
						'glt'=>4	
					),	
				'addendum'=>array(
						'join'=>array('type'=>'left','jtb'=>'jec_project_cost_charge_invoice','jkey'=>'jec_project_id','mkey'=>'jec_project_id','tb'=>$this->mm_tb),
						'con'=>array($this->mm_tb.'.isactive'=>'Y'),
						/*'jsql'=>array($this->mm_tb.'.*','jec_project_cost_charge_invoice.*','CASE WHEN jec_project_cost_charge_invoice.sub_estimated_cost IS NULL THEN jec_project_cost_charge_invoice.add_estimated_cost ELSE (jec_project_cost_charge_invoice.add_estimated_cost - jec_project_cost_charge_invoice.sub_estimated_cost) END AS as_estimated_cost'),*/
						'fixselect'=>$this->mm_tb.'.*,jec_project_cost_charge_invoice.*,CASE WHEN jec_project_cost_charge_invoice.sub_estimated_cost IS NULL THEN jec_project_cost_charge_invoice.add_estimated_cost ELSE (jec_project_cost_charge_invoice.add_estimated_cost - jec_project_cost_charge_invoice.sub_estimated_cost) END AS as_estimated_cost',
						'glt'=>4	
					),	
				'invoice'=>array(
						'join'=>array('type'=>'left','jtb'=>'jec_project_invoice','jkey'=>'jec_project_id','mkey'=>'jec_project_id','tb'=>$this->mm_tb),
						'con'=>array($this->mm_tb.'.isactive'=>'Y'),
						'glt'=>4	
					),	
				'invoice_d'=>array(
						'join'=>array('type'=>'right','jtb'=>'jec_projinvoice','jkey'=>'jec_project_id','mkey'=>'jec_project_id','tb'=>$this->mm_tb),
						'con'=>array($this->mm_tb.'.isactive'=>'Y','jec_projinvoice.isactive'=>'Y'),
						'jsql'=>array($this->mm_tb.'.*','SUM(jec_projinvoice.invoiceamount) AS invoice_amount'),
						'glt'=>4	
					),	
				'join_task'=>array(
						'join'=>array('type'=>'left outer','jtb'=>'jec_projtask','jkey'=>'jec_project_id','mkey'=>'jec_project_id','tb'=>$this->mm_tb,'and'=>" AND jec_projtask.isactive='Y'"),
						'con'=>array($this->mm_tb.'.isactive'=>'Y'),
						'jsql'=>array($this->mm_tb.'.*'),
						'group_by'=>array($this->mm_tb.'.jec_project_id'),
						'glt'=>4	
					),	
				'addendum_join_task'=>array(
						'join'=>array('type'=>'left','jtb'=>'jec_project_cost_charge_invoice','jkey'=>'jec_project_id','mkey'=>'jec_project_id','tb'=>$this->mm_tb),
						'join_1'=>array('type'=>'left outer','jtb'=>'jec_projtask','jkey'=>'jec_project_id','mkey'=>'jec_project_id','tb'=>$this->mm_tb,'and'=>" AND jec_projtask.isactive='Y'"),
						'con'=>array($this->mm_tb.'.isactive'=>'Y','jec_projtask.isactive'=>'Y'),
						'fixselect'=>$this->mm_tb.'.*,jec_project_cost_charge_invoice.*,CASE WHEN jec_project_cost_charge_invoice.sub_estimated_cost IS NULL THEN jec_project_cost_charge_invoice.add_estimated_cost ELSE (jec_project_cost_charge_invoice.add_estimated_cost - jec_project_cost_charge_invoice.sub_estimated_cost) END AS as_estimated_cost',
						'group_by'=>array($this->mm_tb.'.jec_project_id'),	
						'glt'=>4	
					),		
				'cost_join_task'=>array(
						'join'=>array('type'=>'left','jtb'=>'jec_project_cost_charge_invoice','jkey'=>'jec_project_id','mkey'=>'jec_project_id','tb'=>$this->mm_tb),
						'join_1'=>array('type'=>'left outer','jtb'=>'jec_projtask','jkey'=>'jec_project_id','mkey'=>'jec_project_id','tb'=>$this->mm_tb,'and'=>" AND jec_projtask.isactive='Y'"),
						'con'=>array($this->mm_tb.'.isactive'=>'Y','jec_projtask.isactive'=>'Y'),
						'group_by'=>array($this->mm_tb.'.jec_project_id'),	
						'glt'=>4	
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
						'ld'=>$this->ci->CM->FormatData(array('key'=>'id','value'=>'name','sn'=>date('Y'),'en'=>(date('Y')+4)),"page_db","num"),
						'ld_key'=>'id',
						'ld_value'=>'name',
						'full_selected'=>'N'
                    ),
                'name'=>array(
                        'call_name'=>'專案名稱',
                        'type'=>'text'
                    ),
                'description'=>array(
                        'call_name'=>'備註說明',
                        'type'=>'text',
						'style'=>'width:360px;'
                    ),/*
                'jec_customer_id'=>array(
                        'call_name'=>'客戶',
                        'type'=>'select',
                        'ld'=>'mm_customer_set@def',
                        'ld_key'=>'jec_customer_id',
                        'ld_value'=>'name'
                    ),*/
                'jec_customer_id_title'=>array(
                        'call_name'=>'客戶-顯示',
                        'type'=>'text',
						'onblur'=>'PL_CloseList();',
						'onclick'=>"PL_ChangePL('cus');",
						'onfocus'=>"PL_ChangePL('cus');",
						'style'=>"width:120px;"
                    ),
                'jec_customer_id'=>array(
                        'call_name'=>'客戶',
                        'type'=>'hidden'
                    ),
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
                'projtype'=>array(
                        'call_name'=>'專案性質',
                        'type'=>'select',
                        'ld'=>$this->ci->$_G['L_CS']->common_use_ld('projtype'),
                        'ld_key'=>'id',
                        'ld_value'=>'name',
						'full_selected'=>'N'              
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
						'maxlength'=>50            
                    ),
                'name2'=>array(
                        'call_name'=>'工程(標的)名稱',
                        'type'=>'text',
						'maxlength'=>50            
                    ),
                'address'=>array(
                        'call_name'=>'覆約地點',
                        'type'=>'text',
						'maxlength'=>100,
						'style'=>'width:360px;'            
                    ),
                'description2'=>array(
                        'call_name'=>'備註說明2',
                        'type'=>'text',
						'maxlength'=>100,
						'style'=>'width:360px;'            
                    ),
                'description3'=>array(
                        'call_name'=>'備註說明3',
                        'type'=>'text',
						'maxlength'=>100,
						'style'=>'width:360px;'            
                    )
            );
        return $final;
    }
	function get_project_cost($project_id=0)
	{
		//Don't bother me.
		$sql="SELECT SUM(price) AS cost FROM jec_projtask WHERE jec_project_id='".$project_id."' AND isactive='Y'";
		$result=$this->ci->db->query($sql)->result_array();
		return (float)$result[0]['cost'];
	}	
	function get_project_invoice($project_id=0)
	{
		//Don't bother me.
		$sql="SELECT SUM(invoiceamount) AS invoice FROM jec_projinvoice WHERE jec_project_id='".$project_id."' AND isactive='Y'";
		$result=$this->ci->db->query($sql)->result_array();
		return (float)$result[0]['invoice'];
	}	
	function get_project_charge($project_id=0)
	{
		//Don't bother me.
		$sql="SELECT SUM(chargefee) AS charge FROM jec_projcharge WHERE jec_project_id='".$project_id."' AND isactive='Y'";
		$result=$this->ci->db->query($sql)->result_array();
		return (float)$result[0]['charge'];
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
	
	function get_project_percentage($project_id=0)
	{	//取得完成百分比--- Update by Johnson 2012/11/19 算式錯誤了
		$sql="SELECT SUM(taskworkweight) AS workweight_ti FROM jec_projtask_search_view WHERE jec_project_id='".$project_id."' AND projtasktype='6' AND isactive='Y'";
		$result=$this->ci->db->query($sql)->result_array();
		$workweight=$result[0]['workweight_ti'];
		//$sql="SELECT COUNT(jec_projtask_id) AS work FROM jec_projtask WHERE jec_project_id='".$project_id."' AND projtasktype!='4' AND isactive='Y'";
		$sql="SELECT SUM(taskworkweight) AS work FROM jec_projtask WHERE jec_project_id='".$project_id."' AND projtasktype!='4' AND isactive='Y'";
		$result=$this->ci->db->query($sql)->result_array();
		$work=$result[0]['work'];
		if($work==0||$workweight==0):
			$final=0;
		else:
			$final=($workweight/$work)*100;
		endif;
		return $final;
	}
	
	function get_percent_css($num=0,$data=array())
	{	//data可參考值
	
	/*
.mm_pg_unfinish{
	background:#FF0000;
	color:#FFFFFF;
}
.mm_pg_normal{
	background:#339900;
	color:#000000;
}
.mm_pg_alert{
	background:#FFFF00;
	color:#000000;
}	
	*/
		if(date('Y-m-d')>substr($data['enddate'],0,10)):
			if ($num>=100):
				$final='style="background:#339900;color:#000000;"';
			else:
				$final='style="background:#FF0000;color:#FFFFFF;"';
			endif;
		else:
			if($num>50):
				$final='style="background:#339900;color:#000000;"';
			else:
				$final='style="background:#FFFF00;color:#000000;"';
			endif;
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
	function get_project_row($project_id=0)
	{
		$result=$this->ci->db->where($this->mm_kid,$project_id)->get($this->mm_tb)->result_array();
		return count($result)>0?$result[0]:0;
	}
	function exe_right_check()
	{	//執行的權限設定--不過方向大致已定就是了。= =!ok
		 //model->test-//資料異動權限
		 //->無權限的就銷掉--拉出來，有相關過濾的設在td_checl--
		 switch($type){
		 	case 'save_work':
				//
				break;
			case 'test_work':
				//
				break;
		 }
		 
	}
	
    function after_exe_ac($ac='',$data=array())
    {   //
 		//
    }         
}