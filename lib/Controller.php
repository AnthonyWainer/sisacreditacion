<?php

require_once '../model/Main.php';
require_once '../model/semestre.php';
require_once '../model/evaluacion.php';


class ControllerException extends Exception {
    
}

class Controller {

    public function __call($name, $arguments) {
        throw new ControllerException("Error! El método {$name}  no está definido.");
    }

    public function PaginationPOST($p) {
        $data = array();
        $data['rows'] = $p['rows'];
        $data['query'] = $p['query'];
        $data['url'] = $p['url'];
        $view = new View();
        $view->setData($data);
        $view->setTemplate('../view/_PaginationPOST.php');
        return $view->renderPartial();
    }
 public function PaginationPOST2($p) {
        $data = array();
        $data['rows'] = $p['rows'];
        $data['query'] = $p['query'];
        $data['url'] = $p['url'];
        $view = new View();
        $view->setData($data);
        $view->setTemplate('../view/_PaginationPOSt2.php');
        return $view->renderPartial();
    }
 public function ListaPdf_eu($idevento) {
        $obj = new Main();
        $obj->criterio = $idevento;
        $data = array();
        $data['rows'] = $obj->getDetalle_evento_eu();
        $data['disabled'] = $p['disabled'];
        $view = new View();
        $view->setData($data);
        $view->setTemplate('../view/_Pdf_eu.php');
        return $view->renderPartial();
    }

public function ListaPdf_ps($idevento) {
        $obj = new Main();
        $obj->criterio = $idevento;
        $data = array();
        $data['rows'] = $obj->getDetalle_evento();
        $data['disabled'] = $p['disabled'];
        $view = new View();
        $view->setData($data);
        $view->setTemplate('../view/_Pdf_ps.php');
        return $view->renderPartial();
    }
    public function grilla_solicitudes_ps($p) {
        $obj = new Main();
        $data = array();
        $data['rows'] = $obj->getDatos_grilla_solicitudes_ps();
        $data['name'] = $p['name'];
        $data['id'] = $p['id'];
        $data['code'] = $p['code'];
        $data['disabled'] = $p['disabled'];
        $view = new View();
        $view->setData($data);
        $view->setTemplate('../view/solicitudes_ps.php');
        return $view->renderPartial();
    }

    
    public function grilla_solicitudes_eu($p) {
        $obj = new Main();
        $data = array();
        $data['rows'] = $obj->getDatos_grilla_solicitudes_eu();
        $data['name'] = $p['name'];
        $data['id'] = $p['id'];
        $data['code'] = $p['code'];
        $data['disabled'] = $p['disabled'];
        $view = new View();
        $view->setData($data);
        $view->setTemplate('../view/solicitudes_eu.php');
        return $view->renderPartial();
        
        
        
    }
    public function grilla_solicitudes_docentes_ps($p) {
        $obj = new Main();
        $data = array();
        $data['rows'] = $obj->getDatos_grilla_solicitudes_docentes_ps();
        $data['name'] = $p['name'];
        $data['id'] = $p['id'];
        $data['code'] = $p['code'];
        $data['disabled'] = $p['disabled'];
        $view = new View();
        $view->setData($data);
        $view->setTemplate('../view/solicitudes_docentes_ps.php');
        return $view->renderPartial();
     
    }
     public function grilla_solicitudes_docentes_eu($p) {
        $obj = new Main();
        $data = array();
        $data['rows'] = $obj->getDatos_grilla_solicitudes_docentes_eu();
        $data['name'] = $p['name'];
        $data['id'] = $p['id'];
        $data['code'] = $p['code'];
        $data['disabled'] = $p['disabled'];
        $view = new View();
        $view->setData($data);
        $view->setTemplate('../view/solicitudes_docentes_eu.php');
        return $view->renderPartial();
     
    }
    
        public function grilla_notificaciones_docentes_ps($p) {
        $obj = new Main();
        $data = array();
        $data['rows'] = $obj->getDatos_grilla_notificaciones_docentes_ps();
        $data['name'] = $p['name'];
        $data['id'] = $p['id'];
        $data['code'] = $p['code'];
        $data['disabled'] = $p['disabled'];
        $view = new View();
        $view->setData($data);
        $view->setTemplate('../view/notificaciones_docentes_ps.php');
        return $view->renderPartial();
        
        
        
    }
     public function grilla_notificaciones_docentes_eu($p) {
        $obj = new Main();
        $data = array();
        $data['rows'] = $obj->getDatos_grilla_notificaciones_docentes_eu();
        $data['name'] = $p['name'];
        $data['id'] = $p['id'];
        $data['code'] = $p['code'];
        $data['disabled'] = $p['disabled'];
        $view = new View();
        $view->setData($data);
        $view->setTemplate('../view/notificaciones_docentes_eu.php');
        return $view->renderPartial();
        
        
        
    }
    public function grilla_notificaciones_alumnos_ps($p) {
        $obj = new Main();
        $data = array();
        $data['rows'] = $obj->getDatos_grilla_notificaciones_alumnos_ps();
        $data['name'] = $p['name'];
        $data['id'] = $p['id'];
        $data['code'] = $p['code'];
        $data['disabled'] = $p['disabled'];
        $view = new View();
        $view->setData($data);
        $view->setTemplate('../view/notificaciones_alumnos_ps.php');
        return $view->renderPartial();
        
        
        
    }
    
     public function grilla_notificaciones_alumnos_eu($p) {
        $obj = new Main();
        $data = array();
        $data['rows'] = $obj->getDatos_grilla_notificaciones_alumnos_eu();
        $data['name'] = $p['name'];
        $data['id'] = $p['id'];
        $data['code'] = $p['code'];
        $data['disabled'] = $p['disabled'];
        $view = new View();
        $view->setData($data);
        $view->setTemplate('../view/notificaciones_alumnos_eu.php');
        return $view->renderPartial();
        
        
        
    }
    public function Select($p) {

        $obj = new Main();
        $obj->table = $p['table'];
        $data = array();

        $data['rows'] = $obj->getList();
        $data['name'] = $p['name'];
        $data['id'] = $p['id'];
        $data['code'] = $p['code'];
        $data['disabled'] = $p['disabled'];
        $view = new View();
        $view->setData($data);
        $view->setTemplate('../view/_Select.php');
        return $view->renderPartial();
    }

    public function Select_ajax_string_prov($p) {
        $obj = new Main();
        $obj->table = $p['table'];
        $obj->filtro = $p['filtro'];
        $obj->criterio = $p['criterio'];
        $data = array();
        $data['rows'] = $obj->getList_ajax_string();
        $data['name'] = $p['name'];
        $data['id'] = $p['id'];
        $data['code'] = $p['code'];
        $data['disabled'] = $p['disabled'];
        $view = new View();
        $view->setData($data);
        if ($p['ajax']) {
            $view->setTemplate('../view/_Select_ajax.php');
        } else {
            $view->setTemplate('../view/_Select.php');
        }
        return $view->renderPartial();
    }

    public function leer_sub_eventos($idevento = "", $tipo_eve = "", $ubi = "") {


        $obj = new main();
        $view = new View();
        $data['ubigeo'] = $ubi;
        $data['id_even'] = $tipo_eve;
        $data['rows'] = $obj->get_sub_eventos($idevento);
        $data['idevento'] = $idevento;
        $view->setData($data);
        $view->setTemplate('../view/evento_proyeccion_social/_sub_eventos.php');
        return $view->renderPartial();
    }

    public function leer_pre_actividades($idevento) {

        $obj = new main();
        $view = new View();
        $data = array();
        $data['id_evnt'] = $idevento;
        $datos = $data['rows'] = $obj->get_pre_actividades($idevento);
//        print_r($datos);exit;
        $view->setData($data);
        $view->setTemplate('../view/evento_proyeccion_social/_pre_actividades.php');
        return $view->renderPartial();
    }

    public function leer_pre_actividades_sinUpdate($idevento) {

        $obj = new main();
        $view = new View();
        $data = array();
        $datos = $data['rows'] = $obj->get_pre_actividades($idevento);
//        print_r($datos);exit;
        $view->setData($data);
        $view->setTemplate('../view/evento_proyeccion_social/_pre_actividades.php');
        return $view->renderPartial();
    }

    public function SelectActual($p) {
        $obj = new Main();
//        $obj->table = $p['table'];
        $data = array();

        $data['rows'] = $obj->getSemestreActual();
        $data['name'] = $p['name'];
        $data['id'] = $p['id'];
        $data['code'] = $p['code'];
        $data['disabled'] = $p['disabled'];
        $view = new View();
        $view->setData($data);
        $view->setTemplate('../view/_Select.php');
        return $view->renderPartial();
    }

    public function cinco_ultimos_semestres($p) {
        $obj = new Main();
//        $obj->table = $p['table'];
        $data = array();

        $data['rows'] = $obj->cinco_ultimos_semestres();
        $data['name'] = $p['name'];
        $data['id'] = $p['id'];
        $data['code'] = $p['code'];
        $data['disabled'] = $p['disabled'];
        $view = new View();
        $view->setData($data);
        $view->setTemplate('../view/_Select.php');
        return $view->renderPartial();
    }

    public function Datos_grilla($p) {
        $obj = new Main();
//        $obj->table = $p['table'];
//        $obj->criterio = $p['criterio1'];
        $obj->criterio = $p['criterio'];
        $obj->filtro = $p['filtro'];
//        $obj->filtro1 = $p['filtro1'];
        $data = array();

        $data['rows'] = $obj->getDatos_grilla();

        $data['name'] = $p['name'];
        $data['id'] = $p['id'];
        $data['code'] = $p['code'];
        $data['disabled'] = $p['disabled'];
        $view = new View();
        $view->setData($data);
        $view->setTemplate('../view/_tabla.php');
        return $view->renderPartial();
    }

    public function mostrar_semestre_ultimo() {
        $obj = new Main();
        $semestre_ultimo = $obj->mostrar_semestre_ultimo();
        return $semestre_ultimo;
    }

    public function Datos_grilla_facultad($p) {
        $obj = new Main();
        $obj->criterio = $p['criterio'];
        $obj->filtro = $p['filtro'];
        $obj->criterio2 = $p['criterio2'];
        $obj->filtro2 = $p['filtro2'];
        $data = array();

        $data['rows'] = $obj->getDatos_grilla_facultad();

        $data['name'] = $p['name'];
        $data['id'] = $p['id'];
        $data['code'] = $p['code'];
        $data['disabled'] = $p['disabled'];
        $data['modovista'] = $p['modovista'];
        $view = new View();
        $view->setData($data);
        $view->setTemplate('../view/_tabla.php');
        return $view->renderPartial();
    }

    public function mostrar_mis_asistencias_eventos_tutoria_alumno($p) {

        $obj = new Main();

        $obj->criterio = $p['criterio'];
        $obj->criterio2 = $p['criterio2'];
        $data = array();

        $data['rows'] = $obj->get_mostrar_mis_asistencias_eventos_tutoria_alumno();
        $data['name'] = $p['name'];
        $data['id'] = $p['id'];
        $data['code'] = $p['code'];
        $data['disabled'] = $p['disabled'];
        $view = new View();
        $view->setData($data);
        $view->setTemplate('../view/_tabla_mis_asistencias_alumno.php');
        return $view->renderPartial();
    }

    public function Pagination2($p) {
        $data = array();
        $data['rows'] = $p['rows'];
        $data['query'] = $p['query'];
        $data['url'] = $p['url'];
        $data['fac'] = $p['fac'];
        $data['criterio'] = $p['criterio'];
        $view = new View();
        $view->setData($data);
        $view->setTemplate('../view/_Pagination2.php');
        return $view->renderPartial();
    }

    public function Lista($p) {
        $obj = new Main();
//        $obj->table = $p['table'] no uso tabla;
        $data = array();

        $data['rows'] = $obj->getList();
        $data['name'] = $p['name'];
        $data['id'] = $p['id'];
        $data['code'] = $p['code'];
        $data['disabled'] = $p['disabled'];
        $view = new View();
        $view->setData($data);
        $view->setTemplate('../view/_Lista.php');
        return $view->renderPartial();
    }

    public function grilla($name, $columns, $rows, $options, $pag, $edit, $view, $select = false, $new = true, $asig, $chek, $presidente) {
        $obj = new Main();
        $data = array();
        $data['nr'] = $obj->getnr();
        $data['cols'] = $columns;
        $data['rows'] = $rows;
        $data['edit'] = $edit;
        $data['view'] = $view;
        $data['select'] = $select;
        $data['name'] = $name;
        $data['pag'] = $pag;
        $data['new'] = $new;
        $data['asig'] = $asig;
        $data['chek'] = $chek;
        $data['presidente'] = $presidente;
        $data['combo_search'] = $this->Combo_Search($options);
        $view = new View();
        $view->setData($data);
        $view->setTemplate('../view/_grilla.php');
        $view->setLayout('../template/Layout.php');
        return $view->renderPartial();
    }

    public function grilla2($name, $columns, $rows, $options, $pag, $edit, $view, $select = false, $new = true, $asig, $chek, $presidente, $cheket_estado_asignacion = false) {
        $obj = new Main();
        $data = array();
        $data['nr'] = $obj->getnr();
        $data['cols'] = $columns;
        $data['rows'] = $rows;
        $data['edit'] = $edit;
        $data['view'] = $view;
        $data['select'] = $select;
        $data['name'] = $name;
        $data['pag'] = $pag;
        $data['new'] = $new;
        $data['asig'] = $asig;
        $data['chek'] = $chek;
        $data['presidente'] = $presidente;
        $data['cheket_estado_asignacion'] = $cheket_estado_asignacion;
        $data['combo_search'] = $this->Combo_Search($options);
        $view = new View();
        $view->setData($data);
        $view->setTemplate('../view/_grilla_asig_tuto.php');
        $view->setLayout('../template/Layout.php');
        return $view->renderPartial();
    }

    public function Select1($p) {
        $obj = new Main();
//        $obj->table = $p['table'];
        $obj->filtro = $p['filtro'];
        $data = array();
        $data['rows'] = $obj->getSemestre();
        $data['name'] = $p['name'];

        $data['id'] = $p['id'];
        $data['code'] = $p['code'];
        $data['disabled'] = $p['disabled'];
        $view = new View();
        $view->setData($data);
        $view->setTemplate('../view/_Selectlista.php');
        return $view->renderPartial();
    }

    public function SelectD($p) {
        $obj = new Main();
//        $obj->table = $p['table'];
        $obj->filtro = $p['filtro'];
        $data = array();
        $data['rows'] = $obj->getSemestreD();
        $data['name'] = $p['name'];

        $data['id'] = $p['id'];
        $data['code'] = $p['code'];
        $data['disabled'] = $p['disabled'];
        $view = new View();
        $view->setData($data);
        $view->setTemplate('../view/_Selectlista.php');
        return $view->renderPartial();
    }

    public function Select_ajax($p) {
        $obj = new Main();
        $obj->table = $p['table'];
        $obj->filtro = $p['filtro'];
        $obj->criterio = $p['criterio'];
        $data = array();
        $data['rows'] = $obj->getList_ajax();
        $data['name'] = $p['name'];
        $data['id'] = $p['id'];
        $data['disabled'] = $p['disabled'];
        $view = new View();
        $view->setData($data);
        $view->setTemplate('../view/_Select_ajax.php');
        return $view->renderPartial();
    }

    public function Select_tipo_biblio($p) {
        $obj = new Main();
        $obj->table = $p['table'];
        $obj->filtro = 0;
        $obj->criterio = 0;
        $data = array();
        $data['rows'] = $obj->getList_ajax();
        $data['name'] = $p['name'];
        $data['id'] = $p['id'];
        $data['disabled'] = $p['disabled'];
        $view = new View();
        $view->setData($data);
        $view->setTemplate('../view/_Edit_Silabo_biblio.php');
        return $view->renderPartial();
    }

    public function Select_ajax_string($p) {
        $obj = new Main();
        $obj->table = $p['table'];
        $obj->filtro = $p['filtro'];
        $obj->criterio = $p['criterio'];
        $data = array();
        $data['rows'] = $obj->getList_ajax_string();
        $data['name'] = $p['name'];
        $data['id'] = $p['id'];
        $data['disabled'] = $p['disabled'];
        $view = new View();
        $view->setData($data);
        $view->setTemplate('../view/_Select_ajax.php');
        return $view->renderPartial();
    }

    public function lista_recibir($p) {
        $obj = new Main();
//        $obj->table = $p['table'];
        $obj->filtro = $p['filtro'];
        $obj->criterio = $p['criterio'];
        $obj->filtro1 = $p['filtro1'];
        $obj->criterio1 = $p['criterio1'];
        $data = array();
        $data['rows'] = $obj->getLista();
        $data['rows3'] = $obj->estadoSilAlu();
//        $data['name'] = $p['name'];
//        $data['id'] = $p['id'];
        $data['disabled'] = $p['disabled'];
        $view = new View();
        $view->setData($data);
        $view->setTemplate('../view/_Lista_ajax.php');
        return $view->renderPartial();
    }

    //lista de alumnos del curso seleccionado x el docente

    public function grilla_notasproyecto($p) {
        $obj = new Main();
//        $obj->table = $p['table'];
////        $obj->criterio = $p['criterio1'];
//        $obj->criterio = $p['criterio'];
//        $obj->filtro = $p['filtro'];
//        $obj->filtro1 = $p['filtro1'];
        $data = array();

        $data['rows'] = $obj->getDatos_grilla_notasproyecto();
        $data['name'] = $p['name'];
        $data['id'] = $p['id'];
        $data['code'] = $p['code'];
        $data['disabled'] = $p['disabled'];
        $view = new View();
        $view->setData($data);
        $view->setTemplate('../view/notasproyecto.php');
        return $view->renderPartial();
    }

    public function Lista_recibir_A($p) {
        $obj = new Main();
//        $obj->table = $p['table'];
        $obj->filtro = $p['filtro'];
        $obj->criterio = $p['criterio'];
        $obj->filtro1 = $p['filtro1'];
        $obj->criterio1 = $p['criterio1'];
        $obj->opt = $p['opcion'];
        $data = array();
        if ($obj->opt == "A") {
            $data['opcion'] = "normal";
        } else {
            $data['opcion'] = "asistencia";
        }
        $data['rows'] = $obj->getListaA();
//        $data['name'] = $p['name'];
//        $data['id'] = $p['id'];
        $data['disabled'] = $p['disabled'];
        $view = new View();
        $view->setData($data);

        $view->setTemplate('../view/_tablaA.php');
        return $view->renderPartial();
    }

    public function FiltroEditar_P($p) {
        $obj = new Main();
        $obj->criterio = $p['criterio'];
        $data = array();
        $data['rows'] = $obj->getDatos_FiltroEditar();
        $data['disabled'] = $p['disabled'];
        $view = new View();
        $view->setData($data);
        $view->setTemplate('../view/_filtroEditar.php');
        return $view->renderPartial();
    }

//    public function Nombre_curso($p) {
//        
//        $obj = new Main();
////        $obj->table = $p['table'];
//        $obj->filtro = $p['filtro'];
//        $obj->criterio = $p['criterio'];
//         
//        $data = array();
//        $data['rows'] = $obj->getNombre();
////        $data['name'] = $p['name'];
////        $data['id'] = $p['id'];
//        $data['disabled'] = $p['disabled'];
//        $view = new View();
//        $view->setData($data);
//       $view->setTemplate('../view/_Silabo.php');
//        return $view->renderPartial();
//    }

    public function genSilabo($p) {
        $obj = new Main();
//        $obj->table = $p['table'];
        $obj->filtro = 0;
        $obj->criterio = 0;
        $obj->cod = $p['filtro']; # codsemestre
        $obj->filtro1 = $p['filtro1']; # codcruso
        $obj->filtro2 = $p['filtro2']; #codsilabo

        $data = array();
        $data['rows'] = $obj->silDG();
        $data['rows2'] = $obj->silUni();
        $data['rows3'] = $obj->getTema();
        $data['rows4'] = $obj->getBibliografiaS();
        $data['rows5'] = $obj->getSyllabus_P4();
        $data['disabled'] = $p['disabled'];
        $view = new View();
        $view->setData($data);
        $view->setTemplate('../view/_generarSilabo.php');
        return $view->renderPartial();
    }

    public function Lista_recibir_A2($p) {
        $obj = new Main();
//        $obj->table = $p['table'];
        $obj->filtro = $p['filtro'];
        $obj->criterio = $p['criterio'];
        $obj->filtro1 = $p['filtro1'];
        $obj->criterio1 = $p['criterio1'];
        $data = array();
        $data['rows'] = $obj->getListaA();
        $data['rows2'] = $obj->getSyllabus_P();
        $data['rows3'] = $obj->getRetornoN();
        $data['notas_py']=$obj->getNotaspy();
        $data['rows4'] = $obj->getSyllabus_P3();
        //$data['eval'] = $obj->getEvaluacion3();
        
        foreach ( $data['rows'] as $key => $value){
            //foreach al alumno(rows) para recontruir el array de rows_notas_tutoria 
              $data['rows_notas_tutoria'][$value['CodigoAlumno']] = array('nota_tutoria'=>$this->mostrar_nota_tutoria(array('CodigoAlumno'=>$value['CodigoAlumno'],'CodigoSemestre'=>$obj->criterio1)));
            
        }
//       echo "<div align='left'><pre>"; print_r( $data['rows_notas_tutoria']);echo "</div>";exit;
        
//        $data['name'] = $p['name'];
//        $data['id'] = $p['id'];
        $data['disabled'] = $p['disabled'];
        $view = new View();
        $view->setData($data);
        $view->setTemplate('../view/_tablaN.php');
        return $view->renderPartial();
    }

    public function Syllabus_P($p) {
        $obj = new Main();
//        $obj->table = $p['table'];
        $obj->filtro = $p['filtro'];
        $obj->criterio = $p['criterio'];
        $obj->filtro1 = $p['filtro1'];
        $obj->criterio1 = $p['criterio1'];
        $data = array();
        $data['rows'] = $obj->getSyllabus_P();
        $data['rows3'] = $obj->getEvaluacion3();

//        $data['name'] = $p['name'];
//        $data['id'] = $p['id'];
        $data['disabled'] = $p['disabled'];
        $view = new View();
        $view->setData($data);
        $view->setTemplate('../view/_Silabo.php');
        return $view->renderPartial();
    }

    public function Lista_notas($p) {
        $obj = new Main();
        $obj->criterio = $p['criterio'];
        $obj->criterio1 = $p['criterio1'];
        $obj->criterio2 = $p['criterio2'];
        $data = array();
        $data['rows'] = $obj->getRetornoN();
        $data['disabled'] = $p['disabled'];
        $view = new View();
        $view->setData($data);
        $view->setTemplate('../view/_nota.php');
        return $view->renderPartial();
    }

    //holaaaaaaaaaa
// mando la lista de los cursos del docente x la carga academica segun el semestre seleccionado
    public function lista_recibir_D($p) {
        $obj = new Main();
//        $obj->table = $p['table'];
        $obj->filtro = $p['filtro'];
        $obj->criterio = $p['criterio'];
        $obj->filtro1 = $p['filtro1'];
        $obj->criterio1 = $p['criterio1'];
        $data = array();
        $data["id"] = $p['criterio'];
        $data['rows'] = $obj->getListaD();
        $data['rows2'] = $obj->estadoSil();

//        $data['name'] = $p['name'];
//        $data['id'] = $p['id'];
        $data['disabled'] = $p['disabled'];
        $view = new View();
        $view->setData($data);
        $view->setTemplate('../view/_Lista_ajax.php');
        return $view->renderPartial();
    }

    public function silabus_recibir($p) {
        $obj = new Main();
//        $obj->table = $p['table'];
        $obj->filtro = $p['filtro'];
        $obj->criterio = $p['criterio'];
        $obj->filtro1 = $p['filtro1'];
        $obj->criterio1 = $p['criterio1'];

        $data = array();
        $data['rows'] = $obj->getSilabu();

        $data['disabled'] = $p['disabled'];
        $view = new View();
        $view->setData($data);
        $view->setTemplate('../view/_Silabo.php');
        return $view->renderPartial();
    }

    public function detalle_silabus($p) {

        $obj = new Main();
        
//        $obj->table = $p['table'];
        $obj->filtro = $p['filtro'];
        $obj->criterio0 = $p['criterio0'];
        $obj->criterio = 'idunidad';
        $obj->filtro1 = $p['filtro1'];
        $obj->criterio1 = $p['criterio1'];

        $data = array();
        $data['rows'] = $obj->getdatos_Silabu();
        $data['rows3'] = $obj->getEvaluacion();
        $data['rows4'] = $obj->getTipEva();

        $data['disabled'] = $p['disabled'];
        $view = new View();
        $view->setData($data);
        $view->setTemplate('../view/_Edit_Silabo.php');
        return $view->renderPartial();
    }

    public function bibliografia_silabus($p) {

        $obj = new Main();
        $datab = array();
        $datab['rows22'] = $obj->getBibliografia();
        //print_r(($datab['rows22']));
        $datab['disabled'] = $p['disabled'];
        $view = new View();
        $view->setData($datab);
        $view->setTemplate('../view/_Edit_Silabo_biblio.php');
        return $view->renderPartial();
    }

    public function unidad_recibir($p) {
        $obj = new Main();
        $uni = new semestre();
//        $obj->table = $p['table'];
        $obj->filtro = $p['filtro'];
        $obj->criterio = $p['criterio'];
        $obj->filtro1 = $p['filtro1'];
        $obj->criterio1 = $p['criterio1'];
        $uni->codSemestre = $p['criterio1'];
        $obj->opt = $p['option'];

        $data = array();
        $data['rows'] = $obj->getUnidad();
        $data['uni'] = $uni->ver();
        if ($obj->opt == 'dsa') {
            $data['rows2'] = "boton";
        } else {
            $data['rows2'] = "";
        }

        $data['disabled'] = $p['disabled'];
        $view = new View();
        $view->setData($data);

        if ($obj->opt == 'S') {
            $view->setTemplate('../view/_SinUnidad.php');
        } else {

            $view->setTemplate('../view/_Unidad.php');
        }
        return $view->renderPartial();
    }

    public function unidad_recibirid($p) {
        $obj = new Main();
//        $obj->table = $p['table'];
        $obj->filtro = $p['filtro'];
        $obj->criterio = $p['criterio'];
        $obj->filtro1 = $p['filtro1'];
        $obj->criterio1 = $p['criterio1'];



        $data = array();
        $data['rows'] = $obj->getUnidadid();

        $data['disabled'] = $p['disabled'];
        $view = new View();
        $view->setData($data);

        $view->setTemplate('../view/_Sipdf.php');


        return $view->renderPartial();
    }

//         public function silabus_recibirid($p) {
//        $obj = new Main();
////        $obj->table = $p['table'];
//        $obj->filtro = $p['filtro'];
//        $obj->criterio = $p['criterio'];
//         $obj->filtro1 = $p['filtro1'];
//        $obj->criterio1 = $p['criterio1'];
//       
//       
//        $data = array();
//        $data['rows2'] = $obj->getSilabusid();
//
//        $data['disabled'] = $p['disabled'];
//        $view = new View();
//        $view->setData($data);
//       
//        $view->setTemplate('../view/_Sipdf.php');
//        
//       
//        return $view->renderPartial();
//        
//        }


    public function notas_alumno($p) {
        $obj = new Main();
//        $obj->table = $p['table'];
        $obj->filtro2 = $p['filtro2'];
        $obj->criterio2 = $p['criterio2'];
        $obj->criterio1 = $p['criterio1'];
        $obj->criterio = $p['criterio'];
        $obj->filtro = $p['filtro'];
        $obj->filtro1 = $p['filtro1'];

        $obj->opcion = $p['opcion'];
        $data = array();
        $data['rows'] = $obj->getSyllabus_P5();
        $data['rows1'] = $obj->getNotasPro2();
        $data['disabled'] = $p['disabled'];
        $view = new View();
        $view->setData($data);

        $view->setTemplate('../view/_tablaM.php');



        return $view->renderPartial();
    }

    public function tema_recibir($p) {
        $obj = new Main();
//        $obj->table = $p['table'];
        $obj->filtro = $p['filtro'];
        $obj->criterio = $p['criterio'];

        $obj->opcion = $p['opcion'];
        $data = array();
        $data['rows'] = $obj->getTema();

        $data['disabled'] = $p['disabled'];
        $view = new View();
        $view->setData($data);
        if ($obj->opcion == 'A') {
            $view->setTemplate('../view/_SinTema.php');
        } else {

            if ($obj->opcion == 'B') {
                $view->setTemplate('../view/_TemaA.php');
            } else {
                $view->setTemplate('../view/_Tema.php');
            }
        }

        return $view->renderPartial();
    }

    public function evaluacion_recibir($p) {
        $obj = new Main();
        $eva = new evaluacion();
        $obj->criterio = $p['criterio'];
        $data = array();
        $data['rows'] = $obj->getEvaluacion();
        $data['eva']  = $eva->getTipoEva();
        $data['disabled'] = $p['disabled'];
        $view = new View();
        $view->setData($data);
        $view->setTemplate('../view/_evaluacion.php');
        return $view->renderPartial();
    }

    public function tema_recibirF($p) {
        $obj = new Main();
//        $obj->table = $p['table'];
        $obj->filtro = $p['filtro'];
        $obj->criterio = $p['criterio'];

        $obj->opcion = $p['opcion'];
        $data = array();
        $data['rows2'] = $obj->getTema();

        $data['disabled'] = $p['disabled'];
        $view = new View();
        $view->setData($data);

        $view->setTemplate('../view/_Sipdf.php');


        return $view->renderPartial();
    }

//     public function Clase_recibir($p) {
//        $obj = new Main();
////        $obj->table = $p['table'];
//        $obj->filtro = $p['filtro'];
//        $obj->criterio = $p['criterio'];
//        
//        
//        $data = array();
//        $data['rows2'] = $obj->getClase();
//
//        $data['disabled'] = $p['disabled'];
//        $view = new View();
//        $view->setData($data);
//        
//        $view->setTemplate('../view/_TemaA.php');
//        
//        
//        return $view->renderPartial();
//    }




    public function bibliografia_recibir($p) {
        $obj = new Main();
//        $obj->table = $p['table'];
        $obj->filtro = $p['filtro'];
        $obj->criterio = $p['criterio'];

        $obj->opcion = $p['opcion'];
        $data = array();
        $data['rows4'] = $obj->getBiblio();

        $data['disabled'] = $p['disabled'];
        $view = new View();
        $view->setData($data);


        $view->setTemplate('../view/_Edit_Silabo.php');


        return $view->renderPartial();
    }

//     public function Datos_grilla($p) {
//        $obj = new Main();
////        $obj->table = $p['table'];
//        $obj->filtro = $p['filtro'];
//        $obj->criterio = $p['criterio'];
//         $obj->filtro1 = $p['filtro1'];
//        $obj->criterio1 = $p['criterio1'];
//       
//        $data = array();
//        $data['rows'] = $obj->getSilabu();
//
//        $data['disabled'] = $p['disabled'];
//        $view = new View();
//        $view->setData($data);
//        $view->setTemplate('../view/_Silabo.php');
//        return $view->renderPartial();
//    }

    public function Select_ajax_string_dis($p) {
        $obj = new Main();
        $obj->table = $p['table'];
        $obj->filtro = $p['filtro'];
        $obj->criterio = $p['criterio'];
        $data = array();
        $data['rows'] = $obj->getList_ajax_string_dis();
        $data['name'] = $p['name'];
        $data['id'] = $p['id'];
        $data['code'] = $p['code'];
        $data['disabled'] = $p['disabled'];
        $view = new View();
        $view->setData($data);
        if ($p['ajax']) {
            $view->setTemplate('../view/_Select_ajax.php');
        } else {
            $view->setTemplate('../view/_Select.php');
        }
        return $view->renderPartial();
    }

    public function Pagination($p) {
        $data = array();
        $data['rows'] = $p['rows'];
        $data['query'] = $p['query'];
        $data['url'] = $p['url'];
        $view = new View();
        $view->setData($data);
        $view->setTemplate('../view/_Pagination.php');
        return $view->renderPartial();
    }

    public function grilla_E_PS_EU($name, $columns, $rows, $options, $pag, $edit, $view, $select = false, $new = true, $ver_detalles = false, $unirse = false, $unirse_profesor = false) {
        $obj = new Main();
        $data = array();
        $data['nr'] = $obj->getnr();
        $data['cols'] = $columns;
        $data['rows'] = $rows;
        $data['edit'] = $edit;
        $data['view'] = $view;
        $data['select'] = $select;
        $data['name'] = $name;
        $data['pag'] = $pag;
        $data['new'] = $new;
        $data['ver_detalles'] = $ver_detalles;
        $data['unirse'] = $unirse;
        $data['unirse_profesor'] = $unirse_profesor;
        $data['combo_search'] = $this->Combo_Search($options);
        $view = new View();
        $view->setData($data);
        $view->setTemplate('../view/_grilla_E_PS_EU.php');
        $view->setLayout('../template/Layout.php');
        return $view->renderPartial();
    }

    public function getFiels($p) {
        $obj = new Main();
        $obj->tabla = $p['tabla'];
        $obj->campo = $p['campo'];
        $obj->idtabla = $p['idtabla'];
        $datos = $obj->getFiels($p);
        return $datos;
    }

    public function Combo_Search($options) {
        $data = array();
        $data['options'] = $options;
        $view = new View();
        $view->setData($data);
        $view->setTemplate('../view/_Combo_Search.php');
        return $view->renderPartial();
    }

    public function grilla_proyecto($p) {
        $obj = new Main();
//        $obj->table = $p['table'];
////        $obj->criterio = $p['criterio1'];
//        $obj->criterio = $p['criterio'];
//        $obj->filtro = $p['filtro'];
//        $obj->filtro1 = $p['filtro1'];
        $data = array();
        //print_r($p); exit();
        $data['rows'] = $obj->getDatos_grilla_proyecto();
        $data['rows2'] = $obj->getDatos_grilla_objetivos();
        $data['rows3'] = $obj->getDatos_grilla_docentes();
        $data['rows4'] = $obj->getDatos_grilla_alumnos();
        $data['rows5'] = $obj->getDatos_grilla_alumnos2();
        $data['name'] = $p['name'];
        $data['id'] = $p['id'];
        $data['code'] = $p['code'];
        $data['disabled'] = $p['disabled'];
        $view = new View();
        $view->setData($data);
        $view->setTemplate('../view/_tabla2.php');
        return $view->renderPartial();
    }

    public function grilla_solicitaproyecto($p) {
        $obj = new Main();
//        $obj->table = $p['table'];
////        $obj->criterio = $p['criterio1'];
//        $obj->criterio = $p['criterio'];
//        $obj->filtro = $p['filtro'];
//        $obj->filtro1 = $p['filtro1'];
        $data = array();

        $data['rows'] = $obj->getDatos_grilla_solicitaproyectos();

        $data['name'] = $p['name'];
        $data['id'] = $p['id'];
        $data['code'] = $p['code'];
        $data['disabled'] = $p['disabled'];
        $view = new View();
        $view->setData($data);
        $view->setTemplate('../view/_tabla4.php');
        return $view->renderPartial();
    }

    public function grilla_miproyecto($p) {
        $obj = new Main();
//        $obj->table = $p['table'];
////        $obj->criterio = $p['criterio1'];
//        $obj->criterio = $p['criterio'];
//        $obj->filtro = $p['filtro'];
//        $obj->filtro1 = $p['filtro1'];
        $data = array();
        /*if($_REQUEST['semestre']==null){
            $_REQUEST['semestre']=  $this->mostrar_semestre_ultimo();        
    }*/
//    echo $_REQUEST['semestre'];exit;
        $data['rows'] = $obj->getDatos_grilla_miproyecto($_REQUEST['semestre']);
        //print_r($data['rows']);exit;
        $data['rows1'] = $obj->getNotasPro2();
        $data['name'] = $p['name'];
        $data['id'] = $p['id'];
        $data['code'] = $p['code'];
        $data['disabled'] = $p['disabled'];
            $data['semestreacademico'] = $this->SelectD(array('id' => 'semestreacademico', 'name' =>'semestreacademico','filtro'=>$_SESSION['idusuario']));
        $view = new View();
        $view->setData($data);
        $view->setTemplate('../view/_tabla3.php');
        return $view->renderPartial();
    }
public function grilla_miproyecto2($p) {
        $obj = new Main();
//        $obj->table = $p['table'];
////        $obj->criterio = $p['criterio1'];
//        $obj->criterio = $p['criterio'];
//        $obj->filtro = $p['filtro'];
//        $obj->filtro1 = $p['filtro1'];
        $data = array();
        if($_REQUEST['semestre']==null){
            $_REQUEST['semestre']=  $this->mostrar_semestre_ultimo();        
    }
        $data['rows'] = $obj->getDatos_grilla_miproyecto($_REQUEST['semestre']);
        $data['rows1'] = $obj->getNotasPro();
        $data['name'] = $p['name'];
        $data['id'] = $p['id'];
        $data['code'] = $p['code'];
        $data['disabled'] = $p['disabled'];
            $data['semestreacademico'] = $this->SelectD(array('id' => 'semestreacademico', 'name' =>'semestreacademico','filtro'=>$_SESSION['idusuario']));
        $view = new View();
        $view->setData($data);
        $view->setTemplate('../view/_tabla3_2.php');
        return $view->renderPartial();
    }
    public function pdf_proyecto($p) {
        $obj = new Main();
//        $obj->table = $p['table'];
////        $obj->criterio = $p['criterio1'];
//        $obj->criterio = $p['criterio'];
//        $obj->filtro = $p['filtro'];
//        $obj->filtro1 = $p['filtro1'];
        $data = array();

        $data['rows'] = $obj->getDetalle_proyecto();
        $data['rows2'] = $obj->getDatos_grilla_objetivos();
        $data['rows3'] = $obj->getDatos_grilla_docentes();
        $data['rows4'] = $obj->getDatos_grilla_alumnos();
        $data['name'] = $p['name'];
        $data['id'] = $p['id'];
        $data['code'] = $p['code'];
        $data['disabled'] = $p['disabled'];
        $view = new View();
        $view->setData($data);
        $view->setTemplate('../view/_Pdf.php');
        return $view->renderPartial();
    }

    public function Detalle_Proyecto_P($p) {
        $obj = new Main();
        $obj->criterio = $p['criterio'];
        $data = array();
        $data['rows'] = $obj->getDetalle_proyecto();
        $data['disabled'] = $p['disabled'];
        $view = new View();
        $view->setData($data);
        $view->setTemplate('../view/_Detalle.php');
        return $view->renderPartial();
    }

    public function Detalle_Proyecto1_P($p) {
        $obj = new Main();
        $obj->criterio = $p['criterio'];
        $data = array();
        $data['rows'] = $obj->getDetalle_proyecto();
        $data['disabled'] = $p['disabled'];
        $view = new View();
        $view->setData($data);

        $view->setTemplate('../view/_Detalle1.php');
        return $view->renderPartial();
    }

    public function Calificaiones($p) {
        $obj = new Main();
//        $obj->table = $p['table'];
        $obj->alumno = $p['alumno'];
        $obj->nota = $p['notas'];
        $obj->evaluacion = $p['evaluacion'];


//         var_dump($obj->nota);
//         exit();

        $data = array();
        $data['rows'] = $obj->Insertar();

        $data['disabled'] = $p['disabled'];
        $mensaje = 'Se inserto correctamente';

        return $mensaje;
    }

    public function Asistencia($p) {
        $obj = new Main();
//        $obj->table = $p['table'];
        $obj->alumno = $p['alumno'];

        $obj->asistencia = $p['asistencia'];

        $obj->clase = $p['clase'];


//         var_dump($obj->asistencia);
//         exit();

        $data = array();
        $data['rows'] = $obj->InsertarA();

        $data['disabled'] = $p['disabled'];
        $mensaje = 'Se inserto correctamente';

        return $data;
    }

    public function grilla_informativo($p) {
        $obj = new Main();
//        $obj->table = $p['table'];
////        $obj->criterio = $p['criterio1'];
//        $obj->criterio = $p['criterio'];
//        $obj->filtro = $p['filtro'];
//        $obj->filtro1 = $p['filtro1'];
        $data = array();

        $data['rows'] = $obj->getDatos_web_informativo();
        $data['rows2'] = $obj->getDatos_web_evento();
        $data['rows3'] = $obj->getDatos_web_noticias();
        $data['rows4'] = $obj->getDatos_web_contenido();
        $data['rows5'] = $obj->getDatos_web_desarrolladores();
        $data['name'] = $p['name'];
        $data['id'] = $p['id'];
        $data['code'] = $p['code'];
        $data['disabled'] = $p['disabled'];
        $view = new View();
        $view->setData($data);
        $view->setTemplate('../contenido.php');
        return $view->renderPartial();
    }

    public function ListaProyecto_P($p) {
        $obj = new Main();
        $obj->criterio = $p['criterio'];
        $data = array();
        $data['rows'] = $obj->getDetalle_proyecto();
        $data['disabled'] = $p['disabled'];
        $view = new View();
        $view->setData($data);
        $view->setTemplate('../view/_Proyecto.php');
        return $view->renderPartial();
    }

    public function Marco_P($p) {
        $obj = new Main();
        $obj->criterio = $p['criterio'];
        $data = array();
        $data['rows'] = $obj->getDetalle_proyecto();
        $data['disabled'] = $p['disabled'];
        $view = new View();
        $view->setData($data);
        $view->setTemplate('../view/_Marco.php');
        return $view->renderPartial();
    }

    public function Metodologia_P($p) {
        $obj = new Main();
        $obj->criterio = $p['criterio'];
        $data = array();
        $data['rows'] = $obj->getDetalle_proyecto();
        $data['disabled'] = $p['disabled'];
        $view = new View();
        $view->setData($data);
        $view->setTemplate('../view/_Metodologia.php');
        return $view->renderPartial();
    }

    public function Aspectos_P($p) {
        $obj = new Main();
        $obj->criterio = $p['criterio'];
        $data = array();
        $data['rows'] = $obj->getDetalle_proyecto();
        $data['disabled'] = $p['disabled'];
        $view = new View();
        $view->setData($data);
        $view->setTemplate('../view/_Aspectos.php');
        return $view->renderPartial();
    }

    public function ListaAlumno_P($p) {
        $obj = new Main();
        $obj->criterio = $p['criterio'];
        $data = array();
        $data['rows'] = $obj->getDatos_grilla_alumnos();
        $data['disabled'] = $p['disabled'];
        $view = new View();
        $view->setData($data);
        $view->setTemplate('../view/_Alumno.php');
        return $view->renderPartial();
    }
    public function ListaAlumno_Pro($p) {
        $obj = new Main();
        $obj->criterio = $p['criterio'];
        $data = array();
        $data['rows'] = $obj->getDatos_grilla_alumnos();
        $data['rows1'] = $obj->getNotasPro($this->mostrar_semestre_ultimo());
        $data['disabled'] = $p['disabled'];
        $view = new View();
        $view->setData($data);
        $view->setTemplate('../view/_AlumnosP.php');
        return $view->renderPartial();
    }
    public function ListaAlumno1_P($p) {
        $obj = new Main();
        $obj->criterio = $p['criterio'];
        $data = array();
        $data['rows'] = $obj->getDatos_grilla_alumnos();
        $data['disabled'] = $p['disabled'];
        $view = new View();
        $view->setData($data);
        $view->setTemplate('../view/_Alumno1.php');
        return $view->renderPartial();
    }

    public function ListaDocente_P($p) {
        $obj = new Main();
        $obj->criterio = $p['criterio'];
        $data = array();
        $data['rows'] = $obj->getDatos_grilla_docentes();
        $data['disabled'] = $p['disabled'];
        $view = new View();
        $view->setData($data);
        $view->setTemplate('../view/_Docente.php');
        return $view->renderPartial();
    }

    public function ListaPdf_P($p) {
        $obj = new Main();
        $obj->criterio = $p['criterio'];
        $data = array();
        $data['rows'] = $obj->getDetalle_proyecto();
        $data['disabled'] = $p['disabled'];
        $view = new View();
        $view->setData($data);
        $view->setTemplate('../view/_Pdf.php');
        return $view->renderPartial();
    }

    public function Actividad_P($p) {
        $obj = new Main();
        $obj->criterio = $p['criterio'];
        $data = array();
        $data['rows'] = $obj->getDatos_Actividades();
        $data['disabled'] = $p['disabled'];
        $view = new View();
        $view->setData($data);
        $view->setTemplate('../view/_Actividad.php');
        return $view->renderPartial();
    }

    public function Notas_P($p) {
        $obj = new Main();
        $obj->criterio = $p['criterio'];
        $data = array();
        $data['rows'] = $obj->getVerNotasProyecto();
        $data['disabled'] = $p['disabled'];
        $view = new View();
        $view->setData($data);
        $view->setTemplate('../view/_Notas.php');
        return $view->renderPartial();
    }

    public function grilla_solicitudes($p) {
        $obj = new Main();
//        $obj->table = $p['table'];
////        $obj->criterio = $p['criterio1'];
//        $obj->criterio = $p['criterio'];
//        $obj->filtro = $p['filtro'];
//        $obj->filtro1 = $p['filtro1'];
        $data = array();

        $data['rows'] = $obj->getDatos_grilla_solicitudes();
        $data['name'] = $p['name'];
        $data['id'] = $p['id'];
        $data['code'] = $p['code'];
        $data['disabled'] = $p['disabled'];
        $view = new View();
        $view->setData($data);
        $view->setTemplate('../view/solicitudes.php');
        return $view->renderPartial();
    }
    //MIUTCHELL
    public function grilla_cca($name,$name2,$accion, $columns, $rows, $options, $pag, $boton1,$boton2,$edit, $view, $select = false, $new = true,$asig,$chek,$presidente) {
        $obj = new Main();
        $data = array();
        $data['nr'] = $obj->getnr();
        $data['cols'] = $columns;
        $data['rows'] = $rows;
        $data['boton1']=$boton1;
        $data['boton2']=$boton2;
        $data['edit'] = $edit;
        $data['view'] = $view;
        $data['select'] = $select;
        $data['name'] = $name;
        $data['name2']=$name2;
        $data['accion']=$accion;
        $data['pag'] = $pag;
        $data['new'] = $new;
        $data['asig'] = $asig;
        $data['chek'] = $chek;
        $data['presidente'] = $presidente;
        $data['combo_search'] = $this->Combo_Search($options);
        $view = new View();
        $view->setData($data);
        $view->setTemplate('../view/_grilla_cca.php');
        $view->setLayout('../template/Layout.php');
        return $view->renderPartial();
    }
          
    public function lista_cca($name, $columns, $rows, $options, $pag,$pension,$requisitos, $detallar,$edit, $view, $select = false, $new = true,$asig,$chek,$presidente) {
        $obj = new Main();
        $data = array();
        $data['nr'] = $obj->getnr();
        $data['cols'] = $columns;
        $data['rows'] = $rows;
        $data['pension']=$pension;
        $data['requisitos']=$requisitos;
        $data['detallar']=$detallar;
        $data['edit'] = $edit;
        $data['view'] = $view;
        $data['select'] = $select;
        $data['name'] = $name;
        $data['pag'] = $pag;
        $data['new'] = $new;
        $data['asig'] = $asig;
        $data['chek'] = $chek;
        $data['presidente'] = $presidente;
        $data['combo_search'] = $this->Combo_Search($options);
        $view = new View();
        $view->setData($data);
        $view->setTemplate('../view/comision_cca/_Lista.php');
        $view->setLayout('../template/Layout.php');
        return $view->renderPartial();
    }
    
     public function SelectAsig($p) {
    
        $obj = new Main();
        $obj->table = $p['table'];
        $obj->idp = $p['idp'];
        $data = array();

        $data['rows'] = $obj->getListAsig();
        $data['name'] = $p['name'];
        $data['id'] = $p['id'];
        $data['code'] = $p['code'];
        $data['disabled'] = $p['disabled'];
        $view = new View();
        $view->setData($data);
        $view->setTemplate('../view/_Select.php');
        return $view->renderPartial();
    }
    
    public function SelectTipoEva($p) {
    
        $obj = new Main();
        $obj->table = $p['table'];
        $obj->idp = $p['idp'];
        $data = array();

        $data['rows'] = $obj->getListTipoEva();
        $data['name'] = $p['name'];
        $data['id'] = $p['id'];
        $data['code'] = $p['code'];
        $data['disabled'] = $p['disabled'];
        $view = new View();
        $view->setData($data);
        $view->setTemplate('../view/_Select.php');
        return $view->renderPartial();
    }
     public function mostrar_nota_tutoria($p) {
        $obj = new Main();
        if (empty($p['CodigoSemestre'])) {
            $obj->CodigoSemestre = $this->mostrar_semestre_ultimo();
        } else {
            $obj->CodigoSemestre = $p['CodigoSemestre'];
        }

        $obj->CodigoAlumno = $p['CodigoAlumno'];
        $obj->CodAlumnoSira = $p['CodAlumnoSira'];
        $data = $obj->mostrar_record_asistencias_tutoria();
        $data_Eu_Ps = $obj->mostrar_record_asistencias_Eu_Ps();
//       echo "<pre>"; print_r($data_Eu_Ps);exit;
        if (empty($data['CodigoAlumno'])) {
            return "No Se Encontro El Alumno Asignado o el Semestre como Parametros";
        } else {
            if (!empty($data_Eu_Ps['CodigoAlumno'])) { // si exite asistencias para eu y ps se saka sus notas, tambien de tutoria

                $cant_total_Eu_ps = $data_Eu_Ps['cant_asistencias'] + $data_Eu_Ps['cant_inasistencias'];
              
                $nota_Eu_ps = ($data_Eu_Ps['cant_asistencias'] / $cant_total_Eu_ps) * 20;
               
               $cant_total_tutoria = $data['cant_asistencias'] + $data['cant_inasistencias'];
               $nota_tutoria = ($data['cant_asistencias'] / $cant_total_tutoria) * 20;
//               echo $nota_Eu_ps;exit;
//               echo $data_Eu_Ps['cant_asistencias'].','.$data_Eu_Ps['cant_inasistencias'];exit;
//               echo $data['cant_asistencias'].','.$data['cant_inasistencias'];exit;
                return round($nota = ($nota_Eu_ps+ $nota_tutoria)/2) ;
//              return $nota = round((($data_Eu_Ps['cant_asistencias']+ $data['cant_asistencias'])/($cant_total_Eu_ps+$cant_total_tutoria))*20) ;
                
            } else { //solo nota tutoria por que no tiene eu y ps
              
             $cant_total = $data['cant_asistencias'] + $data['cant_inasistencias'];
              return round($nota = ($data['cant_asistencias'] / $cant_total) * 20);
                
            }
        }
    }


}

?>


