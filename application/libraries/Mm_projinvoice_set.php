<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Mm_projinvoice_set
{
    var $mm_tb='jec_projinvoice';
	var $mm_tablename='JEC_projinvoice';
	var $mm_glt='2';
    var $mm_td=array();
    var $mm_kid='jec_projinvoice_id';
    var $mm_deltype='isactive';
    var $mm_actb='jec_projinvoice';
			
	public function __construct()
	{   global $_G;
		$this->ci =& get_instance();
		$this->load_mm_td();
	}
	
	function load_mm_td()
	{   global $_G;
	    $this->mm_td=array(
		        'nav'=>array(   //noticetype
						'con'=>array('datatype'=>3)				
				    ),		
				'cus_proj'=>array(
						'join'=>array('type'=>'left','jtb'=>'jec_project','jkey'=>'jec_project_id','mkey'=>'jec_project_id','tb'=>$this->mm_tb),
						'join_1'=>array('type'=>'left','jtb'=>'jec_customer','jkey'=>'jec_customer_id','mkey'=>'jec_customer_id','tb'=>'jec_project'),
						'join_2'=>array('type'=>'left','jtb'=>'jec_user','jkey'=>'jec_user_id','mkey'=>'jec_usersales_id','tb'=>'jec_project'),
						'join_3'=>array('type'=>'left','jtb'=>'jec_user','jtb_as'=>'jec_user2','jkey'=>'jec_user_id','mkey'=>'jec_user_id','tb'=>'jec_project'),
						'con'=>array($this->mm_tb.'.isactive'=>'Y'),
						'jsql'=>array($this->mm_tb.'.*','jec_project.name','jec_project.customername','jec_customer.name AS customer_name','jec_project.jec_customer_id','jec_project.jec_usersales_id','jec_project.projyear','jec_project.jec_company_id','jec_user.name AS sales_name','jec_user2.name AS incharge_name'),
						'glt'=>4	
					),																
				'def'=>array()
		    );
		
	}
    
    function load_mm_field_check()
    {	global $_G;

        $final=array(
                'invoicedate'=>array(
                        'call_name'=>'發票日期',
                        'type'=>'text',
						'readonly'=>'Y',
						'style'=>'width:80px;',
						'def_value'=>date('Y-m-d')              
                    ),
                'invoiceyear'=>array(
                        'call_name'=>'發票年度',
                        'type'=>'select',
						'ld'=>$this->ci->CM->FormatData(array('key'=>'id','value'=>'name','sn'=>(date('Y')-4),'en'=>(date('Y')+4)),"page_db","num"),
						'ld_key'=>'id',
						'ld_value'=>'name',
						'full_selected'=>'N'           
                    ),	
                'invoiceamount'=>array(
                        'call_name'=>'金額',
                        'type'=>'text',
						'pii'=>array('nod'),
						'style'=>'width:100px;'            
                    ),			
                'description'=>array(
                        'call_name'=>'備註說明',
                        'type'=>'text',
						'maxlength'=>100         
                    ) //
            );
        return $final;
    }
	
	function get_projinvoice_row($projinvoice_id=0)
	{
		$result=$this->ci->db->where($this->mm_kid,$projinvoice_id)->get($this->mm_tb)->result_array();
		return count($result)>0?$result[0]:0;
	}
	function delete_projinvoice($data=array())
	{	//del_file
		//
		if(!is_array($data)):
			$data=$this->get_projinvoice_row($data);
		endif;
			$this->ci->db->where($this->mm_kid,$data[$this->mm_kid])->update($this->mm_actb,array('isactive'=>'N'));	
		
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