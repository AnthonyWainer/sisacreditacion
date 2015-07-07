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
<div class="row">
    <div class="col-md-12" id="aumentar">
		<div class='container-fluid' id="grande">
			<form id="formnotas" method="post">
				<table class="table table-hover table-bordered" id="ola" style="margin-left: -100px;width:850px" >
					<thead>   
						<tr style="background-color:#eaf8fc;" > 
							<th>#</th>
							<th>Código</th>
							<th>NOMBRE</th>
							

							<?php $cont=0;foreach ($rows2 as $key => $value) { $idU= $value[9]; ?>
							
							<?php foreach ($rows4 as $key => $value44) {?>
							
								<?php 
									if ($idU== $value44[9]) { ?>
									<th>
									<?php $new_array=explode(' ',$value44[7]);
									$acr='';
									$contad=count($new_array);
									if($contad>1){
										foreach($new_array as $key=>$val){											
											echo $val[0];
										}
									}else{
											echo substr($value44[7],0,3);	
									} ?>
									</th> 
									<?php }			
								}
							?>	
													
							<th>
								<?php 
									$h=$cont+1;
                                                                        echo "U".$h;
								?>
							</th>
                                                      
							<?php $cont=$cont+1;}?>
							<!--<th>Actud.</th>-->
							<th padding="25px 20px" >Promedio</th>
						</tr>
       
					</thead>
					<tbody style="width:100%;">
	
						<?php $cont=1; $i=1; foreach ($rows as $key => $value) {  ?>
						<tr> 
							<td><?php echo $cont; $cont++;?></td>
							<td>
								<?php echo strtoupper(utf8_encode($value[2]));?>
								<input type="hidden" name="idalumno[]" value="<?php echo $value[0] ?>" >
							</td>   
							<td style="font-size:11px;" align="left">
								<?php echo strtoupper(utf8_encode($value[1]));?>
							</td>

							<?php $alum= $value[0];

								date_default_timezone_set();
             					$fechaA= date("d-m-Y");
             					//echo $fechaA;
             					$diaA= date("d");
					            $mesA= date("m");
             					$anioA= date("Y");
             					//echo $diaA;

								if (isset($rows2)){ $j=1;
									foreach ($rows2 as $key => $value) {  

                                            $idU= $value[9]; $por= $value[10];  ?>
										
											<?php if (isset($rows4)){$ev=1;
												foreach ($rows4 as $key => $value5) {
                                                        $ie= $value5[3]; $ponderado= $value5[2]; $noe =  $value5[7];
													//echo $value5[9]; 
													if ($idU== $value5[9]) {

													 ?>
													<td class="tnota U<?php echo $j;?>  U<?php echo $j.'-'.$i.'-'.$ev; $ev++;?>">
													
													<?php #echo $ponderado; 
													$estadoBtn  = $value5[10];
													$fechaE= date("d-m-Y",strtotime($value5[1]));  $diaE= (date("d",strtotime($value5[1]))+7);  $mesE=date("m",strtotime($value5[1])); $anioE=date("Y",strtotime($value5[1]));
													 if (isset($rows3)){ 
													 foreach ($rows3 as $key => $value) { 
													 	 
														 if (($value[0]==$alum) && ($value[2]==$ie)){
															if ($noe == "Proyecto de Investigacion") { 
                                                                                                                            //colocar nota de Proyecto de investigacion 
                                                                                                                                       $nota_proy_i= $rows_notas_py[$alum]['nota'] ;if(empty($nota_proy_i)){echo "<span class='colorD'>0</span>";}else{if($nota_proy_i<=10){echo "<span class='colorD'>0</span>";}else{echo"<span class='colorA'> ".round($nota_proy_i)."</span>";}} ?>
			
																<input type="hidden" id="0"/>		
																 	
													 		<?php	}else{
													 		if ($noe == "Eventos de Tutoria") {
                                                                                                                             $nota_tutoria=$rows_notas_tutoria[$alum]['nota_tutoria'];if(is_numeric($nota_tutoria)) {if($nota_tutoria<=10){echo"<span class='colorD'> ".$nota_tutoria."</span>";}else{echo"<span class='colorA'> ".$nota_tutoria."</span>";}}else{echo "<span class='colorD'>0</span>";}
                                                                                                                            ?>
													 				<!-- colocar nota de tutoria -->
																<input type="hidden" id="0"/>
													 		<?php }else{
													 			if ($noe == "Identificacion Institucional") {
//                                                                                                                                    colocar nota de identificacion institucional 
                                                                                                                                        $nota_i_i= $rows_notas_identificacion_insti[$alum]['nota_i_i'] ;if(empty($nota_i_i)){echo "<span class='colorD'>".$nota_i_i."</span>";}else{echo"<span class='colorA'> ".$nota_i_i."</span>";} 
                                                                         
                                                                                                                                    ?>
													 				
													 				<input type="hidden" id="0"/>
													 		<?php }else{
													 				if ($noe == "Consejeria") {?>	
													 				<!-- colocar nota de consejeria -->									 	
													 				<input type="hidden" id="0"/>
													 		<?php }else{
															if (($fechaE == $fechaA) || (((int)$diaA <= (int)$diaE)&&((int)$mesA == (int)$mesE)&&((int)$anioA == (int)$anioE))){

														 		?>

																 <input type='text' maxlength='2'  pattern='{0-9}+'  class='form-control nota <?php if ((int)$value[1]<=10){echo "colorD";}else{echo "colorA";}?>' name="<?php echo $alum;?>,<?php echo $ie;?>" id = "<?php echo ($value[1]*$ponderado)/100;?>"value="<?php echo (int)$value[1];?>" onblur='hi(this)'/>	
														  	<?php }else{ ?>
															  	<input type='text' disabled class='form-control nota <?php if ((int)$value[1]<=10){echo "colorD";}else{echo "colorA";}?>' name="<?php echo $alum;?>,<?php echo $ie;?>" id = "<?php echo ($value[1]*$ponderado)/100;?>"value="<?php echo (int)$value[1];?>" onblur='hi(this)'/>		
															  	<?php
														  	}
														  }
														   }
														   }
														   }
														}
														  ?>
													<?php } ?>
														<input type="hidden" id="0"/>
													<?php } } ?>
     
													</td>
											<?php }}?>
										
										<td bgcolor="#eaf8fc" class="Uni tnota"  >
									
											<input type="text" disabled name="<?php echo $por; ?>" class='form-control nota'maxlength='2' id="<?php echo $j.'-'.$i ?>">
												
										</td>
                                                                        
								<?php   $j++; } ?>
<!--                                                                     <td>-->
                                                                                    <?php 
                                                                                   /* $temp=0; 
                                                                                    $nota_i=0;
                                                                                    foreach ($notas_py as $kpy){ 
                                                                                    	if($kpy[3]==$alum){ 
                                                                                    		$nota_i += $kpy[1];
                                                                                    		$temp=$temp+1; 
                                                                                    	} 
                                                                                    	$ponderado_i=$kpy[7]; 
                                                                                    } 
                                                                                    $nota_i = (int)($nota_i/$temp);
                                                                                    if($temp==0){
                                                                                     	$nota_i=0;
                                                                                    } */
                                                                                    ?> 
                                                                                  <?php // $nota_tutoria=$rows_notas_tutoria[$alum]['nota_tutoria'];if(is_numeric($nota_tutoria)) {if(($nota_tutoria*0.8+$rows_notas_py[$alum]['nota']*0.2)<=10){echo"<span class='colorD'> ".($nota_tutoria*0.8+$rows_notas_py[$alum]['nota']*0.2)."</span>";}else{echo"<span class='colorA'> ".($nota_tutoria*0.8+$rows_notas_py[$alum]['nota']*0.2)."</span>";}}else{echo "<span class='colorD'>".($rows_notas_py[$alum]['nota']*0.2)."</span>";} ?>
							
                                                                                    <!--<input type='hidden' maxlength='2'  pattern='{0-9}+'  class='input-small form-control nota <?php //if ((int)$nota_i<=10){echo "colorD";}else{echo "colorA";}?>' name="<?php // echo $alum;?>,<?php // echo $ie;?>" id = "<?php // echo ($nota_i*$ponderado_i)/100;?>"value="<?php //echo (int)$nota_i;?>" onblur='hi(this)'/>-->	
                                                                                    <?php // if( (int)$nota_i<10){ echo "<i style='color:red'>".(int)$nota_i."</i>";}else{echo "<i  style='color:blue'>".(int)$nota_i."</i>";}?>
                                                                      <!--</td>-->
							<?php }?>
                                                                                  <!--<td bgcolor="#eaf8fc" ><?php // $nota_tutoria=$rows_notas_tutoria[$alum]['nota_tutoria'];if(is_numeric($nota_tutoria)) {if(($nota_tutoria*08+$nota_i)<=10){echo"<span class='colorD'> ".$nota_tutoria."</span>";}else{echo"<span class='colorA'> ".$nota_tutoria."</span>";}}else{echo "<span class='colorD'>0</span>";} ?></td>-->
							
							<td  class="tnota">
                                                           
								<input class='form-control nota' id="<?php echo $i.'p'; ?>"disabled type="text" name="" value="" placeholder="">
								
							</td>
						</tr>
					<?php $i++;} ?>
					</tbody>
					<!---
					<tfoot style="display: inline-block;width:100%">
						<tr>
							<td style="border:0;">
								<div class="button" id="enviarn">Enviar</div>
							</td>
						</tr>
					</tfoot>
   					-->
				</table>
			</form>
		</div>
    </div>             
</div>
<script>
    nroFilas= $("#ola tbody tr:nth-child(1) td").length-3;
    nroColumnas= $("#ola tbody tr").length;
    //nroColumnas = 1;
    nroUnidades= $("#ola tbody tr:nth-child(1) .Uni").length;
	var n = [], b= [];
//alert(nroUnidades);
for (var u = 1; u <= nroUnidades; u++) {	
	b[u]=[];
	for (var c = 1; c <= nroColumnas; c++) {
			
		//for (var u = 1; u <= nroUnidades; u++) {
			tam= $('#ola tbody tr:nth-child(1) .U'+u).length;

			//alert(tam);
			if(tam==1){
				b[c]= $('.U'+u+'-'+c+'-'+tam+' input').attr('id');
				
			}else{
				//alert("yes");
				n[c]=[];
				for (var t = 1; t <= tam; t++) {
					n[c].push($('.U'+u+'-'+c+'-'+t+' input').attr('id'));
				}
			}
	}
	if (nroUnidades==1){
		for (var cc = 1; cc <= nroColumnas; cc++) {
			if (parseInt(b[cc])<=10){
				$('#'+u+'-'+cc).addClass('colorD');
			}else{
				$('#'+u+'-'+cc).addClass('colorA');
			}		

			$('#'+u+'-'+cc).val(parseInt(b[cc]));
		}
		console.log(b);
	}else{
		tam= $('#ola tbody tr:nth-child(1) .U'+u).length;
		
		for (var cc = 1; cc <= nroColumnas; cc++) {
			b= 0;
			for (var t = 0; t < tam; t++) {
				b+=parseFloat(n[cc][t]);
			
				if (parseInt(n[cc][t])<=10){
					$('#'+u+'-'+cc).addClass('colorD');
				}else{
					$('#'+u+'-'+cc).addClass('colorA');
				}
				$('#'+u+'-'+cc).val(parseInt(b));
			}
			//alert(b);
		}

	}

}	
console.log(n);

if (nroUnidades!=1){
	for (var c = 1; c <= nroColumnas; c++) {
		a=0;
		for (var u = 1; u <= nroUnidades; u++) {	
		
			a+=($('#'+u+'-'+c).val()*parseInt($('#'+u+'-'+c).attr('name')))/100;
                       // alert(a);

		}
                
		if (parseInt(a)<=10){
			$('#'+c+'p').addClass('colorD');
		}else{
			$('#'+c+'p').addClass('colorA');
		}
		$('#'+c+'p').val(parseInt(a));
	}
}else{
	for (var c = 1; c <= nroColumnas; c++) {
		b=0;
		
		tam= $('#ola tbody tr:nth-child(1) .U1').length;
		for (var t = 0; t < tam; t++) {
				b+=parseFloat(n[c][t]);
                //alert(b);
                                
		}
		if (parseInt(b)<=10){
			$('#1-'+c).addClass('colorD');
			$('#'+c+'p').addClass('colorD');
		}else{
			$('#1-'+c).addClass('colorA');
			$('#'+c+'p').addClass('colorA');
		}

		$('#1-'+c).val(parseInt(b));
		$('#'+c+'p').val(parseInt(b));
	}
}
//alert(parseFloat($('.U1-1-1 input').attr('id'))+parseFloat($('.U1-1-2 input').attr('id')));

	function hi(control){
		//alert(control.value);
		cl2= $(control).attr('name');
		myArray = cl2.split(',');
		idAlumno=myArray[0];
		idTipEvaluacion=myArray[1];
		campoInput= $(control).val();

		$.post('index.php', 'controller=cursosemestre&action=editarNota&CodAlumno=' +idAlumno+'&CodTipEvaluacion='+idTipEvaluacion+'&campo='+campoInput, function(data) {
			alertify.success("se inserto nota");	 
        });
		curso= $('#tablaevaluaciones .codcurso').val();
       	VerRegistro(curso);

    
		/*
        $.post('index.php','controller=cursosemestre&action=getCalificaciones&idsemestre='+codsemestre+'&idcurso='+codcurso+'&idalumno='+idAlumno, function(data) {
        $(".vernot").empty().append(data);
        $(".vernot input[type=number]").css("display","");
	    });*/
	}
/*
	$('#ola .tnota').click(function(){
		cl= $(this).attr('id');
		$('input[type=text]').attr('id',''+cl);
		$('<div class="vernot"></div>').appendTo(''+this);

	});
*/
</script>


    