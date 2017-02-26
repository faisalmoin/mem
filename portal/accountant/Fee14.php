<!DOCTYPE html>
<html>
<head>
<?php require_once("header.php");
$today = strtotime(date('d M Y'));
$this_yr = strtotime(date("Y", $today)."-04-01");
$nxt_yr = strtotime((date("Y", $today)+1)."-03-31");

if($today > strtotime(date("Y", $today)."-04-01") && $today < strtotime((date("Y", $today)+1)."-03-31")){
	$FinYr = date('y', $today)."-".(date('y', $today)+1);
} else if ($today < strtotime(date("Y", $today)."-04-01")  && $today < strtotime((date("Y", $today))."-03-31")) {
        $FinYr = (date('y', $today)-1)."-".date('y', $today);
    }
?>

<style>
table {
    border-collapse: collapse;
    width: 100%;
}

th, td {
    text-align: left;
    padding: 8px;
}

tr:nth-child(even){background-color: #FBF8EF}
</style>
	<!--script type="text/javascript">
	jQuery(document).ready(function($) {

      $("#AcadYear").change(function() {
            var value = $(this).val();
            alert(value);
           
       });
       });
	</script-->
</head>


<!-- Datatables -->
<link href="../vendors/datatables.net-bs/css/dataTables.bootstrap.min.css" rel="stylesheet">
<link href="../vendors/datatables.net-buttons-bs/css/buttons.bootstrap.min.css" rel="stylesheet">
<link href="../vendors/datatables.net-fixedheader-bs/css/fixedHeader.bootstrap.min.css" rel="stylesheet">
<link href="../vendors/datatables.net-responsive-bs/css/responsive.bootstrap.min.css" rel="stylesheet">
<link href="../vendors/datatables.net-scroller-bs/css/scroller.bootstrap.min.css" rel="stylesheet">

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
<h2>School List </h2> <!-- Page Name -->
<ul class="nav navbar-right panel_toolbox">
<li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
<li class="dropdown">
<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false"><i class="fa fa-wrench"></i></a>
<ul class="dropdown-menu" role="menu">
<li><a href="#">Settings 1</a></li>
<li><a href="#">Settings 2</a></li>
</ul>
</li>
</ul>
<div class="clearfix"></div>
</div>
<div class="x_content">
<!-- Content -->

<div class = "container">
    <div class = "col-md-3" >
        <ul class = "nav nav-tabs nav-stacked affix" id = "myNav">
        <h2 style="color: #81BEF7;">Fee At a Glance</h2> 
        <!-- dropdown Start -->
	        <form action="#" method="post" name="Myform">
			<h5 style="color: #81BEF7;">Financial Year :  
			<?php $mssql1="SELECT Distinct[Academic Year] FROM [Class Fee Line] WHERE [Company Name]='".$CompName."' ORDER BY [Academic Year]" ;
			$msAY=odbc_exec($conn, $mssql1) or die(odbc_errormsg());
			?>
			<select name="AcadYear" id="AcadYear" style="padding: 4px; background-color: #FBF8EF; border: 0px solid #E5E4E2;" onchange="this.form.submit(Myform)">
			<option value="<?php echo $FinYr;?>"></option>
			<?php while(odbc_fetch_array($msAY)){
	         echo "<option value='".odbc_result($msAY, "Academic Year")."'";
	         if(odbc_result($msAY, "Academic Year") == $FinYr ){echo " selected";}
	         echo ">".odbc_result($msAY, "Academic Year")."</option>";
			 }?>
			</select>
	         </h5> 
			</form>
         <!-- dropdown End -->         
            <li><a href = "#Structure">Fee Structure</a></li>
            <li><a href = "#Type">Fee Type</a></li>
            <li><a href = "#Component">Fee Component</a></li>
            <li><a href = "#Category">Discount Fee Category</a></li>
            <li><a href = "#Payment">Payment Method</a></li>
            <li><a href = "#Discount">Discount Fee Structure</a></li>
        </ul>
    </div>
    
     <div class = "col-md-9" style="overflow-x:auto;">
         <!--form action="#" method="post" name="Myform">
				<table class="table table-responsive">
					<tr>
					
						<td style="font-weight: bold;color: #81BEF7;border:none;"></td>
                        <td style="font-weight: bold;border:none;text-align: right;" >
                        <h4>Financial Year : 
						<--?php $mssql1="SELECT Distinct[Academic Year] FROM [Class Fee Line] WHERE [Company Name]='".$CompName."' ORDER BY [Academic Year]" ;
			            $msAY=odbc_exec($conn, $mssql1) or die(odbc_errormsg());
						?>
						<select name="AcadYear" id="AcadYear" style="padding: 4px; background-color: #FBF8EF; border: 0px solid #E5E4E2;" onchange="this.form.submit(Myform)">
						<option value="<--?php echo $FinYr;?>"></option>
						<--?php while(odbc_fetch_array($msAY)){
                          echo "<option value='".odbc_result($msAY, "Academic Year")."'";
                          if(odbc_result($msAY, "Academic Year") == $FinYr ){echo " selected";}
                          echo ">".odbc_result($msAY, "Academic Year")."</option>";
						 }?>
						</select>
                        </h4>
						</td>
						
					</tr>
				</table>
			</form-->
          
          
         <h3 style="color: #000080;" id = "Structure">Fee Structure</h3>
       		
		 <?php 
         echo "</br>";
         require_once("FeeStructureList.php"); ?>
		
         <h3 style="color: #000080;" id = "Type">Fee Type</h3>
		 <?php 
		 echo "</br>";
		 require_once("FeeTypeList.php"); ?>
				
         
         <h3 style="color: #000080;" id = "Component">Fee Component</h3>
		 <?php
         echo "</br>";
         require_once("FeeComponentList.php"); ?>
         
         <h3 style="color: #000080;" id = "Category">Discount Fee Category</h3>
		 <?php 
         echo "</br>";
         require_once("FeeDiscountCatList.php"); ?>
         
         
         <h3 style="color: #000080;" id = "Payment">Payment Method</h3>
		 <?php 
         echo "</br>";
         require_once("FeePaymentList.php"); ?>
         
        
         <h3 style="color: #000080;" id = "Discount">Discount Fee Structure</h3>
		 <?php 
         echo "</br>";
         require_once("FeeDiscLineList.php"); ?>
      </div>
   </div>

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

<!-- Datatables -->
<script src="../vendors/datatables.net/js/jquery.dataTables.min.js"></script>
<script src="../vendors/datatables.net-bs/js/dataTables.bootstrap.min.js"></script>
<script src="../vendors/datatables.net-buttons/js/dataTables.buttons.min.js"></script>
<script src="../vendors/datatables.net-buttons-bs/js/buttons.bootstrap.min.js"></script>
<script src="../vendors/datatables.net-buttons/js/buttons.flash.min.js"></script>
<script src="../vendors/datatables.net-buttons/js/buttons.html5.min.js"></script>
<script src="../vendors/datatables.net-buttons/js/buttons.print.min.js"></script>
<script src="../vendors/datatables.net-fixedheader/js/dataTables.fixedHeader.min.js"></script>
<script src="../vendors/datatables.net-keytable/js/dataTables.keyTable.min.js"></script>
<script src="../vendors/datatables.net-responsive/js/dataTables.responsive.min.js"></script>
<script src="../vendors/datatables.net-responsive-bs/js/responsive.bootstrap.js"></script>
<script src="../vendors/datatables.net-scroller/js/datatables.scroller.min.js"></script>
<script src="../vendors/jszip/dist/jszip.min.js"></script>
<script src="../vendors/pdfmake/build/pdfmake.min.js"></script>
<script src="../vendors/pdfmake/build/vfs_fonts.js"></script>


<!-- Datatables -->
<script>
$(document).ready(function() {
$('#datatable').dataTable();
$('#datatable-responsive').DataTable({
fixedHeader: true
});
});
</script>
<!-- /Datatables -->

 
<script type = "text/javascript">
   $(function () {
      $('#myNav').affix({
         offset: {
            top: 60  
         }
      });
   });
</script>
<?php require_once("../footer.php");?>
</body>
</html>
