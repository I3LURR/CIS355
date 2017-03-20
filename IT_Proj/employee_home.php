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
            <a href="customer_home.php" class="btn btn-success">Create Problem</a>
            <a href="employee_home.php" class="btn btn-primary">Employee Home</a>
            <a href="customers.php">Customers Page</a>
        </p>

        <table class="table table-striped table-bordered">
            <thead>
            <tr>
                <th>Customer Name</th>
                <th>Username</th>
                <th>Problem Type</th>
                <th>Problem Definition</th>
                <th>Problem Date</th>
                <th>Actions</th>
            </tr>
            </thead>
            <tbody>
            <?php
            $pdo = Database::connect();
            $sql = 'SELECT cust.customer_name, cust.customer_username, prob.problem_id, prob.problem_type,
    							prob.problem_definition, prob.problem_date FROM Customers_tbl as cust, Problem_tbl as prob
    							WHERE prob.customer_id=cust.customer_id AND prob.problem_resolved=0
    							ORDER BY prob.problem_date DESC';
            foreach ($pdo->query($sql) as $row) {
                echo '<tr>';
                echo '<td>'. $row['customer_name'] . '</td>';
                echo '<td>'. $row['customer_username'] . '</td>';
                echo '<td>'. $row['problem_type'] . '</td>';
                echo '<td>'. $row['problem_definition'] . '</td>';
                echo '<td>'. $row['problem_date'] . '</td>';
                echo '<td width=170>';
                //echo '<a class="btn btn-info" href="update.php?id='.$row['problem_id'].'">Update</a>';
                //echo '&nbsp;';
                echo '<a class="btn btn-success" href="resolve.php?id='.$row['problem_id'].'&userId='.$id. '">Resolve</a>';
                echo '&nbsp;';
                echo '<a class="btn btn-danger" href="delete.php?id='.$row['problem_id'].'&userId='.$id. '">Delete</a>';
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