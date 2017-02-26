<?php

$connection = imap_open ("{mail.educompschools.com}", "schoolerp@educompschools.com", "0rgan1cc") or die("Can't connect to '" . $imapaddress ."' as user '" . $imapuser ."' with password '" . $imappassword ."': " . imap_last_error());

$m_search=imap_search ($connection, 'UNSEEN');
if(!$m_search){
	echo("No New Messages ");
}
else{
	// Order results starting from newest message
	rsort($m_search);
	
	//loop through and do what's necessary 
	foreach ($m_search as $onem) {

		//get imap header info for obj thang
		$headers = imap_headerinfo($connection, $onem);
		$head = imap_fetchheader($connection, $headers->Msgno);
		$body = imap_body($connection, $headers->Msgno, FT_INTERNAL );

		$fromaddr = $header->from[0]->mailbox . "@" . $header->from[0]->host;
		
		echo "<br /><br />";
	}
}


//purge messages (if necessary)
imap_expunge($connection);

//close mailbox 
imap_close($connection);

?>