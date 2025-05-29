<?php
@session_start();
include("js/s3Config.php");
$rand = mt_rand(0,(sizeof($values)-1));
shuffle($values);
$s3Capcha = '<div><div id="capcha_div">請選擇文字提示的圖案： <strong>'.$values[$rand]."</strong>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</div>";
for($i=0;$i<sizeof($values);$i++) {
    $value2[$i] = mt_rand();
    $s3Capcha .= '<div><span>'.$values[$i].' <input type="radio" name="s3capcha" value="'.$value2[$i].'"></span><div id="capcha_div_inner" style="background: url('.$imagePath.$values[$i].'.'.$imageExt.') bottom left no-repeat; width:'.$imageW.'px; height:'.$imageH.'px;cursor:pointer;display:none;" class="img" /></div></div>';
}
$s3Capcha .= '</div>';
$_SESSION['s3capcha'] = $value2[$rand];
echo $s3Capcha;
?>