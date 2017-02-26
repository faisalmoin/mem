<?php
	require_once("header.php");

	$keyword = $_REQUEST['CustomerNo'];
	$query = odbc_exec($conn, "SELECT [Customer No] FROM [Ledger Credit] WHERE [Invoice No]='$keyword' OR [Customer No]='$keyword' AND [Company Name]='$ms'") or die(odbc_errormsg($conn));
	$CustNo = odbc_result($query, "Customer No");
	
?>
<?php
	date_default_timezone_set("Asia/Kolkata"); 
	
	// Get all dates ...
        $dbt_dates="";
	$dt="";
	$query1 = "SELECT [Invoice Date] FROM [Ledger Credit] WHERE [Company Name]='$ms' AND [Customer No]='$CustNo'";

	$dts1 = odbc_exec($conn, $query1) or die(odbc_errormsg($conn));
	while(odbc_fetch_array($dts1)){
		$dt .= odbc_result($dts1, "Invoice Date").", ";
	}
	$dt01 = substr($dt, 0, -2);

	$dts2 = odbc_exec($conn, "SELECT [Payment Date] FROM [Ledger Debit] WHERE [Company Name]='$ms' AND [Customer No]='$CustNo' AND [Payment Date] NOT IN ($dt01) ") or die(odbc_errormsg($conn));
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

 <div class="container ui form">
 <div id="editor"></div>
<button id="create_pdf" >generate PDF</button>
 <table class='table table-responsive'  id="basic-table">
	<tr>
		<td colspan="2" style="border:none;">
			<h3 class="text-primary">Information - <?php echo $CustNo?></h3>
		</td>
	</tr>
	<tr>
		<td style="border:none;"><?php 
			if(odbc_result($rs, "Gender") ==1 ) echo "Master <b>";
			if(odbc_result($rs, "Gender") ==2 ) echo "Miss <b>";
			echo odbc_result($rs, "Name") ."</b>"; 
		?></td>
		<td style="border:none;">
		<?php
			if(odbc_result($rs, "Gender") ==1 ) echo "Son of  <b>";
			if(odbc_result($rs, "Gender") ==2 ) echo "Daughter of <b>";
			echo  "Mr. ". odbc_result($rs, "Father_s Name") . " &#38; Mrs. ". odbc_result($rs, "Mother_s Name")."</b>";
		?>
		</td>
	</tr>
	<tr>
		<td colspan="2" style="border:none;">
		<?php
			echo "Residing at <b>";
			echo odbc_result($rs, "Address1")." ".odbc_result($rs, "Address2")." ".odbc_result($rs, "Address 3").", ".odbc_result($rs, "City").", ".odbc_result($rs, "State").", ".odbc_result($rs, "Country")." - ".odbc_result($rs, "Post Code") ;
			echo "</b>";
			if(odbc_result($rs, "Mobile Number") != "") echo " <span class='glyphicon glyphicon-phone'> </span> ". odbc_result($rs, "Mobile Number");
			if(odbc_result($rs, "Phone Number") != "") echo " <span class='glyphicon glyphicon-phone-alt'> </span>  ". odbc_result($rs, "Phone Number");
		?>
		</td>
	</tr>
	<tr>
		<td style="border:none;">
			Class : <b><?php echo odbc_result($rs, "Class")?></b>
		</td>
		<td style="border:none;">
			Academic Year : <b><?php echo odbc_result($rs, "Academic Year")?></b>
		</td>
	</tr>
 </table>
 
<?php 
	echo "<table class='table table-responsive table-striped'>
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
	$crd = odbc_exec($conn, "SELECT * FROM [Ledger Credit] WHERE [Company Name]='$ms' AND [Customer No]='$CustNo' ORDER BY [Invoice Date] ASC ") or die(odbc_errormsg($conn));
	while(odbc_fetch_array($crd)){
		echo "<tr>";
		echo "<td>".date('d/M/Y', odbc_result($crd, "Invoice Date"))."</td>";
		echo "<td>".odbc_result($crd, "Description")."</td>";
                echo "<td style='text-align: right;'>".number_format(odbc_result($crd, "Credit Amount"),2,'.','')."</td>";
		echo "<td></td>";
		echo "<td style='text-align: right;'>";
                //Balance
                    $bal = $bal+number_format(odbc_result($crd, "Credit Amount"),2,'.','');
                    echo number_format($bal,2,'.','');
                echo "</td>";
		echo "</tr>";

		//Debit Amount
		$dbt = odbc_exec($conn, "SELECT [Payment Date], ([Debit Amount]+[Adv Fee]) AS [Debit Amount], [Description] FROM [Ledger Debit] WHERE [Company Name]='$ms' AND [Customer No]='$CustNo'  AND [Payment Date] >= '".odbc_result($crd, "Invoice Date")."' AND [Payment Date] <'".$date[$i]."' ORDER BY [Payment Date] ASC ") or die(odbc_errormsg($conn));
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
            
            $r_dt = odbc_exec($conn, "SELECT [Payment Date], ([Debit Amount]+[Adv Fee]) AS [Debit Amount], [Description] FROM [Ledger Debit] WHERE [Company Name]='$ms' AND [Customer No]='$CustNo'  AND [Payment Date] NOT IN (".$dbt_dates.") ORDER BY [Payment Date] ASC ") or die(odbc_errormsg($conn));
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
		
		$tot_amt_debit = odbc_exec($conn, "SELECT SUM([Debit Amount]+ [Adv Fee]) FROM [Ledger Debit] WHERE [Company Name]='$ms' AND [Customer No]='$CustNo' ") or die(odbc_errormsg($conn));
		$tot_amt_Credit = odbc_exec($conn, "SELECT SUM([Credit Amount]) FROM [Ledger Credit] WHERE [Company Name]='$ms' AND [Customer No]='$CustNo'") or die(odbc_errormsg($conn));
		echo "<td style='text-align: right;'>".number_format(odbc_result($tot_amt_Credit, ""),2,'.','')."</td>";
		echo "<td style='text-align: right;'>".number_format(odbc_result($tot_amt_debit, ""),2,'.','')."</td>";
		echo "<td style='text-align: right; font-size: 18px; color: #880000;'>";
		echo number_format(odbc_result($tot_amt_Credit, "") - odbc_result($tot_amt_debit, ""),2,'.','');
		echo"</td>";
		echo"</tr>";
		
		echo "</table>";
		?>
</div>
<script src="../bs/pdf/jquery.min.js"></script>
<script type="text/javascript" src="../bs/pdf/jspdf.min.js"></script>
<script type="text/javascript" src="../bs/pdf/html2canvas.min.js"></script>
<script type="text/javascript" src="../bs/pdf/app.js"></script>
	
<?php require_once("../footer.php"); ?>
