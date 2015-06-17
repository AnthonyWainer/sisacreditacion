<?php

include_once("../lib/dbfactory.php");

class asignaciontutoria extends Main {

    function alumnos_asignados($query, $p, $CodigoProfesor, $CodigoSemestre) {
        $sql = " SELECT
                        alumnos.CodigoAlumno,
                        alumnos.NombreAlumno,
                        concat(alumnos.ApellidoPaterno,' ',alumnos.ApellidoMaterno) AS Apellidos,
                        concat(alumnos.TipoDocumento,' ',alumnos.NumDocumento) AS Documento,
                        date(alumnos.FechaIngreso),
                        alumnos.CodAlumnoSira
                        FROM
                        detalle_asignacion_tutoria
                        Inner Join profesores ON detalle_asignacion_tutoria.CodigoProfesor = profesores.CodigoProfesor
                        Inner Join alumnos ON detalle_asignacion_tutoria.CodigoAlumno = alumnos.CodigoAlumno
                        Inner Join semestreacademico ON detalle_asignacion_tutoria.CodigoSemestre = semestreacademico.CodigoSemestre
                        where detalle_asignacion_tutoria.CodigoProfesor=" . $CodigoProfesor . " and  detalle_asignacion_tutoria.CodigoSemestre=" . $CodigoSemestre . "";
        $param = array(array('key' => ':query', 'value' => "%$query%", 'type' => 'STR'));
        $data['total'] = $this->getTotal($sql, $param);
        $data['rows'] = $this->getRow($sql, $param, $p);
        $data['rowspag'] = $this->getRowPag($data['total'], $p);
        return $data;
    }

    function asignar_estado_temporal_asignacion($_P) {

        $sql = $this->Query("sp_asignar_estado_temporal_asignacion(0,:p1,:p2)");
        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(':p1', $_P['CodigoAlumno'], PDO::PARAM_STR);
        $stmt->bindValue(':p2', 1, PDO::PARAM_INT);
        $p1 = $stmt->execute();
        $p2 = $stmt->errorInfo();
        return array($p1, $p2[2]);
    }

    function alumnos_asignados_asistencias($query, $p, $CodigoProfesor, $CodigoSemestre, $idevento) {
        $sql = " SELECT
                        alumnos.CodigoAlumno,
                        alumnos.NombreAlumno,
                        concat(alumnos.ApellidoPaterno,' ',alumnos.ApellidoMaterno) AS Apellidos,
                        concat(alumnos.TipoDocumento,' ',alumnos.NumDocumento) AS Documento,
                        date(alumnos.FechaIngreso),
                        alumnos.CodAlumnoSira,
			case when( detalle_asistencia_alumno_tutoria.asistencia_alumno =1 and detalle_asistencia_alumno_tutoria.idevento=" . $idevento . "  ) then 'Asistio' else 'Falta' end Asistencias,
			detalle_asistencia_alumno_tutoria.idevento
                        FROM
                        detalle_asignacion_tutoria
                        Inner Join profesores ON detalle_asignacion_tutoria.CodigoProfesor = profesores.CodigoProfesor
                        Inner Join alumnos ON detalle_asignacion_tutoria.CodigoAlumno = alumnos.CodigoAlumno
			Left Join detalle_asistencia_alumno_tutoria ON detalle_asistencia_alumno_tutoria.CodigoAlumno = alumnos.CodigoAlumno and detalle_asistencia_alumno_tutoria.idevento=" . $idevento . "
                        Inner Join semestreacademico ON detalle_asignacion_tutoria.CodigoSemestre = semestreacademico.CodigoSemestre
                        where detalle_asignacion_tutoria.CodigoProfesor=" . $CodigoProfesor . " and  detalle_asignacion_tutoria.CodigoSemestre='" . $CodigoSemestre . "' ";

        $param = array(array('key' => ':query', 'value' => "%$query%", 'type' => 'STR'));
        $data['total'] = $this->getTotal($sql, $param);
        $data['rows'] = $this->getRow($sql, $param, $p);
        $data['rowspag'] = $this->getRowPag($data['total'], $p);
        return $data;
    }

    function mostrar_semestre_ultimo() {
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

    function devolver_asistencias($query, $p, $idprofesor, $idevento) {
        $sql = "SELECT
                                    detalle_asistencia_alumno_tutoria.asistencia_alumno,
                                    detalle_asistencia_alumno_tutoria.CodigoProfesor,
                                    detalle_asistencia_alumno_tutoria.CodigoAlumno
                                    FROM
                                    detalle_asistencia_alumno_tutoria
                                    WHERE detalle_asistencia_alumno_tutoria.CodigoProfesor ='" . $idprofesor . "' and detalle_asistencia_alumno_tutoria.idevento='" . $idevento . "'";
        $param = array(array('key' => ':query', 'value' => "%$query%", 'type' => 'STR'));
        $data['total'] = $this->getTotal($sql, $param);
        $data['rows'] = $this->getRow($sql, $param, $p);
        $data['rowspag'] = $this->getRowPag($data['total'], $p);
        return $data;
    }

    function mostrar_Facultad_idUsusario($idusuario) {

        $facultad = $this->db->query("SELECT
        profesores.CodigoDptoAcad as depfac
        FROM
        profesores
        where profesores.CodigoProfesor='" . $idusuario . "'");
        $ct = $facultad->fetch();
        $facultad = $ct['depfac'];
        return $facultad;
    }

    function edit_asignados($CodigoProfesor,$CodigoSemestre) {
      
       $query = "SELECT
        detalle_asignacion_tutoria.CodigoProfesor,
        detalle_asignacion_tutoria.CodigoAlumno,
        CONCAT_WS(' ',alumnos.NombreAlumno,alumnos.ApellidoPaterno,alumnos.ApellidoMaterno) as nombre
        FROM
        detalle_asignacion_tutoria
        INNER JOIN alumnos ON alumnos.CodigoAlumno = detalle_asignacion_tutoria.CodigoAlumno
        where detalle_asignacion_tutoria.CodigoProfesor='".$CodigoProfesor."' and detalle_asignacion_tutoria.CodigoSemestre='".$CodigoSemestre."'
        ";
        $sth = $this->db->prepare($query);
        $sth->execute();
        return $sth->fetchAll();
    
    }

    function edit($id) {
        $stmt = $this->db->prepare("SELECT * FROM alumnos WHERE CodigoAlumno = :id");
        $stmt->bindValue(':id', $id, PDO::PARAM_STR);
        $stmt->execute();
        return $stmt->fetchObject();
    }

    function vaciar_estado_chek_asignacion_tutoria($id) {
        $this->db->query("truncate table estado_chek_asignacion_tutoria ");
    }
function vaciar($_P,$sem){ 
     $this->db->query("delete from detalle_asignacion_tutoria where detalle_asignacion_tutoria.CodigoProfesor='".$_P['CodigoProfesor']."' and detalle_asignacion_tutoria.CodigoSemestre='".$sem."'");

}
    function insert($_P, $sem) {

        $sql2 = $this->Query("sp_detalle_asignacion_tutoria_iu(0,:p1,:p2,:p3,:p4)");
        $stmt2 = $this->db->prepare($sql2);
        $fecha = date("Y-m-d");
        try {
            $this->db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $this->db->beginTransaction();
            $estado = false;
            foreach ($_P['id_idalumno'] as $key => $r) {
                $stmt2->bindValue(':p1', $_P['CodigoProfesor'], PDO::PARAM_STR);
                $stmt2->bindValue(':p2', $_P['id_idalumno'][$key], PDO::PARAM_STR);
                $stmt2->bindValue(':p3', $sem, PDO::PARAM_STR);
                $stmt2->bindValue(':p4', $fecha, PDO::PARAM_STR);


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
        $stmt = $this->db->prepare("DELETE FROM alumno WHERE CodigoAlumno = :p1");
        $stmt->bindValue(':p1', $p, PDO::PARAM_INT);
        $p1 = $stmt->execute();
        $p2 = $stmt->errorInfo();
        return array($p1, $p2[2]);
    }

}

?>
