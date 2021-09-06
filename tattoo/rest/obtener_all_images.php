<?php
require 'Images.php';
if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    $dominio = $_GET['dominio'];
    $images = Images::getAllImages($dominio);
    if ($images) {
        $datos["estado"] = "1";
        $datos["images"] = $images;
        print json_encode($datos);
    } else {
        print json_encode(array(
            "estado" => 2,
            "mensaje" => "KO"
        ));
    }
}
