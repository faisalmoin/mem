<?php
	require_once("SetupLeft.php");
?>

<script type='text/javascript'>//<![CDATA[
window.onload=function(){
$(document).ready(function(){
	cnt = 2;
	$(".addCF").click(function(){
		$("#customFields").append('<tr><td>'+ cnt +'</td><td><input type="text" class="form-control" name="Code[]" required /></td><td><input type="text" name="Description[]" class="form-control" required></td><td><a href="javascript:void(0);" class="remCF">Remove</a></td></tr>');
		document.getElementById("count").value=cnt;
		cnt++;
	});
    $("#customFields").on('click','.remCF',function(){
        $(this).parent().parent().remove();
	document.getElementById("count").value=cnt;
	cnt--;
    });
    
});
}//]]> 

</script>

<?php
		$rs = odbc_exec($conn, "SELECT * FROM [Fee Components] WHERE [ID]='{$_GET['ComponentId']}' ORDER BY [Code]") or exit(odbc_errormsg($conn));
		while(odbc_fetch_array($rs))
		
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
<h2>Fee Component </h2>
<ul class="nav navbar-right panel_toolbox">
<li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
<li><a href="FeeComponentNew.php" title="Create New ..."><img src="../img/btn-create.png" id="btn-create" width="20px" alt="Create New"></a></li>
</ul>
<div class="clearfix"></div>
</div>
<div class="x_content">

<form action="FeeComponentEditAdd.php" method="post">
<table class="table table-responsive" id="customFields">
	<tr style="font-weight: bold;">
		
		<td>Fee Code</td>
		<td>Fee Description</td>
		
	</tr>
	<tr>
		
		<td><input type="text" name="Code" value="<?php echo odbc_result($rs, "Code"); ?>" class="form-control" maxlength="10" required></td>
		<td><input type="text" name="Description" value="<?php echo odbc_result($rs, "Description"); ?>" class="form-control" maxlength="30" required></td>
		
	</tr>
</table>
<input type="hidden" value="<?php echo odbc_result($rs,"ID");?>" name="id">
<input type="hidden" value="1" name="count" id="count" />
<button type="submit" class="btn btn-success">Submit</button>
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
<!-- Bootstrap -->
<script src="../vendors/bootstrap/dist/js/bootstrap.min.js"></script>

<!-- Custom Theme Scripts -->
<script src="../build/js/custom.min.js"></script>

<?php
	require_once("SetupRight.php");
?>