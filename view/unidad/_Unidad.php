<script type="text/javascript" src="lib/alertify.js"></script>
<link rel="stylesheet" href="themes/alertify.core.css"  type="text/css"/>
<link rel="stylesheet" href= "themes/alertify.default.css"  type="text/css"/>

   <?php  $conta = 11;
   foreach ($rows as $key => $value) {
        ?>  
      Unidad <?php echo $conta-10; ?>: <?php echo $value[0]; $cu =$value[1] ?>

      <div class="table-responsive">
          
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








