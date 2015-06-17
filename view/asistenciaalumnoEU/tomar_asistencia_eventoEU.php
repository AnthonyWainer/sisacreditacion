<script>
    $(function() {
        $("#tabs").tabs();
        $('#t_evntoEU_alumno1').DataTable({
        "paging":   true,
        "sPaginationType": "full_numbers",
        "bJQueryUI":true
    } );
    $('#t_evntoEU_alumno2').DataTable({
        "paging":   true,
        "sPaginationType": "full_numbers",
        "bJQueryUI":true
    } );
       $('#t_evntoEU_alumno3').DataTable({
        "paging":   true,
        "sPaginationType": "full_numbers",
        "bJQueryUI":true
    } );
    
        $("#seleccionado").change(function() {
         var seleccionado = $(this).val();
         idevento=$("#idevento").val();
         $.post('index.php', 'controller=asistenciaalumnoEU&action=asistenciaEU&seleccionado='+seleccionado+'&idevento='+idevento, function(data) {
            console.log(data);
            $("#asistencia_segun_tipoEU").empty().append(data);
        });

        });
        
      $("#guardar1").click(function() {
            ser = $("#frm1").serialize();
            $("#guardoc").fadeIn(500);
            $.post('index.php', ser, function(data) {});
    $("#guardoc").fadeOut(500);
        });
         $("#guardar2").click(function() {
            ser = $("#frm2").serialize();
            $("#guaralum").fadeIn(500);
            $.post('index.php', ser, function(data) {});
    $("#guaralum").fadeOut(500);
        });
     $("#guardar3").click(function() {
            ser = $("#frm3").serialize();
            $("#guaraext").fadeIn(500);
            $.post('index.php', ser, function(data) {});
    $("#guaraext").fadeOut(500);
        });
    });
</script>
<a href="index.php?controller=asistenciaalumnoEU" class="btn btn-primary glyphicon glyphicon-backward">ATRAS</a>
<input type="hidden" value="<?php echo $idevento; ?>">
Evento :  <?php echo utf8_encode($val['tema']); ?> 
<div id="tabs">
    <ul>
        <li><a href="#tabs-4">DOCENTES</a></li>
        <li><a  href="#tabs-5">ALUMNOS</a></li>
        <li><a  href="#tabs-6">OTROS</a></li>
    </ul>
    <div id="tabs-4" align='center'>
   <div class="div_container">
    <form id="frm1" action="index.php" method="POST">
    <input type="hidden" name="controller" value="asistenciaalumnoEU" />
    <input type="hidden" name="action" value="save_asistencias_docentes" />
     <input type="hidden" name="idevento" value="<?php echo $idevento_sub;?>" />
    <div class="contFrm ui-corner-all" style="background: #fff;">
        <div class="contenido" style="margin:0 auto; width: 100%; ">
            <fieldset class="ui-corner-all" >
                <legend align="left">Asistencia Profesor</legend> 
                <table id="t_evntoEU_alumno1" class="display" cellspacing="0" width="100%">
                    <thead>
                        <tr>
                           
                            <th>NOMBRE</th>
                            <th>CARGO</th>
                             <th>ASISTENCIA</th>
                        </tr>
                    </thead>

                    <tfoot>
                        <tr>
                           
                            <th>NOMBRE</th>
                            <th>CARGO</th>
                             <th>ASISTENCIA</th>
                        </tr>
                    </tfoot>
                    <tbody>
                        <?php //  echo "<div align='left'><pre>";print_r($row); ?>
                        <?php foreach ($lis_doce as $key => $value)
                        {$asis=$value['asistencia_docente'];
                            if($asis=='1'){ $checked="checked";}else{ $checked="";}
                            echo "<tr>";
                            echo "<td>".$value['Nombre']."<input type='hidden' name='nombre[]' value='".$value['Nombre']."'></td>";
                            echo "<td>".$value['cargo']."<input type='hidden' name='cargo[]' value='".$value['cargo']."'></td>";
                            echo "<td align='center'><input type='hidden' name='CodigoProfesor[]' value='".$value['CodigoProfesor']."'><input type='checkbox' name='chek[".$value['CodigoProfesor']."]' value='1' $checked > </td>";
                    
                            echo"</tr>";
                        }?>
                    <tbody>
                </table>
                <span id="guardoc" style="display: none">GUARDANDO...</span>
                  <input type="button" name="guardar1" id="guardar1" value="GUARDAR">
            </fieldset> 
        </div>
    </div>
</form>
</div>     
    </div>
    <div id="tabs-5" align='center'>
        <div class="div_container">
   <form id="frm2" action="index.php" method="POST">
    <input type="hidden" name="controller" value="asistenciaalumnoEU" />
    <input type="hidden" name="action" value="save_asistencias_alumnos" />
     <input type="hidden" name="idevento" value="<?php echo $idevento_sub;?>" />
    <div class="contFrm ui-corner-all" style="background: #fff;">
        <div class="contenido" style="margin:0 auto; width: 100%; ">
            <fieldset class="ui-corner-all" >
                <legend align="left">Asistencia Alumnos</legend> 
                <table id="t_evntoEU_alumno2" class="display" cellspacing="0" width="100%">
                    <thead>
                        <tr>
                           
                            <th>NOMBRE</th>
                            <th>CARGO</th>
                             <th>ASISTENCIA</th>
                        </tr>
                    </thead>

                    <tfoot>
                        <tr>
                           
                            <th>NOMBRE</th>
                            <th>CARGO</th>
                             <th>ASISTENCIA</th>
                        </tr>
                    </tfoot>
                    <tbody>
                        <?php //  echo "<div align='left'><pre>";print_r($row); ?>
                             <?php foreach ($lis_alum as $key => $value)
                        {$asis=$value['asistencia_alumno'];
                            if($asis=='1'){ $checked="checked";}else{ $checked="";}
                            echo "<tr>";
                            echo "<td>".$value['Nombre']."<input type='hidden' name='nombre[]' value='".$value['Nombre']."'></td>";
                            echo "<td>".$value['cargo']."<input type='hidden' name='cargo[]' value='".$value['cargo']."'></td>";
                            echo "<td align='center'><input type='hidden' name='CodigoAlumno[]' value='".$value['CodigoAlumno']."'><input type='checkbox' name='chek[".$value['CodigoAlumno']."]' value='1' $checked>  </td>";
                            echo"</tr>";
                        }?>
                    <tbody>
                </table>
                <span id="guaralum" style="display: none">GUARDANDO...</span>
                 <input type="button" class="btn btn-info" name="guardar2" id="guardar2" value="GUARDAR">
            </fieldset> 
        </div>
    </div>
</form>
</div>
    </div>
    <div id="tabs-6" align='center'>
     <div class="div_container">
   <form id="frm3" action="index.php" method="POST">
    <input type="hidden" name="controller" value="asistenciaalumnoEU" />
    <input type="hidden" name="action" value="save_asistencias_externos" />
    <input type="hidden" name="idevento" value="<?php echo $idevento_sub;?>" />
    <div class="contFrm ui-corner-all" style="background: #fff;">
        <div class="contenido" style="margin:0 auto; width: 100%; ">
            <fieldset class="ui-corner-all" >
                <legend align="left">Asistencia de Otros</legend> 
                <table id="t_evntoEU_alumno3" class="display" cellspacing="0" width="100%">
                    <thead>
                        <tr>
                            <th>NOMBRE</th>
                            <th>INSTITUCION</th>
                            <th>CARGO</th>
                             <th>ASISTENCIA</th>
                        </tr>
                    </thead>

                    <tfoot>
                        <tr>
                             <th>NOMBRE</th>
                            <th>INSTITUCION</th>
                            <th>CARGO</th>
                             <th>ASISTENCIA</th>
                        </tr>
                    </tfoot>
                    <tbody>
                        <?php // echo "<div align='left'><pre>";print_r($row); ?>
                         <?php foreach ($lis_exter as $key => $value)
                        {  $asis=$value['asistencia_externo'];
                            if($asis=='1'){ $checked="checked";}else{ $checked="";}
                            echo "<tr>";
                            echo "<td>".$value['Nombre']."<input type='hidden' name='nombre[]' value='".$value['Nombre']."'></td>";
                            echo "<td>".$value['institucion']."<input type='hidden' name='institucion[]' value='".$value['institucion']."'></td>";
                            echo "<td>".$value['descripcion']."<input type='hidden' name='descripcion[]' value='".$value['descripcion']."'></td>";
                            echo "<td align='center'><input type='hidden' name='id_externo[]' value='".$value['id_externos']."'><input type='checkbox' name='chek[".$value['id_externos']."]' value='1' $checked>  </td>";
                            echo"</tr>";
                        }?>
                    <tbody>
                </table>
                <span id="guaraext" style="display: none">GUARDANDO...</span>
                <button type="button" name="guardar3" class="btn btn-info" id="guardar3" value="GUARDAR">GUARDAR</button>
            </fieldset> 
        </div>
    </div>
</form>
</div>
    </div>
</div>