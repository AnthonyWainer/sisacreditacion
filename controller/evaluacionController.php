<?php
require_once '../lib/Controller.php';
require_once '../lib/View.php';
require_once '../model/evaluacion.php';
class evaluacionController extends Controller {    
    public function index() 
    {
        if (!isset($_GET['p'])){$_GET['p']=1;}
        if(!isset($_GET['q'])){$_GET['q']="";}        
        if(!isset($_GET['criterio'])){$_GET['criterio']="evaluacion.descripcionevaluacion";}
        $obj = new evaluacion();
        $data = array();             
        $data['data'] = $obj->index($_GET['q'],$_GET['p'],$_GET['criterio']);
        $data['query'] = $_GET['q'];
        $data['pag'] = $this->Pagination(array('rows'=>$data['data']['rowspag'],'url'=>'index.php?controller=evaluacion&action=index','query'=>$_GET['q']));                
        $cols = array("Codigo","Unidad","Tipo","Descripcion","Fecha","Ponderado");        
       
        $opt = array("idevaluacion"=>"CODIGO","idunidad"=>"id unidad","idtipo_evaluacion"=>"id tipo evaluacion",
            "descripcionevaluacion"=>"Descripcion Evaluacion","fecha"=>"FECHA","ponderado"=>"PONDERADO");
        $data['grilla'] = $this->grilla("evaluacion",$cols, $data['data']['rows'],$opt,$data['pag'],true,true);
        $view = new View();
        $view->setData($data);
        $view->setTemplate( '../view/evaluacion/_Index.php' );
        $view->setLayout( '../template/Layout.php' );
        $view->render();
    }
    public function insertEvaluacion(){
        $obj = new evaluacion();
        $obj->insert($_POST); 
    }
    public function insertEvaluacion1(){
        $obj = new evaluacion();
        $obj->insert1($_POST); 
    }    
    public function edit() {
        $obj = new evaluacion();
        $data = array();
        $view = new View();
        
        $obj = $obj->edit($_GET['id']); 
       
        $data['obj'] = $obj;
        $data['unidad'] = $this->Select(array('id'=>'idunidad','name'=>'idunidad','table'=>'v_unidad','code'=>$obj->idunidad));
        $data['tipo_evaluacion'] = $this->Select(array('id'=>'idtipo_evaluacion','name'=>'idtipo_evaluacion','table'=>'tipo_evaluacion','code'=>$obj->idtipo_evaluacion));
       
        $view->setData($data);
        $view->setTemplate( '../view/evaluacion/_Form.php' );
        $view->setLayout( '../template/Layout.php' );
        $view->render();
    }
    public function save(){
        
        $obj = new evaluacion();
      
        if ($_POST['idevaluacion']=='') {
            
            $p = $obj->insert($_POST);
            
            if ($p[0]){
                header('Location: index.php?controller=evaluacion');
            } else {
            $data = array();
            $view = new View();
            $data['msg'] = $p[1];
            $data['url'] ='index.php?controller=evaluacion';
            $view->setData($data);
            $view->setTemplate( '../view/_Error_App.php' );
            $view->setLayout( '../template/Layout.php' );
            $view->render();
            }
        } else {
          
            $p = $obj->update($_POST);            
            if ($p[0]){
                header('Location: index.php?controller=evaluacion');
            } else {
            $data = array();
            $view = new View();
            $data['msg'] = $p[1];
            $data['url'] =  'index.php?controller=evaluacion';
            $view->setData($data);
            $view->setTemplate( '../view/_Error_App.php' );
            $view->setLayout( '../template/Layout.php' );
            $view->render();
            }
        }
    }

    public function create() {
        $data = array();
        $view = new View();
        $data['obj'] = $obj;
        $data['unidad'] = $this->Select(array('id'=>'idunidad','name'=>'idunidad','table'=>'v_unidad','code'=>$obj->idunidad));
        $data['tipo_evaluacion'] = $this->Select(array('id'=>'idtipo_evaluacion','name'=>'idtipo_evaluacion','table'=>'tipo_evaluacion','code'=>$obj->idtipo_evaluacion));
       
        $view->setData($data);
        $view->setTemplate( '../view/evaluacion/_Form.php' );
        $view->setLayout( '../template/Layout.php' );
        $view->render();
    }
    public function delete() {
        $obj = new evaluacion();
        $obj->delete($_POST['id']);
    }
	
    public function getProfesores()
    {
        $ofic = $this->Select_ajax(array('id'=>'idcriterio','name'=>'idcriterio','table'=>'vista_profesores','filtro'=>'CodigoCondicion','criterio'=>$_POST['CodigoCondicion']));
        echo $ofic;
    }
	
       public function getProfesores1()
    {
        $ofic = $this->Select_ajax(array('id'=>'idcriterio','name'=>'idcriterio','table'=>'vista_profesores','filtro'=>'CodigoCategoria','criterio'=>$_POST['COdigoCategoria']));
        echo $ofic;
    }
	
       public function getProfesores2()
    {
        $ofic = $this->Select_ajax(array('id'=>'idcriterio','name'=>'idcriterio','table'=>'vista_profesores','filtro'=>'CodigoDedicacion','criterio'=>$_POST['CodigoDedicacion']));
        echo $ofic;
    }
	
       public function getProfesores3()
    {
        $ofic = $this->Select_ajax(array('id'=>'idcriterio','name'=>'idcriterio','table'=>'vista_profesores','filtro'=>'CodigoDptoAcad','criterio'=>$_POST['CodigoDptoAcad']));
        echo $ofic;
    }
	
        public function getProfesores4()
    {
        $ofic = $this->Select_ajax(array('id'=>'idcriterio','name'=>'idcriterio','table'=>'vista_profesores','filtro'=>'CodigoProfesor','criterio'=>$_POST['CodigoProfesor']));
        echo $ofic;
    }
}
?>