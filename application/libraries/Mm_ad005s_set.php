<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Mm_ad005s_set
{
    var $mm_tb='ad005';
	var $mm_tablename='JEC_Projnotice';
	var $mm_glt='2';
    var $mm_td=array();
    var $mm_kid='jec_projnotice_id';
    var $mm_deltype='isactive';
    var $mm_actb='ad005';
	
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
                    ),
                'cp_finish'=>array(
                        'call_name'=>'工作完成',
                        'type'=>'text'
                    ),
                'cp_finish_time'=>array(
                        'call_name'=>'工作完成',
                        'type'=>'text',
						'readonly'=>'Y'
                    ),
                'cp_adtime_startdate'=>array(
                        'call_name'=>'工作完成',
                        'type'=>'text',
						'disabled'=>'Y',
						'style'=>'width:100px'
                    ),
                'cp_adtime_enddate'=>array(
                        'call_name'=>'工作完成',
                        'type'=>'text',
						'readonly'=>'Y',
						'style'=>'width:100px;'
                    ),//讀取要調整的時間-@@
                'cp_transfer_user'=>array(
                        'call_name'=>'工作移轉',
                        'type'=>'select',
						'full_selected'=>'N',
						'ld'=>array(),
						'ld_key'=>'jec_user_id',
						'ld_value'=>'name'
                    ),
                'cp_impossible'=>array(
                        'call_name'=>'無法完成',
                        'type'=>'text'
                    ),
                'cp_iptime_startdate'=>array(
                        'call_name'=>'工作完成',
                        'type'=>'text',
						'disabled'=>'Y',
						'style'=>'width:100px;'
                    ),
                'cp_iptime_enddate'=>array(
                        'call_name'=>'工作完成',
                        'type'=>'text',
						'readonly'=>'Y',
						'style'=>'width:100px;'
                    ),//讀取要調整的時間
                'cp_ip_transfer_user'=>array(
                        'call_name'=>'工作移轉',
                        'type'=>'select',
						'full_selected'=>'N',
						'ld'=>array(),
						'ld_key'=>'jec_user_id',
						'ld_value'=>'name'
                    ),
				'rp_addsign_user'=>array(
                        'call_name'=>'向前加簽',
                        'type'=>'select',
						'full_selected'=>'N',
						'ld'=>array(),
						'ld_key'=>'jec_user_id',
						'ld_value'=>'name'
                    ),
                'cp_impossible_time'=>array(
                        'call_name'=>'無法完time成',
                        'type'=>'text',
						'readonly'=>'Y'
                    ),
                'cp_recover'=>array(
                        'call_name'=>'工作回復',
                        'type'=>'text'
                    ),
                'cp_recover_time'=>array(
                        'call_name'=>'回復時間',
                        'type'=>'text',
						'readonly'=>'Y'
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
		return isset($this->subject_info[$index])?$this->subject_info[$index]:0;
	}	
	function notice_action($data=array())
	{	//ac
		$final=0;
		$upd=array_merge($data,$this->ci->CM->Base_New_UPD());
		$this->ci->db->insert($this->mm_tb,$upd);
		$final=mysql_insert_id();
		return $final;
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
		//spec
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
						$tag.'承辦人'.$tag=>'sales_name'
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
					)
			);
		return isset($info[$noticetype])?$info[$noticetype]:array();
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