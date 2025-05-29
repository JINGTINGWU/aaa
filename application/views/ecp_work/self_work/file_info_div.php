<?php

$targetDir="./uploads/temp_save/".$dir."/upload_list.txt";
//echo $targetDir;
if( is_file($targetDir) )
{
   //echo "目錄存在!";
   // Use fopen function to open a file
$file = fopen($targetDir, "r");

// Read the file line by line until the end
while (!feof($file)) {
$value = fgets($file);
echo "附件數:".substr_count($value,"<ef>");
}

// Close the file that no longer in use
fclose($file);


}
else
{
	echo "附件數:0";
}
?>