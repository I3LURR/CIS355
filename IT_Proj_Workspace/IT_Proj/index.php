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
			$userPasswordError = 'Please enter a Password';
			$valid = false;
		}

		$blnConnectionSuccess = True;
		$data = null;
		if ($valid) {
			try{
				$pdo = Database::connect();
				$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
				$sql = "SELECT users_username, users_password FROM Users_tbl WHERE users_username='" . $userName . "'";
				$q = $pdo->prepare($sql);
				$q->execute();
				$data = $q->fetch(PDO::FETCH_ASSOC);
				$pdo = Database::disconnect();
			} catch (PDOException $e) {
				$userNameError = "Connection failed, I think!";
				$blnConnectionSuccess = False;
			}
		}
		
		if ($blnConnectionSuccess) {
			// Check to make sure there is data
			if (!$data) {
				$userNameError = "Please enter a valid userName!";
			} else {
				//Check to make sure the password brought back matches the one in input
				if ($userPassword == $data['users_password']) {
					header("Location: http://csis.svsu.edu/~tmolear/CIS355/IT_Proj/employee_home.php?id=" .$userName);
				} else {
					$userNameError = "Please input a valid password!";
				}
			}	
		}
		
	/*	 //check to see if userName/Password is valid
		$data = null;
		if($valid) {
			try {
			$pdo = Database::connect();
			$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			$sql = "SELECT users_username, users_password FROM Users_tbl WHERE users_username='tmolear'";
			$q = $pdo->prepare($sql);
			$q->execute();
			$data = $q->fetch(PDO::FETCH_FIELDS);
			}	catch (PDOException $e) {
				$userNameError =  'Connection failed, I think!.';
				}
		
			//If nothing was returned
			if(!$data) {
				$userNameError = "Invalid username. Please enter a valid username.";
			} else {
				//There is data so lets check the password
				$row = $data->fetch_assoc();
				
				echo $row["users_password"];
				
				 if($row["users_password"] = $userPassword) {
					$data->free();
					$pdo = Database::disconnect();
					header("Location: http://csis.svsu.edu/~tmolear/CIS355/IT_Proj/employee_home.php");
					die();
				} else {
					$userPasswordError = " Invalid password. Please enter the correct password.";
				}	
				$data->free();
				$pdo = Database::disconnect(); 
			}
			
			
	
		}	*/
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
					      	<input name="userPassword" type="password" placeholder="Password" value="<?php echo !empty($userPassword)?$userPassword:'';?>">
					      	<?php if (!empty($userPasswordError)): ?>
					      		<span class="help-inline"><?php echo $userPasswordError;?></span>
					      	<?php endif;?>
					    </div>
					  </div>
					  <div class="form-actions">
					  	<button type="submit" class="btn btn-success">Sign In</button>
					  </div>
					</form>
				</div>
				
    </div> <!-- /container -->
  </body>
</html>