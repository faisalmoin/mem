<?php
	require_once("SetupLeft.php");
	
	//exit($CompName);
	
	//Check for same user
	$result=odbc_exec($conn, "SELECT COUNT([id]) FROM [user] WHERE [LoginID]='".$_REQUEST['LoginID']."'") or die("odbc_errormsg($conn)");
	$row=odbc_result($result, "" );
	
	if($row==0){
		$AddUser=odbc_exec($conn, "INSERT INTO [user]([FullName], [Email], [LoginID], [Password], [ContactNo], 
		[UserType], [UserStatus]) VALUES
		('".$_REQUEST['FullName']."', '".$_REQUEST['Email']."', '".strtoupper($_REQUEST['LoginID'])."', 
		'".md5('password')."', '".$_REQUEST['ContactNo']."', 
		'".$_REQUEST['UserType']."', 'Active')") or die(odbc_errormsg($conn));
		
		if($AddUser){
			$MapUser = odbc_exec($conn, "SELECT [ID], [LoginID] FROM [user] WHERE [LoginID]='".strtoupper($_REQUEST['LoginID'])."' ") or exit(odbc_errormsg($conn));
			$mUser = odbc_exec($conn, "INSERT INTO [usermap] ([UserTableID], [UserLoginID], [CompanyTableID], [CompanyErpCode]) VALUES('".odbc_result($MapUser, "ID")."', '".odbc_result($MapUser, "LoginID")."', '$CompName', '')") or exit(odbc_errormsg($conn));
			if($mUser){
			echo "<div class='bs-example'>
					<div class='alert alert-success alert-error'>
						<a href='#' class='close' data-dismiss='alert'>&times;</a>
						<strong>Success!</strong> User <strong>".$_REQUEST['FullName'] ."</strong> has been registered.
					</div>
				</div>";
			}
			else{
			echo "<div class='bs-example'>
					<div class='alert alert-success alert-error'>
						<a href='#' class='close' data-dismiss='alert'>&times;</a>
						<strong>Error!</strong> Unable to map <strong>".$_REQUEST['FullName'] ."</strong> with the company.
					</div>
				</div>";
			}
		}
		else{
			echo "<div class='container'><div class='bs-example'><div class='alert alert-danger alert-error'><a href='#' class='close' data-dismiss='alert'><strong>Error!</strong> There is some problem, please check.</div></div>";
		}
	}
	else{
		echo "<div class='container'>
			<div class='bs-example'>
				<div class='alert alert-danger alert-error'>
					<a href='#' class='close' data-dismiss='alert'>&times;</a>
					<strong>Error!</strong> User <strong>".$_REQUEST['FullName'] ."</strong> already registered.
				</div>
			</div>";
		echo	"<h1 class='text-primary'><small>Map <strong>".$_REQUEST['FullName']."</strong> with Company?</small></h1>
				<a class='btn btn-primary' href='MapUser.php?LoginID=".$_REQUEST['LoginID']."'>Yes</a> <a class='btn btn-default' href='NewUser.php'>No</a>
			</div>";
	}

	require_once("SetupRight.php");
?>