           <input  type="hidden" id="curs" value="<?php echo $value[5] ;?>"/>
            <input type="hidden" id="semes" value="<?php echo $value[4] ; ?>">
              <br>

          <button id="biblio" type="button" class="btn btn-default" onClick="bib()">Agregar</button> 

                   <table id="bibl" class='table table-hover table-bordered' style="width:800px; margin-left:-70px;">
                            <thead>
                              <tr style='background-color:#EAF8FC;font-size:12px;text-transform:uppercase;color:#000'>
                              <th>tipo de bibliografía</th>
                              <th>Descripción</th>
                              <th>Eliminar</th>
                              </tr>
                            </thead>

                            <tbody>

                                 <?php $asd=1; foreach ($rows2 as $key => $value)  { 
                                       if ($value[1]==$idsilak) {
                                     
                                  ?>
                                <input type="hidden" class="idbibliog<?php echo $asd;  ?>" value="<?php echo $value[0]?>" />
                                  <tr class="dtp">
                                    <td width="10%">
                                      <?php 
                                        echo "<select name='descripcion_tipobibliografia' style='width:100px;' class='form-control' id='idtipo_bibliografia'>";
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

                                    <td><input type='text' id="<?php echo $asd; $asd++;?>"   name='descripcionBibio[]' value="<?php echo $value[2]; ?>"
                                      class='text ui-widget-content ui-corner-all' style='width: 100%; text-align: left;'/>
                                    </td>
                                    <td width="50px"><p class="col-md-1 eli" onclick="eliBib(<?php echo $value[2]; ?>)" title="eliminar bibliografia"><i class="fa fa-trash-o"></i></p></td>
                                  </tr>
                        <?php }   }?>
                            </tbody>
                    </table>

                    <script type="text/javascript">
                    $(document).ready(function(){
                        $('.dtp input').blur(function(){
                            id= $(this).attr('id');
                            edit= $(this).val();
                            idb= $('.idbibliog'+id).val();
                           $.post('index.php', 'controller=cursosemestre&action=editarBiblio&Bibliografia='+idb+'&Editar='+edit, function(data) {
                            alertify.success("Se guardaron sus cambios");  
                          }); 
                      });

                        $('.dtp select').change(function(){
                            edit= $(this).val();
                            campo= $(this).attr('id');
                            idb= $('#idbibliok').val();
                            //alert("olassssii  "+ campo + "  " +idb+ "  " + edit);
                           $.post('index.php', 'controller=cursosemestre&action=editarBiblio_tipo&Campo=' +campo+
                                                '&Bibliografia='+idb+'&Editar='+edit, function(data) {
                                                  alertify.success("Se guardaron sus cambios");  
                          });
                      });
                    });
                </script>