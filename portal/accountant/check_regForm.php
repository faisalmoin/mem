<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 5/21/2015
 * Time: 10:56 AM
 */
    session_start();

    require_once("../db.txt");
    /*$LoginID=$_SESSION['LoginID'];

    $UserCompany=mysql_query("SELECT `CompanyTableID`, `CompanyERPCode` FROM `usermap` WHERE `UserLoginID`='$LoginID'") or die(mysql_error());
    $UsrComp=mysql_fetch_array($UserCompany);

    $Company=mysql_query("SELECT * FROM `company` WHERE `id`='$UsrComp[0]'") or die(mysql_error());
    $Comp=mysql_fetch_array($Company);

    //Connect to SchoolERP DB
    $CompanyName=mysql_query("SELECT `Name` FROM `company` WHERE `id`='".$UsrComp[0]."'") or die(mysql_error());
    $CompName=mysql_fetch_array($CompanyName);

    $ms="$CompName[0]"; */
    $ms=$_REQUEST['ms'];

    $RegFormAvail = strtoupper($_REQUEST['RegistrationFormNo']);
    $Result_RegForm = odbc_exec($conn, "SELECT * FROM [Temp Application] WHERE [Registration No_]='".$RegFormAvail."' AND [Company Name]='$ms'");

    if(odbc_num_rows($Result_RegForm) > 0){
        print "<span style=\"color:red;\">Form No. already exists ...</span>";
    }
    else{
        print "<span style=\"color:green;\"></span>";
    }
?>