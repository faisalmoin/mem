<!DOCTYPE html>
<html><head></head><body>
<?php
	require_once("db.txt");
	
	$result = mysql_query("SELECT * FROM `complaint` WHERE `id`='22' ") or die(mysql_error());
	$row = mysql_fetch_array($result);
	
	$str = $row['Description'];
	
	$pos = strpos($str, "Content-ID: ");
	$npos = strrpos($str, "------=_Next");
	
	if(!$npos){
		echo "does not exist...<br />";
	}
	else{	
		$str_start = explode(" ", substr($str, $pos));
		$str_end = substr($str, $npos);
		
		$startpos = $pos + strlen($str_start[0]);
		
		if (strpos($str, $pos) !== false) {
		    $endpos = strpos($str, $str_end, $startpos);
		    if (strpos($str, $str_end, $startpos) !== false) {
			$result = substr($str, $startpos, $endpos - $startpos);
		    }
		}
		
		//echo '<img  src="data:image/png;base64,'.$result.'" />';
		$img = explode(" ", $result);
		echo '<img  src="data:image/png;base64,'.$img[1].'" />';
	}
		
?>
</body></html>