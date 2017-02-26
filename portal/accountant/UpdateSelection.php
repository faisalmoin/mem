<?php
	require_once("header.php");
         if (isset($_SESSION['token'])){
		if (isset($_POST['token'])){
			if ($_POST['token'] != $_SESSION['token']){
				exit('<div class="container">
					<div class="alert alert-danger">
						<strong>Alert !!! </strong> You have tried to forge the process by refreshing the page or url. Exiting the process initiation.
					</div>
				</div>');
			}
		}
	}
	$count=$_REQUEST['Count'];

	    for ($i = 1; $i < $count; $i++) {
            $id = $_REQUEST['id' . $i];

            if ($id != "") {

                $result = odbc_prepare($conn, "UPDATE [Temp Application] SET [Registration Status]=3, [UpdateStatus]=1 WHERE [Enquiry No_]='$id' AND [Company Name]='$ms'");
                    
                if (odbc_execute($result)) {
                    echo "<html><meta http-equiv='refresh' content='0, NewSelection.php?err=1'></html>";
                } else {
                    echo "<html><meta http-equiv='refresh' content='0, NewSelection.php?err=0'></html>";
                }
            }
        }

	require_once("../footer.php");
?>