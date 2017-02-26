<?php 
	require_once("header.php");
        
        $today = strtotime(date('Y-m-d'));
        $this_yr = strtotime(date("Y")."-04-01");
        $nxt_yr = strtotime((date("Y")+1)."-03-31");
        
        if($today > strtotime(date("Y")."-04-01") && $today < strtotime((date("Y")+1)."-03-31")){
            $FinYr = date('y')."-".(date('y')+1);
        }
        
	require_once("Company.php");
?>


<?php require_once("footer.php"); ?>