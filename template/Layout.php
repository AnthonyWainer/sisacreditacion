<?php if (!isset($_GET["variable"])&& $_GET["variabñe"]!="Sl"){?>
<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8" />
        <title>SIS-ACREDITACION</title>
        <script type="text/javascript" src="js/jquery-1.11.1.min.js"></script>
        <script type="text/javascript" src="js/bootstrap.min.js"></script>
        <link type="text/css" href="css/jquery-ui-1.8.13.custom.css" rel="stylesheet" />
        <link type="text/css" href="css/layout.css" rel="stylesheet" />
        <link href="css/cssmenu.css" rel="stylesheet" type="text/css" />
        <link href="css/templatemo_style.css" rel="stylesheet" type="text/css" />
        <script type="text/javascript" src="js/jquery-1.6.1.min.js"></script>
        <script type="text/javascript" src="js/jquery-ui-1.8.13.custom.min.js"></script>    
        <script type="text/javascript" src="js/menus.js"></script>
        <script type="text/javascript" src="js/session.js"></script>
        <link type="text/css" href="css/bootstrap.min.css" rel="stylesheet" />
        <script type="text/javascript" src="js/required.js"></script>
        <script type="text/javascript" src="js/validateradiobutton.js"></script>
        <script type="text/javascript" src="js/utiles.js"></script>
        <link rel="stylesheet" href="css/css.css">   
        <script type="text/javascript" src="js/jquery.blockUI.js"></script>
        <script src="js/datatables_mrm2.js"></script>
        <link href="css/datatables_mrm.css" type="text/css" rel="stylesheet"/>

        <script language="javascript" type="text/javascript">

            $(document).ready(function() {
                $.get('index.php', 'controller=Index&action=Menu', function(menu) {
                    $("#menu").empty();
                    var opciones_menu = menu;
                    $("#menu").generaMenu(opciones_menu);
                }, 'json');
            });
            function clearText(field) {
                if (field.defaultValue == field.value)
                    field.value = '';
                else if (field.value == '')
                    field.value = field.defaultValue;
            }
        </script>
    </head>

    <body style='background-image: url("css/images_eapisi/fondo.gif");'>

        <div class="container">
            <div class="row">
                <div class="col-md-3" style="background-color: #5086C4; height: 50px;">
                    <div class="col-md-3" style="padding-left:0; padding-right: 0;">
                        <img src="css/images_eapisi/eapisi.png" width="60px" height="50px">
                    </div>
                    <div class="col-md-9" style="text-align: center;

                    <?php if ($_SESSION['perfil'] == "PROFESOR" || $_SESSION['perfil'] == "ALUMNO" ){ ?>
                                <?php echo "font-size: 1.9em;"; }else{echo "font-size: 0.9em;";}?>" >
                                
                        <p style="text-align: center; color: #fff">
                        <strong style="text-align: center; text-shadow: 0.2em 0.2em 0.2em #333">
                            <?php echo utf8_encode($_SESSION['perfil']); ?>
                        </strong>
                        </p>
                    </div>

                </div>
                <div class="col-md-9" style="height: 50px; padding-left: 0; padding-right: 0;" >
                    <div style="background-color: #0B8E36; height: 60%;">
                        <p style="text-align: center; color: #fff; font-size: 1.4em; text-shadow: 0.2em 0.2em 0.2em #333">
                        <strong>"UNIVERSIDAD NACIONAL DE SAN MARTÍN"</strong>
                        </p>
                    </div>
                    <div style="background-color: #9F3BAE; height: 20px; ">
                        <p style="text-align: center; color: #fff; font-size: 12px; text-shadow: 0.2em 0.2em 0.2em #333" >
                        "Escuela Academica Profesional de Ingenieria de Sistemas e Informatica"</p> 
                    </div>

                </div>

            </div>
            <div class="row">
                <div class="col-md-12" style="background-color: #81AFD0; height: auto; padding-right: 0; border: 1px solid #B8B8B8;">
                    <div class="col-md-1">
                        <div style="margin-top: 3px;" title="foto">
                            <img onclick="cambiarfoto()" width="50" height="40" style="cursor:pointer; border-radius:5px;"
                             src="css/images_eapisi/user.jpg" >
                        </div>
                    </div>
                    <div class="col-md-8" style=" height: 40px; margin-top: 10px;">
                        <div>
                            <p style="text-align: left; color: #fff; font-size: 20px; font-family: comic; text-shadow: 0.2em 0.2em 0.2em #333 ">
                            <strong> <?php echo utf8_encode($_SESSION['name']); ?></strong>
                            </p>
                        </div>
                      
                    </div>

                   <!--<div class="col-md-3" style="padding-top: 15px;">
                        <p href="#" style="font-family: Calibri; color: #fff !important;; text-align: right;">
                        <?php /*setlocale(LC_ALL, "es_ES");
                        $fechal = strftime("%A %d de %B del %Y");
                        $fechal = ucwords($fechal);
                        echo $fechal; */?>
                        </p>
                    </div> 
                            -->
                
                    <div class="col-md-3" style="padding-top: px;">
                        <a href="/sisacreditacion">
                        <button type="button"  class="btn btn-primary" title="Inicio" 
                            style="width:20%; height:40px; text-align: center;">
                            <span class="glyphicon glyphicon-home" ></span>
                        </button>
                        </a>
                        <a  style="font-family: Calibri; color: #fff;" href="index.php?controller=User&action=logout">
                            <img width="50px" height="50px" src="../web/images/salir.jpg" title="cerrar sesión">
                        </a>
                    </div>
                </div>
            </div>

            <!-- .......... MENU .......... -->

            <div class="row">
                    <div class="navbar" id="menu2" role="navigation" style="margin-bottom: 0; min-height: 0;">
                        <div  class="container-fluid" id="menu2-contenedor">
                            <div  class="navbar-header">
                                <button style="background-color:#D1C3D5;" type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
                                    <span class="sr-only">Toggle navigation</span>
                                    <span style="background-color: #6A1981;" class="icon-bar"></span>
                                    <span style="background-color: #6A1981;" class="icon-bar"></span>
                                    <span style="background-color: #6A1981;" class="icon-bar"></span>
                                </button>
                                <a class="navbar-brand" href="#"></a>
                            </div>

                            <div class="collapse navbar-collapse " style="padding-left: 0;
                                 padding-right: 0;" id="bs-example-navbar-collapse-1">
                                <div id="menu"></div>


                            </div>
                        </div> 
                </div>
            </div> 

            <!--.............................MENU................................-->  

        </div>


        <div class="container">


            <div class="row panel-body" style="padding-left:0; padding-right: 0; background-color: white; min-height: 400px;">

                

                <?php echo $content; ?>

            </div>              

        </div>
        <div class="container" style="background: rgba(142,39,163,1); height: 40px;" >


        </div>


    </body>
</html>

<?php }else{?>
<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8" />
        <title>SIS-ACREDITACION</title>
        <script type="text/javascript" src="js/jquery-1.11.1.min.js"></script>
        <script type="text/javascript" src="js/bootstrap.min.js"></script>

        <link type="text/css" href="css/jquery-ui-1.8.13.custom.css" rel="stylesheet" />
        <link type="text/css" href="css/layout.css" rel="stylesheet" />
        <link href="css/cssmenu.css" rel="stylesheet" type="text/css" />
        <link href="css/templatemo_style.css" rel="stylesheet" type="text/css" />
        <script type="text/javascript" src="js/jquery-1.6.1.min.js"></script>
        <script type="text/javascript" src="js/jquery-ui-1.8.13.custom.min.js"></script>    
        <script type="text/javascript" src="js/menus.js"></script>
        <script type="text/javascript" src="js/session.js"></script>
        <link type="text/css" href="css/bootstrap.min.css" rel="stylesheet" />
        <script type="text/javascript" src="js/required.js"></script>
        <script type="text/javascript" src="js/validateradiobutton.js"></script>
        <script type="text/javascript" src="js/utiles.js"></script>
        <script language="javascript" type="text/javascript">
            $(document).ready(function() {
                $.get('index.php', 'controller=Index&action=Menu', function(menu) {
                    $("#menu").empty();
                    var opciones_menu = menu;
                    $("#menu").generaMenu(opciones_menu);
                }, 'json');
            });
            function clearText(field)
            {
                if (field.defaultValue == field.value)
                    field.value = '';
                else if (field.value == '')
                    field.value = field.defaultValue;
            }


        </script>

    </head>
    <body>

        <div class="container">
            <div class="row">
                

            </div>
            <div class="row">
                
            </div>

            <!--..........-----------------------MENU---------------------.......-->

            <div class="row">
                
            </div> 

            <!--.............................MENU................................-->  

        </div>







        <div class="container">


            
<?php echo $content; ?>

                   

        </div>
        <div>

        </div>


    </body>
</html>


<?php } ?>
