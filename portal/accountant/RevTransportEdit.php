<?php require_once("header.php");?>
<table id="results2" class="table table-responsive">
    <script>
                function jsFunction(){
                    // set text box value here
                    var txt1 =  document.getElementById('TransFee');
                    var txt2 =  document.getElementById('TransDist');
                    if(document.getElementById('SlabCode').value==""){
                        txt1.value = "0";
                        txt2.value = "0";
                    }
                    <?php
                        $TransportSlab = odbc_exec($conn, "SELECT [Amount], [Distance covered], [Slab Code] FROM [Transport Slab] WHERE [Company Name]='$ms' ORDER BY [Slab Code]");
                        while(odbc_fetch_array($TransportSlab)){
                    ?>
                    if(document.getElementById('SlabCode').value == "<?php echo odbc_result($TransportSlab, 'Slab Code')?>"){
                        txt1.value = <?php echo round(odbc_result($TransportSlab, 'Amount'),2)?>;
                        txt2.value = <?php echo odbc_result($TransportSlab, 'Distance covered')?>;
                    }
                    <?php
                    }
                    ?>
                }
            </script>
            <?php
              // $Customerno=$_REQUEST['invoice'];
               $Admissionno=$_REQUEST['id'];
               $Customer = odbc_exec($conn, "SELECT * FROM [Temp Student] WHERE [Company Name]='$CompName' AND [No_]='$Admissionno'  ");
               $Customerno=odbc_result($Customer, "Registration No_");
                $Transport = odbc_exec($conn, "SELECT * FROM [Temp Student] WHERE [Company Name]='$ms' AND [No_]= '".$Admissionno."' ") or die(odbc_errormsg($conn));
                $a=odbc_result($Transport, "Route No_");
                $b=odbc_result($Transport, "Transport Fee");
                $c=odbc_result($Transport, "Distance Covered in KM");?>
            <tr>
                <td>Slab Code</td>
                <td>
               
                    <select name="SlabCode" id="SlabCode" class="form-control" onchange="jsFunction()">
                    <option value="<?php echo odbc_result($Transport, "Slab Code") ?>"></option>
			<?php  $TransCode = odbc_exec($conn, "SELECT [Slab Code] FROM [Transport Slab] WHERE [Company Name]='$ms'");
                         while(odbc_fetch_array($TransCode)){
		         echo "<option value='".odbc_result($TransCode, "Slab Code")."'";
		         if(odbc_result($TransCode, "Slab Code") == odbc_result($Transport, "Route No_") ){echo " selected";}
		         echo ">".odbc_result($TransCode, "Slab Code")."</option>";
				 }?>
                     </select>
                
                
              
                    
                </td>
            </tr>                
            <tr>
                <td>Transport Fee</td>
                <td>
                    <input type="text" readonly="true" id="TransFee" name="TransFee" value='<?php echo number_format($b,2,'.',''); ?>' class="form-control" />
                </td>
            </tr>
            <tr>
                <td>Distance (KM)</td>
                <td>
                    <input type="text" maxlength="2" readonly="true" id="TransDist" name="TransDist" value='<?php echo number_format($c,2,'.','') ?>' class="form-control" />
                </td>
            </tr>
	
</table>
