<script type="text/javascript" src="js/app/evt_form_asignaciontutoria.js" ></script>
<h6 class="ui-widget-header">Asignaciones</h6>
<!--<input type="text" id='idfacultad'>-->
SEMESTRE : <div style="width:160px;display: inline-block;"><?php echo $semestreacademico; ?></div>
<br>
<div class="container-fluid">   
    <div class="row">  
        <div  class="col-sm-12 col-md-12 ">
            <div id="alumnos">
            <iframe id="iframe_buscar_alumno"src="index.php?controller=alumno&action=search_por_facultad&fac=<?php echo $idfacultad;?>&sinCab=true" width="900" height="520"  marginwidth="0" noresize scrolling="No" frameborder="0">      
            </iframe>
            </div>
        </div>
    </div>
    <div align="right"><button id="agregar_lista" class="btn btn-success btn-xs" style="margin-right: 35px;display: none;">Agregar a la lista </button></div>
    <input type="hidden" id="array_click2" name="array_click2" >
    <div class="row">  
        <div class="col-sm-6 col-md-6 ">
            <div id="lista_profesores"><span style="color:blue;font-size: 18px;">LISTA DE DOCENTES:</span>
                <div  style="overflow-y: auto; max-height: 510px;">
                    <div align="left">
                        <div style="width:390px;">
                            <div id="tabla" style="margin-left: 16px;">

                                <?php echo $tabla; ?>
                            </div>

                        </div>

                    </div>
                </div>
            </div>
        </div>
        <div class="col-sm-6 col-md-6">
            <form id="frm" action="index.php" method="POST">
                <input type="hidden" name="controller" value="asignaciontutoria" />
                <input type="hidden" name="action" value="save" />
                <div class="contFrm ui-corner-all" style="background: #fff;">
                    <div class=""id="grilla" style="visibility: hidden;"><br>
                        <fieldset class="ui-corner-all" >
                            <legend>Asignación de Alumnos</legend>  
                            <input type="hidden" id="CodigoProfesor" name="CodigoProfesor">
                            <input type="hidden" id="Codigo_Semestre" name="Codigo_Semestre">
                            DOCENTE: <span type="text" name="prof"id="prof">&nbsp;</span><br>
                            <input id="CodigoAlumno" name="CodigoAlumno" type="hidden" value="<?php echo $obj->NombreAlumno; ?>" />
                            <!--Alumno: <input id="NombreAlumno" name="NombreAlumno" class="text ui-widget-content ui-corner-all" style=" width: 280px; text-align: left;" value="<?php // echo strtoupper(utf8_encode($obj->NombreAlumno)); ?>" readonly="" />-->                        
<!--                            <a title="Agregar Alumno" href="javascript:" id="btnadd"><img src="images/add.png"/></a>
                            <span id="lupa" >

                            </span>-->
                            <div class="contain" id="tdetalle">
                                <table id="detalle" class="ui-widget ui-widget-content" style="width: 380px; margin: 0 auto; " >
                                    <thead class="ui-widget ui-widget-content">
                                        <tr class="ui-widget-header" style="height: 20px">                            
                                            <th width="60px" >CODIGO</th>
                                            <th width="300px">NOMBRE DE ALUMNO</th>            
                                            <th width="20px">&nbsp;</th>
                                        </tr>
                                    </thead>
                                    <tbody>

                                    </tbody>
                                </table>
                            </div>
                        </fieldset>
                        <fieldset class="ui-corner-all" >
                            <legend>Accion</legend>
                            <div  style="clear: both; padding: 10px; width: auto;text-align: center">
                                <a href="#" id="save" class="button">GRABAR</a>
                                <a href="index.php?controller=asignaciontutoria" class="button">REFRESCAR</a>
                            </div>
                        </fieldset>

                    </div>
                </div>
            </form>
        </div>

    </div>

</div>