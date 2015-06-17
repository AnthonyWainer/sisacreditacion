<?php

require_once '../lib/Controller.php';
require_once '../lib/View.php';
require_once '../model/asignaciontutoria.php';

class asignaciontutoriaController extends Controller {

    public function index() {
        $obj = new asignaciontutoria();
        $idfacultad = $obj->mostrar_Facultad_idUsusario($_SESSION['idusuario']);
        $data['semestreacademico'] = $this->cinco_ultimos_semestres(array('id' => 'CodigoSemestre', 'name' => 'CodigoSemestre', 'table' => 'semestreacademico', 'code' => $this->mostrar_semestre_ultimo()));
        $data['idfacultad']=$idfacultad;
        $view = new View();
        $view->setData($data);  
        $view->setTemplate('../view/asignaciontutoria/_Index.php');

        $view->setLayout('../template/Layout.php');

        $view->render();
    }
    public function edit(){
      $obj = new asignaciontutoria();
        $data=array();
        $sem = $obj->mostrar_semestre_ultimo();
        $data['rows']=$obj->edit_asignados($_POST['CodigoProfesor'],$sem);
        $view = new View();
        $view->setData($data);  
        $view->setTemplate('../view/asignaciontutoria/_lista_editar.php');
        $view->setLayout('../template/Vacia.php');
        $view->render();
    }

    public function asignar_estado_temporal_asignacion() {
        $obj = new asignaciontutoria();
        $p = $obj->asignar_estado_temporal_asignacion($_POST);//va a hacer una consulta en model asignaciontutoria 
        if ($p[0]) {
                echo "ok";
            } else {
                $data = array();
                $view = new View();
                $data['msg'] = $p[1];
                $data['url'] = 'index.php?controller=asignaciontutoria';
                $view->setData($data);
                $view->setTemplate('../view/_Error_App.php');
                echo $view->renderPartial();
            }
    }

public function save() { 
        $obj = new asignaciontutoria();
        $sem = $obj->mostrar_semestre_ultimo();
        $obj->vaciar($_POST,$sem);
        $p = $obj->insert($_POST,$sem);
        $obj->vaciar_estado_chek_asignacion_tutoria();
        
        if ($p[0]) {
            die("<script> window.location='index.php?controller=asignaciontutoria'; </script>");
        } else {
            $data = array();
            $view = new View();
            $data['msg'] = $p[1];
            $data['url'] = 'index.php?controller=asignaciontutoria';
            $view->setData($data);
            $view->setTemplate('../view/_Error_App.php');
            $view->setLayout('../template/Layout.php');
            $view->render();
        }
    }

    public function Parametros_facultad() {
        $obj = new asignaciontutoria();
        $semestre = $obj->mostrar_semestre_ultimo();
        $semestre2=$semestre;
        $idfacultad = $obj->mostrar_Facultad_idUsusario($_SESSION['idusuario']);
        $idsemestre=$_POST['sem'];    
        
        if(!empty($idsemestre)){$semestre=$idsemestre;$modovista=true; }
        else{$modovista=false;}
        if($semestre2==$idsemestre){$modovista=false;}        
        
        $envio = $this->Datos_grilla_facultad(array('filtro' => 'CodigoFacultad', 'criterio' => $idfacultad, 'filtro2' => 'CodigoSemestre', 'criterio2' => $semestre,'modovista'=>$modovista,'idfacultad'=>$idfacultad));
        echo $envio;
    }
    
    

    public function mostrarLupa() {
        $obj = new asignaciontutoria();
        $idfacultad = $obj->mostrar_Facultad_idUsusario($_SESSION['idusuario']);
        echo " <a title='Buscar Alumno'   name='CodigoProfesor' id='CodigoProfesor' style='cursor:pointer;' onclick='mostrar_alumnos(\"$idfacultad\");' ><img src='images/lupa.gif'/></a><br>";
        $view = new View();
        $view->setTemplate('../view/asignaciontutoria/_Index.php');
    }

    public function mostrar_alumnos_asignados() {
        
        if (!isset($_GET['p'])) {
            $_GET['p'] = 1;
        }
        if (!isset($_GET['q'])) {
            $_GET['q'] = "";
        }
        $CodigoProfesor=$_GET['CodigoProfesor'];
        $obj = new asignaciontutoria();
        $sem = $obj->mostrar_semestre_ultimo();
        $semestre=$_GET['sem']; 
        if(!empty($semestre)){$sem=$semestre;}
        
        $data = array();
        if(empty($CodigoProfesor)){ $CodigoProfesor=$_POST['CodigoProfesor'];$data['List_sin_cabecera']=true;}
        $lista=$data['data'] = $obj->alumnos_asignados($_GET['q'], $_GET['p'],$CodigoProfesor,$sem);
        $data['catidadalumnos']=count($lista['rows']);
        $data['query'] = $_GET['q'];
        $data['pag'] = $this->PaginationPOST2(array('rows' => $data['data']['rowspag'], 'url' => 'index.php?controller=asignaciontutoria&action=mostrar_alumnos_asignados', 'query' => $_GET['q']));
        $cols = array("CODIGO", "Nombre", "Apellidos", "Documentos", "Fecha Ingreso", "CodAlumnoSira");
        $data['grilla'] = $this->grilla("alumno", $cols, $data['data']['rows'], $opt, $data['pag'], false, false, false, false);

        $data['semestre']=$sem;
        $view = new View();
        $view->setData($data);
        
        $view->setTemplate('../view/asignaciontutoria/_Lista.php');
        $view->setLayout('../template/List.php');
        $view->render();
    }
    public function mostrar_alumnos_asignados_template_vacio() {
        
        if (!isset($_GET['p'])) {
            $_GET['p'] = 1;
        }
        if (!isset($_GET['q'])) {
            $_GET['q'] = "";
        }
        $idevento=$_POST['idevento'];
        $CodigoProfesor=$_SESSION['idusuario'];
        $obj = new asignaciontutoria();
        $sem = $obj->mostrar_semestre_ultimo();
        $chekeos=array();
        $chekeos = $obj->devolver_asistencias($_GET['q'], $_GET['p'],$CodigoProfesor,$idevento);
        $data = array();
        $lista=$data['data'] = $obj->alumnos_asignados_asistencias($_GET['q'], $_GET['p'],$CodigoProfesor,$sem,$idevento);
        $data['query'] = $_GET['q'];
        $data['pag'] = $this->Pagination2(array('rows' => $data['data']['rowspag'], 'url' => 'index.php?controller=asignaciontutoria&action=mostrar_alumnos_asignados_template_vacio', 'query' => $_GET['q']));
        $cols = array("CODIGO", "Nombre", "Apellidos", "Documentos", "Fecha Ingreso", "CodAlumnoSira");
        $data['grilla'] = $this->grilla("alumno", $cols, $data['data']['rows'], $opt, $data['pag'], false, false, false, false,false,true);

        $data['semestre']=$sem;
        $data['control']=$chekeos;
        $data['lista']=$lista;
        $view = new View();
        $view->setData($data);
        $view->setTemplate('../view/asignaciontutoria/_Lista2.php');
        $view->setLayout('../template/Vacia.php');
        $view->render();
    }
    
}

?>