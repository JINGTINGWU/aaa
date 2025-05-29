<?php 
if (!defined('BASEPATH')) exit('No direct script access allowed');

class Quick_info_model extends CI_Model 
{   //
	var $qad_id=0;
	var $qim_var_1='';//common_use_1
	var $qim_var_2='';
	
	
    function __construct() 
    {   global $_G;
        parent::__construct();
		if(isset($this->ad_id)) $this->qad_id=$this->ad_id;
    }
    
    function get_undone_task()   //
    {   global $_G; 
		$sql="
			SELECT COUNT(DISTINCT a.jec_projtask_id) AS num FROM jec_projtask AS a LEFT OUTER JOIN jec_usergroup AS b ON a.jec_group_id=b.jec_group_id WHERE a.projtasktype='2' AND (a.jec_user_id='".$this->qad_id."' OR b.jec_user_id='".$this->qad_id."') AND a.isactive='Y'
		";
		$data=$this->db->query($sql)->result_array();
		return $data[0]['num'];
    }
    function get_delay_task()   //
    {   global $_G; 
		$sql="
			SELECT COUNT(DISTINCT a.jec_projtask_id) AS num FROM jec_projtask AS a LEFT OUTER JOIN jec_usergroup AS b ON a.jec_group_id=b.jec_group_id WHERE a.projtasktype='2' AND (a.jec_user_id='".$this->qad_id."' OR b.jec_user_id='".$this->qad_id."') AND a.enddate<'".date('Y-m-d 00:00:00')."' AND a.isactive='Y'
		";
		$data=$this->db->query($sql)->result_array();
		return $data[0]['num'];
    }	
    function get_unconfirm_notice()   //
    {   global $_G; //未確認的 
		$sql="
			SELECT COUNT(DISTINCT a.jec_projnotice_id) AS num FROM jec_projnotice AS a LEFT JOIN jec_projtask AS b ON a.jec_projtask_id=b.jec_projtask_id WHERE a.noticetype IN(4,5,6,7,8,9) AND a.jec_user_id='".$this->qad_id."' AND a.isactive='Y' AND b.isactive='Y'
		";
		$data=$this->db->query($sql)->result_array();
		return $data[0]['num'];
    }	
    function get_alert_notice()   //
    {   global $_G; //notice
		$sql="
			SELECT COUNT(jec_projnotice_id) AS num FROM jec_projnotice a 
LEFT JOIN jec_project b ON a.jec_project_id=b.jec_project_id 
WHERE a.noticetype='3' AND b.projstatus='2' AND a.jec_user_id='".$this->qad_id."'
		";
		$data=$this->db->query($sql)->result_array();
		return $data[0]['num'];//
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
		$up_dept_id=$this->GM->GetSpecData('jec_dept','jec_deptuplayer_id','jec_dept_id',$dept_id);
		if($up_dept_id==0):
			$final=$this->GM->GetSpecData('jec_dept','jec_user_id','jec_dept_id',$up_dept_id);
		else:
			$final=$this->GM->GetSpecData('jec_dept','jec_user_id','jec_dept_id',$dept_id);
		endif;
		return $final;
	}//
	
	function get_dept_top_mng_id($dept_id=0)
	{
		$up_dept_id=$this->GM->GetSpecData('jec_dept','jec_deptuplayer_id','jec_dept_id',$dept_id);
		do{
			$dept_id=$up_dept_id;
			$up_dept_id=$this->GM->GetSpecData('jec_dept','jec_deptuplayer_id','jec_dept_id',$dept_id);
		}while($up_dept_id!=0);
		$final=$this->GM->GetSpecData('jec_dept','jec_user_id','jec_dept_id',$up_dept_id);
		return $final;
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
				if(count($mng_list)>0)://為主管喔
					//get_full_user
					foreach($mng_list as $dept):
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
				$user_list=$this->db->where('jec_dept_id',$key_id)->where('isactive','Y')->select('jec_user_id')->get('jec_user')->result_array();
				foreach($user_list as $user):
					if(!in_array($user['jec_user_id'],$this->qim_var_2)) $this->get_acc_right_id('group',$user['jec_user_id']);
					
				endforeach;
				break;
		endswitch;
		//final->get_qim_var_1
	}
	
	
}

?>