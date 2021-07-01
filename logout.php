<?php include "connection.ph"?>
<?php
session_start();
session_destroy();
header("Location:login.php");
?>