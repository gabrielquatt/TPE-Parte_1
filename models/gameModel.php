<?php

class gameModel{
  
 private $db;

    public function __construct(){
        $this->db = new PDO('mysql:host=localhost;dbname=games;charset=utf8', 'root', '');
        $host = 'localhost';
        $userName = 'root';
        $password = '';
        $database = 'games';

        try {
            $this->db = new PDO("mysql:host=$host;dbname=$database;charset=utf8", $userName, $password);
    
            $this->db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);
        } catch (Exception $e) {
            var_dump($e);
        }
    }
  
     public function getAll() {
         $query = $this->db->prepare('SELECT * FROM categoria');
         $query->execute();
         return $query->fetchAll(PDO::FETCH_OBJ);
     }
     
     public function getGameSpecific($category) {
        $querys = $this->db->prepare("SELECT juego.*, categoria.nombre as categoria FROM
        juego JOIN categoria ON juego.id_categoria = categoria.id_categoria WHERE categoria.nombre  ='$category'");
        $querys->execute();
        return $querys->fetchAll(PDO::FETCH_OBJ);
    }

     public function deleteGameDB($id) {
        $query = $this->db->prepare('DELETE FROM juego WHERE id_juego = ?');
        $query->execute([$id]);
    }
    public function deleteCategoryDB($borrar) {
        $query = $this->db->prepare('DELETE FROM categoria WHERE id_categoria = ?');
        $query->execute([$borrar]);
    }
    public function saveCategory($name) {
        $query = $this->db->prepare('INSERT INTO categoria (nombre) VALUES (?)');
        return $query->execute([$name]);
    }
    public function saveGame($title,$detail,$category,$qualification) {
        $query = $this->db->prepare('INSERT INTO juego (nombre, detalle ,id_categoria, calificacion ) VALUES (?,?,?,?)');
        return $query->execute([$title,$detail,$category,$qualification]);
    }
    public function editGameDB($title,$detail,$category,$qualification,$game) {
        $query = $this->db->prepare("UPDATE  juego SET nombre = '$title', detalle= '$detail', id_categoria = '$category', calificacion = '$qualification' WHERE id_juego = '$game'");
        $query->execute([$title,$detail,$category,$qualification,$game]);
    }
}
?>