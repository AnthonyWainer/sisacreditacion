<?php
include_once("../lib/dbfactory.php");
class misasistenciasAlumno extends Main{
    function index($query, $p, $c,$semestre_ultimo,$codalumno) {
        $sql = "        SELECT
                        evento.idevento,
                        evento.tema,
                        tipo_evento.descripcion,
                        evento.fecha,
			case when ( detalle_asistencia_alumno_tutoria.asistencia_alumno=1 and detalle_asistencia_alumno_tutoria.idevento=evento.idevento )  then 'Asistio' else ' No Asistio ' end Estado
                        FROM
                        tipo_evento
                        Inner Join evento ON evento.idevento = tipo_evento.idtipo_evento
                        Inner Join detalle_asistencia_alumno_tutoria ON evento.idevento = detalle_asistencia_alumno_tutoria.idevento
                        where  evento.CodigoSemestre='".$semestre_ultimo."' and detalle_asistencia_alumno_tutoria.CodigoAlumno=".$codalumno." and " . $c . " like :query";
        $param = array(array('key' => ':query', 'value' => "%$query%", 'type' => 'STR'));
        $data['total'] = $this->getTotal($sql, $param);
        $data['rows'] = $this->getRow($sql, $param, $p);
        $data['rowspag'] = $this->getRowPag($data['total'], $p);
        return $data;
    }
    function alumnos_asignados($query,$p,$CodigoProfesor,$CodigoSemestre) 
    {       
            $sql = "   SELECT
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
                        where detalle_asignacion_tutoria.CodigoProfesor=".$CodigoProfesor." and  detalle_asignacion_tutoria.CodigoSemestre=".$CodigoSemestre."
                       ";
        
        $param = array(array('key'=>':query' , 'value'=>"%$query%" , 'type'=>'STR' ));
        $data['total'] = $this->getTotal( $sql, $param );
        $data['rows'] =  $this->getRow($sql, $param , $p );        
        $data['rowspag'] = $this->getRowPag($data['total'], $p );        
        return $data;
    }
    function docentes_asignados($query,$p,$idfacultad,$sem) 
    {       
            $sql = "  SELECT DISTINCT
                        profesores.CodigoProfesor,
                        concat(profesores.NombreProfesor,' ',profesores.ApellidoPaterno,' ',profesores.ApellidoMaterno) AS Docente,
                        profesores.Sexo,
                        profesores.FechaIngreso,
                        profesores.CodigoDptoAcad
                        FROM
                                                detalle_matricula
                                                INNER JOIN semestreacademico ON detalle_matricula.CodigoSemestre = semestreacademico.CodigoSemestre
                                                INNER JOIN profesores ON profesores.CodigoProfesor = detalle_matricula.CodigoProfesor
                                                INNER JOIN departamentoacademico ON profesores.CodigoDptoAcad = departamentoacademico.CodigoDptoAcad

                        where
                        departamentoacademico.CodigoDptoAcad='".$idfacultad."' and semestreacademico.CodigoSemestre= '".$sem."'
                       ";
        
        $param = array(array('key'=>':query' , 'value'=>"%$query%" , 'type'=>'STR' ));
        $data['total'] = $this->getTotal( $sql, $param );
        $data['rows'] =  $this->getRow($sql, $param , $p );        
        $data['rowspag'] = $this->getRowPag($data['total'], $p );        
        return $data;
    }
	function mi_tutor($codalumno,$semestre){ 
        $tutor=$this->db->query("SELECT
                                       concat(profesores.NombreProfesor,' ',profesores.ApellidoPaterno,' ',profesores.ApellidoMaterno) AS TutorNombreCompleto
                                       FROM
                                       detalle_asignacion_tutoria
                                       Inner Join profesores ON profesores.CodigoProfesor = detalle_asignacion_tutoria.CodigoProfesor
                                       where detalle_asignacion_tutoria.CodigoAlumno=".$codalumno." and detalle_asignacion_tutoria.CodigoSemestre=".$semestre."");         
        $ct=$tutor->fetch();      
        $tutor=$ct['TutorNombreCompleto'];return $tutor;
    }
    
    

}
?>
