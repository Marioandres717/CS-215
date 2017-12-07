<?php
	// check to see if the form was submitted
	if (isset($_POST["submitted"]) && $_POST["submitted"]) {
		// check that there aren't empty fields
		$fn = trim($_POST["first_name"]);
		$ln = trim($_POST["last_name"]);
		$em = trim($_POST["email"]);
		$DofB = trim($_POST["DofB"]);
		$pd = trim($_POST["password"]);
		if(strlen($fn) > 0 && strlen($ln) > 0 && strlen($em) > 0 && strlen($DofB) > 0 && strlen($pd) >= 8) {
			// load the database and insert information
			$db = new mysqli("localhost", "rendon2m", "asd123", "rendon2m");
		  	if ($db->connect_error) {
		  		die ("Connection failed: " . $db->connect_error);
		  	}

				$check = "SELECT email FROM users WHERE email='$em';";
				$check_res = $db->query($check);

				if($check_row = $check_res->fetch_assoc()){
					$error = ("The email already exits.");
					$db->close();
				} else {

			  	$q = "INSERT INTO users(email, first_name, last_name, DofB, password)
					VALUES ('$em', '$fn', '$ln', '$DofB', '$pd');";

			  	if($db->query($q) === TRUE){
				   echo "Account Created succesfully";
			           header("Location: login.php");
				   $db->close();
				   exit();
				} else {
			           echo "Error: ".$q.'<br>'.$db->error;
							 }
		     }
		} else {
			$error = ("You can't have blank fields.");
		}
	} else {
		$error = "";
	}
?>

<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title>Sign up</title>
    <link rel="stylesheet" href="public/dope.css">
    <script type="text/javascript" src="public/js/functionality.js"></script>
  </head>
  <body>
    <nav class="top-nav">
      <p class="brand"><i class="fa fa-telegram" aria-hidden="true"></i> BlueIvy</p>
      <a href="login.php" class="l">Login</a>
      <a href="#" class="l">Sign up</a>
    </nav>

    <div class="signup">
      <h1>Sign up!</h1>
        <form id="signup_form" action="signup.php" method="POST">
					<span class="error"><?= $error ?> </span>
					<input type="hidden" name="submitted" value="1" />
          <fieldset>
            <legend></legend>
            <label>First name: </label><span id="firstName_id" class="error"></span>
            <input type="text" id="firstName" name="first_name"/>
            <label>Last name: </label><span id="lastName_id" class="error"></span>
            <input type="text" id="lastName" name="last_name"/>
            <label>Email: </label><span id="email_id" class="error"></span>
            <input type="email" id="email" name="email"/>
            <label>Date of birth <span>(yyyy-mm-dd) </span>: </label><span id="dateOfBirth_id" class="error"></span>
            <input type="date" id="dateOfBirth" name="DofB" />
            <label>Password: </label><span id="password_id" class="error"></span>
            <input type="password" id="password" name="password"/>
            <label>Repeat password: </label><span id="repeatPassword_id" class="error"></span>
            <input type="password" id="repeatPassword"/>
            <button type="submit" class="login_btn default-page">sign up</button>
          </fieldset>
        </form>
    </div>
    <script type="text/javascript" src="public/js/signup.js"></script>
  </body>
</html>
