<script>
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
        $("#agregarexterno").click(function(){
            $("#reg_externo").css("display","");
        });
        
        var t=$('#agregar_exter').DataTable({
        "paging":   true,
        "sPaginationType": "full_numbers",
        "bJQueryUI":true,
        "language": {
            "lengthMenu": "filas _MENU_ ",
            "zeroRecords": "No hay registros que coincidan con la busqueda",
            "info": "Mostrando _PAGE_ de _PAGES_ entradas",
            "infoEmpty": "No records available",
            "infoFiltered": "(filtered from _MAX_ total records)"
        }
    } );
     $("#addRow1").click(function() {
     t.row.add( [
            'Nuevo ID','<input type="text" name="nombre_E[]" style = "width: 100%">',
            '<input type="text" name="apellido_E[]"  style = "width: 100%">',
            '<input type="text" name="direccion_E[]" style = "width: 100%">',
            '<input type="text" name="telefono_E[]" style = "width: 100%">',
            '<input type="text" name="dni_E[]" style = "width: 100%">',
            '<input type="text" name="institucion_E[]" style = "width: 100%">'
    
        ] ).draw();
    } );
        $("#reg_externo").css("display","none");
        $("#guardar_externos").click(function(){
            idevento= $("#idevento").val();
            ser=$("#form_externo").serialize();
            $.post('index.php', 'controller=asignacionPS&action=agregar_externo&' + ser+'&idevento='+idevento , function(data) {});
            $.post('index.php', 'controller=asignacionPS&action=listado_exter_ps' , function(data) {
                console.log(data);
            $("#externo_lis").empty().append(data);
            });
        });
        $(".altualizar_externo").click(function(){
            idevento = $("#idevento").val();
            id_externo=$(this).attr("externo");
            cheket=$("#asignado"+id_externo+":checked").val() ;
            if(cheket=='1'){cheket=1;}else{cheket=0;}
            cost=$("#costo_"+id_externo).val();
            cargon=$("#cargo_"+id_externo).val();
            $.post('index.php', 'controller=asignacionPS&action=save_externo&idevento=' + idevento + '&id_externo=' + id_externo + '&costo=' + cost + '&cargo=' + cargon+'&check='+cheket, function(data) {});
        });
</script>
<div  style="overflow-y: auto; max-height: 510px; max-width: 100%">
        <table id="otros" class="display" cellspacing="0" width="95%">
            <thead>
                <tr>
                    <th>CodigoProfesor</th>
                    <th>NombreProfesor</th>
                    <th>Cargo</th>
                    <th>Costo</th>
                    <th>Chek</th>
                    <th>Accion</th>
                </tr>
            </thead>

            <tfoot>
                <tr>
                    <th>CodigoProfesor</th>
                    <th>NombreProfesor</th>
                    <th>Cargo</th>
                    <th>Costo</th>
                    <th>Chek</th>
                    <th>Accion</th>
                </tr>
            </tfoot>
            <tbody>
                <?php foreach ($externos as $key => $value) { if($value['asignado']=='yes'){$chekP='checked';}else{$chekP='';}?>
                    <tr>
                        <td><?php echo $value['id_externos']; ?></td>
                        <td><?php echo utf8_encode($value['externo']); ?></td>
                        <td><?php
                            echo '<select class="form-control" style="width: 100%;" id="cargo_' . $value['id_externos'] . '">';
                            echo $cargo;
                            echo "</select>";
                            ?></td>
                        <td><input type="text" id="costo_<?php echo $value['id_externos']; ?>" name="costo[<?php echo $value['id_externos']; ?>]"></td>
                        <td><input type="checkbox" id="asignado<?php echo $value['id_externos']; ?>" <?php echo $chekP;?> value="1"></td>
                        <td>&nbsp;&nbsp;&nbsp;<a  externo='<?php echo $value['id_externos']; ?>' style="cursor:pointer;"class="altualizar_externo glyphicon glyphicon-floppy-disk"></a></td>
                    </tr>

                <?php } ?>
                
            </tbody>
        </table>
            </div>
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
       