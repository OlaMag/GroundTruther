<!-- this file defines the data to be sent to the server and sends it -->
<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<script type="text/javascript" src="js_functions.js"></script>
<link rel="stylesheet" type="text/css" href="stylesheet.css"> 
<title>Data submitted</title>
</head>

<body>
<?php
/* resume current session */
session_start();

/*check if inside session */
if (!isset($_SESSION["email"])){
   exit("<div id='container'><p>Access prohibited; this email and password are not registered!<br />
   <a href='login_page.php'>&nbsp;Log in</a></p></div>");
}
///////* get all variables to fill in tbl_obs in vgi_database *////////////////

$coords = $_POST["coords"];
$disturbance = $_POST["disturbance"];
$date = $_POST["date"];
$landscape = $_POST["landscape"];
//comment and image are optional
$comment = $_POST["comment"];

//start uploading file
$target_dir = "uploads/";
$img_name = $target_dir . basename($_FILES["fileToUpload"]["name"]);
$uploadOk = 1;
$imageFileType = strtolower(pathinfo($img_name,PATHINFO_EXTENSION));


if (basename($_FILES["fileToUpload"]["name"])!=""){
	$err_message = "";
	// Allow certain file formats
	if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
	&& $imageFileType != "gif" && $imageFileType != "tif" && $imageFileType != "tiff") {
		$err_message = $err_message . "Sorry, only JPG, JPEG, PNG, TIF, TIFF & GIF files are allowed.<br>";
		$uploadOk = 0;
	}
	// Check if $uploadOk is set to 0 by an error
	if ($uploadOk == 0) {
		$err_message = $err_message . "Sorry, your image was not uploaded but the rest of your data has been uploaded.";
	// if everything is ok, try to upload file
	} else {
		if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $img_name)) {
			$err_message = $err_message . "The file ". basename( $_FILES["fileToUpload"]["name"]). " has been uploaded.";
		} else {
			$err_message = $err_message . "Sorry, there was an error uploading your image but the rest of your data has been uploaded.";
		}
	}

	echo "<div id='container'>$err_message</div>";
}
//end of uploading a file


/////////////* make a request to enter submitted data into vgi_database *//////////////////
include("est_connection.php"); 
$sess_email = $_SESSION["email"];
$sql = "select id_part from tbl_personal_basic where email='$sess_email'";
$result = mysqli_query($db_connection, $sql);
$id_part = mysqli_fetch_row($result)[0];
$sql = "insert into tbl_obs values ($id_part, NULL, '$coords', '$disturbance', '$landscape', '$comment','$date', '$img_name')";
$result = mysqli_query($db_connection, $sql);
mysqli_close($db_connection);

?>

<!-- if upload is successful, notify user -->
<div id="container">
	<h2>Sent!</h2>
	<p>Thank you! Your observation is now in the database.</p>
	<h2>What would you like to do next?</h2>
	<a href='display_map_result.php'>See map</a>
   <br>
	<a href='contribute_data.php'>Enter another point</a>
   <br>
   <a href='login_page.php'>Log out</a>
</div>
</body>
</html>

