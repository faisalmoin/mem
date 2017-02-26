<div class="table-responsive" style="width:40%;" xmlns="http://www.w3.org/1999/html">
	<table class="table">
		<tr>
			<td>Food Habits</td>
			<td>
                <select name="FoodHabits" class="form-control">
                    <option value="0"></option>
                    <option value="1">Veg</option>
                    <option value="2">No-Veg</option>
                </select>
            </td>
		</tr>
		<tr>
			<td>Quota</td>
			<td>
                    <select name="Quota" class="form-control">
                        <option value=""></option>
                    <?php
                        $quota = odbc_exec($conn, "SELECT * FROM [".$ms."Quota]");
                        while(odbc_fetch_array($quota)){
                    ?>
                        <option value="<?php echo odbc_result($quota, 'Code')?>"><?php echo odbc_result($quota, 'Code')?></option>
                    <?php
                        }
                    ?>
                    </select>
            </td>
		</tr>
		<tr>
			<td>Physically Challanged</td>
			<td><input type="checkbox" name="PhysicallyChallenged" value="1" <?php if(odbc_result($rs, 'Physically Challenged')==1) echo " checked"; ?> /></td>
		</tr>
        <script type='text/javascript'>//<![CDATA[
            $(function(){
                var checkboxes = $("input[id='StaffChild']"),
                    submitButt = $("select[id='StaffCode']");
                    checkboxes.click(function() {
                    submitButt.attr("disabled", !checkboxes.is(":checked"));
                });
            });
            //]]>
        </script>
		<tr>
			<td>Staff Child</td>
			<td><input type="checkbox" name="StaffChild" value="Yes" onclick="enableDisabled(this)" id="StaffChild" /></td>
		</tr>
		<tr>
			<td>Staff Code</td>
			<td>
                <select name="StaffCode" class="form-control" id="StaffCode" disabled>
                    <option value=""></option>
                    <?php
                    $StaffCode = odbc_exec($conn, "SELECT [No_], [First Name], [Last Name], [Job Title] FROM [Employee] WHERE [Company Name]='$ms' ORDER BY [No_]");
                    while(odbc_fetch_array($StaffCode)){
                        ?>
                        <option value="<?php echo odbc_result($StaffCode, 'No_')?>"><?php echo odbc_result($StaffCode, 'No_')." | ".odbc_result($StaffCode, 'First Name')." ".odbc_result($StaffCode, 'Last Name') ." - ".odbc_result($StaffCode, 'Job Title')?></option>
                    <?php
                    }
                    ?>
                </select>
            </td>
		</tr>
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
            <tr>
                <td>Slab Code</td>
                <td>
                <select name="SlabCode" id="SlabCode" class="form-control" onchange="jsFunction()">
                    <option value=""></option>
                    <?php
                        $TransCode = odbc_exec($conn, "SELECT [Slab Code] FROM [Transport Slab] WHERE [Company Name]='$ms'");
                        while(odbc_fetch_array($TransCode)){
                            echo "<option value='". odbc_result($TransCode, "Slab Code")."'>". odbc_result($TransCode, "Slab Code")."</option>";
                        }
                    ?>
                </select>
                </td>
            </tr>                
            <tr>
                <td>Transport Fee</td>
                <td>
                    <input type="text" readonly="true" id="TransFee" name="TransFee" value='0' class="form-control" />
                </td>
            </tr>
            <tr>
                <td>Distance (KM)</td>
                <td>
                    <input type="text" maxlength="2" readonly="true" id="TransDist" name="TransDist" value='0' class="form-control" />
                </td>
            </tr>
		<tr>
			<td>Height (CM)</td>
			<td><input type="text" maxlength="3" name="Height" class="form-control isNumeric" /></td>
		</tr>
		<tr>
			<td>Weight (KG)</td>
			<td><input type="text" maxlength="3" name="Weight" class="form-control isNumeric" /></td>
		</tr>
	</table>
</div>