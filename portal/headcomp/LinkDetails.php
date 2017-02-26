<?php require_once("SetupLeft.php");
$Company = odbc_exec($conn, "SELECT * FROM [RegFormToDate] WHERE [Company Name]= '$CompName' ") or exit(odbc_errormsg($conn));
while(odbc_fetch_array($Company))	
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

<h1 class="text-primary">Registration From </h1>

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
		<td><a href="FormDateEdit.php?dateid=<?php echo odbc_result($Company, "ID")?>">Edit Validity Date</a></td>
	</tr>
	
</table>


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



<?php require_once("SetupRight.php");?>