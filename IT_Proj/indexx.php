<?php 
	
	require 'database.php';

	if ( !empty($_POST)) {
		// keep track validation errors
		$userNameError = null;
		$userPasswordError = null;
		
		// keep track post values
		$userName = $_POST['userName'];
		$userPassword = $_POST['userPassword'];
		
		// validate input
		$valid = true;
		if (empty($userName)) {
			$userNameError = 'Please enter a User Name';
			$valid = false;
		}
		
		if (empty($userPassword)) {
			$emailError = 'Please enter a Password';
			$valid = false;
		}
		
		// insert data
		if ($valid) {
			$pdo = Database::connect();
			$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			$sql = "INSERT INTO customers (userName, userPassword) values(?, ?)";
			$q = $pdo->prepare($sql);
			$q->execute(array($userName, $userPassword));
			Database::disconnect();
			header("Location: index.php");
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
		    			<h2>Sign In</h2>
		    		</div>
    		
	    			<form class="form-horizontal" action="indexx.php" method="post">
					  <div class="control-group <?php echo !empty($userNameError)?'error':'';?>">
					    <label class="control-label">User Name</label>
					    <div class="controls">
					      	<input name="userName" type="text"  placeholder="User Name" value="<?php echo !empty($userName)?$userName:'';?>">
					      	<?php if (!empty($userNameError)): ?>
					      		<span class="help-inline"><?php echo $userNameError;?></span>
					      	<?php endif; ?>
					    </div>
					  </div>
					  <div class="control-group <?php echo !empty($userPassword)?'error':'';?>">
					    <label class="control-label">User Name</label>
					    <div class="controls">
					      	<input name="userName" type="password" placeholder="Password" value="<?php echo !empty($userName)?$userName:'';?>">
					      	<?php if (!empty($userNameError)): ?>
					      		<span class="help-inline"><?php echo $userNameError;?></span>
					      	<?php endif;?>
					    </div>
					  </div>
					  <div class="form-actions">
						  <button type="submit" class="btn btn-success">Log In</button>
						</div>
					</form>
				</div>
				
    </div> <!-- /container -->
  </body>
</html>