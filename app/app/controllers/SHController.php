<?php

namespace App\Controllers;

use App\Models\Superheroe;
use App\Models\Habilidad;
use App\Models\SuperheroeHabilidad;
use App\Models\Ciudadanos;
use App\Models\Peticiones;
use App\Services\FileUploadService;

class SHController extends BaseController {

    public function AddAction() {
        $processForm = false;
        $data = array();
        $data['nombre'] = $data['idUsuario'] = $data['evolucion'] = NULL;
        if (!empty($_POST)) {
            $data['nombre'] = $_POST['nombre'];
            $data['idUsuario'] = $_POST['idUsuario'];
            $processForm = true;

            if (empty($_POST['idUsuario'])) {
                $processForm = false;
                $data['msgErrorIdUsuario'] = "Error de autentificación";
            }

            if (empty($_POST['nombre'])) {
                $processForm = false;
                $data['msgErrorNombre'] = "El nombre no puede estar vacío";
            }
        }
        if ($processForm) {
            $superheroe = Superheroe::getInstancia();
            $superheroe->setNombre($data["nombre"]);
            if (FileUploadService::saveImg($_FILES)){
                $superheroe->setImagen(FileUploadService::$uploadedFile);
                $superheroe->setIdUsuario($data["idUsuario"]);
                $superheroe->set();
                header('Location:' . '/home');
            }else{
                $data['msgErrorImagen'] = "Error al subir la imagen, intenta reducir su tamaño.";
            };
        }
        $this->renderHTML('../views/addSuperheroe_view.php', $data);
    }


    public function DelAction($request) {
        $elementos = explode('/', $request);
        $id = end($elementos);
        $superheroe = Superheroe::getInstancia();
        $superheroe->setId($id);
        $superheroe->delete();
        header('Location:' . '/home');
    }


    public function EditAction($request) {
        $data = array();
        $elementos = explode('/', $request);
        $data['id'] = end($elementos);
        $superheroe = Superheroe::getInstancia();
        ['nombre' => $nombre, 'imagen' => $imagen] = $superheroe->get($data['id'])[0];
        $data['nombre'] = $nombre;
        $data['imagen'] = $imagen;
        if (!empty($_POST)) {
            if (isset($_POST['nombre'])) $data['nombre'] = $_POST['nombre'];
            $data['imagen'] = strlen($_POST['imagen'] > 0) ? $_POST['imagen'] : NULL;
            $nombre = $_POST['nombre'] ?? $nombre;
            $superheroe->setId($data['id']);
            $superheroe->setNombre($nombre);
            $superheroe->setImagen($data['imagen']);
            $superheroe->edit();
        }
        $this->renderHTML('../views/editSuperheroe_view.php', $data);
    }

    public function AddSkillAction($request) {
        $processForm = false;
        $data = array();
        $data['nombre'] = $data['valor'] = NULL;
        $elementos = explode('/', $request);
        $data['idSuperheroe'] = end($elementos);
        $data['nombreSuperheroe'] = Superheroe::getInstancia()->get($data['idSuperheroe'])[0]['nombre'];
        if (!empty($_POST)) {
            $data['nombre'] = $_POST['nombre'];
            $data['valor'] = $_POST['valor'];
            $processForm = true;
            if (empty($_POST['nombre'])) {
                $processForm = false;
                $data['msgErrorNombre'] = "El nombre no puede estar vacío";
            }
            if (empty($_POST['valor'])) {
                $processForm = false;
                $data['msgErrorValor'] = "El valor no puede estar vacío";
            }
        }
        if ($processForm) {
            $habilidad = Habilidad::getInstancia();
            $habilidad->setNombre($data["nombre"]);
            $habilidad->set();
            $superheroe_habilidad = SuperheroeHabilidad::getInstancia();
            $superheroe_habilidad->setIdSuperheroe($data["idSuperheroe"]);

            $superheroe_habilidad->setIdHabilidad($habilidad->getId());
            $superheroe_habilidad->setValor($data["valor"]);
            $superheroe_habilidad->set();
            header('Location:' . '/home');
        }

        $this->renderHTML('../views/addSkills_view.php', $data);
    }

    public function AddRequestAction($request) {
        if (!isset($_SESSION['idCiudadano'])) {
            $ciudadano = Ciudadanos::getInstancia();
            $ciudadano->setIdUsuario($_SESSION['idUsuario']);
            $_SESSION['idCiudadano'] = $ciudadano->get()[0]['id'];
        }
        $processForm = false;
        $data = array();


        $elementos = explode('/', $request);
        $data['titulo'] = $data['descripcion'] = NULL;
        $data['idSuperheroe'] = end($elementos);
        $superheroe = Superheroe::getInstancia();
        $data['nombreSuperheroe'] = $superheroe->get($data['idSuperheroe'])[0]["nombre"];

        if (!empty($_POST)) {
            $data['titulo'] = $_POST['titulo'];
            $data['descripcion'] = $_POST['descripcion'];
            $processForm = true;
            if (empty($_POST['titulo'])) {
                $processForm = false;
                $data['msgErrorTitulo'] = "El título no puede estar vacío";
            }
            if (empty($_POST['descripcion'])) {
                $processForm = false;
                $data['msgErrorDescripcion'] = "La descripción no puede estar vacía";
            }
        }
        if ($processForm) {
            $peticion = Peticiones::getInstancia();
            $peticion->setTitulo($data["titulo"]);
            $peticion->setDescripcion($data["descripcion"]);
            $peticion->setIdSuperheroe($data["idSuperheroe"]);
            $peticion->setIdCiudadano($_SESSION['idCiudadano']);
            $peticion->set();
            $data['msgSuccess'] = "Petición enviada correctamente";
        }

        $this->renderHTML('../views/addRequest_view.php', $data);
    }

    public function ListRequestsAction($request) {

        $data = array();
        $peticion = Peticiones::getInstancia();
        $peticion->setIdSuperheroe($_SESSION['idSuperheroe']);
        $data = $peticion->getLastRq(SHPORPAGINA);

        $this->renderHTML('../views/requests_view.php', $data);
    }
    public function CompleteRequestAction($request) {
        $data = array();
        $elementos = explode('/', $request);
        $data['id'] = end($elementos);
        $peticion = Peticiones::getInstancia();
        $peticion->setId($data['id']);
        $peticion->setIdSuperheroe($_SESSION['idSuperheroe']);
        $peticion->markAsCompleted();
        if ($_SESSION['perfil'] == 'superheroe') {
            //Check if the superhero has evolved;
            if ($peticion->superheroEvolved()) {
                $superheroe = Superheroe::getInstancia();
                $superheroe->setId($_SESSION['idSuperheroe']);
                $superheroe->evolve();
                $_SESSION['perfil'] = 'experto';
            };
        }
        header('Location:' . '/superheroes/listRequests');
    }

    public function ListSkillsAction($request) {
        $data = array();
        $superheroe = Superheroe::getInstancia();
        $superheroe->setId($_SESSION['idSuperheroe']);
        $data = $superheroe->getHabilidades();
        $this->renderHTML('../views/skills_view.php', $data);
    }

    public function ModifySkillAction($request) {
        $data = array();
        $elementos = explode('/', $request);
        $data['idHabilidad'] = end($elementos);

        if (!empty($_POST)) {
            $data['nombre'] = $_POST['nombre'];
            $data['valor'] = $_POST['valor'];
            $processForm = true;
            if (empty($_POST['nombre'])) {
                $processForm = false;
            }
            if (empty($_POST['valor'])) {
                $processForm = false;
            }
        }
        if ($processForm) {
            $superheroeHabilidad = SuperheroeHabilidad::getInstancia();
            $habilidad = Habilidad::getInstancia();
            $habilidad->setId($data['idHabilidad']);
            $habilidad->setNombre($data['nombre']);
            $habilidad->edit();
            $superheroeHabilidad->setIdSuperheroe($_SESSION['idSuperheroe']);
            $superheroeHabilidad->setIdHabilidad($data['idHabilidad']);
            $superheroeHabilidad->setValor($data['valor']);
            $superheroeHabilidad->edit();
        }

        $superheroe = Superheroe::getInstancia();
        $superheroe->setId($_SESSION['idSuperheroe']);
        $data = $superheroe->getHabilidades();

        $this->renderHTML('../views/skills_view.php', $data);
    }
}
