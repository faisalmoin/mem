<?php
	require_once("SetupLeft.php");        
        
?>

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
<h2>New Employee Registration </h2>
<ul class="nav navbar-right panel_toolbox">
<li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>                
</ul>
<div class="clearfix"></div>
</div>
<div class="x_content">


<form action="EmployeeAdd.php" enctype="multipart/form-data" method="POST">
    
	<ul id="myTab" class="nav nav-tabs">
		<li class="active"><a href="#gen" data-toggle="tab">General</a></li>
		<li><a href="#com" data-toggle="tab">Communication</a></li>
		<li><a href="#tax" data-toggle="tab">Qualification</a></li>
		<li><a href="#efil" data-toggle="tab">Legal Details</a></li>
	</ul>

	<div id="myTabContent" class="tab-content">
		<div class="tab-pane fade in active" id="gen">
				<table class="table ">                                    
                                    <tr>
                                            <td colspan="2" style="background-color: #CEECF5; font-size: 20px; height: 50px">General Information</td>
					</tr>
                                        <tr>
						<td height="50px">Title</td>
						<td height="50px"><select name="Title" required class="form-control">
								<option value=""></option>
								<option value="1">Miss</option>
								<option value="2">Mr.</option>
                                                                <option value="3">Ms.</option>
                                                                <option value="4">Dr.</option>
                                                    </select></td>
					</tr>
					<tr>
						<td height="50px">First Name</td>
						<td height="50px"><input type="text" name="Name" required class="form-control text-uppercase" placeholder="First Name" /></td>
					</tr>
					<tr>
						<td height="50px">Middle Name</td>
						<td height="50px"><input type="text" name="MidName" class="form-control" placeholder="Middle Name" /></td>
					</tr>
					<tr>
						<td height="50px">Last Name</td>
						<td height="50px"><input type="text" name="LName" class="form-control" placeholder="Last Name" /></td>
					</tr>
                                        <tr>
					 <td height="50px">Date Of Birth</td>
					<!--td height="50px">
						<input type="text" name="DOB" class="form-control" id="date1" />
					</td-->
                                        <td height="50px" class="ss-item-required"><input type="text" name="DOB" maxlength="16" style="padding: 4px; background-color: #FFFF00; border: 0px solid #E5E4E2;" class="form-control" id="datepicker2" onchange="checkDiff(this.value)" required readonly /></td>
                                        </tr>
                                       <tr>
					<td height="50px">Gender</td>
					<td height="50px">
						<select name="Gender" style="padding: 4px; background-color: #FFFF00; border: 0px solid #E5E4E2;" class="form-control" required>
							<option value=""></option>
							<option value="1">Male</option>
							<option value="2">Female</option>
						</select>
					</td>
                                       </tr>
                                     
				
				
				<tr>
					<td height="50px">Citizenship</td>
					<td height="50px">
					<?php
						$mssql5="SELECT [Code],[ID] FROM [Citizenship]";
						$msCT1=  odbc_exec($conn, $mssql5) or die(odbc_errormsg($conn));
					?>
						<select name="Citizenship" style="padding: 4px; border: 0px solid #E5E4E2;" class="form-control" >
							<option value=""></option>
							<?php
							while(odbc_fetch_array($msCT1)){
								echo "<option value='".odbc_result($msCT1, 'ID')."'";
								if(odbc_result($msCT1, 'Code') == "INDIAN") echo " selected";
								echo ">".odbc_result($msCT1, 'Code')."</option>";
							}
							?>
						</select>
					</td>
                                </tr>
                                <tr>
                                          <td height="50px">Employment Date</td>
                                        <td height="50px"><input type="text" class="form-control" id="date2" name="empdate"/></td>
					
					
				</tr>
                                
                                <tr>
                                    
                                     <td height="50px">Employee Type</td>
                                       <td height="50px"><select name="emptype" required class="form-control">
								<option value=""></option>
								<option value="1">Full Time</option>
								<option value="2">part-time</option>
                                                                <option value="3">Contractual</option>
                                                                <option value="4">Trainees</option>
                                                                <option value="5">Contract to Hire</option>
                                                                
                                                                
                                                                 
                                                    </select></td>
                                </tr>
                                <tr>
                                        <td height="50px">Department</td>
                                        <td height="50px"><input type="text" class="form-control" id="date2" name="department"/></td>
					
                                </tr> 
                                <tr>
                                    
                                     <td height="50px">Job Title</td>
                                        <td height="50px"><input type="text" class="form-control" id="date2" name="jobtype"/></td>
                                <tr>
                                        <td height="50px">CTC</td>
                                        <td height="50px"><input type="text" class="number-only form-control" id="date2" name="ctc"/><p style="color:red; font-size: 10px;">Only Numbers</p></td>
					
                                </tr>
                                
                                  <!--tr>
                                    
                                     <td height="50px">PAN Card No_</td>
                                        <td height="50px"><input type="text" class="form-control" id="date2" name="panno"/></td>
                                  </tr>
                                  <tr>
                                        <td height="50px">Company E-Mail</td>
                                        <td height="50px"><input type="email" class="form-control" name="CompanyEmail" size="92px" maxlength="50" style="padding: 4px;" /></td>
					  
                                </tr-->
                                
                                
                                  <tr>
                                    
                                     <td height="50px">Blood Group</td>
                                        <td height="50px"><select name="Blood" required class="form-control">
								<option value=""></option>
								<option value="1">O+</option>
								<option value="2">O-</option>
                                                                <option value="3">A+</option>
								<option value="4">A-</option>
                                                                <option value="5">B+</option>
								<option value="6">B-</option>
                                                                <option value="7">AB+</option>
								<option value="8">AB-</option>
                                                    </select></td>
                                  </tr>
                                  
                                  	<tr>
						<td height="50px">Teaching / Non Teaching</td>
						<td height="50px"><select name="Teaching" required class="form-control">
								<option value=""></option>
								<option value="1">Teaching</option>
								<option value="0">Non Teaching</option>
                                                    </select></td>
					</tr>
                                        <tr>
					<td height="50px">Company Email ID</td>
                                        <td height="50px"><input type="email" class="form-control" name="CompanyEmail" size="92px" maxlength="50" style="padding: 4px;" /></td>
				</tr>
					
				</table>
			
		</div>
            <!---------first page end---------->
		<div class="tab-pane fade" id="com">
				<table class="table table-responsive">
                                    <tr>
                                            <td colspan="2" style="background-color: #CEECF5; font-size: 20px; height: 50px">Communication Details</td>
					</tr>
					<tr>
					<td height="50px">Address</td>
					<td height="50px"><input type="text" placeholder="Address 1" name="Address1" id="Addressee" size="92" class="form-control" required="true" /></td>
				</tr>
				<tr>
					<td height="50px">Address</td>
					<td height="50px"><input type="text" placeholder="Address 2" name="Address2" size="92" class="form-control" /></td>
				</tr>
				
				<tr><td height="50px">Post Code</td>
                                <td height="50px">
                                <input type="text" name="PostCode" maxlength="6" class="form-control" style="padding: 4px;background-color: #ffff00" id="postcode" class="isNumeric" maxlength="6" onblur="if(this.value.length < 6){alert('Post Code must be 6 digit ...');}" onchange="updateCityState()" />
				</td>
                                </tr>
                                <tr>
				<td height="50px">State</td>
				<td height="50px"><input type="text" name="State" style="padding: 4px;" id="state" maxlength="10" class="form-control" /></td>
				</tr>
				<tr>
					<td height="50px">Country</td>
                                        <td height="50px"><input type="text" name="Country" id="country" maxlength="10" style="padding: 4px;" class="form-control"/></td>
                                </tr>
                                <tr>
                                        <td height="50px">City</td>
                                        <td height="50px"><input type="text" name="City" id="city" maxlength="30" style="padding: 4px;" class="form-control"/></td>
					
				</tr>
				<tr>
					<td height="50px">Phone No. (Landline)</td>
                                        <td height="50px"><input type="tel" maxlength="15" class="number-only form-control" name="Landline" style="padding: 4px;"/></td>
                                </tr>
                                <tr>
                                        <td height="50px">Mobile No.</td> 
                                        <td height="50px"><input type="text" class="number-only form-control" name="Mobile" maxlength="10" style="padding: 4px;" onblur="if(this.value.length < 10){alert('Mobile number should not be less than 10 digit ...');}" /></td>
				</tr>
				<tr>
					<td height="50px">Email</td>
                                        <td height="50px"><input type="email" class="form-control" name="Email" size="92px" maxlength="50" style="padding: 4px;" /></td>
				</tr>
                               
				</table>
			
		</div>
		<div class="tab-pane fade" id="tax"> 
				<table class="table table-responsive">
					<tr>
                                            <td colspan="2" style="background-color: #CEECF5; font-size: 20px; height: 50px">Qualification Details</td>
					</tr>
					<tr>
						<td height="50px">Highest Qualification</td>
						<td height="50px"><select name="Qualification" required class="form-control">
								<option value=""></option>
								<option value="1">Diploma</option>
								<option value="2">Graduate</option>
                                                               <option value="3">Ph.D</option>
                                                                <option value="4">Professional Degree</option>
								<option value="5">Post Graduate</option>
                                                                <option value="6">Under Graduate</option>
                                                                <option value="7">Post Graduate Diploma</option>
                                                                <option value="8">Non Graduate</option>
                                                                 <option value="9">Other</option>
                                                    </select></td>
					</tr>
					<tr>
						<td height="50px">Degree</td>
						<td height="50px"><input type="text" name="Degree"  class="form-control" /></td>
					</tr>
					<!--tr>
						<td>Specialization</td>
						
                                                    <td><input type="text" name="LSTNo"  class="form-control" /></td>
					</tr-->
					<tr>
						<td height="50px">Institute/University</td>
						<td height="50px"><input type="text" name="University"  class="form-control" /></td>
					</tr>
                                        <tr><td height="50px">Post Code</td>
                                        <td height="50px">
                                        <input type="text" name="PostCode1" maxlength="6" class="form-control" style="padding: 4px;background-color: #ffff00" id="postcode1" class="isNumeric" maxlength="6" onblur="if(this.value.length < 6){alert('Post Code must be 6 digit ...');}" onchange="updateCityState1()" />
                                        </td>
                                        </tr>
					<tr>
						<td height="50px">Country</td>
                                                <td height="50px"><input type="text" id="country1" name="Country1"  class="form-control" /></td>
					</tr>
					<tr>
						<td height="50px">State</td>
                                                <td height="50px"><input type="text" id="state1" name="State1"  class="form-control" /></td>
					</tr>
					<tr>
						<td height="50px">City</td>
						<td height="50px"><input type="text" id="city1" name="City1" class="form-control" /></td>
					</tr>
					<!--tr>
						<td style="background-color: #E5E4E2; height: 50px" colspan="2"><strong>Income Tax</strong></td>
					</tr-->
					<tr>
						<td height="50px">Passing Year</td>
                                                
						<td height="50px"><input type="text" name="Passingyear" class="form-control" id="date5" /></td>
					</tr>
                                        <tr>
						<td height="50px">B_ED</td>
                                                
                                                <td height="50px"><input type="checkbox" name="B_ED" value="1"/></td>
					</tr>
				
					
				</table>
			
		</div>
		<div class="tab-pane fade" id="efil">
				<table class="table table-responsive">
				 <tr>
                                            <td colspan="2" style="background-color: #CEECF5; font-size: 20px; height: 50px">Legal Documents</td>
					</tr>
                                    <tr> 
                                         <td height="50px">Passport Size Photo</td>
                                       <td height="50px"><input type="file" name="fileToUpload[]" id="fileToUpload">
							<!--small>File Size <= 300KB</small-->
						</td>
                                        
                                </tr>	
                                   
					<tr>
						<td height="50px">PAN No.</td>
						 <td height="50px"><input type="file" name="fileToUpload[]" id="fileToUpload">
							<!--small>File Size <= 300KB</small-->
						</td>
					</tr>
					<tr>
						<td height="50px">Aadhar No </td>
						 <td height="50px"><input type="file" name="fileToUpload[]" id="fileToUpload">
							<!--small>File Size <= 300KB</small-->
						</td>
					</tr>
                                        
                                        <tr>
						<td height="50px">Apointment letter </td>
						 <td height="50px"><input type="file" name="fileToUpload[]" id="fileToUpload">
							<!--small>File Size <= 300KB</small-->
						</td>
					</tr>
                                        <tr>
						<td height="50px">Highest Qualification Certificate</td>
						 <td height="50px"><input type="file" name="fileToUpload[]" id="fileToUpload">
							<!--small>File Size <= 300KB</small-->
						</td>
					</tr>
                                       
                                        <tr>
						<td height="50px"> Previous Employment Certificate</td>
						 <td height="50px"><input type="file" name="fileToUpload[]" id="fileToUpload">
							<!--small>File Size <= 300KB</small-->
						</td>
					</tr>
                                         <tr>
						<td height="50px">DOB Certificate</td>
						 <td height="50px"><input type="file" name="fileToUpload[]" id="fileToUpload">
							<!--small>File Size <= 300KB</small-->
						</td>
					</tr>
                                          <tr>
						<td height="50px">Voter Id</td>
						 <td height="50px"><input type="file" name="fileToUpload[]" id="fileToUpload">
							<!--small>File Size <= 300KB</small-->
						</td>
					</tr>
                                          <tr>
						<td height="50px">Passport</td>
						 <td height="50px"><input type="file" name="fileToUpload[]" id="fileToUpload">
							<!--small>File Size <= 300KB</small-->
						</td>
					</tr>
					
				</table>
                     
                    <td height="50px"><input type="hidden" class="form-control" value="<?php echo $CompName; ?>" name="companyname"/></td>
				
			</div>			
		<br />
		<button type="submit" class="btn btn-success">Register</button>
	</div>
	
</form>

</div>
</div>
</div>
</div>
</div>
</div>
</div> 


<!-- jQuery -->
<script src="../vendors/jquery/dist/jquery.min.js"></script>
<script src="../vendors/jquery/dist/jquery-ui.js"></script>
<!-- Bootstrap -->
<script src="../vendors/bootstrap/dist/js/bootstrap.min.js"></script>
<!-- FastClick -->
<script src="../vendors/fastclick/lib/fastclick.js"></script>
<!-- NProgress -->
<script src="../vendors/nprogress/nprogress.js"></script>
<!-- iCheck -->
<script src="../vendors/iCheck/icheck.min.js"></script>
<!-- Datatables -->
<script src="../vendors/datatables.net/js/jquery.dataTables.min.js"></script>
<script src="../vendors/datatables.net-bs/js/dataTables.bootstrap.min.js"></script>
<script src="../vendors/datatables.net-buttons/js/dataTables.buttons.min.js"></script>
<script src="../vendors/datatables.net-buttons-bs/js/buttons.bootstrap.min.js"></script>
<script src="../vendors/datatables.net-buttons/js/buttons.flash.min.js"></script>
<script src="../vendors/datatables.net-buttons/js/buttons.html5.min.js"></script>
<script src="../vendors/datatables.net-buttons/js/buttons.print.min.js"></script>
<script src="../vendors/datatables.net-fixedheader/js/dataTables.fixedHeader.min.js"></script>
<script src="../vendors/datatables.net-keytable/js/dataTables.keyTable.min.js"></script>
<script src="../vendors/datatables.net-responsive/js/dataTables.responsive.min.js"></script>
<script src="../vendors/datatables.net-responsive-bs/js/responsive.bootstrap.js"></script>
<script src="../vendors/datatables.net-scroller/js/datatables.scroller.min.js"></script>
<script src="../vendors/jszip/dist/jszip.min.js"></script>
<script src="../vendors/pdfmake/build/pdfmake.min.js"></script>
<script src="../vendors/pdfmake/build/vfs_fonts.js"></script>

<!-- Custom Theme Scripts -->
<script src="../build/js/custom.min.js"></script>

<!-- Datatables -->
<script>
  $(document).ready(function() {
    $('#datatable-responsive').DataTable({
          fixedHeader: true
      });
    $('#datatable').dataTable();
  });
</script>
<!-- /Datatables -->

<?php
	require_once("SetupRight.php");
	require_once("ValidationEmployee.php");
?>

<script>
    $(function() {

   /* $("#date1").datepicker({ 
                      changeMonth: true, 
          changeYear: true,
                      showButtonPanel: true,
                      yearRange: "1950:2016"
                      });*/
                      
                        $("#date2").datepicker({ 
                      changeMonth: true, 
                      maxDate:0,
          changeYear: true,
                      showButtonPanel: true,
                      yearRange: "1950:2016"
                      });
                      
                        $("#date3").datepicker({ 
                      changeMonth: true, 
          changeYear: true,
                      yearRange: "1950:2016"
                      });
                        $("#date4").datepicker({ 
                      changeMonth: true, 
          changeYear: true,
                      yearRange: "1950:2016"
                      });
                       $("#date5").datepicker({ 
                      changeMonth: true, 
          changeYear: true,
                      yearRange: "1950:2016"
                      });
                      
    $("#dt1").datepicker({ 
      //minDate: "<--?php echo date('d/M/Y', strtotime(odbc_result($Student, "Date of Birth")))?>", 
      minDate:0,
      //maxDate: 0, 
      changeMonth: true, 
      changeYear: true
    });
  
  });
    
    // Ajax for City & Country on PIN Code
    var ajax = getHTTPObject();

    function getHTTPObject()
    {
            var xmlhttp;
            if (window.XMLHttpRequest) {
              // code for IE7+, Firefox, Chrome, Opera, Safari
              xmlhttp=new XMLHttpRequest();
            } else if (window.ActiveXObject) {
              // code for IE6, IE5
              xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
            } else {
              //alert("Your browser does not support XMLHTTP!");
            }
            return xmlhttp;
    }
//Communication Post Code
    function updateCityState()
    {
            if (ajax)
            {
                    var zipValue = document.getElementById("postcode").value;
                    if(zipValue)
                    {
                            var url = "get_city_state.php";
                            var param = "?zip=" + escape(zipValue);

                            ajax.open("GET", url + param, true);
                            ajax.onreadystatechange = handleAjax;
                            ajax.send(null);
                    }
            }
    }
    
    function handleAjax()
    {
            if (ajax.readyState == 4)
            {
                    citystatearr = ajax.responseText.split(",");

                    var city = document.getElementById('city');
                    var state = document.getElementById('state');

                    city.value = citystatearr[0];
                    state.value = citystatearr[1];
                    country.value = citystatearr[2];
            }
    }
    //Father Postcode
    function updateCityState1()
    {
            if (ajax)
            {
                    var zipValue = document.getElementById("postcode1").value;
                    if(zipValue)
                    {
                            var url1 = "get_city_state1.php";
                            var param = "?zip1=" + escape(zipValue);

                            ajax.open("GET", url1 + param, true);
                            ajax.onreadystatechange = handleAjax1;
                            ajax.send(null);
                    }
            }
    }
    
    function handleAjax1()
    {
            if (ajax.readyState == 4)
            {
                    citystatearr1 = ajax.responseText.split(",");

                    var city1 = document.getElementById('city1');
                    var state1 = document.getElementById('state1');
                    var country1 = document.getElementById('country1');

                    city1.value = citystatearr1[0];
                    state1.value = citystatearr1[1];
                    country1.value = citystatearr1[2];
            }
    }
    


    // End of Get City State
    //  change language
   $(function(){
    $('select').change(function() {            
            var selections = [];
            $('#select1 option:selected').each(function(){
                    if($(this).val())
                        selections.push($(this).val());
                }
            )
            $('#select2 option:selected').each(function(){
                    if($(this).val())
                        selections.push($(this).val());
                }
            )
            //console.log(selections );
            $('#select2 option').each(function() {
                $(this).attr('disabled', $.inArray($(this).val(),selections)>-1 && !$(this).is(":selected"));
            });
            $('#select1 option').each(function() {
                $(this).attr('disabled', $.inArray($(this).val(),selections)>-1 && !$(this).is(":selected"));
            });
        });
        });
        
          jQuery(document).ready(function($) {
          $('.number-only').keypress(function(evt) {
            var charCode = (evt.which) ? evt.which : event.keyCode;

            if (charCode != 46 && charCode > 31 && (charCode < 48 || charCode > 57)){
              return false;
            }

            return true;
        });
   
   });
    
    
</script>
