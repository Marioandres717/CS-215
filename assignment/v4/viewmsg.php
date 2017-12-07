<?php
	// checking if the user is login, if not redirect to the login page
	session_start();
	if (!isset($_SESSION["message_id"])){
		header("Location: login.php");
		exit();
	} else {
		if(isset($_POST["submitted"]) && $_POST["submitted"]){
			$m_id = $_SESSION["message_id"];
			$cn = trim($_POST["content"]);
			$date = date("Y-m-d");
			$time = date("h:i:s A");
			$ms = trim($_POST["msg_subject"]);

			// check that there is no false information
			if(strlen($cn) > 0){
				// load the database and get the orders for this user
				$db = new mysqli("localhost", "rendon2m", "asd123", "rendon2m");
				if ($db->connect_error) {
				die ("Connection failed: " . $db->connect_error);
				}

				$q = "INSERT INTO reply(message_id, reply_subject, content, date_reply, time_reply)
					VALUES ('$m_id', '$ms', '$cn', '$date', '$time');";

				if($db->query($q) === TRUE){
					echo "Your reply has been sended succesfully";
					header("Location: viewmsg.php");
					$db->close();
					exit();
					} else {
					 echo "Error: ".$q.'<br>'.$db->error;
					}
				} else {
					$error = ("You must enter a non-blank email recipient/content of message/passcode to send the message.");
				}
			} else {

				$db = new mysqli("localhost", "rendon2m", "asd123", "rendon2m");
			  	if ($db->connect_error) {
			  		die ("Connection failed: " . $db->connect_error);
			  	}
					$m_id =$_SESSION['message_id'];
        				 $q = "SELECT content, date_reply, time_reply, reply_subject FROM reply
				     WHERE message_id='$m_id';";
					$result = $db->query($q);
			}
		}
?>

<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title>Retrieve message</title>
		<link rel="stylesheet" href="public/dope.css">
    <script type="text/javascript" src="public/js/functionality.js"></script>
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
       <a href="msgpost.php"><i class="fa fa-envelope" aria-hidden="true"></i> New message</a>
       <a href="index.php"><i class="fa fa-stack-overflow" aria-hidden="true"></i> Message list</a>
       <a href="#" class="active"><i class="fa fa-envelope-open" aria-hidden="true"></i> Read message</a>
   </div>

    <div class="message-content">
      <span class="sender-info"><?php echo $_SESSION["email"] ?> </span>
      <span class="sender-info"><?php echo $_SESSION["time_post"] ?> </span>
      <span class="sender-info"><?php echo $_SESSION["date_post"] ?></span>
      <h3><?php echo $_SESSION["msg_subject"] ?></h3>
      <p>
				<?php echo $_SESSION["content"] ?>
      </p>

			<img class="msg-img" src="<?php echo $_SESSION['img'] ?>"/>
    <hr>

		<?php
				while($row = $result->fetch_assoc()){
				echo "<span class='sender-info'>".$row['time_reply']."</span>";
				echo "<span class='sender-info'>".$row['date_reply']."</span>";
				echo "<h3>".$row['reply_subject']."</h3>";
				echo "<p>".$row['content']."</p>";
				echo "<hr>";
		}$db->close();
?>

      <form id="replay_msg" action="viewmsg.php" method="POST">
				<input type="hidden" name="submitted" value="1" />
        <label>Message title: </label><span id="recipient-email_id" class="error"></span>
        <input type="text" id="recipientEmail" class="recipient-email" name="msg_subject">
        <textarea id="message" rows="10" cols="50" maxlength="500" placeholder="YOU text goes here..." name="content"></textarea>
        <span id="message_id"></span>
        <button type="submit" class="default-page"><i class="fa fa-paper-plane-o" aria-hidden="true"></i> Respond</button>
      </form>
    </div>
		 <script type="text/javascript" src="public/js/viewmsg.js"></script>
  </body>
</html>
