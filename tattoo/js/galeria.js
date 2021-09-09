$(document).ready(function(){
    getAllImages();

    $(".btn-filtros-movil").on('click', function() {
        $(".block-filtros").slideToggle();
    });
});

function getAllImages() {
    $(".box-galeria").html('');
    $.ajax({
        url: '../tattoo/rest/obtener_all_images.php',
        dataType: 'json',
        data: ({dominio: 'davidcaballerocalvo.es'}),
        success: function(data) {
            for(var i=0; i<data.images.length; i++) {
                $(".box-galeria").append(''+
                    '<div id="' + data.images[i].id + '" class="foto-galeria" style="background-image: url(../tattoo/rest/images/' + data.images[i].url + ')"></div>');
            }
        },
        error: function(error) {
            showErrorNotification('Error al obtener imagenes');
        }
    });
}

function showErrorNotification(texto) {
    $("#snackbar-error").text(texto);
    var x = document.getElementById("snackbar-error");
    x.className = "show";
    setTimeout(function(){ x.className = x.className.replace("show", ""); }, 3000);
}