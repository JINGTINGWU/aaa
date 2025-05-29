<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
class Routine_model extends CI_Model
{
    //喔喔喔
    //game-是否要執行的一次…
    var $file_path='';
	var $http_path='';
    //var $db='';
    var $main_tb='routine_schedule';
    var $main_key='zrs_id';
    var $main_mark='zrs_isactive';
	var $exetype_span=1;
	var $exetype_daily=2;

    
    function __construct()
    {   global $_G;
		//$this->file_path=$_SERVER['DOCUMENT_ROOT'].'/pmstest/uploads/routine/';
		$this->file_path='uploads/routine/';
		log_message('info','file path:'.$this->file_path);
		$this->http_path='uploads/routine/';
        date_default_timezone_set('Asia/Taipei');
        parent::__construct();
    }

    function reset_routine()
    {   //重開機後的關掉狀態->當全為N時就是停止狀態
		$this->db->update($this->main_tb,array('zrs_exe_switch'=>'N','zrs_status'=>'N'));
    }
    
    function get_routine($key_id=0)
    {
		$routine=$this->db->where($this->main_key,$key_id)->get($this->main_tb)->result_array();
        return $routine[0]; //--
    }
    
    function get_next_exe_interval($key_id=0)
    {   //決定下次執行的時間窩-  
		$routine=$this->get_routine($key_id);
        switch($routine['zrs_exe_type']):
            case 1://span--
                $final=$routine['zrs_exe_timespan']*60;
            break;
            case 2://daily
                //計算到下次執行的間隔…
                $final=strtotime($routine['zrs_setchange_time'])-time();
            break;
            case 3: //指定日期的--
                //
            break;
            default://nono
                $final=3600;//1hour
            break;
        endswitch;
        return $final; //min
    }
	
	function get_setchange_time($key_id=0)
	{	//取得下次執行/變更的時間-
		$final='';//
		if(is_array($key_id)):
			$routine_data=$key_id;
		else:
			$routine_data=$this->get_routine($key_id);
		endif;
		
		$now_time=time();
		if(isset($routine_data['zrs_id'])):
			switch($routine_data['zrs_exe_type']):
				case $this->exetype_span:					
					$final=date('Y-m-d H:i:s',mktime(date('H',$now_time),date('i',$now_time)+$routine_data['zrs_exe_timespan'],date('s',$now_time),date('m',$now_time),date('d',$now_time),date('Y',$now_time)));	
					break;
				case $this->exetype_daily:
					//判斷有無超過本日的執行時間
					$today_exe=date('Y-m-d').' '.$routine_data['zrs_exe_dailytime'].':00';
					$test_time=strtotime($today_exe);
					if($now_time>$test_time){//find tomorrow
						//JS_Msg($today_exe);
						$final=date('Y-m-d H:i:s',mktime(date('H',$test_time),date('i',$test_time),date('s',$test_time),date('m',$test_time),date('d',$test_time)+1,date('Y',$test_time)));//
					}else{
						$final=$today_exe;
					}
					break;	
			endswitch;
			//
		endif;
		return $final;
	}
    
    function exe_routine_once($key_id=0)
    {   //
        $routine=$this->get_routine($key_id);
		log_message('info','exe_routine_once:'.$this->file_path.$routine['zrs_exe_file'].'.php');		
		if(file_exists($this->file_path.$routine['zrs_exe_file'].'.php')):
			require($this->file_path.$routine['zrs_exe_file'].'.php');
                        $next_time=$this->get_setchange_time($key_id);
			$this->update_routine_set($key_id,array('zrs_setchange_time'=>$next_time));
            log_message('info','exe_routine_once true '.$this->file_path.$routine['zrs_exe_file'].'.php');
            return true;
		else:
            log_message('info','exe_routine_once false '.$this->file_path.$routine['zrs_exe_file'].'.php');
			return false;
		endif;
    }
    
    function update_routine_set($key_id=0,$data=array())
    {   //
        if($key_id==0):
            //取empty_id
        else:
			//$this->CM->JS_Msg('@@@');
			$this->db->where($this->main_key,$key_id)->update($this->main_tb,$data);
        endif;
        //okok-
    }
	
	function exe_switch($key_id=0,$switch='N')
	{	global $_G;
		$routine_data=$this->get_routine($key_id);
		if(isset($routine_data[$this->main_key])):
			$this->switch_routine($key_id,$switch);//。
			switch($switch):
				case 'Y'://---!
					$this->status_routine($key_id,'Y');
					//更改下回執行時間= =
					$next_time=$this->get_setchange_time($key_id);
					$this->update_routine_set($key_id,array('zrs_setchange_time'=>$next_time));
					break;
				case 'N':
					$this->status_routine($key_id,'N');
					break;
			endswitch;
		endif;
	}
	//
    function switch_routine($key_id=0,$switch='N')
    {	
		$this->db->where($this->main_key,$key_id)->update($this->main_tb,array('zrs_exe_switch'=>$switch));
    }//
    
    function status_routine($key_id=0,$status='N')
    {   //
		$this->db->where($this->main_key,$key_id)->update($this->main_tb,array('zrs_status'=>$status));
    }
    
    function onexe_routine($key_id=0,$status='N')
    {   //
		$this->db->where($this->main_key,$key_id)->update($this->main_tb,array('zrs_on_exe'=>$status));
    }	
	
	function get_routine_empty_id()
	{	
		$result=$this->db->where($this->main_mark,'N')->order_by($this->main_key,'ASC')->limit(1,0)->get($this->main_tb)->result_array();
		if(count($result)>0):
			return $result[0][$this->main_key];
		else:
			return 0;
		endif;
	}//
	
	function get_field_info($id=0)
	{
        $final=array(
                'zrs_exe_timespan'=>array(
                        'call_name'=>'間隔時間(min)',
                        'type'=>'text',
						'pii'=>array('no')
                    ),
                'zrs_exe_dailytime'=>array(
                        'call_name'=>'每日執行時間',
                        'type'=>'text',
						'maxlength'=>5
                    ),
                'zrs_exe_file'=>array(
                        'call_name'=>'執行的檔名',
                        'type'=>'text'
                    ),
                'zrs_exe_switch'=>array(
                        'call_name'=>'執行開關',
                        'type'=>'select',
						'ld'=>array(array('id'=>'Y','value'=>'開啟'),array('id'=>'N','value'=>'關閉')),
						'ld_key'=>'id',
						'ld_value'=>'value'                
                    ),
                'zrs_title'=>array(
                        'call_name'=>'排程名稱',
                        'type'=>'text'             
                    ),
                'zrs_exe_type'=>array(
                        'call_name'=>'排程類別',
                        'type'=>'select',
                        'ld'=>array(array('id'=>$this->exetype_span,'value'=>'間隔時段'),array('id'=>$this->exetype_daily,'value'=>'每日定時')),
                        'ld_value'=>'value',
                        'ld_key'=>'id',
                        'full_selected'=>'N'
                    )
            );
     	$final=$id===0?$final:$final[$id];
        return $final;
	}
    
    function run_routine_process_once()
    {   //統一執行的-every min. 
		$routine_list=$this->db->where($this->main_mark,'Y')->where('zrs_exe_switch','Y')->get($this->main_tb)->result_array();
        foreach($routine_list as $value):
            //時間略超過時就執行。//
            if(strtotime($value['zrs_setchange_time'])<strtotime(date('Y-m-d H:i:s'))): 
                //exe. than change next_time.這種方式可以立刻停。不必等到下次-
				$this->db->insert('arrange_test',array('at_time'=>date('Y-m-d H:i:s'),'at_name'=>$value['zrs_setchange_time'].'----'.date('Y-m-d H:i:s').'--'.$value['zrs_title']));
				$this->onexe_routine($value[$this->main_key],'Y');				
				
				$this->exe_routine_once($value[$this->main_key]);
				$next_time=$this->get_setchange_time($value[$this->main_key]);
				$this->update_routine_set($value[$this->main_key],array('zrs_setchange_time'=>$next_time));
                
				$this->onexe_routine($value[$this->main_key],'N');
            endif;
        endforeach;
    }
	
	function single_setting_ac($ac='',$key='',$value='')
	{	$ss_tb='single_setting_list'; $ss_key='skey'; $ss_value='svalue';
		$final='';	//
		switch($ac):
			case 'update':
				$this->db->where($ss_key,$key)->update($ss_tb,array($ss_value=>$value));
				break;
			case 'get':
				$temp=$this->db->where($ss_key,$key)->get($ss_tb)->row();
				$final=$temp->$ss_value;
				break;
		endswitch;
		return $final;//
	}
	
	function sys_single_setting($ac='',$key='',$value='')
	{	$ss_tb='jec_setup'; $ss_key='noticetype'; $ss_value='value';
		$final='';	//
		switch($ac):
			case 'update':
				$this->db->where($ss_key,$key)->update($ss_tb,array($ss_value=>$value));
				break;
			case 'get':
				$temp=$this->db->where($ss_key,$key)->get($ss_tb)->row();
				$final=$temp->$ss_value;
				break;
		endswitch;
		return $final;//
	}
	
	function full_reset_changetime()
	{	//
		$routine_list=$this->db->where($this->main_mark,'Y')->where('zrs_exe_switch','Y')->get($this->main_tb)->result_array();
		foreach($routine_list as $value):
			$next_time=$this->get_setchange_time($value[$this->main_key]);
			$this->update_routine_set($value[$this->main_key],array('zrs_setchange_time'=>$next_time));
		endforeach;//
	}
	
	function close_exe_status()
	{
		$this->db->update($this->main_tb,array('zrs_on_exe'=>'N'));
	}
	
	function get_ap_min()
	{
		$data=$this->db->where('noticetype','AP')->where('isactive','Y')->get('jec_setup')->result_array();
		return $data[0]['value'];
	}
	
	function update_ap_nt($time='')
	{
		$this->db->where('noticetype','AT')->where('isactive','Y')->update('jec_setup',array('value'=>$time));
	}
}



?>