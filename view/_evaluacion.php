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
<?php foreach ($rows as $key => $value) { ?>
			<tr class="dtp1">
				<td >
					<input type="hidden" id="ideva" value="<?php echo $value[4]?>" />
				 <?php 
                 
               echo "<select style='border:none; background:#EAF8FC; width:300px;' class='form-control k2' id='idtipo_evaluacion'>";
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
				<textarea class="k2" style="border: none; resize: none; background-color: rgb(249, 249, 249);" id="descripcionevaluacion"><?php echo (utf8_encode($value[1]));?></textarea>
				</td>
				<td>
				<?php echo (utf8_encode($value[2]));?>
				</td>
				<td>
				<?php echo (utf8_encode($value[3]));?>
				</td>
                <td><p class="col-md-1 eli" onclick="eliEva(<?php echo $value[4]?>,<?php echo $value[5]?>)" title="eliminar unidad"><i class="fa fa-trash-o"></i></p></td>
			</tr>
<?php } ?>
	</tbody>
</table>

<script type="text/javascript">
    $(document).ready(function(){
        $('.eva select').change(function(){
	        edit= $(this).val();
	        campo= $(this).attr('id');
	        ide=$('#ideva').val();
	        //alert(edit + " "+campo + " " + ide);
	        $.post('index.php', 'controller=cursosemestre&action=editarEva_tipo&Campo=' +campo+
	                                                '&Evaluacion='+ide+'&Editar='+edit, function(data) {
	                          });
        });

        $('.eva .k2').blur(function(){
	        edit= $(this).val();
	        campo= $(this).attr('id');
	        ide=$('#ideva').val();
	        //alert(edit + " "+campo + " " + ide);
	        $.post('index.php', 'controller=cursosemestre&action=editarEva_tipo&Campo=' +campo+
	                                                '&Evaluacion='+ide+'&Editar='+edit, function(data) {
	                          });
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