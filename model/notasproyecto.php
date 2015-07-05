<?php

include_once("../lib/dbfactory.php");

class notasproyecto extends Main {

    public $opt;

    function index($query, $p, $c) {
        $sql = "SELECT
                    idconcepto,
                    nota,
                    idproyecto,
                    CodigoAlumno,
                    CodigoSemestre
                    FROM
                    detalle_concepto_detproyecto
                where " . $c . " like :query";
        $param = array(array('key' => ':query', 'value' => "%$query%", 'type' => 'STR'));
        $data['total'] = $this->getTotal($sql, $param);
        $data['rows'] = $this->getRow($sql, $param, $p);
        $data['rowspag'] = $this->getRowPag($data['total'], $p);
        return $data;
    }

    function alumnos_asignados($query, $p, $CodigoAlumno, $idproyecto, $NombreAlumno) {

        $sql = "   SELECT
                        alumnos.CodigoAlumno,
                        alumnos.NombreAlumno,
                        concat(alumnos.ApellidoPaterno,' ',alumnos.ApellidoMaterno) AS Apellidos,
                        concat(alumnos.TipoDocumento,' ',alumnos.NumDocumento) AS Documento,
                        alumnos.FechaIngreso,
                        alumnos.CodAlumnoSira
                        FROM
                        detalle_asignacion_tutoria
                        Inner Join profesores ON detalle_asignacion_tutoria.CodigoProfesor = profesores.CodigoProfesor
                        Inner Join alumnos ON detalle_asignacion_tutoria.CodigoAlumno = alumnos.CodigoAlumno
                        Inner Join semestreacademico ON detalle_asignacion_tutoria.CodigoSemestre = semestreacademico.CodigoSemestre
                        where detalle_asignacion_tutoria.CodigoProfesor=" . $CodigoProfesor . " and  detalle_asignacion_tutoria.CodigoSemestre=" . $CodigoSemestre . "
                       ";

        $param = array(array('key' => ':query', 'value' => "%$query%", 'type' => 'STR'));
        $data['total'] = $this->getTotal($sql, $param);
        $data['rows'] = $this->getRow($sql, $param, $p);
        $data['rowspag'] = $this->getRowPag($data['total'], $p);
        return $data;
    }

    function edit($id) {
        $stmt = $this->db->prepare("SELECT * FROM detalle_concepto_detproyecto WHERE idproyecto = :id");
        $stmt->bindValue(':id', $id, PDO::PARAM_STR);
        $stmt->execute();
        return $stmt->fetchObject();
    }

    function insert($_P) {
        echo "<script>alert('Las notas del alumno se enviaron exitosamente');window.close();</script>";

        echo "<pre>";
        print_r($_P);
        $t = $_P['tam'];
        $stmt = $this->db->prepare("SELECT * from detalleproyecto_matrixalumno WHERE idproyecto=:id and estado=1");
        $stmt->bindValue(':id', $_P['idproyecto'], PDO::PARAM_STR);
        $stmt->execute();
        $datos_pys = $stmt->fetchAll();

        foreach ($datos_pys as $k) {
            $sql2 = $this->Query("sp_det_concep_detproy_iu(0,:p1,:p2,:p3,:p4,:p5)");
            $stmt2 = $this->db->prepare($sql2);

            $stmt2->bindValue(':p1', 3, PDO::PARAM_INT);
            $stmt2->bindValue(':p2', 0, PDO::PARAM_STR);
            $stmt2->bindValue(':p3', $_P['idproyecto'], PDO::PARAM_STR);
            $stmt2->bindValue(':p4', $k[3], PDO::PARAM_STR);
            $stmt2->bindValue(':p5', $_P['semestre'], PDO::PARAM_STR);
            $stmt2->execute();
        }
    }

    function actualiza($_P) {#echo "<script>alert('Las notas del alumno se enviaron exitosamente');window.close();</script>";
        echo "<pre>";
        print_r($_P);

        $stmt = $this->db->prepare("UPDATE detalle_concepto_detproyecto SET nota = :p3
                                    WHERE idproyecto = :p1 and CodigoAlumno= :p2 and CodigoSemestre= 20150");
        $stmt->bindValue(':p1', $_P['idproyecto'], PDO::PARAM_STR);
        $stmt->bindValue(':p2', $_P['IdAlumno'], PDO::PARAM_STR);
        $stmt->bindValue(':p3', $_P["nota"], PDO::PARAM_STR);
        $p1 = $stmt->execute();
    }

    function Enviar_notas_finales($alumnos, $idproyecto) {
        try {
            $this->db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $this->db->beginTransaction();
            foreach ($alumnos as $key => $value) {

                $sql = "UPDATE detalle_concepto_detproyecto SET estado_envio = '1' WHERE idproyecto = '" . $idproyecto . "' and CodigoAlumno= '" . $value['CodigoAlumno'] . "' and CodigoSemestre= 20150";
                $stmt = $this->db->prepare($sql);
//                $stmt->bindValue(':p1', $idproyecto, PDO::PARAM_INT);
//                $stmt->bindValue(':p2', $value['CodigoAlumno'], PDO::PARAM_STR);
//                $stmt->bindValue(':p3', '1', PDO::PARAM_STR);
                $stmt->execute();
            }
            
            $this->db->commit();
            $resp = true;
            $msg = "se Enviaron todas las notas Correctamente";
        } catch (PDOException $e) {
            $this->db->rollBack();
            $resp = false;
            $msg = $e->getMessage();
        }
        return array('resp' => $resp, 'msg' => $msg);
    }

    function update($_P) {

        $sql = $this->Query("sp_det_concep_detproy_iu(0,:p1,:p2,:p3,:p4,:p5)");
        $stmt = $this->db->prepare($sql);

        if ($_P['idpadre'] == "") {
            $_P['idpadre'] = null;
        }
        $stmt->bindValue(':p1', $_P['idconcepto'], PDO::PARAM_STR);
        $stmt->bindValue(':p2', $_P['nota'], PDO::PARAM_STR);
        $stmt->bindValue(':p3', $_P['idproyecto'], PDO::PARAM_STR);
        $stmt->bindValue(':p4', $_P['CodigoAlumno'], PDO::PARAM_STR);
        $stmt->bindValue(':p5', $_P['CodigoSemestre'], PDO::PARAM_STR);

        $p1 = $stmt->execute();
        $p2 = $stmt->errorInfo();
        return array($p1, $p2[2]);
    }

    function delete($p) {
        $stmt = $this->db->prepare("DELETE FROM detalle_concepto_detproyecto WHERE idproyecto = :p1");
        $stmt->bindValue(':p1', $p, PDO::PARAM_INT);
        $p1 = $stmt->execute();
        $p2 = $stmt->errorInfo();
        return array($p1, $p2[2]);
    }

}

?>