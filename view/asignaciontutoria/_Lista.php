 <!--<a href="javascript:window.print()">imprimir</a>-->
 <script>
 $(function(){
    $(".links").click(function(){
        str= $(this).attr("id"); 
        str=str+'&controller=asignaciontutoria&action=mostrar_alumnos_asignados&CodigoProfesor=0700015';
              $.get('index.php',str, function(data) {
                  console.log(data);
                  $("#Mis_companeros_tutoria").empty().append(data);
      });
    });
 });
 </script>
<style type="text/css">
    #criterio{visibility: hidden;} #q{visibility: hidden;} input{visibility: hidden;}
</style>
<div class="div_container" id="Mis_companeros_tutoria" align="center">
  <?php if($List_sin_cabecera==false){?>  <h2 class="ui-widget-header">ALUMNOS ASIGNADOS AL DOCENTE: <?php echo $_GET['prof']; ?><br> EN EL SEMESTRE : <?php echo $semestre; ?> - CANTIDAD DE ALUMNOS : <?php echo $catidadalumnos;?></h2>
  <?php } echo $grilla; ?>
</div>