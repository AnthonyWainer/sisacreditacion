
<script>
    $(function () {
        $("#tabs").tabs();
        $("#addRow").css("display", "none");
        $("#legendsub_evento").css("display", "none");
        $("#addRowSA").css("display", "none");
        $("#legendpre_actividad").css("display", "none");
        $("#guardar_sub_ev").css("display", "none");
        $("#guardar_pre_act").css("display", "none");
        
        
         ideven=$("#ideven").val();
         $.post('index.php','controller=evento_extension_universitaria&action=pdf_eu&idevento='+ideven,function(data){
        });
        
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
         $('#pre_acti').DataTable({
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
         $('#sub_acti').DataTable({
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
        <li><a href="#tabs-2">CRONOGRAMA</a></li>
        <li><a href="#tabs-3">PRE ACTIVIDADES</a></li>
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
            <table id="sub_acti" class="display" cellspacing="0" width="100%">
            <thead>
                <tr>
                    <th>NOMBRE CRONOGRAMA</th>
                    <th>FECHA</th>
                    <th>HORA</th>
                    <th>LUGAR</th>
                </tr>
            </thead>

            <tfoot>
                <tr>
                    <th>NOMBRE CRONOGRAMA</th>
                    <th>FECHA</th>
                    <th>HORA</th>
                    <th>LUGAR</th>
                </tr>
            </tfoot>
            <tbody>
                <?php foreach ($sub_eventos as $key => $value) { ?>
                    <tr>
                        <td><?php echo utf8_encode($value['tema']); ?></td>
                        <td><?php echo $value['fecha']; ?></td>
                        <td><?php echo $value['hora_evento']; ?></td>
                        <td><?php echo $value['lugar']; ?></td>
                    </tr>

                <?php } ?>
            </tbody>
        </table>
        </div>
    </div>
       <div id="tabs-3" align='center'>

            <table id="pre_acti" class="display" cellspacing="0" width="100%">
            <thead>
                <tr>
                    <th>TEMA DEL EVENTO</th>
                    <th>NOMBRE PRE ACTIVIDAD</th>
                    <th>DESCRIPCION</th>
                    <th>FECHA INICIO</th>
                    <th>FECHA TERMINO</th>
                </tr>
            </thead>

            <tfoot>
                <tr>
                    <th>TEMA DEL EVENTO</th>
                    <th>NOMBRE PRE ACTIVIDAD</th>
                    <th>DESCRIPCION</th>
                    <th>FECHA INICIO</th>
                    <th>FECHA TERMINO</th>
                </tr>
            </tfoot>
            <tbody>
                <?php foreach ($pre_actividades as $key => $value) { ?>
                    <tr>
                        <td><?php echo utf8_encode($value['tema']); ?></td>
                        <td><?php echo utf8_encode($value['pre_actividad']); ?></td>
                        <td><?php echo utf8_encode($value['descripcion']); ?></td>
                        <td><?php echo $value['fecha_inicio']; ?></td>
                        <td><?php echo $value['fecha_termino']; ?></td>
                    </tr>

                <?php } ?>
            </tbody>
        </table>
       </div>
       <div>
    <button type="button" class="">
    <a href="index.php?controller=evento_extension_universitaria" class="btn btn-primary active" role="button"><img alt="" src="images/arrow_left.png" />REGRESAR</a>
    <a style="color: #ffffff; " class="btn btn-primary btn-sm" href="eventos.pdf" target="_blanc">OBTENER PDF</a>
   
    </button>
    </div>
        
</div>