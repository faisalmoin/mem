<?php require_once("SetupLeft.php");
/*$FeeClasi=odbc_exec($conn, "SELECT [Code], [Description] FROM [Fee Components] WHERE [Company Name]='$CompName' ORDER BY [Description]");
	while(odbc_fetch_array($FeeClasi)){
		$fClass .= '<option value="'.odbc_result($FeeClasi, "Code").'">'.odbc_result($FeeClasi, "Description").'</option>';
	}*/
?>

<script type='text/javascript'>//<![CDATA[
window.onload=function(){
$(document).ready(function(){
	cnt = 2;
	$(".addCF").click(function(){
            
		$("#customFields").append('<tr><td>'+ cnt +'</td><td><input type="text" name="Code[]" maxlength="10" style="width: 200px" class="form-control" /></td><td><input type="text" name="Description[]" maxlength="20" style="width: 200px" class="form-control" /></td><td><a href="javascript:void(0);" class="remCF">Remove</a></td></tr>');
		
               // $("#customFields").append('<tr><td>'+ cnt +'</td><td><select name="Code[]" class="form-control" required><option value=""><?php echo $fClass; ?></option></select></td><td><input type="text" name="Description[]" maxlength="20" style="width: 200px" class="form-control" /></td><td><a href="javascript:void(0);" class="remCF">Remove</a></td></tr>');
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


        $(document).ready(function()
        {
            $("#AcadYr").change(function()
            {
                var id=$(this).val();
                var dataString = 'id='+ id +'&&comp=<?php echo $CompName?>';

                $.ajax
                ({
                    type: "POST",
                    url: "get_curr.php",
                    data: dataString,
                    cache: false,
                    success: function(html)
                    {
                        $("#Curr").html(html);
                    }
                });
            });


            $("#Curr").change(function()
            {
                var sid=$(this).val();
                var dataString = 'sid='+ sid +'&&comp=<?php echo $CompName?>';

                $.ajax
                ({
                    type: "POST",
                    url: "get_class.php",
                    data: dataString,
                    cache: false,
                    success: function(html)
                    {
                        $("#Class").html(html);
                    }
                });
            });
        });
    

</script>

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
<h2>Discount Fee Category </h2>
<ul class="nav navbar-right panel_toolbox">
<li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
</ul>
<div class="clearfix"></div>
</div>
<div class="x_content">

<form action="FeeDiscountCatAdd.php" method="post">
<table class="table table-responsive" id="customFields">
	<tr>
		<td colspan="2">Academic Year</td>
		<td colspan="1">Curriculum</td>
		<td colspan="1">Class</td>
	</tr>
	<tr>
		<td colspan="2">
			<select name="AcadYear" id="AcadYr" class="form-control" style="width: 150px" required>
			<option value=""></option>
			<?php
				$Acad = odbc_exec($conn, "SELECT DISTINCT([Code]) FROM [Academic Year] WHERE [Company Name]='$CompName'");
				while(odbc_fetch_array($Acad)){
					echo "<option value='".odbc_result($Acad, 'Code')."'>".odbc_result($Acad, 'Code')."</option>";
				}
			?>
			</select>
		</td>
		<td colspan="1">
			<select name="Curriculum" id="Curr" class="form-control" style="width: 150px" required>
			<option value=""></option>			
			</select>
		</td>
		<td colspan="1">
			<select name="Class" id="Class" class="form-control" style="width: 150px" required>
			<option value=""></option>
			</select>
		</td>
	</tr>
	<tr>	
		<td>SN</td>
		<td>Code</td>
		<td>Description</td>
		<td></td>
	</tr>
	<tr>
		<td>1</td>
                <!--td><select name="Code[]" class="form-control" required>
				<option value=""></option>
				<--?php echo $fClass?>
				
			</select></td-->
		<td><input type="text" name="Code[]" maxlength="10" style="width: 200px" class="form-control" required /></td>
		<td><input type="text" name="Description[]" maxlength="20" style="width: 200px" class="form-control" required /></td>
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

<?php require_once("SetupRight.php"); ?>