<!DOCTYPE html>
<html lang="en">
<head>

<meta charset="UTF-8">
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


<!--script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script-->
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
<script type="text/javascript">
$(document).ready(function(){
    $("#myNav").affix({
        offset: { 
            top: 195 
     	}
    });
    $("#myNav").on('affixed.bs.affix', function(){
        //alert("The left navigation menu has been affixed. Now it doesn't scroll with the page.");
    });
});
</script>
<style type="text/css">
    /* Custom Styles */
    ul.nav-tabs{
        width: 220px;
        margin-top: 20px;
        border-radius: 4px;
        border: 0px solid #ddd;
        box-shadow: 0 1px 4px rgba(0, 0, 0, 0.067);
    }
    ul.nav-tabs li{
        margin: 0;
        border-top: 0px solid #ddd;
    }
    ul.nav-tabs li:first-child{
        border-top: none;
    }
    ul.nav-tabs li a{
        margin: 0;
        padding: 8px 16px;
        border-radius: 0;
    }
    ul.nav-tabs li.active a, ul.nav-tabs li.active a:hover{
        color: #fff;
        background: #0088cc;
        border: 1px solid #0088cc;
    }
    ul.nav-tabs li:first-child a{
        border-radius: 4px 4px 0 0;
    }
    ul.nav-tabs li:last-child a{
        border-radius: 0 0 4px 4px;
    }
    ul.nav-tabs.affix{
        top: 30px; /* Set the top position of pinned element */
    }
</style>
</head>
  <body data-spy="scroll" data-target="#myScrollspy">
  <div class="container">
	<div class="row">
          <div class="col-xs-3" id="myScrollspy">
	            <ul class="nav nav-tabs nav-stacked" id="myNav">
	            <h2 style="color: #81BEF7;">Fee At a Glance</h2> 
	            <!-- dropdown Start -->
		        <form action="#" method="post" name="Myform">
				<h4 style="color: #81BEF7;">Financial Year :  
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
		         </h4> 
				</form>
				<!-- dropdown End -->
                <li class="active"><a href="#Structure">Fee Structure</a></li>
                <li><a href="#Type">Fee Type</a></li>
                <li><a href="#Component">Fee Component</a></li>
                <li><a href="#Category">Discount Fee Category</a></li>
                <li><a href="#Payment">Payment Method</a></li>
                <li><a href="#Discount">Discount Fee Structure</a></li>
               </ul>
               </div>
		       <div class="col-xs-9">
		       <?php echo "</br></br>";?>
            <h3 style="color: #000080;" id="Structure">Fee Structure</h3>
            <?php echo "</br></br>";
            require_once("FeeStructureList.php"); ?>
            <hr>
            
            <h3 style="color: #000080;" id="Type">Fee Type</h3>
            <?php echo "</br></br>";
            require_once("FeeTypeList.php");?>
            <hr>
            
            <h3 style="color: #000080;" id="Component">Fee Component</h3>
            <?php echo "</br></br>";
             require_once("FeeComponentList.php")?>
             <hr>
            
            <h3 style="color: #000080;" id="Category">Discount Fee Category</h3>
            <?php echo "</br></br>";
            require_once("FeeDiscountCatList.php"); ?>
            <hr>
            <h3 style="color: #000080;" id="Payment">Payment Method</h3>
            <?php echo "</br></br>";
            require_once("FeePaymentList.php"); ?>
           
            <hr>
            <h3 style="color: #000080;" id="Discount">Discount Fee Structure</h3>
            <?php echo "</br></br>";
            require_once("FeeDiscLineList.php"); ?>
            </div>
          </div>
    </div>
    <?php require_once("../footer.php");?>
</body>
</html>                                		