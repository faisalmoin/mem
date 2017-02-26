<?php
    require_once("header.php");
/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
?>
<style>
table {
    border-collapse: collapse;
    width: 100%;
}

th, td {
    text-align: left;
    padding: 8px;
}

tr:nth-child(even){background-color: #FBF8EF}
</style>
<div class="container">
    
    <ul id="myTab" class="nav nav-tabs">
        <li class="active"><a href="#active" data-toggle="tab">Active</a></li>
        <li><a href="#inactive" data-toggle="tab">In-Active</a></li>
        <li><a href="#alumni" data-toggle="tab">Alumni</a></li>
    </ul>
    
    <div id="myTabContent" class="tab-content">
        
        <div class="tab-pane fade in active" id="active">
            <h3 class="text-primary">Active Student List</h3>
            <table class="table table-responsive">
                <tr style="font-weight: bold;color: #81BEF7;">
                    <td>SN</td>
                    <td>Admission No.</td>
                    <td>Student Name</td>
                    <td>Academic Year</td>
                    <td>Class & Section</td>
                    <td>Date of Birth</td>
                    <td>Gender</td>
                    <td>Addresse</td>
                    <td>Contact No</td>
                </tr>
                <?php
                    $i=1;
                    $stu2=odbc_exec($conn, "SELECT [No_], [Name], [Academic Year], [Class], [Section], [Date Of Birth], [Gender], [Addressee], [Mobile Number] FROM [Temp Student] WHERE [Student Status]=1 AND [Company Name]='$ms' ORDER BY [Academic Year], [Class], [Section], [No_] ASC") or die(odbc_errormsg($conn));
                    while(odbc_fetch_array($stu2)){
                ?>
                <tr>
                    <td><?php echo $i; ?></td>
                    <td><a href="StudentCard.php?id=<?php echo odbc_result($stu2, "No_"); ?>"><?php echo odbc_result($stu2, "No_"); ?></a></td>
                    <td><?php echo odbc_result($stu2, "Name"); ?></td>
                    <td><?php echo odbc_result($stu2, "Academic Year"); ?></td>
                    <td><?php echo odbc_result($stu2, "Class")." ".odbc_result($stu2, "Section"); ?></td>
                    <td><?php echo date('d/M/Y', strtotime(odbc_result($stu2, "Date Of Birth"))); ?></td>
                    <td><?php 
			if(odbc_result($stu2, "Gender")==1) echo "Boy"; 
			if(odbc_result($stu2, "Gender")==2) echo "Girl"; 
		    ?></td>
                    <td><?php echo odbc_result($stu2, "Addressee"); ?></td>
                    <td><?php echo odbc_result($stu2, "Mobile Number"); ?></td>		
                </tr>
                <?php
                        $i++;
                    }
                ?>
            </table>
        </div>
        
        <div class="tab-pane fade in" id="inactive">
            <h3 class="text-primary">In-Active Student List</h3>
            <table class="table table-responsive">
                <!--tr style="font-weight: bold; background-color: #d3d3d3;"-->
                <tr style="font-weight: bold;color: #81BEF7;">
                    <td>SN</td>
                    <td>Admission No.</td>
                    <td>Student Name</td>
                    <td>Academic Year</td>
                    <td>Class & Section</td>
                    <td>Addresse</td>
                    <td>Contact No</td>
                    <td>Effective From</td>
                </tr>
                <?php
                    $i=1;
                    $stu3=odbc_exec($conn, "SELECT [No_], [Name], [Academic Year], [Class], [Section], [Addressee], [Mobile Number],[Withdrwal Applied Date] FROM [Temp Student] WHERE [Student Status]=3 AND [Company Name]='$ms' ORDER BY [Class], [Section], [No_] ASC") or die(odbc_errormsg($conn));
                    while(odbc_fetch_array($stu3)){
                ?>
                <tr>
                    <td><?php echo $i; ?></td>
                    <td><a href="StudentCard.php?id=<?php echo odbc_result($stu3, "No_"); ?>"><?php echo odbc_result($stu3, "No_"); ?></a></td>
                    <td><?php echo odbc_result($stu3, "Name"); ?></td>
                    <td><?php echo odbc_result($stu3, "Academic Year"); ?></td>
                    <td><?php echo odbc_result($stu3, "Class")." ".odbc_result($stu3, "Section"); ?></td>
                    <td><?php echo odbc_result($stu3, "Addressee"); ?></td>
                    <td><?php echo odbc_result($stu3, "Mobile Number"); ?></td>
                    <td><?php if(odbc_result($stu3, "Withdrwal Applied Date") != "1753-01-01 00:00:00.000") echo date('d/M/Y', strtotime(odbc_result($stu3, "Withdrwal Applied Date"))); ?></td>
                </tr>
                <?php
                        $i++;
                    }
                ?>
            </table>
        </div>
        
        <div class="tab-pane fade in" id="alumni">
            <h3 class="text-primary">Alumni Student List</h3>
            <table class="table table-responsive">
                <tr style="font-weight: bold;color: #81BEF7;">
                    <td>SN</td>
                    <td>Admission No.</td>
                    <td>Student Name</td>
                    <td>Academic Year</td>
                    <td>Class & Section</td>
                    <td>Addresse</td>
                    <td>Contact No</td>
                    <td>Effective From</td>
                </tr>
                <?php
                    $i=1;
                    $stu=odbc_exec($conn, "SELECT [No_], [Name], [Academic Year], [Class], [Section], [Addressee], [Mobile Number],[Withdrwal Applied Date] FROM [Temp Student] WHERE [Student Status]=2 AND [Company Name]='$ms' ORDER BY [Class], [Section], [No_] ASC") or die(odbc_errormsg($conn));
                    while(odbc_fetch_array($stu)){
                ?>
                <tr>
                    <td><?php echo $i; ?></td>
                    <td><a href="StudentCard.php?id=<?php echo odbc_result($stu, "No_"); ?>"><?php echo odbc_result($stu, "No_"); ?></a></td>
                    <td><?php echo odbc_result($stu, "Name"); ?></td>
                    <td><?php echo odbc_result($stu, "Academic Year"); ?></td>
                    <td><?php echo odbc_result($stu, "Class")." ".odbc_result($stu, "Section"); ?></td>
                    <td><?php echo odbc_result($stu, "Addressee"); ?></td>
                    <td><?php echo odbc_result($stu, "Mobile Number"); ?></td>
                    <td><?php if(odbc_result($stu3, "Withdrwal Applied Date") != "1753-01-01 00:00:00.000") echo date('d/M/Y', strtotime(odbc_result($stu2, "Withdrwal Applied Date"))); ?></td>
                </tr>
                <?php
                        $i++;
                    }
                ?>
            </table>
        </div>
        
    </div>
    </div>
</div>
<?php require_once("../footer.php");?>