<?php

require_once '../lib/Controller.php';
require_once '../lib/View.php';
require_once '../model/notificaciones_alumnos_ps.php';
//require_once '../model/ubigeos.php';

class notificaciones_alumnos_psController extends Controller {

    public function index() {
//        if (!isset($_GET['p'])) {
//            $_GET['p'] = 1;
//        }
//        if (!isset($_GET['q'])) {
//            $_GET['q'] = "";
//        }
//        if (!isset($_GET['criterio'])) {
//            $_GET['criterio'] = "idevento";
//        }
//        $obj = new notificaciones_alumnos_ps();
//        $data = array();
//        $datos = $data['data'] = $obj->index($_GET['q'], $_GET['p'], $_GET['criterio']);
//        $data['query'] = $_GET['q'];
//        $data['pag'] = $this->Pagination(array('rows' => $data['data']['rowspag'], 'url' => 'index.php?controller=notificaciones_alumnos_ps&action=index', 'query' => $_GET['q']));
//
//        $cols = array("CODIGO", "TEMA DE EVENTO", "TIPO", "estado", "mensaje del docente");
////,"UNIRSE" 
 $data['notificaciones_alumnos_ps']=  $this->grilla_notificaciones_alumnos_ps(); 
////        $opt = array("evento_proyeccion_social.DescripcionTipoColegio" => "Tema");
//        $data['grilla'] = $this->grilla_E_PS_EU("evento_proyeccion_social", $cols, $data['data']['rows'], $opt, $data['pag'], false, true, false, false,false,false);
        $view = new View();
        $view->setData($data);
        $view->setTemplate('../view/notificaciones_alumnos_ps/_Index.php');
        $view->setLayout('../template/Layout2.php');
        $view->render();
    }
    
    
 public  function Parametros ()
         {
           $envio=$this->Datos_grilla(array('filtro' => 'CodigoSemestre','criterio' => $_POST['CodigoSemestre']));      
                echo $envio ;
            
             
         }

    
    public function insertarDetalle_alumnos_notificaciones() {
        $obj = new notificaciones_alumno_ps();
        $obj->InsertDet_alumnos_notificaciones($_REQUEST);
        header('Location: index.php?controller=notificaciones_alumnos_ps&action=index');
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