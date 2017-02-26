<?php
/*
    LATRIX - attendance tracking and reporting
    Copyright (C) 2006,2009 Manticore Software
    Published under GPL V3, see admin.php for more detail
*/
$page_load_start = microtime(true);
$pagetitle = "Employee Home Page";
	require_once("include/defs.inc");	//this can be moved down, once the page size is established from the company settings.
	require_once("classes/errorbox.php");
	require_once("classes/db_conn.php");
	require_once("classes/config.php");
	require_once("classes/menu-bar.php");
	require_once("classes/homeview.php");

$errorbox = new Errorbox();
//var_dump($page->ctrl);
//var_dump($_POST);
$db_conn = new DB_Conn();
$config = new Config($db_conn);
$config->checkLocation();
$config->checkUser();						// this checks the cookie and loads company information 
$menubar = new MenuBar($config, $db_conn);
$view = new HomeView($config, $db_conn, $errorbox);
$help_url = $view->help_url;

	require_once("include/header.php");
?>
<body>
<script type="text/javascript" src="include/StandardScripts.js"></script>
<script type="text/javascript" src="include/overlib_mini.js"></script>
<script type="text/javascript" src="include/scw.js"></script>
<form method="post" action="admin.php" name="latform" id="latform" enctype="multipart/form-data">
<div id="overDiv" style="position:absolute; visibility:hidden; z-index:1001;"></div>
	<table class="maintable" cellspacing="0px" cellpadding="0px" >
		<tr class="banner"><td>
			<?php include 'include/newheader.php'; ?>
		</td></tr>
		<tr><td>
			<?php echo $menubar->build(); ?>
		</td></tr>
		<tr><td style="padding: 10px;" align="center">
			<?php echo $view->show(); ?>
		</td></tr>
		<tr><td>
			<?php include 'include/lfooter.php'; ?>
		</td></tr>
	</table>
</form>
</body>
</html>



