<?php
$dns = "mysql:host=localhost;dbname=king concrete";
$user = "root";
$pass = "";
$option = array(

    PDO::MYSQL_ATTR_INIT_COMMAND => "SET Names utf8"

);

try {
    $con = new PDO($dns, $user, $pass, $option);
    $con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {

    echo "Your Connect Is Filed " . $e->getMessage();

}


?>