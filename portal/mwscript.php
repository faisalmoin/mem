<?php
/**
 * Created by PhpStorm.
 * User: Pallab DB
 * Date: 30-07-2015
 * Time: 11:03
 */
//error_reporting( error_reporting() & ~E_NOTICE );

    set_time_limit(0);
    //Connection String to local database.
    $server = "DESKTOP-5CA22A2\MSSQL";
    $database = "MDB_School";

    $conn = odbc_connect("Driver={SQL Server};Server=$server;Database=$database;", "", "") or die( print_r( odbc_errormsg(), true));

    if(!$conn){
        echo "Error !!!";
    }
    else{
        //Connect to Middleware Database;
        $MWServer = "10.0.0.82";
        $MWDB = "MDB_School";
        $MWUser = "sa";
        $MWPass = "@514educomp";

        $MWConn = odbc_connect("Driver={SQL Server};Server=$MWServer;Database=$MWDB;", "$MWUser", "$MWPass") or die( print_r( odbc_errormsg(), true));
        
        $SQL1 = odbc_exec($MWConn, "SELECT * FROM INFORMATION_SCHEMA.TABLES ORDER BY 'TABLE_NAME'") or die(odbc_errormsg($MWConn));
        
        if(!$MWConn){
            echo "Error !!!";
        }
        else{
            echo "Middleware Connection  - Success !!!<br />";
            $table = "USE MDB_School;<br />";

            while(odbc_fetch_row($SQL1)){
                //Check if Table is available in Local DB;
                $Check = odbc_exec($conn, "select * from sysobjects where name = '".odbc_result($SQL1, "TABLE_NAME")."' ") or die(odbc_errormsg($conn));
                if(odbc_num_rows($Check) == 0 ){
                    //echo "Action: Create !!! <br />";

                    //Fetch table from Middle-ware
                    $TabStr = odbc_exec($MWConn, "select * from Information_schema.Columns where table_name = '".odbc_result($SQL1, "TABLE_NAME")."'") or die(odbc_errormsg($MWConn));
                    $lastnum = odbc_num_rows($TabStr);
                    /*
                    $i=1;
                    $table .= "<br /><br />SET ANSI_NULLS ON<br />
                        GO<br />
                        SET QUOTED_IDENTIFIER ON<br />
                        GO<br />
                        SET ANSI_PADDING ON<br />
                        GO<br /><br />";
                    $table .= "CREATE TABLE [".odbc_result($SQL1, "TABLE_NAME")."](<br />";
                    while(odbc_fetch_array($TabStr)){
                        $table .= "[".odbc_result($TabStr, 'COLUMN_NAME')."] [".odbc_result($TabStr, 'DATA_TYPE')."]";
                        if(odbc_result($TabStr, 'DATA_TYPE') == "varchar") $table .= "(".odbc_result($TabStr, 'CHARACTER_MAXIMUM_LENGTH').")";
                        if(odbc_result($TabStr, 'DATA_TYPE') == "decimal") $table .= "(".odbc_result($TabStr, 'NUMERIC_PRECISION').", ".odbc_result($TabStr, 'NUMERIC_PRECISION_RADIX').")";
                        if(odbc_result($TabStr, "IS_NULLABLE") == "NO") $table .= " NOT NULL";

                        if ($i != $lastnum) $table .= ",";
                        $table .= "<br />";
                        $i +=  1;
                    }

                    $table .= ") ;<br /><br />";
                    echo $table;
                     */
                }
                else{
                    //If table is available then check no. of column
                    $MW_Table = odbc_exec($MWConn, "SELECT Count(*) FROM INFORMATION_SCHEMA.Columns where TABLE_NAME = '".odbc_result($SQL1, "TABLE_NAME")."'") OR die(odbc_errormsg($MWConn));
                    $lTable = odbc_exec($conn, "SELECT Count(*) FROM INFORMATION_SCHEMA.Columns where TABLE_NAME = '".odbc_result($SQL1, "TABLE_NAME")."'") OR die(odbc_errormsg($conn));
                    
                    if(odbc_result($MW_Table, "") == odbc_result($lTable, "")){
                        //fetch the column fields
                        $TabField = odbc_exec("SELECT COLUMN_NAME FROM INFORMATION_SCHEMA.Columns where TABLE_NAME = '".odbc_result($SQL1, "TABLE_NAME")."'") or die(odbc_errormsg($MWConn));
                        while(odbc_fetch_array($TabField)){
                            echo odbc_result($TabField, 'COLUMN_NAME')."<br />";
                        }
                        
                    }
                    else{
                        echo odbc_result($SQL1, "TABLE_NAME")." - Alter<br />";
                        //Check fields in each table
                        $MWTabStr = odbc_exec($MWConn, "select * from Information_schema.Columns where table_name = '".odbc_result($SQL1, "TABLE_NAME")."'") or die(odbc_errormsg()); // Middleware
                        while(odbc_fetch_array($MWTabStr)){
                            $LclTabStr = odbc_exec($conn, "select * from Information_schema.Columns where table_name = '".odbc_result($SQL1, "TABLE_NAME")."".odbc_result($MWTabStr, "COLUMN_NAME")."'") or die(odbc_errormsg($conn)); // Local
                            if(odbc_num_rows($LclTabStr) == 0 ) {
                                $alter = "ALTER TABLE [".odbc_result($SQL1, "TABLE_NAME")."] ADD [";
                                $alter .= odbc_result($MWTabStr, 'COLUMN_NAME')."]";
                                $alter .= " [".odbc_result($MWTabStr, 'DATA_TYPE')."] "; /*
                                if(odbc_result($MWTabStr, 'DATA_TYPE') == "varchar") $alter .= "(".odbc_result($MWTabStr, 'CHARACTER_MAXIMUM_LENGTH').")";
                                if(odbc_result($MWTabStr, 'DATA_TYPE') == "decimal") $alter .= "(".odbc_result($MWTabStr, 'NUMERIC_PRECISION').", ".odbc_result($MWTabStr, 'NUMERIC_PRECISION_RADIX').")";
                                if(odbc_result($MWTabStr, "IS_NULLABLE") == "NO") $alter .= " NOT NULL"; */
                                $alter .=";";
                                echo $alter ."<br />";
                            }
                        }
                    }
                }

                //echo "</p>";
            }

        }
    }
?>