<?php include("../lib/functions.php"); ?>
<script type="text/javascript" src="js/app/evt_form_evento.js" ></script>
<script type="text/javascript" src="js/validateradiobutton.js"></script>
<div class="div_container">
<h4 class="ui-widget-header">Tutorias Registradas</h4>
<?php if($_SESSION['cargo']=='Presidente' && $_SESSION['comicion']=='COMISION ESPECIAL DE TUTORIA'){
  // echo "<div align='center'><button style='margin-left:90px;cursor:pointer;' onclick='crear_modo_sin_cargo();'  class='ver btn btn-success btn-xs'>Crear Mi Evento Personal</button></div>";  
}?>
<?php echo $grilla;?>
</div>