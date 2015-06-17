<?php

require_once '../lib/Controller.php';
require_once '../lib/View.php';
require_once '../model/reporteasistencias.php';

class reporteasistenciasController extends Controller {

    public function index() { 
        
        
        $obj = new reporteasistencias();
        $data = array();
  
        $view = new View();
        $view->setData($data);
        $view->setTemplate('../view/reporteasistencias/_Index.php');
        $view->setLayout('../template/Layout.php');
        $view->render();
    }
    public function get(){
        $obj = new reporteasistencias();
        $obj->get_reporte_asistencias($_REQUEST);
        
        
    }


}

?>