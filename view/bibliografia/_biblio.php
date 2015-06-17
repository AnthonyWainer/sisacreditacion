<?php foreach ($rows2 as $key => $v)  { } ?>
<script>
  function bib(ids){
    $.post('index.php', 'controller=bibliografia&action=save&ids='+ids, function(data) {
           bi(ids);
           alertify.success("bibliografia insertada");
    });
  }
  function eliminarBiblio(idb,ids){

    alertify.confirm("¿ESTÁS SEGURO DE ELIMINAR LA BIBLIOGRAFÍA?", function (e) {
    if (e) {
        $.post('index.php', 'controller=bibliografia&action=delete&ids='+idb, function(data) {
               bi(ids);
               alertify.error("bibliografia eliminada");
        });
    } else {
        alertify.log("bibliografia no eliminada");  
    }
    });
  }
      $('.dtp input').blur(function(){
                            id= $(this).attr('id');
                            edit= $(this).val();
                            idb= $('.idbibliog'+id).val();
                           $.post('index.php', 'controller=cursosemestre&action=editarBiblio&Bibliografia='+idb+'&Editar='+edit, function(data) {
                            alertify.success("Se guardaron sus cambios");  
                          }); 
      });

      $('.dtp select').change(function(){
          idb= $(this).attr('id');
          tipo= $(this).val();
        $.post('index.php', 'controller=cursosemestre&action=editarBiblio_tipo&idbibliog=' +idb+'&tipo='+tipo, function(data) {
             alertify.success("Se guardaron sus cambios");  
                          });
                      });

</script>
<div class="col-md-12">
<button id="biblio" type="button" class="btn btn-default" onclick="bib(<?php echo $v[1]; ?>)">Agregar</button> 
<table id="bibl" class='table table-hover table-bordered' style="">
  <thead>
    <tr style='background-color:#EAF8FC;font-size:12px;text-transform:uppercase;color:#000'>
        <th>#</th>
        <th>tipo de bibliografía</th>
        <th>Descripción</th>
        <th>Eliminar</th>
    </tr>
  </thead>

  <tbody>
    <?php $asd=1; foreach ($rows2 as $key => $value)  { 
    ?>
      <input type="hidden" class="idbibliog<?php echo $asd;  ?>" value="<?php echo $value[0]?>" />
      <tr class="dtp">
        <td width="5%"><?php echo $asd; ?></td>
        <td width="10%">
          <?php 
            echo "<select name='descripcion_tipobibliografia' id=".$value[0]." style='width:100px;' class='form-control' id='idtipo_bibliografia'>";
              foreach ($rows5 as $key => $bib){                                       
                  if ($value[3] != $bib[1] ) {
                    echo "<option value='".$bib[1]."'> ".$bib[0]."</option>";
                  } else { 
                    echo "<option selected='selected' value='".$bib[1]."'> ".$bib[0]."</option>";
                  }
              }
            echo "</select>";   
            echo '<br/>';
          ?>      
        </td>

        <td><input type='text' id="<?php echo $asd; $asd++;?>"   name='descripcionBibio[]' value="<?php echo $value[2]; ?>" class='text ui-widget-content ui-corner-all' style='width: 100%; text-align: left;'/>
        </td>
        <td width="50px"><p class="col-md-1 eli" onclick="eliminarBiblio(<?php echo $value[0]; ?>,<?php echo $v[1]; ?>)" title="eliminar bibliografia"><i class="fa fa-trash-o"></i></p>
        </td>
      </tr>
    <?php }   ?>
  </tbody>
</table>
</div>

