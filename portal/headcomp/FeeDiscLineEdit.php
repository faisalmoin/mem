<?php
	require_once("SetupLeft.php");?>



<h1 class="text-primary">Discount Fee Structure Edit</h1>
<form action="FeeDiscLineEditAdd.php" method="post">
<?php
		$i=1;
		$rs = odbc_exec($conn, "SELECT * FROM [Discount Fee Line] WHERE [ID]='".$_REQUEST[Id]."' AND [Company Name]='$CompName' ORDER BY [Academic Year]");
		while(odbc_fetch_array($rs)){
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
<h2>Discount Fee Structure </h2>
<ul class="nav navbar-right panel_toolbox">
<li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
</ul>
<div class="clearfix"></div>
</div>
<div class="x_content">
	
<table class="table table-responsive">
	<tr>
		<td>Academic Year</td>
		<td><input type="text" class="form-control" value="<?php echo odbc_result($rs, 'Academic Year');?>" name="Academic" readonly></td>
		</tr>
		<tr>	
		<?php 
			$cls = odbc_exec($conn, "SELECT [Class] FROM [Discount Fee Header] WHERE [No_]='".odbc_result($rs, 'Document No_')."' AND [Company Name]='$CompName' ");
			
		?>
		<td>Class</td>
                <?php if(odbc_result($cls, 'Class')==""){ ?>
                <td><input type="text" class="form-control" value="All Class" name="Class" readonly></td>
                <?php } else{ ?>
                <td><input type="text" class="form-control" value="<?php echo odbc_result($cls, 'Class');?>" name="Class" readonly></td>	
                <?php }?>
                </tr>
		<tr>
		<td>Document No</td>
		<td><input type="text" class="form-control" value="<?php echo odbc_result($rs, 'Document No_');?>" name="Document" readonly></td>	
		</tr>
		<tr>
		<td>Fee Code</td>
		<td><input type="text" class="form-control" value="<?php echo odbc_result($rs, 'Fee Code');?>" name="FeeCode'" readonly></td>	
	</tr>
		<tr>
		<td>Discount %</td>
		<td><input type="text" class="form-control" value="<?php echo number_format(odbc_result($rs, 'Discount%'),2,'.',',');?>" id="desc" name="Discount" required></td>	
	</tr>
	<tr>
		<td>Description</td>
		<td><input type="text" class="form-control" value="<?php echo odbc_result($rs, 'Description');?>" name="Description" required></td>	
	</tr>
	
</table>
<?php }?>
<input type="hidden" value="<?php echo odbc_result($rs, "ID");?>" name="Id" />

<button type="submit" class="btn btn-success">Submit</button>

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
<?php require_once("SelectRight.php"); ?>