<script type="text/javascript">
    $(function(){
        $( "#q" ).focus();
        
    });
    function delete_reg(controller,id)
    {
       if(confirm("Realmente deseas eliminar este registro"))
                {
                    href = "index.php?controller="+controller+"&action=delete&id="+id;
                    window.location = href;
                } 
    }
</script>
<?php 
//    $action = "index";
//    if($edit==false && $view==false) {$action = "search";}
    $action = $_GET['action'];
    $controller = $_GET['controller'];
?>
<div class="contain">
<div class="wrapper-search" style="margin: 0 auto; width: 83%; margin-bottom: 10px;">
    <form action="" method="GET">
        <input type="hidden" name="controller" value="<?php echo $controller; ?>" />
        <input type="hidden" name="action" value="<?php echo $action; ?>" />
        <input type="hidden" name="p" value="1" />
        <?php echo $combo_search; ?>
        <input type="text" name="q" id="q" class="text ui-widget-content ui-corner-all " value="<?php echo $_GET['q']; ?>" style="width: 50%; margin-left: 3px; margin-top: 5px; margin-bottom: 3px; " />
        <input type="submit" value="Buscar" class="ui-button ui-widget ui-state-default ui-corner-all ui-button-text-only ui-state-hover"   />
        <?php if($new) { ?>
        <a href="index.php?controller=<?php echo $name; ?>&action=create" class="button" style="width: 5%" > Nuevo </a>
        <?php } ?>
    </form>
</div>
<div class="wrapper-grid ui-corner-all">
<table class="ui-widget ui-widget-content" style="width: 100%;">
    <thead class="ui-widget ui-widget-content" >
        <tr class="ui-widget-header tr-head" >
            <?php foreach($cols as $c) { ?>
            <th ><?php echo strtoupper($c); ?></th>
            <?php } 
            
            if($ver_detalles){echo '<th align="center">Ver Detalles</th>';}
            if($edit) {echo '<th >editar</th>';}
            if($view) {echo '<th >eliminar</th>';}
            if($select) {echo '<th >&nbsp;</th>';} 
            if($unirse){echo '<th align="center">Unirse</th>';}
            if($unirse_profesor){echo '<th align="center">Unirse</th>';}
            ?>            
            </tr>
        </thead>
        <tbody >
        <?php 
        $n = 0;
         foreach ($rows as $value) { 
          $n ++;
           echo '<tr>';
           $myselect = "<td align='center' width='5%'><a title='Seleccionar' href='javascript:get(";
           $cont = count($cols);
              foreach($cols as $key => $c)
              { 
                  if($key==0){echo "<td class='td-".($key+1)."' align=center width=5%>".$value[$key]."</td>";}
                  else {echo "<td class='td-".($key+1)."'>".utf8_encode($value[$key])."</td>";}
                  if($cont==($key+1)) {$myselect .= '"'.trim($value[$key]).'"';}
                    else {$myselect .= '"'.trim($value[$key]).'",';}
              }
           $myselect .= ")'><img src='images/front.png' /></a></td>";
          
           
           
           if($ver_detalles){
               ?>
        <td align="center" width="5%" ><a style="color:blue;" href="index.php?controller=<?php echo $name; ?>&action=show_detalles&id=<?php  echo $value[0]; ?>" title="Ver Detalles" class="glyphicon glyphicon-chevron-down" ></a></td>
                <?php
           }
              if($edit) 
              { 
                ?>
                    <td align="center" width="5%" ><a href="index.php?controller=<?php echo $name; ?>&action=edit&id=<?php  echo $value[0]; ?>" title="Editar"><img alt="" src="images/edit.png" /></a></td>
                <?php
              }
              if($view) {
                  ?>
                   <td align="center" width="5%"  ><a href="javascript:delete_reg('<?php echo $name; ?>','<?php  echo $value[0]; ?>')" title="Eliminar"><img alt="" src="images/delete.png" /></a></td>
                  <?php 
              }
              
              if($select) {
                  echo $myselect;
              }
              
              if($unirse){
               ?>
        <td align="center" width="5%" ><a href="index.php?controller=<?php echo $name; ?>&action=unirse_evento&id=<?php  echo $value[0]; ?>" title="Unirse"><img src="../web/images/add.png"></a></td>
                <?php
           }
           if($unirse_profesor){
               ?>
        <td align="center" width="5%" ><a href="index.php?controller=<?php echo $name; ?>&action=unirse_profesor_evento&id=<?php  echo $value[0]; ?>" title="Unirse"><img src="../web/images/add.png"></a></td>
                <?php
           }
              echo '</tr>';
          } 
        
          
          
          for($i=0;$i<($nr-$n);$i++)
          {
            echo "<tr>";                    
            foreach($cols as $c) { ?>
              <th >&nbsp;</th>
            <?php } 
            if($ver_detalles) {echo '<th >&nbsp;</th>';}
            if($edit) {echo '<th >&nbsp;</th>';}
            if($view) {echo '<th >&nbsp;</th>';}
            if($select) {echo '<th >&nbsp;</th>';}
            if($unirse) {echo '<th >&nbsp;</th>';}
            //creo que falta lo de la linea anterior en $unirse_profesor
            echo "</tr>";
          }          
       ?>        
    </tbody>    
</table> 
</div>    
</div>
<?php echo $pag; ?>