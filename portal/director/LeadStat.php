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
	else{
		$st_codes = odbc_exec($conn, "SELECT DISTINCT [State] FROM [CRM Oppurtunity] ") or die(odbc_errormsg($conn));
		while(odbc_fetch_array($st_codes)){
			$stc .= "'".odbc_result($st_codes, "State")."', ";
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
			<th style="vertical-align:middle;text-align: center;" colspan="9">LEAD</th>
		</tr>
		<tr style="background-color: #2874a6;color: #ffffff;">
                        <th style="vertical-align:middle;">Oppurtunity Date</th>
			<th style="vertical-align:middle;">Name</th>
			<th style="vertical-align:middle;">City</th>
			<th style="text-align: center; vertical-align:middle;">Brand</th>
			<th style="vertical-align:middle;">Sales Representative</th>
                        <th style="vertical-align:middle;">Last Activity Date</th>
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
		
			$q1 = odbc_exec($conn, $sql4) or die(odbc_errormsg($conn)); // Live Server
			while(odbc_fetch_array($q1)){
		
		?>
		<tr>
			<td colspan="9" style="text-align: center;font-weight: bold;background-color: #d5dbdb"><?php echo strtoupper(odbc_result($q1, "Region"))?></td>
		</tr>
		<?php
                        $md = 1;
			//Get States
			$stcode = "";
			$st_code = odbc_exec($conn, "SELECT DISTINCT [StateCode] FROM [postcode] WHERE [Region]='".odbc_result($q1, "Region")."' ") or die(odbc_errormsg($conn));
			while(odbc_fetch_array($st_code)){
				if($stage != "") $ste = " AND [Stage]='$stage'";
				else $ste ="";
				if($brand != "") $brd = " AND [Likely Brand]='$brand'";
				else $brd ="";
				if($_REQUEST['l'] != "") $lvl = " AND [Level]='Agreement signed'";
				else if($_REQUEST['l'] == "" && ($brand != "" || $stage != "")) $lvl =" AND [Level]<>'Agreement signed'";
				//else $lvl = "";
				else $lvl = " AND [Level]<>'Agreement signed'";
				
				$lead = odbc_exec($conn, "SELECT * FROM [CRM Oppurtunity] WHERE [State]='".odbc_result($st_code, "StateCode")."' $ste $brd $lvl") or die(odbc_errormsg($conn));
				if(odbc_num_rows($lead)!=0){
				while(odbc_fetch_array($lead)){
		?>
		<tr 
			<?php echo (odbc_result($lead, "Level") == "Agreement signed") ? " style='font-weight:bold; color: #0e6251;' " : ""?>
		>
                    <td>
                        <?php echo date('d/M/Y', odbc_result($lead, "Opp Date")); ?>
                    </td>
			<td>
                            <a href="#?id=<?php echo odbc_result($lead, "ID")?>" 
                               data-toggle="modal" data-target="#myModal<?php echo $md; ?>">
                                   <?php echo odbc_result($lead, "Name")?></a>
                            <!-- Modal -->
                            <div id="myModal<?php echo $md; ?>" class="modal fade" role="dialog">
                              <div class="modal-dialog" style="min-width: 90%; min-height: 80%; ">

                                <!-- Modal content-->
                                <div class="modal-content">
                                  <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                                    <h3 class="text-primary">Oppurtunity ID: <strong><?php echo odbc_result($lead, "Opp No"); ?><strong></h3>
                                  </div>
                                    <div class="modal-body">
                                    
                                      <div class="container">
	<table class="table table-responsive table-bordered">
		<tr>
			<td style="background-color: #f2f2f2;">
				<table class="table table-responsive" style="background-color: #f2f2f2;">
					<tr>
						<td style="border:none;">Date</td>
						<td style="border:none;">
							<span class="text-primary" style="font-weight: bold;"><?php echo date('d/M/Y', odbc_result($lead, "Opp Date")); ?></span>
						</td>
					</tr>
					<tr>
						<td style="border:none;">Name</td>			
						<td  style="border:none;"><span class="text-primary" style="font-weight: bold;"><?php echo odbc_result($lead, "Name"); ?></span></td>
					</tr>
                                        <tr>
						<td style="border:none;">Address</td>			
						<td  style="border:none;"><span class="text-primary" style="font-weight: bold;"><?php echo odbc_result($lead, "Address 1"); ?></span>
						<span class="text-primary" style="font-weight: bold;"><?php echo odbc_result($lead, "Address 2"); ?></span> 
						<span class="text-primary" style="font-weight: bold;"><?php echo odbc_result($lead, "City"); ?></span>
						<span class="text-primary" style="font-weight: bold;"><?php echo odbc_result($lead, "State"); ?></span>
						<span class="text-primary" style="font-weight: bold;"><?php echo odbc_result($lead, "Country"); ?></span>
						<span class="text-primary" style="font-weight: bold;"><?php echo odbc_result($lead, "Post Code"); ?></span></td>
					</tr>
					<tr>
						<td style="border:none;">Mobile</td>			
						<td style="border:none;"><span class="text-primary" style="font-weight: bold;"><?php echo odbc_result($lead, "Mobile"); ?></span></td>
					</tr>
					<tr>
						<td style="border:none;">Email</td>
						<td  style="border:none;"><span class="text-primary" style="font-weight: bold;"><?php echo odbc_result($lead, "Email"); ?></span></td>
					</tr>
					<tr>
						<td style="border:none;">Lead Source</td>			
						<td style="border:none;">
							<span class="text-primary" style="font-weight: bold;"><?php echo odbc_result($lead, "Source"); ?></span>
						</td>
					</tr>
					<tr>
						<td style="border:none;">Status</td>
						<td style="border:none;">
							<span class="text-primary" style="font-weight: bold;"><?php echo odbc_result($lead, "Status"); ?></span>
						</td>
					</tr>
					<tr>
						<td style="border:none;">Brand:</td>
						<td style="border:none;"><span class="text-primary" style="font-weight: bold;"><?php echo odbc_result($lead, "Likely Brand"); ?></span></td>
					</tr>
					<tr>
						<td style="border:none;">Own Land:</td>
						<td style="border:none;"><span class="text-primary" style="font-weight: bold;"><?php echo odbc_result($lead, "land"); ?></span></td>
					</tr>
					<tr>
						<td style="border:none;">Investment Potential:</td>
						<td style="border:none;"><span class="text-primary" style="font-weight: bold;"><?php echo odbc_result($lead, "investment"); ?></span></td>
					</tr>
					<tr>
						<td style="border:none;">Created By:</td>
						<td style="border:none;"><span class="text-primary" style="font-weight: bold;"><?php echo odbc_result($lead, "User ID"); ?></span></td>
					</tr>
				</table>
			</td>
                        <td>
                            <table class="table table-responsive" style="font-size: 12px;" >
					<tr>
						<td colspan="6" style="background-color: #ffffff; border:none;">
							<h3 class="text-danger" >Activities</h3>
						</td>
					</tr>
					<tr>
						<th>Date</th>
						<th>Contact Person</th>
						<th>Contact No</th>
						<th>Stage</th>
						<th>Level</th>
						<th>Remarks</th>
						<th>Activity</th>
						<th>Outcome</th>
						<th>Activity Status</th>
					</tr>
					<?php
						$act = odbc_exec($conn, "SELECT [Date], [Stage], [Level], [Remarks], [Contact Person], [Contact No], [Activity Status], [Activities], [Outcome] FROM [CRM Opp Activity] WHERE 
							[Opp ID]='".odbc_result($lead, "Opp No")."' ORDER BY [Date] DESC") or die(odbc_errormsg($conn));
						while(odbc_fetch_array($act)){
					?>
					<tr>
						<td style="font-weight: normal;"><?php echo date('d/M/Y', odbc_result($act, "Date")); ?></td>
						<td style="font-weight: normal;"><?php echo odbc_result($act, "Contact Person"); ?></td>
						<td style="font-weight: normal;"><?php echo odbc_result($act, "Contact No"); ?></td>
						<td style="font-weight: normal;"><?php echo odbc_result($act, "Stage"); ?></td>
						<td style="font-weight: normal;"><?php echo odbc_result($act, "Level"); ?></td>
						<td style="font-weight: normal;"><?php echo odbc_result($act, "Remarks"); ?></td>
						<td style="font-weight: normal;"><?php echo odbc_result($act, "Activities"); ?></td>
						<td style="font-weight: normal;"><?php echo odbc_result($act, "Outcome"); ?></td>
						<td style="font-weight: normal;"><?php echo odbc_result($act, "Activity Status"); ?></td>
					</tr>
					<?php
						}	
					?>
				</table>
                        </td>
                        </tr>              
                        </table>         
                                      
                                  </div>
                                  <div class="modal-footer">
                                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                  </div>
                                </div>

                              </div>
                            </div>
                        </td>
			<td><?php echo odbc_result($lead, "City")?>, <?php echo odbc_result($lead, "State")?></td>
			<td><?php echo odbc_result($lead, "Likely Brand")?></td>
                        <td><?php echo date('d/M/Y', odbc_result($act, "Date")); ?></td>
			<td><?php 
				$AsgTo = odbc_exec($conn, "SELECT [FullName] FROM [user] WHERE [LoginID]='".odbc_result($lead, "Assign To")."' ");
				echo odbc_result($AsgTo, "FullName");
			?></td>
			<td><?php echo (odbc_result($lead, "Stage")=="Conversion")?"Qualified":odbc_result($lead, "Stage"); ?></td>
			<td><?php echo odbc_result($lead, "Level")?></td>
			<td><?php echo odbc_result($lead, "Source")?></td>
			
		</tr>
		<?php
                                    $md++;
				}
				}
			}	
		?>
		<?php } ?>
		</tbody>	
	</table>
</div>
<?php require_once("footer.php"); ?>