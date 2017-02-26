<?php
/*
    LATRIX - attendance tracking and reporting
    Copyright (C) 2006,2009 Manticore Software

   This package is free software; you can redistribute it and/or
   modify it under the terms of the GNU General Public
   License as published by the Free Software Foundation; either
   version 3.0 of the License, or (at your option) any later version.

   This library is distributed in the hope that it will be useful,
   but WITHOUT ANY WARRANTY; without even the implied warranty of
   MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the GNU
   Lesser General Public License for more details.

   You should have received a copy of the GNU Lesser General Public
   License along with this library; if not, it is available at
   the GNU web site (http://www.gnu.org/) or by writing to the
   Free Software Foundation, Inc., 51 Franklin St, Fifth Floor,
   Boston, MA  02110-1301  USA

 *****************************************************************************

 Contact:   The LATRIX has its own bugtracker, currently available under
	    http://gateway.manticore-uk.com/mantis. You will need to sign up
	    for a user account before you can log any issues.

 Credits:   Lots. The LATRIX makes use of a good number of other little helpers.
	    The calendar pop-up control is provided by Anthony Garratt
	    The overlib library comes from 
            There is extensive use of PEAR libraries all over the place. For
	    individual package credits please go to pear.php.net
            The WYSIWYG editor is tinyMCE from moxio.

 Link back: Please give me credit and link back to my page.  To ensure that
            search engines give my page a higher ranking you can add the
            following HTML to any indexed page on your web site:

            <A HREF="http://www.latrix.org">
              LATRIX: Attendance tracking and reporting by Manticore Software
            </A>
*/
$page_load_start = microtime(true);
$pagetitle = "Administration";
//var_dump($_POST);
//print_r($_POST);
	require_once("include/defs.inc");	//this can be moved down, once the page size is established from the company settings.
	require_once("classes/errorbox.php");
	require_once("classes/db_conn.php");
	require_once("classes/config.php");
	require_once("classes/menu-bar.php");

$errorbox = new Errorbox();
//var_dump($_POST);
$db_conn = new DB_Conn();
$config = new Config($db_conn);
$config->checkLocation();
$config->checkUser();						// this checks the cookie and loads company information 
//var_dump($config->ctrl);
$menubar = new MenuBar($config, $db_conn);
if ($config->ctrl['action'] == 'show' || $config->ctrl['action'] == 'none') {
	require_once("classes/tableview.php");
	$view = new TableView($config, $db_conn, $errorbox);
} else {
	require_once("classes/recordview.php");
	$view = new RecordView($config, $db_conn, $errorbox);
}
$help_url = $view->help_url;
//$errorbox->debug("There are ".$view->count." rows in the database.");
//$errorbox->debug("action = ".$config->ctrl['action']);
switch ($config->ctrl['action']) {
	case 'add':
		// do not load any data from db, but do load from POST. Suppress navigator and set new flag in item
		$view->navbar->setVisible(false);
		$view->item->setNew(true);
		$view->item->loadPOST();
		$config->ctrl['mode'] = 'edit';
		$config->ctrl['record'] = 0;		//in case there is a previous number
		$config->ctrl['display'] = 0;
		break;
	case 'approve':
		$view->item->approve();
		$config->ctrl['mode'] = 'show';
		$view = nothing;
		require_once("classes/tableview.php");
		$view = new TableView($config, $db_conn, $errorbox);
		break;
	case 'decline':
		$view->item->decline();
		$config->ctrl['mode'] = 'show';
		$view = NULL;
		require_once("classes/tableview.php");
		$view = new TableView($config, $db_conn, $errorbox);
		break;
	case 'del':
	case 'delete':
		$view->item->delete();
		$config->ctrl['mode'] = 'show';
		$view = NULL;
		require_once("classes/tableview.php");
		$view = new TableView($config, $db_conn, $errorbox);
		break;
	case 'edit':
		$view->navbar->setVisible(true);
		$view->item->setNew(false);
	//	$view->item->load($page->ctrl['record']);	already done during instantiation
	//	$view->item->loadPOST();
		$config->ctrl['mode'] = 'edit';
		break;
	case 'export':	//throw it all away and move to the export page;
		header ('Location: export.php');
		break;
	case 'import':	//throw it all away and move to the import page;
		header ('Location: import.php');
		break;
	case 'move':	// not quite sure we need to so something here.
		$config->ctrl['mode'] = 'view';
		break;
	case 'resetpw':
		$view->item->resetPassword();
		$config->ctrl['mode'] = 'show';
		break;
	case 'save':
		/* save: if there is a record number, load the data. if there isn't -> set the suppress flag in the navigator and the new flag in the item.
			overlay data with POST data. check the data against rules. 
			if OK, save the data (or add a record and load the new record ID) and change mode to view. if not OK, change mode to edit 
			load record navigation numbers.
		*/
		if ($config->ctrl['record'] <> 0) {
			$view->item->setNew(false);
			$view->navbar->setVisible(true);
			$view->item->load($config->ctrl['record']);
		} else {
			$view->navbar->setVisible(false);
			$view->item->setNew(true);
		}
		$view->item->loadPOST();
		if ($view->item->checkData() == true) {
//			$errorbox->debug("data has checked OK");
			if ($config->ctrl['record'] == 0) {
				$view->item->add();
			} else {
				$view->item->save();
			}
			$config->ctrl['mode'] = 'view';
			$view->navbar->setVisible(true);
		} else {
//			$errorbox->debug("data has NOT checked OK");
			$config->ctrl['mode'] = 'edit';
		}
		break;
	case 'show':	// no action required
		if($config->ctrl['subject'] == 'Reports') {
			header( 'location: reports.php');
		}
		$config->ctrl['mode'] = 'show';
		break;
	case 'view':	// no action required
		$config->ctrl['mode'] = 'view';
		break;
	case 'password':
		break;
	}

	require_once("include/header.php");
?>
<body onload="initFilter();">
<script type="text/javascript" src="include/StandardScripts.js"></script>
<script type="text/javascript" src="include/overlib_mini.js"></script>
<script type="text/javascript" src="include/scw.js"></script>
<script type="text/javascript" src="include/Filter.js"></script>
<?php
if (isset($view->item) && $view->item->requiresTinyMCE) {
	echo '<script type="text/javascript" src="include/tinymce/jscripts/tiny_mce/tiny_mce.js"></script>'."\n";
	echo "<script type=\"text/javascript\">\ntinyMCE.init({\n";
	echo "theme : \"advanced\",\n";
	echo "mode : \"exact\",\n";
	echo "elements : \"".$view->item->editor_elements."\"\n});\n</script>\n";
}
?>

<form method="post" action="admin.php" name="latform" id="latform" enctype="multipart/form-data">
<div id="overDiv" style="position:absolute; visibility:hidden; z-index:1001;"></div>
	<table class="maintable">
		<tr class="banner"><td>
			<?php include 'include/newheader.php'; ?>
		</td></tr>
		<tr class="menubar"><td>
			<?php echo $menubar->build(); ?>
		</td></tr>
		<tr><td>
			<?php echo $view->show(); ?>
		</td></tr>
		<tr><td>
			<?php include 'include/lfooter.php'; ?>
		</td></tr>
	</table>
</form>
</body>
</html>

