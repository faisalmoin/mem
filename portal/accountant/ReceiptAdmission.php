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
		<title>Invoice</title>
		<!-- Bootstrap core CSS -->
		<link href="../bs/css/bootstrap.min.css" rel="stylesheet" />
		<!-- Custom styles for this template -->
		<link href="../bs/css/sticky-footer-navbar.css" rel="stylesheet" />
		<script src="../bs/js/ie-emulation-modes-warning.js"></script>
		<script src="../bs/js/jquery.min.js"></script>
		<script src="../bs/js/bootstrap.js"></script>
		<style type="text/css" media="print">
                     @media print {
                    
	          html, body {
	            margin: 0px;
	            padding: 0px;
	            background: #FFF; 
	            font-size: 9px;
                   
                   .noprint { display: none; }
 
                   
	          }
                  
	          .container, .container div {
	            width: 100%;
	            margin: 0;
	            padding: 0;
	          }
	          .template { overflow: hidden; }
	          img { width: 100%; }
	        }
                
                
               @page{
                    size: auto A4 landscape;
                    margin-right: 0mm;
                    margin-left: 0mm;
                    margin-top: 8mm;
                    margin-bottom: 8mm;

                    
                  }
                header header nav, footer{
                display: none;
                }

               
		</style>
		<script>
			if (opener && !opener.closed) {
			<?php if($_REQUEST[loop]==1){?>
			opener.location.href = "ListSelection.php?eid=<?php echo odbc_result($Student, "System Genrated No_");?>&Stu=<?php echo odbc_result($Student, "Name"); ?>'";
			<?php } ?>
			}
		</script>
	</head>
        <body onload="window.print()">	
            <table class="table table-responsive" style="margin:12px;">
             <tr>
              <td style="padding-right: 25px;">
	       <div>
		<table class="table table-responsive" style="border: 1px solid #d3d3d3; border-style: dashed;" >
			<tr>
                            <?php
                            $SchoolName= odbc_exec($conn, "SELECT * FROM [Company Information] WHERE [ID]='$ms' ");
                            
                            ?>
                             <?php if(odbc_result($SchoolName, "Picture") != ""){ ?>
                               <td rowspan="2" style="border: 1px solid #d3d3d3; border: none;">
				<img src="<?php echo odbc_result($SchoolName, "Picture")?>" style="width: 120px; height: 120px">
				</td>
                              <?php } ?>
				<td colspan="5" align="center" valign="top" style="border: none;">
                                   <h4><?php echo odbc_result($comp, "Name")?></h4>
				<?php 
					echo strtoupper(odbc_result($comp, "Address"))." ".strtoupper(odbc_result($comp, "Address 2"))." ".strtoupper(odbc_result($comp, "Adress3"))." <br />";
					echo strtoupper(odbc_result($comp, "City"))." ".strtoupper(odbc_result($comp, "State"))." - ".odbc_result($comp, "Post Code")." ".odbc_result($comp, "Country")."<br />";
					echo "Phone: ".odbc_result($comp, "Phone No_")." Email: ".strtolower(odbc_result($comp, "E-mail"))."<br />";
				?>
				</td>
			</tr>
			<tr>
				<td colspan="5" align="center" valign="top" style="border: none;"><h4>Invoice</h4></td>
			</tr>
			<tr>
				<td colspan="4">Date: <b><?php echo date('d/M/Y'); ?></b></td>
				<td align='right'>Invoice No: </td>
				<td><b><?php echo $inv;?></b></td>
			</tr>
                        <?php
  $Admission = odbc_exec($conn, "SELECT [No_] FROM [Temp Student] WHERE [Registration No_]='".odbc_result($Student, 'System Genrated No_')."' AND [Company Name]='$ms'") or die(odbc_errormsg($conn));
         $AdmissionNo = odbc_result($Admission, "No_");
?>
                       <tr>
				
				<td width="20%" style="border: none;">Student No: </td>
				<td colspan="3" align="justify" style="border: none;"><b><?php echo $AdmissionNo?></b></td>
			</tr>
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
				<td style="border: 2px solid #d3d3d3;">S.No</td>
				<td colspan="2" style="border: 2px solid #d3d3d3;">Description</td>
				<td align="center" style="border: 2px solid #d3d3d3;">Amount</td>
				<td align="center" style="border: 2px solid #d3d3d3;">Discount Amount</td>
				<td align="center" style="border: 2px solid #d3d3d3;">Net Amount</td>
			</tr>
			<?php
				$i = 1;
				$rs = odbc_exec($conn, "SELECT * FROM [Ledger Invoice] 
					WHERE [Company Name]='$ms' AND [Customer No]='$id' AND [Invoice No]='$inv' AND [Reverse]=0 ");
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
                                        }?>
			        </tr><?php
					$i++;
				}
			?>
			<tr>
				<td colspan="3" style="border-left: 1px solid #d3d3d3; border-top: 1px solid #d3d3d3; border-bottom: 1px solid #d3d3d3;"><b>TOTAL</b></td>				
                                <td style="border-top: 1px solid #d3d3d3;border-bottom: 1px solid #d3d3d3;border-right: 1px solid #d3d3d3; border-left: 1px solid #d3d3d3;">
                                    <?php
					//Get Amount From Credit
					$TotAmt1 = odbc_exec($conn, "SELECT SUM([Amount]) FROM [Ledger Invoice] WHERE [Invoice No]='$inv' AND [Customer No]='$id' AND [Company Name]='$ms' AND [Reverse]=0 ");
					echo number_format(odbc_result($TotAmt1, ""),2, '.','');				
				?>
                                </td>
                                <td align="right" style="border-top: 1px solid #d3d3d3;border-bottom: 1px solid #d3d3d3;border-right: 1px solid #d3d3d3;">
                                <?php
					//Get Amount From Credit
					$TotAmt2 = odbc_exec($conn, "SELECT SUM([Discount Code1 Amount]) FROM [Ledger Invoice] WHERE [Invoice No]='$inv' AND [Customer No]='$id' AND [Company Name]='$ms' AND [Reverse]=0 ");
					echo number_format(odbc_result($TotAmt2, ""),2, '.','');				
				?></td>
                                <td style="border-top: 1px solid #d3d3d3;border-bottom: 1px solid #d3d3d3;border-right: 1px solid #d3d3d3;" align="right"><b>
				<?php
					//Get Amount From Credit
					$TotAmt = odbc_exec($conn, "SELECT SUM([Net Amount]) FROM [Ledger Invoice] WHERE [Invoice No]='$inv' AND [Customer No]='$id' AND [Company Name]='$ms' AND [Reverse]=0 ");
					echo number_format(odbc_result($TotAmt, ""),2, '.','');				
				?></b>
				</td>
			</tr>
			<tr>
				<td style="border-top: 1px solid #d3d3d3;" colspan="5">				
					Amount in Words: Rupees <b><?php echo strtoupper(convert_number_to_words(round(odbc_result($TotAmt, ""))));?></b> Only
				</td>
			</tr>
			<!--tr>
				<td colspan="6">				
				
					<p>DD / Cheque No. : .................................................. Bank: ......................................... Dated: ......................................... </p>
						(<i>Admission is subject to realisation of Cheque(s)</i>)
				</td>
			</tr-->
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
        </div></td>
        
        
        <!---------------------------------------------------------second invoice-------------------------------------------------------------------->
        
        <td>
            <div>
		<table class="table table-responsive" style="border: 1px solid #d3d3d3; border-style: dashed;">
			<tr>
                            <?php
                            $SchoolName= odbc_exec($conn, "SELECT * FROM [Company Information] WHERE [ID]='$ms' ");
                            
                            ?>
                             <?php if(odbc_result($SchoolName, "Picture") != ""){ ?>
                               <td rowspan="2" style="border: 1px solid #d3d3d3; border: none;">
				<img src="<?php echo odbc_result($SchoolName, "Picture")?>" style="width: 120px; height: 120px">
				</td>
                              <?php } ?>
				<td colspan="5" align="center" valign="top" style="border: none;">
                                   <h4><?php echo odbc_result($comp, "Name")?></h4>
				<?php 
					echo strtoupper(odbc_result($comp, "Address"))." ".strtoupper(odbc_result($comp, "Address 2"))." ".strtoupper(odbc_result($comp, "Adress3"))." <br />";
					echo strtoupper(odbc_result($comp, "City"))." ".strtoupper(odbc_result($comp, "State"))." - ".odbc_result($comp, "Post Code")." ".odbc_result($comp, "Country")."<br />";
					echo "Phone: ".odbc_result($comp, "Phone No_")." Email: ".strtolower(odbc_result($comp, "E-mail"))."<br />";
				?>
				</td>
			</tr>
			<tr>
				<td colspan="5" align="center" valign="top" style="border: none;"><h4>Invoice</h4></td>
			</tr>
			<tr>
				<td colspan="4">Date: <b><?php echo date('d/M/Y'); ?></b></td>
				<td align='right'>Invoice No: </td>
				<td><b><?php echo $inv?></b></td>
			<tr>
                            <tr>
				
				<td width="20%" style="border: none;">Student No: </td>
				<td colspan="3" align="justify" style="border: none;"><b><?php echo $AdmissionNo?></b></td>
			</tr>
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
				<td style="border: 2px solid #d3d3d3;">S.No</td>
				<td colspan="2" style="border: 2px solid #d3d3d3;">Description</td>
				<td align="center" style="border: 2px solid #d3d3d3;">Amount</td>
				<td align="center" style="border: 2px solid #d3d3d3;">Discount Amount</td>
				<td align="center" style="border: 2px solid #d3d3d3;">Net Amount</td>
			</tr>
			<?php
				$i = 1;
				$rs = odbc_exec($conn, "SELECT * FROM [Ledger Invoice] 
					WHERE [Company Name]='$ms' AND [Customer No]='$id' AND [Invoice No]='$inv' AND [Reverse]=0 ");
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
                                       } ?>
			        </tr>
			        <?php
					$i++;
				       }
			          ?>
			       <tr>
				<td colspan="3" style="border-left: 1px solid #d3d3d3; border-top: 1px solid #d3d3d3; border-bottom: 1px solid #d3d3d3;"><b>TOTAL</b></td>				
				 <td style="border-top: 1px solid #d3d3d3;border-bottom: 1px solid #d3d3d3;border-right: 1px solid #d3d3d3; border-left: 1px solid #d3d3d3;">
                                    <?php
					//Get Amount From Credit
					$TotAmt1 = odbc_exec($conn, "SELECT SUM([Amount]) FROM [Ledger Invoice] WHERE [Invoice No]='$inv' AND [Customer No]='$id' AND [Company Name]='$ms' AND [Reverse]=0 ");
					echo number_format(odbc_result($TotAmt1, ""),2, '.','');				
				?>
                                </td>
                                <td align="right" style="border-top: 1px solid #d3d3d3;border-bottom: 1px solid #d3d3d3;border-right: 1px solid #d3d3d3;">
                                <?php
					//Get Amount From Credit
					$TotAmt2 = odbc_exec($conn, "SELECT SUM([Discount Code1 Amount]) FROM [Ledger Invoice] WHERE [Invoice No]='$inv' AND [Customer No]='$id' AND [Company Name]='$ms' AND [Reverse]=0 ");
					echo number_format(odbc_result($TotAmt2, ""),2, '.','');				
				?></td>
                                <td style="border-top: 1px solid #d3d3d3;border-bottom: 1px solid #d3d3d3;border-right: 1px solid #d3d3d3;" align="right"><b>
				<?php
					//Get Amount From Credit
					$TotAmt = odbc_exec($conn, "SELECT SUM([Net Amount]) FROM [Ledger Invoice] WHERE [Invoice No]='$inv' AND [Customer No]='$id' AND [Company Name]='$ms' AND [Reverse]=0 ");
					echo number_format(odbc_result($TotAmt, ""),2, '.','');				
				?></b>
				</td>
			</tr>
			<tr>
				<td style="border-top: 1px solid #d3d3d3;" colspan="5">				
					Amount in Words: Rupees <b><?php echo strtoupper(convert_number_to_words(round(odbc_result($TotAmt, ""))));?></b> Only
				</td>
			</tr>
			<!--tr>
				<td colspan="6">				
				
					<p>DD / Cheque No. : .................................................. Bank: ......................................... Dated: ......................................... </p>
						(<i>Admission is subject to realisation of Cheque(s)</i>)
				</td>
			</tr-->
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
         </td>
       </tr>
      </table>
    </body>
</html>
