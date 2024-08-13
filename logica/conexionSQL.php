<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
<?php
$server = "localhost";
$user = "root";
$pass = "password";
$db = "conexion"
$conectar = new mysqli($server, $user, $pass, $db);
if($conectar->connect_errno){
    die("Conexion Fallida" . $conectar->connect_errno);
}else{
    echo "Conectado";
}
?>
</body>
</html>
