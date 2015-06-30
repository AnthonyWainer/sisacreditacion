<?php
include_once("../lib/dbfactory.php");
class evaluacion extends Main{    
    function index($query,$p,$c) 
    {
        $sql = "SELECT
                evaluacion.idevaluacion,
                unidad.descripcionunidad,
                tipo_evaluacion.descripcion,
                evaluacion.descripcionevaluacion,
                evaluacion.fecha,
                evaluacion.ponderado
                FROM
                evaluacion
                Inner Join unidad ON unidad.idunidad = evaluacion.idunidad
                Inner Join tipo_evaluacion ON tipo_evaluacion.idtipo_evaluacion = evaluacion.idtipo_evaluacion


                where ".$c." like :query";         
        $param = array(array('key'=>':query' , 'value'=>"%$query%" , 'type'=>'STR' ));
        $data['total'] = $this->getTotal( $sql, $param );
        $data['rows'] =  $this->getRow($sql, $param , $p );        
        $data['rowspag'] = $this->getRowPag($data['total'], $p );        
        return $data;
    }       
    function edit($id ) 
    {
        $stmt = $this->db->prepare("SELECT * FROM evaluacion WHERE idevaluacion = :id");
        $stmt->bindValue(':id', $id , PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchObject();
    }
    function insert($_P) {
        
        print_r($_P);
        $sentencia=$this->db->query("SELECT MAX(idevaluacion) as cant from evaluacion");         
        $ct=$sentencia->fetch();      
        $xd=1+(int)$ct['cant'];
        $sql = $this->Query("sp_eva_iu(0,:p1,:p2,:p3,:p4,:p5,:p6)");
        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(':p1', $xd , PDO::PARAM_INT);
        $stmt->bindValue(':p2', $_P['idunidad'] , PDO::PARAM_INT);
        $stmt->bindValue(':p3', 1 , PDO::PARAM_INT);
        $stmt->bindValue(':p4', '', PDO::PARAM_STR);
        $stmt->bindValue(':p5', '', PDO::PARAM_STR);
        $stmt->bindValue(':p6', $_P['ponderado'] , PDO::PARAM_INT);
        $p1 = $stmt->execute();
        echo "llegue con  alicia";
    }
    function insert1($_P) {
        
        print_r($_P);
        $sentencia=$this->db->query("SELECT MAX(idevaluacion) as cant from evaluacion");         
        $ct=$sentencia->fetch();      
        $xd=1+(int)$ct['cant'];
        $sql = $this->Query("sp_eva_iu(0,:p1,:p2,:p3,:p4,:p5,:p6)");
        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(':p1', $xd , PDO::PARAM_INT);
        $stmt->bindValue(':p2', $_P['idunidad'] , PDO::PARAM_INT);
        $stmt->bindValue(':p3', $_P['idevaluacion'] , PDO::PARAM_INT);
        $stmt->bindValue(':p4', '', PDO::PARAM_STR);
        $stmt->bindValue(':p5', '', PDO::PARAM_STR);
        $stmt->bindValue(':p6', $_P['ponderado'] , PDO::PARAM_INT);
        $p1 = $stmt->execute();
        echo "llegue con  alicia";
    }
    function update($_P ) {
        
        $sql = $this->Query("sp_eva_iu(1,:p1,:p2,:p3,:p4,:p5,:p6)");
        $stmt = $this->db->prepare($sql);
        if($_P['idpadre']==""){$_P['idpadre']=null;}
        
        $stmt->bindValue(':p1', $_P['idevaluacion']  , PDO::PARAM_INT);
        $stmt->bindValue(':p2', $_P['idunidad'] , PDO::PARAM_INT);
        $stmt->bindValue(':p3', $_P['idtipo_evaluacion'] , PDO::PARAM_INT);
        $stmt->bindValue(':p4', $_P['descripcionevaluacion'] , PDO::PARAM_STR);
        $stmt->bindValue(':p5', $_P['fecha'] , PDO::PARAM_STR);
        $stmt->bindValue(':p6', $_P['ponderado'] , PDO::PARAM_STR);
       

        $p1 = $stmt->execute();
        $p2 = $stmt->errorInfo();
        return array($p1 , $p2[2]);
    }
    //aki toy
    function actualizar_evaluacion_tipo($_P) {
        echo "<pre>"; print_r ($_P);
        $eva=$_P["Evaluacion"];
        $cam= $_P["Campo"];
        $edit= $_P["Editar"];

        $stmt = $this->db->prepare("UPDATE evaluacion SET ".$cam." = :p2
                                    WHERE idevaluacion = :p1");
        $stmt->bindValue(':p1', $eva, PDO::PARAM_INT);
        $stmt->bindValue(':p2', $edit, PDO::PARAM_STR);
        $p1 = $stmt->execute();
    }
    function updateBoton($_P) {
        $eva=(int)$_P["idevaluacion"];
        $stmt = $this->db->prepare("UPDATE evaluacion SET estadoBoton = 1
                                    WHERE idevaluacion = :p1");
        $stmt->bindValue(':p1', $eva, PDO::PARAM_INT);
        $p1 = $stmt->execute();
    }    
    function getTipoEva() {
        $sth = $this->db->prepare("SELECT idtipo_evaluacion,descripcion FROM tipo_evaluacion");
        $sth->execute();
        return $sth->fetchAll();
    }
    
    function delete($p) {
        $stmt = $this->db->prepare("DELETE FROM evaluacion WHERE idevaluacion = :p1");
        $stmt->bindValue(':p1', $p, PDO::PARAM_INT);
        $p1 = $stmt->execute();
        $p2 = $stmt->errorInfo();
        return array($p1 , $p2[2]);
    }
}
?>

