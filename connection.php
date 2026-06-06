<?php
$host= "localhost";
$database="airline";
$user= "root";
$pass="";

try{
    $conn=new PDO("mysql:host=$host;dbname=$database",$user,$pass);
    $conn->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
}catch(PDOexception $err){
    echo "connection failed".$err->getMessage();
}
?>