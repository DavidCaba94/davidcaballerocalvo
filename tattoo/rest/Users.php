<?php
require 'Database.php';
class Users
{
    function __construct()
    {
    }
    public static function getUserLogin($user,$pass){
        $consulta = "SELECT * FROM users WHERE user='$user' AND pass='$pass'";
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
