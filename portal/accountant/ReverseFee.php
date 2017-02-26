<?php
	require_once("header.php");

	$id = $_GET['invoice'];
	$class = $_GET['Class'];
	$AdmissionYear = $_GET['Class'];


	$today = strtotime(date('d M Y'));
	$this_yr = strtotime(date("Y", $today)."-04-01");
	$nxt_yr = strtotime((date("Y", $today)+1)."-03-31");
	
	if($today > strtotime(date("Y", $today)."-04-01") && $today < strtotime((date("Y", $today)+1)."-03-31")){
		$FinYr = date('y', $today)."-".(date('y', $today)+1);
	} else if ($today < strtotime(date("Y", $today)."-04-01")  && $today < strtotime((date("Y", $today))."-03-31")) {
        $FinYr = (date('y', $today)-1)."-".date('y', $today);
    }
	
	//Get Student Info
	$row = odbc_exec($conn, "SELECT * FROM [Temp Student] WHERE [Company Name]='$ms' AND [Registration No_]='$id'") or die(odbc_errormsg($conn));
	

?>


<!-- Body -->
<div class="right_col" role="main">
<div class="">
<div class="page-title">
<div class="title_left">
</div>

<div class="clearfix"></div>

<!-- Section 1 -->
<div class="row">
<div class="col-md-12 col-sm-12 col-xs-12">
<div class="x_panel">
<div class="x_title">
<h2>Individual Student Fee Generation </h2> <!-- Page Name -->
<ul class="nav navbar-right panel_toolbox">
<li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
</ul>
<div class="clearfix"></div>
</div>
<div class="x_content">
<!-- Section Content -->
	<div class="col-md-6 col-sm-4 col-xs-12 profile_details">
		<div class="well profile_view">
			<div class="col-sm-12">
				<h4 class="brief"><i>Sudent Details</i></h4>
				<div class="left col-xs-7">
				
					<p><strong>Student No : </strong> <span style="color: #000000;"><?php echo odbc_result($row, "No_");?></span> </p>
					<h2 style="color: #FF4000;"><?php echo odbc_result($row, "Name"); ?></h2>
					<p><strong>Class : </strong> <span style="color: #000000;"><?php echo odbc_result($row, "Class");?> (<?php echo odbc_result($row, "Section");?>)</span> </p>					
					<p><strong>AY : </strong> <span style="color: #000000;"><?php echo odbc_result($row, "Academic Year");?></span> </p>
					<p><strong>Status : </strong> <span style="color: #000000;"><?php 
						if(odbc_result($row, "Student Status") == 1){
							echo "Active";
						} else if(odbc_result($row, "Student Status") == 2){
							echo "In-Active";
						} else if(odbc_result($row, "Student Status") == 3){
							echo "Withdrawal";
						} else if(odbc_result($row, "Student Status") == 4){
							echo "alumnae";
						}
					?></span> </p>
					<p><strong>DOB : </strong> <span style="color: #000000;"><?php echo date('d/M/Y', strtotime(odbc_result($row, "Date of Birth"))); ?> (<?php
						$StuYr = odbc_exec($conn, "SELECT datediff(year, '".odbc_result($row, "Date of Birth")."', getdate()) AS [Yr]") or die(odbc_errormsg($conn));
						$StuMnths = odbc_exec($conn, "SELECT datediff(year, '".odbc_result($row, "Date of Birth")."', getdate())*12 AS [Mn]") or die(odbc_errormsg($conn));
						$StuDays = odbc_exec($conn, "select datepart(d,getdate())-datepart(d,'".odbc_result($row, "Date of Birth")."') AS [Days]") or die(odbc_errormsg($conn));
						echo odbc_result($StuYr, "Yr")."Y ".odbc_result($StuMnths, "Mn")."M ".odbc_result($StuDays, "Days")."D ";
					?>)</span> </p>
					<p><strong>Gender : </strong> <span style="color: #000000;"><?php 
						if(odbc_result($row, "Gender") == 1) {echo "Boy";}
						else if(odbc_result($row, "Gender") == 2) {echo "Girl";}
					?></span> </p>
					<ul class="list-unstyled">
						<li><strong>Ward of : </strong> <span style="color: #000000;">Mr. <?php echo odbc_result($row, "Father_s Name");?> and Mrs. <?php echo odbc_result($row, "Mother_s Name");?> </span></li>					
						<li><i class="fa fa-building"></i> Address: <span style="color: #000000;"><?php echo odbc_result($row, "Address1")." ".odbc_result($row, "Address2")." ".odbc_result($row, "Address 3")." ".odbc_result($row, "City")." ".odbc_result($row, "State")." ".odbc_result($row, "Country")." ".odbc_result($row, "Post Code");?></span></li>
						<li><i class="fa fa-phone"></i> Phone #: <span style="color: #000000;"><?php echo odbc_result($row, "Mobile Number");?></span></li>
					</ul>
				</div>
				<div class="right col-xs-5 text-center">
					<?php
						echo '<img src="';
						if(odbc_result($row, "Student Image") != ""){
							echo odbc_result($row, "Student Image");
						} else {
							if(odbc_result($row, "Gender") == 1) {echo "../img/boy.jpg";}
							else if(odbc_result($row, "Gender") == 2) {echo "../img/girl.jpg";}							
						}
						echo '"" alt="" class="img-circle img-responsive">';
					?>	
				</div>
			</div>
			<div class="col-xs-12 bottom text-center">
				<div class="col-xs-12 col-sm-6 emphasis">
					<!--p class="ratings">
					<a>4.0</a>
					<a href="#"><span class="fa fa-star"></span></a>
					<a href="#"><span class="fa fa-star"></span></a>
					<a href="#"><span class="fa fa-star"></span></a>
					<a href="#"><span class="fa fa-star"></span></a>
					<a href="#"><span class="fa fa-star-o"></span></a>
					</p -->
				</div>
				<div class="col-xs-12 col-sm-6 emphasis">
					<!--button type="button" class="btn btn-success btn-xs"> <i class="fa fa-user">
					</i> <i class="fa fa-comments-o"></i> </button-->
					<a href="StudentCard.php?id=<?php echo odbc_result($row, "No_")?>" class="btn btn-primary btn-xs">
						<i class="fa fa-user"> </i> View Card
					</a>
				</div>
			</div>
		</div>
	</div>

	<div class="col-md-6 col-sm-4 col-xs-12 profile_details">
		<div class="well profile_view">
		<form action="IndividualStudent.php" method="POST" name="form1" >
			<div class="col-sm-12">
				<h4 class="brief"><i>Term Fees</i></h4>
				<div class="left col-xs-12">
					<div class="row">
                        <div class="col-xs-12 table">
                          	<table class="table table-striped">
                          	<thead>
	                          	<tr>
	                          		<th> # </th>
	                          		<th>Fees Description</th>
	                          		<th></th>
	                          		<th>Remarks</th>
	                          	</tr>
                          	</thead>
                          	<tbody>
						        <?php 
						        $i=1;
						         $FeeCode=odbc_exec($conn, "SELECT * FROM [Fee Type] WHERE [Academic Year]='$FinYr' AND [Company Name]='$ms' ");
						        while(odbc_fetch_array($FeeCode)){
						        ?>
						        <tr>
						        	<td><?php echo $i; ?></td>
                					<td>
                						<?php echo odbc_result($FeeCode, 'Description');?>
                						<p><small><?php echo date('d/M/Y', odbc_result($FeeCode, 'Start Date'));?> - <?php echo date('d/M/Y', odbc_result($FeeCode, 'End Date'));?></small></p>
                					</td>
                					<td>
                					<?php
                						$FeeCheck = odbc_exec($conn, "SELECT * FROM [Ledger Credit] WHERE [Customer No]='".$id."' AND [Company Name]='$ms' AND [Description] = '".odbc_result($FeeCode, 'Code')."'") or die(odbc_errormsg($conn));
                						
                						if(odbc_num_rows($FeeCheck) == 0 ){
                							if(odbc_result($FeeCheck, "Start Date") < strtotime(date('m/d/y')) ){
                					?>
                					<input type="hidden" name="FeeType<?php echo $i; ?>" value="<?php echo odbc_result($FeeCode, 'Code');?>" />
                					<td><input type="checkbox" name="fee<?php echo $i?>" value="1" />
                					<input type="hidden" name="Class" value="<?php echo odbc_result($row, 'Class');?>" />
                					<input type="hidden" name="Academic" value="<?php echo odbc_result($row, 'Academic Year');?>" />
                					<input type="hidden" name="registration" value="<?php echo $id;?>" />
                					
                					<?php
                							}
                						}
                					?>
                					</td>
                					<td>
            						<?php
            							if(odbc_num_rows($FeeCheck) > 0 ){
            								echo "Fee raised on ".date('d/M/Y', odbc_result($FeeCheck, "Invoice Date"));
            							}	
            							if(odbc_result($FeeCheck, "Start Date") > strtotime(date('m/d/y')) ){
            								echo "Applicable on and after ".date('d/M/Y', odbc_result($FeeCode, "Start Date"));
            							}
            						?>
                					</td>
						        </tr>
						        <?php
						        		$i++;
						    		}
						        ?>
					        </tbody>
                          	</table>
                      	</div>
                  	</div>
				</div>
			</div>
			<div class="col-xs-12 bottom text-center">
				<div class="col-xs-12 col-sm-6 emphasis">
					<!--p class="ratings">
					<a>4.0</a>
					<a href="#"><span class="fa fa-star"></span></a>
					<a href="#"><span class="fa fa-star"></span></a>
					<a href="#"><span class="fa fa-star"></span></a>
					<a href="#"><span class="fa fa-star"></span></a>
					<a href="#"><span class="fa fa-star-o"></span></a>
					</p -->
				</div>
				<div class="col-xs-12 col-sm-6 emphasis">
					
					<!--a href="IndividualStudent.php?registration=<?php echo $id ?>&Class=<?php echo odbc_result($row, "Class");?>&Academic=<?php echo odbc_result($row, "Academic Year");?>" class="btn btn-primary btn-xs">
						<i class="fa fa-credit-card"> </i> Generate
					</a-->
					<input type="hidden" value="<?php echo $i?>" name="fee_count">
                   <i class="fa fa-credit-card"> <input type="submit" value="Generate" class="btn btn-primary btn-xs"></i>

				</div>
			</div>

			</form>
		</div>
	</div>

<!-- /Section Content -->
</div>
</div>
</div>
</div>
<!-- /Section 1 -->


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
<?php
	require_once("../footer.php");
?>
