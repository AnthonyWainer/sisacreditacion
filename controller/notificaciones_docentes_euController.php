<?php

require_once '../lib/Controller.php';
require_once '../lib/View.php';
require_once '../model/notificaciones_docentes_eu.php';
//require_once '../model/ubigeos.php';

class notificaciones_docentes_euController extends Controller {

    public function index() {

 $data['notificaciones_docentes_eu']=  $this->grilla_notificaciones_docentes_eu(); 
        $view = new View();
        $view->setData($data);
        $view->setTemplate('../view/notificaciones_docentes_eu/_Index.php');
        $view->setLayout('../template/Layout2.php');
        $view->render();
    }
    
    
 public  function Parametros ()
         {
           $envio=$this->Datos_grilla(array('filtro' => 'CodigoSemestre','criterio' => $_POST['CodigoSemestre']));      
                echo $envio ;
            
             
         }

  
    public function insertarDetalle_docentes_notificaciones() {
        $obj = new notificaciones_docentes_eu();
        $obj->InsertDet_docentes_notificaciones($_REQUEST);
        header('Location: index.php?controller=notificaciones_docentes_eu&action=index');
        $data = array();
        $view = new View();
        $view->setData($data);
        $view->setTemplate('../view/_Error_App.php');
        echo $view->renderPartial();
    }
   
    public function delete() {
        $obj = new evento_proyeccion_social();
        $p = $obj->delete($_GET['id']);
        if ($p[0]) {
            header('Location: index.php?controller=evento_proyeccion_social');
        } else {
            $data = array();
            $view = new View();
            $data['msg'] = $p[1];
            $data['url'] = 'index.php?controller=evento_proyeccion_social';
            $view->setData($data);
            $view->setTemplate('../view/_Error_App.php');
            $view->setLayout('../template/Layout.php');
            $view->render();
        }
    }

   

}

?>