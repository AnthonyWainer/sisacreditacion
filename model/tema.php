<?php
include_once("../lib/dbfactory.php");
class tema extends Main{    
    function index($query,$p,$c) 
    {
        $sql = "SELECT
                tema.idtema,
                tema.contenido,
                tema.competencia,
                unidad.nombreunidad
                FROM
                tema
                Inner Join unidad ON tema.idunidad = unidad.idunidad
                WHERE ".$c." like :query";         
        $param = array(array('key'=>':query' , 'value'=>"%$query%" , 'type'=>'STR' ));
        $data['total'] = $this->getTotal( $sql, $param );
        $data['rows'] =  $this->getRow($sql, $param , $p );        
        $data['rowspag'] =  $this->getRowPag($data['total'], $p );        
        return $data;
    }       
    function edit($id ) 
    {
        $stmt = $this->db->prepare("SELECT * FROM tema WHERE idtema = :id");
        $stmt->bindValue(':id', $id , PDO::PARAM_STR);
        $stmt->execute();
        return $stmt->fetchObject();
    }

    function update($_P ) {
        $sql = $this->Query("sp_tema_iu(1,:p1,:p2,:p3,:p4,:p5,:p6,:p7,:p8)");
        $stmt = $this->db->prepare($sql);
        if($_P['idpadre']==""){$_P['idpadre']=null;}
        $stmt->bindValue(':p1', $_P['idtema'] , PDO::PARAM_INT);
        $stmt->bindValue(':p2', $_P['idunidad'] , PDO::PARAM_INT);
        $stmt->bindValue(':p3', $_P['semana'] , PDO::PARAM_STR);
        $stmt->bindValue(':p4', $_P['contenido'] , PDO::PARAM_STR);
        $stmt->bindValue(':p5', $_P['conceptual'] , PDO::PARAM_STR);
        $stmt->bindValue(':p6', $_P['procedimental'] , PDO::PARAM_STR);
        $stmt->bindValue(':p7', $_P['actitudinal'] , PDO::PARAM_STR);
        $stmt->bindValue(':p8', $_P['competencia'] , PDO::PARAM_STR);

        $p1 = $stmt->execute();
        $p2 = $stmt->errorInfo();
        return array($p1 , $p2[2]);
    }
    function delete($p) {
        $stmt = $this->db->prepare("DELETE FROM tema WHERE idtema = :p1");
        $stmt->bindValue(':p1', $p, PDO::PARAM_INT);
        $p1 = $stmt->execute();
        $p2 = $stmt->errorInfo();
        return array($p1 , $p2[2]);
    }
    
    function actualizar_tema($_P) {
        echo "<pre>"; print_r ($_P);
        $tem=$_P["Tema"];
        $cam= $_P["Campo"];
        $edit= $_P["Editar"];

        $stmt = $this->db->prepare("UPDATE tema SET ".$cam." = :p2
                                    WHERE idtema = :p1");
        $stmt->bindValue(':p1', $tem, PDO::PARAM_INT);
        $stmt->bindValue(':p2', $edit, PDO::PARAM_STR);
        $p1 = $stmt->execute();
    }

    function insert($_P){
            $sentencia4=$this->db->query("SELECT MAX(idunidad) as cuni from unidad");         
            $ct4=$sentencia4->fetch();    
            $ultimaunidad = $ct4["cuni"];
            $seman =($_P["duracion"]);
            for ($k=0; $k<$seman; $k++) { 
                    $sentencia5=$this->db->query("SELECT MAX(idtema) as tem from tema");         
                    $ct5=$sentencia5->fetch();      
                    $xd4=1+ (int)$ct5['tem'];
                    $d=$k+1;
                    $c=$c + 1;  
                    $sem='semana '.$c;
                    $sql = $this->Query("sp_tema_iu(0,:p1,:p2,:p3,:p4,:p5,:p6,:p7)");
                    $stmt4 = $this->db->prepare($sql);
                    $stmt4->bindValue(':p1', $xd4 , PDO::PARAM_INT);
                    $stmt4->bindValue(':p2', $ultimaunidad , PDO::PARAM_INT);
                    $stmt4->bindValue(':p3', $sem , PDO::PARAM_STR);
                    $stmt4->bindValue(':p4', '' , PDO::PARAM_STR);
                    $stmt4->bindValue(':p5', '' , PDO::PARAM_STR);
                    $stmt4->bindValue(':p6', '' , PDO::PARAM_STR);
                    $stmt4->bindValue(':p7', '' , PDO::PARAM_STR);
                    $p3 = $stmt4->execute();
                    $p3 = $stmt4->errorInfo();
            }  
    }
}
?>
