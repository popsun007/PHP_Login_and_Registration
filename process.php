<?php 
session_start();
require_once("connection.php");

if (isset($_POST['action']) && ($_POST['action'] == "register")){
	register($_POST);
}
if (isset($_POST['action']) && ($_POST['action'] == "log_in")){
	login($_POST);
}
if (isset($_POST['log_out']) && ($_POST['log_out'] == "Log Out!")){
	session_destroy();
	header("location: index.php");
}
function has_number($str){
	for($i=0; $i<strlen($str); $i++){
		if(is_numeric($str[$i])){
			return true;
		}
	}
	return false;
}

function register($post){
	//------------begin validation----------------//
	if (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)){
		$_SESSION['errors'][] = "Email format is NOT validate!";
	}
	if (empty($_POST['first_name']) || has_number($_POST['first_name'])){
		$_SESSION['errors'][] = "First name must be no number and not empty.";
	}
	if (empty($_POST['last_name']) || has_number($_POST['last_name'])){
		$_SESSION['errors'][] = "Last name must be no number and not empty.";
	}
	if (empty($_POST['password']) || ($_POST['password'] != $_POST['com_password'])){
		$_SESSION['errors'][] = "Password can not be empty and remain same password.";
	}

	//-------------end validation-------------------//
	
	//--------------communicate with Database------------//
	$query = "INSERT INTO login_out (email, first_name, last_name, password) 
			VALUES ('{$_POST['email']}','{$_POST['first_name']}','{$_POST['last_name']}','{$_POST['password']}');";
	run_mysql_query($query);
	$_SESSION['log_in'] = true;
	header("location: index.php");
}

function login($post) {
	if (empty($_POST['log_email'])||empty($_POST['log_password'])){
		$_SESSION['errors'][] = "User name or password can not be empty!";
	}
	$query = "SELECT id, CONCAT(first_name, ' ', last_name) AS name FROM login_out 
			WHERE email = '{$_POST['log_email']}' AND password = '{$_POST['log_password']}';" ;
	$infos = fetch($query);
	if($infos){
		$_SESSION['user_id'] = $infos[0]['id'];
		$_SESSION['user_name'] = $infos[0]['name'];
		header("location: success.php"); 
	}
	else{
		$_SESSION['errors'][] = "User name and password don't match!";
	}
}

if(isset($_SESSION['errors'])){
	unset($_SESSION['log_in']);

	header("location: index.php");
	die();
}

?>