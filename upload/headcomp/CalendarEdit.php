<?php
	require_once("SetupLeft.php");
        $id = $_REQUEST['id'];
        
        $rs = odbc_exec($conn, "SELECT * FROM [Calendar] WHERE [ID]='$id'") or die(odbc_errormsg($conn));
        
?>
<link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/timepicker/1.3.5/jquery.timepicker.min.css">
<script src="//cdnjs.cloudflare.com/ajax/libs/timepicker/1.3.5/jquery.timepicker.min.js"></script>

<script type='text/javascript'>//<![CDATA[
window.onload=function(){

	
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
    $('body').on('focus',".e_time", function(){
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

<form name="form" methos="POST" action="CalendarUpdate.php">
	<div class="form-group">
		<h1>Calendar</h1>		
	</div>
	<div class="row">
		<div class="col-md-12">
                    <table id="customFields" class="table table-responsive" style="width: 50%">
                            <tr>
                                <td style="font-weight: bold; ">Description</td>
                                <td><input type="text" name="Description" value="<?php echo odbc_result($rs, "Description")?>" class="form-control"  /></td>
                            </tr>
                            <tr>
                                <td style="font-weight: bold; ">From</td>
                                <td>
                                    <input type="text" class="date" name="s_date" value="<?php echo date("d/M/Y", odbc_result($rs, "Start Date"))?>" maxlength="11" style="width: 10em;padding: 5px; border: 1px solid #D8D8D8;" required />
                                    <input type="text" class="s_time" name="s_time" value="<?php echo odbc_result($rs, "Start Time")?>" maxlength="5" style="width: 5em;padding: 5px; border: 1px solid #D8D8D8;" required />
                                </td>
                            </tr>
                            <tr>
                                <td style="font-weight: bold; ">To</td>
                                <td>
                                    <input type="text" class="date" name="e_date" value="<?php echo date("d/M/Y", odbc_result($rs, "End Date"))?>" maxlength="11" style="width: 10em;padding: 5px; border: 1px solid #D8D8D8;" required />
                                    <input type="text" class="e_time" name="e_time" value="<?php echo odbc_result($rs, "End Time")?>" maxlength="5" style="width: 5em;padding: 5px; border: 1px solid #D8D8D8;" required />
                                </td>
                            </tr>
                            <tr>
                                <td style="font-weight: bold; ">Type</td>
                                <td>
						<select name="ActivityType" class="form-control" required style="width: 218px;">
                                                    <option value="1" <?php echo (odbc_result($rs, "Activity Type")==1?" selected":"")?>>Holiday</option>
                                                    <option value="2" <?php echo (odbc_result($rs, "Activity Type")==2?" selected":"")?> >Event</option>
                                                    <option value="3" <?php echo (odbc_result($rs, "Activity Type")==3?" selected":"")?> >Weekly off</option>
						</select>
					</td>
                            </tr>
			</table>
                    <input type="hidden" name="id" value="<?php echo $id;?>"
		</div>
	</div>	
        <a href="CalendarList.php" class="btn btn-default">Cancel</a>
	<input type="submit" onclick="checking()" value="Edit" class="btn btn-primary">
        <a href="CalendarDel.php?id=<?php echo $id?>" class="btn btn-danger">Delete</a>

</form>

<?php
    require_once("SetupRight.php");
?>