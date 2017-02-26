<?php
require_once ("../db.txt");
require_once ("../bs/class.phpmailer.php");

$mail = new PHPMailer ();
$mail->IsSMTP (); // set mailer to use SMTP
$mail->Host = "125.16.64.67"; // specify main and backup server
$mail->SMTPAuth = true; // turn on SMTP authentication
$mail->Username = "erpadministrator@mempl.com"; // SMTP username
$mail->Password = "access@1234"; // SMTP password
$mail->SMTPDebug = 1;

$mail->From = "erpadministrator@mempl.com";
$mail->FromName = "MEM ERP";

$subject = "MEMPL ERP: Agreement signup information missing - regarding";

// Get Director
$q3 = odbc_exec ( $conn, "SELECT [FullName], [Email] FROM [user] WHERE [UserType]='Director' AND [UserStatus]='Active'" );
while ( odbc_fetch_array ( $q3 ) ) {
	// $to_name .= odbc_result($q3, "FullName").", ".odbc_result($q3, "Email");
	$mail->AddAddress ( odbc_result ( $q3, "Email" ), odbc_result ( $q3, "FullName" ) );
}

// Get agreement details not filled
$q1 = odbc_exec ( $conn, "SELECT COUNT([ID]), [Assign To] FROM [CRM Oppurtunity] WHERE [Opp No] NOT IN (SELECT [Opp No] FROM [CRM Agreement]) AND [Level] = 'Agreement signed' GROUP BY [Assign To]" );
while ( odbc_fetch_array ( $q1 ) ) {
	// Get user details
	$q2 = odbc_exec ( $conn, "SELECT [FullName], [Email] FROM [user] WHERE [LoginID]='" . odbc_result ( $q1, "Assign To" ) . "' AND [UserStatus]='Active'" );
	// $cc_name = odbc_result($q2, "FullName").", ".odbc_result($q2, "Email");
	$mail->addCC ( odbc_result ( $q2, "Email" ), odbc_result ( $q2, "FullName" ) );
	$mail->addBCC ( "erpadministrator@mempl.com", "MEM ERP" );
	$mail->AddReplyTo ( "erpadministrator@mempl.com", "MEM ERP" );
	
	$body = "<html><head><style>body, table{font-family: arial; font-size: 16px;}</style></head><body><p>Dear " . odbc_result ( $q2, "FullName" ) . ", </p>";
	$body .= "<p>This is to inform you that, details of below mentioned client is missing in Agreement. You are requested to login into the 
				<a href='http://202.54.232.178/' target='_BLANK' style>MIS Portal</a> with your Login ID and Password.</p> 
				<p>Under <b>Transaction -> Agreements</b>, click on <b>New Agreement</b>
				to open the <u>New Agreement Form</u>.</p>
				<p>List of the clients are hereunder: </p>
				<table style='width: 50%;padding: 5px;border: 1px solid #d3d3d3;'>
					<tr style='font-weight: bold;'>
						<td>SN</td>
						<td>Client Name</td>
						<td>City</td>						
						<td>State</td>						
						<td>Opportunity ID</td>						
					</tr>";
	$i = 1;
	$q4 = odbc_exec ( $conn, "SELECT [Opp No],[Name],[City], [State], [Assign To] FROM [CRM Oppurtunity] WHERE [Opp No] NOT IN (SELECT [Opp No] FROM [CRM Agreement]) AND [Level] = 'Agreement signed' AND [Assign To]='" . odbc_result ( $q1, "Assign To" ) . "'" );
	while ( odbc_fetch_array ( $q4 ) ) {
		$body .= "
					<tr>
						<td>" . $i . "</td>
						<td>" . odbc_result ( $q4, "Name" ) . "</td>
						<td>" . odbc_result ( $q4, "City" ) . "</td>
						<td>" . odbc_result ( $q4, "State" ) . "</td>
						<td>" . odbc_result ( $q4, "Opp No" ) . "</td>
					</tr>";
		$i ++;
	}
	$body .= "</table>
				<p>This is a system generated email, PLEASE DO NOT REPLY.</p>
				</body></html>";
	
	// echo $body;
	$mail->IsHTML ( true ); // set email format to HTML
	
	$mail->WordWrap = 50; // set word wrap to 50 characters
	$mail->Subject = $subject;
	$mail->Body = $body;
	$mail->AltBody = $body;
	$mail->Body;
	
	if (! $mail->Send ()) {
		echo "<p>Message could not be sent.";
		echo "Mailer Error: " . $mail->ErrorInfo . "</p>";
	} else {
		echo "<p>Message has been sent</p>";
	}
}

/*
 * echo "Director: ".$to_name."<br />";
 * echo "CC Name: ".$cc_name."<br />";
 */
?>