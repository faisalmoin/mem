<?php
	$today = date('Y-m-d')." 00:00:00";
	$AssYear = odbc_exec($conn, "select [Start Date], [End Date], [Code] FROM [Academic Year] WHERE [Start Date] > '2015-11-16' AND [Company Name]='".$ms."'") or die(odbc_errormsg($conn));
	
	/*
	$AssYear = odbc_exec($conn, "SELECT MAX([Code]) FROM [Academic Year] WHERE  [Start Date] <= '$today' AND [Company Name]='".$ms."'") or die(odbc_errormsg($conn));
	
	$Dates = odbc_exec($conn, "SELECT [Start Date], [End Date] FROM [Academic Year] WHERE  [Code] = '".odbc_result($AssYear, "")."' AND [Company Name]='$ms'") or die(odbc_errormsg($conn));
	$sYr = date('Y', strtotime(odbc_result($Dates, 'Start Date'))); 
	$sMnth = date('m', strtotime(odbc_result($Dates, 'Start Date'))); 
	$eYr = date('Y', strtotime(odbc_result($Dates, 'End Date'))); 
	$eMnth = date('m', strtotime(odbc_result($Dates, 'End Date'))); 
	*/
?>
<script src="../bs/js/Chart.js" language="JavaScript"></script>
<!-- Custom styles for this template -->
<div class="container">
	
    <div class="col-sm-10 col-sm-offset-1 main">
        <h1>Dashboard <small>| Academic Year: <?php echo odbc_result($AssYear, "Code");?></small></h1>
                <?php
                    //$sql1 = "SELECT COUNT(*) FROM [Temp Enquiry] WHERE [Admission For Year] IN (SELECT MAX([Admission For Year]) FROM [Temp Enquiry]) AND [User ID]='$LoginID' AND [Company Name]='".$ms."'";
		    $sql1 = "SELECT COUNT([No_]) FROM [Temp Enquiry] WHERE YEAR([Enquiry Date])='$sYr' AND YEAR([Enquiry Date])<='$eYr' AND MONTH([Enquiry Date]) >=04 AND [User ID]='$LoginID' AND [Company Name]='".$ms."'";
		    $Enq = odbc_exec($conn,$sql1);
                ?>
    <hr>
        <div class="row">
            <div class="col-md-3 col-sm-12 col-xs-12">
                <div class="panel panel-primary text-center no-boder bg-color-green" style="background-color: #0088cc;">
                    <div class="panel-right pull-center" style="background-color: #0088cc; color: #ffffff; font-weight: bolder; font-size: 24px;">
                        <h1><?php echo odbc_result($Enq, "")?></h1>
                        <strong> Enquiry</strong>
                    </div>
                </div>
            </div>
            <?php
            $sql2 = "SELECT COUNT(*) FROM [Temp Enquiry] WHERE YEAR([Enquiry Date])='$sYr' AND YEAR([Enquiry Date])<='$eYr' AND MONTH([Enquiry Date]) >=04 AND [User ID]='$LoginID' AND ([Registration Status] = 1 OR [Registration Status] = 2) AND [Company Name]='".$ms."'";
            $Reg = odbc_exec($conn,$sql2);
            ?>
            <div class="col-md-3 col-sm-12 col-xs-12">
                <div class="panel panel-primary text-center no-boder bg-color-blue"  style="background-color: #449d44;">
                    <div class="panel-right pull-center" style="background-color: #449d44; color: #ffffff; font-weight: bolder; font-size: 24px;">
                        <h1><?php echo odbc_result($Reg, "")?> </h1>
                        <strong> Registration</strong>
                    </div>
                </div>
            </div>
            <?php
            $sql3 = "SELECT COUNT(*) FROM [Temp Application] WHERE YEAR([Date of Receive])='$sYr' AND YEAR([Date of Receive])<='$eYr' AND MONTH([Date of Receive]) >='04' AND [User ID]='$LoginID' AND [Registration Status] = 3 AND [Company Name]='".$ms."'";
	    $Sel = odbc_exec($conn,$sql3);
            ?>
            <div class="col-md-3 col-sm-12 col-xs-12">
                <div class="panel panel-primary text-center no-boder bg-color-green" style="background-color: #DE70CC; border-color: #DE70CC;">
                    <div class="panel-right pull-center" style="background-color: #DE70CC; color: #ffffff; font-weight: bolder; font-size: 24px;">
                        <h1><?php echo odbc_result($Sel, "")?></h1>
                        <strong> Selection </strong>
                    </div>
                </div>
            </div>
            <?php
                $sql4 = "SELECT COUNT(*) FROM [Temp Student] WHERE YEAR([Date Joined])='$sYr' AND YEAR([Date Joined])<='$eYr' AND MONTH([Date Joined]) >=04 AND [User ID]='$LoginID' AND [Company Name]='".$ms."' ";
                $Adm = odbc_exec($conn,$sql4);
            ?>
            <div class="col-md-3 col-sm-12 col-xs-12">
                <div class="panel panel-primary text-center no-boder bg-color-blue"  style="background-color: #E6AB16; border-color: #E6AB16;">
                    <div class="panel-right pull-center" style="background-color: #E6AB16; color: #ffffff; font-weight: bolder;  font-size: 24px;">
                        <h1><?php echo odbc_result($Adm, "")?> </h1>
                        <strong>Admission</strong>
                    </div>
                </div>
            </div>
        </div>

        <hr>

        <div class="table-responsive">
            <div class="col-md-3 col-sm-12 col-xs-12">
                        <h3>Enquiry Status</h3>
                        <table class="table table-striped" >
                            <thead>
                            <tr style="font-weight: bold; background-color: #E6AB16; color: #fff;">
                                <td>Enquiry Status</td>
                                <td align="center">Count</td>
                            </tr>
                            </thead>
                            <tbody>
                            <?php
                            $EnqStat = odbc_exec($conn, "SELECT DISTINCT([Enquiry Status]) FROM [Temp Enquiry] WHERE [Company Name]='".$ms."' ORDER BY [Enquiry Status] ");
                            while(odbc_fetch_array($EnqStat)){
                                ?>
                                <tr>
                                    <td><?php
                                        if(odbc_result($EnqStat, "Enquiry Status")==0) echo "Cold";
                                        if(odbc_result($EnqStat, "Enquiry Status")==1) echo "Hot";
                                        if(odbc_result($EnqStat, "Enquiry Status")==2) echo "Warm";
                                        ?>
                                    </td>
                                    <td align="center">
                                        <?php
                                        $CntEnqStat = odbc_exec($conn, "SELECT COUNT(*) FROM [Temp Enquiry] WHERE [Enquiry Status]='".odbc_result($EnqStat, "Enquiry Status")."' AND  [Company Name]='".$ms."' AND [User ID]='$LoginID' AND YEAR([Enquiry Date])='$sYr' AND YEAR([Enquiry Date])<='$eYr' AND MONTH([Enquiry Date]) >=04 ");
                                        echo odbc_result($CntEnqStat, "");
                                        ?>
                                    </td>
                                </tr>
                            <?php
                            }
                            ?>
                            </tbody>
                        </table>
                </div>
                <div class="col-md-4 col-sm-12 col-xs-12">
                        <h3>Conversion <small>(Last 7 days)</small></h3>
                        <table class="table " >
                            <thead>
                            <tr style="font-weight: bold; background-color: #FF95AE; color: #fff;">
                                <td>Status</td>
                                <td align="center">Count</td>
                            </tr>
                            </thead>
                            <tbody>
                            <tr>
                                <td>Registration</td>
                                <td align="center">
                                    <?php
                                        $RegStat = odbc_exec($conn, "SELECT TOP 7 COUNT([No_]) FROM [Temp Application] WHERE [User ID]='$LoginID' AND  [Company Name]='".$ms."' AND [Date of Sale] < '$today'");
                                        echo odbc_result($RegStat, "");
                                    ?>
                                </td>
                            </tr>
                            <tr>
                                <td>Admission</td>
                                <td align="center">
                                    <?php
                                        $AdmStat = odbc_exec($conn, "SELECT TOP 7 COUNT([No_]) FROM [Temp Student] WHERE [User ID]='$LoginID' AND  [Company Name]='".$ms."' AND [Date Joined] <= '$today'");
                                        echo odbc_result($AdmStat, "");
                                    ?>
                                </td>
                            </tr>
                            </tbody>
                        </table>
                </div>
                <div class="col-md-5 col-sm-12 col-xs-12">
                    <div class="panel-right pull-center">
                    <div id="canvas-holder" align="center">
                        <canvas id="chart-area" width="200" height="200"/>
                    </div>
                    </div>
                    <script>

                        var polarData = [
                            {
                                value: <?php echo odbc_result($Enq, "")?>,
                                color:"#0088cc",
                                highlight: "#FF5A5E",
                                label: "Enquiry"
                            },
                            {
                                value: <?php echo odbc_result($Reg, "")?>,
                                color: "#449D44",
                                highlight: "#5AD3D1",
                                label: "Registration"
                            },
                            {
                                value: <?php echo odbc_result($Sel, "")?>,
                                color: "#DE70CC",
                                highlight: "#FFC870",
                                label: "Selection"
                            },
                            {
                                value: <?php echo odbc_result($Adm, "")?>,
                                color: "#E6AB16",
                                highlight: "#A8B3C5",
                                label: "Admission"
                            }

                        ];

                        window.onload = function(){
                            var ctx = document.getElementById("chart-area").getContext("2d");
                            window.myPolarArea = new Chart(ctx).PolarArea(polarData, {
                                responsive:true
                            });
                        };
                    </script>
                </div>
        </div>

        <hr>

        <div class="table-responsive">
            <h3>Next Enquiry Follow-up</h3>
            <?php
                $Followups = odbc_exec($conn, "SELECT TOP 7 * FROM [Temp Enquiry] WHERE [User ID]='$LoginID' AND  [Company Name]='".$ms."' AND [Registration Status]=0 AND [Next FollowUp Date] >= '$today' ORDER BY [Next FollowUp Date] ASC");
            ?>
            <table class="table table-striped table-hover">
                <thead>
                    <tr style="font-weight: bold; background-color: #0088cc; color: #fff;">
                        <td>SN</td>
                        <td>Candidate Name</td>
                        <td>Father's Name</td>
                        <td>Mother's Name</td>
                        <td>Mobile Number</td>
                        <td>Admission for Class</td>
                        <td>Academic Year</td>
                        <td>Enquiry Status</td>
                        <td>Date</td>
                    </tr>
                </thead>
                <tbody>
                    <?php
                        $i=1;
                        while(odbc_fetch_array($Followups)){
                    ?>
                    <tr>
                        <td><?php echo $i?></td>
                        <td><?php echo odbc_result($Followups,"Name")?></td>
                        <td><?php echo odbc_result($Followups,"Father_s Name")?></td>
                        <td><?php echo odbc_result($Followups,"Mother_s Name")?></td>
                        <td><?php echo odbc_result($Followups,"Mobile Number")?></td>
                        <td><?php echo odbc_result($Followups,"Class Applied")?></td>
                        <td><?php echo odbc_result($Followups,"Admission For Year")?></td>
                        <td><?php
                                if(odbc_result($Followups,"Enquiry Status")==0) echo "Hot";
                                if(odbc_result($Followups,"Enquiry Status")==1) echo "Cold";
                                if(odbc_result($Followups,"Enquiry Status")==2) echo "Warm";
                            ?></td>
                        <td><?php echo date('d/M/Y', strtotime(odbc_result($Followups,"Next Followup Date"))); ?></td>
                    </tr>
                    <?php
                            $i += 1;
                        }

                    ?>

                </tbody>
            </table>

        </div>

        </div>
</div>
