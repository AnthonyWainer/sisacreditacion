<?php 
$conexion=mysql_connect("localhost","root","") or //conexion al servidor
die("Problemas en la conexion");

mysql_select_db("s",$conexion) or //conexion a la base de datos 
die("Problemas en la selección de la base de datos");
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
        
        $res = mysql_query($sql, $conexion);
        $arrayX = array();


       while ($dep_rows = mysql_fetch_array($res)) {
            $arrayX[$dep_rows["tema"]][] = (int) ($dep_rows["cantidad"]);
            $arrayX[$dep_rows["tema"]][] = (int) ($dep_rows["Masculino"]);
            $arrayX[$dep_rows["tema"]][] = (int) ($dep_rows["Femenino"]);
        }
      
        echo json_encode($arrayX);
        break;
    // case n // otras opciones
}
?>