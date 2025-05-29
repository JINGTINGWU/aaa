<?php
        switch($_G['response_type']):
            case 'normal':
                $this->CM->PGV($_G['df_ip']);
                $_G['var_surl']=$_G['ob']."/".$_G['ot']."/".$_G['np']."/";
                $_G['var_url']=$_G['key_id']."/".$_G['var_surl'];
                $_G['var_purl']=$this->m_controller."/".$s_cate."_mng/";
                $_G['this_view']=$this->MAD->get_page_view($this->m_controller,$s_cate);
                $this->MAD->add_init_set($this->mm_init_set);
				$_G['tcate_menu']=$this->$MDST->m_tcate;
				$_G['G']=$_G;

                $this->load->view($_G['P_this_view'],$_G);             
            break;
            case 'bk_ac':
                if(isset($_G['acbk_div'])&&$_G['acbk_div']!=''):
                    $this->CM->JS_Load($_G['acbk_div'],$_G['acbk_url'],"p");
                else:
                    $this->CM->JS_Link($_G['acbk_url'],"p");
                endif;
            break;
            case 'ajax':
                echo $_G['ajax_output'];
            break;
        endswitch;
?>