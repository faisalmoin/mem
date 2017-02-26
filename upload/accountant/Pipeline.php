<?php
	require_once("header.php");
    
	$keyword = $_REQUEST['cust'];
	//echo "<br /><br /><br /><br />Err:$keyword";
	$query = odbc_exec($conn, "SELECT [Customer No] FROM [Ledger Credit] WHERE [Invoice No]='$keyword' OR [Customer No]='$keyword' AND [Company Name]='$ms'") or die(odbc_errormsg($conn));
	$CustomerNo = odbc_result($query, "Customer No");
	$stu = odbc_exec($conn, "SELECT [Name], [Addressee], [Class], [Academic Year] FROM [Temp Student] WHERE [Company Name]='$ms' AND [System Genrated No_]= '".odbc_result($query, "Customer No")."'") or die(odbc_errormsg($conn));
	if(odbc_num_rows($stu) == 0){
		$stu1 = odbc_exec($conn, "SELECT [Name], [Addressee], [Class], [Academic Year] FROM [Temp Application] WHERE [Company Name]='$ms' AND [System Genrated No_]= '".odbc_result($query, "Customer No")."'") or die(odbc_errormsg($conn));
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
	
	
	
	$keyword = $_REQUEST['cust'];
	
	$query = odbc_exec($conn, "SELECT [Invoice No] FROM [ledger Debit] WHERE [Customer No]='$keyword' OR [Invoice No]='$keyword' AND [Company Name]='$ms'") or die(odbc_errormsg($conn));
	$num_rows = odbc_num_rows($query);
	$InvoiceNo = odbc_result($query, "Invoice No");
	$RealizationDate = odbc_result($query, "Realization Date");
	$PaymentRealization = odbc_result($query, "Payment Realization");
	
	
?>

<script>

	$(function() {
		$( '.PaymentDt' ).datepicker({maxDate: '0'}); // Change this line
	});

	$(function(){
	    $("#myform").submit(function(){

	        var valid=0;
	        $(this).find('input[type=text]').each(function(){
	            if($(this).val() != "") valid+=1;
	        });

	        if(valid){
	          //  alert(valid + " inputs have been filled");
	            return true;
	        }
	        else {
	            alert("error: you must fill in at least one field");
	            return false;
	        }
	    });
	});

</script> 


<div class="container">

<?php
  $Admission = odbc_exec($conn, "SELECT [No_] FROM [Temp Student] WHERE [Registration No_]='$keyword' AND [Company Name]='$ms'") or die(odbc_errormsg($conn));
         $AdmissionNo = odbc_result($Admission, "No_");
?>

	<h2 class="text-primary">Student NO - <?php echo $AdmissionNo?></h2>
	<table class="table table-responsive">
		<tr>
			<td colspan="2"><h3>Account Information</h3></h3>
		<tr>
		<tr>
			<td>Student Name</td>
			<td>Ward of</td>
		</tr>
		<tr>
			<td><span class="text-primary" style="font-weight: bold;"><?php echo strtoupper($Name)?></span></td>
			<td><span class="text-primary" style="font-weight: bold;"><?php echo $Addressee?></span></td>
		</tr>
		<tr>
			<td>Academic Year</td>
			<td>Class</td>
		</tr>
		<tr>
			<td><span class="text-primary" style="font-weight: bold;"><?php echo $Acad?></span></td>
			<td><span class="text-primary" style="font-weight: bold;"><?php echo $Class?></span></td>
		</tr>
		<tr>
		
		</table>
	<form id="myform" action="PipelineEdit.php" method="post" onsubmit="return checkform(this)">
	<table class="table table-responsive">
	<tr>
		<th>Payment Date</th>
		<th>Payment Mode</th>
		<th>Debit Amount</th>
		<th>Realization Date</th>
		</tr>	
		
<?php
	$q = 1;
	$ldgr = odbc_exec($conn, "SELECT * FROM [ledger Debit] WHERE [Customer No]='$keyword' AND [Payment Realization] = 0 AND [Company Name]='$ms' ORDER BY [Invoice Date] DESC");
	while(odbc_fetch_array($ldgr)){
	if($RealizationDate == NULL){
  ?>

		<tr>
		
		<td><?php echo date('d/M/Y', odbc_result($ldgr, "Payment Date"));?></td>
		
		<td><?php echo odbc_result($ldgr, "Payment Mode")?></td>
		
		<td><?php echo number_format((odbc_result($ldgr, "Debit Amount")+odbc_result($ldgr, "Adv Fee")),2,'.',',') ?></td>
		
		<td style="border: none; ">
			<input type="text" name="PaymentDt<?php echo $q;?>" class="PaymentDt" style="padding:4px; background-color: #FFFF00; border: 1px solid #C0C0C0;width: 170px" readonly >
			<input type="hidden" name="id<?php echo $q?>" value="<?php echo odbc_result($ldgr, "ID") ?>" />
		</td>
		</tr>		
		<?php
					$q++;				
				}			
			}
		?>
		
	</table>
	
	
	<input type="hidden" value="<?php echo $q;?>" name="count">
	<input type="submit" name="update" class="btn btn-success" value="Update" >
		
</form>
</div>
<?php
	require_once("../footer.php");
?>