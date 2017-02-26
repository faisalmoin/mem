<?php
	require_once("../db.txt");

	$id=$_REQUEST['id'];
	$ms=$_REQUEST['ms'];
	$LoginID=$_REQUEST['LoginID'];
	/*
	$UserCompany=mysql_query("SELECT `CompanyTableID`, `CompanyERPCode` FROM `usermap` WHERE `UserLoginID`='$LoginID'") or die(mysql_error());
	$UsrComp=mysql_fetch_array($UserCompany);
	
	//Connect to SchoolERP DB
	$CompanyName=mysql_query("SELECT `Name` FROM `company` WHERE `id`='".$UsrComp[0]."'") or die(mysql_error());
	$CompName=mysql_fetch_array($CompanyName);
	*/
	
	$Comp=odbc_exec($conn, "SELECT * FROM [company information] WHERE [id]='$ms'") or die(odbc_errormsg($conn));
		
	$stuRec = "SELECT * FROM [Temp Application] WHERE [Enquiry No_]='".$id."' AND [Company Name]='".$ms."' ";
	$rs = odbc_exec($conn, $stuRec);
	
	require_once("../ConvertNum2Words.php");
?>
<html>
<head>
	<title>Registration Receipt</title>
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
		<td width="30%" height="40px" colspan="5" align="center"><br /><span style="font-weight: bold; font-size: 14px;">Registration Fee - Receipt</span><br /></td>
	</tr>
	<tr>	
		<td style="font-weight:bold;"><label>Master / Miss :</label></td>
		<td colspan="2" style="font-family: garamond; font-size: 11px; font-weight: bold;"><?php echo strtoupper(odbc_result($rs, "Name"))?></td>
		<td style="font-weight:bold;">Receipt No:</td>
		<td style="font-family: garamond; font-size: 11px;"><?php echo odbc_result($rs, "No_")?></td>
	</tr>
	<tr>
		<td style="font-weight:bold;"><label>S.O. / D.O :</label></td>
		<td colspan="2" style="font-family: garamond; font-size: 11px;"><?php echo odbc_result($rs, "Father_s Name")?></b></td>
		<td style="font-weight:bold;">Session:</td>
		<td style="font-family: garamond; font-size: 11px;"><?php echo odbc_result($rs, "Academic Year")?></b></td>
	</tr>
	<tr>
		<td style="font-weight:bold;">Addmission for : </td>
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
		<span style="font-family: garamond; font-size: 11px;"><?=number_format((float)odbc_result($rs, "Application Cost"),2,'.', '')?>
		(Rupees <?=strtoupper(convert_number_to_words(number_format((float)odbc_result($rs, "Application Cost"),2,'.', '')));?> Only) </span>
		</td>
	</tr>
	<tr>
		<td colspan="2" style="font-weight:bold;">vide cash / cheque / DD No</td>
		<td style="font-family: garamond; font-size: 11px;"><?php echo ((odbc_result($rs, "Mode of Payment")!="CASH")?odbc_result($rs, "Bank Name"): "CASH" );?> / No. <?php echo odbc_result($rs, "Cheque _ DD No_")?></td>
		<td style="font-weight:bold;">Dated : </td>
		<td style="font-family: garamond; font-size: 11px;"><?php 
			if(odbc_result($rs, "Cheque _ DD Date") != '1753-01-01 00:00:00.000' ){
				echo date('d/M/Y', strtotime(odbc_result($rs, "Cheque _ DD Date")));
			}
			else{
				echo "";
			}
		?></td>
	</tr>
	<tr>
		<td style="font-weight:bold;">Registration Form No</td>
		<td style="font-family: garamond; font-size: 11px;"><?php echo odbc_result($rs, "Registration No_");?></td>
		<td></td>
		<td colspan="2" valign="top" style="font-weight:bold;">Thank you.</td>
	</tr>
	<tr>
		<td height="60px" valign="bottom" style="font-weight:bold;">Date</td>
		<td style="font-family: garamond; font-size: 11px;" valign="bottom"><?php echo date('d/M/Y', strtotime(odbc_result($rs, "Date of Sale")));?></td>
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