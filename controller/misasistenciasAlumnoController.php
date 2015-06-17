<?php

require_once '../lib/Controller.php';
require_once '../lib/View.php';
require_once '../model/misasistenciasAlumno.php';

class misasistenciasAlumnoController extends Controller {
    public function index() {

         $data['semestreacademico'] = $this->cinco_ultimos_semestres(array('id' => 'CodigoSemestre', 'name' => 'CodigoSemestre', 'table' => 'semestreacademico', 'code' => $obj->CodigoSemestre));
      
        $view = new View();
        $view->setData($data);


        $view->setTemplate('../view/misasistenciasAlumno/_Index.php');

        $view->setLayout('../template/Layout.php');

        $view->render();
    }

    public function mostrar_mis_asistencias_eventos() {
        
    
        $obj = new misasistenciasAlumno();  
        $semestre =$this->mostrar_semestre_ultimo(); 
        $idsemestre=$_POST['sem'];
        if(!empty($idsemestre)){$semestre=$idsemestre;}
        $codalumno=$_SESSION['idusuario'];
        $envio = $this->mostrar_mis_asistencias_eventos_tutoria_alumno(array( 'criterio' => $semestre, 'criterio2' => $codalumno));
        echo $envio;
         
    }
	public function mi_Tutor() {
   
        $obj = new misasistenciasAlumno();  
        $semestre =$this->mostrar_semestre_ultimo(); 
       
        $idsemestre=$_POST['sem'];
        if(!empty($idsemestre)){$semestre=$idsemestre;}
        $codalumno=$_SESSION['idusuario'];
        $mitutor= $obj->mi_tutor($codalumno,$semestre);
        echo $mitutor;
        
    }
  
    
}

?>