<?php include "connection.php" ?>
<?php
session_start();

if(isset($_SESSION['username'])){
echo "<h2>Already Login: ".$_SESSION['username']."</h2>";
echo '<br><a href="logout.php">Logout</a>';
}
if(isset($_GET['token'])){
	$token = $_GET['token'];
	$sql = "update stulogin SET status = :status WHERE token = :token ";
$query = $conn->prepare($sql);
$query->bindValue(':status','active',PDO::PARAM_STR);
$query->bindValue(':token',$token,PDO::PARAM_STR);
$row = $query->execute();
	if($row){
		$_SESSION['msg'] = "Account activated successfully.";
		header("Location: http://localhost/first_project/pdocrud_login/login.php");
	}else{
		$_SESSION['msg']= "Sorry Acccount activate unsuccessful.";
		header("Location: http://localhost/first_project/pdocrud_login/signup.php");
	}
	
}
?>