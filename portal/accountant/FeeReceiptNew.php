<?php
	require_once("header.php");
	$inv_dt = time();
	
	//Quarter calculation
	$qDate = odbc_exec($conn, "SELECT [Start Date], [End Date] FROM [Academic Year] WHERE [Code]='$AcadYear' AND [Company Name]='$ms'");
	$q1Sdt = strtotime(odbc_result($qDate, "Start Date"));
	$q1Edt = strtotime("+3 months -1 day", strtotime(odbc_result($qDate, "Start Date")));
	$q2Sdt = strtotime("+3 months", strtotime(odbc_result($qDate, "Start Date")));
	$q2Edt = strtotime("+6 months -1 day", strtotime(odbc_result($qDate, "Start Date")));
	$q3Sdt = strtotime("+6 months", strtotime(odbc_result($qDate, "Start Date")));
	$q3Edt = strtotime("+9 months -1 day", strtotime(odbc_result($qDate, "Start Date")));
	$q4Sdt = strtotime("+9 months", strtotime(odbc_result($qDate, "Start Date")));
	$q4Edt = strtotime(odbc_result($qDate, "Start Date"));
	//echo $q1Edt;
	//Get Quarter as per current date
	
	$today = $inv_dt;
		$this_yr = strtotime(date("Y", $today)."-04-01");
	$nxt_yr = strtotime((date("Y", $today)+1)."-03-31");
	
	if($today > strtotime(date("Y", $today)."-04-01") && $today < strtotime((date("Y", $today)+1)."-03-31")){
		$FinYr = date('y', $today)."-".(date('y', $today)+1);
	} else if ($today < strtotime(date("Y", $today)."-04-01")  && $today < strtotime((date("Y", $today))."-03-31")) {
        $FinYr = (date('y', $today)-1)."-".date('y', $today);
    }
	
	//Q1 Calculation
	if($today > strtotime(date("Y", $today)."-04-01") && $today < strtotime((date("Y", $today))."-06-30")){
		$Qtr = "Q1";
	}
	//Q2 Calculation
	if($today > strtotime(date("Y", $today)."-07-01") && $today < strtotime((date("Y", $today))."-09-30")){
		$Qtr = "Q2";
	}
	//Q3 Calculation
	if($today > strtotime(date("Y", $today)."-10-01") && $today < strtotime((date("Y", $today))."-12-31")){
		$Qtr = "Q3";
	}
	//Q1 Calculation
	if($today > strtotime(date("Y", $today)."-01-01") && $today < strtotime((date("Y", $today))."-03-31")){
		$Qtr = "Q4";
	}
	
	
	//echo "Fin Yr - ".$FinYr. " // Qtr: ". $Qtr ." // Year: ". date("Y", $today)." // Month: ". date("m", $today);
	
	$CustomerNo = $_REQUEST['cust'];
	$stu = odbc_exec($conn, "SELECT [Name], [Addressee], [Class], [Academic Year] FROM [Temp Student] WHERE [Company Name]='$ms' AND [System Genrated No_]= '$CustomerNo'") or die(odbc_errormsg($conn));
	if(odbc_num_rows($stu) == 0){
		$stu1 = odbc_exec($conn, "SELECT [Name], [Addressee], [Class], [Academic Year] FROM [Temp Application] WHERE [Company Name]='$ms' AND [System Genrated No_]= '$CustomerNo'") or die(odbc_errormsg($conn));
		$Name = odbc_result($stu1, "Name");
		$Addressee = odbc_result($stu1, "Addressee");
		$Class = odbc_result($stu1, "Class");
		$Acad = odbc_result($stu1, "Academic Year");
	}
	else{
		$Name = odbc_result($stu, "Name");
		$Addressee = odbc_result($stu, "Addressee");
		$Class = odbc_result($stu, "Class");
		$Acad = odbc_result($stu, "Academic Year");
	}
	//echo "Error";

	$Admission = odbc_exec($conn, "SELECT [No_] FROM [Temp Student] WHERE [Registration No_]='$CustomerNo' AND [Company Name]='$ms'") or die(odbc_errormsg($conn));
	$AdmissionNo = odbc_result($Admission, "No_");
?>
	
  
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
<h2>Student No - <?php echo $AdmissionNo?> </h2> <!-- Page Name -->
<ul class="nav navbar-right panel_toolbox">
<li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
</ul>
<div class="clearfix"></div>
</div>
<div class="x_content">
<!-- Content -->

      
   
				<table class="table table-responsive" style="border: 1px solid #e2e2e2">
					<tr>
						<td colspan="2" style="border: none;"><h2>Account Information</h2></td>
					<tr>
					<tr>
						<td style="border: none; ">Student Name</td>
                                                <td style="border: none; "><span class="text-danger" style="font-weight: bold;"><?php echo strtoupper($Name)?></span></td>
						<td style="border: none; ">Ward of</td>
                                                <td style="border: none; "><span class="text-primary" style="font-weight: bold;"><?php echo $Addressee?></span></td>
					</tr>
					<!--tr>
						<td style="border: none; "><span class="text-danger" style="font-weight: bold;"><?php echo strtoupper($Name)?></span></td>
						<td style="border: none; "><span class="text-primary" style="font-weight: bold;"><?php echo $Addressee?></span></td>
					</tr-->
					<tr>
						<td style="border: none; ">Academic Year</td>
                                                <td style="border: none; "><span class="text-primary" style="font-weight: bold;"><?php echo $Acad?></span></td>
						<td style="border: none; ">Class</td>
                                                <td style="border: none; "><span class="text-primary" style="font-weight: bold;"><?php echo $Class?></span></td>
					</tr>
					<!--tr>
						<td style="border: none; "><span class="text-primary" style="font-weight: bold;"><?php echo $Acad?></span></td>
						<td style="border: none; "><span class="text-primary" style="font-weight: bold;"><?php echo $Class?></span></td>
					</tr-->
				</table>
                
                <form action="FeeReceiptAdd.php" method="post" name="form" onsubmit="return CheckThis(this)">
                        <?php
                            $invNo = "";
                                $CreditInvNo = odbc_exec($conn, "SELECT * FROM [ledger Credit] WHERE [Company Name]='$ms' AND [Customer No]='$CustomerNo' AND [Reverse]=0 " ) or die(odbc_errormsg(odbc_errormsg()));
                                if(odbc_num_rows($CreditInvNo) != 0){
                        ?>
                        <table class="table table-responsive" style="border: 1px solid #e2e2e2">
                                <?php
                                        while(odbc_fetch_array($CreditInvNo)){
                                            $a = odbc_result($CreditInvNo, "Credit Amount");
                                            $DebitInvNo = odbc_exec($conn, "SELECT * FROM [Ledger Debit] WHERE [Company Name]='$ms' AND [Reverse]=0 AND [Customer No]='$CustomerNo' AND [Invoice No]='".odbc_result($CreditInvNo, "Invoice No")."' ") or die(odbc_errormsg("133"));
                                            $b=odbc_result($DebitInvNo, "Debit Amount")+odbc_result($DebitInvNo, "Adv Fee");


                                            if($a >= $b || odbc_num_rows($DebitInvNo)==0)
                                            {
                                                    $invNo .= "'".odbc_result($CreditInvNo, "Invoice No")."', ";
                                            }
                                         }

                                        $invNo = substr($invNo, 0, -2);
                                        $f=1;
                                        $nTot = 0;
                                        //if($invNo == 0 || $invNo == "" ){							
                                        //	echo '<tr><td colspan="3"><div class="alert alert-warning">No dues ... </div></td></tr>';
                                        //}
                                        //else{
                                ?>
                                <tr style="background-color: #ffffe3;">
                                        <th style="border: none;">Fee Description</th>
                                        <th style="border: none;">Generated Amount</th>
                                        <th style="border: none;">Fee O/S</th>
                                        <th style="border: none;">Payment recieved</th>
                                </tr>					
                                <?php
                                        $sql1 = "SELECT * FROM [ledger invoice] WHERE [Company Name]='$ms' AND [Reverse]=0 AND [Customer No]='$CustomerNo' AND "; 
                                       // if (!empty($invNo)){
                                        $sql1 .= " [Invoice No] IN ($invNo) AND ";
                                       // }
                                        $sql1 .= " [Fee Description] LIKE 'Net %' AND [Fee Description] LIKE '% payable' ";
                                        $rs = odbc_exec($conn, $sql1) or die(odbc_errormsg($conn));
                                        $paymentTotal = odbc_exec($conn, "SELECT SUM([Amount Paid]) FROM [Ledger Payment] WHERE [Company Name]='$ms' AND [Reverse]=0 AND [Customer No]='$CustomerNo' AND [Qtr]= '$Qtr' ") or die(odbc_errormsg($conn));
                                       // echo odbc_result($paymentTotal, "");
                                       // echo "SELECT SUM([Amount Paid]) FROM [Ledger Payment] WHERE [Company Name]='$ms' AND [Reverse]=0 AND [Customer No]='$CustomerNo' AND [Qtr]= '$Qtr' ";
                                        /* 
                                        $sql23 = "SELECT * FROM [ledger Payment] WHERE [Company Name]='$ms' AND [Reverse]=0 AND [Customer No]='$CustomerNo' AND "; 
                                       // if (!empty($invNo)){
                                        $sql23 .= " [Invoice No] IN ($invNo) AND ";
                                       // }
                                        $sql23 .= " [Fee Description] LIKE 'Net %' AND [Fee Description] LIKE '% payable' ";
                                       // echo $sql1;
                                        $rs23 = odbc_exec($conn, $sql23) or die(odbc_errormsg($conn));
                                        echo odbc_result($rs23, "Amount Paid");*/
                                        //echo "SELECT * FROM [ledger invoice] WHERE [Company Name]='$ms' AND [Customer No]='$CustomerNo' AND [Invoice No] IN (".$invNo.") AND [Fee Description] LIKE 'Net %' AND [Fee Description] LIKE '% payable' ";
                                        //echo "</br></br>";
                                        while(odbc_fetch_array($rs)){
                                        $qry1 = odbc_exec($conn, "SELECT SUM([Amount Paid]) FROM [Ledger Payment] WHERE [Company Name]='$ms' AND [Reverse]=0 AND [Customer No]='$CustomerNo'  AND  [Fee Description] = '".odbc_result($rs, "Fee Description")."' AND [Invoice No] = '".odbc_result($rs, "Invoice No")."' AND [Qtr]= '$Qtr' ") or die(odbc_errormsg($conn));
                                        $diff = odbc_result($rs, "Net Amount") - odbc_result($qry1, "");
                                        $nTot += odbc_result($rs, "Net Amount");
                                    ?>		
                                    <tr>
                                        <td style="border: none; "><?php echo odbc_result($rs, "Fee Description"); ?></td>
                                        
                                        <td style="border: none; "><input value="<?php echo number_format(odbc_result($rs, "Net Amount"),2,".", "");?>" 
                                        type="text" name="genrated<?php echo $f; ?>" 
                                        class="form-control" style="padding:4px; border: 1px solid #C0C0C0;width: 170px; text-align: right;"  
                                        required readonly></td>
                                        
                                        <td style="border: none; "><input value="<?php echo number_format(odbc_result($rs, "Net Amount")-odbc_result($qry1, ""),2,".", "");?>" 
                                        type="text" name="net_amt<?php echo $f; ?>" 
                                        class="form-control" style="padding:4px; border: 1px solid #C0C0C0;width: 170px; text-align: right;"  
                                        required readonly></td>


                                        <?php if($diff >= 0){ ?>
                                        <td style="border: none;"><input value="<?php echo number_format($diff,2,".", ""); ?>" type="text"  
                                        name="amt_paid<?php echo $f;?>" 
                                        class="amt_paid" id="amt_paid<?php echo $f;?>" 
                                        style="padding:4px; background-color: #FFFF00; border: 1px solid #C0C0C0;width: 170px; text-align: right;"  
                                        onkeypress='return chkNumeric(event)'
                                        onchange="InputSum()"
                                        onblur="myFunction()"

                                        ></td>
                                        <?php }else {?>
                                        <td style="border: none;"><input value="<?php echo 0; ?>" type="text"  
                                        name="amt_paid<?php echo $f;?>" 
                                        class="amt_paid" id="amt_paid<?php echo $f;?>" 
                                        style="padding:4px; background-color: #FFFF00; border: 1px solid #C0C0C0;width: 170px; text-align: right;"  
                                        onkeypress='return chkNumeric(event)'
                                        onchange="InputSum()"
                                        onblur="myFunction()"

                                        ></td>
                                        <?php }?>
                                        <input value="<?php echo odbc_result($rs, "Fee Description"); ?>" type="hidden"  name="Fee_description<?php echo $f?>">					    
                                    </tr>
                                    <?php
                                        $f++;
                                        }	

                                //} // End of Invoice Check
                                        ?>	
                        <tr>
                                <td style="border: none; ">Total</td>
                                 <td style="border: none; "><input type="text" value="<?php echo number_format($nTot,2,".", "");?>" name="" class="form-control" style="padding:4px; border: 1px solid #C0C0C0;width: 170px; text-align: right; font-weight:bold; color: navy;" readonly></td>
                                <td style="border: none; "><input type="text" id="total1" value="<?php echo number_format($nTot,2,".", "")-number_format(odbc_result($paymentTotal, ""),2,".", "");?>" name="" class="form-control" style="padding:4px; border: 1px solid #C0C0C0;width: 170px; text-align: right; font-weight:bold; color: navy;" readonly></td>
                                <td style="border: none; "><input type="text" 
                                    id="total2" name="total2" class="total2 form-control" 
                                    style="padding:4px; border: 1px solid #C0C0C0;width: 170px; text-align: right; font-weight:bold; color: navy;" readonly></td>
                        </tr>
                        <tr>
                                <!--td style="border: none; " colspan="2">Amount Received</td>
                                <td style="border: none; "><input type="text" name="Amount" id="Amount" 
                                        class="form-control" style="padding:4px; background-color: #FFFF00; border: 1px solid #C0C0C0;width: 170px; text-align: right;"  
                                        onkeypress='return validateQty(event)'
                                        required></td-->
                        </tr>
                        <tr>
                                <td style="border: none; " colspan="3">Payment Date</td>
                                <td style="border: none; "><input type="text" name="PaymentDt" id="PaymentDt" class="form-control" style="padding:4px; background-color: #FFFF00; border: 1px solid #C0C0C0;width: 170px" required readonly></td>
                        </tr>
                        <tr>
                                <td style="border: none; " colspan="3">Mode of Payment</td>
                                <td style="border: none; ">
                                    <select name="PaymentMode" class="form-control" style="padding:4px; background-color: #FFFF00; border: 1px solid #C0C0C0;width: 170px" id="PayMode" required>
                                    <option value=""></option>
                                    <?php
                                        $Bal = odbc_exec($conn, "SELECT [Code] FROM [Payment Method] WHERE [Company Name]='$ms'");
                                        while(odbc_fetch_array($Bal)){
                                        echo "<option value='".odbc_result($Bal, "Code")."'>".odbc_result($Bal, "Code")."</option>";
                                        }
                                    ?>
                                    </select>
                                </td>
                        </tr>
                        <tr>
                                <td style="border: none; " colspan="3">Bank Name</td>
                                <td style="border: none; "><input type="text" name="BankName" id="BankName" style="padding:4px;width: 170px" class="form-control" disabled="true" /></td>
                        </tr>
                        <tr>
                                <td style="border: none; " colspan="3">Cheque / DD No.</td>
                                <td style="border: none; "><input type="text" name="ChequeDDNo" id="DDNo" maxlength="6" style="padding:4px;width: 170px" class="form-control" onkeypress='return validateQty(event)' onblur="if(this.value.length < 6){alert('Cheque No. must be 6 digit ...');}" disabled="true" /></td>
                        </tr>
                        <tr>
                                <td style="border: none; " colspan="3">Cheque / DD Date.</td>
                                <td style="border: none; "><input type="text" id="DDDt" name="ChequeDDt" maxlength="6" style="padding:4px;width: 170px" class="form-control" disabled="true" readonly /></td>
                        </tr>
                        <tr>
                                <td style="border: none; " colspan="3"></td>
                                <input type="hidden" value="<?php echo $CustomerNo;?>" name="cust_no" />
                                <input type="hidden" value="<?php echo $f; ?>" name="fee_count">
                                <td style="border: none; "><input type="submit" value="Submit" class="btn btn-success"   /></td>
                        </tr>
                        </table>
                <?php
                }
                else{
                        echo '<div class="alert alert-warning">';
                        echo "No dues ...";
                        echo '</div>';
                  }
        ?>
        </form>	
        
<!-- /Content -->
</div>
</div>
</div>
</div>
</div>
</div>
</div>
<!-- /Body -->

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

<script  type='text/javascript'>
		function validateQty(event) {
			var key = window.event ? event.keyCode : event.which;

			if (event.keyCode == 8 || event.keyCode == 46
			|| event.keyCode == 37 || event.keyCode == 39) {
			return true;
			}
			else if ( key < 48 || key > 57 ) {
			return false;
			}
			else return true;
		};


		
    function chkNumeric(evt) {
        evt = (evt) ? evt : window.event;
        var charCode = (evt.which) ? evt.which : evt.keyCode;
        if (charCode > 31 && (charCode < 48 || charCode > 57)) {
            if (charCode == 46) { return true; }
            else { return false; }
        }
        return true;
    }

		
		$(function() {
		$("#PayMode").change(function() {
			if($(this).val() == "CASH") {
                            $("#BankName").attr("disabled", "disabled");
                            $("#DDNo").attr("disabled", "disabled");
                            $("#DDDt").attr("disabled", "disabled");
			}
		else {    
			$("#BankName").removeAttr("disabled");
			$("#DDNo").removeAttr("disabled");
			$("#DDDt").removeAttr("disabled");
			}
		});
		$( "#PaymentDt" ).datepicker({maxDate:0});
		$( "#DDDt" ).datepicker({maxDate:0});
		});
		
              
		$(document).ready(function(){
			InputSum();
		 });
		
		function InputSum() {
			var sum = 0;
			$('input[id^="amt_paid"]').each(function () {
				sum += parseFloat($(this).val(), 10);
			});
			    
			document.getElementById("total2").value = sum;
		}
		
		function CheckThis(form) {
			var a = document.getElementById("total2").value;
			var b = document.getElementById("Amount").value;
		
			if (a === '' || b ==='') {
				alert("Amount Received field is empty ...");
				document.getElementById("Amount").focus();
				return false;
			}
			if (b < a) {
				alert("Amount Received is lesser than sum total of Payment Recieved ...");
				document.getElementById("Amount").focus();
				
				return false;
			}

			if (d === '') {
				alert("Amount Received field is empty ...");
				document.getElementById("Amount").focus();
				return false;
			}
		}
	</script>
<!-- /Datatables -->

<?php require_once("../footer.php");?>