<?php
session_start();
$previous_time = $_SESSION['update'];
$current_date = $_SESSION['dateUpdate'];
$information[] = array();

$db = new mysqli("localhost", "rendon2m", "asd123", "rendon2m");
if($db->connect_error){
  die("connectiond failed: " .$db->connect_error);
}
;

$q = "SELECT * FROM message WHERE date_post = '$current_date' AND time_post > '$previous_time';";
if($result = $db->query($q)){
  if($result->num_rows > 0) {
    while($Srow = $result->fetch_assoc()){
          $row["title"] = $Srow["msg_subject"];
          $row["content"] = $Srow["content"];
          $row["message_id"] = $Srow["message_id"];
          $row["lastView"] = $Srow["last_view"];
          $row["time"] = $Srow["time_post"];
          $row["date"] = $Srow["date_post"];
          $row["image"] = $Srow["image"];
          $row["email"] = $Srow["email"];
          $information[] = $row;
    }
  $_SESSION['update'] = date("h:i:s A");
  $_SESSION['dateUpdate'] = date("Y-m-d");
  $result->close();
  $db->close();
  echo json_encode($information);
}else {
  echo ('{"foo": 1}');
  }
}


?>
