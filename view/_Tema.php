<style>
    .F textarea{
        white-space:normal; 
    }
</style>

<table class="table table-striped table-bordered" align="justify">
    <thead class="mloencontre">
        <tr>
            <th vertical-align="middle"><b>Semana</b></th>
            <th vertical-align="middle"><b>Contenido</b></th>
            <th vertical-align="middle"><b>Concepto</b></th>
            <th vertical-align="middle"><b>Procedimiento</b></th>
            <th vertical-align="middle"><b>Actitudinal</b></th>
        </tr> 
    </thead>
    <tbody style="background-color: #f5f5f5 ;">
    <?php $fi=1; foreach ($rows as $key => $value) { ?>

        <tr class="F F<?php echo $fi ?>" >

            <td ><?php echo (utf8_encode($value[0]));?></td>
            <td class="F<?php echo $fi?>C1">
                <input class="Tem" type="hidden" value="<?php echo $value[5];?>"> 
                <input class="Cam" type="hidden" value="contenido"> 
                <textarea id="F<?php echo $fi?>C1" name="txta" cols="40%" rows="5" style="background-color: #f9f9f9; ;border:none; resize: none;">
                    <?php echo $value[1];?>
                </textarea> 
            </td>

            <td class="F<?php echo $fi?>C2">
                <input class="Tem" type="hidden" value="<?php echo $value[5];?>"> 
                <input class="Cam" type="hidden" value="conceptual"> 
                <textarea name="" id="F<?php echo $fi?>C2" cols="40%" rows="5" style="background-color: #f9f9f9; border:none; resize: none;">
                <?php echo $value[2];?>
                </textarea> 
            </td>

            <td class="F<?php echo $fi?>C3">
                <input class="Tem" type="hidden" value="<?php echo $value[5];?>"> 
                <input class="Cam" type="hidden" value="procedimental"> 
                <textarea name="" id="F<?php echo $fi?>C3" cols="40%" rows="5" style="background-color: #f9f9f9; border:none; resize: none;">
                <?php echo $value[3];?>
                </textarea> 
            </td>

            <td class="F<?php echo $fi?>C4">
                <input class="Tem" type="hidden" value="<?php echo $value[5];?>"> 
                <input class="Cam" type="hidden" value="actitudinal"> 
                <textarea name="" id="F<?php echo $fi?>C4" cols="40%" rows="5" style="background-color: #f9f9f9; border:none; resize: none;">
                <?php echo $value[4];?>
                </textarea> 
            </td>


        </tr> 
        <?php $fi++; } ?>
    </tbody>
</table>

<script type="text/javascript">
    $(document).ready(function(){
        //alert($('tbody .F').length);
        $('.F textarea').blur(function(){
            Edit= $(this).val();
            abc= $(this).attr('id');
            Cam= $('.'+abc+' .Cam').val();
            Tem= $('.'+abc+' .Tem').val();
           $.post('index.php', 'controller=cursosemestre&action=editarTema&Campo=' +Cam+'&Tema='+Tem+'&Editar='+Edit, function(data) {
            alertify.success("dato ingresado");  
            });
        });

    });
</script>