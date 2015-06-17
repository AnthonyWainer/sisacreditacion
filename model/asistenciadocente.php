<?php

include_once("../lib/dbfactory.php");

class asistenciadocente extends Main {

      function index($query, $p, $c,$semestre_ultimo) {
        $sql = "        SELECT evento.idevento,
evento.tema, 
tipo_evento.descripcion,
evento.fecha,
evento.CodigoProfesor
FROM evento Inner Join tipo_evento ON tipo_evento.idtipo_evento = evento.idtipo_evento 
where tipo_evento.idtipo_evento='1' and evento.CodigoSemestre='".$semestre_ultimo."'";
//        echo $sql;exit;
        $param = array(array('key' => ':query', 'value' => "%$query%", 'type' => 'STR'));
        $data['total'] = $this->getTotal($sql, $param);
        $data['rows'] = $this->getRow($sql, $param, $p);
        $data['rowspag'] = $this->getRowPag($data['total'], $p);
        return $data;
    }
     function mostrar_Facultad_idUsusario($idusuario){
       $sql = "SELECT
        profesores.CodigoDptoAcad as depfac
        FROM
        profesores
        where profesores.CodigoProfesor='".$idusuario."'";
 
        $statement = $this->db->prepare($sql);
        $statement->execute();
        $data = $statement->fetch();
        return $data;
    } 
     function docentes_asignados($idfacultad,$sem,$idevento) 
    {       
            $sql = "  select    DISTINCT

                        profesores.CodigoProfesor,
                        concat(profesores.NombreProfesor,' ',profesores.ApellidoPaterno,' ',profesores.ApellidoMaterno) as Docente,
			profesores.sexo,
			profesores.FechaIngreso,
                         profesores.CodigoDptoAcad,
			case when( detalle_asistencia_docente_tutoria.asistencia_docente =1 and detalle_asistencia_docente_tutoria.idevento=".$idevento."  ) then 'Asistio' else 'Falta' end Asistencias,
			detalle_asistencia_docente_tutoria.idevento
                        FROM
                        detalle_matricula
                        Inner Join semestreacademico ON detalle_matricula.CodigoSemestre = semestreacademico.CodigoSemestre
                        Inner Join profesores ON profesores.CodigoProfesor = detalle_matricula.CodigoProfesor
                        Left Join detalle_asistencia_docente_tutoria ON detalle_asistencia_docente_tutoria.CodigoProfesor = profesores.CodigoProfesor and detalle_asistencia_docente_tutoria.idevento=".$idevento."
                        Inner Join departamentoacademico ON profesores.CodigoDptoAcad = departamentoacademico.CodigoDptoAcad
                        where
                        departamentoacademico.CodigoDptoAcad='".$idfacultad."' and semestreacademico.CodigoSemestre= '".$sem."'
                       ";
        $statement = $this->db->prepare($sql);
        $statement->execute();
        $data = $statement->fetchAll();
        return $data;
    }
    
    function profesores_acti($facul,$seme){
        $sql = "select DISTINCT

                        profesores.CodigoProfesor,
                        concat(profesores.NombreProfesor,' ',profesores.ApellidoPaterno,' ',profesores.ApellidoMaterno) as Docente,
                         profesores.CodigoDptoAcad
                        FROM
                        detalle_matricula
                        INNER JOIN semestreacademico ON detalle_matricula.CodigoSemestre = semestreacademico.CodigoSemestre
                        INNER JOIN profesores ON profesores.CodigoProfesor = detalle_matricula.CodigoProfesor
                        INNER JOIN departamentoacademico ON profesores.CodigoDptoAcad = departamentoacademico.CodigoDptoAcad
                  where
                            departamentoacademico.CodigoDptoAcad='".$facul."' and semestreacademico.CodigoSemestre= '".$seme."'";
        $statement = $this->db->prepare($sql);
        $statement->execute();
        $data = $statement->fetchAll();
        return $data;
    }
            
    function detector_de_evento($idevento){
                $sql = "SELECT
detalle_asistencia_docente_tutoria.idevento
FROM
detalle_asistencia_docente_tutoria
WHERE detalle_asistencia_docente_tutoria.idevento='".$idevento."'";
        $statement = $this->db->prepare($sql);
        $statement->execute();
        $data = $statement->fetchAll();
        return $data;
    }
    
    
            function devolver_asistencias($query,$p,$idevento){ 
        $sql="SELECT
            detalle_asistencia_docente_tutoria.asistencia_docente,
            detalle_asistencia_docente_tutoria.CodigoProfesor,
            detalle_asistencia_docente_tutoria.fecha
            FROM
            detalle_asistencia_docente_tutoria
            WHERE detalle_asistencia_docente_tutoria.idevento= '".$idevento."'";
            
         $param = array(array('key'=>':query' , 'value'=>"%$query%" , 'type'=>'STR' ));
        $data['total'] = $this->getTotal( $sql, $param );
        $data['rows'] =  $this->getRow($sql, $param , $p );        
        $data['rowspag'] = $this->getRowPag($data['total'], $p );        
        return $data;
    }
    function insert($iddocen,$idevento) {
        $sql2 = $this->Query("sp_detalle_asistencia_docente_tutoria_iu(0,:p1,:p2,:p3,:p4)");     
        $stmt2 = $this->db->prepare($sql2);
        try{
            $this->db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $this->db->beginTransaction();
            $estado = false;$n=0;
            
            foreach($iddocen as $key => $r) 
            {
                $stmt2->bindValue(':p1', $r['CodigoProfesor'], PDO::PARAM_STR);
                $stmt2->bindValue(':p2', $idevento , PDO::PARAM_STR);          
                $stmt2->bindValue(':p3', NULL, PDO::PARAM_STR); 
                $stmt2->bindValue(':p4', NULL, PDO::PARAM_STR); 
//                echo  $_P['codigo_primera_columna'][$key]."/".$idevento."/".$fecha."/".$_P['chek'][$key+1]; exit;
               
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
  function update($ideve,$idprof,$asis) {
        
        $sql2 = $this->Query("sp_detalle_asistencia_docente_tutoria_iu(1,:p1,:p2,:p3,:p4)");     
        $stmt2 = $this->db->prepare($sql2);
        try{
            $this->db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $this->db->beginTransaction();
            $estado = false;    
            foreach($idprof as $key => $r) 
            {
                $stmt2->bindValue(':p1', $r , PDO::PARAM_STR);
                $stmt2->bindValue(':p2', $ideve , PDO::PARAM_STR);          
                $stmt2->bindValue(':p3', NULL, PDO::PARAM_STR); 
                $stmt2->bindValue(':p4', $asis[$r], PDO::PARAM_STR); 
//                echo  $_P['codigo_primera_columna'][$key]."/".$idevento."/".$fecha."/".$_P['chek'][$key+1]; exit;
               
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



}

?>
