<?php

namespace App\Models;

require_once('DBAbstractModel.php');

class SuperheroeHabilidad extends DBAbstractModel {
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
    private $idSuperheroe;
    private $idHabilidad;
    private $valor;

    public function setId($id) {
        $this->id = $id;
    }
    public function setIdSuperheroe($idSuperheroe) {
        $this->idSuperheroe = $idSuperheroe;
    }
    public function setIdHabilidad($idHabilidad) {
        $this->idHabilidad = $idHabilidad;
    }
    public function setValor($valor) {
        $this->valor = $valor;
    }
    public function getMensaje() {
        return $this->mensaje;
    }

    public function set() {
        $this->query = "INSERT INTO superheroes_habilidades (idSuperheroe, idHabilidad,valor)
                        VALUES(:idSuperheroe, :idHabilidad, :valor)";
        $this->parametros['idSuperheroe'] = $this->idSuperheroe;
        $this->parametros['idHabilidad'] = $this->idHabilidad;
        $this->parametros['valor'] = $this->valor;
        $this->get_results_from_query();
        $this->mensaje = 'SH agregado correctamente';
    }

    public function get($id = '') {
        $this->query = "
        SELECT superheroes_habilidades.id, nombre, idHabilidad, idSuperheroe, valor FROM superheroes_habilidades
        INNER JOIN habilidades
        ON habilidades.id = idHabilidad
        WHERE idSuperheroe = :idSuperheroe;";
        $this->parametros['idSuperheroe'] = $this->idSuperheroe;
        $this->get_results_from_query();
        return $this->rows;
    }

    public function edit() {
        $this->query = "UPDATE superheroes_habilidades 
        SET valor= :valor
        WHERE idSuperheroe = :idSuperheroe AND idHabilidad = :idHabilidad";
        $this->parametros['valor'] = $this->valor;
        $this->parametros['idSuperheroe'] = $this->idSuperheroe;
        $this->parametros['idHabilidad'] = $this->idHabilidad;
        $this->get_results_from_query();
        $this->mensaje = 'Habilidad editada correctamente';
    }

    public function delete() {
        $this->query = "DELETE FROM superheroes_habilidades WHERE id = :id";
        $this->parametros['id'] = $this->id;
        $this->get_results_from_query();
        $this->mensaje = 'Habilidad eliminada';
    }
}
