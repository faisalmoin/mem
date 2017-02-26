<?php
/**
 * Created by Pallab DB.
 * User: Pallab DB
 * Date: 5/8/2015
 * Time: 4:46 PM
 */

    require_once("header.php");

    if(isset($_REQUEST['submit'])) {
        if (!empty($_REQUEST['AdmNo'])) {
            $Stu = "SELECT * FROM [Temp Student] WHERE [Company Name] = '$ms' AND [Student Status] <3 AND (lower([No_]) LIKE lower('%".strtoupper($_REQUEST['AdmNo'])."%') OR lower([Name]) LIKE lower('%".strtoupper($_REQUEST['AdmNo'])."%') OR lower([Mobile Number]) LIKE lower('%".strtoupper($_REQUEST['AdmNo'])."%') OR lower([Phone Number]) LIKE lower('%".strtoupper($_REQUEST['AdmNo'])."%') OR lower([Enquiry No_]) LIKE lower('%".strtoupper($_REQUEST['AdmNo'])."%') OR lower([Application No_]) LIKE lower('%".strtoupper($_REQUEST['AdmNo'])."%') OR lower([Registration No_]) LIKE lower('%".strtoupper($_REQUEST['AdmNo'])."%')) ";
            $check = odbc_exec($conn, $Stu);
            if(odbc_num_rows($check) < 1){
                echo("<div class='container'>
				        <div class='bs-example'>
					        <div class='alert alert-danger alert-error'>
						        <a href='#' class='close' data-dismiss='alert'>&times;</a>
						        <strong>Error!</strong> Data not found, kindly check ...
					        </div>
				        </div>
				    </div>");
            }
            /*else{
                header("Location: StudentCard.php?q=".odbc_result($check, 'No_'));
            }*/
        } else {
            echo "<div class='container'>
				    <div class='bs-example'>
                        <div class='alert alert-danger alert-error'>
                            <a href='#' class='close' data-dismiss='alert'>&times;</a>
                            <strong>Error!</strong> Please provide Student's Enrollment/Admission Number ...
                        </div>
				    </div>
				</div>";
        }
    }

?>
<div class="container">
    <div class="panel panel-default">
        <div class="panel-heading"><h3 class="text-primary">Student's Card</h3></div>
            <div class="panel-body">
                <form role="form" method="get">
                    <div class="row form-group">
                        <div class="col-sm-2"></div>
                        <div class="col-sm-2"><label class="control-label">Student Enrollment No.</label></div>
                        <div class="col-sm-4"><input type="text" name="AdmNo" title="Enter Student's Name / Application No / Registration No / Mobile Number / Phone Number / Enquiry No. ..." class="form-control input-lg" required autocomplete="Off" autofocus="true" style="text-transform: uppercase" /></div>
                        <div class="col-sm-2"><button type="submit" class="btn btn-primary input-lg" name="submit">Submit</button></div>
                        </div>
                </form>
            </div>
    </div>
</div>

<div class="container">
    <div class="panel panel-default">
        <div class="panel-heading"><h3 class="text-primary">Student List</h3></div>
        <div class="table-responsive">
            <table class="table table-striped table-hover table-responsive">
                <thead>
                    <tr style="font-weight: bold;" class="warning">
                        <td>SN</td>
                        <td>Registration No</td>
                        <td>Student Name</td>
                        <td>Gender</td>
                        <td>Class</td>
                        <td>Section</td>
                        <td>Academic Year</td>
                        <td>Status</td>
                    </tr>
                </thead>
                <tbody>
                <?php
                    $i = 1;
                    $Student = odbc_exec($conn, $Stu);
                    while(odbc_fetch_array($Student)){
                ?>
                <tr>
                    <td><?php echo $i; ?></td>
                    <td>
                        <a href="StudentCard.php?id=<?php echo odbc_result($Student, "No_")?>" class="text-primary"><?php echo odbc_result($Student, "No_"); ?></a>
                        <?php
                            //require("ModalStuCard.php");
                        ?>
                    </td>
                    <td><?php echo odbc_result($Student, "Name"); ?></td>
                    <td><?php
                            if(odbc_result($Student, "Gender") == 1) echo "Boy";
                            if(odbc_result($Student, "Gender") == 2) echo "Girl";
                        ?></td>
                    <td><?php echo odbc_result($Student, "Class"); ?></td>
                    <td><?php echo odbc_result($Student, "Section"); ?></td>
                    <td><?php echo odbc_result($Student, "Academic Year"); ?></td>
                    <td><?php
                            if(odbc_result($Student, "Student Status")== 0) echo "";
                            if(odbc_result($Student, "Student Status")== 1) echo "Active";
                            if(odbc_result($Student, "Student Status")== 2) echo "In-Active";
                            if(odbc_result($Student, "Student Status")== 3) echo "Alumni";
                        ?></td>
                </tr>
                <?php
                        $i += 1;
                    }
                ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
<?php require_once("../footer.php"); ?>