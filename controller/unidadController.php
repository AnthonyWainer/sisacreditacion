<?php

require_once '../lib/Controller.php';
require_once '../lib/View.php';
require_once '../model/unidad.php';

class unidadController extends Controller {

    public function index() {
        if (!isset($_GET['p'])) {
            $_GET['p'] = 1;
        }
        if (!isset($_GET['q'])) {
            $_GET['q'] = "";
        }
        if (!isset($_GET['criterio'])) {
            $_GET['criterio'] = "unidad.nombreunidad";
        }
        $obj = new unidad();
        $data = array();
        $data['data'] = $obj->index($_GET['q'], $_GET['p'], $_GET['criterio']);
        $data['query'] = $_GET['q'];
        $data['pag'] = $this->Pagination(array('rows' => $data['data']['rowspag'], 'url' => 'index.php?controller=unidad&action=index', 'query' => $_GET['q']));
        $cols = array("Codigo", "Cod. Silabus", "Nombre", "Descripcion", "Duracion", "Sumilla", "Competencia", "porcentaje");
        $opt = array("unidad.nombreunidad" => "Nombre Unidad", "silabus.sumilla" => "Sumilla");
        $data['grilla'] = $this->grilla("unidad", $cols, $data['data']['rows'], $opt, $data['pag'], true, true);
        $view = new View();
        $view->setData($data);
        $view->setTemplate('../view/unidad/_Index.php');
        $view->setLayout('../template/Layout.php');
        $view->render();
    }

    public function edit() {
        $obj = new unidad();
        $data = array();
        $view = new View();
        $obj = $obj->edit($_GET['id']);
        $data['obj'] = $obj;
        $data['silabus'] = $this->Select(array('id' => 'idsilabus', 'name' => 'idsilabus', 'table' => 'silabus', 'code' => $obj->idsilabus));
        $view->setData($data);
        $view->setTemplate('../view/unidad/_Form.php');
        $view->setLayout('../template/Layout.php');
        $view->render();
    }

    public function save() {
        if (isset($_SESSION["perfil"]) && ($_SESSION["perfil"] == 'PROFESOR')) {
            $obj = new unidad();
            if ($_POST['idunidad'] == '') {
                $p = $obj->insert($_POST);
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
        } else {

            $obj = new unidad();
            if ($_POST['idunidad'] == '') {
                $p = $obj->insert($_POST);
                if ($p[0]) {
                    header('Location: index.php?controller=unidad');
                } else {
                    $data = array();
                    $view = new View();
                    $data['msg'] = $p[1];
                    $data['url'] = 'index.php?controller=unidad';
                    $view->setData($data);
                    $view->setTemplate('../view/_Error_App.php');
                    $view->setLayout('../template/Layout.php');
                    $view->render();
                }
            } else {
                $p = $obj->update($_POST);
                if ($p[0]) {
                    header('Location: index.php?controller=unidad');
                } else {
                    $data = array();
                    $view = new View();
                    $data['msg'] = $p[1];
                    $data['url'] = 'index.php?controller=unidad';
                    $view->setData($data);
                    $view->setTemplate('../view/_Error_App.php');
                    $view->setLayout('../template/Layout.php');
                    $view->render();
                }
            }
        }
    }

    public function delete() {
        $obj = new unidad();
        $obj->delete($_POST['id']);
    }

    public function create() {
        $obj = new unidad();
        $obj->insert($_POST);
    }

    public function getUnidad() {
        $ofic = $this->Select_ajax(array('id' => 'idcriterio', 'name' => 'idcriterio', 'table' => 'vista_unidad', 'filtro' => 'idsilabus', 'criterio' => $_POST['idsilabus']));
        echo $ofic;
    }

}

?>