$(window).bind("beforeunload",function(event){
   //return("hola"); 
   if (validaciones){
      return a;
   } 
});

function validaciones() {
 a= $("#frm1").submit();
 return a;

}

$(function() {
    
$( "#tabs" ).tabs();

    $("#generar_u").click(function(){
          var num= $("#nuni").val();
         //$("#unidd").dialog("open");
    });


$('.nota').live('keyup' ,function(){
  rangoNumeros($(this).val(),$(this));
});

    $('#grabar_1').click(function() {

      $("#frm1").submit();
    
        if ( $('#competencia_1').val() == " " ) {
            alert("llenar competencia");
        }else{
        if ( $('#metodologia_1').val() == " " ) {
            alert("llenar metodologia");
        }else{
           if ( $('#objetivo_1').val() == "" ) {
            alert("llenar objetivo");
        }else{
        if ( $('#sumilla_1').val() == "" ) {
            alert("llenar sumilla");
        }else{
           if ( $('#bibliografia_1').val() == "" ) {
            alert("llenar bibliografia");
        }
        }
      }
       
        }

      }
       
    });



    $(".datepicker").datepicker();
    //var vars = $("#semestreacademico").val();
 
    

    $("#semestreacademico").change(function() {
      var idsa = $(this).val();
      carga(idsa);
      //alert(idsa);  
    });
    carga($("#semestreacademico").val());

});

function validarLetras(e)
{
  tecla=(document.all) ? e.keyCode : e.which;
  if(tecla==8) return true; // backspace
  if(tecla==32) return true; // espacio
  if(tecla==9) return true; // tab
  if(tecla==37) return true; // flecha izquierda
  if(tecla==38) return true; // fleach arriba
  if(tecla==39) return true; // flecha derecha
  if(tecla==40) return true; // flecha abajo
  if(e.ctrlkey && tecla==86){ return true;}// Ctrl v
  if(e.ctrlkey && tecla==67){ return true;}// Ctrl c
  if(e.ctrlkey && tecla==88){ return true;}// Ctrl x  
  patron=/[a-zA-Z]/;
  te=String.fromCharCode(tecla);
  return patron.test(te);
}
function validarNumero(e)
{
  tecla=(document.all) ? e.keyCode : e.which;
  if(tecla==8) return true; // backspace
  if(tecla==32) return true; // espacio
  if(tecla==9) return true; // tab
  if(e.ctrlkey && tecla==86){ return true;}// Ctrl v
  if(e.ctrlkey && tecla==67){ return true;}// Ctrl c
  if(e.ctrlkey && tecla==88){ return true;}// Ctrl x  
  patron=/[0-9]/;
  te=String.fromCharCode(tecla);
  return patron.test(te);
}


 $( "#abrir" ).click(function() {
      runEffect(100,280,185,1);
      
    });
    $( ".cerrar" ).click(function() {
      runEffect(0,200,60,0);
    });

function runEffect($a,$b,$c,$d) {
       var selectedEffect = "slide";
       var options = {};
      if ( selectedEffect === "scale" ) {
        options = { percent: $a };
      } else if ( selectedEffect === "size" ) {
        options = { to: { width: $b, height: $c } };
      }

      if ($d==1){
        $( ".effect" ).show( selectedEffect, options, 500);
      }else{
        $( ".effect" ).hide( selectedEffect, options, 1000 );
      }
}
var kk=2;
function bib(){
      $("#bibl tbody tr:eq(0)").clone("#bibl").removeClass("dtp").appendTo("#bibl tbody");
//      $(".dts").clone().appendTo("#bibl tbody tr:nth-child("+i+") td:nth-child(2)").css("display","").removeClass("dts");
      kk++;
}


function carga(vars){
     //$("#idsemeestreacademicoescondido").attr('value',vars);
     $(".silaboo").css("display","");
     $("#silabus").css("display", "none");
     $(".olassss").css("display", "none");
     $("#edibi").css("display", "none");
     $("#tpi").css("display", "none");
        //var ids = $(this).val();
        //console.log(ids);
        $("#tablaevaluaciones").css("display", "none");
        $("#silaedit").css("display", "nonw");
        $("#borrarb").css("display", "none");
        $.post('index.php', 'controller=cursosemestre&action=getCursosD&CodigoSemestre=' + vars, function(data) {
            //console.log(data);
//           $("#boton").css("display", "none");
            $("#lista").css("display", "none");
//            $("#boton").css("display", "none");
            $("#tablaevaluaciones").css("display", "none");
            $("#edibi").css("display", "none");
            $("#tpi").css("display", "none");
             $("#silaedit").css("display", "none");
            $("#cursodocente").empty().append(data);
            $("#accordion").css("display", "none");
        });
}



// lista de alumnos de cursos q enseña el docente  ->>>boton lista
function Ver(id) {
    var idsemestre = $("#semestreacademico").attr("value");
    var opt="A";
    $(".silaboo").css("display","none");
    $(".olassss").css("display", "none");
    $("#tablaevaluaciones").css("display", "none");
    $("#borrarb").css("display", "none");
    $("#silaedit").css("display", "none");
    $.post('index.php', 'controller=cursosemestre&action=getListaA&idcurso='+id+'&idSemestre=' + idsemestre+'&opcion='+opt, function(data) {
        
        $("#sillabus").css("display", "none");
//        $("#boton").css("display", "none");

        $("#accordion").css("display", "none");
        $("#silaedit").css("display", "none");
        $("#lista").css("display", "inline");
        $("#lista").empty().append(data);
    });
}

//  fin lista de alumnos de cursos q enseña el docente--->>boton registro  notas de cada envento
function VerRegistro(id) {
    var idsemestre = $("#semestreacademico").attr("value");
  $(".silaboo").css("display","none");
$("#tablaevaluaciones").css("display", "");
$("#borrarb").css("display", "");
$("#lista").empty().css("display", "none");
    $.post('index.php', 'controller=cursosemestre&action=getSillabysD&Codigo=' + id + '&idSemestre=' + idsemestre, function(data) {
        $("#accordion").css("display", "none");
        
        $("#evaluaciones").css("display", "inline");
        $("#silaedit").css("display", "none");
         $("#boton").css("display", "none");
        $("#evaluaciones").empty().append(data);
        $("#regresar").css("display", "none");
      
    });
      $.post('index.php', 'controller=cursosemestre&action=getListaA2&Codigo=' + id + '&idSemestre=' + idsemestre, function(data) {
            $(".olassss").empty().append(data);
     });
     $(".olassss").css("display", "");
     
//      $.post('index.php', 'controller=cursosemestre&action=getNcurso&Codigo=' + id , function(data) {
//           
//          $(".ncurso").empty().append(data);
//     });
        
}



$("#regresar").live("click", function() {
    $("#chau").css("display", "");
    $("#boton").css("display", "none");
    $("#agrandar").attr({
        'class': 'col-md-8'
    });
     
        
         $("#ola").css({
            'width':'500px'
        });
        
        $("#ola").css({
            'height':'60px'
        });
        
         $("#grande").css({
            'height':'270px'
        });
         $("#grande").css({
            'width':'635px'
        });
        
        $(".nota").remove();
        
    $("#borrarb").css("display", "none");
});


//boton del mostrar el siabus  y editar


function VerSi(id,codigosemestre) {
    var codemestre = codigosemestre;
//alert (id+'**'+codemestre);
$(".silaboo").css("display","none");
$("#boton").css("display", "none");
//olassss
$("#borrarb").css("display", "none");
$(".olassss").css("display", "none");
$("#tablaevaluaciones").css("display", "none");
//$("#silaedit").css("display","inline");
$.post('index.php', 'controller=cursosemestre&action=getEdiSillabus&Codigo=' + id + '&codemestre=' + codemestre, function(data) {
//$("#evaluaciones").css("display", "inline");
//alert(data);
 $("#tablaevaluaciones").css("display", "none");
 $("#accordion").css("display", "none");
 $("#boton").css("display", "none");
 $("#lista").css("display", "none");    
 $("#silaedit").css("display", "inline"); 
 $("#silaedit").empty().append(data);
 $(".regresar").css("display", "none");
 });

}

$(".unidad").live("click", function() {
    unidad();
});
$(".eva111").live("click", function() {
  eva111();
});
function eva111(){
   var semestre = $("#semestre").attr("value");
    var curso = $("#curso").attr("value");
    var opt="asd";
               
    $.post('index.php', 'controller=cursosemestre&action=getUni&CodigoCurso=' + curso + '&idSemestre=' + semestre+'&sin='+opt, function(data) {
        $("#evalua").html(data);
    });
}
function unidad(){
    var semestre = $("#semestre").attr("value");
    var curso = $("#curso").attr("value");
    var opt="asd";

    $.post('index.php', 'controller=cursosemestre&action=getUnidad&CodigoCurso=' + curso + '&idSemestre=' + semestre+'&sin='+opt, function(data) {
      if(data=="")
      {
        alert("estoi vacio");
      }else{
        $("#un11").html(data);
      }
    });
}
function temasdUnidad(id){
    
    var codunidad=$("#idunidad").attr("value");
    //    console.log(codunidad);
var opt='B';
$.post('index.php', 'controller=cursosemestre&action=getTema&Codigo=' +id+'&option='+opt, function(data) {
$("#boton").css("display", "none");
        $(".tema").empty().append(data);
    });
};





$("#unid").live("click", function() {
    var semestre = $("#semestre").attr("value");
    var curso = $("#curso").attr("value");
    var sin='S';
      
$(".recibS").css("display","none");
$(".recibU").css("display","none");
$(".recibT").css("display","none");
$("#chau").css("display","none");
$(".regresar").css("display","");

    $.post('index.php', 'controller=cursosemestre&action=getUnidad&CodigoCurso=' + curso + '&idSemestre=' + semestre+ '&sin='+sin, function(data) {
//$("#boton").css("display", "none");
        $("#uni").empty().append(data);
    });

});



$("#vertema").live("click",function(){
    var codunidad=$("#codunidad").attr("value");
    var opt='A';
    

$.post('index.php', 'controller=cursosemestre&action=getTema&Codigo=' + codunidad+'&option='+opt , function(data) {

        $("#tema").empty().append(data);
    });
});




function filtro (id,jar){

    idTipEvaluacion= id;
    idAlumno =$("input[name='idalumno[]']").serialize();
    tamA =$("input[name='idalumno[]']").length;
    //alert(tamA);
    campoInput =0;
    
    //alert(idAlumno);
    
    $(jar).attr("disabled","");
    $.post('index.php', 'controller=cursosemestre&action=getEstadoBoton&idevaluacion='+idTipEvaluacion, function(data) {
    });

    $.post('index.php', 'controller=cursosemestre&action=enviarNota&tamano='+tamA+'&'+idAlumno+'&CodTipEvaluacion='+idTipEvaluacion+'&campo='+campoInput, function(data) {
    });

    curso= $('#tablaevaluaciones .codcurso').val();
    //alert(curso);
    VerRegistro(curso);
    $('.nota').numerico();
}


function VerAsistencia(id) {
    var idsemestre = $("#semestreacademico").attr("value");
    var opt='dsa';

    alert(id)

$("#silaedit").css("display","none");
    $("#lista").css("display","none");
        $("#evaluaciones").css("display","none");
        $(".olassss").css("display","none");
    $.post('index.php', 'controller=cursosemestre&action=getUnidad&CodigoCurso=' + id + '&idSemestre=' + idsemestre+'&sin='+opt, function(data) {
        $("#unidadesA").empty().append(data);
    });
}

function TemasClase(idtema,idclase){
    
var semestre = $(".semestre").attr("value");
var curso = $(".curso").attr("value");
      var unidad =$("#idunidad").val();
      var esunidad=".codunidad"+unidad;
//      var idclase=$("#idclaseC").attr("value");
      var cerrar="codunidad"+unidad+" collapsed";
       
   
      $(esunidad).attr({
          'class':cerrar
      });
      
      $(".tema").attr({
          
          'class':'tema panel-collapse collapse',
          'style':'height: 0px'
          
      });
      
      $("#chau").css("display","none");
      $("#agrandar").attr({
         'class':'col-md-11'
     });
     if (idtema==="todavia"){
                      $("#Bregresar").html("<a href='index.php?controller=cursosemestre' class='button' id='regreS'>Regresar</a>");

         $("#agrandar").attr({
            
            'class':'col-md-11 col-md-offset-2'
            
        });
        
         alert("NO ES LA FECHA ESTALBECIDA");
         $(".tablaAsis").css("visibility","hidden");
     }else{
         if(idtema==="paso"){
                          $("#Bregresar").html("<a href='index.php?controller=cursosemestre' class='button' id='regreS'>Regresar</a>");

             $("#agrandar").attr({
            
            'class':'col-md-11 col-md-offset-2'
            
        });
        
             alert("El limite de tiempo caduco");
         $(".tablaAsis").css("visibility","hidden");

         }
         else{
             $("#Bregresar").html("<a href='index.php?controller=cursosemestre' class='button' id='regreS'>Regresar</a>");
         var opt="B";
                  $(".tablaAsis").css("visibility","");

    $.post('index.php', 'controller=cursosemestre&action=getListaA&idcurso='+curso + '&idSemestre=' + semestre+'&opcion='+opt, function(data) {
        
        $("#sillabus").css("display", "none");
//        $("#boton").css("display", "none");

       
        $(".tablaAsis").empty().append(data);
        $(".daridclase").html("<input type='hidden' class='idclase' value='"+idclase+"' />");
    });
        $("#agrandar").attr({
            
            'class':'col-md-11 col-md-offset-1'
            
        });
     }
 }
  
    
}

$("#enviarA").live("click",function(){
    var alumno =$('input[name="alumno[]"]').serialize();
    var asistencia =$('input[name="asisten[]"]').serialize();
    var clase =$(".idclase").attr("value");
    
   $.post('index.php','controller=cursosemestre&action=getAsistencia&idalumno='+alumno+'&idclase='+clase+'&asistencia='+asistencia,function(data) {

        $("#asisss").empty().append(data);
    });
    
    alert ("se inserto la asistencia");
    $("#ola").css("display","none");
    
});


function editSylabus(id){
     $(".recibS").css("display","");
    var vali="Sl";
                 $(".regresar").css("display","");
                 $(".ecp").attr({
                     
                     'style':'font-size: 12px;'
                 });
                 
                  $("#ampliar").attr({
                      'class':'col-md-onset-1' 
                 });

    $(".recibS").attr({
        
        'src':'index.php?controller=silabus&action=edit&id='+id+'&variable='+vali
    });
    $(".recibS").css("display","");
    
    $("#chau").css("display","none");
}


function edidUnidad(id){
    var vali="Sl";
                 $(".regresar").css("display","");
 $(".ecp").attr({
                     
                     'style':'font-size: 12px;'
                 });
    $(".recibS").remove();
    $(".recibU").css("display","");
    $(".recibU").attr({
        
        'src':'index.php?controller=unidad&action=edit&id='+id+'&variable='+vali
    });
    $(".recibU").css("display","");
        $("#chau").css("display","none");
    
   
}

//index.php?controller=tema&action=edit&id=

function edidTema(id){
     $(".ecp").attr({
                     
                     'style':'font-size: 12px;'
                 });
                  $("#ampliar").attr({
                      'class':'col-md-offset-3' 
                 });
                
    var vali="Sl";
    $(".recibS").remove();
    $(".recibU").remove();
    $(".recibT").css("display","");
    $(".recibT").attr({
        
        'src':'index.php?controller=tema&action=edit&id='+id+'&variable='+vali
    });
    $(".recibT").css("display","");
        $("#chau").css("display","none");
    
   
}

$(".regresar").live("click",function(){
      $("#chau").css("display","");
            $(".regresar").css("display","none");
    $(".recibS").remove();
    $(".recibU").remove();
    $(".recibT").remove();
 $(".ecp").attr({
                     
                     'style':''
                 });
                 
                  $("#ampliar").attr({
                      'class':'' 
                 });
    
});


function activa(param){
    $("#"+param).addClass("active");
}

function rangoNumeros(nro,input){
        if(nro>=0 & nro<=20){
         // alertify.log("esta en el rango")
        }else{
          input.val("");
          alertify.log("por favor ingrese un numero mayor igual a '0' o menor igual a '20'");
        }
}