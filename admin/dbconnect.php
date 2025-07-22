<?php
$hostname="localhost";
$username= "root";
$password= "";
$dbname= "golden_city";
$dbn = "mysql:host=$hostname; dbname=$dbname";
try {
    $conn = new PDO($dbn, $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $conn->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
    echo"connection got";

}catch(Exception $e) {  
    echo $e->getMessage();
}

?>