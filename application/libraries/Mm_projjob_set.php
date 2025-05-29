<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Mm_projjob_set
{
    var $mm_tb='jec_projjob';
	var $mm_tablename='JEC_Projjob';
	var $mm_glt='2';
    var $mm_td=array();
    var $mm_kid='jec_projjob_id';
    var $mm_deltype='isactive';
    var $mm_actb='jec_projjob';
			
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
		/*
                'jec_job_id'=>array(
                        'call_name'=>'任務id',
                        'type'=>'select',
                        'ld'=>'mm_job_set@def',
						'ld_key'=>'jec_job_id',
						'ld_value'=>'name' 
                    ),*/
                'jec_job_id_title'=>array(
                        'call_name'=>'任務名稱-顯示',
                        'type'=>'text',
						'onblur'=>'PL_CloseList();',
						'onclick'=>"PL_ChangePL('job');",
						'onfocus'=>"PL_ChangePL('job');",
						'style'=>"width:250px;"
                    ),
                'jec_job_id'=>array(
                        'call_name'=>'任務名稱',
                        'type'=>'hidden'
                    ),
                'description'=>array(
                        'call_name'=>'備註',
                        'type'=>'text',
						'style'=>'width:350px'
                    ),
                'jobname'=>array(
                        'call_name'=>'任務名稱',
                        'type'=>'text',						
						'style'=>'width:100px;'//100
                    ),
				'jobjobtype'=>array(
						'call_name'=>'',
						'ld'=>array(array('id'=>1,'name'=>'逐項完成'),array('id'=>2,'name'=>'一起完成')),
						'ld_key'=>'id',
						'ld_value'=>'name'
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
	
	function delete_projjob($projjob=0)
	{
		if(!is_array($projjob)):
			$projjob=$this->get_projjob_row($projjob);
		endif;
		if(is_array($projjob)):
			$projf_set=$this->ci->CM->Init_TB_Set('mm_projfile_set');//刪檔
			
			$file_list=$this->ci->db->where('jec_projjob_id',$projjob['jec_projjob_id'])->where('jec_project_id',$projjob['jec_project_id'])->get($projf_set['mm_tb'])->result_array();
			$save_folder='uploads/project_file/';
			foreach($file_list as $value):
				@unlink($save_folder.$this->ci->CM->ReadFileName('read',$value['filename']));
			endforeach;
			$this->ci->db->where('jec_projjob_id',$projjob['jec_projjob_id'])->where('jec_project_id',$projjob['jec_project_id'])->update($projf_set['mm_tb'],array('isactive'=>'N','updated'=>date('Y-m-d H:i:s'),'updatedby'=>$this->ci->ad_id));
			//file的為累加
			//find_task
			$projt_set=$this->ci->CM->Init_TB_Set('mm_projtask_set');
			$projp_set=$this->ci->CM->Init_TB_Set('mm_projprod_set');
			$task_list=$this->ci->db->where('jec_projjob_id',$projjob['jec_projjob_id'])->where('isactive','Y')->get($projt_set['mm_tb'])->result_array();
			foreach($task_list as $v1):
				//job_list....
				$prod_list=$this->ci->db->where('jec_projtask_id',$v1['jec_projtask_id'])->where('isactive','Y')->get($projp_set['mm_tb'])->result_array();
				foreach($prod_list as $v2):
					$this->ci->$projp_set['mm_set']->delete_projprod($v2);
				endforeach;
				//$this->ci->db->where('jec_projtask_id',$v1['jec_projtask_id'])->where('isactive','Y')->update($projp_set['mm_tb'],array('isactive'=>'N'));
			endforeach;
			
			$this->ci->db->where('jec_projjob_id',$projjob['jec_projjob_id'])->where('isactive','Y')->update($projt_set['mm_tb'],array('isactive'=>'N','updated'=>date('Y-m-d H:i:s'),'updatedby'=>$this->ci->ad_id));
			
			$this->ci->db->where($this->mm_kid,$projjob[$this->mm_kid])->update($this->mm_tb,array('isactive'=>'N','updated'=>date('Y-m-d H:i:s'),'updatedby'=>$this->ci->ad_id));	
		endif;
	}
	
	function get_projjob_row($jec_projjob_id=0)
	{
		$result=$this->ci->db->where($this->mm_kid,$jec_projjob_id)->get($this->mm_tb)->result_array();
		return count($result)>0?$result[0]:0;
	}
	
	function seqno_action($type='',$data=array())
	{
		switch($type):
			case 'move_up':
				//find_pre
				$test=$this->ci->db->where('jec_project_id',$data['jec_project_id'])->where('isactive','Y')->where('seqno <',$data['seqno'])->order_by('seqno','DESC')->get($this->mm_tb)->result_array();
				if(count($test)>0):
					$this->ci->db->where($this->mm_kid,$data[$this->mm_kid])->update($this->mm_tb,array('seqno'=>$test[0]['seqno']));
					$this->ci->db->where($this->mm_kid,$test[0][$this->mm_kid])->update($this->mm_tb,array('seqno'=>$data['seqno']));
				endif;
				break;
			case 'move_down':
				$test=$this->ci->db->where('jec_project_id',$data['jec_project_id'])->where('isactive','Y')->where('seqno >',$data['seqno'])->order_by('seqno','ASC')->get($this->mm_tb)->result_array();
				if(count($test)>0):
					$this->ci->db->where($this->mm_kid,$data[$this->mm_kid])->update($this->mm_tb,array('seqno'=>$test[0]['seqno']));
					$this->ci->db->where($this->mm_kid,$test[0][$this->mm_kid])->update($this->mm_tb,array('seqno'=>$data['seqno']));
				endif;
				break;
			case 'reorder':
				$order_list=$this->ci->db->where('jec_project_id',$data['jec_project_id'])->where('isactive','Y')->order_by('seqno','ASC')->get($this->mm_tb)->result_array();
				foreach($order_list as $no=>$value):
					$this->ci->db->where($this->mm_kid,$value[$this->mm_kid])->update($this->mm_tb,array('seqno'=>($no+1)));
				endforeach;
				break;
		endswitch;
		
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

    }         
}