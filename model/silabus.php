<?php
include_once("../lib/dbfactory.php");
class silabus extends Main{    
    function index($query,$p,$c){
        $sql = "SELECT
                silabus.idsilabus,
                carga_academica.idcargaacademica,
                silabus.sumilla,
                silabus.metodologia,
                CONCAT(trim(profesores.NombreProfesor),' ',trim(profesores.ApellidoPaterno),' ',trim(profesores.ApellidoMaterno)),
                cursos.DescripcionCurso,
                silabus.fecha_inicio,
                silabus.duracion,
                semestreacademico.Descripcion
                FROM
                silabus
                Inner Join carga_academica ON carga_academica.idcargaacademica = silabus.idcargaacademica
                Inner Join profesores ON carga_academica.CodigoProfesor = profesores.CodigoProfesor
                Inner Join cursos ON carga_academica.CodigoCurso = cursos.CodigoCurso
                Inner Join semestreacademico ON semestreacademico.CodigoSemestre = carga_academica.CodigoSemestre
                where ".$c." like :query";         
        $param = array(array('key'=>':query' , 'value'=>"%$query%" , 'type'=>'STR' ));
        $data['total'] = $this->getTotal( $sql, $param );
        $data['rows'] =  $this->getRow($sql, $param , $p );        
        $data['rowspag'] = $this->getRowPag($data['total'], $p );        
        return $data;
    } 
    function select($_P){
        echo "<pre>"; print_r ($_P);
        $idsilabo=$_P["codsilabo"];
        $stmt = $this->db->prepare("SELECT idsilabus,sumilla,competencia, metodologia,competencia FROM silabus 
            where idsilabus = :p1");
        $stmt->bindValue(':p1', $idsilabo, PDO::PARAM_INT);
        $p1 = $stmt->execute();
    }

    function edit($id ) 
    {
        $stmt = $this->db->prepare("SELECT * FROM silabus WHERE idsilabus = :id");
        $stmt->bindValue(':id', $id ,PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchObject();
        
        $sql = $this->Query("mostrar_carga_academica_poridsilabus(:id)");
        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(':p1', $id , PDO::PARAM_INT);
        $p1 = $stmt->execute();
       
    }

 function insert($_P) {

        $coddocente  = $_P["coddocente"];
        $codcurso    = $_P["codcurso"];
        $codsemestre = $_P["codemestre"];

   
        $stmt = $this->db->prepare("
            SELECT idcargaacademica FROM carga_academica  
            where CodigoProfesor=:p1 and 
                  CodigoSemestre=:p2 and
                  CodigoCurso= :p3
         ");
        $stmt->execute(array(':p1' => $coddocente , ':p2'=>$codsemestre,':p3'=>$codcurso));
        $result = $stmt->fetch();

        /*guardamos silabo*/
        
        $idcargaacademica = $result["idcargaacademica"];
        $competencia = $_P["competenciaS"];
        $metodologia = $_P["metodologia"];
        $objetivo = $_P["objetivo"];
        $sumilla = $_P["sumilla"];

        $sentencia=$this->db->query("SELECT MAX(idsilabus) as cant from silabus");         
        $ct=$sentencia->fetch();      
        $xd=1+(int)$ct['cant'];
        $sql = $this->Query("sp_sila_iu(0,:p1,:p2,:p3,:p4,:p5,:p6)");
        $stmt2 = $this->db->prepare($sql);
        $stmt2->bindValue(':p1', $xd , PDO::PARAM_INT);
        $stmt2->bindValue(':p2', $idcargaacademica , PDO::PARAM_INT);
        $stmt2->bindValue(':p3', $sumilla , PDO::PARAM_STR);
        $stmt2->bindValue(':p4', $metodologia , PDO::PARAM_STR);
        $stmt2->bindValue(':p5', $competencia , PDO::PARAM_STR);
        $stmt2->bindValue(':p6', $objetivo , PDO::PARAM_STR);
        
        $p1 = $stmt2->execute();
        $p1 = $stmt2->errorInfo();
       
        $sentencia2=$this->db->query("SELECT MAX(idsilabus) as ids from silabus");         
        $ct2=$sentencia2->fetch(); 
        $ultimosilabus = $ct2["ids"];
        
        $cuentaunidad = count($_P["nombreuni"]);

        //ingresamos unidades
        $c=0;
        for ($i=0; $i<$cuentaunidad ;$i++) { 
 
            $sentencia3=$this->db->query("SELECT MAX(idunidad) as un from unidad");         
            $ct3=$sentencia3->fetch();      
            $xd2=1+ (int)$ct3['un'];
         
            $sql = $this->Query("sp_uni_iu(0,:p1,:p2,:p3,:p4,:p5,:p6,:p7)");
            $stmt3 = $this->db->prepare($sql);
            $stmt3->bindValue(':p1', $xd2 , PDO::PARAM_INT);
            $stmt3->bindValue(':p2', $ultimosilabus , PDO::PARAM_INT);
            $stmt3->bindValue(':p3', $_P['nombreuni'][$i] , PDO::PARAM_STR); 
            $stmt3->bindValue(':p4', $_P['descripcion'][$i] , PDO::PARAM_STR);
            $stmt3->bindValue(':p5', $_P['competencia'][$i] , PDO::PARAM_STR);
            $stmt3->bindValue(':p6', $_P['duracion'][$i] , PDO::PARAM_STR);
            $stmt3->bindValue(':p7', $_P['porcentaje'][$i] , PDO::PARAM_STR);
            $p2 = $stmt3->execute();
            $p2 = $stmt3->errorInfo();
            
            //capturamos la ultima unidad
           $sentencia4=$this->db->query("SELECT MAX(idunidad) as cuni from unidad");         
            $ct4=$sentencia4->fetch();    
            $ultimaunidad = $ct4["cuni"];


            $cuentadur = count($_P["duracion"][$i]);
            $seman =($_P["duracion"][$i]);
            for ($j=0; $j<$cuentadur ;$j++) { 
                 $s=$j+1;
                 //isertamos los temas
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
                    $stmt4->bindValue(':p4', $_P['cont'.$d.'-'.$s.''] , PDO::PARAM_STR);
                    $stmt4->bindValue(':p5', $_P['conce'.$d.'-'.$s.''] , PDO::PARAM_STR);
                    $stmt4->bindValue(':p6', $_P['proc'.$d.'-'.$s.''] , PDO::PARAM_STR);
                    $stmt4->bindValue(':p7', $_P['act'.$d.'-'.$s.''] , PDO::PARAM_STR);
                    $p3 = $stmt4->execute();
                    $p3 = $stmt4->errorInfo();
                }
            }  
               //isertamos la evaluacion
            $hh = $i+1;
//            print_r($_P['tipEva'.$hh]); exit();
            $cuentaEva = count($_P['tipEva'.$hh]);
             for ($t=0; $t<$cuentaEva; $t++) { 
                     $sentencia6=$this->db->query("SELECT MAX(idevaluacion) as eva from evaluacion");         
                     $ct6=$sentencia6->fetch();      
                      $xd51=1+ (int)$ct6['eva'];
                    $sql = $this->Query("sp_eva_iu(0,:p1,:p2,:p3,:p4,:p5,:p6)");
                    $stmt41 = $this->db->prepare($sql);
                    $stmt41->bindValue(':p1', $xd51 , PDO::PARAM_INT);
                    $stmt41->bindValue(':p2', $ultimaunidad , PDO::PARAM_INT);
                    $stmt41->bindValue(':p3', $_P['tipEva'.$hh][$t] , PDO::PARAM_INT);
                    $stmt41->bindValue(':p4', $_P['descripcionEva'.$hh][$t] , PDO::PARAM_STR);
                    $stmt41->bindValue(':p5', $_P['fechaEva'.$hh][$t] , PDO::PARAM_STR);
                    $stmt41->bindValue(':p6', $_P['ponderadoEva'.$hh][$t] , PDO::PARAM_INT);
                    $p41 = $stmt41->execute();
                    $p41 = $stmt41->errorInfo();
                }   
        } 

        //ingresamos bibliografia
        $uss= count($_P["descripcionBibio"]);         
        $ref=1;  
        for ($o=0; $o <$uss; $o++) { 
            $sentencia6=$this->db->query("SELECT MAX(idbibliografia) as cant from bibliografia");         
            $ct=$sentencia6->fetch();      
            $xd6=1+(int)$ct['cant'];

            $sql = $this->Query("sp_biblio_iu(0,:p1,:p2,:p3,:p4,:p5)");
            $stmt6 = $this->db->prepare($sql);
            $stmt6->bindValue(':p1', $xd6 , PDO::PARAM_INT);
            $stmt6->bindValue(':p2', $ultimosilabus , PDO::PARAM_INT);
            $stmt6->bindValue(':p3', $ref , PDO::PARAM_INT);
            $stmt6->bindValue(':p4', $_P['descripcionBibio'][$o] , PDO::PARAM_STR);
            $stmt6->bindValue(':p5', $_P['tipbibl'][$o] , PDO::PARAM_INT);
            $p6 = $stmt6->execute();
            $p6 = $stmt6->errorInfo();
         } 

        
    header('Location: sisacreditacion/web/index.php?controller=cursosemestre');

}
     
    
    function update($_P ) {
        
        $sql = $this->Query("sp_sila_iu(1,:p1,:p2,:p3,:p4,:p5,:p6,:p7,:p8,:p9)");
        $stmt = $this->db->prepare($sql);
        if($_P['idpadre']==""){$_P['idpadre']=null;}
        
        $stmt->bindValue(':p1', $_P['idsilabus']  , PDO::PARAM_INT);
        $stmt->bindValue(':p2', $_P['idcargaacademica'] , PDO::PARAM_INT);
        $stmt->bindValue(':p3', $_P['sumilla'] , PDO::PARAM_STR);
        $stmt->bindValue(':p4', $_P['metodologia'] , PDO::PARAM_STR);
        $stmt->bindValue(':p5', $_P['competencia'] , PDO::PARAM_STR);
        $stmt->bindValue(':p6', $_P['fecha_inicio'] , PDO::PARAM_STR);
        $stmt->bindValue(':p7', $_P['fecha_termino'] , PDO::PARAM_STR);
        $stmt->bindValue(':p8', $_P['duracion'] , PDO::PARAM_STR);
        $stmt->bindValue(':p9', $_P['objetivo'] , PDO::PARAM_STR);
        $p1 = $stmt->execute();
        $p2 = $stmt->errorInfo();
        return array($p1 , $p2[2]);
    }
    function delete($p) {
        $stmt = $this->db->prepare("DELETE FROM silabus WHERE idsilabus = :p1");
        $stmt->bindValue(':p1', $p, PDO::PARAM_INT);
        $p1 = $stmt->execute();
        $p2 = $stmt->errorInfo();
        return array($p1 , $p2[2]); 
    }
    function actualizar_silabo($_P) {
        echo "<pre>"; print_r ($_P);
        $idsilabo=$_P["codsilabo"];
        $campo= $_P["campot"];
        $nom= $_P["nombre"];

        $stmt = $this->db->prepare("UPDATE silabus SET ".$nom." = :p2
                                    WHERE idsilabus = :p1");
        $stmt->bindValue(':p1', $idsilabo, PDO::PARAM_INT);
        $stmt->bindValue(':p2', $campo, PDO::PARAM_STR);
        $p1 = $stmt->execute();
    }
}
?>


