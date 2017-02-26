<?php
	//require_once("../db.txt");
	
	$inbox = imap_open ("{mail.educompschools.com}", "schoolerp@educompschools.com", "0rgan1cc") or die("Can't connect to '" . $imapaddress ."' as user '" . $imapuser ."' with password '" . $imappassword ."': " . imap_last_error());
	
	$emails = imap_search($inbox,'UNSEEN');
	
	if($emails) {
	
		/* begin output var */
		$output = '';
		
		/* put the newest emails on top */
		rsort($emails);
		
		/* for every email... */
		foreach($emails as $email_number) {
			
			/* get information specific to this email */
			$overview = imap_fetch_overview($inbox,$email_number,0);
			$message = imap_body($inbox, $email_number);
			
			/* output the email header information */
			$output.= '<div class="toggler '.($overview[0]->seen ? 'read' : 'unread').'">';
			$output.= '<span class="subject">'.$overview[0]->subject.'</span> ';
			$output.= '<span class="from">'.$overview[0]->from.'</span>';
			$output.= '<span class="date">on '.$overview[0]->date.'</span>';
			$output.= '</div>';
						
			/* output the email body */
			$output.= '<div class="body">'.$message.'</div>';
			
			$x=strtolower($overview[0]->subject);
			$tempsubject=(explode(" ",$x));
			//if($tempsubject[0]=='complaint' || $tempsubject[0]=='issue')
			//{
			/*	$countID=mysql_query("SELECT COUNT(`id`)+1 FROM `complaint`") or die(mysql_error());
				$cID=mysql_fetch_array($countID);
				
				$ComplaintID="CTKT".date('ym').str_pad($cID[0],8,"0", STR_PAD_LEFT);

				$sql="INSERT INTO `complaint` SET
					`CallDate` = '".date("Y-m-d H:i:s", strtotime($overview[0]->date))."',
					`Description` = '".addslashes($message)."',
					`EmailAddress` = '".$overview[0]->from."',
					`ComplaintID` = '".$ComplaintID."',
					`CallStatus`='Open'";
				
				//$result = mysql_query($sql) or die(mysql_error());
				
				//Email
				$to = "schoolerp@educompschools.com, ".$overview[0]->from;
				$from = "schoolerp@educompschools.com";

				$subject = "Re: School ERP // Complaint Acknowledgement // Complaint ID: $ComplaintID // ".$overview[0]->subject;

				$body .="<html><body style='font-family: Arial, Helvetica, Sans-Serif; font-size: 13px'>
					<p align='justify'>Dear user,</p>
					<br />
					<p align='justify'>We have recieved your complaint as per the below mentioned details. We will try to resolve the issue at the earliest and will keep you updated regarding the same.</p>
					<br /><br />";
				$body .= "<div >".addslashes($message)."</div>";
				$body .="<br /><br />
					Kindly keep the ticket number - <b>$ComplaintID</b>, for future reference.
					<p align='justify'>
					    Thanks & Regards,<br />
					    Support Team <br />
					    ESIML
					</p>
					</body></html>";
					
				require_once("../smtp.php");
			*/
			//}
		}		
		echo $output;
		//echo "All complaints logged ...";
	} 
	else{
		echo "No new mails...";
	}
	
	/* close the connection */
	imap_close($inbox);
?>