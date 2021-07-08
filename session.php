<?php include "function.php"?>
<?php
session_start();
//  Creates session variables
if (isset($_SESSION['name']) && isset($_SESSION['password'])) {
   $uname=$_SESSION['name'];
   $pass=$_SESSION['password'];
}

// fucntion call
 $row =session($uname, $pass);
    if ($pass === $row['password']) {
        echo " Login ".$_SESSION['name']." user";
    }
     else {
        echo "user not login";
     }
?>