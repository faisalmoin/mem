

<?php
	require_once("header.php");
	
	$keyword = $_REQUEST['invoice'];
	
        $query = odbc_exec($conn, "SELECT [Customer No] FROM [Ledger Credit] WHERE [Invoice No]='$keyword' OR [Customer No]='$keyword' AND [Company Name]='$ms'") or die(odbc_errormsg($conn));
	$CustomerNo = odbc_result($query, "Customer No");
	
	
	$app = odbc_exec($conn, "SELECT [Name], [Addressee], [Class], [Academic Year] FROM [Temp Application] WHERE [Company Name]='$ms' AND ([System Genrated No_]= '".$CustomerNo."' OR [System Genrated No_]= '".$keyword."') ") or die(odbc_errormsg($conn));
	$stu = odbc_exec($conn, "SELECT [Name], [Addressee], [Class], [Academic Year] FROM [Temp Student] WHERE [Company Name]='$ms' AND ([No_]= '".odbc_result($app, "System Genrated No_")."' OR [System Genrated No_]= '".$keyword."') ") or die(odbc_errormsg($conn));
	
	if(odbc_num_rows($stu) == 1){
		//$stu1 = odbc_exec($conn, "SELECT [Name], [Addressee], [Class], [Academic Year] FROM [Temp Application] WHERE [Company Name]='$ms' AND [System Genrated No_]= '".odbc_result($query, "Customer No")."'") or die(odbc_errormsg($conn));
		$Name = odbc_result($stu, "Name");
		$Addressee = odbc_result($stu, "Addressee");
		$Class = odbc_result($stu, "Class");
		$Acad = odbc_result($stu, "Academic Year");
	}
	else{
		$Name = odbc_result($app, "Name");
		$Addressee = odbc_result($app, "Addressee");
		$Class = odbc_result($app, "Class");
		$Acad = odbc_result($app, "Academic Year");
	}
	//echo "Error";
	
	if($CustomerNo == ""){
		$CustomerNo = $keyword;
	}
         $Admission = odbc_exec($conn, "SELECT [No_] FROM [Temp Student] WHERE [Registration No_]='$CustomerNo' AND [Company Name]='$ms'") or die(odbc_errormsg($conn));
         $AdmissionNo = odbc_result($Admission, "No_");
         ?>

<!-- Body -->
<div class="right_col" role="main">
<div class="">
<div class="page-title">
<div class="title_left">
<h1>Fee Receipt - <?php echo $AdmissionNo?></h1> <!-- Page Name -->
</div>

<div class="clearfix"></div>

<div class="row">
<div class="col-md-12 col-sm-12 col-xs-12">
<div class="x_panel">
<div class="x_title">
<h2>Account Information</h2> <!-- Page Name -->
<div class="clearfix"></div>
</div>
<div class="x_content">
<!-- Content -->

	<table id="datatable" class="table table-responsive">
		<tr>
			<td style="border:none;">Student Name</td>
			<td style="border:none;">Ward of</td>
		</tr>
		<tr>
			<td style="border:none;"><span class="text-primary" style="font-weight: bold;"><?php echo strtoupper($Name)?></span></td>
			<td style="border:none;"><span class="text-primary" style="font-weight: bold;"><?php echo $Addressee?></span></td>
		</tr>
		<tr>
			<td style="border:none;">Academic Year</td>
			<td style="border:none;">Class</td>
		</tr>
		<tr>
			<td style="border:none;"><span class="text-primary" style="font-weight: bold;"><?php echo $Acad?></span></td>
			<td style="border:none;"><span class="text-primary" style="font-weight: bold;"><?php echo $Class?></span></td>
		</tr>
	</table>

</div>
</div>
</div>
</div>

<div class="row">
<div class="col-md-12 col-sm-12 col-xs-12">
<div class="x_panel">
<div class="x_title">
<h2>Account Summary</h2>
<ul class="nav navbar-right panel_toolbox">
<li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
</ul>
<div class="clearfix"></div>
</div>
<div class="x_content">

	<table id="datatable" class="table table-responsive">
		<tr>
					<td align="center" style="border: none;background-color: #A9A9F5; border-radius:5px; ">
					<?php
						$sql1 = "SELECT SUM([Credit Amount]) FROM [Ledger Credit] WHERE [Reverse] = 0 AND [Customer No] = '$CustomerNo' AND [Company Name]='".$ms."'";
						$Billed = odbc_exec($conn,$sql1);
					?>
					<h1><?php echo number_format(odbc_result($Billed, ""),2,'.',',')?></h1>
								<strong>Billed</strong>
					</td>
					<td align="center" style="border: none;"><h1> - </h1></td>
					<td align="center" style="border: none;background-color: #E1F5A9;border-radius:5px; ">
					<?php
						$sql2 = "SELECT SUM([Adv Fee]) FROM [Ledger Credit] WHERE [Reverse] = 0 AND [Customer No] = '$CustomerNo' AND [Company Name]='".$ms."'";
						$Adj = odbc_exec($conn,$sql2);
					?>
					<h1><?php echo number_format(odbc_result($Adj, ""), 2, '.',',') ?></h1>
								<strong> Adjustments </strong>
					</td>
					<td align="center" style="border: none;"><h1> - </h1></td>
					<td align="center" style="border: none;background-color: #9FF781;border-radius:5px; ">
					<?php
						$sql2 = "SELECT SUM([Debit Amount]+[Adv Fee]) FROM [Ledger Debit] WHERE [Reverse] = 0 AND [Customer No] = '$CustomerNo' AND [Company Name]='".$ms."'";
						$Payment = odbc_exec($conn,$sql2);
					?>
					<h1><?php echo number_format(odbc_result($Payment, ""),2,'.',',')?> </h1>
					<strong> Payment</strong>
					</td>
					<td align="center" style="border: none;"><h1> = </h1></td>
					<td align="center"  style="border: none;background-color: #F5A9A9;border-radius:5px; ">
					<h1><?php echo number_format((odbc_result($Billed, "")-odbc_result($Payment, "")),2,'.',',') ?></h1>
								<strong> Due </strong>
					</td>
				</table>

</div>
</div>
</div>
</div>

<div class="row">
<div class="col-md-12 col-sm-12 col-xs-12">
<div class="x_panel">
<div class="x_title">
<h2>Payment Status </h2>
<div class="clearfix"></div>
</div>
<div class="x_content">

			<div class="row">
				<div class="col-md-8 col-md-offset-2">
					<?php
						$sql3 = "SELECT SUM([Debit Amount]+[Adv Fee]) FROM [Ledger Debit] WHERE [Customer No] = '$CustomerNo' AND [Company Name]='".$ms."' AND [Payment Realization]=0 AND [Reverse] = 0";
						$pipeline = odbc_exec($conn,$sql3);
					?>
					<a href="Pipeline.php?cust=<?php echo $CustomerNo;?>">
					<div class="col-md-6 col-sm-12 col-xs-12">
						<div class="panel panel-primary text-center no-boder bg-color-green" style="background-color: #A9BCF5;">
							<div class="panel-right pull-center" style="background-color: #A9BCF5; color: #ffffff; font-weight: bolder; font-size: 24px;">
								<h1><?php echo number_format(odbc_result($pipeline, ""),2,'.',',')?></h1>
								<strong> In Pipeline</strong>
							</div>
						</div>
					</div>
					</a>
				   <!--?php 
				   if(number_format((odbc_result($Billed, ""))-(odbc_result($Payment, "")),2,'.',',')<0)
				   {
				   	?>
				   	<a>
				   	<div class="col-md-6 col-sm-12 col-xs-12">
						<div class="panel panel-primary text-center no-boder bg-color-blue"  style="background-color: #449d44;">
							<div class="panel-right pull-center" style="background-color: #449d44; color: #ffffff; font-weight: bolder; font-size: 24px;">
								
								<h1><?php echo number_format((odbc_result($Billed, "")-odbc_result($Payment, "")),2,'.',',') ?> </h1>
								<strong> Payment Received</strong>
							</div>
						</div>
					</div>
					</a>
				   	<--?php 
				   }
				   else {
				   ?-->
						<a href="FeeReceiptNew.php?cust=<?php echo $CustomerNo; ?>">
					<div class="col-md-6 col-sm-12 col-xs-12">
						<div class="panel panel-primary text-center no-boder bg-color-blue"  style="background-color: #449d44;">
							<div class="panel-right pull-center" style="background-color: #449d44; color: #ffffff; font-weight: bolder; font-size: 24px;">
								
								<h1><?php echo number_format((odbc_result($Billed, "")-odbc_result($Payment, "")),2,'.',',') ?> </h1>
								<strong> Payment Received</strong>
							</div>
						</div>
					</div>
					</a>
					<!--?php }?-->
					
				</div>
			</div>	
			
</div>
</div>
</div>
</div>
</div>
</div>
</div>
</div>

<!-- Page Classes -->
<!-- jQuery -->
<script src="../vendors/jquery/dist/jquery.min.js"></script>
<script src="../vendors/jquery/dist/jquery-ui.js"></script>
<link href="../vendors/jquery/dist/jquery-ui.css" rel="stylesheet">
<!-- Bootstrap -->
<script src="../vendors/bootstrap/dist/js/bootstrap.min.js"></script>

<!-- Custom Theme Scripts -->
<script src="../build/js/custom.min.js"></script>


<?php require_once("../footer.php"); ?>