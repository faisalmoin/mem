<?php
	require_once("SetupLeft.php");
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
<h2>Fee Structure </h2>
<ul class="nav navbar-right panel_toolbox">
<li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
<li><a href="FeeStructureNew.php" title="Create New ..."><img src="../img/btn-create.png" id="btn-create" width="30px" alt="Create New"></a></li>
</ul>
<div class="clearfix"></div>
</div>
<div class="x_content">

<form action="FeeStructureEditAdd.php" method="post">
		<?php
		$i=1;
		$rs = odbc_exec($conn, "SELECT * FROM [Class Fee Line] WHERE [ID]= '".$_REQUEST[Id]."' AND [Company Name]='$CompName' ORDER BY [Academic Year], [Group Code] ") or die(odbc_errormsg($conn));
		while(odbc_fetch_array($rs)){
	?>
	<table class="table table-responsive">
		<tr>
			<td>Academic Year</td>
		    <td>Class</td>
			<td>Fee Classification</td>
		</tr>
		<tr>
			<td>
			
			<?php $mssql1="SELECT DISTINCT([Academic Year]) FROM [Class Section] WHERE [Company Name]='$CompName' ORDER BY [Academic Year]";
				$msAY=odbc_exec($conn, $mssql1) or die(odbc_errormsg());
				?>
				<select name="Academic" class="form-control" required>
				<option value="<?php echo odbc_result($rs, "Academic Year");?>"></option>
				<?php while(odbc_fetch_array($msAY)){
		         echo "<option value='".odbc_result($msAY, "Academic Year")."'";
		         if(odbc_result($msAY, "Academic Year") == odbc_result($rs, "Academic Year") ){echo " selected";}
		         echo ">".odbc_result($msAY, "Academic Year")."</option>";
				 }?>
				</select>
			</td>
			
			<td>
			<?php $mssql2="SELECT [Code] AS [Class] FROM [Class] WHERE [Company Name]='$CompName'  ORDER BY [Sequence]";
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
			<td>
				<select name="FeeClassification" class="form-control" required>
				<option value="GENERAL">GENERAL</option>
				</select>
			</td>
		</tr>
	</table>
	
	<table class="table table-responsive" id="customFields">
		<tr>
			
			<td>Fee Description</td>
			<td>Amount</td>
			<td>Occurence</td>
			<td>Total Amount</td>
			<td>Monthly Amount</td>
			<td>Fee Group</td>
			<td></td>
		</tr>
                <script>
		function calculate(){
                    //alert("Hello! I am an alert box!!");
                    
                    var mon = $("#Months").val();
                    var amt = $("#Amount").val();
                    var totalRoyalty =(amt * mon);
                    var MonAmount=totalRoyalty/12;
                     $("#MonthlyAmount").val(MonAmount);
                     $("#toAmount").val(totalRoyalty);
                     
		}
                
                
	</script>
        
        
        
        
         <script type="text/javascript">
       
     jQuery(document).ready(function($) {

    
      
     $("#Amount").focusout(function(event) {
   // $('#Amount').change(function (){
           
                    var mon = $("#Months").val();
                    var amt = $("#Amount").val();
                    var totalRoyalty =(amt * mon);
                     $("#toAmount").val(totalRoyalty); 
                   //  alert(totalRoyalty);
           
            
    });  
     /*   $("#Amount").on('click', function(){
     var mon = $("#Months").val();
                    var amt = $("#Amount").val();
                    var totalRoyalty =(amt * mon);
                     $("#toAmount").val(totalRoyalty); 
         });*/

        });
 
 

     </script>
        
		<tr>
		
			
			<td><?php $mssql3="SELECT [Code], [Description] FROM [Fee Components] WHERE [Company Name]='$CompName' ORDER BY [Description]";
				$msAY3=odbc_exec($conn, $mssql3) or die(odbc_errormsg());
				?>
				<select name="Description" class="form-control" required>
				<option value="<?php echo odbc_result($rs, "Code");?>"></option>
				<?php while(odbc_fetch_array($msAY3)){
                                echo "<option value='".odbc_result($msAY3, "Description")."'";
                                if(odbc_result($msAY3, "Description") == odbc_result($rs, "Description") ){echo " selected";}
                                echo ">".odbc_result($msAY3, "Description")."</option>";
				 }?>
				</select>
			</td>
                        <?php 
                        $a=odbc_result($rs, "No_ of months");
                        $b=odbc_result($rs, "Group Code");
               
                        ?>
                        <td><input type="text" value="<?php echo number_format(odbc_result($rs, "Amount"),2,'.',''); ?>" name="Amount" id="Amount" class="form-control" style="text-align: right" required></td>
			<td><select name="months" id="Months" class="form-control" onchange="calculate()" required>			
			    <option value=""></option>
			    <option <?php if(($a == 1) && ($b =="REG" || $b =="ADM")) { echo "selected='selected'"; } ?> value=1>One Time</option>
			    <option <?php if(odbc_result($rs, "No_ of months") == 12) { echo "selected='selected'"; } ?> value=12>Monthly</option>
			    <option <?php if(odbc_result($rs, "No_ of months") == 4) { echo "selected='selected'"; } ?> value=4>Quarterly</option>
			    <option <?php if(odbc_result($rs, "No_ of months") == 2) { echo "selected='selected'"; } ?> value=2>Half Yearly</option>
			    <option <?php if(odbc_result($rs, "Group Code") =="INV" && odbc_result($rs, "No_ of months") == 1) { echo "selected='selected'"; } ?> value=1>Annually</option>
				
                            <!--?php echo $Occur?-->
			</select></td>
                        <td><input type="text" value= "<?php echo number_format(odbc_result($rs, "Total Amount"),2,'.',''); ?>" name="toAmount" class="form-control" id="toAmount" value="0" style="text-align: right" required></td>

                         <td><input type="text" value= "<?php echo number_format(odbc_result($rs, "Monthly Amount"),2,'.',''); ?>" name="MonthlyAmount" class="form-control" id="MonthlyAmount" value="0" style="text-align: right" required></td>
			<td>
				<select name="GroupCode" class="form-control" required>
					<option value=""></option>
					<option <?php if(odbc_result($rs, "Group Code") == REG) { echo "selected='selected'"; } ?> value="REG">Registration Fee</option>
					<option <?php if(odbc_result($rs, "Group Code") == ADM) { echo "selected='selected'"; } ?> value="ADM">Admission Fee</option>
					<option <?php if(odbc_result($rs, "Group Code") == INV) { echo "selected='selected'"; } ?> value="INV">School Fee</option>
				</select>
			</td>			
			<!--td><a href="javascript:void(0);" class="addCF">Add More</a></td-->
		</tr>
	</table>
	<?php }?>
    <input type="hidden" value="1" name="count" id="count" />
	<input type="hidden" value="<?php echo odbc_result($rs, "ID");?>" name="Id" />
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