<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Mm_calendar_set
{
    var $mm_tb='jec_calendar';
	var $mm_tablename='JEC_Calendar';
	var $mm_glt='2';
    var $mm_td=array();
    var $mm_kid='jec_calendar_id';
    var $mm_deltype='isactive';
    var $mm_actb='jec_calendar';
	var $noticetype_info=array(
				'rp_finish'=>4,
				'rp_adjust'=>5,
				'rp_transfer'=>6,
				'rp_impossible'=>7,
				'rp_pause'=>8,
				'rp_recover'=>9,
				'rp_progress'=>11,
				'cp_adjust'=>15,
				'cp_adjust_N'=>25,
				'cp_impossible_A'=>15,
				'cp_impossible_T'=>16,
				'cp_impossible_C'=>17,
				'cp_pause_Y'=>18,
				'cp_pause_N'=>28,
				'cp_recover_Y'=>19,
				'cp_recover_N'=>29,
				'cp_transfer_Y'=>16,
				'cp_transfer_N'=>26,
				'cp_finish_Y'=>14,
				'cp_finish_N'=>24,
				'delay'=>2 
			);	
	var $noticetype_pdb=array(
			1=>'待辦工作通知',
			2=>'逾期工作通知',
			3=>'系統警示通知',
			4=>'工作完成待確認',
			5=>'日期變更待確認',
			6=>'工作移轉待確認',
			7=>'無法完成待處理',
			8=>'工作暫停待確認',
			9=>'工作回復待確認',
			11=>'工作進度回報',
			14=>'工作完成已確認',
			15=>'日期變更已確認',
			16=>'工作移轉已確認',
			17=>'工作廢止已確認',
			18=>'工作暫停已確認',
			19=>'工作回復已確認',
			24=>'工作完成退回',
			25=>'日期變更退回',
			26=>'工作移轉退回',
			27=>'無法完成的退回',
			28=>'工作暫停退回',
			29=>'工作回復退回',
			'AA'=>'手動新增行事曆待辦工作'
		);	
	var $btn_allow=array(
			4,5,6,7,8,9
		);	
	var $rp_btn=array(
			1,2,11,14,15,16,17,18,19,24,25,26,27,28,29
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
                'description'=>array(
                        'call_name'=>'工作內容',
                        'type'=>'text',
						'style'=>'width:75%;'
                    ),
				'startdate'=>array(
						'call_name'=>'開始日期',
						'type'=>'text',
						'readonly'=>'Y'
					),
				'enddate'=>array(
						'call_name'=>'結束日期',
						'type'=>'text',
						'readonly'=>'Y'
					),
				'daynotice'=>array(
						'call_name'=>'前置通知天數',
						'type'=>'select',
						'ld'=>$this->ci->CM->FormatData(array('key'=>'id','value'=>'name','sn'=>0,'en'=>7),"page_db","num"),
						'ld_key'=>'id',
						'ld_value'=>'name'
					),
				'name'=>array(
						'call_name'=>'日曆',
						'type'=>'text'
					),
				'isopen'=>array(
						'call_name'=>'是否公開',
						'type'=>'select',
						'ld'=>array(array('id'=>'N','name'=>'不公開'),array('id'=>'Y','name'=>'選擇公開'),array('id'=>'Y','name'=>'全公司')),
						'ld_key'=>'id',
						'ld_value'=>'name'
					)
					//
            );
        return $final;
    }
	
	function get_noticetype($index='')
	{
		return isset($this->noticetype_info[$index])?$this->noticetype_info[$index]:0;
	}
	
	
	function calendar_action($data=array(),$type=0)
	{	//ac
		//$this->ci->CM->JS_TMsg($data['jec_user_id']);
		$final=0;
		//check_exist
		if($type===0):
			$check=$this->ci->db->where('jec_projtask_id',$data['jec_projtask_id'])->where('jec_user_id',$data['jec_user_id'])->where('noticefrom',$data['noticefrom'])->where('isactive','Y')->get($this->mm_tb)->result_array();
			$this->ci->CM->JS_TMsg(count($check));
		else:
			$check=array();
		endif;
		
		//@@
		if(count($check)==0):
			$upd=array_merge($data,$this->ci->CM->Base_UP_UPD());
			$this->ci->db->insert($this->mm_tb,$upd);
			$final=mysql_insert_id();
		else:
			$final=$check[0]['jec_calendar_id'];
			$this->ci->db->where('jec_calendar_id',$final)->update($this->mm_tb,$data);
		endif;
		
		//$this->ci->db->insert($this->mm_tb,$upd);
		
		return $final;
	}
	
	function delete_calendar($data=array())
	{
		$this->ci->CM->JS_TMsg($data['jec_projtask_id'].'-'.$data['jec_user_id'].'-'.$data['noticefrom']);
		$this->ci->db->where('jec_projtask_id',$data['jec_projtask_id'])->where('jec_user_id',$data['jec_user_id'])->where('noticefrom',$data['noticefrom'])->where('isactive','Y')->update($this->mm_tb,array('isactive'=>'N'));
	}
	
	function get_cal_by_projtask($projtask_id=0)
	{
		$final=$this->ci->db->where('jec_projtask_id',$projtask_id)->where('isactive','Y')->where('noticefrom',1)->get($this->mm_tb)->result_array();
		return $final;
	}

	
    function after_exe_ac($ac='',$data=array())
    {   //
 		//
    }         
}