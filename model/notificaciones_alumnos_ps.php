<?php

include_once("../lib/dbfactory.php");

class notificaciones_alumnos_ps extends Main {


   
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
   
  
            
    function InsertDet_alumnos_notificaciones($_P) {
        $fecha=  date('Y/m/d');
        $estado=0;
      
        $stmt = $this->db->prepare("INSERT INTO detalle_alumno_evento VALUES(:idevento, :fecha, :CodigoAlumno, :estado, :CodigoSemestre,:mensaje,:mensaje_confirmacion)");
        $stmt->bindValue(':idevento',$_P['codigo'], PDO::PARAM_INT );
        $stmt->bindValue(':fecha',$fecha, PDO::PARAM_STR );
        $stmt->bindValue(':CodigoAlumno',$_P['alumno'], PDO::PARAM_STR);
        $stmt->bindValue(':estado',$estado, PDO::PARAM_INT );
        $stmt->bindValue(':CodigoSemestre',$_P['semestre'], PDO::PARAM_STR );
         $stmt->bindValue(':mensaje',$_P['mensaje'], PDO::PARAM_STR);
        $stmt->bindValue(':mensaje_confirmacion',$_P['mensaje_confirmacion'], PDO::PARAM_STR);
        $stmt->execute();
        return $stmt->fetchObject();
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
