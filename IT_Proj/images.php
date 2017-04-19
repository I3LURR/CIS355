<?php

require 'database.php';

if ( !empty($_POST)) {


    $$id = 'svsu2.jpg';

    $pdo = Databse::connect();
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $sql="select * from Image_tbl where image_name= ?";
    $q = $pdo->prepare($sql);
    $q->execute(array($id));
    $data = $q->fetch(PDO::FETCH_ASSOC);
    $pdo = Database::disconnect();

    echo '<img  height=5%; width=15%; src="data:image/jpeg;base64,' . base64_encode( $data['image'] ) . '" />';
}


?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <link   href="css/bootstrap.min.css" rel="stylesheet">
    <script src="js/bootstrap.min.js"></script>
    <link rel="icon" href="img/cardinal_logo.png" type="image/png" />
</head>

<body>
<div class="container">

    <div class="span10 offset1">



        <!--
        <div class="row">
            <br />
            <p style="color: red;">System temporarily unavailable.</p>
        </div>
        -->

        <div class="row">
            <p>
                <a class="btn btn-primary" href="upload_banner.php">Upload Jpg</a>
                <a class="btn"  href="index.php">Back</a>
            </p>
        </div>

        <form class="form-horizontal" action="images.php" method="POST">

            <div class="control-group">
                <label class="control-label">Image Name to Display</label>
                <div class="controls">
                    <input name="imagename" type="text"  placeholder="img1" required>
                </div>
            </div>


            <div class="form-actions">
                <button type="submit" class="btn btn-success">View Image</button>
            </div>

        </form>


    </div> <!-- end div: class="span10 offset1" -->

</div> <!-- end div: class="container" -->

</body>

</html>
