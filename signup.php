<?php include "connection.php"?>
<!-- Session file -->
  session_start();
  $msg = "";
<!-- Data Check section -->
<?php
 if(isset($_POST['signup'])){
     $name = $_POST['name'];
     $email = $_POST['email'];
     $password = $_POST['password'];
     $cpassword = $_POST['cpassword'];
// Condition for email exits or not
    if(empty($name)){
        $errorMsg[]="Please enter your name";
    }
    elseif (empty($email)) {
        $errorMsg[]="please enter your email";
    }
    else if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errorMsg[]="please enter Valid email";
    }
    elseif (empty($password)) {
       $errorMsg[]="please enter your password";
    }
    elseif (strlen($password) < 6 ) {
        $errorMsg[]="password must atleast 6 character";
    }
//  select statement
     $sql = 'SELECT * FROM signup WHERE email=:email';
     $query = $conn->prepare($sql);
     $query->bindValue(':email', $email);
     $query->execute();
     $row = $query->fetch(PDO::FETCH_ASSOC);
//  Check user name already exits
   if($row["name"]==$name){
    $errorMsg[]="sorry this name already exits";
   }
   elseif ($row['email']==$email) {
    $errorMsg[]="sorry this email already exits";
   }
  elseif (!isset($errorMsg)) {
  $password = password_hash($password, PASSWORD_DEFAULT);
  }
  // Insert Data to the table
  $insert_state ="INSERT INTO signup (name,email,password,cpassword) VALUES (:name,:email,:password,:cpassword)";
  $query=$conn->prepare($insert_state);
  $query->bindValue(':name',$name);
  $query->bindValue(':email',$email);
  $query->bindValue(':password',$password);
  $query->bindValue(':cpassword',$cpassword);
  $query->execute();
  $result= $query->fetch(PDO::FETCH_ASSOC);
  // mail section
  if($result)
	{
  $subject = "Account activate";
  $body = "Hi, $username Click here to activate your account
  http://localhost/firt_project/login.php?token=$token";
  $headers = "From:mwaqasmwaqas094@gmail.com";
if(mail($email, $subject, $body, $headers)){
  $_SESSION['msg'] ="Check you email to activate Account.";
  header("Location: login.php");
} 
  else {
     $msg= "Email sending failed...";
  }
else{
		$msg="Not Register";
	}
	else{
	$msg="password is not matched";
  }
}
?>

<!-- Message Creating Area -->
<?php 
if(isset($errorMsg)){
    foreach($errorMsg as $error){
        ?>
        <div class="alert alert-danger">
         <strong>Wrong! <?php echo $error; ?></strong>
        </div>
        <?php
 }
 }
 if(isset($signupMsg)){
  ?>
   <div class="alert alert-primary">
     <strong><?php echo $signupMsg; ?></strong>
   </div>
   <?php
 }
 ?>
<!-- HTML PART -->
<?php echo "$msg"; ?>
<form action="#" method="POST">
<div class="mb-3">
    <label for="InputEmail1" class="form-label">Name</label>
    <input type="text" name="name" class="form-control" id="exampleInputEmail1" placeholder="name">
  </div><br>
  <div class="mb-3">
    <label for="InputEmail1" class="form-label">Email address</label>
    <input type="email" name="email" class="form-control" id="exampleInputEmail1" placeholder="email">
  </div><br>
  <div class="mb-3">
    <label for="InputPassword1" class="form-label">Password</label>
    <input type="password" name="password" class="form-control" id="exampleInputPassword1">
  </div><br>
  <div class="mb-3">
    <label for="InputPassword1" class="form-label">Confirm-Password</label>
    <input type="password" name="c-password" class="form-control" id="exampleInputPassword1">
  </div><br>
  <button type="submit" name="signup" class="btn btn-primary">Submit</button>
   <p>if you have already account then create a account <a href="#">Signin</a> </p>
</form>
<?php			
	if(isset($_SESSION['username'])){
	 echo "<h2>Already Login: ".$_SESSION['username']."</h2>";
		echo '<br><a href="logout.php">Logout</a>';
	}else{
		echo '<p>Already Registered<a href="login.php"> Login Now!</a></p>';
	}
?>