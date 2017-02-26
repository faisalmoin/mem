<?php
include('../db.txt');

if($_POST)
{
    $q = odbc_real_escape_string($conn,$_POST['search']);
  //  $DiscCode = odbc_exec($conn, "SELECT [No_] FROM [Discount Fee Header] WHERE [Company name]='$CompName'");
    $strSQL_Result = odbc_exec($conn,"select [ID],[Name] from [Temp Application] where [Name] like '%$q%' OR Email like '%$q%' order by ID LIMIT 5");
    while($row=odbc_fetch_array($strSQL_Result))
    {
        $username   = $row['name'];
        $email      = $row['email'];
        $b_username = '<strong>'.$q.'</strong>';
        $b_email    = '<strong>'.$q.'</strong>';
        $final_username = str_ireplace($q, $b_username, $username);
        $final_email = str_ireplace($q, $b_email, $email);
        ?>
            <div class="show" align="left">
                <img src="https://fbcdn-sphotos-e-a.akamaihd.net/hphotos-ak-prn1/27301_312848892150607_553904419_n.jpg" style="width:50px; height:50px; float:left; margin-right:6px;" /><span class="name"><?php echo $final_username; ?></span>&nbsp;<br/><?php echo $final_email; ?><br/>
            </div>
        <?php
    }
}
?>







    $key=$_GET['key'];
  $DiscCode = odbc_exec($conn, "SELECT [No_] FROM [Discount Fee Header] WHERE [Company name]='$CompName'");
  while(odbc_fetch_array($DiscCode)){
	echo odbc_result($DiscCode, "No_");
	}
    echo json_encode($rs);
?>


<!--?php
if(isset($_FILES["file"]["type"]))
{
$validextensions = array("jpeg", "jpg", "png");
$temporary = explode(".", $_FILES["file"]["name"]);
$file_extension = end($temporary);
if ((($_FILES["file"]["type"] == "image/png") || ($_FILES["file"]["type"] == "image/jpg") || ($_FILES["file"]["type"] == "image/jpeg")
) && ($_FILES["file"]["size"] < 5000000)//Approx. 100kb files can be uploaded.
&& in_array($file_extension, $validextensions)) {
if ($_FILES["file"]["error"] > 0)
{
echo "Return Code: " . $_FILES["file"]["error"] . "<br/><br/>";
}
else
{
if (file_exists("upload/" . $_FILES["file"]["name"])) {
echo $_FILES["file"]["name"] . " <span id='invalid'><b>already exists.</b></span> ";
}
else
{
$sourcePath = $_FILES['file']['tmp_name']; // Storing source path of the file in a variable
$targetPath = "upload/".$_FILES['file']['name']; // Target path where file is to be stored
move_uploaded_file($sourcePath,$targetPath) ; // Moving Uploaded file
echo "<span id='success'>Image Uploaded Successfully...!!</span><br/>";
echo "<br/><b>File Name:</b> " . $_FILES["file"]["name"] . "<br>";
echo "<b>Type:</b> " . $_FILES["file"]["type"] . "<br>";
echo "<b>Size:</b> " . ($_FILES["file"]["size"] / 1024) . " kB<br>";
echo "<b>Temp file:</b> " . $_FILES["file"]["tmp_name"] . "<br>";
}
}
}
else
{
echo "<span id='invalid'>***Invalid file Size or Type***<span>";
}
}
?-->