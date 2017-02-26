<?php 
	require_once("header.php");
	
	
        $today = strtotime(date('Y-m-d'));
        $this_yr = strtotime(date("Y")."-04-01");
        $nxt_yr = strtotime((date("Y")+1)."-03-31");
        
        if($today > strtotime(date("Y")."-04-01") && $today < strtotime((date("Y")+1)."-03-31")){
            $FinYr = date('y')."-".(date('y')+1);
        }
	$AcadYr = $FinYr;
	$id = $CompName;
	
	$Comp = odbc_exec($conn, "SELECT * FROM [Company Information] WHERE [ID]='$id'") or die(odbc_errormsg($conn));
?>


<!-- ace scripts -->
<script src="assets/js/ace-elements.min.js"></script>
<script src="assets/js/ace.min.js"></script>
<div id="content">
    <table border="0" width="100%">
        <tr>
            <td style="height: 100%; background-color: #0088cc;padding: 25px" width="30%" class="headcol" valign="top" >
                <div  id="container">
                    <div class="full">
			<!-- <h2 style="color:#ffffff;"><a href="#" onclick="history.go(-1);" class="glyphicon glyphicon-circle-arrow-left" style="color: #ffffff; text-decoration: none;"></a></h2> -->
			
                        <h3 style="color:#ffffff;"><?php echo odbc_result($Comp, "Name")?></h3>
			<span style="color:#ffffff;">
			<?php echo odbc_result($Comp, 'Address')?> <?php echo odbc_result($Comp, 'Address 2') ?><?php echo odbc_result($Comp, 'Address 3') ?> <br />
			<?php echo odbc_result($Comp, 'City')?> <?php echo odbc_result($Comp, 'State')?> Phone: <?php echo odbc_result($Comp, 'Phone No_')?><br />
			</span><br />
                        <p style="color: #ffffff; text-align: right;">Financial/Academic Year: <?php echo $FinYr?></p>
                        <span style="color: #ffffff;">Student</span>
                        <table width="100%" cellspacing="15px">
                            <tr>
                                <td style="height: 80px; background-color: #000080; color: #ffffff; border-right: 5px solid #0088cc;"><h3 style="text-align: center;"><?php
				$s1 = odbc_exec($conn, "SELECT COUNT([ID]) FROM [Temp Enquiry] WHERE [Admission For Year]='$FinYr' AND [Company Name]='$id' ") or die(odbc_errormsg($conn));
                                echo odbc_result($s1, "");
                            ?></h3></td>
                                <td style="height: 80px; background-color: #000080; color: #ffffff; border-right: 5px solid #0088cc;"><h3 style="text-align: center;"><?php
                                $s2 = odbc_exec($conn, "SELECT COUNT([ID]) FROM [Temp Student] WHERE [Admission For Year]='$FinYr' AND [Company Name]='$id' ") or die(odbc_errormsg($conn));
                                echo odbc_result($s2, "");
                            ?></h3></td>
                            </tr>
                            <tr>
                                <td style="height: 10px; background-color: #000080; color: #ffffff; border-right: 5px solid #0088cc;border-bottom: 15px solid #0088cc;">Enquiry</td>
                                <td style="height: 10px; background-color: #000080; color: #ffffff; border-right: 5px solid #0088cc;border-bottom: 15px solid #0088cc;">Admission</td>
                            </tr>
                            <tr>
                                <td style="height: 80px; background-color: #000080; color: #ffffff; border-right: 5px solid #0088cc;"><h3 style="text-align: center;"><?php
                                $s3 = odbc_exec($conn, "SELECT COUNT([ID]) FROM [Temp Student] WHERE [Student Status]<>1 AND [Company Name]='$id' AND [Date of Leaving] BETWEEN '01/Jan/".date('Y')."' AND '31/Dec/".date('Y')."'") or die(odbc_errormsg($conn));
                                echo odbc_result($s3, "");
                            ?></h3></td>
                                <td style="height: 80px; background-color: #000080; color: #ffffff; border-right: 5px solid #0088cc;"><h3 style="text-align: center;"><?php
                                $s4 = odbc_exec($conn, "SELECT COUNT([ID]) FROM [Temp Student] WHERE [Student Status]=1 AND [Company Name]='$id'") or die(odbc_errormsg($conn));
                                echo odbc_result($s4, "");
                            ?></h3></td>
                            </tr>
                            <tr>
                                <td style="height: 10px; background-color: #000080; color: #ffffff; border-right: 5px solid #0088cc;border-bottom: 15px solid #0088cc;">Withdrawal</td>
                                <td style="height: 10px; background-color: #000080; color: #ffffff; border-right: 5px solid #0088cc;border-bottom: 15px solid #0088cc;">Student</td>
                            </tr>
                        </table>
			
                        <br /><br />
			
                        <span style="color: #ffffff;">Financial</span>
                        <table width="100%" cellspacing="15px">
                            <tr>
                                <td style="height: 80px; background-color: #000080; color: #ffffff; border-right: 5px solid #0088cc;"><h3 style="text-align: center;"><?php
                                $q2 = odbc_exec($conn, "SELECT SUM([Credit Amount]) FROM [Ledger Credit] WHERE [Company Name]='$id' ") or die(odbc_errormsg($conn));
                                $q2l = strlen(number_format(odbc_result($q2, ""), 0, ".", ""));
                                if($q2l >= 4 && $q2l <= 5) echo round(odbc_result($q2, "")/1000,2) ." K";
                                if($q2l >= 6 && $q2l <= 7) echo round(odbc_result($q2, "")/100000,2) ." L";
                                if($q2l >= 8 && $q2l <= 9) echo round(odbc_result($q2, "")/10000000,2) ." Cr";                                
                                ?></h3></td>
				<td style="height: 80px; background-color: #000080; color: #ffffff; border-right: 5px solid #0088cc;"><h3 style="text-align: center;"><?php
                                $q3 = odbc_exec($conn, "SELECT SUM([Debit Amount]+[Adv Fee]) FROM [Ledger Debit] WHERE [Company Name]='$id'") or die(odbc_errormsg($conn));
                                $q3l = strlen(number_format(odbc_result($q3, ""), 0, ".", ""));
                                if($q3l >= 4 && $q3l <= 5) echo round(odbc_result($q3, "")/1000,2) ." K";
                                if($q3l >= 6 && $q3l <= 7) echo round(odbc_result($q3, "")/100000,2) ." L";
                                if($q3l >= 8 && $q3l <= 9) echo round(odbc_result($q3, "")/10000000,2) ." Cr";
                                ?></h3></td>
                            </tr>
                            <tr>
                                <td style="height: 10px; background-color: #000080; color: #ffffff; border-right: 5px solid #0088cc;border-bottom: 15px solid #0088cc;">Credit Amount</td>
                                <td style="height: 10px; background-color: #000080; color: #ffffff; border-right: 5px solid #0088cc;border-bottom: 15px solid #0088cc;">Debit Amount</td>
                            </tr>
                            <tr>
                                <td style="height: 80px; background-color: #000080; color: #ffffff; border-right: 5px solid #0088cc;"><h3 style="text-align: center;"><?php
                                $q4 = odbc_exec($conn, "SELECT SUM([Debit Amount]+[Adv Fee]) FROM [Ledger Debit] WHERE [Company Name]='$id' AND [Payment Realization]=0") or die(odbc_errormsg($conn));
                                $q4l = strlen(number_format(odbc_result($q4, ""), 0, ".", ""));
                                if($q4l >= 4 && $q4l <= 5) echo round(odbc_result($q4, "")/1000,2) ." K";
                                if($q4l >= 6 && $q4l <= 7) echo round(odbc_result($q4, "")/100000,2) ." L";
                                if($q4l >= 8 && $q4l <= 9) echo round(odbc_result($q4, "")/10000000,2) ." Cr";
                                
                                ?>
                                </h3></td>
				<td style="height: 80px; background-color: #000080; color: #ffffff; border-right: 5px solid #0088cc;"><h3 style="text-align: center;"><?php
				$q5 = (odbc_result($q2, "")-odbc_result($q3, ""));                                
				$q5l = strlen(number_format($q5, 0, ".", ""));
				
				if($q5l >= 4 && $q5l <= 5) echo round($q5/1000,2) ." K";
                                if($q5l >= 6 && $q5l <= 7) echo round($q5/100000,2) ." L";
                                if($q5l >= 8 && $q5l <= 9) echo round($q5/10000000,2) ." Cr";
				
				?>
				</td>
                            </tr>
                            <tr>
                                <td style="height: 10px; background-color: #000080; color: #ffffff; border-right: 5px solid #0088cc;border-bottom: 15px solid #0088cc;">In-Pipeline</td>
                                <td style="height: 10px; background-color: #000080; color: #ffffff; border-right: 5px solid #0088cc;border-bottom: 15px solid #0088cc;">Outstanding</td>
                            </tr>
                        </table>
                        
                    </div> <!-- End of class FULL -->
                </div> <!-- End of id Container -->
            </td>
            <td width="70%" style="height: 100%; background-color: #ffffff;padding: 25px;" class="long" valign="top">
		<?php require_once("menu.php"); ?>
		<ul id = "myTab" class = "nav nav-tabs">
			<li class = "active">
				<a href = "#home" data-toggle = "tab">
					Student
				</a>
			</li>
			<li><a href = "#fee" data-toggle = "tab">Fee Structure</a></li>
			<li><a href = "#discount" data-toggle = "tab">Discount Structure</a></li>
			<li><a href = "#royalty" data-toggle = "tab">Royalty</a></li>
		</ul>
		
		<div id = "myTabContent" class = "tab-content">
			<div class = "tab-pane fade in active" id = "home">
				<h3 class="text-primary">Classwise Student Status</h3>
					<div style="border: 0px solid #d3d3d3; background-color: #FFFFFF;border-radius: 5px;">
						<div class="table">
							<table class="table" style="color: #736f6e;">
								<tr style="font-weight: bold;">
									<td style="border: 0px;">Class</td>
									<?php
										$StuSec = odbc_exec($conn, "SELECT DISTINCT([Section]) FROM [Class Section] WHERE [Company Name]='$id' ORDER BY [Section]") or die(odbc_errormsg($conn));
										$colspan = odbc_num_rows($StuSec);
										while(odbc_fetch_array($StuSec)){
											echo "<td  style='border: 0px;' align='center'>".odbc_result($StuSec, 'Section')."</td>";
										}
									?>
									<td style="border: 0px;" align="center">TOTAL</td>
								</tr>
								<?php
									$StuClass = odbc_exec($conn, "SELECT [Code], [Description] FROM [Class] WHERE [Company Name]='$id' ORDER BY [Sequence]");
									while(odbc_fetch_array($StuClass)){
								?>
								<tr><td>
									<?php echo odbc_result($StuClass, 'Description'); ?>
								</td>
								<?php
									$StuSecCount = odbc_exec($conn, "SELECT DISTINCT([Section]) FROM [Class Section] WHERE [Company Name]='$id' ORDER BY [Section]") or die(odbc_errormsg($conn));
									while(odbc_fetch_array($StuSecCount)){

									$CountStu = odbc_exec($conn, "SELECT COUNT([No_]) FROM [Temp Student]  WHERE [Company Name]='$id' AND [Class] = '".odbc_result($StuClass, 'Code')."' AND [Section] = '".odbc_result($StuSecCount, 'Section')."' AND [Academic Year] = '$AcadYr' AND [Student Status] = 1 ");
										if(odbc_result($CountStu, '') != 0){
											echo "<td align='center'>";
											echo odbc_result($CountStu, '');
										}
										else{
											echo "<td align='center' style='color: #E3E4FB'>";
											echo odbc_result($CountStu, '');
										}
										echo "</td>";
									}
									$ClassStrength = odbc_exec($conn, "SELECT COUNT([No_]) FROM [Temp Student] WHERE [Company Name]='$id' AND [Class] = '".odbc_result($StuClass, 'Code')."' AND [Academic Year] = '$AcadYr' AND [Student Status] = 1 ");
									echo "<td style='color: #000000;' align='center'>".odbc_result($ClassStrength, '')."</td>";
								?>
							</tr>
							<?php
								}
							?>

							<tr style="font-size: 18px;">
								<td colspan="<?php echo ($colspan+1)?>"><strong>TOTAL</strong></td>
								<td style="color: #000000;" align="center"><b>
								<?php
									$SchStrength = odbc_exec($conn, "SELECT COUNT([No_]) FROM [Temp Student] WHERE [Company Name]='$id' AND [Academic Year] = '$AcadYr' AND [Student Status] = 1 ");
									echo odbc_result($SchStrength, '');
								?></b>
								</td>
							</tr>
						</table>
					</div>
				</div>
			</div>
			<div class = "tab-pane fade" id = "fee">				
				<h1 class="text-primary">Fee Structure</h1>
				<table class="table table-responsive">
					<tr>
						<td>SN</td>
						<td>Academic Year</td>
						<td>Curriculum</td>
						<td>Class</td>
						<td>Description</td>
						<td>Occurrence</td>
						<td align="center">Amount</td>
						<td align="center">Total Amount</td>
						<td align="center">Fee Group</td>
					</tr>
					<?php
						$i=1;
						$rs = odbc_exec($conn, "SELECT * FROM [Class Fee Line] WHERE [Company Name]='$id' AND [Academic Year] = '$FinYr' ORDER BY [Group Code] ") or die(odbc_errormsg($conn));
						while(odbc_fetch_array($rs)){
					?>
					<tr>
						<td><?php echo $i?></td>
						<td align="center" ><?php echo odbc_result($rs, "Academic Year"); ?></td>
						<td><?php 			
							$Curr = odbc_exec($conn, "SELECT [Curriculum] FROM [Class Fee Header] WHERE [No_]='".odbc_result($rs, "Document No_")."'");
							echo odbc_result($Curr, "Curriculum");  ?></td>
						<td><?php echo odbc_result($rs, "Class"); ?></td>
						<td><?php echo odbc_result($rs, "Description"); ?></td>
						<td align="right"><?php 
										if(odbc_result($rs, "No_ of months") ==0) echo "One Time"; 
										if(odbc_result($rs, "No_ of months") ==1) echo "Monthly"; 
										if(odbc_result($rs, "No_ of months") ==2) echo "Quarter 1"; 
										if(odbc_result($rs, "No_ of months") ==3) echo "Quarter 2"; 
										if(odbc_result($rs, "No_ of months") ==4) echo "Quarter 3"; 
										if(odbc_result($rs, "No_ of months") ==5) echo "Quarter 4"; 
										if(odbc_result($rs, "No_ of months") ==6) echo "Half Yearly"; 
										if(odbc_result($rs, "No_ of months") ==7) echo "Annually"; 
						?></td>
						<td align="right"><?php echo number_format(odbc_result($rs, "Amount"),2,'.',''); ?></td>		
						<td align="right"><?php echo number_format(odbc_result($rs, "Total Amount"),2,'.',','); ?></td>
						<td><?php echo odbc_result($rs, "Group Code"); ?></td>						
					</tr>
					<?php
							$i++;
						}
					?>
				</table>
			
			</div>
			<div class = "tab-pane fade" id = "discount">

				<h1 class="text-primary">Discount Fee Structure</h1>
				<table class="table table-responsive">
					<tr>
						<td>SN</td>
						<td>Academic Year</td>
						<td>Class</td>
						<td>Document No</td>
						<td>Fee Code</td>
						<td>Discount % </td>
						<td>Description</td>
					</tr>
					<?php
						$i=1;
						$rs = odbc_exec($conn, "SELECT * FROM [Discount Fee Line] WHERE [Company Name]='$id' AND [Academic Year]='$FinYr'");
						while(odbc_fetch_array($rs)){
					?>
					<tr>
						<td><?php echo $i;?></td>
						<td align="center"><?php echo odbc_result($rs, 'Academic Year');?></td>
						<td><?php 
							$cls = odbc_exec($conn, "SELECT [Class] FROM [Discount Fee Header] WHERE [No_]='".odbc_result($rs, 'Document No_')."' AND [Company Name]='$CompName' ");
							echo odbc_result($cls, 'Class');
						?></td>
						<td><?php echo odbc_result($rs, 'Document No_');?></td>
						<td><?php echo odbc_result($rs, 'Fee Code');?></td>
						<td align="right"><?php echo number_format(odbc_result($rs, 'Discount%'),2,'.',',');?></td>
						<td><?php echo odbc_result($rs, 'Description');?></td>
					</tr>
					<?php
							$i++;
						}
					?>
				</table>				
			</div>
			<div class = "tab-pane fade" id = "royalty">				
				<!-- <h1 class="text-primary">Royalty</h1> -->
				<?php
					$td ="";
					$FeeHead = odbc_exec($conn, "SELECT [Fee Description] FROM [Royalty Setup] WHERE [Company Name]='$id' ") or die(odbc_errormsg($conn));
					$colspan = odbc_num_rows($FeeHead);
					while(odbc_fetch_array($FeeHead)){
						$td .= "<th style='text-align: center; border: none;'>".ucwords(strtolower(odbc_result($FeeHead, "Fee Description")))."</th>";
					}
				?>
				<table class="table table-responsive" border="1">
					<tr style="background-color: #000000; color: #ffffff">
						<th rowspan="2" style="text-align: center; border: none;">Qtr</th>
						<th colspan="<?php echo $colspan; ?>" style="text-align: center; border: none;">Generated</th>
						<th colspan="<?php echo $colspan; ?>" style="text-align: center; border: none;">Collected</th>
					</tr>
					<tr style="background-color: #000000; color: #ffffff">
						<?php echo $td; ?>
						<?php echo $td; ?>
					</tr>
					<?php
						$Fin = odbc_exec($conn, "SELECT DISTINCT([FinYr]) FROM [Ledger Invoice] WHERE [Company Name]='$id' ORDER BY [FinYr] DESC") or die(odbc_errormsg($conn));
						while(odbc_fetch_array($Fin)){
					?>
					<tr style="background-color: #BDBDBD;">
						<td colspan="<?php echo ($colspan*2)+1?>" style="text-align: center; font-weight: bold;"><?php echo odbc_result($Fin, "FinYr") ?></td>
					</tr>
					<?php
						//Get Quarter
						$Qtr = odbc_exec($conn, "SELECT DISTINCT([Qtr]) FROM [Ledger Invoice] WHERE [Company Name]='$id'") or die(odbc_errormsg($conn));
						while(odbc_fetch_array($Qtr)){
					?>
					<tr>
						<td><?php echo odbc_result($Qtr, "Qtr") ?></td>
						<?php
							$FeeHead = odbc_exec($conn, "SELECT [Fee Description] FROM [Royalty Setup] WHERE [Company Name]='$id' ") or die(odbc_errormsg($conn));
							while(odbc_fetch_array($FeeHead)){
								echo "<td style='text-align: right;'>";
								$Inv = odbc_exec($conn, "SELECT SUM([Net Amount]) FROM [Ledger Invoice] 
										WHERE [Fee Description] LIKE 'Net ".odbc_result($FeeHead, "Fee Description")." payable' 
										AND [Company Name]='$id' AND [Qtr]='".odbc_result($Qtr, "Qtr")."'  AND [FinYr]='".odbc_result($Fin, "FinYr")."' ");
								
								echo number_format(odbc_result($Inv, ""), "2", ".", "");
								echo "</td>";
								
							} // Fee Head
							
							$FeeHead1 = odbc_exec($conn, "SELECT [Fee Description] FROM [Royalty Setup] WHERE [Company Name]='$id' ") or die(odbc_errormsg($conn));
							while(odbc_fetch_array($FeeHead1)){
								echo "<td style='text-align: right;'>";
								$Pay = odbc_exec($conn, "SELECT SUM([Amount Paid]) FROM [Ledger Payment] 
										WHERE [Fee Description] LIKE 'Net ".ucwords(strtolower(odbc_result($FeeHead1, "Fee Description")))." payable' 
										AND [Company Name]='$id' AND [Qtr]='".odbc_result($Qtr, "Qtr")."'  AND [FinYr]='".odbc_result($Fin, "FinYr")."' ");
								
								echo number_format(odbc_result($Pay, ""), "2", ".", ""); 
								echo "</td>";
							}
						?>
						
					</tr>

				<?php
						} // Quarter
					} //Fin Year

				?>
				</table>
			</div>
			
            </td>
        </tr>
        
    </table>
</div>

<?php require_once("footer.php"); ?>

