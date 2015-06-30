<?php

require_once '../lib/Controller.php';
require_once '../lib/View.php';
require_once '../model/alumno.php';
require_once '../model/silabus.php';
require_once '../model/tema.php';
require_once '../model/calificacion.php';
require_once '../model/bibliografia.php';
require_once '../model/unidad.php';
require_once '../model/evaluacion.php';


class cursosemestreController extends Controller {

    public function index() {

        $data = array();
        $data['semestreacademico'] = $this->SelectD(array('id' => 'semestreacademico', 'name' =>'semestreacademico','filtro'=>$_SESSION['idusuario']));
        // die($_SESSION['idusuario']);
        $view = new View();
        $view->setData($data);
        $view->setTemplate('../view/cursosemestre/_Index.php');
        $view->setLayout('../template/Layout.php');
        $view->render();
    }

    public function  generarsilabo(){
       $codsemestre=$_GET["CodSemestre"];
        $codcurso= $_GET["CodCurso"];
       $codsilabo=$_GET["CodSilabo"];
       $envio = $this->genSilabo(array('filtro' => $codsemestre,'filtro1' =>$codcurso,'filtro2'=> $codsilabo));
       echo $envio;
    }
    
    public function getCursosD()
       {
        $envio=$this->lista_recibir_D(array('filtro1' => 'CodigoSemestre','filtro' =>'CodigoProfesor','criterio' => $_POST['CodigoSemestre'],'criterio1' => $_SESSION['idusuario']));      
        echo $envio ;
//            echo $_SESSION['idusuario'];
//             echo $_POST['CodigoSemestre'];
            
       }
    
       public function getListaA ()
       {
        $codcurso=$_POST["idcurso"];
        $codsemestre= $_POST["idSemestre"];
       $opt=$_POST["opcion"];
        $envio=$this->Lista_recibir_A(array('filtro' => 'CodigoCurso','filtro1' =>'CodigoSemestre','criterio' => $codcurso,'criterio1' => $codsemestre,'opcion'=>$opt));      
//        echo $codcurso;
//        echo $codsemestre;
      echo $envio;
        
       }
       
//       public function getNcurso ()
//       {
//        $codcurso=$_POST["Codigo"];
//        
//        
//        $envio=$this->Nombre_curso(array('filtro' => 'CodigoCurso','criterio' => $codcurso));      
//            
//      echo $envio;
//        
//       }
       
       public function getListaA2 ()
       {
        $codcurso=$_POST["Codigo"];
        $codsemestre= $_POST["idSemestre"];
        
        $envio=$this->Lista_recibir_A2(array('filtro' => 'CodigoCurso','filtro1' =>'CodigoSemestre','criterio' => $codcurso,'criterio1' => $codsemestre));      
//        echo $codcurso;
//        echo $codsemestre;
      echo $envio;
        
       }
       public function  getCalificaciones()
        {
           $semestre=$_POST["idsemestre"];
           $curso=$_POST["idcurso"];
           $alumno=$_POST["idalumno"];
           $envio=$this->Lista_notas(array('criterio' => $curso,'criterio1' =>$semestre, 'criterio2' =>$alumno));      
       
        echo $envio;
           
        }
       public function getSillabysD()
       {
        $codcurso=$_POST["Codigo"];
        $codsemestre=$_POST["idSemestre"];
        
        $envio=$this->Syllabus_P(array('filtro' => 'CodigoCurso','filtro1' =>'CodigoSemestre','criterio' => $codcurso,'criterio1' => $codsemestre));      
//        echo $codcurso;
//        echo $codsemestre;
      echo $envio;
      }
             
       
         public function getEdiSillabus()
       {
        
        //print_r($_POST);exit();
        $codcurso=$_POST["Codigo"];
        $codsemestre=$_POST["codemestre"];
        
        $envio=$this->detalle_silabus(array('filtro' => 'CodigoCurso','filtro1' =>'CodigoSemestre','criterio0' => $codcurso,'criterio1' => $codsemestre));      
//        echo $codcurso;
//        echo $codsemestre;
       
        echo $envio;
        
       }
      public function getEdiSillabusBiblio(){
        //print_r($_POST);exit();
        //$codSilabo=$_POST["silabo"];
        $codSilabo=1;
        $envio=$this->bibliografia_silabus(array('criterio22' => $codSilabo));   
//        echo $codcurso;
//        echo $codsemestre;
               
        echo $envio;
       }
       
       public function getUnidad ()
       {
        $codcurso=$_POST["CodigoCurso"];
        $codsemestre= $_POST["idSemestre"];
        $opt=$_POST['sin'];
        
        $envio=$this->unidad_recibir(array('filtro' => 'CodigoCurso','filtro1' =>'CodigoSemestre','criterio' => $codcurso,'criterio1' => $codsemestre,'option' => $opt));      
       
        echo $envio;
        
       }
        public function getUni ()
       {
        $codcurso=$_POST["CodigoCurso"];
        $codsemestre= $_POST["idSemestre"];
        $opt=$_POST['sin'];
        
        $envio=$this->unidad_recibirU(array('filtro' => 'CodigoCurso','filtro1' =>'CodigoSemestre','criterio' => $codcurso,'criterio1' => $codsemestre,'option' => $opt));      
       
        echo $envio;
        
       }      
       
       
       public function getUnidadF ()
       {
        $codcurso=$_POST["CodigoCurso"];
        $codsemestre= $_POST["idSemestre"];
        $opt="A";
        
        $envio=$this->unidad_recibir(array('filtro' => 'CodigoCurso','filtro1' =>'CodigoSemestre','criterio' => $codcurso,'criterio1' => $codsemestre,'option' => $opt));      
        echo $envio;
       }
        public function editarSilabo () {
        //print_r($_POST); exit();
        $obj = new silabus();
        $p = $obj-> actualizar_silabo($_POST);      
       }
       public function  enviarNota(){
         $obj = new calificacion();
         $p = $obj-> insert($_POST);  
       }
       public function  editarNota(){
         $obj = new calificacion();
         $p = $obj-> update($_POST);  
       }
        public function getEstadoBoton(){
        $obj = new evaluacion();
        $p = $obj-> updateBoton($_POST);
       }
       public function getTema()
       {
        $unidad=$_POST["Codigo"];
       $option=$_POST["option"];
        
        $envio=$this->tema_recibir(array('filtro' => 'idunidad','criterio' => $unidad ,'opcion'=>$option));      
       
        echo $envio;
        
       }
      public function getEvaluacion(){
        $unidad=$_POST["Codigo"];
        $envio=$this->evaluacion_recibir(array('criterio' => $unidad));
        echo $envio;
       }
      public function editarTema() {
        $obj = new tema();
        $p = $obj-> actualizar_tema($_POST);      
       }

//aqui toy
       public function editarBiblio() {
        $obj = new bibliografia();
        $p = $obj-> actualizar_bibliografia($_POST);      
       }

//aqui toy
       public function editarBiblio_tipo() {
        $obj = new bibliografia();
        $p = $obj-> actualizar_bibliografia_tipo($_POST);      
       }

//aqui toy editar editarUni_nombre
       public function editarUni_nombre() {
        $obj = new unidad();
        $p = $obj-> actualizar_unidad_nombre($_POST);      
       }
//aqui toy editarEva_tipo
        public function editarEva_tipo() {
        $obj = new evaluacion();
        $p = $obj-> actualizar_evaluacion_tipo($_POST);      
       }
       
       
       public function getEditN() 
       {
        $evaluacion=$_POST["idevaluacion"];
       $alumno=$_POST["idalumno"];
       $nota=$_POST["notas"];
        
//           print_r($_POST);
           $envio=$this->Calificaiones(array('evaluacion' => $evaluacion,'alumno' => $alumno ,'notas'=>$nota));      
       
//        echo $envio;
//        echo $evaluacion;
//        echo $alumno;
//        echo $nota;
//   var_dump($nota.$evaluacion.$alumno);
//        exit();
        
       }
       
       public function getBibliografia()
       {
        $curso=$_POST["curso"];
       $semestre=$_POST["semestre"];
        
        $envio=$this->bibliografia_recibir(array('filtro' => 'CodigoAlumno','criterio' => $curso ,'filtro1' => 'CodigoSemestre','criterio1' => $semestre ));      
       
        echo $envio;
        
       }
       
       
//       
//        public function getClase()
//       {
//        $unidad=$_POST["CodigoT"];
//       
//        
//        $envio=$this->Clase_recibir(array('filtro' => 'idtema','criterio' => $unidad));      
//       
//        echo $envio;
//        
//       }
       

        ///faltaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa
        public function getAsistencia() 
       {
        $clase=$_POST["idclase"];
       $alumno=$_POST["idalumno"];
       $asistencia=$_POST["asistencia"];
        
//           print_r($_POST);
           $envio=$this->Asistencia(array('clase' => $clase,'alumno' => $alumno ,'asistencia'=>$asistencia));      
       
//        echo $envio;
//        echo $evaluacion;
//        echo $alumno;
//        echo $nota;
//   var_dump($nota.$evaluacion.$alumno);
//        exit();
        
       }
       
       
       
       ////Syllabusssssssssssssssssss inicio
       
       
       
       public function edit() {
        $obj = new silabus();
        $data = array();
        $view = new View();
        $obj = $obj->edit($_GET['id']);
        $data['obj'] = $obj;
        $data['cargaacademica'] = $this->Select(array('id' => 'idcargaacademica', 'name' => 'idcargaacademica', 'table' => 'carga_academica', 'code' => $obj->idcargaacademica));
        $data['profesores'] = $this->Select(array('id' => 'CodigoProfesor', 'name' => 'CodigoProfesor', 'table' => 'profesores', 'code' => $obj->CodigoProfesor));
        $data['cursos'] = $this->Select(array('id' => 'CodigoCurso', 'name' => 'CodigoCurso', 'table' => 'v_cursos', 'code' => $obj->CodigoCurso));
        $data['semestre'] = $this->Select(array('id' => 'CodigoSemestre', 'name' => 'CodigoSemestre', 'table' => 'semestreacademico', 'code' => $obj->CodigoSemestre));


        $view->setData($data);
        $view->setTemplate('../view/silabus/_Form.php');
        $view->setLayout('../template/Layout.php');
        $view->renderPartial();
    }

    public function save() {
       
        $obj = new silabus();
        $p = $obj->insert($_POST);
        

        /*if (isset($_SESSION["perfil"]) && ($_SESSION["perfil"] == 'PROFESOR')) {
            $obj = new silabus();
            if ($_POST['idsilabus'] == '') {
                $p = $obj->insert($_POST);
                if ($p[0]) {
                    header('Location:index.php?controller=cursosemestre');
                } else {
                    $data = array();
                    $view = new View();
                    $data['msg'] = $p[1];
                    $data['url'] = 'index.php?controller=cursosemestre';
                    $view->setData($data);
                    $view->setTemplate('../view/_Error_App.php');
                    $view->setLayout('../template/Layout.php');
                    $view->render();
                }
            } else {
                $p = $obj->update($_POST);
                if ($p[0]) {
                    header('Location: index.php?controller=cursosemestre');
                } else {
                    $data = array();
                    $view = new View();
                    $data['msg'] = $p[1];
                    $data['url'] = 'index.php?controller=cursosemestre';
                    $view->setData($data);
                    $view->setTemplate('../view/_Error_App.php');
                    $view->setLayout('../template/Layout.php');
                    $view->render();
                }
            }
        } */
    }

    public function delete() {
        $obj = new silabus();
        $p = $obj->delete($_GET['id']);
        if ($p[0]) {
            header('Location: index.php?controller=cursosemestre');
        } else {
            $data = array();
            $view = new View();
            $data['msg'] = $p[1];
            $data['url'] = 'index.php?controller=cursosemestre';
            $view->setData($data);
            $view->setTemplate('../view/_Error_App.php');
            $view->setLayout('../template/Layout.php');
            $view->render();
        }
    }

    public function create() {

        $data = array();
        $view = new View();
        $data['cargaacademica'] = $this->Select(array('id' => 'idcargaacademica', 'name' => 'idcargaacademica', 'table' => 'carga_academica', 'code' => $obj->idcargaacademica));
        $data['profesores'] = $this->Select(array('id' => 'CodigoProfesor', 'name' => 'CodigoProfesor', 'table' => 'profesores', 'code' => $obj->CodigoProfesor));
        $data['cursos'] = $this->Select(array('id' => 'CodigoCurso', 'name' => 'CodigoCurso', 'table' => 'v_cursos', 'code' => $obj->CodigoCurso));
        $data['semestre'] = $this->Select(array('id' => 'CodigoSemestre', 'name' => 'CodigoSemestre', 'table' => 'semestreacademico ', 'code' => $obj->CodigoSemestre));

        $view->setData($data);
        $view->setTemplate('../view/silabus/_Form.php');
        $view->setLayout('../template/Layout.php');
        $view->render();
    }

    public function getCargaAcademica() {
        $ofic = $this->Select_ajax(array('id' => 'idcriterio', 'name' => 'idcriterio', 'table' => 'vista_cargaacademica', 'filtro' => 'carga_academica', 'criterio' => $_POST['idcargaacademica']));
        echo $ofic;
    }
  function getTipoBiblio() {
        $ofic2 = $this->Select_tipo_biblio(array('id' => 'idcriterio', 'name' => 'idcriterio', 'table' => 'tipo_bibliografia'));
        echo $ofic2;
    }

       
       //Syllabussss FINNNNNNNNNN
       
       
       
}
?>