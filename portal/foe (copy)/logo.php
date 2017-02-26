<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 5/6/2015
 * Time: 8:45 AM
 */

    $LoginID = "pallabdb";

    require_once("../db.txt");

    $UserCompany=mysql_query("SELECT `CompanyTableID`, `CompanyERPCode` FROM `usermap` WHERE `UserLoginID`='$LoginID'") or die(mysql_error());
    $UsrComp=mysql_fetch_array($UserCompany);

    $Company=mysql_query("SELECT * FROM `company` WHERE `id`='$UsrComp[0]'") or die(mysql_error());
    $Comp=mysql_fetch_array($Company);

    //Connect to SchoolERP DB
    $CompanyName=mysql_query("SELECT `Name` FROM `company` WHERE `id`='".$UsrComp[0]."'") or die(mysql_error());
    $CompName=mysql_fetch_array($CompanyName);

    $ms="$CompName[0]\$";

    //Picture from SchoolERP DB
    $picture="SELECT [Picture] FROM [".$ms."Company Information]";
    $pic = odbc_exec($conn, $picture);

    //$src = "data:image/jpg;base64,".base64_encode(odbc_result($pic,"Picture"));
    $src = odbc_result($pic,"Picture");
    $imgage = base64_decode($src);

    $im = imagecreatefromstring($imgage);
    echo $imgage;
if ($im !== false) {
    header('Content-Type: image/png');
    imagepng($im);
    imagedestroy($im);
}
else {
    echo 'An error occurred.';
}

    //print $src ;
?>
<img src="<?php $src ?>" ></img>
