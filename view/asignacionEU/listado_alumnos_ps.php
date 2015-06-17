<script>
    
$(function(){
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
        $("#acc").click(function() {
            idevento = $("#idevento").val();
            str=$('#frm_alumno').serialize();
            $("#texlumno").fadeIn(100);
             $.post('index.php', 'controller=asignacionEU&action=actualizar_alumno&' + str+'&idevento='+idevento , function(data) {

            });
            $("#texlumno").fadeOut(150);
        });
});
</script>asd
<form id="frm_alumno" ><span style="display: none" id="texlumno">ACTUALIZANDO....</span>
    <input type="button" value="ACTUALIZAR ALUMNOS" id="acc">
    <div  style="overflow-y: auto; max-height: 510px; max-width: 100%">
        <table id="alumnos" class="display" cellspacing="0" width="95%">
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
                <?php foreach ($alumnosps as $oky => $val) { ?>
                    <tr>
                        <td><?php echo $val['CodigoAlumno']; ?><input type="hidden" name="CodigoAlumno[]" value="<?php echo $val['CodigoAlumno']; ?>"></td>
                        <td><?php echo utf8_encode($val['Nombre']); ?></td>
                        <td><?php
                        echo $cargoA[$val['CodigoAlumno']];
//                            echo '<select class="form-control" style="width: 100%;" id="cargo_A[' . $val['CodigoAlumno'] . ']" name="cargo_A[' . $val['CodigoAlumno'] . ']" >';
//                            echo $cargo;
//                            echo"</select>"
                            ?></td>
                    </tr>
                <?php } ?>




            </tbody>
        </table>
    </div>
</form>