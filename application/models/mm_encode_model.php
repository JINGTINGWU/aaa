<?php 
if (!defined('BASEPATH')) exit('No direct script access allowed');

class Mm_encode_model extends CI_Model 
{   //查詢項目設定// 

    function __construct() 
    {   global $_G;
        parent::__construct();
    }
    
    function ID_Output($f_id,$f_type,$f_var){

        $f_id=rtrim($f_id);
        //type1->encode type2->decode  $f_var=>Eng
        $word=array("b","e","c","h","f","l","i","d","a","j","k","t","m","p","o","s","r","q","z","g","u","w","v","x","n","y");
	    for($i=0;$i<26;$i++){
	        $word[$word[$i]]=$i;
	    }
	    $number="";	
	    for($i=0;$i<strlen($f_var);$i++){
	        $number.=$word[substr($f_var,$i,1)];
	    }	
	    if(strlen($number)>8){ $number=substr($number,strlen($number)-8,8); }	

	    switch($f_type){
	        case "1":
	            $mix=$f_id*1*$number;
                //turn to eng
	            $final="";
			    $test="";
	            for($i=0;$i<strlen($mix);$i++){			    
	                $this_word=$word[substr($mix,$i,1)];
				    $test.=$this_word;
		            if(rand(1,2)==1){ $this_word=strtoupper($this_word); }
	                $final.=$this_word;		       
	            }
	            //add random eng&position;
	            $r_num=rand(3,6);
	            $tag_num="";
	            for($i=1;$i<=$r_num;$i++){
		            $this_p=rand(0,9); $this_e=$word[rand(0,25)];
		            $final=substr($final,0,$this_p).$this_e.substr($final,$this_p);
		            if($this_p==0){
		                $tag_num.="0";
		            }else{
		                $tag_num.=10-$this_p;
		            }
	            }
			    //add random num
			    $temp="";
			    for($i=0;$i<=strlen($final);$i++){
			        $temp.=substr($final,$i,1);
				    if(rand(1,2)==1){ $temp.=rand(1,99); }
			    }
	            //add first eng
	            $final=$word[rand(0,25)].$tag_num.$temp.$r_num;		
		    break;
		    case "2":
		        $r_num=substr($f_id,strlen($f_id)-1,1);
			    $tag_num=substr($f_id,1,$r_num);
			    $mix=substr($f_id,$r_num+1,strlen($f_id)-1-$r_num);
	            $final=$mix;
		  	    //del number
			    $temp="";
			    for($i=0;$i<strlen($final);$i++){
			        $this_e=substr($final,$i,1);
				    if($this_e!="0"&&$this_e!="1"&&$this_e!="2"&&$this_e!="3"&&$this_e!="4"&&$this_e!="5"&&$this_e!="6"&&$this_e!="7"&&$this_e!="8"&&$this_e!="9"){
				        $temp.=$this_e;
				        //$final.=$word[strtolower($this_e)];
				    }
			    }
			    $final=$temp;				
			    //del addition eng
			    for($i=1;$i<=$r_num;$i++){
			        //從尾倒推
				    $this_p=substr($tag_num,$r_num-$i,1);
				    if($this_p!=0){
				        $this_p=10-$this_p*1;
				    }


				    if(strlen($final)<$this_p){
				        $final=substr($final,0,$this_p-2);
				    }elseif(strlen($final)==$this_p){
				        $final=substr($final,0,$this_p-1);
				    }elseif($this_p==0){
				        $final=substr($final,1);
				    }else{
				        $final=substr($final,0,$this_p).substr($final,$this_p+1);
				    }
			    }

                $temp="";
			    for($i=0;$i<strlen($final);$i++){
			        $temp.=$word[strtolower(substr($final,$i,1))];
			    }				
			    $final=$temp*1/$number;

	  	    break;
	    }

	    return $final;

    }

    function ReturnFinalCode($f_value,$f_string,$f_type){
        if($f_value==""){
            $final="";
        }else{
            $final=$this->ID_Output($f_value,$f_type,$f_string);
        }
        return $final;
    }
                                 
}

?>