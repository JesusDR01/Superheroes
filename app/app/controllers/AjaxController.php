<?php
namespace App\Controllers;

use App\Models\Superheroe;
use App\Models\Peticiones;

class AjaxController extends BaseController{
    
    public function AjaxAction(){
        $data = array();
        $superheroe = Superheroe::getInstancia();
        $superheroe->setNombre($_GET["nombre"]);
        if (!isset($_GET["nombre"])){
            $data = $superheroe->getLastSh(SHPORPAGINA);
        }else{
            $data = $superheroe->getByNombre();
        }
        $this-> renderHTML('../views/list_superheroes_view.php',$data);
    }

    public function AjaxRequestAction(){
        $data = array();
        $data = array();
        $peticion = Peticiones::getInstancia();
        $peticion->setTitulo($_GET["peticion"]);
        $peticion->setIdSuperheroe($_SESSION['idSuperheroe']);
        
        if (!isset($_GET["peticion"])){
            $data = $peticion->getLastRq(SHPORPAGINA);
        }else{
            $data = $peticion->getByNombre();
        }
        $this-> renderHTML('../views/list_requests_view.php',$data);
    }

}

?>