<?php
namespace App\Controllers;

use App\Models\Superheroe;

class IndexController extends BaseController{
    
    public function IndexAction(){
        $data = array();
        $superheroe = Superheroe::getInstancia();
        $data = $superheroe->getLastSh(SHPORPAGINA);
        $this-> renderHTML('../views/index_view.php',$data);
    }

}

?>