<?php require_once("SetupLeft.php");
$Occur ='<option value=""></option>
            <option value=1>Annually</option>
            <option value=2>Half Yearly</option>
            <option value=4>Quarterly</option>
			<option value=12>Monthly</option>';
?>

<!-- Datatables -->
<link href="../vendors/datatables.net-bs/css/dataTables.bootstrap.min.css" rel="stylesheet">
<link href="../vendors/datatables.net-buttons-bs/css/buttons.bootstrap.min.css" rel="stylesheet">
<link href="../vendors/datatables.net-fixedheader-bs/css/fixedHeader.bootstrap.min.css" rel="stylesheet">
<link href="../vendors/datatables.net-responsive-bs/css/responsive.bootstrap.min.css" rel="stylesheet">
<link href="../vendors/datatables.net-scroller-bs/css/scroller.bootstrap.min.css" rel="stylesheet">

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
</ul>
<div class="clearfix"></div>
</div>
<div class="x_content">

<form action="FeeTransportAdd.php" method="post">
<table class="table table-container"  id="customFields">
	<tr>
		<td>SN</td>
		<td>Slab Code</td>
		<td>Slab Name</td>
		<td>Route No.</td>
		<td>Distance (KM)</td>
		<td>Amount</td>
		<td>Occurence</td>
		<td>Total Amount</td>
		<td>Monthly Amount</td>
		
	</tr>
	<tr>
		<td>1</td>
		<td><input type="text" name="SlabCode[]" maxlength="10" class="form-control" required ></td>
		<td><input type="text" name="SlabName[]" maxlength="20" class="form-control" required ></td>
		<td><input type="text" name="SlabRoute[]" style="width: 60px;" maxlength="20" class="form-control" required ></td>
		
		      <td>	
				<select name="SlabDistance[]" class="form-control mySelect" onchange="toggleDisability(this);" required>
				<option value=""></option>
				<?php for ($x = 0; $x <= 100; $x++) {
		                echo "<option value='".$x."'";
		                echo ">".$x."</option>";
				 }?>
				</select></td>
			
		<td><input type="text" name="SlabAmount[]" maxlength="5" class="form-control" style="text-align: right;width: 70px;" required ></td>

		<td><select name="Months[]" id="Months" class="form-control" onchange="calculate(this)" required>			<?php echo $Occur?>
			</select></td>
			<td><input type="text" name="TotAmt[]" maxlength="5" class="form-control" style="text-align: right;width: 70px;" required ></td>
			<td><input type="text" name="MnthAmt[]" maxlength="5" class="form-control" style="text-align: right;width: 70px;" required ></td>
		<!--td><a href="javascript:void(0);" class="addCF">Add More</a></td-->
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
		$("#customFields").append('<tr><td>'+ cnt +'</td><td><input type="text" name="SlabCode[]" maxlength="10" class="form-control" required ></td><td><input type="text" name="SlabName[]"  maxlength="20" class="form-control" required ></td><td><input type="text" name="SlabRoute[]" style="width: 60px;" maxlength="20" class="form-control" required ></td><td><select name="SlabDistance[]" class="form-control mySelect" onchange="toggleDisability(this);" required><option value=""></option><option value="1">0 - 1</option><option value="2">1 - 2</option><option value="3">2 - 3</option><option value="4">3 - 4</option><option value="5">4 - 5</option><option value="6">5 - 6</option><option value="7">6 - 7</option><option value="8">7 - 8</option></select></td><td><input type="text" name="SlabAmount[]" maxlength="5" class="form-control" style="text-align: right;width: 70px;" required ></td><td><a href="javascript:void(0);" class="remCF">Remove</a></td></tr>');
		
               // $("#customFields").append('<tr><td>'+ cnt +'</td><td><input type="text" name="SlabCode[]" maxlength="10" class="form-control" required ></td><td><input type="text" name="SlabName[]"  maxlength="20" class="form-control" required ></td><td><input type="text" name="SlabRoute[]" style="width: 60px;" maxlength="20" class="form-control" required ></td><td><select name="SlabDistance[]" class="form-control mySelect" onchange="toggleDisability(this);" required><option value=""></option><?php for ($x = 0; $x <= 100; $x++) { echo "<option value='".$x."'"; echo ">".$x."</option>";}?></select></td><td><input type="text" name="SlabAmount[]" maxlength="5" class="form-control" style="text-align: right;width: 70px;" required ></td><td><a href="javascript:void(0);" class="remCF">Remove</a></td></tr>');

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
	function calculate(elem){
		c = document.getElementById('count').value;
		var mon = 0;
		var tr = elem.parentElement.parentElement;
		var amt = parseInt(tr.querySelector('[name="SlabAmount[]"]').value||0, 10);
		var mon = parseInt(tr.querySelector('[name="Months[]"]').value||0, 10);
		
		//if(mon == 0 || mon == 1 || mon == 2  || mon == 3  || mon == 4  || mon == 5  || mon == 7 ) {mon = 1;}
        if(mon == 1 ) {mon = 1;}
        else if(mon == 12  ) {mon = 12;}
		else if(mon == 4  ) {mon = 4;}
        else if(mon == 2  ) {mon = 2;}
		
		
		tr.querySelector('[name="TotAmt[]"]').value = (amt * mon);
		tr.querySelector('[name="MnthAmt[]"]').value = (amt * mon)/12;
		
	}
</script>
<?php require_once("SetupRight.php");?>




