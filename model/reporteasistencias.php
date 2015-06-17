<?php

include_once("../lib/dbfactory.php");

class reporteasistencias extends Main {

    public function get_reporte_asistencias() {

        extract($_GET);
        switch ($caso) {
            case 'grafico1':
                $sql = "SELECT
                        evento.tema,
                        Count(detalle_asistencia_alumno_tutoria.CodigoProfesor) AS cantidad,
                        Sum(case when detalle_asistencia_alumno_tutoria.asistencia_alumno='1' then 1 else 0 end) AS Masculino,
                        Sum(case when detalle_asistencia_alumno_tutoria.asistencia_alumno Is Null then 1 else 0 end) AS Femenino
                        FROM
                        detalle_asistencia_alumno_tutoria
                        Inner Join evento ON detalle_asistencia_alumno_tutoria.idevento = evento.idevento where evento.CodigoProfesor is null
                        group by detalle_asistencia_alumno_tutoria.idevento";

                $sth = $this->db->prepare($sql);
                $sth->execute();

                $res = $sth->fetchAll();
                $arrayX = array();


                foreach ($res as $key => $dep_rows) {
                    $arrayX[$dep_rows["tema"]][] = (int) ($dep_rows["cantidad"]);
                    $arrayX[$dep_rows["tema"]][] = (int) ($dep_rows["Masculino"]);
                    $arrayX[$dep_rows["tema"]][] = (int) ($dep_rows["Femenino"]);
                }

                echo json_encode($arrayX);
                break;
            // case n // otras opciones
        }
    }

}

?>
