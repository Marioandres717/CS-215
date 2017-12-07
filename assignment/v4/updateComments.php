<?php
session_start();
$previous_time = $_SESSION['update'];
$current_date = $_SESSION['dateUpdate'];
$comment[] = array();

$db = new mysqli("localhost", "rendon2m", "asd123", "rendon2m");
if($db->connect_error){
  die("connectiond failed: " .$db->connect_error);
}

$q = "SELECT * FROM reply WHERE date_reply = '$current_date' AND time_reply > '$previous_time';";
if($result = $db->query($q)){
  if($result->num_rows > 0) {
    while($Srow = $result->fetch_assoc()){
          $row["title"] = $Srow["reply_subject"];
          $row["content"] = $Srow["content"];
          $row["message_id"] = $Srow["message_id"];
          $row["time"] = $Srow["time_reply"];
          $row["date"] = $Srow["date_reply"];
          $comment[] = $row;
    }
  $_SESSION['update'] = date("h:i:s A");
  $_SESSION['dateUpdate'] = date("Y-m-d");
  $result->close();
  $db->close();
  echo json_encode($comment);
}else {
  echo ('{"foo": 1}');
  }
}


?>
