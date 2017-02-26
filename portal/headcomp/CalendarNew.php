<?php
	require_once("SetupLeft.php");
?>

<!-- Datatables -->
<link href="../vendors/datatables.net-bs/css/dataTables.bootstrap.min.css" rel="stylesheet">
<link href="../vendors/datatables.net-buttons-bs/css/buttons.bootstrap.min.css" rel="stylesheet">
<link href="../vendors/datatables.net-fixedheader-bs/css/fixedHeader.bootstrap.min.css" rel="stylesheet">
<link href="../vendors/datatables.net-responsive-bs/css/responsive.bootstrap.min.css" rel="stylesheet">
<link href="../vendors/datatables.net-scroller-bs/css/scroller.bootstrap.min.css" rel="stylesheet">

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
<h2>Calendar </h2>
<ul class="nav navbar-right panel_toolbox">
<li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li> 
<li><a href="AcademicYearNew.php" title="Create New ..."><img src="../img/btn-create.png" id="btn-create" width="20px" alt="Create New"></a></li>                              
</ul>
<div class="clearfix"></div>
</div>
<div class="x_content">

<form name="form" methos="POST" action="CalendarAdd.php">
	<div class="form-group">
		
		<label for="year" class="col-xs-2 col-form-label">Year: </label>
		<select name="year" style="width: 100px;" class="form-control" id="year" required>
			<option value=""></option>
			<?php
				$yr = date("Y");

				$start_yr = date("Y")-2;

				for($y = $start_yr; $y<= ($start_yr+4); $y++){
					echo "<option value='".$y."'";
					//if($y==$yr){echo " selected";}
					echo ($y==$yr)? " selected":"";
					echo ">$y</option>";
				}
			?>
		</select>
	</div>
	<div class="row">
		<div class="col-md-12">
			<table id="customFields" class="table table-responsive">
				<tr style="background-color: #eee;">
					<th style="height: 40px; ">SN</th>
					<th style="height: 40px; ">From Date</th>
                                        <th style="height: 40px; ">To Date</th>
                                        <th style="height: 40px; ">Start Time</th>
                                        <th style="height: 40px; ">End Time</th>
                                        <th>Event Type</th>
					<th>Event / Description</th>					
					<th></th>
				</tr>
				<tr>
					<td>1</td>
                                        <td><input type="text" class="form-control date" name="s_date[]" maxlength="11" style="width: 10em;" required /></td>
					<td><input type="text" class="form-control date" name="e_date[]" maxlength="11" style="width: 10em;" required /></td>
                                        <td><input type="text" class="form-control s_time" name="s_time[]" maxlength="5" style="width: 5em;" required /></td>
                                        <td><input type="text" class="form-control e_time" name="e_time[]" maxlength="5" style="width: 5em;" required /></td>
					<td>
						<select name="ActivityType[]" class="form-control" required>
							<option value="1">Holiday</option>
							<option value="2">Event</option>
                            <option value="3">Weekly off</option>
						</select>
					</td>
                                        <td><input type="text" class="form-control" name="Description[]" maxlength="50" required /></td>
					<td></td>
				</tr>

			</table>
		</div>
	</div>
	<div class="row">
		<div class="col-md-12">
			<div style="text-align: right">
				<input type="hidden" value="1" name="count" id="count" />
				<a href="javascript:void(0);" class="addCF btn btn-default" title="Add More">+</a>
			</div>
		</div>
	</div>
        <a href="CalendarList.php" class="btn btn-default">Cancel</a>
	<input type="submit" onclick="checking()" value="Submit" class="btn btn-primary">

</form>



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
<!-- Bootstrap -->
<script src="../vendors/bootstrap/dist/js/bootstrap.min.js"></script>

<!-- Custom Theme Scripts -->
<script src="../build/js/custom.min.js"></script>

<link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/timepicker/1.3.5/jquery.timepicker.min.css">
<script src="//cdnjs.cloudflare.com/ajax/libs/timepicker/1.3.5/jquery.timepicker.min.js"></script>

<script type='text/javascript'>//<![CDATA[
window.onload=function(){
$(document).ready(function(){
	cnt = 2;
	$(".addCF").click(function(){
		$("#customFields").append('<tr><td>'+ cnt +'</td>\n\
                    <td><input type="text" class="form-control date" name="s_date[]" maxlength="11" style="width: 10em;" required /></td>\n\
                    <td><input type="text" class="form-control date" name="e_date[]" maxlength="11" style="width: 10em;" required /></td>\n\
                    <td><input type="text" class="form-control s_time" name="s_time[]" maxlength="5" style="width: 5em;" required /></td>\n\
                    <td><input type="text" class="form-control e_time" name="e_time[]" maxlength="5" style="width: 5em;" required /></td>\n\
                    <td><select name="ActivityType[]" class="form-control" required>\n\
                        <option value="1">Holiday</option>\n\
                        <option value="2">Event</option>\n\
                        <option value="3">Weekly off</option>\n\\n\
                        </select></td>\n\
                    <td><input type="text" class="form-control" name="Description[]" maxlength="50" required /></td>\n\
                    <td><a href="javascript:void(0);" class="remCF"><img src="wrong.jpeg" style="width: 15px; " /></a></td></tr>');
		document.getElementById("count").value=cnt;
		cnt++;
	});
    $("#customFields").on('click','.remCF',function(){
        $(this).parent().parent().remove();
	document.getElementById("count").value=cnt;
	cnt--;
    });
    
	});

	$('body').on('focus',".date", function(){
    	$(this).datepicker();
	});
    $('body').on('focus',".s_time", function(){
        $('.s_time').timepicker({
            timeFormat: 'HH:mm',
            interval: 15,
            minTime: '00:00',
            maxTime: '23:59',
            defaultTime: '00:00',
            startTime: '00:00',
            dynamic: true,
            dropdown: true,
            scrollbar: true
        });
    });
    $('body').on('focus',".s_time", function(){
        $('.e_time').timepicker({
            timeFormat: 'HH:mm',
            interval: 15,
            minTime: '00:15',
            maxTime: '23:59',
            defaultTime: '23:59',
            startTime: '00:15',
            dynamic: true,
            dropdown: true,
            scrollbar: true
        });
    });
        
  
}//]]> 


function checking() {
    var empty = 0;
    $('input[type=text]').each(function(){
       if (this.value == "") {
           empty++;
           $("#error").show('slow');
           //alert('Empty input(s)');
           return false;
       } 
    })
   
}


</script>
<?php
	require_once("SetupRight.php");
?>