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
$id_seguido = (isset($_POST['id_seguido'])) ? $_POST['id_seguido'] : '';

switch($opcion){
	case 1:
        $consulta = "SELECT * FROM seguidos WHERE id_usuario = '$id' ORDER BY id DESC";
        $resultado = $conexion->prepare($consulta);
        $resultado->execute();
        $data=$resultado->fetchAll(PDO::FETCH_ASSOC);
        break;
  case 2:
        $consulta = "SELECT * FROM seguidos WHERE id_usuario = '$id' AND id_seguido = '$id_seguido'";
        $resultado = $conexion->prepare($consulta);
        $resultado->execute();
        $data=$resultado->fetchAll(PDO::FETCH_ASSOC);
        break; 
  case 3:
        $consulta = "INSERT INTO seguidos (id_usuario, id_seguido) VALUES('$id', '$id_seguido')";
        $resultado = $conexion->prepare($consulta);
        $resultado->execute();                
        break;
  case 4:
        $consulta = "INSERT INTO seguidores (id_usuario, id_seguidor) VALUES('$id_seguido', '$id')";
        $resultado = $conexion->prepare($consulta);
        $resultado->execute();                
        break;
  case 5:
        $consulta = "DELETE FROM seguidos WHERE id_usuario='$id' AND id_seguido='$id_seguido'";
        $resultado = $conexion->prepare($consulta);
        $resultado->execute();                           
        break;
  case 6:
        $consulta = "DELETE FROM seguidores WHERE id_usuario='$id_seguido' AND id_seguidor='$id'";	
        $resultado = $conexion->prepare($consulta);
        $resultado->execute();                           
        break;
  case 7:
        $consulta = "DELETE FROM seguidos WHERE id_usuario='$id'";	
        $resultado = $conexion->prepare($consulta);
        $resultado->execute();                           
        break;
  case 8:
        $consulta = "DELETE FROM seguidores WHERE id_seguidor='$id'";	
        $resultado = $conexion->prepare($consulta);
        $resultado->execute();                           
        break;
}
print json_encode($data, JSON_UNESCAPED_UNICODE);
$conexion = NULL;