<?php
require 'Database.php';
class Images
{
    function __construct()
    {
    }
    public static function getAllImages($dominio){
        $consulta = "SELECT * FROM images WHERE dominio = '$dominio' ORDER BY id DESC";
        try {
            $comando = Database::getInstance()->getDb()->prepare($consulta);
            $comando->execute();
            return $comando->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            return false;
        }
    }
    public static function insert($url,$dominio,$tipo,$fecha) {
        $comando = "INSERT INTO images ( " .
                "url," .
      			"dominio," .
      			"tipo," .
      			"fecha)" .
            " VALUES(?,?,?,?)";
        $sentencia = Database::getInstance()->getDb()->prepare($comando);
        return $sentencia->execute(
            array($url,$dominio,$tipo,$fecha)
        );
    }
    public static function delete($id){
        $comando = "DELETE FROM images WHERE id=?";
        $sentencia = Database::getInstance()->getDb()->prepare($comando);
        return $sentencia->execute(array($id));
    }
}
?>
