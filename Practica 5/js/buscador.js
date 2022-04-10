
function buscar(texto){
          var xhttp = new XMLHttpRequest();
          xhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
             document.getElementById("resultadoBusqueda").innerHTML = this.responseText;
            }
          };
          xhttp.open("GET", "php/buscador.php?textoBusqueda="+texto, true);
          xhttp.send();


}

function cierraSugerencias(){
     document.getElementById("resultadoBusqueda").innerHTML="";
}
