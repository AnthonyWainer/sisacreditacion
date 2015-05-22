<?php

class Main {

    protected $db;
    protected $rows = 10;
    protected $pag = 5;
    protected $exec;

    public function __construct() {
        $site_path = realpath(dirname(__FILE__)) . DIRECTORY_SEPARATOR . '../lib/config.ini';
        try {
            $this->db = DatabaseFactory::create($site_path);
            $this->exec = DatabaseFactory::getExecute($site_path);
            $_SESSION['namebd'] = strtoupper($this->db->getAttribute(PDO::ATTR_DRIVER_NAME));
        } catch (PDOException $e) {
            $error = 'Conexion Fallada: ' . $e->getMessage();
            header("Location:index.php?controller=BaseDatos&action=orror&str=" . $error);
        }
    }

    public function Query($partSQL) {

        return $this->exec . " " . $partSQL;
    }

    public function en_fecha($fecha) {
        $fecha = str_replace("/", "-", $fecha);
        $f = explode("-", $fecha);
        if (strlen($f[0]) == 2) {
            return $f[2] . "-" . $f[1] . "-" . $f[0];
        } else {
            return $f[0] . "-" . $f[1] . "-" . $f[2];
        }
    }

    public function es_fecha($fecha) {

        $f = explode("-", $fecha);
        if ($f[2] == "00") {
            return "";
        } else {
            return $f[2] . "/" . $f[1] . "/" . $f[0];
        }
    }

   function get_datos_profesores_por_facultad($_evt,$semes,$idfacul){
//        $query = "select DISTINCT
//
//                        profesores.CodigoProfesor,
//                        concat(profesores.NombreProfesor,' ',profesores.ApellidoPaterno,' ',profesores.ApellidoMaterno) as Docente,
//                         profesores.CodigoDptoAcad
//                        FROM
//                        detalle_matricula
//                        INNER JOIN semestreacademico ON detalle_matricula.CodigoSemestre = semestreacademico.CodigoSemestre
//                        INNER JOIN profesores ON profesores.CodigoProfesor = detalle_matricula.CodigoProfesor
//                        INNER JOIN departamentoacademico ON profesores.CodigoDptoAcad = departamentoacademico.CodigoDptoAcad
//                  where
//                            departamentoacademico.CodigoDptoAcad='07' and semestreacademico.CodigoSemestre= '20132'";
$query ="select DISTINCT
                        detalle_asistencia_docente.id_cargo,
                        profesores.CodigoProfesor,
                        concat(profesores.NombreProfesor,' ',profesores.ApellidoPaterno,' ',profesores.ApellidoMaterno) as Docente,
                         profesores.CodigoDptoAcad,
case when (detalle_asistencia_docente.CodigoProfesor =profesores.CodigoProfesor) then 'yes' else 'no' end asignado
FROM
detalle_matricula
INNER JOIN semestreacademico ON detalle_matricula.CodigoSemestre = semestreacademico.CodigoSemestre
INNER JOIN profesores ON profesores.CodigoProfesor = detalle_matricula.CodigoProfesor
INNER JOIN departamentoacademico ON profesores.CodigoDptoAcad = departamentoacademico.CodigoDptoAcad
left JOIN detalle_asistencia_docente ON profesores.CodigoProfesor = detalle_asistencia_docente.CodigoProfesor and detalle_asistencia_docente.idevento='".$_evt."'
where
                            departamentoacademico.CodigoDptoAcad='".$idfacul."' and semestreacademico.CodigoSemestre= '".$semes."'
";
//echo $query;exit; 
        $sth = $this->db->prepare($query);
        $sth->execute();
        $profesores= $sth->fetchAll();

        return $profesores;
    }

    function getDetalle_evento() {
        $query = "SELECT 
                        evento.idevento,
                        evento.tema,
                        tipo_evento.descripcion,
                        evento.CodigoSemestre,
                        evento.fecha,
                        evento.fecha_termino,
                        evento.lugar,
                        evento.hora_evento,
                        `ubigeos$`.DISTRITO,
                        `ubigeos$`.PROVINCIA,
                        `ubigeos$`.DEPARTAM,
                        CONCAT(profesores.ApellidoPaterno,' ',profesores.ApellidoMaterno,' ',profesores.NombreProfesor) AS Responsable,
                        CONCAT(alumnos.ApellidoPaterno,' ',alumnos.ApellidoMaterno,' ',alumnos.NombreAlumno) AS Participante

                        FROM
                        evento
                        INNER JOIN tipo_evento ON evento.idtipo_evento = tipo_evento.idtipo_evento
                        INNER JOIN `ubigeos$` ON evento.Ubigeo = `ubigeos$`.UBIGEO
                        INNER JOIN profesores ON evento.CodigoProfesor = profesores.CodigoProfesor
                        INNER JOIN detalle_asistencia_alumno ON evento.idevento = detalle_asistencia_alumno.idevento
                        INNER JOIN alumnos ON detalle_asistencia_alumno.CodigoAlumno = alumnos.CodigoAlumno

                        where evento.idevento='{$this->criterio}'
                   
                            ";
                      
                      

        $sth = $this->db->prepare($query);
//        $sth->bindValue(':criterio', $this->criterio, PDO::PARAM_STR);
//        $sth->bindValue(':criterio1', $this->criterio1, PDO::PARAM_STR);
        $sth->execute();

        return $sth->fetchAll();
    }



function getDetalle_evento_eu() {
        $query = "SELECT 
                        evento.idevento,
                        evento.tema,
                        tipo_evento.descripcion,
                        evento.CodigoSemestre,
                        evento.fecha,
                        evento.fecha_termino,
                        evento.lugar,
                        evento.hora_evento,
                        `ubigeos$`.DISTRITO,
                        `ubigeos$`.PROVINCIA,
                        `ubigeos$`.DEPARTAM,
                        CONCAT(profesores.ApellidoPaterno,' ',profesores.ApellidoMaterno,' ',profesores.NombreProfesor) AS Responsable,
                        CONCAT(alumnos.ApellidoPaterno,' ',alumnos.ApellidoMaterno,' ',alumnos.NombreAlumno) AS Participante

                        FROM
                        evento
                        INNER JOIN tipo_evento ON evento.idtipo_evento = tipo_evento.idtipo_evento
                        INNER JOIN `ubigeos$` ON evento.Ubigeo = `ubigeos$`.UBIGEO
                        INNER JOIN profesores ON evento.CodigoProfesor = profesores.CodigoProfesor
                        INNER JOIN detalle_asistencia_alumno ON evento.idevento = detalle_asistencia_alumno.idevento
                        INNER JOIN alumnos ON detalle_asistencia_alumno.CodigoAlumno = alumnos.CodigoAlumno

                        where evento.idevento='{$this->criterio}'
                   
                            ";
                      
                      

        $sth = $this->db->prepare($query);
//        $sth->bindValue(':criterio', $this->criterio, PDO::PARAM_STR);
//        $sth->bindValue(':criterio1', $this->criterio1, PDO::PARAM_STR);
        $sth->execute();

        return $sth->fetchAll();
    }

    function cinco_ultimos_semestres() {
        $query = "SELECT 
                        distinct
                        semestreacademico.CodigoSemestre,
                        semestreacademico.Abreviatura
                         FROM
                        detalle_matricula
                        Inner Join semestreacademico ON semestreacademico.CodigoSemestre = detalle_matricula.CodigoSemestre
                        order by    semestreacademico.CodigoSemestre desc limit 0,5";

        $sth = $this->db->prepare($query);
        $sth->execute();
        return $sth->fetchAll();
    }

    function silDG() {
        $query = "SELECT cu.DescripcionCurso, cu.Creditos, cu.TipoCurso, cu.Ciclo, cu.CodCursoSira,
            ac.DescripcionArea, cu.HorasTeoria, cu.HorasPractica, si.idsilabus,
             si.sumilla, si.metodologia, si.competencia, sac.Abreviatura, sac.FechaInicio, sac.FechaTermino, 
             ca.CodigoCurso, CONCAT(pro.NombreProfesor,' ', pro.ApellidoPaterno,' ',pro.ApellidoMaterno),si.objetivo,
             cu.OrdenSegunPlan
            from cursos as cu inner join areacurricular as ac on
            cu.CodigoAreaCurricular = ac.CodigoAreaCurricular inner join carga_academica as ca on
            cu.CodigoCurso = ca.CodigoCurso inner join  silabus as si on
            ca.idcargaacademica = si.idcargaacademica inner join semestreacademico as sac on
            ca.CodigoSemestre = sac.CodigoSemestre inner join profesores as pro on
            ca.CodigoProfesor = pro.CodigoProfesor
            where idsilabus = {$this->filtro2} ";
        $sth = $this->db->prepare($query);
        $sth->bindValue(':filtro2', $this->filtro2, PDO::PARAM_INT);
        $sth->execute();
        return $sth->fetchAll();
    }

    function get_sub_eventos($idevento) {

        $query = " select * from evento where evento.idevento_padre='" . $idevento . "'";
//        echo $query;exit;
        $sth = $this->db->prepare($query);
        $sth->execute();
        $datos = $sth->fetchAll();
        return $datos;
    }

    function get_pre_actividades($idevento) {
        $query = " select * from p_c_evento where idevento='" . $idevento . "'";
//        echo $query;exit;
        $sth = $this->db->prepare($query);
        $sth->execute();
        $datos = $sth->fetchAll();
        return $datos;
    }

    function silUni() {
        $query = "SELECT idunidad,nombreunidad, descripcionunidad, duracion, competencia,porcentaje from unidad  
            where idsilabus = {$this->filtro2} ";
        $sth = $this->db->prepare($query);
        $sth->bindValue(':filtro2', $this->filtro2, PDO::PARAM_INT);
        $sth->execute();
        return $sth->fetchAll();
    }

    public function getFiels($p) {
        $query = "SELECT * from {$this->tabla} where {$this->tabla}.{$this->campo}={$this->idtabla}";
        $sth = $this->db->prepare($query);
        $sth->execute();
        return $sth->fetch();
    }

    function getList() {
        $query = "SELECT * FROM {$this->table} ";

        $sth = $this->db->prepare("SELECT * FROM {$this->table}");
        $sth->execute();
        return $sth->fetchAll();
    }

    function getDatos_grilla() {
        $query = "SELECT 
                            DISTINCT

                            profesores.CodigoProfesor,
                            concat(profesores.NombreProfesor,' ',profesores.ApellidoPaterno,' ',profesores.ApellidoMaterno) as Docente
                            FROM
                            detalle_matricula
                            Inner Join semestreacademico ON detalle_matricula.CodigoSemestre = semestreacademico.CodigoSemestre
                            Inner Join profesores ON profesores.CodigoProfesor = detalle_matricula.CodigoProfesor where
                            detalle_matricula.{$this->filtro}='{$this->criterio}'
                            ";

        $sth = $this->db->prepare($query);
//        $sth->bindValue(':criterio', $this->criterio, PDO::PARAM_STR);
//        $sth->bindValue(':criterio1', $this->criterio1, PDO::PARAM_STR);
        $sth->execute();

        return $sth->fetchAll();
    }

    function getSemestreActual() {
        $query = "SELECT
                        distinct
                        semestreacademico.CodigoSemestre,
                        semestreacademico.Abreviatura
                         FROM
                        detalle_matricula
                        Inner Join semestreacademico ON semestreacademico.CodigoSemestre = detalle_matricula.CodigoSemestre
                        order by semestreacademico.Abreviatura desc";

        $sth = $this->db->prepare($query);
        $sth->execute();
        return $sth->fetchAll();
    }

    public function getNotaspy(){
     $query="SELECT *from detalle_concepto_detproyecto INNER JOIN concepto on (concepto.idconcepto=detalle_concepto_detproyecto.idconcepto) where CodigoSemestre='{$this->criterio1}'";
        $sth = $this->db->prepare($query);   
     $sth->execute();
     return $sth->fetchAll();
    }
    function getRetornoN() {

        $query = "SELECT 
                        distinct
                        C.CodigoAlumno,
                        C.nota,
                        C.idevaluacion

                        from
                         calificacion AS C
                        inner join evaluacion as E on
                        E.idevaluacion=C.idevaluacion
                        inner join unidad as U on
                        E.idunidad=U.idunidad
                        inner join silabus as S on 
                        U.idsilabus=S.idsilabus
                        inner join carga_academica as CA on
                        S.idcargaacademica=CA.idcargaacademica

                        WHERE  CodigoCurso='{$this->criterio}' and CodigoSemestre='{$this->criterio1}'";

        $sth = $this->db->prepare($query);
        $sth->bindValue(':criterio', $this->criterio, PDO::PARAM_INT);
        $sth->bindValue(':criterio1', $this->criterio1, PDO::PARAM_INT);
        $sth->execute();
//    var_dump($sth);
//    exit();
        return $sth->fetchAll();
    }

    function getSemestre() {

        $query = "SELECT DISTINCT
                            semestreacademico.CodigoSemestre,
                            semestreacademico.Abreviatura
                                FROM
                                matricula
                                Inner Join alumnos ON alumnos.CodigoAlumno = matricula.CodigoAlumno
                                Inner Join semestreacademico ON semestreacademico.CodigoSemestre = matricula.CodigoSemestre
                                where
                                alumnos.CodigoAlumno= :filtro
                                order by semestreacademico.Abreviatura desc";

        $sth = $this->db->prepare($query);
        $sth->bindValue(':filtro', $this->filtro, PDO::PARAM_STR);
        $sth->execute();
        return $sth->fetchAll();
    }

    function getSemestreD() {

        $query = "select 
                        distinct
                        semestreacademico.CodigoSemestre,
                        semestreacademico.Abreviatura
                        from
                        carga_academica
                        inner join semestreacademico on semestreacademico.CodigoSemestre=carga_academica.CodigoSemestre
                                where
                                carga_academica.CodigoProfesor= :filtro
                                order by semestreacademico.Abreviatura desc";

        $sth = $this->db->prepare($query);
        $sth->bindValue(':filtro', $this->filtro, PDO::PARAM_STR);
        $sth->execute();
        return $sth->fetchAll();
    }

    function getDatos_grilla_asi_tuto() {
        $query = "SELECT
alumnos.NombreAlumno,
evento.tema,
detalle_asistencia_alumno_tutoria.fecha,
detalle_asistencia_alumno_tutoria.asistencia_alumno,
detalle_asistencia_alumno_tutoria.observacion_alumno,
detalle_asistencia_alumno_tutoria.CodigoAlumno
FROM
detalle_asistencia_alumno_tutoria
Inner Join alumnos ON detalle_asistencia_alumno_tutoria.CodigoAlumno = alumnos.CodigoAlumno
Inner Join evento ON evento.idevento = detalle_asistencia_alumno_tutoria.idevento


                    where
                             detalle_asistencia_alumno_tutoria.idevento='{$this->criterio}'
                            ";

        $sth = $this->db->prepare($query);
//        $sth->bindValue(':criterio', $this->criterio, PDO::PARAM_STR);
//        $sth->bindValue(':criterio1', $this->criterio1, PDO::PARAM_STR);
        $sth->execute();

        return $sth->fetchAll();
    }

    function getDatos_grilla_facultad() {

        $query = "select DISTINCT

                        profesores.CodigoProfesor,
                        concat(profesores.NombreProfesor,' ',profesores.ApellidoPaterno,' ',profesores.ApellidoMaterno) as Docente,
                         profesores.CodigoDptoAcad
                        FROM
                        detalle_matricula
                        INNER JOIN semestreacademico ON detalle_matricula.CodigoSemestre = semestreacademico.CodigoSemestre
                        INNER JOIN profesores ON profesores.CodigoProfesor = detalle_matricula.CodigoProfesor
                        INNER JOIN departamentoacademico ON profesores.CodigoDptoAcad = departamentoacademico.CodigoDptoAcad
                  where
                            departamentoacademico.CodigoDptoAcad='{$this->criterio}' and semestreacademico.CodigoSemestre= {$this->criterio2} ";

        $sth = $this->db->prepare($query);
//        $sth->bindValue(':criterio', $this->criterio, PDO::PARAM_STR);
//        $sth->bindValue(':criterio1', $this->criterio1, PDO::PARAM_STR);
        $sth->execute();

        return $sth->fetchAll();
    }

    //cambiar consu

    function getLista() {
        $query = "select 
                        C.CodigoCurso,
                        C.DescripcionCurso,
                        C.creditos,
                        P.NombreProfesor,
                        DM.CodigoCurso,
                        DM.CodigoSemestre
                        from detalle_matricula as DM
                        INNER JOIN cursos AS C ON C.CodigoCurso = DM.CodigoCurso
                        INNER JOIN profesores AS P ON P.CodigoProfesor = DM.CodigoProfesor
                        WHERE DM.{$this->filtro1}= '$this->criterio1' AND DM.{$this->filtro}='$this->criterio'";

        $sth = $this->db->prepare($query);
        $sth->bindValue(':criterio', $this->criterio, PDO::PARAM_STR);
        $sth->bindValue(':criterio1', $this->criterio1, PDO::PARAM_STR);
        $sth->execute();
//        var_dump($sth);
//        exit();
        return $sth->fetchAll();
    }

    function get_mostrar_mis_asistencias_eventos_tutoria_alumno() {
        $query = "SELECT
 evento.idevento,
 evento.tema,
 tipo_evento.descripcion,
 evento.fecha,
 case when ( detalle_asistencia_alumno_tutoria.asistencia_alumno=1 and detalle_asistencia_alumno_tutoria.idevento=evento.idevento ) then 'Asistio' else ' No Asistio ' end Estado
 FROM
 tipo_evento
 Inner Join evento ON evento.idtipo_evento = tipo_evento.idtipo_evento
 Inner Join detalle_asistencia_alumno_tutoria ON evento.idevento = detalle_asistencia_alumno_tutoria.idevento
                        where  evento.CodigoSemestre='{$this->criterio}' and detalle_asistencia_alumno_tutoria.CodigoAlumno='{$this->criterio2}'";


        $sth = $this->db->prepare($query);
        $sth->execute();

        return $sth->fetchAll();
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

    function getDatos_grilla_Profesor_asignacion() {
        $query = "select DISTINCT

                        profesores.CodigoProfesor,
                        concat(profesores.NombreProfesor,' ',profesores.ApellidoPaterno,' ',profesores.ApellidoMaterno) as Docente
                        FROM
                        detalle_matricula
                        INNER JOIN semestreacademico ON detalle_matricula.CodigoSemestre = semestreacademico.CodigoSemestre
                        INNER JOIN profesores ON profesores.CodigoProfesor = detalle_matricula.CodigoProfesor
                        INNER JOIN departamentoacademico ON profesores.CodigoDptoAcad = departamentoacademico.CodigoDptoAcad
                  where
                            departamentoacademico.CodigoDptoAcad='{$this->criterio}'
                            ";

        $sth = $this->db->prepare($query);
//        $sth->bindValue(':criterio', $this->criterio, PDO::PARAM_STR);
//        $sth->bindValue(':criterio1', $this->criterio1, PDO::PARAM_STR);
        $sth->execute();

        return $sth->fetchAll();
    }

    function getListaA() {
        $query = "SELECT 
                        A.CodigoAlumno,
                        concat(A.ApellidoPaterno,' ',A.ApellidoMaterno,', ',A.NombreAlumno) as alumno,
                        A.CodAlumnoSira
                        from detalle_matricula as DM
                        inner join alumnos AS A on A.CodigoAlumno = DM.CodigoAlumno
                        inner join cursos as C on C.CodigoCurso = DM.CodigoCurso

                        WHERE DM.{$this->filtro}= '{$this->criterio}' AND DM.{$this->filtro1}='{$this->criterio1}'
                        ORDER By alumno asc";
        $sth = $this->db->prepare($query);
        $sth->bindValue(':criterio', $this->criterio, PDO::PARAM_STR);
        $sth->bindValue(':criterio1', $this->criterio1, PDO::PARAM_STR);
        $sth->execute();
//        var_dump($sth);
//        exit();
        return $sth->fetchAll();
    }

    function getNombre() {
        $query = "select 
                            cursos.DescripcionCurso
                            FROM 
                            cursos

                            where 
                             cursos.{$this->filtro}= '{$this->criterio}' ";

        $sth = $this->db->prepare($query);
        $sth->bindValue(':criterio', $this->criterio, PDO::PARAM_STR);
        $sth->execute();
//        var_dump($sth);
//        exit();
        return $sth->fetchAll();
    }

    function getSyllabus_P() {
        $query = "SELECT 
                        E.descripcionevaluacion,
                        E.fecha,
                        E.ponderado,
                        E.idevaluacion,
                        CA.CodigoCurso,
                        CA.CodigoSemestre,
                        C.DescripcionCurso,
                       TE.descripcion,
                       U.nombreunidad,
                       U.idunidad,
                       U.porcentaje
                        from evaluacion as E
                        inner join unidad as U on U.idunidad = E.idunidad
                        inner join silabus as S on S.idsilabus = U.idsilabus
                        inner join carga_academica as CA on CA.idcargaacademica = S.idcargaacademica
                        inner join cursos as C on C.CodigoCurso = CA.CodigoCurso
                       inner join tipo_evaluacion as TE  on E.idtipo_evaluacion=TE.idtipo_evaluacion

                                WHERE CA.{$this->filtro}= '{$this->criterio}' AND CA.{$this->filtro1}='{$this->criterio1}'
                    group by U.nombreunidad
                        ";


        $sth = $this->db->prepare($query);
        $sth->bindValue(':criterio', $this->criterio, PDO::PARAM_STR);
        $sth->bindValue(':criterio1', $this->criterio1, PDO::PARAM_STR);
        $sth->execute();
//        var_dump($sth);
//        exit();
        return $sth->fetchAll();
    }
    function getSyllabus_P3() {
        $query = "SELECT 
                        E.descripcionevaluacion,
                        E.fecha,
                        E.ponderado,
                        E.idevaluacion,
                        CA.CodigoCurso,
                        CA.CodigoSemestre,
                        C.DescripcionCurso,
                       TE.descripcion,
                       U.nombreunidad,
                       U.idunidad,
                       E.estadoBoton
                        from evaluacion as E
                        inner join unidad as U on U.idunidad = E.idunidad
                        inner join silabus as S on S.idsilabus = U.idsilabus
                        inner join carga_academica as CA on CA.idcargaacademica = S.idcargaacademica
                        inner join cursos as C on C.CodigoCurso = CA.CodigoCurso
                       inner join tipo_evaluacion as TE  on E.idtipo_evaluacion=TE.idtipo_evaluacion

                                WHERE CA.{$this->filtro}= '{$this->criterio}' AND CA.{$this->filtro1}='{$this->criterio1}'
                        ";


        $sth = $this->db->prepare($query);
        $sth->bindValue(':criterio', $this->criterio, PDO::PARAM_STR);
        $sth->bindValue(':criterio1', $this->criterio1, PDO::PARAM_STR);
        $sth->execute();
//        var_dump($sth);
//        exit();
        return $sth->fetchAll();
    }
    function getSyllabus_P4() {
        $query = "SELECT 
                        TE.descripcion, E.ponderado,
                       
                       U.nombreunidad,
                       U.idunidad
                        from evaluacion as E
                        inner join unidad as U on U.idunidad = E.idunidad
                        inner join silabus as S on S.idsilabus = U.idsilabus
                        inner join carga_academica as CA on CA.idcargaacademica = S.idcargaacademica
                        inner join cursos as C on C.CodigoCurso = CA.CodigoCurso
                       inner join tipo_evaluacion as TE  on E.idtipo_evaluacion=TE.idtipo_evaluacion

                                WHERE CA.CodigoCurso= '{$this->filtro1}' AND CA.CodigoSemestre='{$this->cod}'
                        ";


        $sth = $this->db->prepare($query);
        $sth->bindValue(':filtro1', $this->filtro1, PDO::PARAM_STR);
        $sth->bindValue(':filtro', $this->cod, PDO::PARAM_STR);
        $sth->execute();
//        var_dump($sth);
//        exit();
        return $sth->fetchAll();
    }
    function getSyllabus_P5() {

        $query = "SELECT 
                        te.descripcion,Cal.nota,porcentaje,ponderado
                        from evaluacion as E INNER JOIN
                                                calificacion as Cal ON  E.idevaluacion = Cal.idevaluacion 
                                                inner join tipo_evaluacion as te on E.idtipo_evaluacion = te.idtipo_evaluacion
                        inner join unidad as U on U.idunidad = E.idunidad
                        inner join silabus as S on S.idsilabus = U.idsilabus
                        inner join carga_academica as CA on CA.idcargaacademica = S.idcargaacademica
                        inner join cursos as C on C.CodigoCurso = CA.CodigoCurso

                         WHERE CA.{$this->filtro}= '{$this->criterio}' AND CA.{$this->filtro1}='{$this->criterio1}'AND Cal.{$this->filtro2}='{$this->criterio2}'
                        ";


        $sth = $this->db->prepare($query);
        $sth->bindValue(':criterio', $this->criterio, PDO::PARAM_STR);
        $sth->bindValue(':criterio1', $this->criterio1, PDO::PARAM_STR);
        $sth->bindValue(':criterio2', $this->criterio2, PDO::PARAM_STR);
        $sth->execute();
//        var_dump($sth);
//        exit();
        return $sth->fetchAll();
    }    
    
    function getSyllabus_P2() {
        $query = "SELECT 
                       
                        E.fecha,
                        CA.CodigoCurso,
                        CA.CodigoSemestre,
                       TE.descripcion
                        from evaluacion as E
                        inner join unidad as U on U.idunidad = E.idunidad
                        inner join silabus as S on S.idsilabus = U.idsilabus
                        inner join carga_academica as CA on CA.idcargaacademica = S.idcargaacademica
                        inner join cursos as C on C.CodigoCurso = CA.CodigoCurso
                       inner join tipo_evaluacion as TE  on E.idtipo_evaluacion=TE.idtipo_evaluacion

                        WHERE CA.{$this->filtro}= '{$this->criterio}' AND CA.{$this->filtro1}='{$this->criterio1}'";

        $sth = $this->db->prepare($query);
        $sth->bindValue(':criterio', $this->criterio, PDO::PARAM_STR);
        $sth->bindValue(':criterio1', $this->criterio1, PDO::PARAM_STR);
        $sth->execute();
//        var_dump($sth);
//        exit();
        return $sth->fetchAll();
    }

    function getListaD() {

        $query = "
                        SELECT
                                
                                    carga_academica.CodigoCurso,
                                    cursos.DescripcionCurso as Curso,
                                    concat(profesores.NombreProfesor,' ',profesores.ApellidoPaterno,' ',profesores.ApellidoMaterno) as Docente,
                                   cursos.creditos,
                                   plancurricular.descripcionplan

                                 FROM
                                  carga_academica
                                   INNER JOIN profesores ON carga_academica.CodigoProfesor = profesores.CodigoProfesor
                                    INNER JOIN cursos ON carga_academica.CodigoCurso = cursos.CodigoCurso
                                    inner join plancurricular on plancurricular.codigoplan=cursos.codigoplan
                                

                        WHERE carga_academica.{$this->filtro}= '{$this->criterio1}' AND carga_academica.{$this->filtro1}='{$this->criterio}'";

        $sth = $this->db->prepare($query);
//        $sth->bindValue(':criterio', $this->criterio, PDO::PARAM_STR);
//        $sth->bindValue(':criterio1', $this->criterio1, PDO::PARAM_STR);
        $sth->execute();
//        var_dump($sth);
//        exit();
        return $sth->fetchAll();
    }

    function estadoSil() {
        $query = "SELECT CodigoCurso from carga_academica inner join silabus on 
        carga_academica.idcargaacademica = silabus.idcargaacademica
            where CodigoSemestre= {$this->criterio} and CodigoProfesor= {$this->criterio1}
        ";
        $sth = $this->db->prepare($query);
        $sth->execute();
        return $sth->fetchAll();
    }
    function estadoSilAlu() {
        $query = "SELECT CodigoCurso from carga_academica inner join silabus on 
        carga_academica.idcargaacademica = silabus.idcargaacademica
            where CodigoSemestre= {$this->criterio1}
        ";
        $sth = $this->db->prepare($query);
        $sth->execute();
        return $sth->fetchAll();
    }

    function getSilabu() {
        $query = "select
                            distinct
                            silabus.competencia,
                            silabus.metodologia,
                            silabus.objetivo,
                            silabus.sumilla,
                            carga_academica.CodigoSemestre,
                            carga_academica.CodigoCurso,
                            silabus.idsilabus
                            from 
                            carga_academica
                            inner join silabus on silabus.idcargaacademica=carga_academica.idcargaacademica
                                WHERE carga_academica.{$this->filtro}='$this->criterio' and carga_academica.{$this->filtro1}='$this->criterio1'";

        $sth = $this->db->prepare($query);
        $sth->execute();
//        var_dump($sth);
//        exit();
        return $sth->fetchAll();
    }

    function getBibliografia() {
        $query = "SELECT bi.idbibliografia, bi.referencia, bi.descripcion, tb.idtipo_bibliografia,
                        tb.descripcion_tipobibliografia, bi.identificador
                 FROM bibliografia as bi inner join tipo_bibliografia as tb on
                    tb.idtipo_bibliografia = bi.idtipo_bibliografia
                     WHERE identificador = 1 ";
        $sth = $this->db->prepare($query);
        $sth->execute();
        return $sth->fetchAll();
    }
 function getBibliografiaS() {
        $query = "SELECT bi.idbibliografia, bi.referencia, bi.descripcion, tb.idtipo_bibliografia,
                        tb.descripcion_tipobibliografia, bi.identificador
                 FROM bibliografia as bi inner join tipo_bibliografia as tb on
                    tb.idtipo_bibliografia = bi.idtipo_bibliografia
                     WHERE referencia ='$this->filtro2' and identificador = 1 ";
        $sth = $this->db->prepare($query);
        $sth->execute();
        return $sth->fetchAll();
    }
    function getdatos_Silabu() {


        $query = "select
                            distinct
                             silabus.competencia,
                            silabus.metodologia,
                            silabus.objetivo,
                            silabus.sumilla,
                            carga_academica.CodigoSemestre,
                            carga_academica.CodigoCurso,
                            silabus.idsilabus
                            from 
                            carga_academica
                            inner join silabus on silabus.idcargaacademica=carga_academica.idcargaacademica
                                WHERE carga_academica.{$this->filtro}='$this->criterio0' and carga_academica.{$this->filtro1}='$this->criterio1'";

        $sth = $this->db->prepare($query);
        $sth->execute();
        return $sth->fetchAll();
    }

    function getUnidad() {
        $query = " select
                               distinct
                               U.nombreunidad,
                               U.idunidad,
                               CA.CodigoSemestre,
                               CA.CodigoCurso,
                               U.descripcionunidad,
                               U.competencia,
                               U.porcentaje,
                               U.duracion
                                from unidad as U
                                inner join silabus as S on S.idsilabus = U.idsilabus
                                inner join carga_academica as CA on CA.idcargaacademica = S.idcargaacademica
                                inner join cursos as C on C.CodigoCurso = CA.CodigoCurso
                                WHERE 
                                CA.{$this->filtro}='{$this->criterio}' and CA.{$this->filtro1}='{$this->criterio1}'";

        $sth = $this->db->prepare($query);
        $sth->execute();
//        var_dump($sth);
//        exit();
        return $sth->fetchAll();
    }

    function getUnidadid() {
        $query = " select
                               distinct
                                   U.nombreunidad,
                                   U.idunidad,
                                   T.semana,
                                   T.contenido,
                                   T.conceptual,
                                   T.procedimental,
                                   T.actitudinal,
                                   T.competencia,
                                   T.idunidad,
                                   S.sumilla,
                                   S.metodologia,
                                   S.competencia,
                                   S.objetivo,
                                   C.Creditos,
                                   C.DescripcionCurso,
                                   C.Ciclo,
                                   EP.DescripcionEscuela,
                                   F.DescripcionFacultad,
                                   SA.Abreviatura,
                                   S.duracion,
                                   CONCAT(P.NombreProfesor,' ',P.ApellidoPaterno,' ',P.ApellidoMaterno) as NombreProfesor,
                                   P.Email,
                                   B.descripcion
                                   FROM
                                   unidad AS U
                                   Inner Join tema AS T ON U.idunidad = T.idunidad
                                   Inner Join silabus AS S ON S.idsilabus = U.idsilabus
                                   Inner Join carga_academica AS CA ON CA.idcargaacademica = S.idcargaacademica
                                   Inner Join cursos AS C ON C.CodigoCurso = CA.CodigoCurso
                                   Inner Join escuelaprofesional AS EP ON EP.CodigoEscuela = C.CodigoEscuela
                                   Inner Join facultades AS F ON F.CodigoFacultad = EP.CodigoFacultad
                                   Inner Join semestreacademico AS SA ON SA.CodigoSemestre = CA.CodigoSemestre
                                   Inner Join profesores as P ON P.CodigoProfesor = CA.CodigoProfesor
                                   cross join bibliografia AS B ON B.identificador = S.idsilabus
                                WHERE 
                                CA.{$this->filtro}='{$this->criterio}' and CA.{$this->filtro1}='{$this->criterio1}'";

        $sth = $this->db->prepare($query);
        $sth->execute();
//        var_dump($sth);
//        exit();
        return $sth->fetchAll();
    }

//    function getSilabusid() {
//        $query = " select
//                              
//                            distinct
//                            silabus.competencia,
//                            silabus.metodologia,
//                            silabus.objetivo,
//                            silabus.sumilla,
//                            CA.CodigoSemestre,
//                            CA.CodigoCurso
//                            from 
//                            carga_academica as CA
//                            inner join silabus on silabus.idcargaacademica=CA.idcargaacademica
//                                WHERE CA.{$this->filtro}='$this->criterio' and CA.{$this->filtro1}='$this->criterio1'";
//
//        $sth = $this->db->prepare($query);
//        $sth->execute();
////        var_dump($sth);
////        exit();
//        return $sth->fetchAll();
//    }
//    

    function getTema() {
        $query = " SELECT distinct 
                 semana, contenido, conceptual, procedimental, actitudinal, tema.idtema,idunidad,clase.fecha,clase.idtema,clase.idclase
                            FROM tema
                left join clase on 
                tema.idtema=clase.idtema
                                WHERE 
                                {$this->filtro}={$this->criterio}";

        $sth = $this->db->prepare($query);
        $sth->execute();
//        var_dump($sth);
//        exit();
        return $sth->fetchAll();
    }

    function getEvaluacion() {
        $query = "SELECT idtipo_evaluacion, descripcionevaluacion, fecha, ponderado,idevaluacion FROM `evaluacion`
                  WHERE idunidad= {$this->criterio} ";
        $sth = $this->db->prepare($query);
        $sth->execute();
        return $sth->fetchAll();
    }
        function getEvaluacion3() {
        $query = "SELECT descripcion,idunidad,evaluacion.ponderado,fecha,idevaluacion,evaluacion.estadoBoton FROM `evaluacion` inner join tipo_evaluacion on evaluacion.idtipo_evaluacion = tipo_evaluacion.idtipo_evaluacion
                  ";
        $sth = $this->db->prepare($query);
        $sth->execute();
        return $sth->fetchAll();
    }
        function getTipEva() {
        $query = "SELECT idtipo_evaluacion, descripcion FROM `tipo_evaluacion`";
        $sth = $this->db->prepare($query);
        $sth->execute();
        return $sth->fetchAll();
    }

    function getClase() {
        $query = " select 
                            clase.idclase,
                            clase.fecha,
                            clase.idtema
                            from 
                            clase
                            inner join tema on tema.idtema=clase.idtema
                                WHERE 
                                clase.{$this->filtro}={$this->criterio}";

        $sth = $this->db->prepare($query);
        $sth->execute();
//        var_dump($sth);
//        exit();
        return $sth->fetchAll();
    }

       
    function getBiblio() {
        $query = " SELECT distinct 
                    
                semana, contenido, conceptual, procedimental, actitudinal, competencia,idtema
                            FROM tema
                                WHERE 
                                {$this->filtro}={$this->criterio}";

        $sth = $this->db->prepare($query);
        $sth->execute();
//        var_dump($sth);
//        exit();
        return $sth->fetchAll();
    }

    function getDatos_grilla_solicitudes() {
        $codigo = $_SESSION['idusuario'];
        $query = "SELECT
                    proyecto.idproyecto,
                    CONCAT(alumnos.NombreAlumno,' ',alumnos.ApellidoPaterno,' ',alumnos.ApellidoMaterno) as Alumno,
                    proyecto.nombre_proyecto,
                    detalleproyecto_matrixalumno.mensaje,
                    detalleproyecto_matrixalumno.fecha,
                    alumnos.CodigoAlumno
                    FROM
                    (detalleproyecto_matrixalumno
                    INNER JOIN alumnos ON alumnos.CodigoAlumno = detalleproyecto_matrixalumno.CodigoAlumno
                    INNER JOIN proyecto ON detalleproyecto_matrixalumno.idproyecto = proyecto.idproyecto)
                    INNER JOIN detalle_profesor_proy_fun ON proyecto.idproyecto=detalle_profesor_proy_fun.idproyecto
                    WHERE detalleproyecto_matrixalumno.estado=0 AND detalle_profesor_proy_fun.CodigoProfesor='" . $codigo . "'";

        $sth = $this->db->prepare($query);
//        $sth->bindValue(':criterio', $this->criterio, PDO::PARAM_STR);
//        $sth->bindValue(':criterio1', $this->criterio1, PDO::PARAM_STR);
        $sth->execute();

        return $sth->fetchAll();
    }

    function getList_ajax() {
        $sth = $this->db->prepare("SELECT * FROM {$this->table} where {$this->filtro} = :criterio");
        $sth->bindValue(':criterio', $this->criterio, PDO::PARAM_INT);
        $sth->execute();
        return $sth->fetchAll();
    }

    function getList_ajax_string() {
        //$sql= 'SELECT distinct `ubigeos$`.PROVINCIA FROM {$this->table} WHERE `ubigeos$`.DEPARTAM="'.$param.'"';
        $sth = $this->db->prepare("SELECT distinct PROVINCIA,PROVINCIA FROM {$this->table} where {$this->filtro} = :criterio");
        $sth->bindValue(':criterio', $this->criterio, PDO::PARAM_STR);
        $sth->execute();
        return $sth->fetchAll();
    }

    function getDatos_grilla_solicitudes_ps() {
        $codigo = $_SESSION['idusuario'];
        $query = "SELECT
                    evento.tema,
                    evento.idtipo_evento,
                    tipo_evento.descripcion,
                    evento.CodigoProfesor,
                    CONCAT(alumnos.NombreAlumno,' ',alumnos.ApellidoPaterno,' ',alumnos.ApellidoMaterno)as Nombre,
                    detalle_alumno_evento.CodigoAlumno,
                    detalle_alumno_evento.mensaje,
                    detalle_alumno_evento.fecha,
                    detalle_alumno_evento.estado,
                    evento.idevento
                    FROM
                    ((evento  
                    INNER JOIN detalle_alumno_evento ON evento.idevento = detalle_alumno_evento.idevento ) 
                    inner join alumnos ON detalle_alumno_evento.CodigoAlumno=alumnos.CodigoAlumno)
                    INNER JOIN tipo_evento ON evento.idtipo_evento=tipo_evento.idtipo_evento 
                    WHERE detalle_alumno_evento.estado='en espera' and evento.idtipo_evento in (3,5) AND evento.CodigoProfesor='" . $codigo . "'"
                . "ORDER BY fecha asc";
//        echo $query;exit;
        $sth = $this->db->prepare($query);
//        $sth->bindValue(':criterio', $this->criterio, PDO::PARAM_STR);
//        $sth->bindValue(':criterio1', $this->criterio1, PDO::PARAM_STR);
        $sth->execute();
        return $sth->fetchAll();
    }
function getDatos_grilla_solicitudes_eu() {
        $codigo = $_SESSION['idusuario'];
        $query = "SELECT
                    evento.tema,
                    evento.idtipo_evento,
                    tipo_evento.descripcion,
                    evento.CodigoProfesor,
                    CONCAT(alumnos.NombreAlumno,' ',alumnos.ApellidoPaterno,' ',alumnos.ApellidoMaterno)as Nombre,
                    detalle_alumno_evento.CodigoAlumno,
                    detalle_alumno_evento.mensaje,
                    detalle_alumno_evento.fecha,
                    detalle_alumno_evento.estado,
                    evento.idevento
                    FROM
                    ((evento  
                    INNER JOIN detalle_alumno_evento ON evento.idevento = detalle_alumno_evento.idevento ) 
                    inner join alumnos ON detalle_alumno_evento.CodigoAlumno=alumnos.CodigoAlumno)
                    INNER JOIN tipo_evento ON evento.idtipo_evento=tipo_evento.idtipo_evento 
                    WHERE detalle_alumno_evento.estado='en espera'  and  evento.idtipo_evento in (4,6) AND evento.CodigoProfesor='" . $codigo . "'"
                . "ORDER BY fecha asc";
        $sth = $this->db->prepare($query);
//        $sth->bindValue(':criterio', $this->criterio, PDO::PARAM_STR);
//        $sth->bindValue(':criterio1', $this->criterio1, PDO::PARAM_STR);
        $sth->execute();
        return $sth->fetchAll();
    }
     function getDatos_grilla_solicitudes_docentes_ps() {
        $codigo = $_SESSION['idusuario'];
        $query = "SELECT
                    evento.tema,
                    evento.idtipo_evento,
                    tipo_evento.descripcion,
                    evento.CodigoProfesor,
                    CONCAT(profesores.NombreProfesor,' ',profesores.ApellidoPaterno,' ',profesores.ApellidoMaterno)as Nombre,
                    detalle_profesor_evento.CodigoProfesor,
                    detalle_profesor_evento.mensaje,
                    detalle_profesor_evento.fecha,
                    detalle_profesor_evento.estado,
                    evento.idevento
                    FROM
                    ((evento  
                    INNER JOIN detalle_profesor_evento ON evento.idevento = detalle_profesor_evento.idevento ) inner join profesores ON detalle_profesor_evento.CodigoProfesor=profesores.CodigoProfesor)
                    INNER JOIN tipo_evento ON evento.idtipo_evento=tipo_evento.idtipo_evento 
                    WHERE detalle_profesor_evento.estado='en espera' and evento.idtipo_evento in (3,5) AND evento.CodigoProfesor='" . $codigo . "'"
                . "ORDER BY fecha asc";

        $sth = $this->db->prepare($query);
//        $sth->bindValue(':criterio', $this->criterio, PDO::PARAM_STR);
//        $sth->bindValue(':criterio1', $this->criterio1, PDO::PARAM_STR);
        $sth->execute();

        return $sth->fetchAll();
    }
    function getDatos_grilla_solicitudes_docentes_eu() {
        $codigo = $_SESSION['idusuario'];
        $query = "SELECT
                    evento.tema,
                    evento.idtipo_evento,
                    tipo_evento.descripcion,
                    evento.CodigoProfesor,
                    CONCAT(profesores.NombreProfesor,' ',profesores.ApellidoPaterno,' ',profesores.ApellidoMaterno)as Nombre,
                    detalle_profesor_evento.CodigoProfesor,
                    detalle_profesor_evento.mensaje,
                    detalle_profesor_evento.fecha,
                    detalle_profesor_evento.estado,
                    evento.idevento
                    FROM
                    ((evento  
                    INNER JOIN detalle_profesor_evento ON evento.idevento = detalle_profesor_evento.idevento ) inner join profesores ON detalle_profesor_evento.CodigoProfesor=profesores.CodigoProfesor)
                    INNER JOIN tipo_evento ON evento.idtipo_evento=tipo_evento.idtipo_evento 
                    WHERE detalle_profesor_evento.estado='en espera' and evento.idtipo_evento in (4,6) AND evento.CodigoProfesor='" . $codigo . "'"
                . "ORDER BY fecha asc";

        $sth = $this->db->prepare($query);
//        $sth->bindValue(':criterio', $this->criterio, PDO::PARAM_STR);
//        $sth->bindValue(':criterio1', $this->criterio1, PDO::PARAM_STR);
        $sth->execute();

        return $sth->fetchAll();
    }
    
       function getDatos_grilla_notificaciones_docentes_ps() {
        $codigo = $_SESSION['idusuario'];
       $query = "SELECT
                    evento.tema,
                    evento.idtipo_evento,
                    tipo_evento.descripcion,
                    evento.CodigoProfesor,
                    detalle_profesor_evento.CodigoProfesor,
                    detalle_profesor_evento.mensaje_confirmacion,
                    detalle_profesor_evento.fecha,
                    detalle_profesor_evento.estado,
                    evento.idevento
                    FROM
                    ((evento  
                    INNER JOIN detalle_profesor_evento ON evento.idevento = detalle_profesor_evento.idevento ) inner join profesores ON detalle_profesor_evento.CodigoProfesor=profesores.CodigoProfesor)
                    INNER JOIN tipo_evento ON evento.idtipo_evento=tipo_evento.idtipo_evento 
                    WHERE   evento.idtipo_evento in (3,5) and detalle_profesor_evento.CodigoProfesor='" . $codigo . "'" 
                . "ORDER BY fecha asc";

        $sth = $this->db->prepare($query);
//        $sth->bindValue(':criterio', $this->criterio, PDO::PARAM_STR);
//        $sth->bindValue(':criterio1', $this->criterio1, PDO::PARAM_STR);
        $sth->execute();

        return $sth->fetchAll();
    }
    function getDatos_grilla_notificaciones_docentes_eu() {
        $codigo = $_SESSION['idusuario'];
       $query = "SELECT
                    evento.tema,
                    evento.idtipo_evento,
                    tipo_evento.descripcion,
                    evento.CodigoProfesor,
                    detalle_profesor_evento.CodigoProfesor,
                    detalle_profesor_evento.mensaje_confirmacion,
                    detalle_profesor_evento.fecha,
                    detalle_profesor_evento.estado,
                    evento.idevento
                    FROM
                    ((evento  
                    INNER JOIN detalle_profesor_evento ON evento.idevento = detalle_profesor_evento.idevento ) inner join profesores ON detalle_profesor_evento.CodigoProfesor=profesores.CodigoProfesor)
                    INNER JOIN tipo_evento ON evento.idtipo_evento=tipo_evento.idtipo_evento 
                    WHERE  evento.idtipo_evento in (4,6) and detalle_profesor_evento.CodigoProfesor='" . $codigo . "'" 
                . "ORDER BY fecha asc";

        $sth = $this->db->prepare($query);
//        $sth->bindValue(':criterio', $this->criterio, PDO::PARAM_STR);
//        $sth->bindValue(':criterio1', $this->criterio1, PDO::PARAM_STR);
        $sth->execute();

        return $sth->fetchAll();
    }
    function getDatos_grilla_notificaciones_alumnos_ps() {
        $codigo = $_SESSION['idusuario'];
        $query = "SELECT
                    evento.tema,
                    evento.idtipo_evento,
                    tipo_evento.descripcion,
                    evento.CodigoProfesor,
                    detalle_alumno_evento.CodigoAlumno,
                    detalle_alumno_evento.mensaje_confirmacion,
                    detalle_alumno_evento.fecha,
                    detalle_alumno_evento.estado
                    FROM
                    ((evento  
                    INNER JOIN detalle_alumno_evento ON evento.idevento = detalle_alumno_evento.idevento ) inner join alumnos ON detalle_alumno_evento.CodigoAlumno=alumnos.CodigoAlumno)
                    INNER JOIN tipo_evento ON evento.idtipo_evento=tipo_evento.idtipo_evento 
                    WHERE  evento.idtipo_evento in (3,5) and detalle_alumno_evento.CodigoAlumno='" . $codigo . "'"
                . "ORDER BY fecha asc";

        $sth = $this->db->prepare($query);
//        $sth->bindValue(':criterio', $this->criterio, PDO::PARAM_STR);
//        $sth->bindValue(':criterio1', $this->criterio1, PDO::PARAM_STR);
        $sth->execute();

        return $sth->fetchAll();
    }
    function getDatos_grilla_notificaciones_alumnos_eu() {
        $codigo = $_SESSION['idusuario'];
        $query = "SELECT
                    evento.tema,
                    evento.idtipo_evento,
                    tipo_evento.descripcion,
                    evento.CodigoProfesor,
                    detalle_alumno_evento.CodigoAlumno,
                    detalle_alumno_evento.mensaje_confirmacion,
                    detalle_alumno_evento.fecha,
                    detalle_alumno_evento.estado
                    FROM
                    ((evento  
                    INNER JOIN detalle_alumno_evento ON evento.idevento = detalle_alumno_evento.idevento ) inner join alumnos ON detalle_alumno_evento.CodigoAlumno=alumnos.CodigoAlumno)
                    INNER JOIN tipo_evento ON evento.idtipo_evento=tipo_evento.idtipo_evento 
                    WHERE  evento.idtipo_evento in (4,6) and detalle_alumno_evento.CodigoAlumno='" . $codigo . "'"
                . "ORDER BY fecha asc";

        $sth = $this->db->prepare($query);
//        $sth->bindValue(':criterio', $this->criterio, PDO::PARAM_STR);
//        $sth->bindValue(':criterio1', $this->criterio1, PDO::PARAM_STR);
        $sth->execute();

        return $sth->fetchAll();
    }
    function getDatos_grilla_proyecto() {
        $query = "SELECT 
                        proyecto.idproyecto,
                        proyecto.nombre_proyecto,
                        proyecto.periodo_ejecucion,
                        CONCAT(profesores.ApellidoPaterno,' ',profesores.ApellidoMaterno,' ',profesores.NombreProfesor) AS Responsable,
                        escuelaprofesional.DescripcionEscuela,
                        proceso_proyecto.nombre,
                       0,
                    
                        proyecto.presupuesto,
              
                        tipo_proyecto.nombre_tipo_proyecto,
                        facultades.DescripcionFacultad,
                        linea_investigacion.nombre_linea,
                        eje_tematico.nombre_ejetematico,
                        grupo.nombre_grupo,
                        0,
                       0,
                      0,
                       proceso_proyecto.idproceso_proyecto
                        FROM
                        proyecto
                        INNER JOIN detalle_profesor_proy_fun ON proyecto.idproyecto = detalle_profesor_proy_fun.idproyecto
                        INNER JOIN profesores ON profesores.CodigoProfesor = detalle_profesor_proy_fun.CodigoProfesor
                        INNER JOIN proceso_proyecto on(proceso_proyecto.idproceso_proyecto=proyecto.estado_proyecto)
                        INNER JOIN escuelaprofesional ON proyecto.CodigoEscuela=escuelaprofesional.CodigoEscuela
                        INNER JOIN tipo_proyecto ON proyecto.idtipo_proyecto = tipo_proyecto.idtipo_proyecto
                        INNER JOIN facultades ON escuelaprofesional.CodigoFacultad = facultades.CodigoFacultad
                        INNER JOIN linea_investigacion ON proyecto.idlinea_investigacion = linea_investigacion.idlinea_investigacion
                        INNER JOIN eje_tematico ON linea_investigacion.idejetematico = eje_tematico.idejetematico
                        INNER JOIN grupo ON eje_tematico.idgrupo = grupo.idgrupo               
                        
                        where detalle_profesor_proy_fun.idfuncion=2 and proyecto.situacion=1 and facultades.CodigoFacultad= 7
                        GROUP BY proyecto.idproyecto
                            ";

        $sth = $this->db->prepare($query);
//        $sth->bindValue(':criterio', $this->criterio, PDO::PARAM_STR);
//        $sth->bindValue(':criterio1', $this->criterio1, PDO::PARAM_STR);
        $sth->execute();

        return $sth->fetchAll();
    }

    function getDatos_grilla_solicitaproyectos() {
        $query = "SELECT 
                        proyecto.idproyecto,
                        proyecto.nombre_proyecto,
                        proyecto.periodo_ejecucion,
                        CONCAT(profesores.ApellidoPaterno,' ',profesores.ApellidoMaterno,' ',profesores.NombreProfesor) AS Responsable,
                        escuelaprofesional.DescripcionEscuela,
                        proceso_proyecto.nombre,
                       0,
                    
                        proyecto.presupuesto,
              
                        tipo_proyecto.nombre_tipo_proyecto,
                        facultades.DescripcionFacultad,
                        linea_investigacion.nombre_linea,
                        eje_tematico.nombre_ejetematico,
                        grupo.nombre_grupo,
                        0,
                        0,
                        0,
                        proceso_proyecto.idproceso_proyecto
                        FROM
                        proyecto
                        INNER JOIN detalle_profesor_proy_fun ON proyecto.idproyecto = detalle_profesor_proy_fun.idproyecto
                        INNER JOIN profesores ON profesores.CodigoProfesor = detalle_profesor_proy_fun.CodigoProfesor

                        INNER JOIN proceso_proyecto on(proceso_proyecto.idproceso_proyecto=proyecto.estado_proyecto)

                        INNER JOIN escuelaprofesional ON proyecto.CodigoEscuela=escuelaprofesional.CodigoEscuela
                        INNER JOIN tipo_proyecto ON proyecto.idtipo_proyecto = tipo_proyecto.idtipo_proyecto
                        INNER JOIN facultades ON escuelaprofesional.CodigoFacultad = facultades.CodigoFacultad
                        INNER JOIN linea_investigacion ON proyecto.idlinea_investigacion = linea_investigacion.idlinea_investigacion
                        INNER JOIN eje_tematico ON linea_investigacion.idejetematico = eje_tematico.idejetematico
                        INNER JOIN grupo ON eje_tematico.idgrupo = grupo.idgrupo
                                          
                        where detalle_profesor_proy_fun.idfuncion=2 and proyecto.situacion=0
                        GROUP BY proyecto.idproyecto";

        $sth = $this->db->prepare($query);
//        $sth->bindValue(':criterio', $this->criterio, PDO::PARAM_STR);
//        $sth->bindValue(':criterio1', $this->criterio1, PDO::PARAM_STR);
        $sth->execute();

        return $sth->fetchAll();
    }

    function getDetalle_proyecto() {
        $query = "SELECT 
                        proyecto.idproyecto,
                        proyecto.nombre_proyecto,
                        proyecto.periodo_ejecucion,
                        CONCAT(profesores.ApellidoPaterno,' ',profesores.ApellidoMaterno,' ',profesores.NombreProfesor) AS Responsable,
                        escuelaprofesional.DescripcionEscuela,
                        estado_proyecto.descripcion,
                        MAX(DISTINCT(control_proyecto.fecha)) as Fecha_Inicio,
                        proyecto.presupuesto,
                        tipo_proyecto.nombre_tipo_proyecto,
                        facultades.DescripcionFacultad,
                        linea_investigacion.nombre_linea,
                        eje_tematico.nombre_ejetematico,
                        grupo.nombre_grupo,
                        `ubigeos$`.DISTRITO,
                        `ubigeos$`.PROVINCIA,
                        `ubigeos$`.DEPARTAM,
                        proyecto.antecedentes_problema, 
            proyecto.definicion_problema, 
            proyecto.formulacion_problema, 
            proyecto.justificacion, 
            proyecto.importancia, 
            proyecto.limitaciones, 
                        proyecto.objetivo_general, 
            proyecto.antecedentes_investigacion, 
            proyecto.definicion_terminos, 
            proyecto.bases_teoricas, 
            proyecto.hipotesis, 
            proyecto.sistema_variables, 
            proyecto.escala_medicion, 
            proyecto.tipo_investigacion, 
            proyecto.nivel_investigacion, 
            proyecto.disenio_investigacion, 
                           proyecto.cobertura_investigacion, 
                           proyecto.fuente_investigacion, 
                           proyecto.tecnicas_investigacion, 
                           proyecto.instrumentos_investigacion, 
                           proyecto.presentacion_datos, 
                           proyecto.analisis_datos, 
                           proyecto.interpretacion_datos, 
                           proyecto.presupuesto,
                           proyecto.asignacion_recursos, 
                           proyecto.financiamiento                         


                        FROM
                        proyecto
                        INNER JOIN detalle_profesor_proy_fun ON proyecto.idproyecto = detalle_profesor_proy_fun.idproyecto
                        INNER JOIN profesores ON profesores.CodigoProfesor = detalle_profesor_proy_fun.CodigoProfesor
                        INNER JOIN control_proyecto ON proyecto.idproyecto = control_proyecto.idproyecto
                        INNER JOIN estado_proyecto ON control_proyecto.idestado_proyecto = estado_proyecto.idestado_proyecto
                        INNER JOIN escuelaprofesional ON proyecto.CodigoEscuela=escuelaprofesional.CodigoEscuela
                        INNER JOIN tipo_proyecto ON proyecto.idtipo_proyecto = tipo_proyecto.idtipo_proyecto
                        INNER JOIN facultades ON escuelaprofesional.CodigoFacultad = facultades.CodigoFacultad
                        INNER JOIN linea_investigacion ON proyecto.idlinea_investigacion = linea_investigacion.idlinea_investigacion
                        INNER JOIN eje_tematico ON linea_investigacion.idejetematico = eje_tematico.idejetematico
                        INNER JOIN grupo ON eje_tematico.idgrupo = grupo.idgrupo
                        INNER JOIN `ubigeos$` ON proyecto.Ubigeo = `ubigeos$`.UBIGEO
                        
                        where proyecto.idproyecto={$this->criterio}
                   
                            ";

        $sth = $this->db->prepare($query);
        $sth->bindValue(':criterio', $this->criterio, PDO::PARAM_STR);
//        $sth->bindValue(':criterio1', $this->criterio1, PDO::PARAM_STR);
        $sth->execute();

        return $sth->fetchAll();
    }

    function getDatos_grilla_objetivos() {

        $query = "SELECT
                    proyecto.idproyecto,
                    proyecto.nombre_proyecto,
                    objetivo_proyecto.descripcion
                    FROM
                    sisacreditacion.proyecto
                    INNER JOIN objetivo_proyecto ON 
                    objetivo_proyecto.idproyecto = proyecto.idproyecto
                    where objetivo_proyecto.idproyecto={$this->criterio}
                    
                            ";

        $sth = $this->db->prepare($query);
        $sth->bindValue(':criterio', $this->criterio, PDO::PARAM_INT);
//        $sth->bindValue(':criterio1', $this->criterio1, PDO::PARAM_STR);
        $sth->execute();

        return $sth->fetchAll();
    }

    function getDatos_web_informativo() {
        $query = "SELECT id_sliderweb,descripcion,imagen_slider 
                    FROM slider_web
                    ORDER BY id_sliderweb DESC ";

        $sth = $this->db->prepare($query);
//        $sth->bindValue(':criterio', $this->criterio, PDO::PARAM_STR);
//        $sth->bindValue(':criterio1', $this->criterio1, PDO::PARAM_STR);
        $sth->execute();

        return $sth->fetchAll();
    }

    function getDatos_web_evento() {
        $query = "SELECT id_eventoweb,titulo,descripcion,fecha 
                    FROM evento_web
                    ORDER BY fecha DESC ";

        $sth = $this->db->prepare($query);
//        $sth->bindValue(':criterio', $this->criterio, PDO::PARAM_STR);
//        $sth->bindValue(':criterio1', $this->criterio1, PDO::PARAM_STR);
        $sth->execute();

        return $sth->fetchAll();
    }

    function getDatos_web_noticias() {
        $query = "SELECT
                noticia_web.id_noticiaweb,
                noticia_web.titulo,
                noticia_web.descripcion,
                noticia_web.imagen,
                noticia_web.fecha
                FROM
                noticia_web ORDER BY noticia_web.fecha DESC ";

        $sth = $this->db->prepare($query);
//        $sth->bindValue(':criterio', $this->criterio, PDO::PARAM_STR);
//        $sth->bindValue(':criterio1', $this->criterio1, PDO::PARAM_STR);
        $sth->execute();

        return $sth->fetchAll();
    }

    function getDatos_web_contenido() {
        $query = "SELECT
                contenido_web.id_contenidoweb,
                contenido_web.titulo,
                contenido_web.descripcion,
                contenido_web.mision,
                contenido_web.vision
                FROM
                contenido_web ORDER BY contenido_web.id_contenidoweb DESC ";

        $sth = $this->db->prepare($query);
//        $sth->bindValue(':criterio', $this->criterio, PDO::PARAM_STR);
//        $sth->bindValue(':criterio1', $this->criterio1, PDO::PARAM_STR);
        $sth->execute();

        return $sth->fetchAll();
    }

    function getDatos_web_desarrolladores() {
        $query = "SELECT
                desarrolladores_web.id_desarrolladoresweb,
                desarrolladores_web.imagen,
                desarrolladores_web.descripcion
                FROM
                desarrolladores_web ORDER BY desarrolladores_web.id_desarrolladoresweb ASC ";

        $sth = $this->db->prepare($query);
//        $sth->bindValue(':criterio', $this->criterio, PDO::PARAM_STR);
//        $sth->bindValue(':criterio1', $this->criterio1, PDO::PARAM_STR);
        $sth->execute();

        return $sth->fetchAll();
    }

    function getDatos_grilla_docentes() {
        $query = "SELECT
                    proyecto.idproyecto,
                    proyecto.nombre_proyecto,
                    funcion.nombre_funcion,
                    CONCAT(profesores.ApellidoPaterno,' ',profesores.ApellidoMaterno,' ',profesores.NombreProfesor) as docente
                    FROM
                    proyecto
                    INNER JOIN detalle_profesor_proy_fun ON detalle_profesor_proy_fun.idproyecto = proyecto.idproyecto
                    INNER JOIN profesores ON profesores.CodigoProfesor = detalle_profesor_proy_fun.CodigoProfesor
                    INNER JOIN funcion ON detalle_profesor_proy_fun.idfuncion = funcion.idfuncion
                    where detalle_profesor_proy_fun.idproyecto = '{$this->criterio}'
                    ";

        $sth = $this->db->prepare($query);
        $sth->bindValue(':criterio', $this->criterio, PDO::PARAM_INT);
//        $sth->bindValue(':criterio1', $this->criterio1, PDO::PARAM_STR);
        $sth->execute();

        return $sth->fetchAll();
    }

    function getDatos_grilla_notasproyecto() {
        $query = "SELECT * FROM concepto
                   ";

        $sth = $this->db->prepare($query);
//        $sth->bindValue(':criterio', $this->criterio, PDO::PARAM_STR);
//        $sth->bindValue(':criterio1', $this->criterio1, PDO::PARAM_STR);
        $sth->execute();

        return $sth->fetchAll();
    }

    function getDatos_grilla_alumnos() {
        $query = "SELECT
                   proyecto.idproyecto,
                   proyecto.nombre_proyecto,
                   
                   detalleproyecto_matrixalumno.estado,
                   CONCAT(alumnos.ApellidoPaterno,' ',alumnos.ApellidoMaterno,' ',alumnos.NombreAlumno) as alumno,
                   
                   detalleproyecto_matrixalumno.CodigoAlumno,
                   alumnos.CodAlumnoSira
                    FROM
                    proyecto
                    INNER JOIN detalleproyecto_matrixalumno ON detalleproyecto_matrixalumno.idproyecto = proyecto.idproyecto
                    INNER JOIN alumnos ON alumnos.CodigoAlumno = detalleproyecto_matrixalumno.CodigoAlumno
                    where   detalleproyecto_matrixalumno.idproyecto='{$this->criterio}'AND  detalleproyecto_matrixalumno.estado=1
                    ";

        $sth = $this->db->prepare($query);
        $sth->bindValue(':criterio', $this->criterio, PDO::PARAM_INT);

        $sth->execute();

        return $sth->fetchAll();
    }

        function getDatos_grilla_alumnos2() {

        $query = "SELECT
                   proyecto.idproyecto,
                   proyecto.nombre_proyecto,
                   
                   detalleproyecto_matrixalumno.estado,
                   CONCAT(alumnos.ApellidoPaterno,' ',alumnos.ApellidoMaterno,' ',alumnos.NombreAlumno) as alumno,
                   
                   detalleproyecto_matrixalumno.CodigoAlumno
                    FROM
                    proyecto
                    INNER JOIN detalleproyecto_matrixalumno ON detalleproyecto_matrixalumno.idproyecto = proyecto.idproyecto
                    INNER JOIN alumnos ON alumnos.CodigoAlumno = detalleproyecto_matrixalumno.CodigoAlumno
                    where alumnos.CodigoAlumno = ". $_SESSION['idusuario']." GROUP BY 1";

        $sth = $this->db->prepare($query);
        $sth->execute();
        return $sth->fetchAll();
    }

    function getDatos_Actividades() {

        $query = "SELECT
                            actividad.idactividad,
                            actividad.nombre_actividad,
                            actividad.fecha_inicio,
                            actividad.fecha_termino
                            from actividad
                             where  
                            idproyecto ='{$this->criterio}'
                    ";

        $sth = $this->db->prepare($query);
        $sth->bindValue(':criterio', $this->criterio, PDO::PARAM_INT);

        $sth->execute();

        return $sth->fetchAll();
    }

    function getVerNotasProyecto() {
        $query = "SELECT
                    concepto.nombre_concepto,
                    detalle_concepto_detproyecto.nota,
                    detalle_concepto_detproyecto.CodigoAlumno,
                    detalle_concepto_detproyecto.idproyecto,
                    concepto.peso_promedial,
                    concepto.idconcepto
                    
                    FROM
                    detalle_concepto_detproyecto
                    Inner Join concepto ON detalle_concepto_detproyecto.idconcepto = concepto.idconcepto
                    where detalle_concepto_detproyecto.CodigoAlumno='" . $_SESSION['idusuario'] . "' and detalle_concepto_detproyecto.idproyecto='{$this->criterio}'
                   
                            ";

        $sth = $this->db->prepare($query);
        $sth->bindValue(':criterio', $this->criterio, PDO::PARAM_STR);
//        $sth->bindValue(':criterio1', $this->criterio1, PDO::PARAM_STR);
        $sth->execute();

        return $sth->fetchAll();
    }

    function getDatos_FiltroEditar() {

        $query = "SELECT
                                    actividad.idactividad,
                                    proyecto.idproyecto,
                                    actividad.nombre_actividad,
                                    proyecto.nombre_proyecto,
                                    actividad.fecha_inicio,
                                    actividad.fecha_termino
                                    FROM
                                    actividad
                                    Inner Join proyecto ON actividad.idproyecto = proyecto.idproyecto
                                    where  
                            actividad.idactividad ='{$this->criterio}'
                    ";

        $sth = $this->db->prepare($query);
        $sth->bindValue(':criterio', $this->criterio, PDO::PARAM_INT);

        $sth->execute();

        return $sth->fetchAll();
    }

    function getDatos_grilla_miproyecto($semestre) {

        $codigo = $_SESSION['idusuario'];
        if ($_SESSION['perfil'] == 'ALUMNO') {
            if($semestre==null){
               
                $semestre=  $this->mostrar_semestre_ultimo();
            }
            $query = "SELECT
                        proyecto.idproyecto,
                        proyecto.nombre_proyecto,
                        proyecto.periodo_ejecucion,
                        CONCAT(profesores.ApellidoPaterno,' ',profesores.ApellidoMaterno,' ',profesores.NombreProfesor) AS Responsable,
                        MAX(DISTINCT(control_proyecto.fecha)) as Fecha_Inicio,
                        escuelaprofesional.DescripcionEscuela,
                        estado_proyecto.descripcion,
                        proyecto.presupuesto,
                        tipo_proyecto.nombre_tipo_proyecto,
                        facultades.DescripcionFacultad,
                        linea_investigacion.nombre_linea,
                        eje_tematico.nombre_ejetematico,
                        grupo.nombre_grupo
                     
                        FROM
                        proyecto
                        INNER JOIN detalle_profesor_proy_fun ON proyecto.idproyecto = detalle_profesor_proy_fun.idproyecto
                        INNER JOIN profesores ON profesores.CodigoProfesor = detalle_profesor_proy_fun.CodigoProfesor
                        INNER JOIN control_proyecto ON proyecto.idproyecto = control_proyecto.idproyecto
                        INNER JOIN estado_proyecto ON control_proyecto.idestado_proyecto = estado_proyecto.idestado_proyecto
                        INNER JOIN escuelaprofesional ON proyecto.CodigoEscuela=escuelaprofesional.CodigoEscuela
                        INNER JOIN tipo_proyecto ON proyecto.idtipo_proyecto = tipo_proyecto.idtipo_proyecto
                        INNER JOIN facultades ON escuelaprofesional.CodigoFacultad = facultades.CodigoFacultad
                        INNER JOIN linea_investigacion ON proyecto.idlinea_investigacion = linea_investigacion.idlinea_investigacion
                        INNER JOIN eje_tematico ON linea_investigacion.idejetematico = eje_tematico.idejetematico
                        INNER JOIN grupo ON eje_tematico.idgrupo = grupo.idgrupo
                       
            INNER JOIN detalleproyecto_matrixalumno ON proyecto.idproyecto=detalleproyecto_matrixalumno.idproyecto
                        INNER JOIN detalle_matricula ON detalleproyecto_matrixalumno.CodigoAlumno=detalle_matricula.CodigoAlumno
                        INNER JOIN matricula ON detalle_matricula.CodigoAlumno=matricula.CodigoAlumno
                        INNER JOIN alumnos ON matricula.CodigoAlumno=alumnos.CodigoAlumno
                        
                        where detalle_profesor_proy_fun.idfuncion=2 and
            detalleproyecto_matrixalumno.CodigoAlumno='" . $codigo . "' AND detalleproyecto_matrixalumno.estado=1
               and  detalleproyecto_matrixalumno.CodigoSemestre='$semestre'        
               GROUP BY proyecto.idproyecto";
           
            $sth = $this->db->prepare($query);
//        $sth->bindValue(':criterio', $this->criterio, PDO::PARAM_STR);
//        $sth->bindValue(':criterio1', $this->criterio1, PDO::PARAM_STR);
             $sth->execute();

            return $sth->fetchAll();
        }
        if ($_SESSION['perfil'] == 'PROFESOR') {
            $query = "SELECT
                 
                                    detalle_profesor_proy_fun.idproyecto as id, 
                                    proyecto.nombre_proyecto,
                                    proyecto.periodo_ejecucion,
                                    (select CONCAT(profesores.NombreProfesor,' ',profesores.ApellidoPaterno,' ',profesores.ApellidoMaterno) AS Responsable 
                                    from detalle_profesor_proy_fun 
                                    inner join profesores on profesores.CodigoProfesor = detalle_profesor_proy_fun.CodigoProfesor
                                    where idfuncion=2 and idproyecto =id)as jefeproyecto,
                                    (select profesores.CodigoProfesor AS codigo_responsable 
                                    from detalle_profesor_proy_fun 
                                    inner join profesores on profesores.CodigoProfesor = detalle_profesor_proy_fun.CodigoProfesor
                                    where idfuncion=2 and idproyecto =id)as cod_jefeproyecto,
                                    MAX(DISTINCT(control_proyecto.fecha)) as Fecha_Inicio,
                                    escuelaprofesional.DescripcionEscuela,
                                    estado_proyecto.descripcion, 
                                    proyecto.presupuesto,
                                    tipo_proyecto.nombre_tipo_proyecto,
                                    facultades.DescripcionFacultad, 
                                    linea_investigacion.nombre_linea,
                                    eje_tematico.nombre_ejetematico, 
                                    grupo.nombre_grupo
                                    
                        FROM
                        detalle_profesor_proy_fun
                        INNER JOIN proyecto ON proyecto.idproyecto = detalle_profesor_proy_fun.idproyecto
                        INNER JOIN profesores ON profesores.CodigoProfesor = detalle_profesor_proy_fun.CodigoProfesor
                        INNER JOIN control_proyecto ON proyecto.idproyecto = control_proyecto.idproyecto
            INNER JOIN estado_proyecto ON control_proyecto.idestado_proyecto = estado_proyecto.idestado_proyecto
                        INNER JOIN escuelaprofesional ON proyecto.CodigoEscuela=escuelaprofesional.CodigoEscuela
                        INNER JOIN tipo_proyecto ON proyecto.idtipo_proyecto = tipo_proyecto.idtipo_proyecto
                        INNER JOIN facultades ON escuelaprofesional.CodigoFacultad = facultades.CodigoFacultad
                        INNER JOIN linea_investigacion ON proyecto.idlinea_investigacion = linea_investigacion.idlinea_investigacion
                        INNER JOIN eje_tematico ON linea_investigacion.idejetematico = eje_tematico.idejetematico
                        INNER JOIN grupo ON eje_tematico.idgrupo = grupo.idgrupo
                        INNER JOIN detalle_concepto_detproyecto on(detalle_concepto_detproyecto.idproyecto=proyecto.idproyecto)       
                        inner join detalleproyecto_matrixalumno on detalleproyecto_matrixalumno.idproyecto=proyecto.idproyecto
                       where detalle_profesor_proy_fun.CodigoProfesor='" . $codigo . "' AND proyecto.situacion=1
                      
                           and  detalleproyecto_matrixalumno.CodigoSemestre='$semestre'   
                        GROUP BY proyecto.idproyecto
                            ";
  //         echo $query;exit;
            $sth = $this->db->prepare($query);
            
            


//        $sth->bindValue(':criterio', $this->criterio, PDO::PARAM_STR);
//        $sth->bindValue(':criterio1', $this->criterio1, PDO::PARAM_STR);
            $sth->execute();
            $data=$sth->fetchAll();
//            echo "<pre>";print_r($data);exit;
//            echo count($count);exit;
             if(empty($data)){ 
//                 echo "entre";exit;
                   $query2 = "SELECT
                 
                                    detalle_profesor_proy_fun.idproyecto as id, 
                                    proyecto.nombre_proyecto,
                                    proyecto.periodo_ejecucion,
                                    (select CONCAT(profesores.NombreProfesor,' ',profesores.ApellidoPaterno,' ',profesores.ApellidoMaterno) AS Responsable 
                                    from detalle_profesor_proy_fun 
                                    inner join profesores on profesores.CodigoProfesor = detalle_profesor_proy_fun.CodigoProfesor
                                    where idfuncion=2 and idproyecto =id)as jefeproyecto,
                                    (select profesores.CodigoProfesor AS codigo_responsable 
                                    from detalle_profesor_proy_fun 
                                    inner join profesores on profesores.CodigoProfesor = detalle_profesor_proy_fun.CodigoProfesor
                                    where idfuncion=2 and idproyecto =id)as cod_jefeproyecto,
                                    MAX(DISTINCT(control_proyecto.fecha)) as Fecha_Inicio,
                                    escuelaprofesional.DescripcionEscuela,
                                    estado_proyecto.descripcion, 
                                    proyecto.presupuesto,
                                    tipo_proyecto.nombre_tipo_proyecto,
                                    facultades.DescripcionFacultad, 
                                    linea_investigacion.nombre_linea,
                                    eje_tematico.nombre_ejetematico, 
                                    grupo.nombre_grupo
                                    
                        FROM
                        detalle_profesor_proy_fun
                        INNER JOIN proyecto ON proyecto.idproyecto = detalle_profesor_proy_fun.idproyecto
                        INNER JOIN profesores ON profesores.CodigoProfesor = detalle_profesor_proy_fun.CodigoProfesor
                        INNER JOIN control_proyecto ON proyecto.idproyecto = control_proyecto.idproyecto
            INNER JOIN estado_proyecto ON control_proyecto.idestado_proyecto = estado_proyecto.idestado_proyecto
                        INNER JOIN escuelaprofesional ON proyecto.CodigoEscuela=escuelaprofesional.CodigoEscuela
                        INNER JOIN tipo_proyecto ON proyecto.idtipo_proyecto = tipo_proyecto.idtipo_proyecto
                        INNER JOIN facultades ON escuelaprofesional.CodigoFacultad = facultades.CodigoFacultad
                        INNER JOIN linea_investigacion ON proyecto.idlinea_investigacion = linea_investigacion.idlinea_investigacion
                        INNER JOIN eje_tematico ON linea_investigacion.idejetematico = eje_tematico.idejetematico
                        INNER JOIN grupo ON eje_tematico.idgrupo = grupo.idgrupo   
                        
                        where detalle_profesor_proy_fun.CodigoProfesor='" . $codigo . "' AND proyecto.situacion=1
                         
                        GROUP BY proyecto.idproyecto
                            ";
//                   echo $query;exit;
            $sth2 = $this->db->prepare($query2);
            $sth2->execute();
            $data=$sth2->fetchAll();
            //print_r($data);exit;
             }
            # print_r($data);exit;
//        echo ($query);
//        exit();
            return $data;
        }
    }

    function getList_ajax_string_dis() {
        $sth = $this->db->prepare("SELECT distinct UBIGEO,DISTRITO FROM {$this->table} where {$this->filtro} = :criterio");
        $sth->bindValue(':criterio', $this->criterio, PDO::PARAM_STR);
        $sth->execute();
        return $sth->fetchAll();
    }
    function getNotasPro($semestre){
        $query = "SELECT
                          *
                            from 
                            detalle_concepto_detproyecto
                            WHERE CodigoSemestre=20150 and detalle_concepto_detproyecto.idproyecto=$this->criterio";

        $sth = $this->db->prepare($query);
        $sth->execute();
        return $sth->fetchAll();
    }
    function getNotasPro2(){
        $query = "SELECT
                          *
                            from 
                            detalle_concepto_detproyecto
                            WHERE CodigoSemestre=20150" ;

        $sth = $this->db->prepare($query);
        $sth->execute();
        return $sth->fetchAll();
    }
    public function ffecha($fecha) {
        $nfecha = explode("/", $fecha);
        return $nfecha[2] . "-" . $nfecha[1] . "-" . $nfecha[0];
    }

    public function getfecha($fecha) {
        $nfecha = explode("-", $fecha);
        return $nfecha[2] . "/" . $nfecha[1] . "/" . $nfecha[0];
    }

    public function getTotal($sql, $param) {
        $statement = $this->db->prepare($sql);
        foreach ($param as $key => $value) {
            switch ($value['type']) {
                case 'STR':
                    $statement->bindParam($value['key'], $value['value'], PDO::PARAM_STR);
                    break;
                default:
                    $statement->bindParam($value['key'], $value['value'], PDO::PARAM_INT);
                    break;
            }
        }
        $statement->execute();
        return $statement->rowCount();
    }

    public function getRow($sql, $param, $p) {
        $p = $this->rows * ($p - 1);
        if ($this->exec == "EXEC") {
            
        } else {
            $sql = $sql . " LIMIT {$this->rows} OFFSET {$p} ";
        }
        $statement = $this->db->prepare($sql);
        foreach ($param as $key => $value) {
            switch ($value['type']) {
                case 'STR':
                    $statement->bindParam($value['key'], $value['value'], PDO::PARAM_STR);
                    break;
                default:
                    $statement->bindParam($value['key'], $value['value'], PDO::PARAM_INT);
                    break;
            }
        }
        $statement->execute();

        return $statement->fetchAll();
    }

    public function getRowPag($total_rows, $vp) {
        $data = array();
        if (ceil($total_rows / $this->rows) <= $this->pag) {
            for ($x = 1; $x <= ceil($total_rows / $this->rows); $x++) {
                if ($x == $vp) {
                    $data[] = array('active' => 1, 'type' => 1, 'value' => $x);
                } else {
                    $data[] = array('active' => 0, 'type' => 1, 'next' => 0, 'value' => $x);
                }
            }
        } else {
            $flag = TRUE;
            if (ceil($total_rows / $this->rows) % $this->pag != 0) {
                for ($j = ceil($total_rows / $this->rows); $j >= $this->pag; $j--) {
                    if ($j % $this->pag == 0) {
                        if ($vp > $j) {
                            $flag = FALSE;
                            for ($x = $j + 1; $x <= ceil($total_rows / $this->rows); $x++) {
                                if ($x == $j + 1) {
                                    $data[] = array('active' => 0, 'type' => 2, 'value' => $x - 1);
                                }
                                if ($x == $vp) {
                                    $data[] = array('active' => 1, 'type' => 1, 'value' => $x);
                                } else {
                                    $data[] = array('active' => 0, 'type' => 1, 'value' => $x);
                                }
                            }
                            break;
                        } else {

                            break;
                        }
                    }
                }
                if ($flag) {
                    for ($x = $vp; $x <= ceil($total_rows / $this->rows); $x++) {
                        if (( $x % $this->pag ) == 0) {
                            if ($x - $this->pag <= 0) {
                                $z = 1;
                            } else {
                                $z = ($x - $this->pag) + 1;
                            }
                            for ($y = $z; $y <= ($x); $y++) {
                                if ($y > $this->pag && $y == $z) {
                                    $data[] = array('active' => 0, 'type' => 2, 'value' => $y - 1);
                                }
                                if ($y == $vp) {
                                    $data[] = array('active' => 1, 'type' => 1, 'value' => $y);
                                } else {
                                    $data[] = array('active' => 0, 'type' => 1, 'value' => $y);
                                }
                                if ($y == $x && $y != ceil($total_rows / $this->rows)) {
                                    $data[] = array('active' => 0, 'type' => 3, 'value' => $y + 1);
                                }
                            }
                            break;
                        }
                    }
                }
            } else {
                for ($x = $vp; $x <= ceil($total_rows / $this->rows); $x++) {
                    if (( $x % $this->pag ) == 0) {
                        if ($x - $this->pag <= 0) {
                            $z = 1;
                        } else {
                            $z = ($x - $this->pag) + 1;
                        }
                        for ($y = $z; $y <= ($x); $y++) {
                            if ($y > $this->pag && $y == $z) {
                                $data[] = array('active' => 0, 'type' => 2, 'value' => $y - 1);
                            }
                            if ($y == $vp) {
                                $data[] = array('active' => 1, 'type' => 1, 'value' => $y);
                            } else {
                                $data[] = array('active' => 0, 'type' => 1, 'value' => $y);
                            }
                            if ($y == $x && $y != ceil($total_rows / $this->rows)) {
                                $data[] = array('active' => 0, 'type' => 3, 'value' => $y + 1);
                            }
                        }
                        break;
                    }
                }
            }
        }
        return $data;
    }

    public function getnr() {
        return $this->rows;
    }

    function Insertar() {

//         $sentencia=$this->db->query("SELECT MAX(idcalificacion) as cant from calificacion");         
//        $ct=$sentencia->fetch();      
//        $xd=1+(int)$ct['cant'];  



        for ($i = 0; $i < count($this->alumno); $i++) {

            $xd = $this->alumno[$i];
            $xy = $this->nota[$i];
            $sql = "insert into calificacion values(NULL,$this->evaluacion,'$xd',$xy)";


            for ($i = 0; $i < count($this->alumno); $i++) {

                $a = $this->alumno[$i];
                $n = $this->nota[$i];
                $sql = "insert into calificacion values(NULL,$this->evaluacion,'$a',$n)";

//               echo  $this->alumno[$i]."---".$this->nota[$i];
//               exit();
//                echo $sql;exit();
                $stmt = $this->db->prepare($sql);
                $stmt->execute();
            }


//        
//        $p1 = $stmt->execute();
//        $p2 = $stmt->errorInfo();
//        return array($p1 , $p2[2]);
        }

        function InsertarA() {

            for ($a = 0; $a < count($this->alumno); $a++) {

                $al = $this->alumno[$a];

                $as = $this->asistencia[$a];
            }

            $sql = "insert into asistencia_clase values(NULL,$this->clase,'$al','$as')";
//               echo  $this->alumno[$a]."---".$this->asistencia[$a]."---".$asistencia."---".$alumno;
//               exit();
//                 echo $sql;exit();
            $stmt = $this->db->prepare($sql);
            $stmt->execute();

            $mensaje = "se inserto correctamente";


            $p1 = $stmt->execute();
            $p2 = $stmt->errorInfo();
            return array($p1, $p2[2]);
//         return $mensaje;
        }

    }

    //MITCHELLL
        function getListTipoEva() {

        $sth = $this->db->prepare("SELECT idtipo_evaluacion, descripcion FROM {$this->table} WHERE iddocente = {$_SESSION['idusuario']}");
        $sth->execute();
        return $sth->fetchAll();
    }

    function getListAsig() {

        $sth = $this->db->prepare("SELECT idasignatura, descripcion FROM {$this->table} WHERE iddocente = {$this->idp}");
        $sth->execute();
        return $sth->fetchAll();
    } public function mostrar_record_asistencias_tutoria() {
        $ideventos_tutoria= $this->get_evento_tutoria_this_ultimo_semestre();
        $ideventos_tutoria = implode(",", $ideventos_tutoria);
        $sql = "SELECT
        alumnos.CodigoAlumno,
        alumnos.NombreAlumno,
        concat(alumnos.ApellidoPaterno,' ',alumnos.ApellidoMaterno) AS Apellidos,
        concat(alumnos.TipoDocumento,' ',alumnos.NumDocumento) AS Documento,
        date(alumnos.FechaIngreso) as fecha_ingreso,
        alumnos.CodAlumnoSira,
       Sum(case when detalle_asistencia_alumno_tutoria.asistencia_alumno =1 then 1 else 0  end) AS cant_asistencias,
       Sum(case when detalle_asistencia_alumno_tutoria.asistencia_alumno is NULL then 1 else 0 end) AS cant_inasistencias
       FROM
        detalle_asignacion_tutoria
        Inner Join profesores ON detalle_asignacion_tutoria.CodigoProfesor = profesores.CodigoProfesor
        Inner Join alumnos ON detalle_asignacion_tutoria.CodigoAlumno = alumnos.CodigoAlumno
        Left Join detalle_asistencia_alumno_tutoria ON detalle_asistencia_alumno_tutoria.CodigoAlumno = alumnos.CodigoAlumno 
        Inner Join semestreacademico ON detalle_asignacion_tutoria.CodigoSemestre = semestreacademico.CodigoSemestre
        where detalle_asignacion_tutoria.CodigoSemestre='{$this->CodigoSemestre}' and (alumnos.CodAlumnoSira='{$this->CodAlumnoSira}' or alumnos.CodigoAlumno='{$this->CodigoAlumno}') and detalle_asistencia_alumno_tutoria.idevento in (".$ideventos_tutoria.")";
//       echo $sql;exit;
        $sth = $this->db->prepare($sql);
        $sth->execute();
        return $sth->fetch();
    }

    public function mostrar_record_asistencias_Eu_Ps() {

        $data_sub_Eu_Ps = $this->get_data_sub_eventos_Eu_Ps();
        $fields = array();
        foreach ($data_sub_Eu_Ps as $key => $value) {
            array_push($fields, $value['idevento']);
        }
        $todos_idsuventos = implode(",", $fields);

        $sql = "SELECT
        detalle_asistencia_alumno.CodigoAlumno, 
       alumnos.CodAlumnoSira,
        detalle_asistencia_alumno.idevento,
        CONCAT (' ',alumnos.NombreAlumno,alumnos.ApellidoPaterno,alumnos.ApellidoMaterno) as Nombre,
       Sum(case when detalle_asistencia_alumno.asistencia_alumno =1 then 1 else 0  end) AS cant_asistencias,
       Sum(case when detalle_asistencia_alumno.asistencia_alumno is NULL then 1 else 0 end) AS cant_inasistencias,
        evento.tema,
        evento.idtipo_evento,
        cargo_asistencia_evento.descripcion as cargo
        FROM
        detalle_asistencia_alumno
        INNER JOIN alumnos ON detalle_asistencia_alumno.CodigoAlumno = alumnos.CodigoAlumno
        INNER JOIN evento ON detalle_asistencia_alumno.idevento = evento.idevento
        INNER JOIN tipo_evento ON evento.idtipo_evento = tipo_evento.idtipo_evento
        INNER JOIN cargo_asistencia_evento ON detalle_asistencia_alumno.id_cargo = cargo_asistencia_evento.id_cargo
        WHERE evento.idevento in (".$todos_idsuventos.") AND (detalle_asistencia_alumno.CodigoAlumno='{$this->CodigoAlumno}' or alumnos.CodAlumnoSira='{$this->CodAlumnoSira}')";
//       echo $sql,exit;
        $sth = $this->db->prepare($sql);
        $sth->execute();
//        echo "<pre>";print_r($sth->fetch());exit;
        return $sth->fetch();
    }

    function get_evento_tutoria_this_ultimo_semestre() {
        $sql="select idevento from evento WHERE evento.CodigoSemestre='{$this->CodigoSemestre}' and evento.idtipo_evento='1'";
        $sth = $this->db->prepare($sql);
        $sth->execute();
        $eventos_tutoria=$sth->fetchAll();
        $fields = array();
        foreach ($eventos_tutoria as $key => $value) {
            array_push($fields, $value['idevento']);
        }
        return $fields;
    }
    function get_data_sub_eventos_Eu_Ps($param) {
        $sql = "SELECT *
        FROM
        evento
        WHERE evento.idevento_padre is not null and (evento.idtipo_evento=3  or evento.idtipo_evento=4)";

        $sth = $this->db->prepare($sql);
        $sth->execute();
        return $sth->fetchAll();
    }

    

}

?>
