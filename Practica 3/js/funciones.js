function desplegarComentarios(){
      var elemento=document.getElementById("div_comentarios");
      var elemento2=document.getElementById("boton_comentarios");
      var elemento3=id=document.getElementById("boton_quitar_comentarios");

      elemento.style.display = 'block'
      elemento2.style.display = 'none'
      elemento3.style.display = 'block'
     // elemento3.style.display = 'block'

}
function quitarComentarios(){
     var elemento=document.getElementById("div_comentarios");
     var elemento2=document.getElementById("boton_comentarios");
     var elemento3=id=document.getElementById("boton_quitar_comentarios");

     elemento2.style.display = 'block'
     elemento.style.display = 'none'
     elemento3.style.display = 'none'

}

function compruebaPalabra(id){

     var input = document.getElementById(id),
     badwords = /\b(puta|coño|policia|polla|joder|fuck|politico*s|mierda|matar|gilipolla*s)\b/g;

     input.value = input.value.replace(badwords, function (fullmatch, badword) {
        return new Array(badword.length + 1).join('*');
     });



}



function insertaComentario(){

     var nombre=document.getElementById("nombre_comentario").value;
     var email=document.getElementById("email_comentario").value;
     var texto_com=document.getElementById("texto_com").value;
     var f= new Date();
     var day = f.getDate();
     var month= f.getMonth()+1;
     var year = f.getFullYear();
     var fecha = day + '/' + month + '/' + year;
     var hours = f.getHours();
     var min= f.getMinutes();
     var hora=hours + " : " + min;
     var total=fecha + ", " + hora;


     document.getElementById("div_comentarios").innerHTML=

     '<div class="comentario">'+
          '<p class="th_comentario">#Comentario3</p>'+
               '<p class="autor_comentario"><label class="negrita"> Autor:</label> '+
                    nombre + ' | ' + email +
               '<p class="fecha_comentario"><label class="negrita">Fecha y Hora:</label>  '+
                    total+
               '</p>'+
               '<p class="descripcion_comentario" ><label class="negrita">Descripción</label></p>'+
               '<div>'+
                    '<p class="texto_comentario">'+
                    texto_com+
                    '</p>'+
               '</div>'+
     '</div>'+
     document.getElementById("div_comentarios").innerHTML


}

function compartir(){
     var titulo = document.getElementById("titulo");
     var imagen = document.getElementById("imagenNoticia");
     window.open("vistas/popupCompartir.php?compartir=true&titular="
     + titulo.innerHTML + "&imagen=" + imagen.src, "Compartir en Facebook", "width=700, height=400, scrollbars=NO");
     //alert(titulo.innerHTML + "\n" + "Via @Diariodeportivo");
}
