<?php  if (!defined('BASEPATH')) exit('No direct script access allowed');

class Hscal
{   //日曆用的
    //ds->data_source   
    /*
    */
	public function __construct()
	{   global $_G;
		$this->ci =& get_instance();
	}  
	
	function cal_Feb_days($year=0)
	{
		$final=28;
		if($year%4==0) $final=29;
		if($year%100==0) $final=28;
		if($year%400==0) $final=29;	
		return $final;
	}   
	
	function cal_get_weeknum($sed=array())
	{	
		//echo '<br><br><br><br>'.$sed['sd'];
		$final['start_w']=date("w",strtotime($sed['sd']." 00:00:00")); $final['end_w']=date("w",strtotime($sed['ed']." 00:00:00"));
		$end_W=date("W",strtotime($sed['ed']." 00:00:00"));
		$start_W=date("W",strtotime($sed['sd']." 00:00:00"));
		if(date("m",strtotime($sed['ed']." 00:00:00"))==12):
			$end_W=date("W",mktime(0,0,0,12,24,substr($sed['ed'],0,4)))+1;	
		endif;
		/*
		if(date("m",strtotime($sed['sd']." 00:00:00"))==1):
			$start_W=1;	
		endif;*/
		//有bug...
		if($start_W>$end_W):
			$week_num=$end_W+1;
			$start_W=1;
		else:
			$week_num=$end_W-$start_W+1;
		endif;
		
		
		
		//if($final['start_w']==0) $week_num-=1;
		//if($final['end_w']==0) $week_num+=1;
		$final['week_num']=$week_num;
		$final['end_W']=$end_W;
		$final['start_W']=$start_W;
		//if_Sun->7
		//if($final['start_w']==0) $final['start_w']=7;
		return $final;
	} 

	function cal_get_sed($type="ws",$today=0)
	{	//get start/end date
		
		$ed_info=array(1=>31,2=>array('sd'=>28,'ed'=>29),3=>31,4=>30,5=>31,6=>30,7=>31,8=>31,9=>30,10=>31,11=>30,12=>31);
		$today=$today===0?date("Y-m-d"):$today;
		$final['sd']=$final['ed']=$today;
		$today_w=date("w",strtotime($today." 00:00:00"));
		$mon=date("m",strtotime($today." 00:00:00"))*1;
		$day=date("d",strtotime($today." 00:00:00"));
		$year=date("y",strtotime($today." 00:00:00"));
		switch($type):
			case 'ws'://Sunday
				//0->6
				$s_days=$today_w;
				$e_days=6-$today_w;
				$final['sd']=date('Y-m-d',mktime(0,0,0,$mon,$day-$s_days,$year));
				$final['ed']=date('Y-m-d',mktime(0,0,0,$mon,$day+$e_days,$year));				
				//0 (for Sunday) through 6 (for Saturday)
			break;
			case 'wm': //Monday-
				if($today_w==0):
					$s_days=6;
					$e_days=0;
				else:
					$s_days=$today_w-1;
					$e_days=7-$today_w;
				endif;
				$final['sd']=date('Y-m-d',mktime(0,0,0,$mon,$day-$s_days,$year));
				$final['ed']=date('Y-m-d',mktime(0,0,0,$mon,$day+$e_days,$year));
				//echo $final['sd']."-".$final['ed'];
			break;
			case 'm':
				$final['sd']=substr($today,0,8)."01";
				//$mon=substr($today,5,2)*1;
				if(is_array($ed_info[$mon])):
					$final['ed']=substr($today,0,8).$this->cal_Feb_days(substr($today,0,4));
				else:
					$final['ed']=substr($today,0,8).$ed_info[$mon];
				endif;
			break;
			case 'd':
				$final['sd']=$today;
				$final['ed']=$today;
			break;
		endswitch;
		return $final;//
	}
	
	function get_mon_wsed($sed=array(),$wtype='wm')
	{	//取得 月份顯示的實際起始結束日
		 
		$fw=$this->cal_get_sed($wtype,$sed['sd']);
		$lw=$this->cal_get_sed($wtype,$sed['ed']);
		$final=array(
				'sd'=>$fw['sd'],
				'ed'=>$lw['ed']
			);
		return $final;
	}
	
	function get_days($sed=array())
	{	
		$span=strtotime($sed['ed'].' 00:00:01')-strtotime($sed['sd'].' 00:00:00');
		$days=($span/3600)/24 ; 
		return ceil($days);
	}
   
}