<?php 
	require_once("header.php");
	
	//Academic Year
        $AcadStartDate = (date(Y)-2)."-".date('m-d');
        $AcadEndDate = (date(Y)+1)."-".date('m-d');
        $a=0;
        $AcadYr = odbc_exec($conn, "SELECT DISTINCT TOP 3 [Code] FROM [Academic Year] WHERE ([Start Date] BETWEEN '$AcadStartDate' AND '$AcadEndDate') ORDER BY [Code] ASC") or exit(odbc_errormsg($conn));
        while(odbc_fetch_array($AcadYr)){
                echo "";
                        if($a==0) {
                                $ac0= odbc_result($AcadYr, "Code");
                        }
                        if($a==1) {
                                $ac1= odbc_result($AcadYr, "Code");
                        }
                        if($a==2) {
                                $ac2= odbc_result($AcadYr, "Code");
                        }
                //echo "".odbc_result($AcadYr, "Code")."</td>";								
                $a++;
        }
?>
		<div class="container">
			<h1 class="text-primary">Monthly Report - <?php echo date('M')?>'<?php echo date('y')?></h1>
			<!-- Tab Starts -->
			<ul id = "myTab" class = "nav nav-tabs">
				<?php
					$Band = mysql_query("SELECT DISTINCT(`Band`) FROM `company` ORDER BY `Band`") or die(mysql_error());
					while($bnd = mysql_fetch_array($Band)){
				?>
				<li><a href="#band<?php echo $bnd[0]?>" data-toggle = "tab">Band - <?php echo $bnd[0]?></a></li>
				<?php
					}
				?>
			</ul>
			
			<div id = "myTabContent" class = "tab-content">
				<?php
					$c=0;
					$Bands = mysql_query("SELECT DISTINCT(`Band`) FROM `company` ORDER BY `Band`") or die(mysql_error());
					while($bnds = mysql_fetch_array($Bands)){
				?>
				<div class = "tab-pane fade in <?php if($c==0) echo ' active'; ?>" id = "band<?php echo $bnds[0]?>">
					<table class="table table-stripped table-bordered" style="font-size: 11px;">
						<tr>
							<td>Name of the School</td>
							<?php
								$Company = mysql_query("SELECT `Name` FROM `company` WHERE `Band`='".$bnds[0]."' AND `Name` NOT LIKE 'Training%' ") or die(mysql_error());
								while($cmp = mysql_fetch_array($Company)){
									echo "<td>".$cmp[0]."</td>";
								}
							?>
						</tr>
						<tr>
							<td>Name of the Principal</td>
							<?php
								$Company = mysql_query("SELECT `Name` FROM `company` WHERE `Band`='".$bnds[0]."' AND `Name` NOT LIKE 'Training%' ") or die(mysql_error());
								while($cmp = mysql_fetch_array($Company)){
									$Principal = odbc_exec($conn, "SELECT [First Name], [Middle Name], [Last Name] FROM [Employee] WHERE [Job Title] LIKE 'Principal' AND [Company Name]='".$cmp[0]."' AND [Status]=0") or die(odbc_errormsg($conn));
									echo "<td>".odbc_result($Principal, 'First Name')." ".odbc_result($Principal, 'Middle Name')." ".odbc_result($Principal, 'Last Name')."</td>";
								}
							?>
						</tr>
						<tr>
							<td>Year of Establishment</td>
						</tr>
						<tr>
							<td>Student Strength (FY: <?php echo $ac1?>)</td>
							<?php
								$Company = mysql_query("SELECT `Name` FROM `company` WHERE `Band`='".$bnds[0]."' AND `Name` NOT LIKE 'Training%' ") or die(mysql_error());
								while($cmp = mysql_fetch_array($Company)){
									$Student = odbc_exec($conn, "SELECT COUNT([No_]) FROM [Temp Student] WHERE [Student Status] = 1 AND [Company Name]='".$cmp[0]."' AND [Academic Year]='".$ac1."'") or die(odbc_errormsg($conn));
									echo "<td>".odbc_result($Student, '')."</td>";
								}
							?>
						</tr>
						<tr>
							<td>In-active Students (FY: <?php echo $ac1?>)</td>
							<?php
								$Company = mysql_query("SELECT `Name` FROM `company` WHERE `Band`='".$bnds[0]."' AND `Name` NOT LIKE 'Training%' ") or die(mysql_error());
								while($cmp = mysql_fetch_array($Company)){
									$Inactive = odbc_exec($conn, "SELECT COUNT([No_]) FROM [Temp Student] WHERE [Student Status] = 2 AND [Company Name]='".$cmp[0]."' AND [Academic Year]='".$ac1."'") or die(odbc_errormsg($conn));
									echo "<td>".odbc_result($Inactive, '')."</td>";
								}
							?>
						</tr>
						<tr>
							<td>Total Withdrawals (FY: <?php echo $ac1?>)</td>
							<?php
								$Company = mysql_query("SELECT `Name` FROM `company` WHERE `Band`='".$bnds[0]."' AND `Name` NOT LIKE 'Training%' ") or die(mysql_error());
								while($cmp = mysql_fetch_array($Company)){
									$TC = odbc_exec($conn, "SELECT COUNT([No_]) FROM [Temp Student] WHERE [Student Status] = 3 AND [Company Name]='".$cmp[0]."' AND [Academic Year]='".$ac1."'") or die(odbc_errormsg($conn));
									echo "<td>".odbc_result($TC, '')."</td>";
								}
							?>
						</tr>
						<tr>
							<td>No. of Sections</td>
							<?php
								$Company = mysql_query("SELECT `Name` FROM `company` WHERE `Band`='".$bnds[0]."' AND `Name` NOT LIKE 'Training%' ") or die(mysql_error());
								while($cmp = mysql_fetch_array($Company)){
									$Section = odbc_exec($conn, "SELECT COUNT([Class Code]) FROM [Class SECTION] WHERE [Company Name]='".$cmp[0]."' AND [Section] <> 'SNA' ") or die(odbc_errormsg($conn));
									echo "<td>".odbc_result($Section, '')."</td>";
								}
							?>
						</tr>
						<tr>
							<td>Highest Class</td>
							<?php
								$Company = mysql_query("SELECT `Name` FROM `company` WHERE `Band`='".$bnds[0]."' AND `Name` NOT LIKE 'Training%' ") or die(mysql_error());
								while($cmp = mysql_fetch_array($Company)){
									$ClassCode = odbc_exec($conn, "SELECT [Code] FROM [Class] WHERE [Company Name]='".$cmp[0]."' AND [Sequence] IN (SELECT MAX([Sequence]) FROM [Class] WHERE [Company Name]='".$cmp[0]."')") or die(odbc_errormsg($conn));
									echo "<td>".odbc_result($ClassCode, 'Code')."</td>";
								}
							?>
						</tr>
						<tr>
							<td>Admission Target (FY <?php echo $ac2?>)</td>
							<?php								
								$Company = mysql_query("SELECT `Name` FROM `company` WHERE `Band`='".$bnds[0]."' AND `Name` NOT LIKE 'Training%' ") or die(mysql_error());
								while($cmp = mysql_fetch_array($Company)){
									//echo "SELECT SUM([Total Addmissions]) From schoolerp.dbo.[".$cmp[0]."\$Edu Calendar Entry] WHERE [Academic Year]='$ac2' <br />";
									$NxtTarget = odbc_exec($conn, "SELECT SUM([Total Addmissions]) From schoolerp.dbo.[".$cmp[0]."\$Edu Calendar Entry] WHERE [Academic Year]='$ac2' ") or exit(odbc_errormsg($conn));
									echo "<td>".round(odbc_result($NxtTarget, ""),0)."</td>";
								}
							?>
						</tr>
						<tr>
							<td>Admission till Date (FY <?php echo $ac2?>)</td>							
							<?php								
								$Company = mysql_query("SELECT `Name` FROM `company` WHERE `Band`='".$bnds[0]."' AND `Name` NOT LIKE 'Training%' ") or die(mysql_error());
								while($cmp = mysql_fetch_array($Company)){
									$admsnInDate1 = odbc_exec($conn, "SELECT COUNT([No_]) FROM [Temp Student] WHERE [Company Name]='".$cmp[0]."' AND [Admission For Year]='$ac2' ") or exit(odbc_errormsg($conn));
									echo "<td>".round(odbc_result($admsnInDate1, ""),0)."</td>";
								}
							?>
						</tr>
						<tr>
							<td>No. of Teaching Staff</td><td></td>
						</tr>
						<tr>
							<td>No. of Non-Teaching Staff</td><td></td>
						</tr>
					</table>
				</div>
				<!--
				<div class = "tab-pane fade in" id = "band1">
					<p>Tutorials Point is a place for beginners in all technical areas.
					This website covers most of the latest technologies and explains each of
					the technology with simple examplesasdadasdasdasasdads. You also have a 
					<b>tryit</b> editor, wherein you can edit your code and 
					try out different possibilities of the examples.</p>
				</div>
				-->
				<?php
						$c++;
					}
				?>
			</div>
		</div>
<?php require_once("../footer.php");?>


