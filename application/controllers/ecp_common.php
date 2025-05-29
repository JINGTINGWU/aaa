<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Ecp_common extends CI_Controller 
{
    var $mm_base_url='';
    var $m_controller='ecp_common';
    var $m_pp=10; //統一的每頁筆數  
    var $var_to_array='common/var_to_array.php';
    var $def_info=array(
            'MDST'=>'ECPM'
        );
    var $df_array=array('tag','ac','np','key_id','ob','ot','pp','seg','s_cate','MDST','chinfo');    
    var $mm_init_set=array();  
    var $mm_content_id="ecp_content";  
    var $mm_acbk_div='ecp_content';
    var $ad_id=1;//管理者id
    //var $ad_client_id=MM_Client_Id;
    var $ad_org_id=1000000;//商店 id
    var $ad_right_number=6;
    var $ad_rolerange=2;

    
    function __construct() 
    {   
        parent::__construct();
		@session_start();
		$this->load->model('ecp_logincheck2');
		if (! $this->ecp_logincheck2->login_check()) header('Location: '.base_url());
        //$this->core->init();
		$this->load->model('Get_model','GM',True);
		$this->load->model('Common_model','CM',True);
		$this->load->model('Mm_admin_model','MAD',True);

		global $_G;

		$loginparameters = $this->session->userdata(LOGIN_SESSION);
		$this->ad_id=$loginparameters['jec_user_id'];
        $_G['admin_menu']=$this->MAD->get_admin_menu();
        $_G['mm_js']=array('jquery');
        $_G['L_CS']='mm_common_set'; $this->CM->Unique_Load_Lib($_G['L_CS']);
        $this->mm_init_set=$this->MAD->save_init_set();
		$this->load->model('ecp_loadmenu');
		$this->navigation=$this->ecp_loadmenu->load_menu();
    }
	function download_file($id=0,$tag=0)
	{
		 $id=(int)($id);
		 $file=$this->CM->db->where('jec_projfile_id',$id)->where('isactive','Y')->get('jec_projfile')->result_array();
		 if(count($file)>0):
		 	$filename=$file[0]['filename'];
			$path=$file[0]['filepath'];
			//$filename=iconv('utf-8','big5',$filename);
			$file_exist = file_exists('C:/xampp/htdocs/pmstest/'.$path.$filename);
			$file_size = filesize('C:/xampp/htdocs/pmstest/'.$path.$filename);
		 else:
		 	exit();
		 endif;
		 //$filename=iconv('utf-8','big5',$filename);
		 
         @header('Pragma: public');
         @header('Expires: 0');
         @header('Last-Modified: ' . gmdate('D, d M Y H:i ') . ' GMT');
         @header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
         @header('Cache-Control: private', false);
         //@header('Content-Type: application/octet-stream;charset=utf-8;');
         @header('Content-Type: application/octet-stream;');
         @header('Content-Length: '.$file_size);
         @header('Content-Disposition: attachment; filename="' . $this->CM->ReadFileName('download',$filename) . '";');
         @header('Content-Transfer-Encoding: binary');//utf-8 / binary
         @readfile($path.$this->CM->ReadFileName('read',$filename));	
/*
		?>
		<script>
		window.open('<?php echo base_url().$path.$this->CM->ReadFileName('save',$filename);?>','','');
		</script>
		<?php
			//$this->CM->JS_Link(base_url().$path.$this->CM->ReadFileName('save',$filename),'self');
*/
	}
	/*
	function download_file($filename='',$path='',$tag=0)
	{
		$filename=base64_decode($filename);
		$path=base64_decode($path);
         @header('Pragma: public');
         @header('Expires: 0');
         @header('Last-Modified: ' . gmdate('D, d M Y H:i ') . ' GMT');
         @header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
         @header('Cache-Control: private', false);
         @header('Content-Type: application/octet-stream');
         //@header('Content-Length: ' . $file_size);
         @header('Content-Disposition: attachment; filename="' . $filename . '";');
         @header('Content-Transfer-Encoding: binary');//utf-8
         @readfile($path.$filename);	
	}*/
	
	
    function index($tag='project_new_index',$ac='edit',$key_id=0,$ob='created',$ot='DESC',$np=0,$chinfo='')
    {   global $_G; 
		//
    }
	
	function testtest()
	{
		//phpinfo();
		//$mssqlef=$this->load->database('mssqlef',TRUE);
		$mssqlerp=$this->load->database('mssqlerp',TRUE);
		//$final['test']=$mssqlerp->get('ressa')->result_array();//->order_by('ScriptSheetNo','DESC')->limit(200,0)
		$final['test']=$mssqlerp->query("SELECT * FROM ressa ")->result_array();
		$this->load->view('testtest',$final);
		//$num=2;
		//$len=4;
		//printf("%0".$len."d", $num);
		//$mssqlerp=$this->load->database('mssqlerp',TRUE);
	}
	
	function delete_file($bk_action='',$key_id=0)
	{//delete_file/reload_file_list
		//delete_file
		$this->CM->db->where('jec_projfile_id',$key_id)->update('jec_projfile',array('isactive'=>'N'));		$file_name=$this->GM->GetSpecData('jec_projfile','filename','jec_projfile_id',$key_id);
		
		$this->CM->db->where('jec_projfile_id',$key_id)->update('jec_projfile',array('isactive'=>'N'));
		
		$save_folder='uploads/project_file/';
		@unlink($save_folder.$this->CM->ReadFileName('read',$file_name));

		echo '<pass>1</pass>';
		echo '<msg>已刪除。</msg>';
		if($bk_action!='') echo '<bk_action>'.$bk_action.'</bk_action>';
	}	
	
    function phrase_search_div($target_id='',$phrasetype=0,$s_word='')
    {   global $_G; 
		
		$_G=array_merge($_G,array(
				'target_id'=>$target_id,
				'pharsetype'=>$phrasetype,
				's_word'=>$s_word
			));
		$s_word=urldecode($s_word);
		$phrase_set=$this->CM->Init_TB_Set('mm_phrase_set');
		$ip_data=array('orwhere'=>array("phrasetype='1' OR createdby='".$this->ad_id."'"));
		
		$_G['main_list']=$this->GM->common_ac('list',array('info'=>$phrase_set['mm_set'],'type'=>'def','data'=>$ip_data));
		$_G['phrasetype_pdb']=$this->CM->FormatData(array('db'=>$this->$_G['L_CS']->common_use_ld('phrasetype'),'key'=>'id','vf'=>'name'),'page_db',1);
		$this->load->view("common/phrase_search_div",$_G); 
    }
	
	function search_select($type='',$word='')
	{	global $_G;
		$word=urldecode($word);
		$_G['main_list']=array();
		$isSelf='N';
		if(file_exists('tools/common/search_select/'.$type.'.php')):
			include('tools/common/search_select/'.$type.'.php');
		endif;
		$this->load->view("common/search_select/".$type,$_G); 
	}
	function search_select_self($type='',$word='')
	{	global $_G;
		$word=urldecode($word);
		$_G['main_list']=array();
		$isSelf='Y';
		if(file_exists('tools/common/search_select/'.$type.'.php')):
			include('tools/common/search_select/'.$type.'.php');
		endif;
		$this->load->view("common/search_select/".$type,$_G); 
	}
	
	function search_select_con($type='',$kid=0,$word='')
	{	global $_G;
		$word=urldecode($word);
		$_G['main_list']=array();
		$isSelf='N';
		if(file_exists('tools/common/search_select/'.$type.'.php')):
			include('tools/common/search_select/'.$type.'.php');
		endif;
		$this->load->view("common/search_select/".$type,$_G); 
	}
	function search_select_con_self($type='',$kid=0,$word='')
	{	global $_G;
		$word=urldecode($word);
		$_G['main_list']=array();
		$isSelf='Y';
		if(file_exists('tools/common/search_select/'.$type.'.php')):
			include('tools/common/search_select/'.$type.'.php');
		endif;
		$this->load->view("common/search_select/".$type,$_G); 
	}
	
    function file_upload_div($type='',$key_id=0,$bk_action='')//
    {   global $_G; 
		$this->CM->close_cache();
		$_G['temp_folder']='up_'.date('Y-m-d-H-i-s').'_'.rand(11,99);
		$_G['upload_url']=site_url('ecp_common/file_upload_ac/'.$_G['temp_folder'].'/'.$type.'/'.$key_id.'/'.$bk_action.'/');
		$_G['save_url']=site_url('ecp_common/file_upload_save/'.$_G['temp_folder'].'/'.$type.'/'.$key_id.'/'.$bk_action.'/');
		$_G['dump_url']='';
		$this->load->model('File_model','FM',True);
		$this->FM->delete_temp_folder($_G['temp_folder']);
		$this->FM->prepare_temp_folder($_G['temp_folder']);
		/*
		switch($type):
			case 'project_list':
				
				break;
		endswitch;
		*/
		$this->load->view("common/file_upload_div",$_G); 
    }
	
    function file_upload_div_rp($type='',$key_id=0,$bk_action='')//
    {   global $_G; 
		//$_G['temp_folder']='up_'.date('Y-m-d-H-i-s').'_'.rand(11,99);
		$_G['temp_folder']=$type.$key_id;
		$_G['upload_url']=site_url('ecp_common/file_upload_ac/'.$_G['temp_folder'].'/'.$type.'/'.$key_id.'/'.$bk_action.'/');
		$_G['save_url']=site_url('ecp_common/file_upload_save/'.$_G['temp_folder'].'/'.$type.'/'.$key_id.'/'.$bk_action.'/');
		$_G['dump_url']='';
		$this->load->model('File_model','FM',True);
		$this->FM->delete_temp_folder($_G['temp_folder']);
		$this->FM->prepare_temp_folder($_G['temp_folder']);
		/*
		switch($type):
			case 'project_list':
				
				break;
		endswitch;
		*/
		$this->load->view("common/file_upload_div",$_G); 
    }
	
    function file_upload_ac($folder='',$type='',$key_id=0,$bk_action='')
    {   global $_G; 
		$targetDir='uploads/'.MM_Common_Temp.$folder.'/';
		$target_folder=$targetDir;
		//$ad_id=$this->ad_id;
		include('tools/common/upload_ac.php');
		//insert_data
		//$ac_file='tools/common/upload_ac/add/'.$type.'.php';	
		
		//if(file_exists($ac_file)) include_once $ac_file;
    }	
	
	function file_upload_save($folder='',$type='',$key_id=0,$bk_action='')
	{	//save
		ignore_user_abort(true);
		set_time_limit(0); 
		$no_save=array('rp_finish','rp_adjust','rp_transfer','rp_impossible','rp_pause','rp_transfer_superuser');
		//
			
		if(in_array($type,$no_save)):
			//要整理出存留的
			$target_folder='uploads/'.MM_Common_Temp.$folder.'/';
			
			$content=strtolower($_POST['content']);	
			$as_content=fopen($target_folder.'already_saved.txt','a+');
			
			$content=$this->CM->GetString($content,'檔案大小','新增檔案');
		//fwrite($test,"\n".$content);
			$content_array=$this->CM->GetRow($content,'<tr','</tr>');
			//$keep_info=array();
			foreach($content_array as $value):
			//$etr=$this->CM->GetString($value,'<tr','</tr>');
				if($this->CM->InStr($value,'id="')):
					$e_id=$this->CM->GetString($value,'id="','"');
				else:
					if(strpos($_SERVER[HTTP_USER_AGENT], "MSIE 7.0")):
						$e_id=trim($this->CM->GetString($value,'id=','>'));
					else:
						$e_id=trim($this->CM->GetString($value,'id=','class'));
					endif;
					//$e_id=trim($this->CM->GetString($value,'id=','class'));
				endif;
				//$e_id=$this->CM->GetString($value,'id="','"');
				$e_filename=$this->CM->GetString($value,'<span>','</span>');
				$sub_name=$this->CM->FormatData($e_filename,'file',2);
				$up_name=$e_id.'.'.$sub_name;
				//array_push($keep_info,$up_name);
				fwrite($as_content,"<ef>".$e_filename."@@@@@@@@@@".$up_name."</ef>");
			endforeach;
			fclose($as_content);
			$bk_action="reload_file_list";
		else:
		
			$target_folder='uploads/'.MM_Common_Temp.$folder.'/';
			//$save_record=fopen($target_folder.'save_record.txt','a+');
			if(file_exists($target_folder.'upload_list.txt')):
				$uploaded=file_get_contents($target_folder.'upload_list.txt');
			else:
				$uploaded='';
			endif;
		
		//$uploaded_list=explode('\n',$uploaded);
			$uploaded_list=$this->CM->GetRow($uploaded,'<ef>','</ef>');
			$uploaded_info=array();
			foreach($uploaded_list as $value):
				$eid=trim($this->CM->GetString($value,'','@@@@@@@@@@'));
				array_push($uploaded_info,$eid);
			//fwrite($save_record,"\n\n".$eid."===".$type);
			endforeach;
		
		//already_saved
			if(file_exists($target_folder.'already_saved.txt')):
				$saved=file_get_contents($target_folder.'already_saved.txt');
			else:
				$saved='';
			endif;
			$saved_list=$this->CM->GetRow($saved,'<ef>','</ef>');
			$saved_info=array();
			$saved_key=array();
			foreach($saved_list as $value):
			//$eid=trim($value);
				$eid=trim($this->CM->GetString($value,'','@@@@@@@@@@'));
				array_push($saved_info,$eid);
				$efid=trim($this->CM->GetString($value,'@@@@@@@@@@',''));
				$saved_key[$eid]=$efid;
			//fwrite($save_record,"\n\n".$eid."===".$type);
			endforeach;		
		
			$content=strtolower($_POST['content']);
			//$this->CM->JS_Msg($content);
		//$test=fopen($target_folder.'excuse_me.txt','a+');
		//fclose($test); 
		//
		
			$content=$this->CM->GetString($content,'檔案大小','新增檔案');
			//$tt=fopen('uploads/cccccc.txt','a+');
			//fwrite($tt,$HTTP_SERVER_VARS['HTTP_USER_AGENT']."\n".$content);
			//fclose($tt);
			$content_array=$this->CM->GetRow($content,'<tr','</tr>');
			$keep_info=array();
			foreach($content_array as $value):
			//$etr=$this->CM->GetString($value,'<tr','</tr>'); --
				if($this->CM->InStr($value,'id="')):
					$e_id=$this->CM->GetString($value,'id="','"');
				else:
					if(strpos($_SERVER['HTTP_USER_AGENT'], "MSIE 7.0")):
						$e_id=trim($this->CM->GetString($value,'id=','>'));
					else:
						$e_id=trim($this->CM->GetString($value,'id=','class'));
					endif;
				endif;
				
				$e_filename=$this->CM->GetString($value,'<span>','</span>');
				$sub_name=$this->CM->FormatData($e_filename,'file',2);
				$up_name=$e_id.'.'.$sub_name;
				array_push($keep_info,$up_name);
			endforeach;
		//整理要刪除的。
		
		//delete_ac
			$ac_file='tools/common/upload_ac/delete/'.$type.'.php';	
			if(file_exists($ac_file)) include ($ac_file);
			$this->load->model('File_model','FM',True);
			$this->FM->delete_temp_folder($folder);
		//reply ajax--Excuse Me.
		//refreash
		
		endif;

		echo '<pass>1</pass>';
		if($bk_action!='') echo '<bk_action>'.$bk_action.'</bk_action>';
	}
	
	function save_pg_session($type='')
	{
		if(isset($_SESSION[$type])):
			foreach($_SESSION[$type] as $st=>$sv):
				if(isset($_POST[$st])) $_SESSION[$type][$st]=$_POST[$st];		
			endforeach;
		endif;
		echo '<pass>1</pass><bk_action>refresh_search</bk_action>';
		/*
		if(file_exists('tools/common/pg_sess/'.$type.'.php')):
			include('tools/common/pg_sess/'.$type.'.php');
		endif;
		*/
	}
	function save_session($type='')
	{
		ignore_user_abort(true);
		if(isset($_SESSION[$type])):
			foreach($_SESSION[$type] as $st=>$sv):
				if(isset($_POST[$st])) $_SESSION[$type][$st]=$_POST[$st];		
			endforeach;
		endif;
		echo '<pass>1</pass><bk_action>get_test_sess</bk_action>';
	}
	
	function select_prepare_item($project_id=0)
	{	//勾選備品清單-
	$prodprep_v_set=$this->CM->Init_TB_Set('mm_productprep_search_set');
	$ip_data=array('con_jec_project_id'=>$project_id,'con_isactive'=>'Y','ob_seqno'=>'ASC');
	$final['main_list']=$this->GM->common_ac('list',array('info'=>$prodprep_v_set['mm_set'],'type'=>'def','data'=>$ip_data));
	$this->load->view("common/select_prepare_item",$final);
	}
	
	function import_prepare_item()
	{	//select_string,projtask_id,project_id
	$gv=array('select_string','projtask_id','project_id');
	$gv=$this->CM->GPV($gv);//
	$costtype=$this->GM->GetSpecData('jec_project','costtype','jec_project_id',$gv['project_id']);
	//先取得未有的
	
	$selected_array=explode(',',$gv['select_string']);
	$prodprep_set=$this->CM->Init_TB_Set('mm_productprep_set');
	$projp_set=$this->CM->Init_TB_Set('mm_projprod_set');
	$prodo_set=$this->CM->Init_TB_Set('mm_productopen_set');
	$projt_set=$this->CM->Init_TB_Set('mm_projtask_set');
	$mm_tb=$prodprep_set['mm_tb'];
	$ip_data=array('con_'.$mm_tb.'.jec_project_id'=>$gv['project_id'],'con_'.$mm_tb.'.isactive'=>'Y','con_'.$mm_tb.'.isexport'=>'N');	//
	$final['main_list']=$this->GM->common_ac('list',array('info'=>$prodprep_set['mm_set'],'type'=>'join_prod','data'=>$ip_data));
	$seqno=$this->$projp_set['mm_set']->get_projprod_series($gv['projtask_id'])-1;
	
	foreach($final['main_list'] as $value):
	if(in_array($value['jec_productprep_id'],$selected_array)):
	//
	$seqno++;
	$upd=array(
			'jec_project_id'=>$gv['project_id'],
			'jec_projtask_id'=>$gv['projtask_id'],
			'jec_product_id'=>$value['jec_product_id'],
			'prodtype'=>'',
			'quantity'=>$value['quantity'],
			'price'=>$value['price'],
			'total'=>$value['total'],
			'startdate'=>$value['startdate'],
			'prodname'=>$value['prodname'],
			'prodspec'=>$value['prodspec'],
			'prod_uom_id'=>$value['prod_uom_id'],
			'description'=>$value['description'],
			'jec_vendor_id'=>$value['jec_vendor_id'],
			'cost'=>$value['price'],
			'seqno'=>$seqno,
			'jec_productprep_id'=>$value['jec_productprep_id']
	);//
	$upd=array_merge($upd,$this->CM->Base_New_UPD());//
	if($value['jec_product_id']>0):
	$upd['cost']=$this->$projp_set['mm_set']->get_erp_cost($upd['jec_product_id'],$costtype);	//取得prodtype...
	$upd['costtime']=date("Y-m-d H:i:s");
	if($value['prodtype']==8)://新增自訂的
	//$sgv=array("value","description",'jec_uom_id','name','specification'); $sgv=$this->CM->NFGV($sgv,array('post_sur_tag'=>'_spec'));
	$sgv=array(
			'value'=>$value['value'],
			'description'=>$value['description'],
			'jec_uom_id'=>$value['prod_uom_id'],
			'name'=>$value['prodname'],
			'specification'=>$value['prodspec']
	);
	$supd=array_merge($sgv,$this->CM->Base_New_UPD());
	$supd['price']=$upd['price'];
		
	$this->GM->common_ac('insert',array('info'=>$prodo_set['mm_set'],'upt'=>'def','upd'=>$supd));
	$upd['jec_productopen_id']=mysql_insert_id();
	endif;
	else:
	$upd['cost']=0;
	endif;
	//insert
	$upd['extramultiple']=1;
	$upd['extraaddition']=0;
	$upd['estimcostcalc']=$upd['total']*$upd['extramultiple']+$upd['extraaddition'];
	$upd['salecostcalc']=$upd['cost']==0?$upd['estimcostcalc']:$upd['cost']*$upd['quantity']*$upd['extramultiple']+$upd['extraaddition'];
	
	if((int)$upd['jec_product_id']==0) $upd['jec_product_id']=NULL;
	$this->GM->common_ac('insert',array('info'=>$projp_set['mm_set'],'upt'=>'def','upd'=>$upd));
	/**/
	//up isexport.
	$this->GM->common_ac('update',array('info'=>$prodprep_set['mm_set'],'upt'=>'def','upd'=>array('exporttime'=>date('Y-m-d H:i:s'),'isexport'=>'Y'),'kid'=>$value['jec_productprep_id']));
	$this->db->where($projt_set['mm_kid'],$gv['projtask_id'])->update($projt_set['mm_tb'],array('isprojprod'=>'Y'));	endif;
	endforeach;
	//refresh_bak ...
	echo '<pass>1</pass><bk_action>after_import_selected</bk_action>';
	}
	
	
	function get_dept_by_saler()
	{
		$user_id=(int)$_POST['user_id'];
		if($user_id==0):
			$dept_id=0;
		else:
			$dept_id=$this->GM->GetSpecData('jec_user','jec_dept_id','jec_user_id',$user_id);
		endif;
		echo '<pass>1</pass><bk_action>change_dept_id</bk_action><dept_id>'.$dept_id.'</dept_id>';
	}
	
	function get_purchase_list_by_dept()
	{
		$dept_id=$_POST['dept_id'];
		if($dept_id==''):
			$purchase_list="<option>--請選擇--</option>";
		else:
			//- - id>>Name
			$os=$this->CM->db->where('noticetype','OS')->where('isactive','Y')->get('jec_setup')->result_array();
			$os=strtolower($os[0]['value']);
			$istrans=$os=='linux'?'Y':'N';
			$dept_id=$istrans=='Y'?iconv('utf-8','big5',$dept_id):$dept_id;
			
			$this->load->library('form_input');
			$mssqlef = $this->load->database('mssqlef', true);
			$dept_list = $mssqlef->where('ad019005',$dept_id)->select('ad019004')->select('ad019006')->order_by('ad019004','DESC')->get('ad019')->result_array();
			$dept_list=$this->CM->FormatData(array('db'=>$dept_list,'field'=>'ad019004,ad019006','istrans'=>$istrans),'page_db','mssql_ld');
			$ds=array(
					'call_name'=>'',
					'type'=>'select',
					'only_list'=>'Y',
					'id'=>'efprojno',
					'ld'=>$dept_list,
					'ld_key'=>array('ad019004','ad019006'),
					'ld_key_span'=>'>>',
					'ld_value'=>array('ad019004','ad019006')
				);
			$purchase_list=$this->form_input->fi_get_input($ds);
			//$dept_id=$this->GM->GetSpecData('jec_user','jec_dept_id','jec_user_id',$user_id);-
		endif;
		echo '<pass>1</pass><innerId>efprojno</innerId><innerHTML>'.$purchase_list.'</innerHTML>';
	}
	
	function search_ef_proj($s_comparetype=1,$s_searchtype='odmems003005',$s_keyword='___',$dept_no='-',$ob='odmems003005',$ot='DESC')
	{	global $_G;
		//$dept_no=iconv('utf-8','big5',$dept_no);
		$np=0;
		$dept_no=trim(urldecode($dept_no));
		$_G['os']=$this->GM->GetSpecData('jec_setup','value','noticetype','OS');
		$_G['ob']=$ob;
		$_G['ot']=$ot;
		$_G['base_url']=base_url($this->m_controller.'/search_ef_proj/');
		$_G['ob_base_url']=base_url($this->m_controller.'/search_ef_proj/'.$s_comparetype.'/'.$s_searchtype.'/'.$s_keyword.'/'.$dept_no.'/').'/';
		
		$ad005_set=$this->CM->Init_TB_Set('mm_ad005_set');
		
		
		$final['main_data']=array();
		
		$this->load->model('Mm_search_obj','SOBJ',True);
		$this->load->library('form_input');
		$final['ip_info']=$this->SOBJ->get_search_info();
		$ip_info=$this->$ad005_set['mm_set']->load_mm_field_check();
		$final['ip_info']['search_type']=$ip_info['search_type'];
		$final['ip_data']=array_merge($this->SOBJ->get_search_item('def_ef_proj'),array('search_type'));
		$_G['s_main_op']=$this->form_input->each_op_trans($final['ip_data'],$final['ip_info'],$final['main_data']);
		
		$mssqlef=$this->load->database('mssqlefnet',TRUE);
		//$dept_no=iconv('utf-8','big5',$dept_no);
		
		$sql="select odmems003002 from odmems003 left join resda on odmems003001=resda001 and odmems003002=resda002 where (resda021 is null or resda021=2)";
		//$mssqlef->select('odmems003002');
		if($dept_no!=''&&$dept_no!='-'):
			$sql=$sql." and odmems003004C='".$this->CM->db_trans($dept_no,'input')."'";
			//$mssqlef->where('odmems003004C',$this->CM->db_trans($dept_no,'input'));
		endif;
		// Update by Johnson 2013/02/22
		//$mssqlef->where('odmems003020','N');
		$sql=$sql." and odmems003020='N'";
		$total_num=$mssqlef->query($sql)->num_rows();
		
		//$mssqlef->select('*');
		$sql="select * from odmems003 left join resda on odmems003001=resda001 and odmems003002=resda002 where (resda021 is null or resda021=2)";

		if($dept_no!=''&&$dept_no!='-'):
			$sql=$sql." and odmems003004C='".$this->CM->db_trans($dept_no,'input')."'";
			//$mssqlef->where('odmems003004C',$this->CM->db_trans($dept_no,'input'));
		endif;
		// Update by Johnson 2013/02/22
		//$mssqlef->where('odmems003020','N');
		$sql=$sql." and odmems003020='N'";
		$sql=$sql." order by ".$ob." ".$ot;
		
		$_G['main_list']=$mssqlef->query($sql)->result_array();	//->limit($np,20)
		
		$this->GM->total_rows=$total_num;
		$this->GM->per_page=20;
		$this->GM->cur_page=$np;
		//$_G['pd']=$this->GM->page_data(array('now_ot'=>'odmems003002','uri_segment'=>7,'base_url'=>base_url().$this->m_controller.'/search_ef_proj/'.$s_comparetype.'/'.$s_searchtype.'/'.$s_keyword.'/'.$dept_no.'/'));
		
		$this->load->view('common/search_ef_proj_div',$_G);
	}
	
	function check_projno()
	{	global $_G;
		$_G['os']=$this->GM->GetSpecData('jec_setup','value','noticetype','OS');
		$gv=array('projdept','projno'); $gv=$this->CM->GPV($gv);
		$mssqlef=$this->load->database('mssqlef',TRUE);
		$mssqlef->where('ad019004',$this->CM->db_trans($gv['projno'],'input'));
		if($gv['projdept']!='') $mssqlef->where('ad019005',$this->CM->db_trans($gv['projdept'],'input'));
		$test=$mssqlef->order_by('ad019003','DESC')->get('ad019')->result_array();
		if(count($test)==0):
			$pass='N';
			$ad_info='';
		else:
			$pass='Y';
			$ad_info="<projdept>".$this->CM->db_trans($test[0]['ad019005'],'output')."</projdept><projno>".$this->CM->db_trans($test[0]['ad019004'],'output')."</projno><projname>".$this->CM->db_trans($test[0]['ad019006'],'output')."</projname>";
		endif;
		//
		
		echo '<pass>1</pass><isexist>'.$pass.'</isexist><bk_action>projno_check_result</bk_action>'.$ad_info;
	}
	
	function mssql_test()
	{
				$mssqlef = $this->load->database('mssqlef', true);  // 連接ERP資料庫
				//$mssqlerp->limit(10,0);
				//$test = $mssqlerp->get('INVMB')->result_array();
				/*
				foreach($test as $value):
					foreach($value as $st=>$sv):
						echo $st.'-'.$sv.'<br>';
					endforeach;
					//echo $value['ad005004'].'<br>'; ->where('ScriptSheetNo','2012/08/01 15:25:15')
				endforeach;*/
				$test = $mssqlef->order_by('ScriptSheetNo','DESC')->order_by('RecordsetName','DESC')->limit(350,0)->get('ressa')->result_array();
				$final['test']=$test;
				$this->load->view('testtest',$final);
				//$df=$this->load->database('default',TRUE);
	}   
	function Refresh_Link($d='')
	{	/*
		if($d==date('Y-m-d')):
			
			$old_host='http://pms.ems.com.tw/pms/';//原本的
			$new_host='http://pms.ems.com.tw/pmstest/';//新的 http://192.168.1.249/pms/


			$list=$this->CM->db->like('emailcontent',$old_host)->get('jec_projnotice')->result_array();
			foreach($list as $value):
				$new_content=str_replace($old_host,$new_host,$value['emailcontent']);
				$this->CM->db->where('jec_projnotice_id',$value['jec_projnotice_id'])->update('jec_projnotice',array('emailcontent'=>$new_content));
			endforeach;
			echo 'Done';
		endif;*/
	}   

	function MailTest()
	{
		$sender_name='test';
		$sender_email='test@yahoo.com.tw';
		$title="test";
		$content="test";
		$receive_email="person-10529@yahoo.com.tw";
		
		
		require_once("tools/append/PHPMailer/class.phpmailer.php");
		require_once("tools/append/PHPMailer/class.smtp.php");
		
		$mail = new PHPMailer();
		$mail->IsSMTP();
		$mail->SMTPAuth = true; //設定SMTP需要驗證
		//$mail->SMTPSecure = "ssl"; // Gmail的SMTP主機需要使用SSL連線
		$mail->Host = "mail.ems.com.tw"; //Gamil的SMTP主機
		$mail->Port = 25; //Gamil的SMTP主機的SMTP埠位為465埠。
		
		$mail->Username = "pms"; //設定驗證帳號
		$mail->Password = "pms_5050207"; //設定驗證密碼
		$mail->From = $sender_email; //設定寄件者信箱
		$mail->FromName = $sender_name; //設定寄件者姓名
		
		//設定收件者
		$mail->AddAddress($receive_email);
		//設定密件副本
		//$mail->AddBCC("55555@abc.com");
		
		//設定信件字元編碼
		$mail->CharSet="utf-8";
		//設定信件編碼，大部分郵件工具都支援此編碼方式
		$mail->Encoding = "base64";
		//設置郵件格式為HTML
		$mail->IsHTML(true);
		//每50自斷行
		//$mail->WordWrap = 50;
		
		//郵件主題
		$mail->Subject=$title;
		//郵件內容
		$mail->Body = $content; //附加內容
		// $mail->AltBody = '這是附加的信件內容';
		
		//寄送郵件
		if(!$mail->Send()){
			return false;
		}else{
			return true;
		}
	}
}

/* End of file home.php */
/* Location: ./application/controllers/home.php */