<?php 
	require 'database.php';
	$id = 0;
	$user = "";
			
	$valid = true;
	if ( !empty($_GET['id'])) {
		$id = $_REQUEST['id'];
	} else {
		$valid = false;
	}
	
	
	if (!empty($_GET['userId'])) {
		$user = $_REQUEST['userId'];
	} else {
		$valid = false;
	}
	
	if ( !empty($_POST)) {
		// keep track post values
		$id = $_POST['id'];
		$user = $_POST['user'];
		
		// delete data
		$pdo = Database::connect();
		$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$sql = "DELETE FROM Problem_tbl  WHERE problem_id = ?";
		$q = $pdo->prepare($sql);
		$q->execute(array($id));
		Database::disconnect();
		header("Location: http://csis.svsu.edu/~tmolear/CIS355/IT_Proj/employee_home.php?id=". $user);
		
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
	    			<form class="form-horizontal" action="delete.php" method="post">
	    			  <input type="hidden" name="id" value="<?php echo $id;?>"/>
	    			  <input type="hidden" name="user" value=" <?php echo $user;?>" />
					  <div class="alert alert-danger">
  						<strong>Delete a Customer</strong> Are you sure you want to delete this problem?
					  </div>
					  <div class="form-actions">
						  <button type="submit" class="btn btn-danger">Yes</button>
						  <?php echo '<a class="btn" href="employee_home.php?id='. $user. '">No</a>'; ?>
					  </div>
					</form>
				</div>
				
    </div> <!-- /container -->
  </body>
</html>