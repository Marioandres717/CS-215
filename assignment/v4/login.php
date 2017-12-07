<?php
	// check to see if the form was submitted
	if (isset($_POST["submitted"]) && $_POST["submitted"]) {
		// get the username and password and check that they aren't empty
		$em = trim($_POST["email"]);
		$pd = trim($_POST["password"]);

		if (strlen($em) > 0 && strlen($pd) >= 8) {
			// load the database and verify the username/password
			$db = new mysqli("localhost", "rendon2m", "asd123", "rendon2m");
		  	if ($db->connect_error) {
		  		die ("Connection failed: " . $db->connect_error);
		  	}

		  	$q = "SELECT first_name, email FROM users WHERE email = '$em' AND password = '$pd';";
		  	$result = $db->query($q);

		  	if ($row = $result->fetch_assoc()) {
		  		// login successful
		  		session_start();
				$_SESSION["first_name"] = $row["first_name"];
				$_SESSION["email"] = $row["email"];
				header("Location: index.php");
				$db->close();
				exit();
			} else {
				// login unsuccessful
				$error = ("The username/password combination was incorrect.");
				$db->close();
			}
		} else {
			$error = ("You must enter a non-blank username/password combination to login.");
		}
	} else {
		$error = "";
	}
?>

<?php
if(isset($_POST["pass_submitted"]) && $_POST["pass_submitted"]){

	$pc = $_POST["passcode"];

	if(strlen($pc) ===  8) {
			$db = new mysqli("localhost", "rendon2m", "asd123", "rendon2m");
					if($db->connect_error){
						die ("Conection failed: ".$db->connect_error);
					}

					$last_view = "UPDATE message SET last_view = CURRENT_TIMESTAMP WHERE passcode = '$pc';";
					$db->query($last_view);

					$q = "SELECT message_id, content, date_post, time_post, image, email, last_view, msg_subject FROM message
								WHERE passcode = '$pc';";

					$result = $db->query($q);

					if($row = $result->fetch_assoc()){
						session_start();
						$_SESSION["message_id"] = $row["message_id"];
						$_SESSION["content"] = $row["content"];
						$_SESSION["date_post"] = $row["date_post"];
						$_SESSION["time_post"] = $row["time_post"];
						$_SESSION["img"] = $row["image"];
						$_SESSION["email"] = $row["email"];
						$_SESSION["msg_subject"] = $row["msg_subject"];
						$_SESSION["last_view"] = $row["last_view"];
						//MORE CODE
						header("Location: viewmsg.php");
						$db->close();
						exit();
					} else {
						$error_pc = ("You must enter a valid passcode.");
					}
	} else {
		$error_pc = ("Your passcode must be 8 characters long");
	}
} else {
	$error = " ";
}
?>

<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title>Login</title>
    <link rel="stylesheet" href="public/dope.css">
    <script type="text/javascript" src="public/js/functionality.js"></script>
  </head>
  <body>
    <nav class="top-nav">
      <p class="brand"><i class="fa fa-telegram" aria-hidden="true"></i> BlueIvy</p>
      <a href="#">Login</a>
      <a href="signup.php">Sign up</a>
    </nav>
    <div class="login">
		<h3 class="error"><?= $error ?></h3>
      <h1>Login</h1>
      <form class="login_form" action="login.php" method="POST">
				<input type="hidden" name="submitted" value="1" />
        <span id="email_id" class="error"></span>
        <input type="text" id="email" name="email" placeholder="Email"/>
        <span id="password_id" class="error"></span>
        <input type="password" id="password" placeholder="Password" name="password"/>
        <input type="submit" class="login_btn default-page" value="Login"/>
      </form>
      <a href="#" class="forgot_pass">Forgot password?</a>
      <a href="signup.php"><button type="button" class="login_btn default-page">Create account</button></a>
      <p>Create an account with your email address</p>
    </div>

    <div class="passcode">
      <h1>View a message</h1>
      <p>(optional)</p>
			<h3 class="error"><?= $error_pc ?></h3>
      <form class="passcode_form" action="login.php" method="POST">
				<input type="hidden" name="pass_submitted" value="1" />
        <span id="passcode_id" class="error"></span>
        <input type="text" id="passcode" placeholder="Passcode" name="passcode"/>
        <input type="submit" class="default-page" value="View"/>
      </form>
      <ul>
        <li>Please, enter the passcode a sender informed you about.</li>
        <li>It is necessary in order to view your new messages.</li>
        <li>BlueIvy's <strong>cares</strong> in keeping user's communitcation cofidential and secure.</li>
      </ul>
    </div>

    <script type="text/javascript" src="public/js/login.js"></script>
  </body>
</html>
