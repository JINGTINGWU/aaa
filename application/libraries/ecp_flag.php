<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Ecp_flag
{
    protected $ci;
    
	public function __construct()
	{
		$this->ci =& get_instance();
	}
    
	// 回傳任務特性
	function get_jobtype($jobtype)
	{
		$result = '';
		switch ($jobtype)
		{
			case '1': $result = '工作項目需逐項完成'; break;
			case '2': $result = '所有工作項目可一起完成'; break;
			default: $result = '未定義:'.$jobtype; break;
		}
		return $result;
	}
	
	// 回傳工作類別
	function get_tasktype($tasktype)
	{
		$result = '';
		switch ($tasktype)
		{
			case '1': $result = '行政'; break;
			case '2': $result = '採購'; break;
			case '3': $result = '生產'; break;
			case '4': $result = '領用'; break;
			case '5': $result = '施工'; break;
			default: $result = '未定義:'.$tasktype; break;
		}
		return $result;
	}
	
	// 回傳工作處理原則
	function get_processtype($processtype)
	{
		$result = '';
		switch ($processtype)
		{
			case '1': $result = '重要'; break;
			case '2': $result = '正常'; break;
			case '3': $result = '輔助'; break;
			default: $result = '未定義:'.$processtype; break;
		}
		return $result;
	}
	
	// 回傳工作確認方式
	function get_confirmtype($confirmtype)
	{
		$result = '';
		switch ($confirmtype)
		{
			case '1': $result = '強制'; break;
			case '2': $result = '自動'; break;
			case '3': $result = '不需確認'; break;
			default: $result = '未定義:'.$confirmtype; break;
		}
		return $result;
	}
	
	// 回傳工作檢核方式
	function get_checktype($checktype)
	{
		$result = '';
		switch ($checktype)
		{
			case '1': $result = '開始前'; break;
			case '2': $result = '完成前'; break;
			default: $result = '未定義:'.$checktype; break;
		}
		return $result;
	}
	
	// 回傳料品類別
	function get_prodtype($prodtype)
	{
		$result = '';
		switch ($prodtype)
		{
			case '1': $result = '採購'; break;
			case '2': $result = '生產'; break;
			case '3': $result = '領用'; break;
			case '4': $result = '委外'; break;
			case '5': $result = '勞務'; break;
			case '8': $result = '開放'; break;
			case '9': $result = '工作明細'; break;
			default: $result = '未定義:'.$prodtype; break;
		}
		return $result;
	}
	
	// 回傳參數設定中的參數類型
	function get_noticetype($noticetype)
	{
		$result = '';
		switch ($noticetype)
		{
			case '01': $result = '待辦工作通知內容'; break;
			case '02': $result = '逾期工作通知內容'; break;
			case '03': $result = '系統警示通知內容'; break;
			case '04': $result = '工作完成待確認通知內容'; break;
			case '05': $result = '日期變更待確認通知內容'; break;
			case '06': $result = '工作移轉待確認通知內容'; break;
			case '07': $result = '無法完成待處理通知內容'; break;
			case '08': $result = '工作暫停待確認通知內容'; break;
			case '09': $result = '工作回復待確認通知內容'; break;
			case '10': $result = '督導人移轉待確認通知內容'; break;
			case '14': $result = '工作完成已確認通知內容'; break;
			case '15': $result = '日期變更已確認通知內容'; break;
			case '16': $result = '工作移轉已確認通知內容'; break;
			case '17': $result = '工作廢止已確認通知內容'; break;
			case '18': $result = '工作暫停已確認通知內容'; break;
			case '19': $result = '工作回復已確認通知內容'; break;
			case '20': $result = '督導人移轉已確認通知內容'; break;
			case '24': $result = '工作完成退回通知內容'; break;
			case '25': $result = '日期變更退回通知內容'; break;
			case '26': $result = '工作移轉退回通知內容'; break;
			case '27': $result = '無法完成退回通知內容'; break;
			case '28': $result = '工作暫停退回通知內容'; break;
			case '29': $result = '工作回復退回通知內容'; break;
			case '30': $result = '督導人移轉退回通知內容'; break;
			case '31': $result = '展期暨移轉待確認通知內容'; break;
			case '41': $result = '展期暨移轉已確認通知內容'; break;
			case '51': $result = '展期暨移轉退回通知內容'; break;
			case 'AA': $result = '手動新增行事曆待辦工作'; break;
			case 'AP': $result = '定時程式執行間隔時間(分鐘)'; break;
			case 'AT': $result = '下次定時程式預計執行的時間'; break;
			case 'AS': $result = '定時程式是否執行中'; break;
			case 'AW': $result = '定時程式是否要執行'; break;
			case 'BA': $result = '逾期後自動通知承辦人(或群組)的天數'; break;
			case 'BB': $result = '逾期後自動通知部門主管的天數'; break;
			case 'BC': $result = '逾期後自動通知上級主管的天數'; break;
			case 'BD': $result = '逾期後自動通知最高主管的天數'; break;
			case '90': $result = '專案工作尚未分派通知內容'; break;
			case 'CA': $result = '專案得標開展後，在多少天數內必須將所有的工作項目都分派出去'; break;
			case 'OS': $result = '主機作業系統：WIN/LINUX'; break;
			case '11': $result = '工作進度回報通知內容'; break;
			case '12': $result = '開始前工作檢核通知'; break;
			case '13': $result = '完成前工作檢核通知'; break;
			case 'EM': $result = '通知信件寄件人電子郵件'; break;
			case 'EN': $result = '通知信件寄件人名稱'; break;
			case 'ES': $result = '郵件主機'; break;
			case 'ET': $result = '郵件主機PORT'; break;
			case 'EU': $result = '郵件主機帳號'; break;
			case 'EV': $result = '郵件主機密碼'; break;
			case 'EW': $result = '費用異常拋轉「聯絡單簽呈」草稿的工號'; break;
			default: $result = '未定義:'.$noticetype; break;
		}
		return $result;
	}
}