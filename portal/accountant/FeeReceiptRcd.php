<?php
	require_once("../db.txt");
	require_once("../ConvertNum2Words.php");
	
	$ms = $_REQUEST['ms']; //Company Name
	$id = $_REQUEST['id']; //Enquiry No
	$inv = $_REQUEST['inv']; //Invoice No
	$amount = $_REQUEST['amount']; //amount
	$paymode=$_REQUEST['pay_mode'];
	$bank=$_REQUEST['$bank'];
	$chkno=$_REQUEST['chkno'];
	$chkdt=$_REQUEST['chkdt'];
	$dtd=$_REQUEST['pay_dt'];
	
	
	//Get School Name and Address Details
	$Comp = odbc_exec($conn, "SELECT [School Name], [Address], [Address 2], [Adress3], [Post Code], [City], [Picture],
						[Country_Region Code] AS [Country], [State], [Phone No_], [E-mail] FROM [Company Information] WHERE [ID]='$ms'") or exit(odbc_errormsg($conn));
	

	$AcadYr = $_REQUEST['AcadYr']; //Admission for Year
	$Student = strtoupper($_REQUEST['Student']); //Student Name
	$ReceiptNo = $_REQUEST['id']; //System Genrated No_

	$Class = $_REQUEST['Class']; //Class
	$TransFee = $_REQUEST['TransFee']; //Transport Fee	

//Get Student Details
$rs = odbc_exec($conn, "SELECT * FROM [Temp Application] WHERE [System Genrated No_]='$id' AND [Company Name]='$ms'  ") or exit(odbc_errormsg($conn));

?>
<!DOCTYPE html>
<html>
	<head>
		<title>Receipt</title>
		<style>
			html, body, wrapper{
				margin:0px;
				font-family: arial;
				font-size: 11px;
			}
		</style>
		<script>
			if (opener && !opener.closed) {
			opener.location.href = "FeeReceiptEntry.php?invoice=<?php echo $id;?>";
			}
		</script>
	</head>
	<body  onload="window.print()">
<?php 
	for($i=0; $i<2; $i++ ){
?>
<table width="100%" style="font-family: arial; font-size: 10px; border: 1px solid #000000;" align="center" width="100%" border="0px" >
	<tr>
		<td width="30%" valign="top" colspan="2" rowspan="4">
			<img src="<?php echo odbc_result($Comp, "Picture")?>" style="width: 100px; height: 100px">
		</td>
		<td valign="top" align="justify" colspan="4"><h2><?php echo odbc_result($Comp, 'School Name')?></h2></td>
	</tr>
	<tr>
		<td width="30%" valign="top" colspan="2"><?php echo odbc_result($Comp, 'Address')?></td>
	</tr>
	<tr>
		<td width="30%" valign="top" colspan="2"><?php echo odbc_result($Comp, 'Address 2') ?><?php echo odbc_result($Comp, 'Address 3') ?></td>
	</tr>
	<tr>
		<td width="30%" valign="top" colspan="2"><?php echo odbc_result($Comp, 'City')?> <?php echo odbc_result($Comp, 'State')?> Phone: <?php echo odbc_result($Comp, 'Phone No_')?> </td>
	</tr>
	<tr>
		<td width="30%" height="40px" colspan="5" align="center"><br /><span style="font-weight: bold; font-size: 14px;">Fee - Receipt</span><br /></td>
	</tr>
         <?php 
      $Admission = odbc_exec($conn, "SELECT [No_] FROM [Temp Student] WHERE [Registration No_]='$id' AND [Company Name]='$ms'") or die(odbc_errormsg($conn));
         $AdmissionNo = odbc_result($Admission, "No_");
      ?>
        <tr>	
		
		<td style="font-weight:bold;">Student No:</td>
		<td style="font-family: garamond; font-size: 11px;"><?php echo $AdmissionNo?></td>
	</tr>
	<tr>	
		<td style="font-weight:bold;"><label>Master / Miss :</label></td>
		<td colspan="2" style="font-family: garamond; font-size: 11px; font-weight: bold;">
			<?php echo strtoupper(odbc_result($rs, "Name"))?>
		</td>
		<td style="font-weight:bold;">Receipt No:</td>
		<td style="font-family: garamond; font-size: 11px;"><?php echo odbc_result($rs, "No_")?></td>
	</tr>
	<tr>
		<td style="font-weight:bold;"><label>S.O. / D.O :</label></td>
		<td colspan="2" style="font-family: garamond; font-size: 11px;"><?php echo odbc_result($rs, "Father_s Name")?></b></td>
		<td style="font-weight:bold;">Class:</td>
		<td style="font-family: garamond; font-size: 11px;"><?php echo odbc_result($rs, "Class")?></b></td>
	</tr>
	<tr>
		<td style="font-weight:bold;">Addmission for year: </td>
		<td colspan="2" style="font-family: garamond; font-size: 11px;"><?php echo odbc_result($rs, "Admission for Year")?></b></td>
		<td style="font-weight:bold;">Contact No:</td>
		<td style="font-family: garamond; font-size: 11px;"><?php echo odbc_result($rs, "Mobile Number")?></b></td>
	</tr>
	<tr>
		<td style="font-weight:bold;">Resident of :</td>
		<td colspan="4" style="font-family: garamond; font-size: 11px;"><?php echo odbc_result($rs, "Address1")?> <?php echo odbc_result($rs, "Address2")?> <?php echo odbc_result($rs, "City")?> <?php echo odbc_result($rs, "State")?> <?php echo odbc_result($rs, "Country")?> <?php echo odbc_result($rs, "Post Code")?></b></b></b></b></td>
	</tr>
	<tr>
		<td colspan="5" style="font-weight:bold;" >Received with thanks from Mr./Mrs.
		<span style="font-family: garamond; font-size: 11px;"><?php echo odbc_result($rs, "Addressee")?></span></td>
	</tr>
	<tr>
		<td colspan="5" valign="bottom" style="font-family: garamond; font-size: 11px;font-weight: bold;">a sum of Rs.
		<span style="font-family: garamond; font-size: 11px;"><?=number_format($amount,2,'.', '')?>
		(Rupees <?=strtoupper(convert_number_to_words(number_format($amount,2,'.', '')));?> Only) </span>
		</td>
	</tr>
	<tr>
		<td colspan="2" style="font-weight:bold;">vide cash / cheque / DD No</td>
		<td style="font-family: garamond; font-size: 11px;">
			<?php
				if($paymode == "CASH"){
					echo "CASH";
				}
				else{
					echo $paymode. " / Instr. No. - ".$chkno;
				}
			?>
		</td>
		<td style="font-weight:bold;">Dated : </td>
		<td style="font-family: garamond; font-size: 11px;"><?php 	echo $dtd; ?></td>
	</tr>
	<tr>
		<td style="font-weight:bold;">Instr. Bank Name & Branch</td>
		<td style="font-family: garamond; font-size: 11px;"><?php echo ($bank?$bank:"N/A") ;?></td>
	</tr>
	<tr>
		<td colspan="3" height="80px"></td>
		<td colspan="2" valign="top" style="font-weight:bold;">Thank you.</td>
	</tr>
	<tr>
		<td height="60px" valign="bottom" style="font-weight:bold;">Date</td>
		<td style="font-family: garamond; font-size: 11px;" valign="bottom"><?php echo $dtd;?></td>
		<td></td>
		<td colspan="2" valign="bottom" style="font-weight:bold;">Authorised Signatory</td>
	</tr>
</table>
<br /><br /><br /><br />
<?php
	}
?>

</body>
</html>
