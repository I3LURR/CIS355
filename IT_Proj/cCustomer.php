<?php

session_start();
if(!isset($_SESSION["person_id"])){ // if "user" not set,
    session_destroy();
    header('Location: index.php');     // go to login page
    exit;
}

	require 'database.php';

	if ( !empty($_POST)) {
		// keep track validation errors
		$userNameError = null;
		$userNameError = null;
		$mobileError = null;
		
		// keep track post values
		$userName = $_POST['username'];
		$name = $_POST['name'];
		$mobile = $_POST['mobile'];
		
		echo $date;
		
		// validate input
		$valid = true;
		if (empty($userName)) {
			$userNameError = 'Please enter UserName';
			$valid = false;
		}
		
		if (empty($name)) {
			$userNameError = 'Please enter name Address';
			$valid = false;
		} 
		
		if (empty($mobile)) {
			$mobileError = 'Please enter Mobile Number';
			$valid = false;
		}
		
		// insert data
		if ($valid) {
			$pdo = Database::connect();
			$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			$sql = "INSERT INTO Customers_tbl (customer_username,customer_name,customer_phoneNum) values(?, ?, ?)";
			$q = $pdo->prepare($sql);
			$q->execute(array($userName,$name,$mobile));
			Database::disconnect();
			header("Location: customers.php");
		}
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
		    			<h3>Create a Customer</h3>
		    		</div>
    		
	    			<form class="form-horizontal" action="cCustomer.php" method="post">
					  <div class="control-group <?php echo !empty($userNameError)?'error':'';?>">
					    <label class="control-label">User Name</label>
					    <div class="controls">
					      	<input name="username" type="text"  placeholder="UserName" value="<?php echo !empty($userName)?$userName:'';?>">
					      	<?php if (!empty($userNameError)): ?>
					      		<span class="help-inline"><?php echo $userNameError;?></span>
					      	<?php endif; ?>
					    </div>
					  </div>
					  <div class="control-group <?php echo !empty($userNameError)?'error':'';?>">
					    <label class="control-label">Name</label>
					    <div class="controls">
					      	<input name="name" type="text" placeholder="Name" value="<?php echo !empty($name)?$name:'';?>">
					      	<?php if (!empty($userNameError)): ?>
					      		<span class="help-inline"><?php echo $userNameError;?></span>
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
						  <button type="submit" class="btn btn-success">Create</button>
						  <a class="btn" href="customers.php">Back</a>
						</div>
					</form>
				</div>
				
    </div> <!-- /container -->
  </body>
</html>