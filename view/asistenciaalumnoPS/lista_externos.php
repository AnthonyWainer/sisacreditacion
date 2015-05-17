<script>
    $(function() {
  
     $('#t_evntoPS_alumno').DataTable({
        "paging":   true,
        "sPaginationType": "full_numbers",
        "bJQueryUI":true
    } );
    });
</script>
<div class="div_container">
   <form id="frm" action="index.php" method="POST">
    <input type="hidden" name="controller" value="asistenciaalumnoPS" />
    <input type="hidden" name="action" value="save_asistencias_externos" />
    <input type="hidden" name="idevento" value="<?php echo $idevento;?>" />
    <div class="contFrm ui-corner-all" style="background: #fff;">
        <div class="contenido" style="margin:0 auto; width: 100%; ">
            <fieldset class="ui-corner-all" >
                <legend align="left">Asistencia de Externos</legend> 
                <table id="t_evntoPS_alumno" class="display" cellspacing="0" width="100%">
                    <thead>
                        <tr>
                           
                            <th>Nombre</th>
                            <th>DNI</th>
                            <th>Institucion</th>
                            <th>Cargo</th>
                            <th>Estado de Pago</th>
                             <th>Asistencia</th>
                        </tr>
                    </thead>

                    <tfoot>
                        <tr>
                           
                            <th>Nombre</th>
                            <th>DNI</th>
                            <th>Institucion</th>
                            <th>Cargo</th>
                            <th>Estado de Pago</th>
                              <th>Asistencia</th>
                        </tr>
                    </tfoot>
                    <tbody>
                        <?php // echo "<div align='left'><pre>";print_r($row); ?>
                        <?php foreach ($row as $key => $value)
                        {  $asis=$value['Asistencia'];
                            if($asis=='1'){ $checked="checked";}else{ $checked="";}
                            echo "<tr>";
                            echo "<td>".$value['Nombre']."</td>";
                            echo "<td>".$value['DNI']."</td>";
                            echo "<td>".$value['nombre_institucion']."</td>";
                            echo "<td>".$value['cargo']."</td>";
                            echo "<td align='center'>".$value['costo']."</td>";
                            echo "<td align='center'><input type='hidden' name='id_externo[]' value='".$value['id_externos']."'><input type='checkbox' name='chek[".$value['id_externos']."]' value='1' $checked>  </td>";
                            echo"</tr>";
                        }?>
                    <tbody>
                </table>
                <input type="submit" value="Guardar" name="guardar" >
            </fieldset> 
        </div>
    </div>
</form>
</div>