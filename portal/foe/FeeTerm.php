		<?php require_once("header.php");?>
		
			<div class="container">
				<h2 class="text-primary">Term Fee</h2>
				<div class="row">
				<div class="col-md-8 col-md-offset-2">
				<form action="FeeTermList.php" method="POST">
				<table class="table table-responsive">
				<tr>
				<td>Select Fee Type.</td>
				<td> 
				<select class="form-control" name="FeeType" id="section" required>
			    <option value=""></option>
			     <?php
			      $FeeCode=odbc_exec($conn, "SELECT DISTINCT([Code]) FROM [Fee Type] WHERE [Company Name]='$ms'");
			       while(odbc_fetch_array($FeeCode)){
			       echo "<option value='".odbc_result($FeeCode, 'Code')."'";
			       echo ">".odbc_result($FeeCode, 'Code')."</option>";
			       }
			     ?>
			    </select>
			    </td>
			    </tr>
			    <tr>
			    <td>Select Class Code</td>
			    <td>
			    <select class="form-control" name="ClssCode" id="section" required>
			    <option value=""></option>
			    <?php
			      $ClassSec=odbc_exec($conn, "SELECT DISTINCT([Class Code]) FROM [Class Section] WHERE [Company Name]='$ms'");
			      while(odbc_fetch_array($ClassSec)){
			      echo "<option value='".odbc_result($ClassSec, 'Class Code')."'";
			      echo ">".odbc_result($ClassSec, 'Class Code')."</option>";
			      }
			    ?>
			    </select>
			    <!--input type="hidden" value="<--?php echo odbc_result($ClassSec, "Class"); ?>" name="Class">
		        <input type="hidden" value="<--?php echo odbc_result($ClassSec, "Academic Year"); ?>" name="AcademicYear"-->
		
			    </td>
			    </tr>
			    <tr><td><input type="submit" value="Next" class="btn btn-primary"></td> </tr>
			    </table>
			    </form>
			  </div>
			  </div>
			</div>
			<?php require_once("../footer.php"); ?>