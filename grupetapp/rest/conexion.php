<?php
    class Conexion{
        public static function Conectar(){
            define('servidor', 'db5001769823.hosting-data.io');
            define('nombre_bd', 'dbs1460905');
            define('usuario', 'dbu483300');
            define('password', 'Grupetaap2021!');	
            $opciones = array(PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8');			
            try{
                $conexion = new PDO("mysql:host=".servidor."; dbname=".nombre_bd, usuario, password, $opciones);
                return $conexion;                    
            }catch (Exception $e){
                die("El error de Conexión es: ". $e->getMessage());
            }
        }
    }
?>