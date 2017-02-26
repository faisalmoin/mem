<?php
	require_once("header.php");
	
	if($_GET['rPage']=="" || $_GET['rPage']==1){
		$e_min=0;
		$e_max=50;
		$ePrev = 0;
	}
	else{
		$e_max=50*$_GET['rPage'];
		$e_min = ($e_max - 50);
	}	
	
?>
<script language="javascript">
var popupWindow = null;
function positionedPopup(url,winName,w,h,t,l,scroll){
settings =
'height='+h+',width='+w+',top='+t+',left='+l+',scrollbars='+scroll+',resizable'
popupWindow = window.open(url,winName,settings)
}
</script>

<div class="container">
<h1 class="text-primary">Registration List</h1>
<hr />
<div class="table-responsive">
	<table class="table table-striped table-hover">
		<form name="form" method="get">
			<tr>
				<td colspan="9" align="right"> Go to page
					<select name="rPage" onchange="this.form.submit()">
						
						<?php							
							$enqCount=odbc_exec($conn, "SELECT (COUNT([No_])/50)+1 FROM [Temp Application] WHERE [Registration Status]=2 AND [Company Name]='$ms'") or die(odbc_errormsg($conn));
							for($f=1; $f<=odbc_result($enqCount,""); $f++){
								echo "<option value='$f' ";
								if($f == $_GET['rPage']) echo "selected";
								echo ">$f</option>";
							}
						?>
					</select>
				</td>
			</tr>
		</form>
		<thead>
			<tr style="font-weight: bold; background-color: #A9E2F3;">
				<td>Enquiry No.</td>
				<td>Registration No.</td>
				<td>Registration Form No.</td>
				<td>Candidate Name</td>
				<td>Class Applied</td>
				<td>Application Status</td>
				<td>Sale Date</td>
				<td>Confirmation Date</td>
				<td></td>
			</tr>
		</thead>
		<tbody>
			<?php
                $i=1;
				//$result=odbc_exec($conn, "SELECT TOP 50 [Enquiry No_],[No_], [Registration No_], [Name], [Class],[Registration Status],[Date of Sale], [Date of Receive]  FROM [Temp Application] WHERE [Registration Status] = 2  AND [Company Name]='$ms'");
				$result=odbc_exec($conn, "SELECT [Enquiry No_],[No_], [Registration No_], [Name], [Class],[Registration Status],[Date of Sale], [Date of Receive]  FROM ( 
									SELECT *, ROW_NUMBER() OVER (ORDER BY [Date of Receive] DESC) as row FROM [Temp Application] WHERE [Company Name]='$ms' AND [Registration Status] <> 0
									) a WHERE a.row > $e_min and a.row <= $e_max ORDER BY [Registration No_] ASC, [No_] ASC ") or die(odbc_errormsg($conn));
				while(odbc_fetch_array($result)){
			?>
			<tr>
				<td><?php echo odbc_result($result, "Enquiry No_")?></td>
				<td><?php echo odbc_result($result, "No_")?></td>
				<td><?php echo odbc_result($result, "Registration No_")?></td>
				<td><?php echo odbc_result($result, "Name")?></td>
				<td><?php echo odbc_result($result, "Class")?></td>
				<td><?php
                    if(odbc_result($result, 'Registration Status') == 1) echo "SOLD";
                    if(odbc_result($result, "Registration Status")==2) echo "RECEIVED";
                    if(odbc_result($result, "Registration Status")==3) echo "SELECTED";
                    if(odbc_result($result, "Registration Status")==4) echo "PENDING APPROVAL";
                    if(odbc_result($result, "Registration Status")==5) echo "APPROVED";
                    if(odbc_result($result, "Registration Status")==6) echo "ADMITTED";
                    ?></td>
				<td><?php echo date('d/M/Y', strtotime(odbc_result($result, "Date of Sale")))?></td>
				<td><?php echo date('d/M/Y', strtotime(odbc_result($result, "Date of Receive")))?></td>
				<td>
					<div class="bs-example">	
						<!--<a href="RegistrationList.php?id=<?php //echo odbc_result($result, 'Enquiry No_')?>#myModal<?php //echo $i?>" class="btn btn-lg btn-primary btn-sm" data-toggle="modal">View</a>-->
						<?php
							//require("ModalRegistration.php");
						?>
						<a href="ReceiptRegistration.php?id=<?php echo odbc_result($result, "Enquiry No_")?>&ms=<?php echo $ms?>&LoginID=<?php echo $LoginID?>"
							onclick="positionedPopup(this.href,'myWindow','700','300','100','200','yes');return false">Receipt</a>
					</div>
					
				</td>
			</tr>
			<?php
                    $i += 1;
				}
			?>
			</tbody>
	</table>
</div>
</div>
<?php require_once("../footer.php");?>