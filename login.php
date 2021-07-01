<?php include "connection.php" ?>
<?php
session_start();
if(isset($_SESSION['username'])){
     echo "<h2>Already Login: ".$_SESSION['username']."</h2>";
     echo '<br><a href="logout.php">Logout</a>';
     header("Location: http://localhost/first_project/pdocrud_login/index.php");
}
 if(isset($_POST['login'])){
  $email = $_POST['email'];
  $password = $_POST['password'];
// Condition to check name or password enter or not
if(empty($email)){
    $errorMsg[]="Please enter your email";
}
elseif (empty($password)) {
    $errorMsg[]="Please enter your password";
}
// Select statement
   $sql = "SELECT * FROM signup WHERE email=:email AND password=:password";
   $query= $conn->prepare($sql);
   $query->bindValue(':email',$email);
   $query->bindValue(':password',$password);
   $query->execute();
   $row = $query->fetch(PDO::FETCH_ASSOC);
// Condition
if($row === false){
    $_SESSION['msg']= "Incorrect email";
   }else
   {
       $validpass = password_verify($passverify, $row['password']);
   
        if($validpass){
            $_SESSION['user_id'] = $row['id'];
            $_SESSION['username'] = $row['name'];
            header("Location: index.php");
        }else{
        $_SESSION['msg']="Incorrect email password";
        }
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
<form action="#" method="POST">
  <div class="mb-3">
    <label for="InputEmail1" class="form-label">Email address</label>
    <input type="email" name="email" class="form-control" id="exampleInputEmail1" placeholder="email">
  </div>
  <div class="mb-3">
    <label for="InputPassword1" class="form-label">Password</label>
    <input type="password" name="password" class="form-control" id="exampleInputPassword1">
  </div>
  <button type="submit" name="login" class="btn btn-primary">Submit</button>
   <p>if you have't any account then create a account <a href="http://localhost/first_project/signup.php">Signup</a> </p>
</form>