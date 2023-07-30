<?php
  session_start();
	if (!empty($_SERVER['HTTPS']) && ('on' == $_SERVER['HTTPS'])) {
		$uri = 'https://';
	} else {
		$uri = 'http://';
	}
  $uri .= $_SERVER['HTTP_HOST'];
  if(!isset($_SESSION["user"])){
    header('Location: '.$uri.'./User/login.php');
    exit;
  }
	header('Location: '.$uri.'./navbar.php');
	exit;
?>
