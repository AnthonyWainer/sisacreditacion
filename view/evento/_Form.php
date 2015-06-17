<?php include("../lib/functions.php"); ?>
<script type="text/javascript" src="js/app/evt_form_evento.js" ></script>
<script type="text/javascript" src="js/validateradiobutton.js"></script>
<link href="css/formproyecto.css" rel="stylesheet" type="text/css" />
<div class="div_container">
    <h6 class="ui-widget-header">Registro de Tutoria</h6>

    <style>

    fieldset{
        
    -webkit-border-radius: 0 0 20px 20px;
    -moz-border-radius: 0 0 20px 20px;
    border-radius: 0 0 20px 20px;
         border: black 1px solid; 
    padding: 15px 20px;
    
         }
       
       
        h2 {
    
       
    color: #242424;
    font-size: 28px;
    padding: 5px 5px;
    text-shadow: 0 0 0.2em #999999;
}

         h2 span[class*="fontawesome-"] {
    margin-right: 14px;
}
       
        div {
   margin: .3em 0;
}
label {
   width: 20%;
   float: left;
   text-align: left;
   
  
   
}

      
</style>

    
    <form id="frm" action="index.php" method="POST">
        <input type="hidden" name="controller" value="evento" />
        <input type="hidden" name="action" value="save" />
        <div class="contFrm ui-corner-all">
            <div class="transparente" class="contenido" style="margin:0 auto; width: 450px; ">
<!--                <fieldset style="border:6px groove #ccc; background:#CC99FF;"  class="ui-corner-all" >-->

<!--    <table width="100">-->
       
 
 <?php if(isset($_GET['modo_sin_cargo'])){?> <input type="hidden" id="crear_modo_sin_cargo" name="crear_modo_sin_cargo" value="<?php echo $_GET['modo_sin_cargo'];?>"><?php } ?>
<fieldset>
     <table width="100"><legend><h2>Datos</h2></legend>
                   <div class="col-md-12">
                                <div class="col-md-6">
                                    
                          
                                    <big> <label for="idevento" >Codigo</label></big>
                                    <input type="text" class="form-control oblig" placeholder="Codigo" name="idevento" id="idevento" value="<?php echo $obj->idevento; ?>" readonly>
                                </div>  
            
          <div class="col-md-6">
                                        
                         
                       <big><label for="fecha" >Fecha</label></big>
                          
                           
                       <input type="date" min="<?php echo  date("Y-m-d");?>" class="form-control oblig" placeholder="Fecha" name="fecha" id="fecha" value="<?php echo $obj->fecha; ?>">
                                
                       
                                </div>
                        
                <div class="col-md-6">  
                       <big><label for="hora" >Hora</label></big>
                       <input type="time" class="form-control oblig" placeholder="Hora" name="hora" id="hora" value="<?php echo $obj->hora_evento; ?>">
                               </div>
                       
                        <div class="col-md-6">
                                           
                                    <big><label for="tema" >Tema</label></big>
                                
                                    <input type="text" class="form-control oblig" placeholder="Tema" name="tema" id="tema" value="<?php echo $obj->tema; ?>">
                                       
                                    
                                </div>   
            </div>   
      
                             <div class="col-md-12">
                             
                                                            
                              
                            
                       <div class="col-md-6" style="width: 100%;">
                                     <big> <label for="tipo_evento" style="width: 161px;"> Tipo de Evento</label></big>
                                <?php echo $tipo_evento; ?>
                                </div>
                            
                             </div>                         
                  </table>                               
                        
                </fieldset> 
               
                        
                    <div  style="clear: both; padding: 10px; width: auto;text-align: center">
                        <button type="submit" id="añadir" class="btn btn-success glyphicon glyphicon-plus-sign" >AÑADIR</button>
                        <a href="index.php?controller=evento" class="btn btn-primary glyphicon glyphicon-backward">ATRAS</a>
                    </div>
<!--                </table>-->
                 
            </div>
        </div>
    </form>
</div>