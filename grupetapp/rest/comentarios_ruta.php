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
$id_ruta = (isset($_POST['id_ruta'])) ? $_POST['id_ruta'] : '';
$id_usuario = (isset($_POST['id_usuario'])) ? $_POST['id_usuario'] : '';
$nom_apellidos = (isset($_POST['nom_apellidos'])) ? $_POST['nom_apellidos'] : '';
$comentario = (isset($_POST['comentario'])) ? $_POST['comentario'] : '';
$fecha = (isset($_POST['fecha'])) ? $_POST['fecha'] : '';

switch($opcion){
  case 1:
        $consulta = "SELECT * FROM comentarios_ruta WHERE id_ruta = '$id_ruta'";
        $resultado = $conexion->prepare($consulta);
        $resultado->execute();
        $data=$resultado->fetchAll(PDO::FETCH_ASSOC);
        break;
  case 2:
        $consulta = "SELECT * FROM comentarios_ruta WHERE id_usuario = '$id_usuario'";
        $resultado = $conexion->prepare($consulta);
        $resultado->execute();
        $data=$resultado->fetchAll(PDO::FETCH_ASSOC);
        break; 
  case 3:
        $consulta = "INSERT INTO comentarios_ruta (id_ruta, id_usuario, nom_apellidos, comentario, fecha) VALUES('$id_ruta', '$id_usuario', '$nom_apellidos', '$comentario', '$fecha')";
        $resultado = $conexion->prepare($consulta);
        $resultado->execute();                
        break;
  case 4:
        $consulta = "DELETE FROM comentarios_ruta WHERE id='$id'";
        $resultado = $conexion->prepare($consulta);
        $resultado->execute();                           
        break;
}
print json_encode($data, JSON_UNESCAPED_UNICODE);
$conexion = NULL;