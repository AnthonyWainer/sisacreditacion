<script type="text/javascript" src="lib/alertify.js"></script>
<link rel="stylesheet" href="themes/alertify.core.css"  type="text/css"/>
<link rel="stylesheet" href= "themes/alertify.default.css"  type="text/css"/>
<link rel="stylesheet" href="http://fontawesome.io/assets/font-awesome/css/font-awesome.css">

<style>
    .codunidad:hover{
        background: #eaf8fc;
        height: 32px;
    }
    .codunidad{
        height: 32px; 
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
            foreach ($rows as $key => $value) {
        ?>  
<br>
<div class="panel panel-default col-md-12  "  >
    <p class="col-md-3" style="width: 18%;">UNIDAD <?php echo $conta-10; ?> : </p>
    <div class="panel-heading codunidad tamañodeuni col-md-8"   id="<?php echo $conta+20; ?>">
    <input type="hidden" class="idunidad<?php echo $conta; ?>" value="<?php echo $value[1]; ?>">
                <h4 class="panel-title" id="hola" style="text-align: center; " >
                    <a data-toggle="collapse"  data-parent="#accordion" style="text-decoration: none; font-size: 11px"
                     href="#<?php echo $conta; ?>" >
                        <p class="col-md-12" title="abrir unidad" data-toggle="modal" data-target="#myModal2"><?php echo utf8_encode($value[0]); ?></p>
                    </a>
                    
                </h4>
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
    </div>
<p class="col-md-1 eli" onclick="eliUni(<?php echo $value[1]?>)" title="eliminar unidad"><i class="fa fa-trash-o"></i></p>
</div>

<?php $conta = $conta + 1;}?>

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
            <div class="panel-body temas"></div>
         </div>
        <div class="kmodal-footer" style="text-align: left;">
            <div class="evaluacion"></div>
         </div>
      </div>
   </div>
</div>
 
<script>
function eliUni(id){
    alert("huanaco"+id);

}

$(document).ready(function(){


var tamañodeuni= $(".tamañodeuni").length;
$('.codunidad').live("click",function(){
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
            $.post('index.php', 'controller=cursosemestre&action=getEvaluacion&Codigo=' +unidad, function(data) {
                $(".evaluacion").empty().append(data);
            });
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

