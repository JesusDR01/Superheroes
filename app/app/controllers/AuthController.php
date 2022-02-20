<?php

namespace App\Controllers;

use App\Models\Superheroe;
use App\Models\Ciudadanos;
use App\Models\Usuarios;
use App\Services\FileUploadService;

class AuthController extends BaseController {
    public function LoginAction() {
        $data = array();
        $processForm = false;
        $data['usuario'] = $data['psw'] = NULL;
        if (!empty($_POST)) {
            $data['usuario'] = $_POST['usuario'] ?? null;
            $data['psw'] = $_POST['psw'] ?? null;
            $processForm = true;

            if (empty($_POST['usuario'])) {
                $processForm = false;
                $data['msgErrorUsuario'] = "El nombre de usuario no puede estar vacío";
            }

            if (empty($_POST['psw'])) {
                $processForm = false;
                $data['msgErrorPsw'] = "La contraseña no puede estar vacía";
            }
        }
        if ($processForm) {
            $usuario = Usuarios::getInstancia();
            $usuario->setUsuario($data["usuario"]);
            $usuario->setPassword($data["psw"]);
            $perfil = $usuario->getPerfil();
            if (isset($perfil)) {
                $_SESSION['perfil'] = $perfil;
                $_SESSION['idUsuario'] = $usuario->getId();
                $_SESSION['idSuperheroe'] = $usuario->getIdSuperheroe();
                $_SESSION['idCiudadano'] = $usuario->getIdCiudadano();
                header('Location:' . '/home');
            } else {
                $data['msgErrorUsuario'] = "El usuario no existe";
            }
        }
        $this->renderHTML('../views/login_view.php', $data);
    }

    public function RegisterAction() {
        $data = array();
        $processForm = false;
        $data['nombreCiudadano'] = $data['nombreSuperheroe'] = $data['usuarioSuperheroe'] = $data['usuarioCiudadano'] = $data['email'] = $data['psw'] = NULL;
        if (!empty($_POST)) {
            $data['usuarioCiudadano'] = $_POST['usuarioCiudadano'] ?? null;
            $data['usuarioSuperheroe'] = $_POST['usuarioSuperheroe'] ?? null;
            $data['psw'] = $_POST['psw'] ?? null;
            $data['email'] = $_POST['email'] ?? null;
            $data['nombreCiudadano'] = $_POST['nombreCiudadano'] ?? null;
            $data['nombreSuperheroe'] = $_POST['nombreSuperheroe'] ?? null;
            $data['imagen'] = isset($_POST['imagen']) ? $_POST['imagen'] : NULL;

            $processForm = true;

            if ((isset($_POST['ciudadano']) && empty($data['usuarioCiudadano'])) || (isset($_POST['superheroe']) && empty($data['usuarioSuperheroe']))) {
                $processForm = false;
                $data['msgErrorUsuario'] = "El nombre de usuario no puede estar vacío";
            }

            if (empty($data['psw'])) {
                $processForm = false;
                $data['msgErrorPsw'] = "La contraseña no puede estar vacía";
            }
            if ((isset($_POST['ciudadano']) && empty($data['nombreCiudadano'])) || (isset($_POST['superheroe']) && empty($data['nombreSuperheroe']))) {
                $processForm = false;
                $data['msgErrorNombre'] = "El nombre no puede estar vacío";
            }

            if (isset($_POST['ciudadano']) && empty($data['email'])) {
                $processForm = false;
                $data['msgErrorEmail'] = "El email no puede estar vacío";
            }
        }
        if ($processForm) {
            $usuario = Usuarios::getInstancia();
            $usuario->setUsuario($data['usuarioCiudadano'] ?? $data['usuarioSuperheroe']);
            $usuario->setPassword($data['psw']);
            
            if (count($usuario->get()) == 0) {
                
                if (isset($_POST['ciudadano'])) {
                    $usuario->set();
                    $_SESSION['idUsuario'] = $usuario->lastInsert();
                    $ciudadano = Ciudadanos::getInstancia();
                    $ciudadano->setNombre($data['nombreCiudadano']);
                    $ciudadano->setEmail($data['email']);
                    $ciudadano->setIdUsuario($_SESSION['idUsuario']);
                    $ciudadano->set();
                    $_SESSION['idSuperheroe'] = $usuario->getIdSuperheroe();
                    $_SESSION['idCiudadano'] = $usuario->getIdCiudadano();
                    $_SESSION['perfil'] = 'ciudadano';
                    header('Location:' . '/home');
                } else if (isset($_POST['superheroe'])) {
                    $superheroe = Superheroe::getInstancia();
                    $superheroe->setNombre($data['nombreSuperheroe']);
                    if (FileUploadService::saveImg($_FILES)){
                        $usuario->set();
                        $_SESSION['idUsuario'] = $usuario->lastInsert();
                        $superheroe->setImagen(FileUploadService::$uploadedFile);
                        $superheroe->setIdUsuario($_SESSION['idUsuario']);
                        $superheroe->set();
                        $_SESSION['idSuperheroe'] = $usuario->getIdSuperheroe();
                        $_SESSION['idCiudadano'] = $usuario->getIdCiudadano();
                        $_SESSION['perfil'] = 'superheroe';
                        header('Location:' . '/home');
                    }else{
                        $data['msgErrorImagen'] = "Error al subir la imagen, intenta reducir su tamaño.";
                    };
                } else {
                    $data['msgErrorInvalid'] = "Formulario incorrecto";
                }
            } else {
                $data['msgErrorExists'] = "Ese nombre de usuario ya existe";
            }
        }
        $this->renderHTML('../views/register_view.php', $data);
    }



    public function LogoutAction() {
        header('Location: /home');
        session_destroy();
    }

    public function InfoAction() {
        $data = array();
        if ($_SESSION['perfil'] == 'ciudadano'){
            $ciudadano = Ciudadanos::getInstancia();
            $ciudadano->setIdUsuario($_SESSION['idUsuario']);
            $data = $ciudadano->get();
        }else{
            $superheroe = Superheroe::getInstancia();
            $superheroe->setIdUsuario($_SESSION['idUsuario']);
            $data = $superheroe->getByUser();
        }
        $this->renderHTML('../views/info_view.php', $data);
    }
}
