<?php
	require_once("header.php");
	$id=$_REQUEST["id"];
        $_SESSION['token'] = md5(session_id() . time()); 
	$result=odbc_exec($conn, "SELECT * FROM [Temp Application] WHERE [Enquiry No_]='$id' AND [Company Name]='$ms'");
	odbc_fetch_array($result);
	
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
<h2>Registration Confirmation </h2> <!-- Page Name -->
<ul class="nav navbar-right panel_toolbox">
<li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
</ul>
<div class="clearfix"></div>
</div>
<div class="x_content">
<!-- Content -->

		<form action="AddRegistrationConfirm.php" method="POST" onkeypress="return event.keyCode != 13;">
		<table width="50%" border="0px" align="center">
		    <input type="hidden" name="token" value="<?php echo $_SESSION['token'] ?>" />	
            <tr>
				<td height="40px">Registraion No</td>
				<td><input type="text" class="form-control" readonly="true" name="RegistrationNo" value="<?php echo odbc_result($result, 'No_')?>" style="padding: 4px;" size="30px" /></td>
			</tr>
			<tr>
				<td height="40px">Candidate Name</td>
				<td><input type="text" class="form-control" readonly="true" name="Student" value="<?php echo odbc_result($result, 'Name')?>" style="padding: 4px;" size="30px" /></td>
			</tr>
			<tr>
				<td height="40px">Class Applied</td>
				<td><input type="text" class="form-control" readonly="true" name="ClassApplied" value="<?php echo odbc_result($result, 'Class')?>" style="padding: 4px;" size="30px" /></td>
			</tr>
			<tr>
				<td height="40px" >Date of Received</td>
				<td class="ss-item-required">
					<input type="text" class="form-control" name="ReceivedDate" id="rcvDT" style="padding: 4px;background-color: #FFFF00;border: 1px solid #000000;" size="30px; background-color: #FFFF00" required readonly />
				</td>
			</tr>
			<tr>
				<td height="40px">Registration Form No</td>
				<td><input type="text" class="form-control" readonly="true" name="RegistrationFormNo" value="<?php echo odbc_result($result, 'Registration No_')?>" style="padding: 4px;" size="30px" /></td>
			</tr>
			<tr>
				<td height="40px">Registration Status</td>
				<td><input type="text" class="form-control" readonly="true" name="RegistrationStatus" value="<?php
                        if(odbc_result($result, 'Registration Status') == 1) echo "SOLD";
                        if(odbc_result($result, "Registration Status")==2) echo "RECEIVED";
                        if(odbc_result($result, "Registration Status")==3) echo "SELECTED";
                        if(odbc_result($result, "Registration Status")==4) echo "PENDING APPROVAL";
                        if(odbc_result($result, "Registration Status")==5) echo "APPROVED";
                        if(odbc_result($result, "Registration Status")==6) echo "ADMITTED";
                    ?>" style="padding: 4px;font-weight: bold; color: #0000A0" size="23px" /></td>
			</tr>
			<tr>
				<td height="40px">Remarks</td>
				<td><input type="text" class="form-control" name="Remarks" style="padding: 4px;" size="30px" value="<?php echo odbc_result($result, 'Remarks');?>" /></td>
			</tr>
			<tr>
				<td></td>
				<td>
					<input type="hidden" value="<?php echo odbc_result($result, 'Enquiry No_')?>" name="id" />
					<button type='submit' class='btn btn-primary' onclick="formcheck();">Recieved</button>
				</td>
			</tr>
		</table>
		</form>

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


<script type="text/javascript" charset="utf-8">
    $(function()
	{
             $("#rcvDT").datepicker({minDate: "<?php echo date('d/M/Y', strtotime(odbc_result($result, "Date of Sale")))?>",maxDate: 0});
		//$("#rcvDT").datepicker({ minDate: "<?php echo date('d-m-Y', strtotime(odbc_result($result, 'Date of Sale')));?>", maxDate: 0 });
               // $("#rcvDT").datepicker({minDate: -15, maxDate: 0 });
	});
	
	function popitup(url) {
		newwindow=window.open(url,'name','height=430,width=700');
		if (window.focus) {newwindow.focus()}
		return false;
	}
    function formcheck() {
        var fields = $(".ss-item-required")
            .find("select, textarea, input").serializeArray();

        $.each(fields, function(i, field) {
            if (!field.value){
                alert(field.name + ' is required');
                return false;
            }
        });
        console.log(fields);
    }
</script>

<?php
	require_once("../footer.php");
?>