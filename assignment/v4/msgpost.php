<?php
	// checking if the user is login, if not redirect to the login page
	session_start();
	if (!isset($_SESSION["email"])) {
	 header("Location: login.php");
	 exit();
	} else {
	      //set up the image information
		$target_dir = "public/images/";
		$target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
		$imageFileType = pathinfo($target_file,PATHINFO_EXTENSION);

	      // check if the form is summited
	if(isset($_POST["submitted"]) && $_POST["submitted"]){

			// check if image file is upload
			if(!is_uploaded_file($_FILES["fileToUpload"]['tmp_name'])) {
				    $target_file = "";
			} else {
					if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
					&& $imageFileType != "gif" ){
						$target_file = " ";
					}
					else {
					move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file);
				}
			}

			// if everything is ok, try to upload file

			$fn = $_SESSION["first_name"];
			$em = $_SESSION["email"];
			$ms = trim($_POST["msg_subject"]);
			$cn = trim($_POST["content"]);
			$pc = trim($_POST["passcode"]);
			$date = date("Y-m-d");
			$time = date("h:i:s A");
			$img = $target_file;

			// check that there is no false information
			if(strlen($ms) > 0 && strlen($pc) === 8 && strlen($cn) > 0){
				// load the database and get the orders for this user
				$db = new mysqli("localhost", "rendon2m", "asd123", "rendon2m");
				if ($db->connect_error) {
				die ("Connection failed: " . $db->connect_error);
				}

				$q = "INSERT INTO message(email, passcode, msg_subject, content, image, last_view,date_post, time_post)
					VALUES ('$em', '$pc', '$ms', '$cn', '$img', CURRENT_TIMESTAMP,'$date', '$time');";

				if($db->query($q) === TRUE){
					echo "Message sended succesfully";
					header("Location: msgpost.php");
					$db->close();
					exit();
					} else {
					 echo "Error: ".$q.'<br>'.$db->error;
					}
				} else {
					$error = ("You must enter a non-blank email recipient/content of message/passcode to send the message.");
				}
	    } else {
		      $error = "";
		  }
	}

?>

<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title>Post Message</title>
    <link rel="stylesheet" href="public/dope.css">
    <script type="text/javascript" src="public/js/functionality.js" ></script>
  </head>
  <body>
    <nav class="top-nav">
      <p class="brand"><i class="fa fa-telegram" aria-hidden="true"></i> BlueIvy</p>
<?php if(!isset($_SESSION["email"])) :?>
      <a href="login.php">Login</a>
      <a href="signup.php">Sign up</a>
 <?php  else : ?>
       <a href="logout.php">Logout</a>
    <?php endif; ?>
    </nav>

    <div class="main-menu">
       <a href="#" class="active"><i class="fa fa-envelope" aria-hidden="true"></i> New message</a>
       <a href="index.php"><i class="fa fa-stack-overflow" aria-hidden="true"></i> Message list</a>
       <a href="viewmsg.php"><i class="fa fa-envelope-open" aria-hidden="true"></i> Read message</a>
   </div>

    <div class="new-message">
	<p><?= $_SESSION["user_id"] ?></p>
	<p><?= $_SESSION["email"] ?></p>
      <h1>New message</h1>
      <form id="post_msg" action="msgpost.php" method="POST" enctype="multipart/form-data">
	<p class="error"><?= $error ?></P>
	<input type="hidden" name="submitted" value="1"/>
        <label>Message subject: </label><span id="recipient-email_id" class="error"></span>
        <input type="text" class="recipient-email" id="recipientEmail" name="msg_subject"/>
        <textarea id="message" rows="10" cols="50" placeholder="Your text goes here..." name="content"></textarea>
        <span id="message_id"></span>
        <input type="file" id="upload" name="fileToUpload">
        <label>Passcode: </label>
        <input type="text" id="passcode" name="passcode"><span id="passcode_id" class="error"></span>
				<div id="suggestions"></div>
        <button type="submit" id="sendMSG" class="default-page"><i class="fa fa-paper-plane-o" aria-hidden="true"></i> send</button>
      </form>
    </div>
    <script type="text/javascript" src="public/js/msgpost.js"></script>
  </body>
</html>
