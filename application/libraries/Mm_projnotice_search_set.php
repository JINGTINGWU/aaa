<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Mm_projnotice_search_set
{
    var $mm_tb='jec_projnotice_search_view';
	var $mm_tablename='JEC_Projnotice_search_view';
	var $mm_glt='2';
    var $mm_td=array();
    var $mm_kid='jec_projnotice_id';
    var $mm_deltype='isactive';
    var $mm_actb='jec_projnotice';
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
				'cp_impossible_N'=>27,
				'cp_pause_Y'=>18,
				'cp_pause_N'=>28,
				'cp_transfer_Y'=>16,
				'cp_transfer_N'=>26,
				'cp_finish_Y'=>14,
				'cp_finish_N'=>24,
				'rp_transfer_superuser'=>10,
                'cp_transfer_super_Y'=>20,
                'cp_transfer_super_N'=>30,
				'rp_adjust_transfer'=>31,
				'rp_addsign'=>32,
				'cp_adjust_transfer_Y'=>41,
				'cp_addsign_Y'=>42,
                'cp_adjust_transfer_N'=>51,
				'delay'=>2 
			);	
	var $subject_info=array(
				'rp_finish'=>'工作完成回報',
				'rp_adjust'=>'日期調整申請',
				'rp_transfer'=>'工作移轉申請',				
				'rp_impossible'=>'工作無法完成回報',
				'rp_pause'=>'工作暫停申請',
				'rp_recover'=>'工作回復申請',
				'rp_progress'=>'工作進度回報',
				'cp_adjust'=>'日期變更已確認',
				'cp_adjust_N'=>'日期變更退回',
				'cp_impossible_A'=>'日期變更已確認',
				'cp_impossible_T'=>'工作移轉已確認',
				'cp_impossible_C'=>'工作廢止已確認',
				'cp_impossible_N'=>'工作無法完成退回',
				'cp_pause_Y'=>'工作暫停已確認',
				'cp_pause_N'=>'工作暫停退回',
				'cp_transfer_Y'=>'工作移轉已確認',
				'cp_transfer_N'=>'工作移轉退回',
				'cp_finish_Y'=>'工作完成已確認',
				'cp_finish_N'=>'工作完成退回',
				'rp_transfer_superuser'=>'督導人移轉申請',
				'cp_transfer_super_Y'=>'督導人移轉已確認',
				'cp_transfer_super_N'=>'督導人移轉退回',
				'rp_adjust_transfer'=>'展期暨移轉申請',
				'cp_adjust_transfer_Y'=>'展期暨移轉已確認',
				'cp_adjust_transfer_N'=>'展期暨移轉退回',
				'rp_addsign'=>'向前加簽申請',
				'cp_addsign_Y'=>'向前加簽已回簽',
				'delay'=>'逾期工作通知',
				'1'=>'待辦工作通知',
				12=>'開始前工作檢核通知',
				13=>'完成前工作檢核通知'
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
			12=>'開始前工作檢核通知',
			13=>'完成前工作檢核通知',
			14=>'工作完成已確認',
			15=>'日期變更已確認',
			16=>'工作移轉已確認',
			17=>'工作廢止已確認',
			18=>'工作暫停已確認',
			19=>'工作回復已確認',
			24=>'工作完成退回',
			25=>'日期變更退回',
			26=>'工作移轉退回',
			27=>'無法完成退回',
			28=>'工作暫停退回',
			29=>'工作回復退回',
			10=>'督導人移轉待確認',
			20=>'督導人移轉已確認',
			30=>'督導人移轉退回',
			31=>'展期暨移轉待確認',
			41=>'展期暨移轉已確認',
			51=>'展期暨移轉退回',
			'AA'=>'手動新增行事曆待辦工作',
			'32'=>'向前加簽待回簽',
			'42'=>'向前加簽已回簽'
		);
	var $btn_allow=array(
			4,5,6,7,8,9,10,31,32
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
                'jec_job_id'=>array(
                        'call_name'=>'任務id',
                        'type'=>'select',
                        'ld'=>'mm_job_set@def',
						'ld_key'=>'jec_job_id',
						'ld_value'=>'name' 
                    ),
                'description'=>array(
                        'call_name'=>'備註',
                        'type'=>'text'
                    )
            );
        return $final;
    }
	function get_noticetype($index='')
	{
		return isset($this->noticetype_info[$index])?$this->noticetype_info[$index]:0;
	}
	function get_email_subject($index='')
	{
		return isset($this->subject_info[$index])?'履約管制系統-'.$this->subject_info[$index]:'';
	}	
	function get_projnotice_row($projnotice_id=0)
	{
		$result=$this->ci->db->where($this->mm_kid,$projnotice_id)->get($this->mm_tb)->result_array();
		return count($result)>0?$result[0]:0;
	}
	
	function get_mail_content($mail_pdb=array(),$noticetype=0,$data=array())
	{	$final='';
		$noticetype=$this->ci->CM->FormatData($noticetype,'number',2);
		
		if(isset($mail_pdb[$noticetype])):
			$final=$mail_pdb[$noticetype];
			$replace=$this->mail_replace_array($noticetype);
			foreach($replace as $st=>$sv):
				$final=str_replace($st,$data[$sv],$final);
			endforeach;
		endif;
		return $final;
	}
	
	function mail_replace_array($noticetype=0)
	{	$tag='$';
		$noticetype=(int)$noticetype;
		$info=array(
				1=>array(
						$tag.'專案名稱'.$tag=>'proj_name',
						$tag.'工作名稱'.$tag=>'task_name',
						$tag.'承辦人'.$tag=>'sales_name',
						$tag.'日期區間'.$tag=>'date_period'
					),
				2=>array(
						$tag.'專案名稱'.$tag=>'proj_name',
						$tag.'工作名稱'.$tag=>'task_name',
						$tag.'承辦人'.$tag=>'sales_name',
						$tag.'逾期天數'.$tag=>'delay_days'			
					),
				3=>array(
						$tag.'專案名稱'.$tag=>'proj_name',
						$tag.'工作名稱'.$tag=>'task_name',
						$tag.'承辦人'.$tag=>'sales_name',
						$tag.'確認'.$tag=>'confirm_name'
					),
				4=>array(
						$tag.'專案名稱'.$tag=>'proj_name',
						$tag.'工作名稱'.$tag=>'task_name',
						$tag.'承辦人'.$tag=>'sales_name'
					),
				5=>array(
						$tag.'專案名稱'.$tag=>'proj_name',
						$tag.'工作名稱'.$tag=>'task_name',
						$tag.'承辦人'.$tag=>'sales_name',
						$tag.'新日期區間'.$tag=>'new_date_period'
					),
				6=>array(
						$tag.'專案名稱'.$tag=>'proj_name',
						$tag.'工作名稱'.$tag=>'task_name',
						$tag.'承辦人'.$tag=>'sales_name',
						$tag.'新承辦人'.$tag=>'new_sales_name'
					),
				7=>array(
						$tag.'專案名稱'.$tag=>'proj_name',
						$tag.'工作名稱'.$tag=>'task_name',
						$tag.'承辦人'.$tag=>'sales_name'
					),
				8=>array(
						$tag.'專案名稱'.$tag=>'proj_name',
						$tag.'工作名稱'.$tag=>'task_name',
						$tag.'承辦人'.$tag=>'sales_name'
					),
				9=>array(
						$tag.'專案名稱'.$tag=>'proj_name',
						$tag.'工作名稱'.$tag=>'task_name',
						$tag.'承辦人'.$tag=>'sales_name'
					),
				10=>array(
						$tag.'專案名稱'.$tag=>'proj_name',
						$tag.'工作名稱'.$tag=>'task_name',
						$tag.'督導人'.$tag=>'sales_name',
						$tag.'新督導人'.$tag=>'new_sales_name'
					),
				11=>array(
						$tag.'專案名稱'.$tag=>'proj_name',
						$tag.'工作名稱'.$tag=>'task_name',
						$tag.'承辦人'.$tag=>'sales_name',
						$tag.'備註說明'.$tag=>'description'
					),
				12=>array(
						$tag.'專案名稱'.$tag=>'proj_name',
						$tag.'工作名稱'.$tag=>'task_name',
						$tag.'承辦人員'.$tag=>'sales_name',
						$tag.'檢核表開始前的工作名稱'.$tag=>'check_name',
						$tag.'開始日期'.$tag=>'startdate'
					),
				13=>array(
						$tag.'專案名稱'.$tag=>'proj_name',
						$tag.'工作名稱'.$tag=>'task_name',
						$tag.'承辦人員'.$tag=>'sales_name',
						$tag.'檢核表完成前的工作名稱'.$tag=>'check_name',
						$tag.'完成日期'.$tag=>'finishdate'
					),
				14=>array(
						$tag.'專案名稱'.$tag=>'proj_name',
						$tag.'工作名稱'.$tag=>'task_name',
						$tag.'承辦人'.$tag=>'sales_name'
					),
				15=>array(
						$tag.'專案名稱'.$tag=>'proj_name',
						$tag.'工作名稱'.$tag=>'task_name',
						$tag.'承辦人'.$tag=>'sales_name',
						$tag.'新日期區間'.$tag=>'new_date_period'
					),
				16=>array(
						$tag.'專案名稱'.$tag=>'proj_name',
						$tag.'工作名稱'.$tag=>'task_name',
						$tag.'承辦人'.$tag=>'sales_name',
						$tag.'新承辦人'.$tag=>'new_sales_name'
					),
				17=>array(
						$tag.'專案名稱'.$tag=>'proj_name',
						$tag.'工作名稱'.$tag=>'task_name',
						$tag.'承辦人'.$tag=>'sales_name'
					),
				18=>array(
						$tag.'專案名稱'.$tag=>'proj_name',
						$tag.'工作名稱'.$tag=>'task_name',
						$tag.'承辦人'.$tag=>'sales_name'
					),
				19=>array(
						$tag.'專案名稱'.$tag=>'proj_name',
						$tag.'工作名稱'.$tag=>'task_name',
						$tag.'承辦人'.$tag=>'sales_name'
					),
				20=>array(
						$tag.'專案名稱'.$tag=>'proj_name',
						$tag.'工作名稱'.$tag=>'task_name',
						$tag.'督導人'.$tag=>'sales_name',
						$tag.'新督導人'.$tag=>'new_sales_name'
					),
				24=>array(
						$tag.'專案名稱'.$tag=>'proj_name',
						$tag.'工作名稱'.$tag=>'task_name',
						$tag.'承辦人'.$tag=>'sales_name'
					),
				25=>array(
						$tag.'專案名稱'.$tag=>'proj_name',
						$tag.'工作名稱'.$tag=>'task_name',
						$tag.'承辦人'.$tag=>'sales_name',
						$tag.'新日期區間'.$tag=>'new_date_period'
					),
				26=>array(
						$tag.'專案名稱'.$tag=>'proj_name',
						$tag.'工作名稱'.$tag=>'task_name',
						$tag.'承辦人'.$tag=>'sales_name',
						$tag.'新承辦人'.$tag=>'new_sales_name'
					),
				27=>array(
						$tag.'專案名稱'.$tag=>'proj_name',
						$tag.'工作名稱'.$tag=>'task_name',
						$tag.'承辦人'.$tag=>'sales_name'
					),
				28=>array(
						$tag.'專案名稱'.$tag=>'proj_name',
						$tag.'工作名稱'.$tag=>'task_name',
						$tag.'承辦人'.$tag=>'sales_name'
					),
				29=>array(
						$tag.'專案名稱'.$tag=>'proj_name',
						$tag.'工作名稱'.$tag=>'task_name',
						$tag.'承辦人'.$tag=>'sales_name'
					),
				30=>array(
						$tag.'專案名稱'.$tag=>'proj_name',
						$tag.'工作名稱'.$tag=>'task_name',
						$tag.'督導人'.$tag=>'sales_name',
						$tag.'新督導人'.$tag=>'new_sales_name'
					),
				31=>array(
						$tag.'專案名稱'.$tag=>'proj_name',
						$tag.'工作名稱'.$tag=>'task_name',
						$tag.'承辦人'.$tag=>'sales_name',
						$tag.'新日期區間'.$tag=>'new_date_period',
						$tag.'新承辦人'.$tag=>'new_sales_name'
					),
				41=>array(
						$tag.'專案名稱'.$tag=>'proj_name',
						$tag.'工作名稱'.$tag=>'task_name',
						$tag.'承辦人'.$tag=>'sales_name',
						$tag.'新日期區間'.$tag=>'new_date_period',
						$tag.'新承辦人'.$tag=>'new_sales_name'
					),
				51=>array(
						$tag.'專案名稱'.$tag=>'proj_name',
						$tag.'工作名稱'.$tag=>'task_name',
						$tag.'承辦人'.$tag=>'sales_name',
						$tag.'新日期區間'.$tag=>'new_date_period',
						$tag.'新承辦人'.$tag=>'new_sales_name'
					)
			);
		return isset($info[$noticetype])?$info[$noticetype]:array();
	}
	
	function notice_action($data=array())
	{	//ac
		$final=0;
		$upd=array_merge($data,$this->ci->CM->Base_New_UPD());
		$this->ci->db->insert($this->mm_tb,$upd);
		$final=mysql_insert_id();
		return $final;
	}
	
	function get_noticetype_img()
	{	$final=array();
		$data=$this->ci->db->where('isactive','Y')->get('jec_setup')->result_array();
		
		foreach($data as $value):
			$st=(int)$value['noticetype'];
			$final[$st]=$value['icon'];
		endforeach;
		return $final;
	}
	function exe_right_check($type='def',$data=array())
	{	
		$final=false;
		 switch($type){
		 	case 'check_confirm':
				if($data['jec_user_id']==$this->ci->ad_id):
					$final=true;
					//check projtask_status...
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