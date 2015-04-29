<?php
require_once '../dompdf-master/dompdf_config.inc.php';
$html='';
$html.='
<!DOCTYPE html>
<html lang="es">
<head>
	<meta http-equiv="Content-type" content="text/html; charset=utf-8" />
	<title>Document</title>
<style>
	#customers{
		margin: 0 auto;
		border: 0px dashed skyblue;
		width: 625px;
		padding: 40px;
		border-radius: 5px 5px 5px 5px;
	}
	.unsm{
		float: left;
		vertical-align: middle;
		width: 80px; height:95px; 
	}
 .cont p{
 	margin-left: -3.5em;
 	text-align: center;
 }

 .bleach p{text-align: right;}

 .zatch p{margin: 0.5em; text-align: center;}

 p{margin: 0.5em;
   text-align: justify;
 }

 ol{margin: 0.5em 25px;}

 dir{margin: 0.3em 0px;
     text-align: justify;
 }

.tb tr td{padding: 10px; text-align: justify;}

.tbb tr td dir{margin: 0.3em 0px;}

</style>

</head>
<body>
<div id="customers">
<img class="unsm" src="../web/images/noticias/unsm.png" />
<div class="cont">
	 <p><strong style="font-size: 19px">UNIVERSIDAD NACIONAL DE SAN MARTÍN-T</strong></p>
	 <p> FACULTAD DE INGENIERÍA DE SISTEMAS E INFORMÁTICA  </p>
	 <p> Escuela Académico Profesional de Ingeniería de Sistemas e Informática </p>
 ';
 foreach ($rows as $key => $value) { $curso=utf8_encode($value[0]); $semes=$value[12];

 	$html.='<p><strong> Semestre Académico: '.$value[12].'</strong></p>
</div>
 	<h4 align="center">SÍLABO  </h4>
	<div style="text-align: left" >
	<strong>I. DATOS GENERALES</strong>
	<table class="table tbb">
	  <tbody>
		<tr>
		<td ><dir>1. ASIGNATURA</dir></td>
		<td >:</td>
	<td> '.utf8_encode($value[0]).'</td>
	</tr>
	<tr>
		<td><dir>2. CÓDIGO</dir></td>
		<td>:</td>
	<td>'.utf8_encode($value[4]).'</td>
	</tr>
			
			<tr>
				<td><dir>3. SEMESTRE ACADÉMICO</dir></td>
				<td>:</td>
				<td>'.$value[12].'</td>
			</tr>
			<tr>
				<td><ol>I. Fecha Inicio</ol></td>
				<td>:</td>
				<td>'.$value[13].'</td>
			</tr>
			<tr>
				<td><ol>II. Fecha Término</ol></td>
				<td>:</td>
				<td>'.$value[14].'</td>
			</tr>			
			<tr>
				<td><dir>4. ÁREA CURRICULAR</dir></td>
				<td>:</td>
				<td>'.$value[5].'</td>
			</tr>
			<tr>
				<td><dir>5. N° DE ORDEN</dir></td>
				<td>:</td>
				<td>'.$value[18].'</td>
			</tr>
			<tr>
				<td><dir>6. CICLO EN EL QUE SE DICTA</dir></td>
				<td>:</td>
				<td>'.$value[3].'</td>
			</tr>
			<tr>
				<td><dir>7. DURACIÓN DE SEMANAS</dir></td>
				<td>:</td>
				<td> '.floor((strtotime($value[14])-strtotime($value[13]))/604800).'</td>
			</tr>
			<tr>
				<td><dir>8. HORAS A LA SEMANA</dir></td>
				<td>:</td>
				<td>HT= '.$value[6].', HP= '.$value[7].', HT= '.($value[6]+$value[7]).'</td>
			</tr>
			<tr>
				<td><dir>9.N° DE CRÉDITOS</dir></td>
				<td>:</td>
				<td>'.intval($value[1]).'</td>
			</tr>
			<tr>
				<td><dir>10. DOCENTE RESPONDABLE</dir></td>
				<td>:</td>
				<td>Ing.'.utf8_encode($value[16]).'</td>
			</tr>
		</tbody>
	</table>

</div>
<br>
<div style="text-align: left" >
	<strong>II. SUMILLA</strong>
	<dir>'.$value[9].'</dir>
</div>
<br><br>
<div style="text-align: left" >
	<strong>III. OBJETIVO</strong>
	<dir>'.$value[17].'</dir>
</div>
<br><br>
<div style="text-align: left" >
	<strong>IV. METODOLOGIA</strong>
	<dir>'.$value[10].'</dir>
</div>
<br><br>
<div style="text-align: left" >
	<strong>V. COMPETENCIA</strong>
	<dir>'.$value[11].'</dir>
    <div>
<br><br>
        <strong>VI. PROGRAMACIÓN DE DESARROLLO DEL CONTENIDO TEMÁTICO DE LA SUMILLA</strong>
		<dir>
		<strong>4.1. Diseño</strong></dir>
';
}
if(isset($rows2)){
	$i=1;
	foreach ($rows2 as $key => $value ) {
 	 $html.='<dir><p>UNIDAD '.$i.': '.strtolower(utf8_encode($value[1])).'</p></dir>';
 	 $i++;
 	}
 }
 $html.='</div><br>
         <dir><strong>4.2. Contenido</strong></dir> 
        ';
if(isset($rows2)){
	$f=1;
   foreach ($rows2 as $key => $value) { $idu= $value[0];
   	$html.='<strong><p><dir>UNIDAD '.$f.':  '.utf8_encode($value[1]).'</dir></p></strong>
		    <dir><strong>4.2.1 Descripcion:</strong></dir><dir><p>'.$value[2].'</p></dir>
			<dir><p><strong>4.2.2 Duracion:</strong>    '.$value[3].' Semanas</p></dir>
			<dir><strong>4.2.3 Competencia:</strong></dir> <dir><p>'.$value[4].'</p></dir>
			<dir><p><strong>4.2.4 Porcentaje:</strong>  '.$value[5].'%</p></dir><br>';
			$f++;
	if(isset($rows3)){
		$html.='
			<table class="table table-striped table-bordered tb" rules="all" border="1" align="justify">
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
		';
		foreach ($rows3 as $key => $value) { 
		if($idu==$value[6]){
			$html.='
			<tr>
            <td >'.utf8_encode($value[0]).'</td>
            <td>
                '.$value[1].'
            </td>

            <td>
                '.$value[2].'
            </td>

            <td>
                '.$value[3].'
            </td>

            <td>
                '.$value[4].'
            </td>
        </tr> 
			';
			} 
		}
	$html.=' </tbody></table>';
	} 
$html.='</li>';
  }
}

$html.='<br>

<div style="text-align: left" >
	<strong>VII. SISTEMA DE EVALUACIÓN DEL APRENDIZAJE</strong>
<br><br>
<table class="table table-striped table-bordered tb" rules="all" border="1" align="justify">
		    <thead class="mloencontre">
		        <tr>
		            <th vertical-align="middle"><b>SIMBOLO</b></th>
		            <th vertical-align="middle"><b>CONCEPTO</b></th>
		            <th vertical-align="middle"><b>LA NOTA</b></th>
		        </tr> 
		        <tr>
					<th colspan="2" align="center">
						ACADEMICA(100%)
					</th>

					<th></th>
		        </tr>
		    </thead>
		    <tbody>';
			   if(isset($rows5)){
				foreach ($rows5 as $key => $value) {
			 	 $html.='<tr>
			 	 			<td>';
									$new_array=explode(' ',$value[0]);
									$acr='';
									$contad=count($new_array);
									if($contad>1){
										foreach($new_array as $key=>$val){											
											$html.= $val[0];
										}
									}else{
										$html.= substr($value[0],0,3);
									}
									

			 	 			$html.='</td>
			 	 			<td>'.$value[0].'</td>
			 	 			<td>'.$value[1].'%</td>
			 	 		</tr>
				         ';
				     }
			 }

	$html.='</tbody>
			<tfoot>
				<th colspan="2" align="center">TOTAL</th>
				<th align="center">100%</th>
			</tfoot>
		    </table>
		    </div>
		'.'
		<br>
			<strong>FORMULA:</strong> <br><br>
			F= ';
			   if(isset($rows5)){ $f="";
				foreach ($rows5 as $key => $value) {
						$ar = explode(" ", $value[0]);
						$aa = substr($ar[0], 0,1);
						$bb = substr($ar[1], 0,1);
						$f .= ((int)$value[1]).'*'.$aa.$bb." + ";
				}
			}

$html.= '( '.substr($f, 0,-2).' )/100<br><br><div style="text-align: left" >
	    <strong>VIII. BIBLIOGRAFIA</strong>';
if(isset($rows4)){
	foreach ($rows4 as $key => $value) {$idb=$value[3];
		if($idb==1){
 	 $html.='<dir><p>'.$value[2].'</p></dir>
	         ';
	     }
 	}
 }
$html.='<br><br><dir><strong>LINKOGRAFIA</strong></dir>';
if(isset($rows4)){
	foreach ($rows4 as $key => $value) {$idb=$value[3];
 if($idb==2){
	     $html.='
	        <dir><p>'.$value[2].'</p></dir>
	         ';
	       }
	   }
 }

 $html.='<br><br><br><div class="bleach">
         <p>Tarapoto, '.date_default_timezone_set().date("d/m/Y").'</p></div>
      ';

foreach ($rows as $key => $value) { $curso=utf8_encode($value[0]); $semes=$value[12];
$html.='
      <br><br><div class="zatch">
          <p>--------------------------------------------------</p>
          <p>Ing.'.utf8_encode($value[16]).'</p>
          <p>Responsable del Curso</p>
      </div>
      ';
  }

$html.='
	 </div>	
	</div>
  </body>
</html>';

//echo $html; exit();


# Instanciamos un objeto de la clase DOMPDF.
$mipdf = new DOMPDF();
 
# Definimos el tamaño y orientación del papel que queremos.
# O por defecto cogerá el que está en el fichero de configuración.
$mipdf ->set_paper("A4", "portrait");
 
# Cargamos el contenido HTML.
$mipdf ->load_html($html);
 
# Renderizamos el documento PDF.
$mipdf ->render();
# Enviamos el fichero PDF al navegador.
$mipdf ->stream(''.$curso.'--'.$semes.".pdf");

?>
 
