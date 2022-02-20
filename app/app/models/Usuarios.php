<?php


namespace App\Models;

require_once('DBAbstractModel.php');
class Usuarios extends DBAbstractModel {
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
    private $usuario;
    private $password;
    private $perfil;
    private $idSuperheroe;
    private $idCiudadano;

    public function setId($id) {
        $this->id = $id;
    }
    public function setUsuario($usuario) {
        $this->usuario = $usuario;
    }
    public function setPassword($password) {
        $this->password = $password;
    }
    public function setPerfil($perfil) {
        $this->perfil = $perfil;
    }
    public function getId() {
        return $this->id;
    }
    public function getIdSuperheroe() {
        return $this->idSuperheroe;
    }
    public function getIdCiudadano() {
        return $this->idCiudadano;
    }
    public function getMensaje() {
        return $this->mensaje;
    }

    public function getPerfil() {
        $this->query = "SELECT * FROM ciudadanos
        WHERE idUsuario = (SELECT id FROM usuarios
        WHERE usuario= :usuario AND psw= :psw)";
        $this->parametros['usuario'] = $this->usuario;
        $this->parametros['psw'] = $this->password;
        $this->get_results_from_query();

        if (count($this->rows) == 1) {
            foreach ($this->rows[0] as $propiedad => $valor) {
                $this->$propiedad = $valor;
            }
            
            $this->mensaje = 'Usuario encontrado';
            $this->perfil = 'ciudadano';
            $this->idCiudadano = $this->id;
        } else {
            $this->query = "SELECT * FROM superheroes
            WHERE idUsuario = (SELECT id FROM usuarios
            WHERE usuario= :usuario AND psw= :psw)";

            $this->get_results_from_query();
            
            if (count($this->rows) == 1) {
                foreach ($this->rows[0] as $propiedad => $valor) {
                    $this->$propiedad = $valor;
                }
                $this->mensaje = 'Usuario encontrado';
                $this->idSuperheroe = $this->id;
                $this->perfil = $this->evolucion == 'EXPERTO' ? 'experto' : 'superheroe';
            } else {
                $this->mensaje = 'Usuario no encontrado';
            }
        }
        if (isset($this->idUsuario)){
            $this->id = $this->idUsuario;
        }
        return $this->perfil;
    }

    public function set() {
        $this->query = "SELECT * FROM usuarios WHERE usuario = :usuario";
        $this->parametros['usuario'] = $this->usuario;
        $this->get_results_from_query();
        if (count($this->rows) == 0) {
            $this->query = "INSERT INTO usuarios(usuario, psw)
                            VALUES(:usuario, :psw)";
            $this->parametros['psw'] = $this->password;
            $this->get_results_from_query();
            $this->setId($this->lastInsert());
            $this->mensaje = 'Usuario agregado correctamente';
            return true;
        }else{
            $this->mensaje = 'Usuario ya existe';
            return false;
        }
    }

    public function get($id = '') {
        $this->query = "
            SELECT id, usuario, psw
            FROM usuarios
            WHERE usuario = :usuario AND psw = :psw";
        $this->parametros['usuario'] = $this->usuario;
        $this->parametros['psw'] = $this->password;
        $this->get_results_from_query();
        if (count($this->rows) == 1) {
            foreach ($this->rows[0] as $propiedad => $valor) {
                $this->$propiedad = $valor;
            }
            $this->mensaje = 'Usuario encontrado';
        } else {
            $this->mensaje = 'Usuario no encontrado';
        }
        return $this->rows;
    }

    public function getAll() {}

    public function edit() {}

    public function delete() {}
}