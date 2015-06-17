<?php include("../lib/functions.php"); ?>
<script type="text/javascript" src="js/app/evt_form_alumno.js" ></script>
<script type="text/javascript" src="js/validateradiobutton.js"></script>

<div class="div_container">
    <h6 class="ui-widget-header">Registro de oficina</h6>

    <form id="frm" action="index.php" method="POST">
        <input type="hidden" name="controller" value="alumno" />
        <input type="hidden" name="action" value="save" />
        <?php $id=$_GET['id'];?>
        <input type="hidden" name="id" value="<?php echo "$id"; ?>" />
        <div class="contFrm ui-corner-all" style="background: #fff;">
            <div class="contenido" style="margin:0 auto; width: 750px; " align="center">
                
                
                <div id="tabla">

                 <?php echo $grill; ?>
                 </div>
            </div>


        </div>
    </form>
</div>
