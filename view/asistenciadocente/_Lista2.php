<script>
    $(function() {
        $('#lista_asitencia_docente').DataTable({
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
            serial=$('#frm').serialize();
            $.post('index.php', 'controller=asistenciadocente&action=save&'+serial+'&idevento=' + idevento, function(data) {
            });
        });

    });
</script>
<div class="col-lg-12">
    <div id="lista">
        
            <div class="contFrm ui-corner-all" style="background: #fff;">

                <fieldset class="ui-corner-all" >
                    <legend><label>LISTA DE DOCENTES EN EL EVENTO :<?php echo " ".$evento ?></label> <label id="evento"></label></legend>  
                    <input type="hidden" id="idevento" name="idevento" value="<?php echo $idevento; ?>">
                    <div id="lista_alumnos">
                        <div  style="overflow-y: auto; max-height: 400px; max-width: 100%">
                        <form id="frm">
                        <table id="lista_asitencia_docente" class="display" cellspacing="0" width="100%">
                <thead>
                    <tr>
                        <th>CODIGO</th>
                        <th>NOMBRE</th>
                        <th>SEXO</th>
                        <th>COD. ALUMNO SIRA</th>
                        <th></th>
                    </tr>
                </thead>

                <tfoot>
                    <tr>
                        <th>CODIGO</th>
                        <th>NOMBRE</th>
                        <th>SEXO</th>
                        <th>COD. ALUMNO SIRA</th>
                        <th></th>
                    </tr>
                </tfoot>
                <tbody>
                    <?php foreach ($lista_docente as $key => $value) { 
                        if ($value['Asistencias'] == 'Asistio') {
                            $chekP = 'checked';
                        } else {
                            $chekP = '';
                        }?>
                    <tr>
                            <td><?php echo $value['CodigoProfesor']; ?><input type="hidden" name='codigoalumno[<?php echo $value['CodigoProfesor']; ?>]' value="<?php echo $value['CodigoProfesor'] ?>"></td>
                            <td><?php echo utf8_encode($value['Docente']); ?></td>
                            <td><?php echo $value['sexo']; ?></td>
                            <td><?php echo $value['FechaIngreso']; ?></td>
                            <td><input type="checkbox" name="asistencia[<?php echo $value['CodigoProfesor']; ?>]" id="asignado<?php echo $value['CodigoProfesor']; ?>" <?php echo $chekP; ?> value="1"></td>
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
                        <a href="index.php?controller=asistenciadocente" class="button">ATRAS</a>
                    </div>
                </fieldset>


            </div>
        
    </div>
</div>
