<?php

    date_default_timezone_set('Asia/Calcutta');
    $cid = '6';
   // if(!$cid){ header("Location: index.php");}
    require_once("header.php");
    //Company details ....
   $Comp = odbc_exec($conn, "SELECT * FROM [Company Information] WHERE [ID]='$cid' ") or exit(odbc_errormsg($conn));
   //while(odbc_fetch_array($Comp))
				

?>

<div class="container">
   <form name="myForm" method="POST" action="company.php" onsubmit="return(validateForm());" onkeypress="return event.keyCode != 13;">

<table width="100%" align="center" border="0px" cellspacing="0px" cellpadding="5px"  class="table table-responsive borderless"  style="font-family: 'Oxygen', Arial; font-size: 18px;">
    <tr>
        <td height="200px" colspan="6" align='center' style="border-top: 0px;">
            <p style="font-family: 'Poiret One', 'arial'; font-size: 42px; text-transform: uppercase;" class="text-primary"><?php echo odbc_result($Comp, "Company Name"); ?> </p><input type="hidden" name="cid" value="<?php echo $cid; ?>"><input type="hidden" name="SchoolName" value="<?php echo $Comp['SchoolName']; ?>"><br />
		<?php echo odbc_result($Comp, "Company Name");?>//<?php echo odbc_result($Comp, "Address");?>//<?php echo odbc_result($Comp, "City");?>
		<input type="hidden" name="Address1" value="<?php echo odbc_result($Comp, "City");?>">
		<input type="hidden" name="Address2" value="<?php echo odbc_result($Comp, "City"); ?>">
		<input type="hidden" name="Address3" value="<?php echo odbc_result($Comp, "Company Name"); ?>">
	    </p>
                <p style="font-family: 'Poiret One', 'arial'; font-size: 24px; text-transform: uppercase;">Registration Form</p>
                <p style="font-family: 'Josefin Sans', 'arial'; font-size: 18px; text-transform: uppercase;">Academic Session 
		<?php
			$val = "".(date('Y')+1)."-".(date('y')+2);
		?>
                    <select name='AcadYear' style="padding: 5px;" id='input'> 
                        <?php
                            for($x=1; $x<=1; $x++) {
				$ts = (date('Y')+$x)."-".((date('y')+1)+$x);
                                echo "<option value='".(date('Y')+$x)."-".((date('y')+1)+$x)."'";                                
                                if($ts == $val) echo " selected ";
                                
                                echo ">".(date('Y')+$x)."-".((date('y')+1)+$x)."</option>";
                                
                            }
                            
                        ?>
                    </select>
                </p>
        </td>
    </tr> 
 
    <tr>
        <td></td>
        <td>Name of the Child</td>
        <td><input type="checkbox" name="check0" value="Nationality" checked /></td>
        <td><input type="hidden" name="text0" value="ChildName"/></td>
        
    </tr>
     <tr>
        <td></td>
        <td>Nationality</td>
        <td><input type="checkbox" name="check1" value="Nationality" checked /></td>
         <td><input type="hidden" name="text1" value="Nationality"/></td>
    </tr>
    <tr>
        <td></td>
        <td>Date of Birth</td>
        <td><input type="checkbox" name="check2" value="DOB" checked /></td>
        <td><input type="hidden" name="text2" value="DOB"/></td>
    </tr>
     <tr>
        <td></td>
        <td>Mother Tongue</td>
        <td><input type="checkbox" name="check3" value="MotherTongue" checked /></td>
        <td><input type="hidden" name="text3" value="MotherTongue"/></td>
    </tr>
     <tr>
        <td></td>
        <td>Religion & Caste</td>
        <td><input type="checkbox" name="check4" value="ReligionCaste" checked /></td>
         <td><input type="hidden" name="text4" value="ReligionCaste"/></td>
    </tr>
     <tr>
        <td></td>
        <td>Class to which admission is sought:</td>
        <td><input type="checkbox" name="check5" value="ClassAdmission" checked /></td>
        <td><input type="hidden" name="text5" value="ClassAdmission"/></td>
    </tr>
     <tr>
        <td></td>
        <td>Parent Information</td>
        <td><input type="checkbox" name="check6" value="ParentInformation" checked /></td>
        <td><input type="hidden" name="text6" value="ParentInformation"/></td>
    </tr>
     <tr>
        <td></td>
        <td>Residential Address</td>
        <td><input type="checkbox" name="check7" value="ResidentialAddress" checked /></td>
        <td><input type="hidden" name="text7" value="ResidentialAddress"/></td>
    </tr>
     <tr>
        <td></td>
        <td>Residential Phone No.</td>
        <td><input type="checkbox" name="check8" value="ResidentialPhone" checked /></td>
        <td><input type="hidden" name="text8" value="ResidentialPhone"/></td>
    </tr>
     <tr>
        <td></td>
        <td>Emergency Phone No.</td>
        <td><input type="checkbox" name="check9" value="EmergencyPhone" checked /></td>
        <td><input type="hidden" name="text9" value="EmergencyPhone"/></td>
    </tr>
     <tr>
        <td></td>
        <td>Email for communication</td>
        <td><input type="checkbox" name="check10" value="Email" checked /></td>
        <td><input type="hidden" name="text10" value="Email" /></td>
    </tr>
     <tr>
        <td></td>
        <td>Marital Status</td>
        <td><input type="checkbox" name="check11" value="MaritalStatus" checked /></td>
        <td><input type="hidden" name="text11" value="MaritalStatus" /></td>
    </tr>
   <tr>
        <td></td>
        <td>Distance to School from Residence</td>
        <td><input type="checkbox" name="check12" value="Distance" checked /></td>
        <td><input type="hidden" name="text12" value="Distance" /></td>
    </tr>
    <tr>
        <td></td>
        <td>major ailment/allergy</td>
        <td><input type="checkbox" name="check13" value="major" checked /></td>
        <td><input type="hidden" name="text13" value="major" /></td>
    </tr>
    <tr>
        <td></td>
        <td>Sibling in School</td>
        <td><input type="checkbox" name="check14" value="SiblingSchool" checked /></td>
        <td><input type="hidden" name="text14" value="SiblingSchool" /></td>
    </tr>
   
	

            
</table>
<input type="Submit" class='btn btn-primary' value='Submit'>
</form>
   
</div>

<?php require 'SetupRight.php'?>

