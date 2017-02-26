<?php require_once("SetupLeft.php");  ?>

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
<h2>Curriculum </h2>
<ul class="nav navbar-right panel_toolbox">
<li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
</ul>
<div class="clearfix"></div>
</div>
<div class="x_content">
<form action="CurriculumAdd.php" method="post">
	<h1 class="text-primary"></h1>
	<table class="table table-responsive"  id="customFields">
		<thead>
		<tr>
			<td style="width: 10%">S/N</td>
			<td style="width: 20%">Code<sup class="text-danger">*<sup></td>
			<td style="width: 20%">Description</td>
			<td></td>
		</tr>
		</thead>
		<tr>
			<td>1</td>
			<td><input type="text" maxlength="20" style="background-color: #FFFF00" class="form-control" name="Code[]" required /></td>
			<td><input type="text" maxlength="100" style="width: 300px" class="form-control" name="Description[]"></td>
			<td><a href="javascript:void(0);" class="addCF">Add More</a></td>
		</tr>
	</table>
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

<script type='text/javascript'>//<![CDATA[
window.onload=function(){
$(document).ready(function(){
	cnt = 2;
	$(".addCF").click(function(){
		$("#customFields").append('<tr><td>'+ cnt +'</td><td><input type="text" style="background-color: #FFFF00" class="form-control" name="Code[]" required /></td><td><input type="text" name="Description[]" class="form-control" required></td><td><a href="javascript:void(0);" class="remCF">Remove</a></td></tr>');
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
<?php require_once("SetupRight.php"); ?>