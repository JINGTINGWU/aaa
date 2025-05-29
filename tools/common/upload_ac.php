<?php
/**
 * upload.php
 *
 * Copyright 2009, Moxiecode Systems AB
 * Released under GPL License.
 *
 * License: http://www.plupload.com/license
 * Contributing: http://www.plupload.com/contributing
 */

// HTTP headers for no cache etc
header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
header("Cache-Control: no-store, no-cache, must-revalidate");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");

// Settings-
//
//$targetDir = ini_get("upload_tmp_dir") . DIRECTORY_SEPARATOR . "plupload";
//$targetDir='uploads/test/';
//$targetDir = 'uploads';

$cleanupTargetDir = true; // Remove old files
$maxFileAge = 5 * 3600; // Temp file age in seconds

// 5 minutes execution time - 
@set_time_limit(5 * 60);

// Uncomment this one to fake upload time
// usleep(5000);

// Get parameters
$chunk = isset($_REQUEST["chunk"]) ? intval($_REQUEST["chunk"]) : 0;
$chunks = isset($_REQUEST["chunks"]) ? intval($_REQUEST["chunks"]) : 0;
$fileName = isset($_REQUEST["name"]) ? $_REQUEST["name"] : '';


		//save時去尋，有存在的才save，同名的後來的會覆蓋上去。 
		
// Clean the fileName for security reasons
$fileName = preg_replace('/[^\w\._]+/', '_', $fileName);

// Make sure the fileName is unique but only if chunking is disabled
if ($chunks < 2 && file_exists($targetDir . DIRECTORY_SEPARATOR . $fileName)) {
	$ext = strrpos($fileName, '.');
	$fileName_a = substr($fileName, 0, $ext);
	$fileName_b = substr($fileName, $ext);

	$count = 1;
	while (file_exists($targetDir . DIRECTORY_SEPARATOR . $fileName_a . '_' . $count . $fileName_b))
		$count++;

	$fileName = $fileName_a . '_' . $count . $fileName_b;
}

$filePath = $targetDir . DIRECTORY_SEPARATOR . $fileName;

// Create target dir
if (!file_exists($targetDir))
	@mkdir($targetDir);

// Remove old temp files	
if ($cleanupTargetDir && is_dir($targetDir) && ($dir = opendir($targetDir))) {
	while (($file = readdir($dir)) !== false) {
		$tmpfilePath = $targetDir . DIRECTORY_SEPARATOR . $file;

		// Remove temp file if it is older than the max age and is not the current file
		if (preg_match('/\.part$/', $file) && (filemtime($tmpfilePath) < time() - $maxFileAge) && ($tmpfilePath != "{$filePath}.part")) {
			@unlink($tmpfilePath);
		}
	}

	closedir($dir);
} else
	die('{"jsonrpc" : "2.0", "error" : {"code": 100, "message": "Failed to open temp directory."}, "id" : "id"}');
	

// Look for the content type header
if (isset($_SERVER["HTTP_CONTENT_TYPE"]))
	$contentType = $_SERVER["HTTP_CONTENT_TYPE"];

if (isset($_SERVER["CONTENT_TYPE"]))
	$contentType = $_SERVER["CONTENT_TYPE"];

// Handle non multipart uploads older WebKit versions didn't support multipart in HTML5
if (strpos($contentType, "multipart") !== false) {
	if (isset($_FILES['file']['tmp_name']) && is_uploaded_file($_FILES['file']['tmp_name'])) {
		// Open temp file
		$out = fopen("{$filePath}.part", $chunk == 0 ? "wb" : "ab");
		if ($out) {
			// Read binary input stream and append it to temp file
			$in = fopen($_FILES['file']['tmp_name'], "rb");

			if ($in) {
				while ($buff = fread($in, 4096))
					fwrite($out, $buff);
			} else
				die('{"jsonrpc" : "2.0", "error" : {"code": 101, "message": "Failed to open input stream."}, "id" : "id"}');
			fclose($in);
			fclose($out);
			@unlink($_FILES['file']['tmp_name']);
		} else
			die('{"jsonrpc" : "2.0", "error" : {"code": 102, "message": "Failed to open output stream."}, "id" : "id"}');
	} else
		die('{"jsonrpc" : "2.0", "error" : {"code": 103, "message": "Failed to move uploaded file."}, "id" : "id"}');
} else {
	// Open temp file
	$out = fopen("{$filePath}.part", $chunk == 0 ? "wb" : "ab");
	if ($out) {
		// Read binary input stream and append it to temp file
		$in = fopen("php://input", "rb");

		if ($in) {
			while ($buff = fread($in, 4096))
				fwrite($out, $buff);
		} else
			die('{"jsonrpc" : "2.0", "error" : {"code": 101, "message": "Failed to open input stream."}, "id" : "id"}');

		fclose($in);
		fclose($out);
	} else
		die('{"jsonrpc" : "2.0", "error" : {"code": 102, "message": "Failed to open output stream."}, "id" : "id"}');
}

// Check if file has been uploaded
if (!$chunks || $chunk == $chunks - 1) {
	// Strip the temp .part suffix off 
	rename("{$filePath}.part", $filePath);
}
$up_msg='';
		$old_content=file_get_contents($targetDir.'upload_list.txt');
		$test=fopen($targetDir.'upload_list.txt','a+');//累加的寫入方式
		/* 測試用的 */

		
		if($this->CM->InStr($old_content,"<ef>".$fileName."@@@@@@@@@@".$_FILES['file']['name'].'</ef>')==false):
			fwrite($test,"<ef>".$fileName."@@@@@@@@@@".$_FILES['file']['name'].'</ef>');
			//save
			//$projf_set=$this->CM->Init_TB_Set('mm_projfile_set');
			$as_info=array();
			if(file_exists($target_folder.'already_saved.txt')):
				$as_data=file_get_contents($target_folder.'already_saved.txt');
				$as_list=$this->CM->GetRow($as_data,'<ef>','</ef>');
				foreach($as_data as $value):
					$eid=trim($value);
					array_push($as_info,$eid);
				endforeach;
			endif;
			
			$as_content=fopen($target_folder.'already_saved.txt','a+');
	
			switch($type):
				case 'project_list':
					$save_folder='uploads/project_file/'.$this->GM->GetSpecData('jec_project','value','jec_project_id',$key_id).'/';
					$save_name=trim($_FILES['file']['name']);
					//check_有無重覆
					$check=$this->CM->db->where('filename',$save_name)->where('isactive','Y')->get('jec_projfile')->result_array();
					//if(count($check)==0):
						$upd=array_merge(array('jec_user_id'=>$this->ad_id,'jec_project_id'=>$key_id,'filename'=>$save_name,'filepath'=>$save_folder),$this->CM->Base_New_UPD());
					//$this->GM->common_ac('insert',array('info'=>$projf_set['mm_set'],'upt'=>'def','upd'=>$upd));
						$this->CM->db->insert('jec_projfile',$upd);
						$file_id=mysql_insert_id();
						fwrite($as_content,"<ef>".$fileName."@@@@@@@@@@".$file_id."</ef>");
					//endif;
					

					break;
				case 'prepare_item':
					$save_folder='uploads/project_file/'.$this->GM->GetSpecData('jec_project','value','jec_project_id',$key_id).'/';
					$save_name=trim($_FILES['file']['name']);
					//check_有無重覆
					$check=$this->CM->db->where('filename',$save_name)->where('isactive','Y')->get('jec_projfile')->result_array();
					//if(count($check)==0):
						$upd=array_merge(array('jec_user_id'=>$this->ad_id,'jec_project_id'=>$key_id,'filename'=>$save_name,'filepath'=>$save_folder,'filetype'=>5),$this->CM->Base_New_UPD());
					//$this->GM->common_ac('insert',array('info'=>$projf_set['mm_set'],'upt'=>'def','upd'=>$upd));
						$this->CM->db->insert('jec_projfile',$upd);
						$file_id=mysql_insert_id();
						fwrite($as_content,"<ef>".$fileName."@@@@@@@@@@".$file_id."</ef>");
					//endif;
					

					break;
				case 'job_list':
						$job_data=$this->CM->db->where('jec_projjob_id',$key_id)->get('jec_projjob')->result_array();
						$job_data=$job_data[0];
					$save_folder='uploads/project_file/'.$this->GM->GetSpecData('jec_project','value','jec_project_id',$job_data['jec_project_id']).'/';
					$save_name=trim($_FILES['file']['name']);
					
					$check=$this->CM->db->where('filename',$save_name)->where('isactive','Y')->get('jec_projfile')->result_array();
					//if(count($check)==0):

					
					//
						$upd=array_merge(array('jec_user_id'=>$this->ad_id,'jec_project_id'=>$job_data['jec_project_id'],'jec_projjob_id'=>$key_id,'filename'=>$save_name,'filepath'=>$save_folder),$this->CM->Base_New_UPD());
						$this->CM->db->insert('jec_projfile',$upd);
					//$this->GM->common_ac('insert',array('info'=>$projf_set['mm_set'],'upt'=>'def','upd'=>$upd));

						$file_id=mysql_insert_id();
						fwrite($as_content,"<ef>".$fileName."@@@@@@@@@@".$file_id."</ef>");
					//endif;
					
					
					break;
				case 'task_list':
						$task_data=$this->CM->db->where('jec_projtask_id',$key_id)->get('jec_projtask')->result_array();
						$task_data=$task_data[0];				
					$save_folder='uploads/project_file/'.$this->GM->GetSpecData('jec_project','value','jec_project_id',$task_data['jec_project_id']).'/';
					$save_name=trim($_FILES['file']['name']);
					$check=$this->CM->db->where('filename',$save_name)->where('isactive','Y')->get('jec_projfile')->result_array();
					//if(count($check)==0):

					
					//
						$upd=array_merge(array('jec_user_id'=>$this->ad_id,'jec_project_id'=>$task_data['jec_project_id'],'jec_projjob_id'=>$task_data['jec_projjob_id'],'jec_projtask_id'=>$key_id,'filename'=>$save_name,'filepath'=>$save_folder),$this->CM->Base_New_UPD());
						$this->CM->db->insert('jec_projfile',$upd);
					//$this->GM->common_ac('insert',array('info'=>$projf_set['mm_set'],'upt'=>'def','upd'=>$upd));

						$file_id=mysql_insert_id();
						fwrite($as_content,"<ef>".$fileName."@@@@@@@@@@".$file_id."</ef>");						
					//endif;

					break;
				case 'rp_finish':
					break;
				case 'rp_adjust':
					break;
				case 'rp_transfer':
					break;
				case 'rp_impossible':
					break;
				case 'rp_pause':
					break;
				case 'add_prod_list'://追加-j直接save
					$save_folder='uploads/project_file/'.$this->GM->GetSpecData('jec_project','value','jec_project_id',$key_id).'/';
					$save_name=trim($_FILES['file']['name']);
					//check_有無重覆
					$check=$this->CM->db->where('filename',$save_name)->where('isactive','Y')->get('jec_projfile')->result_array();
					//if(count($check)==0):
						$upd=array_merge(array('jec_user_id'=>$this->ad_id,'jec_project_id'=>$key_id,'filetype'=>3,'filename'=>$save_name,'filepath'=>$save_folder),$this->CM->Base_New_UPD());
					//$this->GM->common_ac('insert',array('info'=>$projf_set['mm_set'],'upt'=>'def','upd'=>$upd));
						$this->CM->db->insert('jec_projfile',$upd);
						$file_id=mysql_insert_id();
						fwrite($as_content,"<ef>".$fileName."@@@@@@@@@@".$file_id."</ef>");
					//endif;
					break;
				case 'reduce_prod_list'://追減
					$save_folder='uploads/project_file/'.$this->GM->GetSpecData('jec_project','value','jec_project_id',$key_id).'/';
					$save_name=trim($_FILES['file']['name']);
					//check_有無重覆
					$check=$this->CM->db->where('filename',$save_name)->where('isactive','Y')->get('jec_projfile')->result_array();
					//if(count($check)==0):
						$upd=array_merge(array('jec_user_id'=>$this->ad_id,'jec_project_id'=>$key_id,'filetype'=>4,'filename'=>$save_name,'filepath'=>$save_folder),$this->CM->Base_New_UPD());
					//$this->GM->common_ac('insert',array('info'=>$projf_set['mm_set'],'upt'=>'def','upd'=>$upd));
						$this->CM->db->insert('jec_projfile',$upd);
						$file_id=mysql_insert_id();
						fwrite($as_content,"<ef>".$fileName."@@@@@@@@@@".$file_id."</ef>");
					//endif;
					break;
			endswitch;
			fclose($as_content);
		endif; 		
		
		//fwrite($test,"\n".$fileName."@@@@@@@@@@".$_FILES['file']['name']);
		fclose($test);//
// Return JSON-RPC response
die('{"jsonrpc" : "2.0", "result" : null, "id" : "id","message":"'.$up_msg.'"}');
?>