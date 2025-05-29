<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Mm_ad005_set
{
    var $mm_tb='ad005';
	var $mm_tablename='ad005';
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
				'target_db'=>array(
                        'call_name'=>'DB',
                        'type'=>'select',
                        'ld'=>array(array('id'=>'A','name'=>'弓詮'),array('id'=>'B','name'=>'銓準')),
						'ld_key'=>'id',
						'ld_value'=>'name',
						'full_selected'=>'N'						
					),
                'ad005053'=>array(
                        'call_name'=>'報支流程',
                        'type'=>'select',
                        'ld'=>array(array('id'=>'A','name'=>'事前請購'),array('id'=>'B','name'=>'事前請購兼採購'),array('id'=>'C','name'=>'事後報支')),
						'ld_key'=>'id',
						'ld_value'=>'name' 
                    ),
                'ad005059'=>array(
                        'call_name'=>'報支類別',
                        'type'=>'select',
                        'ld'=>array(array('id'=>'一般報支','name'=>'一般報支'),array('id'=>'分期報支','name'=>'分期報支')),
						'ld_key'=>'id',
						'ld_value'=>'name' 
                    ),
                'ad005055'=>array(
                        'call_name'=>'專案採購',
                        'type'=>'mradio',
                        'ld'=>array(array('id'=>'是','name'=>'是'),array('id'=>'否','name'=>'否')),
						'ld_key'=>'id',
						'ld_value'=>'name',
						'def_value'=>'否' 
                    ),
                'ad005005'=>array(
                        'call_name'=>'廠商編號',
                        'type'=>'hidden'
                    ),
                'ad005005_title'=>array(
                        'call_name'=>'客戶-顯示',
                        'type'=>'text',
						'onblur'=>'PL_CloseList();',
						'onclick'=>"PL_ChangePL('p_vendor');",
						'onfocus'=>"PL_ChangePL('p_vendor');",
						'style'=>"width:120px;"
                    ),
                'ad005009'=>array(
                        'call_name'=>'需用日期',
                        'type'=>'text',
						'readonly'=>'Y'
                    ),
                'ad005006'=>array(
                        'call_name'=>'採購人員帳號',
                        'type'=>'hidden'
                    ),
                'ad005006_title'=>array(
                        'call_name'=>'客戶-顯示',
                        'type'=>'text',
						'onblur'=>'PL_CloseList();',
						'onclick'=>"PL_ChangePL('p_user');",
						'onfocus'=>"PL_ChangePL('p_user');",
						'style'=>"width:120px;"
                    ),
                'ad005010'=>array(
                        'call_name'=>'申請人員帳號',
                        'type'=>'hidden'
                    ),
                'ad005010_title'=>array(
                        'call_name'=>'客戶-顯示',
                        'type'=>'text',
						'onblur'=>'PL_CloseList();',
						'onclick'=>"PL_ChangePL('a_user');",
						'onfocus'=>"PL_ChangePL('a_user');",
						'style'=>"width:120px;"
                    ),
                'ad005013'=>array(
                        'call_name'=>'領用人員帳號',
                        'type'=>'hidden'
                    ),
                'ad005013_title'=>array(
                        'call_name'=>'客戶-顯示',
                        'type'=>'text',
						'onblur'=>'PL_CloseList();',
						'onclick'=>"PL_ChangePL('r_user');",
						'onfocus'=>"PL_ChangePL('r_user');",
						'style'=>"width:120px;"
                    ),
                'ad005016'=>array(
                        'call_name'=>'附註用途',
                        'type'=>'textarea',
						'style'=>'width:90%;height:50px;'
                    ),
                'ad005038'=>array(
                        'call_name'=>'預定採購金額',
                        'type'=>'text',
						'readonly'=>'Y'
                    ),
                'ad005037'=>array(
                        'call_name'=>'調整金額',
                        'type'=>'text',
						'onchange'=>"PG_BK_Action('recount_amt',{ type:'am',id:'ad005037'})",
						'pii'=>array('noam')
                    ),
                'ad005054'=>array(
                        'call_name'=>'調整原因',
                        'type'=>'text',
						'style'=>'width:90%;'
                    ),
				'fix_price'=>array(
						'call_name'=>'',
						'type'=>'hidden'
					),
                'ad005056'=>array(
                        'call_name'=>'議價金額',
                        'type'=>'text',
						'pii'=>array('nod'),
						'onchange'=>"PG_BK_Action('recount_amt',{ type:'m',id:'ad005056'})"
                    ),
                'ad005057'=>array(
                        'call_name'=>'折扣金額',
                        'type'=>'text',
						'pii'=>array('nod'),
						'onchange'=>"PG_BK_Action('recount_amt',{ type:'m',id:'ad005057'})"
                    ),
                'ad005060'=>array(
                        'call_name'=>'折扣原因',
                        'type'=>'text',
						'style'=>'width:90%;'
                    ),
                'ad005018'=>array(
                        'call_name'=>'合計數字',
                        'type'=>'text',
						'pii'=>array('nod'),
						'readonly'=>'Y'
                    ),
                'ad005017'=>array(
                        'call_name'=>'合計國字',
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