<?php
	require_once("../db.txt");
	require_once("../ConvertNum2Words.php");
	
	$ms = $_REQUEST['ms']; //Company Name
	$id = $_REQUEST['id']; //Enquiry No
	$inv = $_REQUEST['inv']; //Invoice No
	
	//Get School Name and Address Details
	$comp = odbc_exec($conn, "SELECT[School Name] AS [Name], [Address], [Address 2], [Adress3], [Post Code], [City], 
						[Country_Region Code] AS [Country], [State], [Phone No_], [E-mail] FROM [Company Information] WHERE [ID]='$ms'") or exit(odbc_errormsg($conn));
	//$comp = mysql_fetch_array($Company);

	$AcadYr = $_REQUEST['AcadYr']; //Admission for Year
	$Student = strtoupper($_REQUEST['Student']); //Student Name
	$ReceiptNo = $_REQUEST['id']; //System Genrated No_

	$Class = $_REQUEST['Class']; //Class
	$TransFee = $_REQUEST['TransFee']; //Transport Fee	

//Get Student Details
$Student = odbc_exec($conn, "SELECT * FROM [Temp Application] WHERE [System Genrated No_]='$id' AND [Company Name]='$ms'  ") or exit(odbc_errormsg($conn));


?>
<!DOCTYPE html>
<html>
	<head>
		<title>Fee - Pay-in Slip</title>
		<!-- Bootstrap core CSS -->
		<link href="../bs/css/bootstrap.min.css" rel="stylesheet" />
		
		<!-- Custom styles for this template -->
		<link href="../bs/css/sticky-footer-navbar.css" rel="stylesheet" />
			
		<!-- Just for debugging purposes. Don't actually copy these 2 lines! -->
		<!--[if lt IE 9]><script src="../../assets/js/ie8-responsive-file-warning.js"></script><![endif]-->
		<script src="../bs/js/ie-emulation-modes-warning.js"></script>
		<script src="../bs/js/jquery.min.js"></script>
		<script src="../bs/js/bootstrap.js"></script>
		<style>
			@media print {
	          html, body {
	            margin: 0;
	            padding: 0;
	            background: #FFF; 
	            font-size: 9px;
	          }
	          .container, .container div {
	            width: 100%;
	            margin: 0;
	            padding: 0;
	          }
	          .template { overflow: hidden; }
	          img { width: 100%; }
	        }
                
                 .circleBase {
                        border-radius: 50%;
                        behavior: url(PIE.htc); /* remove if you don't care about IE8 */
                    }

                    .type1 {
                        width: 100px;
                        height: 100px;
                        background: yellow;
                        border: 3px solid red;
                    }
       
                
		</style>
		<script>
			if (opener && !opener.closed) {
			opener.location.href = "ListSelection.php?eid=<?php echo odbc_result($Student, "System Genrated No_");?>&Stu=<?php echo odbc_result($Student, "Name"); ?>'";
			}
		</script>
	</head>
	<body onload="window.print()">	
	<div>
		<table class="table table-responsive">
			<tr>
                            <?php
                            $SchoolName= odbc_exec($conn, "SELECT * FROM [Company Information] WHERE [ID]='$ms' ");
                            
                            ?>
                            <!--td>
                                <div class="circleBase type1"> <--?php if(odbc_result($SchoolName, "Picture") != ""){ ?>
                                    <img src="<--?php echo odbc_result($SchoolName, "Picture")?>" style="width: 230px; height: 70px">
				     <--?php } ?></div></td-->
                               <!--td rowspan="2" style="border: 1px solid #d3d3d3; border: none;">
				<img src="<--?php echo odbc_result($SchoolName, "Picture")?>" style="width: 200px; height: 80px">
				</td-->
                            
				<td colspan="6" align="center" valign="top" style="border: none;">
                                    <?php if(odbc_result($SchoolName, "Picture") != ""){ ?>
                                    <img src="<?php echo odbc_result($SchoolName, "Picture")?>" style="width: 230px; height: 70px">
				     <?php } ?>
                                    <h4><?php echo odbc_result($comp, "Name")?></h4>
				<?php 
					echo strtoupper(odbc_result($comp, "Address"))." ".strtoupper(odbc_result($comp, "Address 2"))." ".strtoupper(odbc_result($comp, "Adress3"))." <br />";
					echo strtoupper(odbc_result($comp, "City"))." ".strtoupper(odbc_result($comp, "State"))." - ".odbc_result($comp, "Post Code")." ".odbc_result($comp, "Country")."<br />";
					echo "Phone: ".odbc_result($comp, "Phone No_")." Email: ".strtolower(odbc_result($comp, "E-mail"))."<br />";
				?>
				</td>
			</tr>
			<tr>
				<td colspan="6" align="center" valign="top" style="border: none;"><h4>Fee - Pay-in Slip</h4></td>
			</tr>
			<tr>
				<td colspan="4">Date: <b><?php echo date('d/M/Y'); ?></b></td>
				<td align='right'>Receipt No: </td>
				<td><b><?php echo odbc_result($Student, 'System Genrated No_')?></b></td>
			<tr>
			<tr>
				<td width="20%" style="border: none;">Name</td>
				<td colspan="3" align="justify" style="border: none;" ><?php 
					echo "<b>";
					if(odbc_result($Student, "Gender")==1) echo "Master ";
					if(odbc_result($Student, "Gender")==2) echo "Miss ";
					echo odbc_result($Student, "Name");
					echo "</b> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
				?></td>
			</tr>
			<tr>
				<td style="border: none;">
					<?php
						if(odbc_result($Student, "Gender")==1) echo "Son of ";
						if(odbc_result($Student, "Gender")==2) echo "Daughter of ";					
					?>
				</td>
				<td colspan="3" style="border: none;">
					<?php
						if(odbc_result($Student, "Address To")=="FATHER") echo " <b>Sri. ".strtoupper(odbc_result($Student, "Father_s Name"))."</b>";
						if(odbc_result($Student, "Address To")=="MOTHER") echo " <b>Smt. ".strtoupper(odbc_result($Student, "Mother_s Name"))."</b>";
						if(odbc_result($Student, "Address To")!="FATHER" || odbc_result($Student, "Address To")=="MOTHER") echo " <b>Sri ".strtoupper(odbc_result($Student, "Father_s Name"))."</b> ";
					?>
				</td>
			</tr>
			<tr>
				<td style="border: none;">Address</td>
				<td colspan="5" style="border: none;">
					<?php
						echo "<b>".odbc_result($Student, "Address1")." ".odbc_result($Student, "Address2")." ".odbc_result($Student, "City")." ".odbc_result($Student, "State")."</b>";
					?>
				</td>
			</tr>
			<tr>
				<td style="border: none;">Class / Section</td>
				<td  style="border: none;" colspan="3"><b>
					<?php
						echo odbc_result($Student, "Class") ." / ". odbc_result($Student, "Section")
					?></b>
				</td>
				<td align="right" style="border: none;">Academic Year</td>
				<td style="border: none;"><b><?php
						echo odbc_result($Student, "Admission for Year") ;
					?></b></td>
			<tr>
			<tr style="font-weight: bold">
				<td style="border: 1px solid #000000;">SN</td>
				<td colspan="2" style="border: 1px solid #000000;">Description</td>
				<td align="center" style="border: 1px solid #000000;">Amount</td>
				<td align="center" style="border: 1px solid #000000;">Discount Amount</td>
				<td align="center" style="border: 1px solid #000000;">Net Amount</td>
			</tr>
			<?php
				$i = 1;
				$rs = odbc_exec($conn, "SELECT * FROM [Ledger Invoice] 
					WHERE [Company Name]='$ms' AND [Customer No]='$id' AND [Invoice No]='$inv' ");
				while(odbc_fetch_array($rs)){			
			?>
			<tr style="font-weight: normal;">
				<td><?php echo $i;?></td>
				<td colspan="2"><?php 
					$a = odbc_result($rs, "Fee Description");
					if(strpos($a, 'Net ') !== false && strpos($a, ' payable') !== false){
							echo "<b><i>".odbc_result($rs, "Fee Description")."</i></b>";
					}	
					else{
						echo $a;
					}
				?></td>
				<?php if(odbc_result($rs, "Amount") != 0){ ?>
				<td align="right"><?php echo number_format(odbc_result($rs, "Amount"),2,'.',',');?></td>
				<td><span>&nbsp;</span></td>
				<td><span>&nbsp;</span></td>
				<?php }
					if(odbc_result($rs, "Amount") == 0 && odbc_result($rs, "Discount Code1") != ""){
						echo "<td></td><td align='right'>".number_format(odbc_result($rs, "Discount Code1 Amount"),2,'.',',')."</td><td><span>&nbsp;</span></td>";
					}
					//if(odbc_result($rs, "Amount") == 0 && odbc_result($rs, "Discount Code1") == "" && odbc_result($rs, "Net Amount") !=0){
                                            if(odbc_result($rs, "Amount") == 0 && odbc_result($rs, "Discount Code1") == ""){
						echo "<td></td><td></td><td align='right'><b>".number_format(odbc_result($rs, "Net Amount"),2,'.',',')."</b></td>";
                                               
					}
						
				?>
			</tr>
			
			<?php
					$i++;
				}
			?>
			<tr>
				<td colspan="5" style="border-left: 1px solid #000000; border-top: 1px solid #000000; border-bottom: 1px solid #000000;"><b>TOTAL</b></td>				
				<td style="border-top: 1px solid #000000;border-bottom: 1px solid #000000;border-right: 1px solid #000000;" align="right"><b>
				<?php
					//Get Amount From Credit
					$TotAmt = odbc_exec($conn, "SELECT SUM([Net Amount]) FROM [Ledger Invoice] WHERE [Invoice No]='$inv' AND [Customer No]='$id' AND [Company Name]='$ms' ");
					echo number_format(odbc_result($TotAmt, ""),2, '.','');				
				?></b>
				</td>
			</tr>
			<tr>
				<td style="border-top: 1px solid #000000;" colspan="5">				
					Amount in Words: Rupees <b><?php echo strtoupper(convert_number_to_words(round(odbc_result($TotAmt, ""))));?></b> Only
				</td>
			</tr>
			<tr>
				<td colspan="6">				
				
					<p>DD / Cheque No. : .................................................. Bank: ......................................... Dated: ......................................... </p>
						(<i>Admission is subject to realisation of Cheque(s)</i>)
				</td>
			</tr>
			<tr>
				<td colspan="6" height="80px" style="border: none;"></td>
			</tr>
			<tr>
				<td colspan="2" align="center">School Seal</td>
				<td colspan="2" style="border: none;"></td>
				<td colspan="2" align="center">Receiver's Signature</td>
			</tr>
			<tr>
				<td colspan="7" style="border-top: 1px solid #000000;" align="center">
				The above amount once paid will not be refunded under any circumstances.
				</td>
			</tr>
		</table>
		</div>
	</body>
</html>
