<?php
include_once 'conexion.php';
$objeto = new Conexion();
$conexion = $objeto->Conectar();

$_POST = json_decode(file_get_contents("php://input"), true);

function permisos()
{
    if (isset($_SERVER['HTTP_ORIGIN'])) {
        header("Access-Control-Allow-Origin: *");
        header("Access-Control-Allow-Methods: GET, POST, PATCH, PUT, DELETE, OPTIONS");
        header("Access-Control-Allow-Headers: Origin, Authorization, X-Requested-With, Content-Type, Accept");
        header('Access-Control-Allow-Credentials: true');
    }
    if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS') {
        if (isset($_SERVER['HTTP_ACCESS_CONTROL_REQUEST_METHOD']))
            header("Access-Control-Allow-Methods: GET, POST, PATCH, PUT, DELETE, OPTIONS");
        if (isset($_SERVER['HTTP_ACCESS_CONTROL_REQUEST_HEADERS']))
            header("Access-Control-Allow-Headers: Origin, Authorization, X-Requested-With, Content-Type, Accept");
        exit(0);
    }
}
permisos();

$opcion = (isset($_POST['opcion'])) ? $_POST['opcion'] : '';
$nombres = (isset($_POST['nombres'])) ? $_POST['nombres'] : '';
$apellidos = (isset($_POST['apellidos'])) ? $_POST['apellidos'] : '';
$fechaNac = (isset($_POST['fechaNac'])) ? $_POST['fechaNac'] : '';
$direccion = (isset($_POST['direccion'])) ? $_POST['direccion'] : '';
$email = (isset($_POST['email'])) ? $_POST['email'] : '';
$username = (isset($_POST['username'])) ? $_POST['username'] : '';
$password = (isset($_POST['password'])) ? $_POST['password'] : '';

switch ($opcion) {
    case 1:
        $consulta = "SELECT * FROM registro";
        $resultado = $conexion->prepare($consulta);
        $resultado->execute();
        $data = $resultado->fetchAll(PDO::FETCH_ASSOC);
        break;
    case 2:
        $consulta = "INSERT INTO registro (nombres, apellidos, fechaNac, direccion, email) VALUES('$nombres', '$apellidos', '$fechaNac', '$direccion', '$email') ";
        $resultado = $conexion->prepare($consulta);
        $resultado->execute();
        break;
    case 3:
        $consulta = "SELECT username, password, role FROM usuarios WHERE username = '$username'";
        $resultado = $conexion->prepare($consulta);
        $resultado->execute();
        $data = $resultado->fetchAll(PDO::FETCH_ASSOC);
        if (($username=="admin") && ($password=="admin123")) {
            $response[] = array('status' => 1);
        } else {
            $response[] = array('status' => 0);
        }
        break;
    case 4:
        header("Content-Type: application/xls");
        header("Content-Disposition:attachment, filename=download.xls");
        $salida = fopen('php://output','w');
        fputcsv($salida, array('Id','Nombres','Apellidos','Fecha de Nacimiento','Direccion','Email'));

        // $resultado = $conexion->prepare($consulta);
        // $resultado->execute();
        // $data = $resultado->fetchAll(PDO::FETCH_ASSOC);
        $consulta = $conexion->query("SELECT * FROM registro");
        $data=$consulta;
        while($filaR = $consulta->fetch()){
            fputcsv($salida, array($filaR['id'],$filaR['nombres'],$filaR['apellidos'],$filaR['fechaNac'],$filaR['direccion'],$filaR['email'],));
        }
        break;
}
print json_encode($data, JSON_UNESCAPED_UNICODE);
$conexion = NULL;
