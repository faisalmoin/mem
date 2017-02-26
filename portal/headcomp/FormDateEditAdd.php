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
<h2>Online Registration From </h2>
<ul class="nav navbar-right panel_toolbox">
<li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
</ul>
<div class="clearfix"></div>
</div>
<div class="x_content">

<?php

	
		$sql_update = "UPDATE [RegFormToDate] SET 
					[Start Date]='".strtotime(str_replace("/", " ", $_REQUEST['startDate'.$i]))."',
					[End Date]='".strtotime(str_replace("/", " ", $_REQUEST['endDate'.$i]))."'
					where [ID]='".$_REQUEST['id']."' ";
		odbc_exec($conn, $sql_update) or die(odbc_errormsg($conn));
		//exit($sql_update);
	echo '<META http-equiv="refresh" content="0;URL=LinkDetails.php"> ';
?>


</div>
</div>
</div>
</div>
</div>
</div>
</div>

<!-- jQuery -->
<script src="../vendors/jquery/dist/jquery.min.js"></script>
<!-- Bootstrap -->
<script src="../vendors/bootstrap/dist/js/bootstrap.min.js"></script>

<!-- Custom Theme Scripts -->
<script src="../build/js/custom.min.js"></script>

<?php
	require_once("SetupRight.php");
?>
