<?php
  session_start();
  if (!isset($_SESSION["email"])) {
  header("Location: login.php");
  exit();
  } else {
  $id = $_SESSION["email"];
  if(!isset($_SESSION['update']) && !isset($_SESSION['dateUpdate'])){
      $_SESSION['update'] = date("h:i:s A");
      $_SESSION['dateUpdate'] = date("Y-m-d");
    }
  $db = new mysqli("localhost", "rendon2m", "asd123", "rendon2m");
  if ($db->connect_error) {
    die ("Connection failed: " . $db->connect_error);
  }

  $q = "SELECT *FROM message WHERE email ='$id' ORDER BY date_post DESC;";
  $result = $db->query($q);
}


if(isset($_POST['delete_button'])){

	$db = new mysqli("localhost", "rendon2m", "asd123", "rendon2m");
	if ($db->connect_error) {
   	die ("Connection failed: " . $db->connect_error);
  	}
	$m_idform = $_POST['delete_button'];
	$d_r = "DELETE FROM reply WHERE message_id ='$m_idform';";
	$d_m = "DELETE FROM message WHERE message_id='$m_idform';";
	$db->query($d_r);
	$db->query($d_m);
	header("Location: index.php");
	$db->close();
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
       <a href="msgpost.php"><i class="fa fa-envelope" aria-hidden="true"></i> New message</a>
       <a href="#" class="active"><i class="fa fa-stack-overflow" aria-hidden="true"></i> Message list</a>
       <a href="viewmsg.php"><i class="fa fa-envelope-open" aria-hidden="true"></i> Read message</a>
       <a id="turn-off" href="#"><i class="fa fa-power-off" aria-hidden="true"></i> Turn off updates</a>
       <script type="text/javascript" src="public/js/checkUpdate.js"></script>
   </div>

<div class="list-of-messages">
 <form method='POST' action='index.php'>
   <div id="update_msg"></div>
      <?php
            while($row = $result->fetch_assoc()){
              $m_id = $row['message_id'];
              $q1 = "SELECT *FROM reply WHERE message_id = '$m_id';";
              $result1 = $db->query($q1);

                    echo "<div id='$m_id' class='msg-post'>";
                    echo "<p>Last view: ".$row['last_view']."</p>";
                    echo "<h2>".$row['msg_subject']."</h2>";
                    echo "<p>Date post: ".$row['date_post']."</p>";
                    echo "<p>Time post: ".$row['time_post']."</p>";
                    echo "<button type='submit' name='delete_button' value='$m_id' class='btn-delete default-page'><i class='fa fa-trash' aria-hidden='true'></i></button>";
                    echo "<p class='post-content'>".$row['content']."</p>";
                    echo "<img class='index-img' src='".$row['image']."'/>";
                    echo "<hr>";
                      while($row_of_reply = $result1->fetch_assoc()){
                              echo    "<div class='reply-post'>";
                              echo    "<h3>".$row_of_reply["reply_subject"]."</h3>";
                              echo    "<p> Date: ".$row_of_reply['date_reply']."</p>";
                              echo    "<p> Time: ".$row_of_reply['time_reply']."</p>";
                              echo    "<p>".$row_of_reply['content']."</p>";
                              echo    "</div>";
                              echo    "<hr>";
                            }
                    echo "</div>";
                    echo "<div class='space'></div>";
                  } $result->close();
                   $result1->close();
                   $db->close();
      ?>
    </form>
    </div>
  </body>
</html>
