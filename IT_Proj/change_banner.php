<?php

require 'database.php';
header("content-type:image/jpeg");


$$id = $_GET['id'];

$pdo = Databse::connect();
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
$sql="select * from image_tbl where image_name= ?";
$q = $pdo->prepare($sql);
$q->execute(array($name));
$data = $q->fetch(PDO::FETCH_ASSOC);

if ($data) {
    $image_name = $data['image_name'];
    $image_content = $data['image'];
}

echo $image_content;

?>
