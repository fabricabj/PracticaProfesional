function eliminarDato(idProducto,pagina){
    var eliminar = confirm('Desea eliminar esta pelicula?');
    var categoria=document.getElementById('categ').value;
    var eliminarProducto=document.getElementById('eliminarPelicula').value;
    if ( eliminar ) {
          
          $.ajax({
            url: 'ABM.php',
            type: 'POST',
            data: { 
                id: idPelicula,
                categ: categoria,
                pag: pagina,
                delete: eliminarPelicula,
              
            },
         })
         .done(function(response){
            $("#result").html(response);
         })
         .fail(function(jqXHR){
            console.log(jqXHR.statusText);
         });
         alert('La pelicula ha sido eliminada');
    }
} 