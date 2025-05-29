<?php
global $_G;
if(!isset($df_ip))  $df_ip=array();

foreach($df_array as $value):
    if(isset(${$value})){
        $df_ip[$value]=${$value};  
    } 
endforeach;

if($this->CM->InStr($df_ip['ot'],'-')):
	//if((int)$this->CM->GetString($df_ip['ot'],'-','')>0):
		$df_ip['pp']=(int)$this->CM->GetString($df_ip['ot'],'-','');
	//endif;
	$df_ip['ot']=$this->CM->GetString($df_ip['ot'],'','-');
endif;

if((int)$df_ip['pp']<0) $df_ip['pp']=10;
if(substr($df_ip['ac'],strlen($df_ip['ac'])-7)=='noplate'):
    $ori_ac=str_replace("_noplate","",$df_ip['ac']);
    $df_ip['ac']=$ori_ac;$ac=$ori_ac;
    $_G['noplate']='Y';
endif;
//chinfo

//if(isset($df_ip['chinfo'])) $df_ip['chinfo']=base64_decode($df_ip['chinfo']);
?>