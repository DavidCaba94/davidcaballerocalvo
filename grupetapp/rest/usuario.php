<?php
include_once 'conexion.php';
$objeto = new Conexion();
$conexion = $objeto->Conectar();

$_POST = json_decode(file_get_contents("php://input"), true);

function permisos() {  
  if (isset($_SERVER['HTTP_ORIGIN'])){
      header("Access-Control-Allow-Origin: *");
      header("Access-Control-Allow-Methods: GET, POST, PATCH, PUT, DELETE, OPTIONS");
      header("Access-Control-Allow-Headers: Origin, Authorization, X-Requested-With, Content-Type, Accept");
      header('Access-Control-Allow-Credentials: true');      
  }  
  if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS'){
    if (isset($_SERVER['HTTP_ACCESS_CONTROL_REQUEST_METHOD']))          
        header("Access-Control-Allow-Methods: GET, POST, PATCH, PUT, DELETE, OPTIONS");
    if (isset($_SERVER['HTTP_ACCESS_CONTROL_REQUEST_HEADERS']))
        header("Access-Control-Allow-Headers: Origin, Authorization, X-Requested-With, Content-Type, Accept");
    exit(0);
  }
}
permisos();


$opcion = (isset($_POST['opcion'])) ? $_POST['opcion'] : '';
$id = (isset($_POST['id'])) ? $_POST['id'] : '';
$nombre = (isset($_POST['nombre'])) ? $_POST['nombre'] : '';
$apellidos = (isset($_POST['apellidos'])) ? $_POST['apellidos'] : '';
$email = (isset($_POST['email'])) ? $_POST['email'] : '';
$password = (isset($_POST['password'])) ? $_POST['password'] : '';
$fecha_registro = (isset($_POST['fecha_registro'])) ? $_POST['fecha_registro'] : '';
$provincia = (isset($_POST['provincia'])) ? $_POST['provincia'] : '';
$foto = (isset($_POST['foto'])) ? $_POST['foto'] : '';

$password = md5($password);

switch($opcion){
	case 1:
        $consulta = "SELECT * FROM usuarios ORDER BY id DESC";
        $resultado = $conexion->prepare($consulta);
        $resultado->execute();
        $data=$resultado->fetchAll(PDO::FETCH_ASSOC);
        break;
    case 2:
        $consulta = "INSERT INTO usuarios (nombre, apellidos, email, passwd, fecha_registro, provincia) VALUES('$nombre', '$apellidos', '$email', '$password', '$fecha_registro', '$provincia') ";
        $resultado = $conexion->prepare($consulta);
        $resultado->execute();                
        break;
    case 3:
        $consulta = "UPDATE usuarios SET nombre='$nombre', apellidos='$apellidos', email='$email', provincia='$provincia' WHERE id='$id' ";		
        $resultado = $conexion->prepare($consulta);
        $resultado->execute();                        
        $data=$resultado->fetchAll(PDO::FETCH_ASSOC);
        break;        
    case 4:
        $consulta = "DELETE FROM usuarios WHERE id='$id' ";		
        $resultado = $conexion->prepare($consulta);
        $resultado->execute();                           
        break;
    case 5:
        $consulta = "SELECT * FROM usuarios WHERE email='$email' AND passwd='$password'";
        $resultado = $conexion->prepare($consulta);
        $resultado->execute();
        $data=$resultado->fetchAll(PDO::FETCH_ASSOC);
        break;
    case 6:
        $consulta = "SELECT email FROM usuarios WHERE email='$email'";
        $resultado = $conexion->prepare($consulta);
        $resultado->execute();
        $data=$resultado->fetchAll(PDO::FETCH_ASSOC);
        break;  
    case 7:
        $consulta = "SELECT nombre, apellidos, foto FROM usuarios WHERE id='$id'";
        $resultado = $conexion->prepare($consulta);
        $resultado->execute();
        $data=$resultado->fetchAll(PDO::FETCH_ASSOC);
        break;   
    case 8:
        $consulta = "UPDATE usuarios SET foto='$foto' WHERE id='$id' ";		
        $resultado = $conexion->prepare($consulta);
        $resultado->execute();                        
        $data=$resultado->fetchAll(PDO::FETCH_ASSOC);
        break; 
    case 9:
        $consulta = "UPDATE usuarios SET passwd='$password' WHERE id='$id' ";		
        $resultado = $conexion->prepare($consulta);
        $resultado->execute();                        
        $data=$resultado->fetchAll(PDO::FETCH_ASSOC);
        break;
    case 10:
        $consulta = "SELECT * FROM usuarios WHERE id='$id'";
        $resultado = $conexion->prepare($consulta);
        $resultado->execute();
        $data=$resultado->fetchAll(PDO::FETCH_ASSOC);
        break;
    case 11:
        $consulta = "SELECT COUNT(id) AS numUsers FROM usuarios";
        $resultado = $conexion->prepare($consulta);
        $resultado->execute();
        $data=$resultado->fetchAll(PDO::FETCH_ASSOC);
        break;  
    
}
print json_encode($data, JSON_UNESCAPED_UNICODE);
$conexion = NULL;