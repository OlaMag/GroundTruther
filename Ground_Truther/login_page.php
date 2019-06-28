<?php
   /* start session again */
   session_start();
   /* terminate running session */
   session_destroy();
   $_SESSION = array();
?>
<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<link rel="stylesheet" href="stylesheet.css">
<title>Login page</title>
</head>
<!-- user input: email address and password -->
<body>
      <div id="container">
      <form id="login-form" name="login-form" method="post" action="login_check.php">
      <h2>Log in</h2>
      <div class="form-group">
            <label>Email:</label>
            <input name="email" type="text" size="40" maxlength="80" />
      </div>
      <div class="form-group">
            <label>Password:</label>
            <input name="pw" type="password" size="40" maxlength="80" />
      </div>
      <div id="buttons" style="margin: 20px 20px">
            <button type="submit" class="btn btn-default">Submit</button>
            <button type="reset" class="btn btn-default" name="reset" value="Reset">Reset</button>
      </div>
            <p><a href="register.php">Register</a> as a new user or <a href="">request</a> a password reminder.</p>
      </form>
</body>
</html>
