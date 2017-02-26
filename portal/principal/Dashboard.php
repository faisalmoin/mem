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
                        <div class="count green"><?php echo odbc_result($Reg, "")?></div>
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
                        <div class="count blue"><?php echo odbc_result($Sel, "")?></div>
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
                        <div class="count red"><?php echo odbc_result($Adm, "")?></div>
                        <h3>Student</h3>
                        <p> </p>
                    </div>
                </div>
            </div>
            <!-- /Blocks at Top -->
            <!-- Second Row -->
            <div class="row">
                <div class="col-md-9">
                    <div class="x_panel">
                        <div class="x_title">
                            <h2>Financials </h2>
                            <div class="clearfix"></div>
                        </div>
                        <!-- Graph part -->
                        <div class="x_content">
                        <?php
                          $FeeGen = odbc_exec($conn, "SELECT SUM([Credit Amount]) AS [Crd_Amt] from [Ledger Credit] WHERE [FinYr]='".odbc_result($AssYear, "Code")."' AND [Reverse]=0 AND [Company Name]='$ms'") or die(odbc_errormsg($conn));

                          $FeeDbt = odbc_exec($conn, "SELECT SUM([Debit Amount]) AS [Dbt_Amt] from [Ledger Debit] WHERE [FinYr]='".odbc_result($AssYear, "Code")."' AND [Reverse]=0 AND [Company Name]='$ms'") or die(odbc_errormsg($conn));

                          $FeeOS = number_format(odbc_result($FeeGen, "Crd_Amt") - odbc_result($FeeDbt, "Dbt_Amt"),2);

                          $FeePipe = odbc_exec($conn, "SELECT SUM([Debit Amount]) AS [Pipeline] FROM [Ledger Debit] WHERE [Company Name]='$ms' AND [Reverse]=0 AND [Payment Realization]=0") or die(odbc_errormsg($conn));

                        ?>                        
                            <div class="col-md-12 col-sm-12 col-xs-12" style="min-height: auto;">
                                <div class="col-md-3 tile">
                                    <span>Fees Generated</span>
                                    <h2><span class="fa fa-inr"></span> <?php echo number_format(odbc_result($FeeGen, "Crd_Amt"), 2);?></h2>
                                    <span class="sparkline11 graph" style="height: 160px;">
                                        <canvas width="200" height="60" style="display: inline-block; vertical-align: top; width: 94px; height: 30px;"></canvas>
                                    </span>
                                </div>
                                <div class="col-md-3 tile">
                                    <span> Fees Collected</span>
                                    <h2><span class="fa fa-inr"></span> <?php echo number_format(odbc_result($FeeDbt, "Dbt_Amt"), 2);?></h2>
                                    <span class="sparkline22 graph" style="height: 160px;">
                                        <canvas width="200" height="60" style="display: inline-block; vertical-align: top; width: 94px; height: 30px;"></canvas>
                                    </span>
                                </div>                                
                                <div class="col-md-3 tile">
                                    <span>Fee Outstanding</span>
                                    <a href="FeeOutstanding.php"><h2><span class="fa fa-inr"></span>  <?php echo $FeeOS;?></h2></a>
                                    <span class="sparkline11 graph" style="height: 160px;">
                                        <canvas width="200" height="60" style="display: inline-block; vertical-align: top; width: 94px; height: 30px;"></canvas>
                                    </span>
                                </div>                                
                                <div class="col-md-3 tile">
                                    <span>Fees-in-Pipeline</span>
                                    <a href="FeePipeline.php"><h2><span class="fa fa-inr"></span> <?php echo number_format(odbc_result($FeePipe, "Pipeline"), 2);?></h2>
                                    </a>
                                    <span class="sparkline11 graph" style="height: 160px;">
                                        <canvas width="200" height="60" style="display: inline-block; vertical-align: top; width: 94px; height: 30px;"></canvas>
                                    </span>
                                </div>
                            </div>
                            <p>&nbsp;</p>
                            <p>&nbsp;</p>
                            <p>&nbsp;</p>
                            <p>&nbsp;</p>
                        </div>
                    </div>
                </div>

                <div class="col-md-3 col-sm-12 col-xs-12">
                    <div class="x_panel">
                        <div class="x_title">
                            <h2>Pending Approvals</h2>
                            <div class="clearfix"></div>
                        </div>    
                        <div class="col-md-9">
                            <p>Student's Card</p>
                        </div>
                        <div class="col-md-3 title">
                        <?php
                            $StuCard = odbc_exec($conn, "SELECT COUNT(DISTINCT([Student No_])) AS [StCrd] FROM [Student Card Changes] WHERE [Company Name]='$ms' AND [Status]=0") or die(odbc_errormsg($conn));                            
                        ?>
                            <p><a href="StudentCardApp.php" class="pull-right"> <?php echo odbc_result($StuCard, "StCrd");?></a></p>
                        </div>
                        <div class="col-md-9">
                            <p>Transfer Certificate</p>
                        </div>
                        <div class="col-md-3 title">
                        <?php
                            $TCApply = odbc_exec($conn, "SELECT COUNT([TC No_]) AS [TCApply] FROM [Temp Transfer Certificate] WHERE [Company Name]='$ms' AND [TC Issued]=0") or die(odbc_errormsg($conn));                            
                        ?>
                            <p><a href="TCApply.php" class="pull-right"> <?php echo odbc_result($TCApply, "TCApply");?></a></p>
                        </div>                      
                        <div class="col-md-9">
                            <p>Purchase Order</p>     
                        </div>
                        <div class="col-md-3 title">
                        <?php
                            $POApp = odbc_exec($conn, "SELECT COUNT([Company Name]) AS [POApp] from [VMS Item Requisition] WHERE (Status='0' OR Status='3')  AND [Company Name]='$ms'") or die(odbc_errormsg($conn));                            
                        ?>
                            <p><a href="Principal_Approval.php" class="pull-right"> <?php echo odbc_result($POApp, "POApp");?></a></p>
                        </div>                        
                    </div>
                </div>

                <div class="col-md-3 col-sm-12 col-xs-12">
                    <div class="x_panel">
                        <div class="x_title">
                            <h2>Manpower</h2>
                            <div class="clearfix"></div>
                        </div>
                        <div class="col-md-9">
                            <p>Teaching Staff</p>
                        </div>
                        <div class="col-md-3 title">
                        <?php
                            $Teach = odbc_exec($conn, "SELECT COUNT([Company Name]) AS [Teach] from [Employee] WHERE [Teaching Type]=1  AND [Company Name]='$ms'") or die(odbc_errormsg($conn));                            
                        ?>
                            <p><a href="EmployeeList.php" class="pull-right"> <?php echo odbc_result($Teach,"Teach")?></a></p>
                        </div>                        
                        <div class="col-md-9">
                            <p>Non-Teaching Staff</p>     
                        </div>
                        <div class="col-md-3 title">
                        <?php
                            $NoTeach = odbc_exec($conn, "SELECT COUNT([Company Name]) AS [NoTeach] from [Employee] WHERE [Teaching Type]=0  AND [Company Name]='$ms'") or die(odbc_errormsg($conn));                            
                        ?>
                            <p><a href="EmployeeList.php" class="pull-right"> <?php echo odbc_result($NoTeach,"NoTeach")?></a></p>
                        </div>                        
                    </div>
                </div>
            </div>      
            <!-- / Second row -->
            <!-- Third Row -->
            <div class="row">
                <div class="col-md-9 col-xs-12 col-sm-12">
                    <div class="x_panel">
                        <div class="x_title">
                            <h2>Class-wise Strength</h2>
                            <div class="clearfix"></div>
                        </div>
                        <div class="x_content">

                            <table id="datatable-buttons" class="table table-striped table-responsive">
                            <thead>
                            <tr style="font-weight: bold;">
                                <td>Class</td>
                                <?php
                                    $StuSec = odbc_exec($conn, "SELECT DISTINCT([Section]) FROM [Temp Student] WHERE [Company Name]='$ms' ORDER BY [Section]") or die(odbc_errormsg($conn));
                                    $colspan = odbc_num_rows($StuSec);
                                    while(odbc_fetch_array($StuSec)){
                                        echo "<td align='center'>".odbc_result($StuSec, 'Section')."</td>";
                                    }
                                ?>
                                <td align="center">TOTAL</td>
                            </tr>
                            </thead>
                            <tbody>
                            <?php
                                $StuClass = odbc_exec($conn, "SELECT [Code], [Description] FROM [Class] WHERE [Company Name]='$ms' ORDER BY [Sequence]");
                                
                                while(odbc_fetch_array($StuClass)){
                            ?>
                            <tr>
                                <td>
                                <?php echo odbc_result($StuClass, 'Description'); ?>
                                </td>
                                <?php
                                    $StuSecCount = odbc_exec($conn, "SELECT DISTINCT([Section]) FROM [Temp Student] WHERE [Company Name]='$ms' ORDER BY [Section]") or die(odbc_errormsg($conn));
                                    while(odbc_fetch_array($StuSecCount)){
                                    
                                        $CountStu = odbc_exec($conn, "SELECT COUNT([No_]) FROM [Temp Student] WHERE [Company Name]='$ms' AND [Class] = '".odbc_result($StuClass, 'Code')."' AND [Section] = '".odbc_result($StuSecCount, 'Section')."' AND [Academic Year] = '".odbc_result($AssYear, "Code")."' AND [Student Status] = 1 ");
                                        if(odbc_result($CountStu, '') != 0){
                                            echo "<td style='text-align: center; '>";
                                            echo "<a href='StudentClass.php?y=".odbc_result($AssYear, "Code")."&c=".odbc_result($StuClass, 'Code')."&s=".odbc_result($StuSecCount, 'Section')." '>".odbc_result($CountStu, '')."</a>";
                                        } else {
                                            echo "<td style='text-align: center; color: #e2e2e2;'>";
                                            echo odbc_result($CountStu, '');
                                        }
                                        echo "</td>";
                                    }
                                    $ClassStrength = odbc_exec($conn, "SELECT COUNT([No_]) FROM [Temp Student] WHERE [Company Name]='$ms' AND [Class] = '".odbc_result($StuClass, 'Code')."' AND [Academic Year] = '".odbc_result($AssYear, "Code")."' AND [Student Status] = 1 ");
                                    echo "<td style='text-align: center; '>".odbc_result($ClassStrength, '')."</td>";
                                ?>
                            </tr>                            
                            <?php
                                }
                            ?>
                            <tr style="font-size: 18px;">
                                <td colspan="<?php echo ($colspan+1)?>"><strong>TOTAL</strong></td>
                                <td style='text-align: center; '><b>
                                    <?php
                                        $SchStrength = odbc_exec($conn, "SELECT COUNT([No_]) FROM [Temp Student] WHERE [Company Name]='$ms' AND [Academic Year] = '".odbc_result($AssYear, "Code")."' AND [Student Status] = 1 ");
                                        echo odbc_result($SchStrength, '');
                                    ?></b>
                                </td>
                            </tr>
                            </tbody>
                            </table>                            

                        </div>
                    </div>
                </div>

              <div class="col-md-3 col-sm-12 col-xs-12">
                <div class="x_panel">
                  <div class="x_title">
                    <h2>Event of the month</h2>                    
                    <div class="clearfix"></div>
                  </div>
                  <div class="x_content">
                    <article class="media event">
                      <a class="pull-left date">
                        <p class="month">Jan'16</p>
                        <p class="day">01</p>
                      </a>
                      <div class="media-body">
                        <a class="title" href="#">New Year</a>
                        <p>
                          Holiday
                        </p>
                      </div>
                    </article>
                    <article class="media event">
                      <a class="pull-left date">
                        <p class="month">Jan'16</p>
                        <p class="day">26</p>
                      </a>
                      <div class="media-body">
                        <a class="title" href="#">Republic Day</a>
                        <p>
                          Holiday
                        </p>
                      </div>
                    </article>
                    <article class="media event">
                      <a class="pull-left date">
                        <p class="month">Mar'16</p>
                        <p class="day">24</p>
                      </a>
                      <div class="media-body">
                        <a class="title" href="#">Holi</a>
                        <p>
                          Holiday
                        </p>
                      </div>
                    </article>
                    <article class="media event">
                      <a class="pull-left date">
                        <p class="month">Mar'16</p>
                        <p class="day">25</p>
                      </a>
                      <div class="media-body">
                        <a class="title" href="#">Good Friday</a>
                        <p>
                          Holiday
                        </p>
                      </div>
                    </article>
                                        <article class="media event">
                      <a class="pull-left date">
                        <p class="month">Jul'16</p>
                        <p class="day">06</p>
                      </a>
                      <div class="media-body">
                        <a class="title" href="#">Id-Ul Fitr</a>
                        <p>
                          Holiday
                        </p>
                      </div>
                    </article>
                    <a href="CalendarList.php" class="pull-right">View all </a>
                  </div>
                </div>
            
                    <div class="x_panel">
                        <div class="x_title">
                            <h2>Birthdays</h2>
                            <div class="clearfix"></div>
                        </div>
                        <div class="col-md-9">
                            <p>Student</p>
                        </div>
                        <div class="col-md-3 title">
                            <p><a href="FeePipeline.php" class="pull-right"> 
                            <?php
                                $StuDOB=odbc_exec($conn, "SELECT COUNT([No_]) AS [StuDOB] FROM [Temp Student] WHERE [Date Of Birth]='".date('Y-m-d')."'") or die(odbc_errormsg($conn));
                                echo odbc_result($StuDOB, "StuDOB");
                            ?>
                            </a></p>
                        </div>                        
                        <div class="col-md-9">
                            <p>Teaching Staff</p>
                        </div>
                        <div class="col-md-3 title">
                            <p><a href="FeePipeline.php" class="pull-right"> 
                            <?php
                                $TeachDOB=odbc_exec($conn, "SELECT COUNT([No_]) AS [TeachDOB] FROM [Employee] WHERE [Birth Date]='".date('Y-m-d')."'") or die(odbc_errormsg($conn));
                                echo odbc_result($TeachDOB, "TeachDOB");
                            ?></a></p>
                        </div>                        
                        <div class="col-md-9">
                            <p>Non-Teaching Staff</p>     
                        </div>
                        <div class="col-md-3 title">
                            <p><a href="FeePipeline.php" class="pull-right"> 
                            <?php
                                $NonTeachDOB=odbc_exec($conn, "SELECT COUNT([No_]) AS [NonTeachDOB] FROM [Employee] WHERE [Birth Date]='".date('Y-m-d')."'") or die(odbc_errormsg($conn));
                                echo odbc_result($NonTeachDOB, "NonTeachDOB");
                            ?></a></p>
                        </div>                        
                    </div>
                </div>
        </div>
        <!-- / Third Row -->
        <!-- Fourth Row -->
            <div class="row">
                <div class="col-md-9 col-xs-12 col-sm-12">
                </div>
                
            </div>
        <!-- / Fourth Row -->
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