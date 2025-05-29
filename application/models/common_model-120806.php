<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Common_model extends CI_Model {

    var $title   = '';
    
    function __construct()
    {   global $_G;
        parent::__construct();
    } 
	/*
	function UrlAugCheck($data=array(),$rdurl='def',$type='s')
	{  //
	    $test=FALSE;
		$rdurl=$rdurl=='def'?base_url():$rdurl;  $fo=0;
		foreach($data as $value)
		{   //$fo++; echo $fo."<br>";
		    
			$t_type=isset($value[0])?$value[0]:'def';
			switch($t_type)
			{
			    case 'fne':  //field not empty
				        if($value[1][0][$value[2]]==''||$value[1][0][$value[2]]==0) $test=TRUE; 
				    break;
                case 'Y':    //must be Y
				        if($value[1][0][$value[2]]!='Y') $test=TRUE; 
				    break;	
				case 'T':   //must be True
				        if($value[1]==FALSE) $test=TRUE;
				    break;	
				case 'def':
				        if(count($value)==0) $test=TRUE; 
				    break;	
			}
			if($test==TRUE) break;
		}
		if($test==TRUE) $this->JS_Link($rdurl,$type);
	}
	*/


    function InStr($string,$target)
    {
        if(str_replace($target,"",$string)==$string){
	        return false;
	    }else{
	        return true;
	    }        
    }
    function GetString($value,$st,$et="")
    {
        if($this->InStr($value,$st)||$this->InStr($value,$et))
        {   //­Ytag®Ú¥»¤£¦s¦b´N¶Ç¦^ªÅ­È
            if($st!="")
            {
	            $dd=explode($st,$value);
				
                $value=isset($dd[1])?$dd[1]:'';	        
	        }
	        if($et!="")
            {
	            $value=str_replace(strstr($value,$et),"",$value);
	        }
        }
        else
        {
            $value="";
        }
	    return $value;
    }
    function GetTV($value,$tag)
    {   //get tag value
        $final=$this->GetString($value,"<".$tag.">","</".$tag.">");
        return $final;
    }    
    function GetRow($value,$st,$et="",$type=1)
    {
        $ed=explode($st,$value);
	    $o=0;
	    $final=array();
	    foreach($ed as $vv)
        {
	        $o++;
		    if($type==1&&$o==1)
            { //1為跳過第一個		    
		    }
            else
            {
		        if($et!="")
                {
			        $vv=str_replace(strstr($vv,$et),"",$vv);                    
				    array_push($final,$vv);
			    }
                else
                {
			        array_push($final,$vv);
			    }		
		   }
	    }
	    return $final;
    }     
    function StripStr($t_array,$value)
    {
        foreach($t_array as $vv)
        {
            $value=str_replace($vv,"",$value);
        }
        return $value;
    }
	
    	
	
    function JS_Msg($msg='',$code=0,$type='p')
    {
		if($type=='p'){
			?><script>
            	parent.ECP_Msg('<?=$msg?>','<?=$code?>');
            </script><?php
		}else{
			?><script>
            	ECP_Msg('<?=$msg?>','<?=$code?>');
            </script><?php
		}
		/*
        echo "<meta http-equiv=\"Content-Type\" content=\"text/html; charset=utf-8\" />";
        echo "<script>alert('".$msg."');</script>";
		*/
    }   
	
    function JS_TMsg($msg='',$code=0,$type='p')
    {
		
        echo "<meta http-equiv=\"Content-Type\" content=\"text/html; charset=utf-8\" />";
        echo "<script>alert('".$msg."');</script>";
		
    } 
     
    function msg_trans($value='',$type=1)
    {
        switch($type):
            case 1:
                $value=iconv("utf-8","big5",$value);
                //$value='<meta http-equiv=\"Content-Type\" content=\"text/html; charset=utf-8\" />'.$value;
            break;
        endswitch;
        return $value;
    } 
    
    function msg_check($msg)
    {
        if($msg!="")
        {
            $this->CM->JS_Msg($msg);
        }
    }
    function JS_Link($url,$type='s')
    {
        if($type=='s')
        {
            echo "<script>location.href='".$url."';</script>";
        }
        else
        {
            echo "<script>parent.location.href='".$url."';</script>";
        }
    }
    function JS_Load($div='',$url='',$type='s')
    {
        if($type=='s')
        {
            echo "<script>ECP_Load_Div('".$div."','".$url."');</script>";
        }
        else
        {
            echo "<script>parent.ECP_Load_Div('".$div."','".$url."');</script>";
        }
    }    
	
	function PassVar($data=array())
	{   global $_G; 
	    foreach($data as $st=>$sv):
		    $_G[$st]=$sv;
		endforeach;
	}
	
	function GV($data=array())
	{   global $_G;
	    foreach($data as $value)
		{   
		    if(isset($_POST[$value])) $_G[$value]=$_POST[$value]==''?'':trim($_POST[$value]);
			/*if($_G[$value]=='') $_G[$value]=trim($_GET[$value]);*/
		}
	}
    
	function NGV($data=array())
	{
	    $final=array();
	    foreach($data as $value)
		{   
		    if(isset($_POST[$value])) $final[$value]=$_POST[$value]==''?'':trim($_POST[$value]);
			/*if($_G[$value]=='') $_G[$value]=trim($_GET[$value]);*/
		}
        return $final;
	} 
       
	function NFGV($data=array(),$info=array())
	{   //無post 則帶空白資料
	    $final=array();
	    foreach($data as $value)
		{ 
			$post_name=$value;
		    $post_name=isset($info['post_pre_tag'])?$info['post_pre_tag'].$value:$value;
			$post_name=isset($info['post_sur_tag'])?$value.$info['post_sur_tag']:$value;
		    $final[$value]=isset($_POST[$post_name])?trim($_POST[$post_name]):'';  
		}
        return $final;
	}   
      
    function PGV($data=array())
    {   global $_G;
        foreach($data as $st=>$sv):
            $_G[$st]=$sv;
        endforeach;
    }
    
    function UPD($data=array(),$set='',$final=array(),$info=array())//info->額外需要的絛件
    {   global $_G;
        //除錯的東東
        $sur_tag=isset($info['sur_tag'])?$info['sur_tag']:''; //加在post接收之尾
        $pre_tag=isset($info['pre_tag'])?$info['pre_tag']:''; //加在post接收之首
        
        if(!isset($this->$set)) $this->load->library($set);
        $check_info=$this->$set->load_mm_field_check();
        //$final=array();
        $pre_len=strlen($this->field_pre);
        foreach($data as $value):
            if(isset($_POST[$pre_tag.$this->field_pre.$value.$sur_tag])):
                $final[$value]=$_POST[$pre_tag.$this->field_pre.$value.$sur_tag];
                //$final[$value]=$final[$value]==''?0:$final[$value];//check的待補
            endif;            
        endforeach;
        return $final;
    }

    function tag_pack($value)  //把值包裝成tag形式
    {
        $final="";
        foreach($value as $tt=>$vv){
            $final.="<".$tt.">".$vv."</".$tt.">";
        }
        return $final;
    }
	
	function css_set($tag='',$data=array())
	{   		
		global $_G;
		$_G['css']=$tag.'_style';
		$_G['reset']=$tag.'_reset';
		$_G['img_folder']=$tag;
		
		foreach($data as $st=>$sv)
		{  //spec
		    $_G[$st]=$sv;
		}			
	}
	
	function close_cache()
	{
        header("Cache-Control: no-store, no-cache, must-revalidate"); 
        header("Cache-Control: post-check=0, pre-check=0", false); 	
	}
	
	function common_load()
	{
	    $bu=base_url();
	    ?>
         <link href="<?php echo $bu;?>css/card_reset.css" rel="stylesheet" type="text/css" />
         <link href="<?php echo $bu;?>css/<?=$css?>.css" rel="stylesheet" type="text/css" />
         <script src="<?php echo $bu;?>js/jquery.js"></script>
        <?php
        if(isset($js)):
            foreach($js as $value):
	            ?><script src="<?php echo $bu;?>js/<?=$value?>.js"></script><?php
	        endforeach;
        endif;
	}
	
	//db relative
	function array_input($field='',$data=array())
	{
	    $final=array();
		foreach($data as $value):
		   array_push($final,$value[$field]);
		endforeach;
		return $final;
	}
    
    function add_one_field($table='',$field='',$fv=0,$kf='',$kv=0)
    {
        $this->db->where($kf,$kv)->update($table,array($field=>$fv));
    }
    
    function add_one_hit($table='',$field='',$kf='',$key=0)
    {
        $this->db->query('UPDATE '.$table.' SET '.$field.'='.$field.'+1 WHERE '.$kf."='".$key."'");
    }    
  
	
    function SendMailGo($receive_email,$receive_name,$title,$content,$sender_email,$sender_name){
		if(@mail($receive_email,$title,"$content\n","MIME-Version: 1.0\nFrom: $sender_email\nReply-To: $sender_email\nErrors-To: $sender_email\nContent-Type:text/html\n\n")):
			return true;
		else:
			return false;
		endif;	
    }
    
    function SSCatePDB($source,$key,$vf)   //自定義類別pdb Self Set
    {
        $final=$this->FormatData(array("db"=>$source,"key"=>$key,"vf"=>$vf),"page_db",1);
        return $final;
    } 
    
    function FormatData($value,$type,$num)
    {
        $final="";
        switch($type){
            case "sdate":
                switch($num){
                    case 1: //Y->y/y->Y /國/西年轉
                        if(strlen($value)==4){
                            $final=$value-1911;
                        }else{
                            $final=$value+1911;
                        }
                    break;
                }
            break;
            case "file":
                switch($num){
                    case 1:  //純檔名
	                    for($i=strlen($value);$i>=1;$i--){
		                    if(substr($value,$i,1)=="."){
			                    $final=substr($value,$i);
			                    $final=str_replace($final,"",$value);
			                    return $final;
			                    break;
	                        }
                        }
                    break;
                    case 2:  //副檔名
						$final=substr(strchr($value,"."),1);      
                    break;                
                }
            break;
            case "cut_string":
                switch($num){  //1
				    case 1:
                        $fc=$value['fc'];
                        $cl=$value['cl'];
                        $final=mb_substr($fc,0,$cl,"utf-8");
					break;
                    case 'tag':
                        if($this->InStr($value,"-")):
                            $final=$this->GetString($value,"","-");
                        else:
                            $final=$value;
                        endif;
                    break;
                }
            break;
            case "number":
			    switch($num){
			        case "0":
                        $final=array();
                        for($i=0;$i<$value;$i++)
                        {
                            array_push($final,$i);
                        }
                    break;
				    case "1": //1->一
					    $ff="";
                        $f_value=$value;
					    $title_array=array("零","一","二","三","四","五","六","七","八","九","十");
						$multi_array=array("","","十","百","千","萬");
						$total_multi=strlen($f_value);
						$order=0;
						//special
						switch($f_value){
						    case "10":
							    $ff="十";
							break;
							default:
						        for($i=$total_multi;$i>=1;$i--){
						            $order++;
							        $x=$i-1;
							        $y=substr($f_value,$x,1);
							        $each_num[$order]=$y;
						        }
						        for($i=1;$i<=$total_multi;$i++){
						            if($each_num[$i]==0){
									    //
							            $this_title=$title_array[$each_num[$i]];
							        }else{
							            $this_title=$title_array[$each_num[$i]];
							        }
									$this_multi=$multi_array[$i];
						            if($each_num[$i]==0){
									    //如果上一個不是零的話再加
										$q=$i-1;							            
										if($each_num[$q]!=0){
										    $ff=$this_title.$ff;
										}
							        }else{
									    if($f_value<20&&$i==2){
										    $this_title="";
										}
							            $ff=$this_title.$this_multi.$ff;

							        }									
						        }															
							break;
						}                        
						//$final=iconv("","utf-8",$ff);
                        $final=$ff;
					break;
					case 'ch_num':
					$num=$value; $mode=true;
					
					
	$char = array("零","壹","貳","叁","肆","伍","陸","柒","捌","玖");
	$dw = array("","拾","佰","仟","","萬","億","兆");
	$dec = "點";
	$retval = "";
	if($mode)
		preg_match_all("/^0*(\d*)\.?(\d*)/",$num, $ar);
	else
		preg_match_all("/(\d*)\.?(\d*)/",$num, $ar);
	if($ar[2][0] != "")
		$retval = $dec . ch_num($ar[2][0], false); //如果有小數，先遞歸處理小數
	if($ar[1][0] != "")
	{
		$str = strrev($ar[1][0]);
		for($i=0;$i<strlen($str);$i++)
		{
			$out[$i] = $char[$str[$i]];
			if($mode)
			{
				$out[$i] .= $str[$i] != "0"? $dw[$i%4] : "";
				if($str[$i] == 0)
					$out[$i] = "";
				if($i%4 == 0)
					$out[$i] .= $dw[4+floor($i/4)];
			}
		}
		$retval = join("",array_reverse($out)) . $retval;
	}
	
					$final=$retval;
					break;
                    case 2: //1->01 /def是2位
                        if(is_array($value))
                        {   //自定len/日後擴充
                            $final=0;
                        }
                        else
                        {   //固定二位
                            $final=strlen($value)==1?"0".$value:$value;
                        }
                    break;
					case "fill_num":
						$num=$value['len']-strlen($value['value']);
						$final='';
						for($i=1;$i<=$num;$i++):
							$final.="0";
						endfor;
						$final.=$value['value'];
					break;
				}
            
            
            break;
            case "page_db":
                switch($num){
                    case 1:  //value->key,vf,db
                        $db=$value['db']; $key=$value['key']; $vf=$value['vf'];
                        if(!is_array($db))://重取
                            $mm_set=$this->GetString($db,"","@");
                            $type=$this->GetString($db,"@","");
                            $db=$this->GM->common_ac('list',array('info'=>$mm_set,'type'=>$type,'data'=>array()));
                        endif;
                        foreach($db as $vv){
							if(is_array($value['key'])):
								$e_key='';
								foreach($value['key'] as $no=>$field):	
									$e_key.=$vv[$field];
									if($no==0) $e_key.='-';
								endforeach;
								if($e_key!=''):
									if(is_array($vf)):
										foreach($vf as $vfv):
											$final[$e_key][$vfv]=$vv[$vfv];
										endforeach;
									else:
										$final[$e_key]=$vv[$vf]; 
									endif;
								endif; 							
							else:
								if(is_array($vf)):
									foreach($vf as $vfv):
										$final[$vv[$key]]=$vv[$vfv];
									endforeach;
								else:
									$final[$vv[$key]]=$vv[$vf];
								endif;
							endif;
                            
                        }
                    break;
                    case 'order'://排序
                        $final=array();
                        $vf=$value['vf'];
                        if($value['type']=='ASC'):
                        else:
                        endif;
                    break;
                    case 's_array':
                        $final=array();
                        foreach($value['db'] as $vv):
                            array_push($final,$vv[$value['key']]);
                        endforeach;
                    break;
                    case 'num'://sn/en/len/key/value
						$final=array();
                        for($i=$value['sn'];$i<=$value['en'];$i++):
                            $evalue=$i;
                            if(isset($value['len'])) $evalue=$this->FormatData(array("len"=>$value['len'],"value"=>$evalue),"number","fill_num");
                            array_push($final,array($value['key']=>$evalue,$value['value']=>$evalue));
                        endfor;
                    break;
                }
            break;
            case "input":
                switch($num)
                {
                    case 1:
                        $final=array();
                        foreach($value['tag'] as $vv):
                            $final[$vv]=$value['source'][$vv];
                        endforeach;
                    break;
                    case 'setdate':
                        $sur_tag='';
                        $pre_tag='';
                        if(is_array($value)):
                            $pre_tag=isset($value['pre_tag'])?$value['pre_tag']:'';
                            $sur_tag=isset($value['sur_tag'])?$value['sur_tag']:'';
                            $field=$value['field'];
                            $value=$field;
                            //echo $value;
                        endif;
                        $final=$_POST[$pre_tag.$this->field_pre.$value."_y".$sur_tag]."-".$this->FormatData($_POST[$pre_tag.$this->field_pre.$value."_m".$sur_tag],'number',2)."-".$this->FormatData($_POST[$pre_tag.$this->field_pre.$value."_d".$sur_tag],'number',2);
                    break;
                    case 'ld':
                        $final=array();
						$index_pre=isset($value['index_pre'])?$value['index_pre']:'';
                        foreach($value['ld'] as $st=>$sv):
                            array_push($final,array($value['st']=>$index_pre.$st,$value['sv']=>$sv));
                        endforeach;
                    break;//
                }
            break;
            case "table":
                switch($num):
                    case 'tr_h';
                        if($value['no']%$value['cols']==1) $final='<tr>';
                    break;
                    case 'tr_e':
                        if($value['no']==$value['total']):
                            for($i=1;$i<=($value['cols']-$value['no']%$value['cols']);$i++):
                                $final.='<td></td>';
                            endfor;
                            $final.='</tr>';  
                            //
                        else:
                            if($value['no']%$value['cols']==0) $final='</tr>';                            
                        endif;
						
                    break;
                endswitch;
            break;
        }
        return $final;
    } 
    
    function Unique_Load_Lib($set_name)
    {
        if(!isset($this->$set_name)) $this->load->library($set_name);
    }  
    //---
    function Init_TB_Set($set_name)
    {
        $this->Unique_Load_Lib($set_name); 
        $final['mm_tb']=$this->$set_name->mm_tb;
        $final['mm_kid']=$this->$set_name->mm_kid;
        $final['mm_set']=$set_name;
        return $final;
    } 
    

    
    function trans_input_G($final=array(),$pre='',$npre='')//pre只用在id
    {   
        $input_info=$final['input_info'];
        $up_f=$final['up_f'];
        $main_data=$final['main_data'];
        $this->Unique_Load_Lib('form_input');
        $field_pre=$this->field_pre;
        $final['field_pre']=$field_pre;
        foreach($up_f as $value):

            $eip=$input_info[$value];
            $eip['id']=$pre.$field_pre.$value;
            $eip['name']=$npre.$field_pre.$value;
            $eip['tf']=$value;
            $eip['sd']=$main_data[$value];
            $eips=$this->form_input->fi_get_input($eip); 
           
            $final['ip_'.$value]=array(
                'title'=>$input_info[$value]['call_name'],
                'op'=>$eips
            );
        endforeach; 
        return $final; //--- 
    } 
    
    function ReOrderSeqno($mm_set='',$source=array(),$seq_vf='seqno')
    {
        $mm_set=$this->CM->Init_TB_Set($mm_set);
        $mm_kid=$mm_set['mm_kid'];
        foreach($source as $no=>$value):
            $e_no=$no+1;
            $this->db->where($mm_kid,$value[$mm_kid])->update($mm_set['mm_tb'],array($seq_vf=>$e_no));
        endforeach;
    } 
    
    function get_df_url($final=array(),$df_ip=array())
    {
        $final['var_surl']=$df_ip['ob']."/".$df_ip['ot']."/".$df_ip['np']."/";
        $final['var_purl']=$this->m_controller."/".$df_ip['s_cate']."_mng/";  
        return $final;
    } 
    
    function get_image($id=0,$type='')
    {
        $mm_set=$this->Init_TB_Set('mm_ad_image_set');
        $final=$this->GM->common_ac('list',array('info'=>$mm_set['mm_set'],'upt'=>'def','kid'=>$id,'row_type'=>1));
        return $final;
    }   
    
    function get_img_full_path($ad_image_id=0,$df_path='')
    {
        $e_img=$this->get_image($ad_image_id);
        $pic_subname=$this->GetString($e_img['sys_filename'],".","");
        $pic_file='http://'.$_SERVER['HTTP_HOST'].$df_path.$e_img['sys_filename_s'];
        $file_path=$e_img['sys_filename_s']==''?base_url()."images/empty_pic.jpg":$pic_file;   
        return $file_path;     
    }
    function Upload_File($f_file,$f_path,$f_name,$mode=0){
        global $_G;
            //mode 1->副檔名轉小寫
			$full_name=$f_file["name"];
            $f_s_name=$this->FormatData($full_name,"file",2);
            if($mode==1){
                $f_s_name=strtolower($f_s_name);
            }
            $exif = exif_read_data($f_file["tmp_name"], 'IFD0');
            $emsg=""; $get_info=array('DateTime','Make','Model');
            if($exif):
                foreach ($exif as $key => $section) {
                    if(is_array($section)):
                    foreach ($section as $name => $val) {
                        if(in_array($name,$get_info)):
                            $_G['photo_header'][$name]=trim($val);
                        endif;
                        $emsg.="$key.$name: $val<br />\n";  //
                    }
                    endif;//來吧!抓資訊哦。
                }
            endif;
            if(!isset($_G['photo_header']['DateTime'])):
                $exif = exif_read_data($f_file["tmp_name"], 0, true);
                if($exif):
                    foreach ($exif as $key => $section) {
                        if(is_array($section)):
                            foreach ($section as $name => $val) {
                                if(in_array($name,$get_info)):
                                    $_G['photo_header'][$name]=trim($val);
                                endif;
                                $emsg.="$key.$name: $val<br />\n";  //
                            }
                        endif;//來吧!抓資訊哦。
                    }
                endif;   
            endif;         
            //echo $emsg;
            //$this->CM->JS_Msg('');
            if (@copy ($f_file["tmp_name"],$f_path.$f_name.".".$f_s_name)) {
				
                unlink( $f_file["tmp_name"]); 
				$final['status']=1;
				$final['sub_name']=trim($f_s_name);
				return $final;
			} else {
				
			    $final['status']=0;
			    return $final;
			}
    } 
	
	function SingleUpload($input_name='',$f_path='',$output_name='')
	{	global $_G;
		$msg='';
		if($output_name=='') $output_name=$_FILES[$input_name]['name'];
		if($_FILES[$input_name]['name']!=''):
			$f_name=$output_name;
			$eup=$this->Upload_File($_FILES[$input_name],$f_path,$f_name);
			if($eup['status']==1):
					//add_file	
				$_G['up_filename']=$output_name.'.'.$eup['sub_name'];	
			else:
				$msg.="檔案 ".$eup['full_name']." 上傳失敗。";
			endif;
		endif;
	
		return $msg;//''的話無問題
	}
	
    function Base_New_UPD()
    {   global $_G;
        $final=array(
                //'ad_client_id'=>$this->ad_client_id,
                //'ad_org_id'=>$this->ad_org_id,
                'isactive'=>'Y',
                'created'=>date('Y-m-d H:i:s'),//time(),
                'createdby'=>$this->ad_id,
                'updated'=>date('Y-m-d H:i:s'),//time()
                'updatedby'=>$this->ad_id   
            );
        return $final;
    }
    function Base_UP_UPD()
    {   global $_G;
        $final=array(
                'updated'=>date('Y-m-d H:i:s'),//time()
                'updatedby'=>$this->ad_id   
            );
        return $final;
    }
	
	function CHINFO_MNG($chinfo='')
	{	$final=array();	
		$chinfo_array=explode('&',$chinfo);
		foreach($chinfo_array as $value):
			if($value!=''):
				$st=$this->GetString($value,'','=');
				$sv=$this->GetString($value,'=','');
				if($st!='') $final[$st]=$sv;
			endif;
		endforeach;

		return $final;
	}
    
	function GPV($array=array(),$data=array())
	{	//get post var/data['sur_tag']
		$sur_tag=isset($data['sur_tag'])?$data['sur_tag']:'';
		$final=array();
		$type=isset($data['type'])?$data['type']:'def';
		$final=$type=='upd'?$data['upd']:$final;
		foreach($array as $value):
		//先GET後POST
			if(isset($_GET[$value.$sur_tag])):
				//$final[$value]=get_magic_quotes_gpc()?stripslashes($_GET[$value.$sur_tag]):$_GET[$value.$sur_tag];	
				$final[$value]=$_GET[$value.$sur_tag];	 
			endif;
			if(isset($_POST[$value.$sur_tag])):
				$final[$value]=$_POST[$value.$sur_tag];
				//$final[$value]=get_magic_quotes_gpc()?stripslashes($_POST[$value.$sur_tag]):$_POST[$value.$sur_tag];		 
			endif;
		endforeach;
		return $final;
	}  
	
	function DL_URL($id=0)
	{
		$id=(int)($id);
		$final=base_url('ecp_common/download_file/'.$id.'/0/');
		return $final;
	}
	
	function User_Group()
	{	//
		
	}
	
	function db_trans($value='',$type='input')
	{	global $_G;
		if($_G['os']=='LINUX'):
			switch($type):
				case 'input':
					$value=iconv('utf-8','big5',$value);
				break;
				case 'ouput':
					$value=iconv('big5','utf-8',$value);
				break;
			endswitch;
		endif;
		return $value;
	}
	
function GTPV($array=array(),$data=array())
{	//get post var
	$final=array();
	$type=isset($data['type'])?$data['type']:'def';
	$final=$type=='upd'?$data['upd']:$final;
	switch($type){
		case 'sarray':
			foreach($array as $st)://st rece /sv op
			//先GET後POST
				if(isset($_GET[$st])):
					$final[$st]=$_GET[$st];		 
				endif;
				if(isset($_POST[$st])):
					$final[$st]=$_POST[$st];			 
				endif;
			endforeach;		
		break;
		case 'field_set':
			foreach($array as $st=>$sv):
				if(isset($_GET[$st])):
					$final[$st]=$_GET[$st];		 
				endif;
				if(isset($_POST[$st])):
					$final[$st]=$_POST[$st];			 
				endif;
			endforeach;
		break;
		default:
			foreach($array as $st=>$sv)://st rece /sv op
			//先GET後POST
				if(isset($_GET[$st])):
					$final[$sv]=$_GET[$st];		 
				endif;
				if(isset($_POST[$st])):
					$final[$sv]=$_POST[$st];			 
				endif;
			endforeach;
		break;
	}

	return $final;
} 
		
}
?>