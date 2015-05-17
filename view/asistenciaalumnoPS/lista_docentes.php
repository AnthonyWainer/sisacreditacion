<script>
    $(function() {
  
     $('#t_evnto_alumno').DataTable({
        "paging":   true,
        "sPaginationType": "full_numbers",
        "bJQueryUI":true
    } );
    });
</script>
<div class="div_container">
    <form id="frm" action="index.php" method="POST">
    <input type="hidden" name="controller" value="asistenciaalumnoPS" />
    <input type="hidden" name="action" value="save_asistencias_docentes" />
    <div class="contFrm ui-corner-all" style="background: #fff;">
        <div class="contenido" style="margin:0 auto; width: 100%; ">
            <fieldset class="ui-corner-all" >
                <legend align="left">Asistencia Profesor</legend> 
                <table id="t_evntoPS_alumno" class="display" cellspacing="0" width="100%">
                    <thead>
                        <tr>
                           
                            <th>Nombre</th>
                            <th>Cargo</th>
                            <th>Estado de Pago</th>
                             <th>Asistencia</th>
                        </tr>
                    </thead>

                    <tfoot>
                        <tr>
                           
                            <th>Nombre</th>
                            <th>Cargo</th>
                            <th>Estado de Pago</th>
                              <th>Asistencia</th>
                        </tr>
                    </tfoot>
                    <tbody>
                        <?php //  echo "<div align='left'><pre>";print_r($row); ?>
                        <?php foreach ($row as $key => $value)
                        {
                            echo "<tr>";
                            echo "<td>".$value['Nombre']."</td>";
                            echo "<td>".$value['cargo']."</td>";
                            echo "<td align='center'>".$value['costo']."</td>";
                            echo "<td align='center'><input type='hidden' name='CodigoProfesor[]' value='".$value['CodigoProfesor']."'><input type='checkbox' name='chek[".$value['CodigoProfesor']."]' value='1'  </td>";
                    
                            echo"</tr>";
                        }?>
                    <tbody>
                </table>
                <input type="submit" value="Guardar" name="guardar">
            </fieldset> 
        </div>
    </div>
</form>
</div>