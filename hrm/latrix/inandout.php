<?php
/*
    LATRIX - attendance tracking and reporting
    Copyright (C) 2006,2009 Manticore Software
    Published under GPL V3, see admin.php for more detail
*/
$page_load_start = microtime(true);
$pagetitle = "In & Out";
$help_url = 'http://www.latrix.org.uk/node/51';

	require_once("include/defs.inc");
	require_once("classes/errorbox.php");
	require_once("classes/db_conn.php");
	require_once("classes/config.php");

// load three recordsets: ins, leaves and outs
$errorbox = new Errorbox();
$db_conn = new DB_Conn();
$config = new Config($db_conn);
// Check the access code (posted across timed refreshes). If there isn't one, get one
if (!isset($_POST['txtaccesscode'])) {
	header('Location: inandoutcode.php?target=inandout');
} else {
	$valid = $config->getLocationFromCode();
	if (!$valid) {
		header('Location: inandoutcode.php?target=inandout');
	}
}
$sql = "SELECT e.emp_id, fname, sname, d.name AS dept  FROM employees e INNER JOIN presence p ON e.emp_id = p.emp_id
		INNER JOIN teams t ON e.team_id = t.team_id INNER JOIN departments d ON t.dept_id = d.dept_id
		WHERE p.att_date = curdate() AND p.end_time = '00:00:00' and e.company_id = "
		  .$config->company['company_id']." AND e.enabled = 1 ORDER BY dept, sname, fname";
$emp_in = $db_conn->query($sql);
// being out is not that simple. Outer joins don't work for this and I do not want to force use of subqueries. 
// this first query simply gives us everybody who is not on leave
// We then have to filter out all those people that are in. 
$sql = "SELECT DISTINCT e.emp_id, fname, sname, d.name AS dept FROM employees e LEFT JOIN emp_leave l ON e.emp_id = l.emp_id 
		INNER JOIN teams t ON e.team_id = t.team_id INNER JOIN departments d ON t.dept_id = d.dept_id
		  WHERE ((l.start_date > curdate() OR l.start_date is NUll) OR (l.end_date < curdate() OR l.end_date IS NULL))
		  AND e.company_id = ".$config->company['company_id']." AND e.enabled = 1 AND e.visitor = 0 ORDER BY dept, sname, fname";
$emp_out = $db_conn->query($sql);
//need a different construct for being out. The condition basically is: anybody who is 
//		a) not on leave
//		b) has no record in attendance for the current date with an end time = 00:00:00 (which indicates being in) 
$sql = "SELECT e.emp_id, fname, sname, d.name AS dept FROM employees e INNER JOIN emp_leave l ON e.emp_id = l.emp_id
		INNER JOIN teams t ON e.team_id = t.team_id INNER JOIN departments d ON t.dept_id = d.dept_id
		  WHERE l.start_date <= curdate() AND l.end_date >= curdate() AND e.company_id = "
		  .$config->company['company_id']." AND e.enabled = 1 AND e.visitor = 0 ORDER BY sname, fname";
$emp_leave = $db_conn->query($sql);

function emp_is_in($row) {
	global $emp_in;
	if (count($emp_in) == 0) {
		return false;
	}
	foreach($emp_in as $rowin) {
		if ($rowin['emp_id'] == $row['emp_id']) {
			return true;
		}
	}
	return false;
}

	require_once("include/header.php");
?>
</head>
<body>
<script type="text/javascript" src="include/StandardScripts.js"></script>
<form method=post action="inandout.php">
<table class="maintable">
<tr class="banner">
	<td>
	<?php include 'include/newheader.php'; ?>
	</td>
</tr>
<tr>
	<td>
		<table width="100%">
			<tr>
				<td colspan=5>
					<?php echo date('Y-m-d H:i:s');?>
				</td>
			</tr>
			<tr>
				<td style="width: 5%"></td>
				<td class=cellgreen style="width: 30%;">In</td>
				<td class=cellamber style="width: 30%;">On Leave</td>
				<td class=cellred style="width: 30%;">Out</td>
				<td style="width: 5%"></td>
			</tr>
			<tr>
				<td></td>
				<td class=framegreen>
				<input type="hidden" id="txtaccesscode" name="txtaccesscode" value="<?php echo $_POST['txtaccesscode'] ?>">
				<?php
				if (count($emp_in) > 0) {
					$dept = "";
					foreach ($emp_in as $row) {
						if ($dept <> $row[3]) {
							if ($dept <> "") { echo "</ul>\n"; }
							$dept = $row[3];
							echo '<ul>'.$dept.':';
						}
						echo '<li>'.$row[2].','.$row[1];
					}
					echo "</ul>\n";
				} else {
					echo 'None';
				}
				?>
				</td>
				<td class=frameamber>
				<?php
				if (count($emp_leave) > 0) {
					$dept = "";
					foreach ($emp_leave as $row) {
						if ($dept <> $row[3]) {
							if ($dept <> "") { echo "</ul>\n"; }
							$dept = $row[3];
							echo '<ul>'.$dept.':';
						}
						echo '<li>'.$row[2].','.$row[1];
					}
					echo "</ul>\n";
				} else {
					echo 'None';
				}
				?>
				</td>
				<td class=framered>
				<?php
				if (count($emp_out) > 0) {
					// OK so there are people who are not on leave. Now let's see who is in and who is not in. 
					$dept = '';
					foreach ($emp_out as $row) {
						if (!emp_is_in($row)) {
							if ($dept <> $row[3]) {
								if ($dept <> '') { echo "</ul>\n"; }
								$dept = $row[3];
								echo '<ul>'.$dept.':';
							}
							echo "<li>&nbsp;&nbsp;&nbsp;".$row[2].','.$row[1];
						}
					}
					echo "</ul>\n";
				} else {
					echo 'None';
				}
				?>
				</td>
				<td></td>
			</tr>
		</table>
	</td>
</tr>
<tr>
	<td>
	<?php include 'include/lfooter.php'; ?>
	</td>
</tr>
</table>
</form>
</body>
</html>

