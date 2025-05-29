<?php 
if (!defined('BASEPATH')) exit('No direct script access allowed');

class Quick_info_model extends CI_Model 
{   //
	var $qad_id=0;
	var $qim_var_1='';//common_use_1
	var $qim_var_2='';
	
	const SYS_MNG_ROLE = 1; //系統管理者id
	
	
    function __construct() 
    {   global $_G;
        parent::__construct();
		if(isset($this->ad_id)) $this->qad_id=$this->ad_id;
    }
    
    function get_undone_task()   //
    {   global $_G;	
	 	if($this->session->userdata('undone_task')<>false)
		{
			return $this->session->userdata('undone_task');
		}
		else
		{
		$sql="
			SELECT COUNT(distinct a.jec_projtask_id) AS num FROM jec_projtask AS a LEFT OUTER JOIN jec_usergroup AS b ON a.jec_group_id=b.jec_group_id WHERE a.projtasktype='2' AND (a.jec_user_id='".$this->qad_id."' OR b.jec_user_id='".$this->qad_id."') AND a.isactive='Y'
		";
		$data=$this->db->query($sql)->result_array();
		$this->session->set_userdata('undone_task',$data[0]['num']);
		return $data[0]['num'];
		}
    }
    function get_delay_task()   //
    {   global $_G; 
		if($this->session->userdata('delay_task')<>false)
		{
			return $this->session->userdata('delay_task');
		}
		else
		{
		$sql="
			SELECT COUNT(DISTINCT a.jec_projtask_id) AS num FROM jec_projtask AS a LEFT OUTER JOIN jec_usergroup AS b ON a.jec_group_id=b.jec_group_id WHERE a.projtasktype='2' AND (a.jec_user_id='".$this->qad_id."' OR b.jec_user_id='".$this->qad_id."') AND a.enddate<'".date('Y-m-d 00:00:00')."' AND a.isactive='Y'
		";
		$data=$this->db->query($sql)->result_array();		
		$this->session->set_userdata('delay_task',$data[0]['num']);
		return $data[0]['num'];
		}
    }	
    function get_unconfirm_notice()   //
    {   global $_G; //未確認的 
		if($this->session->userdata('unconfirm_notice') != "")
		{
			return $this->session->userdata('unconfirm_notice');
		}
		else
		{
		$sql="
			SELECT COUNT(DISTINCT a.jec_projnotice_id) AS num FROM jec_projnotice AS a LEFT JOIN jec_projtask AS b ON a.jec_projtask_id=b.jec_projtask_id WHERE a.noticetype IN(4,5,6,7,8,9,10,31,32) AND a.jec_user_id='".$this->qad_id."' AND a.isactive='Y' AND b.isactive='Y' and (a.description is null or (a.description <> '批次展期' and a.description <> '批次刪除'))
		";
		$data=$this->db->query($sql)->result_array();
		$this->session->set_userdata('unconfirm_notice',$data[0]['num']);
		return $data[0]['num'];
		}
    }	
	function get_batchunconfirm_notice()   //
    {   global $_G; //未批次確認的 
		if($this->session->userdata('batchunconfirm_notice') != "")
		{
			return $this->session->userdata('batchunconfirm_notice');
		}
		else
		{
		$sql="
			SELECT a.jec_project_id FROM jec_projnotice as a inner join jec_project as b on a.jec_project_id=b.jec_project_id inner join jec_dept as c on c.jec_dept_id=b.jec_dept_id WHERE noticetype IN(4,5,6,7,8,9,10,31) AND c.jec_user_id='".$this->qad_id."' AND a.isactive='Y'  and b.isactive='Y' and a.description in ('批次展期','批次刪除') group by a.jec_project_id
		";
		$data=$this->db->query($sql)->num_rows();
		$this->session->set_userdata('batchunconfirm_notice',(string)$data);
		return $data;
		}
	}	
    function get_alert_notice()   //
    {   global $_G; //notice
		if($this->session->userdata('alert_notice')!= "")
		{
			return $this->session->userdata('alert_notice');
		}
		else
		{
		$sql="
			SELECT COUNT(jec_projnotice_id) AS num FROM jec_projnotice a 
LEFT JOIN jec_project b ON a.jec_project_id=b.jec_project_id 
WHERE a.noticetype='3' AND b.projstatus='2' AND a.jec_user_id='".$this->qad_id."'
		";
		$data=$this->db->query($sql)->result_array();
		$this->session->set_userdata('alert_notice',$data[0]['num']);
		return $data[0]['num'];//
		}
    }	
	
	function get_menu_right($menu_id=0,$role_id=0)
	{
		
		$data=$this->db->where('jec_menu_id',$menu_id)->where('jec_role_id',$role_id)->where('isactive','Y')->get('jec_rolemenu')->result_array();
		//
		return $data[0];
	}
	function menu_right_check($data=array(),$check=array(),$type=array())
	{	$final=true;
		foreach($check as $value):
			if($data['is'.$value]=='N'):
				$final=false;
				break;
			endif;
		endforeach;
		if($final==false):
			if(isset($type['url'])):
				$this->CM->JS_Link($type['url']);
			endif;
			if(isset($type['exit'])):
				exit();
			endif;
		endif;
		return $final;
	}
	
	function get_right_tag($data=array())
	{	$final=array();
		$info=array('ac'=>'access','add'=>'insert','up'=>'update','del'=>'delete');
		$type=array('dp'=>'style="display:none;"','da'=>'disabled');

		foreach($info as $st=>$sv):
			foreach($type as $tst=>$tsv):
				$final[$st.'_'.$tst]=$data['is'.$sv]=='Y'?'':$tsv;
			endforeach;
		endforeach;

		return $final;
	}
	
	function get_final_sales_name($data=array())
	{
		if((int)$data['jec_user_id']>0):
			$final=$this->db->where('jec_user_id',$data['jec_user_id'])->get('jec_user')->result_array();
		else:
			$final=$this->db->where('jec_group_id',$data['jec_group_id'])->get('jec_group')->result_array();
		endif;
		return $final[0]['name'];
	}
	
	function get_final_super_name($data=array())
	{
		if((int)$data['jec_usersuper_id']>0):
			$final=$this->db->where('jec_user_id',$data['jec_usersuper_id'])->get('jec_user')->result_array();		
		endif;
		return $final[0]['name'];
	}
	
	function get_final_sales_array($data=array())
	{	$final=array();
		if((int)$data['jec_user_id']>0):
			$final=$this->db->where('jec_user_id',$data['jec_user_id'])->where('isactive','Y')->get('jec_user')->result_array();
		else:
			$final=$this->db->where('jec_group_id',$data['jec_group_id'])->where('isactive','Y')->get('jec_usergroup')->result_array();
		endif;
		$final=$this->CM->FormatData(array('db'=>$final,'key'=>'jec_user_id'),'page_db','s_array');
		return $final;
	}
	
	function get_user_row($jec_user_id=0)
	{
		
		$result=$this->db->where('jec_user_id',$jec_user_id)->get('jec_user')->result_array();
		//$this->CM->JS_TMsg($result[0]['jec_user_id']);
		return $result[0];
	}
	
	function get_dept_mng_id($dept_id=0)
	{
		$final=$this->GM->GetSpecData('jec_dept','jec_user_id','jec_dept_id',$dept_id);
		return $final;
	}
	
	function get_dept_up_mng_id($dept_id=0)
	{
		// Update by Johnson 2012/11/14 原本的寫法根本取不到上級主管
		$up_dept_id=$this->GM->GetSpecData('jec_dept','jec_deptuplayer_id','jec_dept_id',$dept_id);
//		if($up_dept_id==0):
//			$final=$this->GM->GetSpecData('jec_dept','jec_user_id','jec_dept_id',$up_dept_id);
//		else:
//			$final=$this->GM->GetSpecData('jec_dept','jec_user_id','jec_dept_id',$dept_id);
//		endif;
		if($up_dept_id!=0)
		{
			$final=$this->GM->GetSpecData('jec_dept','jec_user_id','jec_dept_id',$up_dept_id);
			return $final;
		}
		else
		{
			// $final=$this->GM->GetSpecData('jec_dept','jec_user_id','jec_deptuplayer_id',0);  // 居然找不到, 直接用1找, 先固定之
			$top_id = 1; $top_user_id = 85;
			// $final=$this->GM->GetSpecData('jec_dept','jec_user_id','jec_dept_id',$top_id);  // 居然也找不到
			$this->db->select('jec_user_id');
			$this->db->from('jec_dept');
			$this->db->where('jec_dept_id', $top_id);
			$row = $this->db->get('')->result_array();
			if (! empty($row[0]['jec_user_id']))
				return $row[0]['jec_user_id'];
			else
				return $top_user_id;  // 會走到這一步也不得己了, 出絕招!
		}
	}
	
	function get_dept_top_mng_id($dept_id=0)
	{
		// Update by Johnson 2012/11/14 以jec_dept_id=0去找資料當然找不到啊!!!直接用jec_deptuplayer_id=0找即可
//		$up_dept_id=$this->GM->GetSpecData('jec_dept','jec_deptuplayer_id','jec_dept_id',$dept_id);
//		do{
//			$dept_id=$up_dept_id;
//			$up_dept_id=$this->GM->GetSpecData('jec_dept','jec_deptuplayer_id','jec_dept_id',$dept_id);
//		}while($up_dept_id!=0);
//		$final=$this->GM->GetSpecData('jec_dept','jec_user_id','jec_dept_id',$up_dept_id);
		//$final=$this->GM->GetSpecData('jec_dept','jec_user_id','jec_deptuplayer_id',0);  // 居然找不到, 直接用1找, 先固定之
		// 有空時待修改以遞迴方式取得上級主管資料
		$top_id = 1; $top_user_id = 85;
		// $final=$this->GM->GetSpecData('jec_dept','jec_user_id','jec_dept_id',$top_id);  // 居然也找不到
		// return $final;
		$this->db->select('jec_user_id');
		$this->db->from('jec_dept');
		$this->db->where('jec_dept_id', $top_id);
		$row = $this->db->get('')->result_array();
		if (! empty($row[0]['jec_user_id']))
			return $row[0]['jec_user_id'];
		else
			return $top_user_id;  // 會走到這一步也不得己了, 出絕招!
	}
		
	function get_redirect_url($type='',$data='',$uid=0,$loginparameters)
	{	$final='';
	/*
		if($loginparameters):
			$loginparameters = $this->session->userdata($loginparameters);
		else:
			$loginparameters=array();
		endif;*/
		$this->load->model('Mm_encode_model', 'MEM');
		$uid=$this->MEM->ReturnFinalCode($uid,'emsproj',2);//網址所屬ID
		
		
		if(isset($loginparameters['jec_user_id'])):
			$needlogin=FALSE;
		else:
			$needlogin=TRUE;
		endif;
		
		switch($type):
			case 'work_report'://task_id
				//check
				//$jec_projtask_id=(int)$data;
				$jec_projtask_id=$this->MEM->ReturnFinalCode($data,'emsproj',2);//網址所屬I
				$projt_v_set=$this->CM->Init_TB_Set('mm_projtask_search_set');
				$projt_data=$this->$projt_v_set['mm_set']->get_projtask_row($jec_projtask_id);
				$sales_array=$this->get_final_sales_array($projt_data);
				if(in_array($uid,$sales_array)):
					//
					if(isset($loginparameters['jec_user_id'])):
						if($loginparameters['jec_user_id']==$uid):
							$final=base_url('ecp_work/self_work_mng/work_report_index/list/'.$jec_projtask_id.'/');
						else:
							//$this->CM->JS_TMsg('NeedLogin');
							//$this->session->sess_destroy();//先登出
							$needlogin=TRUE;
							$final=base_url('ecp_work/self_work_mng/work_report_index/list/'.$jec_projtask_id.'/'); //rp
							//$final=base_url('ecp_work/self_work_mng/work_list_index/list/-1/');//不是本人-請先登出
						endif;
					else:
						$final=base_url('ecp_work/self_work_mng/work_report_index/list/'.$jec_projtask_id.'/');
					endif;
				else:
					$final=base_url('ecp_work/self_work_mng/work_list_index/list/-1/');
				endif;
				
				//$final=base_url('ecp_work/self_work_mng/work_list_index/list/-1/');
				break;
			case 'work_confirm'://noticeid-data->projnotice_id
				//用在delay的。-super.Project
				//為專管或super
				$jec_projnotice_id=$this->MEM->ReturnFinalCode($data,'emsproj',2);//網址所屬I
				$td=$this->db->where('jec_projnotice_id',$jec_projnotice_id)->get('jec_projnotice')->result_array();
				$projn_data=$td[0];
				if(isset($loginparameters['jec_user_id'])):
					if($uid==$loginparameters['jec_user_id']):
						if($uid==$projn_data['jec_user_id']):
							$final=base_url('ecp_work/inform_item_mng/confirm_list_index/list/'.$jec_projnotice_id.'/');
						else:
							$final=base_url('ecp_work/inform_item_mng/work_record_index/list/'.$jec_projnotice_id.'/');
						endif;		
					else:
						//login_out
						$needlogin=TRUE;
						if($uid==$projn_data['jec_user_id']):
							$final=base_url('ecp_work/inform_item_mng/confirm_list_index/list/'.$jec_projnotice_id.'/');
						else:
							$final=base_url('ecp_work/inform_item_mng/work_record_index/list/'.$jec_projnotice_id.'/');
						endif;	
					endif;
				else:
					if($uid==$projn_data['jec_user_id']):
						$final=base_url('ecp_work/inform_item_mng/confirm_list_index/list/'.$jec_projnotice_id.'/');
					else:
						$final=base_url('ecp_work/inform_item_mng/work_record_index/list/'.$jec_projnotice_id.'/');
					endif;
				endif;
				
				break;
			case 'work_index':
				$final=base_url('ecp_work/self_work_mng/work_list_index/list/-1/');
				break;
		endswitch;
		
		if($final!=''&&isset($loginparameters['jec_user_id'])&&$needlogin==FALSE):
			$this->CM->JS_Link($final);
		endif;
		$data=array('url'=>$final,'needlogin'=>$needlogin);
		return $data;
	}
	
	function get_acc_right_id($type='user',$key_id=0)
	{	//
		//check_主管-
		if(!is_array($this->qim_var_1)) $this->qim_var_1=array();
		switch($type):
			case 'user_wi':
				$array=$this->get_acc_right_id('user_array',$key_id);
				$test=implode("','",$array);
				$final=substr($test,0,3)=="','"?substr($test,3):$test;
				return "'".$final."'";
				break;
			case 'group_wi':
				$array=$this->get_acc_right_id('group_array',$key_id);
				$test=implode("','",$array);
				$final=substr($test,0,3)=="','"?substr($test,3):$test;
				return "'".$final."'";
				break;
			case 'user_array':
				$this->qim_var_1=array();
				$this->QIM->get_acc_right_id('user',$key_id);
				asort($this->qim_var_1);
				$final=$this->QIM->qim_var_1;
				return $final;
				break;
			case 'group_array':
				$this->QIM->qim_var_1=$this->QIM->qim_var_2=array();
				$this->QIM->get_acc_right_id('group',$key_id);
				asort($this->qim_var_1);
				$final=$this->QIM->qim_var_1;
				$this->QIM->qim_var_1='';
				return $final;
				break;
			case 'user'://
				//$final=array($key_id);
				array_push($this->qim_var_1,$key_id);
				$mng_list=$this->db->where('jec_user_id',$key_id)->where('isactive','Y')->get('jec_dept')->result_array();
				$asi_list=$this->db->where('jec_user_id',$key_id)->where('isactive','Y')->where('jec_title_id',14)->get('jec_user')->result_array();
				if(count($mng_list)>0)://為部門主管
					//get_full_user
					foreach($mng_list as $dept):
						$this->get_acc_right_id('dept',$dept['jec_dept_id']);
					endforeach;
				elseif(count($asi_list)>0)://為助理
					//get_full_user
					foreach($asi_list as $dept):
						$this->get_acc_right_id('dept',$dept['jec_dept_id']);
					endforeach;				
				endif;
				$this->qim_var_1=array_unique($this->qim_var_1);
				
				
				break;
			case 'group'://取得所屬的group.
				array_push($this->qim_var_2,$key_id);
				//$group_list=$this->db->where('jec_user_id',$key_id)->where('isactive','Y')->select('jec_group_id')->join('jec_dept', 'jec_dept.jec_user_id = jec_usergroup.jec_user_id')->get('jec_usergroup')->result_array();
				$group_list=$this->db->where('jec_user_id',$key_id)->where('isactive','Y')->select('jec_group_id')->get('jec_usergroup')->result_array();
				foreach($group_list as $group):
					if(!in_array($group['jec_group_id'],$this->qim_var_1)) array_push($this->qim_var_1,$group['jec_group_id']);
				endforeach;
				$mng_list=$this->db->where('jec_user_id',$key_id)->where('isactive','Y')->get('jec_dept')->result_array();
				if(count($mng_list)>0)://為主管喔
					foreach($mng_list as $dept):
						$this->get_acc_right_id('dept_group',$dept['jec_dept_id']);
					endforeach;					
				endif;
				$this->qim_var_1=array_unique($this->qim_var_1);
				

				break;
			case 'dept'://check...is_dept?-
				$user_list=$this->db->where('jec_dept_id',$key_id)->where('isactive','Y')->select('jec_user_id')->get('jec_user')->result_array();
				foreach($user_list as $user):
					if(!in_array($user['jec_user_id'],$this->qim_var_1)&&$user['jec_user_id']>0):
						array_push($this->qim_var_1,$this->get_acc_right_id('user',$user['jec_user_id']));
					endif;
				endforeach;
				
				$next=$this->db->where('jec_deptuplayer_id',$key_id)->where('isactive','Y')->get('jec_dept')->result_array();
				if(count($next)>0):
					foreach($next as $dept):
						$this->get_acc_right_id('dept',$dept['jec_dept_id']);
					endforeach;
				endif;
				break;
			case 'dept_group'://
				//dept_id
				//check有無下層

				$user_list=$this->db->where('jec_dept_id',$key_id)->where('isactive','Y')->select('jec_user_id')->get('jec_user')->result_array();
				foreach($user_list as $user):
					if(!in_array($user['jec_user_id'],$this->qim_var_2)) $this->get_acc_right_id('group',$user['jec_user_id']);
					
				endforeach;
				

				
				break;
		endswitch;
		//final->get_qim_var_1
	}
	
	/**
	* 對專案內容是否有異動權限
	* @param int $project_id
	* @return boolean
	*/
	public function is_project_modify($project_id)
	{
		//確認是否為管理者
		$user_data = $this->get_user_row($this->ad_id);
		if($user_data['jec_role_id'] == self::SYS_MNG_ROLE)
		{
			return true;
		}
		
		//是否為專案主持人、專案負責人、建檔人員
		$proj_set=$this->CM->Init_TB_Set('mm_project_set');
		$proj_data = $this->$proj_set['mm_set']->get_project_row($project_id);
		$asi_list=$this->db->where('jec_dept_id',$proj_data['jec_dept_id'])->where('isactive','Y')->where('jec_title_id',14)->where('jec_user_id',$this->ad_id)->get('jec_user')->result_array();
		if($proj_data['jec_user_id'] == $this->ad_id 
			or $proj_data['jec_usersales_id'] == $this->ad_id
			or $proj_data['createdby'] == $this->ad_id 
			or count($asi_list)>0)
		{
			return true;
		}
		
		//是否為專案主持人主管
		$incharge_user = $this->get_user_row($proj_data['jec_user_id']);
		if($this->get_dept_mng_id($incharge_user['jec_dept_id']) == $this->ad_id)
		{
			return true;
		}
		
		
		return false;
	}
	
	
}

?>