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
<h2>Payment Method </h2>
<ul class="nav navbar-right panel_toolbox">
<li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
</ul>
<div class="clearfix"></div>
</div>
<div class="x_content">

<script type='text/javascript'>//<![CDATA[
window.onload=function(){
$(document).ready(function(){
	cnt = 2;
	$(".addCF").click(function(){
		$("#customFields").append('<tr><td>'+ cnt +'</td><td><input type="text" name="Code[]" maxlength="10" class="form-control" required></td><td><input type="text" name="Description[]" maxlength="10" class="form-control" required></td><td><a href="javascript:void(0);" class="remCF">Remove</a></td></tr>');
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
			$rs = odbc_exec($conn, "SELECT * FROM [Payment Method] WHERE [ID]='{$_GET['PaymentId']}' ORDER BY [Code]") or exit(odbc_errormsg($conn));
			while(odbc_fetch_array($rs))
		?>
<form action="FeePaymentEditAdd.php" method="post">
<h1 class="text-primary">Payment Method</h1>
<table class="table table-responsive" id="customFields">
	<tr>
		
		<td>Code</td>
		<td>Description</td>
		
	</tr>
	<tr>
		
		<td><input type="text" name="Code" value="<?php echo odbc_result($rs, "Code");?>" maxlength="10" class="form-control" required Readonly></td>
		<td><input type="text" name="Description" value="<?php echo odbc_result($rs, "Description");?>" maxlength="10" class="form-control" required></td>
		
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

<?php require_once("SetupRight.php"); ?>

