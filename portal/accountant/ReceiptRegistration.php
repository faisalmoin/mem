<?php

	require_once("../db.txt");
	require_once("../ConvertNum2Words.php");

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
	

?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <!-- Meta, title, CSS, favicons, etc. -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>MEM School ERP | Registration Receipt</title>

    <!-- Bootstrap -->
    <link href="../vendors/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link href="../vendors/font-awesome/css/font-awesome.min.css" rel="stylesheet">
    <!-- NProgress -->
    <link href="../vendors/nprogress/nprogress.css" rel="stylesheet">
    <!-- iCheck -->
    <link href="../vendors/iCheck/skins/flat/green.css" rel="stylesheet">
    <!-- jQuery custom content scroller -->
    <link href="../vendors/malihu-custom-scrollbar-plugin/jquery.mCustomScrollbar.min.css" rel="stylesheet"/>

    <!-- Custom Theme Style -->
    <link href="../build/css/custom.min.css" rel="stylesheet">
</head>
<body  onload="window.print()">

<!-- Body -->
<div class="right_col" role="main">
	<div class="">
		<div class="page-title">
			<div class="title_left"></div>

			<div class="clearfix"></div>

			<div class="row">
				<?php 
					for($i=0; $i<2; $i++ ){
				?>
				<div class="col-md-6 col-sm-12 col-xs-6">
					<div class="x_panel">
						<div class="x_content">
						<!-- Content -->
							<table class="table ">
								<tr>
									<td valign="top" style="border: none; width: 150px">
										<img src="<?php echo odbc_result($Comp, "Picture")?>" style="width: 100%" align="left" style="padding: 5px;">
									</td>
									<td colspan="4" style="border: none">
									<h2><?php echo odbc_result($Comp, 'School Name')?></h2>
									<?php echo odbc_result($Comp, 'Address')?> <?php echo odbc_result($Comp, 'Address 2') ?><?php echo odbc_result($Comp, 'Address 3') ?>
									<?php echo odbc_result($Comp, 'City')?> <?php echo odbc_result($Comp, 'State')?> <br />Phone: <?php echo odbc_result($Comp, 'Phone No_')?> 
									
									</td>
								</tr>
								<tr>
									<td colspan="5" align="center" style="border:none;"><br /><span style="font-size: 18px;">Registration Fee - Receipt</span><br /></td>
								</tr>
								<tr>	
									<td style="border:none;">Master / Miss :</td>
									<td colspan="2" style="border:none;"><?php echo strtoupper(odbc_result($rs, "Name"))?></td>
									<td style="border:none;">Receipt No : </td>
									<td style="border:none;"><b><?php echo odbc_result($rs, "No_")?></b></td>
								</tr>
								<tr>
									<td style="border:none;">S.O. / D.O :</td>
									<td colspan="2" style="border:none;"><b><?php echo odbc_result($rs, "Father_s Name")?></b></td>
									<td style="border:none;">Session : </td>
									<td style="border:none;"><b><?php echo odbc_result($rs, "Academic Year")?></b></td>
								</tr>
								<tr>
									<td style="border:none;">Addmission for : </td>
									<td colspan="2" style="border:none;"><b><?php echo odbc_result($rs, "Admission for Year")?></b></td>
									<td style="border:none;">Class : </td>
									<td style="border:none;"><b><?php echo odbc_result($rs, "Class")?></b></td>
								</tr>
								<tr>
									<td style="border:none;">Resident of :</td>
									<td colspan="4" style="border:none;"><?php echo odbc_result($rs, "Address1")?> <?php echo odbc_result($rs, "Address2")?> 	<?php echo odbc_result($rs, "Country")?> <?php echo odbc_result($rs, "Post Code")?>
									</td>
								</tr>
						
                        <tr>
						<td colspan="5" style="border:none;" >Received with thanks from Mr./Mrs.
										<strong><?php echo odbc_result($rs, "Addressee")?></strong> a sum of <strong>Rs. <?php echo number_format((float)odbc_result($rs, "Application Cost"),2,'.', '')?></strong> (Rupees <?php  echo strtoupper(convert_number_to_words(round(odbc_result($rs, "Application Cost"))))?> Only) 
									</td>
								</tr>
                       


								<tr>
									<td colspan="2" style="border:none;">vide <strong>
										<?php
											if(odbc_result($rs, "Mode of Payment")=="CASH") {echo "CASH";}
											else if(odbc_result($rs, "Mode of Payment")!="CASH") {echo odbc_result($rs, "Mode of Payment");}
										?>
										</strong>
									</td>
									<td style="border:none;" colspan="3">
									<?php
										if((odbc_result($rs, "Mode of Payment")!="CASH")){
											echo "Bank : ". odbc_result($rs, "Bank Name") ." Instrument No. : ".odbc_result($rs, "Cheque _ DD No_"). " Dated : ";
											if(odbc_result($rs, "Cheque _ DD Date") != '1753-01-01 00:00:00.000' ){
												echo date('d/M/Y', strtotime(odbc_result($rs, "Cheque _ DD Date")));
											} else{
											echo "";
											}
										}
									?>
									 </td>
								</tr>
								<tr>
									<td style="border:none;">Registration Form No</td>
									<td style="border:none;"><?php echo odbc_result($rs, "Registration No_");?></td>
									<td colspan="3" valign="top" style="border:none;"></td>
								</tr>
								<tr>
									<td height="40px" colspan="4" style="border:none;" ></td>
								</tr>
								<tr>
									<td valign="bottom" style="border:none;">Date : <?php echo date('d/M/Y', strtotime(odbc_result($rs, "Date of Sale")));?></td>
									<td colspan="2" style="border:none;"></td>
									<td valign="bottom" style="border:none;text-align: right;">Authorised Signatory</td>
								</tr>
							</table>														

						<!-- End of Content -->
						</div>
					</div>
				</div>
				<?php
					}
				?>
			</div>
		</div>
	</div>
</div>

<!-- jQuery -->
<script src="../vendors/jquery/dist/jquery.min.js"></script>
<script src="../vendors/jquery/dist/jquery-ui.js"></script>
<link href="../vendors/jquery/dist/jquery-ui.css" rel="stylesheet">
<!-- Bootstrap -->
<script src="../vendors/bootstrap/dist/js/bootstrap.min.js"></script>

<!-- Custom Theme Scripts -->
<script src="../build/js/custom.min.js"></script>
</body>
</html>