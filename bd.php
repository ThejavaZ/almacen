<?php
ob_start();

$servidor = "localhost";
$baseDeDatos = "almacen";
$port = 3307;  // Aqui es mariaDB o MySQL 3306
$usuario = "root";
$contrasenia = "";

try{
    $conexion = new PDO("mysql:host=$servidor;dbname=$baseDeDatos;port=$port", $usuario, $contrasenia);
    $conexion->exec("SET NAMES 'utf8mb4'");

}catch(Exception $ex){
    echo $ex->getMessage();
}
?>