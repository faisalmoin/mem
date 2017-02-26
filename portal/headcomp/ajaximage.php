<?php
//include('db.php');

//include('../db.class.php'); // Connection to database
$bdd = new db();
 
$acceptedExtension = Array('image/jpeg', 'image/jpg'); // Accepted extensions
$maxSize = 256000;
$destFolder = '../upload/image-profile/'; // We upload the image here
 
$imgType = $_FILES["imageProfile"]["type"];
$imgSize = $_FILES["imageProfile"]["size"];
$imgName = $_FILES["imageProfile"]["name"];
$imgTmpName = $_FILES["imageProfile"]["tmp_name"];
list($txt, $ext) = explode("image/", $imgType); // Get image extension

if (in_array($imgType, $acceptedExtension) && $imgSize <= $maxSize && $imgSize != "") { // Test is extension allowed and image size ok
 
	$newThumbImageName = 'profile-'.$_POST['userId'].'.'.$ext; // We rename the image (in our example it will be profile-1.jpeg)

	if(move_uploaded_file($imgTmpName,$destFolder.$newThumbImageName)) { // Upload image
		
		$query = $bdd->execute('UPDATE tc_tuto_upload_refresh_image SET image_profile = "'.$newThumbImageName.'" WHERE user='.$_POST['userId']); // Update database

		$text = '<p class="myImage"><img src="/upload/image-profile/'.$newThumbImageName.'" width="100" alt="" /></p>'; // Send back the image...
		$text .= '<div class="alert alert-success" role="alert">Image profile uploaded successfully.</div>'; //...and a successfull text
		
		$dataBack = array('text' => $text, 'imgURL' => '/upload/image-profile/'.$newThumbImageName); // Also send back the image URL
	}
 
} else {
	if (!in_array($imgType, $acceptedExtension)) $text = '<div class="alert alert-danger" role="alert">Wrong format! Formats accepted: jpeg, jpg.</div>';
	if ($imgSize > $maxSize) $text = '<div class="alert alert-danger" role="alert">Image too heavy. Maximum 256 Kb.</div>';
	if ($imgSize == "") $text = '<div class="alert alert-danger" role="alert">Please choose an image!</div>';
	
	$dataBack = array('text' => $text);
}

$dataBack = json_encode($dataBack);
echo $dataBack;
?>
?>