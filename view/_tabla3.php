<script type="text/javascript" src="js/jquery.dataTables.js"></script>
<link href="css/demo_table.css" rel="stylesheet" type="text/css" />
<link href="css/demo_table_jui.css" rel="stylesheet" type="text/css" />
<link href="css/demo_page.css" rel="stylesheet" type="text/css" />
<link href="css/jquery.dataTables_themeroller.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="js/jquery-ui-1.10.3.custom.js"></script>
<script type="text/javascript" src="js/jquery-ui-1.10.3.custom.min.js"></script>
<script type="text/javascript" charset="utf-8">
    $(document).ready(function() {
        $('#datatables').dataTable({
            "sPaginationType": "full_numbers",
            "aaSorting": [[0, "asc"]],
            "bJQueryUI": true

        });


    });
    eviar_notas_poyectos = function() {
        idproyecto = $("#p_idproyecto").val();
        $.post('index.php', 'controller=notasproyecto&action=Enviar_Notas_Finales&idproyecto=' + idproyecto, function(data) {
            if (data.resp == 1) {
                alertify.success(data.msg);
            }
            else {
                alertify.error(data.msg);
            }
        }, 'json');
    }
</script> 


<style>
    #dialogo table{
        background-color: #408B40;  
        font-family: Calibri;
    }
    #dialogo table thead tr th{
        text-align: center;
        color: white;

        font-size: 13px;
        border: 1px solid black;
    }
    #dialogo table tbody tr{
        background-color: #C6F2C6;
    }
    #dialogo table tbody tr td{
        border: 1px solid black;

        font-size: 13px;
    }
    #myTab a{
        color: #428bca;
    }

</style> 


<div class="tab-pane" id="actividades" style="display:none;">
    <div class="col-md-10">
        <table id="tabladetalle">
            <thead>
                <tr>
                    <th>ACTIVIDAD</th>
                    <th>FECHA INICIO</th>
                    <th>FECHA TERMINO</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($rows as $key => $value) { ?>
                    <tr>
                        <td><?php echo strtoupper(utf8_encode($value[1])); ?></td>

                        <td><?php echo strtoupper(utf8_encode($value[2])); ?></td>

                        <td><?php echo strtoupper(utf8_encode($value[3])); ?></td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
        <button type="button" onclick="document.getElementById('actividades').style.display = 'none', document.getElementById('listaproyecto').style.display = ''" class="btn btn-success">Regresar</button>
    </div>
</div>


<div class="tab-pane" id="notas" style="display:none;">
    <div class="col-md-10">
        <table id="tabladetalle">
            <thead>
                <tr>
                    <td padding="25px 20px" rowspan="2">CONCEPTO</td>
                    <td padding="25px 20px" rowspan="2">NOTA</td>
                    <td padding="25px 20px" rowspan="2">CODIGO ALUMNO</td>
                    <td padding="25px 20px" rowspan="2">CODIGO PROYECTO</td>

                </tr>
            </thead>
            <tbody>
                <?php foreach ($rows as $key => $value) { ?>
                    <tr>    

                        <td>
                            <?php echo strtoupper(utf8_encode($value[0])); ?>
                        </td>
                        <td>
                            <?php echo strtoupper(utf8_encode($value[1])); ?>
                        </td>
                        <td>
                            <?php echo strtoupper(utf8_encode($value[2])); ?>
                        </td>

                        <td>
                            <?php echo strtoupper(utf8_encode($value[3])); ?>
                        </td>

                    </tr>  
                <?php } ?>
            </tbody>
        </table>
        <button type="button" onclick="document.getElementById('actividades').style.display = 'none', document.getElementById('listaproyecto').style.display = ''" class="btn btn-success">Regresar</button>
    </div>
</div>

<?php if (isset($_SESSION["perfil"]) && ($_SESSION["perfil"] == 'PROFESOR')) { ?>
    <?php echo $semestreacademico; ?>
<?php } ?>
<div id="listaproyecto" style=" margin-left: 20px;">

    <div id="data">
        <?php if (count($rows) != 0) { ?>
            <table id="datatables" class="display">
                <thead>
                    <tr>
                        <th class="hidden">ID</th>
                        <th>NOMBRE</th>
                        <th>TEMA</th>
                        <th>PERIODO DE EJECUCION</th>
                        <th>JEFE DEL PROYECTO</th>
                        <th>FECHA</th>
                        <!-- <?php if (isset($_SESSION["perfil"]) && ($_SESSION["perfil"] == 'ALUMNO')) { ?>
                             <th >VER MIS NOTAS</th>
                        <?php } ?> -->
                        <th>NOTAS</th>
                        <th >VER MAS</th>

                        <th >ACTIVIDADES</th>

                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($rows as $key => $value) { ?>

                        <tr>  

                            <td class="hidden"> 
                                <?php echo strtoupper(utf8_encode($value[0])); ?>

                            </td>

                            <td> 
                                <?php echo strtoupper(utf8_encode($value[1])); ?>
                            </td>
                            <td>
                                <?php echo strtoupper(utf8_encode($value[2])); ?>
                            </td>
                            <td>
                                <?php echo strtoupper(utf8_encode($value[3])); ?>
                            </td>
                            <td>
                                <?php echo strtoupper(utf8_encode($value[4])); ?>
                            </td>
                            <td>
                                <?php echo strtoupper(utf8_encode($value[5])); ?>
                            </td>


                            <!-- <?php if (isset($_SESSION["perfil"]) && ($_SESSION["perfil"] == 'ALUMNO')) { ?>
                                 <td>
                                     
                                     <div id="abrir3" style="margin-left: 20px;">
                                         <a><li id="" style="margin: 2px;position: relative;padding: 4px 0;cursor: pointer;float: left;list-style: none; font-family: Calibri;" class="ui-state-default ui-corner-all" title=".ui-icon-circle-plus" >
                                                 <span style="float: left; margin: 0 4px; background-image: url(css/images/ui-icons_2e83ff_256x240.png);"class="ui-icon ui-icon-circle-zoomout"
                                                       onclick="verNotas('<?= strtoupper(utf8_encode($value[0])) ?>',
                                                                       document.getElementById('notas').style.display = '', document.getElementById('listaproyecto').style.display = 'none')"></span></li></a>
                                     </div> 
             
                                 </td>
                            <?php } ?> -->
                            <td>
                                <?php $pp = $value[0] ?>
                                <?php
                                if (isset($_SESSION["perfil"]) && ($_SESSION["perfil"] == 'ALUMNO')) {

                                    foreach ($rows1 as $key => $value1) {
                                        if (($_SESSION['idusuario'] == $value1[3]) && ($pp == $value1[2] )) {
                                            ?>
                                            <?php echo (int) $value1[1] ?>
                <?php } ?>
            <?php }
        } else { ?>
                                    <button type="button"class="btn btn-default btn-sm notasProy"data-toggle="modal" data-target="#InNota" id="<?php echo $value[0]; ?>" >NOTAS</button>
                                    <div class="modal fade " id="InNota" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                                    <strong class="modal-title" id="myModalLabel" style="font-size:18px;margin-right: 40px;">NOTAS</strong>
                                                    &nbsp; <button type="button" class="btn btn-primary" id="enviar_notas" onclick="eviar_notas_poyectos();" >Enviar Notas</button>

                                                </div>
                                                <div class="modal-body alumnos">

                                                </div>
                                            </div>
                                        </div>
                                    </div>
        <?php } ?>
                            </td>
                            <td>

                                <div id="abrir" style="margin-left: 20px;">
                                    <a><li id="" style="margin: 2px;position: relative;padding: 4px 0;cursor: pointer;float: left;list-style: none; font-family: Calibri;" class="ui-state-default ui-corner-all" title=".ui-icon-circle-plus" >
                                            <span style="float: left; margin: 0 4px; background-image: url(css/images/ui-icons_2e83ff_256x240.png);"class="ui-icon ui-icon-circle-plus"
                                                  onclick="verMas('<?= strtoupper(utf8_encode($value[0])) ?>',
                                                                  document.getElementById('detalleproyecto').style.display = '', document.getElementById('listaproyecto').style.display = 'none')"></span></li></a>
                                </div> 

                            </td>

                            <td>
                                <div id="abrir2" style="margin-left: 20px;">
                                    <a><li  style="margin: 2px;position: relative;padding: 4px 0;cursor: pointer;float: left;list-style: none; font-family: Calibri;" class="ui-state-default ui-corner-all" title=".ui-icon-circle-plus" >
                                            <span style="float: left; margin: 0 4px; background-image: url(css/images/ui-icons_2e83ff_256x240.png);"class="ui-icon ui-icon-tag"
                                                  onclick="verActividad('<?= strtoupper(utf8_encode($value[0])) ?>',
                                                                  document.getElementById('actividades').style.display = '', document.getElementById('listaproyecto').style.display = 'none')"></span></li></a>
                                </div> 

                            </td>


                        </tr>  
        <?php } ?>
                </tbody>
            </table>
        </div>
    <?php } else {
        echo 'USTED NO ESTA EN NINGUN PROYECTO <br>PARA REGISTRARSE VAYA A <a href="index.php?controller=listaproyecto"><span style="color: red;" >LISTA DE PROYECTOS</span></a>';
        ?>

<?php } ?>     

</div>


<div id="detalleproyecto" style="display:none;">
    <div class="col-md-1"></div>
    <div class="col-md-10">
        <ul class="nav nav-tabs" id="myTab" style="font-family: Calibri; font-size: 12px">
            <li class="active"><a href="#generales" data-toggle="tab">DATOS GENERALES</a></li>
            <li><a  href="#planteamiento" data-toggle="tab">PLANTEAMIENTO DEL PROBLEMA</a></li>
            <li><a href="#objetivos" data-toggle="tab">OBJETIVOS</a></li>
            <li><a href="#marco" data-toggle="tab">MARCO TEORICO</a></li>
            <li><a href="#metodologia" data-toggle="tab">METODOLOGIA</a></li>
            <li><a href="#aspectos" data-toggle="tab">ASPECTOS ADMISTRATIVOS</a></li>
            <li><a href="#docentes" data-toggle="tab">DOCENTES</a></li>
            <li><a href="#alumnos" data-toggle="tab">ALUMNOS</a></li>
        </ul> 
        <div class="tab-content col-md-12" style="height: 300px;background-color: #F7F7F7; margin-bottom: 15px;font-family: Calibri;text-align: left;padding-left: 0; padding-right: 0; border-bottom:1px solid #ddd ; border-left: 1px solid #ddd;border-right:1px solid #ddd; border-radius: 4px;">
            <!---detalles generales-->
            <div class="tab-pane active" style="overflow-y: scroll; height: 300px;" id="generales">

            </div>
            <!---detalles generales-->

            <!---detalles ubigeo empieza-->
            <div class="tab-pane" id="planteamiento">

            </div>
            <!---detalles ubigeo termina-->


            <!---detalles objetivo empieza-->
            <div class="tab-pane" id="objetivos">

            </div>
            <!---detalles objetivo termina-->
            <!---detalles MARCO empieza-->
            <div class="tab-pane" id="marco">

            </div>
            <!---detalles MARCO termina-->

            <!---detalles metodologia empieza-->
            <div class="tab-pane" id="metodologia">

            </div>
            <!---detalles metodologia termina-->

            <!---detalles aspectos empieza-->
            <div class="tab-pane" id="aspectos">

            </div>
            <!---detalles aspectos termina-->

            <!---detalles profesor empieza-->
            <div class="tab-pane" id="docentes">

            </div>
            <!---detalles profesor termina-->

            <!--detalles alumnos empiesa-->
            <div class="tab-pane" id="alumnos" >

            </div>  
            <!---detalles alumnos fin-->

        </div>


        <div>  
            <button type="button" onclick="document.getElementById('detalleproyecto').style.display = 'none', document.getElementById('listaproyecto').style.display = ''" class="btn btn-success">Regresar</button>

        </div>
        <div class="col-md-1"></div>
    </div>

    <script>
        $(".notasProy").click(function(event) {
            idproyecto = $(this).attr("id");
            $.post('index.php', 'controller=misproyectos&action=getListaAlumnoP&idproyecto=' + idproyecto, function(data) {
                console.log(data);
                $(".alumnos").empty().html(data);
            });


        });

        $("#semestreacademico").change(function() {
            $.get("index.php", "controller=misproyectos&action=index_proyectos&semestre=" + $(this).val(), function(datos) {
                //datos 
                $("#listaproyecto").empty().append(datos);
            }, 'json');
        });

    </script>