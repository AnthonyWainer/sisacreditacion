<?php
include_once("../lib/dbfactory.php");
class evento extends Main{    
    function index($query,$p,$c,$semestre_ultimo,$cod_profesor) 
    {
        $sql = " SELECT
            evento.idevento,
evento.tema,
evento.idtipo_evento,
evento.fecha,
evento.hora_evento,

tipo_evento.descripcion
FROM
evento
INNER JOIN tipo_evento ON evento.idtipo_evento = tipo_evento.idtipo_evento
WHERE evento.idtipo_evento in (1,7) and evento.CodigoSemestre='".$semestre_ultimo."' and " . $c . " like :query";       
        $param = array(array('key'=>':query' , 'value'=>"%$query%" , 'type'=>'STR' ));
        $data['total'] = $this->getTotal( $sql, $param );
        $data['rows'] =  $this->getRow($sql, $param , $p );        
        $data['rowspag'] = $this->getRowPag($data['total'], $p );        
        return $data;
    }       
    function edit($id ) 
    {
        $stmt = $this->db->prepare("SELECT * FROM evento WHERE idevento=:id");
        $stmt->bindValue(':id', $id , PDO::PARAM_STR);
        $stmt->execute();
        return $stmt->fetchObject();
    }
    
    function insert($_P ) {
        if($_SESSION['cargo']!='Presidente' || $_SESSION['comicion']!='COMISION ESPECIAL DE TUTORIA'){$cod_profesor=$_SESSION['idusuario'];}
        if($_P['crear_modo_sin_cargo']==true){$cod_profesor=$_SESSION['idusuario'];}
        $sentencia=$this->db->query("SELECT MAX(idevento) as cant from evento");         
        $ct=$sentencia->fetch();      
        $xd=1+(int)$ct['cant'];
        $semestre_ultimo = $this->mostrar_semestre_ultimo();
        $sql = $this->Query("sp_evento_iu(0,:p1,:p2,:p3,:p4,:p5,:p6,:p7)");
        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(':p1', $xd , PDO::PARAM_INT);       
        $stmt->bindValue(':p2', $_P['tema'] , PDO::PARAM_STR);      
        $stmt->bindValue(':p3', $_P['idtipo_evento'] , PDO::PARAM_INT);        
        $stmt->bindValue(':p4', $semestre_ultimo, PDO::PARAM_STR);       
        $stmt->bindValue(':p5', $_P['fecha'] , PDO::PARAM_STR);
        $stmt->bindValue(':p6',$cod_profesor , PDO::PARAM_STR);
        $stmt->bindValue(':p7', $_P['hora'] , PDO::PARAM_STR);
        
        $p1 = $stmt->execute();
        $p2 = $stmt->errorInfo();
        return array($p1 , $p2[2]);
    }
    function update($_P ) {
        if($_SESSION['cargo']!='Presidente' && $_SESSION['comicion']!='COMISION ESPECIAL DE TUTORIA'){$cod_profesor=$_SESSION['idusuario'];}
        $semestre_ultimo = $this->mostrar_semestre_ultimo();
        $sql = $this->Query("sp_evento_iu(1,:p1,:p2,:p3,:p4,:p5,:p6,:p7)");
        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(':p1',$_P['idevento'] , PDO::PARAM_INT);       
        $stmt->bindValue(':p2', $_P['tema'] , PDO::PARAM_STR);      
        $stmt->bindValue(':p3', $_P['idtipo_evento'] , PDO::PARAM_INT);        
        $stmt->bindValue(':p4', $semestre_ultimo, PDO::PARAM_STR);       
        $stmt->bindValue(':p5', $_P['fecha'] , PDO::PARAM_STR);
        $stmt->bindValue(':p6', $cod_profesor , PDO::PARAM_STR);
        $stmt->bindValue(':p7', $_P['hora'] , PDO::PARAM_STR);
        $p1 = $stmt->execute();
        $p2 = $stmt->errorInfo();
        return array($p1 , $p2[2]);
    }
    function delete($p) {
        $sql = $this->Query("sp_evento_sd(1,:p1)");
        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(':p1', $p, PDO::PARAM_INT);
        $p1 = $stmt->execute();
        $p2 = $stmt->errorInfo();
        return array($p1 , $p2[2]);
    }
}
?>
