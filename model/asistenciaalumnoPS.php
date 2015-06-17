<?php

include_once("../lib/dbfactory.php");

class asistenciaalumnoPS extends Main {

    function index($query, $p, $c, $semestre_ultimo, $cod_profesor) {
        $sql = " SELECT
                        evento.idevento,
                         evento.tema,
                        tipo_evento.descripcion,
                        evento.fecha,
                        evento.CodigoProfesor,
                        clasificacion_evento.descripcion
                        FROM
                        evento
 Inner Join tipo_evento ON tipo_evento.idtipo_evento = evento.idtipo_evento
 Inner Join clasificacion_evento ON clasificacion_evento.id_clasificacion_evento = tipo_evento.id_clasificacion_evento
    where  evento.CodigoSemestre='" . $semestre_ultimo . "' and  tipo_evento.idtipo_evento= 5 and evento.idevento_padre is null and " . $c . " like :query";
       
        $param = array(array('key' => ':query', 'value' => "%$query%", 'type' => 'STR'));
        $data['total'] = $this->getTotal($sql, $param);
        $data['rows'] = $this->getRow($sql, $param, $p);
        $data['rowspag'] = $this->getRowPag($data['total'], $p);
        return $data;
    }

    

    function sub_evento($_se) {
        $sql = "SELECT
                        evento.idevento,
                         evento.tema,
                        tipo_evento.descripcion,
                        evento.fecha,
                        evento.CodigoProfesor,
                        clasificacion_evento.descripcion
                        FROM
                        evento
 Inner Join tipo_evento ON tipo_evento.idtipo_evento = evento.idtipo_evento
 Inner Join clasificacion_evento ON clasificacion_evento.id_clasificacion_evento = tipo_evento.id_clasificacion_evento
    where  evento.idevento_padre='" . $_se . "'";
        $statement = $this->db->prepare($sql);
        $statement->execute();
        $data = $statement->fetchAll();
        return $data;
    }
      function mostar_lista_eu_externo($idevento) {
        $sql = "SELECT
CONCAT(externos.nombre,externos.apellidos) AS Nombre,
externos.institucion,
externos.direccion,
detalle_asistencia_externo.asistencia_externo,
cargo_asistencia_evento.descripcion,
evento.idevento,
evento.tema,
detalle_asistencia_externo.id_externos
FROM
externos
INNER JOIN detalle_asistencia_externo ON detalle_asistencia_externo.id_externos = externos.id_externos
INNER JOIN cargo_asistencia_evento ON detalle_asistencia_externo.id_cargo = cargo_asistencia_evento.id_cargo
INNER JOIN evento ON detalle_asistencia_externo.idevento = evento.idevento
WHERE evento.idevento='".$idevento."' "
        ;
        $statement = $this->db->prepare($sql);
        $statement->execute();
        $obj = $statement->fetchAll();
        return $obj;
    }

    function mostar_lista_eu_alumnos($idevento) {
        $sql = "SELECT
 detalle_asistencia_alumno.CodigoAlumno,          
detalle_asistencia_alumno.idevento,
CONCAT (' ',alumnos.NombreAlumno,alumnos.ApellidoPaterno,alumnos.ApellidoMaterno) as Nombre,
detalle_asistencia_alumno.asistencia_alumno,
evento.tema,
evento.idtipo_evento,
cargo_asistencia_evento.descripcion as cargo
FROM
detalle_asistencia_alumno
INNER JOIN alumnos ON detalle_asistencia_alumno.CodigoAlumno = alumnos.CodigoAlumno
INNER JOIN evento ON detalle_asistencia_alumno.idevento = evento.idevento
INNER JOIN tipo_evento ON evento.idtipo_evento = tipo_evento.idtipo_evento
INNER JOIN cargo_asistencia_evento ON detalle_asistencia_alumno.id_cargo = cargo_asistencia_evento.id_cargo
WHERE evento.idevento='" . $idevento . "'"
        ;
        $statement = $this->db->prepare($sql);
        $statement->execute();
        $obj = $statement->fetchAll();
        return $obj;
    }

    function mostar_lista_eu_docente($idevento) {
        $sql = "SELECT
detalle_asistencia_docente.asistencia_docente,
detalle_asistencia_docente.CodigoProfesor,
evento.idtipo_evento,
CONCAT(' ',profesores.NombreProfesor,profesores.ApellidoPaterno,profesores.ApellidoMaterno) AS Nombre,
cargo_asistencia_evento.descripcion as cargo,
evento.tema
FROM
detalle_asistencia_docente
INNER JOIN evento ON detalle_asistencia_docente.idevento = evento.idevento
INNER JOIN tipo_evento ON tipo_evento.idtipo_evento = evento.idtipo_evento
INNER JOIN profesores ON detalle_asistencia_docente.CodigoProfesor = profesores.CodigoProfesor
INNER JOIN cargo_asistencia_evento ON detalle_asistencia_docente.id_cargo = cargo_asistencia_evento.id_cargo
WHERE evento.idevento='" . $idevento . "' "
        ;
        $statement = $this->db->prepare($sql);
        $statement->execute();
        $obj = $statement->fetchAll();
        return $obj;
    }

    function update_externos($_P) {
        $sql2 = $this->Query("asistencia_externo(:p1,:p2,:p3)");
        $stmt2 = $this->db->prepare($sql2);
        try {
            $this->db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $this->db->beginTransaction();
            $estado = false;
            foreach ($_P['id_externo'] as $key => $r) {
                if ($_P['chek'][$_P['id_externo'][$key]] == "") {
                   $asi = '0';
                } else {
                $asi = '1';
                }
//                echo "id ex ".$_P['id_externo'][$key];echo "-";  echo "check".$_P['chek'][$_P['id_externo'][$key]];echo "<br>";
                $stmt2->bindValue(':p1', $_P['id_externo'][$key], PDO::PARAM_INT);
                $stmt2->bindValue(':p2', $_P['idevento'], PDO::PARAM_INT);
                $stmt2->bindValue(':p3',$asi,PDO::PARAM_STR);
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
     function update_docentes($_Pd) {
        $sql2 = $this->Query("asistencia_docente(:p1,:p2,:p3)");
        $stmt2 = $this->db->prepare($sql2);
        try {
            $this->db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $this->db->beginTransaction();
            $estado = false;
            foreach ($_Pd['CodigoProfesor'] as $key => $r) {
                if ($_Pd['chek'][$_Pd['CodigoProfesor'][$key]] == "") {
               $asi = '0';
                } else {
                $asi = '1';
                }
//echo "id ex ".$_P['id_externo'][$key];echo "-";  echo "check".$_P['chek'][$_P['id_externo'][$key]];echo "<br>";
                $stmt2->bindValue(':p1', $_Pd['CodigoProfesor'][$key], PDO::PARAM_STR);
                $stmt2->bindValue(':p2', $_Pd['idevento'], PDO::PARAM_INT);
                $stmt2->bindValue(':p3',$asi,PDO::PARAM_STR);
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


 function update_alumnos($_Pa) {
        $sql2 = $this->Query("asistencia_alumno(:p1,:p2,:p3)");
        $stmt2 = $this->db->prepare($sql2);
        try {
            $this->db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $this->db->beginTransaction();
            $estado = false;
            foreach ($_Pa['CodigoAlumno'] as $key => $r) {
                if ($_Pa['chek'][$_Pa['CodigoAlumno'][$key]] == "")
                    {
                    $asi = '0';
                } else {
                $asi = '1';
                }
//                echo "id ex ".$_P['id_externo'][$key];echo "-";  echo "check".$_P['chek'][$_P['id_externo'][$key]];echo "<br>";
                 $stmt2->bindValue(':p2', $_Pa['idevento'], PDO::PARAM_INT);
                $stmt2->bindValue(':p1', $_Pa['CodigoAlumno'][$key], PDO::PARAM_INT);
                $stmt2->bindValue(':p3',$asi,PDO::PARAM_STR);
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

   

}
