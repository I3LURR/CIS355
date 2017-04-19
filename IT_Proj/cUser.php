<?php
/* ---------------------------------------------------------------------------
 * filename    : fr_per_create.php
 * author      : Tyler O, tmolear@svsu.edu
 * description : This program adds/inserts a new user (table: fr_persons)
 * ---------------------------------------------------------------------------
 */
/*session_start();
if(!isset($_SESSION["fr_person_id"])){ // if "user" not set,
    session_destroy();
    header('Location: index.php');     // go to login page
    exit;
}*/

require 'database.php';
if ( !empty($_POST)) { // if not first time through
    // initialize user input validation variables
    $userIDError = null;
    $usernameError = null;
    $fnameError = null;
    $lnameError = null;
    $mobileError = null;
    $passwordError = null;
    $titleError = null;

    // initialize $_POST variables
    $userID = $_POST['userid'];
    $username = $_POST['username'];
    $fname = $_POST['fname'];
    $lname = $_POST['lname'];
    $mobile = $_POST['mobile'];
    $password = $_POST['password'];
    $passwordhash = MD5($password);

    // validate user input
    $valid = true;
    if (empty($userID)) {
        $userIDError = 'Please enter UserID';
        $valid = false;
    }
    if (!preg_match("/^[0-9]{6}$/", $userID)) {
        $userIDError = 'Please write a proper userID maximum of 6 #';
        $valid = false;
    }
    if (empty($username)) {
        $usernameError = 'Please enter Username';
        $valid = false;
    }
    if (empty($fname)) {
        $fnameError = 'Please enter First Name';
        $valid = false;
    }
    if (empty($lname)) {
        $lnameError = 'Please enter Last Name';
        $valid = false;
    }


    $pdo = Database::connect();
    $sql = "SELECT * FROM Users_tbl";
    foreach($pdo->query($sql) as $row) {
        if($username == $row['users_username']) {
            $emailError = 'Username has already been registered!';
            $valid = false;
        }
    }
    Database::disconnect();
    // email must contain only lower case letters
    if (strcmp(strtolower($username),$username)!=0) {
        $emailError = 'username can contain only lower case letters';
        $valid = false;
    }
    if (empty($mobile)) {
        $mobileError = 'Please enter Mobile Number (or "none")';
        $valid = false;
    }
    if(!preg_match("/^[0-9]{3}-[0-9]{3}-[0-9]{4}$/", $mobile)) {
        $mobileError = 'Please write Mobile Number in form 000-000-0000';
        $valid = false;
    }
    if (empty($password)) {
        $passwordError = 'Please enter valid Password';
        $valid = false;
    }

    // restrict file types for upload
    // insert data
    if ($valid)
    {
        $pdo = Database::connect();
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $sql = "INSERT INTO Users_tbl (users_id,users_username,users_password,users_first_name,users_last_name,users_phonenumber) values(?, ?, ?, ?, ?, ?)";
        $q = $pdo->prepare($sql);
        $q->execute(array($userID,$username,$passwordhash,$fname,$lname,$mobile));
        Database::disconnect();
        header("Location: index.php");
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <link   href="css/bootstrap.min.css" rel="stylesheet">
    <script src="js/bootstrap.min.js"></script>
    <link rel="icon" href="cardinal_logo.png" type="image/png" />
</head>

<body>
<div class="container">

    <div class="span10 offset1">

        <div class="row">
            <h3>Add New User</h3>
        </div>

        <form class="form-horizontal" action="cUser.php" method="post" enctype="multipart/form-data">

            <div class="control-group <?php echo !empty($fnameError)?'error':'';?>">
                <label class="control-label">First Name</label>
                <div class="controls">
                    <input name="fname" type="text"  placeholder="First Name" value="<?php echo !empty($fname)?$fname:'';?>">
                    <?php if (!empty($fnameError)): ?>
                        <span class="help-inline"><?php echo $fnameError;?></span>
                    <?php endif; ?>
                </div>
            </div>

            <div class="control-group <?php echo !empty($lnameError)?'error':'';?>">
                <label class="control-label">Last Name</label>
                <div class="controls">
                    <input name="lname" type="text"  placeholder="Last Name" value="<?php echo !empty($lname)?$lname:'';?>">
                    <?php if (!empty($lnameError)): ?>
                        <span class="help-inline"><?php echo $lnameError;?></span>
                    <?php endif; ?>
                </div>
            </div>

            <div class="control-group <?php echo !empty($userIDError)?'error':'';?>">
                <label class="control-label">UserID</label>
                <div class="controls">
                    <input name="userid" type="text" placeholder="User ID" value="<?php echo !empty($userID)?$userID:'';?>">
                    <?php if (!empty($userIDError)): ?>
                        <span class="help-inline"><?php echo $userIDError;?></span>
                    <?php endif;?>
                </div>
            </div>

            <div class="control-group <?php echo !empty($usernameError)?'error':'';?>">
                <label class="control-label">UserName</label>
                <div class="controls">
                    <input name="username" type="text" placeholder="UserName" value="<?php echo !empty($username)?$username:'';?>">
                    <?php if (!empty($usernameError)): ?>
                        <span class="help-inline"><?php echo $usernameError;?></span>
                    <?php endif;?>
                </div>
            </div>

            <div class="control-group <?php echo !empty($mobileError)?'error':'';?>">
                <label class="control-label">Mobile Number</label>
                <div class="controls">
                    <input name="mobile" type="text"  placeholder="Mobile Phone Number" value="<?php echo !empty($mobile)?$mobile:'';?>">
                    <?php if (!empty($mobileError)): ?>
                        <span class="help-inline"><?php echo $mobileError;?></span>
                    <?php endif;?>
                </div>
            </div>

            <div class="control-group <?php echo !empty($passwordError)?'error':'';?>">
                <label class="control-label">Password</label>
                <div class="controls">
                    <input id="password" name="password" type="text"  placeholder="Password" value="<?php echo !empty($password)?$password:'';?>">
                    <?php if (!empty($passwordError)): ?>
                        <span class="help-inline"><?php echo $passwordError;?></span>
                    <?php endif;?>
                </div>
            </div>





            <div class="form-actions">
                <button type="submit" class="btn btn-success">Create</button>
                <a class="btn" href="index.php">Back</a>
            </div>

        </form>

    </div> <!-- end div: class="span10 offset1" -->

</div> <!-- end div: class="container" -->
</body>
</html>