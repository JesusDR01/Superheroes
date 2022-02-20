<?php

namespace App\Models;

require_once('DBAbstractModel.php');

class Ciudadanos extends DBAbstractModel {
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

    private $nombre;
    private $email;
    private $idUsuario;


    public function setId($id) {
        $this->id = $id;
    }
    public function setNombre($nombre) {
        $this->nombre = $nombre;
    }
    public function setEmail($email) {
        $this->email = $email;
    }
    public function setIdUsuario($idUsuario) {
        $this->idUsuario = $idUsuario;
    }

    public function getMensaje() {
        return $this->mensaje;
    }

    public function set() {
        $this->query = "INSERT INTO ciudadanos(nombre,email,idUsuario) VALUES (:nombre, :email,:idUsuario)";
        $this->parametros['nombre'] = $this->nombre;
        $this->parametros['email'] = $this->email;
        $this->parametros['idUsuario'] = $this->idUsuario;
        $this->get_results_from_query();
        $this->mensaje = 'Ciudadano agregado correctamente';
    }

    public function get($id = '') {
        $this->query = "
        SELECT * FROM ciudadanos
        WHERE idUsuario = :idUsuario";

        $this->parametros['idUsuario'] = $this->idUsuario;

        $this->get_results_from_query();

        if (count($this->rows) == 1) {
            foreach ($this->rows[0] as $propiedad => $valor) {
                $this->$propiedad = $valor;
            }
            $this->mensaje = 'sh encontrado';
        } else {
            $this->mensaje = 'sh no encontrado';
        }
        return $this->rows;
    }

    public function edit() {}
    public function delete() {}
}
