<?php
   
	require_once("header.php");
	?>
	<!---------------------------------- step process-------------------- -->
	<style>
	body {
		//margin-top:40px;
	}
	.stepwizard-step p {
		margin-top: 10px;
	}
	.stepwizard-row {
		display: table-row;
	}
	.stepwizard {
		display: table;
		width: 50%;
		position: relative;
	}
	.stepwizard-step button[disabled] {
		opacity: 1 !important;
		filter: alpha(opacity=100) !important;
	}
	.stepwizard-row:before {
		top: 14px;
		bottom: 0;
		position: absolute;
		content: " ";
		width: 100%;
		height: 1px;
		background-color: #ccc;
		z-order: 0;
	}
	.stepwizard-step {
		display: table-cell;
		text-align: center;
		position: relative;
	}
	.btn-circle {
		width: 30px;
		height: 30px;
		text-align: center;
		padding: 6px 0;
		font-size: 12px;
		line-height: 1.428571429;
		border-radius: 15px;
	}
	</style>
	<?php
	//echo "<br /><br /><br />";
	//print_r($_POST);
	/*
	$id=$_REQUEST['id']; //Enquiry No
	$Pre_AdmNo=$_REQUEST['Pre_AdmNo'];
	$NewLine=$_REQUEST['NewLine'];
	*/
	

?>



<div class="container">	
<h1 class="text-primary">Admission<small> - Fees &#38; Discount</small></h1>
<form role="form" method="post" action="RevAdmissiondiscountEdit.php" name="AdmForm1" onkeypress="return event.keyCode != 13;">
	
	
 <!---------------------------------- step process-------------------- -->
  <!--div class="stepwizard col-md-offset-3">
    <div class="stepwizard-row setup-panel">
      <div class="stepwizard-step">
        
        <a href="#step-1" type="button" class="btn btn-default btn-circle" disabled="disabled">1</a>
        <p style="font-weight: bold; color:red;">Information</p>
      </div>
      <div class="stepwizard-step">
        <a href="#step-2" type="button" class="btn btn-primary btn-circle">2</a>
        <p style="font-weight: bold; color:red;">Fee & Discount</p>
      </div>
      
     <div class="stepwizard-step">
        <a href="#step-3" type="button" class="btn btn-default btn-circle" disabled="disabled">3</a>
        <p style="font-weight: bold; color:red;">Confirm</p>
      </div>
      
      </div>
  </div-->
  
  
   <!---------------------------------- step process-------------------- -->
  
	
	<ul class="nav nav-tabs" id="StuTab">		
		<li class="active"><a href="#StuTab2" data-toggle="tab"> General </a></li>
                <li><a href="#StuTab3" data-toggle="tab"> Fees </a></li>
		<li><a href="#StuTab4" data-toggle="tab"> Discounts </a></li>
                <li><a href="#StuTab5" data-toggle="tab"> Transport Fee </a></li>
	</ul>
	
	<div class="tab-content" id="StuTabContent">
                <div class="tab-pane face in active" id="StuTab2">
                   <?php require_once("RevStudentCard.php"); ?>
               </div> 
				
		<div class="tab-pane face in" id="StuTab3" >
			<?php require_once("REVAdmFeesEdit.php"); ?>
		</div>
		<div class="tab-pane face in" id="StuTab4">
			<?php require_once("RevAdmDiscEdit.php"); ?>
		</div>
            <div class="tab-pane face in" id="StuTab5" >
			<?php require_once("RevTransportEdit.php"); ?>
		</div>
	</div>
	
	<div>
	<button class="btn btn-primary">Submit</button>
		
	</div>
	
	</form>
</div>

<?php require_once("../footer.php"); ?>
