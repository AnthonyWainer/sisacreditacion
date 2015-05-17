<script>
    $(function() {
        $(".wrapper-search").html('');
         
    });
</script>
<div class="div_container"  align="center">
<?php if(!empty($control['rows'])){  ?> 
    <script>document.getElementById("identificador_editar").value = true;  </script>

<?php } echo $grilla; 
//print_r( $control['rows'][0]['asistencia_alumno']);
?>
</div>