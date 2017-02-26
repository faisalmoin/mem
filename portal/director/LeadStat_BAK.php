<?php
	require_once("header.php");
	
	$part ="";
	
	$brand = $_REQUEST['b'];
	$stage = $_REQUEST['s'];
	$zone = $_REQUEST['z'];
	
	if($brand !=""){
		$part1 = " [Likely Brand]='$brand' ";
	}
	if($stage != ""){
		$part2 = " [Stage]='$stage'";
	}
	if($zone !=""){
		$st_codes = odbc_exec($conn, "SELECT DISTINCT [StateCode] FROM [postcode] WHERE [Region]='$zone' ") or die(odbc_errormsg($conn));
		while(odbc_fetch_array($st_codes)){
			$stc .= "'".odbc_result($st_codes, "StateCode")."', ";
		}
		$stc = substr($stc, 0, -2);
		$part3 = "  [State] IN (".$stc.")";
	}
	
	if($brand != "" || $stage != "" || $zone !=""){
		$part .= " WHERE ";
	}
	if($brand != "" && $stage != "" && $zone !=""){
		$part .= "$part1 AND $part2 AND $part3";
		if($_REQUEST['l'] != ""){
			$part .= " AND [Level] = 'Agreement signed'";
		}
	}
	if($brand != "" && $stage != "" && $zone ==""){
		$part .= "$part1 AND $part2";
	}
	if($brand != "" && $stage == "" && $zone !=""){
		$part .= "$part1 AND $part3";
	}
	if($brand == "" && $stage != "" && $zone !=""){
		$part .= "$part2 AND $part3";
	}
	if($brand != "" && $stage == "" && $zone ==""){
		$part .= "$part1";
	}
	if($brand == "" && $stage != "" && $zone ==""){
		$part .= "$part2";
	}
	if($brand == "" && $stage == "" && $zone !=""){
		$part .= "$part3";
	}
	if($brand == "" && $stage == "" && $zone ==""){
		$part .= "";
	}
	
	
?>
<div class="container">
	<!--  Lead Status -->
	<table class="table table-responsive table-bordered" style="background-color: #ffffff;">
		<thead>
		<tr>
			<th style="vertical-align:middle;text-align: center;" colspan="6">LEAD</th>
		</tr>
		<tr style="background-color: #2874a6;color: #ffffff;">
			<th style="vertical-align:middle;">City</th>
			<th style="text-align: center; vertical-align:middle;">Brand</th>
			<th style="vertical-align:middle;">Sales Representative</th>
			<th style="text-align: center; ">Stage</th>			
			<th style="text-align: center; ">Level</th>			
			<th style="text-align: center; ">Reference</th>			
		</tr>
		</thead>
		<tbody>
		<?php 
			$sts0 = "";
		if($part=""){
			if($part3 == ""){
			$sql4 = "SELECT DISTINCT [State] FROM [CRM Oppurtunity] ";
			}
			echo "P: ". $sql4."<br />";
			
			$q0 = odbc_exec($conn, $sql4 ) or die(odbc_errormsg($conn));
			while(odbc_fetch_array($q0)){
				$sts0 .= "'".odbc_result($q0, "State")."', ";
			}
			$sts0 = substr($sts0, 0, -2);
			
			$part4 = str_replace("[State]", "[StateCode]", "SELECT DISTINCT [Region] FROM [postcode] WHERE $part3 ORDER BY [Region]");
		}
		else{
			if($part3 == "") $sql4 = str_replace("WHERE", "", "SELECT DISTINCT [Region] FROM [postcode] WHERE $part3 ORDER BY [Region]");
			else if($part3 != "") $sql4 = str_replace("[State]", "[StateCode]", "SELECT DISTINCT [Region] FROM [postcode] WHERE $part3 ORDER BY [Region]");
			
		}
		//echo "Q: ".$sql4."<br />";
			$q1 = odbc_exec($conn, $sql4) or die(odbc_errormsg($conn)); // Live Server
			while(odbc_fetch_array($q1)){
		?>
		<tr>
			<td colspan="6" style="text-align: center;font-weight: bold;background-color: #d5dbdb"><?php echo strtoupper(odbc_result($q1, "Region"))?></td>
		</tr>
		<?php
			//Get States
			$stcode = "";
			$st_code = odbc_exec($conn, "SELECT DISTINCT [StateCode] FROM [postcode] WHERE [Region]='".odbc_result($q1, "Region")."' ") or die(odbc_errormsg($conn));
			while(odbc_fetch_array($st_code)){
				if($stage != "") $ste = " AND [Stage]='$stage'";
				else $ste ="";
				if($brand != "") $brd = " AND [Likely Brand]='$brand'";
				else $brd ="";
				if($_REQUEST['l'] != "") $lvl = " AND [Level]='Agreement signed'";
				else $lvl ="";
		//echo "SELECT * FROM [CRM Oppurtunity] WHERE [State]='".odbc_result($st_code, "StateCode")."' $ste $brd $lvl";
				$lead = odbc_exec($conn, "SELECT * FROM [CRM Oppurtunity] WHERE [State]='".odbc_result($st_code, "StateCode")."' $ste $brd $lvl") or die(odbc_errormsg($conn));
				if(odbc_num_rows($lead)!=0){
				while(odbc_fetch_array($lead)){
		?>
		<tr>
			<td><?php echo odbc_result($lead, "City")?> <?php echo odbc_result($lead, "State")?></td>
			<td><?php echo odbc_result($lead, "Likely Brand")?></td>
			<td><?php echo odbc_result($lead, "Assign To")?></td>
			<td><?php echo odbc_result($lead, "Stage")?></td>
			<td><?php echo odbc_result($lead, "Level")?></td>
			<td><?php echo odbc_result($lead, "Source")?></td>
			
		</tr>
		<?php
				}
				}
			}	
		?>
		<?php } ?>
		</tbody>	
	</table>
</div>
<?php require_once("footer.php"); ?>