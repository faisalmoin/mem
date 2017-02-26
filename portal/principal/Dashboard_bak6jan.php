<?php
    $today = date('Y-m-d')." 00:00:00";
    $wkday = date('Y-m-d ', strtotime("7 days ago"))." 00:00:00";
    $AssYear = odbc_exec($conn, "select TOP 1 [Start Date], [End Date], [Code] FROM [Academic Year] WHERE NOT ([Start Date] > '$today' OR [End Date]  < '$today') AND [Company Name]='".$ms."'") or die(odbc_errormsg($conn));
    if(odbc_num_rows($AssYear) == 0){
        $AssYear = odbc_exec($conn, "select TOP 1 MIN([Enquiry Date]) AS [Start Date], MAX([Enquiry Date]) AS [End Date] FROM [Temp Enquiry] WHERE [Company Name]='".$ms."'") or die(odbc_errormsg($conn));
    }

?>

 <!-- Font Awesome -->
<link href="../vendors/font-awesome/css/font-awesome.min.css" rel="stylesheet">
<!-- NProgress -->
<link href="../vendors/nprogress/nprogress.css" rel="stylesheet">

<!-- Body -->
<div class="right_col" role="main" style="border-left: 1px solid #d2d2d2;">
<div class="">
<div class="page-title">
<div class="title_left">
<!-- h2>Dashboard <small>| Academic Year: <?php echo odbc_result($AssYear, "Code");?></small></h2 -->
</div>

<div class="clearfix"></div>
    <!-- Blocks at Top -->
            <div class="row top_tiles">
                <?php
                    $sql1 = "SELECT COUNT([No_]) FROM [Temp Enquiry] WHERE ([Admission for Year]='".odbc_result($AssYear, "Code")."') AND [Company Name]='".$ms."'";
                    $Enq = odbc_exec($conn,$sql1);
                ?>
                <div class="animated flipInY col-lg-3 col-md-3 col-sm-6 col-xs-12">
                    <div class="tile-stats">
                        <div class="icon"><i class="fa fa-comments-o"></i></div>
                        <div class="count"><?php echo odbc_result($Enq, "")?></div>
                        <h3>Enquiry</h3>
                        <p> </p>
                    </div>
                </div>
                <?php
                    $sql2 = "SELECT COUNT(*) FROM [Temp Enquiry] WHERE ([Admission for Year]='".odbc_result($AssYear, "Code")."') AND ([Registration Status] = 1 OR [Registration Status] = 2) AND [Company Name]='".$ms."'";
                    $Reg = odbc_exec($conn,$sql2);
                ?>
                <div class="animated flipInY col-lg-3 col-md-3 col-sm-6 col-xs-12">
                    <div class="tile-stats">
                        <div class="icon"><i class="fa fa-refresh"></i></div>
                        <div class="count"><?php echo odbc_result($Reg, "")?></div>
                        <h3>Registration</h3>
                        <p> </p>
                    </div>
                </div>
                <?php
                    $sql4 = "SELECT COUNT(*) FROM [Temp Student] WHERE ([Admission for Year]='".odbc_result($AssYear, "Code")."') AND [Company Name]='".$ms."' ";
                    $Sel = odbc_exec($conn,$sql4);
                ?>
                <div class="animated flipInY col-lg-3 col-md-3 col-sm-6 col-xs-12">
                    <div class="tile-stats">
                        <div class="icon"><i class="fa fa-check-square-o"></i></div>
                        <div class="count"><?php echo odbc_result($Sel, "")?></div>
                        <h3>Admission</h3>
                        <p> </p>
                    </div>
                </div>
                <?php
                    $sql4 = "SELECT COUNT(*) FROM [Temp Student] WHERE ([Academic Year]='".odbc_result($AssYear, "Code")."') AND [Company Name]='".$ms."' AND [Student Status]=1 ";
                    $Adm = odbc_exec($conn,$sql4);
                ?>
                <div class="animated flipInY col-lg-3 col-md-3 col-sm-6 col-xs-12">
                    <div class="tile-stats">
                        <div class="icon"><i class="fa fa-group"></i></div>
                        <div class="count"><?php echo odbc_result($Adm, "")?></div>
                        <h3>Student</h3>
                        <p> </p>
                    </div>
                </div>
            </div>
            <!-- /Blocks at Top -->
            <!-- Second Row -->
            <div class="row">
                <div class="col-md-12">
                    <div class="x_panel">
                        <div class="x_title">
                            <h2>Transaction Summary <small>Weekly progress</small></h2>
                            <div class="clearfix"></div>
                        </div>
                        <!-- Graph part -->
                        <div class="x_content">                            
                            <div class="col-md-9 col-sm-12 col-xs-12">
                                <div class="demo-container" style="height:280px">
                                    <div id="placeholder33x" class="demo-placeholder"></div>
                                </div>
                                <?php
                                  $FeeGen = odbc_exec($conn, "SELECT SUM([Credit Amount]) AS [Crd_Amt] from [Ledger Credit] WHERE [FinYr]='".odbc_result($AssYear, "Code")."' AND [Reverse]=0 AND [Company Name]='$ms'") or die(odbc_errormsg($conn));

                                  $FeeDbt = odbc_exec($conn, "SELECT SUM([Debit Amount]) AS [Dbt_Amt] from [Ledger Debit] WHERE [FinYr]='".odbc_result($AssYear, "Code")."' AND [Reverse]=0 AND [Company Name]='$ms'") or die(odbc_errormsg($conn));

                                  $FeeOS = number_format(odbc_result($FeeGen, "Crd_Amt") - odbc_result($FeeDbt, "Dbt_Amt"),2);

                                ?>
                            <div class="tiles">
                                <div class="col-md-4 tile">
                                    <span>Fees Generated</span>
                                    <h2><span class="fa fa-inr"></span> <?php echo number_format(odbc_result($FeeGen, "Crd_Amt"), 2);?></h2>
                                    <span class="sparkline11 graph" style="height: 160px;">
                                        <canvas width="200" height="60" style="display: inline-block; vertical-align: top; width: 94px; height: 30px;"></canvas>
                                    </span>
                                </div>
                                <div class="col-md-4 tile">
                                    <span> Fees Collected</span>
                                    <h2><span class="fa fa-inr"></span> <?php echo number_format(odbc_result($FeeDbt, "Dbt_Amt"), 2);?></h2>
                                    <span class="sparkline22 graph" style="height: 160px;">
                                        <canvas width="200" height="60" style="display: inline-block; vertical-align: top; width: 94px; height: 30px;"></canvas>
                                    </span>
                                </div>
                                <div class="col-md-4 tile">
                                    <span>Fee Outstanding</span>
                                    <h2><span class="fa fa-inr"></span> <?php echo $FeeOS;?></h2>
                                    <span class="sparkline11 graph" style="height: 160px;">
                                        <canvas width="200" height="60" style="display: inline-block; vertical-align: top; width: 94px; height: 30px;"></canvas>
                                    </span>
                                </div>
                            </div>
                        </div>
                        <!-- / Graph part -->
                        
                        <!-- Overdue Customers -->
                        <div class="col-md-3 col-sm-12 col-xs-12">
                            <div>
                                <div class="x_title">
                                    <h2>Overdue Customers</h2>
                                    <div class="clearfix"></div>
                                </div>
                                <ul class="list-unstyled top_profiles scroll-view">
                                    <?php 
                                        $i = 1;
                                        $query = "SELECT DISTINCT([Customer No]) FROM  [Ledger Credit] WHERE [Reverse]=0 AND [Company Name]='$ms' ";

                                        $rs = odbc_exec($conn, $query) or die(odbc_errormsg($conn));
                                        while(odbc_fetch_array($rs)){
                                        $x = odbc_exec($conn, "SELECT SUM([Credit Amount]) FROM [Ledger Credit] WHERE [Company Name]='$ms' AND [Reverse]=0 AND [Customer No]='".odbc_result($rs, "Customer No")."' ") or die(odbc_errormsg($conn));
                                        $y = odbc_exec($conn, "SELECT SUM([Debit Amount] + [Adv Fee]) FROM [Ledger Debit] WHERE [Company Name]='$ms' AND [Reverse]=0 AND [Customer No]='".odbc_result($rs, "Customer No")."' ") or die(odbc_errormsg($conn));

                                        $diff = odbc_result($x, "") - odbc_result($y, "");

                                        if($diff > 0){
                                            $Admission = odbc_exec($conn, "SELECT [No_] FROM [Temp Student] WHERE [Registration No_]='".odbc_result($rs, "Customer No")."' AND [Company Name]='$ms'") or die(odbc_errormsg($conn)); 
                                            $AdmissionNo = odbc_result($Admission, "No_");

                                            $cust = odbc_exec($conn, "SELECT [Name], [Class], [Academic Year], [Section] FROM [Temp Application] WHERE [Company Name]='$ms' AND [System Genrated No_]='".odbc_result($rs, "Customer No")."' ") or die(odbc_errormsg($conn));
                                            if($AdmissionNo){
                                    ?>
                                    <li class="media event">
                                        
                                        <?php
                                          if($i % 2 == 0){ echo '<a class="pull-left border-green profile_thumb"><i class="fa fa-user green"></i>';}
                                          else if ($i % 3 == 0){ echo '<a class="pull-left border-blue profile_thumb"><i class="fa fa-user blue"></i>';}
                                          else { echo '<a class="pull-left border-aero profile_thumb"><i class="fa fa-user aero"></i>';}
                                        ?>
                                            
                                        </a>
                                        <div class="media-body">
                                            <a class="title" href="#"><?php echo odbc_result($cust, "Name")?> (<?php echo $AdmissionNo;?>)</a>
                                            <p><?php echo odbc_result($cust, "Class")?> - <?php echo odbc_result($cust, "Section")?>
                                                </p>
                                            <p>O/S <span class="fa fa-inr"></span><strong> <?php echo number_format($diff,2,'.','');?></strong> </p>
                                            <p> <!-- small>12 Sales Today</small --></p>
                                        </div>
                                    </li>
                                    <?php 
                                                        $i++;
                                                    }

                                                }
                                            
                                            if($i > 5 ) {break;}
                                        }
                                    ?>


                                </ul>
                                <br />
                                <a class="pull-right" href="FeeOutstanding.php">View all</a>
                            </div>
                        </div>
                        <!-- / Over due customer -->
                    </div>
            </div>
            <!-- / Second row -->

            <!-- Bottom Panel -->
            <div class="row">
              <div class="col-md-4">
                <div class="x_panel">
                  <div class="x_title">
                    <h2>Student's Approvals Pending</h2>
                    
                    <div class="clearfix"></div>
                  </div>
                  <div class="x_content">
                  <?php
                    $i=1;
                    $App = odbc_exec($conn, "SELECT Distinct[Student No_] FROM [Student Card Changes] WHERE [Company Name]='$ms' AND [Status]=0") or die(odbc_errormsg($conn)); 
                    while(odbc_fetch_array($App)){
                      $pa_dt = odbc_exec($conn, "SELECT MAX([Changes Date]) AS [PA_DT] FROM [Student Card Changes] WHERE [Company Name]='$ms' AND [Status]=0 AND [Student No_]='".odbc_result($App, "Student No_")."'") or die(odbc_errormsg($conn));
                      $rs = odbc_exec($conn, "SELECT [Name], [Class], [Section] FROM [Temp Student] WHERE [No_]='".odbc_result($App, "Student No_")."' AND [Company Name]='$ms'") or die(odbc_errormsg($conn));
                    
                  ?>
                    <article class="media event">
                      <a class="pull-left date">
                        <p class="month"><?php echo date("M'y", odbc_result($pa_dt, "PA_DT")); ?></p>
                        <p class="day"><?php echo date('d', odbc_result($pa_dt, "PA_DT")); ?></p>
                      </a>
                      <div class="media-body">
                        <a class="title" href="#">[<?php echo odbc_result($App, "Student No_");?>] <?php echo odbc_result($rs, 'Name');?></a>
                        
                        <p>Class : <b><?php echo odbc_result($rs, 'Class');?></b> Section : <b><?php echo odbc_result($rs, 'Section');?></b> </p>
                      </div>
                    </article>
                    <?php
                        $i++;
                        if($i>6){break;}
                      }
                    ?>
                    <a href="StudentCardApp.php" class="pull-right">View all </a>
                  </div>
                </div>
              </div>

              <div class="col-md-4">
                <div class="x_panel">
                  <div class="x_title">
                    <h2>Fees-in-Pipeline</h2>
                    
                    <div class="clearfix"></div>
                  </div>
                  <div class="x_content">
                    <?php 
                      $i = 1;

                      $query = "SELECT TOP 5 * FROM [Ledger Debit] WHERE [Company Name]='$ms' AND [Reverse]=0 AND [Payment Realization]=0";

                      $rs = odbc_exec($conn, $query) or die(odbc_errormsg($conn));
                      while(odbc_fetch_array($rs)){
                        $cust = odbc_exec($conn, "SELECT [Name], [Class], [Section] FROM [Temp Application] WHERE [Company Name]='$ms' AND [System Genrated No_]='".odbc_result($rs, "Customer No")."' ") or die(odbc_errormsg($conn));
                        $Admission = odbc_exec($conn, "SELECT [No_] FROM [Temp Student] WHERE [Registration No_]='".odbc_result($rs, "Customer No")."' AND [Company Name]='$ms'") or die(odbc_errormsg($conn));
                    ?>
                    <article class="media event">
                      <a class="pull-left date">
                        <p class="month"><?php echo date("M'y", odbc_result($rs, "Payment Date"))?></p>
                        <p class="day"><?php echo date('d', odbc_result($rs, "Payment Date"))?></p>
                      </a>
                      <div class="media-body">
                        <a class="title" href="#">[<?php echo $AdmissionNo;?>] <?php echo odbc_result($cust, "Name")?> <small><?php echo odbc_result($cust, "Class")?>-<?php echo odbc_result($cust, "Section")?></small></a>
                        <p>
                          Amount: <span class="fa fa-inr"></span> <b><?php echo number_format((odbc_result($rs, "Debit Amount")+odbc_result($rs, "Adv Fee")),2,'.','')?></b> Payment Mode: <?php echo odbc_result($rs, "Payment Mode")?> Payment Date: <?php echo date('d/M/Y', odbc_result($rs, "Payment Date"))?>
                        </p>
                      </div>
                    </article> 
                    <?php 
                        $i++;
                      }
                    ?>
                    <a href="FeePipeline.php" class="pull-right">View all </a>
                  </div>
                </div>
              </div>

              <div class="col-md-4">
                <div class="x_panel">
                  <div class="x_title">
                    <h2>Calendar</h2>
                    
                    <div class="clearfix"></div>
                  </div>
                  <div class="x_content">
                    <?php
                      $Cal = odbc_exec($conn, "SELECT TOP 5 * FROM [Calendar] WHERE [Start Date] <= '".strtotime(date('m/d/Y'))."' ORDER BY [Start Date] ASC ") or die(odbc_errormsg($conn));
                      while(odbc_fetch_array($Cal)){
                    ?>
                    <article class="media event">
                      <a class="pull-left date">
                        <p class="month"><?php echo date("M'y", odbc_result($Cal, "Start Date"))?></p>
                        <p class="day"><?php echo date('d', odbc_result($Cal, "Start Date"))?></p>
                      </a>
                      <div class="media-body">
                        <a class="title" href="#"><?php echo odbc_result($Cal, "Description")?></a>
                        <p>
                          <?php
                            if(odbc_result($Cal, "Activity Type")== '1'){ echo "Holiday"; }
                            else if (odbc_result($Cal, "Activity Type")== '2'){ echo "Event"; }
                            else if (odbc_result($Cal, "Activity Type")== '3'){ echo "Weekly off"; }
                          ?>

                        </p>
                      </div>
                    </article>
                    <?php
                      }
                    ?>
                    <a href="CalendarList.php" class="pull-right">View all </a>
                  </div>
                </div>
            </div>
            </div>
            </div>
            <div class="clearfix"></div>


            <!-- / Bottom Panel -->
            <!-- Bottom Panel -->
            <div class="row">
              <div class="col-md-4">
                <div class="x_panel">
                    <div class="x_title">
                    <h2>Pending PO Approval</h2>
                    
                    <div class="clearfix"></div>
                    </div>
                    <div class="x_content">
                    <?php
                        $SQL = "SELECT * from [VMS Item Requisition] WHERE (Status='0' OR Status='3')  AND [Company Name]='$ms'";
                        $Cal_r = odbc_exec($conn, $SQL) or die(odbc_errormsg($conn));
                        while(odbc_fetch_array($Cal_r)){
                    ?>
                        <div class="media-body">
                            <a class="title" href="#"><?php echo odbc_result($Cal_r, "Item Name")?></a>
                            <p><?php echo odbc_result($Cal_r, "Specification")?></p>
                            <p>Qty : <?php echo odbc_result($Cal_r, "Qty")?> Price : <span class="fa fa-inr"> <?php echo odbc_result($Cal_r, "Price")?></span></p>
                            <p>Purpose : <?php echo odbc_result($Cal_r, "Price")?></p>
                        </div>
                    <?php
                        }
                    ?>
                        <a href="Principal_Approval.php" class="pull-right">View all </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>
</div>
</div>
</div>
</div>
<!-- /Body -->

<!-- Page Classes -->

    <!-- jQuery -->
    <script src="../vendors/jquery/dist/jquery.min.js"></script>
    <!-- Bootstrap -->
    <script src="../vendors/bootstrap/dist/js/bootstrap.min.js"></script>
    <!-- FastClick -->
    <script src="../vendors/fastclick/lib/fastclick.js"></script>
    <!-- NProgress -->
    <script src="../vendors/nprogress/nprogress.js"></script>
    <!-- Chart.js -->
    <script src="../vendors/Chart.js/dist/Chart.min.js"></script>
    <!-- jQuery Sparklines -->
    <script src="../vendors/jquery-sparkline/dist/jquery.sparkline.min.js"></script>
    <!-- Flot -->
    <script src="../vendors/Flot/jquery.flot.js"></script>
    <script src="../vendors/Flot/jquery.flot.pie.js"></script>
    <script src="../vendors/Flot/jquery.flot.time.js"></script>
    <script src="../vendors/Flot/jquery.flot.stack.js"></script>
    <script src="../vendors/Flot/jquery.flot.resize.js"></script>
    <!-- Flot plugins -->
    <script src="../vendors/flot.orderbars/js/jquery.flot.orderBars.js"></script>
    <script src="../vendors/flot-spline/js/jquery.flot.spline.min.js"></script>
    <script src="../vendors/flot.curvedlines/curvedLines.js"></script>
    <!-- DateJS -->
    <script src="../vendors/DateJS/build/date.js"></script>
    <!-- bootstrap-daterangepicker -->
    <script src="../vendors/moment/min/moment.min.js"></script>
    <script src="../vendors/bootstrap-daterangepicker/daterangepicker.js"></script>
    
    <!-- Custom Theme Scripts -->
    <script src="../build/js/custom.min.js"></script>
    <!-- jQuery custom content scroller -->
    <script src="../vendors/malihu-custom-scrollbar-plugin/jquery.mCustomScrollbar.concat.min.js"></script>

    <!-- jQuery Sparklines -->
    <script type="text/javascript">
      $(document).ready(function() {   
        <?php
          $fee_gen = odbc_exec($conn, "SELECT COUNT([Invoice Date]) AS [Inv_dt], [Description] FROM [Ledger Credit] WHERE [FinYr]='".odbc_result($AssYear, "Code")."' AND [Reverse]=0 AND [Company Name]='$ms' GROUP BY [Description]") or die(odbc_errormsg($conn));
          while(odbc_fetch_array($fee_gen)){
            $val11 .= odbc_result($fee_gen, "Inv_dt").", ";
          }
          $val11 = substr($val11, 0, -2);
        ?>     
        $(".sparkline11").sparkline([<?php echo $val11;?>], {
          type: 'bar',
          height: '40',
          barWidth: 8,
          colorMap: {
            '7': '#a1a1a1'
          },
          barSpacing: 2,
          barColor: '#26B99A'
        });
        <?php
          $fee_rcv = odbc_exec($conn, "SELECT [Description], COUNT([Payment Date]) AS [Inv_Dr] FROM [Ledger Debit] WHERE [FinYr]='".odbc_result($AssYear, "Code")."' AND [Reverse]=0 AND [Company Name]='$ms' GROUP BY [Description]") or die(odbc_errormsg($conn));
          while(odbc_fetch_array($fee_rcv)){
            $val22 .= odbc_result($fee_rcv, "Inv_Dr").", ";
          }
          $val22 = substr($val22, 0, -2);
        ?>
        $(".sparkline22").sparkline([<?php echo $val22?>], {
          type: 'line',
          height: '40',
          width: '200',
          lineColor: '#26B99A',
          fillColor: '#ffffff',
          lineWidth: 3,
          spotColor: '#34495E',
          minSpotColor: '#34495E'
        });
      });
    </script>
    <!-- /jQuery Sparklines -->
    <!-- Flot -->
    <script>
      $(document).ready(function() {
        //define chart clolors ( you maybe add more colors if you want or flot will add it automatic )
        var chartColours = ['#96CA59', '#3F97EB', '#72c380', '#6f7a8a', '#f7cb38', '#5a8022', '#2c7282'];

        //generate random number for charts
        randNum = function() {
          return (Math.floor(Math.random() * (1 + 40 - 20))) + 20;
        };

        var d1 = [];
        //var d2 = [];

        //here we generate data for chart
        for (var i = 0; i < 30; i++) {
          d1.push([new Date(Date.today().add(i).days()).getTime(), randNum() + i + i + 10]);
          //    d2.push([new Date(Date.today().add(i).days()).getTime(), randNum()]);
        }

        var chartMinDate = d1[0][0]; //first day
        var chartMaxDate = d1[20][0]; //last day

        var tickSize = [1, "day"];
        var tformat = "%d/%m/%y";

        //graph options
        var options = {
          grid: {
            show: true,
            aboveData: true,
            color: "#3f3f3f",
            labelMargin: 10,
            axisMargin: 0,
            borderWidth: 0,
            borderColor: null,
            minBorderMargin: 5,
            clickable: true,
            hoverable: true,
            autoHighlight: true,
            mouseActiveRadius: 100
          },
          series: {
            lines: {
              show: true,
              fill: true,
              lineWidth: 2,
              steps: false
            },
            points: {
              show: true,
              radius: 4.5,
              symbol: "circle",
              lineWidth: 3.0
            }
          },
          legend: {
            position: "ne",
            margin: [0, -25],
            noColumns: 0,
            labelBoxBorderColor: null,
            labelFormatter: function(label, series) {
              // just add some space to labes
              return label + '&nbsp;&nbsp;';
            },
            width: 40,
            height: 1
          },
          colors: chartColours,
          shadowSize: 0,
          tooltip: true, //activate tooltip
          tooltipOpts: {
            content: "%s: %y.0",
            xDateFormat: "%d/%m",
            shifts: {
              x: -30,
              y: -50
            },
            defaultTheme: false
          },
          yaxis: {
            min: 0
          },
          xaxis: {
            mode: "time",
            minTickSize: tickSize,
            timeformat: tformat,
            min: chartMinDate,
            max: chartMaxDate
          }
        };
        var plot = $.plot($("#placeholder33x"), [{
          label: "",
          data: d1,
          lines: {
            fillColor: "rgba(150, 202, 89, 0.12)"
          }, //#96CA59 rgba(150, 202, 89, 0.42)
          points: {
            fillColor: "#fff"
          }
        }], options);
      });
    </script>
    <!-- /Flot -->

<?php require_once "../footer.php"; ?>