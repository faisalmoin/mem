<?php	
	$ModalResult=mysql_query("SELECT * FROM `company` WHERE `id`='".$row[9]."'") or die(mysql_error());
	$ModRow=mysql_fetch_array($ModalResult);
?>
					    <!-- Modal HTML -->
					    <div id="myModal<?php echo $i?>" class="modal fade">
						<div class="modal-dialog">
						    <div class="modal-content">
							<div class="modal-header">
							    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
							    <h4 class="modal-title">Company Details</h4>
							</div>
							<div class="modal-body">								



<div class="tabbable"> <!-- Only required for left/right tabs -->
	<ul class="nav nav-tabs">
		<li class="active"><a href="#myModal<?php echo $i?>tab1" data-toggle="tab">General</a></li>
		<li><a href="#myModal<?php echo $i?>tab2" data-toggle="tab">Communication</a></li>
		<li><a href="#myModal<?php echo $i?>tab3" data-toggle="tab">Tax Information</a></li>
		<li><a href="#myModal<?php echo $i?>tab4" data-toggle="tab">E Filling</a></li>
	</ul>
	<div class="tab-content">
		<div class="tab-pane active" id="myModal<?php echo $i?>tab1">
			<table align="center">
				<tr>
					<td>ERP Code</td>
					<td colspan="2"><?=$ModRow[49]?></td>
				</tr>
				<tr>
					<td>Name</td>
					<td colspan="2"><?=$ModRow[1]?></td>
				</tr>
				<tr>
					<td>Address</td>
					<td colspan="2"><?=$ModRow[2]?></td>
				</tr>
				<tr>
					<td>Address 2</td>
					<td colspan="2"><?=$ModRow[3]?></td>
				</tr>
				<tr>
					<td>Address 3</td>
					<td colspan="2"><?=$ModRow[4]?></td>
				</tr>
				<tr>
					<td>Post Code / City</td>
					<td><?=$ModRow[5]?> / </td>
					<td><?=$ModRow[6]?></td>
				</tr>
				<tr>
					<td>Country/Region Code</td>
					<td><?=$ModRow[7]?></td>
				</tr>
				<tr>
					<td>State</td>
					<td><?=$ModRow[8]?></td>
				</tr>
				<tr>
					<td>Phone No.</td>
					<td><?=$ModRow[9]?></td>
				</tr>
				<tr>
					<td>VAT Registration No.</td>
					<td><?=$ModRow[10]?></td>
				</tr>
				<tr>
					<td>Trust</td>
					<td><?=$ModRow[11]?></td>
				</tr>
				<tr>
					<td>School Type</td>
					<td><?=$ModRow[12]?></td>
				</tr>
				<tr>
					<td>School Code</td>
					<td><?=$ModRow[13]?></td>
				</tr>
				<tr>
					<td>School Name</td>
					<td colspan="2"><?=$ModRow[14]?></td>
				</tr>
				<tr>
					<td>Name 2</td>
					<td colspan="2"><?=$ModRow[15]?></td>
				</tr>
				<tr>
					<td>Band</td>
					<td><?=$ModRow[16]?></td>
				</tr>
				<tr>
					<td>Company Status</td>
					<td><?=$ModRow[17]?></td>
				</tr>
			</table>
		</div>
		<div class="tab-pane" id="myModal<?php echo $i?>tab2">
			<table align="center">
				<tr>
					<td>Phone No.</td>
					<td><?=$ModRow[18]?></td>
				</tr>
				<tr>
					<td>Fax No.</td>
					<td><?=$ModRow[19]?></td>
				</tr>
				<tr>
					<td>Email</td>
					<td><?=$ModRow[20]?></td>
				</tr>
				<tr>
					<td>Home Page</td>
					<td><?=$ModRow[21]?></td>
				</tr>
				<tr>
					<td>IC Partner Code</td>
					<td><?=$ModRow[22]?></td>
				</tr>
				<tr>
					<td>IC Inbox Type</td>
					<td><?=$ModRow[23]?></td>
				</tr>
				<tr>
					<td>IC Inbox Details</td>
					<td><?=$ModRow[24]?></td>
				</tr>
			</table>
		</div>
		<div class="tab-pane" id="myModal<?php echo $i?>tab3">
			<table>
				<tr>
					<td> <!-- TAX / VAT -->
						<table>
							<tr>
								<td colspan="2"><strong>TAX / VAT</strong></td>
							</tr>
							<tr>
								<td>Export or Deemed Export</td>
								<td><?php if ($ModRow[25]=="1") echo '&#9745;' ?></td>
							</tr>
							<tr>
								<td>Composition</td>
								<td><?php if ($ModRow[26]=="1") echo '&#9745;' ?></td>
							</tr>
							<tr>
								<td>Composition Type</td>
								<td><?=$ModRow[50]?></td>
							</tr>
							<tr>
								<td>L.S.T. No</td>
								<td><?=$ModRow[27]?></td>
							</tr>
							<tr>
								<td>C.S.T. No</td>
								<td><?=$ModRow[28]?></td>
							</tr>
							<tr>
								<td>VAT Registration. No</td>
								<td><?=$ModRow[29]?></td>
							</tr>
							<tr>
								<td>T.I.N. No</td>
								<td><?=$ModRow[30]?></td>
							</tr>
						</table>
					</td>
					<td valign="top" style="border-left: 1px solid #000;"> <!-- Service Tax -->
						<table cellpadding="5">
							<tr>
								<td colspan="2"><strong>Service Tax</strong></td>
							</tr>
							<tr>
								<td>Input Service Distribution</td>
								<td><?php if ($ModRow[35]=="1") echo '&#9745;' ?></td>
							</tr>
							<tr>
								<td>Central STC Applicable</td>
								<td><?php if ($ModRow[36]=="1") echo '&#9745;' ?></td>
							</tr>
							<tr>
								<td>ST Payment Period</td>
								<td><?=$ModRow[37]?></td>
							</tr>
							<tr>
								<td>ST Payment Due Day</td>
								<td><?=$ModRow[38]?></td>
							</tr>
							<tr>
								<td>Service Tax Registration</td>
								<td><?=$ModRow[39]?></td>
							</tr>
						</table>
					</td>
				</tr>
				<tr>
					<td colspan="2" style="border-top: 1px solid #000;"> <!-- Income Tax -->
						<table>
							<tr>
								<td><strong>Income Tax</strong></td>
							</tr>
							<tr>
								<td>T.A.N. No.</td>
								<td><?=$ModRow[31]?></td>
							</tr>
							<tr>
								<td>T.C.A.N. No.</td>
								<td><?=$ModRow[32]?></td>
							</tr>
							<tr>
								<td>Circle No.</td>
								<td><?=$ModRow[33]?></td>
							</tr>
							<tr>
								<td>Assigning Officer</td>
								<td><?=$ModRow[51]?></td>
							</tr>
							<tr>
								<td>Ward No.</td>
								<td><?=$ModRow[34]?></td>
							</tr>
						</table>
					</td>
				</tr>
			</table>
		</div>
		<div class="tab-pane" id="myModal<?php echo $i?>tab4">
			<table width="60%" align="center">
				<tr>
					<td>P.A.N. Status</td>
					<td><?=$ModRow[40]?></td>
				</tr>
				<tr>
					<td>P.A.N. No.</td>
					<td><?=$ModRow[41]?></td>
				</tr>
				<tr>
					<td>Deductor Category</td>
					<td><?=$ModRow[42]?></td>
				</tr>
				<tr>
					<td>PAO Code</td>
					<td><?=$ModRow[43]?></td>
				</tr>
				<tr>
					<td>PAO Registration No</td>
					<td><?=$ModRow[44]?></td>
				</tr>
				<tr>
					<td>DDO Code</td>
					<td><?=$ModRow[45]?></td>
				</tr>
				<tr>
					<td>DDO Registration No</td>
					<td><?=$ModRow[46]?></td>
				</tr>
				<tr>
					<td>Ministry Type</td>
					<td><?=$ModRow[47]?></td>
				</tr>
				<tr>
					<td>Ministry Code</td>
					<td><?=$ModRow[48]?></td>
				</tr>
			</table>
		</div>
	</div>
</div>	
</div>
							<div class="modal-footer">
							    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
							</div>
						    </div>
						</div>
					    </div>