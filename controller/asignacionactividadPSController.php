<?php

require_once '../lib/Controller.php';
require_once '../lib/View.php';
require_once '../model/asignacionactividadPS.php';

class asignacionactividadPSController extends Controller {

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
        $obj = new asignacionactividadPS();
        $semestre_ultimo = $this->mostrar_semestre_ultimo();
        $data = array();
        $data['data'] = $obj->index($_GET['q'], $_GET['p'], $_GET['criterio'], $semestre_ultimo, $_SESSION['idusuario']);
        $data['query'] = $_GET['q'];
        $data['pag'] = $this->Pagination2(array('rows' => $data['data']['rowspag'], 'url' => 'index.php?controller=asignacionactividadPS&action=index', 'query' => $_GET['q']));
        $cols = array("CODIGO", "TEMA EVENTO", "TIPO EVENTO", "Fecha");

        $data['grilla'] = $this->grilla("asignacionactividadPS", $cols, $data['data']['rows'], $opt, $data['pag'], false, false, false, false, true);


        $view = new View();
        $view->setData($data);
        $view->setTemplate('../view/asignacionactividadPS/_Index.php');
        $view->setLayout('../template/Layout3.php');
        $view->render();
    }

    public function lista_cursosxcursos() {
        $obj = new asignacionactividadPS();
        $main = new main();
        $data = array();
        $data['row'] = $obj->get_cursos($_REQUEST['curso_profesor'],$_REQUEST['idevento']);
        $view = new View();
        $view->setData($data);
        $view->setTemplate('../view/asignacionactividadPS/listado_cursos.php');
        echo $view->renderPartial();
    }

    public function actualizar_alumno() {
        $obj = new asignacionactividadPS();
        $obj->actualizar_Alumno($_REQUEST);
//        foreach ($_REQUEST['cargo_A']as $cargo){}
    }

    public function agregar_externo() {
        $obj = new asignacionactividadPS();
        $obj->agregar_exter($_REQUEST);
    }

    public function listado_alumnos_ps1() {
        $obj = new asignacionactividadPS();
        $data = array();
        $data['alumnosps'] = $obj->get_datos_alumnnos_PS($_REQUEST['idevento']);
        $selec_aluno=$data['alumnosps'];
        foreach ($selec_aluno as $key => $value){

            $data['cargoA'][$value['CodigoAlumno']] = $this->Select(array('id' => 'cargo_A', 'name' => 'cargo[]', 'table' => 'cargo_asistencia_evento', 'code' => $value['id_cargo']));
        
        }
//        $data['cargo'] = $this->Select_options(array('id' => 'id_cargo', 'name' => 'id_cargo', 'table' => 'cargo_asistencia_evento', 'code' => 3));
        $view = new View();
        $view->setData($data);
        $view->setTemplate('../view/asignacionactividadPS/listado_alumnos_ps.php');
        echo $view->renderPartial();
    }

    public function listado_exter_ps() {
        $obj = new asignacionactividadPS();
        $data = array();
//        $data['cargo'] = $this->Select_options(array('id' => 'id_cargo', 'name' => 'id_cargo', 'table' => 'cargo_asistencia_evento', 'code' => 3));
        $data['externos'] = $obj->get_datos_externo_PS();
        $ter=$data['externos'];
        foreach ($ter as $key => $value){
            $data['cargoE'][$value['id_externos']] = $this->Select(array('id' => 'cargo_'.$value['id_externos'], 'name' => 'cargote[]', 'table' => 'cargo_asistencia_evento', 'code' => $value['id_cargo']));
        }
        $view = new View();
        $view->setData($data);
        $view->setTemplate('../view/asignacionactividadPS/listado_externo_ps.php');
        echo $view->renderPartial();
    }

    public function asignaractividadPS() {
        $obj = new asignacionactividadPS();
        $main = new main();
        $data = array();
        $semestre_ultimo = $this->mostrar_semestre_ultimo();
        $facultad_pro=$obj->facultad_profesor($_SESSION['idusuario']);
        $tiene=$obj->detec_asignado($_REQUEST['idevento']);
//        print_r ($tiene);exit;
        $profes = $main->get_datos_profesores_por_facultad($_REQUEST['idevento'],$semestre_ultimo,$facultad_pro['CodigoDptoAcad']);
        $alumn=$obj->get_alum_fac($_REQUEST['idevento']);
        if(empty($tiene)){
            $obj->insert_profesor_ini($_REQUEST['idevento'],$profes);
            $obj->insertar_alumnos_ini($_REQUEST['idevento'], $alumn);
        }       
        $data['profesores'] = $main->get_datos_profesores_por_facultad($_REQUEST['idevento'],$semestre_ultimo,$facultad_pro['CodigoDptoAcad']);
        $prof_select=$data['profesores'];
          
        foreach ($prof_select as $key => $value){

            $data['cargo'][$value['CodigoProfesor']] = $this->Select(array('id' => 'cargo_'.$value['CodigoProfesor'], 'name' => 'cargo_[]', 'table' => 'cargo_asistencia_evento', 'code' => $value['id_cargo']));
        
        }
        
//        $data['cargo'] = $this->Select(array('id' => 'id_cargo', 'name' => 'id_cargo', 'table' => 'cargo_asistencia_evento', 'code' => 3));
        $data['alumnosps'] = $obj->get_datos_alumnnos_activi_PS($_REQUEST['idevento']);

        $alumno_selet=$data['alumnosps'];  
        foreach ($alumno_selet as $key => $value){
            $data['cargoA'][$value['CodigoAlumno']] = $this->Select(array('id' => 'cargo_A', 'name' => 'cargo[]', 'table' => 'cargo_asistencia_evento', 'code' => $value['id_cargo']));
        }
//        $data['profasig'] = $obj->get_prof_asignado($_REQUEST['idevento']);
        $data['externos'] = $obj->get_datos_externo_PS($_REQUEST['idevento']);
        $exter=$data['externos'];
        foreach ($exter as $key => $value){
            $data['cargoE'][$value['id_externos']] = $this->Select(array('id' => 'cargo_'.$value['id_externos'], 'name' => 'cargote[]', 'table' => 'cargo_asistencia_evento', 'code' => $value['id_cargo']));
        }
        $data['idevento'] = $_REQUEST['idevento'];
        $data['evento'] = $_REQUEST['evento'];
        $view = new View();
        $view->setData($data);
        $view->setTemplate('../view/asignacionactividadPS/asignacion_PS.php');
        echo $view->renderPartial();
    }

    public function lista_sub_evento() {
        $obj = new asignacionactividadPS();
        $data = array();
        $data['sub_evento'] = $obj->sub_evento($_REQUEST['idevento']);
        $view = new View();
        $view->setData($data);
        $view->setTemplate('../view/asignacionactividadPS/lista_sub_evento.php');
        echo $view->renderPartial();
    }

    public function save_externo() {
        $obj = new asignacionactividadPS();
        if ($_REQUEST['check'] == '1') {
            $inser = $obj->insetar_externo($_REQUEST);
        } else {
            $eliminar = $obj->eliminar_externo($_REQUEST['idevento'], $_REQUEST['id_externo']);
        }
    }
    
    public function save_profesor() {
        $obj = new asignacionactividadPS();
        $sem = $this->mostrar_semestre_ultimo();
        $obj->eliminar_docente($_REQUEST['cod_prof'], $_REQUEST['idevento']);
        $p = $obj->insert_profesor($_REQUEST);
    }

    public function save_profesor_alumno() {
        $obj = new asignacionactividadPS();
        $sem = $this->mostrar_semestre_ultimo();
        if ($_REQUEST['check'] == '1') {echo 'estoy chequeado';
            if (empty($_REQUEST['curso'])) { echo 'no tengo curso';
                        $obj->eliminar_docente($_REQUEST['cod_prof'], $_REQUEST['idevento']);
                    
                    if ($p[0]) {
                        if ($e[0]) {
                            
                        } else {
                            $data = array();
                            $view = new View();
                            $data['msg'] = $e[1];echo 'fallo maldicion';
                            $data['url'] = 'index.php?controller=asistenciaalumno';
                            $view->setData($data);
                            $view->setTemplate('../view/_Error_App.php');
                            $view->setLayout('../template/Layout.php');
                            $view->render();
                        }
                        header('Location: index.php?controller=asignacionactividadPS');
                    } else {
                        $data = array();
                        $view = new View();
                        $data['msg'] = $p[1];
                        $data['url'] = 'index.php?controller=asignacionactividadPS';
                        $view->setData($data);
                        $view->setTemplate('../view/_Error_App.php');
                        $view->setLayout('../template/Layout.php');
                        $view->render();
                    }
            } else {echo 'tengo curso';
                $obj->eliminar_docente($_REQUEST['cod_prof'], $_REQUEST['idevento']);
                $obj->eliminar_alumno($_REQUEST['cod_prof'], $_REQUEST['idevento']);
                $alumnos = $obj->get_alumnos($_REQUEST['cod_prof'], $_REQUEST['curso'], $sem);
                $p = $obj->insert_profesor($_REQUEST);
                $e = $obj->insertar_alumnos($_REQUEST, $alumnos);
                if ($p[0]) {
                    
                    if ($e[0]) {
                        
                    } else {
                        $data = array();
                        $view = new View();
                        $data['msg'] = $e[1];
                        $data['url'] = 'index.php?controller=asistenciaalumno';
                        $view->setData($data);
                        $view->setTemplate('../view/_Error_App.php');
                        $view->setLayout('../template/Layout.php');
                        $view->render();
                    }
                    header('Location: index.php?controller=asignacionactividadPS');
                } else {
                    $data = array();
                    $view = new View();
                    $data['msg'] = $p[1];
                    $data['url'] = 'index.php?controller=asignacionactividadPS';
                    $view->setData($data);
                    $view->setTemplate('../view/_Error_App.php');
                    $view->setLayout('../template/Layout.php');
                    $view->render();
                }
            }
        } else {echo 'no estoy chequeado';
            $obj->eliminar_docente($_REQUEST['cod_prof'], $_REQUEST['idevento']);
                $obj->eliminar_alumno($_REQUEST['cod_prof'], $_REQUEST['idevento']);
        }
    }

}

?>