<?php
require 'Images.php';
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $url = $_POST['url'];
    $dominio = $_POST['dominio'];
    $tipo = $_POST['tipo'];
    $fecha = $_POST['fecha'];
    $body = json_decode(file_get_contents("php://input"), true);
    $retorno = Images::insert($url,$dominio,$tipo,$fecha);
    if ($retorno) {
        $json_string = json_encode(array("estado" => 1,"mensaje" => "Creacion correcta"));
		echo $json_string;
    } else {
        $json_string = json_encode(array("estado" => 2,"mensaje" => "No se creo el registro"));
		echo $json_string;
    }
}
?>