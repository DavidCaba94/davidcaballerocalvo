var urlImagen, estiloImagen = 'Otro';
$(document).ready(function(){
    getAllImages();
    $("#imagen").change(function(){
		cargarImagen();
	});

	$(".btn-image").on('click', function() {
        guardarImagen();
    });

    $("input[name=estilo]").click(function () {
        estiloImagen = $(this).val();
    });
});

function getAllImages() {
    $(".flex-fotos").html('');
    $.ajax({
        url: '../tattoo/rest/obtener_all_images.php',
        dataType: 'json',
        data: ({dominio: 'davidcaballerocalvo.es'}),
        success: function(data) {
            console.log(data.images);
            for(var i=0; i<data.images.length; i++) {
                $(".flex-fotos").append(''+
                    '<div class="miniatura-foto" style="background-image: url(../tattoo/rest/images/' + data.images[i].url + ')">'+
                        '<div class="eliminar-foto"></div>'+
                    '</div>');
            }
        },
        error: function(error) {
            console.log(error);
        }
    });
}

async function cargarImagen() {
    const file = document.querySelector('#imagen').files[0];
    if(file != null) {
        foto = await toBase64(file);
        $(".upload-image").attr("src", foto);
    }
}

function guardarImagen() {
    var formData = new FormData();
    var files = $('#imagen')[0].files[0];
    formData.append('file',files);
    $.ajax({
        url: '../tattoo/rest/upload_image.php',
        type: 'post',
        data: formData,
        contentType: false,
        processData: false,
        success: function(response) {
            if (response != 0 && response != 1) {
                urlImagen = response.split('/')[1];
                guardarRegistroBD();
            } else {
                alert('Error en la subida');
            }
        },
        error: function(error) {
            console.log(error);
        }
    });
    return false;
}

function guardarRegistroBD() {
    $.ajax({
        type: 'POST',
        url: '../tattoo/rest/insertar_imagen.php',
        dataType: 'json',
        data: ({
            url: urlImagen, 
            dominio: 'davidcaballerocalvo.es', 
            tipo: estiloImagen, 
            fecha: getTodayDate()
        }),
        success: function(data) {
            if(data.estado == 1){
                getAllImages();
            } else {
                alert('Error al guardar el registro');
            }
        },
        error: function(error) {
            console.log(error);
        }
  });
}

const toBase64 = file => new Promise((resolve, reject) => {
    const reader = new FileReader();
    reader.readAsDataURL(file);
    reader.onload = () => resolve(reader.result);
    reader.onerror = error => reject(error);
});

function getTodayDate() {
    var today = new Date();
    var dd = String(today.getDate()).padStart(2, '0');
    var mm = String(today.getMonth() + 1).padStart(2, '0');
    var yyyy = today.getFullYear();

    today = dd + '-' + mm + '-' + yyyy;
    return today;
}