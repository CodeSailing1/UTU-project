<?php
class Comentarios
{
    private $idProducto;
    private $pdo;
    public function  __construct($idProducto, $pdo)
    {
        $this->idProducto = $idProducto;
        $this->pdo = $pdo;
    }
    public function showComments()
    {
        $stm = $this->pdo->prepare("SELECT * FROM comenta c JOIN usuario u ON c.idUsuario = u.idUsuario WHERE idProducto =  :idProducto order by c.fechaComentario desc ");
        $stm->bindParam(':idProducto', $this->idProducto);
        if($stm->execute())
        {
            $comentarios = $stm->fetchAll(PDO::FETCH_ASSOC);
            return json_encode($comentarios);
        }
    }
    public function addComment($idUsuario, $comentario)
    {
        date_default_timezone_set('America/Montevideo');
        $date = date('Y-m-d H:i:s');
        $stm =  $this->pdo->prepare("INSERT INTO comenta (idUsuario, idProducto, textoComentario, fechaComentario) VALUES  (:idUsuario, :idProducto, :comentario, :fechaComentario)");
        $stm->bindParam(':idUsuario', $idUsuario);
        $stm->bindParam(':idProducto', $this->idProducto);
        $stm->bindParam(':comentario', $comentario);
        $stm->bindParam(':fechaComentario', $date);
        if($stm->execute())
        {
            return  json_encode(['success' => true, 'message' => 'Comentario agregado con exito']);
        }
    }
    public function deleteComment($idUsuario, $idComentario)
    {
        $stm = $this ->pdo->prepare("DELETE FROM comenta WHERE idUsuario = :idUsuario AND idComentario = :idComentario");
        $stm->bindParam(':idUsuario', $idUsuario);
        $stm->bindParam(':idcomentario', $idComentario);
        if(  $stm->execute())
        {
            return  json_encode(['success' => true, 'message' => 'Comentario eliminado con exito']);
        }
    }
}