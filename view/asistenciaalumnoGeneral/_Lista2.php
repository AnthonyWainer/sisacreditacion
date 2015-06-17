<script>
    $(function(){
        $('#lista_asitencia_alumno').DataTable({
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
        $('#save').click(function(){
            idevento=$('#idevento').val();
            seria=$('#frm').serialize();
            $.post('index.php', 'controller=asistenciaalumnoGeneral&action=save&'+seria+'&idevento=' + idevento, function(data) {
            });
        });
    });
</script>
<div class="col-lg-12">
    <div id="lista">
        
            <div class="contFrm ui-corner-all" style="background: #fff;">

                <fieldset class="ui-corner-all" >
                    <legend><label>LISTA DE ALUMNOS EN EL EVENTO :<?php echo " ".$_REQUEST['evento']?></label> <label id="evento"></label></legend>  
                    <div id="lista_alumnos">
                        <input type="hidden" name="idevento" id="idevento" value="<?php echo $idevento ?>">
                        <div  style="overflow-y: auto; max-height: 400px; max-width: 100%">
                            <form id="frm">
<table id="lista_asitencia_alumno" class="display" cellspacing="0" width="100%">
                <thead>
                    <tr>
                        <th>CODIGO</th>
                        <th>NOMBRE</th>
                        <th>APELLIDOS</th>
                        <th>DOCUMENTOS</th>
                        <th>COD. ALUMNO SIRA</th>
                        <th></th>
                    </tr>
                </thead>

                <tfoot>
                    <tr>
                        <th>CODIGO</th>
                        <th>NOMBRE</th>
                        <th>APELLIDOS</th>
                        <th>DOCUMENTOS</th>
                        <th>COD. ALUMNO SIRA</th>
                        <th></th>
                    </tr>
                </tfoot>
                <tbody>
                    <?php foreach ($lista_alumno as $key => $value) { 
                        if ($value['Asistencias'] == 'Asistio') {
                            $chekP = 'checked';
                        } else {
                            $chekP = '';
                        }?>
                    <tr>
                            <td><?php echo $value['CodigoAlumno']; ?><input type="hidden" name='codigoalumno[<?php echo $value['CodigoAlumno']; ?>]' value="<?php echo $value['CodigoAlumno'] ?>"></td>
                            <td><?php echo utf8_encode($value['NombreAlumno']); ?></td>
                            <td><?php echo utf8_encode($value['Apellidos']); ?></td>
                            <td><?php echo $value['Documento']; ?></td>
                            <td><?php echo $value['CodAlumnoSira']; ?></td>
                            <td><input type="checkbox" name="asistencia[<?php echo $value['CodigoAlumno']; ?>]" id="asignado<?php echo $value['CodigoProfesor']; ?>" <?php echo $chekP; ?> value="1"></td>
                        </tr>

<?php } ?>


                </tbody>
            </table>
                                </form>
                        </div>
                    </div>
                </fieldset>
                <fieldset class="ui-corner-all" >
                    <legend>Accion</legend>
                    <div  style="clear: both; padding: 10px; width: auto;text-align: center">
                        <a href="#" id="save" class="button">GRABAR</a>
                        <a href="index.php?controller=asistenciaalumno" class="button">ATRAS</a>
                    </div>
                </fieldset>


            </div>
        
    </div>
</div>
