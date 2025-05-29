<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Mm_projecttemptask_set
{
    var $mm_tb='jec_projecttemptask';
	var $mm_tablename='JEC_Projecttemptask';
	var $mm_glt='2';
    var $mm_td=array();
    var $mm_kid='jec_projecttemptask_id';
    var $mm_deltype='isactive';
    var $mm_actb='jec_projecttemptask';
			
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
				'join_task'=>array(
						'join'=>array('type'=>'left','jtb'=>'jec_task','jkey'=>'jec_task_id','mkey'=>'jec_task_id','tb'=>$this->mm_tb),
                        'con'=>array($this->mm_tb.'.isactive'=>'Y'),
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
                'projstatus'=>array(
                        'call_name'=>'專案狀態',
                        'type'=>'select',
                        'ld'=>$this->ci->$_G['L_CS']->common_use_ld('projstatus'),
                        'ld_key'=>'id',
                        'ld_value'=>'name'              
                    )
            );
        return $final;
    }    
	
	function delete_project($project_id=0)
	{
		if((int)$project_id>0):
			$projf_set=$this->ci->CM->Init_TB_Set('mm_projfile_set');//刪檔
			$this->ci->db->where('jec_project_id',$project_id)->update($projf_set['mm_tb'],array('isactive'=>'N'));
			$projp_set=$this->ci->CM->Init_TB_Set('mm_projprod_set');//刪工作明細
			$this->ci->db->where('jec_project_id',$project_id)->update($projp_set['mm_tb'],array('isactive'=>'N'));
			$projt_set=$this->ci->CM->Init_TB_Set('mm_projtask_set');//刪工作
			$this->ci->db->where('jec_project_id',$project_id)->update($projt_set['mm_tb'],array('isactive'=>'N'));	
			$projj_set=$this->ci->CM->Init_TB_Set('mm_projjob_set');//刪任務
			$this->ci->db->where('jec_project_id',$project_id)->update($projj_set['mm_tb'],array('isactive'=>'N'));	
			
			//刪專案
			$this->ci->db->where('jec_project_id',$project_id)->update($this->mm_tb,array('isactive'=>'N'));				
		endif;	//
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