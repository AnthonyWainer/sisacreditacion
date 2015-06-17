<script >
    $(function() {
//$('#tsub_eventos').DataTable({
//        "paging":   true,
//        "sPaginationType": "full_numbers",
//        "bJQueryUI":true
//    } );
        var t = $('#tsub_eventos').DataTable({
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
        $("#addRow").click(function() {
            t.row.add([
                '<big> <span class="glyphicon glyphicon-hand-right"> Nuevo</span></big>',
                '<input  type="text" id="tema"  name="tema[]" style="font-size:120%"/>',
                // '<?php echo $id_even ?>',
                '<input type="time" id="hora_evento"  name="hora_evento[]" size="6"/>',
                '<input type="date" id="fecha"  name="fecha[]" size="12"/>',
//            '<input type="text" id="CodigoProfesor"  name="CodigoProfesor[]" size="6"/>',
                '<input type="text" id="lugar"  name="lugar[]" size="12"/>',
                "<td><a href='' class='glyphicon glyphicon-edit'></td>",
                "<td><a href='' class='glyphicon glyphicon-trash'></td>"
            ]).draw();
        });

        $("#guardar_sub_ev").click(function() {
            $("#msg").html('<strong>Guardando ...</strong>');
            ideven=$('#idevento').val();
            serializando = $("#formulario_sub_ev").serialize();
            $.post('index.php', serializando+'&ideven='+ideven, function(data) {
//            $("#msg").empty().append(data);
                $("#sub").empty().append(data);
            });
        });
        $(".elimisub").click(function(){
            idpre = $(this).attr("id_pre_act_del"); idpadre=$("#ideventoo").val();tipoevento=$("#tipoevento").val();ubigeo1=$("#ubigeo1").val();
            if (confirm("Esta seguro que desea eliminarloee?"))
            {
                $.post('index.php', 'controller=eventoPS&action=delete_sub&idpre=' + idpre+'&idpadre='+idpadre+'&tipoevento='+tipoevento+'&ubigeo1='+ubigeo1, function(data) {
                    $("#sub").empty().append(data);
                });
            } 
        });
        $(".editpre").click(function() {
            idpre = $(this).attr("id_pre_act");
            $('#tema_' + idpre).prop('disabled', false);
            $('#hora_evento_' + idpre).prop('disabled', false);
            $('#fecha_' + idpre).prop('disabled', false);
            $('#lugar_' + idpre).prop('disabled', false);
            $('#idevento_' + idpre).prop('disabled', false);

        });
//    $('#guardar_sub_ev').click(function(){
//        seriali=$("#formulario_sub_ev").serialize();
//        $.post('index.php', seriali, function(data) {
//        console.log(data);
//        $("#tabla").empty().append(data);
//        });
//                
//    });
    });
</script>
<!--<script type="text/javascript" src="js/validateradiobutton.js"></script>-->
<div id="sub">
    <div id="msg"></div>

    <form id="formulario_sub_ev" action="index.php" method="POST">
        <input type="hidden" name="controller" value="eventoPS" />
        <input type="hidden" name="action" value="save__subeventos" />
        <input type="hidden" id="ideventoo" name="ideventoo" value="<?php echo $idevento; ?>" />
        <input type="hidden" id="tipoevento" name="tipoevento" value="<?php echo $id_even; ?>"/>
        <input type="hidden" id="ubigeo1" name="ubigeo1" value="<?php echo $ubigeo ?>"
               <div class="contFrm ui-corner-all" style="background: #fff;">
            <div class="contenido" style="margin:0 auto; width: 100%; ">
                <fieldset class="ui-corner-all" >
                    <legend id="legendsub_evento" align="left">REGISTRO DE SUB EVENTOS</legend> 
                    <button type="button" id="addRow" class="btn btn-info"><img alt="" src="images/add.png" />Agregar</button>
                    <button type="button" id="guardar_sub_ev" class="btn btn-info"><img alt="" src="images/disk.png" />Guardar</button>
                    <br>
                    <table id="tsub_eventos" class="display" cellspacing="0" width="100%">
                        <thead>
                            <tr>
                                <th>Sub Evento</th>
                                <th>Tema</th>
                                <th>Hora</th>
                                <th>Fecha</th>
    <!--                            <th>CodigoProfesor</th>-->
                                <th>Lugar</th>
                                <?php
                                if ($_REQUEST['action'] != 'show_detalles') {
                                    echo "<th></th>
                            <th></th> ";
                                }
                                ?>


                            </tr>
                        </thead>

                        <tfoot>
                            <tr>
                                <th>Sub Evento</th>
                                <th>Tema</th>
                                <th>Hora</th>
                                <th>Fecha</th>
    <!--                            <th>CodigoProfesor</th>-->
                                <th>Lugar</th>
                                <?php if ($_REQUEST['action'] != 'show_detalles') {
                                    echo "<th></th><th></th> ";
                                } ?>

                            </tr>
                        </tfoot>
                        <tbody>
                            <?php // echo "<div align='left'><pre>";print_r($rows); ?>
                            <?php
                            foreach ($rows as $key => $value) {
                                echo "<tr>";
                                 echo "<td><input type='hidden' id='idevento_" . $value['idevento'] . "' name='idevento[" . $value['idevento'] . "]' value='" . $value['idevento'] . "' disabled>" . $value['idevento'] . "</td>";
                                echo "<td><input type='text' id='tema_" . $value['idevento'] . "' name='tema_up[" . $value['idevento'] . "]' value='" . utf8_encode($value['tema']) . "' disabled></td>";
                               echo "<td><input type='time' id='hora_evento_" . $value['idevento'] . "' name='hora_evento_up[" . $value['idevento'] . "]' value='" .$value['hora_evento'] . "' disabled></td>";
                              echo "<td><input type='date' id='fecha_" . $value['idevento'] . "' name='fecha_up[" . $value['idevento'] . "]' value='" . $value['fecha'] . "' disabled></td>";
                               echo "<td><input type='text' id='lugar_" . $value['idevento'] . "' name='lugar_up[" . $value['idevento'] . "]' value='" . utf8_encode($value['lugar']) . "' disabled></td>";
                                if ($_REQUEST['action'] != 'show_detalles') {
                                      echo "<td><a href='javascript:' style='color:blue' id_pre_act='" . $value['idevento'] . "' class=' editpre glyphicon glyphicon-edit'></td>";
                                    echo "<td><a href='javascript:' style='color:blue' id_pre_act_del='" . $value['idevento'] . "' class='elimisub glyphicon glyphicon-trash'></td>";
                                }
                                echo"</tr>";
                            }
                            ?>
                        <tbody>
                    </table>
                    <!--                <div id="evento_sub_eventos">
                                        
                                    </div>-->



                </fieldset> 

            </div>


    </form>
</div>
<div id="pre_actividades"></div>

