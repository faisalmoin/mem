<?php
	require_once("header.php");
	
	$Count=$_REQUEST['count'];
	$UserTableID=$_REQUEST['UserTableID'.$i];
	$UserLoginID=$_REQUEST['UserLoginID'.$i];
	
	$UserDetails=mysql_query("SELECT `FullName`, `Email`, `Password` FROM `User` WHERE `id`='$UserTableID'") or die(mysql_error());
	$ud=mysql_fetch_array($UserDetails);
	
	for($i=0; $i<$Count; $i++){
		$CompanyTableID=$_REQUEST["CompanyTableID".$i];
		$CompanyERPCode=$_REQUEST["CompanyERPCode".$i];	
		
		if($CompanyTableID <> "" && $CompanyERPCode <> ""){
			$result = mysql_query("INSERT INTO `usermap` SET `UserTableID`='$UserTableID', `UserLoginID`='$UserLoginID', `CompanyTableID`='$CompanyTableID', `CompanyERPCode`='$CompanyERPCode' ") or die(mysql_error());
			if($result){
				echo "<div class='container'>
						<div class='bs-example'>
							<div class='alert alert-success alert-error'>
								<a href='#' class='close' data-dismiss='alert'>&times;</a>
								<strong>Success!</strong> User has been successfully mapped.
							</div>
						</div>";
				
				//Send Email
				$to = "$ud[0] <$ud[1]>";
				
				$subject = "School Portal Access Credentials.";
				
				$body = "<html>
						<body style='font-family: arial; font-size: 12px;'>
							<p align='justify'>Dear $ud[0],</p>
							<p align='justify'>We would like to bring you notice that your login credentials has been created in our Web Portal.</p> 
							<p align='justify'>Please find below with the login credentials:
								<ul>
									<li>URL: <b>http://202.54.232.180/</b></li>
									<li>Login ID: <b>$UserLoginID</b></li>
									<li>Password: <b>$ud[2]</b></li>
								</ul>
							</p>
							<p align='justify'>For any clarification to write to <b>schoolerp@educompschools.com</b></p>
							<br />
							<p align='justify'>
							Thanks & Regards,<br />
							School Support Team,<br />
							Educomp Solutions Ltd.<br />
							Gurgaon
							</p>
						</body>
					</html>";
					
					require_once("../smtp.php");
			}
			else{
				echo "<div class='container'><div class='bs-example'><div class='alert alert-danger alert-error'><a href='#' class='close' data-dismiss='alert'>&times;</a><strong>Error!</strong> There is some problem, please check.</div></div></div>";
			}
		}
	}
?>



<?php
	require_once("../footer.php");
?>