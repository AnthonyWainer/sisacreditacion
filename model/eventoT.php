<?php
include_once("../lib/dbfactory.php");
class  eventoT extends Main{    
    function index($query,$p,$c,$semestre_ultimo,$cod_profesor) 
    {
        $sql = "SELECT
                        evento.idevento,
                         evento.tema,
                        tipo_evento.descripcion,
                        evento.fecha,
                        evento.hora_evento,
                        evento.CodigoProfesor,
                        clasificacion_evento.descripcion
                        FROM
                        evento
 Inner Join tipo_evento ON tipo_evento.idtipo_evento = evento.idtipo_evento
 Inner Join clasificacion_evento ON clasificacion_evento.id_clasificacion_evento = tipo_evento.id_clasificacion_evento
     where  evento.CodigoSemestre='".$semestre_ultimo."' and clasificacion_evento.id_clasificacion_evento=1  AND  evento.idtipo_evento=1 and " . $c . " like :query "
                . "ORDER BY evento.fecha asc";       
        $param = array(array('key'=>':query' , 'value'=>"%$query%" , 'type'=>'STR' ));
        $data['total'] = $this->getTotal( $sql, $param );
        $data['rows'] =  $this->getRow($sql, $param , $p );        
        $data['rowspag'] = $this->getRowPag($data['total'], $p );        
        return $data;
    }       
}