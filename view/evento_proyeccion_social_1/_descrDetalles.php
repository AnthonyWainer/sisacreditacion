<script>
    $(function () {
        $("#tabs").tabs();
        $("#addRow").css("display", "none");
        $("#legendsub_evento").css("display", "none");
        $("#addRowSA").css("display", "none");
        $("#legendpre_actividad").css("display", "none");
        $("#guardar_sub_ev").css("display", "none");
        $("#guardar_pre_act").css("display", "none");
        
        
        
        $('#docentes').DataTable({
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
        
         $('#alum').DataTable({
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
       
       $('#exter').DataTable({
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
    
       });
     
        
</script>



<div id="tabs">
    <ul>
        <li><a href="#tabs-1">DATOS GENERALES</a></li>
        <li><a href="#tabs-2">SUB EVENTOS</a></li>
        <li><a href="#tabs-3">PRE ACTIVIDADES</a></li>
        <li><a href="#tabs-4">Docentes</a></li>
        <li><a href="#tabs-5">Alumnos</a></li>
        <li><a href="#tabs-6">Externos</a></li>
    </ul>
    <div id="tabs-1" align='center'>

        <table class="table table-hover" style="width: 80%">
            <tr class="success">
                <td >TEMA DEL EVENTO:</td>
                <td><?php echo $obj['tema']; ?></td>
            </tr>

            <tr class="success">
                <td >TIPO DEL EVENTO:</td>
                <td><?php echo utf8_encode($obj_tipo['descripcion']); ?></td>
            </tr>

            <tr class="success">
                <td >FECHA INICIO:</td>
                <td><?php echo $obj['fecha']; ?></td>
            </tr>
            <tr class="success">
                <td >FECHA TERMINO:</td>
                <td><?php echo $obj['fecha_termino']; ?></td>
            </tr>

            <tr class="success">
                <td >LUGAR:</td>
                <td><?php echo $obj['lugar']; ?></td>
            </tr>

            <tr class="success">
                <td >DEPARTAMENTO:</td>
                <td><?php echo $uvi['DEPARTAM']; ?></td>
            </tr>

            <tr class="success">
                <td >PROVINCIA:</td>
                <td><?php echo $uvi['PROVINCIA']; ?></td>
            </tr>

            <tr class="success">
                <td >DISTRITO:</td>
                <td><?php echo $uvi['DISTRITO']; ?></td>
            </tr>

        </table>
    </div>


    <div id="tabs-2" align='center'>

        <div id="evento_sub_eventos">
            <?php echo $sub_eventos; ?>
        </div>
    </div>

    <div id="tabs-3" align='center'>

        <div id="pre_actividades">
            <?php echo $pre_actividades; ?>
        </div>
    </div>


    <div id="tabs-4" align='center'>
        <?php // echo "<pre>";print_r($profesores);?>
        <table id="docentes" class="display" cellspacing="0" width="100%">
            <thead>
                <tr>
                    <th>CÓDIGO</th>
                    <th>NOMBRES</th>
                    <th>CARGO</th>
                    <th>ESTADO DE ASITENCIA</th>
                    <th>TEMA DEL EVENTO</th>
                    <th>COSTO</th>
                </tr>
            </thead>

            <tfoot>
                <tr>
                    <th>CÓDIGO</th>
                    <th>NOMBRES</th>>
                    <th>CARGO</th>
                    <th>ESTADO DE ASITENCIA</th>
                    <th>TEMA DEL EVENTO</th>
                    <th>COSTO</th>
                </tr>
            </tfoot>
            <tbody>
                <?php foreach ($profesores as $key => $value) { ?>
                    <tr>
                        <td><?php echo $value['CodigoProfesor']; ?></td>
                        <td><?php echo utf8_encode($value['ApellidoPaterno']." ".$value['ApellidoMaterno']).", ".utf8_encode($value['NombreProfesor']); ?></td>
                        <td><?php echo utf8_encode($value['descripcion']); ?></td>
                        <td><?php echo $value['asistencia_docente']; ?></td>
                        <td><?php echo utf8_encode($value['tema']); ?></td>
                        <td><?php echo "s/. ".$value['costo']; ?></td>
                    </tr>

                <?php } ?>
            </tbody>
        </table>
    </div>


    <div id="tabs-5" align='center'>
        <?php // echo "<pre>"; print_r($alumnos); ?>
        <table id="alum" class="display" cellspacing="0" width="100%">
            <thead>
                <tr>
                    <th>CÓDIGO</th>
                    <th>NOMBRES</th>
                    <th>CARGO</th>
                    <th>ESTADO DE ASISTENCIA</th>
                    <th>TEMA DEL EVENTO</th> 
                    <th>COSTO</th>
                </tr>
            </thead>

            <tfoot>
                <tr>
                    <th>CÓDIGO</th>
                    <th>NOMBRES</th>
                    <th>CARGO</th>
                    <th>ESTADO DE ASISTENCIA</th>
                    <th>TEMA DEL EVENTO</th> 
                    <th>COSTO</th>
                </tr>
            </tfoot>
            <tbody>
            <?php foreach ($alumnos as $key => $value) { ?>
                    <tr>
                        <td><?php echo $value['CodigoAlumno']; ?></td>
                        <td><?php echo utf8_encode($value['ApellidoMaterno']." ".$value['ApellidoPaterno']).", ".utf8_encode($value['NombreAlumno']); ?></td>
                        <td><?php echo utf8_encode($value['descripcion']); ?></td>
                        <td><?php echo $value['asistencia_alumno']; ?></td>
                        <td><?php echo utf8_encode($value['tema']); ?></td>
                        <td><?php echo "s/. ".$value['costo']; ?></td>
                    </tr>
            <?php } ?>
            </tbody>
        </table>
    </div>

    <div id="tabs-6" align='center'>
    <?php // echo "<pre>"; print_r($externos); ?>
        <table id="exter" class="display" cellspacing="0" width="100%">
            <thead>
                <tr>
                    <th>CÓDIGO</th>
                    <th>NOMBRES</th>
                    <th>CARGO</th>
                    <th>ESTADO DE ASISTENCIA</th>
                    <th>TEMA DEL EVENTO</th> 
                    <th>COSTO</th>
                </tr>
            </thead>

            <tfoot>
                <tr>
                    <th>CÓDIGO</th>
                    <th>NOMBRES</th>
                    <th>CARGO</th>
                    <th>ESTADO DE ASISTENCIA</th>
                    <th>TEMA DEL EVENTO</th> 
                    <th>COSTO</th>
                </tr>
            </tfoot>
            <tbody>
            <?php foreach ($externos as $key => $value) { ?>
                    <tr>
                        <td><?php echo $value['id_externos']; ?></td>
                        <td><?php echo utf8_encode($value['apellidos']).", ".utf8_encode($value['nombre']); ?></td>
                        <td><?php echo utf8_encode($value['descripcion']); ?></td>
                        <td><?php echo $value['asistencia_externo']; ?></td>
                        <td><?php echo utf8_encode($value['tema']); ?></td>
                        <td><?php echo "s/. ".$value['costo']; ?></td>
                    </tr>

<?php } ?>
            </tbody>
        </table>
    </div>
    
    <div>
    <button type="button" class="">
    <a href="index.php?controller=evento_extension_universitaria" class="btn btn-primary active" role="button"><img alt="" src="images/arrow_left.png" />REGRESAR</a>
    <a href="" class="btn btn-default active" role="button">OBTENER PDF</a>
    </button>
    </div>
    
    </div>




