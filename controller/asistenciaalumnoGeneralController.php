<?php

require_once '../lib/Controller.php';
require_once '../lib/View.php';
require_once '../model/asistenciaalumnoGeneral.php';


class asistenciaalumnoGeneralController extends Controller {

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

        $obj = new asistenciaalumnoGeneral();
        $semestre_ultimo = $this->mostrar_semestre_ultimo();
        $data = array();
        $data['data'] = $obj->index($_GET['q'], $_GET['p'], $_GET['criterio'],$semestre_ultimo);
        $data['query'] = $_GET['q'];
        $data['pag'] = $this->Pagination(array('rows' => $data['data']['rowspag'], 'url' => 'index.php?controller=asistenciaalumnoGeneral&action=index', 'query' => $_GET['q']));
        $cols = array("CODIGO", "TEMA", "TIPO EVENTO", "Fecha");

        $data['grilla'] = $this->grilla("asistenciaalumnoGeneral", $cols, $data['data']['rows'], $opt, $data['pag'], false,false,false,false,true);
        
      
        $view = new View();
        $view->setData($data);
        $view->setTemplate('../view/asistenciaalumnoGeneral/_Index.php');
        $view->setLayout('../template/Layout3.php');
        $view->render();
        
     
    }
    public function lista_alumnosf_tutoria() {
        $idevento=$_REQUEST['idevento'];
        $obj = new asistenciaalumnoGeneral();
        $idfacultad = $obj->mostrar_Facultad_idUsusario($_SESSION['idusuario']);
        $sem = $obj->mostrar_semestre_ultimo();
        $detector_prof=$obj->profesores_activo($idevento,$sem,$idfacultad['depfac']);
        $data = array();
    foreach ($detector_prof as $key=>$value){
            $detec_prof=$obj->detectando_profe($idevento,$value['CodigoProfesor']);
            if(empty($detec_prof)){
                $alumnos_profe=$obj->alumnos_de_prof($sem,$value['CodigoProfesor']);
                $llenar=$obj->insert($idevento,$value['CodigoProfesor'],$alumnos_profe);
            }
        }
        $data['lista_alumno'] =$obj->lista_alumnos($idevento,$sem);
        $data['semestre']=$sem;
        $data['idevento']=$idevento;
        $data['evento']=$_REQUEST['evento'];
        $view = new View();
        $view->setData($data);
        $view->setTemplate('../view/asistenciaalumnoGeneral/_Lista2.php');
//        $view->setLayout('../template/Vacia.php');
        echo $view->renderPartial();
    }
     public function save() {
     $obj = new asistenciaalumnoGeneral();
            $p = $obj->update($_REQUEST['idevento'],$_REQUEST['codigoalumno'],$_SESSION['idusuario'],$_REQUEST['asistencia']);
        
        if ($p[0]) {
                 die("<script> window.location='index.php?controller=asistenciaalumnoGeneral'; </script>");
        } else {
            $data = array();
            $view = new View();
            $data['msg'] = $p[1];
            $data['url'] = 'index.php?controller=asistenciaalumnoGeneral';
            $view->setData($data);
            $view->setTemplate('../view/_Error_App.php');
            $view->setLayout('../template/Layout3.php');
            $view->render();
        }
        }

  
  
           
            

}

?>