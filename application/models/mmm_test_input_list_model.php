<?php 
if (!defined('BASEPATH')) exit('No direct script access allowed');

class Mmm_test_input_list_model extends CI_Model 
{   //場地管理->MMMM
    //var $m_controller='ecp_area';
    var $m_function='test_input_list_mng';
	var $m_lib_folder='tools/model/test_input_list/';
    var $m_index='info';
    var $m_tcate=array(
            'info'=>array(
                    'title'=>'基本設定',
                    'index'=>'list'
                ),
            'facebook'=>array(
                    'title'=>'臉書',
                    'index'=>'list'
                ),
            'menuservice'=>array(
                    'title'=>'菜色與服務',
                    'index'=>'list'
                ),
            'button_bk'=>array(
                    'title'=>'回場地列表',
                    'index'=>'fs'
                )
        );
    function __construct() 
    {   global $_G;
        parent::__construct();
        //$_G['img_folder']=$this->m_folder;
    }
    
    //test
    
    function info($df_ip=array())   //基本資料
    {   global $_G; 
        $final['field_pre']=$this->field_pre;
        $final['response_type']='normal';
        $mm_set='mm_areabase_set';//,"jec_citydistrict_id"
        $up_f=array("");//,"c_bpartner_id","jec_brand_id"//,"activitylongterm"
        $search_array_f=array("fs_islongterm"); 
        $final=$this->CM->get_df_url($final,$df_ip);
        // $p_data=explode("_",$df_ip['chinfo']);
        
        include $this->m_lib_folder."info.php";

        //echo $df_ip['ac']."-".$df_ip['pg'];
        return $final;
    }
    function specification($df_ip=array())  //說明
    {   global $_G;
        $final['field_pre']=$this->field_pre;
        $final['response_type']='normal';
        $mm_set='mm_areabase_set';
        $up_f=array("description","descriptionext");
        include $this->m_lib_folder."specification.php";

        //echo $df_ip['ac']."-".$df_ip['pg'];
        return $final;        
    }
    
    function areapic($df_ip=array())  //
    {   global $_G;
        $final['field_pre']=$this->field_pre;
        $final['response_type']='normal';
        $mm_set='mm_areavideo_set';
        $up_f=array("isopen","name","description","ad_image_id");//
        $p_data=explode("_",$df_ip['chinfo']);
        $final['product_id']=isset($p_data[1])?$p_data[1]:0;  
        //$var_surl=$df_ip['ob']."/".$df_ip['ot']."/".$df_ip['np']."/"; 
        //$var_purl=$this->m_controller."/".$df_ip['s_cate']."_mng/";    
        $final=$this->CM->get_df_url($final,$df_ip);
        include $this->m_lib_folder."areapic.php";
         
        //echo $df_ip['ac']."-".$df_ip['pg'];
        return $final;        
    }
    
    function room_add_project($df_ip=array())  //
    {   global $_G;
        $final['field_pre']=$this->field_pre;
        $final['response_type']='normal';
        $mm_set='mm_product_set';
        $mm_cc='mm_common_css';
        $up_f=array();//,"c_bpartner_id","jec_brand_id"/只可選所屬的
        include $this->m_lib_folder."room_add_project.php";

        //echo $df_ip['ac']."-".$df_ip['pg'];
        return $final;           
    }            
    function project($df_ip=array())  //說明
    {   global $_G;
        $final=$this->MAD->model_common_pass();
        $final['field_pre']=$this->field_pre;
        $final['response_type']='normal';
        $mm_set='mm_areaproj_set';
        $up_f=array("qtyfacility","qtyservice","qtyarragement","qtymenu","name","seqno","areaproj_pic","pricelist","tablenop","mintable","maxtable","tablenote","chargefee","pricenote");
        $final['ccate_ptag']='project';
        $final['ccate_menu']=array(
            'project'=>array(
                    'title'=>'基本資料',
                    'index'=>'edit'
                ),
            'project-1'=>array(
                    'title'=>'簡介說明',
                    'index'=>'des_edit'
                ),
            'areaproj_detail'=>array(
                    'title'=>'專案內容',
                    'index'=>'edit'//用勾的哦，像自訂欄位那樣
                ),
            'button_bk'=>array(
                    'title'=>'回專案列表',
                    'index'=>'s2s'
                )
        );
        $final=$this->CM->get_df_url($final,$df_ip); 
        include $this->m_lib_folder."project.php"; 

        //echo $df_ip['ac']."-".$df_ip['pg'];
        return $final;        
    }
    function areaproj_detail($df_ip=array())  //說明
    {   global $_G;
        $final['field_pre']=$this->field_pre;
        $final['response_type']='normal';
        $mm_set='mm_arearoom_set';
        $up_f=array("name","mintable","maxtable","tablenote","pricelist","areameasure","height","seqno");
        include $this->m_lib_folder."areaproj_detail.php";

        return $final;        
    }    
    function promotion($df_ip=array())  //促銷說明
    {   global $_G;

        $final=$this->MAD->model_common_pass();
        $final['field_pre']=$this->field_pre;
        $final['response_type']='normal';
        $mm_set='mm_areaad_set';
        $up_f=array("ispresent","areaad_pic","name","startdate","enddate","description");
        $final['ccate_ptag']='promotion';
        $final['ccate_menu']=array(
            'promotion'=>array(
                    'title'=>'基本資料',
                    'index'=>'edit'
                ),
            'promotion-1'=>array(
                    'title'=>'活動內容',
                    'index'=>'edit_html'
                ),
            'promotion_keyword'=>array(
                    'title'=>'關鍵字設定',
                    'index'=>'edit'
                ),
            'button_bk'=>array(
                    'title'=>'回活動列表',
                    'index'=>'s3s'
                )
        ); 
        $final=$this->CM->get_df_url($final,$df_ip);   
        include $this->m_lib_folder."promotion.php";     

        //echo $df_ip['ac']."-".$df_ip['pg'];
        return $final;        
    }
    
    function bulletin($df_ip=array())  //公告說明
    {   global $_G;
        $final=$this->MAD->model_common_pass();
        $final['field_pre']=$this->field_pre;
        $final['response_type']='normal';
        $mm_set='mm_notice_set';
        $up_f=array("name","description","ispresent","startdate","enddate","notice_pic");   
        $final['ccate_ptag']='bulletin';
        $final['ccate_menu']=array(
            'bulletin'=>array(
                    'title'=>'基本資料',
                    'index'=>'edit'
                ),
            'bulletin-1'=>array(
                    'title'=>'公告內容',
                    'index'=>'edit_html'
                ),
            'button_bk'=>array(
                    'title'=>'回公告列表',
                    'index'=>'s4s'
                )
        );  
        $final=$this->CM->get_df_url($final,$df_ip); 
        include $this->m_lib_folder."bulletin.php";
        
        //echo $df_ip['ac']."-".$df_ip['pg'];
        return $final;        
    }
    
    function photovideo($df_ip=array())  //相簿
    {   global $_G;
        $final['field_pre']=$this->field_pre;
        $final['response_type']='normal';
        $mm_set='mm_videobook_set';
        $up_f=array("name","jec_videokind_id","description","isopen");//,"seqno"
        $final['ccate_ptag']='photovideo';
        $final['ccate_menu']=array(
            'photovideo_pic'=>array(
                    'title'=>'管理相片',
                    'index'=>'list'
                ),
            'photovideo'=>array(
                    'title'=>'相簿編輯',
                    'index'=>'edit'
                ),
            'photovideo_keyword'=>array(
                    'title'=>'關鍵字',
                    'index'=>'edit'
                ),
            'photovideo_newpic'=>array(
                    'title'=>'上傳新相片',
                    'index'=>'edit'
                ),  
            'photovideo_singlepic'=>array(
                    'title'=>'相片管理',
                    'index'=>'edit',
                    'noLink'=>'Y'
                ),             
            'button_bk'=>array(
                    'title'=>'回相簿列表',
                    'index'=>'s5s'
                )
        ); 
        $final=$this->CM->get_df_url($final,$df_ip);   
        //var 1->first_tag.  
        $p_data=explode("_",$df_ip['chinfo']);
        $final['first_tag']=isset($p_data[1])?$p_data[1]:'photovideo'; 
        $final['first_tag']=$final['first_tag']=='photovideo'?$final['first_tag']:'photovideo_'.$final['first_tag'];   
        
        include $this->m_lib_folder."photovideo.php";

        //echo $df_ip['ac']."-".$df_ip['pg'];
        return $final;        
    }
     function photovideo_singlepic($df_ip=array())   //編修相片
    {   global $_G;
        $this->CM->close_cache();
        $final['field_pre']=$this->field_pre;
        $final['response_type']='normal';
        $mm_set='mm_areavideo_set';
        $mm_cc='mm_common_css';
        $up_f=array("name","shootdate","shootplace","description","isopen");//,"c_bpartner_id","jec_brand_id"
        $p_data=explode("_",$df_ip['chinfo']);
        
        $final=$this->CM->get_df_url($final,$df_ip);
        include $this->m_lib_folder."photovideo_singlepic.php"; 

        return $final;          
    }   
     function photovideo_newpic($df_ip=array())   //新相片
    {   global $_G;
        $final['field_pre']=$this->field_pre;
        $final['response_type']='normal';
        $mm_set='mm_areavideo_set';
        $mm_cc='mm_common_css';
        $up_f=array();//,"c_bpartner_id","jec_brand_id"
        $p_data=explode("_",$df_ip['chinfo']);

        $final=$this->CM->get_df_url($final,$df_ip);
        include $this->m_lib_folder."photovideo_newpic.php";
        

        //echo $df_ip['ac']."-".$df_ip['pg'];
        #reset for the
        return $final;          
    }       
    function photovideo_pic($df_ip=array())   //相片列表
    {   global $_G;
        $final['field_pre']=$this->field_pre;
        $final['response_type']='normal';
        $mm_set='mm_areavideo_set';
        $mm_cc='mm_common_css';
        $up_f=array();//,"c_bpartner_id","jec_brand_id"
        $p_data=explode("_",$df_ip['chinfo']);
        //$final['search_word']=isset($_POST['search_word'])?$_POST['search_word']:''; 
        $final=$this->CM->get_df_url($final,$df_ip);
        include $this->m_lib_folder."photovideo_pic.php";
        //echo $df_ip['ac']."-".$df_ip['pg'];
        return $final;          
    }     
    function blog($df_ip=array())  //部落格
    {   global $_G;
        $final['field_pre']=$this->field_pre;
        $final['response_type']='normal';
        $mm_set='mm_areablog_set';
        $up_f=array("description","name","datedoc","blogsource");//,"ad_image_id"
        $final['ccate_ptag']='blog';
        $final['ccate_menu']=array(
            'blog'=>array(
                    'title'=>'基本資料',
                    'index'=>'edit'
                ),
            'blog_keyword'=>array(
                    'title'=>'關鍵字設定',
                    'index'=>'edit'
                ),
            'button_bk'=>array(
                    'title'=>'回部落格列表',
                    'index'=>'s6s'
                )
        ); 
        $final=$this->CM->get_df_url($final,$df_ip);       
        switch($df_ip['ac']):
            case 'list'://
                $this->CM->close_cache();
                //$ar_set=$this->CM->Init_TB_Set($mm_set);
                $final['main_data']=$this->GM->common_ac('list',array('info'=>$mm_set,'type'=>'def','data'=>array('gp'=>'Y','pd_pp'=>$df_ip['pp'],'pd_np'=>$df_ip['np'],'con_jec_areabase_id'=>$df_ip['key_id'],'ob_datedoc'=>$df_ip['ot'])));
                $_G['pg_div_load']='Y';
                $_G['pg_div_type']='ss';
                $_G['pg_div_id']='tcate_'.$df_ip['tag'].'_div';
                $final['pd']=$this->GM->page_data(array('uri_segment'=>$df_ip['seg'],'base_url'=>base_url().$this->m_controller.'/'.$this->m_function.'/'.$df_ip['tag'].'/'.$df_ip['ac'].'/'.$df_ip['key_id'].'/'.$df_ip['ob'].'/'.$df_ip['ot'].'/'));
            break;
            case 'edit':
                $ab_set=$this->CM->Init_TB_Set($mm_set);
                $final['up_f']=$up_f;
                $this->load->library('form_input');
                $final['field_pre']=$this->field_pre;
                $final['input_info']=$this->GM->common_ac('spec_data',array('info'=>$mm_set,'tt'=>'f','target'=>'load_mm_field_check'));
                $final['main_data']=$this->GM->common_ac('list',array('info'=>$mm_set,'upt'=>'def','kid'=>$df_ip['key_id']));  
                $final=$this->CM->trans_input_G($final);
                $final['assign_view']='ccate_plate';
                $final['search_tag']='s6s';
                $final['basearea_id']=$this->db->where($ab_set['mm_kid'],$df_ip['key_id'])->get($ab_set['mm_tb'])->row()->jec_areabase_id;
                $final['s6s_bkurl']=site_url($final['var_purl'].$final['ccate_ptag']."/list/".$final['basearea_id']."/".$final['var_surl']);
                $final['s6s_hidden']='';
            break;
            case 'update'://只放此處有編的
                $up_v=$this->CM->UPD($up_f,$mm_set);
                $up_v['datedoc']=$this->CM->FormatData('datedoc','input','setdate').' 00:00:00';
                if($df_ip['key_id']==0)
                {
                    $this->GM->common_ac('insert',array('info'=>$mm_set,'upt'=>'def','upd'=>$up_v));
                }
                else
                {   
                    $this->GM->common_ac('update',array('info'=>$mm_set,'upt'=>'def','kid'=>$df_ip['key_id'],'upd'=>$up_v)); 
                }
                ?><script>parent.ECP_Msg('',1);</script><?php
            break;
            case 'grab_blog':
                //http://blog.udn.com/rss.jsp?uid=gaing
                
                $rss_url=$this->db->where('jec_areabase_id',$df_ip['key_id'])->get('jec_areabase')->result_array();
                $rss_url=count($rss_url)>0?$rss_url[0]['blogsource']:'';
                if($rss_url==''):
                    $msg="請設定部落格rss網址。";
                else:
                    $ab_set=$this->CM->Init_TB_Set('mm_areablog_set');
                    $rss=simplexml_load_file($rss_url);
                    $author=trim($rss->channel->title);
                    $upd_info=array('name'=>'title','blogsource'=>'link','description'=>'description');
                    
                    foreach($rss->channel->item as $vv):
                        $upd=$this->CM->Base_New_UPD();
                        $upd['datedoc']=date("Y-m-d H:i:s",strtotime($vv->pubDate));
                        $upd['createddate']=$upd['datedoc'];
                        $upd['updated']=date("Y-m-d H:i:s");
                        $upd['updatedby']=$this->ad_id;
                        $upd['author']=$author;
                        foreach($upd_info as $st=>$sv):
                            $upd[$st]=trim($vv->$sv);
                        endforeach;
                        $upd['jec_areabase_id']=$df_ip['key_id'];
                    //test
                        
                        $test=$this->db->where('jec_areabase_id',$df_ip['key_id'])->where('blogsource',$upd['blogsource'])->where('isactive','Y')->get('jec_areablog')->num_rows();//->where('blogsource',$upd['blogsource'])
                        if($test==0) $this->GM->common_ac('insert',array('info'=>$ab_set['mm_set'],'upt'=>'def','upd'=>$upd));
                        /**/
                    endforeach;
                    $msg="OK";
                endif;
                $ajo=array(
                    'msg'=>$msg,
                    "reload"=>"tcate_".$df_ip['tag']."_div",
                    "reload_url"=>site_url($final['var_purl'].$df_ip['tag']."/list/".$df_ip['key_id']."/"),
                    'pass'=>1
                );
                $final['response_type']='ajax';
                $final['ajax_output']=$this->CM->tag_pack($ajo); 
            break;
        endswitch;
        //echo $df_ip['ac']."-".$df_ip['pg'];
        return $final;        
    }     
    
    function keyword($df_ip=array())   //關鍵字
    {   global $_G;
        $final['field_pre']=$this->field_pre;
        $final['response_type']='normal';
        $mm_set='mm_areabase_set';
        $mm_cc='mm_common_css';
        $up_f=array('');//,"c_bpartner_id","jec_brand_id"
        $p_data=explode("_",$df_ip['chinfo']);
        $final['search_word']=isset($_POST['search_word'])?$_POST['search_word']:''; 
        
        switch($df_ip['ac']):
            
            case 'edit':
                $this->CM->Unique_Load_Lib('form_input');
                $kwi_set=$this->CM->Init_TB_Set('mm_keywordinfo_set');
                $kwik_set=$this->CM->Init_TB_Set('mm_keywordinfokind_set');
                $kwik_id=$this->$kwik_set['mm_set']->mm_spec_kind_id('areabase');
                $final['selected_data']=$this->GM->common_ac('list',array('info'=>$kwi_set['mm_set'],'type'=>'join_keyword','data'=>array('ob_jec_keyword.countquery'=>'DESC','con_'.$kwi_set['mm_tb'].'.isactive'=>'Y','con_'.$kwi_set['mm_tb'].'.datakeyid'=>$df_ip['key_id'],'con_'.$kwi_set['mm_tb'].'.'.$kwik_set['mm_kid']=>$kwik_id)));

                $final['tb_cols']=5;
                $final['input_info']=array(
                        'type'=>'checkbox'
                    );   
                $final['selected_array']=$this->CM->array_input('jec_keyword_id',$final['selected_data']);
                
                //search_result
                $final['search_word']=urldecode($final['search_word']);
                $final['main_list']=array();
                if($final['search_word']!=''):
                    $kw_set=$this->CM->Init_TB_Set('mm_keyword_set');
                    $final['main_list']=$this->GM->common_ac('list',array('info'=>$kw_set['mm_set'],'type'=>'def','data'=>array('con_'.$kw_set['mm_tb'].'.isdisplayed'=>'Y','con_'.$kw_set['mm_tb'].'.isactive'=>'Y','like_'.$kw_set['mm_tb'].'.name'=>$final['search_word'])));
                endif;
            break;
            case 'update'://只放此處有編的
                $keyword_kind_tag='areabase';
                $keyword_add_field_pre='kwa';
                $keyword_del_field_pre='kwd';
                $keyword_refresh_string='Y';
                
                include ('tools/common/keyword_update.php');
                //represh頁面/重整
                /*'<meta http-equiv="Content-Type" content="text/html; charset=utf-8" /><?php echo $selected_string;?>*/
                /*<?php echo $_POST['fix_search_keyword'];?>*/
                $browser = get_browser(null, true);
                ?><script>
                    var isFirefox = navigator.userAgent.search("Firefox") > -1; 
                    var isOpera = navigator.userAgent.search("Opera") > -1; 
                    var isSafari = navigator.userAgent.search("Safari") > -1;
                    var isIE = navigator.userAgent.search("MSIE") > -1; 
                    if(isIE){
                        var ie_v=parent.GetString(navigator.userAgent,'compatible;','.0;');
                        ie_v=parseInt(ie_v);
                        if(ie_v>8){
                            isIE=false;
                        } 
                    }
                    if(isIE){
                        parent.mmm_ajax_load('tcate_<?php echo $df_ip['tag'];?>_div','<?php echo site_url($this->m_controller."/".$df_ip['s_cate']."_mng/".$df_ip['tag']."/edit/".$df_ip['key_id']."/".$df_ip['ob']."/".$df_ip['ot']."/".$df_ip['np']."/");?>','','<?php echo iconv("utf-8","big5",$_POST['fix_search_keyword']);?>');
                        //parent.ECP_CH_HTML('specification_kw_string','<?php echo iconv("utf-8","big5",$selected_string);?>');   
                        document.execCommand("stop");
                    }
                </script><?php
                if($browser['browser']!='IE'):
                    ?><script>
                    if(isFirefox||isOpera||isSafari){
                        parent.ECP_CH_HTML('specification_kw_string','<?php echo $selected_string;?>');
                        parent.mmm_ajax_load('tcate_<?php echo $df_ip['tag'];?>_div','<?php echo site_url($this->m_controller."/".$df_ip['s_cate']."_mng/".$df_ip['tag']."/edit/".$df_ip['key_id']."/".$df_ip['ob']."/".$df_ip['ot']."/".$df_ip['np']."/");?>','','<?php echo $_POST['fix_search_keyword'];?>');                        
                    }
                    </script><?php
                endif;
                
                $final['response_type']='';
            break;
        endswitch;
        //echo $df_ip['ac']."-".$df_ip['pg'];
        return $final;          
    }
    
    function promotion_keyword($df_ip=array())   //促銷關鍵字
    {   global $_G;
        $final['field_pre']=$this->field_pre;
        $final['response_type']='normal';
        $mm_set='mm_areaad_set';
        $mm_cc='mm_common_css';
        $up_f=array();//,"c_bpartner_id","jec_brand_id"
        $p_data=explode("_",$df_ip['chinfo']);
        $final['search_word']=isset($_POST['search_word'])?$_POST['search_word']:''; 
        switch($df_ip['ac']):
            case 'edit': 
                $this->CM->Unique_Load_Lib('form_input');
                $kwi_set=$this->CM->Init_TB_Set('mm_keywordinfo_set');
                $kwik_set=$this->CM->Init_TB_Set('mm_keywordinfokind_set');
                $kwik_id=$this->$kwik_set['mm_set']->mm_spec_kind_id('areaad'); 
                $final['selected_data']=$this->GM->common_ac('list',array('info'=>$kwi_set['mm_set'],'type'=>'join_keyword','data'=>array('ob_jec_keyword.countquery'=>'DESC','con_'.$kwi_set['mm_tb'].'.isactive'=>'Y','con_'.$kwi_set['mm_tb'].'.datakeyid'=>$df_ip['key_id'],'con_'.$kwi_set['mm_tb'].'.'.$kwik_set['mm_kid']=>$kwik_id)));

                $final['tb_cols']=5;
                $final['input_info']=array(
                        'type'=>'checkbox'
                    );   
                $final['selected_array']=$this->CM->array_input('jec_keyword_id',$final['selected_data']);
                
                //search_result
                $final['search_word']=urldecode($final['search_word']);
                $final['main_list']=array();
                if($final['search_word']!=''):
                    $kw_set=$this->CM->Init_TB_Set('mm_keyword_set');
                    $final['main_list']=$this->GM->common_ac('list',array('info'=>$kw_set['mm_set'],'type'=>'def','data'=>array('con_'.$kw_set['mm_tb'].'.isdisplayed'=>'Y','con_'.$kw_set['mm_tb'].'.isactive'=>'Y','like_'.$kw_set['mm_tb'].'.name'=>$final['search_word'])));
                endif;
            break;
            case 'update'://只放此處有編的
                $keyword_kind_tag='areaad';
                $keyword_add_field_pre='kwa';
                $keyword_del_field_pre='kwd';
                $keyword_refresh_string='Y';
                
                include ('tools/common/keyword_update.php');
                //represh頁面/重整
                /*
                ?><script>
                    parent.mmm_ajax_load('ccate_<?php echo $df_ip['tag'];?>_div','<?php echo site_url($this->m_controller."/".$df_ip['s_cate']."_mng/".$df_ip['tag']."/edit/".$df_ip['key_id']."/".$df_ip['ob']."/".$df_ip['ot']."/".$df_ip['np']."/");?>','','<?php echo $_POST['fix_search_keyword'];?>');
                </script><?php*/
                $browser = get_browser(null, true);
                ?><script>
                    var isFirefox = navigator.userAgent.search("Firefox") > -1; 
                    var isOpera = navigator.userAgent.search("Opera") > -1; 
                    var isSafari = navigator.userAgent.search("Safari") > -1;
                    var isIE = navigator.userAgent.search("MSIE") > -1; 
                    if(isIE){
                        parent.mmm_ajax_load('ccate_<?php echo $df_ip['tag'];?>_div','<?php echo site_url($this->m_controller."/".$df_ip['s_cate']."_mng/".$df_ip['tag']."/edit/".$df_ip['key_id']."/".$df_ip['ob']."/".$df_ip['ot']."/".$df_ip['np']."/");?>','','<?php echo iconv("utf-8","big5",$_POST['fix_search_keyword']);?>');
                        document.execCommand("stop");
                    }
                </script><?php
                if($browser['browser']!='IE'):
                    ?><script>
                    if(isFirefox||isOpera||isSafari){
                        parent.mmm_ajax_load('ccate_<?php echo $df_ip['tag'];?>_div','<?php echo site_url($this->m_controller."/".$df_ip['s_cate']."_mng/".$df_ip['tag']."/edit/".$df_ip['key_id']."/".$df_ip['ob']."/".$df_ip['ot']."/".$df_ip['np']."/");?>','','<?php echo $_POST['fix_search_keyword'];?>');                        
                    }
                    </script><?php
                endif;
                
                $final['response_type']='';
            break;
        endswitch;
        //echo $df_ip['ac']."-".$df_ip['pg'];
        return $final;          
    }    
    function photovideo_keyword($df_ip=array())   //促銷關鍵字
    {   global $_G;
        $final['field_pre']=$this->field_pre;
        $final['response_type']='normal';
        $mm_set='mm_videobook_set';
        $mm_cc='mm_common_css';
        $up_f=array();//,"c_bpartner_id","jec_brand_id"
        $p_data=explode("_",$df_ip['chinfo']);
        $final['search_word']=isset($_POST['search_word'])?$_POST['search_word']:''; 
        switch($df_ip['ac']):
            case 'edit': 
                $this->CM->Unique_Load_Lib('form_input');
                $kwi_set=$this->CM->Init_TB_Set('mm_keywordinfo_set');
                $kwik_set=$this->CM->Init_TB_Set('mm_keywordinfokind_set');
                $kwik_id=$this->$kwik_set['mm_set']->mm_spec_kind_id('videobook'); 
                $final['selected_data']=$this->GM->common_ac('list',array('info'=>$kwi_set['mm_set'],'type'=>'join_keyword','data'=>array('ob_jec_keyword.countquery'=>'DESC','con_'.$kwi_set['mm_tb'].'.isactive'=>'Y','con_'.$kwi_set['mm_tb'].'.datakeyid'=>$df_ip['key_id'],'con_'.$kwi_set['mm_tb'].'.'.$kwik_set['mm_kid']=>$kwik_id)));

                $final['tb_cols']=5;
                $final['input_info']=array(
                        'type'=>'checkbox'
                    );   
                $final['selected_array']=$this->CM->array_input('jec_keyword_id',$final['selected_data']);
                
                //search_result
                $final['search_word']=urldecode($final['search_word']);
                $final['main_list']=array();
                if($final['search_word']!=''):
                    $kw_set=$this->CM->Init_TB_Set('mm_keyword_set');
                    $final['main_list']=$this->GM->common_ac('list',array('info'=>$kw_set['mm_set'],'type'=>'def','data'=>array('con_'.$kw_set['mm_tb'].'.isdisplayed'=>'Y','con_'.$kw_set['mm_tb'].'.isactive'=>'Y','like_'.$kw_set['mm_tb'].'.name'=>$final['search_word'])));
                endif;
            break;
            case 'update'://只放此處有編的
                $keyword_kind_tag='videobook';
                $keyword_add_field_pre='kwa';
                $keyword_del_field_pre='kwd';
                $keyword_refresh_string='Y';
                //要更新keywords...
                
                include ('tools/common/keyword_update.php');

                
                //represh頁面/重整
                /*
                ?><script>
                    parent.mmm_ajax_load('ccate_<?php echo $df_ip['tag'];?>_div','<?php echo site_url($this->m_controller."/".$df_ip['s_cate']."_mng/".$df_ip['tag']."/edit/".$df_ip['key_id']."/".$df_ip['ob']."/".$df_ip['ot']."/".$df_ip['np']."/");?>','','<?php echo $_POST['fix_search_keyword'];?>');
                    parent.ECP_CH_HTML('photovideo_kw_string','<meta http-equiv="Content-Type" content="text/html; charset=utf-8" /><?php echo $selected_string;?>');
                </script><?php*/
                $browser = get_browser(null, true);
                ?><script>
                    var isFirefox = navigator.userAgent.search("Firefox") > -1; 
                    var isOpera = navigator.userAgent.search("Opera") > -1; 
                    var isSafari = navigator.userAgent.search("Safari") > -1;
                    var isIE = navigator.userAgent.search("MSIE") > -1; 
                    if(isIE){
                        parent.mmm_ajax_load('ccate_<?php echo $df_ip['tag'];?>_div','<?php echo site_url($this->m_controller."/".$df_ip['s_cate']."_mng/".$df_ip['tag']."/edit/".$df_ip['key_id']."/".$df_ip['ob']."/".$df_ip['ot']."/".$df_ip['np']."/");?>','','<?php echo iconv("utf-8","big5",$_POST['fix_search_keyword']);?>');
                        parent.ECP_CH_HTML('photovideo_kw_string','<?php echo iconv("utf-8","big5",$selected_string);?>');   
                        document.execCommand("stop");
                    }
                </script><?php
                if($browser['browser']!='IE'):
                    ?><script>
                    if(isFirefox||isOpera||isSafari){
                        parent.ECP_CH_HTML('photovideo_kw_string','<?php echo $selected_string;?>');
                        parent.mmm_ajax_load('ccate_<?php echo $df_ip['tag'];?>_div','<?php echo site_url($this->m_controller."/".$df_ip['s_cate']."_mng/".$df_ip['tag']."/edit/".$df_ip['key_id']."/".$df_ip['ob']."/".$df_ip['ot']."/".$df_ip['np']."/");?>','','<?php echo $_POST['fix_search_keyword'];?>');                        
                    }
                    </script><?php
                endif;
                
                $final['response_type']='';
            break;
        endswitch;
        //echo $df_ip['ac']."-".$df_ip['pg'];
        return $final;          
    }        
    
    function blog_keyword($df_ip=array())   //促銷關鍵字
    {   global $_G;
        $final['field_pre']=$this->field_pre;
        $final['response_type']='normal';
        $mm_set='mm_areaad_set';
        $mm_cc='mm_common_css';
        $up_f=array();//,"c_bpartner_id","jec_brand_id"
        $p_data=explode("_",$df_ip['chinfo']);
        $final['search_word']=isset($_POST['search_word'])?$_POST['search_word']:'';
        $final=$this->CM->get_df_url($final,$df_ip); 
        switch($df_ip['ac']):
            case 'edit': 
                $this->CM->Unique_Load_Lib('form_input');
                $kwi_set=$this->CM->Init_TB_Set('mm_keywordinfo_set');
                $kwik_set=$this->CM->Init_TB_Set('mm_keywordinfokind_set');
                $kwik_id=$this->$kwik_set['mm_set']->mm_spec_kind_id('blog'); 
                $final['selected_data']=$this->GM->common_ac('list',array('info'=>$kwi_set['mm_set'],'type'=>'join_keyword','data'=>array('ob_jec_keyword.countquery'=>'DESC','con_'.$kwi_set['mm_tb'].'.isactive'=>'Y','con_'.$kwi_set['mm_tb'].'.datakeyid'=>$df_ip['key_id'],'con_'.$kwi_set['mm_tb'].'.'.$kwik_set['mm_kid']=>$kwik_id)));

                $final['tb_cols']=5;
                $final['input_info']=array(
                        'type'=>'checkbox'
                    );   
                $final['selected_array']=$this->CM->array_input('jec_keyword_id',$final['selected_data']);
                
                //search_result
                $final['search_word']=urldecode($final['search_word']);
                $final['main_list']=array();
                if($final['search_word']!=''):
                    $kw_set=$this->CM->Init_TB_Set('mm_keyword_set');
                    $final['main_list']=$this->GM->common_ac('list',array('info'=>$kw_set['mm_set'],'type'=>'def','data'=>array('con_'.$kw_set['mm_tb'].'.isdisplayed'=>'Y','con_'.$kw_set['mm_tb'].'.isactive'=>'Y','like_'.$kw_set['mm_tb'].'.name'=>$final['search_word'])));
                endif;
            break;
            case 'update'://只放此處有編的
                $keyword_kind_tag='blog';
                $keyword_add_field_pre='kwa';
                $keyword_del_field_pre='kwd';
                $keyword_refresh_string='Y';
                
                include ('tools/common/keyword_update.php');
                //represh頁面/重整
                /*
                ?><script>
                    parent.mmm_ajax_load('ccate_<?php echo $df_ip['tag'];?>_div','<?php echo site_url($this->m_controller."/".$df_ip['s_cate']."_mng/".$df_ip['tag']."/edit/".$df_ip['key_id']."/".$df_ip['ob']."/".$df_ip['ot']."/".$df_ip['np']."/");?>','','<?php echo $_POST['fix_search_keyword'];?>');
                </script><?php*/
                $browser = get_browser(null, true);
                ?><script>
                    var isFirefox = navigator.userAgent.search("Firefox") > -1; 
                    var isOpera = navigator.userAgent.search("Opera") > -1; 
                    var isSafari = navigator.userAgent.search("Safari") > -1;
                    var isIE = navigator.userAgent.search("MSIE") > -1; 
                    if(isIE){
                        parent.mmm_ajax_load('ccate_<?php echo $df_ip['tag'];?>_div','<?php echo site_url($this->m_controller."/".$df_ip['s_cate']."_mng/".$df_ip['tag']."/edit/".$df_ip['key_id']."/".$df_ip['ob']."/".$df_ip['ot']."/".$df_ip['np']."/");?>','','<?php echo iconv("utf-8","big5",$_POST['fix_search_keyword']);?>'); 
                        document.execCommand("stop");
                    }
                </script><?php
                if($browser['browser']!='IE'):
                    ?><script>
                    if(isFirefox||isOpera||isSafari){
                        parent.mmm_ajax_load('ccate_<?php echo $df_ip['tag'];?>_div','<?php echo site_url($this->m_controller."/".$df_ip['s_cate']."_mng/".$df_ip['tag']."/edit/".$df_ip['key_id']."/".$df_ip['ob']."/".$df_ip['ot']."/".$df_ip['np']."/");?>','','<?php echo $_POST['fix_search_keyword'];?>');                        
                    }
                    </script><?php
                endif;
                $final['response_type']='';
            break;

        endswitch;
        //echo $df_ip['ac']."-".$df_ip['pg'];
        return $final;          
    }        
    function facebook($df_ip=array())  //分類
    {   global $_G;
        $final['field_pre']=$this->field_pre;
        $final['response_type']='normal';
        $mm_set='mm_areafb_set';
        $up_f=array("description","datatype","name","datedoc","thumbnail_link","videourl","fb_contenthtml");
        $final['ccate_ptag']='facebook';
        $final['ccate_menu']=array(
            'facebook'=>array(
                    'title'=>'基本資料',
                    'index'=>'edit'
                ),
            'facebook_keyword'=>array(
                    'title'=>'關鍵字設定',
                    'index'=>'edit'
                ),
            'button_bk'=>array(
                    'title'=>'回臉書文章列表',
                    'index'=>'s7s'
                )
        );  
        $final=$this->CM->get_df_url($final,$df_ip);      
        switch($df_ip['ac']):
            case 'list'://
                //$ar_set=$this->CM->Init_TB_Set($mm_set);
                $this->CM->close_cache();
                $final['datatype']=array(1=>'文章',3=>'影音');
                $final['main_data']=$this->GM->common_ac('list',array('info'=>$mm_set,'type'=>'def','data'=>array('con_jec_areabase_id'=>$df_ip['key_id'],'ob_datedoc'=>$df_ip['ot'],'pd_pp'=>10,'pd_np'=>$df_ip['np'],'gp'=>'Y')));
                $_G['pg_div_load']='Y';
                $_G['pg_div_type']='ss';
                $_G['pg_div_id']='tcate_'.$df_ip['tag'].'_div';
                $final['pd']=$this->GM->page_data(array('uri_segment'=>$df_ip['seg'],'base_url'=>base_url().$this->m_controller.'/'.$this->m_function.'/'.$df_ip['tag'].'/'.$df_ip['ac'].'/'.$df_ip['key_id'].'/'.$df_ip['ob'].'/'.$df_ip['ot'].'/'));
            break;
            case 'edit':
                $af_set=$this->CM->Init_TB_Set($mm_set);
                $final['up_f']=$up_f;
                $this->load->library('form_input');
                $final['field_pre']=$this->field_pre;
                $final['input_info']=$this->GM->common_ac('spec_data',array('info'=>$mm_set,'tt'=>'f','target'=>'load_mm_field_check'));
                //$final['input_info']['contenthtml']['id']='fb_contenthtml';
                //$final['input_info']['contenthtml']['name']='contenthtml';
                $final['main_data']=$this->GM->common_ac('list',array('info'=>$mm_set,'upt'=>'def','kid'=>$df_ip['key_id']));  
                $final['main_data']['fb_contenthtml']=$final['main_data']['contenthtml'];
                $final=$this->CM->trans_input_G($final);
                $final['assign_view']='ccate_plate';
                $final['search_tag']='s7s';
                $final['basearea_id']=$this->db->where($af_set['mm_kid'],$df_ip['key_id'])->get($af_set['mm_tb'])->row()->jec_areabase_id;
                $final['s7s_bkurl']=site_url($final['var_purl'].$final['ccate_ptag']."/list/".$final['basearea_id']."/".$final['var_surl']);
                $final['s7s_hidden']='';
            break;
            case 'update'://只放此處有編的
                $up_v=$this->CM->UPD($up_f,$mm_set);
                $up_v['contenthtml']=$up_v['fb_contenthtml'];
                unset($up_v['fb_contenthtml']);
                if($df_ip['key_id']==0)
                {
                    $this->GM->common_ac('insert',array('info'=>$mm_set,'upt'=>'def','upd'=>$up_v));
                }
                else
                {   
                    $this->GM->common_ac('update',array('info'=>$mm_set,'upt'=>'def','kid'=>$df_ip['key_id'],'upd'=>$up_v)); 
                }
                ?><script>parent.ECP_Msg('',1);</script><?php
            break;
            case 'grab_post':
                //max_note_id
                $af_set=$this->CM->Init_TB_Set('mm_areafb_set');
                $max_facebook_id=$this->db->where('jec_areabase_id',$df_ip['key_id'])->where('datatype',1)->where('isactive','Y')->limit(1,0)->get('jec_areafb')->result_array();
                $max_facebook_id=count($max_facebook_id)>0?$max_facebook_id[0]['facebook_id']:0;
                $ad_con=$max_facebook_id>0?" AND note_id>".$max_facebook_id:"";
                $msg=$this->FB->set_fb_app_set($df_ip['key_id']);
                
                if($msg==''):
                    $post_list=$this->FB->get_fb_fsql("SELECT uid, note_id, title, content_html, content, created_time, updated_time FROM note WHERE uid=me()".$ad_con);//me(),10,0

                //echo count($post_list);
                    $upd_info=array('name'=>'title','facebook_id'=>'note_id','description'=>'content','contenthtml'=>'content_html');
                    foreach($post_list->data as $vv):
                        $upd=$this->CM->Base_New_UPD();
                        $upd['datedoc']=date("Y-m-d H:i:s",$vv->created_time);
                        $upd['updated']=date("Y-m-d H:i:s",$vv->updated_time);
                        $upd['datatype']=1;
                        foreach($upd_info as $st=>$sv):
                            $upd[$st]=$vv->$sv;
                        endforeach;
                        $upd['jec_areabase_id']=$df_ip['key_id'];
                    //test
                        $test=$this->db->where('facebook_id',$upd['facebook_id'])->where('isactive','Y')->get('jec_areafb')->num_rows();
                        $this->GM->common_ac('insert',array('info'=>$af_set['mm_set'],'upt'=>'def','upd'=>$upd));
                    endforeach;
                    $msg="OK";
                endif;
                $ajo=array(
                    'msg'=>$msg,
                    "reload"=>"tcate_".$df_ip['tag']."_div",
                    "reload_url"=>site_url($final['var_purl'].$df_ip['tag']."/list/".$df_ip['key_id']."/"),
                    'pass'=>1
                );
                $final['response_type']='ajax';
                $final['ajax_output']=$this->CM->tag_pack($ajo); 
            break;
            case 'grab_video':
                //max_note_id
                $af_set=$this->CM->Init_TB_Set('mm_areafb_set');
                $max_facebook_id=$this->db->where('jec_areabase_id',$df_ip['key_id'])->where('datatype',3)->where('isactive','Y')->limit(1,0)->get('jec_areafb')->result_array();
                $max_facebook_id=count($max_facebook_id)>0?$max_facebook_id[0]['facebook_id']:0;
                $ad_con=$max_facebook_id>0?" AND vid>".$max_facebook_id:"";
                $msg=$this->FB->set_fb_app_set($df_ip['key_id']);
                if($msg==''):
                    $post_list=$this->FB->get_fb_fsql("SELECT vid,owner,album_id,title,description,link,thumbnail_link,embed_html,updated_time,created_time FROM video WHERE owner=me()".$ad_con);//me(),10,0

                //echo count($post_list);
                    $upd_info=array('name'=>'title','facebook_id'=>'vid','description'=>'description','contenthtml'=>'embed_html','thumbnail_link'=>'thumbnail_link','videourl'=>'link');
                    foreach($post_list->data as $vv):
                        $upd=$this->CM->Base_New_UPD();
                        $upd['datedoc']=date("Y-m-d H:i:s",$vv->created_time);
                        $upd['updated']=date("Y-m-d H:i:s",$vv->updated_time);
                        $upd['datatype']=3;
                        foreach($upd_info as $st=>$sv):
                            $upd[$st]=$vv->$sv;
                        endforeach;
                        $upd['jec_areabase_id']=$df_ip['key_id'];
                    //test
                        $test=$this->db->where('facebook_id',$upd['facebook_id'])->where('isactive','Y')->get('jec_areafb')->num_rows();
                        $this->GM->common_ac('insert',array('info'=>$af_set['mm_set'],'upt'=>'def','upd'=>$upd));
                    endforeach;
                    $msg="OK";
                endif;
                $ajo=array(
                    'msg'=>$msg,
                    "reload"=>"tcate_".$df_ip['tag']."_div",
                    "reload_url"=>site_url($final['var_purl'].$df_ip['tag']."/list/".$df_ip['key_id']."/"),
                    'pass'=>1
                );
                $final['response_type']='ajax';
                $final['ajax_output']=$this->CM->tag_pack($ajo); 
            break;            
        endswitch;
        //echo $df_ip['ac']."-".$df_ip['pg'];
        return $final;  
    }    
    function facebook_keyword($df_ip=array())   //促銷關鍵字
    {   global $_G;
        $final['field_pre']=$this->field_pre;
        $final['response_type']='normal';
        $mm_set='mm_areaad_set';
        $mm_cc='mm_common_css';
        $up_f=array();//,"c_bpartner_id","jec_brand_id"
        $p_data=explode("_",$df_ip['chinfo']);
        $final['search_word']=isset($_POST['search_word'])?$_POST['search_word']:''; 
        switch($df_ip['ac']):
            case 'edit': 
                $this->CM->Unique_Load_Lib('form_input');
                $kwi_set=$this->CM->Init_TB_Set('mm_keywordinfo_set');
                $kwik_set=$this->CM->Init_TB_Set('mm_keywordinfokind_set');
                $kwik_id=$this->$kwik_set['mm_set']->mm_spec_kind_id('facebook'); 
                $final['selected_data']=$this->GM->common_ac('list',array('info'=>$kwi_set['mm_set'],'type'=>'join_keyword','data'=>array('ob_jec_keyword.countquery'=>'DESC','con_'.$kwi_set['mm_tb'].'.isactive'=>'Y','con_'.$kwi_set['mm_tb'].'.datakeyid'=>$df_ip['key_id'],'con_'.$kwi_set['mm_tb'].'.'.$kwik_set['mm_kid']=>$kwik_id)));

                $final['tb_cols']=5;
                $final['input_info']=array(
                        'type'=>'checkbox'
                    );   
                $final['selected_array']=$this->CM->array_input('jec_keyword_id',$final['selected_data']);
                
                //search_result
                $final['search_word']=urldecode($final['search_word']);
                $final['main_list']=array();
                if($final['search_word']!=''):
                    $kw_set=$this->CM->Init_TB_Set('mm_keyword_set');
                    $final['main_list']=$this->GM->common_ac('list',array('info'=>$kw_set['mm_set'],'type'=>'def','data'=>array('con_'.$kw_set['mm_tb'].'.isdisplayed'=>'Y','con_'.$kw_set['mm_tb'].'.isactive'=>'Y','like_'.$kw_set['mm_tb'].'.name'=>$final['search_word'])));
                endif;
            break;
            case 'update'://只放此處有編的
                $keyword_kind_tag='facebook';
                $keyword_add_field_pre='kwa';
                $keyword_del_field_pre='kwd';
                $keyword_refresh_string='Y';
                
                include ('tools/common/keyword_update.php');
                //represh頁面/重整
                /*
                ?><script>
                    parent.mmm_ajax_load('ccate_<?php echo $df_ip['tag'];?>_div','<?php echo site_url($this->m_controller."/".$df_ip['s_cate']."_mng/".$df_ip['tag']."/edit/".$df_ip['key_id']."/".$df_ip['ob']."/".$df_ip['ot']."/".$df_ip['np']."/");?>','','<?php echo $_POST['fix_search_keyword'];?>');
                </script><?php*/
                $browser = get_browser(null, true);
                ?><script>
                    var isFirefox = navigator.userAgent.search("Firefox") > -1; 
                    var isOpera = navigator.userAgent.search("Opera") > -1; 
                    var isSafari = navigator.userAgent.search("Safari") > -1;
                    var isIE = navigator.userAgent.search("MSIE") > -1; 
                    if(isIE){
                        parent.mmm_ajax_load('ccate_<?php echo $df_ip['tag'];?>_div','<?php echo site_url($this->m_controller."/".$df_ip['s_cate']."_mng/".$df_ip['tag']."/edit/".$df_ip['key_id']."/".$df_ip['ob']."/".$df_ip['ot']."/".$df_ip['np']."/");?>','','<?php echo iconv("utf-8","big5",$_POST['fix_search_keyword']);?>'); 
                        document.execCommand("stop");
                    }
                </script><?php
                if($browser['browser']!='IE'):
                    ?><script>
                    if(isFirefox||isOpera||isSafari){
                        parent.mmm_ajax_load('ccate_<?php echo $df_ip['tag'];?>_div','<?php echo site_url($this->m_controller."/".$df_ip['s_cate']."_mng/".$df_ip['tag']."/edit/".$df_ip['key_id']."/".$df_ip['ob']."/".$df_ip['ot']."/".$df_ip['np']."/");?>','','<?php echo $_POST['fix_search_keyword'];?>');                        
                    }
                    </script><?php
                endif;
                $final['response_type']='';
            break;
        endswitch;
        //echo $df_ip['ac']."-".$df_ip['pg'];
        return $final;          
    }  
    
    function menuservice($df_ip=array())  //說明
    {   global $_G;
        $final=$this->MAD->model_common_pass();
        $final['field_pre']=$this->field_pre;
        $final['response_type']='normal';
        $mm_set='mm_areamenu_set';
        $up_f=array('name','menutype');
        $final['ccate_ptag']='menuservice';
        $final['ccate_menu']=array(
            'menuservice'=>array(
                    'title'=>'菜單',
                    'index'=>'list'
                ),
            'equip'=>array(
                    'title'=>'設備',
                    'index'=>'list'
                ),
            'service'=>array(
                    'title'=>'服務',
                    'index'=>'list'
                )
        );    
        $final=$this->CM->get_df_url($final,$df_ip);
        include $this->m_lib_folder."menuservice.php";
        //echo $df_ip['ac']."-".$df_ip['pg'];
        return $final;        
    }
    function equip($df_ip=array())  //說明
    {   global $_G;
        $final['field_pre']=$this->field_pre;
        $final['response_type']='normal';
        $mm_set='mm_areamenu_set';
        $up_f=array();
        $final=$this->CM->get_df_url($final,$df_ip);
        include $this->m_lib_folder."equip.php";
        //echo $df_ip['ac']."-".$df_ip['pg'];
        return $final;        
    }
    function service($df_ip=array())  //說明
    {   global $_G;
        $final['field_pre']=$this->field_pre;
        $final['response_type']='normal';
        $mm_set='mm_areamenu_set';
        $up_f=array('seqno','ad_image_id','service_no');
        $final=$this->CM->get_df_url($final,$df_ip);
		//incldue
		include $this->m_lib_folder."service.php";
		
        //echo $df_ip['ac']."-".$df_ip['pg'];
        return $final;        
    }    
                                 
}

?>