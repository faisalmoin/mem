<?php
     
   require_once("datab.php");
     
        $empname = strtoupper($_REQUEST['empname']);
        $empcode= addslashes(strtoupper($_REQUEST['empcode']));
        $contact = (strtoupper($_REQUEST['contact']));
        $email = addslashes($_REQUEST['email']);
        $department = addslashes(strtoupper($_REQUEST['department']));
      
   
       $SQL ="INSERT INTO employee(EmployeeCode,EmployeeName,EmployeeContact,EmployeeEmail,EmployeeDepartment,EmployeeStatus)
		 VALUES('$empcode','$empname','$contact','$email','$department','1')"; 
       mysqli_query($conn, $SQL);
         
      
       ?> 
       