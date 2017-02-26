<?php
	require_once("header.php");
	
	$R = $_REQUEST['z'];
	if($R != ""){
		$rg = odbc_exec($conn, "SELECT DISTINCT [StateCode] FROM [postcode] WHERE [Region]='$R'");
		while(odbc_fetch_array($rg)){
			$st_codes .= "'".odbc_result($rg, "StateCode")."', ";			
		}
		
		$st_codes = substr($st_codes, 0, -2);
		$query = "SELECT * FROM [CRM Oppurtunity] WHERE [Stage]='Agreement' AND [Level]='Agreement signed' AND [State] IN ($st_codes) ORDER BY [Name] ";
	}
	else{
		$query = "SELECT * FROM [CRM Oppurtunity] WHERE [Stage]='Agreement' AND [Level]='Agreement signed' ORDER BY [Name] ";
	}
	
?>
<div class="container">
	<table class="table table-responsive table-hover" style="background-color:#ffffff;">
		<thead>
		<tr style='background-color: #0080cc'>
			<th style='padding: 15px;  border: none;' colspan="15">
				<h2 style='color: #ffffff;'>Franchisee Details</h2>
			</th>
		</tr>
		<tr>
			<th valign="top">SN</th>
			<th>Name</th>
			<th>Location</th>
			<th>Contact No</th>
			<th>Email</th>
			<th>Brand</th>
			<th>MOU<br /> Signed Date</th>
			<th>Duration</th>
			<th>Franchisee Fee</th>
                        <th>Franchisee ST</th>
			<th>Royalty %</th>
                        <th>Royalty ST</th>
			<th></th>
		</tr>
		</thead>
		<tbody>
		<?php
			$i=1;
			
			$sql = odbc_exec($conn, $query);
			while(odbc_fetch_array($sql)){
				$sql2 = odbc_exec($conn, "SELECT * FROM [CRM Agreement] WHERE [Opp No]='".odbc_result($sql, "Opp No")."'");
				if(odbc_result($sql2, "Sign Date") != ""){
		?>
		<tr  >
			<td><?php echo $i?></td>
			<td><a href="#" data-toggle="modal" data-target="#myModal<?php $i;?>"><?php echo odbc_result($sql, "Name")?></a></td>
			<td><?php echo odbc_result($sql, "City")?> <?php echo odbc_result($sql, "State")?></td>
			<td><?php echo odbc_result($sql, "Mobile")?></td>
			<td><?php echo odbc_result($sql, "Email")?></td>
			<td><?php echo odbc_result($sql, "Likely Brand")?>
				<!-- Modal -->
				<div id="myModal<?php $i;?>" class="modal fade" role="dialog" style="text-align: justify;min-width: 90%; min-height: 80%; ">
					<div class="modal-dialog" style="min-width: 90%; min-height: 80%; ">

						<!-- Modal content-->
						<div class="modal-content">
							<div class="modal-header" style="background-color: #2874a6; color: #ffffff;">
								<button type="button" class="close" data-dismiss="modal">&times;</button>
								<h4 class="modal-title">Franchisee Details</h4>
							</div>
							<div class="modal-body">
                                                            <table class="table table-responsive" style="background-color: #ffffff;">
                                                                <tr>
                                                                    <td style="border:none;">
                                                                        <table class="table table-responsive" style="background-color: #ffffff;">
									<tr>
										<td style="border:none;">Name</td>			
										<td  style="border:none;"><span class="text-primary" style="font-weight: bold;"><?php echo odbc_result($sql, "Name"); ?></span></td>
									</tr>
									<tr>
										<td style="border:none;">Address</td>			
										<td  style="border:none;"><span class="text-primary" style="font-weight: bold;"><?php echo odbc_result($sql, "Address 1"); ?></span>
										<span class="text-primary" style="font-weight: bold;"><?php echo odbc_result($sql, "Address 2"); ?></span> 
										<span class="text-primary" style="font-weight: bold;"><?php echo odbc_result($sql, "City"); ?></span>
										<span class="text-primary" style="font-weight: bold;"><?php echo odbc_result($sql, "State"); ?></span>
										<span class="text-primary" style="font-weight: bold;"><?php echo odbc_result($sql, "Country"); ?></span>
										<span class="text-primary" style="font-weight: bold;"><?php echo odbc_result($sql, "Post Code"); ?></span></td>
									</tr>
									<tr>
										<td style="border:none;">Mobile</td>			
										<td style="border:none;"><span class="text-primary" style="font-weight: bold;"><?php echo odbc_result($sql, "Mobile"); ?></span></td>
									</tr>
									<tr>
										<td style="border:none;">Email</td>
										<td  style="border:none;"><span class="text-primary" style="font-weight: bold;"><?php echo odbc_result($sql, "Email"); ?></span></td>
									</tr>
									<tr>
										<td style="border:none;">Lead Source</td>			
										<td style="border:none;">
											<span class="text-primary" style="font-weight: bold;"><?php echo odbc_result($sql, "Source"); ?></span>
										</td>
									</tr>
									<tr>
										<td style="border:none;">Brand:</td>
										<td style="border:none;"><span class="text-primary" style="font-weight: bold;"><?php echo odbc_result($sql, "Likely Brand"); ?></span></td>
									</tr>
									<tr>
										<td style="border:none;">Own Land:</td>
										<td style="border:none;"><span class="text-primary" style="font-weight: bold;"><?php echo odbc_result($sql, "land"); ?></span></td>
									</tr>
									<tr>
										<td style="border:none;">Investment Potential:</td>
										<td style="border:none;"><span class="text-primary" style="font-weight: bold;"><?php echo odbc_result($sql, "investment"); ?></span></td>
									</tr>
									<tr>
										<td style="border:none;">Created By:</td>
										<td style="border:none;"><span class="text-primary" style="font-weight: bold;"><?php echo odbc_result($sql, "User ID"); ?></span></td>
									</tr>
                                                                        </table>
                                                                    </td>
                                                                    <td style="border:none;">
                                                                        <table class="table table-responsive" style="background-color: #ffffff;">
                                                                            <tr>
										<td style="border:none;">MOU Sign Date:</td>
										<td style="border:none;"><span class="text-primary" style="font-weight: bold;"><?php echo date("d/M/Y", odbc_result($sql2, "Sign Date"))?></span></td>
									</tr>
                                                                        <tr>
										<td style="border:none;">Start Date:</td>
										<td style="border:none;"><span class="text-primary" style="font-weight: bold;"><?php echo date("d/M/Y", odbc_result($sql2, "From Date"))?></span></td>
									</tr>
                                                                        <tr>
										<td style="border:none;">End Date:</td>
										<td style="border:none;"><span class="text-primary" style="font-weight: bold;"><?php echo date("d/M/Y", odbc_result($sql2, "To Date"))?></span></td>
									</tr>
                                                                        <tr>
										<td style="border:none;">Duration:</td>
										<td style="border:none;"><span class="text-primary" style="font-weight: bold;"><?php echo round(odbc_result($sql2, "Duration")/365) ?> Yrs</span></td>
									</tr>
                                                                        <tr>
										<td style="border:none;">Franchisee Fee:</td>
										<td style="border:none;"><span class="text-primary" style="font-weight: bold;">INR <?php echo round(odbc_result($sql2, "Franchisee Fee")) ?></span></td>
									</tr>
                                                                        <tr>
										<td style="border:none;">Franchisee Service Tax:</td>
										<td style="border:none;"><span class="text-primary" style="font-weight: bold;"><?php 
                                                                                            if(odbc_result($sql2, "ST") == 1) echo "Exclusive";
                                                                                            if(odbc_result($sql2, "ST") == -1) echo "Inclusive";
                                                                                            ?></span>
                                                                                </td>
									</tr>
                                                                        <tr>
										<td style="border:none;">Royalty %:</td>
                                                                                <td style="border:none;"><span class="text-primary" style="font-weight: bold;"><?php echo round(odbc_result($sql2, "Royaly %")) ?> %</span></td>
                                                                        </tr>
                                                                        <tr>
										<td style="border:none;">Royalty Service Tax:</td>
                                                                                <td style="border:none;"><span class="text-primary" style="font-weight: bold;"><?php 
                                                                                        if(odbc_result($sql2, "R_Tax") == 1) echo "Exclusive";
                                                                                        if(odbc_result($sql2, "R_Tax") == -1) echo "Inclusive";
                                                                                        ?></span></td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td style="border:none;">Documents: </td>
                                                                            <td style="border:none;">
                                                                                <a href="<?php echo odbc_result($sql2, "LOI File") ?>" target="_BLANK"<span class="glyphicon glyphicon-file">LOI</span></a>
                                                                                <a href="<?php echo odbc_result($sql2, "MOU File") ?>" target="_BLANK"<span class="glyphicon glyphicon-file">MOU</span></a>
                                                                            </td>
                                                                        </tr>
                                                                        
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
			<td><?php echo date("d/M/Y", odbc_result($sql2, "Sign Date"))?></td>
			<td><?php echo round(odbc_result($sql2, "Duration")/365) ?> Yrs</td>
			<td><?php echo round(odbc_result($sql2, "Franchisee Fee")) ?></td>
                        <td><?php 
                                if(odbc_result($sql2, "ST") == 1) echo "Exclusive";
                                if(odbc_result($sql2, "ST") == -1) echo "Inclusive";
                        ?></td>
			<td><?php echo round(odbc_result($sql2, "Royaly %")) ?> %</td>
                        <td><?php 
                                if(odbc_result($sql2, "R_Tax") == 1) echo "Exclusive";
                                if(odbc_result($sql2, "R_Tax") == -1) echo "Inclusive";
                        ?></td>
			<td><a href="<?php echo odbc_result($sql2, "MOU File") ?>" target="_BLANK"<span class="glyphicon glyphicon-file"></span></a></td>
		</tr>
		<?php
				}
				$i++;
			}
		?>
		</tbody>
	</table>
	
</div>
<?php require_once("footer.php"); ?>