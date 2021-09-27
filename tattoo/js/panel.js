var urlImagen, estiloImagen = 'otro';
var idFinalEliminar = 0;
$(document).ready(function(){
    comprobarLogin();
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

    $(".btn-si").on('click', function() {
        $('.box-popup').css('display', 'none');
        eliminarImagen(idFinalEliminar);
    });
    
    $(".btn-no").on('click', function() {
        $('.box-popup').css('display', 'none');
    });

    $("#cerrar-sesion").on('click', function() {
        cerrarSesion();
    });
});

function comprobarLogin() {
    if(localStorage.getItem('user') == null || localStorage.getItem('pass') == null) {
        window.location.href = 'https://davidcaballerocalvo.es/tattoo/login';
    }
}

function getAllImages() {
    $(".flex-fotos").html('');
    $.ajax({
        url: '../tattoo/rest/obtener_all_images.php',
        dataType: 'json',
        data: ({dominio: 'davidcaballerocalvo.es'}),
        success: function(data) {
            for(var i=0; i<data.images.length; i++) {
                $(".flex-fotos").append(''+
                    '<div class="miniatura-foto" style="background-image: url(../tattoo/rest/images/' + data.images[i].url + ')">'+
                        '<div class="eliminar-foto" onclick="confirmarEliminacion(' + data.images[i].id + ')"></div>'+
                    '</div>');
            }
        },
        error: function(error) {
            showErrorNotification('Error al obtener imagenes');
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
    $(".btn-image").css("display", "none");
    $(".btn-guardando").css("display", "block");
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
                showErrorNotification('Error al cargar la imagen');
                $(".btn-image").css("display", "block");
                $(".btn-guardando").css("display", "none");
            }
        },
        error: function(error) {
            showErrorNotification('Error al cargar la imagen');
            $(".btn-image").css("display", "block");
            $(".btn-guardando").css("display", "none");
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
                showSuccessNotification('Imagen guardada');
                getAllImages();
                $(".upload-image").attr("src", "../tattoo/img/default-image.png");
                $("#otro").prop("checked", true);
            } else {
                showErrorNotification('Error al guardar la imagen');
            }
            $(".btn-image").css("display", "block");
            $(".btn-guardando").css("display", "none");
        },
        error: function(error) {
            showErrorNotification('Error al guardar la imagen');
            $(".btn-image").css("display", "block");
            $(".btn-guardando").css("display", "none");
        }
  });
}

function confirmarEliminacion(id) {
    $('.box-popup').css('display', 'flex');
    idFinalEliminar = id;
}

function eliminarImagen(id) {
    $.ajax({
		type: 'POST',
		url: '../tattoo/rest/eliminar_imagen.php',
		dataType: 'json',
		data: ({id: id}),
		success: function(data) {
			if(data.estado == 1){
                getAllImages();
                showSuccessNotification('Imagen Eliminada');
			} else {
				showErrorNotification('Error al eliminar la imagen');
			}
		},
		error: function(error) {
			showErrorNotification('Error al eliminar la imagen');
		}
	});
}

function cerrarSesion() {
    localStorage.setItem("user", null);
	localStorage.setItem("pass", null);
    localStorage.setItem("check", "unchecked");
    window.location.href = 'https://davidcaballerocalvo.es/tattoo/login';
}

function showSuccessNotification(texto) {
    $("#snackbar-success").text(texto);
    var x = document.getElementById("snackbar-success");
    x.className = "show";
    setTimeout(function(){ x.className = x.className.replace("show", ""); }, 3000);
}

function showErrorNotification(texto) {
    $("#snackbar-error").text(texto);
    var x = document.getElementById("snackbar-error");
    x.className = "show";
    setTimeout(function(){ x.className = x.className.replace("show", ""); }, 3000);
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