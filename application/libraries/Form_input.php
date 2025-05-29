<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Form_input
{   
    var $fi_show_msg='Y';
    var $fi_js_ac=array('onclick','onfocus','onblur','onchange','onmouseover','onmouseout','onkeydown','onkeyup');
    var $fi_cm_p=array('title','style','class','id','name'); //common property
    var $fi_ds=array();
    var $fi_pii_var=array('ne','no','nod','tne','not','noam'); //防呆的類別
    var $fi_spec_p=array('disabled','readonly');
    //ds->data_source   
    /*
	#DESIGN BY UNA
    #type
    #ld list_data->適用select
    #sd source_data
    #tf target_field
    #id
    #name
    #onclick/onfocus/onblur/onmouseover/onmouseout
    #pii prevent illegal input
    #class
    #disabled
    #maxlength....
    #dfv default value->預設值->無值時預設->待補
    #err_msg 錯誤時要展示的訊息
    #show_msg Y/N
    #title
    #call_name ->欄位名稱 
    #on ->當下value  check使用
    */
	public function __construct()
	{   global $_G;
		$this->ci =& get_instance();
	}      

    function temp_hidden_string($array='',$info=array())
    {   //both name & id
        $final='';
        foreach($array as $value):
            $pre_tag=isset($info['post_pre_tag'])?$info['post_pre_tag']:'';
            $eip['id']=$pre_tag.$value;            
            $eip['sd']=isset($_POST[$pre_tag.$value])?$_POST[$pre_tag.$value]:'';
            $eip['call_name']='';
            $eip['type']='hidden';
            $final.=$this->fi_get_input($eip);
        endforeach;
        return $final;
    }
    
    function fi_get_input($ds=array())
    {   $final='';
		
        if(!isset($ds['sd'])) $ds['sd']='';
        if(!isset($ds['name'])) $ds['name']=$ds['id'];   //無name ，指派id
        if(!isset($ds['tf'])) $ds['tf']=$ds['name'];   //無欄位值，指派name
        $this->fi_ds=$ds;
		
        if(isset($ds['type'])):
            switch($ds['type']):
                case 'text':
                    $final=$this->fi_get_text_input();
                break;
                case 'radio':
					$final=$this->fi_get_radio_input();
                break;
				case 'mradio':
					$final=$this->fi_get_mradio_input();
				break;
				case 'file':
					$final=$this->fi_get_file_input();
				break;
                case 'setdate':
                    $final=$this->fi_get_setdate_input();
                break;
                case 'select':
                    $final=$this->fi_get_select_input();
                break;
                case 'mselect'://結果值為陣列
                    $final=$this->fi_get_mselect_input();
                break;
                case 'textarea':
                    $final=$this->fi_get_textarea_input();
                break;
                case 'hidden':
                    $final=$this->fi_get_hidden_input();
                break;
                case 'password':
                    $final=$this->fi_get_password_input();
                break;
                case 'checkbox':
                    $final=$this->fi_get_checkbox_input();
                break;
                case 'mcheckbox':
                    $final=$this->fi_get_mcheckbox_input();
                break;                
            endswitch;
        endif;
        //clean
        
        return $final;
    }
    
    function fi_get_pii($type)
    {   $final='';
        /*?><meta http-equiv="Content-Type" content="text/html; charset=utf-8" /><?php */
        switch($type):
            case 'ne': //not empty
                $err_msg='';
                if($this->fi_show_msg=='Y'):
                    switch($this->fi_ds['type']):
                        case 'select':
                            $err_msg='請選擇 '.$this->fi_ds['call_name'].' 。';
                        break;
                        default:
                            $err_msg='欄位 '.$this->fi_ds['call_name'].' 不可空白。';
                        break;
                    endswitch;
                endif;
                $final="fi_ne('".$this->fi_ds['id']."','".$err_msg."');";
            break;
            case 'no':  //number only
                //$final="fi_no('".$this->fi_ds['id']."');";
                $final="fi_no(this);";
            break;
            case 'nod':  //number only
                //$final="fi_nod('".$this->fi_ds['id']."');";
                $final="fi_nod(this);";
            break;  
            case 'not':  //number only
                $final="fi_not(this);";
            break; 
            case 'tne':  //number only
                $final="fi_tne(this,'欄位 ".$this->fi_ds['call_name']." 不可空白。');";
            break;   
			case 'noam':
				$final="fi_noam(this);";
			break;     
        endswitch;
        return $final;
    }
    //加油吧。把這物件趕出來。應該會有不錯的效果^^
    
    function fi_get_fv($type='',$value='')
    {   $final='';
        switch($type):
            case 'X1':
                $final=$value*1;
            break;
        endswitch;        
        return $final;
    }
    function fi_get_property_string($array=array())
    {   $final=' ';
        foreach($array as $value):
            if(isset($this->fi_ds[$value])):
                $final.=$value.'="'.$this->fi_ds[$value].'" ';
            endif;
        endforeach;
        return $final;
    }
    
    function fi_get_spec_property_string()
    {   $final=" ";
        if(isset($this->fi_ds['disabled'])&&$this->fi_ds['disabled']=='Y'):
            $final.="disabled ";
        endif;
        if(isset($this->fi_ds['readonly'])&&$this->fi_ds['readonly']=='Y'):
            $final.="readonly ";
        endif;
        return $final;        
    }
    
    function fi_do_all_property_string($own_array=0)
    {   $final=" ";
        $final.=$this->fi_get_property_string($this->fi_cm_p);
        $final.=$this->fi_get_property_string($this->fi_js_ac);        
        if(is_array($own_array)) $final.=$this->fi_get_property_string($own_array);
        return $final;
    }  
    
    function fi_pii_add($type=array())
    {   //防呆+原有的
        foreach($this->fi_pii_var as $value):
            if(isset($this->fi_ds['pii'])&&in_array($value,$this->fi_ds['pii'])):
                foreach($type as $vv):
                    if(isset($this->fi_ds[$vv]))
                    {
                        $this->fi_ds[$vv]=$this->fi_get_pii($value).$this->fi_ds[$vv];
                    }
                    else
                    {
                        $this->fi_ds[$vv]=$this->fi_get_pii($value);
                    }
                endforeach;                
            endif;        
        endforeach;
    }
 	function fi_get_file_input()
    {   
		$ori_id=$this->fi_ds['id'];
        //$this->fi_pii_add(array("onclick"));
		if($this->fi_ds['up_type']=='m'):
			$this->fi_ds['id']=$this->fi_ds['id']."ZZZ1";
			$this->fi_ds['name']=$this->fi_ds['id'];
		endif;
		$final='<div id="filediv_'.$this->fi_ds['id'].'">';
        if($this->fi_ds['up_type']=='m'):
            $final.='<input type="hidden" id="'.$ori_id.'_ti" name="'.$ori_id.'_ti" value="1">';
        endif;
		
		 
        $final.='<input type="file" ';
		if(isset($this->fi_ds['filetype'])&&$this->fi_ds['filetype']!='') $this->fi_ds['onchange'].="CheckFileType('".$this->fi_ds['id']."','".$this->fi_ds['filetype']."','','".$this->fi_ds['up_type']."')";
		
        //$own_array=array('cols','rows');
        $final.=$this->fi_do_all_property_string();
        $final.=$this->fi_get_spec_property_string();
        $e_value="";       
        $final.=' ></div>';//<a style="cursor:pointer;" onclick="CleanFile(\''.$this->fi_ds['id'].'\',\'\');" title="清除" class="mm_clean_file">x</a>
        
        return $final;
    }     
    function fi_get_text_input()
    {   $final='';
        $this->fi_pii_add(array("onblur"));
        $final.='<input type="text" ';
        $own_array=array('maxlength','size');
        $final.=$this->fi_do_all_property_string($own_array);
        $final.=$this->fi_get_spec_property_string();
        $e_value="";
        if(isset($this->fi_ds['sd'])) $e_value=is_array($this->fi_ds['sd'])?$this->fi_ds['sd'][$this->fi_ds['tf']]:$this->fi_ds['sd'];
        if(isset($this->fi_ds['get_fv'])):
            if(is_array($this->fi_ds['get_fv'])):
                foreach($this->fi_ds['get_fv'] as $gfv):
                    $e_value=$this->fi_get_fv($gfv,$e_value);   
                endforeach;
            else:
                $e_value=$this->fi_get_fv($this->fi_ds['get_fv'],$e_value);
            endif;
        endif;
        
        $final.=' value="'.$e_value.'" ';
        $final.=' />';
        return $final;
    }
    
    function fi_get_password_input()
    {   $final='';
        $this->fi_pii_add(array("onblur","onchange"));
        $final.='<input type="password" ';
        $own_array=array('maxlength');
        $final.=$this->fi_do_all_property_string($own_array);
        $final.=$this->fi_get_spec_property_string();
        $e_value="";
        if(isset($this->fi_ds['sd'])) $e_value=is_array($this->fi_ds['sd'])?$this->fi_ds['sd'][$this->fi_ds['tf']]:$this->fi_ds['sd'];
        $final.=' value="'.$e_value.'" ';
        $final.=' />';
        
        return $final;
    }    
    
    function fi_get_hidden_input()
    {   $final='';
        //$this->fi_pii_add(array("onblur"));
        $final.='<input type="hidden" ';
        $final.=$this->fi_get_property_string($this->fi_cm_p);
        $e_value="";
        if(isset($this->fi_ds['sd'])) $e_value=is_array($this->fi_ds['sd'])?$this->fi_ds['sd'][$this->fi_ds['tf']]:$this->fi_ds['sd'];
        $final.=' value="'.$e_value.'" ';
        $final.=' />';
        
        return $final;
    }
    
    function fi_var_adjust($name='')
    {   
        switch($name):
            case 'ld':
                if(!is_array($this->fi_ds['ld'])):
                    //變成array
                    $mm_set=$this->ci->CM->GetString($this->fi_ds['ld'],"","@");
                    $type=$this->ci->CM->GetString($this->fi_ds['ld'],"@","");
                    $mm_set=$this->ci->CM->Init_TB_Set($mm_set);
                    $con=isset($this->fi_ds['ld_con'])?$this->fi_ds['ld_con']:array();
                    $final=$this->ci->GM->common_ac('list',array('info'=>$mm_set['mm_set'],'type'=>$type,'data'=>$con));
                    $this->fi_ds['ld']=$final;
                endif;
            break;
        endswitch;
    }  
    
    function fi_get_mselect_input()
    {   $final=array();
        //還是產生一個就好…
        //sd為已選的/ld為目標list/ ld_key與ld_value應相同即可/不需除錯/s
        //分兩個值s與t
        if(isset($this->fi_ds['mselected'])&&is_array($this->fi_ds['mselected'])):
            $mselected=$this->fi_ds['mselected'];
        else:
            $mselected=array();//已選的
            if(isset($this->fi_ds['sd'])&&is_array($this->fi_ds['sd'])):
                foreach($this->fi_ds['sd'] as $value):
                    array_push($mselected,$value[$this->fi_ds['ld_key']]);
                endforeach;
            endif;        
        endif;

        $final='<select multiple="multiple" ';
        $own_array=array('');
        $final.=$this->fi_do_all_property_string($own_array);
        $final.=$this->fi_get_spec_property_string();
        $final.='>';
        $e_op="";
        $e_o=0;
        if(isset($this->fi_ds['ld'])):
            $this->fi_var_adjust('ld');
            foreach($this->fi_ds['ld'] as $value):
                $e_o++;
                $e_op.='<option value="'.$value[$this->fi_ds['ld_key']].'" ';
                $e_op.=' id="'.$this->fi_ds['id'].'_'.$e_o.'" ';
                $e_op.=$e_o==1?' selected ':'';
                if(in_array($value[$this->fi_ds['ld_key']],$mselected)):
                    if(isset($this->fi_ds['ld_on_class'])):
                        $e_op.=' class="'.$this->fi_ds['ld_on_class'].'" ';
                    endif;                
                else:
                    if(isset($this->fi_ds['ld_off_class'])):
                        $e_op.=' class="'.$this->fi_ds['ld_off_class'].'" ';
                    endif;                 
                endif;
                $e_op.='>'.$value[$this->fi_ds['ld_value']].'</option>';
                
            endforeach;
        endif;
        $final.=$e_op;
        $final.='</select>';  
        if(isset($this->fi_ds['no_header'])&&$this->fi_ds['no_header']=='Y'):
            return $e_op;
        else:
            return $final;
        endif;                       
        
    } 
    
    function fi_get_select_input()
    {   global $_G; $final='';
        
        $ip_dl_exclude=isset($this->fi_ds['ip_dl_exclude'])?$this->fi_ds['ip_dl_exclude']:array();
        //$ip_dl_exclude=isset($_G['ip_dl_exclude'])?$_G['ip_dl_exclude']:array();
        
        
        $this->fi_pii_add(array("onblur"));
        $final.='<select ';
        $own_array=array('');
        $final.=$this->fi_do_all_property_string($own_array);
        $final.=$this->fi_get_spec_property_string();
        $e_value="";
        if(isset($this->fi_ds['sd'])) $e_value=is_array($this->fi_ds['sd'])?$this->fi_ds['sd'][$this->fi_ds['tf']]:$this->fi_ds['sd'];        
        if(isset($this->fi_ds['full_selected'])&&$this->fi_ds['full_selected']=='N'):
            $e_op='';
        else:
			$e_op_msg=isset($this->fi_ds['ld_choose_msg'])?$this->fi_ds['ld_choose_msg']:'--請選擇--';
            $e_op='<option value="" selected>'.$e_op_msg.'</option>';
        endif;
       
        if(isset($this->fi_ds['sd'])) $e_value=is_array($this->fi_ds['sd'])?$this->fi_ds['sd'][$this->fi_ds['tf']]:$this->fi_ds['sd'];
        $final.='>';
        //ld_key/ld_value->1 or array('pre<v>value</v>end','value')
		$ld_key_span=isset($this->fi_ds['ld_key_span'])?$this->fi_ds['ld_key_span']:'-';
		
        $this->fi_var_adjust('ld');
        foreach($this->fi_ds['ld'] as $value):
            
			if(is_array($this->fi_ds['ld_key'])):
				$ei_key='';
				foreach($this->fi_ds['ld_key'] as $ldkey_no=>$ldkey_value):
					if($ldkey_no>0) $ei_key.=$ld_key_span;
					$ei_key.=$value[$ldkey_value];
				endforeach;
			else:
				$ei_key=$value[$this->fi_ds['ld_key']];
			endif;
			
            if(is_array($this->fi_ds['ld_value']))
            {
                $ei_value="";
                foreach($this->fi_ds['ld_value'] as $vv):
                    if($this->ci->CM->GetTV($vv,'v')=='')
                    {
                        $ei_value.=$value[$vv]." ";
                    }
                    else
                    {
                        $ei_vf=$this->ci->CM->GetTV($vv,'v');                    
                        $ei_value.=str_replace("<v>".$ei_vf."</v>",$value[$ei_vf],$vv);
                    }                
                endforeach;
            }
            else
            {
                if($this->ci->CM->GetTV($this->fi_ds['ld_value'],'v')=='')
                {
                    $ei_value=$value[$this->fi_ds['ld_value']];
                }
                else
                {
                    $ei_vf=$this->ci->CM->GetTV($this->fi_ds['ld_value'],'v');                    
                    $ei_value=str_replace("<v>".$ei_vf."</v>",$value[$ei_vf],$this->fi_ds['ld_value']);
                }
            }

            if(!in_array($ei_key,$ip_dl_exclude)):
                if(isset($this->fi_ds['sd_opid'])&&$this->fi_ds['sd_opid']=='Y'):
                    $ei_select=$value[$this->fi_ds['ld_opid']]==$e_value?'selected':'';
                else:
                    $ei_select=$ei_key==$e_value?'selected':'';
                endif;
                
                $e_op.='<option value="'.$ei_key.'" '.$ei_select.'>'.$ei_value.'</option>';
            endif;
        endforeach;
        $final.=$e_op;
        $final.='</select>';        
        if(isset($this->fi_ds['only_list'])&&$this->fi_ds['only_list']=='Y') $final=$e_op;
        return $final;
    }

 	function fi_get_textarea_input()
    {   $final='';
        $this->fi_pii_add(array("onblur"));
        $final.='<textarea ';
        $own_array=array('cols','rows');
        $final.=$this->fi_do_all_property_string($own_array);
        $final.=$this->fi_get_spec_property_string();
        $e_value="";
        if(isset($this->fi_ds['sd'])) $e_value=is_array($this->fi_ds['sd'])?$this->fi_ds['sd'][$this->fi_ds['tf']]:$this->fi_ds['sd'];
        $final.='>'.$e_value;
        $final.='</textarea>';
        
        return $final;
    }
    
 	function fi_get_checkbox_input()
    {   $final='';
        //$this->fi_pii_add(array("onclick"));
        $final.='<input type="checkbox" ';
        //$own_array=array('cols','rows');
        $final.=$this->fi_do_all_property_string();
        $final.=$this->fi_get_spec_property_string();
        $e_value="";
        if(isset($this->fi_ds['sd'])) $e_value=is_array($this->fi_ds['sd'])?$this->fi_ds['sd'][$this->fi_ds['tf']]:$this->fi_ds['sd'];
        if(isset($this->fi_ds['on'])) $final.=$e_value==$this->fi_ds['on']?'checked':'';        
        $final.=' value="'.$this->fi_ds['on'].'"> '.$this->fi_ds['call_name'];
        
        return $final;
    } 
    function fi_get_mcheckbox_input()
    {   $final='';
		$this->fi_var_adjust('ld');
        //on->array()/
		//tag_value=''//pre_tag/su_tag
		$pre_label=isset($this->fi_ds['pre_label'])?$this->fi_ds['pre_label']:'';
		$sur_label=isset($this->fi_ds['sur_label'])?$this->fi_ds['sur_label']:'';
        $fix_id=$this->fi_ds['id'];
        $on_array=$this->fi_ds['on'];
		foreach($this->fi_ds['ld'] as $no=>$value)://
			$e_ip=$this->fi_ds;
			$e_ip['on']=$value[$this->fi_ds['ld_key']];
			if(isset($this->fi_ds['tag_value'])&&$this->fi_ds['tag_value']!='') $e_ip['on']=GetTV($e_ip['on'],$this->fi_ds['tag_value']);
			$e_ip['call_name']=$value[$this->fi_ds['ld_value']];
			$e_ip['type']='checkbox';
            $e_ip['id']=$fix_id."_".$no;
            $e_ip['name']=$fix_id."_".$no;
            $e_ip['sd']='';
            if(in_array($e_ip['on'],$on_array)) $e_ip['sd']=$e_ip['on'];
            if((isset($this->fi_ds['no_on'])&&$this->fi_ds['no_on']=='Y')&&$e_ip['sd']==$e_ip['on']):
            else:
                $final.=$pre_label.$this->fi_get_input($e_ip).$sur_label;	
            endif;
					
		endforeach;  
		$final.='<input type="hidden" id="'.$fix_id.'_ti" name="'.$fix_id.'_ti" value="'.$no.'">';      
        return $final;
    }    
    function fi_get_setdate_input()
    {
        $e_value="";
        if(isset($this->fi_ds['sd'])) $e_value=is_array($this->fi_ds['sd'])?$this->fi_ds['sd'][$this->fi_ds['tf']]:$this->fi_ds['sd'];
        $e_value=$e_value==''?date("Y-m-d"):$e_value;
        $fix=array('y'=>substr($e_value,0,4),'m'=>substr($e_value,5,2),'d'=>substr($e_value,8,2));  
  
        $ip_array=array(
                array('tag'=>'y','sn'=>($fix['y']-10),'en'=>($fix['y']+10)),
                array('tag'=>'m','sn'=>1,'en'=>12),
                array('tag'=>'d','sn'=>1,'en'=>31)
            );
        $final='';$fix_id=$this->fi_ds['id'];    
        foreach($ip_array as $value):
            $eip=$this->fi_ds;
            $eip['full_selected']='N';
            $eip['ld_key']='id';
            $eip['ld_value']='name';
            $eip['id']=$eip['name']=$fix_id."_".$value['tag'];
            //$eip['name']=$eip['id'];
            $eip['ld']=array();
            for($i=$value['sn'];$i<=$value['en'];$i++):
                array_push($eip['ld'],array('id'=>$i,'name'=>$i));
            endfor;
            $eip['sd']=$fix[$value['tag']]*1;
            $eip['type']='select';
            $final.=$this->fi_get_input($eip);
        endforeach;
        return $final;    
    }
    function fi_get_radio_input()
    {   $final='';
        //$this->fi_pii_add(array("onblur"));
        $final.='<input type="radio" ';
        $own_array=array();
        $final.=$this->fi_do_all_property_string($own_array);
        $final.=$this->fi_get_spec_property_string();
        $e_value="";
        if(isset($this->fi_ds['sd'])) $e_value=is_array($this->fi_ds['sd'])?$this->fi_ds['sd'][$this->fi_ds['tf']]:$this->fi_ds['sd'];
		
		$e_checked=$e_value==$this->fi_ds['on']?'checked':'';
		if(isset($this->fi_ds['def_value'])&&$e_checked=='') $e_checked=$this->fi_ds['def_value']==$this->fi_ds['on']?'checked':'';
        $final.=' value="'.$this->fi_ds['on'].'" '.$e_checked;
        $final.=' />&nbsp;';
		$final.=isset($this->fi_ds['pre_tag'])?$this->fi_ds['pre_tag']:'';
		$final.=$this->fi_ds['call_name'];
		$final.=isset($this->fi_ds['su_tag'])?$this->fi_ds['su_tag']:'';
        
        return $final;
    }
	
    function fi_get_mradio_input()
    {   $final='';
		$this->fi_var_adjust('ld');
		//tag_value=''//pre_tag/su_tag
		$e_order=0;
		$fix_id=$this->fi_ds['id'];
		foreach($this->fi_ds['ld'] as $value): $e_order++;
			$e_ip=$this->fi_ds;
			$e_ip['on']=$value[$this->fi_ds['ld_key']];
			if(isset($this->fi_ds['tag_value'])&&$this->fi_ds['tag_value']!='') $e_ip['on']=GetTV($e_ip['on'],$this->fi_ds['tag_value']);
			$e_ip['call_name']=$value[$this->fi_ds['ld_value']];
			$e_ip['type']='radio';
			$e_ip['id']=$fix_id.'_'.$e_order;
			$final.=$this->fi_get_input($e_ip);			
		endforeach;        
        return $final;
    }
    //有加日曆時自己處理囉
	function each_op_trans($data=array(),$info=array(),$sd=array(),$sur_tag='',$full_set=array())
	{ 	$final=array();
		if(!is_array($data)&&$data=='full'):
			
			foreach($info as $value=>$sv):
				$eip=$info[$value];
                $target_field=isset($eip['tf'])?$eip['tf']:$value;
                $eip['sd']=isset($sd[$target_field])?htmlentities($sd[$target_field]):"";
				$eip['id']=$value.$sur_tag;
				foreach($full_set as $fst=>$fsv):
					$eip[$fst]=$fsv;
				endforeach;
				$eop=$this->fi_get_input($eip);
				$final[$value]=array("title"=>$eip['call_name'],"op"=>$eop,'value'=>$eip['sd']);			
			endforeach;
		else:
			foreach($data as $value):
				if(isset($info[$value])):
					$eip=$info[$value];
                    $target_field=isset($eip['tf'])?$eip['tf']:$value;
					//$eip['sd']=isset($sd[$value])?$sd[$value]:"";
                    $eip['sd']=isset($sd[$target_field])?$sd[$target_field]:"";
					$eip['id']=$value.$sur_tag;
					foreach($full_set as $fst=>$fsv):
						$eip[$fst]=$fsv;
					endforeach;
					$eop=$this->fi_get_input($eip);
					$final[$value]=array("title"=>$eip['call_name'],"op"=>$eop,'value'=>$eip['sd']);
				endif;
			endforeach;
		endif;
		
		return $final;
	}    
}

?>