<?php require_once("Header1.php"); ?>
   
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8" />
<meta http-equiv="X-UA-Compatible" content="IE=edge" />
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" />
<!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
<meta name="description" content="" />
<meta name="author" content="" />

<title>Meeting Information Form</title>

<link href='http://fonts.googleapis.com/css?family=Poiret+One|Oxygen|Josefin+Sans:400,400italic,300italic,300,600' rel='stylesheet' type='text/css'>
<!-- Latest compiled and minified CSS -->
<link rel="stylesheet" href="bs/css/bootstrap.min.css">

<!-- jQuery library -->
<script type="text/javascript" src="http://code.jquery.com/jquery-1.10.1.js"></script>

<!-- Latest compiled JavaScript -->
<script src="bs/js/bootstrap.min.js"></script>
<link rel="stylesheet" href="bs/css/jquery-ui.css">
	
	  <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
  <link rel="stylesheet" href="/resources/demos/style.css">
  <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
  <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>

  <script>
  $( function() {
    $( "#datepicker" ).datepicker({
      changeMonth: true,
      changeYear: true
    });
  } );
  </script>
<script type="text/javascript" charset="utf-8">
   
function validateEmail(){
    
    var emailID = document.getElementById('Email');
    alert(emailID);
         atpos = emailID.indexOf("@");
         dotpos = emailID.lastIndexOf(".");
         
         if (atpos < 1 || ( dotpos - atpos < 2 )) 
         {
            alert("Please enter correct email ID");
            document.myForm.Email.focus() ;
            return false;
         }
         return( true );
}
</script>

</head>

<body>
    <nav class="navbar-fixed-top" >
		<!-- <nav role="navigation" class="navbar navbar-inverse navbar-static-top"> -->
		<nav role="navigation" style="background-color: #7FFFD4" class="navbar navbar-default navbar-static-top"></nav>
	</nav>
    <br /><br /><br />
     <!--p style="font-family: 'Poiret One', 'arial'; background-color: #a3e4d7; font-size: 24px; text-transform: uppercase;"></p-->
<div class="container">
    <!--<form name="myForm" method="post" action="registration.php" onsubmit="return(validateForm())" onkeypress="return event.keyCode != 13;"> -->
    <form name="myForm" method="Post" action="MeetingAdd.php" onsubmit="return(validateForm());" onkeypress="return event.keyCode != 13;" style="background-color: #ffffff;">

<table width="100%" align="center" border="0px" cellspacing="0px" cellpadding="5px"  class="table table-responsive borderless"  style="font-family: 'Oxygen', Arial; font-size: 18px;">
    <tr>
        <td height="100px" colspan="6" align='center' style="border-top: 0px;">
           
                <p style="color: #008B8B ;font-family: 'Poiret One', 'arial'; font-size: 24px; text-transform: uppercase; font-weight: bold;">Meeting Schedule</p>
               
        </td>
    </tr>
  <tr>
         <td>Organizer<sup style="color: #990000; font-weight: bold">*</sup></td>
         <td><input type="text" name="Organizer" id="Email" class="form-control" onclick="validateEmail();"/></td>
    </tr>
     <tr>
       
        <td>Attendees<sup style="color: #990000; font-weight: bold">*</sup></td>
        <td colspan="3"><input type="text" name="Attendees" class="form-control " /></td>
    </tr>
    <tr>
       
        <td>Summary<sup style="color: #990000; font-weight: bold">*</sup></td>
        <td colspan="3"><input type="text" name="Summary" class="form-control" /></td>
    </tr>
    <tr>
         <td>Location<sup style="color: #990000; font-weight: bold">*</sup></td>
        <td colspan="3"><input type="text" name="Location" class="form-control" /></td>
    </tr>
   <tr>
       
        <td>Date<sup style="color: #990000; font-weight: bold">*</sup></td>
        <td colspan="3"><input type="text" id="datepicker" name="meetingdate" class="form-control" /></td>
        <td>Time<sup style="color: #990000; font-weight: bold">*</sup></td>
        <td><input type="text" name="Time" class="form-control"/></td>
   </tr> 
    
  
     <tr>
       
        <td>Hours <sup style="color: #990000; font-weight: bold">*</sup></td>
        <td colspan="3"><input type="text" name="Hours" class="form-control" /></td>
        
        <td>Minutes <sup style="color: #990000; font-weight: bold">*</sup></td>
        <td colspan="3"><input type="text" name="Minutes" class="form-control" /></td>
    </tr>
    
    
   
            </table>
      
	<p align="justify">
		
		<input type="submit" class='btn btn-primary' id='Review' value='Submit'>
	</p>
    </form>
</div>


</body>
</html>