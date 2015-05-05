<?php
if (session_status() == PHP_SESSION_NONE)
{
	session_start();
}
$_SESSION['backgroundColor'] = $_POST['color'];
echo $_POST['color'];
?>
