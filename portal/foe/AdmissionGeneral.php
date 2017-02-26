<script src="../bs/js/jquery.chained.remote.js" type="text/javascript" charset="utf-8"></script>
<script type="text/javascript" charset="utf-8">
    
    $(function(){

        $("#datepicker1").datepicker({ minDate: -7, maxDate: 0});
        $("#datepicker2").datepicker({changeYear: true, changeMonth: true});
        $("#datepicker3").datepicker({ minDate: 0});        

        $('select').change(function() {            
            var selections = [];
            $('#select1 option:selected').each(function(){
                    if($(this).val())
                        selections.push($(this).val());
                }
            )
            //console.log(selections );
            $('#select2 option').each(function() {
                $(this).attr('disabled', $.inArray($(this).val(),selections)>-1 && !$(this).is(":selected"));
            });
        });
    });

    //Change SECTION value based on CLASS selected //
    $(window).load(function(){
        
        //Change of Discount Code
        $("#acadyr").change(function()
        {
                if($(this).data('options') == undefined){                    
                    /*Taking an array of all options-2 and kind of embedding it on the select1*/                    
                    $(this).data('options',$('#select1 option').clone());
                    $(this).data('options',$('#select2 option').clone());
                }
                var id = $(this).val();
                var options = $(this).data('options').filter('[class=' + id + ']');
                $('#select1, #select2').html(options);
        });

    });
    
    // Numeric Validation
    $(document).ready(function() {
        $('.isNumeric').keypress(function (event) {
            return isNumber(event, this)
        });

    });
    // THE SCRIPT THAT CHECKS IF THE KEY PRESSED IS A NUMERIC OR DECIMAL VALUE.
    function isNumber(evt, element) {
        var charCode = (evt.which) ? evt.which : event.keyCode

        if (
            (charCode != 45 || $(element).val().indexOf('-') != -1) &&      // â€œ-â€� CHECK MINUS, AND ONLY ONE.
            (charCode != 46 || $(element).val().indexOf('.') != -1) &&      // â€œ.â€� CHECK DOT, AND ONLY ONE.
            (charCode != 8 ) &&      // â€œ.â€� CHECK BACKSPACE.
            (charCode < 48 || charCode > 57))
            return false;

        return true;
    }
    
    function changetextbox()
    {
        if (document.getElementById("class").value == "XI" || document.getElementById("class").value == "XII") {
            document.getElementById("Stream").disabled=false;
        } 
        else {
            document.getElementById("Stream").disabled=true;
        }
    }
</script>

    <div class="table-responsive">
	<table class="table">
		<tr>
                    <td>Application No.</td>
                    <td><input type="text" value="<?php echo odbc_result($rs, 'No_'); ?>" class="form-control" name="RegistrationNo" readonly="true" required /></td>
                    <td>Admission Date</td>
                    <td><input type="text" style="background-color: #FFFF00;" value="<?=date('d/M/Y')?>" class="form-control" name="AdmissionDate" id="datepicker1" required readonly /></td>
		</tr>
		<tr>
                    <td>Student Name</td>
                    <td><input type="text" maxlength="50" value="<?php echo odbc_result($rs, 'Name'); ?>" class="form-control" name="StudentName" style="background-color: #ffff00;" required /></td>
                    <td>Hostel Accomodation</td>
                    <td><input type="checkbox" value="1" name="HostelAccomodation" <?php if(odbc_result($rs, 'Hostel Acommodation')==1) echo ' checked'?> />
                &nbsp; &nbsp;&nbsp;&nbsp; EWS/RTE:&nbsp; &nbsp;&nbsp;&nbsp;<input type="checkbox" value="1" name="EWS" <?php if(odbc_result($rs, 'EWS')==1) echo ' checked'?>>
            </td>
		</tr>
		<tr>
                    <td>Gender</td>
                    <td><select  style="background-color: #ffff00;" class="form-control" name="Gender" required >
                            <option value="1" <?php if (odbc_result($rs, 'Gender')==1) echo 'selected';?>>Boy</option>
                            <option value="2" <?php if (odbc_result($rs, 'Gender')==2) echo 'selected';?>>Girl</option>
                        </select>
                    </td>
                    <td>Registration Status</td>
                    <td><input type="text" value="<?php
                        if(odbc_result($rs, 'Registration Status')==1) echo "SOLD";
                        if(odbc_result($rs, 'Registration Status')==2) echo "RECEIVED";
                        if(odbc_result($rs, 'Registration Status')==3) echo "SELECTED";
                        if(odbc_result($rs, 'Registration Status')==4) echo "PENDING APPROVAL";
                        if(odbc_result($rs, 'Registration Status')==5) echo "APPROVED";
                        if(odbc_result($rs, 'Registration Status')==6) echo "ADMITTED";
                        ?>" class="form-control" readonly="true" name="RegistrationStatus" required />
                    </td>
		</tr>
		<tr>
			<td>Date of Birth</td>
			<td><input type="text" value="<?php echo date('d/M/Y', strtotime(odbc_result($rs, 'Date of Birth'))); ?>" class="form-control" name="DOB" id="datepicker2"  required readonly /></td>
			<td>Registration Form No.</td>
			<td><input type="text" value="<?php echo odbc_result($rs, 'Registration No_'); ?>" class="form-control" readonly="true" name="RegistrationFormNo" required /></td>
		</tr>
		<tr>
                    <td>Medium of Instruction</td>
                    <td><?php //echo odbc_result($rs, 'Medium of Instruction'); ?>
                        <select class="form-control" style="background-color: #ffff00;" name="MediumInstruction" required>
                            <option value=""></option>
                            <?php
                                $StuMed = odbc_exec($conn, "SELECT [Code] FROM [MediumOfInstruction]");
                                while(odbc_fetch_array($StuMed)){
                            ?>
                            <option value="<?php echo odbc_result($StuMed, "code"); ?>"
                            <?php
                                if(odbc_result($StuMed, "code") == odbc_result($rs, 'Medium of Instruction')) echo ' selected';
                            //(($StuMed[0] == odbc_result($rs, 'Medium of Instruction'))?" selected":"");
                            ?>
                            ><?php echo odbc_result($StuMed, "code");?></option>
                            <?php
                                }
                            ?>
                        </select>
                    </td>
                    <td>Admission for Year</td>
                    <td><select style="background-color: #ffff00;" class="form-control acadyr"  name="AdmissionYear" id="meetingPlace" required>
                    	<option value=""></option>
                        <!--select style="background-color: #ffff00;" class="form-control acadyr"  name="AdmissionYear" id="meetingPlace" onchange="getAcadmic();getAcadmicDiscount();" required-->
                            
                            <?php
                                $StuAcad = odbc_exec($conn, "SELECT [Code] FROM [Academic Year] WHERE [Company Name]='$ms' ORDER BY [Code], [Sequence]");
                                while(odbc_fetch_array($StuAcad)){
                            ?>
                            <option value="<?php echo odbc_result($StuAcad, 'Code')?>"
                            <?php
                                if(odbc_result($StuAcad, 'Code') == odbc_result($rs, 'Admission For Year')) echo " selected";
                            ?>
                            ><?php echo odbc_result($StuAcad, 'Code')?></option>
                            <?php
                                }
                            ?>
                        </select>
                        
                         
                    </td>
		</tr>
		<tr>
                    <td>Class</td>
                    <td>
                        <select style="background-color: #ffff00;" class="form-control" name="Class" id="class" required >
                            <option value=""></option>
                            <?php
                                $StCl = odbc_result($rs, 'Class');
                                $StuClass=odbc_exec($conn, "SELECT [Code] FROM [Class] WHERE [Company Name]='$ms' ORDER BY [Sequence]");
                                while(odbc_fetch_array($StuClass)){
                            ?>
                            <option value="<?php echo odbc_result($StuClass, 'Code')?>" <?php if (odbc_result($rs, 'Class') == odbc_result($StuClass, 'Code')) echo " selected" ?>><?php echo odbc_result($StuClass, 'Code')?></option>
                            <?php
                                }
                            ?>
                        </select>
                    </td>
                    <td>Language 2</td>
                    <td><select class="form-control" name="Language2">
                            <option value=""></option>
                            <option value="1" <?php if (odbc_result($rs, 'langauge 1')==1) echo ' selected';?>>Hindi</option>
                            <option value="2" <?php if (odbc_result($rs, 'langauge 1')==2) echo ' selected';?>>Tamil</option>
                            <option value="3" <?php if (odbc_result($rs, 'langauge 1')==3) echo ' selected';?>>Sanskrit</option>
                            <option value="4" <?php if (odbc_result($rs, 'langauge 1')==4) echo ' selected';?>>Kannada</option>
                            <option value="5" <?php if (odbc_result($rs, 'langauge 1')==5) echo ' selected';?>>French</option>
                        </select>
                    </td>
                    </tr>
                    
					<tr>
                    <td>Section</td>
                    <td>
                        <select class="form-control" name="Section" style="background-color: #ffff00;" id="section" required>
                            <option value=""></option>
                            <?php
                                //$ClassSec=odbc_exec($conn, "SELECT DISTINCT([Section]), [Class] FROM [Class Section] WHERE [Academic Year]='".odbc_result($rs, 'Admission For Year')."' AND [Company Name]='$ms' AND [Class]='".odbc_result($rs, 'Class')."'");
                                $ClassSec=odbc_exec($conn, "SELECT DISTINCT([Section]) FROM [Class Section] WHERE [Company Name]='$ms'");
                                //$ClassSec=odbc_exec($conn, "SELECT DISTINCT([Section]), [Class] FROM [".$ms."Class Section] WHERE [Class]=''");
                                while(odbc_fetch_array($ClassSec)){
                                    echo "<option value='".odbc_result($ClassSec, 'Section')."' class='".odbc_result($ClassSec, 'Class')."'";
                                    if (odbc_result($ClassSec, 'Section') == "SNA") echo " selected";
                					echo ">".odbc_result($ClassSec, 'Section')."</option>";
                                }
                            ?>
                        </select>
                    </td>
                    <td>Language 3</td>
                    <td><select class="form-control" name="Language3">
                            <option value=""></option>
                            <option value="1" <?php if (odbc_result($rs, 'language 2')==1) echo ' selected';?>>Hindi</option>
                            <option value="2" <?php if (odbc_result($rs, 'language 2')==2) echo ' selected';?>>Tamil</option>
                            <option value="3" <?php if (odbc_result($rs, 'language 2')==3) echo ' selected';?>>Sanskrit</option>
                            <option value="4" <?php if (odbc_result($rs, 'language 2')==4) echo ' selected';?>>Kannada</option>
                            </select>
                    </td>
		</tr>
		<tr>
                    <td>Curriculum Interested</td>
                    <td>
                        <?php
                            $Cur1 = odbc_exec($conn, "SELECT [Code] FROM [Curriculum] WHERE [Company Name]='$ms'");
                        ?>
                        <select style="background-color: #ffff00;" class="form-control" name="CurriculumInterested" required >
                            <option value=""></option>
                            <?php
                                while(odbc_fetch_array($Cur1)) {
                            ?>
                            <option value="<?php echo odbc_result($Cur1, "Code");?>"
                            <?php
                                if (odbc_result($Cur1, "Code") == odbc_result($rs, 'Curriculum Intrested')) echo ' selected'
                                ?>><?php echo odbc_result($Cur1, "Code"); ?></option>
                            <?php
                                }
                            ?>
                        </select>
                    </td>
                    <td>Citizenship</td>
                    <td>
                        <select  class="form-control" name="Citizenship">
                            <option value=""></option>
                            <?php
                                $StuCit1 = odbc_exec($conn, "SELECT [Code] FROM [Citizenship]");
                                while(odbc_fetch_array($StuCit1)){
                            ?>
                            <option value="<?php echo odbc_result($StuCit1, "Code");?>"
                            <?php
                                if(odbc_result($StuCit1, "Code") == odbc_result($rs, 'Citizenship')) echo " selected";
                            ?>
                            ><?php echo odbc_result($StuCit1, "Code");?></option>
                            <?php
                                }
                            ?>
                        </select>
                    </td>
                    
		</tr>
		<tr>
                    <td>Stream</td>
                    <td>
                        <select name="Stream" class="form-control unknown" id="Stream" disabled="true">
                            <option value="0" <?php if(odbc_result($rs, 'Stream') == 0) echo " selected" ?>></option>
                            <option value="1" <?php if(odbc_result($rs, 'Stream') == 1) echo " selected" ?>>Science</option>
                            <option value="2" <?php if(odbc_result($rs, 'Stream') == 2) echo " selected" ?>>Science Non-Medical</option>
                            <option value="3" <?php if(odbc_result($rs, 'Stream') == 3) echo " selected" ?>>Science Medical</option>
                            <option value="4" <?php if(odbc_result($rs, 'Stream') == 4) echo " selected" ?>>Commerce</option>
                            <option value="5" <?php if(odbc_result($rs, 'Stream') == 5) echo " selected" ?>>Arts</option>
                        </select>
                    </td>
                    <td>Remarks</td>
                    <td><input type="text" maxlength="50" value="<?php echo odbc_result($rs, 'Remarks'); ?>" class="form-control" name="Remarks" /></td>
		</tr>
		
		
                <tr>
               
                    <td>Fee Classification</td>
                    <td>
			<input type="text" class="form-control unknown" required style="background-color: #ffff00;" name="FeeClassification" value="GENERAL" readonly="true">
                    </td>
                    <td></td>
                    <td></td>
                </tr>
                <tr></tr>
                <tr></tr>
	</table>
	</div>
<!--script>
function getXMLHTTP() { //fuction to return the xml http object
 var xmlhttp=false;           
   try{
   xmlhttp=new XMLHttpRequest();
     }
     catch(e){                              
    try{                                         
     xmlhttp= new ActiveXObject("Microsoft.XMLHTTP");
     }
     catch(e){
     try{
     xmlhttp = new ActiveXObject("Msxml2.XMLHTTP");
       }
      catch(e1){
      xmlhttp=false;
        }
      }
   }
                                                
     return xmlhttp;
    }
                

        
       function getAcadmic() {
      var Acadmic1 = document.getElementById('meetingPlace').value
      var cls1 = document.getElementById('class').value
      var strURL = "AdmFees.php?cls="+cls1+"&AYear="+Acadmic1;
    //  var strURL1 = "AdmDisc.php?cls="+cls1+"&AYear="+Acadmic1;
      
      var req = getXMLHTTP();
      if (req) {
      req.onreadystatechange = function() {
      if (req.readyState == 4) {
      // only if "OK"
                                                                                
      if (req.status == 200) {
                                                                                                
        document.getElementById('results').innerHTML=req.responseText;                                                                                                
        } else {
          alert("There was a problem while using XMLHTTP:\n" + req.statusText);
            }
             }                                                              
      }                    
      // alert(strURL1);
       alert(strURL);
       req.open("GET", strURL, true);
     // req.open("GET", strURL1, true);
        req.send(null);
        }                              
                }
		                
		function getClass()
		{    
		//alert(subid);
		var Acadmic1 = document.getElementById('meetingPlace').value
		var cls1 = document.getElementById('class').value
		var strURL = "AdmFees.php?cls="+cls1+"&AYear="+Acadmic1;
		//var strURL1 = "AdmDisc.php?cls="+cls1+"&AYear="+Acadmic1;
		alert(strURL);
		
		    var req = getXMLHTTP();
		    if (req)
		    {    req.onreadystatechange = function()
		        {    if (req.readyState == 4)
		            {    if (req.status == 200)
		                {    document.getElementById('results').innerHTML=req.responseText;    }
		                else
		                {    alert("There was a problem while using XMLHTTP:\n" + req.statusText);    }
		            }                
		        }            
		        req.open("GET", strURL, true);
		        req.send(null);
		    }
		}



	function getAcadmicDiscount() {
	    var Acadmic = document.getElementById('meetingPlace').value
	    var cls = document.getElementById('class').value
	    var strURL = "AdmDisc.php?cls="+cls+"&AYear="+Acadmic;
	 
	    
	    var req = getXMLHTTP();
	    if (req) {
	    req.onreadystatechange = function() {
	    if (req.readyState == 4) {
	    // only if "OK"
	                                                                              
	    if (req.status == 200) {
	                                                                                              
	      document.getElementById('results2').innerHTML=req.responseText;                                                                                                
	      } else {
	        alert("There was a problem while using XMLHTTP:\n" + req.statusText);
	          }
	           }                                                              
	    }                    
	    // alert(strURL1);
	     alert(strURL);
	     req.open("GET", strURL, true);
	     req.send(null);
	      }                              
	              }
		                
		function getClassDiscount()
		{    
		//alert(subid);
		var Acadmic = document.getElementById('meetingPlace').value
		var cls = document.getElementById('class').value
		var strURL = "AdmDisc.php?cls="+cls+"&AYear="+Acadmic;
	    alert(strURL);
		
		    var req = getXMLHTTP();
		    if (req)
		    {    req.onreadystatechange = function()
		        {    if (req.readyState == 4)
		            {    if (req.status == 200)
		                {    document.getElementById('results2').innerHTML=req.responseText;    }
		                else
		                {    alert("There was a problem while using XMLHTTP:\n" + req.statusText);    }
		            }                
		        }            
		        req.open("GET", strURL, true);
		        req.send(null);
		    }
		}
		
	

</script-->

 <!--script src="http://ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script-->
    <!--script>
      function makeAjaxRequest(opts){
        $.ajax({
          type: "POST",
          data: { opts: opts },
          url: "AdmFees.php",
          success: function(data) {
            $("#results").html(data);
          }
        });
      }

      $("#meetingPlace").on("change", function(){
        var selected = $(this).val();
        makeAjaxRequest(selected);
      });


    //class
      function AjaxRequest(cls){
          $.ajax({
            type: "POST",
            data: { cls: cls },
            url: "AdmFees.php",
            success: function(res) {
              $("#results").html(" " + res + "");
            }
          });
        }

        $("#class").on("change", function(){
          var selected = $(this).val();
          AjaxRequest(selected);
        });
      
    </script-->
    
    
    
  
