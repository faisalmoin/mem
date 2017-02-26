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
	header('Location: inandoutcode.php?target=in');
} else {
	$valid = $config->getLocationFromCode();
	if (!$valid) {
		header('Location: inandoutcode.php?target=in');
	}
}
$sql = "SELECT e.emp_id, fname, sname, d.name AS dept  FROM employees e INNER JOIN presence p ON e.emp_id = p.emp_id
		INNER JOIN teams t ON e.team_id = t.team_id INNER JOIN departments d ON t.dept_id = d.dept_id
		WHERE p.att_date = curdate() AND p.end_time = '00:00:00' and e.company_id = "
		  .$config->company['company_id']." AND e.enabled = 1 ORDER BY dept, sname, fname";
$emp_in = $db_conn->query($sql);

	require_once("include/header.php");
?>
<body>
<script type="text/javascript" src="include/StandardScripts.js"></script>
<form method=post action="in.php">
<table class=maintable>
<tr class="banner">
	<td>
	<?php include 'include/newheader.php'; ?>
	</td>
</tr>
<tr>
	<td>
		<table width=100%>
			<tr>
				<td colspan=3>
					<?php echo date('Y-m-d H:i:s');?>
				</td>
			</tr>
			<tr>
				<td width="5%"></td>
				<td class=cellgreen width="30%">In</td>
				<td width="5%"></td>
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

