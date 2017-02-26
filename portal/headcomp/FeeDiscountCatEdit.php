<?php
	require_once("SetupLeft.php");
?>

<script type='text/javascript'>//<![CDATA[
window.onload=function(){
$(document).ready(function(){
	cnt = 2;
	$(".addCF").click(function(){
		$("#customFields").append('<tr><td>'+ cnt +'</td><td><input type="text" name="Code[]" maxlength="10" style="width: 200px" class="form-control" /></td><td><input type="text" name="Description[]" maxlength="20" style="width: 200px" class="form-control" /></td><td><a href="javascript:void(0);" class="remCF">Remove</a></td></tr>');
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
<li><a href="FeeDiscountCatNew.php" title="Create New ..."><img src="../img/btn-create.png" id="btn-create" width="30px" alt="Create New"></a></li>
</ul>
<div class="clearfix"></div>
</div>
<div class="x_content">

<form action="FeeDiscountCatEditadd.php" method="post">
			<?php
		$i=1;
		$rs = odbc_exec($conn, "SELECT * FROM [Discount Fee Header] WHERE [ID]='".$_REQUEST[Id]."' AND [Company Name]='$CompName'");
		while(odbc_fetch_array($rs)){
	?>
<table class="table table-responsive" id="customFields">
	<tr>
            <td colspan="1">Code</td>
		<td colspan="1">Academic Year</td>
		<td colspan="1">Curriculum</td>
		
	</tr>
	<tr>
            <td colspan="1">
             <input type="text" value="<?php echo odbc_result($rs, "No_")?>" name="No_" maxlength="10" style="width: 200px" class="form-control" readonly />
            </td>
		
            <td colspan="1">
                   
			<?php 
                       
			$mssql1 = "SELECT DISTINCT([Code]) FROM [Academic Year] WHERE [Company Name]='$CompName'";
                            $msAY1=odbc_exec($conn, $mssql1) or die(odbc_errormsg());
				?>
				<select name="Academic" class="form-control">
				<option value="<?php echo odbc_result($rs, "Academic Year");?>"></option>
                                <?php while(odbc_fetch_array($msAY1)){
		         echo "<option value='".odbc_result($msAY1, "Code")."'";
		         if(odbc_result($msAY1, "Code") == odbc_result($rs, "Academic Year") ){echo " selected";}
		         echo ">".odbc_result($msAY1, "Code")."</option>";
				 }?>
			
		<!--input type="text" value="<--?php echo odbc_result($rs, "Academic Year")?>" name="Academic" maxlength="20" style="width: 200px" class="form-control" readonly /-->
			
		</td>
		<td colspan="1">
                    
                    
			<?php 
                       
			$mssql = "SELECT DISTINCT([Curriculum]) FROM [class section] WHERE [Company Name]='$CompName'";
                            $msAY=odbc_exec($conn, $mssql) or die(odbc_errormsg());
				?>
				<select name="Curriculum" class="form-control">
				<option value="<?php echo odbc_result($rs, "Curriculum");?>"></option>
                                <?php while(odbc_fetch_array($msAY)){
		         echo "<option value='".odbc_result($msAY, "Curriculum")."'";
		         if(odbc_result($msAY, "Curriculum") == odbc_result($rs, "Curriculum") ){echo " selected";}
		         echo ">".odbc_result($msAY, "Curriculum")."</option>";
				 }?>
			<!--input type="text" value="<--?php echo odbc_result($rs, "Curriculum")?>" name="Curriculum" maxlength="20" style="width: 200px" class="form-control" readonly /-->
		</td>
		
               
              
	</tr>
	<tr>	
		
		<td>Class</td>
		<td>Description</td>
		<td></td>
	</tr>
	<tr>
            <td>
			<?php 
                       
			$mssql2 = "SELECT DISTINCT([Class]) FROM [class section] WHERE [Curriculum]='".odbc_result($rs, "Curriculum")."' AND [Company Name]='$CompName' ";	
                            $msAY2=odbc_exec($conn, $mssql2) or die(odbc_errormsg());
				?>
				<select name="Class" class="form-control">
				<option value="<?php echo odbc_result($rs, "Class");?>"></option>
                                 <option value="">All Class</option>
				<?php while(odbc_fetch_array($msAY2)){
		         echo "<option value='".odbc_result($msAY2, "Class")."'";
		         if(odbc_result($msAY2, "Class") == odbc_result($rs, "Class") ){echo " selected";}
		         echo ">".odbc_result($msAY2, "Class")."</option>";
				 }?>
				</select>
			</td>
                
		<?php
			$get = odbc_exec($conn, "SELECT [ID], [Description] FROM [Fee Classification] WHERE [Code]='".odbc_result($rs, "Fee Clasification Code")."' AND [Company name]='$CompName'");
			
		?>
		<td><input type="text" value="<?php echo odbc_result($get, "Description");?>" name="Description" style="width: 200px" class="form-control" readonly required /></td>
		<!--td><a href="javascript:void(0);" class="addCF">Add More</a></td-->
	</tr>
</table>
<?php }?>
<input type="hidden" value="<?php echo odbc_result($get, "ID");?>" name="Id" />
<input type="hidden" value="<?php echo odbc_result($rs, "ID");?>" name="ClsId" />

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