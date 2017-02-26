<?php require_once("SetupLeft.php");?>
  
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

<script>
$(function() {

	  $("#date1").datepicker({ minDate: 0,});
		$("#dt1").datepicker({ 
			//minDate: "<--?php echo date('d/M/Y', strtotime(odbc_result($Student, "Date of Birth")))?>", 
			minDate:0,
			//maxDate: 0, 
			changeMonth: true, 
			changeYear: true
		});
  
  });
  </script>
  
 <?php
$Company = odbc_exec($conn, "SELECT * FROM [RegFormToDate] WHERE [Company Name]= '$CompName' ") or exit(odbc_errormsg($conn));
while(odbc_fetch_array($Company))
 if(odbc_result($Company, "Url")=="") { ?>
<h1 class="text-primary">Registration From </h1>
<form action="FormDateAdd.php">
<table class="table table-responsive">
	<tr>
	    <td>Start Date</td>
		<td>End Date</td>
		<td align="center">Active</td>
	
	</tr>
	
	<tr>
		<td><input type="text" name="startDate" id="date1" class="form-control" required></td>
		<td><input type="text" name="endDate" id="dt1" class="form-control" required></td>
		<td align="center"><input type="checkbox" name="active" checked value="1" ></td>
		<td><input type="hidden" name="Url" value="<?php echo $_SERVER['HTTP_HOST']?>/Company.php?cid=<?php echo $CompName?>" class="form-control"></td>
	</tr>
	<tr>
		<td colspan="2"><button class="btn btn-primary">Submit</button>
		</td>
	</tr>
	
</table>
</form>
 <?php }else{ 
	
?>
<h1 class="text-primary"></h1>

<table class="table table-responsive">
     <tr>
	    <td colspan="2" style="color:#7B2000;">Copy The Link to Your Website To Open in the Form</td>
	</tr>
	<tr>
	   <th>Form Url</th>
	   <td><a href="../Company.php?cid=<?php echo odbc_result($Company, "Company Name")?>&sec=<?php echo odbc_result($Company, "Security")?>"target="Starfall"><?php echo odbc_result($Company, "Url")."&sec=". odbc_result($Company, "Security");?></a></td>
	</tr>
	<tr>
	    <th>URL Status</th>
	    <td>
	      <?php if(odbc_result($Company, "Status") == 1) echo "Active";?>
	       <?php if(odbc_result($Company, "Status") == "") echo "Inactive";?>
	    </td>
	</tr>
		
	<tr>
		<th>Url Validity</th>
		<td><?php echo date('d/M/Y', odbc_result($Company, "Start Date"));?> To <?php echo date('d/M/Y', odbc_result($Company, "End Date"));?></td>
	</tr>
	<tr>
		<td><a href="FormDateEdit.php?dateid=<?php echo odbc_result($Company, "ID")?>" class="btn btn-warning">Edit </a></td>
	</tr>
	
</table>

<?php 
 }
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