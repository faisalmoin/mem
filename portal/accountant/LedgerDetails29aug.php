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
 
    <table class='table table-responsive table-striped' width="100%" id="abc">
    <thead>
            <tr class="statetablerow">
                        <th>SN</th>
                        <th>Date</th>
			<th>Description</th>
			<th style='text-align: right;'>Debit Amount</th>
			<th style='text-align: right;'>Credit Amount</th>
			<th style='text-align: right;'>Balance</th>
            </tr>
          
    </thead>
    <tbody>
    <?php
            $c = 1;
            $Cr = 0;
            $Dr = 0;
            $Bal = 0;
            //Get dates
            $sys_no = odbc_exec($conn, "SELECT [Enquiry No_] FROM [Temp Application] WHERE [System Genrated No_]='".$CustNo."' AND [Company Name]='$ms' ") or die(odbc_errormsg($conn));
	    $cust_no = odbc_result($sys_no, "Enquiry No_");   
            $end_date = time();	
           // $start_date = odbc_result($Agreement, "From Date").', ';
           $get_dates1 = odbc_exec($conn, "SELECT [Invoice No], [Invoice Date],[Credit Amount],[Description] FROM [Ledger Credit] WHERE [Company Name]='$ms' AND [Customer No]='$CustNo' ") or die(odbc_errormsg($conn));
         
            while(odbc_fetch_array($get_dates1)){
                    $start_date .= odbc_result($get_dates1, "Invoice Date").", ";
            }
            $crdate=  substr($start_date, 0,-2); 
            $get_dates2 = odbc_exec($conn, "SELECT [Payment Date],([Debit Amount]+[Adv Fee]) AS [Debit Amount], [Description] FROM [Ledger Debit] WHERE [Company Name]='$ms' AND [Customer No]='$CustNo' AND [Payment Date] NOT IN ($crdate) ") or die(odbc_errormsg($conn));
            while(odbc_fetch_array($get_dates2)){
                    $start_date .= odbc_result($get_dates2, "Payment Date").", ";
            }

            $gDate = explode(", ", $start_date);
           // echo $start_date;
            sort($gDate);
            
            for($i=0; $i< count($gDate); $i++){

                    if(substr($gDate[$i],1,-1) != ""){								
                            //Check invoice
                        
                            $credit = odbc_exec($conn, "SELECT [Invoice No],[Invoice Date],[Credit Amount],[Description] FROM [Ledger Credit] 
									WHERE [Company Name]='$ms' AND [Customer No]='$CustNo' 
									AND [Invoice Date] = '".$gDate[$i]."' ") or die(odbc_errormsg($conn)); 
                            
                        // echo "SELECT * FROM [Ledger Credit] WHERE [Company Name]='$ms' AND [Customer No]='$CustNo' AND [Invoice Date] = '".$gDate[$i]."' <br />";
                         
                            $debit = odbc_exec($conn, "SELECT [Payment Date], ([Debit Amount]+[Adv Fee]) AS [Debit Amount], [Description] FROM [Ledger Debit] WHERE [Company Name]='$ms' AND [Customer No]='$CustNo'  AND [Payment Date] = '".$gDate[$i]."' ") or die(odbc_errormsg($conn));
                         
                          
                          
                      // echo "SELECT [Payment Date], ([Debit Amount]+[Adv Fee]) AS [Debit Amount], [Description] FROM [Ledger Debit] WHERE [Company Name]='$ms' AND [Customer No]='$CustNo'  AND [Payment Date] = '".$gDate[$i]."'  <br />";
                          
                            if(odbc_num_rows($credit) != 0 || odbc_num_rows($debit) != 0 ){								

    ?>
    <tr>
            <td style="text-align: center;"><?php echo $c; ?></td>
            <td><?php echo date("d/M/Y H:i:s", $gDate[$i]); ?></td>
            <td>
            <?php 
                   
                    if(odbc_num_rows($credit) != 0) if(odbc_result($credit, "Description")=='Sale of Registration'){echo "<a href='ReceiptRegistration.php?id=$cust_no&ms=$ms&LoginID=$LoginID&loop=0' target='_BLANK'>".odbc_result($credit, "Description")."</a>";}  else {
                    echo "<a href='ReceiptAdmission.php?id=$CustNo&ms=$ms&inv=".odbc_result($credit, "Invoice No")."&loop=0' target='_BLANK'>".odbc_result($credit, "Description")."</a>"; }
                   else if(odbc_num_rows($debit) != 0) echo "Ledger Debit. - ".odbc_result($debit, "Description");
            ?>
            </td>
            <td style="text-align: right;"><?php echo number_format(odbc_result($credit, "Credit Amount"), 2,'.',','); $Cr += odbc_result($credit, "Credit Amount"); ?></td>
            <td style="text-align: right;"><?php echo number_format(odbc_result($debit, "Debit Amount"), 2,'.',','); $Dr += odbc_result($debit, "Debit Amount"); ?></td>
            <td style="text-align: right;">
            <?php 
                    $Bal = $Bal + (odbc_result($credit, "Credit Amount")-odbc_result($debit, "Debit Amount"));
                    echo number_format($Bal, 2, '.', ',');
            ?>
            </td>
    </tr>
    <?php 
                            }
                            $c++;								
                    }							
            }										
    ?>
    <tr style="font-weight: bold;">
            <td colspan="3">TOTAL</td>
            <td style="text-align: right;"><?php echo number_format($Cr, 2, '.', ','); ?></td>
            <td style="text-align: right;"><?php echo number_format($Dr, 2, '.', ','); ?></td>
            <td style="text-align: right;"><?php echo number_format($Bal, 2, '.', ','); ?></td>
    </tr>
    </tbody>
</table>
</div>

<script src="../bs/pdf/jquery.min.js"></script>
<script type="text/javascript" src="../bs/pdf/jspdf.min.js"></script>
<script type="text/javascript" src="../bs/pdf/html2canvas.min.js"></script>
<script type="text/javascript" src="../bs/pdf/app.js"></script>
	
<?php require_once("../footer.php"); ?>
