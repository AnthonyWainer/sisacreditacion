<style>
     #ola .tnota{
        padding: 0px;
        width: 38px; 
        
    }
    #ola .tnota input{
        font-size: 10px;
        padding: 1px 8px;
        height: 30px;
        border: none;
    }
    .colorD{
        color:red;
    }
    .colorA{
        color:blue;
    }

</style>
<br>
<div class="row">
                    

    <div class=" col-md-10  ">
<br>
 <div class='container-fluid' style="overflow-y: auto; height:270px; width: 650px">

 
        <table class="table table-hover table-bordered ola" >
            <thead>
                <tr>
                <?php  foreach ($rows as $key => $value) {?>
                <th> <?php echo $value[0]; ?> 
                    
                </th>
                
                <?php } ?>

                <th>PI</th>
                <th>TUTORIA</th>
                <th>Identifi. Institu</th>

                <th>NOTA FINAL</th>
                </tr>
                
            </thead>
            <tbody>
                <tr>
                <?php $i=1; foreach ($rows as $key => $value2) {?>
                <td class="Uni tnota"> <input class="as form-control nota" id="A<?php echo $i; $i++; ?>" type="text" name="<?php echo $value2[2]; ?>"   namee="<?php echo $value2[3]; ?>"value="<?php echo (int)$value2[1]; ?> " placeholder="">
                </td>
                
                <?php } ?>
               
                <?php $a=0;  $p=0;
                    foreach ($rows1 as $key => $value1) { 
                            if ($_SESSION['idusuario'] == $value1[3])        { ?>
                             <?php  $a++;  $p += (int)$value1[1]; ?>
                            <?php } ?>
                     <?php }  ?>

                <td> <input type="hidden" id="nota_py" value="<?= (int)($p/$a);?>"><?php echo (int)($p/$a); ?></td>
                <td><input type="hidden" id="nota_t" value="<?= $nota_tutoria?>"><?=$nota_tutoria;?>
                    <input type="hidden" value="0">
                </td>
                <td><input type="hidden" id="nota_ii" value="<?=$rows_nota_identificacion_insti;?>"><?=$rows_nota_identificacion_insti;?>
                    <input type="hidden" value="0">
                </td>

                <td id="total" >
                    
                </td>
                </tr>
                
            </tbody>
        </table>
         
      </div>
      </div>             
</div>

<script>
$('.nota').live('keyup' ,function(){
  rangoNumeros($(this).val(),$(this));
});
function rangoNumeros(nro,input){
        if(nro>=0 & nro<=20){
         // alertify.log("esta en el rango")
        }else{
          input.val("");
          alertify.log("por favor ingrese un numero mayor igual a '0' o menor igual a '20'");
        }
}
    nroColumnas= $(".ola tbody tr td").length-4;
    a=0;
    for (var i = 1; i <= nroColumnas; i++) {
        nota = $('#A'+i).val();
        por= parseFloat($('#A'+i).attr('name'));
        por2= parseFloat($('#A'+i).attr('namee'));
        a+= parseInt(( nota * por * por2 )/10000);
        
    }
     nota_py=$("#nota_py").val();
     nota_t=$("#nota_t").val();
     nota_ii=$("#nota_ii").val();
     p_=(eval(nota_py)+eval(nota_t)+eval(nota_ii))/3; 
    $('#total').text((a*0.9+p_*0.1).toFixed(0));

    $(".as").blur(function(){
        nroColumnas= $(".ola tbody tr td").length-3;
    a=0;
    for (var i = 1; i <= nroColumnas; i++) {
        nota = $('#A'+i).val();
        por= parseFloat($('#A'+i).attr('name'));
        por2= parseFloat($('#A'+i).attr('namee'));
        a+= parseInt(( nota * por * por2 )/10000);
    }
    $('#total').text(a);
    });
</script>