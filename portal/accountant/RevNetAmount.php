<?php
	require_once("../db.txt");
	require_once("../ConvertNum2Words.php");
	
	// $Customerno=$_REQUEST['invoice'];
               $Admissionno=$_REQUEST['id'];
               $Customer = odbc_exec($conn, "SELECT * FROM [Temp Student] WHERE [Company Name]='$ms' AND [No_]='$Admissionno'  ");
               $id=odbc_result($Customer, "Registration No_");
              
      

?>
<!DOCTYPE html>
<html>
	<head>
		<title>Invoice</title>
		
	</head>
        <body>	
            
            
	       <div>
		<table class="table table-responsive" style="border: 0px solid #d3d3d3; border-style: dashed;" >
		<tr style="font-weight: bold; background-color:#E0F8F1;">
				<!--td style="border: 2px solid #d3d3d3;">S.No</td-->
				<td colspan="2" style="border: 0px solid #d3d3d3;">Description</td>
				<td align="right" style="border: 0px solid #d3d3d3;">Amount</td>
				<td align="right" style="border: 0px solid #d3d3d3;">Discount Amount</td>
				<td align="right" style="border: 0px solid #d3d3d3;">Net Amount</td>
			</tr>
			<?php
				$i = 1;
				$rs = odbc_exec($conn, "SELECT * FROM [Ledger Invoice] 
					WHERE [Company Name]='$ms' AND [Customer No]='$id' AND [Reverse]=0 ");
                               while(odbc_fetch_array($rs)){			
			?>
			<tr style="font-weight: normal;">
				<!--td><?php echo $i;?></td-->
				<td colspan="2"><?php 
					$a = odbc_result($rs, "Fee Description");
					if(strpos($a, 'Net ') !== false && strpos($a, ' payable') !== false){
                                       
							echo "<b><i>".odbc_result($rs, "Fee Description")."</i></b>";
                                      
					}	
					else{
						echo $a;
					}
				?></td>
				<?php if(odbc_result($rs, "Amount") != 0){ ?>
				<td align="right"><?php echo number_format(odbc_result($rs, "Amount"),2,'.',',');?></td>
                                <td align="right"><?php //echo annn ?></td>
				<td><span>&nbsp;</span></td>
				<?php }
					if(odbc_result($rs, "Amount") == 0 && odbc_result($rs, "Discount Code1") != ""){
						echo "<td></td><td align='right'>".number_format(odbc_result($rs, "Discount Code1 Amount"),2,'.',',')."</td><td><span>&nbsp;</span></td>";
					}
					   if(odbc_result($rs, "Amount") == 0 && odbc_result($rs, "Discount Code1") == ""){
						echo "<td></td><td></td><td align='right'><b>".number_format(odbc_result($rs, "Net Amount"),2,'.',',')."</b></td>";
                                        }?>
			        </tr><?php
					$i++;
				}
			?>
			<tr>
				<td colspan="2" style="border-left: 1px solid #d3d3d3; border-top: 1px solid #d3d3d3; border-bottom: 1px solid #d3d3d3;"><b>TOTAL</b></td>				
                                <td align="right" style="border-top: 1px solid #d3d3d3;border-bottom: 1px solid #d3d3d3;border-right: 1px solid #d3d3d3; border-left: 1px solid #d3d3d3;">
                                    <?php
					//Get Amount From Credit
					$TotAmt1 = odbc_exec($conn, "SELECT SUM([Amount]) FROM [Ledger Invoice] WHERE [Customer No]='$id' AND [Company Name]='$ms' AND [Reverse]=0 ");
					echo number_format(odbc_result($TotAmt1, ""),2, '.','');				
				?>
                                </td>
                                <td align="right" style="border-top: 1px solid #d3d3d3;border-bottom: 1px solid #d3d3d3;border-right: 1px solid #d3d3d3;">
                                <?php
					//Get Amount From Credit
					$TotAmt2 = odbc_exec($conn, "SELECT SUM([Discount Code1 Amount]) FROM [Ledger Invoice] WHERE [Customer No]='$id' AND [Company Name]='$ms' AND [Reverse]=0 ");
					echo number_format(odbc_result($TotAmt2, ""),2, '.','');				
				?></td>
                                <td style="border-top: 1px solid #d3d3d3;border-bottom: 1px solid #d3d3d3;border-right: 1px solid #d3d3d3;" align="right"><b>
				<?php
					//Get Amount From Credit
					$TotAmt = odbc_exec($conn, "SELECT SUM([Net Amount]) FROM [Ledger Invoice] WHERE [Customer No]='$id' AND [Company Name]='$ms' AND [Reverse]=0 ");
					echo number_format(odbc_result($TotAmt, ""),2, '.','');				
				?></b>
				</td>
			</tr>
			<tr>
				<td style="border-top: 1px solid #d3d3d3;" colspan="5">				
					Amount in Words: Rupees <b><?php echo strtoupper(convert_number_to_words(round(odbc_result($TotAmt, ""))));?></b> Only
				</td>
			</tr>
			
			
		</table>
        </div>
   
    </body>
</html>
