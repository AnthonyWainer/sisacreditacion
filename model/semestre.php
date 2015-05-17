<?php
include_once("../lib/dbfactory.php");
class semestre extends Main{   
    
    public $opt;
    function index($query,$p,$c) {        
        $sql = "SELECT
                    CodigoSemestre,
                    Descripcion
                    FROM
                    semestreacademico
                where ".$c." like :query";         
        $param = array(array('key'=>':query' , 'value'=>"%$query%" , 'type'=>'STR' ));
        $data['total'] = $this->getTotal( $sql, $param );
        $data['rows'] = $this->getRow($sql, $param , $p );        
        $data['rowspag'] =  $this->getRowPag($data['total'], $p );        
        return $data;
    }       
    function edit($id ) {
        $stmt = $this->db->prepare("SELECT * FROM semestreacademico WHERE CodigoSemestre = :id");
        $stmt->bindValue(':id', $id , PDO::PARAM_STR);
        $stmt->execute();
        return $stmt->fetchObject();
    }
    
    function insert($_P ) {
           
            $sentencia=$this->db->query("SELECT COUNT(CodigoSemestre) as cant from semestreacademico");         
         $ct=$sentencia->fetch();      
          $xd=1+ (int)$ct['cant'];
          $xd="".$xd;
        $sql = $this->Query("sp_semestreacademico_iu(0,:p1,:p2,:P3,:p4,:p5,:p6,:p7,:p8,:p9,:p10,:p11,:p12,:p13,:p14,:p15,:p16,:p17,:p18,:p19,:p20)");
        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(':p1',$xd , PDO::PARAM_STR);
        $stmt->bindValue(':p2', $_P['Descripcion'] , PDO::PARAM_STR);
        $stmt->bindValue(':p3', $_P['EstadoSemestre'] , PDO::PARAM_STR);
        $stmt->bindValue(':p4', $_P['ConceptoCarnet'] , PDO::PARAM_STR);
        $stmt->bindValue(':p5', $_P['Abreviatura'] , PDO::PARAM_STR);
        $stmt->bindValue(':p6', $_P['FechaInicio'] , PDO::PARAM_STR);
        $stmt->bindValue(':p7', $_P['FechaTermino'] , PDO::PARAM_STR);
        $stmt->bindValue(':p8', $_P['ExamenOrdinario'] , PDO::PARAM_STR);
        $stmt->bindValue(':p9', $_P['AcreditacionIngresante'] , PDO::PARAM_STR);
        $stmt->bindValue(':p10', $_P['InicioClase'] , PDO::PARAM_STR);
        $stmt->bindValue(':p11', $_P['EncuestaEstudiantil'] , PDO::PARAM_STR);
        $stmt->bindValue(':p12', $_P['ExamenParcial'] , PDO::PARAM_STR);
        $stmt->bindValue(':p13', $_P['RetiroTotal'] , PDO::PARAM_STR);
        $stmt->bindValue(':p14', $_P['EntregaActa'] , PDO::PARAM_STR);
        $stmt->bindValue(':p15', $_P['ExamenFinal'] , PDO::PARAM_STR);
        $stmt->bindValue(':p16', $_P['RecepcionActa'] , PDO::PARAM_STR);
        $stmt->bindValue(':p17', $_P['MatriculaAplazado'] , PDO::PARAM_STR);
        $stmt->bindValue(':p18', $_P['ExamenAplazado'] , PDO::PARAM_STR);
        $stmt->bindValue(':p19', $_P['EntregaAplazado'] , PDO::PARAM_STR);
        $stmt->bindValue(':p20', $_P['RecepcionAplazado'] , PDO::PARAM_STR);
       
        $p1 = $stmt->execute();
        $p2 = $stmt->errorInfo();
        return array($p1 , $p2[2]);
    }
    
    
    
    function update($_P ) {
        
        $sql = $this->Query("sp_semestreacademico_iu(1,:p1,:p2,:P3,:p4,:p5,:p6,:p7,:p8,:p9,:p10,:p11,:p12,:p13,:p14,:p15,:p16,:p17,:p18,:p19,:p20)");
        $stmt = $this->db->prepare($sql);
        
        if($_P['idpadre']==""){$_P['idpadre']=null;}
        $stmt->bindValue(':p1',$xd , PDO::PARAM_STR);
        $stmt->bindValue(':p2', $_P['Descripcion'] , PDO::PARAM_STR);
        $stmt->bindValue(':p3', $_P['EstadoSemestre'] , PDO::PARAM_STR);
        $stmt->bindValue(':p4', $_P['ConceptoCarnet'] , PDO::PARAM_STR);
        $stmt->bindValue(':p5', $_P['Abreviatura'] , PDO::PARAM_STR);
        $stmt->bindValue(':p6', $_P['FechaInicio'] , PDO::PARAM_STR);
        $stmt->bindValue(':p7', $_P['FechaTermino'] , PDO::PARAM_STR);
        $stmt->bindValue(':p8', $_P['ExamenOrdinario'] , PDO::PARAM_STR);
        $stmt->bindValue(':p9', $_P['AcreditacionIngresante'] , PDO::PARAM_STR);
        $stmt->bindValue(':p10', $_P['InicioClase'] , PDO::PARAM_STR);
        $stmt->bindValue(':p11', $_P['EncuestaEstudiantil'] , PDO::PARAM_STR);
        $stmt->bindValue(':p12', $_P['ExamenParcial'] , PDO::PARAM_STR);
        $stmt->bindValue(':p13', $_P['RetiroTotal'] , PDO::PARAM_STR);
        $stmt->bindValue(':p14', $_P['EntregaActa'] , PDO::PARAM_STR);
        $stmt->bindValue(':p15', $_P['ExamenFinal'] , PDO::PARAM_STR);
        $stmt->bindValue(':p16', $_P['RecepcionActa'] , PDO::PARAM_STR);
        $stmt->bindValue(':p17', $_P['MatriculaAplazado'] , PDO::PARAM_STR);
        $stmt->bindValue(':p18', $_P['ExamenAplazado'] , PDO::PARAM_STR);
        $stmt->bindValue(':p19', $_P['EntregaAplazado'] , PDO::PARAM_STR);
        $stmt->bindValue(':p20', $_P['RecepcionAplazado'] , PDO::PARAM_STR);
       
        $p1 = $stmt->execute();
        $p2 = $stmt->errorInfo();
        return array($p1 , $p2[2]);
    }
    function delete($p) {
        $stmt = $this->db->prepare("DELETE FROM semestreacademico WHERE CodigoSemestre = :p1");
        $stmt->bindValue(':p1', $p, PDO::PARAM_INT);
        $p1 = $stmt->execute();
        $p2 = $stmt->errorInfo();
        return array($p1 , $p2[2]);
    }
    function ver(){
        $query = "SELECT FechaInicio,FechaTermino  from semestreacademico WHERE CodigoSemestre = '{$this->codSemestre}' ";
        $sth = $this->db->prepare($query);
        $sth->execute();
        return $sth->fetchAll();
    }
}
?>
