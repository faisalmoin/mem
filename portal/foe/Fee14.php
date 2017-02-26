<!DOCTYPE html>
<html>
<head>
<?php require_once("header.php");
$today = strtotime(date('d M Y'));
$this_yr = strtotime(date("Y", $today)."-04-01");
$nxt_yr = strtotime((date("Y", $today)+1)."-03-31");

if($today > strtotime(date("Y", $today)."-04-01") && $today < strtotime((date("Y", $today)+1)."-03-31")){
	$FinYr = date('y', $today)."-".(date('y', $today)+1);
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

<body>
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
