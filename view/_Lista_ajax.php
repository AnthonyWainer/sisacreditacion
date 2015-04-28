<?php $i=1; ?>
<div class="pn2"></div>
<div class="effect" id="byesyllabus">
<style>
    .list-group{

    box-shadow:0px 0px 10px 0px red;
    }
</style>

<?php foreach ($rows as $key => $value) { $cccu=$value[0]; 
    $cur = utf8_encode(strtoupper($value[1]));
    $credito =(int)$value[3]; $plan=utf8_encode(strtoupper($value[4])); ?>

<div id="<?php echo $i; $i++; ?>" class="lc" style="width:150px; " >
        <div class="list-group" style="margin-left: 17px; border-radius: 10px; 
            <?php 
            if(isset($_SESSION["perfil"]) && ($_SESSION["perfil"] == 'PROFESOR')){
            if (isset($rows2)) {
                     foreach ($rows2 as $key => $value) {  
                        if($value[0]==$cccu){
                             echo 'box-shadow:0px 0px 10px 0px skyblue;';
                        }else{echo '';}
                       }
             }else{
                echo 'box-shadow:0px 0px 10px 0px skyblue;';
             }
            }
               if (isset($rows3)) {
                 
                     foreach ($rows3 as $key => $value222) {  
                        if($value222[0]==$value[0]){
                             echo 'box-shadow:0px 0px 10px 0px skyblue;';
                        }else{echo '';}
                       }
               } 
            

             ?>;"
         title="<?php echo $plan?>">
            
            <?php if(isset($_SESSION["perfil"]) && ($_SESSION["perfil"] == 'ALUMNO')){?>
            
            <p style="font-size:8.4px; border:none"class="list-group-item vcc">
                <?php echo $cur; ?>
                <!-- <b>Docente:</b><?php // echo (utf8_encode(strtoupper($value[2]))); ?> -->
                  <span class="badge" title="creditos" style="background: skyblue; margin-top:-20px; margin-right: -19px;">
                     <?php echo (int)$value[2];?> 
                  </span>  
            </p>
            <?PHP }?>
             
         
            <?php if(isset($_SESSION["perfil"]) && ($_SESSION["perfil"] == 'PROFESOR')){?>
            <a href="#" style="font-size:8.4px;  border:none" class="list-group-item vcc">
            <?php echo $cur; ?>
           <span class="badge" title="creditos" style="background: skyblue; margin-top:-30px; margin-right: -19px;">
             <?php echo $credito; ?> 
           </span>  

            </a>
             <?php }?>
         
         <div>
                <?php if(isset($_SESSION["perfil"]) && ($_SESSION["perfil"] == 'ALUMNO')){?>
                    
                <input  type="hidden" class="semestre" value="<?php echo $value[4]?>"/> 
                <input  type="hidden" class="curso" value="<?php echo $value[3]?>"/> 
                <a onclick="Ver('<?php echo $cccu;?>')" style="font-size:10px; align:center; padding:2px 2px ;" class="btn btn-primary btn-xs">syllabus</a>
                 <a onclick="VerSyllabus('<?php echo $_SESSION['idusuario'];?>','<?php echo $cccu;?>')" style="font-size:10px; align:center; padding:2px 2px ;" class="btn btn-primary btn-xs">notas</a>

              <?php }?>
            <?php if(isset($_SESSION["perfil"]) && ($_SESSION["perfil"] == 'PROFESOR')){?>
                
                <a onclick="Ver('<?php echo $cccu;?>')" style="font-size:10px; align:center; padding:2px 2px ;" 
                id="" name="" class="btn btn-primary btn-xs">lista</a>
                <a onclick="VerRegistro('<?php echo $cccu?>')" style="font-size:10px; align:center; padding:2px 2px ;" 
                id="" name="" class="btn btn-primary btn-xs">registro</a>
                <a onclick="VerSi('<?php echo $cccu?>','<?php echo $id; ?>')" style="font-size:10px; align:center; 
                padding:2px 2px ;" id="" name="" class="btn btn-primary btn-xs">sylabus</a>
                <a onclick="VerAsistencia('<?php echo $cccu?>')" style="display:none; font-size:10px; align:center;
                 padding:2px 2px ;" title="desabilitado por el momento"  class="btn btn-primary btn-xs">asistencia</a>
             <?php }?>
        </div>  
        </div> 
    </div>  

<?php  }?>
</div>
<div class="pn1" width="170px" heigth="20%" style="display: none">
</div>
<span style="cursor:pointer; margin-left:-60px; top:-15px; display: none" title="desplazar" class="glyphicon glyphicon-chevron-down sp1" ></span>
<style type="text/css">
.circ{
    border-radius: 50%; height: 10px; width: 10px;
    background-color: red;
    margin-left: 20px;
    float: left;
}
.spsil{
    margin-left: -150px;
}
</style>
<?php if(isset($_SESSION["perfil"]) && ($_SESSION["perfil"] == 'PROFESOR')){ ?>
<div class="dvsil" style="cursor:pointer; font-size: 8px; "><div class="circ"></div><span class="spsil">silabo vacio</span
></div>
<div class="dvsil" style="cursor:pointer; font-size: 8px; "><div class="circ" style="background: skyblue"></div><span class="spsil">silabo lleno</span
></div>
<?php } ?>
<?php if(isset($_SESSION["perfil"]) && ($_SESSION["perfil"] == 'ALUMNO')){ ?>
<div class="dvsil" style="cursor:pointer; font-size: 8px; "><div class="circ"></div><span class="spsil">silabo vacio</span
></div>
<div class="dvsil" style="cursor:pointer; font-size: 8px; "><div class="circ" style="background: skyblue"></div><span class="spsil">silabo lleno</span
></div>
<?php } ?>
<script>
$(document).ready(function(){
  $('.sp1').click(function(){
    $('.pn1').slideToggle('slow');
  });
  tndiv= $('.lc').length;
  
  $('.lc').click(function(){
    $('.sp1').css("display","");
    $('.dvsil').css("display","none");
     tidp= $(this).attr('id');
     for (i = 1; i <= tndiv; i++) {
         if (i==parseInt(tidp)) {
            $('#'+i).appendTo('.pn2');
         }else{
            $('#'+i).appendTo('.pn1');
         }
         $('.pn1').css("display","none");
     }
  });
})
</script>