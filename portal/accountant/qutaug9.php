<?php

require("../ConvertNum2Words.php");
require_once("header.php");
//echo "<br /><br /><br /><br />";
//echo print_r($_POST);
$AdmissionYear=$_REQUEST['Academic'];
$Class= $_REQUEST['Class'];
$fee_count = $_REQUEST['fee_count'];

$inv_dt = time();
$inv_last_dt = date('t');

$today = $inv_dt;
$this_yr = strtotime(date("Y", $today)."-04-01");
$nxt_yr = strtotime((date("Y", $today)+1)."-03-31");
$this_yr = strtotime(date("Y", $today)."-04-01");
$nxt_yr = strtotime((date("Y", $today)+1)."-03-31");

if($today > strtotime(date("Y", $today)."-04-01") && $today < strtotime((date("Y", $today)+1)."-03-31")){
	$FinYr = date('y', $today)."-".(date('y', $today)+1);
} else if ($today < strtotime(date("Y", $today)."-04-01")  && $today < strtotime((date("Y", $today))."-03-31")) {
        $FinYr = (date('y', $today)-1)."-".date('y', $today);
    }

// loop started

for($f=0; $f<=$_REQUEST['fee_count']; $f++){
	if($_REQUEST['fee'.$f] == 1){

		$d=1;
		$gTotal = 0;

		$Reg= $_REQUEST['registration'.$f];

		$seq = odbc_exec($conn, "SELECT MAX([Posting No])+1 AS [Posting] FROM [Ledger Credit] WHERE [Company Name]='$CompName'") or die(odbc_errormsg($conn));

		$inv = (odbc_result($seq, "Posting") <> ""?odbc_result($seq, "Posting"): 1 );
		$inv_no = str_pad($inv, 10, "0", STR_PAD_LEFT );
			
		$checkDescripton = odbc_exec($conn, "select * from [Ledger Credit] where [Customer No]='".$Reg."' AND [Month]='".date('m', $today)."' AND [Description] = 'Term Fee'  ") or die("Check ...") ;
		//if(odbc_num_rows($checkDescripton)==0){ //check fee term, customer no and finyr
		 
	  ?>
	 <div class="container">
		<h1 class="text-primary">Term<small> - Fee</small></h1>
		<h2 class="text-primary"><?php echo $f." - ".$Reg ?></h2>

		<table id="results2" class="table table-responsive">

			<tr style="font-weight: bold;">
				<td style="text-align: center;"></td>
				<td>Description</td>
				<td>Amount</td>
				<td style="text-align:center">Discounted Amount</td>
				<td style="text-align:center">Net Payable Amount</td>
			</tr>
	    <?php 

		"Monthly: ". MonthNo(1,$Reg);		

		//Q1 Calculation
		if($today > strtotime(date("Y", $today)."-04-01") && $today < strtotime((date("Y", $today))."-06-30")){
			$Qtr = "Q1";
			MonthNo(2,$Reg);
                }
		
		//Q2 Calculation
		if($today > strtotime(date("Y", $today)."-07-01") && $today < strtotime((date("Y", $today))."-09-30")){
			$Qtr = "Q2";
			MonthNo(2,$Reg);
		}
		
		//Q3 Calculation
		if($today > strtotime(date("Y", $today)."-10-01") && $today < strtotime((date("Y", $today))."-12-31")){
			$Qtr = "Q3";
			MonthNo(2,$Reg);
		}
		
		//Q4 Calculation
		if($today > strtotime(date("Y", $today)."-01-01") && $today < strtotime((date("Y", $today))."-03-31")){
			$Qtr = "Q4";
			MonthNo(2,$Reg);
		}		
	
		//Half Yearly Calculation
		if($today > strtotime(date("Y", $today)."-04-01") && $today < strtotime((date("Y", $today))."-09-30")){
			$Hfl = "HLY1";
			MonthNo(3,$Reg);
		}
		
		//H2 Calculation
		if($today > strtotime(date("Y", $today)."-10-01") && $today < strtotime((date("Y", $today))."-03-31")){
			$Hfl = "HLY2";
			MonthNo(3,$Reg);
		}
	
		//Annual fee
		if($today > strtotime(date("Y", $today)."-03-20") && $today < strtotime((date("Y", $today))."-03-31"))
		{
			$ANN = "ANN";
			MonthNo(4,$Reg);
		}
		
		$InvCrd = "INSERT INTO [Ledger Credit]([Invoice Date], [Invoice No], [Customer No], [Description],
		[Credit Amount], [Company Name], [User ID], [Portal ID], [Posting No], [Adv Fee], [FinYr], [Month], [Year], [Qtr])
		VALUES
		('$inv_dt', '$inv_no', '$Reg', 'Term Fee', $gTotal, '$CompName', '$LoginID',
		'$LoginID',$inv, 0, '$FinYr', '".date('m', $today)."', '".date('Y', $today)."', '$Qtr')";
		//odbc_exec($conn, $InvCrd) or exit(odbc_errormsg($conn));

		echo "<br /><br /><br /><br /><br /><br /><br /><br /><br />";
	   ?>

	   <tr style="font-weight: bold;">
		<td colspan="2">TOTAL</td>
        <td></td>
		<td></td>
		<td  style='text-align:right;'><?php echo number_format($gTotal,0,'.',','); ?></td>
	   </tr>

	   <tr>
		<td style="border-top: 1px solid #000000;" colspan="5">				
			Amount : <b>Rupees <?php echo strtoupper(convert_number_to_words(round($gTotal)));?> Only</b>
		</td>
	   </tr>
	
	   <?php 
		$d++;
		/*}
		else
		{
		?>
		<div class="alert alert-success">
		<?php echo "<br /><br />"; ?>
		<strong>Success!</strong> Student No <?php echo $Reg ?> - Fee already Generated.....................
		</div>
		<?php 
		} */
	   }
	   }
	  // loop end
	/*  echo "<script>
            alert('Fee Generated');
           window.location.href='FeeTerm.php ';
          </script>"; */
	 ?>
	 </table>
	 </div>

	   <?php require_once("../footer.php");
			function MonthNo($Mnth,$Reg){
				global $CompName,$Class, $conn,$ANN,$Hfl, $Reg,$AdmissionYear,$gTotal,$inv_dt,$inv_no,$LoginID,$new_amt,$FinYr,$Qtr,$today,$DocumentNo_;
				$f=1;
				$cust_no = $Reg;
				$mnth = $Mnth;
				$new_amt=0;
				
				if($Qtr == "") $Qtr = "MNTH";
				
				$sql = "SELECT * FROM [Class Fee Line] WHERE [Company Name]='".$CompName."' AND [Class]='".$Class."' AND [Group Code]='INV' AND [No_ of months]='".$mnth."' ";	
	                        $rs22 = odbc_exec($conn, $sql) or die("Error ");
			        while(odbc_fetch_array($rs22)){
	                        //$echo .= odbc_result($rs22, "ID").", ";
				
				$rs = odbc_exec($conn, "SELECT * FROM [Class Fee Line] WHERE [Company Name]='$CompName' AND [ID]='".odbc_result($rs22, "ID")."' ") or die(odbc_errormsg($conn));
				while(odbc_fetch_array($rs)){
				$checkMonth = odbc_exec($conn, "select [ID] from [ledger invoice] where 
				[Fee Description]='".odbc_result($rs, "Description")."' AND [Customer No]='".$Reg."' AND [Year]='".date('Y', $today)."' AND [Month] = '".date('m', $today)."' AND [Qtr] = '$Qtr' ") or die(odbc_errormsg($conn)) ;
				//if(odbc_num_rows($checkMonth)==0){  //check month ,qtr,year and description 	
							
				$one_ins = "INSERT INTO [Ledger Invoice]([Invoice Date], [Invoice No], [Customer No], [Fee Description], [Amount],
				[Discount Code1],[Discount Code1 Amount], [Net Amount],[User ID], [Portal ID], [Company Name], [Discount Code2], [Discount Code2 Amount], [FinYr], [Month], [Year], [Qtr])
				VALUES('$inv_dt', '$inv_no', '$cust_no', '". odbc_result($rs, "Description")."', '".odbc_result($rs, "Total Amount")."', '-', 0, 0, '$LoginID', '$LoginID', '$CompName', '', 0, '$FinYr', '".date('m', $today)."', '".date('Y', $today)."', '$Qtr')";
			       // odbc_exec($conn, $one_ins) or exit(odbc_errormsg($conn)); // OneTime
						
				 ?>
				<tr style="font-weight: bold;">
				 <td style="text-align: center;"><!--?php echo $f;?--></td>
				 <td><?php echo odbc_result($rs, "Description");?></td>
				 <td><?php echo number_format(odbc_result($rs, "Total Amount"),2,'.',','); ?></td>
				 <td></td>
				 <td></td>	
				</tr>
	                        <?php			
				 $new_amt = odbc_result($rs, "Total Amount");
				 $e=0;
				 $disc_fee_hdr = odbc_exec($conn, "SELECT [DocumentNo_] FROM [StudentDiscountDetails] WHERE [ApplicationNo]='".$cust_no."' AND [CompanyName]='$CompName'") or die(odbc_errormsg($conn));
				 $DocumentNo_= odbc_result($disc_fee_hdr, 'DocumentNo_');
				 $disc_fee_line = odbc_exec($conn, "SELECT [Description], [Discount%], [Document No_] FROM [Discount Fee Line] WHERE [Company Name]='$CompName' AND [Fee Code]='".odbc_result($rs, "Fee Code")."' AND [Academic Year]='$AdmissionYear' AND [Document No_]='$DocumentNo_' ") or die(odbc_errormsg($conn));
				 if(odbc_result($disc_fee_line, "Description") != "")
						{
							$e = ($new_amt * odbc_result($disc_fee_line, "Discount%"))/100;
							$new_amt = $new_amt - $e;
							
							$Discount = "INSERT INTO [Ledger Invoice]([Invoice Date], [Invoice No], [Customer No], [Fee Description], [Amount],
							[Discount Code1],[Discount Code1 Amount], [Net Amount],[User ID], [Portal ID], [Company Name], [Discount Code2], [Discount Code2 Amount], [FinYr], [Month], [Year], [Qtr])
							VALUES('$inv_dt', '$inv_no', '$cust_no', '".odbc_result($disc_fee_line, "Description")."', 0, '".odbc_result($disc_fee_line, "Document No_")."', $e, 0, '$LoginID', '$LoginID', '$CompName', '', 0, '$FinYr', '".date('m', $today)."', '".date('Y', $today)."', '$Qtr')";
							//odbc_exec($conn, $Discount) or exit(odbc_errormsg($conn)); // OneTime
							echo "<tr style='text-decoration: italics; '><td></td>";
							echo "<td>".odbc_result($disc_fee_line, "Description")." // ". odbc_result($disc_fee_line, "Document No_") ."</td>";
							echo "<td></td>";
							echo "<td style='text-align:right;'>".number_format($e,0,'.',',')."</td>";
							echo "<td>";
							echo "</td></tr>";
						  }
					
					echo "<tr style='font-weight: bold;'><td></td><td>Net ".odbc_result($rs, "Description")." payable </td><td></td><td></td>";
					echo "<td style='text-align:right;'>".number_format($new_amt,0,'.',',')."</td>";
					echo "</tr>";
					
					$Net_payable = "INSERT INTO [Ledger Invoice]([Invoice Date], [Invoice No], [Customer No], [Fee Description], [Amount],
					[Discount Code1],[Discount Code1 Amount], [Net Amount],[User ID], [Portal ID], [Company Name], [Discount Code2], [Discount Code2 Amount], [FinYr], [Month], [Year], [Qtr])
					VALUES('$inv_dt', '$inv_no', '$cust_no', 'Net ".odbc_result($rs, "Description")." payable', 0, '', 0, $new_amt, '$LoginID', '$LoginID', '$CompName', '', 0, '$FinYr', '".date('m', $today)."', '".date('Y', $today)."', '$Qtr')";
					//odbc_exec($conn, $Net_payable) or exit(odbc_errormsg($conn)); // OneTime
					
					$gTotal+= $new_amt;
                    
					$f++;
				  	}
				   return $gTotal;
				    }
                              // } 
                                     
                     //---------------------------------------------------start transport------------------------------------------------------
                              /*      
                          
				$sql1 = dbc_exec($conn, "SELECT * FROM [Temp Application] WHERE [Company Name]='".$CompName."' AND [Class]='".$Class."' ") or die(odbc_errormsg($conn));
				 $SlabCode = odbc_result($sql1, "Slab Code");
                                  $TransFee = odbc_result($sql1, "Transport Fee");
                                  $TransDist= odbc_result($sql1, "Distance Covered in KM");
                                $new_amt = $TransFee;	
				 ?>
				<tr style="font-weight: bold;">
				 <td style="text-align: center;"><!--?php echo $f;?--></td>
				 <td><?php echo "Transport Fee";?></td>
				 <td><?php echo number_format(odbc_result($sql1, "Transport Fee"),2,'.',','); ?></td>
				 <td></td>
				 <td></td>	
				</tr>
	                         <?php			
				 
					echo "<tr style='font-weight: bold;'><td></td><td>Net Transport Fee payable </td><td></td><td></td>";
					echo "<td style='text-align:right;'>".number_format($new_amt,0,'.',',')."</td>";
					echo "</tr>";
					
					$Net_payable = "INSERT INTO [Ledger Invoice]([Invoice Date], [Invoice No], [Customer No], [Fee Description], [Amount],
					[Discount Code1],[Discount Code1 Amount], [Net Amount],[User ID], [Portal ID], [Company Name], [Discount Code2], [Discount Code2 Amount], [FinYr], [Month], [Year], [Qtr])
					VALUES('$inv_dt', '$inv_no', '$cust_no', 'Net ".odbc_result($rs, "Description")." payable', 0, '', 0, $new_amt, '$LoginID', '$LoginID', '$CompName', '', 0, '$FinYr', '".date('m', $today)."', '".date('Y', $today)."', '$Qtr')";
					//odbc_exec($conn, $Net_payable) or exit(odbc_errormsg($conn)); // OneTime
					
					//$gTotal+= $new_amt;
                                        //$f++;
				  
				    //return $gTotal;
			*/
              ///---------------------------------------------------------------------end transport ----------------------------------                      
                                    
               
                         } //function end
                       
			
?>