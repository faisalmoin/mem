 <?php 
 require_once("../db.txt");
 if(isset($_POST['submit']))
 {
 echo $SQL = "INSERT INTO [VMS Item Category Master] (
                                [Item Category]  ) VALUES ('".($_REQUEST['category'])."')";
                //exit($SQL);
                $result = odbc_exec($conn, $SQL) or die(odbc_errormsg($conn));
                if(!result){
                    exit("<div class='alert alert-danger alert-error'><strong>Error!</strong> There is some problem, please check.</div>");
                }
		else{
			
			//Success Message
			echo "<div class='alert alert-success alert-error'><strong>Success!</strong> Data has been Entered.</div>";
		}
		
 }	
		/*
		
		if($result){
			echo "<div class='container'><div class='alert alert-success alert-error'><strong>Success!</strong> Company has been registered.</div></div>";
		}
		else{
			echo "<div class='container'><div class='alert alert-danger alert-error'><strong>Error!</strong> There is some problem, please check.</div></div>";
		}
	}
	else{
		echo "<div class='container'><div class='alert alert-danger alert-error'><strong>Error!</strong> This company is already registered.</div></div>";
	}
                 
                 */
	
?>

