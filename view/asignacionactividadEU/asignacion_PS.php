<script>
    $(function() {
        $("#tabs").tabs();
        $('#profesores').DataTable({
            "paging": false,
            "sPaginationType": "full_numbers",
            "bJQueryUI": true,
            "language": {
                "lengthMenu": "filas _MENU_ ",
                "zeroRecords": "No hay registros que coincidan con la busqueda",
                "info": "Mostrando _PAGE_ de _PAGES_ entradas",
                "infoEmpty": "No records available",
                "infoFiltered": "(filtered from _MAX_ total records)"
            }
        });

        $('#alumnos').DataTable({
//            "scrollY": "200px",
            "paging": false,
            "sPaginationType": "full_numbers",
            "bJQueryUI": true,
            "language": {
                "lengthMenu": "filas _MENU_ ",
                "zeroRecords": "No hay registros que coincidan con la busqueda",
                "info": "Mostrando _PAGE_ de _PAGES_ entradas",
                "infoEmpty": "No records available",
                "infoFiltered": "(filtered from _MAX_ total records)"
            }
        });
        $('#otros').DataTable({
//            "scrollY": "200px",
            "paging": false,
            "sPaginationType": "full_numbers",
            "bJQueryUI": true,
            "language": {
                "lengthMenu": "filas _MENU_ ",
                "zeroRecords": "No hay registros que coincidan con la busqueda",
                "info": "Mostrando _PAGE_ de _PAGES_ entradas",
                "infoEmpty": "No records available",
                "infoFiltered": "(filtered from _MAX_ total records)"
            }
        });
        $("#dialog").dialog({
            autoOpen: false,
            width: 400,
            buttons: [
                {
                    text: "Ok",
                    click: function() {
                        var checkboxValues = new Array();
                        //recorremos todos los checkbox seleccionados con .each
                        $('input[name="orderBox[]"]:checked').each(function() {
                            //$(this).val() es el valor del checkbox correspondiente
                            cur = $(this).attr("cur");
                            //	checkboxValues.push(cur+$(this).val());
                            checkboxValues.push("'" + cur + "'");
                        });
                        cod_profesor = $('#cod_profesor').val();
                        $("#cursos_a_guardar_" + cod_profesor).val(checkboxValues);
                        $(this).dialog("close");
                    }
                },
                {
                    text: "Cancel",
                    click: function() {
                        $(this).dialog("close");
                    }
                }
            ]
        });


        $(".dialog-link").click(function() {
            idevento = $("#idevento").val();
            curso_profesor = $(this).attr("curso_profesor");
            $("#dialog").html('Cargando....');
            $.post('index.php', 'controller=asignacionPS&action=lista_cursosxcursos&curso_profesor=' + curso_profesor+'&idevento='+idevento, function(data) {
                console.log(data);
                $("#dialog").empty().append(data);
            });
            $("#dialog").dialog("open");
        });
        $(".guardar_alumnos_PS").click(function() {

            idevento = $("#idevento").val();
            cod_prof = $(this).attr("profesor");
            cheket = $("#asignado" + cod_prof + ":checked").val();
            if (cheket == '1') {
                cheket = 1;
            } else {
                cheket = 0;
            }
            cargo = $("#cargo_" + cod_prof).val();
            costo = $("#costo_" + cod_prof).val();
            curso = $("#cursos_a_guardar_" + cod_prof).val();
//        alert(cod_prof+','+cargo+','+costo+','+curso);
            $("#msj_guardado_"+cod_prof).html('Guardando...');
            $.post('index.php', 'controller=asignacionPS&action=save_profesor_alumno&cod_prof=' + cod_prof + '&cargo=' + cargo + '&costo=' + costo + '&curso=' + curso + '&idevento=' + idevento + '&check=' + cheket, function(data) {
            });
            $.post('index.php', 'controller=asignacionPS&action=listado_alumnos_ps1&idevento='
                    + idevento + '&evento=' + evento, function(data) {
                        console.log(data);
                        $("#tabs-5").empty().append(data);
                        $("#msj_guardado_"+cod_prof).html('');
                    });

        });
        $("#agregarexterno").click(function() {
            $("#reg_externo").css("display", "");
        });

        var t = $('#agregar_exter').DataTable({
            "paging": true,
            "sPaginationType": "full_numbers",
            "bJQueryUI": true,
            "language": {
                "lengthMenu": "filas _MENU_ ",
                "zeroRecords": "No hay registros que coincidan con la busqueda",
                "info": "Mostrando _PAGE_ de _PAGES_ entradas",
                "infoEmpty": "No records available",
                "infoFiltered": "(filtered from _MAX_ total records)"
            }
        });
        $("#addRow1").click(function() {
            t.row.add([
                'Nuevo ID', '<input type="text" name="nombre_E[]" style = "width: 100%">',
                '<input type="text" name="apellido_E[]"  style = "width: 100%">',
                '<input type="text" name="direccion_E[]" style = "width: 100%">',
                '<input type="text" name="telefono_E[]" style = "width: 100%">',
                '<input type="text" name="dni_E[]" style = "width: 100%">',
                '<input type="text" name="institucion_E[]" style = "width: 100%">'

            ]).draw();
        });
        $("#reg_externo").css("display", "none");

        $(".altualizar_externo").click(function() {
            idevento = $("#idevento").val();
            id_externo = $(this).attr("externo");
            cheket = $("#asignado" + id_externo + ":checked").val();
            if (cheket == '1') {
                cheket = 1;
            } else {
                cheket = 0;
            }
            cost = $("#costo_" + id_externo).val();
            cargon = $("#cargo_" + id_externo).val();
            $("#externo_acct_"+id_externo).fadeIn(30);
            $.post('index.php', 'controller=asignacionPS&action=save_externo&idevento=' + idevento + '&id_externo=' + id_externo + '&costo=' + cost + '&cargo=' + cargon + '&check=' + cheket, function(data) {
            });
            $("#externo_acct_"+id_externo).fadeOut(150);
        });

        $("#acc").click(function() {
            idevento = $("#idevento").val();
            str = $('#frm_alumno').serialize();
            $("#textactualum").fadeIn(30);
            $.post('index.php', 'controller=asignacionactividadEU&action=actualizar_alumno&' + str + '&idevento=' + idevento, function(data) {

            });
            $("#textactualum").fadeOut(150);
        });

        $("#guardar_externos").click(function() {
            idevento = $("#idevento").val();
            ser = $("#form_externo").serialize();
            $.post('index.php', 'controller=asignacionPS&action=agregar_externo&' + ser + '&idevento=' + idevento, function(data) {
            });
            $.post('index.php', 'controller=asignacionPS&action=listado_exter_ps', function(data) {
                console.log(data);
                $("#externo_lis").empty().append(data);
            });
        });
        
        $('#actualizar_docente').click(function(){
            idevento = $("#idevento").val();
            seria=$('#formuloairo').serialize();
            $("#textdocente").fadeIn(100);
            $.post('index.php', 'controller=asignacionactividadEU&action=save_profesor&'+seria+'&idevento='+idevento, function(data) {});
            $("#textdocente").fadeOut(150);
        });
    });
    

</script>
<div id="dialog" title="Lista De Cursos">
</div>
<input type="hidden" id="idevento" value="<?php echo $idevento; ?>">
<a href="index.php?controller=asignacionPS" class="button">ATRAS</a>
<input type="hidden" value="<?php echo $evento; ?>">
Evento :<?php echo $evento; ?>
<div id="tabs">
    <ul>
        <li><a href="#tabs-4">Docentes</a></li>
        <li><a id="cargarAlumno" href="#tabs-5">Alumnos</a></li>
        <li><a id="cargarOtros" href="#tabs-6">Otros</a></li>
    </ul>


    <div id="tabs-4" align='center'>
        <?php // echo "<div align='left'><pre>";print_r($profesores);echo "</div>";?>
        <div  style="overflow-y: auto; max-height: 510px; max-width: 100%"><span style="display:none" id="textdocente">ACTUALIZANDO...</span>
            <input type="button" name="actualizar_docente" id="actualizar_docente" value="Actualizar Docente">
            <form id="formuloairo">
            <table id="profesores" class="display" cellspacing="0" width="100%">
                <thead>
                    <tr>
                        <th>CodigoProfesor</th>
                        <th>NombreProfesor</th>
                        <th>Cargo</th>
                    </tr>
                </thead>

                <tfoot>
                    <tr>
                        <th>CodigoProfesor</th>
                        <th>NombreProfesor</th>
                        <th>Cargo</th>
                    </tr>
                </tfoot>
                <tbody>
                    <?php foreach ($profesores as $key => $value) {
                        if ($value['asignado'] == 'yes') {
                            $chekP = 'checked';
                        } else {
                            $chekP = '';
                        } ?>
                        <tr>
                            <td><?php echo $value['CodigoProfesor']; ?><input type="hidden" name="cod_profe[]" value="<?php echo $value['CodigoProfesor']; ?>" id="cod_profe"></td>
                            <td><?php echo utf8_encode($value['Docente']); ?></td>
                            <td><?php
                            echo $cargo[$value['CodigoProfesor']];
//                            echo '<select class="form-control" style="width: 100%;" id="cargo_' . $value['CodigoProfesor'] . '">';
//                            echo $cargo;
//                            echo "</select>";
                            ?></td>
                        </tr>

<?php } ?>


                </tbody>
            </table>
            </form>
        </div>
    </div>


    <div id="tabs-5" align='center'>

        <form id="frm_alumno" ><span style="display: none" id="textactualum">ACTUALIZANDO...</span>
            <input type="button" value="ACTUALIZAR ALUMNOS" id="acc">
            <div  style="overflow-y: auto; max-height: 510px; max-width: 100%">
                <table id="alumnos" class="display" cellspacing="0" width="100%">
                    <thead>

                        <tr>
                            <th>CodigoAlumno</th>
                            <th>NombreAlumnor</th>
                            <th>Cargo</th>
                        </tr>
                    </thead>

                    <tfoot>
                        <tr>
                            <th>CodigoAlumno</th>
                            <th>NombreAlumno</th>
                            <th>Cargo</th>
                        </tr>
                    </tfoot>
                    <tbody> 
                                <?php  foreach ($alumnosps as $oky => $val) { ?>
                            <tr>
                                <td><?php echo $val['CodigoAlumno']; ?><input type="hidden" name="CodigoAlumno[]" value="<?php echo $val['CodigoAlumno']; ?>"></td>
                                <td><?php echo utf8_encode($val['Nombre']); ?></td>
                                <td><?php
                                echo $cargoA[$val['CodigoAlumno']];
//                                echo '<select class="form-control" style="width: 100%;" id="cargo_A[' . $val['CodigoAlumno'] . ']" name="cargo_A[' . $val['CodigoAlumno'] . ']" >';
//                                echo $cargo;
//                                echo"</select>"
                                ?></td>
                            </tr>
<?php } ?>




                    </tbody>
                </table>
            </div>
        </form>
    </div>

    <div id="tabs-6" align='center' display="none">
        <div id="externo_lis">
            <div  style="overflow-y: auto; max-height: 510px; max-width: 100%">
                <table id="otros" class="display" cellspacing="0" width="100%">
                    <thead>
                        <tr>
                            <th>Codigo Externo</th>
                            <th>Nombre Externo</th>
                            <th>Cargo</th>
                            <th>Chek</th>
                            <th>Guardar</th>
                        </tr>
                    </thead>

                    <tfoot>
                        <tr>
                            <th>Codigo Externo</th>
                            <th>Nombre Externo</th>
                            <th>Cargo</th>
                            <th>Guardar</th>
                            <th>Actualizar</th>
                        </tr>
                    </tfoot>
                    <tbody>
                                <?php foreach ($externos as $key => $value) {
                                    if ($value['asignado'] == 'yes') {
                                        $chekP = 'checked';
                                    } else {
                                        $chekP = '';
                                    } ?>
                            <tr>
                                <td><?php echo $value['id_externos']; ?></td>
                                <td><?php echo utf8_encode($value['externo']); ?></td>
                                <td><?php
                                echo $cargoE[$value['id_externos']];
//                                    echo '<select class="form-control" style="width: 100%;" id="cargo_' . $value['id_externos'] . '">';
//                                    echo $cargo;
//                                    echo "</select>";
                                    ?></td>
                                <td><input type="checkbox" id="asignado<?php echo $value['id_externos']; ?>" <?php echo $chekP; ?> value="1"></td>
                                <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a  externo='<?php echo $value['id_externos']; ?>' style="cursor:pointer;"class="altualizar_externo glyphicon glyphicon-floppy-disk"></a><br> <span id="externo_acct_<?php echo $value['id_externos']; ?>" style="display: none" > Guardando...</span></td>
                            </tr>

<?php } ?>

                    </tbody>
                </table>
            </div>

            <br>
            <input type="button" value="AGREGAR EXTERNO" id="agregarexterno">&nbsp;&nbsp;&nbsp;<br><br><br>   
            <fieldset class="ui-corner-all" id="reg_externo" >
                <legend id="legendsub_evento" align="left">REGISTRO DE EXTERNO</legend>
                <button type="button" id="addRow1" class="btn btn-info"><img alt="" src="images/add.png" />Agregar</button>
                <br>  
                <form id="form_externo">
                    <table id="agregar_exter" class="display" cellspacing="0" width="100%">
                        <thead>
                            <tr>
                                <th>Id Externo</th>
                                <th>Nombre</th>
                                <th>Apellido</th>
                                <th>Dirección</th>
                                <th>Telefono</th>
                                <th>DNI</th>
                                <th>Institucion</th>


                            </tr>
                        </thead>

                        <tfoot>
                            <tr>
                                <th>Id Externo</th>
                                <th>Nombre</th>
                                <th>Apellido</th>
                                <th>Dirección</th>
                                <th>Telefono</th>
                                <th>DNI</th>
                                <th>Institucion</th>



                            </tr>
                        </tfoot>
                        <tbody>
                        <tbody>
                    </table>

                    <br>
                    <input type="button" name="guardar_externos" id="guardar_externos" value="GUARDAR">
                </form>
            </fieldset>
        </div>
    </div>
</div>




