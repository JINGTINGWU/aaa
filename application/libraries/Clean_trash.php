<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
/*
清除垃圾暫存檔物件
*/
class Clean_trash
{
    var $dir_root;  //資料夾
	var $db;//not necessary
	var $keep_dir=array(); //不能刪的資料夾
	var $keep_file=array();  //不能刪的檔名
	var $time_period=200000;  //時間差/191371-約兩天
	var $file_pre_fix=""; //只刪除包含此字串的檔案
	var $sys_dir=array("emsproj",'temp_save','uploads');  //寫死的保護資料夾
	
	function __construct(){
	    //$this->db=$db; //起始就載入db物件
	}
	function del($dir_root){
	    $file_list=scandir($dir_root);
		
        foreach($file_list as $value){
		    if($value!="."&&$value!=".."){
		        if(is_dir($dir_root.$value)){
				    if(in_array($value,$this->keep_dir)==false&&in_array($value,$this->sys_dir)==false){
					    $this->del($dir_root.$value."/");
						@rmdir($dir_root.$value."/");
					}   
			    }else{
				    if(in_array($value,$this->keep_file)==false){
					    $time_cut=(time()-filemtime($dir_root.$value));
					    if($time_cut>$this->time_period){
						    if($this->file_pre_fix==""){
							    @unlink($dir_root.$value);
							}else{
							    if(str_replace($this->file_pre_fix,"",$value)!=$value){
								    @unlink($dir_root.$value);
								}
							}						    
						}
					}  
			    }
			}
		}
		if($dir_root==$this->dir_root&&in_array($dir_root,$this->keep_dir)==false&&in_array($value,$this->sys_dir)==false){
		    @rmdir($dir_root);
		}		
	}		
}
//以下為使用範例
/*
$test=new trash();
$test->keep_dir=array("test_del/","unaworking","obamboo_work","myweb","disk","etype_work","interview");
$test->keep_file=array("DSCN1829x.JPG");
$test->time_period=1;
$test->dir_root="test_del/";
$test->del("test_del/");*/
?>