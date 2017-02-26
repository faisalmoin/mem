<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
?>
<div class="table-responsive">
                <table class="table">
                    <tr>
                        <td colspan="2"><h3 class="text-primary">Sibling Details</h3>
                        <!--td colspan="2"><h3 class="text-primary">Discount Details</h3-->
                    </tr>
                    <tr>
                        <td>Sibling</td>
                        <td><input type="checkbox" name="Sibling" id="Sibling" value="1" onclick="SelectName()" <?php 
					if(odbc_result($row, 'Sibling') == 1) echo " checked";
				?>>
				 <script type="text/javascript">
					//var popup;
					function SelectName() {
						if (document.getElementById('Sibling').checked) {
							var popup;
							//popup = window.open("SiblingDetails.php?id=<?php echo $id;?>&ms=<?php echo $ms?>", "Popup", "width=300,height=100");
							popup = window.open("SiblingDetails.php?id=<?php echo $id;?>&ms=<?php echo $ms?>", "Popup");
							popup.focus();
						}
						else{
							document.getElementById("Sibling").value = "0";
							document.getElementById("SiblingCode").value = "";
							document.getElementById("SiblingName").value = "";
							document.getElementById("SiblingClass").value = "";
							document.getElementById("SiblingSection").value = "";
							document.getElementById("SiblingDOB").value = "";
							document.getElementById("SiblingNo").value = "";
						}
					}
				</script>
			</td>
                        <!--td>Discount Code</td>
                        <td><input type="textkbox" name="DiscountCode" value="<?php echo odbc_result($row, 'Discount Code')?>" class="form-control" readonly="true"></td-->
                    </tr>
                    <tr>
                        <td>Sibling Code</td>
                        <td><input type="textbox" class="form-control" name="SiblingCode" id="SiblingCode" readonly="true" 
				value="<?php echo odbc_result($row, 'Sibbling Code')?>" 					
				class="form-control"></td>
				<input type="hidden" name="SiblingNo" id="SiblingNo" value="<?php echo odbc_result($Student, "Sibling No_"); ?>">
                        <!--td>Discount Code Classification</td>
                        <td><input type="textkbox" name="DiscountCodeClasification" value="<?php echo odbc_result($row, 'Discount Classification')?>" class="form-control" readonly="true"></td-->
                    </tr>
                    <tr>
                        <td>Sibling Name</td>
                        <td><input type="textbox" name="SiblingName" id="SiblingName" readonly="true" value="<?php echo odbc_result($row, 'Sibbling Name')?>" class="form-control"></td>
                        <!--td>Discount Code 1</td>
                        <td><input type="textkbox" name="DiscountCode" value="<?php echo odbc_result($row, 'Discount Code 1')?>" class="form-control" readonly="true"></td-->
                    </tr>
                    <tr>
                        <td>Sibling DOB</td>
                        <td><input type="textbox" name="SiblingDOB" id="SiblingDOB" readonly="true" value="<?php 
				if(odbc_result($row, 'Sibling DOB') != "1900-01-01 00:00:00.000") 
					echo date('d/M/Y', strtotime(odbc_result($row, 'Sibling DOB'))); 
				else echo '' ?>" class="form-control"></td>
                        <!--td>Discount Code Classification 1</td>
                        <td><input type="textkbox" name="DiscountCodeClasification1" value="<?php echo odbc_result($row, 'Discount Classification1')?>" class="form-control" readonly="true"></td-->
                    </tr>
                    <tr>
                        <td>Sibling Class</td>
                        <td><input type="textbox" name="SiblingClass"  id="SiblingClass"  readonly="true" value="<?php echo odbc_result($row, 'Sibling Class')?>" class="form-control"></td>
                    </tr>
                    <tr>
                        <td>Sibling Section</td>
                        <td><input type="textbox" name="SiblingSection" id="SiblingSection" readonly="true" value="<?php echo odbc_result($row, 'Sibling Section')?>" class="form-control"></td>
                    </tr>
                </table>
            </div>
