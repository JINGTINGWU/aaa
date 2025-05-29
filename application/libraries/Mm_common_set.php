<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Mm_common_set
{
    var $mm_mselected_on='mm_mselected_on';
	var $mm_mselected_off='mm_mselected_off';
	var $conparetype_info=array(
			1=>'',
			2=>' >=',
			3=>' <=',
			4=>' >',
			5=>' <'
		);
	var $resda020_info=array(
			0=>'-',
			1=>'未傳送',
			2=>'簽核中',
			3=>'已簽核',
			4=>'已抽單'
		);
 	var $resda021_info=array(
			0=>'-',
			1=>'未完成',
			2=>'同意',
			3=>'不同意',
			4=>'已抽單'
		);   			
	public function __construct()
	{   global $_G;
		$this->ci =& get_instance();
		$this->load_mm_td();
	}
	
	function load_mm_td()
	{   global $_G;
	    $this->mm_td=array(      
				'def'=>array()
		    );
	}
	
	function set_tr_on_off()
	{
		//return " onmouseover=\"mmm_tr_ac('on',this)\" onmouseout=\"mmm_tr_ac('off',this)\" ";
	}

    
    function common_use_ld($tag='')
    {
        $info=array(
                'projtype'=>array(
                        array('id'=>1,'name'=>'標案'),
                        array('id'=>2,'name'=>'專案')
                    ),
				'tendertype'=>array(
                        array('id'=>1,'name'=>'物料標'),						
                        array('id'=>2,'name'=>'工程物料標'),
						array('id'=>3,'name'=>'DMA工程標'),
						array('id'=>4,'name'=>'勞務標')
                    ),
                'projstatus'=>array(
                        array('id'=>1,'name'=>'得標前/專案準備'),   
                        array('id'=>2,'name'=>'得標後/專案開展'),
                        array('id'=>3,'name'=>'未得標'),
                        array('id'=>4,'name'=>'廢標/專案取消'),
                        array('id'=>5,'name'=>'標案暫停/專案暫停'),
                        array('id'=>6,'name'=>'得標結案/專案結案')          
                    ),
                'jobtype'=>array(
                        array('id'=>1,'name'=>'逐項完成'),
                        array('id'=>2,'name'=>'一起完成')    
                    ),
                'tasktype'=>array(
                        array('id'=>1,'name'=>'工作準備'),
                        array('id'=>2,'name'=>'工作開展'),
                       // array('id'=>3,'name'=>'移轉他人'),
                        array('id'=>4,'name'=>'工作廢止'),
                        array('id'=>5,'name'=>'工作暫停'),
                        array('id'=>6,'name'=>'工作完成')    
                    ),
                'prodtype'=>array( //料品類別
                        array('id'=>1,'name'=>'採購'),
                        array('id'=>2,'name'=>'生產'),
                        array('id'=>3,'name'=>'領用'),
                        array('id'=>4,'name'=>'委外'),
                        array('id'=>5,'name'=>'勞務'),
                        array('id'=>8,'name'=>'開放'),
                        array('id'=>9,'name'=>'工作明細')    
                    ),
                'phrasetype'=>array( //
                        array('id'=>1,'name'=>'共用'),
                        array('id'=>2,'name'=>'專屬')  
                    ),
                'noticetype'=>array( //通知狀態
                        array('id'=>1,'name'=>'待辦工作通知'),
                        array('id'=>2,'name'=>'逾期工作通知'),
                        array('id'=>3,'name'=>'系統警示通知'),
                        array('id'=>4,'name'=>'工作完成待確認'),
                        array('id'=>5,'name'=>'日期變更待確認'),
                        array('id'=>6,'name'=>'工作移轉待確認'),
                        array('id'=>7,'name'=>'無法完成待處理'),
						array('id'=>8,'name'=>'工作暫停待確認'),
						array('id'=>9,'name'=>'工作回復待確認'),
						array('id'=>10,'name'=>'督導人移轉待確認'),
						array('id'=>11,'name'=>'工作進度回報'),
						array('id'=>14,'name'=>'工作完成已確認'),
						array('id'=>15,'name'=>'日期變更已確認'),
						array('id'=>16,'name'=>'工作移轉已確認'),
						array('id'=>17,'name'=>'工作廢止已確認'),
						array('id'=>18,'name'=>'工作暫停已確認'),
						array('id'=>19,'name'=>'工作回復已確認'),
						array('id'=>20,'name'=>'督導人移轉已確認'),
						array('id'=>24,'name'=>'工作完成退回'),
						array('id'=>25,'name'=>'日期變更退回'),
						array('id'=>26,'name'=>'工作移轉退回'),
						array('id'=>27,'name'=>'無法完成退回'),
						array('id'=>28,'name'=>'工作暫停退回'),
						array('id'=>29,'name'=>'工作回復退回'),
						array('id'=>30,'name'=>'督導人移轉退回'),
						array('id'=>31,'name'=>'展期暨移轉待確認'),
						array('id'=>41,'name'=>'展期暨移轉已確認'),
						array('id'=>51,'name'=>'展期暨移轉退回'),
						array('id'=>'AA','name'=>'手動新增行事曆待辦工作')            
                    ),
				'cal_noticetype'=>array(
                        array('id'=>1,'name'=>'待辦工作通知'),
                        array('id'=>2,'name'=>'逾期工作通知'),
                        array('id'=>3,'name'=>'系統警示通知'),
                        array('id'=>4,'name'=>'工作完成待確認'),
                        array('id'=>5,'name'=>'日期變更待確認'),
                        array('id'=>6,'name'=>'工作移轉待確認'),
                        array('id'=>7,'name'=>'無法完成待處理'),
						array('id'=>8,'name'=>'工作暫停待確認'),
						array('id'=>9,'name'=>'工作回復待確認'),
						array('id'=>10,'name'=>'督導人移轉待確認'),
						array('id'=>11,'name'=>'工作進度回報'),
						array('id'=>14,'name'=>'工作完成已確認'),
						array('id'=>15,'name'=>'日期變更已確認'),
						array('id'=>16,'name'=>'工作移轉已確認'),
						array('id'=>17,'name'=>'工作廢止已確認'),
						array('id'=>18,'name'=>'工作暫停已確認'),
						array('id'=>19,'name'=>'工作回復已確認'),
						array('id'=>20,'name'=>'督導人移轉已確認'),
						array('id'=>24,'name'=>'工作完成退回'),
						array('id'=>25,'name'=>'日期變更退回'),
						array('id'=>26,'name'=>'工作移轉退回'),
						array('id'=>27,'name'=>'無法完成退回'),
						array('id'=>28,'name'=>'工作暫停退回'),
						array('id'=>29,'name'=>'工作回復退回'),
						array('id'=>30,'name'=>'督導人移轉退回'),
						array('id'=>31,'name'=>'展期暨移轉待確認'),
						array('id'=>41,'name'=>'展期暨移轉已確認'),
						array('id'=>51,'name'=>'展期暨移轉退回'),
						array('id'=>'AA','name'=>'手動新增行事曆待辦工作')	
					),//。
				'costtype'=>array(
                        array('id'=>1,'name'=>'售價定價一'),
                        array('id'=>2,'name'=>'售價定價二'),
                        array('id'=>3,'name'=>'售價定價三'),
                        array('id'=>4,'name'=>'售價定價四'),
                        array('id'=>5,'name'=>'售價定價五'),
                        array('id'=>6,'name'=>'售價定價六'),	
						array('id'=>6,'name'=>'業務底價')			
					),
				'select_type'=>array(
						array('id'=>'S','name'=>'選擇資料'),
						array('id'=>'K','name'=>'自行填寫')
					), 
				'processtype'=>array(
                        array('id'=>1,'name'=>'重要'),
                        array('id'=>2,'name'=>'正常'),
                        array('id'=>3,'name'=>'輔助')	
					),
				'confirmtype'=>array(
                        array('id'=>1,'name'=>'強制'),
                        array('id'=>2,'name'=>'自動'),
                        array('id'=>3,'name'=>'不需確認')		
					),
				'comparetype'=>array(
                        array('id'=>1,'name'=>'等於'),
                        array('id'=>2,'name'=>'大於等於')	,
						array('id'=>3,'name'=>'小於等於')	,
						array('id'=>4,'name'=>'大於'),
						array('id'=>5,'name'=>'小於'),
						array('id'=>6,'name'=>'包含'),
						array('id'=>7,'name'=>'開始包含'),
						array('id'=>8,'name'=>'結束包含')		
					)
				
            );
		if(strpos($_SERVER['REQUEST_URI'],"project_new_index"))
		{
			array_unshift($info['projtype'],array('id'=>0,'name'=>''));
			array_unshift($info['tendertype'],array('id'=>0,'name'=>''));
		}
		else if(strpos($_SERVER['REQUEST_URI'],"project_adjust_index"))
		{
			array_unshift($info['tendertype'],array('id'=>0,'name'=>''));
		}
        return isset($info[$tag])?$info[$tag]:array();
    }
    
    function common_url_ld($tag='')
    {
        $info=array(
                'cal'=>base_url().'tools/append/calendar/',
				'get_dept_by_saler'=>base_url().'ecp_common/get_dept_by_saler/',
				'get_purchase_list_by_dept'=>base_url().'ecp_common/get_purchase_list_by_dept/'
            );
        return isset($info[$tag])?$info[$tag]:'';
    }
        
}