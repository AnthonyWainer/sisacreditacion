
<?php $p=0; foreach ($rows as $key => $value) { 
        $p += $value[3];
    }
    $po = 100-$p;
    if ($po!=0) {  ?>
    <button type="button" class="btn btn-default ag">agregar</button>
    <input type="number" id="Poreva" value="<?php echo $po; ?>">

<?php        
    }
?>

<div class="table-responsive">
    
<table class="table eva" id="eval">
	<thead>
		<tr>
			<th>tipo Evaluacion</th>
			<th>Descripcion</th>
			<th>fecha</th>
			<th>ponderado</th>
            <th>eliminar</th>
		</tr>
	</thead>
	<tbody>
<?php foreach ($rows as $key => $value) {  ?>
			<tr class="dtp1">
				<td >
				 <?php 
                 
               echo "<select style='border:none; rgb(249, 249, 249); width:300px;' name='".$value[4]."?>'  class='form-control k2' id='idtipo_evaluacion'>";
               foreach ($eva as $key => $ev) { 
                   if ($value[0] != $ev[0] ) {
                       echo "<option value='".$ev[0]."'>".$ev[1]."</option>";
                   }else{
                   		echo "<option selected value='".$ev[0]."'>".$ev[1]."</option>";
                   }
                }
                echo "</select>";   
            
         ?>    
				</td>
				<td>
				<textarea class="k2" name="<?php echo $value[4]?>" style="border: none; resize: none; background-color: rgb(249, 249, 249);" id="descripcionevaluacion"><?php echo (utf8_encode($value[1]));?></textarea>
				</td>
				<td>
				<input type="date" name="<?php echo $value[4]?>"class='form-control k2'  id="fecha" style="border: none; background-color: rgb(249, 249, 249);" value="<?php echo (utf8_encode($value[2]));?>" placeholder=""> 
				</td>
				<td>
				<?php echo (utf8_encode($value[3]));?>
				</td>
         <td>
         <p class="eli" onclick="eliEva(<?php echo $value[4]?>,<?php echo $value[5]?>)" title="eliminar evaluacion"><i class="fa fa-trash-o"></i></p>
         </td>
			</tr>
<?php } ?>
	</tbody>
</table>

</div>
<script type="text/javascript">
        $('.dtp1 .k2').change(function(){
            edit= $(this).val();
            campo= $(this).attr('id');
            ide=$(this).attr('name');
            //alert(edit + " "+campo + " " + ide);
            $.post('index.php', 'controller=cursosemestre&action=editarEva_tipo&Campo=' +campo+
                                                    '&Evaluacion='+ide+'&Editar='+edit, function(data) {
                    alertify.success("Cambio guardado");  
                              });
        });

        $('.dtp1 .k2').blur(function(){
            edit= $(this).val();
            campo= $(this).attr('id');
            ide=$(this).attr('name');
            //alert(edit + " "+campo + " " + ide);
            $.post('index.php', 'controller=cursosemestre&action=editarEva_tipo&Campo=' +campo+
                                                    '&Evaluacion='+ide+'&Editar='+edit, function(data) {
            alertify.success("Cambio guardado");                                                          
                              });
        });
function eliEva(id,uni){
    //alert("huanaco"+id);
    alertify.confirm("¿ESTÁS SEGURO DE ELIMINAR LA EVALUACIÓN?", function (e) {
    if (e) {
        $.post('index.php', 'controller=evaluacion&action=delete&id=' +id, function(data) {
            eva(uni);
            alertify.success("EVALUACIÓN ELIMINADA");  
        });
    } else {
        alertify.success("EVALUACIÓN NO ELIMINADA");  
    }
    });
}    
</script>