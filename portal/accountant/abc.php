<?php
	include_once '../db.txt';
	$result = mysql_query("select `Picture` from `complaint`");
    $query_fetch=mysql_fetch_array($result);
    $im = $query_fetch['Picture'];
    echo "<img src='data:image/jpeg;base64,$im' width='500px' />";

?>