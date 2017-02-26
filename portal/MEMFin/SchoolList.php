<?php
	//require_once("../db.txt");
	require_once("header.php");
?>
			    <div class="container">
			       
			     
					<h3 class="text-primary">School List</h3>	
					
					<table class="table table-responsive " border="1" width="100%" id="abc">
					<thead>
					<tr style="background-color: #FFC088; color: #ffffff;" class="statetablerow">
					<th style="text-align: center;">SN</th>
					<th style="text-align: center;">Company Name</th>
                                        <th style="text-align: center;">School Name</th>
					</tr>
					</thead>
					
					
					<?php 
					$c=0;
					$rs = odbc_exec($conn, "SELECT [ID], [Trust], [School Name], [City], [State] FROM [Company Information] WHERE [ID] NOT IN (SELECT DISTINCT([Company Name]) FROM [Royalty Setup])") or die(odbc_errormsg($conn));
					while(odbc_fetch_array($rs)){
				    ?>
					<tr>
					<td style="border: none; "><?php echo $c+1;?></td>
					<td style="border: none; "><?php 
                                            $trust = odbc_exec($conn, "SELECT [Trust Name] FROM [CRM Agreement] WHERE [id]='".odbc_result($rs, "Trust")."'"); 
                                            echo odbc_result($trust, "Trust Name");
                                        ?></td>
                                        <td style="border: none; "><a href="RoyaltySetup02.php?CompName=<?php echo odbc_result($rs, "ID") ?>" > <?php echo odbc_result($rs, "School Name")?></a>, 
                                            <small><?php echo odbc_result($rs, "City")?>, 
                                            <?php $state = odbc_exec($conn, "SELECT [State] FROM [postcode] WHERE [StateCode] ='".odbc_result($rs, "State")."'"); echo odbc_result($state, "State")?> </small></td>
					</tr>
					
					<?php 
                                            $c++;
					}
					
					$c++;
					?>
					</table>
			    </div>
	
   <?php require_once("../footer.php"); ?>
	