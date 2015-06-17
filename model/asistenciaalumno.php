<?php

include_once("../lib/dbfactory.php");

class asistenciaalumno extends Main {

    function index($query, $p, $c,$semestre_ultimo,$cod_profesor) {
        $sql = "        SELECT
                        evento.idevento,
                        evento.tema,
                        tipo_evento.descripcion,
                        evento.fecha,
                        evento.CodigoProfesor
                        FROM
                        evento
                        Inner Join tipo_evento ON tipo_evento.idtipo_evento = evento.idtipo_evento
                        where  tipo_evento.id_clasificacion_evento='1' and evento.CodigoSemestre='".$semestre_ultimo."'and 
(evento.CodigoProfesor is null or evento.CodigoProfesor='".$cod_profesor."')
                        and " . $c . " like :query";
//        echo $sql;exit;
        $param = array(array('key' => ':query', 'value' => "%$query%", 'type' => 'STR'));
        $data['total'] = $this->getTotal($sql, $param);
        $data['rows'] = $this->getRow($sql, $param, $p);
        $data['rowspag'] = $this->getRowPag($data['total'], $p);
        return $data;
    }
    
    function alumnos_de_profe($seme,$idprof){
        $sql = "SELECT
detalle_asignacion_tutoria.CodigoAlumno
FROM
detalle_asignacion_tutoria
where detalle_asignacion_tutoria.CodigoProfesor='".$idprof."' and detalle_asignacion_tutoria.CodigoSemestre='".$seme."'";
        $statement = $this->db->prepare($sql);
        $statement->execute();
        $data = $statement->fetchAll();
        return $data;
    }
    
    function detectando($ideven,$idprof){
        $sql = "SELECT
detalle_asistencia_alumno_tutoria.CodigoProfesor
FROM
detalle_asistencia_alumno_tutoria
where detalle_asistencia_alumno_tutoria.CodigoProfesor='".$idprof."' and detalle_asistencia_alumno_tutoria.idevento='".$ideven."'";
        $statement = $this->db->prepare($sql);
        $statement->execute();
        $data = $statement->fetchAll();
        return $data;
    }
            

    function insert($_event,$idprof,$idalum) {
//        echo "ente".$_event.','.$idprof.','.$idalum;print_r($idalum);exit;
        $sql2 = $this->Query("sp_detalle_asistencia_alumno_tutoria_iu(0,:p1,:p2,:p3,:p4,:p5,:p6)");     
        $stmt2 = $this->db->prepare($sql2);
        try{
            $this->db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $this->db->beginTransaction();
            $estado = false;
            foreach($idalum as $key => $r) 
            {  
                $stmt2->bindValue(':p1', $idprof , PDO::PARAM_STR);
                $stmt2->bindValue(':p2', $r['CodigoAlumno'] , PDO::PARAM_STR);
                $stmt2->bindValue(':p3', $_event , PDO::PARAM_STR);          
                $stmt2->bindValue(':p4', NULL, PDO::PARAM_STR); 
                $stmt2->bindValue(':p5', NULL, PDO::PARAM_STR); 
                $stmt2->bindValue(':p6', NULL, PDO::PARAM_STR); 
                
             
                $stmt2->execute();          
            }  
            
            $this->db->commit();            
            $p1 = true;
            $p2[2] = "";     
            
        }
        catch(PDOException $e) 
        {
            $this->db->rollBack();
            $p1 = false;
            $p2[2] = $e->getMessage();           
        }
        
        return array($p1 , $p2[2]);
        
    }
  function update($idevento,$idalumno,$idprof,$asis) {
        
        $sql2 = $this->Query("sp_detalle_asistencia_alumno_tutoria_iu(1,:p1,:p2,:p3,:p4,:p5,:p6)");     
        $stmt2 = $this->db->prepare($sql2);
        try{
            $this->db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $this->db->beginTransaction();
            $estado = false;
            foreach($idalumno as $key => $r) 
            {
                $stmt2->bindValue(':p1', $idprof , PDO::PARAM_STR);
                $stmt2->bindValue(':p2', $r , PDO::PARAM_STR);
                $stmt2->bindValue(':p3', $idevento , PDO::PARAM_STR);          
                $stmt2->bindValue(':p4', NULL, PDO::PARAM_STR); 
                $stmt2->bindValue(':p5', $asis[$r], PDO::PARAM_STR); 
                $stmt2->bindValue(':p6', "holis", PDO::PARAM_STR); 
                
             
                $stmt2->execute();          
            }  
            
            $this->db->commit();            
            $p1 = true;
            $p2[2] = "";     
            
        }
        catch(PDOException $e) 
        {
            $this->db->rollBack();
            $p1 = false;
            $p2[2] = $e->getMessage();           
        }
        
        return array($p1 , $p2[2]);
        
    }
    
    
    function lista_alumnos($ideven,$cod_prof,$codsem){
        $sql = "SELECT DISTINCT
 alumnos.CodigoAlumno,
 alumnos.NombreAlumno,
 concat(alumnos.ApellidoPaterno,' ',alumnos.ApellidoMaterno) AS Apellidos,
 concat(alumnos.TipoDocumento,' ',alumnos.NumDocumento) AS Documento,
 date(alumnos.FechaIngreso),
 alumnos.CodAlumnoSira,
case when( detalle_asistencia_alumno_tutoria.asistencia_alumno =1 and detalle_asistencia_alumno_tutoria.idevento=" . $ideven . "  ) then 'Asistio' else 'Falta' end Asistencias,
 detalle_asistencia_alumno_tutoria.idevento
 FROM
 detalle_asignacion_tutoria
 Inner Join profesores ON detalle_asignacion_tutoria.CodigoProfesor = profesores.CodigoProfesor
 Inner Join alumnos ON detalle_asignacion_tutoria.CodigoAlumno = alumnos.CodigoAlumno
 Left Join detalle_asistencia_alumno_tutoria ON detalle_asistencia_alumno_tutoria.CodigoAlumno = alumnos.CodigoAlumno and detalle_asistencia_alumno_tutoria.idevento='".$ideven."'
 Inner Join semestreacademico ON detalle_asignacion_tutoria.CodigoSemestre = semestreacademico.CodigoSemestre

 where detalle_asignacion_tutoria.CodigoProfesor='".$cod_prof."' and detalle_asignacion_tutoria.CodigoSemestre='".$codsem."'";
        $statement = $this->db->prepare($sql);
        $statement->execute();
        $data = $statement->fetchAll();
        return $data;
    }



}

?>
