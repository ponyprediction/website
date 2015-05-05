<?php
	$answer = "false";
    if(isset($_POST["password"]) && isset($_POST["hash"]))
    {
		if(password_verify($_POST["password"], $_POST["hash"]))
			$answer = "true";
	}
	echo $answer;
?>