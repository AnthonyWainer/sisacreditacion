<?php

require_once '../lib/Controller.php';
require_once '../lib/View.php';
require_once '../model/asistenciaalumno.php';

class asistenciaalumnoController extends Controller {

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

        $obj = new asistenciaalumno();
        $semestre_ultimo = $this->mostrar_semestre_ultimo();
        $data = array();
        $data['data'] = $obj->index($_GET['q'], $_GET['p'], $_GET['criterio'], $semestre_ultimo,$_SESSION['idusuario']);
        $data['query'] = $_GET['q'];
        $data['pag'] = $this->Pagination2(array('rows' => $data['data']['rowspag'], 'url' => 'index.php?controller=asistenciaalumno&action=index', 'query' => $_GET['q']));
        $cols = array("CODIGO", "TEMA", "TIPO EVENTO", "Fecha");

        $data['grilla'] = $this->grilla("asistenciaalumno", $cols, $data['data']['rows'], $opt, $data['pag'], false, false, false, false, true);


        $view = new View();
        $view->setData($data);
        $view->setTemplate('../view/asistenciaalumno/_Index.php');
        $view->setLayout('../template/Layout3.php');
        $view->render();
    }
    public function nota_de_tutoria(){
       $CodAlumnoSira="097174";//solo este es para ingresar de lennon       
       $CodigoAlumno = "";
       $CodigoSemestre = '20150';
       $nota = $this->mostrar_nota_tutoria(array('CodAlumnoSira' => $CodAlumnoSira,'CodigoAlumno'=>$CodigoAlumno,'CodigoSemestre'=>$CodigoSemestres));
        echo "Tu Nota Es : ".$nota;
    }

    public function save() {
        $obj = new asistenciaalumno();
        
            $p = $obj->update($_REQUEST['idevento'],$_REQUEST['codigoalumno'],$_SESSION['idusuario'],$_REQUEST['asistencia']);
            if ($p[0]) {
                    print_r(json_encode(array("resp"=>1,"msg"=>"se inserto correctamente las asistencias")));
              
            } else {
                $data = array();
                $view = new View();
                $data['msg'] = $p[1];
                $data['url'] = 'index.php?controller=asistenciaalumno';
                $view->setData($data);
                $view->setTemplate('../view/_Error_App.php');
                $view->setLayout('../template/Layout3.php');
                $view->render();
            }
            
    }
    
    public function mostrar_alumnos(){
        $obj = new asistenciaalumno();
        $data = array();
        $semestre_ultimo = $this->mostrar_semestre_ultimo();
        $detector=$obj->detectando($_REQUEST['idevento'],$_SESSION['idusuario']);
        
        if(empty($detector)){
        $datos_alumnos=$obj->alumnos_de_profe($semestre_ultimo,$_SESSION['idusuario']);
        $llenar=$obj->insert($_REQUEST['idevento'],$_SESSION['idusuario'],$datos_alumnos);
        }
        $data['alumno_evento']=$obj->lista_alumnos($_REQUEST['idevento'],$_SESSION['idusuario'],$semestre_ultimo);
        $data['idevento']=$_REQUEST['idevento'];
        $view = new View();
        $view->setData($data);
        $view->setTemplate('../view/asistenciaalumno/lista_alumnos_asistencia.php');
        echo $view->renderPartial();
    }

}

?>