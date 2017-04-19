<?php

require 'database.php';
//This is going to be ther username of the employee that signed in. For when things are resolved


if ( !empty($_GET['id'])) {
    $id = $_REQUEST['id'];
}



$pdo = Database::connect();
if(!empty($id)) {
    $sql = "SELECT * FROM Users_tbl WHERE users_username=" . $id;
} else {
    $sql = 'SELECT * FROM Users_tbl';
}

$arr = array();
foreach ($pdo->query($sql) as $row) {
    array_push($arr, $row['users_first_name'] . ', '. $row['users_last_name']);
}
Database::disconnect();
echo '{"names":' . json_encode($arr) . '}';
