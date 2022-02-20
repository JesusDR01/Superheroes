<?php

namespace App\Models;

require_once('DBAbstractModel.php');

class Peticiones extends DBAbstractModel {
    private static $instancia;
    public static function getInstancia() {
        if (!isset(self::$instancia)) {
            $miclase = __CLASS__;
            self::$instancia = new $miclase;
        }
        return self::$instancia;
    }
    public function __clone() {
        trigger_error('La clonación no es permitida!.', E_USER_ERROR);
    }

    private $id;
    private $titulo;
    private $descripcion;
    private $idSuperheroe;
    private $idCiudadano;

    public function setId($id) {
        $this->id = $id;
    }
    public function setTitulo($titulo) {
        $this->titulo = $titulo;
    }
    public function setDescripcion($descripcion) {
        $this->descripcion = $descripcion;
    }
    public function setIdSuperheroe($idSuperheroe) {
        $this->idSuperheroe = $idSuperheroe;
    }
    public function setIdCiudadano($idCiudadano) {
        $this->idCiudadano = $idCiudadano;
    }
    public function getMensaje() {
        return $this->mensaje;
    }

    public function set() {
        $this->query = "INSERT INTO peticiones(titulo, descripcion, realizada, idSuperheroe, idCiudadano) 
        VALUES (:titulo, :descripcion, FALSE,:idSuperheroe,:idCiudadano);";
        $this->parametros['titulo'] = $this->titulo;
        $this->parametros['descripcion'] = $this->descripcion;
        $this->parametros['idSuperheroe'] = $this->idSuperheroe;
        $this->parametros['idCiudadano'] = $this->idCiudadano;
        $this->get_results_from_query();
        $this->mensaje = 'Petición agregada correctamente';
    }

    public function markAsCompleted() {
        $this->query = "UPDATE `peticiones`
        SET realizada = TRUE
        WHERE idSuperheroe = :idSuperheroe && id = :id";
        $this->parametros['idSuperheroe'] = $this->idSuperheroe;
        $this->parametros['id'] = $this->id;
        $this->get_results_from_query();
        $this->mensaje = 'Petición editada correctamente';
    }

    public function superheroEvolved() {
        $this->query = "SELECT * FROM peticiones
        WHERE idSuperheroe = :idSuperheroe AND realizada = TRUE";
        $this->parametros['idSuperheroe'] = $this->idSuperheroe;
        $this->get_results_from_query();
        if (count($this->rows) >= 3) {
            return true;
        } else {
            return false;
        }
    }

    public function getLastRq($rowLimit) {
        $this->query = "SELECT id, titulo, descripcion, realizada, idSuperheroe, idCiudadano FROM peticiones
        WHERE idSuperheroe = :idSuperheroe
        ORDER BY id DESC LIMIT $rowLimit;";
        $this->parametros['idSuperheroe'] = $this->idSuperheroe;
        $this->get_results_from_query();
        $this->mensaje = "RQs obtenidas correctamente";
        return $this->rows;
    }

    public function getByNombre() {
        $titulo = "%" . $this->titulo . "%";
        $this->query = "SELECT id, titulo, descripcion, realizada, idSuperheroe, idCiudadano FROM peticiones
        WHERE idSuperheroe = :idSuperheroe AND titulo LIKE :titulo
        ORDER BY id DESC";
        $this->parametros['idSuperheroe'] = $this->idSuperheroe;
        $this->parametros['titulo'] = $titulo;
        $this->get_results_from_query();
        return $this->rows;
    }

    public function get($id = '') {}
    public function edit() {}
    public function delete() {}
}
