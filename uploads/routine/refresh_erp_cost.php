<?php
	//先把資料抓回來
	$mssqlerp=$this->load->database('mssqlerp',TRUE);//mssqlef
	$pro_list=$mssqlerp->get("INVMB")->result_array();
	$string='';
	foreach($pro_list as $no=>$value):
		$upd=array(
				'prodname'=>trim($value['MB002']),
				'prodspec'=>trim($value['MB003']),
				'produnit'=>trim($value['MB004']),
				'prodprice0'=>trim($value['MB051']),
				'prodprice1'=>trim($value['MB053']),
				'prodprice2'=>trim($value['MB054']),
				'prodprice3'=>trim($value['MB055']),
				'prodprice4'=>trim($value['MB056']),
				'prodprice5'=>trim($value['MB069']),
				'prodprice6'=>trim($value['MB070']),
				'prodprice7'=>trim($value['MB097']),
				'updated'=>date('Y-m-d H:i:s')
			);
			//$string.=trim($value['MB003']).'=========';
		$this->db->where('prodid',trim($value['MB001']))->update('jec_producterp',$upd);
		//if($no>10) break;
	endforeach;
	$this->CM->JS_TMsg('@@'.$string);
?>