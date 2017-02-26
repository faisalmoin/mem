<?

$id = $_GET['id'];

require_once("../db.txt");

$query = "SELECT `EWS`,`FileType` FROM `registration` where `id`='$id'"; 
$result = MYSQL_QUERY($query); 

$data = MYSQL_RESULT($result,0,"EWS"); 
$type = MYSQL_RESULT($result,0,"FileType"); 
header("Content-length: $size");
header( "Content-type: $type"); 
//print $data;
echo $data;

?>
