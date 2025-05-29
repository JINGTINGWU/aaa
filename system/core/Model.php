<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * CodeIgniter
 *
 * An open source application development framework for PHP 5.1.6 or newer
 *
 * @package		CodeIgniter
 * @author		ExpressionEngine Dev Team
 * @copyright	Copyright (c) 2008 - 2011, EllisLab, Inc.
 * @license		http://codeigniter.com/user_guide/license.html
 * @link		http://codeigniter.com
 * @since		Version 1.0
 * @filesource
 */

// ------------------------------------------------------------------------

/**
 * CodeIgniter Model Class
 *
 * @package		CodeIgniter
 * @subpackage	Libraries
 * @category	Libraries
 * @author		ExpressionEngine Dev Team
 * @link		http://codeigniter.com/user_guide/libraries/config.html
 */
class CI_Model {

	/**
	 * Constructor
	 *
	 * @access public
	 */
	var $csi_array=array('dis','gp','ob','con','like','glt','wi','wni','jsql','row_type','one_field','non','where','orwhere','fixselect','group_by');
	var $sql_type=array('ob'=>3,'con'=>4,'pd'=>3,'like'=>5);
	var $cust_id='';
    var $field_pre="ecp_";//4
	
	function __construct()
	{
		log_message('debug', "Model Class Initialized");
	}

	/**
	 * __get
	 *
	 * Allows models to access CI's loaded classes using the same
	 * syntax as controllers.
	 *
	 * @param	string
	 * @access private
	 */
	function __get($key)
	{
		$CI =& get_instance();
		return $CI->$key;
	}
    function csi_mng($source='',$data='')
	{
		$csi_array=$this->csi_array;
		foreach($csi_array as $value):
		    if(isset($data[$value])) $source[$value]=$data[$value];
		endforeach;
		return $source;	
	}
	
	function cdi_mng($source='',$data='')
	{
		
		foreach($this->sql_type as $st=>$sv):
		    foreach($data as $sst=>$ssv):
			    if(substr($sst,0,$sv)==$st."_"){ $source[$st][substr($sst,$sv)]=$ssv;   }
			endforeach;
		endforeach;		
		
		return $source;	
	}

    function join_mng($data=array(),&$td)
	{
	    for($j=1;$j<=3;$j++)
		{
		    if(isset($data['join_'.$j])){ $td['join_'.$j]=$data['join_'.$j]; echo 'Y'; }
		}
	}
}
// END Model Class

/* End of file Model.php */
/* Location: ./system/core/Model.php */