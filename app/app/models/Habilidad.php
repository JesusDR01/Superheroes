<?php

namespace App\Models;

require_once('DBAbstractModel.php');

class Habilidad extends DBAbstractModel {
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
    private $nombre;

    public function setId($id) {
        $this->id = $id;
    }
    public function setNombre($nombre) {
        $this->nombre = $nombre;
    }

    public function getId() {
        return $this->lastInsert();
    }

    public function set() {
        $this->query = "INSERT INTO habilidades(nombre)
                        VALUES(:nombre)";
        $this->parametros['nombre'] = $this->nombre;
        $this->get_results_from_query();
        $this->mensaje = 'Habilidad agregada correctamente';
    }

    public function edit() {
        $this->query = "UPDATE habilidades 
        SET nombre= :nombre
        WHERE id = :id";
        $this->parametros['nombre'] = $this->nombre;
        $this->parametros['id'] = $this->id;
        $this->get_results_from_query();
        $this->mensaje = 'Habilidad editada correctamente';
    }

    public function get($id = '') {}
    public function delete() {}
}
