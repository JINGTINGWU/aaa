<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Mm_projtask_set
{
    var $mm_tb='jec_projtask';
	var $mm_tablename='JEC_Projtask';
	var $mm_glt='2';
    var $mm_td=array();
    var $mm_kid='jec_projtask_id';
    var $mm_deltype='isactive';
    var $mm_actb='jec_projtask';
	var $btn_del_rp_allow=array(
			0
		);	
	var $btn_del_ty_allow=array(
			1,2,4,5
		);		
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
					/*
                'jec_task_id'=>array(
                        'call_name'=>'工作項目',
                        'type'=>'select',
                        'ld'=>'mm_task_set@def',
                        'ld_value'=>'name',
                        'ld_key'=>'jec_task_id',
                        'full_selected'=>'N',
						'style'=>'width:150px;'
                    ),*/
                'jec_task_id_title'=>array(
                        'call_name'=>'工作項目-顯示',
                        'type'=>'text',
						'onblur'=>'PL_CloseList();',
						'onclick'=>"PL_ChangePL('task');",
						'onfocus'=>"PL_ChangePL('task');",
						'style'=>"width:100px;"
                    ),
                'jec_task_id'=>array(
                        'call_name'=>'工作項目',
                        'type'=>'hidden'
                    ),
                'jec_user_id'=>array(
                        'call_name'=>'承辦人',
                        'type'=>'select',
						'ld'=>'mm_user_set@def',
						'ld_key'=>'jec_user_id',
						'ld_value'=>'name',
						'full_selected'=>'N',
						'style'=>'width:70px;'
                    ),
                'jec_usersuper_id'=>array(
                        'call_name'=>'督導人',
                        'type'=>'select',
						'ld'=>'mm_user_set@def',
						'ld_key'=>'jec_user_id',
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
						'style'=>'width:99%;'
                    ),
                'price'=>array(
                        'call_name'=>'預估成本',
                        'type'=>'text',
                        'pii'=>array('nod'),
						'style'=>'width:60px;'
                    ),
                'startdate'=>array(
                        'call_name'=>'起始日期',
                        'type'=>'text',
                        'readonly'=>'Y',//cal
						'style'=>'width:70px'
                    ),
                'enddate'=>array(
                        'call_name'=>'結束日期',
                        'type'=>'text',
                        'readonly'=>'Y',//cal
						'style'=>'width:70px'
                    ),
                'rp_finish'=>array(
                        'call_name'=>'工作完成',
                        'type'=>'text',
						'style'=>'width:80%;'
                    ),
                'rp_finish_time'=>array(
                        'call_name'=>'工作完成',
                        'type'=>'text',
						'readonly'=>'Y',
						'def_value'=>date('Y-m-d H:i:s')
                    ),
                'rp_adjust'=>array(
                        'call_name'=>'調整日期',
                        'type'=>'text',
						'style'=>'width:80%;'
                    ),
                'rp_adtime_startdate'=>array(
                        'call_name'=>'工作完成',
                        'type'=>'text',
						'disabled'=>'Y'
                    ),
                'rp_adtime_enddate'=>array(
                        'call_name'=>'工作完成',
                        'type'=>'text',
						'readonly'=>'Y'
                    ),
                'rp_transfer'=>array(
                        'call_name'=>'工作移轉',
                        'type'=>'text',
						'style'=>'width:80%;'
                    ),
                'rp_transfer_user'=>array(
                        'call_name'=>'工作移轉',
                        'type'=>'select',
						'full_selected'=>'N',
						'ld'=>array(),
						'ld_key'=>'jec_user_id',
						'ld_value'=>'name'
                    ),
                'rp_impossible'=>array(
                        'call_name'=>'無法完成',
                        'type'=>'text',
						'style'=>'width:80%;'
                    ),
                'rp_impossible_time'=>array(
                        'call_name'=>'無法完time成',
                        'type'=>'text',
						'readonly'=>'Y'
                    ),
                'rp_pause'=>array(
                        'call_name'=>'工作暫停',
                        'type'=>'text',
						'style'=>'width:80%;'
                    ),
                'rp_pause_time'=>array(
                        'call_name'=>'暫停時間',
                        'type'=>'text',
						'readonly'=>'Y'
                    ),
                'rp_recover'=>array(
                        'call_name'=>'工作回復',
                        'type'=>'text',
						'style'=>'width:80%;'
                    ),
                'rp_recover_time'=>array(
                        'call_name'=>'回復時間',
                        'type'=>'text',
						'readonly'=>'Y'
                    )
            );
        return $final;
    }
	
	function get_jec_user_list($projt_data=array())
	{	$tu_user=array();
	
		if(!is_array($projt_data)):
			$projt_data=$this->get_projtask_row($projt_data);
		endif;
		if((int)$projt_data['jec_user_id']>0):
			$tu_user=array(array('jec_user_id'=>$projt_data['jec_user_id']));
		else:
			$tu_user=$this->ci->db->where('jec_group_id',$projt_data['jec_group_id'])->where('isactive','Y')->get('jec_usergroup')->result_array();
		endif;
		return $tu_user;
	}
	
	
	function get_jec_user_ld($exclude=0)
	{	//group&user ->考慮存快取
		if(is_array($exclude)):
			if((int)$exclude['jec_group_id']>0):
				$user_list=$this->ci->db->where('isactive','Y')->order_by('name','ASC')->get('jec_user')->result_array();
				$group_list=$this->ci->db->where('isactive','Y')->where('jec_group_id !=',$exclude['jec_group_id'])->order_by('name','ASC')->get('jec_group')->result_array();
			else:
				$user_list=$this->ci->db->where('isactive','Y')->where('jec_user_id !=',$exclude['jec_user_id'])->order_by('name','ASC')->get('jec_user')->result_array();
				$group_list=$this->ci->db->where('isactive','Y')->order_by('name','ASC')->get('jec_group')->result_array();
			endif;
		else:
			$user_list=$this->ci->db->where('isactive','Y')->order_by('name','ASC')->get('jec_user')->result_array();
			$group_list=$this->ci->db->where('isactive','Y')->order_by('name','ASC')->get('jec_group')->result_array();
		endif;
		$user_ld=$this->multi_list($user_list,array('key'=>'jec_user_id','value'=>'name','tag'=>'U-','op_key'=>'jec_user_id','op_value'=>'name'));
		$group_ld=$this->multi_list($group_list,array('key'=>'jec_group_id','value'=>'name','tag'=>'G-','op_key'=>'jec_user_id','op_value'=>'name'));
		$final=array_merge($user_ld,$group_ld);
		return $final;
	}
	
	function multi_list($list=array(),$data=array())
	{	//key/value/tag  op_key/op_value
		$final=array();
		foreach($list as $value):
			array_push($final,array($data['op_key']=>$data['tag'].$value[$data['key']],$data['op_value']=>$value[$data['value']]));
		endforeach;
		return $final;
	}
	
	function delete_projtask($projtask=0)//check
	{	global $_G;
		if(!is_array($projtask)):
			$projtask=$this->get_projtask_row($projtask);
		endif;
		//check

		
		
		if(is_array($projtask)):

			$projf_set=$this->ci->CM->Init_TB_Set('mm_projfile_set');//刪檔
			$this->ci->db->where('jec_projtask_id',$projtask['jec_projtask_id'])->where('isactive','Y')->update($projf_set['mm_tb'],array('isactive'=>'N'));
			
			
			$projp_set=$this->ci->CM->Init_TB_Set('mm_projprod_set');//刪工作明細
			$prod_list=$this->ci->db->where('jec_projtask_id',$projtask['jec_projtask_id'])->where('isactive','Y')->get($projp_set['mm_tb'])->result_array();
			foreach($prod_list as $vv)://一筆一筆=
				$this->ci->$projp_set['mm_set']->delete_projprod($vv);
			endforeach;
			//$this->ci->db->where('jec_projtask_id',$projtask['jec_projtask_id'])->where('isactive','Y')->update($projp_set['mm_tb'],array('isactive'=>'N'));			
			
			$this->ci->db->where($this->mm_kid,$projtask[$this->mm_kid])->update($this->mm_tb,array('isactive'=>'N'));	
		endif;		

	}
	
	function get_projtask_row($projtask_id=0)
	{
		$result=$this->ci->db->where($this->mm_kid,$projtask_id)->get($this->mm_tb)->result_array();
		return count($result)>0?$result[0]:0;
	}
	function get_projtask_series($jec_projjob_id=0)
	{
		$sql="SELECT MAX(seqno)+1 AS max_value FROM ".$this->mm_tb." WHERE jec_projjob_id='".$jec_projjob_id."' AND isactive='Y'";
		
		$result=$this->ci->db->query($sql)->result_array();
		
		return (int)$result[0]['max_value']>0?$result[0]['max_value']:1;
	}
	
	function recount_projtask_total($projtask_id=0,$type='U')//D->after_delete/A->add
	{
		$sql="SELECT SUM(price*quantity) AS price_count FROM jec_projprod WHERE jec_projtask_id='".$projtask_id."' AND isactive='Y'";
		$result=$this->ci->db->query($sql)->result_array();
		if($result[0]['price_count']==0):
			//check是否有產品存在
			$test="SELECT jec_projprod_id FROM jec_projprod WHERE jec_projtask_id='".$projtask_id."' AND isactive='Y' limit 0,1";
			$test_result=$this->ci->db->query($test)->result_array();
			if(count($test_result)==0):
				if($type=='D'):
					$this->ci->db->where($this->mm_kid,$projtask_id)->update($this->mm_tb,array('price'=>$result[0]['price_count'],'isprojprod'=>'N'));
				else:
					//update
				endif;
			else:
				$this->ci->db->where($this->mm_kid,$projtask_id)->update($this->mm_tb,array('price'=>$result[0]['price_count'],'isprojprod'=>'N'));
			endif;
		else:
			$this->ci->db->where($this->mm_kid,$projtask_id)->update($this->mm_tb,array('price'=>$result[0]['price_count'],'isprojprod'=>'Y'));
		endif;
	}
	
	function seqno_action($type='',$data=array())
	{
		switch($type):
			case 'move_up':
				//find_pre
				$test=$this->ci->db->where('jec_projjob_id',$data['jec_projjob_id'])->where('isactive','Y')->where('seqno <',$data['seqno'])->order_by('seqno','DESC')->get($this->mm_tb)->result_array();
				if(count($test)>0):
					$this->ci->db->where($this->mm_kid,$data[$this->mm_kid])->update($this->mm_tb,array('seqno'=>$test[0]['seqno']));
					$this->ci->db->where($this->mm_kid,$test[0][$this->mm_kid])->update($this->mm_tb,array('seqno'=>$data['seqno']));
				endif;
				break;
			case 'move_down':
				$test=$this->ci->db->where('jec_projjob_id',$data['jec_projjob_id'])->where('isactive','Y')->where('seqno >',$data['seqno'])->order_by('seqno','ASC')->get($this->mm_tb)->result_array();
				if(count($test)>0):
					$this->ci->db->where($this->mm_kid,$data[$this->mm_kid])->update($this->mm_tb,array('seqno'=>$test[0]['seqno']));
					$this->ci->db->where($this->mm_kid,$test[0][$this->mm_kid])->update($this->mm_tb,array('seqno'=>$data['seqno']));
				endif;
				break;
			case 'reorder':
				$order_list=$this->ci->db->where('jec_projjob_id',$data['jec_projjob_id'])->where('isactive','Y')->order_by('seqno','ASC')->get($this->mm_tb)->result_array();
				foreach($order_list as $no=>$value):
					$this->ci->db->where($this->mm_kid,$value[$this->mm_kid])->update($this->mm_tb,array('seqno'=>($no+1)));
				endforeach;
				break;
		endswitch;
		
	}

	function trans_task($source_user_id=0,$new_user_id=0)//移轉工作
	{
		$task_list=$this->ci->db->where('jec_user_id',$source_user_id)->where('isactive','Y')->get($this->mm_tb)->result_array();
		foreach($task_list as $value)://transfer
			//save_reocrd->send notice 工作移轉已確認???
		endforeach;
		$this->ci->db->where('jec_user_id',$source_user_id)->update($this->mm_tb,array('jec_user_id'=>$new_user_id));
	}


	function exe_right_check($type='def',$data=array())
	{	
		$final=false;
		 switch($type){
		 	case 'check_reply':
				$check_user=isset($data['jec_user_id'])?$data['jec_user_id']:$this->ci->ad_id;
				//$projt_set=$this->ci->CM->Init_TB_Set('mm_projtask_set');
				$projt_data=$this->get_projtask_row($data['jec_projtask_id']);
				//check_status.
				$rp_allow=$this->btn_allow;
				if(in_array($projt_data['projtasktype'],$rp_allow)):
					if($projt_data['jec_user_id']==$check_user):
						$final=true;
					else:
						if($projt_data['jec_group_id']>0):
							$check=$this->ci->db->where('jec_group_id',$projt_data['jec_group_id'])->where('jec_user_id',$check_user)->where('isactive','Y')->get('jec_usergroup')->num_rows();
							if($check>0) $final=true;
						endif;
					endif;
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