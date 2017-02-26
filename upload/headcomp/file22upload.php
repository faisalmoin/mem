<?php
	
	$string = "";
	$target_dir = "../uploads/";
	echo "<br /><br /><br /><br />";
//if($_REQUEST["fileToUpload"] != ""){
    //  $total = count($_FILES['fileToUpload']['name']);
      for($i=0; $i < count($_FILES['fileToUpload']['name']); $i++) {
	if($_FILES['fileToUpload']['name'][$i] == ""){
		$string .= "'', ";
	}
	else{
		$target_file = $target_dir . uniqid(). basename($_FILES["fileToUpload"]["name"][$i]);
		$uploadOk = 1;
	
		// Check file size
		if ($_FILES["fileToUpload"]["size"][$i] > 210000) {
			exit( "Sorry, your file is too large.");
			$uploadOk = 0;
		}
		
                
                if ($uploadOk == 0) {
		exit( "Sorry, your file was not uploaded.");
	// if everything is ok, try to upload file
	        } else {
		if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"][$i], $target_file)) {
			//echo "The file ". basename( $_FILES["fileToUpload"]["name"]). " has been uploaded.";
		} else {
			exit( "Sorry, there was an error uploading your file.");
		}
	       }
	       
		$string .= "'".$target_file."', ";
	
	}
	/*
	$imageFileType = pathinfo($target_file,PATHINFO_EXTENSION);
	// Check if image file is a actual image or fake image
	if(isset($_POST["submit"])) {
		$check = getimagesize($_FILES["fileToUpload"]["tmp_name"][$i]);
		if($check !== false) {
			echo "File is an image - " . $check["mime"] . ".";
			$uploadOk = 1;
		} else {
			exit( "File is not an image.");
			$uploadOk = 0;
		}
	}
	// Check if file already exists
	if (file_exists($target_file)) {
		exit( "Sorry, file already exists.");
		$uploadOk = 0;
	}
	
	// Allow certain file formats
	/*
        if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
	&& $imageFileType != "gif" ) {
		//echo "File Type : ".$imageFileType."<br />";
		exit( "Sorry, only JPG, JPEG, PNG,  & GIF files are allowed.");
		$uploadOk = 0;
	}*/
	// Check if $uploadOk is set to 0 by an error
	/*if ($uploadOk == 0) {
		exit( "Sorry, your file was not uploaded.");
	// if everything is ok, try to upload file
	} else {
		if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"][$i], $target_file)) {
			//echo "The file ". basename( $_FILES["fileToUpload"]["name"]). " has been uploaded.";
		} else {
			exit( "Sorry, there was an error uploading your file.");
		}
	}*/
      }
//}
?>