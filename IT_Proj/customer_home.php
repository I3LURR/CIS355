<?php 
	
	require 'database.php';

	if ( !empty($_POST)) {
		// keep track validation errors
		$nameError = null;
		$userNameError = null;
		$mobileError = null;
		$problemSubjectError = null;
		$problemError = null;
		
		// keep track post values
		$name = $_POST['name'];
		$userName = $_POST['username'];
		$mobile = $_POST['mobile'];
		$problemSubject = $_POST['problemSubject'];
		$problem = $_POST['problem'];
		$date = date('Y-m-d H:i:s');
		
		// validate input
		$valid = true;
		if (empty($name)) {
			$nameError = 'Please enter Name';
			$valid = false;
		}
		
		if (empty($userName)) {
			$userNameError = 'Please enter a User Name';
			echo "username empty!";
			$valid = false;
		} 
		
		if (empty($mobile)) {
			$mobileError = 'Please enter Mobile Number';
			$valid = false;
		}
		
		if (empty($problem)) {
			$problemError = 'Please enter a problem';
			$valid = false;
		}
		
		if (empty($problemSubject)) {
			$problemSubjectError = 'Please enter a problem subject';
			$valid = false;
		} else if ($problemSubject == "Select a Subject") {
			$problemSubjectError = 'Please enter a problem subject';
			$valid = false;
		}
		
		
		// see if the customer already exists
		$blnConnectionSuccess = True;
		if ($valid) {
			$data = null;
			try {
				$pdo = Database::connect();
				$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
				$sql = "SELECT * FROM Customers_tbl WHERE customer_username='" . $userName . "'";
				$q = $pdo->prepare($sql);
				$q->execute();
				$data = $q->fetch(PDO::FETCH_ASSOC);
				$pdo = Database::disconnect();
			} catch (PDOException $e) {
				$userNameError = "Database cannot connect!";
				$blnConnectionSuccess = False;
			}
	
			// Check to make sure there is data
			if (!$data) {
				// Customer doesn't exist yet, we will have to add the customer before we create the problem
				try {
				$pdo = Database::connect();
				$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
				$sql = "CALL new_problem(:username, :custname, :custphone, :probtype, :probdef)";
				$q = $pdo->prepare($sql);
				//put values into the params
				$q->bindparam(':username', $userName);
				$q->bindparam(':custname', $name);
				$q->bindparam(':custphone', $mobile);
				$q->bindparam(':probtype', $problemSubject);
				$q->bindparam(':probdef', $problem);
				$q->execute();
				$pdo = Database::disconnect();
				
				//problem and customer should be added successfully lets go back to a blank cust page
				header("Location: http://csis.svsu.edu/~tmolear/CIS355/IT_Proj/customer_home.php?id=gpcorser");	
				} catch (PDOException $e) {
					$userNameError = "Database cannot connect!";
					$blnConnectionSuccess = False;
				}
				
			} else {
				// Customer already exists we can just add the problem.
				try {
				$pdo = Database::connect();
				$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
				$sql = "INSERT INTO Problem_tbl (customer_id, problem_type, problem_definition, problem_date) VALUES (?,?,?,?)";
				$q = $pdo->prepare($sql);
				$q->execute(array($data['customer_id'],$problemSubject,$problem,$date));
				$pdo = Database::disconnect();
				
				//problem added go back to blank customer home
				header("Location: http://csis.svsu.edu/~tmolear/CIS355/IT_Proj/customer_home.php?id=gpcorser");
				} catch (PDOException $e) {
					$userNameError = "Database cannot connect!";
					$blnConnectionSuccess = False;
				}
			}
		
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
		    			<h3>Create a Problem</h3>
		    		</div>
    		
	    			<form class="form-horizontal" action="customer_home.php" method="post">
					  <div class="control-group <?php echo !empty($userNameError)?'error':'';?>">
					    <label class="control-label">User Name</label>
					    <div class="controls">
					      	<input name="username" type="text"  placeholder="Username" value="<?php echo !empty($userName)?$userName:'';?>">
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
					  <div class="control-group <?php echo !empty($problemSubjectError)?'error':'';?>">
					  	<label class="control-label">Problem Subject</label>
					  	<div class="controls">
					  		<select name="problemSubject" placeholder="Select a subject">
					  			<option value="Select a Subject">Select a Subject</option>
					  			<option value="Laptop">Laptop</option>
					  			<option value="Comm Appointment">Comm Appointment</option>
					  			<option value="Port Activation">Port Activation</option>
					  		</select>
					  		<?php if (!empty($problemSubjectError)): ?>
					  			<span class="help-inline"><?php echo $problemSubjectError;?></span>
					  		<?php endif;?>
					  	</div>
					  </div>
					  <div class="control-group <?php echo !empty($problemError)?'error':'';?>">
					  	<label class="control-label">Problem</label>
					  	<div class="controls">
					  		<textarea name="problem" cols="80" rows="20" placeholder="Input problem here..."><?php echo !empty($problem)?$problem:'';?></textarea>
					  		<?php if (!empty($problemError)): ?>
					  			<span class="help-inline"><?php echo $problemError;?></span>
					  		<?php endif;?>
					  	</div>
					  </div>
					  <div class="form-actions">
						  <button type="submit" class="btn btn-success">Create</button>
						  <a class="btn" href="employee_home.php">Back</a>
						</div>
					</form>
				</div>
				
    </div> <!-- /container -->
  </body>
</html>