<?php

namespace App\Models;

#Importar modelo de abstraccion de base de datos
require_once('DBAbstractModel.php');

class Superheroe extends DBAbstractModel {
    /*CONSTRUCCIÓN DEL MODELO SINGLETON*/
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
    private $imagen;
    private $idUsuario;


    public function setId($id) {
        $this->id = $id;
    }
    public function setNombre($nombre) {
        $this->nombre = $nombre;
    }
    public function setImagen($imagen) {
        $this->imagen = $imagen;
    }
    public function setIdUsuario($idUsuario) {
        $this->idUsuario = $idUsuario;
    }
    public function setEvolucion($evolucion) {
        $this->evolucion = $evolucion;
    }

    public function getMensaje() {
        return $this->mensaje;
    }

    public function getHabilidades() {
        $this->query = "SELECT habilidades.id, habilidades.nombre, valor FROM superheroes_habilidades
        INNER JOIN habilidades
        ON habilidades.id = superheroes_habilidades.idHabilidad
        WHERE superheroes_habilidades.idSuperheroe = :id";
        $this->parametros['id'] = $this->id;
        $this->get_results_from_query();

        if (count($this->rows) == 1) {
            foreach ($this->rows[0] as $propiedad => $valor) {
                $this->$propiedad = $valor;
            }
            $this->mensaje = 'habilidades encontradas';
        } else {
            $this->mensaje = 'habilidades no encontradas';
        }
        return $this->rows;
    }

    public function set() {
        $this->query = "INSERT INTO superheroes(nombre, imagen,evolucion,idUsuario)
                        VALUES(:nombre, :imagen, :evolucion, :idUsuario)";
        $this->parametros['nombre'] = $this->nombre;
        $this->parametros['imagen'] = $this->imagen;
        $this->parametros['evolucion'] = $this->evolucion ?? 'PRINCIPIANTE';
        $this->parametros['idUsuario'] = $this->idUsuario;
        $this->get_results_from_query();
        $this->mensaje = 'SH agregado correctamente';
    }

    public function get($id = '') {
        $this->query = "
            SELECT *
            FROM superheroes
            WHERE id = :id";

        $this->parametros['id'] = $id;

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

    public function getByUser() {
        $this->query = "
            SELECT *
            FROM superheroes
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

    public function getAll() {
        $this->query = "SELECT * FROM superheroes";

        $this->get_results_from_query();
        foreach ($this->rows[0] as $propiedad => $valor) {
            $this->$propiedad = $valor;
        }

        return $this->rows;
    }

    public function edit() {
        $this->query = "UPDATE superheroes SET nombre= :nombre, imagen= :imagen, updated_at=CURRENT_TIMESTAMP WHERE id= :id";
        $this->parametros['nombre'] = $this->nombre;
        $this->parametros['imagen'] = $this->imagen;
        $this->get_results_from_query();
        $this->mensaje = 'SH editado correctamente';
    }

    public function delete() {
        $this->query = "DELETE FROM superheroes WHERE id = :id";
        $this->parametros['id'] = $this->id;
        $this->get_results_from_query();
        $this->mensaje = 'SH eliminado';
    }

    public function getLastSh($rowLimit) {
        $this->query = "SELECT superheroes.id AS 'idSuperheroe', superheroes.nombre, imagen, evolucion FROM `superheroes`
        ORDER BY superheroes.id DESC LIMIT $rowLimit;";

        $this->get_results_from_query();
        $this->mensaje = "SH obtenidos correctamente";
        return $this->rows;
    }

    public function getByNombre() {
        $nombre = "%" . $this->nombre . "%";
        $this->query = "SELECT superheroes.id AS 'idSuperheroe', superheroes.nombre, imagen, evolucion FROM `superheroes`
        WHERE superheroes.nombre LIKE :nombre";
        $this->parametros['nombre'] = $nombre;
        $this->get_results_from_query();
        return $this->rows;
        echo $this->mensaje = "SH obtenidos correctamente";
    }

    public function evolve() {
        $this->query = 'UPDATE superheroes SET evolucion="EXPERTO", updated_at=CURRENT_TIMESTAMP WHERE id= :id';
        $this->parametros['id'] = $this->id;
        $this->get_results_from_query();
        $this->mensaje = 'SH evolucionado correctamente';
    }
}
