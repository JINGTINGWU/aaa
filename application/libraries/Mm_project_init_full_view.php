<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Mm_project_init_full_set
{
    var $mm_tb='project_init_full_view';
	var $mm_tablename='JEC_Projtask';
	var $mm_glt='2';
    var $mm_td=array();
    var $mm_kid='jec_projtask_id';
    var $mm_deltype='isactive';
    var $mm_actb='jec_projtask_search_view';
	var $btn_allow=array(
			2,5
		);	
	var $btn_del_rp_allow=array(
			0
		);	
	var $btn_del_ty_allow=array(
			1,2,4,5
		);	
	var $color_info=array(
				1=>'ganttGray',
				2=>'ganttGreen',
				3=>'ganttOrange',
				4=>'ganttGray',
				5=>'ganttBlue',
				6=>'ganttRed'
			);	
	var $edit_1_info=array('taskname','jec_user_id_title','jec_usersuper_id_title','startdate','enddate','taskdaynotice','taskdaydelay');//後，工作名稱、負責人員、督導人員、開始結束日期、通知天數、延遲天數
	var $edit_2_info=array('taskworkweight','taskprocesstype','taskconfirmtype');//，權重、處理、確認
	public function __construct()
	{   global $_G;
		$this->ci =& get_instance();
		$this->load_mm_td();
	}

	function load_mm_td()//
	{   global $_G;
	    $this->mm_td=array(
		        'nav'=>array(   //noticetype
						'con'=>array('datatype'=>3)				
				    ),
				'group'=>array(
						'join'=>array('type'=>'left outer','jtb'=>'jec_usergroup','jkey'=>'jec_group_id','mkey'=>'jec_group_id','tb'=>$this->mm_tb),
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
						'style'=>"width:230px;"//100
                    ),
                'jec_task_id'=>array(
                        'call_name'=>'工作項目',
                        'type'=>'hidden'
                    ),/*
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
                    ),*/
                'jec_user_id'=>array(
                        'call_name'=>'承辦人',
                        'type'=>'hidden'
                    ),
                'jec_usersuper_id'=>array(
                        'call_name'=>'督導人',
                        'type'=>'hidden'
                    ),
                'jec_user_id_title'=>array(
                        'call_name'=>'專案業務',
                        'type'=>'text',
						'onblur'=>'PL_CloseList();',
						'onclick'=>"PL_ChangePL('user');",
						'onfocus'=>"PL_ChangePL('user');",
						'style'=>"width:70px;"
                    ),
                'jec_usersuper_id_title'=>array(
                        'call_name'=>'專案業務',
                        'type'=>'text',
						'onblur'=>'PL_CloseList();',
						'onclick'=>"PL_ChangePL('usersuper');",
						'onfocus'=>"PL_ChangePL('usersuper');",
						'style'=>"width:70px;"
                    ),
                'name'=>array(
                        'call_name'=>'專案名稱',
                        'type'=>'text'
                    ),
                'description'=>array(
                        'call_name'=>'備註說明',
                        'type'=>'textarea',
						'style'=>'width:90%;'
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
                'taskname'=>array(
                        'call_name'=>'工作名稱',
                        'type'=>'textarea',
						'style'=>'width:70px'
                    ),
                'taskdaynotice'=>array(
                        'call_name'=>'前置知天數',
                        'type'=>'select',
						'style'=>'width:40px',
						//'pii'=>array('no')
						'ld'=>$this->ci->CM->FormatData(array('key'=>'id','value'=>'name','sn'=>1,'en'=>30),"page_db","num"),
						'ld_key'=>'id',
						'ld_value'=>'name'
                    ),
                'taskdaydelay'=>array(
                        'call_name'=>'允許延遲天數',
                        'type'=>'select',
						'style'=>'width:40px',
						//'pii'=>array('no')
						'ld'=>$this->ci->CM->FormatData(array('key'=>'id','value'=>'name','sn'=>0,'en'=>30),"page_db","num"),
						'ld_key'=>'id',
						'ld_value'=>'name'
                    ),
                'taskworkweight'=>array(
                        'call_name'=>'工作權重',
                        'type'=>'select',
						'ld'=>$this->ci->CM->FormatData(array('key'=>'id','value'=>'name','sn'=>1,'en'=>10),"page_db","num"),
						'ld_key'=>'id',
						'ld_value'=>'name',
						'full_selected'=>'N'
                    ),
                'taskprocesstype'=>array(
                        'call_name'=>'處理原則',
                        'type'=>'select',
						'ld'=>$this->ci->$_G['L_CS']->common_use_ld('processtype'),
						'ld_key'=>'id',
						'ld_value'=>'name',
						'full_selected'=>'N'
                    ),
                'taskconfirmtype'=>array(
                        'call_name'=>'確認方式',
                        'type'=>'select',
						'ld'=>$this->ci->$_G['L_CS']->common_use_ld('confirmtype'),
						'ld_key'=>'id',
						'ld_value'=>'name',
						'full_selected'=>'N'
                    ),
                'rp_finish'=>array(
                        'call_name'=>'工作完成',
                        'type'=>'textarea',
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
                        'type'=>'textarea',
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
                        'type'=>'textarea',
						'style'=>'width:80%;'
                    ),
					'rp_transfer_super'=>array(
                        'call_name'=>'工作移轉',
                        'type'=>'textarea',
						'style'=>'width:80%;'
                    ),
					/*
                'rp_transfer_user'=>array(
                        'call_name'=>'工作移轉',
                        'type'=>'select',
						'full_selected'=>'N',
						'ld'=>array(),
						'ld_key'=>'jec_user_id',
						'ld_value'=>'name'
                    ),*/
                'rp_transfer_user'=>array(
                        'call_name'=>'工作移轉',
                        'type'=>'hidden'
                    ),
				'rp_transfer_superuser'=>array(
                        'call_name'=>'工作移轉',
                        'type'=>'hidden'
                    ),
                'rp_transfer_user_title'=>array(
                        'call_name'=>'專案業務',
                        'type'=>'text',
						'onblur'=>'PL_CloseList();',
						'onclick'=>"PL_ChangePL('user');",
						'onfocus'=>"PL_ChangePL('user');",
						'style'=>'width:70px;'
                    ),
					'rp_transfer_superuser_title'=>array(
                        'call_name'=>'督導轉移',
                        'type'=>'text',
						'onblur'=>'PL_CloseList();',
						'onclick'=>"PL_ChangePL('superuser');",
						'onfocus'=>"PL_ChangePL('superuser');",
						'style'=>'width:70px;'
                    ),
                'rp_impossible'=>array(
                        'call_name'=>'無法完成',
                        'type'=>'textarea',
						'style'=>'width:80%;'
                    ),
                'rp_impossible_time'=>array(
                        'call_name'=>'無法完time成',
                        'type'=>'text',
						'readonly'=>'Y'
                    ),
                'rp_pause'=>array(
                        'call_name'=>'工作暫停',
                        'type'=>'textarea',
						'style'=>'width:80%;'
                    ),
                'rp_pause_time'=>array(
                        'call_name'=>'暫停時間',
                        'type'=>'text',
						'readonly'=>'Y'
                    ),
                'rp_pause_startdate'=>array(
                        'call_name'=>'恢復開始時間',
                        'type'=>'text',
						'readonly'=>'Y'
                    ),
				'rp_pause_enddate'=>array(
                        'call_name'=>'恢復結束時間',
                        'type'=>'text',
						'readonly'=>'Y'
                    ),
                'rp_recover'=>array(
                        'call_name'=>'工作回復',
                        'type'=>'text',
						'style'=>'width:60%;'
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
	
	function get_jec_user_ld($exclude=0,$word='')
	{	//group&user ->考慮存快取->不含自己
		if(is_array($exclude)):
			if((int)$exclude['jec_group_id']>0):
				if($word==''):
					$user_list=$this->ci->db->where('isactive','Y')->order_by('name','ASC')->get('jec_user')->result_array();
					$group_list=$this->ci->db->where('isactive','Y')->where('jec_group_id !=',$exclude['jec_group_id'])->order_by('name','ASC')->get('jec_group')->result_array();
				else:
					$user_list=$this->ci->db->like('name',$word)->where('isactive','Y')->order_by('name','ASC')->get('jec_user')->result_array();
					$group_list=$this->ci->db->like('name',$word)->where('isactive','Y')->where('jec_group_id !=',$exclude['jec_group_id'])->order_by('name','ASC')->get('jec_group')->result_array();
				endif;

			else:
				if($word==''):
					$user_list=$this->ci->db->where('isactive','Y')->where('jec_user_id !=',$exclude['jec_user_id'])->order_by('name','ASC')->get('jec_user')->result_array();
					$group_list=$this->ci->db->where('isactive','Y')->order_by('name','ASC')->get('jec_group')->result_array();
				else:
					$user_list=$this->ci->db->like('name',$word)->where('isactive','Y')->where('jec_user_id !=',$exclude['jec_user_id'])->order_by('name','ASC')->get('jec_user')->result_array();
					$group_list=$this->ci->db->like('name',$word)->where('isactive','Y')->order_by('name','ASC')->get('jec_group')->result_array();
				endif;
			endif;
		else:
			if($word==''):
				$user_list=$this->ci->db->where('isactive','Y')->order_by('name','ASC')->get('jec_user')->result_array();
				$group_list=$this->ci->db->where('isactive','Y')->order_by('name','ASC')->get('jec_group')->result_array();
			else:
				$user_list=$this->ci->db->like('name',$word)->where('isactive','Y')->order_by('name','ASC')->get('jec_user')->result_array();
				$group_list=$this->ci->db->like('name',$word)->where('isactive','Y')->order_by('name','ASC')->get('jec_group')->result_array();
			endif;

		endif;

		$user_ld=$this->multi_list($user_list,array('key'=>'jec_user_id','value'=>'name','tag'=>'U-','op_key'=>'jec_user_id','op_value'=>'name'));
		$group_ld=$this->multi_list($group_list,array('key'=>'jec_group_id','value'=>'name','tag'=>'G-','op_key'=>'jec_user_id','op_value'=>'name'));
		$final=array_merge($user_ld,$group_ld);
		return $final;
	}
	function get_projtask_row($projtask_id=0)
	{	
		$result=$this->ci->db->where($this->mm_kid,$projtask_id)->get($this->mm_tb)->result_array();
		return count($result)>0?$result[0]:0;
	}
	function multi_list($list=array(),$data=array())
	{	//key/value/tag  op_key/op_value
		$final=array();
		foreach($list as $value):
			array_push($final,array($data['op_key']=>$data['tag'].$value[$data['key']],$data['op_value']=>$value[$data['value']]));
		endforeach;
		return $final;
	}
	
	function get_gantt_data($projtask_list=array())
	{	//取得甘特圖的資料
		$color_info=$this->color_info;
		$final="";
		$eno=0;
		foreach($projtask_list as $no=>$value): 
			if($value['startdate']!='0000-00-00 00:00:00'&&$value['enddate']!='0000-00-00 00:00:00'):
				$eno++;
				if($eno>1) $final.=',';
				$final.='
{ "name": "'.$value['taskname'].'",
   "desc": "",
   "values": [
       {"from": "/Date('.strtotime($value['startdate']).'000)/", "to": "/Date('.strtotime($value['enddate']).'000)/","label":"","desc": "負責人: '.$value['sales_name'].'<br/>督導人員: '.$value['super_name'].'", "customClass": "'.$color_info[$value['projtasktype']].'"}
     ]
}';
			endif;
		endforeach;
		$final='['.$final.']';
		return $final;
	}
	
	function get_user_id_by_title($title='')
	{	$final='';
		if($final==''):
			$exist=$this->ci->db->where('name',$title)->where('isactive','Y')->get('jec_user')->result_array();
			if(count($exist)>0) $final='U-'.$exist[0]['jec_user_id'];
		endif;
		if($final==''):
			$exist=$this->ci->db->where('name',$title)->where('isactive','Y')->get('jec_group')->result_array();
			if(count($exist)>0) $final='G-'.$exist[0]['jec_group_id'];
		endif;
		return $final;
	}
	
	function exe_right_check($type='def',$data=array())
	{	global $_G;
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
			 case 'check_delete':
			 	$final=true; $_G['err_msg']='';
				if(!is_array($data)) $data=$this->get_projtask_row($data);
				if($final==true)://1.7.5.	當待辦工作通知發出後，工作名稱、負責人員、督導人員、開始結束日期、通知天數、延遲天數，不可再修改，也不可刪除。
					if($data['isnotice']=='Y'): 
					    $final=false;
						$_G['err_msg']='已發出待辦通知，無法刪除';
					endif;
				endif;
				if($final==true):// 1.7.7.	當工作已完成，則這筆資料不可再修改，也不可刪除。
					if($data['isfinish']=='Y'):
					   	$final=false;
						$_G['err_msg']='工作已完成，無法刪除';
					endif;
				endif;
				if($final==true):
					if($data['projtasktype']!=1):
					   	$final=false;
						$_G['err_msg']='工作已開始，無法刪除';
					endif;
				endif;
				if($final==true):
					if($data['isnotice']=='Y'):
					   	$final=false;
						$_G['err_msg']='工作已發送通知，無法刪除';
					endif;
				endif;
				if($final==true):// 1.7.8.	當工作項目尚未開始，也沒有任何通知，也沒有工作明細，才可以刪除。
					//check_detail
					$num=$this->ci->db->where('jec_projtask_id',$data['jec_projtask_id'])->where('isactive','Y')->select('jec_projprod_id')->get('jec_projprod')->num_rows();
					if($num>0):
					   	$final=false;
						$_G['err_msg']='工作項下有明細，無法刪除';		
					endif;
				endif;
				
				//data->row
			 	break;
			 case 'check_edit_1':
				//當待辦工作通知發出後。工作名稱、負責人員、督導人員、開始結束日期、通知天數、延遲天數，不可再修改
				$final=true;
				if($data['isnotice']=='Y'||$data['isfinish']=='Y'):
					$final=false;
				endif;
			 	break;
			 case 'check_edit_2':// 1.7.6.	當工作未完成前，權重、處理、確認，都可以再修改，但不可刪除。
			 	$final=true;
				if($data['isfinish']=='Y'):
					$final=false;
				endif;
			 	break;
			case 'check_finish_precheck'://工作完成時的確認前置工作
				if($data['jec_task_id']>0):
					$check_data=$this->ci->db->where('jec_task_id',$data['jec_task_id'])->where('isactive','Y')->get('jec_taskcheck')->result_array();
					$check_array=$this->ci->CM->FormatData(array('db'=>$check_data,'key'=>'jec_task_check_id'),'page_db','s_array');
					$wi=$this->ci->CM->FormatData($check_array,'page_db','wi');
					$sql="SELECT jec_projtask_id FROM jec_projtask WHERE jec_project_id='".$data['jec_project_id']."' AND jec_task_id IN (".$wi.")  AND projtasktype IN ('3','1','2','5') AND isactive='Y'";
					$final_check=$this->ci->db->query($sql)->num_rows();
					if($final_check>0):
						$final=false;
					else:
						$final=true;
					endif;
				else:
					$final=true;
				endif;
				break;
		 }
		 if($final==false&&isset($data['rd_url'])) $this->ci->CM->JS_Link($data['rd_url']);
		 return $final;
	}
	
	function Send_Related_Mail($type='',$data=array())
	{
		switch($type):
			case 'finish_precheck_alert':
				//mail_pdb
				$projn_noticetype=13;
				$mail_db=array();
				$mail_pdb=isset($data['mail_pdb'])?$data['mail_pdb']:$this->ci->CM->FormatData(array('db'=>'mm_setup_set@def','key'=>'noticetype','vf'=>'content'),'page_db',1);
				$value=$projt_data=$data['projt_data'];
				
				$sales_name=$this->ci->QIM->get_final_sales_name($value);
				$mail_data=array('proj_name'=>$value['proj_name'],'task_name'=>$value['taskname'],'noticetype'=>$projn_noticetype,'sales_name'=>$sales_name,'check_name'=>'','finishdate'=>date('Y-m-d'));//$value['startdate']
				$mail_content=$this->ci->mm_projnotice_set->get_mail_content($mail_pdb,$mail_data['noticetype'],$mail_data);
				if($value['proj_jec_user_id']==$value['jec_usersuper_id']):
					$tu_user=array($value['jec_usersuper_id']);
				else:
					$tu_user=array($value['proj_jec_user_id'],$value['jec_usersuper_id']);
				endif;
				//$tu_user=array($value['proj_jec_user_id'],$value['jec_usersuper_id']);
				//$tu_user=array_unique($tu_user);
			//
				foreach($tu_user as $value):
					$tu_value['jec_user_id']=$value;
						if(isset($mail_db[$tu_value['jec_user_id']])):
							$mailto=$mail_db[$tu_value['jec_user_id']];
						else:
							$mailto=$this->ci->QIM->get_user_row($tu_value['jec_user_id']);
							$mail_db[$tu_value['jec_user_id']]=$mailto;
						endif;
							$email=array(
								'name'=>$mailto['name'],
								'to'=>$mailto['email'],
								'time'=>date('Y-m-d H:i:s'),
								'subject'=>$this->ci->mm_projnotice_set->get_email_subject($projn_noticetype),
								'content'=>$mail_content,
								'emailsend'=>'N'
								);

							//要回全部耶…			
							$upd=array(
								'jec_project_id'=>$projt_data['jec_project_id'],
								'jec_projtask_id'=>$projt_data['jec_projtask_id'],
								'noticetype'=>$projn_noticetype,
								'noticefrom'=>1,
								'jec_user_id'=>$tu_value['jec_user_id'],
								'emailtime'=>$email['time'],
								'emailsubject'=>$email['subject'],
								'emailcontent'=>$email['content'],
								'emailsend'=>$email['emailsend'],
								'noticetime'=>date('Y-m-d H:i:s'),
								'startdate'=>$projt_data['startdate'],
								'enddate'=>$projt_data['enddate']
								);
							//$email['content'].='<a href="'.$e_link.'">連結</a>';	
							if($this->ci->CM->SendMailGo($email['to'],$email['name'],$email['subject'],$email['content'],'','From-System')):
								$email['emailsend']='Y';
							endif;	
							
							$n_upd=array(
									'emailsend'=>$email['emailsend'],
									'emailcontent'=>$email['content']
								);
							$t_projnotice_id=$this->ci->mm_projnotice_set->notice_action($upd);
							$this->ci->db->where('jec_projnotice_id',$t_projnotice_id)->update('jec_projnotice',$n_upd);
							
							
							//$this->CM->JS_TMsg('Before_Record_'.$value['jec_projtask_id'].'_'.$df_ip['ac']);
							//record
							$upd=array(
								'jec_project_id'=>$projt_data['jec_project_id'],
								'jec_projtask_id'=>$projt_data['jec_projtask_id'],
								'recordtype'=>$this->ci->mm_projrecord_set->get_recordstatus($projn_noticetype),
								'recordtime'=>date('Y-m-d H:i:s'),
								'jec_user_id'=>$tu_value['jec_user_id'], //回覆給回報的人
								'description'=>$mail_content
								);
							$this->ci->mm_projrecord_set->record_action($upd);
							//$this->CM->JS_TMsg('After_Record_'.$value['jec_projtask_id']);

									
				endforeach;
				break;
		endswitch;
	}
	
    function after_exe_ac($ac='',$data=array())
    {   //
 		//
    }         
}