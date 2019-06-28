<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
	<link rel="stylesheet" href="stylesheet.css">
	<title>Registration</title>
</head>

<body>
<?php
   /* start session again */
   session_start();
   /* terminate running session */
   session_destroy();
   $_SESSION = array(); 

	//check whether email and password are entered and conditions agreed to
	if ((!isset($_POST["submit"]))or (empty($_POST["email"])) or (empty($_POST["pw"])) or !isset($_POST["conditions"])){
	$email = $pw = $err_message = $email_err = $pw_err = $conditions = $cond_err = "";
	if ($_SERVER['REQUEST_METHOD'] === 'POST') {
		//display form, if not complete
	if (empty($_POST["email"])){
		$err_message = $err_message."You have to provide a valid email address.";
		$email_err="* ";
		$email="";
	}else {
		$email_err=" ";
		$email=$_POST["email"];
	}
	if(empty($_POST["pw"])){
		$err_message = $err_message."<br>You have to provide a password.";
		$pw_err="* ";
		$pw="";
	}else{
		$pw_err=" ";
		$pw=$_POST["pw"];
	}
	if(!isset($_POST["conditions"])){
		$err_message = $err_message."<br>You have to agree to terms and conditions (tick the box).";
		$cond_err="* ";
		$conditions="";
	}else {
		$cond_err=" ";
		$conditions = $_POST["conditions"];
	}
	echo "<div id='container'><h4 class='missing-value'>$err_message</h4></div>";
}
?>
<!-- Description of the input form - data about a new user is entered -->
<div id="container">
<form id="register-form" name="login-form" method="post" action="<?php htmlentities($_SERVER['PHP_SELF']) ?>">
<h2>Register</h2>
	<div class="form-group">
		<label><?php echo $email_err ?>Email:</label>
		<input value="<?php echo $email ?>" name="email" type="text" />
	</div>
	<div class="form-group">
		<label><?php echo $pw_err ?>Password:</label>
		<input name="pw" type="password" />
	  </div>
	<br>
	<input type="checkbox" name="conditions" value="1" style="display: inline;" />
	<h4 style="display: inline;"><?php echo $cond_err ?>I agree to the <a href='2_register.php?hello=true'>terms</a> of data storage.</h4>
	<h3>Additional information</h3>
	  <div class="form-group">
		<label>First name:</label>
		<input name="firstname" type="text" />
	  </div>
	  <div class="form-group">
		<label>Surname:</label>
		<input name="surname" type="text" />
	  </div>
	  <div class="form-group">
		<label>Country:</label>
		<input name="country" type="text" />
	  </div>
	  <div class="form-group">
		<label>Town:</label>
		<input name="town" type="text" />
	  </div>
	  <div class="form-group">
		<label>Phone number:</label>
		<input name="phone" type="text" />
	  </div>
<div id="buttons" style="margin: 20px 20px">
    <button type="submit" name="submit">Submit</button>
    <button type="reset" name="reset" value="Reset">Reset</button>
	<!--
	<a href='2_register.php?hello=true'><br>Read terms and conditions.</a>
	-->
</div>
</div>
<br/>

<?php
} else {
	//if all data entered, register the user
	include("est_connection.php");
	$email=$_POST["email"];
	$pw=$_POST["pw"];
	$pw_encrypted = hash('sha256',$pw);
	$name = $_POST["firstname"];
	$surname = $_POST["surname"];
	$country = $_POST["country"];
	$town = $_POST["town"];
	$phone = $_POST["phone"];
	$sql="INSERT INTO tbl_personal_basic VALUES (NULL,'$email','$pw_encrypted')";
	$result=mysqli_query($db_connection,$sql);
	//check if user is already registered (email is a unique identifier)
	if(!$result) {
		exit("<div id='container'>
		Sorry! Registration failed.<br>
		</div>");
	} else {
		//get id of current participant
		$sql = "SELECT id_part FROM tbl_personal_basic WHERE email='$email'";
		$result = mysqli_query($db_connection, $sql);
		$id_part = mysqli_fetch_row($result)[0]; 
		//place id and additional information into tbl_personal_adv
		$sql =   "INSERT INTO tbl_personal_adv VALUES ('$id_part',NULL, '$name', '$surname', '$country', '$town', '$phone')";
		$result = mysqli_query($db_connection, $sql);
		//notify the user of success
		echo "<div id='container'>
		<h2>Registration successful!</h2><br>&nbsp;Welcome, $email!<br>
		<button><a style='text-decoration: none; color: inherit' href='login_page.php'>Log in</a></button>
		</div>";
		//close connection
		mysqli_close($db_connection);
	}
}
// section to display terms and conditions
  function displayTerms() {
    echo "<div id='container'><h4>Terms of Data Storage Use</h4>
	<p>Personal data of survey participants will be only used for<br>
	internal purposes of data processing;<br>
	they will be never forwarded to third parties.
	</p></div>"; 
  }
  if (isset($_GET['hello'])) {
    displayTerms();
  }
  
?>
</form>
</div>
</body>
</html>
