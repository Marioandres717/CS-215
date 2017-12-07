<?php

	$sugges = trim($_GET["q"]);
	$five_sugges = array("suggestions" => array());

	$five_sugges["suggestions"][] = generateRandomString($sugges);
 	$five_sugges["suggestions"][]= generateRandomString($sugges);
	$five_sugges["suggestions"][] = generateRandomString($sugges);
 	$five_sugges["suggestions"][]	= generateRandomString($sugges);
	$five_sugges["suggestions"][] = generateRandomString($sugges);

 	echo json_encode($five_sugges);


		function generateRandomString($a) {
	    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
	    $charactersLength = strlen($characters);
			$recommendation = $a;
	    for ($i = 0; $i < (8 - strlen($a)); $i++) {
	        $recommendation .= $characters[rand(0, $charactersLength - 1)];
	    }
			$db = new mysqli("localhost", "rendon2m", "asd123", "rendon2m");
			if($db->connect_error){
				die("Connection failed: " . $db->connect_error);
			}

			$check = "SELECT passcode FROM message WHERE EXISTS (SELECT 1 FROM message WHERE passcode='$recommendation';";
			if($db->query($check) === TRUE){
				$recommendation = generateRandomString($a);
			}

			$db->close();
	   		 return $recommendation;
		}

?>
