<br>
<!--Partes del  silabo-->

<link rel="stylesheet" href="../web/css/css_edit_silabo.css" />
<script src="../web/js/app/evt_form_edit_silabo.js"></script>  
<link rel="stylesheet" href="../web/css/css.css">   
<script type="text/javascript" src="lib/alertify.js"></script>
<link rel="stylesheet" href="themes/alertify.core.css"  type="text/css"/>
<link rel="stylesheet" href= "themes/alertify.default.css"  type="text/css"/>
<link rel="stylesheet" href="http://fontawesome.io/assets/font-awesome/css/font-awesome.css">
  <?php 
        foreach ($rows as $key => $value) {
        }?>

<!--ALUMNO Comienza-->
           <!--
            <img src='../web/images/check_verde.png' width='15px' title='sílabo completo' style='float: left;  margin-left: -20px; margin-top: -25px;'/>
            <img src='../web/images/error.png' width='15px' title='sílabo completo' style='float: left;  margin-left: -20px; margin-top: -25px;'/> -->
<?php if (isset($_SESSION["perfil"]) && ($_SESSION["perfil"] == 'PROFESOR')) { ?>
    <!--INICIO foreach-->
    <div id="ampliar">
    <ul class="nav nav-tabs" id="myTab" >
        <li class="active"><a href="#obGen" data-toggle="tab" >Objetivos Generales</a></li>
        <li><a href="#unidad" data-toggle="tab" class="unidad">Unidad</a></li>
        <li><a href="#bibliografia" onclick="bi(<?php echo $value[6]; ?>)" data-toggle="tab">Bibliografia</a></li>
        <li><a href="#generarsilabo" data-toggle="tab">Generar Sílabo</a></li>
    </ul> 
    </div>
    <?php 
   if($rows){
    foreach ($rows as $key => $value) { $sem=$value[4]; ?>

        <div class="tab-content col-md-11">
            <div class="tab-pane active" id="obGen" align="justify">
            <br>
             <table class="table table-hover table-bordered" style="width:800px; margin-left:-70px;">
                <tbody>
                   <tr >
                       <td  width="50%"><label>competencia</label>
                       <p id="comp" data-toggle="modal" data-target="#myModal" class="compet"><?php echo ($value[0]) ?></p> 
                       </td>
                       <td >
                         <label>metodologia</label>
                         <p id="met" data-toggle="modal" data-target="#myModal"> <?php echo ($value[1]) ?></p>
                       </td>
                   </tr>
                   <tr>
                       <td >
                         <label>objetivo</label>
                        <p id="ob" data-toggle="modal" data-target="#myModal"> <?php echo ($value[2]) ?></p>
                       </td>
                       <td >
                        <label>sumilla</label>
                        <p id="su" data-toggle="modal" data-target="#myModal"> <?php echo ($value[3]) ?></p>
                       </td>
                   </tr>
                </tbody>
            </table>

            
</div>

        <input type="hidden" id="semestre" value="<?php echo $value[4] ?>"/>
        <input type="hidden" id="curso" value="<?php echo $value[5]; $cursok= $value[5];  ?>"/>
        <input type="hidden" id="silabo" value="<?php echo $value[6]; $idsilak=$value[6]; ?>"/>
<!--        unidad inicio-->
        <div class="tab-pane"  id="unidad" align="justify">
            <div id="unidades"></div>
        </div>
<!--        unidad fin-->

        <div class="tab-pane" id="bibliografia" >
          <input  type="hidden" id="curs" value="<?php echo $value[5] ;?>"/>
          <input type="hidden" id="semes" value="<?php echo $value[4] ; ?>">
          <br>
          <div id="bibliografias"></div>
        </div>
        <div class="tab-pane" id="generarsilabo">
          <br>
          <a class="btn btn-default gensil" title="descargar" target="_blank"
  href='index.php?controller=cursosemestre&action=generarsilabo&CodSemestre=<?php echo $sem ;?>&CodCurso=<?php echo $cursok;?>&CodSilabo=<?php echo $idsilak ;?>'></a>
        </div>
        </div>
<!--        edit fin-->


        <?php }
        }else{

            

         ?>
<form id="frm1" action="index.php?controller=cursosemestre" method="POST">
<input type="hidden" name="controller" value="cursosemestre" />
    <input type="hidden" name="action" value="save" />
    <input type="hidden" name="codemestre" value="<?php echo $_POST["codemestre"]; ?>" >
    <input type="hidden" name="codcurso" value="<?php echo $_POST["Codigo"]; ?>" >
    <input type="hidden" name="coddocente" value="<?php echo $_SESSION['idusuario']; ?>" >
<div class="tab-content col-md-11">
        <div class="tab-pane active" id="obGen" align="justify">
            <br>
            <script src="../web/js/jquery.min.js"></script>
            <script src="../web/js/jquery.autosize.js"></script>
            <script>
               $(function(){
                 $('textarea').autosize();    
               });         
            </script>
            <table class="table">
                <tbody>
                   <tr>
                       <td><label>competencia</label>
                       <textarea id="competencia_1" class="form-control validar" name="competenciaS" required rows="3"> </textarea>
                       </td>
                       <td>
                         <label>metodologia</label>
                         <textarea id="metodologia_1" class="form-control validar" name="metodologia" rows="3"> </textarea>
                       </td>
                   </tr>
                   <tr>
                       <td>
                         <label>objetivo</label>
                         <textarea id="objetivo_1" class="form-control validar" name="objetivo" rows="3"></textarea>
                       </td>
                       <td>
                        <label>sumilla</label>
                        <textarea id="sumilla_1" class="form-control validar" name="sumilla" rows="3"></textarea>
                       </td>
                   </tr>
                </tbody>
            </table>


    </div>  
             
    <div class="tab-pane"  id="unidad" align="justify" >
            <br>
            <button type="button" style="margin-left:40%;" onclick="agregarUni()" class="btn btn-default">
            Agregar</button>
             <button  type="button"class="btn btn-default eliminar">x</button>
            <br>
            <style>
              #tabla textarea{
                margin: 0px;
                border: none;
                font-size: 8px;
                resize: none;
                width: 100%;
                height: 15px;
              }
              #tabla input[type='number']{
                width: 60px;
                margin: 0px;
                border: none;
                font-size: 9px;
                }
            </style>
            <table id="tabla" class='table table-hover table-bordered'>
                <!-- Cabecera de la tabla -->
                <thead>
                  <tr>
                      <th>Nombre</th>
                      <th>Descripción</th>
                      <th>Competencia</th>
                      <th>Duración</th>
                      <th>porcentaje</th>
                      <th>Temas</th>
                  </tr>
                </thead>
               
                <!-- Cuerpo de la tabla con los campos -->
                <tbody>
                   <tr>
                    <td><textarea id='nombreunidad1' class='form-control' name='nombreuni[]'></textarea></td>
                    <td><textarea class='form-control' name='competencia[]'></textarea></td>
                    <td><textarea class='form-control' name='descripcion[]'></textarea></td>
                    <td><input type='number' class='form-control' id='duracion1' value="17" name='duracion[]'/></td>
                    <td><input type='number' id='porcentaje1' class='form-control' name='porcentaje[]' value='100'/></td>
                    <td><button type='button' class='btn btn-default' onClick='semana(1)'>+</button></td>
                  </tr>
                </tbody>
                 
            </table>
            <br>
            <div id='h1'></div>
            <div id="a"></div>
            <div style="display:none">
                  <select  style='width:65%;' class='form-control tipEvaa'>
                      <?php if ($rows4){ 
                          foreach ($rows4 as $key => $value) { ?>
                        ?>
                          <option value='<?php echo $value[0];?>'><?php echo $value[1];?></option>
                       
                      <?php }} ?>
                     </select>
            </div>
        </div>

        <!-- Ingresar bibliografia -->
        <div class="tab-pane" id="bibliografia">
          <br>
          <button id="biblio" type="button" class="btn btn-default" onClick="bib()">Agregar</button>
          <button  type="button"class="btn btn-default eliminarB">x</button>
        <div>

          <table id="bibl" class='table table-hover table-bordered'>
            <thead>
            <tr style='background-color:#EAF8FC;font-size:12px;text-transform:uppercase;color:#000'>
            <th width="200px">tipo de bibliografía</th>
            <th>Descripción</th>
            </tr>
            </thead>

            <tbody>
              <tr class="dtp">
                <td> 
                <?php 
                echo "<select  name='tipbibl[]' style='width:65%; display:;' class='form-control dts'>";
                foreach ($rows5 as $key => $bib){   
                    echo "<option value='".$bib[1]."'>".$bib[0]."</option>";
                  }
                echo "</select>";   
                echo '<br/>'; 
               ?> 
                </td>
                <td><input type='text' id='descripcionBibio' name='descripcionBibio[]' 
                  class='text ui-widget-content ui-corner-all' rows='3' cols='40' style='width: 100%; 
                  text-align: left;' placeholder='Ingresar Descripción'/>
                </td>
              </tr>
            </tbody>
           </table>


        </div> 
    
        </div>
        <div class="tab-pane" id="generarsilabo">
        <br>
          <input type="submit" id="grabar_1" class="btn btn-info" value="Grabar Silabus">
        </div>

</div>


      


</form>

<?php }

        ?> 

    <?php } ?>

<!-- Modal para editar-->
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
   <div class="modal-dialog">
      <div class="kmodal-content">
        <div class="kmodal-header">
          <button type="button" class="close" data-dismiss="modal">
            <span aria-hidden="true">&times;</span>
            <span class="sr-only">Close</span>
            <span id="soyunid" style="display:none"></span>
          </button>
          <h4 class="modal-title" id="myModalLabel"></h4>
         </div>
         <div class="modal-body">
            <textarea name="edits" id="edits"  style="width: 100%; height: 200px" ></textarea>
         </div>
         <div class="kmodal-footer">
           <button type="button" id="guardarS" onclick="guardarre()" data-dismiss="modal" class="btn btn-primary">Guardar</button>
        </div>
      </div>
   </div>
</div>