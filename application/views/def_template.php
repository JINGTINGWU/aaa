<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="keywords" content="ECPlant" />
<meta name="description" content="EMS Project Management System" />
<title></title>
<script type="text/javascript" src="<?=base_url()?>js/jquery.js"></script>
<script type="text/javascript" src="<?=base_url()?>js/thickbox_rc.js"></script>
<script type="text/javascript" src="<?=base_url()?>js/humane.js"></script>
<script type="text/javascript" src="<?=base_url()?>js/common.js"></script>
<link rel="stylesheet" type="text/css" href="<?=base_url()?>/css/jackedup.css" />
<link rel="stylesheet" type="text/css" href="<?=base_url()?>css/menu.css" />
<link rel="stylesheet" type="text/css" href="<?=base_url()?>css/thickbox.css" />


</head>
<body>
<div><?=$this->navigation?></div>
<div id="container">
<?php $this->load->view('common/tcate_menu',$G); ?>
	<!-- ----------------------------------------------------------------------------------- -->
	<!-- 設定功能操作頁籤: 權限定義/編輯權限/使用者管理 -->
<div  id="body">    
<?php $this->load->view($this_view); ?>
</div>
	<p class="footer">線上使用人數: 
    <a href='<?=base_url()?>uploads/count.txt' target="_blank">
    <?php
//首先你要有讀寫檔的許可權
//本程式可以直接運行,第一次報錯,以後就可以
  $online_log = "uploads/count.txt"; //儲存人數的檔,
  $timeout = 300;//30秒內沒動作者,認為掉線
  $entries = file($online_log);

  $temp = array();
 
  for ($i=0;$i<count($entries);$i++) {
   $entry = explode(",",trim($entries[$i]));
   if (($entry[0] != getenv('REMOTE_ADDR')) && ($entry[2] > time()-($timeout))) {
    array_push($temp,$entry[0].",".$entry[1].",".$entry[2]."\r\n"); //取出其他流覽者的資訊,並去掉逾時者,儲存進$temp
   }
  }

   array_push($temp,getenv('REMOTE_ADDR').",".$users[0]['name'].",".(time() + ($timeout))."\r\n"); //更新流覽者的時間
  $users_online = count($temp); //計算線上人數

  $entries = implode("",$temp);
  //寫入檔案
  $fp = fopen($online_log,"w");
   flock($fp,LOCK_EX); //flock() 不能在NFS以及其他的一些網路檔系統中標準工作
   fputs($fp,$entries);
   flock($fp,LOCK_UN);
   fclose($fp);

   echo $users_online."人";

?>  </a>
    ECPlant Tech. 2012</p>
</div>
<iframe id="phf" name="phf" style="display:none;"></iframe>
</body>
</html>