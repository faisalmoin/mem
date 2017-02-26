<?php 

//require_once("SetupLeft.php");

  // Database logic here

 // echo '<pre>'; 
 // print_r($_POST);
 // echo '</pre>';
?>

<?php
require_once("SetupLeft.php");
$db_handle = new DBController();
if(!empty($_POST["country_id"])) {
	$query ="SELECT * FROM states WHERE countryID = '" . $_POST["country_id"] . "'";
	$results = $db_handle->runQuery($query);
?>
	<option value="">Select State</option>
<?php
	foreach($results as $state) {
?>
	<option value="<?php echo $state["id"]; ?>"><?php echo $state["name"]; ?></option>
<?php
	}
}
?>