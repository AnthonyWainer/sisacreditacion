<?php

include_once("../lib/dbfactory.php");

class evento_extension_universitaria extends Main {

    function index($query, $p, $c,$codigo,$seme) {
        $sql = ' SELECT
evento.idevento,
evento.tema,
tipo_evento.descripcion,
evento.fecha,
evento.lugar
FROM
evento INNER JOIN tipo_evento ON tipo_evento.idtipo_evento = evento.idtipo_eventO
WHERE evento.idtipo_evento="6"  AND evento.idevento_padre is null and evento.CodigoSemestre="'.$seme.'" and evento.CodigoProfesor="'.$codigo.'"  and ' . $c . ' like :query';
//        echo $sql;exit;
        $param = array(array('key' => ':query', 'value' => "%$query%", 'type' => 'STR'));
        $data['total'] = $this->getTotal($sql, $param);
        $data['rows'] = $this->getRow($sql, $param, $p);
        $data['rowspag'] = $this->getRowPag($data['total'], $p);
        return $data;
    }

    function index1($query, $p, $c,$codigo,$seme) {
        $sql = ' SELECT
evento.idevento,
evento.tema,
tipo_evento.descripcion,
evento.fecha,
evento.lugar
FROM
evento INNER JOIN tipo_evento ON tipo_evento.idtipo_evento = evento.idtipo_eventO
WHERE evento.idtipo_evento="6"  AND evento.idevento_padre is null and evento.CodigoSemestre="'.$seme.'" and evento.CodigoProfesor  not like "'.$codigo.'"  and ' . $c . ' like :query';
//        echo $sql;exit;
        $param = array(array('key' => ':query', 'value' => "%$query%", 'type' => 'STR'));
        $data['total'] = $this->getTotal($sql, $param);
        $data['rows'] = $this->getRow($sql, $param, $p);
        $data['rowspag'] = $this->getRowPag($data['total'], $p);
        return $data;
    }
    function get_profesores($idevento) {
        $sql = "SELECT
    detalle_asistencia_docente.CodigoProfesor,
    profesores.NombreProfesor,
    profesores.ApellidoPaterno,
    profesores.ApellidoMaterno,
    cargo_asistencia_evento.descripcion,
    detalle_asistencia_docente.asistencia_docente,
    evento.idevento,
    evento.tema,
    detalle_asistencia_docente.costo,
    evento.idevento_padre

    FROM
    detalle_asistencia_docente ,
    profesores ,
    cargo_asistencia_evento,
    evento

    WHERE detalle_asistencia_docente.asistencia_docente='1'  AND detalle_asistencia_docente.costo='0' AND
    profesores.CodigoProfesor=detalle_asistencia_docente.CodigoProfesor AND detalle_asistencia_docente.idevento=evento.idevento AND
    cargo_asistencia_evento.id_cargo=detalle_asistencia_docente.id_cargo 
	and (evento.idevento_padre='" . $idevento . "' OR evento.idevento='" . $idevento . "')";
//        echo $sql;exit;
        $stmt = $this->db->prepare($sql);

        $stmt->execute();
        return $stmt->fetchAll();
    }

    function get_alumnos($idevento) {
        $sql = "SELECT
            detalle_asistencia_alumno.CodigoAlumno,
            alumnos.NombreAlumno,
            alumnos.ApellidoPaterno,
            alumnos.ApellidoMaterno,
            detalle_asistencia_alumno.asistencia_alumno,
            detalle_asistencia_alumno.id_cargo,
            cargo_asistencia_evento.descripcion,
            detalle_asistencia_alumno.idevento,
            evento.tema,
            detalle_asistencia_alumno.costo
            FROM
            alumnos ,
            detalle_asistencia_alumno ,
            evento ,
            cargo_asistencia_evento

            WHERE detalle_asistencia_alumno.asistencia_alumno='1'  AND detalle_asistencia_alumno.costo='0' AND
            alumnos.CodigoAlumno=detalle_asistencia_alumno.CodigoAlumno AND detalle_asistencia_alumno.idevento=evento.idevento AND
            cargo_asistencia_evento.id_cargo=detalle_asistencia_alumno.id_cargo and (evento.idevento_padre='" . $idevento . "' OR evento.idevento='" . $idevento . "')";
        $stmt = $this->db->prepare($sql);

        $stmt->execute();
        return $stmt->fetchAll();
    }
     function get_pre_actividades($idevento){
         $sql="SELECT
p_c_evento.id_pc_evento,
p_c_evento.fecha_inicio,
p_c_evento.fecha_termino,
p_c_evento.pre_actividad,
p_c_evento.descripcion,
p_c_evento.idevento,
evento.tema
FROM
p_c_evento
INNER JOIN evento ON p_c_evento.idevento = evento.idevento
WHERE p_c_evento.idevento='".$idevento."'";
        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll();
    }
    function get_sub_eventos($idevento) {
         $sql="SELECT
evento.hora_evento,
evento.idevento_padre,
evento.lugar,
evento.fecha,
evento.idtipo_evento,
evento.tema
FROM
evento
WHERE evento.idevento_padre='".$idevento."'";
        $stmt = $this->db->prepare($sql);
        
        $stmt->execute();
        return $stmt->fetchAll();
    }
            

    function get_externos($idevento) {
        $sql = "SELECT
            detalle_asistencia_externo.id_externos,
            externos.nombre,
            externos.apellidos,
            detalle_asistencia_externo.asistencia_externo,
            detalle_asistencia_externo.id_cargo,
            cargo_asistencia_evento.descripcion,
            detalle_asistencia_externo.idevento,
            evento.tema,
            detalle_asistencia_externo.costo
            FROM
            evento ,
            cargo_asistencia_evento ,
            externos ,
            detalle_asistencia_externo
            WHERE detalle_asistencia_externo.asistencia_externo='1'  AND detalle_asistencia_externo.costo='0' AND
            externos.id_externos=detalle_asistencia_externo.id_externos AND detalle_asistencia_externo.idevento=evento.idevento AND
            cargo_asistencia_evento.id_cargo=detalle_asistencia_externo.id_cargo and 
           (evento.idevento_padre='" . $idevento . "' OR evento.idevento='" . $idevento . "')";
        $stmt = $this->db->prepare($sql);

        $stmt->execute();
        return $stmt->fetchAll();
    }

    function mostrar_ultimo_semestre() {
        $semestre = $this->db->query("SELECT
                                    distinct
                                    max(detalle_matricula.CodigoSemestre) as semestre_actual
                                    FROM
                                    detalle_matricula
                                    ");
        $ct = $semestre->fetch();
        $semestre = $ct['semestre_actual'];
        return $semestre;
    }

    function InsertDet($_P) {
        $fecha = date('Y/m/d');
        $estado = "en espera";
//        echo "INSERT INTO detalle_alumno_evento VALUES(".$_P['codigo'].", ".$fecha.", ".$_P['alumno'].", ".$estado.", ". $_P['semestre'].", ".$_P['mensaje'].", null)";
//        
//        print_r($_P);exit;
        $stmt = $this->db->prepare("INSERT INTO detalle_alumno_evento VALUES(:idevento, :fecha, :CodigoAlumno, :estado, :CodigoSemestre, :mensaje, :mensaje_confirmacion)");
        $stmt->bindValue(':idevento', $_P['codigo'], PDO::PARAM_INT);
        $stmt->bindValue(':fecha', $fecha, PDO::PARAM_STR);
        $stmt->bindValue(':CodigoAlumno', $_P['alumno'], PDO::PARAM_STR);
        $stmt->bindValue(':estado', $estado, PDO::PARAM_STR);
        $stmt->bindValue(':CodigoSemestre', $_P['semestre'], PDO::PARAM_STR);
        $stmt->bindValue(':mensaje', $_P['mensaje'], PDO::PARAM_STR);
        $stmt->bindValue(':mensaje_confirmacion', NULL, PDO::PARAM_NULL);
        $stmt->execute();
       $p1 = $stmt->execute();
        $p2 = $stmt->errorInfo();
        return array($p1 , $p2[2]);
    }

    function InsertDet_profesor($_P) {
        $fecha = date('Y/m/d');
        $estado = 'en espera';
        $stmt = $this->db->prepare("INSERT INTO detalle_profesor_evento VALUES(:idevento, :fecha, :CodigoProfesor, :estado, :CodigoSemestre, :mensaje,:mensaje_confirmacion)");
        $stmt->bindValue(':idevento', $_P['codigo'], PDO::PARAM_INT);
        $stmt->bindValue(':fecha', $fecha, PDO::PARAM_STR);
        $stmt->bindValue(':CodigoProfesor', $_P['profesor'], PDO::PARAM_STR);
        $stmt->bindValue(':estado', $estado, PDO::PARAM_STR);
        $stmt->bindValue(':CodigoSemestre', $_P['semestre'], PDO::PARAM_STR);
        $stmt->bindValue(':mensaje', $_P['mensaje'], PDO::PARAM_STR);
        $stmt->bindValue(':mensaje_confirmacion', $_P['mensaje_confirmacion'], PDO::PARAM_STR);

        $stmt->execute();
        return $stmt->fetchObject();
    }

    function edit($id) {
        $stmt = $this->db->prepare("SELECT * FROM evento WHERE idevento=:id");
        $stmt->bindValue(':id', $id, PDO::PARAM_STR);
        $stmt->execute();
        return $stmt->fetchObject();
    }

    function insert($_P) {
//        if ($_SESSION['cargo'] != 'Presidente' || $_SESSION['comicion'] != 'COMISION ESPECIAL DE TUTORIA') {
//            $cod_profesor = $_SESSION['idusuario'];
//        }
//        if ($_P['crear_modo_sin_cargo'] == true) {
//            $cod_profesor = $_SESSION['idusuario'];
//        }
        $sentencia = $this->db->query("SELECT MAX(idevento) as cant from evento");
        $ct = $sentencia->fetch();
        $id = 1 + (int) $ct['cant'];
        $semestre_ultimo = $this->mostrar_semestre_ultimo();
        $sql = $this->Query("sp_evento_proyeccion_social_iu(0,:p1,:p2,:p3,:p4,:p5,:p6,:p7,:p8)");
        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(':p1', $id, PDO::PARAM_INT);
        $stmt->bindValue(':p2', $_P['tema'], PDO::PARAM_STR);
        $stmt->bindValue(':p3', $_P['idtipo_evento'], PDO::PARAM_INT);
        $stmt->bindValue(':p4', $semestre_ultimo, PDO::PARAM_STR);
        $stmt->bindValue(':p5', $_P['fecha'], PDO::PARAM_STR);
        $stmt->bindValue(':p6', $_SESSION['idusuario'], PDO::PARAM_STR);
        $stmt->bindValue(':p7', $_P['lugar'], PDO::PARAM_STR);
        $stmt->bindValue(':p8', $_P['distrito'], PDO::PARAM_STR);

        $p1 = $stmt->execute();
        $p2 = $stmt->errorInfo();
        return array($p1, $p2[2], "idevento" => $id);
    }

    function update($_P) {echo('hola');
        if ($_SESSION['cargo'] != 'Presidente' && $_SESSION['comicion'] != 'COMISION ESPECIAL DE TUTORIA') {
            $cod_profesor = $_SESSION['idusuario'];
        }
        $semestre_ultimo = $this->mostrar_semestre_ultimo();
        $sql = $this->Query("sp_evento_proyeccion_social_iu(1,:p1,:p2,:p3,:p4,:p5,:p6,:p7,:p8)");
        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(':p1', $_P['idevento'], PDO::PARAM_INT);
        $stmt->bindValue(':p2', $_P['tema'], PDO::PARAM_STR);
        $stmt->bindValue(':p3', $_P['idtipo_evento'], PDO::PARAM_INT);
        $stmt->bindValue(':p4', $semestre_ultimo, PDO::PARAM_STR);
        $stmt->bindValue(':p5', $_P['fecha'], PDO::PARAM_STR);
        $stmt->bindValue(':p6', $_SESSION['idusuario'], PDO::PARAM_STR);
        $stmt->bindValue(':p7', $_P['lugar'], PDO::PARAM_STR);
        $stmt->bindValue(':p8', $_P['distrito'], PDO::PARAM_STR);
        $p1 = $stmt->execute();
        $p2 = $stmt->errorInfo();
        return array($p1, $p2[2]);
    }

    //agrag_seps--agregarsubeventosdeproyeccionsocial
    function save__sub_eventos($agreg_seps) {
//       echo "<div align='left'><pre>"; print_r($agreg_seps);echo "</div>";exit;

        $cod_semes = $this->mostrar_semestre_ultimo();
        $sql2 = $this->Query("sp_even_subcron_ps_iu(0,:p1,:p2,:p3,:p4,:p5,:p6,:p7,:p8,:p9,:p10,:p11)");
        $stmt2 = $this->db->prepare($sql2);
        try {
            $this->db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $this->db->beginTransaction();
            $estado = false;
            foreach ($agreg_seps['tema'] as $key => $value) {
                $sentencia = $this->db->query("SELECT MAX(idevento) as cant from evento");
                $ct = $sentencia->fetch();
                $id = 1 + (int) $ct['cant'];
//                print_r($id);echo ' ';print_r($value);echo ' ';print_r($agreg_seps['tipoevento']);echo ' ';
//            print_r($cod_semes);echo ' ';print_r($agreg_seps['fecha'][$key]);echo ' ';print_r($_SESSION['idusuario']);echo ' ';print_r($agreg_seps['lugar'][$key]);echo ' ';
//            print_r( $agreg_seps['idevento']);exit;
//            echo ' ';print_r($agreg_seps['idevento']);echo ' ';
//echo "aki";print_r($agreg_seps['fecha'][$key]);
                $stmt2->bindValue(':p1', $id, PDO::PARAM_INT);
                $stmt2->bindValue(':p2', $value, PDO::PARAM_STR);
                $stmt2->bindValue(':p3', $agreg_seps['tipoevento'], PDO::PARAM_INT);
                $stmt2->bindValue(':p4', $cod_semes, PDO::PARAM_STR);
                $stmt2->bindValue(':p5', $agreg_seps['fecha'][$key], PDO::PARAM_STR);
                $stmt2->bindValue(':p6', $_SESSION['idusuario'], PDO::PARAM_STR);
                $stmt2->bindValue(':p7', $agreg_seps['lugar'][$key], PDO::PARAM_STR);
                $stmt2->bindValue(':p8', $agreg_seps['ubigeo1'], PDO::PARAM_STR);
                $stmt2->bindValue(':p9', $agreg_seps['ideventoo'], PDO::PARAM_INT);
                $stmt2->bindValue(':p10', NULL, PDO::PARAM_NULL);
                $stmt2->bindValue(':p11', $agreg_seps['hora_evento'][$key], PDO::PARAM_STR);


                $stmt2->execute();
            }
            $this->db->commit();
            $p1 = true;
            $p2[2] = "";
        } catch (PDOException $e) {
            $this->db->rollBack();
            $p1 = false;
            $p2[2] = $e->getMessage();
        }

        return array($p1, $p2[2]);
    }
    
    function save__sub_actividades_up($_P) {
        $cod_semes = $this->mostrar_semestre_ultimo();
        $sql2 = $this->Query("sp_even_subcron_ps_iu(1,:p1,:p2,:p3,:p4,:p5,:p6,:p7,:p8,:p9,:p10,:p11)");
        $stmt2 = $this->db->prepare($sql2);
        try {
            $this->db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $this->db->beginTransaction();
            $estado = false;
            foreach ($_P['idevento'] as $key => $value) {
//                echo "aki".$_P['idevento'][$key]."tema".$_P['tema_up'][$key];
                $stmt2->bindValue(':p1', $_P['idevento'][$key], PDO::PARAM_INT);
                $stmt2->bindValue(':p2', $_P['tema_up'][$key], PDO::PARAM_STR);
                $stmt2->bindValue(':p3', $_P['tipoevento'], PDO::PARAM_INT);
                $stmt2->bindValue(':p4', $cod_semes, PDO::PARAM_STR);
                $stmt2->bindValue(':p5', $_P['fecha_up'][$key], PDO::PARAM_STR);
                $stmt2->bindValue(':p6', $_SESSION['idusuario'], PDO::PARAM_STR);
                $stmt2->bindValue(':p7', $_P['lugar_up'][$key], PDO::PARAM_STR);
                $stmt2->bindValue(':p8', $_P['ubigeo1'], PDO::PARAM_STR);
                $stmt2->bindValue(':p9', $_P['ideven'], PDO::PARAM_INT);
                $stmt2->bindValue(':p10', NULL, PDO::PARAM_NULL);
                $stmt2->bindValue(':p11', $_P['hora_evento_up'][$key], PDO::PARAM_STR);


                $stmt2->execute();
            }
            $this->db->commit();
            $p1 = true;
            $p2[2] = "";
        } catch (PDOException $e) {
            $this->db->rollBack();
            $p1 = false;
            $p2[2] = $e->getMessage();
        }

        return array($p1, $p2[2]);
    }
    
    function del_sub($_P){
        $stmt = $this->db->prepare("DELETE FROM evento WHERE idevento = :p1");
        $stmt->bindValue(':p1', $_P['idpre'], PDO::PARAM_INT);
        $p1 = $stmt->execute();
        $p2 = $stmt->errorInfo();
        return array($p1, $p2[2]);
    }
            

    function del_preactividad($_P) {
        $stmt = $this->db->prepare("DELETE FROM p_c_evento WHERE id_pc_evento = :p1");
        $stmt->bindValue(':p1', $_P['idpre'], PDO::PARAM_INT);
        $p1 = $stmt->execute();
        $p2 = $stmt->errorInfo();
        return array($p1, $p2[2]);
    }

    function save__pre_actividates_up($_P) {
//        echo "<div align='left'><pre>";print_r($_P);echo "</div>";
        $sql2 = $this->Query("p_c_evento(1,:p1,:p2,:p3,:p4,:p5,:p6)");
        $stmt2 = $this->db->prepare($sql2);
        try {
            $this->db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $this->db->beginTransaction();
            foreach ($_P['id_evento_pre'] as $key => $value) {
//                echo "aki";print_r($_P['fecha_inicio_up'][$value]);
                $stmt2->bindValue(':p1', $value, PDO::PARAM_INT);
                $stmt2->bindValue(':p2', $_P['idevento_'], PDO::PARAM_INT);
                $stmt2->bindValue(':p3', $_P['fecha_inicio_up'][$value], PDO::PARAM_STR);
                $stmt2->bindValue(':p4', $_P['fecha_termino_up'][$value], PDO::PARAM_STR);
                $stmt2->bindValue(':p5', $_P['pre_actividad_up'][$value], PDO::PARAM_STR);
                $stmt2->bindValue(':p6', $_P['descripcion_up'][$value], PDO::PARAM_STR);
                $stmt2->execute();
            }
            $this->db->commit();
            $p1 = true;
            $p2[2] = "";
        } catch (PDOException $e) {
            $this->db->rollBack();
            $p1 = false;
            $p2[2] = $e->getMessage();
        }

        return array($p1, $p2[2]);
    }

    function save__pre_actividates($agreg_seps) {
//       ECHO "<pre>"; print_r($agreg_seps);EXIT;
        $sql2 = $this->Query("p_c_evento(0,:p1,:p2,:p3,:p4,:p5,:p6)");
        $stmt2 = $this->db->prepare($sql2);
        try {
            $this->db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $this->db->beginTransaction();
            $estado = false;
            foreach ($agreg_seps['pre_actividad'] as $key => $value) {
                $sentencia = $this->db->query("SELECT MAX(id_pc_evento) as cant from p_c_evento");
                $ct = $sentencia->fetch();
                $id = 1 + (int) $ct['cant'];
                $stmt2->bindValue(':p1', $id, PDO::PARAM_INT);
                $stmt2->bindValue(':p2', $agreg_seps['idevento_'], PDO::PARAM_INT);
                $stmt2->bindValue(':p3', $agreg_seps['fecha_inicio'][$key], PDO::PARAM_STR);
                $stmt2->bindValue(':p4', $agreg_seps['fecha_termino'][$key], PDO::PARAM_STR);
                $stmt2->bindValue(':p5', $agreg_seps['pre_actividad'][$key], PDO::PARAM_STR);
                $stmt2->bindValue(':p6', $agreg_seps['descripcion'][$key], PDO::PARAM_STR);
                $stmt2->execute();
            }
            $this->db->commit();
            $p1 = true;
            $p2[2] = "";
        } catch (PDOException $e) {
            $this->db->rollBack();
            $p1 = false;
            $p2[2] = $e->getMessage();
        }

        return array($p1, $p2[2]);
    }

    function delete($p) {
        $sql = $this->Query("sp_evento_sd(1,:p1)");
        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(':p1', $p, PDO::PARAM_INT);
        $p1 = $stmt->execute();
        $p2 = $stmt->errorInfo();
        return array($p1, $p2[2]);
    }

}

?>
