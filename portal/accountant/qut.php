<?php

require("../ConvertNum2Words.php");
require_once("header.php");
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
<h2>Term Fee </h2> <!-- Page Name -->
<ul class="nav navbar-right panel_toolbox">
<li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
</ul>
<div class="clearfix"></div>
</div>
<div class="x_content">
<!-- Content -->
        <?php
        $AdmissionYear=$_REQUEST['Academic'];
        $fee_count = $_REQUEST['fee_count'];
        $FeeType = $_REQUEST['FeeType'];
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
        $Class= $_REQUEST['Class'.$f];



   $FeeTpe = odbc_exec($conn, "SELECT * FROM [Fee Type] WHERE [Company Name]='$CompName' AND [Code]= '".$_REQUEST['FeeType']."' ") or die(odbc_errormsg($conn));
    $StartDate = odbc_result($FeeTpe, "Start Date");
    $EndDate = odbc_result($FeeTpe, "End Date");
    //echo "<br /><br />".(int)abs(($StartDate - $EndDate)/(60*60*24*30));
    $termmnth=(int)abs(($StartDate - $EndDate)/(60*60*24*30));
    // echo $termmnth;  
   if($today > $StartDate || $today > $EndDate){

		$seq = odbc_exec($conn, "SELECT MAX([Posting No])+1 AS [Posting] FROM [Ledger Credit] WHERE [Reverse]=0 AND [Company Name]='$CompName' ") or die(odbc_errormsg($conn));

		$inv = (odbc_result($seq, "Posting") <> ""?odbc_result($seq, "Posting"): 1 );
		$inv_no = str_pad($inv, 10, "0", STR_PAD_LEFT );
			
		/*$checkDescripton = odbc_exec($conn, "select * from [Ledger Credit] where [Customer No]='".$Reg."' AND [Month]='".date('m', $today)."' AND [Description] = 'Term Fee' AND [Reverse]=0 ") or die("Check ...") ;*/

        $checkDescripton = odbc_exec($conn, "select * from [Ledger Credit] where [Customer No]='".$Reg."' AND [Description] = '$FeeType' AND [Reverse]=0 AND [Year]='".date('Y', $today)."' ") or die("Check ...") ;

		$Admission = odbc_exec($conn, "SELECT [No_] FROM [Temp Student] WHERE [Registration No_]='".$Reg."' AND [Company Name]='$CompName'") or die(odbc_errormsg($conn));
                $AdmissionNo = odbc_result($Admission, "No_");
               if(odbc_num_rows($checkDescripton)==0){ //Condition check fee term, customer no and finyr
		
                ?>

            <h1 class="text-primary"><small><?php echo $FeeType; ?></small></h1>
            <h2 class="text-primary"><?php echo $f." - ".$AdmissionNo."-".$Class?></h2>
            <table id="results2" class="table table-responsive">
            <tr style="font-weight: bold;">
                    <td style="text-align: center;"></td>
                    <td>Description</td>
                    <td>Amount</td>
                    <td style="text-align:center">Discounted Amount</td>
                    <td style="text-align:center">Net Payable Amount</td>
            </tr>
	       <?php 
        // "Monthly: ". MonthNo(12,$Reg);		

		//Q1 Calculation
		if($today > strtotime(date("Y", $today)."-04-01") && $today < strtotime((date("Y", $today))."-06-30")){
			$Qtr = "Q1";
			MonthNo(4,$Reg);
                }
		
		//Q2 Calculation
		if($today > strtotime(date("Y", $today)."-07-01") && $today < strtotime((date("Y", $today))."-09-30")){
			$Qtr = "Q2";
			MonthNo(4,$Reg);
		}
		
		//Q3 Calculation
		if($today > strtotime(date("Y", $today)."-10-01") && $today < strtotime((date("Y", $today))."-12-31")){
			$Qtr = "Q3";
			MonthNo(4,$Reg);
		}
		
		//Q4 Calculation
		if($today > strtotime(date("Y", $today)."-01-01") && $today < strtotime((date("Y", $today))."-03-31")){
			$Qtr = "Q4";
			MonthNo(4,$Reg);
		}		
	
		//Half Yearly Calculation
		if($today > strtotime(date("Y", $today)."-04-01") && $today < strtotime((date("Y", $today))."-09-30")){
			$Hfl = "HLY1";
			MonthNo(2,$Reg);
		}
		
		//H2 Calculation
		if($today > strtotime(date("Y", $today)."-10-01") && $today < strtotime((date("Y", $today))."-03-31")){
			$Hfl = "HLY2";
			MonthNo(2,$Reg);
		}
	
		//Annual fee
		if($today > strtotime(date("Y", $today)."-03-20") && $today < strtotime((date("Y", $today))."-03-31"))
		{
			$ANN = "ANN";
			MonthNo(1,$Reg);
		}
		
		$InvCrd = "INSERT INTO [Ledger Credit]([Invoice Date], [Invoice No], [Customer No], [Description],
		[Credit Amount], [Company Name], [User ID], [Portal ID], [Posting No], [Adv Fee], [FinYr], [Month], [Year], [Qtr],[Reverse])
		VALUES
		('$inv_dt', '$inv_no', '$Reg', '$FeeType', $gTotal, '$CompName', '$LoginID',
		'$LoginID',$inv, 0, '$FinYr', '".date('m', $today)."', '".date('Y', $today)."', '$Qtr',0)";
		odbc_exec($conn, $InvCrd) or exit(odbc_errormsg($conn));
       // echo $InvCrd;
        //echo "<br/><br/>";

		//echo "<br /><br /><br /><br /><br /><br /><br /><br /><br />";
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
         }
         else
         {
         ?>
         <div class="alert alert-success">
         <?php echo "<br /><br />"; ?>
         <strong>Success!</strong> Student No <?php echo $Reg ?> - Fee already Generated.....................
         </div>
         <?php 
         }//check description
         }//start date end date e
         else{
          ?>
         <div class="alert alert-danger">
         <?php echo "<br /><br />"; ?>
         <strong>Error!</strong> Invalid Date.....................
         </div>
         <?php 
         }
         }

         }// loop end
        echo "<script>
         alert('Fee Generated');
        window.location.href='FeeTerm.php ';
       </script>"; 
       ?>
       </table>




<!-- Function Start -->       
<?php 

        function MonthNo($Mnth,$Reg){
            global $CompName,$Class, $conn,$ANN,$Hfl, $Reg,$AdmissionYear,$gTotal,$inv_dt,$inv_no,$LoginID,$new_amt,$FinYr,$Qtr,$today,$DocumentNo_,$termmnth;
            $f=1;
            $cust_no = $Reg;
            $mnth = $Mnth;
            $new_amt=0;



            if($Qtr == "") $Qtr = "MNTH";

           /* $sql = "SELECT * FROM [Class Fee Line] WHERE [Company Name]='".$CompName."' AND ([Class]='".$Class."' OR [Class]='') AND [Group Code]='INV' AND [No_ of months]='".$mnth."' ";*/

            $sql = "SELECT * FROM [Class Fee Line] WHERE [Company Name]='".$CompName."' AND ([Class]='".$Class."' OR [Class]='') AND [Group Code]='INV' AND [Academic year]= '$FinYr' ";	
           
          // echo $sql."<br/>";


            $rs22 = odbc_exec($conn, $sql) or die(odbc_errormsg($conn));
            while(odbc_fetch_array($rs22)){

            $rs = odbc_exec($conn, "SELECT * FROM [Class Fee Line] WHERE [Company Name]='$CompName' AND [ID]='".odbc_result($rs22, "ID")."' ") or die(odbc_errormsg($conn));

           
            while(odbc_fetch_array($rs)){
            $checkAnnual = odbc_exec($conn, "select [ID] from [ledger invoice] where 
            [Fee Description]='".odbc_result($rs, "Description")."' AND [Customer No]='".$Reg."' AND [Year]='".date('Y', $today)."' AND [Reverse]=0 ") or die(odbc_errormsg($conn)) ;

            $checkQut = odbc_exec($conn, "select [ID] from [ledger invoice] where 
            [Fee Description]='".odbc_result($rs, "Description")."' AND [Customer No]='".$Reg."' AND [Year]='".date('Y', $today)."' AND [Qtr] = '$Qtr' AND [Reverse]=0 ") or die(odbc_errormsg($conn)) ;
            
            $checkMonth = odbc_exec($conn, "select [ID] from [ledger invoice] where 
            [Fee Description]='".odbc_result($rs, "Description")."' AND [Customer No]='".$Reg."' AND [Year]='".date('Y', $today)."' AND [Month] = '".date('m', $today)."' AND [Qtr] = '$Qtr' AND [Reverse]=0 ") or die(odbc_errormsg($conn)) ;
           

          
          
             //if(odbc_num_rows($checkMonth)==0){  //Condition check month ,qtr,year and description    
            //if(odbc_num_rows($checkQut)==0){  //Condition check qtr,year and description 
            //if(odbc_num_rows($checkAnnual)==0){  //Condition check year and description 
           $new_amt = odbc_result($rs, "Monthly Amount")*$termmnth;
            $one_ins = "INSERT INTO [Ledger Invoice]([Invoice Date], [Invoice No], [Customer No], [Fee Description], [Amount],
            [Discount Code1],[Discount Code1 Amount], [Net Amount],[User ID], [Portal ID], [Company Name], [Discount Code2], [Discount Code2 Amount], [FinYr], [Month], [Year], [Qtr],[Reverse])
            VALUES('$inv_dt', '$inv_no', '$cust_no', '". odbc_result($rs, "Description")."', '$new_amt', '-', 0, 0, '$LoginID', '$LoginID', '$CompName', '', 0, '$FinYr', '".date('m', $today)."', '".date('Y', $today)."', '$Qtr',0)";
           odbc_exec($conn, $one_ins) or exit(odbc_errormsg($conn)); // OneTime
          // echo $one_ins;
           // echo "<br/><br/>";

             ?>
            <tr style="font-weight: bold;">
             <td style="text-align: center;"><!--?php echo $f;?--></td>
             <td><?php echo odbc_result($rs, "Description");?></td>
             <td><?php echo number_format(odbc_result($rs, "Monthly Amount")*$termmnth,2,'.',','); ?></td>
             <td></td>
             <td></td>	
            </tr>
            <?php			
             //$new_amt = odbc_result($rs, "Monthly Amount")*$termmnth;
            // echo $new_amt;
             $e=0;
             $disc_fee_hdr = odbc_exec($conn, "SELECT [DocumentNo_] FROM [StudentDiscountDetails] WHERE [ApplicationNo]='".$cust_no."' AND [CompanyName]='$CompName'") or die(odbc_errormsg($conn));
             $DocumentNo_= odbc_result($disc_fee_hdr, 'DocumentNo_');
             $disc_fee_line = odbc_exec($conn, "SELECT [Description], [Discount%], [Document No_] FROM [Discount Fee Line] WHERE [Company Name]='$CompName' AND [Fee Code]='".odbc_result($rs, "Fee Code")."' AND [Academic Year]='$AdmissionYear' AND [Document No_]='$DocumentNo_' ") or die(odbc_errormsg($conn));
            
           
             if(odbc_result($disc_fee_line, "Description") != "")

               {  //echo $new_amt ;
                $e = ($new_amt * odbc_result($disc_fee_line, "Discount%"))/100;
                $new_amt = $new_amt - $e;
                //echo $e;
               // echo $new_amt;
                $Discount = "INSERT INTO [Ledger Invoice]([Invoice Date], [Invoice No], [Customer No], [Fee Description], [Amount],
                [Discount Code1],[Discount Code1 Amount], [Net Amount],[User ID], [Portal ID], [Company Name], [Discount Code2], [Discount Code2 Amount], [FinYr], [Month], [Year], [Qtr],[Reverse])
                VALUES('$inv_dt', '$inv_no', '$cust_no', '".odbc_result($disc_fee_line, "Description")."', 0, '".odbc_result($disc_fee_line, "Document No_")."', $e, 0, '$LoginID', '$LoginID', '$CompName', '', 0, '$FinYr', '".date('m', $today)."', '".date('Y', $today)."', '$Qtr',0)";
               odbc_exec($conn, $Discount) or exit(odbc_errormsg($conn)); // OneTime
               // echo $Discount; 
              //  echo "<br/><br/>";
                echo "<tr style='text-decoration: italics; '><td></td>";
                echo "<td>".odbc_result($disc_fee_line, "Description")." // ". odbc_result($disc_fee_line, "Document No_") ."</td>";
                echo "<td></td>";
                echo "<td style='text-align:right;'>".number_format($e,0,'.',',')."</td>";
                echo "<td>";
                echo "</td></tr>";
                }
                if($new_amt >= 0){$new_amt=$new_amt; }else{$new_amt=0;}
                echo "<tr style='font-weight: bold;'><td></td><td>Net ".odbc_result($rs, "Description")." payable </td><td></td><td></td>";
                echo "<td style='text-align:right;'>".number_format($new_amt,0,'.',',')."</td>";
                echo "</tr>";

                $Net_payable = "INSERT INTO [Ledger Invoice]([Invoice Date], [Invoice No], [Customer No], [Fee Description], [Amount],
                [Discount Code1],[Discount Code1 Amount], [Net Amount],[User ID], [Portal ID], [Company Name], [Discount Code2], [Discount Code2 Amount], [FinYr], [Month], [Year], [Qtr],[Reverse])
                VALUES('$inv_dt', '$inv_no', '$cust_no', 'Net ".odbc_result($rs, "Description")." payable', 0, '', 0, $new_amt, '$LoginID', '$LoginID', '$CompName', '', 0, '$FinYr', '".date('m', $today)."', '".date('Y', $today)."', '$Qtr',0)";
                odbc_exec($conn, $Net_payable) or exit(odbc_errormsg($conn)); // OneTime
               // echo $Net_payable;
               // echo "<br/><br/>";
                 // }
                //}
                //}
             }
              $gTotal+= $new_amt;
          }
            //-----------------------------------------start transport fee----------------------------------------------
            
           
               /* $Transport = odbc_exec($conn, "SELECT * FROM [Temp Application] WHERE [Company Name]='$CompName' AND [System Genrated No_]= '".$Reg."' ") or die(odbc_errormsg($conn));*/
                $Transport = odbc_exec($conn, "SELECT * FROM [Temp Student] WHERE [Company Name]='$CompName' AND [Registration No_]= '".$Reg."' ") or die(odbc_errormsg($conn));
                $a=odbc_result($Transport, "Transport Fee");
                $b=odbc_result($Transport, "Slab Code");
                $c=odbc_result($Transport, "Distance Covered in KM");
                if(!empty($a) && ($b) && ($c)) {
                ?>
                <tr style="font-weight: bold;">
                    <td style="text-align: center;"><!--?php echo $f;?--></td>
                    <td><?php echo "Transport Fee";?></td>
                    <td><?php echo number_format($a*$termmnth,2,'.',','); ?></td>
                    <td></td>
                    <td></td>	
                </tr>
               <?php
               if($a!= "" && $b!= "" && $c!= ""){
               $checkyear1 = odbc_exec($conn, "select [ID] from [ledger invoice] where 
               [Fee Description]='Transport Fee' AND [Customer No]='".$Reg."' AND [Year]='".date('Y', $today)."' AND [Reverse]=0 ") or die(odbc_errormsg($conn)) ;

               $checkQut1 = odbc_exec($conn, "select [ID] from [ledger invoice] where 
               [Fee Description]='Transport Fee' AND [Customer No]='".$Reg."' AND [Year]='".date('Y', $today)."' AND [Qtr] = '$Qtr' AND [Reverse]=0 ") or die(odbc_errormsg($conn)) ;

               $checkMonth1 = odbc_exec($conn, "select [ID] from [ledger invoice] where 
               [Fee Description]='Transport Fee' AND [Customer No]='".$Reg."' AND [Year]='".date('Y', $today)."' AND [Month] = '".date('m', $today)."' AND [Qtr] = '$Qtr' AND [Reverse]=0 ") or die(odbc_errormsg($conn)) ;
           
             // if(odbc_num_rows($checkMonth1)==0){
             // if(odbc_num_rows($checkQut1)==0){
             // if(odbc_num_rows($checkyear1)==0){
               $TranTot=$a*$termmnth;

               $one_ins1 = "INSERT INTO [Ledger Invoice]([Invoice Date], [Invoice No], [Customer No], [Fee Description], [Amount],
               [Discount Code1],[Discount Code1 Amount], [Net Amount],[User ID], [Portal ID], [Company Name], [Discount Code2], [Discount Code2 Amount], [FinYr], [Month], [Year], [Qtr],[Reverse])
               VALUES('$inv_dt', '$inv_no', '$cust_no', 'Transport Fee', '$TranTot', '-', 0, 0, '$LoginID', '$LoginID', '$CompName', '', 0, '$FinYr', '".date('m', $today)."', '".date('Y', $today)."', '$Qtr',0)";
             odbc_exec($conn, $one_ins1) or exit(odbc_errormsg($conn)); // OneTime
               //echo $one_ins1;
               //echo "<br/><br/>";
               
                echo "<tr style='font-weight: bold;'><td></td><td>Net Transport Fee payable </td><td></td><td></td>";
                echo "<td style='text-align:right;'>".number_format($a*$termmnth,0,'.',',')."</td>";
                echo "</tr>";

                $Net_payable1 = "INSERT INTO [Ledger Invoice]([Invoice Date], [Invoice No], [Customer No], [Fee Description], [Amount],
                [Discount Code1],[Discount Code1 Amount], [Net Amount],[User ID], [Portal ID], [Company Name], [Discount Code2], [Discount Code2 Amount], [FinYr], [Month], [Year], [Qtr],[Reverse])
                VALUES('$inv_dt', '$inv_no', '$cust_no', 'Net Transport Fee payable', 0, '', 0, $TranTot, '$LoginID', '$LoginID', '$CompName', '', 0, '$FinYr', '".date('m', $today)."', '".date('Y', $today)."', '$Qtr',0)";
              odbc_exec($conn, $Net_payable1) or exit(odbc_errormsg($conn)); // OneTime
               // echo $Net_payable1;
               // echo "<br/><br/>";
                //}
                //}
                //}
                }
            }
          //--------------------------------------end trans fee-------------------------------------     
              // $gTotal+= $new_amt+$a;
             $gTotal= $gTotal+$TranTot;
                $f++;
              return $gTotal;
              } //function end
               ?>


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

<?php require_once("../footer.php"); ?>