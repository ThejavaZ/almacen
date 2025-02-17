<?php
ob_start();

$servidor = "localhost";
$baseDeDatos = "almacen";
$port = 3307;
$usuario = "root";
$contrasenia = "";

try{
    $conexion = new PDO("mysql:host=$servidor;dbname=$baseDeDatos;port=$port", $usuario, $contrasenia);

}catch(Exception $ex){
    echo $ex->getMessage();
}
?>