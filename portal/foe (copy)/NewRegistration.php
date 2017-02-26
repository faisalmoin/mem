<?php
	require_once("header.php");
	
	$EnqNo=$_REQUEST['EnquiryNo'];
	if($EnqNo != ""){
		$EnqCheck=odbc_exec($conn, "SELECT [id], [EnquiryNo] FROM [Temp Enquiry] WHERE [No_]='".$EnqNo."' AND [Company Name]='".$CompName."' ") or die(odbc_errormsg($conn));
		
		if(odbc_num_rows($EnqCheck)==0){
			$msg="<div class='alert alert-danger alert-error'><a href='#' class='close' data-dismiss='alert'>&times;</a><strong>Error!</strong> Enquiry No. does not exists, kindly check.</div>";
		}
		else{
			header("Location: NewRegistrationDetails.php?EnquiryNo=$EnqNo");
		}
	}
	
?>
<div class="container">	
	<ul class="nav nav-tabs" id="StuTab">
		<li class="active"><a href="#StuTab2" data-toggle="tab">New Registration</a></li>
		<li><a href="#StuTab3" data-toggle="tab">Registration Confirmation</a></li>
		<li><a href="#StuTab1" data-toggle="tab">Registration List</a></li>
	</ul>
	<div class="tab-content" id="StuTabContent">
		<div class="tab-pane face in " id="StuTab1">
			<?php require_once("RegistrationList.php") ?>
		</div>
		<div class="tab-pane face in active" id="StuTab2">
			<div class="container">
				<?php require_once("EnquiryDone.php"); ?>
			</div>
		</div>
		<div class="tab-pane face in " id="StuTab3">
			<div class="container">
				<?php require_once("RegistrationConfirmationList.php"); ?>
			</div>
		</div>
	</div>
</div>
<?php
	require_once("../footer.php");
?>