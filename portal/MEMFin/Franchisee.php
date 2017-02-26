<?php
//http://www.codingcage.com/2014/12/delete-data-from-mysql-with-confirmation.html
	//require_once("../db.txt");
	require_once("header.php");
	$CompName=$_REQUEST['CompName'];
	$today = strtotime(date('d M Y'));
	$this_yr = strtotime(date("Y", $today)."-04-01");
	$nxt_yr = strtotime((date("Y", $today)+1)."-03-31");
	
	if($today > strtotime(date("Y", $today)."-04-01") && $today < strtotime((date("Y", $today)+1)."-03-31")){
		$FinYr = date('y', $today)."-".(date('y', $today)+1);
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
	//$AgrID = odbc_exec($conn, "SELECT [Trust] FROM [Company Information] Where [ID]='$CompName' ") or die(odbc_errormsg($conn));
	//$Agreement = odbc_exec($conn, "SELECT * FROM [CRM Agreement] where [ID]='".odbc_result($AgrID, "Trust")."' ") or die(odbc_errormsg($conn));
	$Agreement = odbc_exec($conn, "SELECT * FROM [CRM Agreement] WHERE [ID]='$CompName'") or die(odbc_errormsg($conn));

?>
	
<!DOCTYPE html>
<html>
<head>

	<title>Franchisee</title>
    <style>
	.input{
		font-family: 'Josefin Sans', 'arial'; 
		font-size: 18px; 
		text-transform: uppercase;        
		color: #0072BC;
	 }
	.borderless tbody tr td, .borderless tbody tr th, .borderless thead tr th {
		border: none;
	 }
	 <!-- Bootstrap core CSS -->
	 <link href="../bs/css/bootstrap.min.css" rel="stylesheet" />
	</style>
       </head>
<body>


 <script type="text/javascript" charset="utf-8">
   $(function(){
	     $("#initialDate").datepicker({
			changeYear: true, 
			changeMonth: true,  
			dateFormat: 'dd/M/yy',
			minDate: '0',
			numberofMonths: '12'
			//yearRange: '<!--?php echo (date('Y')-3).":".(date('Y')-2)?>',  
			//defaultDate: '01/Dec/<--?php echo date('Y')-3;?>' ,
			//minDate: '01/Dec/<--?php echo (date('Y')-3); ?>',
			//maxDate: '30/Nov/<--?php echo (date('Y')-2); ?>'
		});
	});
 </script>
 <link href='https://fonts.googleapis.com/css?family=Raleway' rel='stylesheet' type='text/css'>
			<style>
				body {
					font-family: 'Raleway', sans-serif;
					font-size: 13px;
					padding: 0px;
				}
				table td {
					width: 160px;
					height: 40px;
					border: 1px solid #d3d3d3;
					font-size: 13px;
				}
				
				html {
					-webkit-text-size-adjust: 100%; /* Prevent font scaling in landscape while allowing user zoom */
				}
				thead {display: table-header-group;}
			</style>
			
			<div class="container">
			
			<table width='100%'>
			 <h3 class="text-primary">Franchisee Information</h3>
                                <table class="table table-responsive" style="border: 1px solid #d3d3d3;">
                                    <tr>
                                        <td style="border: none">Name</td>
                                        <td style="border: none; font-weight: normal;font-size: 18px;" colspan="5"><?php echo strtoupper(odbc_result($Agreement, "Trust Name"))?></td>
                                    </tr>
                                    <tr>
                                        <td style="border: none">City</td>
                                        <td style="border: none"><?php echo strtoupper(odbc_result($Agreement, "City"))?></td>
                                        <td style="border: none">State</td>
                                        <td style="border: none"><?php echo strtoupper(odbc_result($Agreement, "State"))?></td>
                                        <td style="border: none"></td>
                                        <td style="border: none"></td>
                                    </tr>
                                    <tr>
                                        <td style="border: none">Agreement Signing Date</td>
                                        <td style="border: none"><?php echo date('d/M/Y', odbc_result($Agreement, "Sign Date"))?></td>
                                        <td style="border: none"></td>
                                        <td style="border: none"></td>
                                        <td style="border: none"></td>
                                        <td style="border: none"></td>
                                    </tr>
                                    <tr>
                                        <td style="border: none">Duration</td>
                                        <td style="border: none"><?php echo strtoupper(odbc_result($Agreement, "Duration"))?></td>
                                        <td style="border: none">From Date</td>
                                        <td style="border: none"><?php echo date('d/M/Y', odbc_result($Agreement, "From Date"))?></td>
                                        <td style="border: none">To Date</td>
                                        <td style="border: none"><?php echo date('d/M/Y', odbc_result($Agreement, "To Date"))?></td>
                                    </tr>
                                    <tr>
                                        <td style="border: none">Outstanding</td>
                                        <td style="border: none; background-color: #FFC088; font-weight: normal;font-size: 18px;"><?php 
                                            $Invoice = odbc_exec($conn, "SELECT SUM([Net Payble]) FROM [MemFin Franchisee Credit] WHERE [Trust ID]='".$CompName."' ") or die(odbc_errormsg($conn));
                                            $Payment = odbc_exec($conn, "SELECT SUM([Total Amount]) FROM [MemFin Franchisee Debit] WHERE [Trust ID]='".$CompName."' ") or die(odbc_errormsg($conn));
                                            
                                            $Outstanding = odbc_result($Invoice, "") - odbc_result($Payment, "");
                                            echo number_format($Outstanding, 2, ".", ',');
                                        ?></td>
                                        <td style="border: none"></td>
                                        <td style="border: none"></td>
                                        <td style="border: none"></td>
                                        <td style="border: none"></td>
                                    </tr>
                                </table>
			    <tr>
				<td colspan='2' style='padding: 25px; border: none;' valign="top">
					<h3 class="text-primary"><?php echo odbc_result($headcmp, "Name")?></h3></td>
			    </tr>
		</table>
		
		
		
		<?php 
		$balanceamt = odbc_exec($conn, "SELECT SUM([Net Payble]) FROM [MemFin Franchisee Credit]") or die(odbc_errormsg($conn));
		$invamt = odbc_exec($conn, "SELECT SUM([Franchisee Amount]) FROM [MemFin Franchisee Credit]") or die(odbc_errormsg($conn));
		?>
		
            <form method="post" action="FranchiseeAdd.php" name="myForm" onsubmit="return myForm()" enctype="multipart/form-data">
            <table class="table table-responsive " border="1" width="100%">
            <thead>
            <tr style="background-color: #FFC088; color: #ffffff;" class="statetablerow">
                <th colspan="2" style="text-align: center;">Name: <?php echo odbc_result($Agreement, "Name")?></th>
            </tr>
            </thead>

            <tr>
              <td>Fee Generate</td>
              <td>
                <select name="Generate" id="Generate" class="form-control" >                  
                  <option value="">Select</option>
                  <option value="1">Yearly</option>
                  <option value="2">Half yearly</option>
                  <option value="4">Quarterly</option>
                  <option value="6">BiMonthly</option>
                  <option value="12">Monthly</option>
                </select>
                </td>
            </tr>

            <tr><td>Invoice Number</td><td><input type="text" class="form-control" name="Invoiceno" value="" /></td></tr>

            <tr><td>Date</td><td><input id="initialDate" type="text" class="form-control" name="Date" value="" required /></td></tr>

            <tr><td>Franchisee Fee Amount</td><td><input type="text" class="form-control" name="totalamount" id="totalamount" readonly value="<?php echo odbc_result($Agreement, "Franchisee Fee");?>" /></td></tr>
            <?php if(odbc_result($Agreement, "ST") == "1" ) {?>
            <tr><td>Balance Amount</td><td><input type="text" class="form-control" name="totalRoyalty" id="totalRoyalty" readonly value="<?php echo odbc_result($Agreement, "Franchisee Fee")-odbc_result($invamt, "");?>"/></td></tr>
            <?php }?>
            <?php if(odbc_result($Agreement, "ST") == "-1" ) {?>
            <tr><td>Balance Amount</td><td><input type="text" class="form-control" name="totalRoyalty" id="totalRoyalty" readonly value="<?php echo odbc_result($Agreement, "Franchisee Fee")-odbc_result($balanceamt, "");?>"/></td></tr>
            <?php }?>
            <tr><td>Invoice Amount</td><td><input type="text" class="form-control number-only"  name="feeamount" id="invAmount" value="" /></td></tr>
            <tr><td>Ervice Tax
            <?php
                if(odbc_result($Agreement, "ST") == "1" ) echo " (Exclusive)";
                if(odbc_result($Agreement, "ST") == "-1" ) echo " (Inclusive)";
	    ?>
            </td><td><input type="text" class="form-control" name="netpayble" id="netpayble" value="15%" readonly /></td></tr>
            <tr><td>Taxable Amount </td><td><input type="text" class="form-control number-only" name="servisetax" id="servicetax" value="" /></td></tr>
            <tr><td>Net Payble</td><td><input type="text" class="form-control number-only" name="payble" id="payble" value="" /></td></tr>
            <tr><td>Invoice SoftCopy</td><td><input type="file" name="fileToUpload" id="fileToUpload" required></td></tr>
            <tr><td colspan="2"><input class="btn btn-primary" type="submit" value="Submit"></td></tr>
            </table>
            <input type="hidden"  name="TrustName" value="<?php echo odbc_result($Agreement, "Trust Name") ?>" />
            <input type="hidden"  name="ID" value="<?php echo odbc_result($Agreement, "ID") ?>" />
            <input type="hidden"  name="companyName" value="<?php echo $CompName ?>" />
            <input type="hidden"  name="FinYr" value="<?php echo $FinYr ?>" />
            </form>
        </div>

	<script type="text/javascript">
		 
     jQuery(document).ready(function($) {

        var serviceTaxAdjustment = <?php echo json_encode(odbc_result($Agreement, "ST"));?>;

        var netpayble = parseFloat($("#netpayble").val());

        $("form").submit(function(event) {

          
           if(parseFloat($("#invAmount").val())+parseFloat($("#servicetax").val()) != parseFloat($("#payble").val())){
              var choice = confirm("Not correct, still want to do it ?");

              if(!choice){
                return false;
              }
           }
         /*
           if(parseFloat($("#totalRoyalty").val())==0){
               var choice1 = confirm("Amount All Ready Paid");

               if(!choice1){
                 return false;
               }
            }
           */
           
        });

        function updateNetPayable(payble) {
          var invoiceAmount = payble / (1 + netpayble / 100);

          updateInvoiceAmount(invoiceAmount);
        }

        function updatePayble(invoiceAmount, servicetaxValue) {
            invoiceAmount = invoiceAmount || 0;
            servicetaxValue = servicetaxValue || 0;
            var sum = (parseFloat(invoiceAmount) + parseFloat(servicetaxValue)).toFixed(2)
            $("#payble").val(sum);
        }

        function updateServiceTax(invoiceAmount) {
          invoiceAmount = invoiceAmount || 0;
          var servicetaxValue = parseFloat(invoiceAmount * netpayble/100).toFixed(2);
          $("#servicetax").val(servicetaxValue);

          updatePayble(invoiceAmount, servicetaxValue);
        }

        function updateInvoiceAmount(invoiceAmount) {
            invoiceAmount = invoiceAmount || 0;
            var invoiceAmount = parseFloat(invoiceAmount).toFixed(2) ;
            $("#invAmount").val(invoiceAmount);
            updateServiceTax(invoiceAmount);
        }

        $("#Generate").change(function() {
            var value = $(this).val();

            var invoiceAmount = 0;

            if(value){
                var totalRoyalty = parseFloat($("#totalRoyalty").val());
                invoiceAmount = totalRoyalty / parseFloat(value);
            }

            if(serviceTaxAdjustment == -1){
              updateNetPayable(invoiceAmount);
            }else{
              updateInvoiceAmount(invoiceAmount);
            }
            
        });

/*
        $("#invAmount").focusout(function(event) {
              var invoiceAmount = parseFloat($(this).val()).toFixed(2) || 0;

              updateInvoiceAmount(invoiceAmount);
        });

        $("#servicetax").focusout(function(event) {
              var servicetaxValue = parseFloat($(this).val()).toFixed(2);

              var invoiceAmount = parseFloat((servicetaxValue * 100) / netpayble).toFixed(2);
              
              updateInvoiceAmount(invoiceAmount);

        });

        $("#payble").focusout(function() {
            var payble = parseFloat($(this).val()).toFixed(2);

            updateNetPayable(payble);
            
        });
*/
        $('.number-only').keypress(function(evt) {
            var charCode = (evt.which) ? evt.which : event.keyCode;

            if (charCode != 46 && charCode > 31 && (charCode < 48 || charCode > 57)){
              return false;
            }

            return true;
        });

     });
	</script>


</body>
</html>
<?php require_once("../footer.php"); ?>