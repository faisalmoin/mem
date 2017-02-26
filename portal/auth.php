<?php
	session_start();
	date_default_timezone_set("Asia/Kolkata");

	$Login=strtoupper($_REQUEST['LoginID']);
	$Password=md5($_REQUEST['Password']);


	//exit();
	if(isset($_REQUEST['session_id'])){
		if($_REQUEST['session_id'] == ""){
			exit("Security bridge...");
		}		
	}
	else{
		exit("Un-identified object ...");
	}
	
	require_once("db.txt");
	require_once("header.php");
	
	function logout($time, $Login){
		echo("<br /><br /><br /><br /><div class='container' align='center'>Your session is active since ".$time.". Kindly logout from previous session ...<br />
                        <a href='logout.php?id=$Login' class='btn btn-warning'>Logout</a>
			</div>");
	}
	
?>
<script type='text/javascript'>//<![CDATA[ 
$(window).load(function(){
$(function() {
  var value = 0;
  var interval = setInterval(function() {
      value += 10;
      $("#progress-bar")
      .css("width", value + "%")
      .attr("aria-valuenow", value)
      .text(value + "%");
      if (value >= 100)
          clearInterval(interval);
  }, 1000);
});
});//]]>  

</script>
<!-- progress bar -->
<!--
<div class="container col-xs-4"></div>
<div class="container col-xs-4">
	<div class="progress progress-striped">
		<div class="progress-bar progress-bar-striped active" id="progress-bar" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" style="width: 0%">
    progress 
		</div>
	</div>
</div>
-->
<?php
	echo "<br /><br /><br />";
	//User Redirect to respective Home Page
	$rs=odbc_exec($conn, "SELECT * FROM [user] WHERE [LoginID]='$Login' AND [Password]='$Password' AND [UserStatus]='Active'") or die(odbc_errormsg($conn));
		
	if(odbc_result($rs, "UserType") == "Admin" ){	
		header("Location: admin/home.php");
	}
	elseif(odbc_result($rs, "UserType") == "HEADCOMP" ){		
		$Log=odbc_exec($conn, "SELECT [ActiveStat], [LoginTime] FROM [login] WHERE [Login]='$Login' AND [LoginTime] IN (SELECT MAX([LoginTime]) FROM [login] WHERE [Login]='$Login')") or exit(odbc_errormsg($conn));
		if(odbc_result($Log, "ActiveStat") !='1'){
			//Insert into Login Table
			odbc_exec($conn, "INSERT INTO [login]([login], [password], [ActiveStat], [LoginTime]) VALUES ('$Login', '$Password', 1, '".time()."' )") or exit(odbc_errormsg($conn));
			
			//Get Company name
			$Comp = odbc_exec($conn, "SELECT [ID] FROM [Company Information] WHERE [ID] IN (SELECT [CompanyTableID] FROM [usermap] WHERE [UserTableID]='".odbc_result($rs, "ID")."')") or exit(odbc_errormsg($conn));
			echo $Comp;
			//Session Record
			$_SESSION['UserName'] = odbc_result($rs, "FullName");
			$_SESSION['Email'] = odbc_result($rs, "Email");
			$_SESSION['LoginID'] = odbc_result($rs, "LoginID");
			$_SESSION['UserType'] = odbc_result($rs, "UserType");
			$_SESSION['ID'] = odbc_result($rs, "ID");
			$_SESSION['CompName'] = odbc_result($Comp, "ID");
			$_SESSION['SessionID'] = $_REQUEST['session_id'];
			
			header("Location: headcomp/home.php");
		}
		else{
			logout(date('d/M/Y H:i:s', odbc_result($Log, "LoginTime")), $Login);
		}
	}
	elseif(odbc_result($rs, "UserType") == "FOE" ){
		$Log=odbc_exec($conn, "SELECT [ActiveStat], [LoginTime] FROM [login] WHERE [Login]='$Login' AND [LoginTime] IN (SELECT MAX([LoginTime]) FROM [login] WHERE [Login]='$Login')") or exit(odbc_errormsg($conn));
		if(odbc_result($Log, "ActiveStat") !='1'){
			//Insert into Login Table
			odbc_exec($conn, "INSERT INTO [login]([login], [password], [ActiveStat], [LoginTime]) VALUES ('$Login', '$Password', 1, '".time()."' )") or exit(odbc_errormsg($conn));
			
			//Get Company name
			$Comp = odbc_exec($conn, "SELECT [ID] FROM [Company Information] WHERE [ID] IN (SELECT [CompanyTableID] FROM [usermap] WHERE [UserTableID]='".odbc_result($rs, "ID")."')") or exit(odbc_errormsg($conn));
			
			//Session Record
			$_SESSION['UserName'] = odbc_result($rs, "FullName");
			$_SESSION['Email'] = odbc_result($rs, "Email");
			$_SESSION['LoginID'] = odbc_result($rs, "LoginID");
			$_SESSION['UserType'] = odbc_result($rs, "UserType");
			$_SESSION['CompName'] = odbc_result($Comp, "ID");
			$_SESSION['SessionID'] = $_REQUEST['session_id'];
			$_SESSION['ID'] = odbc_result($rs, "ID");
			
			header("Location: foe/home.php");
		}
		else{
			logout(date('d/M/Y H:i:s', odbc_result($Log, "LoginTime")), $Login);
		}
	}
	elseif(odbc_result($rs, "UserType") == "Accountant" ){
		$Log=odbc_exec($conn, "SELECT [ActiveStat], [LoginTime] FROM [login] WHERE [Login]='$Login' AND [LoginTime] IN (SELECT MAX([LoginTime]) FROM [login] WHERE [Login]='$Login')") or exit(odbc_errormsg($conn));
		if(odbc_result($Log, "ActiveStat") !='1'){
			//Insert into Login Table
			odbc_exec($conn, "INSERT INTO [login]([login], [password], [ActiveStat], [LoginTime]) VALUES ('$Login', '$Password', 1, '".time()."' )") or exit(odbc_errormsg($conn));
			
			//Get Company name
			$Comp = odbc_exec($conn, "SELECT [ID] FROM [Company Information] WHERE [ID] IN (SELECT [CompanyTableID] FROM [usermap] WHERE [UserTableID]='".odbc_result($rs, "ID")."')") or exit(odbc_errormsg($conn));
			
			//Session Record
			$_SESSION['UserName'] = odbc_result($rs, "FullName");
			$_SESSION['Email'] = odbc_result($rs, "Email");
			$_SESSION['LoginID'] = odbc_result($rs, "LoginID");
			$_SESSION['UserType'] = odbc_result($rs, "UserType");
			$_SESSION['CompName'] = odbc_result($Comp, "ID");
			$_SESSION['SessionID'] = $_REQUEST['session_id'];
			$_SESSION['ID'] = odbc_result($rs, "ID");
			
			header("Location: accountant/home.php");
		}
		else{
			logout(date('d/M/Y H:i:s', odbc_result($Log, "LoginTime")), $Login);
		}
	}
	elseif(odbc_result($rs, "UserType") == "Principal" ){
		$Log=odbc_exec($conn, "SELECT [ActiveStat], [LoginTime] FROM [login] WHERE [Login]='$Login' AND [LoginTime] IN (SELECT MAX([LoginTime]) FROM [login] WHERE [Login]='$Login')") or exit(odbc_errormsg($conn));
		if(odbc_result($Log, "ActiveStat") !='1'){
			//Insert into Login Table
			odbc_exec($conn, "INSERT INTO [login]([login], [password], [ActiveStat], [LoginTime]) VALUES ('$Login', '$Password', 1, '".time()."' )") or exit(odbc_errormsg($conn));
			
			//Get Company name
			$Comp = odbc_exec($conn, "SELECT [ID] FROM [Company Information] WHERE [ID] IN (SELECT [CompanyTableID] FROM [usermap] WHERE [UserTableID]='".odbc_result($rs, "ID")."')") or exit(odbc_errormsg($conn));
			
			//Session Record
			$_SESSION['UserName'] = odbc_result($rs, "FullName");
			$_SESSION['Email'] = odbc_result($rs, "Email");
			$_SESSION['LoginID'] = odbc_result($rs, "LoginID");
			$_SESSION['UserType'] = odbc_result($rs, "UserType");
			$_SESSION['CompName'] = odbc_result($Comp, "ID");
			$_SESSION['SessionID'] = $_REQUEST['session_id'];
			$_SESSION['ID'] = odbc_result($rs, "ID");
			
			header("Location: principal/home.php");
		}
		else{
			logout(date('d/M/Y H:i:s', odbc_result($Log, "LoginTime")), $Login);
		}		
	}
	elseif(odbc_result($rs, "UserType") == "Director" ){
		$Log=odbc_exec($conn, "SELECT [ActiveStat], [LoginTime] FROM [login] WHERE [Login]='$Login' AND [LoginTime] IN (SELECT MAX([LoginTime]) FROM [login] WHERE [Login]='$Login')") or exit(odbc_errormsg($conn));
		if(odbc_result($Log, "ActiveStat") !='1'){
			//Insert into Login Table
			odbc_exec($conn, "INSERT INTO [login]([login], [password], [ActiveStat], [LoginTime]) VALUES ('$Login', '$Password', 1, '".time()."' )") or exit(odbc_errormsg($conn));
				
			//Get Company name
			//$Comp = odbc_exec($conn, "SELECT [ID] FROM [Company Information] WHERE [ID] IN (SELECT [CompanyTableID] FROM [usermap] WHERE [UserTableID]='".odbc_result($rs, "ID")."')") or exit(odbc_errormsg($conn));
				
			//Session Record
			$_SESSION['UserName'] = odbc_result($rs, "FullName");
			$_SESSION['Email'] = odbc_result($rs, "Email");
			$_SESSION['LoginID'] = odbc_result($rs, "LoginID");
			$_SESSION['UserType'] = odbc_result($rs, "UserType");
			$_SESSION['SessionID'] = $_REQUEST['session_id'];
			$_SESSION['ID'] = odbc_result($rs, "ID");
				
			header("Location: director/Home.php");
		}
		else{
			logout(date('d/M/Y H:i:s', odbc_result($Log, "LoginTime")), $Login);
		}
	}
	elseif(odbc_result($rs, "UserType") == "SchoolDirector" ){
		$Log=odbc_exec($conn, "SELECT [ActiveStat], [LoginTime] FROM [login] WHERE [Login]='$Login' AND [LoginTime] IN (SELECT MAX([LoginTime]) FROM [login] WHERE [Login]='$Login')") or exit(odbc_errormsg($conn));
		if(odbc_result($Log, "ActiveStat") !='1'){
			//Insert into Login Table
			odbc_exec($conn, "INSERT INTO [login]([login], [password], [ActiveStat], [LoginTime]) VALUES ('$Login', '$Password', 1, '".time()."' )") or exit(odbc_errormsg($conn));
				
			//Get Company name
			$Comp = odbc_exec($conn, "SELECT [ID] FROM [Company Information] WHERE [ID] IN (SELECT [CompanyTableID] FROM [usermap] WHERE [UserTableID]='".odbc_result($rs, "ID")."')") or exit(odbc_errormsg($conn));
			
			//Session Record
			$_SESSION['UserName'] = odbc_result($rs, "FullName");
			$_SESSION['Email'] = odbc_result($rs, "Email");
			$_SESSION['LoginID'] = odbc_result($rs, "LoginID");
			$_SESSION['UserType'] = odbc_result($rs, "UserType");
			$_SESSION['CompName'] = odbc_result($Comp, "ID");
			$_SESSION['SessionID'] = $_REQUEST['session_id'];
			$_SESSION['ID'] = odbc_result($rs, "ID");
			
			//echo $_SESSION['CompName'];
			//exit();
			header("Location: schooldirector/Home.php");
		}
		else{
			logout(date('d/M/Y H:i:s', odbc_result($Log, "LoginTime")), $Login);
		}
	}
	elseif(odbc_result($rs, "UserType") == "Sales" ){
		$Log=odbc_exec($conn, "SELECT [ActiveStat], [LoginTime] FROM [login] WHERE [Login]='$Login' AND [LoginTime] IN (SELECT MAX([LoginTime]) FROM [login] WHERE [Login]='$Login')") or exit(odbc_errormsg($conn));
		if(odbc_result($Log, "ActiveStat") !='1'){
			//Insert into Login Table
			odbc_exec($conn, "INSERT INTO [login]([login], [password], [ActiveStat], [LoginTime]) VALUES ('$Login', '$Password', 1, '".time()."' )") or exit(odbc_errormsg($conn));
				
			//Get Company name
			//$Comp = odbc_exec($conn, "SELECT [ID] FROM [Company Information] WHERE [ID] IN (SELECT [CompanyTableID] FROM [usermap] WHERE [UserTableID]='".odbc_result($rs, "ID")."')") or exit(odbc_errormsg($conn));
				
			//Session Record
			$_SESSION['UserName'] = odbc_result($rs, "FullName");
			$_SESSION['Email'] = odbc_result($rs, "Email");
			$_SESSION['LoginID'] = odbc_result($rs, "LoginID");
			$_SESSION['UserType'] = odbc_result($rs, "UserType");
			$_SESSION['SessionID'] = $_REQUEST['session_id'];
			$_SESSION['ID'] = odbc_result($rs, "ID");
				
			header("Location: sales/Home.php");
		}
		else{
			logout(date('d/M/Y H:i:s', odbc_result($Log, "LoginTime")), $Login);
		}
	}
	elseif(odbc_result($rs, "UserType") == "MEMAccountant" ){
		$Log=odbc_exec($conn, "SELECT [ActiveStat], [LoginTime] FROM [login] WHERE [Login]='$Login' AND [LoginTime] IN (SELECT MAX([LoginTime]) FROM [login] WHERE [Login]='$Login')") or exit(odbc_errormsg($conn));
		if(odbc_result($Log, "ActiveStat") !='1'){
			//Insert into Login Table
			odbc_exec($conn, "INSERT INTO [login]([login], [password], [ActiveStat], [LoginTime]) VALUES ('$Login', '$Password', 1, '".time()."' )") or exit(odbc_errormsg($conn));
				
			//Get Company name
			//$Comp = odbc_exec($conn, "SELECT [ID] FROM [Company Information] WHERE [ID] IN (SELECT [CompanyTableID] FROM [usermap] WHERE [UserTableID]='".odbc_result($rs, "ID")."')") or exit(odbc_errormsg($conn));
				
			//Session Record
			$_SESSION['UserName'] = odbc_result($rs, "FullName");
			$_SESSION['Email'] = odbc_result($rs, "Email");
			$_SESSION['LoginID'] = odbc_result($rs, "LoginID");
			$_SESSION['UserType'] = odbc_result($rs, "UserType");
			$_SESSION['SessionID'] = $_REQUEST['session_id'];
			$_SESSION['ID'] = odbc_result($rs, "ID");
				
			header("Location: MEMFin/Home.php");
		}
		else{
			logout(date('d/M/Y H:i:s', odbc_result($Log, "LoginTime")), $Login);
		}
	}
        
        
        elseif(odbc_result($rs, "UserType") == "MEMProcurement" ){
		$Log=odbc_exec($conn, "SELECT [ActiveStat], [LoginTime] FROM [login] WHERE [Login]='$Login' AND [LoginTime] IN (SELECT MAX([LoginTime]) FROM [login] WHERE [Login]='$Login')") or exit(odbc_errormsg($conn));
		if(odbc_result($Log, "ActiveStat") !='1'){
			//Insert into Login Table
			odbc_exec($conn, "INSERT INTO [login]([login], [password], [ActiveStat], [LoginTime]) VALUES ('$Login', '$Password', 1, '".time()."' )") or exit(odbc_errormsg($conn));
				
			//Get Company name
			$Comp = odbc_exec($conn, "SELECT [ID],[Address],[City],[Phone No_] FROM [Company Information] WHERE [ID] IN (SELECT [CompanyTableID] FROM [usermap] WHERE [UserTableID]='".odbc_result($rs, "ID")."')") or exit(odbc_errormsg($conn));
				
			//Session Record
			$_SESSION['UserName'] = odbc_result($rs, "FullName");
			$_SESSION['Email'] = odbc_result($rs, "Email");
			$_SESSION['LoginID'] = odbc_result($rs, "LoginID");
			$_SESSION['UserType'] = odbc_result($rs, "UserType");
			$_SESSION['SessionID'] = $_REQUEST['session_id'];
                        $_SESSION['CompName'] = odbc_result($Comp, "ID");
                       	$_SESSION['SessionID'] = $_REQUEST['session_id'];	
                       	$_SESSION['ID'] = odbc_result($rs, "ID");
			header("Location: VMS/Dashboard.php");
		}
		else{
			logout(date('d/M/Y H:i:s', odbc_result($Log, "LoginTime")), $Login);
		}
	}
	
	//At the end....
	else{	
		echo "<br /><br /><br />Failed";
		header("Location: index.php?er=1");
	}

	
	require_once("footer.php");
?>
