//editar silabo
  //competencia
   $( "#comp" ).click(function() {
     cp= $("#comp").html();
     $("#edits").val(cp);
     $(".modal-title").html("competencia");
     $("#soyunid").addClass("comp");

     //$("#dialogoo").title("competencia");
      //$( "#dialogoo" ).dialog( "open" );
    });

  //metodologia 
      $( "#met" ).click(function() {
      me=  $("#met").html();
      $("#edits").val(me);
      $(".modal-title").html("metodologia");
      $("#soyunid").addClass("met");
    });

    //objetivo
      $( "#ob" ).click(function() {
      ob=  $("#ob").html();
      $("#edits").val(ob);
      $(".modal-title").html("objetivo");
      $("#soyunid").addClass("ob");
    });

    //sumilla
$( "#su" ).click(function() {
  su=  $("#su").html();
  $("#edits").val(su);
  $(".modal-title").html("sumilla");
  $("#soyunid").addClass("su");
});

function bi(id){
  $.post('index.php', 'controller=bibliografia&action=verBiblio&ids='+id, function(data) {
         $("#bibliografias").html(data);
  }); 
}
//ingresar unidades
var ii=2;
function agregarUni(){
   if (($('#duracion1').val()==17) || ($('#porcentaje1').val()==100)) {
        alert("cambie la duracion para insertar nueva unidad");
   }else{
      idAlumno= $("input[name='porcentaje[]']").serializeArray();
      duracion= $("input[name='duracion[]']").serializeArray();
      tamA =idAlumno.length;
      var T=100;
      var D=17;
      for (var i = 0; i <parseInt(tamA); i++) {
          T= T - parseInt(idAlumno[i].value);
          D= D - parseInt(duracion[i].value);
      }
  var html = "";
  html += "<tr>";
  html += "<td><textarea id='nombreunidad"+ii+"' class='form-control' name='nombreuni[]'></textarea></td>";
  html += "<td><textarea class='form-control' name='competencia[]'></textarea></td>";
  html += "<td><textarea class='form-control' name='descripcion[]'></textarea></td>";
  html += "<td><input type='number' class='form-control' id='duracion"+ii+"' name='duracion[]'/></td>";
  html += "<td><input type='number' id='porcentaje"+ii+"' class='form-control' name='porcentaje[]' placeholder='%'/></td>";
  html += "<td><button type='button' class='btn btn-default' onClick='semana("+ii+")'>+</button></td>";
  html += "</tr>";
    
    h4 = "<div id='h"+ii+"'></div>"; 

   $(html).appendTo("#tabla tbody");
   $(h4).appendTo("#a");
   $('#tabla textarea').autosize();

      $('#porcentaje'+ii).val(T);
      $('#duracion'+ii).val(D);
      ii++;
    }
}
//ingresar semanas
var temp= [];
var temp2= [];
 j=0;
 t=  0;   
function semana(i){
  //alert("entre");
   var html="";
    temp[i] = $("#duracion"+i).val();
    temp2[i] = $("#nombreunidad"+i).val();

    if ((temp[i]=="") || (temp2[i]=="")) {
      alert("ingresar campos");
    }else{
    t= t + parseInt(temp[i]);
    //alert(t);
            html +="<table class='table table-hover table-bordered' id='tabla'>";
            html +="<thead>";
            html +="<tr>";            
            html +="<th colspan='6'>";
            html +="<h3>unidad: "+1+" "+temp2[i]+"<h3>";
            html +="</th>";
            html +="</tr>";
            html +="<tr>";
            html +="<th>Semanas</th>";
            html +="<th>Contenido</th>";
            html +="<th>Conceptual</th>";
            html +="<th>Procedimental</th>";
            html +="<th>Actitudinal</th>";
           // html +="<td>Clase</td>";
            html +="</tr>";
            html +="</thead>";    
      
      html +="<tbody>";
        for(k=j+1;k<=t ;k++){
            html +="<tr>";
            html += "<td> semana "+k+"</td>";
            html +="<td><input type='text' id='contenido' class='form-control validar' rows='2' cols='30' name='cont"+k+"-"+i+"' /></td>"; 
            html +="<td><input type='text' id='Conceptual' class='form-control validar' rows='5' cols='30'' name='conce"+k+"-"+i+"'/></td>";  
            html +="<td><input type='text' id='procedimental' class='form-control validar' rows='5' cols='30' name='proc"+k+"-"+i+"' /></td>";  
            html +="<td><input type='text' id='actitudinal'  class='form-control validar' rows='5' cols='30' name='act"+k+"-"+i+"' /></td>";
            html  +="</tr>";
           j++;
    }
    html +="</tbody>";
    html +="</table>"; 

    html +="<div class='ee"+i+"'>";
     html +="  <button type='button' style='margin-left:40%;' onclick='agregarEva("+i+")' class='btn btn-default'>";
      html +="       Agregar</button>";
      html +="        <button  type='button' class='btn btn-default ' onclick='eliminarE("+i+")'>x</button>";
      html +="       <table id='tabla"+i+"' class='table table-hover table-bordered'>";
       html +="          <thead>";
        html +="           <tr>";
        html +="               <th>tipo de evaluacion</th>";
         html +="              <th>Descripción</th>";
           html +="            <th>fecha</th>";
          html +="             <th>ponderado</th>";
         html +="          </tr>";
      html +="           </thead>";
       html +="         <tbody>";
       html +="          <tr class='tev'>";
        html +="          <td class='tipEvac'></td>";
       html +="             <td><textarea id='descripcionEva' class='form-control' name='descripcionEva"+i+"[]'></textarea></td>";
       html +="             <td><input type='date' id='fechaEva' class='form-control' name='fechaEva"+i+"[]' /></td>";
       html +="             <td><input type='number' id='ponderadoEva' class='form-control' name='ponderadoEva"+i+"[]' /></td>";
      html +="           </tr>";
      html +="        </tbody>";
      html +="        </table>";
     html +="</div>"; 
    $("#h"+i).html(html);
    $('.tipEvaa').clone().appendTo(".ee"+i+" .tipEvac").removeClass('tipEvaa').attr("name","tipEva"+i+"[]");
   }
}

function agregarEva(p){
  $("#tabla"+p+" tbody .tev").clone().appendTo("#tabla"+p+" tbody").removeClass('tev');
}

// Evento que selecciona la fila y la elimina 
  $(".eliminar").click(function(){
      var trs=$("#tabla tr").length;
             if(trs>2){
                    // Eliminamos la columna
                $("#tabla tbody>tr:nth-child("+(parseInt(trs)-1)+"").remove();
            }
    });
    $(".eliminarB").click(function(){
      var trs=$("#bibl tr").length;
             if(trs>2){
                    // Eliminamos la columna
                $("#bibl tbody>tr:nth-child("+(parseInt(trs)-1)+"").remove();
            }
    });
    function eliminarE(o){
      var trs=$("#tabla"+o+" tr").length;
             if(trs>2){
                    // Eliminamos la columna
                $("#tabla"+o+" tbody>tr:nth-child("+(parseInt(trs)-1)+"").remove();
            }
          }
   //silabo
//$("#guardarS").click(function(){
  //var idsilabo=$("#silabo").val();
  //var campo=$("#edits").html();
  //alert(idsilabo+""+campo);
  //alert("asdfas");
//});

function guardarre(){
  var idsilabo=$("#silabo").val();
  var campo=$(".modal-body #edits").val();
  var nom= $("#myModalLabel").html();
  //alert(idsilabo+""+campo+""+nom);

  var t= $("#soyunid").attr('class');
  $("#"+t).html(campo);



  $.post('index.php', 'controller=cursosemestre&action=editarSilabo&codsilabo=' + idsilabo +'&campot='+ campo +'&nombre='+ nom, function(data) {
           // $("#cursodocente").empty().append(data);
  });
  $(".modal-body #edits").val("");
}
