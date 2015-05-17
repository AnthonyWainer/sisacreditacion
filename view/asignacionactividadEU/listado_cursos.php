<?php // print_r($row); ?>
<script>
    $(function() {
$("#ok").click(function() {
//            var checkboxValues = new Array();
//            //recorremos todos los checkbox seleccionados con .each
//            $('input[name="orderBox[]"]:checked').each(function() {
//                //$(this).val() es el valor del checkbox correspondiente
//                cur = $(this).attr("cur");
//            //	checkboxValues.push(cur+$(this).val());
//                checkboxValues.push(cur);
//            }); alert(checkboxValues);
        });
      
    });
</script>
<input type="hidden" id="cod_profesor" value="<?php echo $row[0]['CodigoProfesor']?>">
<table id="lista_cursos" class="display table table-hover" cellspacing="0" width="100%">
    <thead>
        <tr>
            <th>Codigo Cursos</th>
            <th>Curso</th>
            <th>Chek</th>
        </tr>
    </thead>
    <tfoot>
        <tr>
            <th>Codigo Curso</th>
            <th>Curso</th>
            <th>Chek</th>
        </tr>
    </tfoot>
    <tbody>
        <?php
        foreach ($row as $key => $value) {if($value['asignado']=='yes'){$chekP='checked';}else{$chekP='';}
            echo "<tr>";
            echo "<td>" . $value['CodigoCurso'] . "</td>";
            echo "<td>" . utf8_encode($value['DescripcionCurso']) . "</td>";
            echo "<td><input type='checkbox' cur='". $value['CodigoCurso'] ."' name='orderBox[]' value='1'".$chekP." ></td>";
            echo "</tr>";
        }
        ?>
<!--            <tr>
            <td></td>
            <td></td>
            <td><input type="checkbox"></td>
        </tr>-->
    </tbody>
</table>