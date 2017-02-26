<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
?>
<div class="table-responsive">
	<table class="table">
        <tr><td colspan="4"><h3 class="text-primary">Parents Details</h3></td></td></tr>
        <tr><td colspan="4"><h4 class="text-primary">Father's Details</h4></td></td></tr>
        <tr>
                <td>Father's Name</td>
                <td><input style="background-color: #FFFF00" type="text" name="FatherName" id="FatherName" onchange="document.getElementById('pFName').value=this.value;" class="form-control" value="<?php echo odbc_result($row,  'Father_s Name'); ?>" /></td>
                <td>Passport No.</td>
                <td><input type="text" name="PassportNo" class="form-control"  value="<?php echo odbc_result($row,  'Passport No_');?>"/></td>
        </tr>
        <tr>
                <td>Father's Qualification</td>
                <td><input type="text" name="FatherQualification" onchange="document.getElementById('pFQual').value=this.value;" class="form-control" value="<?php echo odbc_result($row,  'Father_s Qualification'); ?>" /></td>
                <td>Password Exp. Date</td>
                <td><input type="text"name="PassportExpDt" class="form-control" value="<?php echo date("d/M/Y", strtotime(odbc_result($row, "Passport Exp Date"))); ?>" /></td>
        </tr>
        <tr>
                <td>Father's Occupation</td>
                <td><input style="background-color: #FFFF00" type="text" name="FatherOccupation" onchange="document.getElementById('pFOcc').value=this.value;"  class="form-control" value="<?php echo odbc_result($row,  'Father_s Occupation'); ?>" /></td>
                <td>Visa No.</td>
                <td><input type="text" name="VisaNo" class="form-control" value="<?php echo odbc_result($row, "Visa No_"); ?>" /></td>
        </tr>
        <tr>
                <td>Father's Annual Income</td>
                <td><input type="text" name="FatherAnnualIncome" onchange="document.getElementById('pFAI').value=this.value;"  class="form-control" value="<?php echo number_format((float)odbc_result($row,  'Father_s Annual Income'),'2','.',''); ?>" /></td>
                <td>Visa Exp. Date</td>
                <td><input type="text"name="VisaExpDt" class="form-control" value="<?php echo date("d/M/Y", strtotime(odbc_result($row, "Visa Exp Date"))); ?>" /></td>
        </tr>
        <tr><td colspan="4"><h4 class="text-primary">Mother's Details</h4></td></td></tr>
        <tr>
                <td>Mother's Name</td>
                <td><input style="background-color: #FFFF00" type="text" name="MotherName" id="MotherName" onchange="document.getElementById('pMName').value=this.value;"  class="form-control" value="<?php echo odbc_result($row,  'Mother_s Name'); ?>" /></td>
                <td></td>
                <td></td>
        </tr>
        <tr>
                <td>Mother's Qualification</td>
                <td><input type="text" name="MotherQualification" class="form-control" value="<?php echo odbc_result($row,  'Mother_s Qualification'); ?>" onchange="document.getElementById('pMQual').value=this.value;" /></td>
                <td></td>
                <td></td>
        </tr>
        <tr>
                <td>Mother's Occupation</td>
                <td><input style="background-color: #FFFF00" type="text" name="MotherOccupation" onchange="document.getElementById('pMOcc').value=this.value;"  class="form-control" value="<?php echo odbc_result($row,  'Mother_s Occupation'); ?>" /></td>
                <td></td>
                <td></td>
        </tr>
        <tr>
                <td>Mother's Annual Income</td>
                <td><input type="text" name="MotherAnnualIncome" onchange="document.getElementById('pMAI').value=this.value;"  class="form-control" value="<?php echo number_format((float)odbc_result($row,  'Mother_s Annual Income'),'2','.',''); ?>" /></td>
                <td></td>
                <td></td>
        </tr>
        <tr><td colspan="4"><h4 class="text-primary">Guardian's Details</h4></td></td></tr>
        <tr>
                <td>Guardian's Name</td>
                <td><input type="text" name="GaurdianName" id="GaurdianName" onchange="document.getElementById('pGName').value=this.value;"  class="form-control" value="<?php echo odbc_result($row,  'Guardian Name'); ?>" /></td>
                <td></td>
                <td></td>
        </tr>
        <tr>
                <td>Gaurdian's Qualification</td>
                <td><input type="text" name="GaurdianQualification" onchange="document.getElementById('pGQual').value=this.value;"  class="form-control" value="<?php echo odbc_result($row,  'Guardian Qualification'); ?>" /></td>
                <td></td>
                <td></td>
        </tr>
        <tr>
                <td>Gaurdian's Occupation</td>
                <td><input type="text" name="GaurdianOccupation" onchange="document.getElementById('pGOcc').value=this.value;"  class="form-control" value="<?php echo odbc_result($row,  'Guardian Occupation'); ?>" /></td>
                <td></td>
                <td></td>
        </tr>
        <tr>
                <td>Gaurdian's Annual Income</td>
                <td><input type="text" name="GaurdianAnnualIncome" onchange="document.getElementById('pGAI').value=this.value;"  class="form-control" value="<?php echo number_format((float)odbc_result($row,  'Guardian Annual Income'),'2','.',''); ?>" /></td>
                <td></td>
                <td></td>
        </tr>
	</table>
</div>
