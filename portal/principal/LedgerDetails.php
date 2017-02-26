<?php
	require_once("header.php");

	$keyword = $_REQUEST['CustomerNo'];
	$query = odbc_exec($conn, "SELECT [Customer No] FROM [Ledger Credit] WHERE [Invoice No]='$keyword' OR [Customer No]='$keyword' AND [Company Name]='$ms'") or die(odbc_errormsg($conn));
	$CustNo = odbc_result($query, "Customer No");
	
	date_default_timezone_set("Asia/Kolkata"); 
	
	// Get all dates ...
        $dbt_dates="";
	$dt="";
	$query1 = "SELECT [Invoice Date] FROM [Ledger Credit] WHERE [Company Name]='$ms' AND [Customer No]='$CustNo' AND [Reverse]=0" ;

	$dts1 = odbc_exec($conn, $query1) or die(odbc_errormsg($conn));
	while(odbc_fetch_array($dts1)){
		$dt .= odbc_result($dts1, "Invoice Date").", ";
	}
	$dt01 = substr($dt, 0, -2);

	$dts2 = odbc_exec($conn, "SELECT [Payment Date] FROM [Ledger Debit] WHERE  [Company Name]='$ms' AND [Reverse]=0 AND [Customer No]='$CustNo' AND [Payment Date] NOT IN ($dt01) ") or die(odbc_errormsg($conn));
	while(odbc_fetch_array($dts2)){
		$dt .= odbc_result($dts2, "Payment Date"). ", ";
	}
	$dt01 = substr($dt, 0, -2);
	//echo $dt01."<br /><br />";

	$date = explode(", ", $dt01);
	//Credit Amount
	$i=1;
        $bal = 0;
	
	$rs = odbc_exec($conn, "SELECT * FROM [Temp Application] WHERE [Company Name]='$ms' AND [System Genrated No_]='$CustNo' ") or die(odbc_errormsg($conn));
	
?>
<!-- link rel="stylesheet" type="text/css" href="../bs/pdf/semantic.min.css" -->	
<style>
@import 'https://fonts.googleapis.com/css?family=Lato:400,700,400italic,700italic&subset=latin';*,:after,:before{box-sizing:inherit}
html{box-sizing:border-box;font-family:sans-serif;-ms-text-size-adjust:100%;-webkit-text-size-adjust:100%;font-size:14px}
body{background:#ffffff;font-family:Lato,'Helvetica Neue',Arial,Helvetica,sans-serif;font-size:14px;line-height:1.33;color:rgba(0,0,0,.8);font-smoothing:antialiased}
</style>

<!-- Datatables -->
<link href="../vendors/datatables.net-bs/css/dataTables.bootstrap.min.css" rel="stylesheet">
<link href="../vendors/datatables.net-buttons-bs/css/buttons.bootstrap.min.css" rel="stylesheet">
<link href="../vendors/datatables.net-fixedheader-bs/css/fixedHeader.bootstrap.min.css" rel="stylesheet">
<link href="../vendors/datatables.net-responsive-bs/css/responsive.bootstrap.min.css" rel="stylesheet">
<link href="../vendors/datatables.net-scroller-bs/css/scroller.bootstrap.min.css" rel="stylesheet">

<!-- Body -->
<div class="right_col" role="main">
<div class="">
<div class="page-title">
<div class="title_left">
</div>

<div class="clearfix"></div>

<div class="row">
<div class="col-md-12 col-sm-12 col-xs-12">
<div class="x_panel">
<div class="x_title">
<h2>School List </h2> <!-- Page Name -->
<ul class="nav navbar-right panel_toolbox">
<li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
<li class="dropdown">
<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false"><i class="fa fa-wrench"></i></a>
<ul class="dropdown-menu" role="menu">
<li><a href="#">Settings 1</a></li>
<li><a href="#">Settings 2</a></li>
</ul>
</li>
</ul>
<div class="clearfix"></div>
</div>
<div class="x_content">
<!-- Content -->

 <div class="container ui form">
 <div id="editor"></div>
<button id="create_pdf" >generate PDF</button>
 <table class='table table-responsive'  id="basic-table">
     <?php $Admission = odbc_exec($conn, "SELECT * FROM [Temp Student] WHERE [Registration No_]='".$CustNo."' AND [Company Name]='$ms'") or die(odbc_errormsg($conn)); 
           $AdmissionNo = odbc_result($Admission, "No_");?>
	<tr>
		<td colspan="2" style="border:none;">
			<h3 class="text-primary">Information - <?php echo $AdmissionNo?></h3>
		</td>
	</tr>
	<tr>
		<td style="border:none;"><?php 
			if(odbc_result($Admission, "Gender") ==1 ) echo "Master <b>";
			if(odbc_result($Admission, "Gender") ==2 ) echo "Miss <b>";
			echo odbc_result($Admission, "Name") ."</b>"; 
		?></td>
		<td style="border:none;">
		<?php
			if(odbc_result($Admission, "Gender") ==1 ) echo "Son of  <b>";
			if(odbc_result($Admission, "Gender") ==2 ) echo "Daughter of <b>";
			echo  "Mr. ". odbc_result($Admission, "Father_s Name") . " &#38; Mrs. ". odbc_result($rs, "Mother_s Name")."</b>";
		?>
		</td>
	</tr>
	<tr>
		<td colspan="2" style="border:none;">
		<?php
			echo "Residing at <b>";
			echo odbc_result($Admission, "Address1")." ".odbc_result($Admission, "Address2")." ".odbc_result($Admission, "Address 3").", ".odbc_result($Admission, "City").", ".odbc_result($Admission, "State").", ".odbc_result($Admission, "Country")." - ".odbc_result($Admission, "Post Code") ;
			echo "</b>";
			if(odbc_result($Admission, "Mobile Number") != "") echo " <span class='glyphicon glyphicon-phone'> </span> ". odbc_result($Admission, "Mobile Number");
			if(odbc_result($Admission, "Phone Number") != "") echo " <span class='glyphicon glyphicon-phone-alt'> </span>  ". odbc_result($Admission, "Phone Number");
		?>
		</td>
	</tr>
	<tr>
		<td style="border:none;">
			Class : <b><?php echo odbc_result($Admission, "Class")?></b>
		</td>
		<td style="border:none;">
			Academic Year : <b><?php echo odbc_result($Admission, "Academic Year")?></b>
		</td>
	</tr>
 </table>
 
<?php 
	echo "<table id='datatable-responsive' class='table table-striped table-bordered dt-responsive nowrap' cellspacing='0' width='100%' >
		<tr>
		<td colspan='5' style='border:none;'>
			<h3 class='text-primary'>Ledger Details</h3>
		</td>
		</tr>
		<tr>
			<th>Date</th>
			<th>Description</th>
			<th style='text-align: right;'>Debit Amount</th>
			<th style='text-align: right;'>Credit Amount</th>
			<th style='text-align: right;'>Balance</th>
		</tr>";
	$crd = odbc_exec($conn, "SELECT * FROM [Ledger Credit] WHERE [Company Name]='$ms' AND [Customer No]='$CustNo' AND [Reverse]=0 ORDER BY [Invoice Date] ASC ") or die(odbc_errormsg($conn));
	while(odbc_fetch_array($crd)){
		echo "<tr>";
		echo "<td>".date('d/M/Y', odbc_result($crd, "Invoice Date"))."</td>";
		//check for invoice
			$crd_inv = odbc_exec($conn,  "SELECT [Invoice No] FROM [Ledger Credit] 
									WHERE [Description]='".odbc_result($crd, "Description")."'
                                                                        AND [Reverse]=0
									AND [Company Name]='$ms' AND [Customer No]='$CustNo' 
									AND [Invoice Date] = '".odbc_result($crd, "Invoice Date")."' ") or die(odbc_errormsg($conn));
		
                $sys_no = odbc_exec($conn, "SELECT [Enquiry No_] FROM [Temp Application] WHERE [System Genrated No_]='".$CustNo."' AND [Company Name]='$ms' ") or die(odbc_errormsg($conn));
	        $cust_no = odbc_result($sys_no, "Enquiry No_");       
                
                if(odbc_result($crd, "Description")=='Sale of Registration'){
                echo "<td><a href='ReceiptRegistration.php?id=$cust_no&ms=$ms&LoginID=$LoginID&loop=0' target='_BLANK'>".odbc_result($crd, "Description")."</a></td>";
                }else{
                echo "<td><a href='ReceiptAdmission.php?id=$CustNo&ms=$ms&inv=".odbc_result($crd_inv, "Invoice No")."&loop=0' target='_BLANK'>".odbc_result($crd, "Description")."</a></td>";
                }
                echo "<td style='text-align: right;'>".number_format(odbc_result($crd, "Credit Amount"),2,'.','')."</td>";
		echo "<td></td>";
		echo "<td style='text-align: right;'>";
                //Balance
                    $bal = $bal+number_format(odbc_result($crd, "Credit Amount"),2,'.','');
                    echo number_format($bal,2,'.','');
                echo "</td>";
		echo "</tr>";

		//Debit Amount
		$dbt = odbc_exec($conn, "SELECT [Payment Date], ([Debit Amount]+[Adv Fee]) AS [Debit Amount], [Description] FROM [Ledger Debit] WHERE [Company Name]='$ms' AND [Reverse]=0 AND [Customer No]='$CustNo'  AND [Payment Date] >= '".odbc_result($crd, "Invoice Date")."' AND [Payment Date] <'".$date[$i]."' ORDER BY [Payment Date] ASC ") or die(odbc_errormsg($conn));
		//echo "SELECT [Payment Date], ([Debit Amount]+[Adv Fee]) AS [Debit Amount], [Description] FROM [Ledger Debit] WHERE [Company Name]='$ms' AND [Customer No]='$CustNo'  AND [Payment Date] >= '".odbc_result($crd, "Invoice Date")."' AND [Payment Date] <'".$date[$i]."' ORDER BY [Payment Date] ASC ";
                while(odbc_fetch_array($dbt)){
		echo "<tr>";
		echo "<td>".date('d/M/Y', odbc_result($dbt, "Payment Date"))."</td>";
		echo "<td>".odbc_result($dbt, "Description")."</td>";		
		echo "<td></td>";
		echo "<td style='text-align: right;'>".number_format(odbc_result($dbt, "Debit Amount"),2,'.','')."</td>";		
		echo "<td style='text-align: right;'>";
                    $bal = $bal - odbc_result($dbt, "Debit Amount");
                    echo number_format($bal,2,'.','');
                echo "</td>";
		echo "</tr>";
                
                //Capturing Dates
                $dbt_dates .= "'".odbc_result($dbt, "Payment Date")."', ";
                
	
		}
                
                $dbt_dates .= "'".odbc_result($crd, "Invoice Date")."', ";
		$i++;
	    }
            //Getting Debit Amount for remaining dates
            
            $dbt_dates = substr($dbt_dates, 0, -2);
            
            $r_dt = odbc_exec($conn, "SELECT [Payment Date], ([Debit Amount]+[Adv Fee]) AS [Debit Amount], [Description] FROM [Ledger Debit] WHERE [Company Name]='$ms' AND [Reverse]=0 AND [Customer No]='$CustNo'  AND [Payment Date] NOT IN (".$dbt_dates.") ORDER BY [Payment Date] ASC ") or die(odbc_errormsg($conn));
            while(odbc_fetch_array($r_dt)){
            	echo "<tr>";
		echo "<td>".date('d/M/Y', odbc_result($r_dt, "Payment Date"))."</td>";
		echo "<td>".odbc_result($r_dt, "Description")."</td>";		
		echo "<td></td>";
                echo "<td style='text-align: right;'>".number_format(odbc_result($r_dt, "Debit Amount"),2,'.','')."</td>";
		echo "<td style='text-align: right;'>";
		    $bal = $bal - odbc_result($r_dt, "Debit Amount");
                    echo number_format($bal,2,'.','');
                echo "</td>";
		echo "</tr>";                
                
            }
            
            
	    //Calculate Total
		echo "<tr style='font-weight: bold;'>";
		echo "<td colspan='2'>TOTAL</td>";
		
		$tot_amt_debit = odbc_exec($conn, "SELECT SUM([Debit Amount]+ [Adv Fee]) FROM [Ledger Debit] WHERE [Company Name]='$ms' AND [Reverse]=0 AND [Customer No]='$CustNo' ") or die(odbc_errormsg($conn));
		$tot_amt_Credit = odbc_exec($conn, "SELECT SUM([Credit Amount]) FROM [Ledger Credit] WHERE [Company Name]='$ms' AND [Customer No]='$CustNo' AND [Reverse]=0") or die(odbc_errormsg($conn));
		echo "<td style='text-align: right;'>".number_format(odbc_result($tot_amt_Credit, ""),2,'.','')."</td>";
		echo "<td style='text-align: right;'>".number_format(odbc_result($tot_amt_debit, ""),2,'.','')."</td>";
		echo "<td style='text-align: right; font-size: 18px; color: #880000;'>";
		echo number_format(odbc_result($tot_amt_Credit, "") - odbc_result($tot_amt_debit, ""),2,'.','');
		echo"</td>";
		echo"</tr>";
		
		echo "</table>";
		?>
</div>

<!-- /Content -->
</div>
</div>
</div>
</div>
</div>
</div>
</div>
<!-- /Body -->

<script src="../bs/pdf/jquery.min.js"></script>
<script type="text/javascript" src="../bs/pdf/jspdf.min.js"></script>
<script type="text/javascript" src="../bs/pdf/html2canvas.min.js"></script>
<script type="text/javascript" src="../bs/pdf/app.js"></script>


<!-- Page Classes -->
<!-- jQuery -->
<script src="../vendors/jquery/dist/jquery.min.js"></script>
<script src="../vendors/jquery/dist/jquery-ui.js"></script>
<link href="../vendors/jquery/dist/jquery-ui.css" rel="stylesheet">
<!-- Bootstrap -->
<script src="../vendors/bootstrap/dist/js/bootstrap.min.js"></script>

<!-- Custom Theme Scripts -->
<script src="../build/js/custom.min.js"></script>

<!-- Datatables -->
<script src="../vendors/datatables.net/js/jquery.dataTables.min.js"></script>
<script src="../vendors/datatables.net-bs/js/dataTables.bootstrap.min.js"></script>
<script src="../vendors/datatables.net-buttons/js/dataTables.buttons.min.js"></script>
<script src="../vendors/datatables.net-buttons-bs/js/buttons.bootstrap.min.js"></script>
<script src="../vendors/datatables.net-buttons/js/buttons.flash.min.js"></script>
<script src="../vendors/datatables.net-buttons/js/buttons.html5.min.js"></script>
<script src="../vendors/datatables.net-buttons/js/buttons.print.min.js"></script>
<script src="../vendors/datatables.net-fixedheader/js/dataTables.fixedHeader.min.js"></script>
<script src="../vendors/datatables.net-keytable/js/dataTables.keyTable.min.js"></script>
<script src="../vendors/datatables.net-responsive/js/dataTables.responsive.min.js"></script>
<script src="../vendors/datatables.net-responsive-bs/js/responsive.bootstrap.js"></script>
<script src="../vendors/datatables.net-scroller/js/datatables.scroller.min.js"></script>
<script src="../vendors/jszip/dist/jszip.min.js"></script>
<script src="../vendors/pdfmake/build/pdfmake.min.js"></script>
<script src="../vendors/pdfmake/build/vfs_fonts.js"></script>


<!-- Datatables -->
<script>
$(document).ready(function() {
$('#datatable').dataTable();
$('#datatable-responsive').DataTable({
fixedHeader: true
});
});
</script>
<!-- /Datatables -->

 
<?php require_once("../footer.php"); ?>
