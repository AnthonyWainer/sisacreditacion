<?php
require_once '../lib/Controller.php';
require_once '../lib/View.php';
require_once '../model/notasproyecto.php';

class notasproyectoController extends Controller {    
    public function index() 
    {
        
//        if (!isset($_GET['p'])) {
//            $_GET['p'] = 1;
//        }
//        if (!isset($_GET['q'])) {
//            $_GET['q'] = "";
//        }
//        if (!isset($_GET['criterio'])) {
//            $_GET['criterio'] = "detalle_asignacion_tutoria.CodigoSemestre";
//        }
//         $obj = new asignaciontutoria();
//        $data = array();
//        $data['data'] = $obj->index($_GET['q'], $_GET['p'], $_GET['criterio']);
//        $data['query'] = $_GET['q'];
//        $data['pag'] = $this->Pagination(array('rows' => $data['data']['rowspag'], 'url' => 'index.php?controller=alumno&action=index', 'query' => $_GET['q']));
//        $cols = array("CODIGO", "Docente");
//         $opt = array("" => "------","CodigoSemestre" => "Semestre");
//          
//         $data['facultades'] = $this->Select(array('id' => 'CodigoFacultad', 'name' => 'CodigoFacultad', 'table' => 'facultades', 'code' => $obj->CodigoFacultad));
//         $data['semestreacademico'] = $this->SelectActual(array('id' => 'CodigoSemestre', 'name' => 'CodigoSemestre', 'table' => 'semestreacademico', 'code' => $obj->CodigoSemestre));
          $data['notasproyecto']=  $this->grilla_notasproyecto();  
//        $data['grilla'] = $this->grilla("asignaciontutoria", $cols, $data['data']['rows'], $data['pag'], false, false);
         
         $view = new View();
         
        $view->setData($data);
       
       
        
        
        $view->setTemplate('../view/notasproyecto/_Index.php');
       
        $view->setLayout('../template/blanco.php');
        
        $view->render();
    }
    
    public function edit() {
        $obj = new notasproyecto();
        $data = array();
        $view = new View();
        $obj = $obj->edit($_GET['id']);
        $data['obj'] = $obj;
        $data['notasproyectoPadres'] = $this->Select(array('id'=>'idpadre','name'=>'idpadre','table'=>'detalle_concepto_detproyecto','code'=>$obj->idpadre));
        $view->setData($data);
        $view->setTemplate( '../view/notasproyecto/_Form.php' );
        $view->setLayout( '../template/Layout.php' );
        $view->render();
    }
    public function save(){
        $obj = new notasproyecto();
        
            $p = $obj->insert($_POST);
            if ($p[0]){
                die("<script>alert()</script>");
              
            } else {
            $data = array();
            $view = new View();
            $data['msg'] = $p[1];
            $data['url'] =  'index.php?controller=notasproyecto';
            $view->setData($data);
            $view->setTemplate( '../view/_Error_App.php' );
            $view->setLayout( '../template/Layout.php' );
            $view->render();
            }
        
    }
    public function guardar(){
        $obj = new notasproyecto();
        $_POST['semestre']=  $this->mostrar_semestre_ultimo();
//        print_r($_POST); exit;
        $obj->insert($_POST);
        
    }
    public function actualizar(){
        $obj = new notasproyecto();
        $obj->actualiza($_POST);
        
    }
    public function Enviar_Notas_Finales(){
        $main=new Main();
        $main->criterio = $_REQUEST['idproyecto'];
        $alumnos=$main->getDatos_grilla_alumnos();
        $obj = new notasproyecto();
       $resp= $obj->Enviar_notas_finales($alumnos,$_REQUEST['idproyecto']);
        echo json_encode($resp);
        
    }
    public function delete(){
        $obj = new notasproyecto();
        $p = $obj->delete($_GET['id']);
        if ($p[0]){
            header('Location: index.php?controller=notasproyecto');
        } else {
        $data = array();
        $view = new View();
        $data['msg'] = $p[1];
        $data['url'] =  'index.php?controller=notasproyecto';
        $view->setData($data);
        $view->setTemplate( '../view/_Error_App.php' );
        $view->setLayout( '../template/Layout.php' );
        $view->render();
        }
    }
    public function create() {
        $data = array();
        $view = new View();
        $data['notasproyectoPadres'] = $this->Select(array('id'=>'idpadre','name'=>'idpadre','table'=>'vista_notasproyecto'));
        $view->setData($data);
        $view->setTemplate( '../view/notasproyecto/_Form.php' );
        $view->setLayout( '../template/Layout.php' );
        $view->render();
    }
    
    public function mostrar_alumnos_asignados() {
        if (!isset($_GET['p'])) {
            $_GET['p'] = 1;
        }
        if (!isset($_GET['q'])) {
            $_GET['q'] = "";
        }
        $CodigoAlumno=$_GET['codalum'];$idproyecto=$_GET['idproy'];$NombreAlumno=$_GET['nomalum'];
        $obj = new notasproyecto();
        $data = array();
        $data['data'] = $obj->alumnos_asignados($_GET['q'], $_GET['p'],$CodigoAlumno,$idproyecto,$NombreAlumno);
        $data['query'] = $_GET['q'];
        $data['pag'] = $this->Pagination2(array('rows' => $data['data']['rowspag'], 'url' => 'index.php?controller=asignaciontutoria&action=index', 'query' => $_GET['q']));
        $cols = array("CODIGO", "Nombre", "Apellidos", "Documentos", "Fecha Ingreso", "CodAlumnoSira");
        $data['grilla'] = $this->grilla("alumno", $cols, $data['data']['rows'], $opt, $data['pag'], false, false, false, false);


        $view = new View();
        $view->setData($data);
        $view->setTemplate('../view/notasproyecto.php');
        $view->setLayout('../template/List.php');
        $view->render();
    }
   
}
?>
