<?php

require_once("SetupLeft.php");

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
<h2>Fee Type - Add </h2> <!-- Page Name -->
<ul class="nav navbar-right panel_toolbox">
<li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
</ul>
<div class="clearfix"></div>
</div>
<div class="x_content">
<!-- Content -->

<?php
//print_r($_POST);
$count = $_REQUEST['count'];

for($i=0; $i<=$count; $i++){
	if($_REQUEST['Code'][$i] != ""){
		$Check = odbc_exec($conn, "SELECT [Code] FROM [Fee Type] WHERE [Code]='".$_REQUEST['Code'][$i]."' AND [Company Name]='$CompName'") or exit(odbc_errormsg($conn));
		if(odbc_num_rows($Check)==0){
			/*odbc_exec($conn, "INSERT INTO [Fee Type]([Code],[Description],[Start Date],[End Date],[User ID],[Portal ID],Synchronization,[Company Name],InsertStatus,UpdateStatus)
				VALUES ('".strtoupper($_REQUEST['Code'][$i])."', '".ucfirst($_REQUEST['Description'][$i])."', '".strtotime($_REQUEST["startDate"][$i])."', '".strtotime($_REQUEST["endDate"][$i])."', '$LoginID','$LoginID',0, '$CompName',0,0)") or exit(odbc_errormsg($conn));*/
			echo "INSERT INTO [Fee Type]([Code],[Description],[Start Date],[End Date],[Academic Year],[User ID],[Portal ID],Synchronization,[Company Name],InsertStatus,UpdateStatus)
				VALUES ('".strtoupper($_REQUEST['Code'][$i])."', '".ucfirst($_REQUEST['Description'][$i])."', '".strtotime(str_replace("/", " ", $_REQUEST['startDate'][$i]." 01:00:00"))."', '".strtotime(str_replace("/", " ", $_REQUEST['endDate'][$i]." 01:00:00"))."', '".$_REQUEST['AcadYear']."', '$LoginID','$LoginID',0, '$CompName',0,0)";

			//No. of months
			echo "<br /><br />".(int)abs((strtotime(str_replace("/", " ", $_REQUEST['startDate'][$i]." 01:00:00")) - strtotime(str_replace("/", " ", $_REQUEST['endDate'][$i]." 01:00:00")))/(60*60*24*30));	
		}
	}
}
  /*if(odbc_num_rows($Check)==1){
                    echo ("<SCRIPT LANGUAGE='JavaScript'>
        window.alert('Already Exists')
        window.history.go(-2);
        </SCRIPT>");
            }*/
?>
<!--meta http-equiv='refresh' content="0;URL='FeeTypeList.php'" /-->

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

<?php
	require_once("SetupRight.php"); 
?>