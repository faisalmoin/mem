<?php 
require_once 'header.php';
$CurrDate = date('Y-m-d')." 00:00:000";		
	$AcadSQL = odbc_exec($conn, "SELECT MAX([Code]) FROM [Academic Year] WHERE  [Start Date] <= '".$CurrDate."' AND [Company Name]='$ms'");
	$AcadYr = odbc_result($AcadSQL, '');
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
<h2>Student Strength </h2>
<ul class="nav navbar-right panel_toolbox">
<li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>

</ul>
<div class="clearfix"></div>
</div>
<div class="x_content">

<form name="form" method="GET">
	<h2 class="text-primary">Academic Year <?php echo $AcadYr; ?></h2>
	
</form>

<table id="datatable-buttons" class="table table-striped table-bordered">
<thead>
<tr style="font-weight: bold;">
	<td style="border: 0px;">Class</td>
	<?php
		$StuSec = odbc_exec($conn, "SELECT DISTINCT([Section]) FROM [Temp Student] WHERE [Company Name]='$ms' ORDER BY [Section]") or die(odbc_errormsg($conn));
		$colspan = odbc_num_rows($StuSec);
		while(odbc_fetch_array($StuSec)){
			echo "<td  style='border: 0px;' align='center'>".odbc_result($StuSec, 'Section')."</td>";
		}
	?>
	<td style="border: 0px;" align="center">TOTAL</td>
</tr>
</thead>
<tbody>
<?php
	$StuClass = odbc_exec($conn, "SELECT [Code], [Description] FROM [Class] WHERE [Company Name]='$ms' ORDER BY [Sequence]");
	while(odbc_fetch_array($StuClass)){
?>
<tr><td>
<?php echo odbc_result($StuClass, 'Description'); ?>
</td>
<?php
	$StuSecCount = odbc_exec($conn, "SELECT DISTINCT([Section]) FROM [Temp Student] WHERE [Company Name]='$ms' ORDER BY [Section]") or die(odbc_errormsg($conn));
	while(odbc_fetch_array($StuSecCount)){
		
		$CountStu = odbc_exec($conn, "SELECT COUNT([No_]) FROM [Temp Student]  WHERE [Company Name]='$ms' AND [Class] = '".odbc_result($StuClass, 'Code')."' AND [Section] = '".odbc_result($StuSecCount, 'Section')."' AND [Academic Year] = '$AcadYr' AND [Student Status] = 1 ");
		if(odbc_result($CountStu, '') != 0){
			echo "<td align='center'>";
			echo "<a href='StudentClass.php?y=$AcadYr&c=".odbc_result($StuClass, 'Code')."&s=".odbc_result($StuSecCount, 'Section')." '>".odbc_result($CountStu, '')."</a>";
		}
		else{
			echo "<td align='center' style='color: #E3E4FB'>";
			echo odbc_result($CountStu, '');
		}
		echo "</td>";
	}
	$ClassStrength = odbc_exec($conn, "SELECT COUNT([No_]) FROM [Temp Student] WHERE [Company Name]='$ms' AND [Class] = '".odbc_result($StuClass, 'Code')."' AND [Academic Year] = '$AcadYr' AND [Student Status] = 1 ");
	echo "<td style='color: #000000;' align='center'>".odbc_result($ClassStrength, '')."</td>";
?>
</tr>
<?php
	}
?>

<tr style="font-size: 18px;">
	<td colspan="<?php echo ($colspan+1)?>"><strong>TOTAL</strong></td>
	<td style="color: #000000;" align="center"><b>
		<?php
			$SchStrength = odbc_exec($conn, "SELECT COUNT([No_]) FROM [Temp Student] WHERE [Company Name]='$ms' AND [Academic Year] = '$AcadYr' AND [Student Status] = 1 ");
			echo odbc_result($SchStrength, '');
		?></b>
	</td>
</tr>
</tbody>
</table>

</div>
</div>
</div>
</div>
</div>
</div>
</div>

<!-- jQuery -->
<script src="../vendors/jquery/dist/jquery.min.js"></script>
<script src="../vendors/jquery/dist/jquery-ui.js"></script>
<link href="../vendors/jquery/dist/jquery-ui.css" rel="stylesheet">
<!-- Bootstrap -->
<script src="../vendors/bootstrap/dist/js/bootstrap.min.js"></script>

<!-- Custom Theme Scripts -->
<script src="../build/js/custom.min.js"></script>


<!-- Datatables -->
<script src="../vendors/datatables.net/js/jquery.dataTables.min.js"></script>
<script src="../vendors/datatables.net-bs/js/dataTables.bootstrap.min.js"></script>
<script src="../vendors/datatables.net-buttons/js/dataTables.buttons.min.js"></script>
<script src="../vendors/datatables.net-buttons-bs/js/buttons.bootstrap.min.js"></script>
<script src="../vendors/datatables.net-buttons/js/buttons.flash.min.js"></script>
<script src="../vendors/datatables.net-buttons/js/buttons.html5.min.js"></script>
<script src="../vendors/datatables.net-buttons/js/buttons.print.min.js"></script>
<script src="../vendors/datatables.net-fixedheader/js/dataTables.fixedHeader.min.js"></script>
<script src="../vendors/datatables.net-keytable/js/dataTables.keyTable.min.js"></script>
<script src="../vendors/datatables.net-responsive/js/dataTables.responsive.min.js"></script>
<script src="../vendors/datatables.net-responsive-bs/js/responsive.bootstrap.js"></script>
<script src="../vendors/datatables.net-scroller/js/datatables.scroller.min.js"></script>
<script src="../vendors/jszip/dist/jszip.min.js"></script>
<script src="../vendors/pdfmake/build/pdfmake.min.js"></script>
<script src="../vendors/pdfmake/build/vfs_fonts.js"></script>

<!-- Datatables -->
<script>
      $(document).ready(function() {
        var handleDataTableButtons = function() {
          if ($("#datatable-buttons").length) {
            $("#datatable-buttons").DataTable({
              dom: "Bfrtip",
              buttons: [
                {
                  extend: "copy",
                  className: "btn-sm"
                },
                {
                  extend: "csv",
                  className: "btn-sm"
                },
                {
                  extend: "excel",
                  className: "btn-sm"
                },
                {
                  extend: "pdfHtml5",
                  className: "btn-sm"
                },
                {
                  extend: "print",
                  className: "btn-sm"
                },
              ],
              responsive: true
            });
          }
        };

        TableManageButtons = function() {
          "use strict";
          return {
            init: function() {
              handleDataTableButtons();
            }
          };
        }();

        $('#datatable').dataTable();

        $('#datatable-keytable').DataTable({
          keys: true
        });

        $('#datatable-responsive').DataTable({
          fixedHeader: true
        });


        var $datatable = $('#datatable-checkbox');

        $datatable.dataTable({
          'order': [[ 1, 'asc' ]],
          'columnDefs': [
            { orderable: false, targets: [0] }
          ]
        });
        $datatable.on('draw.dt', function() {
          $('input').iCheck({
            checkboxClass: 'icheckbox_flat-green'
          });
        });

        TableManageButtons.init();
      });
    </script>
<!-- /Datatables -->


<?php require_once("../footer.php");?>