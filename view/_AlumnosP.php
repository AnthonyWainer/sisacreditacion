<script type="text/javascript" src="lib/alertify.js"></script>
<link rel="stylesheet" href="themes/alertify.core.css"  type="text/css"/>
<link rel="stylesheet" href= "themes/alertify.default.css"  type="text/css"/>
<style>
    .tnota{
        padding: 0px;
        width: 38px; 
        
    }
    .tnota input{
        font-size: 10px;
        padding: 1px 8px;
        height: 30px;
        border: none;
    }
</style>
<input type="hidden" id="p_idproyecto" name="p_idproyecto" value="<?= $p_idproyecto?>">
<table class="table table-bordered table-hover" >
                    <thead >
                        <tr>
                            <tH>#</tH>
                            <tH>CÓDIGO</tH>
                            <th>ALUMNOS EN EL PROYECTO</th>
                            <?php  if($_SESSION['perfil'] == 'PROFESOR'){?>
                            <th>CALIFICAR</th>
                            <?php  }else{?>
                                <th>NOTAS</th>
                            <?php  }?>

                        </tr>
                    </thead>
                    <tbody>
                                <?php $i=1; foreach ($rows as $key => $value) { $CodA=$value[4];?>
                            <tr> 
                                <td> <?php echo $i; $i++; ?> </td> 
                                <td><?php echo $value[5]; ?></td>
                                <td align="left"> 
                                    <?php echo strtoupper(utf8_encode($value[3])); ?>
                                </td>
                                <?php  if($_SESSION['perfil'] == 'PROFESOR'){?>
                                <td class="tnota">
                                    
                                    <?php if($rows1){
                                          foreach ($rows1 as $key => $value1) { 
                                          if ($CodA == $value1[3] ){                         
                                         ?>
                                            <input class="form-control notaA" type="text" id="<?php echo $value[0]; ?>" name="<?php echo $value[4]; ?>" value="<?php echo (int)$value1[1]; ?>" placeholder="">    
    
                                    <?php } ?> 
                                            


                                    <?php }}else{ ?> 
                                        <input class="form-control nota" type="hidden" id="<?php echo $value[0]; ?>" name="<?php echo $value[4]; ?>" value="0" placeholder="">
                                        <input class="form-control notaE" name='idalumno[]' type="hidden"  value="<?php echo $value[4]; ?>" placeholder="">
                                    <?php } ?>                                    
                                </td>
                                <?php  }else{?>
                                     <?php if($rows1){
                                          foreach ($rows1 as $key => $value1) { 
                                          if ($CodA == $value1[3] ){                         
                                         ?>
                                         <td> <?php echo (int)$value1[1]; ?> </td>
    
                                    <?php } } } ?> 
        

                                <?php } ?>    
                            </tr>  
                            <?php } ?>
                    </tbody>
                </table>


<script>
    if ($(".nota").val()== 0 ){
        alertify.confirm("notas no insertadas, ¿desea insertar?", function (e) {
            if (e) {

                idAlum =$("input[name='idalumno[]']").serialize();
                tam = idAlum.length;
                idPro =$(".nota").attr('id');

                //idAlum= $(this).attr('name');
                //idPro= $(this).attr('id');
                console.log(idAlum+"&idproyecto="+idPro+"&tam="+tam);
                $.post('index.php', 'controller=notasproyecto&action=guardar&'+idAlum+"&idproyecto="+idPro+"&tam="+tam, function(data) {
                    console.log(data);
                });
                alertify.success("notas insertadas");
                alertify.log("click en notas");                
                location.reload();
                $('#InNota').modal({show: true});

            } else {
                alertify.error("notas no insertadas");
                $('#InNota').modal('hide');

            }
        });
        
    }
$('.notaA').live('keyup' ,function(){
  rangoNumeros($(this).val(),$(this));
});
function rangoNumeros(nro,input){
        if(nro>=0 & nro<=20){
         // alertify.log("esta en el rango")
        }else{
          input.val("");
          alertify.log("por favor ingrese un numero mayor igual a '0' o menor igual a '20'");
        }
}
        
    $(".notaA").blur(function(){
        nota= $(this).val();
        idAlum= $(this).attr('name');
        idPro= $(this).attr('id');
        console.log(nota+idAlum+idPro);
        $.post('index.php', 'controller=notasproyecto&action=actualizar&IdAlumno=' +idAlum+'&idproyecto='+idPro+'&nota='+nota, function(data) {
            console.log(data);
        });
        alertify.success("nota guardada");
    });
    
</script>