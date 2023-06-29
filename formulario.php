<?php

$nombre = $_POST['nombre'];
$apellido = $_POST['apellido'];
$direccion = $_POST['direccion'];
$telefono = $_POST['telefono'];
$correo = $_POST['correo'];
$genero = $_POST['genero'];

if (!empty($nombre) || !empty($apellido) || !empty($direccion) || !empty($telefono) || !empty($correo) || !empty($genero)){
    $host = "localhost";
    $dbusername = "root";
    $dbpassword = "";
    $dbname = "automar";

    $conn = new mysqli($host, $dbusername, $dbpassword, $dbname);
    if(mysqli_connect_error()){
        die('connect error('.mysqli_connect_errno().')'.mysqli_connect_error());
    }else{
        $SELECT = "SELECT telefono from formulario where telefono = ? limit 1";
        $INSERT = "INSERT INTO formulario (nombre, apellido, direccion, telefono, correo, genero) values(?,?,?,?,?,?)";

    $stmt = $conn->prepare($SELECT);
        $stmt ->bind_param("i", $telefono);
        $stmt ->execute();
        $stmt ->bind_result($telefono);
        $stmt ->store_result();
        $rnum =$stmt->num_rows();
        if($rnum == 0){
            $stmt ->close();
            $stmt = $conn->prepare($INSERT);
            $stmt ->bind_param("sssiss", $nombre, $apellido, $direccion, $telefono, $correo, $genero);
            $stmt ->execute();
            echo "REGISTRO COMPLETADO.";
        }else{
            echo "alguien registro ese numero";
        }
        $stmt->close();
        $conn->close();
    }
}else{
    echo "Todos los datos son OBLIGATORIOS";
    die();
}

?>