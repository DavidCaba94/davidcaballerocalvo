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
$tipo_notificacion = (isset($_POST['tipo_notificacion'])) ? $_POST['tipo_notificacion'] : '';
$texto_notificacion = (isset($_POST['texto_notificacion'])) ? $_POST['texto_notificacion'] : '';


switch($opcion){
	case 1:
        $consulta = "SELECT * FROM notificaciones WHERE id_usuario='$id_usuario'";
        $resultado = $conexion->prepare($consulta);
        $resultado->execute();
        $data=$resultado->fetchAll(PDO::FETCH_ASSOC);
        break;
    case 2:
        $consulta = "INSERT INTO notificaciones (id_usuario, tipo_notificacion, texto_notificacion) VALUES('$id_usuario', '$tipo_notificacion', '$texto_notificacion') ";
        $resultado = $conexion->prepare($consulta);
        $resultado->execute();                
        break;
    case 3:
        $consulta = "DELETE FROM notificaciones WHERE id='$id' ";		
        $resultado = $conexion->prepare($consulta);
        $resultado->execute();                           
        break;
}
print json_encode($data, JSON_UNESCAPED_UNICODE);
$conexion = NULL;