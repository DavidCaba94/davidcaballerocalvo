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
$id_usuario = (isset($_POST['id_usuario'])) ? $_POST['id_usuario'] : '';
$texto = (isset($_POST['texto'])) ? $_POST['texto'] : '';
$fecha_pub = (isset($_POST['fecha_pub'])) ? $_POST['fecha_pub'] : '';

switch($opcion){
	case 1:
        $consulta = "SELECT * FROM publicaciones ORDER BY id DESC ";
        $resultado = $conexion->prepare($consulta);
        $resultado->execute();
        $data=$resultado->fetchAll(PDO::FETCH_ASSOC);
        break;
    case 2:
        $consulta = "INSERT INTO publicaciones (id_usuario, texto, fecha_pub, likes) VALUES('$id_usuario', '$texto', '$fecha_pub', 0) ";
        $resultado = $conexion->prepare($consulta);
        $resultado->execute();                
        break;        
    case 3:
        $consulta = "DELETE FROM publicaciones WHERE id='$id' ";		
        $resultado = $conexion->prepare($consulta);
        $resultado->execute();                           
        break;
    case 4:
        $consulta = "UPDATE publicaciones SET likes=likes+1 WHERE id='$id' ";		
        $resultado = $conexion->prepare($consulta);
        $resultado->execute();                           
        break;   
    case 5:
        $consulta = "SELECT * FROM publicaciones WHERE id_usuario='$id_usuario' ORDER BY id DESC ";
        $resultado = $conexion->prepare($consulta);
        $resultado->execute();
        $data=$resultado->fetchAll(PDO::FETCH_ASSOC);
        break;
    case 6:
        $consulta = "SELECT * FROM publicaciones WHERE id_usuario IN (SELECT id_seguido FROM seguidos WHERE id_usuario = '$id_usuario') OR id_usuario = '$id_usuario' ORDER BY id DESC";
        $resultado = $conexion->prepare($consulta);
        $resultado->execute();
        $data=$resultado->fetchAll(PDO::FETCH_ASSOC);
        break;
    case 7:
        $consulta = "SELECT COUNT(id) AS numPublicaciones FROM publicaciones";
        $resultado = $conexion->prepare($consulta);
        $resultado->execute();
        $data=$resultado->fetchAll(PDO::FETCH_ASSOC);
        break;
}
print json_encode($data, JSON_UNESCAPED_UNICODE);
$conexion = NULL;