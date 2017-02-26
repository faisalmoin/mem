	

<?php
//http://www.codingcage.com/2014/12/delete-data-from-mysql-with-confirmation.html
	require_once("../db.txt");
	//require_once("header.php");
	$CompName=6;
	//$CompName = $_REQUEST['CompName'];
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
	
	$Agreement = odbc_exec($conn, "SELECT TOP 1 * FROM [CRM Agreement] ") or die(odbc_errormsg($conn));
//change start
     /*      if($_SERVER['REQUEST_METHOD']=='POST')
           {
            $Generate=$_REQUEST["Generate"];
           	$Invoiceno=$_REQUEST["Invoiceno"];
           	$Date=strtotime(str_replace("/", " ",$_REQUEST["Date"].date("H:i:s")));
           	$totalamount=$_REQUEST["totalamount"];
           	$totalRoyalty=$_REQUEST["totalRoyalty"];
           	$feeamount=$_REQUEST["feeamount"];
           	$payble=$_REQUEST["payble"];
           	$servisetax=$_REQUEST["servisetax"];
           	$FinYr=$_REQUEST["FinYr"];
           	$companyName=$_REQUEST["companyName"];
		
		if(odbc_result($Agreement, "ST") == "1" ){
			$Calc = round($feeamount + ($feeamount*$servisetax)/100);
			
			if($payble == $Calc) {
				echo "+ST : $payable";
			}
			else{
          ?>
		 <!--script type="text/javascript">
				function delete_id(id)
				{
	     if(confirm('Sure To Insert This Record ?'))
		     {
		       // window.location.href='index.php?delete_id='+id;
		    	window.location.href = 'FranchiseeAdd.php?one=' $Generate '&one1=' $Invoiceno '&one2=' $Date 
		    	'&one3=' $totalamount '&one4=' $totalRoyalty '&one5=' $feeamount '&one6=' $payble '&one7=' $servisetax
		    	'&one8=' $FinYr '&one9=' $companyName;
		     }
					}
				</script-->
 
     <?php
			}
			
		}
		else if(odbc_result($Agreement, "ST") == "-1" ){
			$Calc = round($feeamount + $feeamount*(100/100+$servisetax));
			if($payble == $Calc) {
				echo "-ST : $payable";
			}
			else{
				?>
			 <!--script type="text/javascript">
		function delete_id(id)
		{
		     if(confirm('Sure To Insert This Record ?'))
		     {
		       // window.location.href='index.php?delete_id='+id;
		    	window.location.href = "FranchiseeAdd.php?one=" $Generate "&one1=" $Invoiceno "&one2=" $Date 
		    	"&one3=" $totalamount "&one4=" $totalRoyalty "&one5=" $feeamount "&one6=" $payble "&one7=" $servisetax
		    	"&one8=" $FinYr "&one9=" $companyName;
		     }
		}
		</script-->
			 
			<?php
			}
		
		   }
           } 
           //change End
            * */
?>
		


<!-- -----------------header start------------------ -->

	<link href="../bs/css/bootstrap.min.css" rel="stylesheet" />
	<link href="../bs/css/sticky-footer-navbar.css" rel="stylesheet" />
	<script src="../bs/js/ie-emulation-modes-warning.js"></script>
	<script src="../bs/js/jquery.min.js"></script>
	<script src="../bs/js/bootstrap.js"></script>
	<link rel="stylesheet" href="../bs/css/jquery-ui.css">
    <script src="../bs/js/jquery-1.10.2.js"></script>
    <script src="../bs/js/jquery-ui.js"></script>
    <link rel="stylesheet" href="../bs/css/style.css">
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
				<tr style='background-color: #0080cc'>
					<td colspan='3' style='padding: 15px;  border: none;'>
						<!--h2 style='color: #ffffff;'><a href='#' onclick='history.go(-1);' class='glyphicon glyphicon-circle-arrow-left' style=' text-decoration: none;color: #ffffff;'></a>
						Royalty
						</h2-->
						<h2 style='color: #ffffff;'><a href='#' onclick='history.go(-1);' class='glyphicon glyphicon-circle-arrow-left' style=' text-decoration: none;color: #ffffff;'></a>
						<?php echo odbc_result($Agreement, "Trust Name")?>
						</h2>
						
					</td>
					
					<td style='padding: 15px;  border: none;'></td>
					<td colspan='2' style='padding: 15px;  border: none;'>
					<h2 style='color: #ffffff;'>Year: <?php echo $FinYr; ?></h2></td>
					<td style='padding: 15px; border: none; color: #ffffff;' valign='top'>
						<!--?php require_once("menu.php")?-->
				    </td>
				</tr>
				
				<tr><td colspan='2' style='padding: 25px; border: none;' valign="top">
					<h3 class="text-primary">Name: <?php echo odbc_result($Agreement, "Name")?></h3></td>
			    </tr>
		</table>
		
		<script>
		
			//fee amount 
			function myFunction() {
			    var x = document.getElementById("Generate").value;// select box id
			    var tot_amt = document.getElementById("totalRoyalty").value;
			    var r;
			    var k;
			    var a;
			   var jsvar = <?php echo json_encode(odbc_result($Agreement, "ST"));?>;
			   // var jsvar = <--?php echo "1";?>;
			    if(x == "Yearly"){
				r = parseFloat(tot_amt/1).toFixed(2);		
			    }
			    if(x == "Halfyearly"){
				r = parseFloat(tot_amt/2).toFixed(2);		
			    }
			    if(x == "Quarterly"){
				r = parseFloat(tot_amt/3).toFixed(2);	
			    }
			    if(x == "BiMonthly"){
				r = parseFloat(tot_amt/6).toFixed(2);		
			    }
			    if(x == "Monthly"){
				r = parseFloat(tot_amt/12).toFixed(2);		
			    }
			    
			    //document.getElementById("servisetax").value = parseFloat(r*100/115).toFixed(2);
			    //document.getElementById("netpayble").value = parseFloat(r) + parseFloat(parseFloat(r*100/115).toFixed(2));;
			    if(jsvar == "1"){
				document.getElementById("demo").value = parseFloat(r).toFixed(2);
				document.getElementById("servicetax").value = parseFloat(r *15/100).toFixed(2);
				k =  parseFloat(r)+ parseFloat((r *15/100));
				document.getElementById("payble").value = k;
			     }
			     if(jsvar == "-1"){
				document.getElementById("payble").value = parseFloat(r).toFixed(2);
				k = parseFloat(r*(100/115)).toFixed(2);
				document.getElementById("demo").value = parseFloat(k).toFixed(2);
				document.getElementById("servicetax").value = parseFloat(r-k).toFixed(2);
			    }
			    }
				// only number and decimal no
		      function isNumberKey(evt)
		       {
		          var charCode = (evt.which) ? evt.which : event.keyCode;
		          if (charCode != 46 && charCode > 31 
		            && (charCode < 48 || charCode > 57))
		             return false;
		
		          return true;
		       }

    </SCRIPT>
	
	<script type="text/javascript">
   
      // Form validation code will come here.
      function validate(myForm)
      {
        
     if( document.myForm.Generate.value != "" && document.myForm.Generate.value == ""  )
         {
            alert( "Please provide your Fee!" );
            document.myForm.Generate.focus() ;
            return false;
         }
         
         if(document.myForm.Invoiceno.value != "" && document.myForm.Invoiceno.value == "" )
         {
            alert( "Please provide your Invoiceno!" );
            document.myForm.Invoiceno.focus() ;
            return false;
         }

         if( document.myForm.feeamount.value != "" && document.myForm.feeamount.value == "")
         {
            alert( "Please provide your Amount!" );
            document.myForm.feeamount.focus() ;
            return false;
         }

         if( document.myForm.servisetax.value != "" && document.myForm.servisetax.value == ""  )
         {
            alert( "Please provide your Tax Amount!" );
            document.myForm.servisetax.focus() ;
            return false;
         }
         if( document.myForm.payble.value != "" && document.myForm.payble.value == "" )
         {
            alert( "Please provide your Amount!" );
            document.myForm.payble.focus() ;
            return false;
         }
         
          var a=document.getElementByName("servisetax").value;
          var b=document.getElementByName("feeamount").value;
          var b=document.getElementByName("payble").value;
          
        if((parseFloat(b*15/100)+ parseFloat(b))!= document.getElementByName("payble").value )
         { 
        	alert( "calculation error!" );
           // document.getElementByName("servisetax").value=parseFloat(b*15/100);
           // document.getElementByName("payble").value=parseFloat(b*15/100)+ parseFloat(b);
            b.focus() ;
          return false;
         }
        return(true);
      }
   
     </script>   
		       
		<?php 
		$balanceamt = odbc_exec($conn, "SELECT SUM([Net Payble]) FROM [MemFin Franchisee %]") or die(odbc_errormsg($conn));
		$invamt = odbc_exec($conn, "SELECT SUM([Franchisee Amount]) FROM [MemFin Franchisee %]") or die(odbc_errormsg($conn));
		?>
		<form method="post" action="FranchiseeAdd.php" name="myForm" onsubmit="return(validate());" >
		<table class="table table-responsive " border="1" width="100%">
		<tr><td>Fee Generate</td><td>
		<select name="Generate" id="Generate" class="form-control" style="width: 180px;padding: 8px;" onchange="myFunction()" required>
		<option value=""></option>
		<option value="Yearly">Yearly</option>
		<option value="Halfyearly">Half yearly</option>
		<option value="Quarterly">Quarterly</option>
		<option value="BiMonthly">BiMonthly</option>
		<option value="Monthly">Monthly</option>
		</select></td></tr>
		<tr><td>Invoice Number</td><td><input style="width: 180px;padding: 8px;" type="text" class="form-control" name="Invoiceno" value="" required/></td></tr>
		<tr><td>Date</td><td><input style="width: 180px;padding: 8px;" id="initialDate" type="text" class="form-control" name="Date" value="" required /></td></tr>
		<tr><td>Franchisee Fee Amount</td><td><input style="width: 180px;padding: 8px;" type="text" class="form-control" name="totalamount" id="totalamount" readonly value="<?php echo odbc_result($Agreement, "Franchisee Fee");?>" /></td></tr>
		<?php if(odbc_result($Agreement, "ST") == "1" ) {?>
		<tr><td>Balance Amount</td><td><input style="width: 180px;padding: 8px;" type="text" class="form-control" name="totalRoyalty" id="totalRoyalty" readonly value="<?php echo odbc_result($Agreement, "Franchisee Fee")-odbc_result($invamt, "");?>"/></td></tr>
		<?php }?>
		<?php if(odbc_result($Agreement, "ST") == "-1" ) {?>
		<tr><td>Balance Amount</td><td><input style="width: 180px;padding: 8px;" type="text" class="form-control" name="totalRoyalty" id="totalRoyalty" readonly value="<?php echo odbc_result($Agreement, "Franchisee Fee")-odbc_result($balanceamt, "");?>"/></td></tr>
		<?php }?>
		<tr><td>Invoice Amount</td><td><input style="width: 180px;padding: 8px;" type="text" class="form-control" onkeypress="return isNumberKey(event)" name="feeamount" id="demo" value="" required/></td></tr>
		<tr><td>Service Tax <?php
			if(odbc_result($Agreement, "ST") == "1" ) echo " (Exclusive)";
			if(odbc_result($Agreement, "ST") == "-1" ) echo " (Inclusive)";
		?></td><td><input style="width: 180px;padding: 8px;" type="text" class="form-control" name="netpayble" id="netpayble" value="15" readonly /></td></tr>
		<tr><td>Taxable Amount </td><td><input style="width: 180px;padding: 8px;" type="text" class="form-control" name="servisetax" id="servicetax" value="" onkeypress="return isNumberKey(event)" required/></td></tr>
		<tr><td>Net Payble</td><td><input style="width: 180px;padding: 8px;" type="text" class="form-control" name="payble" id="payble" value="" onkeypress="return isNumberKey(event)" required/></td></tr>
		<!--tr><td colspan="2"><button class="btn btn-primary">Next</button></td></tr-->
		
		<tr><td><input class="btn btn-primary" type="submit" value="Submit"></td></tr>
		</table>
		<input type="hidden" class="form-control" name="companyName" value="<?php echo $CompName ?>" /> 
		<input type="hidden" class="form-control" name="FinYr" value="<?php echo $FinYr; ?>" />
		<!--input type="hidden" name="count" value="<--?php echo $c;?>"/--> 
							
		</form>
		</div>
		
		