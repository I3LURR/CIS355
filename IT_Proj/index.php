
<?php
/* ---------------------------------------------------------------------------
 * filename    : login.php
 * author      : Tyler tmolear@svsu.edu from Gpcorser
 * description : This program logs the user in by setting $_SESSION variables
 * ---------------------------------------------------------------------------
 */
// Start or resume session, and create: $_SESSION[] array
session_start();
require 'database.php';
if ( !empty($_POST)) { // if $_POST filled then process the form
    // initialize $_POST variables
    $username = $_POST['username']; // username is email address
    $password = $_POST['password'];
    $passwordhash = MD5($password);
     //echo $password . " " . $passwordhash; //exit();
    // robot 87b7cb79481f317bde90c116cf36084b

    // verify the username/password
    $pdo = Database::connect();
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $sql = "SELECT * FROM Users_tbl WHERE users_username = ? AND users_password = ? LIMIT 1";
    $q = $pdo->prepare($sql);
    $q->execute(array($username,$passwordhash));
    $data = $q->fetch(PDO::FETCH_ASSOC);

    if($data) { // if successful login set session variables
        echo "success!";
        $_SESSION['person_id'] = $data['users_id'];
        $sessionid = $data['users_id'];
        $_SESSION['person_title'] = $data['users_username'];
        $serssionuser = $data['users_username'];
        Database::disconnect();
        header("Location: employee_home.php?id=$serssionuser ");
        // javascript below is necessary for system to work on github
        echo "<script type='text/javascript'> document.location = 'employee_home.php'; </script>";
        exit();
    }
   // else { // otherwise go to login error page
     //   Database::disconnect();
       // header("Location: login_error.html");
 //   }
}
// if $_POST NOT filled then display login form, below.
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

        <div class="row">
            <img src="img/svsulogo.png" />
        </div>

        <!--
        <div class="row">
            <br />
            <p style="color: red;">System temporarily unavailable.</p>
        </div>
        -->

        <div class="row">
            <h3>User Login   <a class="btn btn-primary" href="images.php">Image Stuff</a> </h3>
        </div>

        <form class="form-horizontal" action="index.php" method="post">

            <div class="control-group">
                <label class="control-label">Username</label>
                <div class="controls">
                    <input name="username" type="text"  placeholder="gpcorser" required>
                </div>
            </div>

            <div class="control-group">
                <label class="control-label">Password</label>
                <div class="controls">
                    <input name="password" type="password" placeholder="not your SVSU password, please" required>
                </div>
            </div>

            <div class="form-actions">
                <button type="submit" class="btn btn-success">Sign in</button>
                <a class="btn btn-primary" href="cUser.php">Join (New User)</a>
            </div>

            <p><strong>Dear NEW Users</strong>: Please register by clicking the blue "Join" button above.</p>
            <p><strong>Dear Registered Users</strong>: To log in, use your username and password, and click the green "sign in" button.</p>
            <p><strong>Regarding passwords</strong>: Please create a new unique password for this site. <strong><em><span style="color: red;">Please do not use your regular SVSU password.</span><em></strong> If you forgot your password, to RE-SET your password for this site email "re-set password" to: Tyler O'lear, tmolear@svsu.edu.</p>

            <br />


            <footer>
                <small>&copy; Copyright 2017, Tyler O'Lear
                </small>
            </footer>

        </form>


    </div> <!-- end div: class="span10 offset1" -->

</div> <!-- end div: class="container" -->

</body>

</html>
