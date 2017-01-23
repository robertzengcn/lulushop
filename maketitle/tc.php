<?php 
if(isset($_POST['username'])&&$_POST['username']=="xiamen"&&isset($_POST['password'])&&$_POST['password']=="startamazon"){

	session_start();
	$_SESSION['wang']="wang";
	define('Adminflag','gogocontrol');
 include './controlpage.php';	
	
}else{
	
include './tclogin.html';
}
?>


