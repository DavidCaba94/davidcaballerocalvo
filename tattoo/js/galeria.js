var filtrosActivos = [];
var allImages = [];
$(document).ready(function(){
    getAllImages();

    $(".btn-filtros-movil").on('click', function() {
        $(".block-filtros").slideToggle();
    });

    $(".item-filtro").on('click', function() {
        if($(this).hasClass('on')) {
            if($(this).attr('id') !== 'todos') {
                $(this).removeClass('on');
                $(this).addClass('off');
                $("#todos").removeClass('on');
                $("#todos").addClass('off');
                removeFilter($(this).attr('id'));
            }
        } else {
            $(this).removeClass('off');
            $(this).addClass('on');
            if($(this).attr('id') !== 'todos') {
                addFilter($(this).attr('id'));
                $("#todos").removeClass('on');
                $("#todos").addClass('off');
            } else {
                $(".item-filtro").removeClass('on');
                $(".item-filtro").addClass('off');
                $("#todos").removeClass('off');
                $("#todos").addClass('on');
                filtrosActivos = [];
                aplicarFiltros();
                showImages(allImages);
            }
        }
    });

    $(".box-imagen-abierta").on('click', function() {
        $(".box-imagen-abierta").css('display', 'none');
    });
});

function getAllImages() {
    allImages = [];
    
    $.ajax({
        url: '../tattoo/rest/obtener_all_images.php',
        dataType: 'json',
        data: ({dominio: 'davidcaballerocalvo.es'}),
        success: function(data) {
            allImages = data.images;
            showImages(allImages);
        },
        error: function(error) {
            showErrorNotification('Error al obtener imagenes');
        }
    });
}

function addFilter(filterName) {
    filtrosActivos.push(filterName);
    aplicarFiltros();
}

function removeFilter(filterName) {
    filtrosActivos = jQuery.grep(filtrosActivos, function(value) {
        return value != filterName;
    });
    if(filtrosActivos.length == 0) {
        $("#todos").removeClass('off');
        $("#todos").addClass('on');
        showImages(allImages);
    } else {
        aplicarFiltros();
    }
}

function aplicarFiltros() {
    var filteredImages = [];
    allImages.forEach(item => {
        filtrosActivos.forEach(filtro => {
            if(item.tipo == filtro) {
                filteredImages.push(item);
            }
        });
    });
    showImages(filteredImages);
}

function showImages(imgArray) {
    $(".box-galeria").html('');
    for(var i=0; i<imgArray.length; i++) {
        $(".box-galeria").append(''+
            '<div id="' + imgArray[i].id + '" class="foto-galeria" onclick="abrirImagen(' + imgArray[i].id + ')" style="background-image: url(../tattoo/rest/images/' + imgArray[i].url + ')"></div>');
    }
}

function abrirImagen(idImagen) {
    $(".box-imagen-abierta").css('display', 'flex');
    allImages.forEach(item => {
        if(item.id == idImagen) {
            $("#img-select").attr("src", "../tattoo/rest/images/" + item.url);
            $(".imagen-seleccionada img").css("max-height", $(document).height() - 150);
        }
    });
}

function showErrorNotification(texto) {
    $("#snackbar-error").text(texto);
    var x = document.getElementById("snackbar-error");
    x.className = "show";
    setTimeout(function(){ x.className = x.className.replace("show", ""); }, 3000);
}