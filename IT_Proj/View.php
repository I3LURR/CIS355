<?php
/* ---------------------------------------------------------------------------
 * filename    :
 * author      : Tyler O'Lear, tmoler@svsu.edu gpcorser
 * description : T
 * ---------------------------------------------------------------------------
 */
session_start();
if(!isset($_SESSION["person_id"])){ // if "user" not set,
    session_destroy();
    header('Location: index.php');     // go to login page
    exit;
}
require 'database.php';

$id = $_GET['id'];
$pdo = Database::connect();
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
$sql = "SELECT * FROM Customers_tbl where customer_id = ?";
$q = $pdo->prepare($sql);
$q->execute(array($id));
$data = $q->fetch(PDO::FETCH_ASSOC);
Database::disconnect();
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

    <div class="row">
        <h3>View Volunteer Details</h3>
    </div>

    <div class="form-horizontal" >

        <div class="control-group col-md-6">

            <label class="control-label">Name</label>
            <div class="controls ">
                <label class="checkbox">
                    <?php echo $data['customer_name'];?>
                </label>
            </div>

            <label class="control-label">Mobile</label>
            <div class="controls">
                <label class="checkbox">
                    <?php echo $data['customer_phoneNum'];?>
                </label>
            </div>

            <label class="control-label">Title</label>
            <div class="controls">
                <label class="checkbox">
                    <?php echo $data['customer_username'];?>
                </label>
            </div>

            <!-- password omitted on Read/View -->

            <div class="form-actions">
                <a class="btn" href="customers.php">Back</a>
            </div>

        </div>

        <!-- Display photo, if any -->

        <div class='control-group col-md-6'>
            <div class="controls ">
                <?php
                if ($data['filesize'] > 0)
                    echo '<img  height=5%; width=15%; src="data:image/jpeg;base64,' .
                        base64_encode( $data['filecontent'] ) . '" />';
                else
                    echo 'No photo on file.';
                ?><!-- converts to base 64 due to the need to read the binary files code and display img -->
            </div>
        </div>

    </div>  <!-- end div: class="form-horizontal" -->

</div> <!-- end div: class="container" -->

</body>

</html>