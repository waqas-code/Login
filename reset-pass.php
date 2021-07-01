<?php include "connection.php" ?>
<?php
session_start();
if(isset($_POST['reset'])){
if(isset($_GET['token']))
{
$token = $_GET['token'];
	$password = $_POST['password'];
	$cpassword = $_POST['cpassword'];
$password = password_hash($newpass,PASSWORD_BCRYPT);
	$cpassword = password_hash($cpass,PASSWORD_BCRYPT);
	if($password ===  $cpassword)
	{
	$sql =  "UPDATE signup SET password=:password WHERE token=:token";
	$query = $conn->prepare($sql);
	$query->bindValue(':token',$token);
	$query->bindValue(':password',$password);
	$row=$query->execute();
	if($row)
	{
$_SESSION['msg']="Thank you! your password has been updated.";
header("Location: http://localhost/first_project/pdocrud_login/login.php");
	}else
	{
	$_SESSION['passmsg']="Sorry Password reset unsuccessful.";
	header("Location: http://localhost/first_project/pdocrud_login/reset-pass.php");
}
	}else
	{
		$_SESSION['passmsg']="Password is not matching Try agin!";
	}
	
	}else
	{
		echo "No token found";
	}
}
?>
<!-- HTML PART -->
<form action="#" method="POST">
<?php if(isset($_SESSION['passmsg']))
{
	echo $_SESSION['passmsg'];
}else
	echo $_SESSION['passmsg'] = "";
?>
 <div class="mb-3">
    <label for="InputPassword1" class="form-label">Password</label>
    <input type="password" name="password" class="form-control" id="exampleInputPassword1">
  </div>
  <div class="mb-3">
    <label for="InputPassword1" class="form-label">Confirm-Password</label>
    <input type="password" name="c-password" class="form-control" id="exampleInputPassword1">
  </div>
  <button type="submit" name="reset" class="btn btn-primary">Submit</button>
</form>
<?php			
	if(isset($_SESSION['username'])){
	 echo "<h2>Already Login: ".$_SESSION['username']."</h2>";
		echo '<br><a href="logout.php">Logout</a>';
	}else{
		echo '<p>Already Registered<a href="login.php"> Login Now!</a></p>';
	}
?>