<script type="text/javascript" src="js/app/evt_form_eventoEU.js"  ></script>
<script type="text/javascript" src="js/validateradiobutton.js"></script>
<div class="div_container">
    <?php // echo "<div align='left'><pre>";print_r($obj);echo "<br><pre>";print_r($obj_tipo);echo "</div>"?>
    <h6 class="ui-widget-header">Registro de Evento </h6>
    <script>
        $(document).ready(function() {                      
            $("#add").click(function(event) {
                $("#sub_eventos").css('display', 'block');
                $("#pre").css('display', 'none');
            });
            $("#preac").click(function(event) {
                $("#sub_eventos").css('display', 'none');
                $("#pre").css('display', 'block');
            });
//            $("#añadir").click(function(event) {
//                $("#boton").toggle();
//            });
            $("#añadir").click(function() {
                str = $("#frm").serialize();

                $("#mensaje_anadir").fadeIn(1000);

                $.post('index.php', str, function(data) {
                    console.log(data);
                    $("#evento_sub_eventos").empty().append(data);
                });
                $("#mensaje_anadir").fadeOut(1000)

            });
        });

    </script>
    <style>

        fieldset{

            -webkit-border-radius: 0 0 20px 20px;
            -moz-border-radius: 0 0 20px 20px;
            border-radius: 0 0 20px 20px;
            border: black 1px solid; 
            padding: 15px 20px;

        }


        h2 {


            color: #242424;
            font-size: 28px;
            padding: 5px 5px;
            text-shadow: 0 0 0.2em #aaa;
        }

        h2 span[class*="fontawesome-"] {
            margin-right: 14px;
        }

        div {
            margin: .3em 0;
        }
        label {
            width: 20%;
            float: left;
            text-align: left;

        }


    </style>
    <form id="frm" action="index.php" method="POST">
        <input type="hidden" name="controller" value="eventoEU" />
        <input type="hidden" name="action" value="save" />
        <div class="contFrm ui-corner-all" >
            <div class="transparente" class="contenido" style="margin:0 auto; width: 500px; ">
                <!--               <fieldset style="border:6px groove #ccc; background-image:url(css/images_eapisi/fondo.gif) ;"  class="ui-corner-all" >-->


                <fieldset>
                    <table width="100"><legend><h2>Datos</h2></legend>

                        <div  class="tab-content col-md-1" >
                            <tr>
                            <div class="col-md-12">

                                <div class="col-md-6">
                                    <big><label for="idevento" >Codigo</label></big>
                                    <input type="text" class="form-control oblig" placeholder="Codigo" name="idevento" id="idevento" value="<?php echo $obj['idevento']; ?>" readonly>
                                </div> 

                                <div class="col-md-6">
                                    <big ><label for="tema" style="width: 161px;">Tema del evento</label></big>
                                    <input type="text" class="form-control oblig" placeholder="Tema" name="tema" id="tema" value="<?php echo $obj['tema']; ?>">
                                </div>
                            </div>

                            <div class="col-md-12">
                                <div class="col-md-6" style="width: 100%;">
                                    <big> <label for="tipo_evento" style="width: 161px;"> Tipo de Evento</label></big>

                                    <?php echo $tipo_evento; ?>
                                </div>

                            </div>
                            <div class="col-md-12">
                                <div class="col-md-6">
                                    <big><label style="width: 161px;">Fecha Inico</label></big>
                                    <input type="date" min="<?php echo  date("Y-m-d");?>" class="form-control oblig" placeholder="Fecha" name="fecha" id="fecha" value="<?php echo $obj['fecha']; ?>"> 
                                </div>

                                <div class="col-lg-6">
                                    <big><label style="width: 161px;">Fecha Termino</label></big>
                                    <input type="date" class="form-control oblig" placeholder="Fecha_Termino" name="fecha_termino" id="fecha_termino" value="<?php echo $obj['fecha_termino']; ?>"> 
                                </div>

                                <div class="col-md-6">
                                    <big><label>Lugar</label></big>
                                    <input id="lugar" maxlength="100" name="lugar" class="form-control oblig" placeholder="Lugar" style=" width: 185px; text-align: left;" value="<?php echo $obj['lugar']; ?>">
                                </div>

                                <div class="col-md-6">
                                    <big><label>Departamento</label></big>
                                    <?php echo $departamento; ?>
                                </div>
                            </div> 

                            <div class="col-md-12">

                                <div class="col-md-6">
                                    <big><label for="provincia" >Provincia</label></big>
                                    <?php if (!isset($provincia)) { ?>
                                        <select id="provincia" name="provincia" class="form-control oblig" style="width: 161px;">
                                            <option value="">...</option>
                                        </select>
                                        <?php
                                    } else {
                                        echo $provincia;
                                    }
                                    ?>
                                </div> 

                                <div class="col-md-6">
                                    <big><label>Distrito</label></big>

                                    <?php if (!isset($distrito)) { ?>
                                        <select id="distrito" name="distrito" style="width: 100%;" class="form-control oblig">
                                            <option value="">...</option>
                                        </select>  
                                        <?php
                                    } else {
                                        echo $distrito;
                                    }
                                    ?>  

                                </div>

                            </div>
                            </tr>

                    </table>
                </fieldset> 
            </div>
        </div>
    </form>
    <span id="mensaje_anadir" style="display: none">GUARDANDO...</span>
    <button type="button" id="añadir" class="btn btn-success glyphicon glyphicon-plus-sign" >A&Ntilde;ADIR</button>
    <a href="index.php?controller=eventoEU" class="btn btn-primary glyphicon glyphicon-backward">ATRAS</a>
    <div id="recelectando"></div>
    <div id="evento_sub_eventos">
        <?php echo $sub_eventos;
        echo "<br>";
        echo $pre_actividades; ?>
    </div>

    <br/>
</div>
