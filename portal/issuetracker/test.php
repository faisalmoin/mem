 <?php
  function show_mails($server, $account, $password)
  {
    //$mailbox = imap_open("{".$server.":110/pop3}INBOX", $account, $password);
    $mailbox = imap_open("{".$server.":110/pop3}INBOX", $account, $password);
    $mails = imap_fetch_overview($mailbox,"1:*", FT_UID); // This is fetching an overview of all emails

    // Output as a table:
    $return = '<table width="100%">
                 <tr>
                   <td><b>#</b></td>
                   <td><b>From</b></td>
                   <td><b>Date / Time</b></td>
                   <td><b>Subject</b></td>
                 </tr>';
    $size = count($mails); // Number of messages
    $cmsg = 0; // This is used to have a continously number
    for($i=$size-1;$i>=0;$i--)
    {
      $cmsg++;
      $value = $mails[$i];
      $return .= '<tr><td>'.$cmsg.'</td><td>'.$value->from.'</td><td>'.$value->date.'</td><td><a href="'.$_SERVER['PHP_SELF'].'?id='.$value->msgno.'">'.$value->subject.'</a></td></tr>';
    }
    $return .= '</table>';
    imap_close($mailbox);
    return $return;
  }

  function show_mail($id, $server, $account, $password)
  {
    $mailbox = imap_open("{".$server.":110/pop3}INBOX", $account, $password);
    $mail = imap_body($mailbox,$id, FT_UID);
    // This is fetching the email..
    $mail = htmlentities(stripslashes($mail));
    /* stripslashes is stripping the slashes, htmlentities transforms all of the non-regular symbols to their equal html code expression. */
    $return = '<pre>'.$mail.'</pre>';
    imap_close($mailbox);
    return $return;
  }

  if(isset($_GET['id']))
    if(is_numeric($_GET['id']))
      echo show_mail($_GET['id'], "mail.educompschools.com", "schoolerp@educompschools.com", "0rgan1cc");
    else
      echo 'wrong parameter';
  else
    echo show_mails("mail.educompschools.com", "schoolerp@educompschools.com", "0rgan1cc");
?> 