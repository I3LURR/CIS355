<?php


require 'database.php';

$valid = false;

if(! empty($_FILES['myimage']['name'])) {
    $imagename = $_FILES['myimage']['name'];
    $valid = true;
}
if ($valid == true) {
//get the content if its not empty I think
    $imagetmp = addslashes(file_get_contents($_FILES['myimage']['tmp_name']));

    $pdo = Database::connect();
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $sql = "INSERT INTO Image_tbl (image, image_name) VALUES(?,?)";
    $q =$pdo->prepare($sql);
    $q->execute(array($imagetmp, $imagename));
    Database::disconnect();
    header("Location: index.php");
}

?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <link   href="css/bootstrap.min.css" rel="stylesheet">
    <script src="js/bootstrap.min.js"></script>
    <link rel="icon" href="img/cardinal_logo.png" type="image/png" />
</head>

<div class="container">
    <div class="span10 offset1">

        <div class="row">
            <p><strong>You can input your image on this page. To do so click "Choose File".</strong></p>
        </div>

        <form class="form-horizontal" method="POST" action="upload_banner.php" enctype="multipart/form-data">

            <div class="control-group">
                <label class="control-label">Image Input</label>
                <div class="controls">
                    <input type="file" name="myimage">
                </div>
            </div>

            <div class="form-actions">
                <button type="submit" class="btn btn-success">Submit Image</button>
                <a class="btn btn-primary" href="index.php">Back</a>
            </div>
        </form>

    </div>
</div>
</body>
</html>