<!-- check user name and password match the ones in the database -->
<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<script type="text/javascript" src="js_functions.js"></script>
<link rel="stylesheet" type="text/css" href="stylesheet.css"> 
<?php
 /* start session or resume session */
   session_start();

   /* if called from login page */
   if(isset($_POST["email"]))  {
	include('est_connection.php');
	   $email=$_POST["email"];
	   $password=$_POST["pw"];
	   $password_encrypted = hash('sha256',$password);
	   $sql="SELECT id_part,email,password FROM tbl_personal_basic WHERE email='$email' AND password='$password_encrypted'";
	   $result=mysqli_query($db_connection,$sql);
	   $rows=mysqli_num_rows($result);
		 /*if email and password are correct result contains one row and
		 the variable $_SESSION gets value from login email */
		 if($rows==1) {
			 $_SESSION["email"] = $_POST["email"];
		 }
		 else{
			exit("<body><div id='container'><p>Access prohibited<br /><a href='login_page.php'>Back to Login</a>
			</p></div></body>");
		 }
   }
   // check if inside session
	if (!isset($_SESSION["email"])){
		exit("<body><div id='container'><p>Access prohibited<br /><a href='login_page.php'>Back to Login</a>
		</p></div></body>");
	}

?>

<!-- if password and email match, display welcome screen with options  -->

<title>Hello</title>
</head>
<body>
<div id="container">
<h2>Welcome back, <?php echo $email ?>!</h2>
<h3>What would you like to do today?</h3>
<a href="contribute_data.php">Add points</a><br>
<a href="display_map_result.php">See map of points</a><br>
<a href="help_about.php">Get some help with this project</a><br>
<a href="login_page.php">Log out</a>
</div>
</body>