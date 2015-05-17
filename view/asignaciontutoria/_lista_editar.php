<?php // echo "<pre>";print_r($rows);exit;?>
<script>
    $(function() {
 $('.delete').live('click', function() {
        i = $(this).parent().parent().index();
        $('#detalle tbody tr:eq(' + i + ')').remove();
    });
    });
</script>
<table id="detalle" class="ui-widget ui-widget-content" style="width: 380px; margin: 0 auto; ">
    <thead class="ui-widget ui-widget-content">
        <tr class="ui-widget-header" style="height: 20px">
            <th>CODIGO</th>
            <th>NOMBRE DE ALUMNO</th>
            <th></th>
        </tr>
    </thead>
<tbody> 
    <?php foreach($rows as $f){
        echo $f['name'];
        echo "<tr>";
        echo "<td><input type='hidden' name='id_idalumno[]' value='".$f['CodigoAlumno']."'> ".$f['CodigoAlumno']."</td>";
        echo "<td> <input type='hidden' name='id_nombrealumno[]' value='".$f['CodigoAlumno']."'>".  utf8_encode($f['nombre'])."</td>";
        echo '<td><a class="delete glyphicon glyphicon-trash" title="Eliminar item" href="javascript:"></a></td>';
        echo "</tr>";
    }?>
</tbody>
</table>