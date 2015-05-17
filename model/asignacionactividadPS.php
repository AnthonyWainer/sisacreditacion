<?php

include_once("../lib/dbfactory.php");

class asignacionactividadPS extends Main {

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
    where  evento.CodigoSemestre='" . $semestre_ultimo . "' and  (clasificacion_evento.id_clasificacion_evento=2  and  tipo_evento.idtipo_evento= 3) and evento.idevento_padre is null and " . $c . " like :query";

        $param = array(array('key' => ':query', 'value' => "%$query%", 'type' => 'STR'));
        $data['total'] = $this->getTotal($sql, $param);
        $data['rows'] = $this->getRow($sql, $param, $p);
        $data['rowspag'] = $this->getRowPag($data['total'], $p);
        return $data;
    }
    
    function insert_profesor_ini($id,$prof){
        $sql2 = $this->Query("act_asistencia_docente(0,:p1,:p2,:p3,:p4,:p5)");
        $stmt2 = $this->db->prepare($sql2);
        try {
            $this->db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $this->db->beginTransaction();
            $estado = false;
            foreach ($prof as $key => $value) {
                
                $stmt2->bindValue(':p1', $prof[$key]['CodigoProfesor'], PDO::PARAM_STR);
                $stmt2->bindValue(':p2', $id, PDO::PARAM_INT);
                $stmt2->bindValue(':p3', NULL, PDO::PARAM_STR);
                $stmt2->bindValue(':p4', NULL, PDO::PARAM_STR);
                $stmt2->bindValue(':p5', 3, PDO::PARAM_INT);


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
    
    
    function facultad_profesor($idpro){
        $sql = "SELECT
departamentoacademico.CodigoDptoAcad
FROM
profesores
INNER JOIN departamentoacademico ON profesores.CodigoDptoAcad = departamentoacademico.CodigoDptoAcad
where profesores.CodigoProfesor='".$idpro."'";
        $statement = $this->db->prepare($sql);
        $statement->execute();
        $data = $statement->fetch();
        return $data;
    }
            
    function insertar_alumnos_ini($id,$alumnos){
        $sql2 = $this->Query("act_asistencia_alumno(0,:p1,:p2,:p3,:p4,:p5)");
        $stmt2 = $this->db->prepare($sql2);
        try {
            $this->db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $this->db->beginTransaction();
            $estado = false;

            foreach ($alumnos as $key => $value) {
                $stmt2->bindValue(':p1', $value['CodigoAlumno'], PDO::PARAM_STR);
                $stmt2->bindValue(':p2', $id, PDO::PARAM_INT);
                $stmt2->bindValue(':p3', NULL, PDO::PARAM_STR);
                $stmt2->bindValue(':p4', 3, PDO::PARAM_INT);
                $stmt2->bindValue(':p5', NULL, PDO::PARAM_STR);


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
            
    function detec_asignado($id_eve){
        $sql = "SELECT detalle_asistencia_docente.CodigoProfesor FROM detalle_asistencia_docente where detalle_asistencia_docente.idevento='".$id_eve."'";
        $statement = $this->db->prepare($sql);
        $statement->execute();
        $data = $statement->fetchAll();
        return $data;
        
    }

    function eliminar_docente($_c, $_ev) {
        $sql = "DELETE from detalle_asistencia_docente where detalle_asistencia_docente.idevento='" . $_ev . "'";
//        echo $sql; exit;
        $statement = $this->db->prepare($sql);
        $statement->execute();
    }

    function eliminar_alumno($_c, $_ev) {
        $sql = "DELETE from detalle_asistencia_alumno where detalle_asistencia_alumno.CodigoProfesor='" . $_c . "' and detalle_asistencia_alumno.idevento='" . $_ev . "'";
        $statement = $this->db->prepare($sql);
        $statement->execute();
    }

    function agregar_exter($_P) {
        $sql2 = $this->Query("func_insact_externo(0,:p1,:p2,:p3,:p4,:p5,:p6,:p7)");
        $stmt2 = $this->db->prepare($sql2);
        try {
            $this->db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $this->db->beginTransaction();
            $estado = false;
            foreach ($_P['nombre_E'] as $keys => $values) {
                $stmt2->bindValue(':p1', $values, PDO::PARAM_STR);
                $stmt2->bindValue(':p2', $_P['apellido_E'][$keys], PDO::PARAM_STR);
                $stmt2->bindValue(':p3', $_P['direccion_E'][$keys], PDO::PARAM_STR);
                $stmt2->bindValue(':p4', $_P['telefono_E'][$keys], PDO::PARAM_STR);
                $stmt2->bindValue(':p5', $_P['dni_E'][$keys], PDO::PARAM_INT);
                $stmt2->bindValue(':p6', $_P['institucion_E'][$keys], PDO::PARAM_STR);
                $stmt2->bindValue(':p7', $_P['idevento'], PDO::PARAM_INT);


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
    
    
    function get_alum_fac($id_e){
        $query ="SELECT DISTINCT alumnos.CodigoAlumno
FROM
detalle_matricula
INNER JOIN semestreacademico ON semestreacademico.CodigoSemestre = detalle_matricula.CodigoSemestre
INNER JOIN alumnos ON detalle_matricula.CodigoAlumno = alumnos.CodigoAlumno
INNER JOIN facultades ON alumnos.CodigoFacultad = facultades.CodigoFacultad
where facultades.CodigoFacultad='07' and semestreacademico.CodigoSemestre='20132'";
        $sth = $this->db->prepare($query);
        $sth->execute();
        $profesores= $sth->fetchAll();
        return $profesores;
    }

    function detect_profesor($_cp, $_id) {
        $sql = "SELECT
detalle_asistencia_docente.CodigoProfesor
FROM
detalle_asistencia_docente
WHERE
detalle_asistencia_docente.CodigoProfesor = '" . $_cp . "' and detalle_asistencia_docente.idevento='" . $_id . "'";
        $statement = $this->db->prepare($sql);
        $statement->execute();
        $data = $statement->fetch();
        return $data;
    }

    function insetar_externo($_P) {
        $sql = $this->Query("act_asitencia_externo(0,:p1,:p2,:p3,:p4)");
        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(':p1', $_P['idevento'], PDO::PARAM_INT);
        $stmt->bindValue(':p2', $_P['id_externo'], PDO::PARAM_INT);
        $stmt->bindValue(':p3', $_P['cargo'], PDO::PARAM_STR);
        $stmt->bindValue(':p4', NULL, PDO::PARAM_INT);


        $p1 = $stmt->execute();
        $p2 = $stmt->errorInfo();
        return array($p1, $p2[2]);
    }

    function get_prof_asignado($_even) {
        $sql = "SELECT
detalle_asistencia_docente.CodigoProfesor
FROM
detalle_asistencia_docente
WHERE
detalle_asistencia_docente.idevento = '" . $_even . "'";
        $statement = $this->db->prepare($sql);
        $statement->execute();
        $data = $statement->fetch();
        return $data;
    }

    function eliminar_externo($_ev, $_ex) {
        $sql = "DELETE FROM detalle_asistencia_externo 
where detalle_asistencia_externo.idevento='$_ev' 
and detalle_asistencia_externo.id_externos='$_ex'";
        $statement = $this->db->prepare($sql);
        $statement->execute();
        $data = $statement->fetchAll();
        return $data;
    }

    function get_cursos($profesor, $evento) {
        $sql = "SELECT
 carga_academica.CodigoProfesor,
 profesores.ApellidoPaterno,
 cursos.DescripcionCurso,
 carga_academica.CodigoCurso,
 carga_academica.CodigoSemestre,
 profesores.CodigoDptoAcad,
 profesores.CodigoProfesor,
case when (detalle_asistencia_docente.CodigoCurso =cursos.CodigoCurso) then 'yes' else 'no' end asignado
FROM
carga_academica
INNER JOIN profesores ON carga_academica.CodigoProfesor = profesores.CodigoProfesor
INNER JOIN cursos ON carga_academica.CodigoCurso = cursos.CodigoCurso
INNER JOIN semestreacademico ON semestreacademico.CodigoSemestre = carga_academica.CodigoSemestre
INNER JOIN departamentoacademico ON profesores.CodigoDedicacion = departamentoacademico.CodigoDptoAcad
LEFT JOIN detalle_asistencia_docente ON detalle_asistencia_docente.CodigoCurso = cursos.CodigoCurso and detalle_asistencia_docente.idevento='" . $evento . "'
WHERE carga_academica.CodigoSemestre='20132' AND profesores.CodigoDptoAcad='07' AND profesores.CodigoProfesor='" . $profesor . "'";
//        echo $sql;Exit;
        $statement = $this->db->prepare($sql);
        $statement->execute();
        $data = $statement->fetchAll();
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

    function detec_curso_profesor($_codP, $_codE) {
        $sql = "SELECT
detalle_asistencia_docente.CodigoCurso
FROM
detalle_asistencia_docente
WHERE detalle_asistencia_docente.CodigoProfesor='" . $_codP . "' and detalle_asistencia_docente.idevento='" . $_codE . "'";
        $statement = $this->db->prepare($sql);
        $statement->execute();
        $data = $statement->fetchAll();
        return $data;
    }

    function get_alumnos($codprof, $codcurso, $sem) {
        $sql = "SELECT
detalle_matricula.CodigoAlumno,
alumnos.ApellidoPaterno,
alumnos.ApellidoMaterno,
alumnos.NombreAlumno,
profesores.NombreProfesor
FROM
detalle_matricula
INNER JOIN alumnos ON alumnos.CodigoAlumno = detalle_matricula.CodigoAlumno
INNER JOIN profesores ON detalle_matricula.CodigoProfesor = profesores.CodigoProfesor
where detalle_matricula.CodigoProfesor='" . $codprof . "' and detalle_matricula.CodigoCurso in (" . $codcurso . ") and detalle_matricula.CodigoSemestre='" . $sem . "'
";

        $sql = $this->db->prepare($sql);
        $sql->execute();
        $data = $sql->fetchAll();
        return $data;
    }

    function actualizar_Alumno($_P) {
//        foreach ($_P['CodigoAlumno'] as $key => $value){
//            echo $key;
//            $CodigoAlumno=$_P['CodigoAlumno'][$key];
//            
//        }
        $sql2 = $this->Query("act_asistencia_alumno(2,:p1,:p2,:p3,:p4,:p5)");
        $stmt2 = $this->db->prepare($sql2);
        try {
            $this->db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $this->db->beginTransaction();
            $estado = false;
            foreach ($_P['CodigoAlumno'] as $key => $value) {
//                print_r($_P['idevento']);exit;
                $stmt2->bindValue(':p1', $value, PDO::PARAM_STR);
                $stmt2->bindValue(':p2', $_P['idevento'], PDO::PARAM_INT);
                $stmt2->bindValue(':p3', NULL, PDO::PARAM_STR);
                $stmt2->bindValue(':p4', $_P['cargo'][$key], PDO::PARAM_STR);
                $stmt2->bindValue(':p5', NULL, PDO::PARAM_STR);


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

    function mostar_lista_ps_externo($idevento) {
        $sql = "SELECT
detalle_asistencia_externo.id_externos,
detalle_asistencia_externo.costo,
detalle_asistencia_externo.asistencia_externo as  Asistencia,
cargo_asistencia_evento.descripcion as cargo,
detalle_asistencia_externo.idevento ,
evento.tema,
concat_ws(' ',externos.nombre,externos.apellido_paterno,externos.apellido_materno) as Nombre,
externos.DNI,
institucion.nombre_institucion
FROM
detalle_asistencia_externo
INNER JOIN cargo_asistencia_evento ON detalle_asistencia_externo.id_cargo = cargo_asistencia_evento.id_cargo
INNER JOIN evento ON detalle_asistencia_externo.idevento = evento.idevento
INNER JOIN externos ON detalle_asistencia_externo.id_externos = externos.id_externos
INNER JOIN institucion ON externos.id_institucion = institucion.id_institucion
WHERE (evento.idtipo_evento=3 or evento.idtipo_evento=5) AND evento.idevento='" . $idevento . "'"
        ;
        $statement = $this->db->prepare($sql);
        $statement->execute();
        $obj = $statement->fetchAll();
        return $obj;
    }

    function get_datos_externo_PS($_even) {
        $sql = "SELECT
            detalle_asistencia_externo.id_cargo,
externos.id_externos,
externos.institucion,
CONCAT(externos.nombre,' ', externos.apellidos) AS externo,
case when (detalle_asistencia_externo.id_externos =externos.id_externos) then 'yes' else 'no' end asignado 
FROM
externos
LEFT JOIN detalle_asistencia_externo ON detalle_asistencia_externo.id_externos = externos.id_externos and detalle_asistencia_externo.idevento='" . $_even . "'";
//        echo ($sql);exit;
        $statement = $this->db->prepare($sql);
        $statement->execute();
        $data = $statement->fetchAll();
        return $data;
    }

    function get_datos_alumnnos_activi_PS($idevento) {
        $sql = "SELECT
detalle_asistencia_alumno.id_cargo,
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
WHERE evento.idevento='" . $idevento . "'";

        $statement = $this->db->prepare($sql);
        $statement->execute();
        $alumnos = $statement->fetchAll();
        return $alumnos;
    }

    function mostar_lista_ps_docente($idevento) {
        $sql = "SELECT
detalle_asistencia_docente.costo,
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
WHERE evento.idevento='" . $idevento . "' and (evento.idtipo_evento=3 or evento.idtipo_evento=5 )
"
        ;
        $statement = $this->db->prepare($sql);
        $statement->execute();
        $obj = $statement->fetchAll();
        return $obj;
    }

    function insert_profesor($_P) {
        
        
        
        $sql2 = $this->Query("act_asistencia_docente(0,:p1,:p2,:p3,:p4,:p5)");
        $stmt2 = $this->db->prepare($sql2);
        try {
            $this->db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $this->db->beginTransaction();
            $estado = false;
            foreach ($_P['cod_profe'] as $key => $value) {
                $stmt2->bindValue(':p1', $value, PDO::PARAM_STR);
                $stmt2->bindValue(':p2', $_P['idevento'], PDO::PARAM_INT);
                $stmt2->bindValue(':p3', NULL, PDO::PARAM_STR);
                $stmt2->bindValue(':p4', NULL, PDO::PARAM_STR);
                $stmt2->bindValue(':p5', $_P['cargo_'][$key], PDO::PARAM_INT);

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
        
        
//        $cursoA = explode(",", $_P['curso']);
//        $sql2 = $this->Query("act_asistencia_docente(0,:p1,:p2,:p3,:p4,:p5,:p6)");
//        $stmt2 = $this->db->prepare($sql2);
//        try {
//            $this->db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
//            $this->db->beginTransaction();
//            $estado = false;
//            foreach ($cursoA as $key => $value) {
//                $cadena = ereg_replace("[^A-Za-z0-9]", "", $value);
//                $stmt2->bindValue(':p1', $_P['cod_prof'], PDO::PARAM_STR);
//                $stmt2->bindValue(':p2', $_P['idevento'], PDO::PARAM_INT);
//                $stmt2->bindValue(':p3', NULL, PDO::PARAM_STR);
//                $stmt2->bindValue(':p4', $cadena, PDO::PARAM_STR);
//                $stmt2->bindValue(':p5', $_P['costo'], PDO::PARAM_INT);
//                $stmt2->bindValue(':p6', $_P['cargo'], PDO::PARAM_INT);
//
//
//                $stmt2->execute();
//            }
//
//            $this->db->commit();
//            $p1 = true;
//            $p2[2] = "";
//        } catch (PDOException $e) {
//            $this->db->rollBack();
//            $p1 = false;
//            $p2[2] = $e->getMessage();
//        }
//
//        return array($p1, $p2[2]);
    }


    function insertar_alumnos($_P, $alumnos) {echo'entre carajo';
//        $sql = $this->Query("act_asistencia_alum(0,:p1,:p2,:p3,:p4,:p5)");
//        $stmt = $this->db->prepare($sql);
//        foreach ($alumnos as $key => $value){
////            echo $value['CodigoAlumno']."---".$_P['idevento']."<br>";
//        $stmt->bindValue(':p1', $value['CodigoAlumno'] , PDO::PARAM_STR);
//        $stmt->bindValue(':p2', $_P['idevento'] , PDO::PARAM_INT);
//        $stmt->bindValue(':p3', NULL , PDO::PARAM_STR);
//        $stmt->bindValue(':p4', NULL , PDO::PARAM_INT);
//        $stmt->bindValue(':p5', 1 , PDO::PARAM_INT);
//        $p1 = $stmt->execute();
//        $p2 = $stmt->errorInfo(); 
//        }     
//        return array($p1 , $p2[2]);

        $sql2 = $this->Query("act_asistencia_alumno(0,:p1,:p2,:p3,:p4,:p5)");
        $stmt2 = $this->db->prepare($sql2);
        try {
            $this->db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $this->db->beginTransaction();
            $estado = false;
            foreach ($alumnos as $key => $value) {
                $stmt2->bindValue(':p1', $value['CodigoAlumno'], PDO::PARAM_STR);
                $stmt2->bindValue(':p2', $_P['idevento'], PDO::PARAM_INT);
                $stmt2->bindValue(':p3', NULL, PDO::PARAM_STR);
                $stmt2->bindValue(':p5', 3, PDO::PARAM_INT);
                $stmt2->bindValue(':p6', $_P[cod_prof], PDO::PARAM_STR);


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

    function update_externos($_P) {
//        echo "<pre>";print_r($_P);exit;
        $sql2 = $this->Query("act_asistencia_externoPS(:p1,:p2,:p3)");
        $stmt2 = $this->db->prepare($sql2);
        try {
            $this->db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $this->db->beginTransaction();
            $estado = false;

            foreach ($_P['id_externo'] as $key => $r) {
                if ($_P['chek'][$_P['id_externo'][$key]] == "") {
                    $asi = "";
                } else {
                    $asi = 1;
                }
//                echo "id ex ".$_P['id_externo'][$key];echo "-";  echo "check".$_P['chek'][$_P['id_externo'][$key]];echo "<br>";
                $stmt2->bindValue(':p1', $_P['id_externo'][$key], PDO::PARAM_INT);
                $stmt2->bindValue(':p2', $_P['idevento'], PDO::PARAM_INT);
                $stmt2->bindValue(':p3', $asi, PDO::PARAM_STR);
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

        try {
            $this->db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $this->db->beginTransaction();
            foreach ($_Pa['CodigoAlumno'] as $key => $r) {
                echo "id al " . $_Pa['CodigoAlumno'][$key];
                echo "-";
                echo "check" . $_Pa['chek'][$_Pa['CodigoAlumno'][$key]];
                echo "<br>";
            } exit;
            $this->db->commit();
            $pa1 = true;
            $pa2[2] = "";
        } catch (PDOException $a) {
            $this->db->rollBack();
            $pa1 = false;
            $pa2[2] = $a->getMessage();
        }
        return array($pa1, $pa2[2]);
    }

    function update_docente($_Pd) {

        try {
            $this->db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $this->db->beginTransaction();
            foreach ($_Pd['CodigoProfesor'] as $key => $r) {
                echo "id ad " . $_Pd['CodigoProfesor'][$key];
                echo "-";
                echo "check" . $_Pd['chek'][$_Pd['CodigoProfesor'][$key]];
                echo "<br>";
            } exit;
            $this->db->commit();
            $pd1 = true;
            $pd2[2] = "";
        } catch (PDOException $a) {
            $this->db->rollBack();
            $pd1 = false;
            $pd2[2] = $a->getMessage();
        }
        return array($pd1, $pd2[2]);
    }

}
