<?php 
if (!defined('BASEPATH')) exit('No direct script access allowed');

class Get_model extends CI_Model {
    
	var $a_tb='';  //main_tb
	var $b_tb='';
	var $def_pg=1; //預設page_type
	var $join_most=3; ////set most additional 3
	var $jsql=0;
    var $total_rows=0;
    var $per_page=10;
    var $now_page=0;
    var $non=array('orwhere');//
	var $assign_db='';
	
    function __construct() {
        parent::__construct();
    }
	/*  abbreivation explanation
	glt=>get list type
	dt =>datatype
	tb =>table
	con=>condition
	def=>default
	ob =>order by
	np =>now page
	pp =>per page
	gp =>get page
	m  =>more
	pd =>page data
	upd ->update data
    kid ->key_id
    deltype ->full/isactive
	*/	

    function GetSpecData($table,$target,$key,$key_id)
    {   //取得單一資料
    	// Upate by Johnson 2012/12/10 若得到0值則傳回空白, 遇到讀ID的狀況就有BUG
		$f_query = $this->db->where($key,$key_id)->get($table);
		$final = "";
		if ($f_query->num_rows() > 0)
		{
			$row = $f_query->row();
			$final = $row->$target;
		}
		return $final;
		
//		$f_query = $this->db->where($key,$key_id)->get($table)->row();
//		if(isset($f_query->$target))
//		{
//			$final=$f_query->$target;
//		}
//		else
//		{
//			$final="";
//		}
//		return $final;
    }	

    function get_preaction($tb='',$data=array())
	{
	    $input_data=array(
		        'tb'=>$tb
		    );  
           
		$add=array('where'=>'where','dis'=>'dis','con'=>'con','wni'=>'wni','wi'=>'wi','jsql'=>'jsql','ob'=>'orderby','gp'=>'gp','pd'=>'page_data','join'=>'join','like'=>'like','row_type'=>'row_type','one_field'=>'one_field','non'=>'non','orwhere'=>'orwhere','fixselect'=>'fixselect','group_by'=>'group_by','limit'=>'limit');//可能為外加的絛件
		for($j=1;$j<=$this->join_most;$j++):
		    $add['join_'.$j]='join_'.$j;
		endfor;
		foreach($add as $st=>$sv)
		{
		    if(isset($data[$st])) $input_data[$sv]=$data[$st];
		}
		if(isset($data['jsql'])) $this->jsql=$data['jsql'];
		$glt=isset($data['glt'])?$data['glt']:3;	
		$final=$this->get_list($input_data,$glt);	
		return $final;	
	}
	
	function get_list($data=0,$type=0)
	{   global $_G;
        //$this->db = $this->load->database('mssqlef',TRUE); 
		
	    //data=> con/tb/orderby/per_page/now_page/gp->Y
	    //common mng
		
		$com_con=array(
		        1=>array('isactive'=>'Y','isdisplayed'=>'Y'), //level_one
				2=>array('isactive'=>'Y'),
				3=>array('isactive'=>'Y','isopen'=>'Y'),
				4=>array()
		    );
          //$data['assign_db'] 

		if(isset($data['gp'])&&$data['gp']=='Y')//先取總數-再調整np
		{   //取得總數
		
			if($data['page_data']['pp']>0):
			
			
            if(isset($data['non'])) $this->non=$data['non'];
		    if(isset($com_con[$type])) $this->where_array($com_con[$type],0);
		    //if(isset($data['con'])) $this->where_array($data['con']);
            if(isset($data['where'])) $this->db->where($data['where']);
		    if(isset($data['dis'])) $this->dis_array($data['dis']);	
		    if(isset($data['con'])) $this->where_array($data['con']);	
		    if(isset($data['wi'])) $this->wi_array($data['wi']);
            if(isset($data['wni'])) $this->wni_array($data['wni']);	
		    if(isset($data['like'])) $this->like_array($data['like']);   
			if(isset($data['orwhere'])) $this->db->ar_orwhere=$data['orwhere'];    
			if(isset($data['fixselect'])) $this->db->ar_fixselect=$data['fixselect'];   
			if(isset($data['group_by'])) $this->db->group_by($data['group_by']);  
			if(isset($data['limit'])) $this->db->limit($data['limit']); 
		    if(isset($data['join']))
		    {
                $this->g_join($data['join']);
			    for($j=1;$j<=$this->join_most;$j++) 
			    {
			        if(isset($data['join_'.$j])) $this->g_join($data['join_'.$j],1);
			    }	
				$_G['temp_ti']=$this->db->get()->num_rows();
		    }
		    else
		    {
		        $this->jsql();//看情況  
				$_G['temp_ti']=$this->db->get($data['tb'])->num_rows();
		    }
            $this->total_rows=$_G['temp_ti'];
			
			
			endif;
			
            if($data['page_data']['np']>=0&&$data['page_data']['np']>=$this->total_rows)://np下減
                $data['page_data']['np']=$data['page_data']['np']-$data['page_data']['pp'];
                if($data['page_data']['np']<0) $data['page_data']['np']=0;
            	$this->per_page=$data['page_data']['pp'];//
            	$this->now_page=$data['page_data']['np'];//
            endif;	
			
		}     
            
            
		if(isset($data['non'])) $this->non=$data['non'];
        
		if(isset($com_con[$type])) $this->where_array($com_con[$type],0); 
        if(isset($data['where'])) $this->db->where($data['where']);	       
		if(isset($data['dis'])) $this->dis_array($data['dis']);	
		if(isset($data['con'])) $this->where_array($data['con']);	
		if(isset($data['wi'])) $this->wi_array($data['wi']);
        if(isset($data['wni'])) $this->wni_array($data['wni']);	
		if(isset($data['like'])) $this->like_array($data['like']);
		if(isset($data['orwhere'])) $this->db->ar_orwhere=$data['orwhere'];
		if(isset($data['fixselect'])) $this->db->ar_fixselect=$data['fixselect']; 
		if(isset($data['group_by'])) $this->db->group_by($data['group_by']);
		if(isset($data['orderby'])) $this->order_array($data['orderby']);
		if(isset($data['limit'])) $this->db->limit($data['limit']);
		if(isset($data['page_data']['m'])) $data['page_data']['pp']++;	//有more時分頁加1作判斷
		if(isset($data['page_data']['pp'])&&isset($data['page_data']['np'])&&$data['page_data']['pp']>0)
		{
			$this->db->limit($data['page_data']['pp'],$data['page_data']['np']); 
            $this->per_page=$data['page_data']['pp'];
            $this->now_page=$data['page_data']['np'];
		}	
		
		if(isset($data['join']))
		{
            $this->g_join($data['join']);
			for($j=1;$j<=$this->join_most;$j++) 
			{   
			    if(isset($data['join_'.$j])) $this->g_join($data['join_'.$j],1);
			}	
			$final=$this->db->get()->result_array();
		}
		else
		{
		    $this->jsql();//看情況 
			$final=$this->db->get($data['tb'])->result_array();
		}
        

		if(isset($data['page_data']['m']))
		{   //test more
			$_G['temp_more']=count($final)==$data['page_data']['pp']?'Y':'N';
			$data['page_data']['pp']--; //恢復正常值
		}

		if(isset($data['row_type'])&&$data['row_type']==1&&count($final)==1){ $final=$final[0]; } //提取第一筆
		if(isset($data['one_field'])&&isset($data['row_type'])&&$data['row_type']==1&&isset($final[$data['one_field']])) $final=$final[$data['one_field']]; 	
		//echo $this->per_page.'<<';
        $this->must_clean();
		return $final;
	}
	
	
	//commonw
    function must_clean()
    {   //每次執行完必清的
        $this->jsql=0;
        $this->non=array();
		$this->db->orwhere=array();
    }
	
	function where_array($value,$type=1) //1->check 0->no check
	{   //test ad_client_id
	    $test=0;
		foreach($value as $st=>$sv):
			$this->db->where($st,$sv); 
		endforeach;

	}
    function dis_array($value)
	{
        $this->db->distinct();
        $this->db->select($this->CM->array_to_string($value));	
		
	}
	function wi_array($value)
	{
		foreach($value as $st=>$sv):
			$this->db->where_in($st,$sv);
		endforeach;	
	}
	function wni_array($value)
	{  
		foreach($value as $st=>$sv):
			$this->db->where_not_in($st,$sv);
		endforeach;	
	}
	function like_array($value)
	{   $fo=0;
		foreach($value as $st=>$sv): $fo++;
			if($fo==1)
			{
			    $this->db->like($st,$sv);
                //echo $st.'-'.$sv;
			}
			else
			{
                $this->db->like($st,$sv);//改回AND LIKE
			    //$this->db->or_like($st,$sv);
			}			
		endforeach;	
	}
    	
	function order_array($value)
	{
		foreach($value as $st=>$sv):
			$this->db->order_by($st,$sv);
		endforeach;	
	}
    
    function jsql()
    {
        //echo '@@@-----------------------------------------';
			if($this->jsql!==0):   
			    foreach($this->jsql as $vv):
				    $this->db->select($vv);
				endforeach;
			endif;        
    }
    	
	function g_join($value,$type=0) //0 full/1 ->more join
	{
	    if($type===0):
            $this->db->select('*');
			if($this->jsql!==0):
			    foreach($this->jsql as $vv):
				    $this->db->select($vv);
				endforeach;
			endif;
            $this->db->from($value['tb']);
		endif;
		$jtb_as=isset($value['jtb_as'])?$value['jtb_as']:$value['jtb'];
		$tb_as=isset($value['tb_as'])?$value['tb_as']:$value['tb'];
		$jtb_isas=isset($value['jtb_as'])?" AS ".$value['jtb_as']:'';
		$tb_isas=isset($value['tb_as'])?" AS ".$value['tb_as']:'';
		$and=isset($value['and'])?$value['and']:'';
		if(isset($value['type']))
		{
		    $this->db->join($value['jtb'].$jtb_isas, $jtb_as.'.'.$value['jkey'].' = '.$tb_as.'.'.$value['mkey'].$and, $value['type']);	
		}
		else
		{
		    $this->db->join($value['jtb'].$tb_isas, $jtb_as.'.'.$value['jkey'].' = '.$tb_as.'.'.$value['mkey'].$and);	
		}            
	}
	
	function page_data($config=array())
	{   //取得分頁資訊，載link_model
    //cur_page/per_page/
//	var $prefix				= ''; // A custom prefix added to the path.
	//var $suffix				= ''; // A custom suffix added to the path.	  
        //$config['base_url'] = site_url("area/promotion/$keyword/$orderby");
        //input only prefix/suffix
        //$config['base_url']=base_url();
        //$config['suffix']='_chinfo';

        $config['total_rows'] = $this->total_rows;
        $config['per_page'] = $this->per_page;
        $config['cur_page']=$this->now_page;
        //$config['uri_segment'] = 5;
        //echo $config['total_rows']."-".$config['per_page']."-".$config['cur_page']."-".$config['base_url']."-";
        //echo $config['total_rows']."<br>".$config['per_page']."<br>".$config['cur_page']."<br>".$config['base_url']."<br>";
        $this->pagination->initialize($config);
        $page = $this->pagination->create_links();
        //echo $page;
        $final['page']=$page;
        $final['total_result']=$config['total_rows'];
        $final['start']=$this->now_page+1;
        $final['end']=$final['start']+$config['per_page']-1;
		$final['pp']=$config['per_page'];
        //now_ot
		
        if(isset($config['mm_spec_url']))
        {   //排序用的，輸入替換位置與對應欄位
            //分解出per與fix
            //$full_url=$config['base_url'].$config['cur_page']."/";
			$full_url=$config['base_url']."0/";
			if(isset($config['chinfo']))
			{
				if($config['chinfo']=='Unconfirm')
				{
					$full_url=$config['base_url']."0/Unconfirm/";
				}
			}
			else
			{
				$full_url=$config['base_url']."0/";
			}					
            //echo $full_url;
			
			if(isset($config['now_ot'])):
				$pure_ot=$config['now_ot'];
				$full_url=str_replace('/'.$config['now_ot'].'/','/'.$config['now_ot'].'-'.$config['per_page'].'/',$full_url);
				$config['now_ot']=$config['now_ot'].'-'.$config['per_page'];
				if($config['now_ot']=='ASC-'.$config['per_page']):
					//$r_full_url=substr($full_url,0,strlen($full_url)-6).'DESC-'.$config['per_page'].'/0/';
					$r_full_url=str_replace('ASC-'.$config['per_page'].'/0/','DESC-'.$config['per_page'].'/0/',$full_url);
					$d_full_url=$full_url;
				else:
					//$r_full_url=substr($full_url,0,strlen($full_url)-7).'ASC-'.$config['per_page'].'/0/';
					//$d_full_url=substr($full_url,0,strlen($full_url)-7).'ASC-'.$config['per_page'].'/0/';
					$r_full_url=str_replace('DESC-'.$config['per_page'].'/0/','ASC-'.$config['per_page'].'/0/',$full_url);
					$d_full_url=str_replace('DESC-'.$config['per_page'].'/0/','ASC-'.$config['per_page'].'/0/',$full_url);
				endif;
			else:
				$r_full_url=$full_url;
				$d_full_url=$full_url;
			endif;

            
			foreach($config['mm_spec_url'] as $st=>$sv)
            {
                //sv->value."@@@".field;-tag可視情況自定
                $split_tag=isset($config['mm_spec_tag'])?$config['mm_spec_tag']:'@@@';
				if($this->CM->InStr($st,'ob_'.$this->CM->GetString($sv,$split_tag))):
					$final[$st]=str_replace('/'.$this->CM->GetString($sv,$split_tag).'/','/'.$this->CM->GetString($sv,'',$split_tag).'/',$r_full_url);		//相反
				else:
					$final[$st]=str_replace('/'.$this->CM->GetString($sv,$split_tag).'/','/'.$this->CM->GetString($sv,'',$split_tag).'/',$d_full_url);
				endif;
                
            }
			//NoP
			$perp=array(30,50,100,0);
			
			foreach($perp as $p):
				$final['perp_'.$p.'_url']=str_replace('/'.$config['now_ot'].'/','/'.$pure_ot.'-'.$p.'/',$full_url);
			endforeach;

        }
		
        return $final;
  
	}
    function get_projtasktype_str($projtasktype='7')
	{
		switch($projtasktype){
			case '1':
			  $strProjtype='準備';
			  break;
			case '2':
			  $strProjtype='開展';
			  break;
			case '3':
			  $strProjtype='移轉';
			  break;
			case '4':
			  $strProjtype='廢止';
			  break;
			case '5':
			  $strProjtype='暫停';
			  break;
			case '6':
			  $strProjtype='完成';
			  break;
			default:
			  $strProjtype='未定義';
			  break;
			}
		return $strProjtype;
	}
	
    function common_ac($type='list',$data=array())
    {    //通用的DB動作
        
        if(!isset($this->$data['info'])) $this->load->library($data['info']);
        switch($type):
            case 'list':

                if(isset($data['upt']))
                {
                    switch($data['upt']):
                        case 'def': //by keyid
                            $tb=$this->$data['info']->mm_actb;
                            $kf=$this->$data['info']->mm_kid;
                            if(is_array($data['kid'])):
                                foreach($kf as $kv):
                                    if(isset($data['kid'][$kv])) $this->db->where($kv,$data['kid']['$kv']);
                                endforeach;
                            else:
                                $this->db->where($kf,$data['kid']);
                            endif;  
                            $final=$this->db->get($tb)->result_array();
                            $final=count($final)>0?$final[0]:false;  
                            if(isset($data['one_field'])&&isset($final[$data['one_field']])) $final=$final[$data['one_field']];                       
                        break;
                    endswitch;
                    
                }
                else
                {	
                    if(isset($data['glt'])) $this->$data['info']->mm_glt=$data['glt'];
                    $glt=$this->$data['info']->mm_glt;
                    $tb=$this->$data['info']->mm_tb;
                    $td=$this->$data['info']->mm_td;
                    
		            $td[$data['type']]=$this->csi_mng($td[$data['type']],$data['data']);                    				
                    $td[$data['type']]=$this->cdi_mng($td[$data['type']],$data['data']);                    							
		            $td[$data['type']]['glt']=isset($td[$data['type']]['glt'])?$td[$data['type']]['glt']:$glt;	
		            $final=$this->get_preaction($tb,$td[$data['type']]);
					
                    //if($tb=='jec_areamenu') exit('= =');//echo '= =';	                 
                }
                return $final;
            break;
            case 'insert':
                switch($data['upt']):
                    case 'def':
						$tb=$this->$data['info']->mm_actb;
                        $this->db->insert($tb,$data['upd']);
                    break;
                endswitch;
            break;
            case 'update':
                
                switch($data['upt'])://update type
                    case 'def':                        
                        $tb=$this->$data['info']->mm_actb;
                        $kf=$this->$data['info']->mm_kid;
                        //echo '@xxx'.$tb."-".$kf."-".$data['kid']."-".count($data['upd']);
                        if(is_array($data['kid'])):
                            foreach($kf as $kv):
                                if(isset($data['kid'][$kv])) $this->db->where($kv,$data['kid'][$kv]);
                            endforeach;
                        else:
                            $this->db->where($kf,$data['kid']);
                        endif; 
                        $this->db->update($tb,$data['upd']);                         
                        
                    break;
                    case 'mm':
                        $tb=$this->$data['info']->mm_actb;
		                $ipd=$this->csi_mng(array(),$data['data']);				
		                $ipd=$this->cdi_mng(array(),$data['data']);

                        $add=array('con'=>'con','wi'=>'wi','non'=>'non');//可能為外加的絛件
		                foreach($add as $st=>$sv)
		                {
		                    if(isset($ipd[$st])) $input_data[$sv]=$ipd[$st];
                        }  
                        if(isset($input_data['non'])) $this->non=$input_data['non'];              
                        if(isset($input_data['con'])) $this->where_array($input_data['con'],0);	
		                if(isset($input_data['wi'])) $this->wi_array($input_data['wi']);  
                        $this->db->update($tb,$data['upd']);//upd                      
                    break;
                endswitch;
            
   
            break;
            case 'del'://分isactive跟真刪的
                //con
                switch($data['upt'])://update type
                    case 'def':
                        $tb=$this->$data['info']->mm_actb;
                        $deltype=$this->$data['info']->mm_deltype;
                        $kf=$this->$data['info']->mm_kid;
                        if(is_array($data['kid'])):
                            foreach($kf as $kv):
                                if(isset($data['kid'][$kv])) $this->db->where($kv,$data['kid']['$kv']);
                            endforeach;
                        else:
                            $this->db->where($kf,$data['kid']);
                        endif;
                        if($deltype=='full')
                        {
                            $this->db->delete($tb);
                        }
                        else
                        {   
                            $this->db->update($tb,array('isactive'=>'N'));
                        }

                        
                    break;
                    case 'mm':
                        $tb=$this->$data['info']->mm_actb;
                        $deltype=$this->$data['info']->mm_deltype;
		                $ipd=$this->csi_mng(array(),$data['data']);				
		                $ipd=$this->cdi_mng(array(),$data['data']);
                        
                        $add=array('con'=>'con','wi'=>'wi','non'=>'non');//可能為外加的絛件
		                foreach($add as $st=>$sv)
		                {
		                    if(isset($ipd[$st])) $input_data[$sv]=$ipd[$st];
                        }  
                        if(isset($input_data['non'])) $this->non=$input_data['non'];              
                        if(isset($input_data['con'])) $this->where_array($input_data['con'],0);	
		                if(isset($input_data['wi'])) $this->wi_array($input_data['wi']);  
                        if($deltype=='full')
                        {
                            $this->db->delete($tb);
                        }
                        else
                        {   
                            $this->db->update($tb,array('isactive'=>'N'));
                        }                   
                    break;
                endswitch;                
            break;
            case 'spec_data':
                switch($data['tt']):
                    case 'f'://function
                        $final=$this->$data['info']->$data['target']();
                    break;
                    case 'v'://var
                        $final=$this->$data['info']->$data['target'];
                    break;
                endswitch;
                //$final=$this->$data['info']->$data['target'];
                return $final;                
            break;
        endswitch;
        //
        $this->$data['info']->after_exe_ac($type,$data);
        /*
        if(function_exists($this->$data['info']->after_exe_ac())):
            $this->CM->JS_Msg("Yes");          //    
            
        endif;*/
    }	
}
?>