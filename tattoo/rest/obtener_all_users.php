<?php
require 'Users.php';
if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    $user = $_GET['user'];
    $pass = $_GET['pass'];
    $dominio = $_GET['dominio'];
    $users = Users::getUserLogin($user, $pass, $dominio);
    if ($users) {
        $datos["estado"] = "1";
        $datos["users"] = $users;
        print json_encode($datos);
    } else {
        print json_encode(array(
            "estado" => 2,
            "mensaje" => "KO"
        ));
    }
}
