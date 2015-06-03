<script type="text/javascript" src="lib/alertify.js"></script>
<link rel="stylesheet" href="themes/alertify.core.css"  type="text/css"/>
<link rel="stylesheet" href= "themes/alertify.default.css"  type="text/css"/>
<link rel="stylesheet" href="http://fontawesome.io/assets/font-awesome/css/font-awesome.css">


<select name="" class="form-control" id="ev00" onchange="ev00()" >
   <?php  $conta = 11;
   foreach ($rows as $key => $value) {
        ?>  
  <option value="<?php echo $value[1]; ?>">Unidad <?php echo $conta-10; ?>: <?php echo $value[0]; ?></option>
<?php $conta = $conta + 1;}?>
</select>
<h4>EVALUACIÓN</h4> 
<div class="eva2"></div>

 
<script>

function eva(unidad){
  $.post('index.php', 'controller=cursosemestre&action=getEvaluacion&Codigo=' +unidad, function(data) {
      $(".eva2").empty().html(data);
      //alert(data);
  });
}


$("#eva00").change(function(){
  uni = $(this).val();
  eva(uni);
});
  
uni = $("#ev00").val();
eva(uni);

  




</script>



