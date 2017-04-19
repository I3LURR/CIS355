<?php

session_start();
if(!isset($_SESSION["person_id"])){ // if "user" not set,
    session_destroy();
    header('Location: index.php');     // go to login page
    exit;
}
	require 'database.php';
	$probId = 0;
	$user = "";
	
	$valid = true;
	if (!empty($_GET['id'])) {
		$probId = $_REQUEST['id'];
	} else {
		$valid = false;
	}
	
	if (!empty($_GET['userId'])) {
		$user = $_REQUEST['userId'];
	} else {
		$valid = false;
	}
	
	
	
	if ($valid) {
		//If its valid we are going to resolve the problem 
		try{
			$pdo = Database::connect();
			$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			$sql = "UPDATE Problem_tbl SET problem_resolvedby='".$user. "', problem_resolved=1 WHERE problem_id=" . $probId;
			$q = $pdo->prepare($sql);
			$q->execute();
			$data = $q->fetch(PDO::FETCH_ASSOC);
			$pdo = Database::disconnect();
			//should be successful if nothing failed at this point
			header("Location: employee_home.php?id=". $user);
		} catch (PDOException $e) {
			//There was an issue in resolving the problem
			//NOTE: Later I need to send an error to the other page to display
			header("Location: employee_home.php?id=". $user);
			$blnConnectionSuccess = False;
		}
	}
?>
