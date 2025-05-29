<?php
$conf_path = dirname(__FILE__) . "/mssql.conf";    // 定義FreeTDS設定檔的真實路徑
putenv("FREETDSCONF=$conf_path");    //   這行才是關鍵 , 設定環境變數
$dbbase = 'EMS';
$uid = 'sa';
$pwd = 'ecplant0102';
$serverName = "192.168.0.203";
$link = mssql_connect($serverName, $uid, $pwd);

if(false === $link) die("connect error");
if(false === mssql_select_db("EMS" , $link)) die("select db EMS error");
$rows = mssql_query("SELECT * FROM INVMB WHERE MB002 LIKE 'MF800MM%'");
$row = mssql_fetch_array($rows);
var_dump($row);  // 把結果印出來看看 , 應該就是 UTF-8 的中文了

//if (! $conn)
//{
//    echo "Connection could not be established. ";
//    die(print_r(mssql_errors(),true));
//}
//else
//{
//    echo "sql2005 Connection success. ";
//}
?>
