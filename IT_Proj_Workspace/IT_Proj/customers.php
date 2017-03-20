<?php
require 'database.php';
//This is going to be ther username of the employee that signed in. For when things are resolved
$id = "";

if ( !empty($_GET['id'])) {
    $id = $_REQUEST['id'];
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
    <div class="row">
        <h3>PHP CRUD Grid(Problem Table)</h3>
    </div>
    <div class="row">
        <p>
            <a href="cCustomer.php" class="btn btn-success">Create Customer</a>
            <a href="employee_home.php" class="btn btn-primary">Employee Home</a>
            <a href="customers.php">Customers Page</a>
        </p>

        <table class="table table-striped table-bordered">
            <thead>
            <tr>
                <th>Customer ID</th>
                <th>Customer Username</th>
                <th>Customer Name</th>
                <th>Customer PhoneNum</th>
                <th>Actions</th>
            </tr>
            </thead>
            <tbody>
            <?php
            $pdo = Database::connect();
            $sql = 'SELECT cust.customer_id, cust.customer_username, cust.customer_name, cust.customer_phoneNum
    							FROM Customers_tbl as cust';
            foreach ($pdo->query($sql) as $row) {
                echo '<tr>';
                echo '<td>'. $row['customer_id'] . '</td>';
                echo '<td>'. $row['customer_username'] . '</td>';
                echo '<td>'. $row['customer_name'] . '</td>';
                echo '<td>'. $row['customer_phoneNum'] . '</td>';
                echo '<td width=170>';
                echo '<a class="btn btn-info" href="cUpdate.php?id='.$row['customer_id'].'">Update</a>';
                echo '&nbsp;';
                //echo '<a class="btn btn-success" href="cInfo?id='.$row['customer_id'].'&userId='.$id. '">Resolve</a>';
                //echo '&nbsp;';
                echo '<a class="btn btn-danger" href="cDelete.php?id='.$row['customer_id'].'&userId='.$id. '">Delete</a>';
                echo '</td>';
                echo '</tr>';
            }
            Database::disconnect();
            ?>
            </tbody>
        </table>
    </div>
</div> <!-- /container -->
</body>
</html>