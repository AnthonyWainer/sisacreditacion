<?php include("../lib/functions.php"); ?>
<script type="text/javascript" src="js/app/evt_form_misasistenciasAlumno.js" ></script>
<script type="text/javascript" src="js/validateradiobutton.js"></script>
<script>
    $(function() {
        $(".wrapper-search").html('');

    })
</script>
<div class="div_container">
    <h6 class="ui-widget-header">Mis Asistencias</h6>
    <div id="lista_eventos">
        <div class="col-lg-12"><div align="left"><span style="color:blue" id="semestres" > Semestre : <div style="width: 160px;display:inline-block;"><?php echo $semestreacademico; ?></div></span><strong style="margin-left: 10%;"> MI TUTOR : <span id="tutor" ></span></strong><button style="margin-left:90px;"class="ver btn btn-success btn-xs">Listado De Asignados</button></div>
           
            <div id="grilla_eventos"><span style="color:blue;font-size: 18px;">LISTA DE EVENTOS:</span>
                <div align="left">
                    <span id="tabla">

                        <?php echo $grilla; ?>
                    </span>


                </div>
            </div>
            
        </div>
    </div>
    <div id="Mis_companeros_tutoria"> <label>Cargando...</label>
    </div>
    <div id="atras"  style="clear: both; padding: 10px; width: auto;text-align: center">
         <a href="index.php?controller=misasistenciasAlumno" class="button">ATRAS</a>
     </div>
</div>
