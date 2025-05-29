<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Mm_projprod_search_set
{
    var $mm_tb='jec_projprod_search_view';
	var $mm_tablename='JEC_Projprod_search_view';
	var $mm_glt='2';
    var $mm_td=array();
    var $mm_kid='jec_projprod_id';
    var $mm_deltype='isactive';
    var $mm_actb='jec_projprod';
			
	public function __construct()
	{   global $_G;//
		$this->ci =& get_instance();
		$this->load_mm_td();
	}
	
	function load_mm_td()
	{   global $_G;
	    $this->mm_td=array(
		        'nav'=>array(   //noticetype
						'con'=>array('datatype'=>3)				
				    ),																	
				'def'=>array()
		    );
		
	}
    
    function load_mm_field_check()
    {	global $_G;

        $final=array(
                'value'=>array(
                        'call_name'=>'專案編號',
                        'type'=>'text',
                        'readonly'=>'Y'//系統給定 
                    ),
                'jec_product_id_title'=>array(
                        'call_name'=>'料品-顯示',
                        'type'=>'text',
						'onblur'=>'PL_CloseList();',
						'onclick'=>"PL_ChangePL('product');",
						'onfocus'=>"PL_ChangePL('product');",
						'style'=>"width:100px;"
                    ),
                'jec_product_id'=>array(
                        'call_name'=>'料品目',
                        'type'=>'hidden'
                    ),
					/*
                'jec_product_id'=>array(
                        'call_name'=>'料品id',
                        'type'=>'select',
                        'ld'=>'mm_product_set@def',
                        'ld_value'=>'name',
                        'ld_key'=>'jec_product_id',
						'style'=>'width:180px;'
                    ),*/
                'quantity'=>array(
                        'call_name'=>'數量',
                        'type'=>'text',
						'pii'=>array('nod'),
						'style'=>'width:40px;'
                    ),
                'price'=>array(
                        'call_name'=>'單價',
                        'type'=>'text',
						'pii'=>array('nod'),
						'style'=>'width:40px;'
                    ),
                'total'=>array(
                        'call_name'=>'合計',
                        'type'=>'text',
						'pii'=>array('nod')
                    ),
                'description'=>array(
                        'call_name'=>'備註說明',
                        'type'=>'text',
						'style'=>'width:100px;'
                    ),
                'startdate'=>array(
                        'call_name'=>'需求日期',
                        'type'=>'text',
                        'readonly'=>'Y',//cal
						'style'=>'width:70px;'
                    ),/*
                'jec_vendor_id'=>array(
                        'call_name'=>'採購廠商',
                        'type'=>'select',
                        'ld'=>'mm_vendor_set@def',
                        'ld_value'=>'name',
                        'ld_key'=>'jec_vendor_id',
                        'full_selected'=>'N'
                    ),*/
                'jec_vendor_id_title'=>array(
                        'call_name'=>'採購廠商-顯示',
                        'type'=>'text',
						'onblur'=>'PL_CloseList();',
						'onclick'=>"PL_ChangePL('vendor');",
						'onfocus'=>"PL_ChangePL('vendor');",
						'style'=>"width:60px;"
                    ),
                'jec_vendor_id'=>array(
                        'call_name'=>'採購廠商',
                        'type'=>'hidden'
                    ),
				'prodtype'=>array(
						'call_name'=>'type',
						'type'=>'hidden'
					),
				'oppro_value'=>array(
						'call_name'=>'type',
						'type'=>'text',
						'style'=>'width:40px;'
					),
				'oppro_name'=>array(
						'call_name'=>'type',
						'type'=>'text',
						'style'=>'width:100px;'
					),
				'oppro_specification'=>array(
						'call_name'=>'spec',
						'type'=>'text',
						'style'=>'width:40px'
					),
				'oppro_uom'=>array(
						'call_name'=>'type',
						'type'=>'select',
						'ld'=>array(),
						'ld_key'=>'jec_uom_id',
						'ld_value'=>'name',
						'full_selected'=>'N',
						'style'=>'width:50px;'
					),
				'import_producttemp'=>array(
						'call_name'=>'producttemp',
						'type'=>'select',
						'ld'=>'mm_producttemp_set@def',
						'ld_value'=>'name',
						'ld_key'=>'jec_producttemp_id',
						'full_selected'=>'N'
					),
				'import_excel'=>array(
						'call_name'=>'producttemp',
						'type'=>'file',
						'filetype'=>"xls@xlsx",
						'up_type'=>'S',
						'onchange'=>'',
						'style'=>'width:120px;'
					),
				'extramultiple'=>array(//倍數
						'call_name'=>'extramultiple',
						'type'=>'text',
						'style'=>'width:30px;',
						'pii'=>array('nod')
					),
				'extraaddition'=>array(//加乘
						'call_name'=>'extraaddition',
						'type'=>'text',
						'style'=>'width:30px;',
						'pii'=>array('nod')
					)
            );
        return $final;
    }
	
	
	function exe_right_check()
	{	//執行的權限設定--不過方向大致已定就是了。= =!ok
		 //model->test-//資料異動權限
		 //->無權限的就銷掉--拉出來，有相關過濾的設在td_checl--
		 switch($type){
		 	case 'save_work':
				//
				break;
			case 'test_work':
				//
				break;
		 }
		 
	}
	
    function after_exe_ac($ac='',$data=array())
    {   //
 		//
    }         
}