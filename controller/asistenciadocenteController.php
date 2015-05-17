<?php

require_once '../lib/Controller.php';
require_once '../lib/View.php';
require_once '../model/asistenciadocente.php';


class asistenciadocenteController extends Controller {

    public function index() { 
        if (!isset($_GET['p'])) {
            $_GET['p'] = 1;
        }
        if (!isset($_GET['q'])) {
            $_GET['q'] = "";
        }
        if (!isset($_GET['criterio'])) {
            $_GET['criterio'] = "evento.tema";
        }

        $obj = new asistenciadocente();
        $semestre_ultimo = $this->mostrar_semestre_ultimo();
        $data = array();
        $data['data'] = $obj->index($_GET['q'], $_GET['p'], $_GET['criterio'],$semestre_ultimo);
        $data['query'] = $_GET['q'];
        $data['pag'] = $this->Pagination(array('rows' => $data['data']['rowspag'], 'url' => 'index.php?controller=asistenciadocente&action=index', 'query' => $_GET['q']));
        $cols = array("CODIGO", "TEMA", "TIPO EVENTO", "Fecha");

        $data['grilla'] = $this->grilla("asistenciadocente", $cols, $data['data']['rows'], $opt, $data['pag'], false,false,false,false,true);
        
      
        $view = new View();
        $view->setData($data);
        $view->setTemplate('../view/asistenciadocente/_Index.php');
        $view->setLayout('../template/Layout3.php');
        $view->render();
        
     
    }
    public function mostrar_lista_docentes_tutoria() {        
        $idevento=$_REQUEST['idevento'];
        $obj = new asistenciadocente();
        $idfacultad = $obj->mostrar_Facultad_idUsusario($_SESSION['idusuario']);
        $sem = $obj->mostrar_semestre_ultimo();
        $detector=$obj->detector_de_evento($idevento);
        $data = array();
        if(empty($detector)){
            $docente_a=$obj->profesores_acti($idfacultad['depfac'],$sem);
            $insertar=$obj->insert($docente_a,$idevento);
        }
        $data['lista_docente'] = $obj->docentes_asignados($idfacultad['depfac'],$sem,$idevento);
        $data['semestre']=$sem;
        $data['idevento']=$_REQUEST['idevento'];
        $data['evento']=$_REQUEST['evento'];
        $view = new View();
        $view->setData($data);
        $view->setTemplate('../view/asistenciadocente/_Lista2.php');
//        $view->setLayout('../template/Vacia.php');
        echo $view->renderPartial();
    }
     public function save() {
     $obj = new asistenciadocente();
            $p = $obj->update($_REQUEST['idevento'],$_REQUEST['codigoalumno'],$_REQUEST['asistencia']);
        
        if ($p[0]) {
                 die("<script> window.location='index.php?controller=asistenciadocente'; </script>");
        } else {
            $data = array();
            $view = new View();
            $data['msg'] = $p[1];
            $data['url'] = 'index.php?controller=asistenciadocente';
            $view->setData($data);
            $view->setTemplate('../view/_Error_App.php');
            $view->setLayout('../template/Layout3.php');
            $view->render();
        }
        }

  
  
           
            

}

?>