<?php
class Import_model extends CI_Model
{
    
    function __construct()
    {
        // 呼叫模型(Model)的建構函數
        parent::__construct();
        //輸入相關的model
        ?><meta http-equiv="Content-Type" content="text/html; charset=utf-8" /><?php
        
    }
    //要有import的報告
    /*
    
    1、無法辨識的字
    2、重覆的
    3、新增的
    
    */
    var $open_target="";
	var $tb_set=array();
	var $cm_var=array();
    
    function ExecImport($file_name,$import_type,$var="")
    {   //執行匯入
        //$this->load->model('Normal_model','NM',True);
        $file_type=$this->CM->FormatData($file_name,"file",2);
        //http:
		
        $con_obj=$this->ReadFile($file_name,$file_type);
        
        //額外增加參數---------------------------------
        switch($import_type)
        {
			/*
            case "books":
                $book_cate=$this->db->where("rbc_mark",0)->order_by("rbc_number","asc")->get(MM_TB_PRE."_book_cate_list")->result_array();
                $book_cate_db=$this->NM->FormatData(array("db"=>$book_cate,"key"=>"rbc_id","vf"=>"rbc_number"),"page_db",1);
                $var['book_cate_db']=$book_cate_db;
            break;*/
			case 'producttempline'://load
				$this->tb_set['projp_set']=$this->CM->Init_TB_Set('mm_projprod_set');
				$this->tb_set['prod_set']=$this->CM->Init_TB_Set('mm_product_set');
				$this->tb_set['prodo_set']=$this->CM->Init_TB_Set('mm_productopen_set');//
				$this->cm_var['seqno']=0;
				$this->cm_var['projt_data']=$var['projt_data'];
			break;
			case 'productprep':
				//$this->tb_set['projp_set']=$this->CM->Init_TB_Set('mm_projprod_set');
				$this->tb_set['prod_set']=$this->CM->Init_TB_Set('mm_product_set');
				$this->tb_set['prodprep_set']=$this->CM->Init_TB_Set('mm_productprep_set');
                                $this->tb_set['projp_set']=$this->CM->Init_TB_Set('mm_projprod_set');
				//$this->tb_set['prodo_set']=$this->CM->Init_TB_Set('mm_productopen_set');//
				//取得max seqno
				//$this->cm_var['seqno']=0;
				//$this->CM->JS_TMsg($var['proj_data']['jec_project_id']);
				$this->cm_var['seqno']=$this->mm_productprep_set->get_productprep_series($var['proj_data']['jec_project_id']);
				$this->cm_var['proj_data']=$var['proj_data'];
				//$this->CM->JS_TMsg('@@@');
			break;
        }
        //---------------------------額外增加參數_end##
        
        $this->SaveData($con_obj,$import_type,$file_type,$var);
        //後續動作
    
    }
    
    
    function  ReadFile($file_name="",$file_type="")
    {   //讀temp_upload裡已上傳的檔，若讀取成功，結束時要刪掉
        //判別檔案類別
		
        $open_target=MM_Tmep_File_Dir.$file_name;
        $this->open_target=$open_target;
        if($file_name==""||!file_exists($open_target))
        {
            return false;
        }
        else
        {
            $final="";            
            if($file_type=="")
            {
                $file_type=$this->CM->FormatData($file_name,"file",2);
            }        
            switch($file_type)
            {
                case "xls":
					
					
                    require_once("append_tools/phpexcel/Classes/PHPExcel.php");  
                    require_once("append_tools/phpexcel/Classes/PHPExcel/IOFactory.php");  
                    require_once("append_tools/phpexcel/Classes/PHPExcel/Reader/Excel5.php");                      
                    $objReader = new PHPExcel_Reader_Excel5();
                    $objReader->setReadDataOnly(true);  
                    $objPHPExcel = $objReader->load($open_target); 
					/*
                    require_once("append_tools/phpexcel/Classes/PHPExcel.php");  
                    require_once("append_tools/phpexcel/Classes/PHPExcel/IOFactory.php");  
                    require_once("append_tools/phpexcel/Classes/PHPExcel/Reader/Excel2007.php");                      
                    $objReader = new PHPExcel_Reader_Excel2007();    
                    $objReader->setReadDataOnly(true);  
                    $objPHPExcel = $objReader->load($open_target); */
					
                    $final=$objPHPExcel;
					
                    //$this->CM->JS_Msg('read_xls');               
                break;
                case "xlsx": 
                    require_once("append_tools/phpexcel/Classes/PHPExcel.php");  
                    require_once("append_tools/phpexcel/Classes/PHPExcel/IOFactory.php");  
                    require_once("append_tools/phpexcel/Classes/PHPExcel/Reader/Excel2007.php");                      
                    $objReader = new PHPExcel_Reader_Excel2007();    
                    $objReader->setReadDataOnly(true);  
                    $objPHPExcel = $objReader->load($open_target);  
					//$this->CM->JS_Msg($open_target);
                    $final=$objPHPExcel;

                break;
                case "csv":
                
                break;
            }
            return  $final;           
        }

    }
    
    function ExcelField($import_type)
    {
        $final="";
        switch($import_type)
        {
			case 'producttempline':
                $final=array(
                        "A"=>"no",
                        "B"=>"jec_product_id",
                        "C"=>"name",
                        "D"=>"specification",
                        "E"=>"price",
                        "F"=>"quantity",
                        "G"=>"vendor_name",
						"H"=>"prodtype"                  
                    ); //
				//$final=array('no','jec_product_id','name','specification','price','quantity','vendor_name');
			break;
			case 'productprep':
                $final=array(                        
                        "C"=>"value",
                        "D"=>"name",
                        "E"=>"specification",
						"F"=>"quantity",
                        "G"=>"price",
						"K"=>"user_name",
						"M"=>"description"
                    ); //
				//$final=array('no','jec_product_id','name','specification','price','quantity','vendor_name');
			break;
            case "area":
                $final=array(
                        "A"=>"name",
                        "B"=>"description",
                        "C"=>"descriptionext",
                        "D"=>"c_city_id",
                        "E"=>"jec_citydistrict_id",
                        "F"=>"postcode",
                        "G"=>"address",
                        "H"=>"url",
                        "I"=>"linkurl",
                        "J"=>"contactname",
                        "K"=>"phone",
                        "L"=>"fax",
                        "M"=>"email",  
                        "N"=>"taxid",
                        "O"=>"title",
                        "P"=>"note"                      
                    );            
            break;
            case "room":
                $final=array(
                        "A"=>"jec_areabase_id",
                        "B"=>"name",
                        "C"=>"floor",
                        "D"=>"description",
                        "E"=>"mintable",
                        "F"=>"maxtable",
                        "G"=>"pricelist",
                        "H"=>"tablenote",
                        "I"=>"areameasure",
                        "J"=>"height"                   
                    ); 
            break;
        }
        return $final;
    }
    
    
    function DataAdjust($import_type="",$update_array=array(),$var=array())
    {   //有額外正處理的值
        /*
        if($var['semester_id']==""||$var['semester_id']==0)
        {   //若無就取當前學期
            $sem_data=$this->NM->GetOnSemester();
        }
        else
        {
            $sem_data=$this->db->where("rs_id",$var['semester_id'])->get(MM_TB_PRE."_semester_list")->row();
        } */
        $final=$update_array;
        switch($import_type)
        {
			case 'producttempline':
				//value.
				$prod_data=$this->mm_product_set->get_product_row($update_array['jec_product_id']);
				if(!isset($prod_data['jec_product_id'])):
					$prod_data=array(
							'name'=>$update_array['name'],
							'specification'=>$update_array['specification'],
							'jec_vendor_id'=>0
						);
					$prod_data['prodtype']=$update_array['prodtype']=='料品'?1:9;
				endif;
				//Get....
				$this->cm_var['seqno']++;
				//get_jec_vendor_id 
				$vendor_data=$this->db->where('name',$update_array['vendor_name'])->get('jec_vendor')->result_array();
				$update_array['jec_vendor_id']=count($vendor_data)>0?$vendor_data[0]['jec_vendor_id']:$prod_data['jec_vendor_id'];
				$final=array(
						'jec_project_id'=>$this->cm_var['projt_data']['jec_project_id'],
						'jec_projtask_id'=>$this->cm_var['projt_data']['jec_projtask_id'],
						'jec_product_id'=>$update_array['jec_product_id'],
						'seqno'=>$this->cm_var['seqno'],
						'quantity'=>$update_array['quantity'],
						'price'=>$update_array['price'],
						'total'=>$update_array['quantity']*$update_array['price'],
						'jec_vendor_id'=>$update_array['jec_vendor_id'],
						'isimport'=>'Y',
						'importtime'=>date('Y-m-d H:i:s'),
						'prodname'=>$prod_data['name'],
						'prodspec'=>$prod_data['specification'],
						'prodtype'=>$prod_data['prodtype']						
					);
				//get_cost
					$costtype=$this->GM->GetSpecData('jec_project','costtype','jec_project_id',$this->cm_var['projt_data']['jec_project_id']);
					$final['cost']=$this->mm_projprod_set->get_erp_cost($final['jec_product_id'],$costtype);				
					$final['costtime']=date("Y-m-d H:i:s");
				
					$final['extramultiple']=1;
					$final['extraaddition']=0;
					$final['estimcostcalc']=$final['total'];//*1
					//$final['salecostcalc']=$final['quantity']*$final['cost'];
					$final['salecostcalc']=$final['cost']==0?$final['estimcostcalc']:$final['cost']*$final['quantity'];
				
				if($prod_data['prodtype']==8)://add_productopen_id
					//add_
					$upd=array(
							'jec_uom_id'=>$prod_data['jec_uom_id'],
							'price'=>$update_array['price'],
							'name'=>$update_array['name'],
							'specification'=>$update_array['specification'],
							'value'=>''
						);
					$upd=array_merge($upd,$this->CM->Base_New_UPD());
					$final['jec_productopen_id']=$this->GM->common_ac('insert',array('info'=>'mm_productopen_set','upt'=>'def','upd'=>$upd));
				endif;
				$final=array_merge($final,$this->CM->Base_New_UPD());
			break;
            case "productprep"://-Done
				$prod_data=$this->mm_product_set->get_product_row($update_array['jec_product_id']);
				
				if(!isset($prod_data['jec_product_id'])):
					$prod_data=array(
							'value'=>$update_array['value'],
							'name'=>$update_array['name'],
							'specification'=>$update_array['specification'],
							'jec_vendor_id'=>0
						);
					$prod_data['prodtype']=$update_array['prodtype']=='料品'?1:9;
				endif;
				//Get....
				$this->cm_var['seqno']++;
				//get_jec_vendor_id 
				$vendor_data=$this->db->where('name',$update_array['vendor_name'])->get('jec_vendor')->result_array();
				//get_jec_product_id
				$product_data=$this->db->where('value',$update_array['value'])->where('value IS Not NULL', null, false)->get('jec_product')->result_array();
				//get_jec_user_id
				$user_data=$this->db->where('name',$update_array['user_name'])->get('jec_user')->result_array();
				$prod_value=isset($prod_data['value'])?$prod_data['value']:'';
				$costtype=$this->GM->GetSpecData('jec_project','costtype','jec_project_id',$this->cm_var['proj_data']['jec_project_id']);
                                $erp_price=$this->get_wferp_cost($prod_value,$costtype);
                                if($erp_price !=0 && $erp_price != $update_array['price'])
                                {
                                    $this->CM->JS_Msg($prod_value."-".$prod_data['name']."匯入單價錯誤，已修正為ERP價格",-1,"error");
                                }
                                else
                                {
                                    $erp_price= $update_array['price'];
                                }
				$update_array['jec_vendor_id']=count($vendor_data)>0?$vendor_data[0]['jec_vendor_id']:$prod_data['jec_vendor_id'];
				$update_array['jec_product_id']=count($product_data)>0?$product_data[0]['jec_product_id']:$prod_data['jec_product_id'];
				$update_array['jec_user_id']=count($user_data)>0?$user_data[0]['jec_user_id']:$prod_data['jec_user_id'];
				$final=array(
						'jec_project_id'=>$this->cm_var['proj_data']['jec_project_id'],
						//'jec_projtask_id'=>$this->cm_var['projt_data']['jec_projtask_id'],
						'value'=>$prod_value,
						'jec_product_id'=>$update_array['jec_product_id'],
						'seqno'=>$this->cm_var['seqno'],
						'quantity'=>$update_array['quantity'],
						'price'=>$erp_price,
						'total'=>$update_array['quantity']*$erp_price,
						'jec_vendor_id'=>$update_array['jec_vendor_id'],
						'jec_user_id'=>$update_array['jec_user_id'],
						//'isimport'=>'Y',
						//'importtime'=>date('Y-m-d H:i:s'),
						'prodname'=>$prod_data['name'],
						'prodspec'=>$prod_data['specification'],
						'description'=>$update_array['description'],
						'prod_uom_id'=>1
					);
				$final=array_merge($final,$this->CM->Base_New_UPD()); 
            break;
        }
        return $final;
    }
    
    function GetImportTableInfo($import_type,$var="")
    {   //輸入資料表的相關資訊-有的為多表
        $final="";
        switch($import_type)
        {
            case "producttempline":
                $final=array(
                        "result"=>1,
                        "table_1"=>"jec_projprod"
                    );
            break;  		
            case "productprep":
                $final=array(
                        "result"=>1,
                        "table_1"=>"jec_productprep"
                    );
            break;      
            case "room":
                $final=array(
                        "result"=>1,
                        "table_1"=>"jec_arearoom"
                    );
            break;                    
        }
        return $final;
    }


    function FollowAction($import_type,$update_array,$var="")
    {   //資料存入後的後續動作/var為所需的參數
        switch($import_type)
        {
            case "tea_account":
                /*
                $target_table=MM_TB_PRE."_user_list";
                $trans_field=array(
                        "rhu_mark"=>"ru_mark",
                        "rhu_acc"=>"ru_acc",
                        "rhu_update_time"=>"ru_update_time",
                        "rhu_ps"=>"ru_ps",
                        "rhu_name"=>"ru_name",
                        "rhu_grade"=>"ru_grade",
                        "rhu_class"=>"ru_class",
                        "rhu_birthday"=>"ru_birthday",
                        "rhu_id_no_f"=>"ru_id_no_f"                        
                    );
                foreach($trans_field as $tft=>$tfv)
                {
                    $n_update_array[$tfv]=$update_array[$tft];
                }
                $check_exist=$this->db->where("ru_acc",$update_array['rhu_acc'])->where("ru_mark",0)->get($target_table)->row();
                if(isset($check_exist->ru_id))
                {
                    $this->db->where("ru_id",$check_exist->ru_id)->update($target_table,$n_update_array);
                }
                else
                {
                    $this->db->insert($target_table,$n_update_array);
                }*/
            break;
        }
    }
    
    function SaveData($objPHPExcel,$import_type,$file_type,$var="")
    {   //執行save-讀的時候第一行跳過[說明行]/var 為部份必要的參數
        //$user_acc=$this->session->userdata(MM_OnAcc);
        log_message('info','excel:'.$import_type);
		$table_info=$this->GetImportTableInfo($import_type,$var);  //存取資料表的相關資訊
        $excel_field=$this->ExcelField($import_type);  //excel讀取的欄位
		//echo count($excel_field).'sdfsdfsdf'.'-'.$import_type;
        
        //匯入報告的數值------------------------------------
        $report['update_num']=0;
        $report['new_num']=0;
        //-----------------------------匯入報名的數值_end###
        //預先提取的數值------------------------------------
        //$sys_sem=$this->NM->GetOnSemester();   //系統目前運行的學期
       
        //-----------------------------預先提取的數值_end###
        //$this->CM->JS_Msg('save');
        $sheet_num=isset($var['sheet_num'])?$var['sheet_num']:1;
        //$this->CM->JS_Msg($sheet_num);
                $currentSheet = $objPHPExcel->getSheet($sheet_num);//讀取第一個工作表(編號從 0 開始)    
                $allLine=$currentSheet->getHighestRow();//取得總列數 
                log_message('info','all line:'.$allLine);
                $count=0;
                
                switch($import_type)
                {  //預設參數tag
					/*
                    case 'readcer_test':
                        $up_f_book_num=0; //不存在的書 
                        $up_f_data="";
                        $up_book_num=0;
                        $up_qu_num=0;
			            $book_id=0; 
                        $book_qu_num=0;  //單本書的題目數
                        $book_ans_num=0;  //單本書的答案數
                        $book_tb_order="";  //表的序位
                        $cer_read=0;
                        $b_tb=MM_TB_PRE."_books_list";
                        $ts_tb=MM_TB_PRE."_table_status_list";
                        //取得答案數與預設欄位
                        $max_qu=$this->NM->GetSV('MaxTestNum');
                        $max_ans=$this->NM->GetSV('TestAnsNum');
                        $ans_field=array();
                        for($i=1;$i<=$max_ans;$i++)
                        {
                            $ans_field[$this->GetCellNameByNum($i)]=$this->GetCellNameByNum($i+3);
                        }
                    break;
					*/
                }

                for($excel_line = 4;$excel_line<=$allLine;$excel_line++)  //跑excel的行
                {
                    $count++;
                    //-----------------------------------------------------------存入值的初始化
                    $update_array_1=array();
                    $update_array_2=array();
                    switch($import_type)
                    {   //各類別的初始update_array調整
                        case "area":
                        break;
                        case "books":
                            $update_array_1=array(
                                    "rb_mark"=>0,
                                    "rb_update_time"=>date("YmdHis"),
                                    "rb_display"=>1
                                );
                        break;

                        case "tea_account":
                            $update_array_1=array(
                                    "rhu_mark"=>0,
                                    "rhu_update_time"=>date("YmdHis"),
                                    "rhu_create_time"=>date("YmdHis")
                                );
                            $update_array_2=array(
                                    "rgc_schyear"=>$table_info['sch_year'],
                                    "rgc_schtype"=>$table_info['sch_type'],
                                    "rgc_mark"=>0
                                );
                        break;
                    }
					if($count==1 && $import_type=='productprep')
                    {
                        if($currentSheet->getCell("B3")->getValue()!='種類')
                        {
                            $this->CM->JS_Msg("請使用新版履約備品清單匯入",-1,"error");
                            break;
                        }
                    }
                    //-----------------------------------------------------------存入值的初始化_end##
                    
                    if($count>1&&($import_type!='readcer_test'))  //讀的時候第一行跳過[說明行]
                    {   
                        //--------------------------------------------------------置入與調整最終存入值
                        foreach($excel_field as $eft=>$efv)
                        {
                            $update_array_1[$efv]=$currentSheet->getCell("$eft{$excel_line}")->getValue();
                            //echo $update_array_1[$efv];  //這是每個cell的值
                        }                        
						//各類別的額外讀入資料與調整資料
                        $update_array_1=$this->DataAdjust($import_type,$update_array_1,$var);
						//偵測到空白行就跳出匯入過程
                            if($update_array_1['prodname']=='' && $update_array_1['value']=='')
                            {
                                $this->CM->JS_Msg("匯入完成");
                                break;
                            }
                            else if($update_array_1['prodname']=='' || $update_array_1['value']=='') 
                                                {
                                                    $this->CM->JS_Msg("注意! 有品項因品號或品名空白無法匯入",-1,"error");
                                                    continue;
                                                }
                        switch($import_type){
                            case "books":
                            break;
                            case "tea_account":
                                $trans_field=array(
                                        "rhu_acc"=>"rgc_user_no_f",
                                        "rhu_grade"=>"rgc_grade",
                                        "rhu_class"=>"rgc_class",
                                        "rhu_id_no_f"=>"rgc_id_no_f"
                                    );
                                 foreach($trans_field as $tft=>$tfv)
                                 {
                                     $update_array_2[$tfv]=$update_array_1[$tft];
                                 }
                            break;
                        }
                        //----------------------------------------------------------置入與整最終存入值_end##
                        
                        
                        
                        //----------------------------------------------------------存入資料庫的調整與執行
                        //每行的insert視類別再處理
                        
                        switch($import_type)  //check_exist
                        {
                            case "area":
                            break;
                            case "readcer_test":   //清空舊的重新新增= =a->完全特殊處理
                            break;
                            case "tea_account":
                                $check_exist_1=$this->db->where("rhu_acc",$update_array_1['rhu_acc'])->where("rhu_mark",0)->get($table_info['table_1'])->row();
                                $check_exist_2=$this->db->where("rgc_user_no_f",$update_array_2['rgc_user_no_f'])->where("rgc_mark",0)->where("rgc_schyear",$update_array_2['rgc_schyear'])->where("rgc_schtype",$update_array_2['rgc_schtype'])->get($table_info['table_2'])->row();
                            break;
                            case "stu_account":
                                $check_exist_1=$this->db->where("rhu_acc",$update_array_1['rhu_acc'])->where("rhu_mark",0)->get($table_info['table_1'])->row();
                                $check_exist_2=$this->db->where("rgc_user_no_f",$update_array_2['rgc_user_no_f'])->where("rgc_mark",0)->where("rgc_schyear",$update_array_2['rgc_schyear'])->where("rgc_schtype",$update_array_2['rgc_schtype'])->get($table_info['table_2'])->row();
                            break;
                        }
                        
                        switch($import_type)  //存入處理
                        {    //匯入報告以update_array_1為基準/原則上2以後的都屬follow更新
                            case "readcer_test":
                            
                            break;
                            case "area":
                                 //$this->CM->JS_Msg('insert-'.$table_info['table_1']."-".count($update_array_1)."-".$update_array_1['name']."-".$update_array_1['ad_client_id']."-".$update_array_1['ad_org_id']."-".$update_array_1['isactive']."-".$update_array_1['c_city_id']."-".$update_array_1['jec_citydistrict_id']);
                                 //check_exit
                                 $exist_check=$this->db->where('name',$update_array_1['name'])->get('jec_areabase')->result_array();
                                 if(count($exist_check)>0):
                                    $this->db->where('jec_areabase_id',$exist_check['jec_areabase_id'])->update($table_info['table_1'],$update_array_1);
                                 else:
                                    $this->db->insert($table_info['table_1'],$update_array_1);
                                 endif;
                                 
                            break;
                            case "room"://
                                if($update_array_1['jec_areabase_id']>0):
                                    $exist_check=$this->db->where('jec_areabase_id',$update_array_1['jec_areabase_id'])->where('name',$update_array_1['name'])->get('jec_arearoom')->result_array();
                                    //$this->CM->JS_Msg('insert-'.$table_info['table_1']."-".count($update_array_1)."-".$update_array_1['name']."-".$update_array_1['ad_client_id']."-".$update_array_1['ad_org_id']."-".$update_array_1['isactive']."-");
                                    if(count($exist_check)>0):
                                        $this->db->where('jec_arearoom_id',$exist_check[0]['jec_arearoom_id'])->update($table_info['table_1'],$update_array_1);
                                    else:
                                        $this->db->insert($table_info['table_1'],$update_array_1);
                                    endif;
                                endif;
                            break;
							case 'producttempline':
								$this->db->insert($table_info['table_1'],$update_array_1);
							break;
							case 'productprep':
								$this->db->insert($table_info['table_1'],$update_array_1);
							break;
                            default:
                                if($table_info['result']>=1)  
                                {
                                    if(isset($check_exist_1->$table_info['key_field_1']))
                                    {
                                        //update
                                        $this->db->where($table_info['key_field_1'],$check_exist_1->$table_info['key_field_1'])->update($table_info['table_1'],$update_array_1);
                                        $report['update_num']++;
                                    }
                                    else
                                    {
                                        //insert(有mark存在的話先找空資料)
										/*
                                        if(isset($table_info['mark_field_1'])&&$table_info['mark_field_1']!="")
                                        {
                                            $row_id_1=$this->NM->GetEmptyId($table_info['table_1'],$table_info['mark_field_1']."='1'",$table_info['key_field_1']);
                                        }*/
										$row_id_1=0;
                                        if($row_id_1==0)
                                        {
                                            $this->db->insert($table_info['table_1'],$update_array_1);
                                        }
                                        else
                                        {
                                            $this->db->where($table_info['key_field_1'],$row_id_1)->update($table_info['table_1'],$update_array_1);
                                        }
                                        $report['new_num']++;
                                    }
                                }
                                if($table_info['result']>=2)
                                {
                                    if(isset($check_exist_2->$table_info['key_field_2']))
                                    {
                                        //update
                                        $this->db->where($table_info['key_field_2'],$check_exist_2->$table_info['key_field_2'])->update($table_info['table_2'],$update_array_2);
                                    }
                                    else
                                    {
                                        //insert(有mark存在的話先找空資料)
										/*
                                        if(isset($table_info['mark_field_2'])&&$table_info['mark_field_2']!="")
                                        {
                                            $row_id_2=$this->NM->GetEmptyId($table_info['table_2'],$table_info['mark_field_2']."='1'",$table_info['key_field_2']);
                                        }*/
										$row_id_2=0;
                                        if($row_id_2==0)
                                        {
                                            $this->db->insert($table_info['table_2'],$update_array_2);
                                        }
                                        else
                                        {
                                            $this->db->where($table_info['key_field_2'],$row_id_2)->update($table_info['table_2'],$update_array_2);
                                        }
                                    }
                                }                                
                            break;
                        }
                        //-----------------------------------------------------------存入資料庫的調整與執行_end##
                        
                        //-----------------------------------------------------------資料存入後的後續動作
                        switch($import_type)
                        {
                            
                            case "tea_account":/*-暫不需要
                                if($sys_sem->rs_sch_year==$update_array_2['rgc_schyear']&&$sys_sem->rs_sch_type==$update_array_2['rgc_schtype'])
                                {   //表更新的為當期帳號，要對應修改
                                    $this->FollowAction($import_type,$update_array_1);
                                }*/
                            break;
                            case "stu_account":
                                /*
                                if($sys_sem->rs_sch_year==$update_array_2['rgc_schyear']&&$sys_sem->rs_sch_type==$update_array_2['rgc_schtype'])
                                {   //表更新的為當期帳號，要對應修改
                                    $this->FollowAction($import_type,$update_array_1);
                                }*/
                            break;
                        }
                        //-----------------------------------------------------------資料存入後的後續動作_end##
                    }
                    
                } 
				/*
        switch($file_type)
        {
            case "xls":

            break;
            case "xlsx":
			
            
            break;
            case "csv":
            
            break;
        }    */
         
         
        $msg="";
		//$this->CM->JS_Msg('@@@-END');
        switch($import_type)
        {
            case "readcer_test":
                $msg.=$up_book_num>0?"上傳了".$up_book_num."本書的".$up_qu_num."個題目。":"";
                $msg.=$up_f_book_num>0?$up_f_book_num."本書的題目未上傳。".$up_f_data:"";
            break;
			case 'producttempline':
			break;
            default:
                if($report['update_num']>0){
                    $msg.="更新".$report['update_num']."筆。";
                }
                if($report['new_num']>0){
                    $msg.="新增".$report['new_num']."筆。";
                }
            break;
        }
        @unlink($this->open_target);

        $this->CM->msg_check($msg); 
    }
    
    function SpecMng($type='',$var='')
    {   //一些特殊處理
        switch($type)
        {
            case 'readcer_test':
                switch($var['type'])
                {
                    case "get_book":
                    break;
                }
            break;
        }
    }
    
    function GetCellNameByNum($num)
    {   //再補
        $eng=array("A","B","C","D","E","F","G","H","I","J","K","L","M","N","O","P","Q","R","S","T","U","V","W","X","Y","Z");
        $final=$eng[($num-1)];
        return $final;
    }
    
    function UnzipFile()
    {   //解壓縮檔案
        
    }
       // 讀取查詢的ERP價格
	function get_wferp_cost($prod_id=0,$costtype=0)
	{
		$mssqlerp = $this->load->database('mssqlerp', true);  // 連接ERP資料庫
		$MBxxx="";
		$final=0;
		if(!in_array(substr($prod_id,0,1),array("7","9", "A"))):
		if($costtype==4)
            $MBxxx="MB056";
        else if($costtype==6)
			$MBxxx="MB070";
		else if($costtype==7)
			$MBxxx="MB097";
		$data = $mssqlerp->query("select ".$MBxxx." as avg_prodprice from INVMB where MB001='".$prod_id."'")->result_array();
		$final=$data[0]['avg_prodprice'];
		endif;
		return (float)$final;
	}
}
?>