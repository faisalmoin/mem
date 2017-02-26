<?php
	require_once("header.php");

	?>

<!DOCTYPE html>
<html>
<head>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
<script>
$(document).ready(function(){
    $("form").submit(function(){
    	var length = $('#FirstName').val().length;
        alert(length);
    });
});
</script>
</head>
<body>

<form action="">
  First name: <input type="textarea" name="FirstName" id="FirstName" value="Mickey"><br>
  Last name: <input type="textarea" name="LastName" value="Mouse"><br>
  <input type="submit" value="Submit">
</form> 

</body>
</html>

<?php
	require_once("../footer.php");
?>