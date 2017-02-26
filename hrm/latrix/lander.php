<?php
/*
    LATRIX - attendance tracking and reporting
    Copyright (C) 2006,2009 Manticore Software
    Published under GPL V3, see admin.php for more detail
    
    This page is used by all URL's embedded in emails.
    It retrieves the parameter string, decodes it, 
    creates a simple form with the relevant input controls and
    submits to the admin page, where all processing is done.
    
*/

	$gets = explode(':',$_GET['parms']);
?>
<html>
<body onload="document.getElementById('latform').submit();">
<form method="post" action="admin.php" name="latform" id="latform" enctype="multipart/form-data">
	<input type="hidden" id="txtsubject" name="txtsubject" value="<?php echo $gets[1] ?>"> 
	<input type="hidden" id="txtsubsubject" name="txtsubsubject" value="<?php echo $gets[2] ?>"> 
	<input type="hidden" id="txtrecord" name="txtrecord" value="<?php echo $gets[0] ?>"> 
	<input type="hidden" id="txtmode" name="txtmode" value="view"> 
	<input type="hidden" id="txtaction" name="txtaction" value="view"> 
</form>
</body>
</html>