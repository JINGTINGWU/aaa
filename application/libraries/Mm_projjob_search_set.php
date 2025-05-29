<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Mm_projjob_search_set
{
    var $mm_tb='jec_projjob_search_view';
	var $mm_tablename='JEC_Projjob';
	var $mm_glt='2';
    var $mm_td=array();
    var $mm_kid='jec_projjob_id';
    var $mm_deltype='isactive';
    var $mm_actb='jec_projjob_search_view';
			
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
						'join'=>array('type'=>'right outer','jtb'=>'jec_projtask','jkey'=>'jec_projjob_id','mkey'=>'jec_projjob_id','tb'=>$this->mm_tb),
						'con'=>array($this->mm_tb.'.isactive'=>'Y'),
						'jsql'=>array($this->mm_tb.'.*'),
						'group_by'=>array($this->mm_tb.'.jec_projjob_id'),
						'glt'=>4	
					),															
				'def'=>array()
		    );
		
	}
    
    function load_mm_field_check()
    {	global $_G;

        $final=array(
                'jec_job_id_title'=>array(
                        'call_name'=>'任務名稱-顯示',
                        'type'=>'text',
						'onblur'=>'PL_CloseList();',
						'onclick'=>"PL_ChangePL('job');",
						'onfocus'=>"PL_ChangePL('job');",
						'style'=>"width:350px;"
                    ),
                'jec_job_id'=>array(
                        'call_name'=>'任務名稱',
                        'type'=>'hidden'
                    ),/*
                'jec_job_id'=>array(
                        'call_name'=>'任務id',
                        'type'=>'select',
                        'ld'=>'mm_job_set@def', 
						'ld_key'=>'jec_job_id',
						'ld_value'=>'name'  
                    ),*/
                'description'=>array(
                        'call_name'=>'備註',
                        'type'=>'textarea',
						'style'=>'width:350px'
                    ),//
                'jobname'=>array(
                        'call_name'=>'任務名稱',
                        'type'=>'textarea',
						'maxlength'=>300,
						'rows'=>2,											
						'style'=>'width:100px;'//150
                    ),
				'jobjobtype'=>array(
						'call_name'=>'',
						'type'=>'select',
						'ld'=>array(array('id'=>1,'name'=>'逐項完成'),array('id'=>2,'name'=>'一起完成')),
						'ld_key'=>'id',
						'ld_value'=>'name',
						'full_selected'=>'N'
					)//
            );
        return $final;
    }
	
	function get_projjob_series($jec_project_id=0)
	{
		$sql="SELECT MAX(seqno)+1 AS max_value FROM ".$this->mm_tb." WHERE jec_project_id='".$jec_project_id."' AND isactive='Y'";
		
		$result=$this->ci->db->query($sql)->result_array();
		
		return (int)$result[0]['max_value']>0?$result[0]['max_value']:1;
	}
	function get_projjob_row($jec_projjob_id=0)
	{
		$result=$this->ci->db->where($this->mm_kid,$jec_projjob_id)->get($this->mm_tb)->result_array();
		return count($result)>0?$result[0]:0;
	}
	function exe_right_check($type='def',$data=array())
	{	 global $_G;
		 switch($type){
		 	case 'delete_check':
				$_G['err_msg']='';
				$final=true;
				$test=$this->ci->db->where('jec_projjob_id',$data['jec_projjob_id'])->where('isactive','Y')->select('jec_projtask_id')->get('jec_projtask')->num_rows();
				if($test>0):
					$_G['err_msg']='任務中已有工作項目，不可刪除。'; 
				    $final=false;
				endif;
				break;
		 }
		 if($final==false&&isset($data['rd_url'])) $this->ci->CM->JS_Link($data['rd_url']);
		 return $final;
	}
	
    function after_exe_ac($ac='',$data=array())
    {   //
 		//
    }         
}