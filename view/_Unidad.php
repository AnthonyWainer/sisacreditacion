<script type="text/javascript" src="lib/alertify.js"></script>
<link rel="stylesheet" href="themes/alertify.core.css"  type="text/css"/>
<link rel="stylesheet" href= "themes/alertify.default.css"  type="text/css"/>
<link rel="stylesheet" href="font-awesome-4.3.0/css/font-awesome.css">

<style>
    .codunidad01:hover{
        background: #eaf8fc;
        height: 42px;
    }
    .codunidad01{
        height: 42px; 
        color: black;
        padding-top: 10px;
        border-radius: 5px;
        box-shadow: 0px 0px 5px 0px rgb(20, 122, 126);
    }
    .enUni{
        display: none;
    }
    .eli{
       color:red;
       font-size: 22px;
       cursor: pointer;
    }
    .eli:hover{
       color: blue;
    }

</style>
        <?php  $conta = 11;
$nros=0;
$porc=0;
foreach ($rows as $key => $value) {
  $nros += $value[7];
  $porc += $value[6];
}        
#echo "numero de semanas = ".$nros;
function sem($sema,$s,$por){
    if ($sema<$s) {
      ?>
      <br>
      <input type="text" placeholder="nombreunidad" class="nombreU">
      <label for="">nro: temas</label>
      <input type="number" style="width:50px;" class="nroT" value="<?php echo $s-$sema; ?>" placeholder="">
      <label for="">porcentaje: </label>
      <input type="number" style="width:50px;" class="porc"  value="<?php echo 100-$por; ?>" placeholder="">
      <button type="button" class="btn btn-default agU">agregar Unidad</button>
      <?php
    }else{
      #echo "ya esta lleno";
    }
}
              foreach ($uni as $key => $value) {
                $semanas= floor((strtotime($value[1])-strtotime($value[0]))/604800);
                if ($semanas<=8) {
                 sem($nros,8,$porc);
                }else{
                  sem($nros,18,$porc);
                }
                #echo "<br>semanas totales= ".$semanas;
              }



            foreach ($rows as $key => $value) {
              if ($value[0] != "unidad 0") {



        ?>  
   
    <input type="hidden" id="CU" name="" value="<?php echo $value[1]?>">
    <input type="hidden" class="idunidad<?php echo $conta; ?>" value="<?php echo $value[1]; ?>">

      <div class="codunidad01 tamañodeuni01 rows"   id="<?php echo $conta+20; ?>">
        <p class="col-md-3">Unidad <?php echo $conta-10; ?> : </p>
        <h4 id="hola" class="col-md-7" style="text-align: center; margin-top: -0px;">
            <a style="text-decoration: none; color:black" href="#<?php echo $conta; ?>" >
                <p title="abrir unidad" data-toggle="modal" data-target="#myModal2"><?php echo utf8_encode($value[0]); ?></p>
            </a>
        </h4>
      <p class="eli col-md-2" onclick="eliUni(<?php echo $value[1]?>)" title="eliminar unidad"><i class="fa fa-trash-o"></i></p>
      </div>
<br>

    <table class="table enUni" id="en<?php echo $conta; ?>">
            <input type="hidden" id="idunik" value="<?php echo $value[1]?>" />            
            <thead>
              <tr>
                <th style="padding: 0px">
                  <h4> UNIDAD <?php echo utf8_encode($value[1]); ?> : 
                    <input class="k1 kuninomb" id="nombreunidad" type="text" value="<?php echo utf8_encode($value[0]); ?>" style="background-color: #EAF8FC; border:none; width: 100%"/>
                  </h4>
                </th>
                <th> 
                  <h5> 
                    Porcentaje:
                    <?php echo utf8_encode($value[6]); ?>%
                  </h5>
                </th>
              </tr>
            </thead>
            <tbody style="background: #f9f9f9">
              <tr>
                <td>
                <strong>Descripcion:</strong> <br>
                <textarea id="descripcionunidad" class="k1" cols="80%" rows="4" style="white-space:normal; background-color: #f9f9f9; ;border:none; resize: none;">
                  <?php echo utf8_encode($value[4]); ?>
                </textarea> 
                </td>
                <td>
                <strong>Competencia:</strong><br>
                <textarea id="competencia" class="k1" cols="80%" rows="4" style="white-space:normal; background-color: #f9f9f9; ;border:none; resize: none;">
                <?php echo utf8_encode($value[5]); ?>
                </textarea> 
                </td>
              </tr>
            </tbody>
        </table>

<?php $conta = $conta + 1;} }?>

<div class="modal fade" id="myModal2" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
   <div class="modal-dialog" style=" width: 90%;">
      <div class="kmodal-content">
        <div class="kmodal-header" style="height: 180px">
           <h5 id="myModalLabel" class="modal-title mtl" ></h5>
           <h1 style="display:none" class="modal-title2" ></h1>
          <button type="button" class="close" data-dismiss="modal" style="margin-top: -180px" title="cerrar">
            <span aria-hidden="true">&times;</span>
            <span class="sr-only">Close</span>
          </button>

        </div>
         <div class="modal-body2">
            <div class="panel-body temas"  style="overflow: scroll; height: 300px;"></div>
         </div>
        <div class="kmodal-footer" style="text-align: left;">
            <h4>EVALUACIÓN</h4> 
            <div class="evaluacion"></div>
         </div>
      </div>
   </div>
</div>
 
<script>
$(".agU").click(function(){
  idsi = $("#silabo").val();
  nombre = $(".nombreU").val();
  nroT = $(".nroT").val();
  porc = $(".porc").val();
  $.post('index.php', 'controller=unidad&action=create&idsilabo=' +idsi+'&nombreunidad='+nombre+'&duracion='+nroT+'&porcentaje='+porc, function(data) {
        unidad();
        alertify.success("SE INSERTO UNIDAD");  
  });
});


function eva(unidad,tip){
  $.post('index.php', 'controller=cursosemestre&action=getEvaluacion&Codigo=' +unidad, function(data) {
      $(".evaluacion").empty().append(data);
      $(".ag").attr('onclick','hol('+unidad+')');
  });
}
function hol(uni){
  p = $("#Poreva").val();
  $.post('index.php', 'controller=evaluacion&action=insertEvaluacion&idunidad=' +uni+'&ponderado='+p, function(data) {
      eva(uni);
  });
}

function eliUni(id){
    //alert("huanaco"+id);
    alertify.confirm("¿ESTÁS SEGURO DE ELIMINAR LA UNIDAD?", function (e) {
    if (e) {
        $.post('index.php', 'controller=unidad&action=delete&id=' +id, function(data) {
            unidad();
            alertify.success("UNIDAD ELIMINADA");  
        });
    } else {
        alertify.success("UNIDAD NO ELIMINADA");  
    }
    });
}

$(document).ready(function(){


var tamañodeuni= $(".tamañodeuni01").length;
$('.codunidad01').live("click",function(){
        tip= $(this).attr('id');
        for ( y = 11; y <= (parseInt(tamañodeuni)+10); y++) {
        if (y == (parseInt(tip)-20)) {
            $('#en'+y).appendTo('.modal-title');
            $('.modal-title .table').removeClass('enUni');

            var unidad= $('.idunidad'+y).val();
            var opt='C';
            $.post('index.php', 'controller=cursosemestre&action=getTema&Codigo=' +unidad+'&option='+opt, function(data) {
                $(".temas").empty().append(data);
            });
            eva(unidad);
            
        }else{
          $('#en'+y).appendTo('.modal-title2');
          $('.modal-title2 .table').removeClass('enUni');
        }
      }
    });


        $('.enUni .k1').blur(function(){
        edit= $(this).val();
        campo= $(this).attr('id');
        idu=$('#idunik').val();
        
        //alert(edit + " "+campo + " " + idu);
        $.post('index.php', 'controller=cursosemestre&action=editarUni_nombre&Campo=' +campo+
                                                '&Unidad='+idu+'&Editar='+edit, function(data)
        
        
                   {

                   alertify.success("Se guardaron sus cambios");  
                   });

        });
 /*$('mtl').blur(function(){
    Edit= $(this).val();
    abc= $('#modal-title2').attr('id');
    Cam= $('.'+abc+' .Cam').val();
    Tem= $('.'+abc+' .Tem').val();
    $.post('index.php', 'controller=cursosemestre&action=editarTema&Campo=' +Cam+'&Tema='+Tem+'&Editar='+Edit, function(data) {
    });
 });*/


});



</script>


