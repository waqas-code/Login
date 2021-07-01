<!-- Connection File -->
<?php
$servername="localhost";
$db="first_project";
$name="root";
$password="";
// try section
try{
    $conn = new PDO("mysql:host=$servername;dbname=$db", $name, $password);
    // pdo error setup to expection
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
   echo "connection Successfully";
}catch(PDOExpection $e){
    echo "Connection Failed" .$e->getMessage();
}
?>