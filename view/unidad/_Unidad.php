<script type="text/javascript" src="lib/alertify.js"></script>
<link rel="stylesheet" href="themes/alertify.core.css"  type="text/css"/>
<link rel="stylesheet" href= "themes/alertify.default.css"  type="text/css"/>

<?php $p=0; foreach ($rows as $key => $value) { 
        $p += $value[6];
    }
    $po = 100-$p;
    if ($po!=0) {  ?>
    <button type="button" class="btn btn-default ag" id="<?php echo $value[8]; ?>">agregar</button>
    <input type="number" id="Poreva" value="<?php echo $po; ?>">

<?php        
    }
?>
<br><br>

   <?php  $conta = 11;
   foreach ($rows as $key => $value) { $nu = $value[0];
        ?>  

      Unidad <?php echo $conta-10; ?>: <?php echo $value[0]; $cu =$value[1] ?>

      <div class="table-responsive">
<?php $pp=0; foreach ($rows1 as $key => $value) {  if ($value[5] == $cu){ $pp += $value[3]; $iduu=$value[5]; ?>

<?php } 
} 
    $po = 100-$pp;
    if (($po!=0 ) && ($nu == "unidad 0"))  {  ?>
    <button type="button" class="btn btn-default agE" id="<?php echo $iduu; ?>">agregar</button>
             <?php 
                 
               echo "<select style='width:300px;' class='form-control sE'";
               foreach ($eva as $key => $ev) { 
                   if ($value[0] != $ev[0] ) {
                       echo "<option value='".$ev[0]."'>".$ev[1]."</option>";
                   }
                }
                echo "</select>";   
            
         ?>  
    <input type="number" id="Poreva" value="<?php echo $po; ?>">

<?php        
    }
?>         
      <table class="table">
        <thead>
          <tr>
            <th>tipo Evaluacion</th>
            <th>Descripcion</th>
            <th>fecha</th>
            <th>ponderado</th>
          </tr>
        </thead>
        <tbody>
      <?php foreach ($rows1 as $key => $value) {  if ($value[5] == $cu){ ?>
            <tr>
              <td >
               <?php 
                     foreach ($eva as $key => $ev) { 
                         if ($value[0] == $ev[0] ) {
                          echo "<p>".$ev[1]."</p>";
                         }
                      }
                  
               ?>    
              </td>
              <td>
              <?php if ($nu == "unidad 0") { ?>
              <textarea class="k2" name="<?php echo $value[4]?>" style="border: none; resize: none; background-color: rgb(249, 249, 249);" id="descripcionevaluacion"><?php echo (utf8_encode($value[1]));?></textarea>
              <?php }else{ ?>
                  <?php echo $value[1]?>
              <?php } ?>
              </td>
              <td>
              <?php if ($nu == "unidad 0") { ?>
                  <input type="date" name="<?php echo $value[4]?>"class='form-control k2'  id="fecha" style="border: none; background-color: rgb(249, 249, 249);" value="<?php echo (utf8_encode($value[2]));?>" placeholder=""> 
              <?php }else{ ?>
                <?php echo $value[2]?>
              <?php } ?>                  
              </td>
              <td>
              <?php if ($nu == "unidad 0") { ?>
              <input type="text" name="<?php echo $value[4]?>"class='form-control k2'  id="ponderado" style="border: none; background-color: rgb(249, 249, 249);" value="<?php echo (utf8_encode($value[3]));?>" placeholder=""> 
              <?php }else{ ?>
                  <?php echo $value[3]?>
              <?php } ?>              
              </td>
              <?php if ($nu == "unidad 0") { ?>
              <td><p class="col-md-1 eli" onclick="eliEva(<?php echo $value[4]?>,<?php echo $value[5]?>)" title="eliminar unidad"><i class="fa fa-trash-o"></i></p></td>
              <?php }?>

            </tr>
      <?php } } ?>
        </tbody>
      </table>

      </div>
<?php  $conta = $conta + 1;}?>


<script>
$(".ag").click(function(){
  idsi = $(this).attr('id');
  porc = $("#Poreva").val();
    $.post('index.php', 'controller=unidad&action=create2&idsilabo=' +idsi+'&nombreunidad='+'unidad 0'+'&duracion='+0+'&porcentaje='+porc, function(data) {
        alertify.success("SE INSERTO UNIDAD 0");  
        eva111();
  });
});
$(".agE").click(function(){
  idu = $(this).attr('id');
  ide = $(".sE").val();
  porc = $("#Poreva").val();
  $.post('index.php', 'controller=evaluacion&action=insertEvaluacion1&idunidad=' +idu+'&ponderado='+porc+'&idevaluacion='+ide, function(data) {
  alertify.success("SE INSERTO evaluacion");
      eva111();
  });    
});
$('.k2').blur(function(){
            edit= $(this).val();
            campo= $(this).attr('id');
            ide=$(this).attr('name');
            //alert(edit + " "+campo + " " + ide);
            $.post('index.php', 'controller=cursosemestre&action=editarEva_tipo&Campo=' +campo+
                                                    '&Evaluacion='+ide+'&Editar='+edit, function(data) {
              alertify.success("SE INSERTO evaluacion");
              eva111();
                              });
        });
function eliEva(id,uni){
    //alert("huanaco"+id);
    alertify.confirm("¿ESTÁS SEGURO DE ELIMINAR LA EVALUACIÓN?", function (e) {
    if (e) {
        $.post('index.php', 'controller=evaluacion&action=delete&id=' +id, function(data) {
            eva111();
            alertify.success("EVALUACIÓN ELIMINADA");  
        });
    } else {
        alertify.success("EVALUACIÓN NO ELIMINADA");  
    }
    });
}
</script>




