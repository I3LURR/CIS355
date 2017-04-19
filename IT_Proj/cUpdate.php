<?php

session_start();
if(!isset($_SESSION["person_id"])){ // if "user" not set,
    session_destroy();
    header('Location: index.php');     // go to login page
    exit;
}

require 'database.php';

//Gets ID from index.php button call, since its set to null should always call _Get ID, need to use POST
$id = null;
if ( !empty($_GET['id'])) {
    $id = $_REQUEST['id'];
}

if ( null==$id ) {
    header("Location: index.php");
}

if ( !empty($_POST)) {
    // keep track validation errors
    $userNameError = null;
    $nameError = null;
    $mobileError = null;

    // keep track post values
    $userName = $_POST['username'];
    $name = $_POST['name'];
    $mobile = $_POST['mobile'];

    // validate input
    $valid = true;
    if (empty($userName)) {
        $userNameError = 'Please enter Name';
        $valid = false;
    }

    if (empty($name)) {
        $nameError = 'Please enter Email Address';
        $valid = false;
    }

    if (empty($mobile)) {
        $mobileError = 'Please enter Mobile Number';
        $valid = false;
    }

    // update data
    if ($valid) {
        $pdo = Database::connect();
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $sql = "UPDATE Customers_tbl  set customer_username = ?, customer_name = ?, customer_phoneNum =? WHERE customer_id = ?";
        $q = $pdo->prepare($sql);
        $q->execute(array($userName,$name,$mobile,$id));
        Database::disconnect();
        header("Location: customers.php");
    }
} else {
    $pdo = Database::connect();
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $sql = "SELECT * FROM Customers_tbl where customer_id = ?";
    $q = $pdo->prepare($sql);
    $q->execute(array($id));
    $data = $q->fetch(PDO::FETCH_ASSOC);
    $userName = $data['customer_username'];
    $name = $data['customer_name'];
    $mobile = $data['customer_phoneNum'];
    Database::disconnect();
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <link   href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
</head>

<body>
<div class="container">

    <div class="span10 offset1">
        <div class="row">
            <h3>Update a Customer</h3>
        </div>

        <form class="form-horizontal" action="cUpdate.php?id=<?php echo $id;?>" method="post">
            <div class="control-group <?php echo !empty($userNameError)?'error':'';?>">
                <label class="control-label">Username</label>
                <div class="controls">
                    <input name="username" type="text"  placeholder="username" value="<?php echo !empty($userName)?$userName:'';?>">
                    <?php if (!empty($userNameError)): ?>
                        <span class="help-inline"><?php echo $userNameError;?></span>
                    <?php endif; ?>
                </div>
            </div>
            <div class="control-group <?php echo !empty($nameError)?'error':'';?>">
                <label class="control-label">Name</label>
                <div class="controls">
                    <input name="name" type="text" placeholder="Name" value="<?php echo !empty($name)?$name:'';?>">
                    <?php if (!empty($nameError)): ?>
                        <span class="help-inline"><?php echo $nameError;?></span>
                    <?php endif;?>
                </div>
            </div>
            <div class="control-group <?php echo !empty($mobileError)?'error':'';?>">
                <label class="control-label">Mobile Number</label>
                <div class="controls">
                    <input name="mobile" type="text"  placeholder="Mobile Number" value="<?php echo !empty($mobile)?$mobile:'';?>">
                    <?php if (!empty($mobileError)): ?>
                        <span class="help-inline"><?php echo $mobileError;?></span>
                    <?php endif;?>
                </div>
            </div>
            <div class="form-actions">
                <button type="submit" class="btn btn-success">Update</button>
                <a class="btn" href="customers.php">Back</a>
            </div>
        </form>
    </div>

</div> <!-- /container -->
</body>
</html>
