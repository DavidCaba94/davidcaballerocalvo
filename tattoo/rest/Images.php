<?php
require 'Database.php';
class Users
{
    function __construct()
    {
    }
    public static function getAllImages(){
        $consulta = "SELECT * FROM images";
        try {
            $comando = Database::getInstance()->getDb()->prepare($consulta);
            $comando->execute();
            return $comando->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            return false;
        }
    }
}
?>
