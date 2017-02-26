<?php
	require_once("SetupLeft.php");
	
	$FeeClasi=odbc_exec($conn, "SELECT [Code], [Description] FROM [Fee Components] WHERE [Company Name]='$CompName' ORDER BY [Description]");
	while(odbc_fetch_array($FeeClasi)){
		$fClass .= '<option value="'.odbc_result($FeeClasi, "Code").'">'.odbc_result($FeeClasi, "Description").'</option>';
	}
	
	//************** Occurence ************/
	/*
		0 - One Time
		1 - Monthly
		2 - Quarterly
		3 - Half Yearly
		4 - Annually
	*/
	$Occur = '<option value=""></option>
			<option value=1>One Time</option>
			<option value=12>Monthly</option>
			<option value=4>Quarterly</option>
			<option value=2>Half Yearly</option>
			<option value=1>Annually</option>';
	
	
?>

			
<script type='text/javascript'>//<![CDATA[

function addrow(){

	alert('hi');
}
</script>
<script type="text/javascript">
    window.onload=function(){
$(document).ready(function(){
	cnt = 2;
	$(".addCF").click(function(){
		var rowCount = $('#customFields tr').length; 
		//alert(rowCount);
		$("#customFields").append('<tr><td>'+ cnt +'</td><td><select name="FeeCode[]" class="form-control" required><option value=""><?php echo $fClass; ?></option></select></td><td><input type="text" name="Amount[]" id="Amount'+rowCount+'" class="form-control" maxlength="10" style="text-align: right" onchange="calculate(this)" required></td><td><select name="Months[]" id="Months'+rowCount+'" class="form-control" onchange="calculate(this)" required><option value=""></option><option value=1>One Time</option><option value=12>Monthyly</option><option value=4>Quarterly</option><option value=2>Half Yearly</option><option value=1>Annualy</option></select></td><td><input type="text" name="TotAmt[]" id="TotAmt'+rowCount+'" class="form-control" maxlength="10" value="0" style="text-align: right" required readonly></td><td><input type="text" name="MnthtAmt[]" id="MnthtAmt'+rowCount+'" class="form-control" maxlength="10" value="0" style="text-align: right" required readonly></td><td><select name="FeeGroup[]" class="form-control" required><option value=""></option><option value="REG">Registration Fee</option><option value="ADM">Admission Fee</option><option value="INV">School Fee</option></select></td><td><a href="javascript:void(0);" class="remCF">Remove</a></td></tr>');
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
/*window.onload=function(){
$(document).ready(function(){
	alert();
	cnt = 2;
	$(".addCF").click(function(){
		$("#customFields").append('<tr><td>'+ cnt +'</td><td><select name="FeeCode[]" class="form-control" required><option value=""></option><?php echo $fClass?></select></td><td><input type="text" name="Amount[]" id="Amount[]" class="form-control" maxlength="10" style="text-align: right" required></td><td><select name="Months[]" id="Months" class="form-control" onchange="calculate(this)" required><?php echo $Occur?></select></td><td><input type="text" name="TotAmt[]" id="TotAmt" class="form-control" maxlength="10" value="0" style="text-align: right" required></td><td><select name="FeeGroup[]" class="form-control" required><option value=""></option><option value="REG">Registration Fee</option><option value="ADM">Admission Fee</option><option value="INV">School Fee</option></select></td><td><a href="javascript:void(0);" class="remCF">Remove</a></td></tr>');
		document.getElementById("count").value=cnt;
		cnt++;
	});
    $("#customFields").on('click','.remCF',function(){
        $(this).parent().parent().remove();
	document.getElementById("count").value=cnt;
	cnt--;
    });
    
});
}*/ 

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
<h2>Fee Structure </h2>
<ul class="nav navbar-right panel_toolbox">
<li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
</ul>
<div class="clearfix"></div>
</div>
<div class="x_content">

<form action="FeeStructureAdd.php" method="post">
	<table class="table table-responsive">
		<tr>
			<td>Academic Year</td>
			<td>Curriculum</td>
			<td>Class</td>
			<td>Fee Classification</td>
		</tr>
		<tr>
			<td>
				<select name="AcadYear" class="form-control" required>
					<option value=""></option>
                                        
					<?php						
						$ay = odbc_exec($conn, "SELECT DISTINCT([Academic Year]) FROM [Class Section] WHERE [Company Name]='$CompName' ORDER BY [Academic Year]");
						while(odbc_fetch_array($ay)){
							echo "<option value='".odbc_result($ay, 'Academic Year')."'>".odbc_result($ay, 'Academic Year')."</option>";
						}
					?>
				</select>
			</td>
			<td>
				<select name="Curriculum" class="form-control" required>
					<option value=""></option>
					<?php						
						$cur = odbc_exec($conn, "SELECT DISTINCT([Curriculum]) FROM [Class Section] WHERE [Company Name]='$CompName' ORDER BY [Curriculum]");
						while(odbc_fetch_array($cur)){
							echo "<option value='".odbc_result($cur, 'Curriculum')."'>".odbc_result($cur, 'Curriculum')."</option>";
						}
					?>
				</select>
			</td>
			<td>
				<select name="Class" class="form-control" required>
					<option value=""></option>
                                        <option selected="selected" value="AllClass">All Class</option>
					<?php						
						$cls = odbc_exec($conn, "SELECT [Code] AS [Class] FROM [Class] WHERE [Company Name]='$CompName'  ORDER BY [Sequence]");
						while(odbc_fetch_array($cls)){
							echo "<option value='".odbc_result($cls, 'Class')."'>".odbc_result($cls, 'Class')."</option>";
						}
					?>
				</select>
			</td>
			<td>
				<select name="FeeClassification" class="form-control" required>
				<option value="GENERAL">GENERAL</option>
				</select>
			</td>
		</tr>
	</table>
	<script>
		function calculate(elem){
			c = document.getElementById('count').value;
			var mon = 0;
			var tr = elem.parentElement.parentElement;
			var amt = parseInt(tr.querySelector('[name="Amount[]"]').value||0, 10);
			var mon = parseInt(tr.querySelector('[name="Months[]"]').value||0, 10);

			
			//if(mon == 0 || mon == 1 || mon == 2  || mon == 3  || mon == 4  || mon == 5  || mon == 7 ) {mon = 1;}
            if(mon == 1 ) {mon = 1;}
           // else if(mon == 0  ) {mon = 1;}
            else if(mon == 12  ) {mon = 12;}
			else if(mon == 4  ) {mon = 4;}
            else if(mon == 2  ) {mon = 2;}
			else if(mon == 1  ) {mon = 1;}
			
			tr.querySelector('[name="TotAmt[]"]').value = (amt * mon);
			tr.querySelector('[name="MnthtAmt[]"]').value = (amt * mon)/12;
		}
	</script>
        <script>
        $(document).ready(function(){
            
            
            $(('[name="Amount[]"]')).keydown(function(){
                $('[name="Amount[]"]').css("background-color", "red");
            });
           
        });
        </script>
          <!--script type="text/javascript">
       
     jQuery(document).ready(function($) {
     $("#Amount").focusout(function(event) {
         
         
        // c = document.getElementById('count').value;
			var mon = 0;
			var tr = elem.parentElement.parentElement;
			var amt = parseInt(tr.querySelector('[name="Amount[]"]').value||0, 10);
			var mon = parseInt(tr.querySelector('[name="Months[]"]').value||0, 10);
			
			//if(mon == 0 || mon == 1 || mon == 2  || mon == 3  || mon == 4  || mon == 5  || mon == 7 ) {mon = 1;}
                        if(mon == 0 ) {mon = 1;}
                       // else if(mon == 0  ) {mon = 1;}
                        else if(mon == 1  ) {mon = 12;}
			else if(mon == 2  ) {mon = 4;}
                        else if(mon == 3  ) {mon = 2;}
			else if(mon == 4  ) {mon = 1;}
			
			tr.querySelector('[name="TotAmt[]"]').value = (amt * mon);
         
   // $('#Amount').change(function (){
            
                  /*  var mon = $("#Months").val();
                    var amt = $("#Amount").val();
                    var totalRoyalty =(amt * mon);
                     $("#toAmount").val(totalRoyalty); 
                      alert(mon);*/
                   
           });  
    });
 
 

     </script-->
      
	<table class="table table-responsive" id="customFields">
		<tr>
			<td>SN</td>
			<td>Fee Description</td>
			<td>Amount</td>
			<td>Occurence</td>
			<td>Total Amount</td>
			<td>Monthly Amount</td>
			<td>Fee Group</td>
			<td></td>
		</tr>
		<tr>
			<td>1</td>
			<td><select name="FeeCode[]" class="form-control" required>
				<option value=""></option>
				<?php echo $fClass?>
				
			</select></td>
			<td><input type="text" name="Amount[]" id="Amount" class="form-control" maxlength="10" style="text-align: right" required></td>
			<td><select name="Months[]" id="Months" class="form-control" onchange="calculate(this)" required>			
				<?php echo $Occur?>
			</select></td>
            <td><input type="text" name="TotAmt[]" id="TotAmt"  class="form-control" maxlength="10" value="0" style="text-align: right" required readonly>
            </td>
            <td><input type="text" name="MnthtAmt[]" id="MnthtAmt"  class="form-control" maxlength="10" value="0" style="text-align: right" required readonly>
            </td>
			<td>
				<select name="FeeGroup[]" class="form-control" required>
					<option value=""></option>
					<option value="REG">Registration Fee</option>
					<option value="ADM">Admission Fee</option>
					<option value="INV">School Fee</option>
				</select>
			</td>			
		
	<!--td> <a href="javascript:void(0);" onclick="addrow();">Add</a></td-->
        <td><a href="javascript:void(0);" class="addCF">Add More</a></td>
		</tr>
	</table>
	<input type="hidden" value="1" name="count" id="count" />
	<button type="submit" class="btn btn-success">Submit</button>
</form>
<br />
<div style="width: 500px;">
	<strong>Note:</strong>
	<ul>
		<li align="justify"><b>Occurence</b> - Inform the system when to generate the fees</li>
		<li align="justify"><b>Fee Group</b> - Inform the system when the fee to be generated - During Registration, at the time of Admission or as per the occurence.</li>
	</ul>
</div>

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

<?php require_once("SetupRight.php") ?>