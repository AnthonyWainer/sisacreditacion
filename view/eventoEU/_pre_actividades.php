
<script type="text/javascript" >


    $(function() {
        var t = $('#tsub_eventos_preact').DataTable({
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
        $("#guardar_pre_act").click(function() {
//            idevento=$("#idevento_").val();
            serializando = $("#frm_pre").serialize();
            $.post('index.php', serializando, function(data) {
//            $("#msg").empty().append(data);
                $("#pre").empty().append(data);
            });
        });
        $("#addRowSA").click(function() {
            t.row.add([
                '<big> <span class="glyphicon glyphicon-hand-right" > Nuevo</span></big>',
                '<input  type="text" id="pre_actividad[]"  name="pre_actividad[]" style="font-size:120%"/>',
                '<input type="text" id="descripcion[]"  name="descripcion[]" size="6"/>',
                '<input type="date" id="fecha_inicio[]"  name="fecha_inicio[]" size="6"/>',
                '<input type="date" id="fecha_termino[]"  name="fecha_termino[]" size="6"/>',
                "<td><a href='' class='glyphicon glyphicon-edit'></td>",
                "<td><a href='' class='glyphicon glyphicon-trash'></td>"

            ]).draw();
        });
        $(".editpre").click(function() {
            idpre = $(this).attr("id_pre_act");
            $('#pre_actividadd_' + idpre).prop('disabled', false);
            $('#descripcion_' + idpre).prop('disabled', false);
            $('#fecha_inicio_' + idpre).prop('disabled', false);
            $('#fecha_termino_' + idpre).prop('disabled', false);
            $('#id_evento_pre_' + idpre).prop('disabled', false);

        });
        $(".del").click(function() {
            idpadre=$("#idevento_").val();
            idpre = $(this).attr("id_pre_act_del");
            if (confirm("Esta seguro que desea eliminar esta preactividad?"))
            {
                $.post('index.php', 'controller=eventoEU&action=delete_pre&idpre=' + idpre+'&idpadre='+idpadre, function(data) {
                    $("#pre").empty().append(data);
                });
            }

        });

    });
</script>
<script type="text/javascript" src="js/validateradiobutton.js"></script>
<link href="css/formproyecto.css" rel="stylesheet" type="text/css" />
<div id="pre">

    <form id="frm_pre" action="index.php" method="POST">
        <input type="hidden" name="controller" value="eventoEU" />
        <input type="hidden" name="action" value="save__preactividades" />
        <input type="hidden" id="idevento_" name="idevento_" value="<?php echo $id_evnt; ?>" />
        <div class="contFrm ui-corner-all" style="background: #fff;">
            <div class="contenido" style="margin:0 auto; width: 100%; ">
                <fieldset class="ui-corner-all" >
                    <legend id="legendpre_actividad" align="left">REGISTRO DE PRE ACTIVIDADES</legend>
                    <button type="button" id="addRowSA" class="btn btn-info"><img alt="" src="images/add.png" />Agregar</button>
                    <button type="button" id="guardar_pre_act" class="btn btn-info"><img alt="" src="images/disk.png" />Guardar</button>

                    <table id="tsub_eventos_preact" class="display" cellspacing="0" width="100%">
                        <thead>
                            <tr>
                                <th>Pre Evento</th>
    <!--                        <th>idevento</th>-->
                                <th>Nombre</th>
                                <th>Descripcion</th>
                                <th>Fecha Inicio</th>
                                <th>Fecha Termino</th>
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
                                <th>Pre Evento</th>
    <!--                        <th>idevento</th>-->
                                <th>Nombre</th>
                                <th>Descripcion</th>
                                <th>Fecha Inicio</th>
                                <th>Fecha Termino</th>
                                <?php
                                if ($_REQUEST['action'] != 'show_detalles') {
                                    echo "<th></th>
                            <th></th> ";
                                }
                                ?>

                            </tr>
                        </tfoot>
                        <tbody>
                            <?php // echo "<div align='left'><pre>";print_r($rows); ?>
                            <?php
                            foreach ($rows as $key => $value) {
                                echo "<tr>";
                                echo "<td><input type='hidden' id='id_evento_pre_" . $value['id_pc_evento'] . "' name='id_evento_pre[" . $value['id_pc_evento'] . "]' value='" . $value['id_pc_evento'] . "' disabled>" . $value['id_pc_evento'] . "</td>";
//                            echo "<td>".$value['idevento']."</td>";
                                echo "<td><input type='text' id='pre_actividadd_" . $value['id_pc_evento'] . "' name='pre_actividad_up[" . $value['id_pc_evento'] . "]' value='" . utf8_encode($value['pre_actividad']) . "' disabled></td>";
                                echo "<td><input type='text' id='descripcion_" . $value['id_pc_evento'] . "' name='descripcion_up[" . $value['id_pc_evento'] . "]' value='" . $value['descripcion'] . "' disabled></td>";
                                echo "<td> <input type='date' id='fecha_inicio_" . $value['id_pc_evento'] . "'  name='fecha_inicio_up[" . $value['id_pc_evento'] . "]' value='" . $value['fecha_inicio'] . "' disabled></td>";
                                echo "<td><input type='date' id='fecha_termino_" . $value['id_pc_evento'] . "' name='fecha_termino_up[" . $value['id_pc_evento'] . "]' value='" . $value['fecha_termino'] . "' disabled></td>";
                                if ($_REQUEST['action'] != 'show_detalles') {
                                    echo "<td><a href='javascript:'  style='color:blue' id_pre_act='" . $value['id_pc_evento'] . "' class=' editpre glyphicon glyphicon-edit'></td>";
                                    echo "<td><a href='javascript:' style='color:blue' id_pre_act_del='" . $value['id_pc_evento'] . "' class='del glyphicon glyphicon-trash'></td>";
                                }
                                echo"</tr>";
                            }
                            ?>
                        <tbody>
                    </table>




                </fieldset> 

            </div>

        </div>
    </form>
</div>
<div id="pre_actividades"></div>