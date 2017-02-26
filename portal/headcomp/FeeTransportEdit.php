<?php
	require_once("SetupLeft.php");
	$rs = odbc_exec($conn, "SELECT * FROM [Transport Slab] WHERE [ID]='{$_GET['FeeTransportId']}'") or exit(odbc_errormsg($conn));
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
<h2>Transport Slab </h2>
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

<form action="FeeTransportEditAdd.php" method="post">
<table class="table table-container"  id="customFields">
	<tr>
		
		<th>Slab Code</th>
		<th>Slab Name</th>
		<th>Route No.</th>
		<th>Distance (KM)</th></tr>
<tr>
<td><input type="text" name="SlabCode" value="<?php echo odbc_result($rs, "Slab Code")?>" maxlength="10" class="form-control" required ></td>
		<td><input type="text" name="SlabName" value="<?php echo odbc_result($rs, "Slab Name")?>" maxlength="20" class="form-control" required ></td>
		<td><input type="text" name="SlabRoute" value="<?php echo odbc_result($rs, "Route No_"); ?>" maxlength="20" class="form-control" required ></td>
	
		 <td>	
				<select name="SlabDistance" class="form-control mySelect" required>
				<option value="<?php echo odbc_result($rs, "Distance covered");?>"></option>
				<?php for ($x = 0; $x <= 100; $x++) {
		         echo "<option value='".$x."'";
		         if($x == odbc_result($rs, "Distance covered") ){echo " selected";}
		         echo ">".$x."</option>";
				 }?>
				</select></td></tr>

		<tr>
		<th>Amount</th>
		<th>Occurence</th>
		<th>Total Amount</th>
		<th>Monthly Amount</th>
		<th></th>
		
	</tr>
	<tr>
		<td><input type="text" id="Amount" name="SlabAmount" value="<?php echo number_format(odbc_result($rs, "Amount"),2,'.', '' ); ?>" maxlength="10" class="form-control" required ></td>


		<td><select name="months" id="Months" class="form-control" onchange="calculate()" required>			
			    <option value=""></option>
			    
			    <option <?php if(odbc_result($rs, "No_ of months") == 12) { echo "selected='selected'"; } ?> value=12>Monthly</option>
			    <option <?php if(odbc_result($rs, "No_ of months") == 4) { echo "selected='selected'"; } ?> value=4>Quarterly</option>
			    <option <?php if(odbc_result($rs, "No_ of months") == 2) { echo "selected='selected'"; } ?> value=2>Half Yearly</option>
			    <option <?php if(odbc_result($rs, "No_ of months") == 1) { echo "selected='selected'"; } ?> value=1>Annually</option>
				
                            <!--?php echo $Occur?-->
			</select></td>

			<td><input type="text" id="toAmount" name="TotalAmount" value="<?php echo number_format(odbc_result($rs, "Total Amount"),2,'.', '' ); ?>" maxlength="10" class="form-control" required ></td>

			<td><input type="text" id="MonthlyAmount" name="MonthlyAmount" value="<?php echo number_format(odbc_result($rs, "Monthly Amount"),2,'.', '' ); ?>" maxlength="10" class="form-control" required ></td>

		<td></td>
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

<script type='text/javascript'>//<![CDATA[
window.onload=function(){
$(document).ready(function(){
	cnt = 2;
	$(".addCF").click(function(){
		$("#customFields").append('<tr><td>'+ cnt +'</td><td><input type="text" name="SlabCode[]" maxlength="10" class="form-control" required ></td><td><input type="text" name="SlabName[]"  maxlength="20" class="form-control" required ></td><td><input type="text" name="SlabRoute[]" style="width: 60px;" maxlength="20" class="form-control" required ></td><td><select name="SlabDistance[]" class="form-control mySelect" onchange="toggleDisability(this);" required><option value=""></option><option value="1">0 - 1</option><option value="2">1 - 2</option><option value="3">2 - 3</option><option value="4">3 - 4</option><option value="5">4 - 5</option><option value="6">5 - 6</option><option value="7">6 - 7</option><option value="8">7 - 8</option></select></td><td><input type="text" name="SlabAmount[]" maxlength="4" class="form-control" style="text-align: right;width: 70px;" required ></td><td><a href="javascript:void(0);" class="remCF">Remove</a></td></tr>');
		document.getElementById("count").value=cnt;
		cnt++;
	});
    $("#customFields").on('click','.remCF',function(){
        $(this).parent().parent().remove();
	document.getElementById("count").value=cnt;
	cnt--;
    });
    
});
}

//Same SELECT Option disabled
function toggleDisability(selectElement){
   //Getting all select elements
   var arraySelects = document.getElementsByClassName('mySelect');
   //Getting selected index
   var selectedOption = selectElement.selectedIndex;
   //Disabling options at same index in other select elements
   for(var i=0; i<arraySelects.length; i++) {
    if(arraySelects[i] == selectElement)
     continue; //Passing the selected Select Element

    arraySelects[i].options[selectedOption].disabled = true;
   }
 }


//]]> 
</script>
<?php
	$rs = odbc_exec($conn, "SELECT * FROM [Transport Slab] WHERE [ID]='{$_GET['FeeTransportId']}'") or exit(odbc_errormsg($conn));
	while(odbc_fetch_array($rs))
		
	?>
 <script>
		function calculate(){
                    //alert("Hello! I am an alert box!!");
                    
                    var mon = $("#Months").val();
                    var amt = $("#Amount").val();
                    var MonAmount=(amt * mon)/12;
                    var totalRoyalty =(amt * mon);
                     $("#toAmount").val(totalRoyalty);
                     $("#MonthlyAmount").val(MonAmount);
                     
                     
		}
                
                
	</script>
<?php require_once("SetupRight.php"); ?>