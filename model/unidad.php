<?php
include_once("../lib/dbfactory.php");
class unidad extends Main{    
    function index($query,$p,$c) 
    {
        $sql = "select 
            unidad.idunidad,
            silabus.idsilabus,
            unidad.nombreunidad, 
            unidad.descripcionunidad, 
            unidad.duracion,
            silabus.sumilla,
            unidad.competencia,
            unidad.porcentaje
                
                FROM
                unidad
                Inner Join silabus ON  unidad.idsilabus = silabus.idsilabus  
                WHERE ".$c." like :query";         
        $param = array(array('key'=>':query' , 'value'=>"%$query%" , 'type'=>'STR' ));
        $data['total'] = $this->getTotal( $sql, $param );
        $data['rows'] =  $this->getRow($sql, $param , $p );        
        $data['rowspag'] =  $this->getRowPag($data['total'], $p );        
        return $data;
    }       
    function edit($id ) 
    {
        $stmt = $this->db->prepare("SELECT * FROM unidad WHERE idunidad = :id");
        $stmt->bindValue(':id', $id , PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchObject();
    }
    function insert($_P ) {

         $sentencia=$this->db->query("SELECT MAX(idunidad) as cant from unidad");         
         $ct=$sentencia->fetch();      
        $xd=1+ (int)$ct['cant'];
        $sql = $this->Query("sp_uni_iu(0,:p1,:p2,:p3,:p4,:p5,:p6,:p7)");
        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(':p1', $xd , PDO::PARAM_INT);
        $stmt->bindValue(':p2', $_P['idsilabo'] , PDO::PARAM_INT);
        $stmt->bindValue(':p3', $_P['nombreunidad'] , PDO::PARAM_STR); 
        $stmt->bindValue(':p4', '' , PDO::PARAM_STR);
        $stmt->bindValue(':p5','', PDO::PARAM_STR);
        $stmt->bindValue(':p6',  $_P['duracion']  , PDO::PARAM_STR);  
        $stmt->bindValue(':p7', $_P['porcentaje'] , PDO::PARAM_STR);
        $p1 = $stmt->execute();
        $p2 = $stmt->errorInfo();
        return array($p1 , $p2[2]);
    }
    function insert2($_P ) {
         $sentencia=$this->db->query("SELECT MAX(idunidad) as cant from unidad");         
         $ct=$sentencia->fetch();      
        $xd=1+ (int)$ct['cant'];
        $sql = $this->Query("sp_uni_iu(0,:p1,:p2,:p3,:p4,:p5,:p6,:p7)");
        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(':p1', $xd , PDO::PARAM_INT);
        $stmt->bindValue(':p2', $_P['idsilabo'] , PDO::PARAM_INT);
        $stmt->bindValue(':p3', $_P['nombreunidad'] , PDO::PARAM_STR); 
        $stmt->bindValue(':p4', '' , PDO::PARAM_STR);
        $stmt->bindValue(':p5','', PDO::PARAM_STR);
        $stmt->bindValue(':p6',  $_P['duracion']  , PDO::PARAM_STR);  
        $stmt->bindValue(':p7', $_P['porcentaje'] , PDO::PARAM_STR);
        $p1 = $stmt->execute();
        $p2 = $stmt->errorInfo();
            //capturamos la ultima unidad
        $sentencia4=$this->db->query("SELECT MAX(idunidad) as cuni from unidad");         
        $ct4=$sentencia4->fetch();    
        $ultimaunidad = $ct4["cuni"];

        //isertamos la evaluacion
        $hh = $i+1;
        $e = [3,4,6,7,8,10];
        for ($t=0; $t<6; $t++) { 
                    $sentencia6=$this->db->query("SELECT MAX(idevaluacion) as eva from evaluacion");         
                     $ct6=$sentencia6->fetch();      
                      $xd51=1+ (int)$ct6['eva'];
                    $sql = $this->Query("sp_eva_iu(0,:p1,:p2,:p3,:p4,:p5,:p6)");
                    $stmt41 = $this->db->prepare($sql);
                    $stmt41->bindValue(':p1', $xd51 , PDO::PARAM_INT);
                    $stmt41->bindValue(':p2', $ultimaunidad , PDO::PARAM_INT);
                    $stmt41->bindValue(':p3', $e[$t]  , PDO::PARAM_INT);
                    $stmt41->bindValue(':p4', '' , PDO::PARAM_STR);
                    $stmt41->bindValue(':p5', '' , PDO::PARAM_STR);
                    $stmt41->bindValue(':p6', 0 , PDO::PARAM_INT);
                    $p41 = $stmt41->execute();
                    $p41 = $stmt41->errorInfo();
        } 
    }    
    function update($_P ) {
        $sql = $this->Query("sp_uni_iu(1,:p1,:p2,:p3,:p4,:p5,:p6,:p7)");
        $stmt = $this->db->prepare($sql);
        if($_P['idpadre']==""){$_P['idpadre']=null;}
        $stmt->bindValue(':p1', $_P['idunidad'] , PDO::PARAM_INT);
        $stmt->bindValue(':p2', $_P['idsilabus'] , PDO::PARAM_INT);
        $stmt->bindValue(':p3', $_P['nombreunidad'] , PDO::PARAM_STR); 
        $stmt->bindValue(':p4', $_P['descripcionunidad'] , PDO::PARAM_STR);
        $stmt->bindValue(':p5', $_P['duracion'] , PDO::PARAM_STR);
        $stmt->bindValue(':p6', $_P['competencia'] , PDO::PARAM_STR);
        $stmt->bindValue(':p6', $_P['porcentaje'] , PDO::PARAM_STR);
        $p1 = $stmt->execute();
        $p2 = $stmt->errorInfo();
        return array($p1 , $p2[2]);
    }
    function delete($p) {
        $stmt = $this->db->prepare("DELETE FROM unidad WHERE idunidad = :p1");
        $stmt->bindValue(':p1', $p, PDO::PARAM_INT);
        $p1 = $stmt->execute();
        $p2 = $stmt->errorInfo();
        return array($p1 , $p2[2]);
    }

    //aki toy
    function actualizar_unidad_nombre($_P) {
        echo "<pre>"; print_r ($_P);
        $uni=$_P["Unidad"];
        $cam= $_P["Campo"];
        $edit= $_P["Editar"];

        $stmt = $this->db->prepare("UPDATE unidad SET ".$cam." = :p2
                                    WHERE idunidad = :p1");
        $stmt->bindValue(':p1', $uni, PDO::PARAM_INT);
        $stmt->bindValue(':p2', $edit, PDO::PARAM_STR);
        $p1 = $stmt->execute();
    }
}
?>
