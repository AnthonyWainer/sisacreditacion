<script>
    $(function() {
        $('#suv_even').DataTable({
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
        $(".sub_evento").click(function(){
              id_sub_evento=$(this).val();
            tema=$("#sub_even_"+id_sub_evento).val();
            $("#asignacionPS").html('<br><br><br><br><strong><span>Cargando la nueva vista...</span></strong>');
            $.post('index.php', 'controller=asistenciaseventoEU&action=asistenciaEU&idevento='
                 +id_sub_evento+'&evento='+tema, function(data) {
            console.log(data);
            $("#asignacionPS").empty().append(data);
        });
            
        });
    
    });
    
</script>

<div id="dos"><a  href="index.php?controller=asistenciaseventoEU" class="btn btn-primary glyphicon glyphicon-backward">ATRAS</a><span style="color:blue;font-size: 18px;">CRONOGRAMA</span>
    <div align="left">
        <span id="tabla">
            <table id="suv_even" class="display" cellspacing="0" width="95%">
                <thead>

                <tr>
                    <th>CODIGO</th>
                    <th>TEMA</th>
                    <th>TIPO EVENTO</th>
                    <th>FECHA</th>
                    <th>ACCION</th>
                </tr>
            </thead>

            <tfoot>
                <tr>
                    <th>CODIGO</th>
                    <th>TEMA</th>
                    <th>TIPO EVENTO</th>
                    <th>FECHA</th>
                    <th>ACCION</th>
                </tr>
            </tfoot>
            <tbody>

                <?php foreach ($sub_evento as $oky => $val) { ?>
                    <tr>
                        <td><?php echo $val['idevento']; ?><input id="jhos" type="hidden" name="CodigoAlumno[]" value="<?php echo $val['idevento']; ?>"></td>
                        <td><?php echo utf8_encode($val['tema']); ?> <input type="hidden" id="sub_even_<?php echo $val['idevento']; ?>" value="<?php echo utf8_encode($val['tema']); ?>"</td>
                        <td><?php echo utf8_encode($val['descripcion']);  ?></td>
                        <td><?php echo utf8_encode($val['fecha']);  ?></td>
                        <td><button class="sub_evento" name="sub_evento" value="<?php echo $val['idevento']; ?>"><img alt="" src="images/accept.png"></button></td>
                    </tr>
                <?php } ?>




            </tbody>
        </table>
        </span>


    </div>
</div>