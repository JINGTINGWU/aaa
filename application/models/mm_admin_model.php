<?php 
if (!defined('BASEPATH')) exit('No direct script access allowed');

class Mm_admin_model extends CI_Model 
{   //後台管理// 
    var $mm_blank_ac=array('update','del');
    function __construct() 
    {   global $_G;
        parent::__construct();
    }
    
    function save_init_set()
    {   global $_G;
        $final=array();
        foreach($_G as $st=>$sv):
            $final[$st]=$sv;
        endforeach;
        return $final;
    }
    
    function sys_right_check()
    {   //2,設定,Y;3,網頁,Y;4,場地,Y;5,分類,Y;6,商品,Y;7,活動,Y;8,金物,Y;9,訂單,Y;10,會員,Y;11,廣告,Y;12,客服,Y;13,關鍵字,Y;14,統計,Y;
        //explode-
        //user_id取得role_id
        //$this->ad_id-//@@-
    }
    
    function model_common_pass()
    {   global $_G;//first
        $final=array();
        $info=array('noplate');
        foreach($info as $value):
            if(isset($_G[$value])) $final[$value]=$_G[$value];
        endforeach;
        return $final;
    }
    
    function add_init_set($init_data=array())
    {   global $_G;
        if(isset($_G['noplage'])) echo 'add_init_set<br>';
        foreach($init_data as $st=>$sv):
            if(!isset($_G[$st])) $_G[$st]=$sv;
        endforeach;
        $def_info=$this->def_info;
        $_G['tcate_menu']=array();
        
        //---------common set
        $_G['L_CS']='mm_common_set';
        $this->CM->Unique_Load_Lib($_G['L_CS']);
        //---------common set
        //echo $_G['noplate'];
        if(isset($def_info['MDST'])):
            $MDST=$def_info['MDST'];
            $_G['tcate_menu']=$this->$MDST->m_tcate;
            if((isset($_G['show_plate'])&&$_G['show_plate']=='Y'))://($_G['tag']==$this->$MDST->m_index&&$_G['ac']=='list')||
                //echo $_G['this_view']."<";
                //&&(!isset($_G['noplate'])||$_G['noplate']!='Y')
                $_G['P_this_view']='def_template';  
            else:
               // echo $_G['this_view']."<";
                if(in_array($_G['ac'],$this->mm_blank_ac)):
                    $_G['P_this_view']='common/blank';
                else:
                    $_G['P_this_view']=$_G['this_view']; 
                endif;                                 
            endif;
        endif;  
    }
    
    function refresh_page_check()
    {   global $_G;
        if(isset($_G['acbk_refresh_url'])&&isset($_G['acbk_refresh_div'])):
            ?><script>parent.ECP_Load_Div('<?=$_G['acbk_refresh_div']?>','<?=$_G['acbk_refresh_url']?>);</script><?php
        endif;        
    }
    
    function get_page_view($cate='ecp_merchandise_gift',$s_cate='base_prod_gift')
    {   global $_G;
        $info=$this->get_admin_menu();
        $def_info=$this->def_info;
        if(isset($def_info['MDST'])):
            $MDST=$def_info['MDST'];
            $_G['admin_smenu']=$this->get_admin_smenu($this->m_controller);
            $_G['tcate_menu']=$this->$MDST->m_tcate;
            //echo $_G['tag']."-".$_G['ac'];
            if(isset($_G['assign_view'])&&$_G['assign_view']!=''):
                return "".$cate."/".$s_cate."/".$_G['assign_view']; 
            else:
                if($_G['tag']==$this->$MDST->m_index&&$_G['ac']=='list'):          
                    return "".$cate."/".$s_cate."/index";
                else:
                    if($_G['tag']==$this->$MDST->m_index&&$_G['ac']=='edit'):
                        //echo isset($_G['noplate'])?$_G['noplate']."<===":"-";
                        if(isset($_G['noplate'])&&$_G['noplate']=='Y'):
                            return "".$cate."/".$s_cate."/".$_G['tag']."_".$_G['ac'];
                        else:
                            return "".$cate."/".$s_cate."/edit_plate";
                        endif;    
                    else:
                        return "".$cate."/".$s_cate."/".$_G['tag']."_".$_G['ac'];  
                    endif;                                
                endif;            
            endif;

        endif;          
        
    }
	function get_table_id($table_name='')
    {
        $mm_set='mm_ad_table_set';
        $this->CM->Unique_Load_Lib($mm_set);
        $mm_kid=$this->$mm_set->mm_kid;
        $final=$this->CM->db->where('tablename',$table_name)->get($this->$mm_set->mm_tb)->row()->$mm_kid;//$this->$mm_set->mm_kid
        return $final;
    }   
    
    function get_admin_smenu($m_controller='')
    {   global $_G;
        
        $info=array(
                'ecp_project'=>array(
                    'title'=>'合約管理',
                    'list'=>array(// 3.1.	場地資料列表
                        'create_project'=>array(
                                'title'=>'場地資料列表',
                                'isactive'=>'Y',
                                'url'=>site_url('ecp_project/create_project_mng/')
                            ),
                            /* 
                        'base_room'=>array(
                                'title'=>'宴會廳資料管理',
                                'isactive'=>'Y',
                                'url'=>site_url('ecp_wedding/base_room_mng/')
                            ),*/
                        'area_new'=>array(
                                'title'=>'新增場地資料',
                                'isactive'=>'Y',
                                'url'=>site_url('ecp_wedding/area_new_mng/')
                            ),       
                        'area_define'=>array(
                                'title'=>'自訂欄位設定',
                                'isactive'=>'Y',
                                'url'=>site_url('ecp_wedding/area_define_mng/')
                            ),
                        'area_defineline'=>array(
                                'title'=>'設定欄位選項',
                                'isactive'=>'Y',
                                'url'=>site_url('ecp_wedding/area_defineline_mng/')
                            ),  
                        'area_project'=>array(
                                'title'=>'活動特輯管理',
                                'isactive'=>'Y',
                                'url'=>site_url('ecp_wedding/area_project_mng/')
                            ),  
                        'area_projectnew'=>array(
                                'title'=>'新增活動特輯',
                                'isactive'=>'Y',
                                'url'=>site_url('ecp_wedding/area_projectnew_mng/')
                            ),  
                        'area_enquiry'=>array(
                                'title'=>'婚宴場地洽詢單',
                                'isactive'=>'Y',
                                'url'=>site_url('ecp_wedding/area_enquiry_mng/')
                            )                                                                                                              
                    )
                ), 
                'ecp_kind'=>array(
                    'title'=>'商品分類',
                    'list'=>array(
                        'maintain_kind'=>array(
                                'title'=>'商品分類列表',
                                'isactive'=>'Y',
                                'url'=>site_url('ecp_kind/maintain_kind_mng/'),
                                'need_id'=>'smenu_maintain_kid'
                            ),
                        'maintain_kind2'=>array(
                                'title'=>'商品次分類列表',
                                'isactive'=>'Y',
                                'ismenu'=>'N',
                                'url'=>site_url('ecp_kind/maintain_kind2_mng/')
                            )                                                                                        
                    )
                ),        
                'ecp_merchandise_gift'=>array(
                    'title'=>'商品管理',
                    'list'=>array(
                        'base_prod_gift'=>array(
                                'title'=>'小物商品資料列表',
                                'isactive'=>'Y',
                                'url'=>site_url('ecp_merchandise_gift/base_prod_gift_mng/')
                            ),
                        'prod_new_gift'=>array(
                                'title'=>'新增小物商品資料',
                                'isactive'=>'Y',
                                'url'=>site_url('ecp_merchandise_gift/prod_new_gift_mng/')
                            ),       
                        'prod_define'=>array(
                                'title'=>'自訂欄位設定',
                                'isactive'=>'Y',
                                'url'=>site_url('ecp_merchandise_gift/prod_define_mng/')
                            ),    
                        'prod_defineline'=>array(
                                'title'=>'設定欄位選項',
                                'isactive'=>'Y',
                                'url'=>site_url('ecp_merchandise_gift/prod_defineline_mng/')
                            ),   
                        'prod_project'=>array(
                                'title'=>'活動特輯管理',
                                'isactive'=>'Y',
                                'url'=>site_url('ecp_merchandise_gift/prod_project_mng/')
                            ),
                        'prodproject_new'=>array(
                                'title'=>'新增活動特輯',
                                'isactive'=>'Y',
                                'url'=>site_url('ecp_merchandise_gift/prodproject_new_mng/')
                            ),
                        'prod_cust'=>array(
                                'title'=>'商品客製管理',
                                'isactive'=>'Y',
                                'url'=>site_url('ecp_merchandise_gift/prod_cust_mng/')
                            ),
                        'prodcust_new'=>array(
                                'title'=>'新增商品客製',
                                'isactive'=>'Y',
                                'url'=>site_url('ecp_merchandise_gift/prodcust_new_mng/')
                            )    
                            /*,
                        'prod_supplier'=>array(
                                'title'=>'供應商管理',
                                'isactive'=>'Y',
                                'url'=>site_url('ecp_merchandise/prod_supplier_mng/')
                            ),  
                        'prod_brand'=>array(
                                'title'=>'品牌管理',
                                'isactive'=>'Y',
                                'url'=>site_url('ecp_merchandise/prod_brand_mng/')
                            )    */                                                                                                         
                    )
                ),
                'ecp_merchandise_card'=>array(
                    'title'=>'商品管理',
                    'list'=>array(
                        'base_prod_card'=>array(
                                'title'=>'喜帖商品資料列表',
                                'isactive'=>'Y',
                                'url'=>site_url('ecp_merchandise_card/base_prod_card_mng/')
                            ),
                        'prod_new_card'=>array(
                                'title'=>'新增喜帖商品資料',
                                'isactive'=>'Y',
                                'url'=>site_url('ecp_merchandise_card/prod_new_card_mng/')
                            ),          
                        'prod_define'=>array(
                                'title'=>'自訂欄位設定',
                                'isactive'=>'Y',
                                'url'=>site_url('ecp_merchandise_card/prod_define_mng/')
                            ),    
                        'prod_defineline'=>array(
                                'title'=>'設定欄位選項',
                                'isactive'=>'Y',
                                'url'=>site_url('ecp_merchandise_card/prod_defineline_mng/')
                            ),   
                        'prod_project'=>array(
                                'title'=>'活動特輯管理',
                                'isactive'=>'Y',
                                'url'=>site_url('ecp_merchandise_card/prod_project_mng/')
                            ),
                        'prodproject_new'=>array(
                                'title'=>'新增活動特輯',
                                'isactive'=>'Y',
                                'url'=>site_url('ecp_merchandise_card/prodproject_new_mng/')
                            ),
                        'prod_cust'=>array(
                                'title'=>'商品客製管理',
                                'isactive'=>'Y',
                                'url'=>site_url('ecp_merchandise_card/prod_cust_mng/')
                            ),
                        'prodcust_new'=>array(
                                'title'=>'新增商品客製',
                                'isactive'=>'Y',
                                'url'=>site_url('ecp_merchandise_card/prodcust_new_mng/')
                            )                                                                                                           
                    )
                ),
                'ecp_keyword'=>array(
                    'title'=>'關鍵字管理',
                    'list'=>array(
                        'keywordmain'=>array(
                                'title'=>'詞庫總表',
                                'isactive'=>'Y',
                                'url'=>site_url('ecp_keyword/keywordmain_mng/')
                            ),  
                        'act_keywordsub'=>array(
                                'title'=>'相關詞總表',
                                'isactive'=>'Y',
                                'url'=>site_url('ecp_keyword/act_keywordsub_mng/')
                            ),  
                        'keywordkind'=>array(
                                'title'=>'類別管理',
                                'isactive'=>'Y',
                                'url'=>site_url('ecp_keyword/keywordkind_mng/')
                            ),  
                        'new_keywordmain'=>array(
                                'title'=>'新增詞庫',
                                'isactive'=>'Y',
                                'url'=>site_url('ecp_keyword/new_keywordmain_mng/')
                            ),  
                        'keywordsub'=>array(
                                'title'=>'編輯相關詞',
                                'isactive'=>'Y',
                                'url'=>site_url('ecp_keyword/keywordsub_mng/')
                            )
                                                                                                            
                    )
                )
                
                
                
            );  
            if($this->ad_rolerange==2):
                $unset_array=array('ecp_wedding'=>array('area_define','area_defineline','area_project','area_projectnew'),'ecp_merchandise'=>array('prod_define','prod_defineline','prod_project','prodproject_new','prod_cust','prodcust_new'));
                foreach($unset_array as $st=>$sv):
                    foreach($sv as $vv):
                        unset($info[$st]['list'][$vv]);
                    endforeach;
                endforeach;
            endif;
            if(isset($info[$m_controller])):
                return $info[$m_controller];
            else:
                return array();
            endif;     
    } 
    
    function get_admin_menu()
    {   global $_G; //讀資料庫取權限
        if(isset($_G['ad_rolerange'])):
            $info=$this->db->where('parentid',0)->where('menurange',$_G['ad_rolerange'])->where('isactive','Y')->order_by('seqno','ASC')->get('jec_menu')->result_array();
            $fo=0;
            foreach($info as $value):
                $sub_list=$this->db->where('parentid',$value['jec_menu_id'])->where('isactive','Y')->order_by('seqno','ASC')->get('jec_menu')->result_array();
                $info[$fo]['sub_list']=$sub_list;
                $fo++;
            endforeach;
        else:
            $info=array();
        endif;
        return $info;    
    }
    
                                 
}

?>