<script type="text/javascript" src="lib/alertify.js"></script>
<link rel="stylesheet" href="themes/alertify.core.css"  type="text/css"/>
<link rel="stylesheet" href= "themes/alertify.default.css"  type="text/css"/>

<?php $p=0; foreach ($rows as $key => $value) { 
        $p += $value[6];
    }
    $po = 100-$p;
    if ($po!=0) {  ?>
    <button type="button" class="btn btn-default ag" id="<?php echo $value[8]; ?>">agregar</button>
    <input type="number" id="Poreva" value="<?php echo $po; ?>">

<?php        
    }
?>
<br><br>

   <?php  $conta = 11;
   foreach ($rows as $key => $value) {
        ?>  
      Unidad <?php echo $conta-10; ?>: <?php echo $value[0]; $cu =$value[1] ?>

      <div class="table-responsive">
<?php $pp=0; foreach ($rows1 as $key => $value) {  if ($value[5] == $cu){ $pp += $value[3]; ?>

<?php } 
} 
    $po = 100-$pp;
    if ($po!=0) {  ?>
    <button type="button" class="btn btn-default agE" id="<?php echo $value[5]; ?>">agregar</button>
    <input type="number" id="Poreva" value="<?php echo $po; ?>">

<?php        
    }
?>         
      <table class="table">
        <thead>
          <tr>
            <th>tipo Evaluacion</th>
            <th>Descripcion</th>
            <th>fecha</th>
            <th>ponderado</th>
          </tr>
        </thead>
        <tbody>
      <?php foreach ($rows1 as $key => $value) {  if ($value[5] == $cu){ ?>
            <tr>
              <td >
               <?php 
                     foreach ($eva as $key => $ev) { 
                         if ($value[0] == $ev[0] ) {
                          echo "<p>".$ev[1]."</p>";
                         }
                      }
                  
               ?>    
              </td>
              <td>
              <?php echo (utf8_encode($value[1]));?>
              </td>
              <td>
                      <?php echo (utf8_encode($value[2]));?>
              </td>
              <td>
              <?php echo (utf8_encode($value[3]));?>
              </td>
            </tr>
      <?php } } ?>
        </tbody>
      </table>

      </div>
<?php  $conta = $conta + 1;}?>


<script>
$(".ag").click(function(){
  idsi = $(this).attr('id');
  porc = $("#Poreva").val();
    $.post('index.php', 'controller=unidad&action=create&idsilabo=' +idsi+'&nombreunidad='+'unidad 0'+'&duracion='+0+'&porcentaje='+porc, function(data) {
        alertify.success("SE INSERTO UNIDAD 0");  
        eva111();
  });
});
$(".agE").click(function(){
  idu = $(this).attr('id');
  porc = $("#Poreva").val();
  $.post('index.php', 'controller=evaluacion&action=insertEvaluacion&idunidad=' +idu+'&ponderado='+porc, function(data) {
  alertify.success("SE INSERTO evaluacion");
      eva111();
  });    
});

</script>




