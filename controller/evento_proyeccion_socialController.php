<?php

require_once '../lib/Controller.php';
require_once '../lib/View.php';
require_once '../model/evento_proyeccion_social.php';
require_once '../model/ubigeos.php';

class evento_proyeccion_socialController extends Controller {

    public function index() {
        if (!isset($_GET['p'])) {
            $_GET['p'] = 1;
        }
        if (!isset($_GET['q'])) {
            $_GET['q'] = "";
        }
        if (!isset($_GET['criterio'])) {
            $_GET['criterio'] = "idevento";
        }
        $obj = new evento_proyeccion_social();
        $data = array();
        $sem=  $this->mostrar_semestre_ultimo();
        $datos = $data['data'] = $obj->index($_GET['q'], $_GET['p'], $_GET['criterio'],$_SESSION['idusuario'],$sem);
        $data['query'] = $_GET['q'];
        $data['pag'] = $this->Pagination(array('rows' => $data['data']['rowspag'], 'url' => 'index.php?controller=evento_proyeccion_social&action=index', 'query' => $_GET['q']));

        $cols = array("CODIGO", "TEMA DE EVENTO", "TIPO", "FECHA", "LUGAR");

        $opt = array("eventotema" => "Tema", "evento.fecha" => "Fecha");
        $data['grilla'] = $this->grilla_E_PS_EU("evento_proyeccion_social", $cols, $data['data']['rows'], $opt, $data['pag'], true, true, false, true, true, false);
        $view = new View();
        $view->setData($data);
        $view->setTemplate('../view/evento_proyeccion_social/_Index.php');
        $view->setLayout('../template/Layout3.php');
        $view->render();
    }

    public function pdf_ps() {
        $idevento=$_POST['idevento'];
        $envio=$this->ListaPdf_ps($idevento);
      echo $envio;  
       }

    public function edit() {
        $ubigeo = new ubigeos();
        $obj = new evento_proyeccion_social();
        $data = array();
        $view = new View();
        $obj = $data['obj'] = $this->getFiels(array("tabla" => "evento", "campo" => "idevento", "idtabla" => $_REQUEST['id']));
        $dat = $data['obj_tipo'] = $this->getFiels(array("tabla" => "tipo_evento", "campo" => "idtipo_evento", "idtabla" => $obj['idtipo_evento']));
        $ubigeos = $ubigeo->getDatos($obj['UBIGEO']);
        $data['departamento'] = $this->Select(array('id' => 'departamento', 'name' => 'departamento', 'table' => 'vista_departamento', 'code' => $ubigeos['DEPARTAM']));
        $data['provincia'] = $this->Select_ajax_string_prov(array('id' => 'provincia', 'name' => 'provincia', 'table' => 'ubigeos$', 'filtro' => 'DEPARTAM', 'criterio' => $ubigeos['DEPARTAM'], 'code' => $ubigeos['PROVINCIA'], 'ajax' => false));
        $data['distrito'] = $this->Select_ajax_string_dis(array('id' => 'distrito', 'name' => 'distrito', 'table' => 'ubigeos$', 'filtro' => 'PROVINCIA', 'criterio' => $ubigeos['PROVINCIA'], 'code' => $obj['UBIGEO'], 'ajax' => false));
        $data['sub_eventos'] = $this->leer_sub_eventos($_GET['id'],  $obj['idtipo_evento'], $obj['UBIGEO']);
        $data['pre_actividades'] = $this->leer_pre_actividades($_GET['id']);

        $data['tipo_evento'] = $this->Select(array('id' => 'idtipo_evento', 'name' => 'idtipo_evento', 'table' => 'tipo_evento where tipo_evento.idtipo_evento="5"', 'code' => $obj['idtipo_evento']));
//        $data['sub_eventos'] = $this->leer_sub_eventos($_GET['id'],  $obj['idtipo_evento'], $obj['UBIGEO']);
//        $data['pre_actividades'] = $this->leer_pre_actividades($idevento);



        $view->setData($data);
        $view->setTemplate('../view/evento_proyeccion_social/_Form.php');
        $view->setLayout('../template/Layout3.php');
        $view->render();
    }

    public function show_detalles(){
         $ubigeo = new ubigeos();
        $obj = new evento_proyeccion_social();
        $data = array();
        $view = new View();        
        $prof=$data['profesores']=$obj->get_profesores($_GET['id']);
        $data['alumnos']=$obj->get_alumnos($_GET['id']);
        $data['externos']=$obj->get_externos($_GET['id']);
        $data['pre_actividades']=$obj->get_pre_actividades($_GET['id']);
        $data['sub_eventos']=$obj->get_sub_eventos($_GET['id']);
        $obj = $data['obj'] = $this->getFiels(array("tabla" => "evento", "campo" => "idevento", "idtabla" => $_REQUEST['id']));
        $dat = $data['obj_tipo'] = $this->getFiels(array("tabla" => "tipo_evento", "campo" => "idtipo_evento", "idtabla" => $obj['idtipo_evento']));
        $ubigeos = $ubigeo->getDatos($obj['UBIGEO']);
        $ubi = $data['uvi'] = $this->getFiels(array("tabla" => "ubigeos$", "campo" => "UBIGEO", "idtabla" => $obj['UBIGEO']));
        $data['departamento'] = $this->Select(array('id' => 'departamento', 'name' => 'departamento', 'table' => 'vista_departamento', 'code' => $ubigeos['DEPARTAM']));
        $data['provincia'] = $this->Select_ajax_string_prov(array('id' => 'provincia', 'name' => 'provincia', 'table' => 'ubigeos$', 'filtro' => 'DEPARTAM', 'criterio' => $ubigeos['DEPARTAM'], 'code' => $ubigeos['PROVINCIA'], 'ajax' => false));
        $data['distrito'] = $this->Select_ajax_string_dis(array('id' => 'distrito', 'name' => 'distrito', 'table' => 'ubigeos$', 'filtro' => 'PROVINCIA', 'criterio' => $ubigeos['PROVINCIA'], 'code' => $obj['UBIGEO'], 'ajax' => false));
        $data['tipo_evento'] = $this->Select(array('id' => 'idtipo_evento', 'name' => 'idtipo_evento', 'table' => 'tipo_evento where tipo_evento.idtipo_evento="3" or tipo_evento.idtipo_evento="5"', 'code' => $obj['idtipo_evento']));
        $view->setData($data);
        $view->setTemplate('../view/evento_proyeccion_social/_descrDetalles.php');
        $view->setLayout('../template/Layout.php');
        $view->render();
    }

    public function unirse_evento() {
        $obj = new evento_proyeccion_social();
        $data = array();
        $view = new View();
        $id = $_REQUEST['id'];
        $data['id'] = $id;
        $data['semestre'] = $obj->mostrar_ultimo_semestre();
        $view->setData($data);
        $view->setTemplate('../view/evento_proyeccion_social/_unirse_evento.php');
        $view->setLayout('../template/Layout.php');
        $view->render();
    }

    public function unirse_profesor_evento() {
        $obj = new evento_proyeccion_social();
        $data = array();
        $view = new View();
        $id = $_REQUEST['id'];
        $data['id'] = $id;
        $data['semestre'] = $obj->mostrar_ultimo_semestre();
        $view->setData($data);
        $view->setTemplate('../view/evento_proyeccion_social/_unirse_profesor_evento.php');
        $view->setLayout('../template/Layout.php');
        $view->render();
    }

    public function insertarDetalle() {
        $obj = new evento_proyeccion_social();
       $p= $obj->InsertDet($_REQUEST);
       print_r( $p[1]);
        header('Location: index.php?controller=evento_proyeccion_social&action=index_alumno');
        $data = array();
        $view = new View();
        $view->setData($data);
        $view->setTemplate('../view/_Error_App.php');
        echo $view->renderPartial();
    }

    public function insertarDetalle_profesor() {
        $obj = new evento_proyeccion_social();
        $obj->InsertDet_profesor($_REQUEST);
        header('Location: index.php?controller=evento_proyeccion_social&action=index_profesor');
        $data = array();
        $view = new View();
        $view->setData($data);
        $view->setTemplate('../view/_Error_App.php');
        echo $view->renderPartial();
    }

    public function sub_eventos_preactividades($idevento, $tipo_evento, $ubi) {
        echo $data['sub_eventos'] = $this->leer_sub_eventos($idevento, $tipo_evento, $ubi);
        echo $data['pre_actividades'] = $this->leer_pre_actividades($idevento);
    }

    public function save__preactividades() {
        $obj = new evento_proyeccion_social();
        $p = $obj->save__pre_actividates($_REQUEST);
        $q = $obj->save__pre_actividates_up($_REQUEST);
        if(!$q[0]){ echo "error :" . $q[1]; }
        if ($p[0]) {
            echo "ok";
            echo $data['sub_eventos'] = $this->leer_pre_actividades($_REQUEST['idevento_']);
        } else {
            echo "error :" . $p[1];
        }
         
    }
    public function delete_pre() {
        $obj = new evento_proyeccion_social();
        $p = $obj->del_preactividad($_REQUEST);
         if ($p[0]) {
            echo  $this->leer_pre_actividades( $_REQUEST['idpadre']);
        } else {
            echo "error :" . $p[1];
        }
    }
    
    public function delete_sub(){
//        print_r($_REQUEST);exit;
        $obj = new evento_proyeccion_social();
        $p = $obj->del_sub($_REQUEST);
         if ($p[0]) {
            echo $data['sub_eventos'] = $this->leer_sub_eventos($_REQUEST['idpadre'], $_REQUEST['tipoevento'], $_REQUEST['ubigeo1']);
        } else {
            echo "error :" . $p[1];
        }
    }
    
    public function save__subeventos() {
//        echo "aki";print_r($_REQUEST);
        $obj = new evento_proyeccion_social();
        $p = $obj->save__sub_eventos($_REQUEST);
        $q = $obj->save__sub_actividades_up($_REQUEST);
        if ($p[0]) {
            echo $data['sub_eventos'] = $this->leer_sub_eventos($_REQUEST['ideventoo'], $_REQUEST['tipoevento'], $_REQUEST['ubigeo1']);
        } else {
            echo "error :" . $p[1];
        }
    }

    public function index_Alum() {
        if (!isset($_GET['p'])) {
            $_GET['p'] = 1;
        }
        if (!isset($_GET['q'])) {

            $_GET['q'] = "";
        }
        if (!isset($_GET['criterio'])) {
            $_GET['criterio'] = "idevento";
        }
        $obj = new evento_proyeccion_social();
        $data = array();
        $sem=  $this->mostrar_semestre_ultimo();
        $datos = $data['data'] = $obj->index1($_GET['q'], $_GET['p'], $_GET['criterio'],$_SESSION['idusuario'],$sem);
 $data['query'] = $_GET['q'];
        $data['pag'] = $this->Pagination(array('rows' => $data['data']['rowspag'], 'url' => 'index.php?controller=evento_proyeccion_social&action=index', 'query' => $_GET['q']));

        $cols = array("CODIGO", "TEMA DE EVENTO", "TIPO", "FECHA", "LUGAR");
//,"UNIRSE"
        $opt = array("eventotema" => "Tema", "evento.fecha" => "Fecha");
        $data['grilla'] = $this->grilla_E_PS_EU("evento_proyeccion_social", $cols, $data['data']['rows'], $opt, $data['pag'], false, false, false, false, false, true);
        $view = new View();
        $view->setData($data);
        $view->setTemplate('../view/evento_proyeccion_social/_Index.php');
        $view->setLayout('../template/Layout.php');
        $view->render();
    }

    public function index_alumno() {
        if (!isset($_GET['p'])) {
            $_GET['p'] = 1;
        }
        if (!isset($_GET['q'])) {
            $_GET['q'] = "";
        }
        if (!isset($_GET['criterio'])) {
            $_GET['criterio'] = "idevento";
        }
        $obj = new evento_proyeccion_social();
        $data = array();
       $sem=  $this->mostrar_semestre_ultimo();
        $datos = $data['data'] = $obj->index1($_GET['q'], $_GET['p'], $_GET['criterio'],$_SESSION['idusuario'],$sem);
 $data['query'] = $_GET['q'];
        $data['pag'] = $this->Pagination(array('rows' => $data['data']['rowspag'], 'url' => 'index.php?controller=evento_proyeccion_social&action=index', 'query' => $_GET['q']));

        $cols = array("CODIGO", "TEMA DE EVENTO", "TIPO", "FECHA", "LUGAR");
//,"UNIRSE"
        $opt = array("evento_proyeccion_social.DescripcionTipoColegio" => "Tema");
        $data['grilla'] = $this->grilla_E_PS_EU("evento_proyeccion_social", $cols, $data['data']['rows'], $opt, $data['pag'], false, false, false, false, true, true);
        $view = new View();
        $view->setData($data);
        $view->setTemplate('../view/evento_proyeccion_social/_Index.php');
        $view->setLayout('../template/Layout.php');
        $view->render();
    }

    public function index_profesor() {
        if (!isset($_GET['p'])) {
            $_GET['p'] = 1;
        }
        if (!isset($_GET['q'])) {
            $_GET['q'] = "";
        }
        if (!isset($_GET['criterio'])) {
            $_GET['criterio'] = "idevento";
        }
        $obj = new evento_proyeccion_social();
        $data = array();
        $sem=  $this->mostrar_semestre_ultimo();
        $datos = $data['data'] = $obj->index1($_GET['q'], $_GET['p'], $_GET['criterio'],$_SESSION['idusuario'],$sem);
$data['query'] = $_GET['q'];
        $data['pag'] = $this->Pagination(array('rows' => $data['data']['rowspag'], 'url' => 'index.php?controller=evento_proyeccion_social&action=index', 'query' => $_GET['q']));

        $cols = array("CODIGO", "TEMA DE EVENTO", "TIPO", "FECHA", "LUGAR");
//,"UNIRSE"
        $opt = array("evento_proyeccion_social.DescripcionTipoColegio" => "Tema");
        $data['grilla'] = $this->grilla_E_PS_EU("evento_proyeccion_social", $cols, $data['data']['rows'], $opt, $data['pag'], FALSE, false, false, true, true, false, true);
        $view = new View();
        $view->setData($data);
        $view->setTemplate('../view/evento_proyeccion_social/_Index.php');
        $view->setLayout('../template/Layout.php');
        $view->render();
    }

    public function save() {
        $obj = new evento_proyeccion_social();
        if ($_POST['idevento'] == '') {
            $p = $obj->insert($_REQUEST);
            if ($p[0]) {
                $ubi = $_REQUEST['distrito'];
                $tipo_even = $_REQUEST['idtipo_evento'];
                $idevento = $p['idevento'];
                $this->sub_eventos_preactividades($idevento, $tipo_even, $ubi);
            } else {
                $data = array();
                $view = new View();
                $data['msg'] = $p[1];
                $data['url'] = 'index.php?controller=evento_proyeccion_social';
                $view->setData($data);
                $view->setTemplate('../view/_Error_App.php');
                echo $view->renderPartial();
            }
        } else {
            $p = $obj->update($_REQUEST);
            if ($p[0]) {
                header('Location: index.php?controller=evento_proyeccion_social');
            } else {
                $data = array();
                $view = new View();
                $data['msg'] = $p[1];
                $data['url'] = 'index.php?controller=evento_proyeccion_social';
                $view->setData($data);
                $view->setTemplate('../view/_Error_App.php');
                echo $view->renderPartial();
            }
        }
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

    public function create() {
        $data = array();
        $view = new View();
        $data['tipo_evento'] = $this->Select(array('id' => 'idtipo_evento', 'name' => 'idtipo_evento', 'table' => 'tipo_evento where tipo_evento.idtipo_evento="5"'));
        $data['departamento'] = $this->Select(array('id' => 'departamento', 'name' => 'departamento', 'table' => 'vista_departamento', 'code' => $obj->DEPARTAM));
        $data['provincia'] = $this->Select(array('id' => 'provincia', 'name' => 'provincia', 'table' => 'vpovincia', 'code' => $obj->PROVINCIA));
//        $data['distrito'] = $this->Select(array('id' => 'distrito', 'name' => 'distrito', 'table' => 'ubigeos$', 'code' => $obj->UBIGEO));


        $view->setData($data);
        $view->setTemplate('../view/evento_proyeccion_social/_Form.php');
        $view->setLayout('../template/Layout3.php');
        $view->render();
    }

    public function getListaProvincias() {
        $ofic = $this->Select_ajax_string(array('id' => 'idcriterio', 'name' => 'idcriterio', 'table' => 'ubigeos$', 'filtro' => 'DEPARTAM', 'criterio' => $_POST['departamento']));
        echo $ofic;
    }

    public function getListaDistritos() {
        $ofic = $this->Select_ajax_string_dis(array('id' => 'idcriterio', 'name' => 'idcriterio', 'table' => 'ubigeos$', 'filtro' => 'PROVINCIA', 'criterio' => $_POST['provincia'], 'ajax' => true));
        echo $ofic;
    }

}

?>