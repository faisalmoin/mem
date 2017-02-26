<?php
    require_once("header.php");
    $CompName = $_REQUEST['CompName'];
    $Comp = odbc_exec($conn, "SELECT * FROM [Company Information] WHERE [ID]='$CompName'") or die(odbc_errormsg($conn));
?>
		<link href='https://fonts.googleapis.com/css?family=Raleway' rel='stylesheet' type='text/css'>
			<style>
				body {
					font-family: 'Raleway', sans-serif;
					font-size: 13px;
					padding: 0px;
				}
				html {
					-webkit-text-size-adjust: 100%; /* Prevent font scaling in landscape while allowing user zoom */
				}
				thead {display: table-header-group;}
			</style>
                        
    <div class="container">
        <span style="font-size: 25px; text-align: center; " class="text-primary">Royalty Setup</span>
        <hr />
        <h4>School Information</h4>
		<table class="table table-responsive" style="border: 1px solid #d3d3d3;">
                    <tr>
                    <td style="border: none">School Name</td>
                    <td style="border: none; font-weight: normal;font-size: 18px;" colspan="5"><?php echo strtoupper(odbc_result($Comp, "Name"))?></td>
                    </tr>
                    <tr>
                    <td style="border: none">Trust Name</td>
                    <td style="border: none; font-weight: normal;" colspan="3"><?php 
                        $Trust = odbc_exec($conn, "SELECT [Trust Name], [MOU File] FROM [CRM Agreement] WHERE [ID]= '".odbc_result($Comp, "Trust")."'");
                        echo strtoupper(odbc_result($Trust, "Trust Name"))
                    ?></td>
                    <td style="border: none"></td>
                    <td style="border: none"></td>
                    </tr>
                    <tr>
                    <td style="border: none">City</td>
                    <td style="border: none"><?php echo strtoupper(odbc_result($Comp, "City"))?></td>
                    <td style="border: none">State</td>
                    <td style="border: none"><?php
                        $State = odbc_exec($conn, "SELECT [State] FROM [postcode] WHERE [StateCode]='".odbc_result($Comp, "State")."'");
                    echo strtoupper(odbc_result($State, "State"))?></td>
                    <td style="border: none"></td>
                    <td style="border: none"></td>
                    </tr>
                    <tr>
                    <td style="border: none">Brand</td>
                    <td style="border: none"><?php 
                        echo odbc_result($Comp, "Brand")==1?"TKS":""; 
                        echo odbc_result($Comp, "Brand")==2?"TMS":""; 
                        echo odbc_result($Comp, "Brand")==3?"UA":""; 
                        echo odbc_result($Comp, "Brand")==4?"PSBB MS":""; 
                        echo odbc_result($Comp, "Brand")==5?"TSMS":""; 
                    ?></td>
                    <td style="border: none"></td>
                    <td style="border: none"></td>
                    <td style="border: none"></td>
                    <td style="border: none">
                        <a href="<?php echo odbc_result($Trust, "MOU File")?>" target="_BLANK"><span class="glyphicon glyphicon-file"></span>Agreement File</a>
                    </td>
                    </tr>
                </table>
        
                <h4>Fee Component</h4>                
                <form method="post" action="RoyaltySetup03.php">                    
                    <?php
                        //$FeeComp = odbc_exec($conn, "select [Description],[Fee Code],[Amount],[Academic Year],[Class] from [Class Fee Line] WHERE [Company Name]='".$CompName."' ORDER BY [Description]") or die(odbc_errormsg($conn));
                     $FeeComp = odbc_exec($conn, "select DISTINCT([Description]) from [Class Fee Line] WHERE [Company Name]='".$CompName."' ORDER BY [Description]") or die(odbc_errormsg($conn));
                        ?>
                    <table class="table table-responsive table-bordered">
                        <thead>
                        <tr style="background-color: #d4d2d2;">
                            <th>SN</th>
                            <th>Fee Component</th>
                            <th></th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php
                            $j=1;
                            while(odbc_fetch_array($FeeComp)){
                                $Check = odbc_exec($conn, "SELECT DISTINCT([Fee Description]) FROM [Royalty Setup] WHERE [Company Name]='$CompName' AND [Fee Description]='".odbc_result($FeeComp, "Description")."' ") or die(odbc_errormsg($conn));
                        ?>
                            <tr <?php if(odbc_num_rows($Check) == 1){echo 'style="color: #000080;font-weight: bold;"';}?> >
                            <td><?php echo $j; ?></td>
                            <td>
                                    <?php echo odbc_result($FeeComp, "Description"); ?>
                                    <input type="hidden" name="FeeDescription<?php echo $j?>" value="<?php echo odbc_result($FeeComp, "Description"); ?>" />
                                    
                            </td>
                            <td align="right">
                                    <input type="checkbox" name="select<?php echo $j;?>" value="1"
                                    <?php
                                            if(odbc_num_rows($Check) == 1) echo " checked ";
                                    ?>
                                >
                            </td>
                        </tr>

                    <?php
                                    $j++;
                            }
                    ?>
                    <tr>
                            <td colspan="3" align="right">
                                    <input type="hidden" name="count" value="<?php echo $j;?>">
                                    <input type="hidden" name="CompName" value="<?php echo $CompName;?>">
                                    <?php 
                                        if(($j-1) != 0){
                                    ?>
                                    <input type="submit" value="Submit" class="btn btn-primary">
                                    <?php
                                        }
                                        else{
                                            echo '<div class="alert alert-warning" style="text-align: center">
			<strong>Info ! </strong>School did not setup Fee Structure. Kindly contact with school authorities ...
                        <a href="#" class="btn btn-default" onclick="javascript: history.go(-1)"> Back </a>
			</div>';
                                                                            }
                                    ?>
                            </td>
                    </tr>
                    </tbody>
            </table>
        </form>
    </div>
		<?php require_once("../footer.php"); ?>